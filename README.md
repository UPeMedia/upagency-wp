# UP Group Studio (`studio.up.gt`) — Website Redesign & Bricks Builder

Repositorio oficial del rediseño web de **UP Group Studio** (`studio.up.gt`), estudio de ingeniería web, e-commerce de alto tráfico y sistemas de diseño digitales con presencia en **Guatemala** y **Houston, Texas**.

El proyecto sigue el flujo de trabajo de **HTML/SCSS/JS estático → Child Theme + Plantillas JSON para WordPress Bricks Builder**.

---

## Estructura del Proyecto

```text
.
├── bricks-templates/            # Plantillas JSON exportadas y validadas para Bricks Builder
│   ├── header.json              # Header Global (type: "header" + fallback "content")
│   ├── footer.json              # Footer Global + Botón Flotante WhatsApp (type: "footer")
│   ├── page-home.json           # Página de Inicio completa (todas las secciones unificadas)
│   ├── single-portfolio.json    # Plantilla Single Portfolio Case Study (inspirada en VML)
│   ├── hero.json                # Sección 01: Hero + Manifesto 1 + Dark Bento Showcase
│   ├── works.json               # Sección 02: Selected Works (Grid asimétrico de 6 casos)
│   ├── services.json            # Sección 03: Marquee Ribbons + Manifesto 2 + 4 Capacidades
│   ├── studio.json              # Sección 04: Tarjeta Studio Oscura + Métricas + Equipo
│   └── inquiry.json             # Sección 05: Formulario Interactivo de Contacto
│
├── child-theme/                 # Tema Hijo de WordPress para Bricks Builder (upagency v3.0)
│   ├── style.css                # Cabecera de metadatos del Child Theme (Template: bricks)
│   ├── functions.php            # Enqueue de fuentes/CSS/JS + 7 Shortcodes nativos seguros
│   ├── screenshot.png           # Miniatura del tema en WP Admin
│   ├── favicon.ico              # Favicon de UP Group Studio
│   ├── assets/                  # Recursos gráficos del tema (logo, portafolio, equipo)
│   ├── css/
│   │   └── style.css            # Hoja de estilos compilada + overrides !important para Bricks
│   ├── elements/
│   │   └── title.php            # Elemento personalizado de Bricks
│   └── js/
│       ├── script.js            # Interacciones globales, cursor, i18n ES/EN, tilt 3D
│       └── project.js           # Lógica interactiva de Case Study (acordeón, métricas, carrusel)
│
├── scripts/                     # Scripts de automatización y empaquetado
│   ├── build_bricks_templates.py# Generador y validador estricto de árboles JSON para Bricks
│   └── sync-child-theme.sh      # Sincroniza src/ → child-theme/ y genera archivos .zip
│
├── src/                         # Código fuente del Preview Estático (HTML/SCSS/CSS/JS)
│   ├── index.html               # Vista previa de la Página de Inicio (3 actos: Dark/Light/Dark)
│   ├── project.html             # Vista previa de Caso de Estudio Individual (?id=nanajuana, etc.)
│   ├── assets/                  # Imágenes y logotipo oficial de UP Group Studio
│   ├── css/
│   │   └── style.css            # CSS compilado listo para navegador y Bricks
│   ├── scss/
│   │   └── style.scss           # Fuente SCSS principal con sistema de diseño y overrides Bricks
│   └── js/
│       ├── main.js              # Script principal (Home + componentes globales)
│       └── project.js           # Datos bilingües de los 6 proyectos e interacciones Case Study
│
├── wordpress/                   # Respaldo / instalación base de WordPress
├── wp-snippets/                 # Snippets complementarios de WordPress (FluentSnippets)
├── package.json                 # Scripts de desarrollo, compilación SCSS y empaquetado
└── README.md                    # Documentación del proyecto
```

---

## Especificaciones de Marca y Diseño

- **Nombre Oficial y Dominio**: **UP Group Studio** (`studio.up.gt`).
- **Ubicaciones**: **Guatemala** y **Houston, Texas**.
- **Titular Principal (Hero)**:
  - Español (`ES`, idioma por defecto): *«Enciende tu Potencial Digital»*
  - Inglés (`EN`): *«Ignite Your Online Potential»*
