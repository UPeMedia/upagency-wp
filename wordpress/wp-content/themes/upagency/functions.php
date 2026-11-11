<?php 
/**
 * UP Group Studio (up.gt) — Bricks Builder Child Theme Functions
 * Architecture:
 *  1. Polylang & Locale Helper (`up_current_lang()`)
 *  2. Enqueue Google Fonts (Geist, Geist Mono, Caveat), Font Awesome 6, CSS & JS + Polylang URL Localization
 *  3. Register Custom Bricks Elements
 *  4. Register Bricks-Safe Bilingual Shortcodes (`[up_lang_switcher]`, `[up_scroll_stamp]`,
 *     `[up_manifesto_stamp_dark]`, `[up_manifesto_stamp_light]`, `[up_rocket_illustration]`,
 *     `[up_inquiry_form]`, `[up_footer_shapes]`, `[up_marquee_ribbons]`)
 */

// ─── 1. Polylang & Language Helper ────────────────────────────────────
if ( ! function_exists( 'up_current_lang' ) ) {
    function up_current_lang() {
        if ( function_exists( 'pll_current_language' ) ) {
            $slug = pll_current_language( 'slug' );
            if ( $slug ) {
                return strtolower( substr( $slug, 0, 2 ) ) === 'en' ? 'en' : 'es';
            }
        }
        $locale = function_exists( 'get_locale' ) ? get_locale() : 'es_GT';
        return strpos( strtolower( $locale ), 'en' ) === 0 ? 'en' : 'es';
    }
}

if ( ! function_exists( 'up_polylang_urls' ) ) {
    function up_polylang_urls() {
        $current = up_current_lang();
        $urls = [
            'es' => home_url( '/' ),
            'en' => home_url( '/en/' ),
        ];
        $is_polylang = false;

        if ( function_exists( 'pll_the_languages' ) ) {
            $raw = pll_the_languages( [ 'raw' => 1 ] );
            if ( is_array( $raw ) ) {
                $is_polylang = true;
                foreach ( $raw as $lang ) {
                    $code = isset( $lang['slug'] ) ? strtolower( substr( $lang['slug'], 0, 2 ) ) : '';
                    if ( ( $code === 'es' || $code === 'en' ) && ! empty( $lang['url'] ) ) {
                        $urls[ $code ] = $lang['url'];
                    }
                }
            }
        }

        return [
            'isPolylang' => $is_polylang,
            'isWordPress'=> true,
            'current'    => $current,
            'urls'       => $urls,
            'ajaxUrl'    => admin_url( 'admin-ajax.php' ),
            'leadNonce'  => wp_create_nonce( 'up_lead_nonce' ),
        ];
    }
}

