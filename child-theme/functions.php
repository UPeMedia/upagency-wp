<?php 
/**
 * UP Group Studio (studio.up.gt) — Bricks Builder Child Theme Functions
 * Architecture:
 *  1. Enqueue Google Fonts (Geist, Geist Mono, Caveat), Font Awesome 6, CSS & JS
 *  2. Register Custom Bricks Elements
 *  3. Register Bricks-Safe Shortcodes for Interactive Forms & Custom Inline SVGs
 *     (Bypasses Bricks code-signing & inline SVG placeholder restrictions)
 */

// ─── 1. Enqueue Styles & Scripts ──────────────────────────────────────
add_action( 'wp_enqueue_scripts', function() {
    if ( ! function_exists('bricks_is_builder_main') || ! bricks_is_builder_main() ) {
        // Google Fonts (Geist, Geist Mono & Caveat)
        wp_enqueue_style(
            'upagency-fonts',
            'https://fonts.googleapis.com/css2?family=Caveat:wght@600;700&family=Geist:wght@300;400;500;600;700;800;900&family=Geist+Mono:wght@400;500;600&display=swap',
            [],
            null
        );

        // Font Awesome 6
        wp_enqueue_style(
            'font-awesome-6',
            'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css',
            [],
            '6.5.1'
        );

        // Custom Child Theme Stylesheet (css/style.css)
        $css_file = get_stylesheet_directory() . '/css/style.css';
        $css_ver  = file_exists($css_file) ? filemtime($css_file) : '3.0.0';
        wp_enqueue_style(
            'upagency-custom',
            get_stylesheet_directory_uri() . '/css/style.css',
            ['bricks-frontend', 'upagency-fonts', 'font-awesome-6'],
            $css_ver
        );

        // Custom Child Theme Scripts (js/script.js & js/project.js)
        $js_file = get_stylesheet_directory() . '/js/script.js';
        $js_ver  = file_exists($js_file) ? filemtime($js_file) : '3.0.0';
        wp_enqueue_script(
            'upagency-script',
            get_stylesheet_directory_uri() . '/js/script.js',
            [],
            $js_ver,
            true
        );

        $proj_js = get_stylesheet_directory() . '/js/project.js';
        if ( file_exists( $proj_js ) ) {
            wp_enqueue_script(
                'upagency-project',
                get_stylesheet_directory_uri() . '/js/project.js',
                ['upagency-script'],
                filemtime( $proj_js ),
                true
            );
        }
    }
}, 20 );

// ─── 2. Register Custom Bricks Elements ───────────────────────────────
add_action( 'init', function() {
    $element_files = [
        __DIR__ . '/elements/title.php',
    ];

    foreach ( $element_files as $file ) {
        if ( file_exists( $file ) && class_exists( '\Bricks\Elements' ) ) {
            \Bricks\Elements::register_element( $file );
        }
    }
}, 11 );

add_filter( 'bricks/builder/i18n', function( $i18n ) {
    $i18n['custom'] = esc_html__( 'UP Group Studio', 'bricks' );
    return $i18n;
} );

// ─── 3. Register Bricks-Safe Shortcodes ───────────────────────────────

// 3.1 Hero Circular Rotating Stamp
add_shortcode( 'up_scroll_stamp', function() {
    ob_start(); ?>
    <a href="#works" class="scroll-stamp" aria-label="Ver proyectos">
      <svg class="scroll-stamp__svg" viewBox="0 0 120 120">
        <defs>
          <path id="stampCircleHero" d="M 60, 60 m -46, 0 a 46,46 0 1,1 92,0 a 46,46 0 1,1 -92,0"/>
        </defs>
        <text class="scroll-stamp__text">
          <textPath href="#stampCircleHero" textLength="279" lengthAdjust="spacing">UP GROUP STUDIO • GUATEMALA &amp; HOUSTON •</textPath>
        </text>
      </svg>
      <span class="scroll-stamp__icon">
        <i class="fa-solid fa-angles-down"></i>
      </span>
    </a>
    <?php
    return ob_get_clean();
} );

