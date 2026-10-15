<?php
/**
 * Snippet Name: UP Agency - Modern Login Screen (Auto Light/Dark)
 * Description: Replaces the default WordPress login screen with a modern, clean aesthetic.
 *              Features adaptive OS Light/Dark mode, client logo at the top of the form,
 *              and UP Agency developer signature at the bottom.
 * Author: UP Agency
 * Author URI: https://up.gt/
 * Version: 1.0.0
 * 
 * FluentSnippets Settings:
 * - Snippet Type: Functions (PHP)
 * - Run Location: Everywhere (or Frontend Only)
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

// -----------------------------------------------------------------------------
// 1. BRAND SETTINGS
// -----------------------------------------------------------------------------
$client_logo = ''; // Optional: Direct URL to client's logo (e.g., 'https://yoursite.com/logo.svg'). If empty, uses WP Customizer or Site Icon.
$agency_logo = site_url( '/UP_logo-600x600.png' ); // UP Agency logo in WordPress root

// -----------------------------------------------------------------------------
// 2. HEADER URL & TITLE FILTERS
// -----------------------------------------------------------------------------
add_filter( 'login_headerurl', fn() => home_url( '/' ) );
add_filter( 'login_headertext', fn() => get_bloginfo( 'name' ) );

// -----------------------------------------------------------------------------
// 3. FONTS, CSS & ADAPTIVE LIGHT / DARK THEME
// -----------------------------------------------------------------------------
add_action( 'login_head', function() use ( $client_logo ) {
    if ( empty( $client_logo ) ) {
        $logo_id = get_theme_mod( 'custom_logo' );
        $client_logo = $logo_id ? wp_get_attachment_image_url( $logo_id, 'full' ) : get_site_icon_url( 180 );
    }
    ?>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style id="up-agency-login-styles">
      :root {
        --bg: #f8fafc;
        --card: #ffffff;
        --border: #e2e8f0;
        --text: #0f172a;
        --muted: #64748b;
        --input-bg: #f8fafc;
        --btn: #090d16;
        --btn-hover: #1e293b;
        --btn-text: #ffffff;
      }
      @media (prefers-color-scheme: dark) {
        :root {
          --bg: #0b0d13;
          --card: #131722;
          --border: rgba(255, 255, 255, 0.08);
          --text: #f8fafc;
          --muted: #94a3b8;
          --input-bg: rgba(255, 255, 255, 0.04);
          --btn: #ffffff;
          --btn-hover: #e2e8f0;
          --btn-text: #090d16;
        }
      }
      body.login {
        background-color: var(--bg) !important;
        font-family: 'Plus Jakarta Sans', -apple-system, BlinkMacSystemFont, sans-serif !important;
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        min-height: 100vh;
        margin: 0;
        padding: 24px 16px;
        box-sizing: border-box;
      }
      #login {
        width: 100%;
        max-width: 390px;
        padding: 0 !important;
        margin: auto 0 !important;
      }
      #login h1 a {
        background-image: url('<?php echo esc_url( $client_logo ); ?>') !important;
        background-size: contain !important;
        background-position: center !important;
        background-repeat: no-repeat !important;
        width: 100% !important;
        max-width: 180px !important;
        height: 46px !important;
        margin: 0 auto 20px !important;
      }
      body.login form {
        background: var(--card) !important;
        border: 1px solid var(--border) !important;
        border-radius: 18px !important;
        box-shadow: 0 20px 45px -10px rgba(0, 0, 0, 0.1) !important;
        padding: 30px !important;
      }
      body.login label {
        color: var(--muted) !important;
        font-size: 11px !important;
        font-weight: 600 !important;
        text-transform: uppercase !important;
        letter-spacing: .05em !important;
      }
      body.login input[type="text"],
      body.login input[type="password"] {
        background: var(--input-bg) !important;
        border: 1px solid var(--border) !important;
        border-radius: 12px !important;
        color: var(--text) !important;
        height: 44px !important;
        font-size: 14px !important;
        padding: 8px 14px !important;
        margin: 6px 0 16px !important;
      }
      body.login input[type="text"]:focus,
      body.login input[type="password"]:focus {
        border-color: var(--text) !important;
        box-shadow: 0 0 0 2px var(--border) !important;
        outline: none !important;
      }
      body.login .submit input[type="submit"] {
        width: 100% !important;
        height: 44px !important;
        background: var(--btn) !important;
        color: var(--btn-text) !important;
        border: none !important;
        border-radius: 12px !important;
        font-size: 14px !important;
        font-weight: 600 !important;
        cursor: pointer !important;
        transition: all .2s !important;
      }
      body.login .submit input[type="submit"]:hover {
        background: var(--btn-hover) !important;
        transform: translateY(-1px);
      }
      body.login #nav a,
      body.login #backtoblog a {
        color: var(--muted) !important;
        font-size: 13px !important;
        text-decoration: none !important;
      }
      body.login #nav a:hover,
      body.login #backtoblog a:hover {
        color: var(--text) !important;
      }
      .up-dev-badge {
        margin-top: 26px;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 6px 14px 6px 8px;
        border-radius: 50px;
        background: var(--card);
        border: 1px solid var(--border);
        text-decoration: none;
        color: var(--muted);
        font-size: 12px;
        font-weight: 500;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.04);
        transition: transform .2s ease;
      }
      .up-dev-badge:hover {
        transform: translateY(-1px);
        color: var(--text);
      }
      .up-dev-badge img {
        width: 22px;
        height: 22px;
        border-radius: 50%;
        display: block;
      }
      .up-dev-badge strong {
        color: var(--text);
      }
      .up-tag {
        font-size: 9px;
        font-weight: 700;
        text-transform: uppercase;
        padding: 2px 6px;
        border-radius: 4px;
        background: rgba(99, 102, 241, 0.1);
        color: #6366f1;
      }
    </style>
    <?php
} );

// -----------------------------------------------------------------------------
// 4. UP AGENCY DEVELOPER SIGNATURE (FOOTER)
// -----------------------------------------------------------------------------
add_action( 'login_footer', function() use ( $agency_logo ) {
    ?>
    <div style="text-align: center; margin-top: 20px;">
      <a href="https://up.gt/" target="_blank" rel="noopener" class="up-dev-badge">
        <img src="<?php echo esc_url( $agency_logo ); ?>" alt="UP Agency">
        <span>Developed by <strong>UP Agency</strong></span>
        <span class="up-tag">Studio</span>
      </a>
    </div>
    <?php
} );
