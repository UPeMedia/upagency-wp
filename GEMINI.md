# Contexto Maestro del Proyecto, Estudio y Usuario — UP Group Studio (`up.gt`)

Este archivo (`GEMINI.md` / `AGENTS.md`) se carga automáticamente al iniciar cualquier conversación en este directorio para proporcionar contexto completo sobre **Rodrigo Campos**, **UP Group Studio**, la arquitectura técnica del sitio, el progreso del portafolio y el roadmap de marketing/analítica/CRM activo.

---

## 1. Sobre el Usuario y el Estudio

### 👤 Perfil del Usuario: Rodrigo Campos
- **Rol**: Founder & Lead Digital Product Engineer en **UP Group Studio** (`up.gt`).
- **Experiencia**: +15 años de trayectoria en Desarrollo Web Full-Stack, Diseño de Producto Digital (UI/UX), E-Commerce de alto tráfico y Arquitecturas Modernas.
- **Especialidades Técnicas**:
  - Ecosistema **WordPress Avanzado**: **Bricks Builder**, **ACF Pro**, **Polylang** (sitios multilingües `ES`/`EN`), **WooCommerce** y desarrollo de Child Themes a medida sin bloatware.
  - Desarrollo **Headless / Jamstack**: **Next.js**, React, **Contentful CMS**, integraciones API y despliegue en CDN global.
  - **Performance & Conversión**: Optimización Core Web Vitals (95+ Google PageSpeed), GSAP animations, SCSS modular y automatizaciones de flujos comerciales con IA / WhatsApp.
- **Preferencias de Comunicación y Trabajo**:
  - **Idioma**: Responder siempre en **Español** de forma clara, directa y estructurada.
  - **Entregables de Portafolio**: Tablas y bloques de código limpios listos para copiar y pegar (`Copy-Paste Ready`) tanto en Español (`ES`) como en Inglés (`EN`).
  - **Screenshots de Proyectos**: Rodrigo captura personalmente los **full-height screenshots** (`Desktop` y `Mobile`) de cada cliente; el asistente descarga las imágenes destacadas oficiales/logos en `portfolio-assets/XX-slug/` y redacta todos los textos estratégicos bilingües.

### 🚀 Sobre la Empresa: UP Group Studio (`up.gt`)
- **Nombre Oficial**: **UP Group Studio** (Dominio: `https://up.gt`).
- **Liderazgo (Dupla Senior)**:
  - **Rodrigo Campos** (*Founder • Desarrollo Web & Diseño de Producto Digital* — `15+ YRS EXP`).
  - **Yulcer** (*Co-Lead • Diseño Visual, Video & Fotografía Comercial* — `10+ YRS EXP`).
- **Ubicaciones Oficiales del Estudio**: **Guatemala** y **Houston, Texas**.
  - ⚠️ **REGLA ESTRICTA DE UBICACIÓN**: **NUNCA** escribir *"Ciudad de Guatemala"* ni *"Guatemala City"* para referirse a la ubicación de UP Group Studio. Usar siempre únicamente **Guatemala** y **Houston, Texas**.
- **Propuesta de Valor y Manifiesto**:
  - *ES*: «Enciende tu Potencial Digital» — *EN*: «Ignite Your Online Potential».
  - Estudio digital boutique, artesanal y libre de plantillas genéricas (*"Zero Copy-Paste • Pixel Obsessed"*, *"We Speak Geek, But We're Friendly"*). Trato directo con la dupla senior sin intermediarios.
- **Servicios Principales ("À la carte")**:
  1. Desarrollo Web a Medida (*Custom Web Development* — WordPress/Bricks, Next.js/Headless).
  2. Diseño UI/UX & Identidad Visual (*UI/UX Design & Branding*).
  3. E-Commerce & Pasarelas de Pago (*WooCommerce, Shopify, B2B/B2C*).
  4. Fotografía Comercial, Producción Audiovisual & Multimedia.
  5. Velocidad, Soporte Continuo & Automatizaciones con IA.
- **Regla de Privacidad y Contacto en `up.gt`**:
  - No exponer números de teléfono ni correos electrónicos en texto plano visible dentro del sitio.
  - Todo el contacto directo se canaliza a través del formulario interactivo (`[up_inquiry_form]`) y enlaces directos de WhatsApp hacia **`+50237556857`** (`https://wa.me/50237556857`).

---

## 2. Arquitectura Técnica del Repositorio

El proyecto sigue el flujo **HTML/SCSS/JS Estático (`src/`) → Child Theme (`child-theme/`) + Plantillas JSON para WordPress Bricks Builder (`bricks-templates/`)**.

