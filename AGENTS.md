# Contexto Maestro del Proyecto, Estudio y Usuario — UP Group Studio (`up.gt`)

Este archivo (`GEMINI.md` / `AGENTS.md`) se carga automáticamente al iniciar cualquier conversación en este directorio para proporcionar contexto completo sobre **Rodrigo Campos**, **UP Group Studio**, la arquitectura técnica del sitio y el progreso actual del portafolio.

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
- `src/`: Fuente estática de referencia (`index.html`, `project.html`, `design-system.html`, `scss/style.scss`, `css/style.css`, `js/main.js`, `js/project.js`).
- `child-theme/`: Tema hijo oficial de WordPress (`upagency` v3.0, `Template: bricks`).
  - `child-theme/functions.php`: Registro del CPT `project`, las 3 taxonomías personalizadas, redirecciones 301, sincronización automática de campos ACF y los **9 shortcodes nativos**.
  - `child-theme/css/style.css` y `child-theme/js/`: Activos sincronizados desde `src/`.
- `bricks-templates/`: Plantillas JSON generadas y validadas mediante `scripts/build_bricks_templates.py`:
  - `header.json`, `footer.json`, `page-home.json`, `single-portfolio.json`, `hero.json`, `works.json`, `services.json`, `studio.json`, `inquiry.json`.
  - `acf-export-proyectos.json`: Exportación completa de ACF (CPT `project` + 3 Taxonomías + Grupo de Campos `group_up_project_details`).
- `portfolio-assets/`: Carpeta donde se almacenan las imágenes destacadas (`Featured Image`) y logotipos oficiales descargados para cada caso de estudio del portafolio (`01-nanajuana/`, `02-tikal-futura/`, `03-inde/`, `04-camino-real-tikal/`, `05-camino-real-antigua/`, `06-mrc-global/`, etc.).

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
  - Caja Izquierda: `{post_terms_project_location:plain}` + `{post_terms_project_sector:plain}`.
  - Caja Central: `{post_terms_project_category:plain}` + `{post_title}` + `{post_excerpt}`.
  - Caja Derecha: `{acf_project_metric_1_val}` + `{acf_project_metric_1_lbl}`.
- **Sección 2 (`.case-intro-band`)**: Banda de color dinámico (`background-color: {acf_project_theme_color}`) con Kicker (`{acf_project_kicker}`), H1 (`{acf_project_headline}`) y 4 metadatos (`Ubicación`, `Cliente`, `Categorías`, `Año`).
- **Sección 3 (`.case-light-canvas`)**:
  - Inicia arriba con el shortcode `[up_case_hero_devices]` (`.up-devices-showcase`): Frame Desktop Mac (`16:10`) + Frame Mobile iPhone (`9:18.5`) que hacen **auto-scroll suave** sobre los full-height screenshots (`project_screenshot_desktop` y `project_screenshot_mobile`).
  - Columna editorial (`.case-editorial-col`): Párrafo introductorio (`{acf_project_lead_copy}`), shortcode `[up_case_media_actions]` (renderiza el botón hacia `project_live_url` si existe, y justo debajo un reproductor de video `16:9` `.up-case-video-embed` si `project_video_url` tiene un link de YouTube, Vimeo o `.mp4`), acordeón de 4 etapas (`01. El Desafío`, `02. Estrategia & Arquitectura`, `03. Ejecución Digital`, `04. Impacto & Resultados`), 3 métricas de impacto y sección *Keep Reading* de proyectos relacionados.

---

## 4. Estado Actual del Primer Batch de 12 Proyectos del Portafolio

Estamos trabajando **uno por uno** la carga bilingüe (`ES` / `EN`) de los primeros 12 casos de estudio:

