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

        <div class="project-form__actions">
          <button type="button" class="btn-form-wa" onclick="sendInquiryViaWhatsApp()">
            <i class="fa-brands fa-whatsapp"></i>
            <span data-i18n="form.btnSendWhatsApp"><?php echo $is_en ? 'Send summary via WhatsApp' : 'Enviar resumen por WhatsApp'; ?></span>
          </button>
          <button type="submit" class="btn-form-email">
            <i class="fa-regular fa-paper-plane"></i>
            <span data-i18n="form.btnSendEmail"><?php echo $is_en ? 'Submit Inquiry' : 'Enviar Solicitud'; ?></span>
          </button>
        </div>
        <div id="formFeedback" class="form-feedback"></div>
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

// 4.8 Case Study Auto-Scrolling Desktop & Mobile Device Frames Shortcode
add_shortcode( 'up_case_hero_devices', function() {
    $post_id     = get_the_ID();
    $title       = get_the_title( $post_id );
    $desktop_img = function_exists( 'get_field' ) ? get_field( 'project_screenshot_desktop', $post_id ) : get_post_meta( $post_id, 'project_screenshot_desktop', true );
    $mobile_img  = function_exists( 'get_field' ) ? get_field( 'project_screenshot_mobile', $post_id )  : get_post_meta( $post_id, 'project_screenshot_mobile', true );
    $live_url    = function_exists( 'get_field' ) ? get_field( 'project_live_url', $post_id )           : get_post_meta( $post_id, 'project_live_url', true );
    $band_bg     = function_exists( 'get_field' ) ? get_field( 'project_band_bg', $post_id )            : get_post_meta( $post_id, 'project_band_bg', true );

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
    $live_url  = function_exists( 'get_field' ) ? get_field( 'project_live_url', $post_id )  : get_post_meta( $post_id, 'project_live_url', true );
    $video_url = function_exists( 'get_field' ) ? get_field( 'project_video_url', $post_id ) : get_post_meta( $post_id, 'project_video_url', true );

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