### Estructura de Carpetas Clave
- `src/`: Fuente estática de referencia (`index.html`, `project.html`, `design-system.html`, `scss/style.scss`, `css/style.css`, `js/main.js`, `js/project.js`, `assets/og-share-es.jpg`, `assets/og-share-en.jpg`).
- `child-theme/`: Tema hijo oficial de WordPress (`upagency` v3.0, `Template: bricks`).
  - `child-theme/functions.php`:
    - Registro del CPT `project`, las 3 taxonomías personalizadas y redirecciones 301 hacia `/#works`.
    - **9 shortcodes nativos** bilingües (`[up_lang_switcher]`, `[up_scroll_stamp]`, `[up_manifesto_stamp_dark]`, `[up_manifesto_stamp_light]`, `[up_rocket_illustration]`, `[up_inquiry_form]`, `[up_footer_shapes]`, `[up_marquee_ribbons]`, `[up_case_hero_devices]`, `[up_case_media_actions]`).
    - **Inyector dinámico de color de marca y portada (`wp_head` en `is_singular('project')`)** con fallback automático entre traducciones de Polylang (`up_get_project_field()`).
    - **Meta Tags Open Graph y Twitter Cards automáticos** (`og-share-es.jpg` y `og-share-en.jpg` de `1200×630` para WhatsApp y redes sociales).
    - **Motor CRM de Captura de Leads (`CPT: up_lead`)**: Guarda leads completados, enviados por WhatsApp y formularios parciales/abandonados (`auto-save` por token de sesión `lead_token`), con casilla de consentimiento Opt-In, envío de correo HTML (`wp_mail`), sincronización con **Google Sheets Webhook** y **HubSpot CRM** (Forms API v3 / Contacts API v3), administrable desde **Leads / Contactos → ⚙️ Configuración & CRM**.
  - `child-theme/css/style.css` y `child-theme/js/`: Activos sincronizados desde `src/`.
- `bricks-templates/`: Plantillas JSON generadas y validadas mediante `scripts/build_bricks_templates.py`:
  - `header.json`, `footer.json`, `page-home.json`, `single-portfolio.json`, `hero.json`, `works.json`, `services.json`, `studio.json`, `inquiry.json`.
  - `acf-export-proyectos.json`: Exportación completa de ACF (CPT `project` + 3 Taxonomías + Grupo de Campos `group_up_project_details`).
- `portfolio-assets/`: Carpeta donde se almacenan las imágenes destacadas (`Featured Image`) y logotipos oficiales descargados para cada caso de estudio del portafolio (`01-nanajuana/` al `11-sagrado-corazon/`).

### Comandos NPM Principales
- `npm run dev`: Inicia servidor local en `http://localhost:3000` sirviendo `src/`.
- `npm run sass:build`: Compila `src/scss/style.scss` → `src/css/style.css` y copia a `child-theme/css/style.css`.
- `npm run build:bricks`: Ejecuta `python3 scripts/build_bricks_templates.py` para regenerar y validar todos los JSON de `bricks-templates/`.
- `npm run sync`: Sincroniza `src/` → `child-theme/` y regenera las plantillas de Bricks.
- `npm run zip`: Ejecuta `sync` y empaqueta los archivos listos para producción en la raíz:
  - `upagency-child-theme.zip`
  - `upagency-bricks-templates.zip`

---

## 3. Arquitectura del Portafolio (`CPT: project` + Taxonomías + ACF)

### Custom Post Type: `project` (`Proyectos` / `Portafolio`)
- **Slug de URL**: `proyectos` (ej. `up.gt/proyectos/nanajuana/`).
- **Sin archivo público (`has_archive: false`)**: Si alguien visita `/proyectos` o cualquier URL de archivo de sus taxonomías, `child-theme/functions.php` ejecuta una redirección `301` hacia `/#works` (o `/en/#works`).
- **Editor Gutenberg Desactivado**: `supports: ["title", "excerpt", "thumbnail", "custom-fields", "page-attributes"]` (sin `"editor"`) para que las 4 pestañas de ACF aparezcan inmediatamente debajo del título del proyecto.

### Las 3 Taxonomías Personalizadas (Checkboxes en barra lateral derecha)
1. **`project_category` (Categorías / Disciplinas)**:
   - `Desarrollo Web` (`Web Development`)
   - `Diseño Web` (`Web Design`)
   - `E-Commerce` (`E-Commerce`)
   - `Identidad Visual` (`Visual Identity`)
   - `Fotografía` (`Photography`)
   - `Redes Sociales` (`Social Media`)
   - `Multimedia` (`Multimedia`)
