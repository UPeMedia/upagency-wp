#!/usr/bin/env python3
"""
Generates 1600x1200 (4:3 Upwork Portfolio v2 native ratio) Dark Studio Mockups
combining a realistic Studio Display Monitor (Desktop screenshot) + iPhone 16 Pro (Mobile screenshot
with a clean iOS status bar so the Dynamic Island never overlaps the website header),
top executive badges, and bottom tech-stack & impact bar for all portfolio-assets projects.
"""
import os
import shutil
import subprocess

REPO_ROOT = "/home/antigravity/UPeMedia/upagency-wp"
PORTFOLIO_DIR = os.path.join(REPO_ROOT, "portfolio-assets")
ARTIFACT_DIR = "/home/antigravity/.gemini/jetski/brain/v1/default/jetski_remote_agents_3p/5aab53d3-e12d-45f8-a02e-62a35b844579"
SCRATCH_DIR = os.path.join(ARTIFACT_DIR, "scratch")
os.makedirs(SCRATCH_DIR, exist_ok=True)

# 1. Update 00-aem-automotive-oem with the exact Mazda USA (VML) modules (NDA-safe)
AEM_DIR = os.path.join(PORTFOLIO_DIR, "00-aem-automotive-oem")
os.makedirs(AEM_DIR, exist_ok=True)

aem_nda_html = f"""<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<style>
  * {{ box-sizing: border-box; margin: 0; padding: 0; }}
  body {{
    width: 1600px;
    height: 1200px;
    background: #111318 url('{ARTIFACT_DIR}/aem_cx5_clean_unbranded_mockup_1794884870958.jpg') center center / cover no-repeat;
    font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Helvetica, Arial, sans-serif;
    position: relative;
    overflow: hidden;
  }}
  .top-bar {{
    position: absolute;
    top: 26px;
    left: 44px;
    right: 44px;
    display: flex;
    justify-content: space-between;
    align-items: center;
  }}
  .pill {{
    display: inline-flex;
    align-items: center;
    gap: 10px;
    padding: 9px 18px;
    border-radius: 999px;
    font-size: 13px;
    font-weight: 700;
    letter-spacing: 1.3px;
    text-transform: uppercase;
    backdrop-filter: blur(12px);
    box-shadow: 0 8px 24px rgba(0,0,0,0.45);
  }}
  .pill-aem {{
    background: rgba(15, 23, 42, 0.88);
    border: 1px solid rgba(255, 255, 255, 0.2);
    color: #f8fafc;
  }}
  .pill-aem span.dot {{
    width: 9px;
    height: 9px;
    border-radius: 50%;
    background: #dc2626;
    display: inline-block;
  }}
  .pill-nda {{
    background: rgba(24, 24, 27, 0.92);
    border: 1px solid rgba(251, 191, 36, 0.6);
    color: #fde68a;
  }}
  .bottom-banner {{
    position: absolute;
    bottom: 22px;
    left: 44px;
    right: 44px;
    background: rgba(12, 14, 20, 0.92);
    border: 1px solid rgba(255, 255, 255, 0.16);
    border-radius: 12px;
    padding: 13px 24px;
    display: flex;
    justify-content: space-between;
    align-items: center;
    color: #cbd5e1;
    font-size: 13px;
    backdrop-filter: blur(12px);
    box-shadow: 0 10px 30px rgba(0,0,0,0.65);
  }}
  .bottom-banner strong {{
    color: #ffffff;
  }}
  .stack-tags {{
    display: flex;
    gap: 8px;
  }}
  .stack-tag {{
    background: rgba(255,255,255,0.08);
    border: 1px solid rgba(255,255,255,0.16);
    color: #f8fafc;
    padding: 5px 11px;
    border-radius: 6px;
    font-size: 11.5px;
    font-weight: 600;
    letter-spacing: 0.4px;
    white-space: nowrap;
  }}
</style>
</head>
<body>
  <div class="top-bar">
    <div class="pill pill-aem">
      <span class="dot"></span>
      <span>ENTERPRISE CASE STUDY (VML) • ADOBE EXPERIENCE MANAGER (AEM)</span>
    </div>
    <div class="pill pill-nda">
      <span>🔒 CLIENT BRAND &amp; LOGOS REDACTED UNDER NDA (U.S. AUTOMOTIVE OEM)</span>
    </div>
  </div>

  <div class="bottom-banner">
    <div>
      <strong>Modules Built (NDA Reconstruction):</strong> Compare Trims &amp; Specs, Estimated Pricing, Timeline Carousel, Responsive Menus &amp; Storybook CSS Utilities.
    </div>
    <div class="stack-tags">
      <span class="stack-tag">AEM Sites</span>
      <span class="stack-tag">Storybook DS</span>
      <span class="stack-tag">JavaScript / HTML / SCSS</span>
      <span class="stack-tag">WCAG A11y</span>
      <span class="stack-tag">PR Code Reviews</span>
    </div>
  </div>
</body>
</html>
"""