- **Privacidad de Contacto**:
  - No se exponen números telefónicos ni direcciones de correo electrónico en texto plano visible.
  - Todo el contacto directo se canaliza mediante el formulario interactivo y los enlaces directos de WhatsApp hacia **`+50237556857`** (`https://wa.me/50237556857`), incluyendo el botón flotante persistente en la esquina inferior derecha.
- **Sellos Rotatorios SVG (360°)**:
  1. **Hero**: `UP GROUP STUDIO • GUATEMALA & HOUSTON •`
  2. **Manifesto 1 (Dark)**: `WE SPEAK GEEK, BUT WE'RE FRIENDLY •`
  3. **Manifesto 2 (Light)**: `ZERO COPY-PASTE • PIXEL OBSESSED •`

---

## Comandos de Desarrollo Local

### 1. Levantar el servidor de vista previa (`http://localhost:3000`)
```bash
npm run dev
```
- **Home Page**: [http://localhost:3000/](http://localhost:3000/)
- **Caso de Estudio (Ej. Nanajuana)**: [http://localhost:3000/project.html?id=nanajuana](http://localhost:3000/project.html?id=nanajuana)
  - Slugs disponibles: `nanajuana`, `tikal-futura`, `inde`, `hyundai`, `coastal-debt`, `bbdo`.

### 2. Compilar SCSS a CSS y sincronizar con `child-theme/`
```bash
npm run sass:build
```

### 3. Regenerar y validar las plantillas JSON de Bricks
```bash
npm run build:bricks
```

### 4. Sincronizar todo (`src/` → `child-theme/`) y generar `.zip` de despliegue
```bash
npm run sync      # Sincroniza CSS, JS, assets y regenera JSONs
npm run zip       # Además empaqueta upagency-child-theme.zip y upagency-bricks-templates.zip
```

---

## Shortcodes Registrados en el Child Theme (`child-theme/functions.php`)

Para evitar bloqueos de firma de código (*Code Execution*) o placeholders vacíos de SVG inline en Bricks Builder, los componentes SVG complejos y el formulario interactivo están encapsulados como shortcodes nativos de WordPress:

| Shortcode | Descripción |
| :--- | :--- |
| `[up_scroll_stamp]` | Sello circular rotatorio del Hero (`UP GROUP STUDIO • GUATEMALA & HOUSTON •`) |
| `[up_manifesto_stamp_dark]` | Sello circular rotatorio en Manifesto 1 (`WE SPEAK GEEK, BUT WE'RE FRIENDLY •`) |
| `[up_manifesto_stamp_light]` | Sello circular rotatorio en Manifesto 2 (`ZERO COPY-PASTE • PIXEL OBSESSED •`) |
| `[up_marquee_ribbons]` | Cintas cruzadas tipo marquee en la transición entre zona oscura y zona clara |
| `[up_rocket_illustration]` | Ilustración vectorial del cohete isométrico en Manifesto 2 |
| `[up_inquiry_form]` | Formulario interactivo de contacto con chips seleccionables de servicios y presupuesto |
| `[up_footer_shapes]` | Figuras geométricas animadas del bloque CTA del Footer |

---

## Guía de Despliegue en WordPress + Bricks Builder

1. **Actualizar el Child Theme (`upagency`)**:
   - Subir el contenido de `child-theme/` a `/wp-content/themes/upagency/` vía FTP/SFTP, o subir `upagency-child-theme.zip` en **Apariencia → Temas → Añadir nuevo → Subir tema** (reemplazando la versión anterior).
2. **Importar las Plantillas JSON (`bricks-templates/`)**:
   - Ir a **Bricks → Templates → Import** y subir las plantillas de `bricks-templates/` (o el paquete `upagency-bricks-templates.zip`).
3. **Asignar Condiciones de Visualización**:
   - `header.json` → Tipo `Header` → Condición: **Entire Website**.
   - `footer.json` → Tipo `Footer` → Condición: **Entire Website**.
   - `page-home.json` → Insertar en la página de Inicio (**Front Page**).
   - `single-portfolio.json` → Condición: páginas o CPT de proyectos del portafolio.
4. **Limpiar Caché**:
   - Purgar caché en LiteSpeed Cache / Cloudflare para servir la última versión de `css/style.css` y `js/script.js`.