2. **`project_sector` (Segmento de Mercado)**:
   - `Hospitalidad & Turismo` (`Hospitality & Tourism`)
   - `Centros Comerciales` (`Shopping Centers & Retail`)
   - `Gobierno & Energía` (`Government & Energy`)
   - `Salud & Laboratorios` (`Healthcare & Laboratories`)
   - `Legal & Corporativo` (`Legal & Corporate`)
   - `Industria & Construcción` (`Industry & Construction`)
   - `Tecnología & IoT` (`Technology & IoT`)
   - `Automotriz & Servicios` (`Automotive & Services`)
3. **`project_location` (Ubicación del Cliente — 8 ubicaciones oficiales)**:
   - `Miami, FL`
   - `Regional / LATAM`
   - `Dallas, TX`
   - `Houston, TX`
   - `Antigua Guatemala`
   - `Petén, GT`
   - `Río Dulce, GT`
   - `Guatemala`

### Estructura del Layout `single-portfolio.json` y Campos ACF (`group_up_project_details`)
- **Plantillas de Bricks Activas por Idioma (Polylang)**:
  - Español (`ES`): `up-group-studio-single-portfolio-case-study-vml-layout`
  - Inglés (`EN`): `up-group-studio-single-portfolio-case-study-vml-layout-en`
  - Ambas plantillas se alimentan del inyector dinámico de `child-theme/functions.php` (`wp_head` en `is_singular('project')`) con fallback automático entre traducciones de Polylang (`up_get_project_field()`).
- **Sección 1 (`.case-hero-cover`)**: Imagen destacada de fondo (`{featured_image}`) con el header flotante de **3 cajas** (`.cover-Floating-composition`):
  - Caja Izquierda: `{post_terms_project_location:plain}` + `{post_terms_project_sector:plain}` (con fondo en degradado usando `--case-brand-color`).
  - Caja Central: `{post_terms_project_category:plain}` + `{post_title}` + `{post_excerpt}`.
  - Caja Derecha: `{acf_project_metric_1_val}` + `{acf_project_metric_1_label}` (con fondo en degradado usando `--case-brand-color`).
- **Sección 2 (`.case-intro-band`)**: Banda de color dinámico (`project_band_bg` / `project_theme_color` con contraste de texto blanco/oscuro automático por luminancia) con Kicker (`{acf_project_kicker}`), H1 (`{acf_project_headline}`) y 4 metadatos (`Ubicación`, `Cliente`, `Categorías`, `Año`).
- **Sección 3 (`.case-light-canvas`)**:
  - Inicia arriba con el shortcode `[up_case_hero_devices]` (`.up-devices-showcase`): Frame Desktop Mac (`16:10`) + Frame Mobile iPhone (`9:18.5`) que hacen **auto-scroll suave** sobre los full-height screenshots (`project_screenshot_desktop` y `project_screenshot_mobile`).
  - Columna editorial (`.case-editorial-col`): Párrafo introductorio (`{acf_project_lead_copy}`), shortcode `[up_case_media_actions]` (renderiza el botón hacia `project_live_url` si existe, y justo debajo un reproductor de video `16:9` `.up-case-video-embed` si `project_video_url` tiene un link de YouTube, Vimeo o `.mp4`), acordeón de 4 etapas, 3 métricas de impacto (`.case-metric-number` coloreado con `--case-brand-color`) y sección *Keep Reading* de proyectos relacionados.

---

## 4. Estado Actual del Primer Batch de 12 Proyectos del Portafolio