aem_html_path = os.path.join(SCRATCH_DIR, "aem_nda_updated.html")
with open(aem_html_path, "w") as f:
    f.write(aem_nda_html)

aem_out_artifact = os.path.join(ARTIFACT_DIR, "upwork_mockup_00_aem_automotive.png")
subprocess.run([
    "/usr/bin/google-chrome", "--headless", "--no-sandbox", "--disable-gpu",
    "--window-size=1600,1200", "--hide-scrollbars",
    f"--screenshot={aem_out_artifact}", f"file://{aem_html_path}"
], check=False)

shutil.copyfile(aem_out_artifact, os.path.join(AEM_DIR, "upwork-mockup-aem-automotive.png"))
shutil.copyfile(f"{ARTIFACT_DIR}/aem_automotive_case_study_cover.png", os.path.join(AEM_DIR, "upwork-slide-aem-architecture.png"))


# 2. All 11 Real Screenshot Projects in portfolio-assets
PROJECTS = [
    {
        "folder": "01-nanajuana",
        "out_name": "upwork_mockup_01_nanajuana.png",
        "desktop_img": "nanajuana-desktop.png",
        "mobile_img": "nanajuana-mobile.jpg",
        "status_bg": "#0f2942",
        "status_fg": "#ffffff",
        "accent": "#C87D55",
        "pill_left": "LUXURY RESORT & YACHT MARINA • DIRECT BOOKING PLATFORM",
        "pill_right": "🚀 +185% DIRECT ONLINE BOOKINGS • 98/100 PAGESPEED",
        "bottom_text": "<strong>Nanajuana Río Dulce:</strong> Custom WordPress architecture, floating real-time availability engine, suite/slip comparator &amp; WhatsApp Concierge.",
        "tags": ["Custom WordPress", "UI/UX Design", "Direct Booking Engine", "98/100 PageSpeed", "1.1s LCP"]
    },
    {
        "folder": "02-tikal-futura",
        "out_name": "upwork_mockup_02_tikal_futura.png",
        "desktop_img": "tikalfutura-full-desktop.png",
        "mobile_img": "tikalfutura-full-mobile.jpg",
        "status_bg": "#d5eceb",
        "status_fg": "#0f172a",
        "accent": "#38bdf8",
        "pill_left": "SHOPPING CENTER & CONVENTION HUB • HIGH-TRAFFIC WEB PLATFORM",
        "pill_right": "⚡ +140% COMMERCIAL INQUIRIES • 96/100 CORE WEB VITALS",
        "bottom_text": "<strong>Tikal Futura:</strong> Full digital overhaul, interactive store &amp; dining directory, event calendar, and automated B2B commercial leasing funnel.",
        "tags": ["Custom WordPress", "UI/UX Architecture", "Interactive Directory", "Core Web Vitals 96+", "CRM Lead Funnel"]
    },
    {
        "folder": "03-inde",
        "out_name": "upwork_mockup_03_inde.png",
        "desktop_img": "inde-desktop.jpg",
        "mobile_img": "inde-mobile.png",
        "status_bg": "#ffffff",
        "status_fg": "#0f172a",
        "accent": "#DF525C",
        "pill_left": "NATIONAL ENERGY GRID (INDE) • HIGH-AVAILABILITY PORTAL",
        "pill_right": "🛡️ 99.99% UPTIME • 450K+ MONTHLY SESSIONS • WCAG AA+",
        "bottom_text": "<strong>INDE National Electrification Institute:</strong> High-traffic open data platform, predictive document search (-70% lookup time) &amp; AA+ accessibility.",
        "tags": ["High-Traffic WordPress", "UI/UX & Dashboards", "WCAG AA+ A11y", "97/100 Performance", "Edge Caching"]
    },
    {
        "folder": "04-camino-real-tikal",
        "out_name": "upwork_mockup_04_camino_real_tikal.png",
        "desktop_img": "caminorealtikal-desktop.jpg",
        "mobile_img": "caminorealtikal-mobile.jpg",
        "status_bg": "#18181b",
        "status_fg": "#ffffff",
        "accent": "#10b981",
        "pill_left": "HOTEL CAMINO REAL TIKAL • 5-STAR LUXURY ECO-RESORT",
        "pill_right": "🌴 DIRECT BOOKING FUNNEL • CLOUDBEDS / HOSPITALITY ENGINE",
        "bottom_text": "<strong>Camino Real Tikal:</strong> Bilingual hospitality platform &amp; direct-booking funnel engineered for international travelers visiting the Mayan rainforest.",
        "tags": ["Hospitality UI/UX", "Custom WordPress", "Direct Booking Engine", "Mobile-First UX", "Core Web Vitals"]
    },
    {
        "folder": "05-camino-real-antigua",
        "out_name": "upwork_mockup_05_camino_real_antigua.png",
        "desktop_img": "caminorealantigua-desktop.jpg",
        "mobile_img": "caminorealantigua-mobile.jpg",
        "status_bg": "#1c1917",
        "status_fg": "#ffffff",
        "accent": "#d97706",
        "pill_left": "HOTEL CAMINO REAL ANTIGUA • FLAGSHIP 5-STAR HERITAGE HOTEL",
        "pill_right": "🏨 +120% DIRECT RESERVATIONS • WEDDINGS & CORPORATE RFPs",
        "bottom_text": "<strong>Camino Real Antigua:</strong> Luxury hospitality web experience combining colonial heritage aesthetics with frictionless room, spa &amp; event booking flows.",
        "tags": ["Luxury Hospitality", "Custom WordPress", "UI/UX Design", "Booking Integration", "B2B Event RFPs"]
    },
    {
        "folder": "06-mrc-global",
        "out_name": "upwork_mockup_06_mrc_global.png",
        "desktop_img": "mrcglobal-desktop.jpg",
        "mobile_img": "mrcglobal-mobile.jpg",
        "status_bg": "#18181b",
        "status_fg": "#ffffff",
        "accent": "#0ea5e9",
        "pill_left": "MRC GLOBAL (HOUSTON, TX) • ENTERPRISE HEADLESS WEB PLATFORM",
        "pill_right": "🌐 NEXT.JS + CONTENTFUL CMS • FORTUNE 500 PVF LEADER",
        "bottom_text": "<strong>MRC Global (Houston, TX):</strong> Enterprise headless architecture engineered with Next.js, React, and Contentful CMS for global industrial distribution.",
        "tags": ["Next.js", "React.js", "Contentful CMS", "Headless Architecture", "Enterprise UI/UX"]
    },
    {
        "folder": "07-aguilar-castillo-love",
        "out_name": "upwork_mockup_07_aguilar_castillo_love.png",
        "desktop_img": "aguilarcastillolove-desktop.jpg",
        "mobile_img": "aguilarcastillolove-mobile.jpg",
        "status_bg": "#0f172a",
        "status_fg": "#ffffff",
        "accent": "#6366f1",
        "pill_left": "AGUILAR CASTILLO LOVE • MULTINATIONAL CORPORATE LAW FIRM",
        "pill_right": "⚖️ REGIONAL B2B PLATFORM • MULTI-COUNTRY DIRECTORY & INSIGHTS",
        "bottom_text": "<strong>Aguilar Castillo Love:</strong> Regional legal platform spanning 7+ countries with practice-area filtering, partner profiles, and B2B lead capture.",
        "tags": ["Corporate B2B Web", "Custom WordPress", "Multi-Region UX", "Dynamic Directory", "Technical SEO"]
    },
    {
        "folder": "08-shops-at-lakeshore",
        "out_name": "upwork_mockup_08_shops_lakeshore.png",
        "desktop_img": "shopsatlakeshore-desktop.jpg",
        "mobile_img": "shopsatlakeshore-mobile.jpg",
        "status_bg": "#ffffff",
        "status_fg": "#0f172a",
        "accent": "#f59e0b",
        "pill_left": "SHOPS AT LAKESHORE (HOUSTON, TX) • RETAIL & LIFESTYLE DESTINATION",
        "pill_right": "📍 HOUSTON, TEXAS • MOBILE-FIRST UI/UX & TENANT SHOWCASE",
        "bottom_text": "<strong>Shops at Lakeshore (Houston, TX):</strong> Modern retail center web platform designed to drive local foot traffic, tenant visibility, and leasing inquiries.",
        "tags": ["WordPress", "UI/UX Design", "Houston, TX Client", "Mobile-First", "Local SEO & Speed"]
    },
    {
        "folder": "09-spotsee",
        "out_name": "upwork_mockup_09_spotsee.png",
        "desktop_img": "spotsee-desktop.jpg",
        "mobile_img": "spotsee-mobile.jpg",
        "status_bg": "#ffffff",
        "status_fg": "#0f172a",
        "accent": "#ef4444",
        "pill_left": "SPOTSEE (DALLAS, TX) • GLOBAL IoT & SUPPLY CHAIN TELEMETRY",
        "pill_right": "📈 B2B LEAD GENERATION • INTERACTIVE PRODUCT CATALOG",
        "bottom_text": "<strong>SpotSee (Dallas, TX):</strong> B2B industrial IoT platform showcasing impact, temperature, and supply-chain monitoring solutions with CRM integration.",
        "tags": ["Custom Web Dev", "B2B Lead Funnels", "Dallas, TX Client", "UI/UX Design", "CRM Attribution"]
    },
    {
        "folder": "10-clinica-san-benito",
        "out_name": "upwork_mockup_10_clinica_san_benito.png",
        "desktop_img": "clinicamedicasanbenito-desktop.jpg",
        "mobile_img": "clinicamedicasanbenito-mobile.jpg",
        "status_bg": "#ffffff",
        "status_fg": "#0f172a",
        "accent": "#0284c7",
        "pill_left": "CLÍNICA MÉDICA SAN BENITO • HEALTHCARE & PATIENT BOOKING",
        "pill_right": "🩺 DIGITAL APPOINTMENT FUNNEL • MEDICAL SPECIALTIES HUB",
        "bottom_text": "<strong>Clínica Médica San Benito:</strong> Healthcare platform featuring specialty directories, custom commercial photography, and instant WhatsApp appointment booking.",
        "tags": ["Healthcare UI/UX", "Custom WordPress", "Appointment Funnel", "Speed Optimization", "Mobile-First"]
    },
    {
        "folder": "11-sagrado-corazon",
        "out_name": "upwork_mockup_11_sagrado_corazon.png",
        "desktop_img": "labsagradocorazon-desktop.jpg",
        "mobile_img": "labsagradocorazon-mobile.jpg",
        "status_bg": "#ffffff",
        "status_fg": "#0f172a",
        "accent": "#e11d48",
        "pill_left": "SAGRADO CORAZÓN CLINICAL LAB • DIAGNOSTIC & RESULTS PORTAL",
        "pill_right": "🔬 ONLINE LAB CATALOG • FAST PATIENT CONVERSION FLOW",
        "bottom_text": "<strong>Sagrado Corazón Clinical Lab:</strong> Digital diagnostic catalog, branch locator, home-visit scheduling, and online results access for patients and doctors.",
        "tags": ["Healthcare Web", "Custom WordPress", "UI/UX Design", "Patient Funnel", "Core Web Vitals"]
    }
]