// 3.2 Manifesto 1 Dark Rotating Stamp ("We Speak Geek, But We're Friendly")
add_shortcode( 'up_manifesto_stamp_dark', function() {
    ob_start(); ?>
    <div class="rotating-stamp">
      <svg class="rotating-stamp__svg" viewBox="0 0 120 120">
        <defs>
          <path id="stampCircleDark" d="M 60, 60 m -46, 0 a 46,46 0 1,1 92,0 a 46,46 0 1,1 -92,0"/>
        </defs>
        <text class="rotating-stamp__text">
          <textPath href="#stampCircleDark" textLength="278" lengthAdjust="spacing">WE SPEAK GEEK, BUT WE'RE FRIENDLY •</textPath>
        </text>
      </svg>
      <span class="rotating-stamp__center">
        <i class="fa-solid fa-code"></i>
      </span>
    </div>
    <?php
    return ob_get_clean();
} );

// 3.3 Manifesto 2 Light Rotating Stamp ("Zero Copy-Paste • Pixel Obsessed")
add_shortcode( 'up_manifesto_stamp_light', function() {
    ob_start(); ?>
    <div class="rotating-stamp rotating-stamp--light">
      <svg class="rotating-stamp__svg" viewBox="0 0 120 120">
        <defs>
          <path id="stampCircleLight" d="M 60, 60 m -46, 0 a 46,46 0 1,1 92,0 a 46,46 0 1,1 -92,0"/>
        </defs>
        <text class="rotating-stamp__text">
          <textPath href="#stampCircleLight" textLength="278" lengthAdjust="spacing">ZERO COPY-PASTE • PIXEL OBSESSED •</textPath>
        </text>
      </svg>
      <span class="rotating-stamp__center">
        <i class="fa-solid fa-compass-drafting"></i>
      </span>
    </div>
    <?php
    return ob_get_clean();
} );

// 3.4 Split Banner Rocket SVG Illustration
add_shortcode( 'up_rocket_illustration', function() {
    ob_start(); ?>
    <svg class="rocket-illustration" viewBox="0 0 500 380" fill="none" xmlns="http://www.w3.org/2000/svg">
      <rect width="500" height="380" fill="#5B8DEF"/>
      <circle cx="420" cy="70" r="48" fill="#FBBF24"/>
      <circle cx="90" cy="95" r="28" fill="#BC80BB"/>
      <path d="M-20 380 C80 260, 220 290, 320 380 Z" fill="#EB5F69"/>
      <path d="M210 380 C310 250, 430 270, 530 380 Z" fill="#F4A261"/>
      <path d="M0 240 Q120 200 250 240 T500 220 L500 380 L0 380 Z" fill="#FDE68A" fill-opacity="0.85"/>
      <path d="M0 300 Q160 250 320 300 T500 290 L500 380 L0 380 Z" fill="#F472B6"/>
      <path d="M70 380 Q50 310 95 275 Q110 325 70 380 Z" fill="#1E3A8A"/>
      <path d="M105 380 Q105 320 145 295 Q145 345 105 380 Z" fill="#2E9D68"/>
      <path d="M390 380 Q415 300 365 265 Q355 325 390 380 Z" fill="#1E3A8A"/>
      <path d="M430 380 Q460 315 415 285 Q405 335 430 380 Z" fill="#96C594"/>
      <path d="M238 220 L222 380 L278 380 L262 220 Z" fill="#FFFFFF"/>
      <path d="M244 220 L236 380 L264 380 L256 220 Z" fill="#FBBF24"/>
      <g transform="translate(250, 145)">
        <path d="M-26 45 L-44 75 L-18 65 Z" fill="#EB5F69"/>
        <path d="M26 45 L44 75 L18 65 Z" fill="#EB5F69"/>
        <path d="M0 -65 C28 -25, 28 35, 22 65 L-22 65 C-28 35, -28 -25, 0 -65 Z" fill="#FFFFFF"/>
        <path d="M0 -65 C14 -45, 18 -25, 19 -15 L-19 -15 C-18 -25, -14 -45, 0 -65 Z" fill="#EB5F69"/>
        <circle cx="0" cy="10" r="12" fill="#1E293B" stroke="#669ACA" stroke-width="4"/>
        <path d="M-12 65 L12 65 L8 82 L-8 82 Z" fill="#F59E0B"/>
      </g>
      <circle cx="170" cy="60" r="4" fill="#FFFFFF"/>
      <circle cx="340" cy="120" r="5" fill="#FFFFFF"/>
      <circle cx="140" cy="180" r="3.5" fill="#FFFFFF"/>
      <path d="M330 45 L334 55 L344 59 L334 63 L330 73 L326 63 L316 59 L326 55 Z" fill="#FFFFFF"/>
      <path d="M80 185 L83 193 L91 196 L83 199 L80 207 L77 199 L69 196 L77 193 Z" fill="#FBBF24"/>
    </svg>
    <?php
    return ob_get_clean();
} );

