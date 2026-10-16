#!/usr/bin/env bash
# ==============================================================================
# UP Group Studio (studio.up.gt) — Sync & Package Script
# Syncs compiled CSS, JS, and assets from src/ into child-theme/, regenerates
# Bricks Builder JSON templates, and optionally packages deployment ZIPs.
# ==============================================================================

set -euo pipefail

ROOT_DIR="$(cd "$(dirname "${BASH_SOURCE[0]}")/.." && pwd)"
SRC_DIR="${ROOT_DIR}/src"
THEME_DIR="${ROOT_DIR}/child-theme"
TEMPLATES_DIR="${ROOT_DIR}/bricks-templates"
WP_THEME_DIR="${ROOT_DIR}/wordpress/wp-content/themes/upagency"

echo "▸ [1/3] Syncing assets from src/ → child-theme/..."
mkdir -p "${THEME_DIR}/css" "${THEME_DIR}/js" "${THEME_DIR}/assets"
cp "${SRC_DIR}/css/style.css" "${THEME_DIR}/css/style.css"
cp "${SRC_DIR}/js/main.js" "${THEME_DIR}/js/script.js"
cp "${SRC_DIR}/js/project.js" "${THEME_DIR}/js/project.js"
cp -R "${SRC_DIR}/assets/"* "${THEME_DIR}/assets/"

# Also keep local wordpress/wp-content/themes/upagency in sync if present
if [ -d "${WP_THEME_DIR}" ]; then
  mkdir -p "${WP_THEME_DIR}/css" "${WP_THEME_DIR}/js" "${WP_THEME_DIR}/assets"
  cp "${THEME_DIR}/style.css" "${WP_THEME_DIR}/style.css"
  cp "${THEME_DIR}/functions.php" "${WP_THEME_DIR}/functions.php"
  cp "${THEME_DIR}/css/style.css" "${WP_THEME_DIR}/css/style.css"
  cp "${THEME_DIR}/js/script.js" "${WP_THEME_DIR}/js/script.js"
  cp "${THEME_DIR}/js/project.js" "${WP_THEME_DIR}/js/project.js"
  cp -R "${THEME_DIR}/assets/"* "${WP_THEME_DIR}/assets/"
fi

echo "▸ [2/3] Regenerating & validating Bricks Builder JSON templates..."
python3 "${ROOT_DIR}/scripts/build_bricks_templates.py"

if [[ "${1:-}" == "--zip" ]]; then
  echo "▸ [3/3] Packaging deployment archives..."
  TMP_BUILD="$(mktemp -d)"
  mkdir -p "${TMP_BUILD}/upagency"
  cp -R "${THEME_DIR}/"* "${TMP_BUILD}/upagency/"
  (cd "${TMP_BUILD}" && zip -rq "${ROOT_DIR}/upagency-child-theme.zip" upagency -x "*.DS_Store")
  rm -rf "${TMP_BUILD}"

  (cd "${ROOT_DIR}" && zip -rq "${ROOT_DIR}/upagency-bricks-templates.zip" bricks-templates -x "*.DS_Store")
  echo "✔ Created:"
  echo "  - upagency-child-theme.zip"
  echo "  - upagency-bricks-templates.zip"
else
  echo "✔ Sync complete! (Pass --zip to also rebuild .zip archives)"
fi