| # | Cliente / Proyecto | URL Principal / Staging | Estado | Carpeta de Activos |
| :--- | :--- | :--- | :--- | :--- |
| **01** | **Nanajuana Río Dulce** | `https://nanajuanariodulce.com/` | ✅ **COMPLETADO** | `portfolio-assets/01-nanajuana/` |
| **02** | **Tikal Futura Centro Comercial** | `https://tikalfutura.com/` | ✅ **COMPLETADO** (`Desarrollo Web`, `Diseño Web`) | `portfolio-assets/02-tikal-futura/` |
| **03** | **INDE** | `https://inde.gob.gt/` (`inde.upbox.xyz`) | ✅ **COMPLETADO** (`Desarrollo Web`, `Diseño Web`) | `portfolio-assets/03-inde/` |
| **04** | **Hotel Camino Real Tikal** | `https://www.caminorealtikal.com.gt/` | ✅ **COMPLETADO** (`Desarrollo Web`, `Diseño Web`) | `portfolio-assets/04-camino-real-tikal/` |
| **05** | **Hotel Camino Real Antigua** | `https://www.caminorealantigua.com.gt/` | ✅ **COMPLETADO** (`Desarrollo Web`, `Diseño Web`) | `portfolio-assets/05-camino-real-antigua/` |
| **06** | **MRC Global** *(reemplazó a CIMCA)* | `https://www.mrcglobal.com/` *(Next.js + Contentful CMS)* | ✅ **COMPLETADO** (`Desarrollo Web`, `Diseño Web`, `Houston, TX`) | `portfolio-assets/06-mrc-global/` |
| **07** | **Aguilar Castillo Love** | `https://www.aguilarcastillolove.com/` (staging: `https://aguilarcastillolove.upbox.xyz/`) | ⏳ **SIGUIENTE EN FILA** | `portfolio-assets/07-aguilar-castillo-love/` |
| **08** | **Shops at Lakeshore** | `https://shopsatlakeshore.com` (staging: `https://shopsatlakeshore.upbox.xyz/`) | ⏳ Pendiente | `portfolio-assets/08-shops-at-lakeshore/` |
| **09** | **SpotSee** | `https://spotsee.io/` | ⏳ Pendiente | `portfolio-assets/09-spotsee/` |
| **10** | **Clínica Médica San Benito** | `https://clinicamedicasanbenito.com/` | ⏳ Pendiente | `portfolio-assets/10-clinica-san-benito/` |
| **11** | **Sagrado Corazón Laboratorio Clínico** | `https://labsagradocorazon.gt/` | ⏳ Pendiente | `portfolio-assets/11-sagrado-corazon/` |
| **12** | **LLANRESA** | `https://llanresa.com.gt/` | ⏳ Pendiente | `portfolio-assets/12-llanresa/` |
| *—* | *CIMCA (En pausa por ahora)* | `https://cimcagt.com/` | ⏸️ En pausa (reemplazado por MRC Global) | — |

---

## 5. Flujo de Trabajo para los Proyectos Restantes (#07 al #12)

Cuando Rodrigo pida continuar con el siguiente proyecto de la lista:
1. Inspeccionar el sitio en vivo (y el staging `.upbox.xyz` si aplica).
2. Crear la carpeta `portfolio-assets/XX-slug/` y descargar allí las mejores imágenes oficiales de portada (`Featured Image`) y el logotipo del cliente.
3. Entregar la ficha completa lista para copiar y pegar en **Español (`ES`)** e **Inglés (`EN`)** con:
   - Taxonomías a marcar (`project_category`, `project_sector`, `project_location`).
   - Campos nativos de WordPress (`Post Title`, `Slug`, `Excerpt`, `Featured Image`).
   - **Pestaña 1**: `project_theme_color` (color oscuro/vibrante de marca con alto contraste para texto blanco), `project_kicker`, `project_headline`, e indicación para subir los screenshots full-height Desktop/Mobile tomados por Rodrigo.
   - **Pestaña 2**: `project_client`, `project_year`, `project_live_url`, `project_live_label`, `project_video_url` (si el sitio tiene video promocional en YouTube/Vimeo/MP4) y `project_lead_copy`.
   - **Pestaña 3**: Los 4 textos del acordeón (`01. El Desafío`, `02. Estrategia & Arquitectura`, `03. Ejecución Digital`, `04. Impacto & Resultados`).
   - **Pestaña 4**: Las 3 métricas de impacto (`Value` + `Label`).