// 3.5 Interactive Project Inquiry Form (WhatsApp + Direct Submit)
add_shortcode( 'up_inquiry_form', function() {
    ob_start(); ?>
    <div class="inquiry-form-card">
      <form id="projectForm" class="project-form" onsubmit="event.preventDefault(); submitInquiryForm();">
        <div class="project-form__top">
          <div>
            <h3 class="project-form__heading" data-i18n="form.title">Cuéntanos sobre tu proyecto</h3>
            <p class="project-form__sub" data-i18n="form.desc">Selecciona los servicios que te interesan y conversemos hoy mismo.</p>
          </div>
          <div class="service-selector-pills">
            <label class="pill-check">
              <input type="checkbox" name="services" value="Desarrollo Web a Medida" checked>
              <span data-i18n="form.pill1">Desarrollo Web</span>
            </label>
            <label class="pill-check">
              <input type="checkbox" name="services" value="UI/UX Design & Branding">
              <span data-i18n="form.pill2">UI/UX &amp; Branding</span>
            </label>
            <label class="pill-check">
              <input type="checkbox" name="services" value="E-Commerce">
              <span data-i18n="form.pill3">E-Commerce</span>
            </label>
            <label class="pill-check">
              <input type="checkbox" name="services" value="Mantenimiento & Velocidad">
              <span data-i18n="form.pill4">Velocidad / Soporte</span>
            </label>
            <label class="pill-check">
              <input type="checkbox" name="services" value="Automatizaciones & IA">
              <span data-i18n="form.pill5">Automatización &amp; IA</span>
            </label>
          </div>
        </div>

        <div class="project-form__grid">
          <div class="field-group">
            <label for="clientName" data-i18n="form.nameLabel">Tu Nombre *</label>
            <input type="text" id="clientName" placeholder="Ej. Alejandro Méndez" required>
          </div>
          <div class="field-group">
            <label for="clientCompany" data-i18n="form.companyLabel">Empresa / Marca</label>
            <input type="text" id="clientCompany" placeholder="Ej. Corporación GT / US LLC">
          </div>
          <div class="field-group">
            <label for="clientEmail" data-i18n="form.emailLabel">Correo Electrónico *</label>
            <input type="email" id="clientEmail" placeholder="nombre@empresa.com" required>
          </div>
          <div class="field-group">
            <label for="clientPhone" data-i18n="form.phoneLabel">WhatsApp / Teléfono *</label>
            <input type="tel" id="clientPhone" placeholder="+502 / +1 ..." required>
          </div>
        </div>

        <div class="field-group field-group--full">
          <label for="projectScope" data-i18n="form.detailsLabel">Resumen de tu idea o necesidades</label>
          <textarea id="projectScope" rows="2" placeholder="Ej. Buscamos rediseñar nuestro portal corporativo, mejorar tiempos de carga o lanzar tienda online..."></textarea>
        </div>

        <div class="project-form__actions">
          <button type="button" class="btn-form-wa" onclick="sendInquiryViaWhatsApp()">
            <i class="fa-brands fa-whatsapp"></i>
            <span data-i18n="form.btnSendWhatsApp">Enviar resumen por WhatsApp</span>
          </button>
          <button type="submit" class="btn-form-email">
            <i class="fa-regular fa-paper-plane"></i>
            <span data-i18n="form.btnSendEmail">Enviar Solicitud</span>
          </button>
        </div>
        <div id="formFeedback" class="form-feedback"></div>
      </form>
    </div>
    <?php
    return ob_get_clean();
} );