*(Pausado temporalmente en el proyecto #11 para avanzar el Roadmap de Marketing, CRM, Analítica y SEO)*:

| # | Cliente / Proyecto | URL Principal / Staging | Estado | Carpeta de Activos |
| :--- | :--- | :--- | :--- | :--- |
| **01** | **Nanajuana Río Dulce** | `https://nanajuanariodulce.com/` | ✅ **COMPLETADO** | `portfolio-assets/01-nanajuana/` |
| **02** | **Tikal Futura Centro Comercial** | `https://tikalfutura.com/` | ✅ **COMPLETADO** (`Desarrollo Web`, `Diseño Web`) | `portfolio-assets/02-tikal-futura/` |
| **03** | **INDE** | `https://inde.gob.gt/` (`inde.upbox.xyz`) | ✅ **COMPLETADO** (`Desarrollo Web`, `Diseño Web`) | `portfolio-assets/03-inde/` |
| **04** | **Hotel Camino Real Tikal** | `https://www.caminorealtikal.com.gt/` | ✅ **COMPLETADO** (`Desarrollo Web`, `Diseño Web`) | `portfolio-assets/04-camino-real-tikal/` |
| **05** | **Hotel Camino Real Antigua** | `https://www.caminorealantigua.com.gt/` | ✅ **COMPLETADO** (`Desarrollo Web`, `Diseño Web`) | `portfolio-assets/05-camino-real-antigua/` |
| **06** | **MRC Global** *(reemplazó a CIMCA)* | `https://www.mrcglobal.com/` *(Next.js + Contentful CMS)* | ✅ **COMPLETADO** (`Desarrollo Web`, `Diseño Web`, `Houston, TX`) | `portfolio-assets/06-mrc-global/` |
| **07** | **Aguilar Castillo Love** | `https://www.aguilarcastillolove.com/` (`aguilarcastillolove.upbox.xyz`) | ✅ **COMPLETADO** (`Desarrollo Web`, `Diseño Web`, `Regional / LATAM`) | `portfolio-assets/07-aguilar-castillo-love/` |
| **08** | **Shops at Lakeshore** | `https://shopsatlakeshore.com` (`shopsatlakeshore.upbox.xyz`) | ✅ **COMPLETADO** (`Desarrollo Web`, `Diseño Web`, `Houston, TX`) | `portfolio-assets/08-shops-at-lakeshore/` |
| **09** | **SpotSee** | `https://spotsee.io/` | ✅ **COMPLETADO** (`Desarrollo Web`, `Diseño Web`, `Dallas, TX`) | `portfolio-assets/09-spotsee/` |
| **10** | **Clínica Médica San Benito** | `https://clinicamedicasanbenito.com/` | ✅ **COMPLETADO** (`Desarrollo Web`, `Diseño Web`, `Fotografía`, `Petén, GT`) | `portfolio-assets/10-clinica-san-benito/` |
| **11** | **Sagrado Corazón Laboratorio Clínico** | `https://labsagradocorazon.gt/` | ✅ **COMPLETADO** (`Desarrollo Web`, `Diseño Web`, `Petén, GT`) | `portfolio-assets/11-sagrado-corazon/` |
| **12** | **LLANRESA** | `https://llanresa.com.gt/` | ⏸️ **En pausa (Último pendiente del batch)** | `portfolio-assets/12-llanresa/` |
| *—* | *CIMCA (En pausa por ahora)* | `https://cimcagt.com/` | ⏸️ En pausa (reemplazado por MRC Global) | — |

---

## 5. Roadmap Activo de Crecimiento, Analítica, SEO & Marketing (5 Puntos)

Estamos trabajando paso a paso esta lista de 5 prioridades solicitadas por Rodrigo:

1. ✅ **Punto 1 — Imagen Open Graph (`1200×630`) para WhatsApp y Redes Sociales (`ES` / `EN`)**:
   - **Estado**: **COMPLETADO**.
   - Archivos generados en `src/assets/og-share-es.jpg` (`130 KB`), `src/assets/og-share-en.jpg` (`135 KB`), y sus versiones Retina `.png`, sincronizados en `child-theme/assets/` y conectados automáticamente vía `wp_head` en `child-theme/functions.php` (sección 6).
2. ✅ **Punto 2 — Formulario (`[up_inquiry_form]`) + Base de Datos WP + Captura Parcial/Abandonada + Disclaimer Opt-In + Google Sheets + HubSpot**:
   - **Estado**: **COMPLETADO**.
   - Implementado el CPT privado `up_lead` (**Leads / Contactos**) y la página **Leads / Contactos → ⚙️ Configuración & CRM** en `child-theme/functions.php` (sección 7) junto con el auto-save silencioso con debounce y `sendBeacon` en `src/js/main.js`.
3. ⏳ **Punto 3 (SIGUIENTE EN FILA) — Tracking de Clics en Botones Principales en Google Analytics (GA4)**:
   - Rastrear eventos clave en GA4 (`gtag('event', ...)` / `dataLayer.push`): clics en botones de WhatsApp (flotante, formulario, footer), envío de formulario, clic en tarjetas de servicios ("Cotizar"), clic en casos del portafolio, clic en enlaces de sitios en vivo de clientes y cambio de idioma `ES`/`EN`.
4. ⏳ **Punto 4 — SEO Técnico + Posicionamiento en Motores de Búsqueda y Chats de IA (GEO / AEO)**:
   - Datos estructurados `Schema.org` (`ProfessionalService` / `Organization` bilingüe en Guatemala y Houston, TX + `CreativeWork` en cada proyecto), archivo `/llms.txt` optimizado para motores generativos (ChatGPT, Perplexity, Claude, Gemini), títulos/descripciones semánticas, `hreflang` (`es-GT`, `en-US`, `x-default`) y optimización de indexación.
5. ⏳ **Punto 5 — Campaña Matriz y Posts para Redes Sociales**:
   - Estrategia creativa, pilares de contenido, copys bilingües y piezas visuales para presentar el nuevo posicionamiento y portafolio de **UP Group Studio (`up.gt`)**.
