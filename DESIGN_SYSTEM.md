# UP Group Studio (`up.gt`) — Design System v3.0

Documentación oficial del sistema de diseño de **UP Group Studio** (`up.gt`). Combina una estética **High-Contrast Editorial** en 3 actos (inspirada en *Morez*) para la experiencia de marca y un sistema **Editorial Case Study** (inspirado en *VML*) para la narrativa profunda de proyectos del portafolio.

> **Catálogo Visual Interactivo**: Con el servidor local activo (`npm run dev`), puedes explorar todos los tokens y componentes renderizados en vivo en **[http://localhost:3000/design-system.html](http://localhost:3000/design-system.html)**.

---

## 1. Principios de Diseño y Arquitectura en 3 Actos

1. **Ritmo Cromático en 3 Actos (Dark → Light → Dark)**:
   - **Acto I — Dark Zone (`#050505`)**: Inmersión de alto impacto con gradientes *mesh*, tipografía monumental, sellos rotatorios SVG de 360°, Bento Grid con tarjetas pastel vibrantes y grilla asimétrica de portafolio con inclinación 3D.
   - **Transición — Criss-Crossed Marquee Ribbons**: Dos cintas diagonales cruzadas (`#EB5F69` Coral y `#BC80BB` Lilac) que cortan visualmente el paso del modo oscuro al modo claro editorial.
   - **Acto II — Warm Editorial Light Zone (`#FAF9F6`)**: Claridad de lectura para el segundo manifiesto, tarjetas oscuras de capacidades con *aurora glow*, tarjeta Studio asimétrica con estadísticas y formulario interactivo con *chips* seleccionables.
   - **Acto III — Pure Black Footer (`#050505`)**: Cierre arquitectónico con bloque CTA geométrico y 3 cajas delineadas con borde sutil.
2. **Contraste Tipográfico Tripartito**:
   - **Display Geométrica (`Geist`)**: Titulares con *tracking* ajustado (`-0.035em` a `-0.04em`) y pesos contrastados (`700`–`800`).
   - **Técnica Monoespaciada (`Geist Mono`)**: Metadatos, numeración de proyectos (`01`–`06`), etiquetas de categoría y métricas.
   - **Acento Manuscrito (`Caveat`)**: Anotaciones orgánicas acompañadas de flechas dibujadas a mano (*doodles*) para humanizar la precisión técnica (*"We Speak Geek, But We're Friendly"*).
3. **Privacidad y Conversión Directa**:
   - Ningún teléfono ni correo electrónico se expone en texto plano.
   - Toda acción de contacto rápido dirige a WhatsApp (`+50237556857`) o al formulario interactivo con selección por *chips*.

---

## 2. Tokens de Color (`:root`)

### 2.1 Superficies (Surfaces)

| Token CSS | Valor Hex / RGBA | Uso Principal |
| :--- | :--- | :--- |
| `--bg-dark` | `#050505` | Fondo principal del Acto I (Dark Zone) y Acto III (Footer) |
| `--bg-dark-elevated` | `#0D0D12` | Tarjetas oscuras elevadas (`.service-row`, `.studio-card`, `.footer-cta`) |
| `--bg-light` | `#FAF9F6` | Fondo cálido editorial del Acto II (Light Zone) |
| `--bg-light-card` | `#FFFFFF` | Superficie de tarjetas claras, contenedor del formulario y cuerpo de Case Study |

### 2.2 Jerarquía de Texto (Typography Colors)

| Token CSS | Valor Hex / RGBA | Contraste / Uso |
| :--- | :--- | :--- |
| `--text-white` | `#FFFFFF` | Titulares y texto primario sobre superficies oscuras |
| `--text-white-muted` | `rgba(255, 255, 255, 0.72)` | Párrafos descriptivos y subtítulos en zona oscura |
| `--text-white-subtle` | `rgba(255, 255, 255, 0.48)` | Metadatos, etiquetas secundarias y divisores en zona oscura |
| `--text-dark` | `#09090B` | Titulares y texto primario sobre superficies claras (`#FAF9F6` / `#FFFFFF`) |
| `--text-dark-muted` | `#52525B` | Párrafos editoriales y descripciones sobre fondo claro |

### 2.3 Paleta de Acentos Vibrantes y Pasteles

| Token CSS | Valor Hex | Rol Visual en el Sistema |
| :--- | :--- | :--- |
| `--morez-coral` | `#EB5F69` | Acento primario cálido, cinta marquee principal, Bento Card Coral, gradientes CTA |
| `--morez-lilac` | `#BC80BB` | Acento secundario, cinta marquee cruzada, Bento Card Lilac |
| `--morez-blue` | `#669ACA` | Acento técnico frío, Bento Card Blue, *aurora glow* de capacidades |
| `--morez-orchid` | `#9B7EDE` | Acento violeta digital, Bento Card Orchid, estados *hover* y *focus* |
| `--morez-mint` | `#8CC099` | Acento de crecimiento/métricas, indicadores de disponibilidad |
| `--morez-amber` | `#F4A261` | Acento cálido en ilustraciones e iluminación ambiental |
| `--morez-gold` | `#FBBF24` | Anotaciones manuscritas (`.hand-note`), estrellas y detalles destacados |
| `--whatsapp-green` | `#25D366` | Botón flotante persistente de WhatsApp (`.whatsapp-fab`) y pulso activo |

### 2.4 Colores Temáticos por Proyecto (Single Portfolio Case Study)

Cada caso de estudio inyecta dinámicamente la variable `--cs-theme-color` en la banda editorial de introducción (`.cs-intro-band`):

| Proyecto | Slug (`?id=`) | `--cs-theme-color` | Categoría |
| :--- | :--- | :--- | :--- |
| **Nanajuana** | `nanajuana` | `#B45309` | Hospitality & Digital Brand |
| **Tikal Futura** | `tikal-futura` | `#4338CA` | Web Platform & Architecture |
| **INDE** | `inde` | `#0F766E` | Institutional Portal & UX |
| **Hyundai** | `hyundai` | `#1D4ED8` | Automotive Digital Ecosystem |
| **Coastal Debt** | `coastal-debt` | `#0369A1` | Fintech Lead Generation (Houston) |
| **BBDO** | `bbdo` | `#BE123C` | Creative Agency Platform |

---

## 3. Sistema Tipográfico

### 3.1 Familias Tipográficas

```css
--font-sans:   'Geist', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
--font-mono:   'Geist Mono', monospace;
--font-script: 'Caveat', cursive;
```

### 3.2 Escala Tipográfica Fluida

| Elemento / Clase | Familia | Tamaño (`clamp`) | Peso | Line Height | Tracking |
| :--- | :--- | :--- | :--- | :--- | :--- |
| **Hero Display** (`.hero__title`) | `Geist` | `clamp(2.85rem, 6.2vw, 5.25rem)` | `800` | `1.04` | `-0.04em` |
| **Case Study Intro** (`.cs-intro-band__headline`) | `Geist` | `clamp(2rem, 4.2vw, 3.5rem)` | `500` | `1.12` | `-0.03em` |
| **Manifesto Title** (`.manifesto__title`) | `Geist` | `clamp(2rem, 4vw, 3.25rem)` | `700` | `1.14` | `-0.035em` |
| **Section Title** (`.section-title`) | `Geist` | `clamp(2.1rem, 4.2vw, 3.4rem)` | `800` | `1.08` | `-0.035em` |
| **Footer CTA Title** (`.footer-cta__title`) | `Geist` | `clamp(2.2rem, 4.5vw, 3.75rem)` | `800` | `1.06` | `-0.035em` |
| **Service Card Title** (`.service-row__title`) | `Geist` | `clamp(1.35rem, 2.2vw, 1.75rem)` | `700` | `1.2` | `-0.02em` |
| **Case Study Lead** (`.cs-lead-text`) | `Geist` | `clamp(1.25rem, 2vw, 1.55rem)` | `400` | `1.55` | `-0.01em` |
| **Body Regular** (`body.up-body`) | `Geist` | `1rem` (`16px`) | `400` | `1.55` | `0` |
| **Eyebrow / Kicker** (`.eyebrow-pill`) | `Geist Mono` | `0.75rem` (`12px`) | `600` | `1.2` | `0.12em` (UPPERCASE) |
| **Handwritten Note** (`.hand-note`) | `Caveat` | `1.45rem`–`1.65rem` | `700` | `1.15` | `0` |

---

## 4. Layout, Espaciado, Bordes y Movimiento

### 4.1 Contenedores y Grillas

| Token / Clase | Especificación | Propósito |
| :--- | :--- | :--- |
| `--container-max` | `1240px` (`padding: 0 28px`) | Contenedor estándar de secciones en Home y Footer |
| `.cs-editorial-col` | `max-width: 760px` (centrado) | Columna angosta de lectura editorial en páginas de proyecto (VML style) |
| `.bento-grid` | CSS Grid `12 columnas` (`gap: 20px`) | Mosaico asimétrico de 4 tarjetas en el Acto I (`7 cols` + `5 cols`) |
| `.works-grid` | CSS Grid `2 columnas` (`gap: 44px`) | Grilla de portafolio donde los ítems pares llevan `margin-top: 72px` |
| `.services-grid` | CSS Grid `2 columnas` (`gap: 24px`) | Mosaico de 4 tarjetas oscuras de capacidades con iluminación *aurora* |

### 4.2 Radios de Borde (Border Radius)

```css
--radius-xl:   28px;   /* Contenedores principales (.studio-card, .inquiry-box, .footer-cta) */
--radius-lg:   24px;   /* Tarjetas Bento (.bento-card), Portafolio (.work-card) y Servicios (.service-row) */
--radius-md:   16px;   /* Inputs de formulario, marcos internos y cajas del footer */
--radius-pill: 9999px; /* Botones, chips interactivos, eyebrows y conmutador de idioma */
```

### 4.3 Curvas de Animación y Micro-interacciones

- **Curva Primaria (`--ease-out`)**: `cubic-bezier(0.16, 1, 0.3, 1)` — desaceleración suave y elástica para *hover*, acordeones y apariciones.
- **Botones Magnéticos (`[data-magnetic]`)**: Calculan el desplazamiento del cursor respecto al centro del botón y aplican una traslación suave (`±18%`) en escritorio.
- **Inclinación 3D en Portafolio (`[data-tilt]`)**: Rotación en perspectiva (`perspective(1000px) rotateX() rotateY()`) sobre las tarjetas `.work-card`.
- **Sellos Rotatorios 360° (`.scroll-stamp__svg`, `.rotating-stamp__svg`)**: Animación continua `spinStamp 18s linear infinite` con `textLength="278"`–`279` calibrado para cerrar el círculo sin solapamientos.

---

## 5. Librería de Componentes UI

### 5.1 Botones y Llamados a la Acción (CTAs)

| Clase CSS | Apariencia y Comportamiento |
| :--- | :--- |
| `.btn` | Base de botón tipo píldora (`border-radius: 9999px`), `display: inline-flex`, `align-items: center`, `gap: 10px`, `font-weight: 600`. |
| `.btn--primary` | Gradiente vibrante (`linear-gradient(135deg, #EB5F69, #9B7EDE)`), texto blanco y sombra difusa coral/violeta. |
| `.btn--outline-dark` | Fondo translúcido `rgba(255,255,255,0.05)` con `backdrop-filter: blur(10px)` y borde `rgba(255,255,255,0.18)`. |
| `.btn-dark-pill` | Botón negro sólido (`#09090B`) con ícono circular interno para contrastar sobre la zona clara (`#FAF9F6`). |
| `.site-header__cta-item` | Ítem de menú «Contacto» estilizado como botón píldora dentro de la barra de navegación. |
| `.whatsapp-fab` | Botón flotante persistente (`58px × 58px`) en la esquina inferior derecha (`#25D366`) con anillo de pulso animado. |

### 5.2 Tarjetas y Módulos Editoriales

1. **Bento Cards (`.bento-card`)**:
   - Variantes cromáticas: `.bento-card--coral` (`#EB5F69`), `.bento-card--lilac` (`#BC80BB`), `.bento-card--blue` (`#669ACA`), `.bento-card--orchid` (`#9B7EDE`).
   - Incluyen etiqueta superior en píldora, titular audaz y gráfico/mockup flotante.
2. **Work Card (`.work-card`)**:
   - Marco visual `.work-card__media` con `aspect-ratio: 16 / 11`, zoom suave en la imagen al hacer *hover* y botón circular flotante `.work-card__arrow` en la esquina superior derecha.
3. **Service Capability Card (`.service-row`)**:
   - Tarjeta oscura (`#0D0D12`) sobre fondo claro con resplandor radial superior (*aurora glow*), número monoespaciado (`01`–`04`), lista de entregables y píldora de acción.
4. **Case Study Accordion (`.cs-accordion`)**:
   - 4 filas expandibles (*Challenge, Inspiration, Idea, Growth*) con divisor superior negro de `1.5px`, encabezado interactivo `<button class="cs-accordion__header">` e indicador circular `+` que rota `45°` al abrirse (`.is-open`).
5. **Interactive Inquiry Chips (`.chip`)**:
   - Píldoras seleccionables (`input[type="checkbox"]` o `input[type="radio"]` ocultos) para elegir tipo de servicio y rango de inversión con estado activo en `#09090B`.

---

## 6. Reglas de Compatibilidad con WordPress Bricks Builder

Para garantizar que el sistema de diseño se vea idéntico en Bricks Builder y en el preview estático:

1. **Overrides de `flex-direction` (`!important`)**:
   Bricks aplica `display: flex; flex-direction: column` por defecto a todos los `.brxe-block`, `.brxe-container` y `.brxe-div`. Al final de `src/scss/style.scss` (y `child-theme/css/style.css`) se incluyen reglas explícitas con `!important` para todas las filas horizontales (`.site-header__inner`, `.hero__cta-group`, `.cs-intro-band__meta-row`, `.cs-accordion__header`, `.cs-section-bar`, etc.) y grillas CSS (`.bento-grid`, `.works-grid`, `.services-grid`, `.cs-metrics__grid`, `.cs-keep-reading__grid`).
2. **Restricción de Dimensiones del Logo**:
   En Bricks, `.brxe-image` se expande al `100%` si no se limita. Los selectores `.site-logo__img`, `.site-logo img` y `.site-header__inner img` fuerzan `height: 46px !important; max-height: 46px !important; width: auto !important; max-width: 140px !important; object-fit: contain !important` (`38px` de alto / `120px` de ancho máximo en estado `.scrolled`).
3. **Elementos Hoja vs. Contenedores Interactivos**:
   En los JSON de `bricks-templates/`, cualquier botón complejo con hijos (como `.cs-accordion__header` o `.work-card`) se construye con `"name": "block"` y `"tag": "button"` o `"tag": "a"`, nunca con `"name": "button"` (ya que en Bricks `button` es un elemento hoja y no renderiza hijos).