// ─── 2. Enqueue Styles & Scripts ──────────────────────────────────────
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
        $css_ver  = file_exists($css_file) ? filemtime($css_file) : '3.1.0';
        wp_enqueue_style(
            'upagency-custom',
            get_stylesheet_directory_uri() . '/css/style.css',
            ['bricks-frontend', 'upagency-fonts', 'font-awesome-6'],
            $css_ver
        );

        // Custom Child Theme Scripts (js/script.js & js/project.js)
        $js_file = get_stylesheet_directory() . '/js/script.js';
        $js_ver  = file_exists($js_file) ? filemtime($js_file) : '3.1.0';
        wp_enqueue_script(
            'upagency-script',
            get_stylesheet_directory_uri() . '/js/script.js',
            [],
            $js_ver,
            true
        );

        // Pass Polylang URLs & WordPress Flag so JS never overwrites Bricks/Polylang content
        wp_localize_script(
            'upagency-script',
            'upPolylang',
            up_polylang_urls()
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

// ─── 3. Register Custom Bricks Elements ───────────────────────────────
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

// ─── 3.1 Redirect Portfolio & Taxonomy Archives (/proyectos, /projects) to Home #works ───
add_action( 'template_redirect', function() {
    $req_path   = trim( parse_url( $_SERVER['REQUEST_URI'] ?? '', PHP_URL_PATH ), '/' );
    $base_slugs = [
        'proyectos', 'proyecto', 'projects', 'project', 'portafolio', 'portfolio', 'work', 'trabajos',
        'categoria-proyecto', 'project-category', 'segmento', 'project-sector', 'ubicacion', 'project-location'
    ];
    $en_slugs   = array_map( function( $s ) { return 'en/' . $s; }, $base_slugs );

    if (
        is_post_type_archive( [ 'project', 'proyectos', 'portfolio' ] ) ||
        is_tax( [ 'project_category', 'project_sector', 'project_location', 'portfolio_category' ] ) ||
        in_array( strtolower( $req_path ), $base_slugs, true ) ||
        in_array( strtolower( $req_path ), $en_slugs, true )
    ) {
        $is_en  = ( up_current_lang() === 'en' ) || strpos( strtolower( $req_path ), 'en/' ) === 0;
        $target = $is_en ? home_url( '/en/#works' ) : home_url( '/#works' );
        wp_safe_redirect( $target, 301 );
        exit;
    }
} );

// ─── 3.2 Auto-Seed Default Project Taxonomies (Categories, Sectors, Locations — ES & EN) ───
add_action( 'init', function() {
    if ( ! taxonomy_exists( 'project_category' ) ) {
        return;
    }
    if ( get_option( 'up_project_taxonomies_seeded_v3' ) ) {
        return;
    }

    $taxonomy_seeds = [
        'project_category' => [
            [ 'es_name' => 'Desarrollo Web',   'es_slug' => 'desarrollo-web',   'en_name' => 'Web Development', 'en_slug' => 'web-development' ],
            [ 'es_name' => 'Diseño Web',       'es_slug' => 'diseno-web',       'en_name' => 'Web Design',      'en_slug' => 'web-design' ],
            [ 'es_name' => 'E-Commerce',       'es_slug' => 'e-commerce',       'en_name' => 'E-Commerce',      'en_slug' => 'e-commerce-en' ],
            [ 'es_name' => 'Identidad Visual', 'es_slug' => 'identidad-visual', 'en_name' => 'Visual Identity', 'en_slug' => 'visual-identity' ],
            [ 'es_name' => 'Fotografía',       'es_slug' => 'fotografia',       'en_name' => 'Photography',     'en_slug' => 'photography' ],
            [ 'es_name' => 'Redes Sociales',   'es_slug' => 'redes-sociales',   'en_name' => 'Social Media',    'en_slug' => 'social-media' ],
            [ 'es_name' => 'Multimedia',       'es_slug' => 'multimedia',       'en_name' => 'Multimedia',      'en_slug' => 'multimedia-en' ],
        ],
        'project_sector' => [
            [ 'es_name' => 'Hospitalidad & Turismo',    'es_slug' => 'hospitalidad-turismo',    'en_name' => 'Hospitality & Tourism',     'en_slug' => 'hospitality-tourism' ],
            [ 'es_name' => 'Centros Comerciales',       'es_slug' => 'centros-comerciales',     'en_name' => 'Shopping Centers & Retail', 'en_slug' => 'shopping-centers-retail' ],
            [ 'es_name' => 'Gobierno & Energía',        'es_slug' => 'gobierno-energia',        'en_name' => 'Government & Energy',       'en_slug' => 'government-energy' ],
            [ 'es_name' => 'Salud & Laboratorios',      'es_slug' => 'salud-laboratorios',      'en_name' => 'Healthcare & Labs',         'en_slug' => 'healthcare-labs' ],
            [ 'es_name' => 'Legal & Corporativo',       'es_slug' => 'legal-corporativo',       'en_name' => 'Legal & Corporate',         'en_slug' => 'legal-corporate' ],
            [ 'es_name' => 'Industria & Construcción',  'es_slug' => 'industria-construccion',  'en_name' => 'Industry & Construction',   'en_slug' => 'industry-construction' ],
            [ 'es_name' => 'Tecnología & IoT',          'es_slug' => 'tecnologia-iot',          'en_name' => 'Technology & IoT',          'en_slug' => 'technology-iot' ],
            [ 'es_name' => 'Automotriz & Servicios',    'es_slug' => 'automotriz-servicios',    'en_name' => 'Automotive & Services',     'en_slug' => 'automotive-services' ],
        ],
        'project_location' => [
            [ 'es_name' => 'Guatemala',         'es_slug' => 'guatemala',         'en_name' => 'Guatemala',         'en_slug' => 'guatemala-en' ],
            [ 'es_name' => 'Río Dulce, GT',     'es_slug' => 'rio-dulce-gt',      'en_name' => 'Río Dulce, GT',     'en_slug' => 'rio-dulce-gt-en' ],
            [ 'es_name' => 'Petén, GT',         'es_slug' => 'peten-gt',          'en_name' => 'Petén, GT',         'en_slug' => 'peten-gt-en' ],
            [ 'es_name' => 'Antigua Guatemala', 'es_slug' => 'antigua-guatemala', 'en_name' => 'Antigua Guatemala', 'en_slug' => 'antigua-guatemala-en' ],
            [ 'es_name' => 'Houston, TX',       'es_slug' => 'houston-tx',        'en_name' => 'Houston, TX',       'en_slug' => 'houston-tx-en' ],
            [ 'es_name' => 'Dallas, TX',        'es_slug' => 'dallas-tx',         'en_name' => 'Dallas, TX',        'en_slug' => 'dallas-tx-en' ],
            [ 'es_name' => 'Miami, FL',         'es_slug' => 'miami-fl',          'en_name' => 'Miami, FL',         'en_slug' => 'miami-fl-en' ],
            [ 'es_name' => 'Regional / LATAM',  'es_slug' => 'regional-latam',    'en_name' => 'Regional / LATAM',  'en_slug' => 'regional-latam-en' ],
        ],
    ];

    foreach ( $taxonomy_seeds as $tax_name => $terms ) {
        if ( ! taxonomy_exists( $tax_name ) ) {
            continue;
        }
        foreach ( $terms as $item ) {
            $es_term = term_exists( $item['es_slug'], $tax_name );
            if ( ! $es_term ) {
                $es_term = wp_insert_term( $item['es_name'], $tax_name, [ 'slug' => $item['es_slug'] ] );
            }
            $es_term_id = is_array( $es_term ) ? (int) $es_term['term_id'] : (int) $es_term;

            if ( $es_term_id && function_exists( 'pll_set_term_language' ) ) {
                pll_set_term_language( $es_term_id, 'es' );

                if ( function_exists( 'pll_languages_list' ) && in_array( 'en', pll_languages_list(), true ) ) {
                    $en_term = term_exists( $item['en_slug'], $tax_name );
                    if ( ! $en_term ) {
                        $en_term = wp_insert_term( $item['en_name'], $tax_name, [ 'slug' => $item['en_slug'] ] );
                    }
                    $en_term_id = is_array( $en_term ) ? (int) $en_term['term_id'] : (int) $en_term;

                    if ( $en_term_id && ! is_wp_error( $en_term ) ) {
                        pll_set_term_language( $en_term_id, 'en' );
                        if ( function_exists( 'pll_save_term_translations' ) ) {
                            pll_save_term_translations( [
                                'es' => $es_term_id,
                                'en' => $en_term_id,
                            ] );
                        }
                    }
                }
            }
        }
    }

    update_option( 'up_project_taxonomies_seeded_v3', 1 );
}, 25 );

// ─── 4. Register Bricks-Safe Shortcodes ───────────────────────────────

// 4.0 Polylang Language Switcher Shortcode
add_shortcode( 'up_lang_switcher', function() {
    $pll = up_polylang_urls();
    $cur = $pll['current'];
    $es_url = esc_url( $pll['urls']['es'] );
    $en_url = esc_url( $pll['urls']['en'] );
    ob_start(); ?>
    <div class="lang-switcher" id="langSwitcher" role="group" aria-label="<?php echo $cur === 'en' ? 'Language Switcher' : 'Selector de idioma'; ?>">
      <a href="<?php echo $es_url; ?>" class="lang-btn <?php echo $cur === 'es' ? 'active' : ''; ?>" data-lang="es" data-pll-url="<?php echo $es_url; ?>">ES</a>
      <span class="lang-sep">/</span>
      <a href="<?php echo $en_url; ?>" class="lang-btn <?php echo $cur === 'en' ? 'active' : ''; ?>" data-lang="en" data-pll-url="<?php echo $en_url; ?>">EN</a>
    </div>
    <?php
    return ob_get_clean();
} );

// 4.1 Hero Circular Rotating Stamp
add_shortcode( 'up_scroll_stamp', function() {
    $is_en = ( up_current_lang() === 'en' );
    ob_start(); ?>
    <a href="#works" class="scroll-stamp" aria-label="<?php echo $is_en ? 'View projects' : 'Ver proyectos'; ?>">
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

// 4.2 Manifesto 1 Dark Rotating Stamp ("We Speak Geek, But We're Friendly")
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

// 4.3 Manifesto 2 Light Rotating Stamp ("Zero Copy-Paste • Pixel Obsessed")
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

// 4.4 Split Banner Rocket SVG Illustration
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

// 4.5 Interactive Project Inquiry Form (Polylang Bilingual ES/EN + WhatsApp + Direct Submit)
add_shortcode( 'up_inquiry_form', function() {
    $is_en = ( up_current_lang() === 'en' );
    ob_start(); ?>
    <div class="inquiry-form-card">
      <form id="projectForm" class="project-form" onsubmit="event.preventDefault(); submitInquiryForm();">
        <div class="project-form__top">
          <div>
            <h3 class="project-form__heading" data-i18n="form.title">
              <?php echo $is_en ? 'Tell us about your project' : 'Cuéntanos sobre tu proyecto'; ?>
            </h3>
            <p class="project-form__sub" data-i18n="form.desc">
              <?php echo $is_en ? 'Select the services you need and let’s talk today.' : 'Selecciona los servicios que te interesan y conversemos hoy mismo.'; ?>
            </p>
          </div>
          <div class="service-selector-pills">
            <label class="pill-check">
              <input type="checkbox" name="services" value="Desarrollo Web a Medida" checked>
              <span data-i18n="form.pill1"><?php echo $is_en ? 'Web Development' : 'Desarrollo Web'; ?></span>
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
              <span data-i18n="form.pill4"><?php echo $is_en ? 'Speed / Support' : 'Velocidad / Soporte'; ?></span>
            </label>
            <label class="pill-check">
              <input type="checkbox" name="services" value="Automatizaciones & IA">
              <span data-i18n="form.pill5"><?php echo $is_en ? 'AI & Automation' : 'Automatización &amp; IA'; ?></span>
            </label>
          </div>
        </div>

        <div class="project-form__grid">
          <div class="field-group">
            <label for="clientName" data-i18n="form.nameLabel"><?php echo $is_en ? 'Your Name *' : 'Tu Nombre *'; ?></label>
            <input type="text" id="clientName" placeholder="<?php echo $is_en ? 'e.g. Alex Morgan' : 'Ej. Alejandro Méndez'; ?>" required>
          </div>
          <div class="field-group">
            <label for="clientCompany" data-i18n="form.companyLabel"><?php echo $is_en ? 'Company / Brand' : 'Empresa / Marca'; ?></label>
            <input type="text" id="clientCompany" placeholder="<?php echo $is_en ? 'e.g. US LLC / Corp' : 'Ej. Corporación GT / US LLC'; ?>">
          </div>
          <div class="field-group">
            <label for="clientEmail" data-i18n="form.emailLabel"><?php echo $is_en ? 'Email Address *' : 'Correo Electrónico *'; ?></label>
            <input type="email" id="clientEmail" placeholder="<?php echo $is_en ? 'name@company.com' : 'nombre@empresa.com'; ?>" required>
          </div>
          <div class="field-group">
            <label for="clientPhone" data-i18n="form.phoneLabel"><?php echo $is_en ? 'WhatsApp / Phone *' : 'WhatsApp / Teléfono *'; ?></label>
            <input type="tel" id="clientPhone" placeholder="+502 / +1 ..." required>
          </div>
        </div>

        <div class="field-group field-group--full">
          <label for="projectScope" data-i18n="form.detailsLabel"><?php echo $is_en ? 'Project summary or goals' : 'Resumen de tu idea o necesidades'; ?></label>
          <textarea id="projectScope" rows="2" placeholder="<?php echo $is_en ? 'e.g. We want to redesign our corporate website, improve page speed, or launch an online store...' : 'Ej. Buscamos rediseñar nuestro portal corporativo, mejorar tiempos de carga o lanzar tienda online...'; ?>"></textarea>
        </div>

        <!-- Anti-spam Honeypot (hidden from humans) -->
        <div class="up-hp-wrap" aria-hidden="true" style="position:absolute;left:-9999px;opacity:0;pointer-events:none;">
          <input type="text" id="upWebsiteHp" name="up_website_hp" tabindex="-1" autocomplete="off">
        </div>

        <!-- Privacy & Email/WhatsApp Follow-up Consent Disclaimer -->
        <div class="form-consent-row">
          <label class="form-consent-label" for="clientConsent">
            <input type="checkbox" id="clientConsent" name="client_consent" checked required>
            <span data-i18n="form.consent">
              <?php if ( $is_en ) : ?>
                I agree that <strong>UP Group Studio</strong> may store my details and contact me via email or WhatsApp regarding my project inquiry. Zero spam.
              <?php else : ?>
                Acepto que <strong>UP Group Studio</strong> almacene mis datos y me envíe seguimiento por correo electrónico o WhatsApp respecto a mi solicitud. Cero spam.
              <?php endif; ?>
            </span>
          </label>
        </div>

        <div class="project-form__actions">
          <button type="button" class="btn-form-wa" onclick="sendInquiryViaWhatsApp()">
            <i class="fa-brands fa-whatsapp"></i>
            <span data-i18n="form.btnSendWhatsApp"><?php echo $is_en ? 'Send summary via WhatsApp' : 'Enviar resumen por WhatsApp'; ?></span>
          </button>
          <button type="submit" id="btnSubmitInquiry" class="btn-form-email">
            <i class="fa-regular fa-paper-plane"></i>
            <span data-i18n="form.btnSendEmail"><?php echo $is_en ? 'Submit Inquiry' : 'Enviar Solicitud'; ?></span>
          </button>
        </div>
        <div id="formFeedback" class="form-feedback" role="status" aria-live="polite"></div>
      </form>
    </div>
    <?php
    return ob_get_clean();
} );

// 4.6 Footer Geometric Shapes Row + Persistent Floating WhatsApp (Bilingual ES/EN)
add_shortcode( 'up_footer_shapes', function() {
    $is_en = ( up_current_lang() === 'en' );
    $wa_text = $is_en
        ? 'https://wa.me/50237556857?text=Hello%20UP%20Group%20Studio,%20I%20would%20like%20to%20discuss%20a%20project.'
        : 'https://wa.me/50237556857?text=Hola%20UP%20Group%20Studio,%20quisiera%20conversar%20sobre%20un%20proyecto.';
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
    <aside class="floating-whatsapp-container" aria-label="<?php echo $is_en ? 'Quick WhatsApp contact' : 'Contacto rápido por WhatsApp'; ?>">
      <a href="<?php echo esc_url( $wa_text ); ?>"
         target="_blank"
         rel="noopener noreferrer"
         class="floating-whatsapp"
         id="floatingWhatsapp"
         aria-label="<?php echo $is_en ? 'Chat on WhatsApp' : 'Chatear por WhatsApp'; ?>">
        <span class="floating-whatsapp__tooltip" data-i18n="floating.whatsappTooltip"><?php echo $is_en ? 'Chat with us on WhatsApp' : '¿Hablamos por WhatsApp?'; ?></span>
        <span class="floating-whatsapp__btn">
          <i class="fa-brands fa-whatsapp"></i>
        </span>
        <span class="floating-whatsapp__pulse"></span>
      </a>
    </aside>
    <?php
    return ob_get_clean();
} );


// 4.7 Criss-Crossed Marquee Ribbons (Transition Dark -> Light)
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
          <span>✦ UP.GT</span><span>✦ IGNITE YOUR POTENTIAL</span><span>✦ DIGITAL STUDIO</span><span>✦ 95+ PAGESPEED</span><span>✦ CUSTOM CODE</span><span>✦ RODRIGO &amp; YULCER</span>
          <span>✦ UP.GT</span><span>✦ IGNITE YOUR POTENTIAL</span><span>✦ DIGITAL STUDIO</span><span>✦ 95+ PAGESPEED</span><span>✦ CUSTOM CODE</span><span>✦ RODRIGO &amp; YULCER</span>
        </div>
      </div>
    </div>
    <?php
    return ob_get_clean();
} );

// 4.8 Helper: Read Project ACF/Meta Field with Automatic Polylang Translation Fallback (ES <-> EN)
if ( ! function_exists( 'up_get_project_field' ) ) {
    function up_get_project_field( $field_name, $post_id = 0, $ignore_default_color = false ) {
        if ( ! $post_id ) {
            $post_id = get_the_ID();
        }
        $val = function_exists( 'get_field' ) ? get_field( $field_name, $post_id ) : get_post_meta( $post_id, $field_name, true );

        $is_empty = empty( $val ) || ( $ignore_default_color && is_string( $val ) && strtolower( trim( $val ) ) === '#205466' );

        if ( $is_empty && function_exists( 'pll_get_post_translations' ) ) {
            $translations = pll_get_post_translations( $post_id );
            if ( is_array( $translations ) ) {
                foreach ( $translations as $lang_code => $tr_id ) {
                    if ( (int) $tr_id !== (int) $post_id && $tr_id > 0 ) {
                        $tr_val = function_exists( 'get_field' ) ? get_field( $field_name, $tr_id ) : get_post_meta( $tr_id, $field_name, true );
                        if ( ! empty( $tr_val ) && ! ( $ignore_default_color && is_string( $tr_val ) && strtolower( trim( $tr_val ) ) === '#205466' ) ) {
                            return $tr_val;
                        }
                    }
                }
            }
        }
        return $val;
    }
}

// 4.8 Case Study Auto-Scrolling Desktop & Mobile Device Frames Shortcode
add_shortcode( 'up_case_hero_devices', function() {
    $post_id     = get_the_ID();
    $title       = get_the_title( $post_id );
    $desktop_img = up_get_project_field( 'project_screenshot_desktop', $post_id );
    $mobile_img  = up_get_project_field( 'project_screenshot_mobile', $post_id );
    $live_url    = up_get_project_field( 'project_live_url', $post_id );
    $band_bg     = up_get_project_field( 'project_band_bg', $post_id, true );
    if ( empty( $band_bg ) ) {
        $band_bg = up_get_project_field( 'project_theme_color', $post_id, true );
    }
    if ( empty( $band_bg ) ) {
        $band_bg = up_get_project_field( 'project_band_bg', $post_id, false );
    }

    // Resolve image URL if ACF returns array or ID
    if ( is_array( $desktop_img ) && isset( $desktop_img['url'] ) ) {
        $desktop_img = $desktop_img['url'];
    } elseif ( is_numeric( $desktop_img ) ) {
        $desktop_img = wp_get_attachment_image_url( (int) $desktop_img, 'full' );
    }
    if ( is_array( $mobile_img ) && isset( $mobile_img['url'] ) ) {
        $mobile_img = $mobile_img['url'];
    } elseif ( is_numeric( $mobile_img ) ) {
        $mobile_img = wp_get_attachment_image_url( (int) $mobile_img, 'full' );
    }

    $host_label = $live_url ? preg_replace( '#^https?://(www\.)?#i', '', rtrim( $live_url, '/' ) ) : 'up.gt';
    $accent     = $band_bg ? esc_attr( $band_bg ) : '#205466';

    ob_start(); ?>
    <div class="up-devices-showcase" style="--case-brand-color: <?php echo $accent; ?>;">
      <!-- Desktop Browser Frame (Auto-Scrolling Full-Height Screenshot) -->
      <div class="up-device-desktop">
        <div class="up-device-desktop__bar">
          <div class="up-device-dots">
            <span class="dot-r"></span>
            <span class="dot-y"></span>
            <span class="dot-g"></span>
          </div>
          <div class="up-device-url"><?php echo esc_html( $host_label ); ?></div>
          <div class="up-device-badge">DESKTOP</div>
        </div>
        <div class="up-device-desktop__viewport">
          <?php if ( ! empty( $desktop_img ) ) : ?>
            <img src="<?php echo esc_url( $desktop_img ); ?>" alt="<?php echo esc_attr( $title . ' — Desktop' ); ?>" class="up-autoscroll-img up-autoscroll-img--desktop" loading="eager">
          <?php else : ?>
            <div class="up-device-fallback">
              <span><?php echo esc_html( $title ); ?></span>
            </div>
          <?php endif; ?>
        </div>
      </div>

      <!-- Mobile Phone Frame (Auto-Scrolling Full-Height Screenshot) -->
      <div class="up-device-mobile">
        <div class="up-device-mobile__notch"></div>
        <div class="up-device-mobile__viewport">
          <?php if ( ! empty( $mobile_img ) ) : ?>
            <img src="<?php echo esc_url( $mobile_img ); ?>" alt="<?php echo esc_attr( $title . ' — Mobile' ); ?>" class="up-autoscroll-img up-autoscroll-img--mobile" loading="eager">
          <?php elseif ( ! empty( $desktop_img ) ) : ?>
            <img src="<?php echo esc_url( $desktop_img ); ?>" alt="<?php echo esc_attr( $title . ' — Mobile' ); ?>" class="up-autoscroll-img up-autoscroll-img--mobile" loading="eager">
          <?php else : ?>
            <div class="up-device-fallback">
              <span>MOBILE</span>
            </div>
          <?php endif; ?>
        </div>
      </div>
    </div>
    <?php
    return ob_get_clean();
} );

// 4.9 Case Study Optional Live Website Link & Embedded Video Player Shortcode
add_shortcode( 'up_case_media_actions', function() {
    $post_id   = get_the_ID();
    $is_en     = ( up_current_lang() === 'en' );
    $live_url  = up_get_project_field( 'project_live_url', $post_id );
    $video_url = up_get_project_field( 'project_video_url', $post_id );

    if ( empty( $live_url ) && empty( $video_url ) ) {
        return '';
    }

    // Prepare embedded video HTML if a video URL is provided
    $video_embed_html = '';
    if ( ! empty( $video_url ) ) {
        if ( preg_match( '/\.(mp4|webm|ogg|mov)(\?.*)?$/i', $video_url ) ) {
            $video_embed_html = sprintf(
                '<video class="up-case-video-player" src="%s" controls playsinline preload="metadata"></video>',
                esc_url( $video_url )
            );
        } else {
            $oembed = wp_oembed_get( $video_url );
            if ( $oembed ) {
                $video_embed_html = $oembed;
            } else {
                $video_embed_html = sprintf(
                    '<iframe class="up-case-video-iframe" src="%s" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen loading="lazy"></iframe>',
                    esc_url( $video_url )
                );
            }
        }
    }

    ob_start(); ?>
    <div class="up-case-media-stack">
      <?php if ( ! empty( $live_url ) ) : ?>
        <div class="up-case-actions-bar">
          <a href="<?php echo esc_url( $live_url ); ?>" target="_blank" rel="noopener noreferrer" class="up-case-action-btn up-case-action-btn--primary">
            <i class="fa-solid fa-arrow-up-right-from-square"></i>
            <span><?php echo $is_en ? 'Visit Live Website' : 'Visitar Sitio Web en Vivo'; ?></span>
          </a>
        </div>
      <?php endif; ?>

      <?php if ( ! empty( $video_embed_html ) ) : ?>
        <div class="up-case-video-embed">
          <?php echo $video_embed_html; ?>
        </div>
      <?php endif; ?>
    </div>
    <?php
    return ob_get_clean();
} );

// ─── 5. Dynamic Project Theme Color & Cover Image Injector (Single Project ES & EN Templates) ───
// Works seamlessly on both Bricks templates:
//  - up-group-studio-single-portfolio-case-study-vml-layout (ES)
//  - up-group-studio-single-portfolio-case-study-vml-layout-en (EN)
add_action( 'wp_head', function() {
    if ( ! is_singular( 'project' ) ) {
        return;
    }

    $post_id  = get_the_ID();
    $band_bg  = up_get_project_field( 'project_band_bg', $post_id, true );
    if ( empty( $band_bg ) ) {
        $band_bg = up_get_project_field( 'project_theme_color', $post_id, true );
    }
    if ( empty( $band_bg ) ) {
        $band_bg = up_get_project_field( 'project_band_bg', $post_id, false );
    }
    $band_bg = ! empty( $band_bg ) ? trim( (string) $band_bg ) : '#205466';

    // Determine high-contrast text color (#FFFFFF for dark backgrounds, #14110F for light backgrounds)
    $band_text = '#FFFFFF';
    $hex       = ltrim( $band_bg, '#' );
    if ( strlen( $hex ) === 3 ) {
        $hex = $hex[0] . $hex[0] . $hex[1] . $hex[1] . $hex[2] . $hex[2];
    }
    if ( strlen( $hex ) === 6 && ctype_xdigit( $hex ) ) {
        $r   = hexdec( substr( $hex, 0, 2 ) );
        $g   = hexdec( substr( $hex, 2, 2 ) );
        $b   = hexdec( substr( $hex, 4, 2 ) );
        $lum = ( 0.299 * $r + 0.587 * $g + 0.114 * $b ) / 255;
        if ( $lum > 0.60 ) {
            $band_text = '#14110F';
        }
    }

    $thumb_url = get_the_post_thumbnail_url( $post_id, 'full' );
    if ( empty( $thumb_url ) && function_exists( 'pll_get_post_translations' ) ) {
        $translations = pll_get_post_translations( $post_id );
        if ( is_array( $translations ) ) {
            foreach ( $translations as $tr_id ) {
                if ( (int) $tr_id !== (int) $post_id && $tr_id > 0 ) {
                    $tr_thumb = get_the_post_thumbnail_url( $tr_id, 'full' );
                    if ( ! empty( $tr_thumb ) ) {
                        $thumb_url = $tr_thumb;
                        break;
                    }
                }
            }
        }
    }
    ?>
    <style id="up-case-dynamic-theme">
      :root {
        --case-brand-color: <?php echo esc_attr( $band_bg ); ?>;
        --case-band-text: <?php echo esc_attr( $band_text ); ?>;
      }
      /* 1. Colored Editorial Intro Band (Section 2) */
      #caseIntroBand,
      .case-intro-band {
        background-color: var(--case-brand-color) !important;
        color: var(--case-band-text) !important;
      }
      /* 2. Hero Cover Stage Accents & Featured Image Backdrop (Section 1) */
      <?php if ( ! empty( $thumb_url ) ) : ?>
      #caseHeroCover .cover-stage-art,
      .case-hero-cover .cover-stage-art {
        background-image: linear-gradient(135deg, rgba(7, 7, 11, 0.84) 0%, rgba(7, 7, 11, 0.68) 50%, rgba(7, 7, 11, 0.88) 100%), url('<?php echo esc_url( $thumb_url ); ?>');
        background-size: cover;
        background-position: center;
      }
      <?php endif; ?>
      .cover-device--left .cover-device__screen {
        background: linear-gradient(145deg, var(--case-brand-color), #111118);
      }
      .cover-device--right .cover-device__screen {
        background: linear-gradient(165deg, #111118, var(--case-brand-color));
      }
      /* 3. Key Impact Metrics Numbers & Live Button Hover (Section 3) */
      .case-metric-number {
        color: var(--case-brand-color);
      }
      .up-case-action-btn--primary:hover {
        background-color: var(--case-brand-color);
        color: var(--case-band-text);
      }
    </style>
    <?php
}, 30 );

// ─── 6. Automatic Open Graph (WhatsApp / LinkedIn / Meta) & Twitter Card Meta Tags ───
add_action( 'wp_head', function() {
    // Avoid duplicate OG tags if an SEO plugin is already outputting og:image
    if ( defined( 'WPSEO_VERSION' ) || class_exists( 'RankMath' ) || defined( 'SEOPRESS_VERSION' ) ) {
        return;
    }

    $is_en    = ( up_current_lang() === 'en' );
    $site_url = home_url( $_SERVER['REQUEST_URI'] ?? '/' );
    $og_img   = get_stylesheet_directory_uri() . '/assets/' . ( $is_en ? 'og-share-en.jpg' : 'og-share-es.jpg' );
    $og_type  = 'website';

    if ( is_singular( 'project' ) ) {
        $post_id   = get_the_ID();
        $og_type   = 'article';
        $headline  = up_get_project_field( 'project_headline', $post_id );
        $og_title  = get_the_title( $post_id ) . ' — ' . ( $is_en ? 'Case Study | UP Group Studio' : 'Caso de Estudio | UP Group Studio' );
        $og_desc   = has_excerpt( $post_id ) ? get_the_excerpt( $post_id ) : ( $headline ? $headline : '' );
        $thumb_url = get_the_post_thumbnail_url( $post_id, 'large' );
        if ( ! empty( $thumb_url ) ) {
            $og_img = $thumb_url;
        }
    } else {
        $og_title = $is_en
            ? 'UP Group Studio | Ignite Your Online Potential — Guatemala & Houston, TX'
            : 'UP Group Studio | Enciende tu Potencial Digital — Guatemala & Houston, TX';
        $og_desc  = $is_en
            ? 'Boutique digital product & creative studio in Guatemala and Houston, TX. 15+ years crafting custom websites, UI/UX design, e-commerce, and high-converting platforms.'
            : 'Estudio digital en Guatemala y Houston, TX. Más de 15 años creando sitios web a medida, diseño UI/UX, e-commerce e identidades visuales que cautivan y convierten.';
    }
    ?>
    <!-- UP Group Studio — Open Graph & WhatsApp Preview -->
    <meta property="og:locale" content="<?php echo $is_en ? 'en_US' : 'es_GT'; ?>">
    <meta property="og:type" content="<?php echo esc_attr( $og_type ); ?>">
    <meta property="og:site_name" content="UP Group Studio">
    <meta property="og:title" content="<?php echo esc_attr( $og_title ); ?>">
    <meta property="og:description" content="<?php echo esc_attr( wp_strip_all_tags( $og_desc ) ); ?>">
    <meta property="og:url" content="<?php echo esc_url( $site_url ); ?>">
    <meta property="og:image" content="<?php echo esc_url( $og_img ); ?>">
    <meta property="og:image:secure_url" content="<?php echo esc_url( $og_img ); ?>">
    <meta property="og:image:type" content="image/jpeg">
    <meta property="og:image:width" content="1200">
    <meta property="og:image:height" content="630">
    <meta property="og:image:alt" content="<?php echo esc_attr( $og_title ); ?>">
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="<?php echo esc_attr( $og_title ); ?>">
    <meta name="twitter:description" content="<?php echo esc_attr( wp_strip_all_tags( $og_desc ) ); ?>">
    <meta name="twitter:image" content="<?php echo esc_url( $og_img ); ?>">
    <?php
}, 5 );

// ─── 7. Lead Capture CRM Engine (WP Database + Partial Auto-Save + Email + Google Sheets + HubSpot) ───

// 7.1 Register Private CPT `up_lead` ("Leads / Contactos")
add_action( 'init', function() {
    register_post_type( 'up_lead', [
        'labels' => [
            'name'               => 'Leads / Contactos',
            'singular_name'      => 'Lead',
            'menu_name'          => 'Leads / Contactos',
            'all_items'          => 'Todos los Leads',
            'view_item'          => 'Ver Lead',
            'edit_item'          => 'Detalle del Lead',
            'search_items'       => 'Buscar Leads',
            'not_found'          => 'Aún no hay leads registrados.',
            'not_found_in_trash' => 'No hay leads en la papelera.',
        ],
        'public'              => false,
        'show_ui'             => true,
        'show_in_menu'        => true,
        'menu_position'       => 6,
        'menu_icon'           => 'dashicons-email-alt2',
        'supports'            => [ 'title' ],
        'capability_type'     => 'post',
        'capabilities'        => [
            'create_posts' => 'do_not_allow',
        ],
        'map_meta_cap'        => true,
    ] );
} );

// 7.2 Custom Columns for `up_lead` Admin Table
add_filter( 'manage_up_lead_posts_columns', function( $columns ) {
    return [
        'cb'          => '<input type="checkbox" />',
        'lead_status' => 'Estado',
        'title'       => 'Contacto / Empresa',
        'lead_contact'=> 'Email & WhatsApp',
        'lead_srv'    => 'Servicios de Interés',
        'lead_consent'=> 'Consentimiento',
        'lead_sync'   => 'Integraciones',
        'date'        => 'Fecha',
    ];
} );

add_action( 'manage_up_lead_posts_custom_column', function( $column, $post_id ) {
    $status  = get_post_meta( $post_id, '_up_lead_status', true ) ?: 'partial';
    $email   = get_post_meta( $post_id, '_up_lead_email', true );
    $phone   = get_post_meta( $post_id, '_up_lead_phone', true );
    $srv     = get_post_meta( $post_id, '_up_lead_services', true );
    $consent = get_post_meta( $post_id, '_up_lead_consent', true );
    $lang    = strtoupper( get_post_meta( $post_id, '_up_lead_lang', true ) ?: 'es' );
    $em_sent = get_post_meta( $post_id, '_up_lead_email_sent', true );
    $gs_sent = get_post_meta( $post_id, '_up_lead_gsheets_synced', true );
    $hs_sent = get_post_meta( $post_id, '_up_lead_hubspot_synced', true );

    switch ( $column ) {
        case 'lead_status':
            if ( $status === 'completed' ) {
                echo '<span style="display:inline-block;padding:4px 10px;border-radius:99px;background:#DCFCE7;color:#166534;font-weight:700;font-size:11.5px;">🟢 Completado (' . esc_html( $lang ) . ')</span>';
            } elseif ( $status === 'whatsapp' ) {
                echo '<span style="display:inline-block;padding:4px 10px;border-radius:99px;background:#D1FAE5;color:#065F46;font-weight:700;font-size:11.5px;">💬 Vía WhatsApp (' . esc_html( $lang ) . ')</span>';
            } else {
                echo '<span style="display:inline-block;padding:4px 10px;border-radius:99px;background:#FEF3C7;color:#92400E;font-weight:700;font-size:11.5px;">🟡 Parcial / Sin enviar (' . esc_html( $lang ) . ')</span>';
            }
            break;

        case 'lead_contact':
            if ( $email ) {
                echo '<div><a href="mailto:' . esc_attr( $email ) . '" style="font-weight:600;">' . esc_html( $email ) . '</a></div>';
            }
            if ( $phone ) {
                $clean_wa = preg_replace( '/\D+/', '', $phone );
                echo '<div style="margin-top:3px;"><a href="https://wa.me/' . esc_attr( $clean_wa ) . '" target="_blank" rel="noopener" style="color:#15803D;font-weight:600;">📱 ' . esc_html( $phone ) . '</a></div>';
            }
            break;

        case 'lead_srv':
            echo '<span style="font-size:12px;color:#3F3F46;">' . esc_html( $srv ?: '—' ) . '</span>';
            break;

        case 'lead_consent':
            if ( $consent === '1' ) {
                echo '<span style="color:#166534;font-weight:600;font-size:12px;">✓ Opt-In Aceptado</span>';
            } else {
                echo '<span style="color:#71717A;font-size:12px;">—</span>';
            }
            break;

        case 'lead_sync':
            $badges = [];
            if ( $em_sent ) $badges[] = '<span title="Email enviado" style="background:#E0E7FF;color:#1E40AF;padding:2px 7px;border-radius:6px;font-size:11px;font-weight:600;">✉️ Email</span>';
            if ( $gs_sent ) $badges[] = '<span title="Sincronizado con Google Sheets" style="background:#DCFCE7;color:#166534;padding:2px 7px;border-radius:6px;font-size:11px;font-weight:600;">📊 Sheets</span>';
            if ( $hs_sent ) $badges[] = '<span title="Sincronizado con HubSpot" style="background:#FFEDD5;color:#9A3412;padding:2px 7px;border-radius:6px;font-size:11px;font-weight:600;">🟠 HubSpot</span>';
            echo ! empty( $badges ) ? implode( ' ', $badges ) : '<span style="color:#A1A1AA;font-size:11.5px;">Local DB</span>';
            break;
    }
}, 10, 2 );

// 7.3 Lead Detail Meta Box in WP Admin
add_action( 'add_meta_boxes', function() {
    add_meta_box(
        'up_lead_details_box',
        'Ficha Completa del Prospecto (UP Group Studio)',
        function( $post ) {
            $fields = [
                'Estado del Lead'         => get_post_meta( $post->ID, '_up_lead_status', true ),
                'Nombre Completo'         => get_post_meta( $post->ID, '_up_lead_name', true ),
                'Empresa / Marca'         => get_post_meta( $post->ID, '_up_lead_company', true ),
                'Correo Electrónico'      => get_post_meta( $post->ID, '_up_lead_email', true ),
                'WhatsApp / Teléfono'     => get_post_meta( $post->ID, '_up_lead_phone', true ),
                'Servicios Seleccionados' => get_post_meta( $post->ID, '_up_lead_services', true ),
                'Resumen del Proyecto'    => get_post_meta( $post->ID, '_up_lead_scope', true ),
                'Consentimiento (Opt-In)' => get_post_meta( $post->ID, '_up_lead_consent', true ) === '1' ? 'Sí — Aceptó recibir seguimiento por correo/WhatsApp' : 'No marcado',
                'Idioma de Navegación'    => strtoupper( get_post_meta( $post->ID, '_up_lead_lang', true ) ?: 'ES' ),
                'URL de Origen'           => get_post_meta( $post->ID, '_up_lead_page_url', true ),
                'Token de Sesión'         => get_post_meta( $post->ID, '_up_lead_token', true ),
                'Última Actualización'    => get_post_meta( $post->ID, '_up_lead_updated_at', true ),
            ];
            echo '<table class="widefat striped" style="margin-top:8px;"><tbody>';
            foreach ( $fields as $label => $val ) {
                echo '<tr><th style="width:220px;font-weight:700;">' . esc_html( $label ) . '</th><td>' . nl2br( esc_html( $val ?: '—' ) ) . '</td></tr>';
            }
            echo '</tbody></table>';
        },
        'up_lead',
        'normal',
        'high'
    );
} );

// 7.4 Settings Submenu: "Leads / Contactos -> Configuración & Integraciones"
add_action( 'admin_menu', function() {
    add_submenu_page(
        'edit.php?post_type=up_lead',
        'Configuración de Leads & Integraciones',
        '⚙️ Configuración & CRM',
        'manage_options',
        'up-leads-settings',
        'up_render_leads_settings_page'
    );
} );

function up_render_leads_settings_page() {
    if ( ! current_user_can( 'manage_options' ) ) {
        return;
    }

    if ( isset( $_POST['up_leads_settings_nonce'] ) && wp_verify_nonce( $_POST['up_leads_settings_nonce'], 'up_save_leads_settings' ) ) {
        update_option( 'up_lead_notify_email', sanitize_text_field( $_POST['up_lead_notify_email'] ?? '' ) );
        update_option( 'up_lead_enable_partial', isset( $_POST['up_lead_enable_partial'] ) ? '1' : '0' );
        update_option( 'up_lead_gsheets_webhook', esc_url_raw( trim( $_POST['up_lead_gsheets_webhook'] ?? '' ) ) );
        update_option( 'up_lead_hubspot_portal_id', sanitize_text_field( trim( $_POST['up_lead_hubspot_portal_id'] ?? '' ) ) );
        update_option( 'up_lead_hubspot_form_guid', sanitize_text_field( trim( $_POST['up_lead_hubspot_form_guid'] ?? '' ) ) );
        update_option( 'up_lead_hubspot_token', sanitize_text_field( trim( $_POST['up_lead_hubspot_token'] ?? '' ) ) );
        echo '<div class="notice notice-success is-dismissible"><p><strong>✓ Configuración guardada correctamente.</strong></p></div>';
    }

    $notify_email  = get_option( 'up_lead_notify_email', get_option( 'admin_email' ) );
    $enable_partial= get_option( 'up_lead_enable_partial', '1' );
    $gs_webhook    = get_option( 'up_lead_gsheets_webhook', '' );
    $hs_portal_id  = get_option( 'up_lead_hubspot_portal_id', '' );
    $hs_form_guid  = get_option( 'up_lead_hubspot_form_guid', '' );
    $hs_token      = get_option( 'up_lead_hubspot_token', '' );
    ?>
    <div class="wrap" style="max-width:920px;">
      <h1>⚙️ Configuración de Formulario, Google Sheets &amp; HubSpot — UP Group Studio</h1>
      <p>Desde aquí controlas adónde se envían los contactos capturados por el formulario <code>[up_inquiry_form]</code> (tanto los enviados como los borradores parciales/abandonados).</p>

      <form method="post" action="">
        <?php wp_nonce_field( 'up_save_leads_settings', 'up_leads_settings_nonce' ); ?>

        <table class="form-table" role="presentation">
          <tr>
            <th scope="row"><label for="up_lead_notify_email">📧 Correo(s) para recibir Notificaciones</label></th>
            <td>
              <input type="text" id="up_lead_notify_email" name="up_lead_notify_email" value="<?php echo esc_attr( $notify_email ); ?>" class="regular-text" style="width:100%;max-width:480px;">
              <p class="description">Puedes separar varios correos con coma (ej. <code>rodrigo@up.gt, hola@up.gt</code>). Nunca se expone en el código público.</p>
            </td>
          </tr>

          <tr>
            <th scope="row">🟡 Captura de Formularios Abandonados (Parciales)</th>
            <td>
              <label>
                <input type="checkbox" name="up_lead_enable_partial" value="1" <?php checked( $enable_partial, '1' ); ?>>
                Guardar automáticamente en WordPress (y Google Sheets) cuando el usuario escribe su correo o teléfono aunque no presione «Enviar»
              </label>
            </td>
          </tr>

          <tr>
            <th scope="row"><label for="up_lead_gsheets_webhook">📊 Google Sheets Webhook URL</label></th>
            <td>
              <input type="url" id="up_lead_gsheets_webhook" name="up_lead_gsheets_webhook" value="<?php echo esc_attr( $gs_webhook ); ?>" class="regular-text" style="width:100%;max-width:620px;" placeholder="https://script.google.com/macros/s/.../exec">
              <p class="description">Pega aquí la URL de tu aplicación web de Google Apps Script (abajo tienes el código listo para copiar y pegar).</p>
            </td>
          </tr>

          <tr>
            <th scope="row"><label for="up_lead_hubspot_portal_id">🟠 HubSpot Portal ID (Hub ID)</label></th>
            <td>
              <input type="text" id="up_lead_hubspot_portal_id" name="up_lead_hubspot_portal_id" value="<?php echo esc_attr( $hs_portal_id ); ?>" class="regular-text" placeholder="Ej. 45829102">
              <p class="description">Opcional: Si usas HubSpot Forms API, coloca tu Portal ID y abajo el Form GUID.</p>
            </td>
          </tr>

          <tr>
            <th scope="row"><label for="up_lead_hubspot_form_guid">🟠 HubSpot Form GUID</label></th>
            <td>
              <input type="text" id="up_lead_hubspot_form_guid" name="up_lead_hubspot_form_guid" value="<?php echo esc_attr( $hs_form_guid ); ?>" class="regular-text" style="width:100%;max-width:480px;" placeholder="Ej. 8a3f1b2c-4d5e-6f7a-8b9c-0d1e2f3a4b5c">
            </td>
          </tr>

          <tr>
            <th scope="row"><label for="up_lead_hubspot_token">🔑 HubSpot Private App Token (Alternativo)</label></th>
            <td>
              <input type="password" id="up_lead_hubspot_token" name="up_lead_hubspot_token" value="<?php echo esc_attr( $hs_token ); ?>" class="regular-text" style="width:100%;max-width:480px;" placeholder="pat-na1-...">
              <p class="description">Opcional: Si prefieres crear/actualizar contactos directo vía HubSpot CRM Contacts API v3 sin crear un formulario en HubSpot, pega aquí tu Private App Token con permiso <code>crm.objects.contacts.write</code>.</p>
            </td>
          </tr>
        </table>

        <?php submit_button( 'Guardar Configuración de Leads' ); ?>
      </form>

      <hr style="margin:32px 0;">
      <h2>📋 Código listo para conectar Google Sheets (en 60 segundos)</h2>
      <ol>
        <li>Crea una hoja de cálculo nueva en <strong>Google Sheets</strong>.</li>
        <li>En el menú superior haz clic en <strong>Extensiones → Apps Script</strong>.</li>
        <li>Borra lo que haya y pega este bloque de código (actualiza automáticamente la fila si un lead pasa de <code>PARCIAL</code> a <code>COMPLETADO</code> sin duplicar filas):</li>
      </ol>
      <pre style="background:#18181B;color:#F4F4F5;padding:18px;border-radius:10px;overflow-x:auto;font-size:12.5px;line-height:1.5;">function doPost(e) {
  var sheet = SpreadsheetApp.getActiveSpreadsheet().getActiveSheet();
  if (sheet.getLastRow() === 0) {
    sheet.appendRow(['Fecha', 'Estado', 'Idioma', 'Nombre', 'Empresa', 'Email', 'WhatsApp / Tel', 'Servicios', 'Detalles', 'Opt-In', 'URL Origen', 'Token']);
  }
  var data = JSON.parse(e.postData.contents);
  var token = data.lead_token || '';
  var rowValues = [
    new Date(),
    data.status_label || data.submission_type,
    (data.lang || 'es').toUpperCase(),
    data.name || '',
    data.company || '',
    data.email || '',
    data.phone || '',
    data.services || '',
    data.scope || '',
    data.consent === '1' ? 'Sí' : 'No',
    data.page_url || '',
    token
  ];

  // Si ya existe el Token en la columna 12 (porque entró antes como Parcial), actualiza esa misma fila
  if (token && sheet.getLastRow() > 1) {
    var tokens = sheet.getRange(2, 12, sheet.getLastRow() - 1, 1).getValues();
    for (var i = 0; i < tokens.length; i++) {
      if (tokens[i][0] === token) {
        sheet.getRange(i + 2, 1, 1, rowValues.length).setValues([rowValues]);
        return ContentService.createTextOutput(JSON.stringify({ result: 'updated', row: i + 2 })).setMimeType(ContentService.MimeType.JSON);
      }
    }
  }

  sheet.appendRow(rowValues);
  return ContentService.createTextOutput(JSON.stringify({ result: 'inserted' })).setMimeType(ContentService.MimeType.JSON);
}</pre>
      <p>4. Haz clic en <strong>Implementar → Nueva implementación → Tipo: Aplicación web</strong>, elige <em>«Cualquier usuario (Anyone)»</em> en quién tiene acceso, copia la URL generada y pégala arriba en <strong>Google Sheets Webhook URL</strong>.</p>
    </div>
    <?php
}

// 7.5 AJAX Handler (`up_save_lead`) — Saves/Updates WP Lead, Sends Email, Syncs Google Sheets & HubSpot
add_action( 'wp_ajax_up_save_lead', 'up_handle_save_lead_ajax' );
add_action( 'wp_ajax_nopriv_up_save_lead', 'up_handle_save_lead_ajax' );

function up_handle_save_lead_ajax() {
    // 1. Anti-spam Honeypot check
    $honeypot = sanitize_text_field( $_POST['up_website_hp'] ?? '' );
    if ( ! empty( $honeypot ) ) {
        wp_send_json_success( [ 'status' => 'ignored' ] );
    }

    $submission_type = sanitize_key( $_POST['submission_type'] ?? 'partial' );
    if ( ! in_array( $submission_type, [ 'partial', 'whatsapp', 'completed' ], true ) ) {
        $submission_type = 'partial';
    }

    // Check if partial capture is enabled
    if ( $submission_type === 'partial' && get_option( 'up_lead_enable_partial', '1' ) !== '1' ) {
        wp_send_json_success( [ 'status' => 'partial_disabled' ] );
    }

    $lead_token = sanitize_text_field( $_POST['lead_token'] ?? '' );
    $lang       = sanitize_key( $_POST['lang'] ?? 'es' );
    $name       = sanitize_text_field( $_POST['name'] ?? '' );
    $company    = sanitize_text_field( $_POST['company'] ?? '' );
    $email      = sanitize_email( $_POST['email'] ?? '' );
    $phone      = sanitize_text_field( $_POST['phone'] ?? '' );
    $services   = sanitize_text_field( $_POST['services'] ?? '' );
    $scope      = sanitize_textarea_field( $_POST['scope'] ?? '' );
    $consent    = ( $_POST['consent'] ?? '0' ) === '1' ? '1' : '0';
    $page_url   = esc_url_raw( $_POST['page_url'] ?? home_url( '/' ) );
    $page_title = sanitize_text_field( $_POST['page_title'] ?? 'UP Group Studio' );
    $hutk       = sanitize_text_field( $_POST['hutk'] ?? '' );

    // Require at least email or phone (or name/scope on WhatsApp click)
    if ( empty( $email ) && empty( $phone ) && empty( $name ) ) {
        wp_send_json_error( [ 'message' => 'Empty lead data' ] );
    }

    // 2. Find existing lead by `lead_token` (or recent partial with same email) so we update instead of duplicating
    $existing_id = 0;
    if ( ! empty( $lead_token ) ) {
        $existing = get_posts( [
            'post_type'      => 'up_lead',
            'post_status'    => 'publish',
            'posts_per_page' => 1,
            'fields'         => 'ids',
            'meta_query'     => [
                [
                    'key'   => '_up_lead_token',
                    'value' => $lead_token,
                ],
            ],
        ] );
        if ( ! empty( $existing ) ) {
            $existing_id = (int) $existing[0];
        }
    }

    $display_name  = $name ?: ( $email ?: $phone );
    $post_title    = $company ? "{$display_name} — {$company}" : $display_name;
    $status_labels = [
        'completed' => 'COMPLETADO (Formulario)',
        'whatsapp'  => 'ENVIADO POR WHATSAPP',
        'partial'   => 'PARCIAL / ABANDONADO',
    ];
    $status_label  = $status_labels[ $submission_type ];

    if ( $existing_id > 0 ) {
        // Never downgrade a 'completed' lead back to 'partial'
        $prev_status = get_post_meta( $existing_id, '_up_lead_status', true );
        if ( $prev_status === 'completed' && $submission_type === 'partial' ) {
            $submission_type = 'completed';
            $status_label    = $status_labels['completed'];
        }
        wp_update_post( [
            'ID'         => $existing_id,
            'post_title' => $post_title,
        ] );
        $lead_id = $existing_id;
    } else {
        $lead_id = wp_insert_post( [
            'post_type'   => 'up_lead',
            'post_status' => 'publish',
            'post_title'  => $post_title,
        ] );
    }

    if ( ! $lead_id || is_wp_error( $lead_id ) ) {
        wp_send_json_error( [ 'message' => 'Could not save lead' ] );
    }

    // Save all metadata
    update_post_meta( $lead_id, '_up_lead_token', $lead_token );
    update_post_meta( $lead_id, '_up_lead_status', $submission_type );
    update_post_meta( $lead_id, '_up_lead_lang', $lang );
    update_post_meta( $lead_id, '_up_lead_name', $name );
    update_post_meta( $lead_id, '_up_lead_company', $company );
    update_post_meta( $lead_id, '_up_lead_email', $email );
    update_post_meta( $lead_id, '_up_lead_phone', $phone );
    update_post_meta( $lead_id, '_up_lead_services', $services );
    update_post_meta( $lead_id, '_up_lead_scope', $scope );
    update_post_meta( $lead_id, '_up_lead_consent', $consent );
    update_post_meta( $lead_id, '_up_lead_page_url', $page_url );
    update_post_meta( $lead_id, '_up_lead_updated_at', current_time( 'mysql' ) );

    // 3. Send Email Notification on 'completed' or 'whatsapp' (only once per final submission)
    $already_emailed = get_post_meta( $lead_id, '_up_lead_email_sent_' . $submission_type, true );
    if ( in_array( $submission_type, [ 'completed', 'whatsapp' ], true ) && ! $already_emailed ) {
        $notify_to = get_option( 'up_lead_notify_email', get_option( 'admin_email' ) );
        if ( ! empty( $notify_to ) ) {
            $subj_prefix = ( $submission_type === 'whatsapp' ) ? '💬 [Lead WhatsApp up.gt]' : '🚀 [Nuevo Proyecto up.gt]';
            $subject     = "{$subj_prefix} {$post_title}";
            $wa_clean    = preg_replace( '/\D+/', '', $phone );

            $body  = '<div style="font-family:-apple-system,BlinkMacSystemFont,Segoe UI,Roboto,sans-serif;max-width:600px;margin:0 auto;background:#09090B;color:#FFFFFF;border-radius:16px;overflow:hidden;border:1px solid #27272A;">';
            $body .= '<div style="padding:24px 28px;background:linear-gradient(135deg,#EB5F69 0%,#F4A261 50%,#669ACA 100%);color:#FFFFFF;">';
            $body .= '<div style="font-size:11px;font-weight:700;letter-spacing:0.14em;text-transform:uppercase;">UP GROUP STUDIO • LEAD NOTIFICATION</div>';
            $body .= '<h2 style="margin:6px 0 0;font-size:22px;font-weight:800;">' . esc_html( $post_title ) . '</h2>';
            $body .= '</div>';
            $body .= '<div style="padding:26px 28px;background:#FFFFFF;color:#18181B;">';
            $body .= '<p style="margin:0 0 16px;"><strong>Estado:</strong> ' . esc_html( $status_label ) . ' (' . strtoupper( esc_html( $lang ) ) . ')</p>';
            $body .= '<table style="width:100%;border-collapse:collapse;font-size:14px;">';
            $body .= '<tr><td style="padding:8px 0;border-bottom:1px solid #E4E4E7;width:150px;"><strong>Nombre:</strong></td><td style="padding:8px 0;border-bottom:1px solid #E4E4E7;">' . esc_html( $name ?: '—' ) . '</td></tr>';
            $body .= '<tr><td style="padding:8px 0;border-bottom:1px solid #E4E4E7;"><strong>Empresa / Marca:</strong></td><td style="padding:8px 0;border-bottom:1px solid #E4E4E7;">' . esc_html( $company ?: '—' ) . '</td></tr>';
            $body .= '<tr><td style="padding:8px 0;border-bottom:1px solid #E4E4E7;"><strong>Email:</strong></td><td style="padding:8px 0;border-bottom:1px solid #E4E4E7;">' . ( $email ? '<a href="mailto:' . esc_attr( $email ) . '">' . esc_html( $email ) . '</a>' : '—' ) . '</td></tr>';
            $body .= '<tr><td style="padding:8px 0;border-bottom:1px solid #E4E4E7;"><strong>WhatsApp / Tel:</strong></td><td style="padding:8px 0;border-bottom:1px solid #E4E4E7;">' . esc_html( $phone ?: '—' ) . '</td></tr>';
            $body .= '<tr><td style="padding:8px 0;border-bottom:1px solid #E4E4E7;"><strong>Servicios:</strong></td><td style="padding:8px 0;border-bottom:1px solid #E4E4E7;">' . esc_html( $services ?: '—' ) . '</td></tr>';
            $body .= '<tr><td style="padding:8px 0;border-bottom:1px solid #E4E4E7;"><strong>Resumen:</strong></td><td style="padding:8px 0;border-bottom:1px solid #E4E4E7;">' . nl2br( esc_html( $scope ?: '—' ) ) . '</td></tr>';
            $body .= '<tr><td style="padding:8px 0;"><strong>Consentimiento:</strong></td><td style="padding:8px 0;">' . ( $consent === '1' ? '✓ Aceptó recibir correo/WhatsApp' : 'No marcado' ) . '</td></tr>';
            $body .= '</table>';
            if ( ! empty( $wa_clean ) ) {
                $body .= '<div style="margin-top:22px;"><a href="https://wa.me/' . esc_attr( $wa_clean ) . '" style="display:inline-block;padding:12px 22px;background:#25D366;color:#051B0C;text-decoration:none;font-weight:800;border-radius:99px;font-size:13.5px;">Responder por WhatsApp</a></div>';
            }
            $body .= '</div></div>';

            $headers = [ 'Content-Type: text/html; charset=UTF-8' ];
            if ( ! empty( $email ) && is_email( $email ) ) {
                $headers[] = 'Reply-To: ' . ( $name ? $name : $email ) . ' <' . $email . '>';
            }

            $sent = wp_mail( $notify_to, $subject, $body, $headers );
            if ( $sent ) {
                update_post_meta( $lead_id, '_up_lead_email_sent', 1 );
                update_post_meta( $lead_id, '_up_lead_email_sent_' . $submission_type, 1 );
            }
        }
    }

    // 4. Sync with Google Sheets Webhook (both partial & completed/whatsapp — Apps Script updates row by lead_token)
    $gs_webhook = get_option( 'up_lead_gsheets_webhook', '' );
    if ( ! empty( $gs_webhook ) ) {
        $gs_payload = [
            'lead_id'         => $lead_id,
            'lead_token'      => $lead_token,
            'submission_type' => $submission_type,
            'status_label'    => $status_label,
            'lang'            => $lang,
            'name'            => $name,
            'company'         => $company,
            'email'           => $email,
            'phone'           => $phone,
            'services'        => $services,
            'scope'           => $scope,
            'consent'         => $consent,
            'page_url'        => $page_url,
            'timestamp'       => current_time( 'mysql' ),
        ];
        $gs_res = wp_remote_post( $gs_webhook, [
            'headers' => [ 'Content-Type' => 'application/json' ],
            'body'    => wp_json_encode( $gs_payload ),
            'timeout' => 5,
        ] );
        if ( ! is_wp_error( $gs_res ) ) {
            update_post_meta( $lead_id, '_up_lead_gsheets_synced', 1 );
        }
    }

    // 5. Sync with HubSpot (Forms API v3 or Contacts API v3) when email is valid
    if ( ! empty( $email ) && is_email( $email ) && in_array( $submission_type, [ 'completed', 'whatsapp', 'partial' ], true ) ) {
        $hs_portal_id = get_option( 'up_lead_hubspot_portal_id', '' );
        $hs_form_guid = get_option( 'up_lead_hubspot_form_guid', '' );
        $hs_token     = get_option( 'up_lead_hubspot_token', '' );

        // Split name into firstname / lastname for HubSpot
        $name_parts = preg_split( '/\s+/', trim( $name ), 2 );
        $firstname  = $name_parts[0] ?? '';
        $lastname   = $name_parts[1] ?? '';

        // 5A: HubSpot Forms API v3
        if ( ! empty( $hs_portal_id ) && ! empty( $hs_form_guid ) ) {
            $hs_url    = "https://api.hsforms.com/submissions/v3/integration/submit/" . rawurlencode( $hs_portal_id ) . "/" . rawurlencode( $hs_form_guid );
            $hs_fields = [
                [ 'name' => 'email',     'value' => $email ],
                [ 'name' => 'firstname', 'value' => $firstname ],
                [ 'name' => 'lastname',  'value' => $lastname ],
                [ 'name' => 'phone',     'value' => $phone ],
                [ 'name' => 'company',   'value' => $company ],
                [ 'name' => 'message',   'value' => "[{$status_label}] Servicios: {$services} | Resumen: {$scope}" ],
            ];
            $hs_context = [
                'pageUri'  => $page_url,
                'pageName' => $page_title,
            ];
            if ( ! empty( $hutk ) ) {
                $hs_context['hutk'] = $hutk;
            }
            $hs_body = [
                'fields'  => $hs_fields,
                'context' => $hs_context,
            ];
            if ( $consent === '1' ) {
                $hs_body['legalConsentOptions'] = [
                    'consent' => [
                        'consentToProcess' => true,
                        'text'             => 'Acepto que UP Group Studio almacene mis datos y me contacte por correo electrónico o WhatsApp.',
                    ],
                ];
            }
            $hs_res = wp_remote_post( $hs_url, [
                'headers' => [ 'Content-Type' => 'application/json' ],
                'body'    => wp_json_encode( $hs_body ),
                'timeout' => 5,
            ] );
            if ( ! is_wp_error( $hs_res ) && wp_remote_retrieve_response_code( $hs_res ) < 300 ) {
                update_post_meta( $lead_id, '_up_lead_hubspot_synced', 1 );
            }
        }

        // 5B: HubSpot Private App Token (Contacts API v3)
        if ( ! empty( $hs_token ) ) {
            $hs_api_res = wp_remote_post( 'https://api.hubapi.com/crm/v3/objects/contacts', [
                'headers' => [
                    'Authorization' => 'Bearer ' . $hs_token,
                    'Content-Type'  => 'application/json',
                ],
                'body'    => wp_json_encode( [
                    'properties' => [
                        'email'      => $email,
                        'firstname'  => $firstname,
                        'lastname'   => $lastname,
                        'phone'      => $phone,
                        'company'    => $company,
                        'lifecyclestage' => 'lead',
                    ],
                ] ),
                'timeout' => 5,
            ] );
            if ( ! is_wp_error( $hs_api_res ) && in_array( wp_remote_retrieve_response_code( $hs_api_res ), [ 200, 201, 409 ], true ) ) {
                update_post_meta( $lead_id, '_up_lead_hubspot_synced', 1 );
            }
        }
    }

    wp_send_json_success( [
        'lead_id' => $lead_id,
        'status'  => $submission_type,
    ] );
}