for p in PROJECTS:
    folder_path = os.path.join(PORTFOLIO_DIR, p["folder"])
    d_img = os.path.join(folder_path, p["desktop_img"])
    m_img = os.path.join(folder_path, p["mobile_img"])
    tags_html = "".join([f'<span class="stack-tag">{t}</span>' for t in p["tags"]])

    html = f"""<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<style>
  * {{ box-sizing: border-box; margin: 0; padding: 0; }}
  body {{
    width: 1600px;
    height: 1200px;
    background: radial-gradient(circle at 50% 35%, #232733 0%, #12141c 60%, #0a0b10 100%);
    font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Helvetica, Arial, sans-serif;
    position: relative;
    overflow: hidden;
  }}
  .ambient-glow {{
    position: absolute;
    width: 900px;
    height: 650px;
    left: 220px;
    top: 180px;
    background: radial-gradient(circle, {p["accent"]}33 0%, transparent 70%);
    filter: blur(40px);
    pointer-events: none;
  }}
  .studio-floor {{
    position: absolute;
    bottom: 0;
    left: 0;
    right: 0;
    height: 250px;
    background: linear-gradient(180deg, rgba(10,11,16,0) 0%, rgba(18,20,28,0.95) 45%, #090a0f 100%);
    pointer-events: none;
  }}
  .top-bar {{
    position: absolute;
    top: 26px;
    left: 44px;
    right: 44px;
    display: flex;
    justify-content: space-between;
    align-items: center;
    z-index: 30;
  }}
  .pill {{
    display: inline-flex;
    align-items: center;
    gap: 10px;
    padding: 9px 18px;
    border-radius: 999px;
    font-size: 13px;
    font-weight: 700;
    letter-spacing: 1.3px;
    text-transform: uppercase;
    backdrop-filter: blur(12px);
    box-shadow: 0 8px 24px rgba(0,0,0,0.45);
  }}
  .pill-left {{
    background: rgba(15, 23, 42, 0.88);
    border: 1px solid rgba(255, 255, 255, 0.2);
    color: #f8fafc;
  }}
  .pill-left span.dot {{
    width: 9px;
    height: 9px;
    border-radius: 50%;
    background: {p["accent"]};
    display: inline-block;
  }}
  .pill-right {{
    background: rgba(24, 24, 27, 0.92);
    border: 1px solid {p["accent"]}99;
    color: #f8fafc;
  }}

  /* Studio Display Monitor */
  .monitor-wrap {{
    position: absolute;
    top: 112px;
    left: 88px;
    width: 1160px;
    display: flex;
    flex-direction: column;
    align-items: center;
    z-index: 10;
  }}
  .monitor-bezel {{
    width: 1160px;
    height: 760px;
    background: #0d0e12;
    border-radius: 22px;
    padding: 18px;
    box-shadow: 0 40px 90px rgba(0,0,0,0.85), 0 0 0 2px rgba(255,255,255,0.14), inset 0 1px 1px rgba(255,255,255,0.2);
    position: relative;
  }}
  .webcam-dot {{
    position: absolute;
    top: 7px;
    left: 50%;
    transform: translateX(-50%);
    width: 6px;
    height: 6px;
    border-radius: 50%;
    background: #27272a;
  }}
  .monitor-screen {{
    width: 100%;
    height: 100%;
    border-radius: 8px;
    overflow: hidden;
    background: #ffffff;
    position: relative;
  }}
  .monitor-screen img {{
    width: 100%;
    height: auto;
    display: block;
  }}
  .monitor-stand-neck {{
    width: 220px;
    height: 145px;
    background: linear-gradient(90deg, #71717a 0%, #d4d4d8 22%, #a1a1aa 50%, #d4d4d8 78%, #52525b 100%);
    position: relative;
    box-shadow: inset 0 18px 25px rgba(0,0,0,0.55), 0 20px 30px rgba(0,0,0,0.6);
    display: flex;
    justify-content: center;
  }}
  .stand-cutout {{
    width: 96px;
    height: 52px;
    background: #141720;
    border-radius: 0 0 48px 48px;
    box-shadow: inset 0 -3px 6px rgba(255,255,255,0.35);
  }}
  .monitor-stand-base {{
    width: 244px;
    height: 14px;
    background: linear-gradient(90deg, #52525b 0%, #e4e4e7 30%, #a1a1aa 70%, #52525b 100%);
    border-radius: 4px 4px 2px 2px;
    box-shadow: 0 12px 28px rgba(0,0,0,0.9);
  }}

  /* Overlapping iPhone 16 Pro Frame */
  .phone-bezel {{
    position: absolute;
    right: 78px;
    bottom: 98px;
    width: 356px;
    height: 730px;
    background: #18181b;
    border-radius: 52px;
    padding: 13px;
    box-shadow: -28px 35px 85px rgba(0,0,0,0.9), 0 0 0 3px #52525b, inset 0 0 4px rgba(255,255,255,0.25);
    z-index: 20;
  }}
  .dynamic-island {{
    position: absolute;
    top: 21px;
    left: 50%;
    transform: translateX(-50%);
    width: 92px;
    height: 24px;
    background: #09090b;
    border-radius: 20px;
    z-index: 25;
    box-shadow: 0 1px 3px rgba(0,0,0,0.5);
  }}
  .phone-screen {{
    width: 100%;
    height: 100%;
    border-radius: 40px;
    overflow: hidden;
    background: #ffffff;
    display: flex;
    flex-direction: column;
  }}
  .ios-status-bar {{
    height: 36px;
    min-height: 36px;
    background: {p["status_bg"]};
    color: {p["status_fg"]};
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 4px 24px 0;
    font-size: 11px;
    font-weight: 700;
  }}
  .phone-viewport {{
    flex: 1;
    overflow: hidden;
    position: relative;
  }}
  .phone-viewport img {{
    width: 100%;
    height: auto;
    display: block;
  }}

  /* Bottom Bar */
  .bottom-banner {{
    position: absolute;
    bottom: 22px;
    left: 44px;
    right: 44px;
    background: rgba(12, 14, 20, 0.92);
    border: 1px solid rgba(255, 255, 255, 0.16);
    border-radius: 12px;
    padding: 13px 24px;
    display: flex;
    justify-content: space-between;
    align-items: center;
    color: #cbd5e1;
    font-size: 13.5px;
    backdrop-filter: blur(12px);
    box-shadow: 0 10px 30px rgba(0,0,0,0.65);
    z-index: 30;
  }}
  .bottom-banner strong {{
    color: #ffffff;
  }}
  .stack-tags {{
    display: flex;
    gap: 8px;
  }}
  .stack-tag {{
    background: rgba(255,255,255,0.08);
    border: 1px solid rgba(255,255,255,0.16);
    color: #f8fafc;
    padding: 5px 11px;
    border-radius: 6px;
    font-size: 11.5px;
    font-weight: 600;
    letter-spacing: 0.4px;
    white-space: nowrap;
  }}
</style>
</head>
<body>
  <div class="ambient-glow"></div>
  <div class="studio-floor"></div>

  <div class="top-bar">
    <div class="pill pill-left">
      <span class="dot"></span>
      <span>{p["pill_left"]}</span>
    </div>
    <div class="pill pill-right">
      <span>{p["pill_right"]}</span>
    </div>
  </div>

  <div class="monitor-wrap">
    <div class="monitor-bezel">
      <div class="webcam-dot"></div>
      <div class="monitor-screen">
        <img src="file://{d_img}" alt="Desktop View">
      </div>
    </div>
    <div class="monitor-stand-neck">
      <div class="stand-cutout"></div>
    </div>
    <div class="monitor-stand-base"></div>
  </div>

  <div class="phone-bezel">
    <div class="dynamic-island"></div>
    <div class="phone-screen">
      <div class="ios-status-bar">
        <span>9:41</span>
        <span>5G 100%</span>
      </div>
      <div class="phone-viewport">
        <img src="file://{m_img}" alt="Mobile View">
      </div>
    </div>
  </div>

  <div class="bottom-banner">
    <div>{p["bottom_text"]}</div>
    <div class="stack-tags">{tags_html}</div>
  </div>
</body>
</html>
"""
    html_file = os.path.join(SCRATCH_DIR, f"mockup_{p['folder']}.html")
    with open(html_file, "w") as f:
        f.write(html)

    out_artifact = os.path.join(ARTIFACT_DIR, p["out_name"])
    subprocess.run([
        "/usr/bin/google-chrome", "--headless", "--no-sandbox", "--disable-gpu",
        "--window-size=1600,1200", "--hide-scrollbars",
        f"--screenshot={out_artifact}", f"file://{html_file}"
    ], check=False)

    out_repo = os.path.join(folder_path, "upwork-mockup-desktop-mobile.png")
    shutil.copyfile(out_artifact, out_repo)
    print("Generated:", out_repo)