// 3.6 Footer Geometric Shapes Row + Persistent Floating WhatsApp
add_shortcode( 'up_footer_shapes', function() {
    ob_start(); ?>
    <div class="footer-shapes-row" aria-hidden="true">
      <svg class="f-shape f-shape--1" viewBox="0 0 60 60"><path d="M30 5V55M5 30H55M12 12L48 48M48 12L12 48" stroke="#BC80BB" stroke-width="8" stroke-linecap="round"/></svg>
      <svg class="f-shape f-shape--2" viewBox="0 0 80 80"><g fill="#EB5F69"><ellipse cx="40" cy="18" rx="10" ry="16"/><ellipse cx="40" cy="62" rx="10" ry="16"/><ellipse cx="18" cy="40" rx="16" ry="10"/><ellipse cx="62" cy="40" rx="16" ry="10"/><ellipse cx="24" cy="24" rx="12" ry="12"/><ellipse cx="56" cy="56" rx="12" ry="12"/><ellipse cx="56" cy="24" rx="12" ry="12"/><ellipse cx="24" cy="56" rx="12" ry="12"/></g><circle cx="40" cy="40" r="8" fill="#050505"/></svg>
      <svg class="f-shape f-shape--3" viewBox="0 0 90 90"><circle cx="45" cy="48" r="28" stroke="#F4A261" stroke-width="14" fill="none"/><path d="M32 18L45 5L58 18" stroke="#F4A261" stroke-width="10" stroke-linecap="round" stroke-linejoin="round" fill="none"/></svg>
      <svg class="f-shape f-shape--4" viewBox="0 0 80 80"><circle cx="40" cy="40" r="30" stroke="#71717A" stroke-width="8" fill="none"/><circle cx="40" cy="40" r="14" stroke="#71717A" stroke-width="8" fill="none"/></svg>
      <svg class="f-shape f-shape--5" viewBox="0 0 70 70"><text x="12" y="56" fill="#669ACA" font-size="62" font-weight="800" font-family="Georgia, serif">&amp;</text></svg>
      <svg class="f-shape f-shape--6" viewBox="0 0 80 80"><path d="M28 28H52V52H28V28ZM28 28C28 20 22 14 14 14C6 14 6 28 14 28H28ZM52 28C52 20 58 14 66 14C74 14 74 28 66 28H52ZM28 52C28 60 22 66 14 66C6 66 6 52 14 52H28ZM52 52C52 60 58 66 66 66C74 66 74 52 66 52H52Z" stroke="#96C594" stroke-width="7" fill="none"/></svg>
      <svg class="f-shape f-shape--7" viewBox="0 0 60 60"><path d="M30 4V56M4 30H56M11 11L49 49M49 11L11 49M30 4L23 18M30 4L37 18" stroke="#FBBF24" stroke-width="5" stroke-linecap="round"/></svg>
    </div>
    <aside class="floating-whatsapp-container" aria-label="Contacto rápido por WhatsApp">
      <a href="https://wa.me/50237556857?text=Hola%20UP%20Group%20Studio,%20quisiera%20conversar%20sobre%20un%20proyecto."
         target="_blank"
         rel="noopener noreferrer"
         class="floating-whatsapp"
         id="floatingWhatsapp"
         aria-label="Chatear por WhatsApp">
        <span class="floating-whatsapp__tooltip" data-i18n="floating.whatsappTooltip">¿Hablamos por WhatsApp?</span>
        <span class="floating-whatsapp__btn">
          <i class="fa-brands fa-whatsapp"></i>
        </span>
        <span class="floating-whatsapp__pulse"></span>
      </a>
    </aside>
    <?php
    return ob_get_clean();
} );


// 3.7 Criss-Crossed Marquee Ribbons (Transition Dark -> Light)
add_shortcode( 'up_marquee_ribbons', function() {
    ob_start(); ?>
    <div class="ribbons-transition" aria-hidden="true">
      <div class="ribbon ribbon--dark">
        <div class="ribbon__track">
          <span>✦ UP GROUP STUDIO</span><span>✦ WEB DEVELOPMENT</span><span>✦ UI/UX DESIGN</span><span>✦ E-COMMERCE</span><span>✦ AI AUTOMATION</span><span>✦ GUATEMALA</span><span>✦ HOUSTON</span>
          <span>✦ UP GROUP STUDIO</span><span>✦ WEB DEVELOPMENT</span><span>✦ UI/UX DESIGN</span><span>✦ E-COMMERCE</span><span>✦ AI AUTOMATION</span><span>✦ GUATEMALA</span><span>✦ HOUSTON</span>
        </div>
      </div>
      <div class="ribbon ribbon--light">
        <div class="ribbon__track ribbon__track--reverse">
          <span>✦ STUDIO.UP.GT</span><span>✦ IGNITE YOUR POTENTIAL</span><span>✦ DIGITAL STUDIO</span><span>✦ 95+ PAGESPEED</span><span>✦ CUSTOM CODE</span><span>✦ RODRIGO &amp; YULCER</span>
          <span>✦ STUDIO.UP.GT</span><span>✦ IGNITE YOUR POTENTIAL</span><span>✦ DIGITAL STUDIO</span><span>✦ 95+ PAGESPEED</span><span>✦ CUSTOM CODE</span><span>✦ RODRIGO &amp; YULCER</span>
        </div>
      </div>
    </div>
    <?php
    return ob_get_clean();
} );
