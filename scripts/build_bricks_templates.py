#!/usr/bin/env python3
"""
Generator & Validator for UP Group Studio (studio.up.gt) Bricks Builder JSON Templates.
Strictly enforces all rules from the WordPress Bricks Builder skill:
- Root elements are `name: "section"` with `parent: 0`
- Bidirectional `parent` <-> `children` links
- Leaf elements (`image`, `icon`, `heading`, `text-basic`, `text-link`, `button`, `shortcode`) never have children
- Clickable containers with children use `name: "block"` with `tag: "a"` or `tag: "button"`
- Header templates provide both `"header"` and `"content"` keys
- Footer templates provide both `"footer"` and `"content"` keys
- Native Font Awesome `icon` elements with `iconSize`
- Shortcodes (`name: "shortcode"`) for forms and custom SVG art
"""

import json
import os
import hashlib

ROOT_DIR = os.path.dirname(os.path.dirname(os.path.abspath(__file__)))
OUT_DIR = os.path.join(ROOT_DIR, "bricks-templates")
os.makedirs(OUT_DIR, exist_ok=True)


class BricksTreeBuilder:
    def __init__(self, prefix="up"):
        self.prefix = prefix
        self.counter = 0
        self.elements = []
        self.by_id = {}

    def _next_id(self):
        self.counter += 1
        raw = hashlib.md5(f"{self.prefix}_{self.counter}".encode()).hexdigest()
        # 6-char lowercase alphanumeric starting with a letter
        chars = "abcdefghijklmnopqrstuvwxyz"
        first = chars[int(raw[0:2], 16) % 26]
        return first + raw[2:7]

    def add(self, name, parent=0, css="", label="", tag=None, text=None, attrs=None, extra_settings=None):
        el_id = self._next_id()
        settings = {}
        if css:
            settings["_cssClasses"] = css
            settings["_hidden"] = {"_cssClasses": css}
        if tag:
            settings["tag"] = tag
        if text is not None:
            settings["text"] = text
        if attrs:
            # Bricks custom attributes array
            settings["_attributes"] = [
                {"id": self._next_id(), "name": k, "value": v}
                for k, v in attrs.items()
            ]
        if extra_settings:
            settings.update(extra_settings)

        el = {
            "id": el_id,
            "name": name,
            "parent": parent,
            "children": [],
            "settings": settings,
            "label": label or (css.split()[0] if css else name)
        }
        self.elements.append(el)
        self.by_id[el_id] = el
        if parent != 0 and parent in self.by_id:
            self.by_id[parent]["children"].append(el_id)
        return el_id

    def icon(self, parent, fa_class, size="18", css=""):
        parts = fa_class.strip().split()
        return self.add(
            "icon",
            parent=parent,
            css=css,
            label="Icon",
            extra_settings={
                "icon": {
                    "library": "fontawesome",
                    "icon": " ".join(parts)
                },
                "iconSize": str(size)
            }
        )

    def shortcode(self, parent, sc_text, label="Shortcode"):
        return self.add(
            "shortcode",
            parent=parent,
            label=label,
            extra_settings={"shortcode": sc_text}
        )

    def validate(self):
        leaf_types = {"image", "icon", "heading", "text-basic", "text-link", "button", "shortcode"}
        for el in self.elements:
            if el["parent"] == 0 and el["name"] != "section":
                raise ValueError(f"Root element {el['id']} ({el['label']}) must be 'section', got '{el['name']}'")
            if el["name"] in leaf_types and len(el["children"]) > 0:
                raise ValueError(f"Leaf element {el['id']} ({el['name']}) cannot have children!")
            for cid in el["children"]:
                if cid not in self.by_id or self.by_id[cid]["parent"] != el["id"]:
                    raise ValueError(f"Broken parent/child link between {el['id']} and {cid}")
        return self.elements


# ---------------------------------------------------------------------------
# 1. HEADER TEMPLATE (`header.json`)
# ---------------------------------------------------------------------------
def build_header():
    b = BricksTreeBuilder("hdr")
    sec = b.add("section", 0, css="site-header", label="Header Section", tag="header", extra_settings={"_cssId": "header"})
    cnt = b.add("container", sec, css="container site-header__inner", label="Header Container", extra_settings={
        "_direction": "row",
        "_alignItems": "center",
        "_justifyContent": "space-between"
    })

    # Logo Link Block
    logo_link = b.add("block", cnt, css="site-logo", label="Site Logo Link", tag="a", extra_settings={
        "link": {"type": "external", "url": "/"},
        "_widthMax": "max-content"
    })
    b.add("image", logo_link, css="site-logo__img", label="Logo Image", extra_settings={
        "image": {"url": "/wp-content/themes/upagency/screenshot.png", "alt": "UP Group Studio"},
        "_height": "54",
        "_heightMax": "54",
        "_widthMax": "max-content"
    })
    b.add("text-basic", logo_link, css="sr-only", label="SR Only Brand Text", tag="span", text="UP Group Studio")

    # Navigation
    nav = b.add("block", cnt, css="site-nav", label="Main Navigation", tag="nav", extra_settings={"_widthMax": "max-content"})
    ul = b.add("block", nav, css="site-nav__list", label="Nav List", tag="ul", extra_settings={"_direction": "row", "_alignItems": "center"})

    nav_items = [
        ("Proyectos", "#works", "nav.works", "site-nav__link"),
        ("Servicios", "#services", "nav.services", "site-nav__link"),
        ("El Estudio", "#studio", "nav.studio", "nav.studio"),
    ]
    for text, url, i18n, cls in [
        ("Proyectos", "#works", "nav.works", "site-nav__link"),
        ("Servicios", "#services", "nav.services", "site-nav__link"),
        ("El Estudio", "#studio", "nav.studio", "site-nav__link"),
    ]:
        li = b.add("block", ul, label=f"Item {text}", tag="li", extra_settings={"_widthMax": "max-content"})
        b.add("text-link", li, css=cls, label=text, text=text, attrs={"data-i18n": i18n}, extra_settings={
            "link": {"type": "external", "url": url}
        })

    li_cta = b.add("block", ul, css="site-nav__cta-item", label="Item Contacto CTA", tag="li", extra_settings={"_widthMax": "max-content"})
    b.add("text-link", li_cta, css="nav-contact-pill", label="Contacto Button", text="Contacto", attrs={"data-i18n": "nav.contact"}, extra_settings={
        "link": {"type": "external", "url": "#inquiry"}
    })

    # Right Language Switcher
    right = b.add("block", cnt, css="site-header__right", label="Header Right", extra_settings={"_direction": "row", "_widthMax": "max-content"})
    lang_sw = b.add("block", right, css="lang-switcher", label="Language Switcher", extra_settings={"_cssId": "langSwitcher", "_direction": "row", "_widthMax": "max-content"})
    b.add("button", lang_sw, css="lang-btn active", label="ES Button", text="ES", attrs={"data-lang": "es"})
    b.add("text-basic", lang_sw, css="lang-sep", label="Separator", tag="span", text="/")
    b.add("button", lang_sw, css="lang-btn", label="EN Button", text="EN", attrs={"data-lang": "en"})

    els = b.validate()
    return {
        "id": 2001,
        "name": "up-global-header",
        "title": "UP Group Studio — Global Header",
        "type": "header",
        "templateType": "header",
        "global_classes": [],
        "header": els,
        "content": els
    }


# ---------------------------------------------------------------------------
# 2. HERO + CLIENT LOGOS SECTION (`hero.json`)
# ---------------------------------------------------------------------------
def append_hero_section(b):
    sec = b.add("section", 0, css="dark-zone hero-section", label="Hero & Clients Section", extra_settings={"_cssId": "hero"})
    cnt = b.add("container", sec, css="container", label="Hero Container")

    card = b.add("block", cnt, css="hero-mesh-card", label="Hero Mesh Gradient Card")
    b.add("block", card, css="mesh-grain", label="Mesh Grain Overlay")

    content = b.add("block", card, css="hero-mesh-card__content", label="Hero Copy Wrapper")
    b.add("heading", content, css="hero-title", label="Hero Title", tag="h1", text="Enciende tu<br>Potencial Digital", attrs={"data-i18n": "hero.title"})
    b.add("text-basic", content, css="hero-subtitle", label="Hero Subtitle", tag="p",
          text="Somos <strong>UP Group Studio</strong>, un estudio digital en Guatemala y Houston, TX. Llevamos más de 15 años creando sitios web a medida, identidades visuales y estrategias digitales que cautivan y convierten.",
          attrs={"data-i18n": "hero.desc"})

    # Rotating Stamp Shortcode
    b.shortcode(card, "[up_scroll_stamp]", label="Hero Rotating Stamp")

    # Client Logos Grid
    clients_wrap = b.add("block", cnt, css="clients-section", label="Clients Logos Wrapper")
    grid = b.add("block", clients_wrap, css="clients-grid", label="Clients Grid (2x6)")

    logos = [
        ("INDE", "fa-solid fa-bolt", "logo-mark"),
        ("NANAJUANA", None, "logo-mark logo-mark--serif"),
        ("TIKAL FUTURA", "fa-solid fa-building-columns", "logo-mark"),
        ("HYUNDAI", None, "logo-mark logo-mark--bold"),
        ("BBDO", None, "logo-mark logo-mark--heavy"),
        ("CAMINO REAL", None, "logo-mark logo-mark--serif"),
        ("BILTMORE", None, "logo-mark"),
        ("MRC GLOBAL", None, "logo-mark logo-mark--bold"),
        ("COASTAL DEBT", "fa-solid fa-shield-halved", "logo-mark"),
        ("CIMCA", None, "logo-mark"),
        ("ALDEAS SOS", "fa-solid fa-hand-holding-heart", "logo-mark"),
        ("RODRI8", None, "logo-mark logo-mark--mono"),
    ]
    for name, icon_cls, mark_cls in logos:
        item = b.add("block", grid, css="client-logo-item", label=f"Client {name}")
        mark = b.add("block", item, css=mark_cls, label=f"Mark {name}", tag="span")
        if icon_cls:
            b.icon(mark, icon_cls, size="16")
        b.add("text-basic", mark, label=name, tag="span", text=name)


# ---------------------------------------------------------------------------
# 3. PORTFOLIO BENTO + DARK MANIFESTO + MARQUEE RIBBONS (`works.json`)
# ---------------------------------------------------------------------------
def append_works_section(b):
    sec = b.add("section", 0, css="dark-zone portfolio-section", label="Portfolio Bento & Manifesto 1", extra_settings={"_cssId": "works"})
    cnt = b.add("container", sec, css="container", label="Portfolio Container")

    bento = b.add("block", cnt, css="portfolio-bento", label="Portfolio Bento Grid")

    projects = [
        ("nanajuana", "Nanajuana Río Dulce", "NANAJUANA", "RÍO DULCE • MARINA & RESORT", "fa-solid fa-anchor", "bento-card--lilac", False, "works.p1Tag", "UI/UX • Booking Engine • Brand Content", "works.p1Desc", "Experiencia digital inmersiva y reservas directas para el destino náutico más exclusivo de Guatemala.", "works.p1Cat", "Diseño Web & Motor de Reservas"),
        ("tikal-futura", "Grand Tikal Futura", "TIKAL FUTURA", "GRAND HOTEL & CONVENTION CENTER", "fa-solid fa-gem", "bento-card--blue", True, "works.p2Tag", "Arquitectura Corporativa • Portal de Eventos", "works.p2Desc", "Renovación integral del centro de convenciones y complejo hotelero más icónico de Guatemala.", "works.p2Cat", "Portal Corporativo & Convenciones"),
        ("inde", "INDE Guatemala", "INDE", "INSTITUTO NACIONAL DE ELECTRIFICACIÓN", "fa-solid fa-bolt-lightning", "bento-card--coral", False, "works.p3Tag", "Portal Institucional • Alta Disponibilidad", "works.p3Desc", "Plataforma de alto tráfico con visualización energética nacional, estándares de accesibilidad y ciberseguridad.", "works.p3Cat", "Plataforma Institucional & Datos"),
        ("hyundai", "Hyundai Comerciales", "HYUNDAI", "VEHÍCULOS COMERCIALES & FLOTILLAS", "fa-solid fa-truck-fast", "bento-card--orchid", True, "works.p4Tag", "Catálogo B2B • Embudo de Leads", "works.p4Desc", "Catálogo interactivo y cotizador en tiempo real para la línea de camiones y autobuses Hyundai.", "works.p4Cat", "Catálogo Digital & Lead Generation"),
        ("coastal-debt", "Coastal Debt (USA)", "COASTAL DEBT", "FINANCIAL RELIEF • UNITED STATES", "fa-solid fa-chart-line", "bento-card--mint", False, "works.p5Tag", "US Fintech Market • Speed Optimization", "works.p5Desc", "Plataforma financiera para el mercado de EE.UU. con calculadoras interactivas y conversión de alto rendimiento.", "works.p5Cat", "Fintech Web & Optimización"),
        ("bbdo", "BBDO Guatemala", "BBDO", "CREATIVE AGENCY NETWORK", "fa-solid fa-award", "bento-card--amber", True, "works.p6Tag", "Creative Showcase • Video Portfolio", "works.p6Desc", "Showcase editorial multipremiado exhibiendo campañas regionales con fluidez y velocidad instantánea.", "works.p6Cat", "Diseño Editorial & Portafolio"),
    ]

    for slug, title, emblem_name, emblem_sub, icon_cls, card_cls, staggered, tag_k, tag_v, desc_k, desc_v, cat_k, cat_v in projects:
        item_cls = "bento-item bento-item--staggered" if staggered else "bento-item"
        item = b.add("block", bento, css=item_cls, label=f"Project {title}", tag="article")

        card = b.add("block", item, css=f"bento-card {card_cls}", label=f"Card {title}", tag="a",
                     attrs={"data-project": title},
                     extra_settings={"link": {"type": "external", "url": f"/project/?id={slug}"}})

        center = b.add("block", card, css="bento-card__center", label="Center Emblem")
        emb = b.add("block", center, css="bento-emblem", label="Emblem Inner")
        b.icon(emb, icon_cls, size="38", css="bento-emblem__icon")
        b.add("text-basic", emb, css="bento-emblem__name", label="Emblem Name", tag="span", text=emblem_name)
        b.add("text-basic", emb, css="bento-emblem__sub", label="Emblem Subtitle", tag="span", text=emblem_sub)

        reveal = b.add("block", card, css="bento-card__hover-reveal", label="Hover Reveal Overlay")
        b.add("text-basic", reveal, css="reveal-pill", label="Reveal Tag", tag="span", text=tag_v, attrs={"data-i18n": tag_k})
        b.add("text-basic", reveal, css="reveal-desc", label="Reveal Description", tag="p", text=desc_v, attrs={"data-i18n": desc_k})
        cta = b.add("block", reveal, css="reveal-cta", label="Reveal CTA", tag="span")
        b.add("text-basic", cta, label="Explorar caso", tag="span", text="Explorar caso", attrs={"data-i18n": "works.cta"})
        b.icon(cta, "fa-solid fa-arrow-up-right-from-square", size="14")

        meta = b.add("block", item, css="bento-meta", label="Project Meta")
        b.add("heading", meta, css="bento-title", label=title, tag="h3", text=title)
        b.add("text-basic", meta, css="bento-category", label=cat_v, tag="p", text=cat_v, attrs={"data-i18n": cat_k})

    # Dark Editorial Manifesto 1
    man_wrap = b.add("block", cnt, css="manifesto-section manifesto-section--dark", label="Manifesto 1 Dark")
    man_grid = b.add("block", man_wrap, css="manifesto-grid", label="Manifesto Grid")
    stamp_col = b.add("block", man_grid, css="manifesto-stamp-col", label="Stamp Column")
    b.shortcode(stamp_col, "[up_manifesto_stamp_dark]", label="Manifesto 1 Rotating Stamp")

    copy_col = b.add("block", man_grid, css="manifesto-copy-col", label="Manifesto Copy Column")
    b.add("text-basic", copy_col, css="manifesto-lead", label="Manifesto Paragraph 1", tag="p",
          text='No solo hacemos <span class="doodle-word doodle-word--yellow">sitios web.</span> Los hacemos visibles ante los ojos de todos y en Google. Hablamos geek, pero te explicamos cada paso sin tecnicismos incomprensibles para que tu proyecto digital sea <span class="doodle-word doodle-word--mint">genial.</span>',
          attrs={"data-i18n": "manifesto1.p1"})
    b.add("text-basic", copy_col, css="manifesto-lead", label="Manifesto Paragraph 2", tag="p",
          text='Hemos trabajado en proyectos que salen de lo ordinario: retos que nos impulsan a <span class="doodle-word doodle-word--blue">crear a medida</span> y superar expectativas. Eso es lo que amamos 💖: la excelencia técnica y visual, jamás el copiar y pegar.',
          attrs={"data-i18n": "manifesto1.p2"})

    man_foot = b.add("block", copy_col, css="manifesto-footer", label="Manifesto Footer")
    b.add("text-basic", man_foot, css="manifesto-caption", label="Manifesto Caption", tag="p",
          text="¿Tienes un proyecto en mente? Cuéntanos tus objetivos.", attrs={"data-i18n": "manifesto1.caption"})
    b.add("text-link", man_foot, css="btn-gradient-pill", label="Manifesto CTA", text="Iniciar una conversación",
          attrs={"data-i18n": "manifesto1.cta"}, extra_settings={"link": {"type": "external", "url": "#inquiry"}})

    # Criss-Crossed Marquee Ribbons Transition
    b.shortcode(sec, "[up_marquee_ribbons]", label="Criss-Crossed Marquee Ribbons")


# ---------------------------------------------------------------------------
# 4. SERVICES À LA CARTE SECTION (`services.json`)
# ---------------------------------------------------------------------------
def append_services_section(b):
    sec = b.add("section", 0, css="light-zone services-section", label="Services À La Carte Section", extra_settings={"_cssId": "services"})
    b.add("block", sec, css="services-aurora-bg", label="Pastel Aurora Glow")
    cnt = b.add("container", sec, css="container", label="Services Container")

    hdr = b.add("block", cnt, css="services-header", label="Services Header")
    b.add("text-basic", hdr, css="services-kicker", label="Services Kicker", tag="span",
          text="SOLUCIONES A LA MEDIDA DE TU NEGOCIO", attrs={"data-i18n": "services.kicker"})
    b.add("heading", hdr, css="services-main-title", label="Services Title", tag="h2",
          text='<span data-i18n="services.title">Nuestros servicios<br>à la carte</span> <span class="services-sticker">🎨</span>')
    b.add("text-basic", hdr, css="services-subtitle", label="Services Subtitle", tag="p",
          text="Sin ataduras a un solo CMS ni plantillas prefabricadas. Elegimos la tecnología exacta que tu empresa necesita para escalar en Guatemala o Estados Unidos.",
          attrs={"data-i18n": "services.subtitle"})

    grid = b.add("block", cnt, css="services-cards-grid", label="Services Cards Grid")
    services = [
        ("srv-card--glow-1", "fa-solid fa-code", "services.s1Title", "Desarrollo de<br>sitios web a medida", "services.s1Desc", "Portales corporativos, sitios institucionales y plataformas web rápidas, seguras y adaptadas al 100% a tus objetivos comerciales.", "Desarrollo Web a Medida"),
        ("srv-card--glow-2", "fa-solid fa-pen-nib", "services.s2Title", "Diseño UI/UX &<br>Identidad visual", "services.s2Desc", "Interfaces memorables, sistemas de diseño, dirección de arte, fotografía comercial y producción audiovisual de alto impacto.", "UI/UX Design & Branding"),
        ("srv-card--glow-3", "fa-solid fa-bag-shopping", "services.s3Title", "Tiendas Online &<br>E-Commerce", "services.s3Desc", "Comercio electrónico diseñado para vender 24/7 con pasarelas locales (Guatemala) e internacionales (Stripe, PayPal en EE.UU.).", "E-Commerce"),
        ("srv-card--glow-4", "fa-solid fa-gauge-high", "services.s4Title", "Mantenimiento &<br>Optimización Web", "services.s4Desc", "Aceleración de Core Web Vitals (95+ en Google PageSpeed), blindaje de seguridad, backups y soporte técnico continuo.", "Mantenimiento & Velocidad"),
        ("srv-card--glow-5", "fa-solid fa-wand-magic-sparkles", "services.s5Title", "Automatización &<br>Inteligencia Artificial", "services.s5Desc", "Conexión inteligente de formularios a WhatsApp y CRM, agentes de IA de atención al cliente y optimización de flujos operativos.", "Automatizaciones & IA"),
    ]

    for glow_cls, icon_cls, tk, tv, dk, dv, svc_val in services:
        card = b.add("block", grid, css=f"srv-card {glow_cls}", label=svc_val, tag="article")
        icon_box = b.add("block", card, css="srv-card__icon", label="Service Icon Box")
        b.icon(icon_box, icon_cls, size="18")

        body = b.add("block", card, css="srv-card__body", label="Service Body")
        b.add("heading", body, css="srv-card__title", label="Service Title", tag="h3", text=tv, attrs={"data-i18n": tk})
        b.add("text-basic", body, css="srv-card__desc", label="Service Description", tag="p", text=dv, attrs={"data-i18n": dk})

        foot = b.add("block", card, css="srv-card__footer", label="Service Footer")
        b.add("text-link", foot, css="srv-pill-btn", label="Cotizar Button", text="Cotizar",
              attrs={"data-select-service": svc_val, "data-i18n": "services.btn"},
              extra_settings={"link": {"type": "external", "url": "#inquiry"}})


# ---------------------------------------------------------------------------
# 5. STUDIO MANIFESTO 2 + DUO CARDS (`studio.json`)
# ---------------------------------------------------------------------------
def append_studio_section(b):
    sec = b.add("section", 0, css="light-zone manifesto-section manifesto-section--light", label="Studio Leadership Section", extra_settings={"_cssId": "studio"})
    cnt = b.add("container", sec, css="container", label="Studio Container")

    grid = b.add("block", cnt, css="manifesto-grid", label="Studio Manifesto Grid")
    stamp_col = b.add("block", grid, css="manifesto-stamp-col", label="Light Stamp Column")
    b.shortcode(stamp_col, "[up_manifesto_stamp_light]", label="Manifesto 2 Rotating Stamp")

    copy_col = b.add("block", grid, css="manifesto-copy-col", label="Studio Copy Column")
    b.add("text-basic", copy_col, css="manifesto-lead manifesto-lead--dark", label="Studio Lead 1", tag="p",
          text='No nos gustan los sitios creados en serie. Cada proyecto es diseñado artesanalmente para reflejar tu identidad y responder a tus <span class="doodle-word">objetivos.</span>',
          attrs={"data-i18n": "manifesto2.p1"})
    b.add("text-basic", copy_col, css="manifesto-lead manifesto-lead--dark", label="Studio Lead 2", tag="p",
          text='Colaborar con UP Group Studio es elegir una dupla <span class="doodle-word">humana y senior</span> que domina su oficio, responde directo por WhatsApp y te acompaña a largo plazo desde <strong>Guatemala</strong> y <strong>Houston, Texas</strong> ✹',
          attrs={"data-i18n": "manifesto2.p2"})

    duo = b.add("block", copy_col, css="studio-duo-grid", label="Leadership Duo Grid")

    # Rodrigo Card
    rc = b.add("block", duo, css="duo-card", label="Rodrigo Campos Card")
    rc_av = b.add("block", rc, css="duo-card__avatar duo-card__avatar--rodrigo", label="Avatar RC")
    b.add("text-basic", rc_av, label="RC Initials", tag="span", text="RC")
    rc_info = b.add("block", rc, css="duo-card__info", label="Info RC")
    rc_head = b.add("block", rc_info, css="duo-card__head", label="Head RC")
    b.add("heading", rc_head, label="Rodrigo Campos", tag="h4", text="Rodrigo Campos")
    b.add("text-basic", rc_head, css="duo-badge", label="15+ YRS EXP", tag="span", text="15+ YRS EXP")
    b.add("text-basic", rc_info, css="duo-role", label="Role RC", tag="p",
          text="Founder • Web Development & Digital Product Design", attrs={"data-i18n": "studio.rodrigoRole"})
    rc_links = b.add("block", rc_info, css="duo-links", label="Links RC")
    b.add("text-link", rc_links, label="rodri8.com", text="rodri8.com", extra_settings={"link": {"type": "external", "url": "https://rodri8.com", "newTab": True}})
    b.add("text-link", rc_links, label="LinkedIn", text="LinkedIn", extra_settings={"link": {"type": "external", "url": "https://www.linkedin.com/in/rodri8/", "newTab": True}})

    # Yulcer Card
    yc = b.add("block", duo, css="duo-card", label="Yulcer Card")
    yc_av = b.add("block", yc, css="duo-card__avatar duo-card__avatar--yulcer", label="Avatar YC")
    b.add("text-basic", yc_av, label="YC Initials", tag="span", text="YC")
    yc_info = b.add("block", yc, css="duo-card__info", label="Info YC")
    yc_head = b.add("block", yc_info, css="duo-card__head", label="Head YC")
    b.add("heading", yc_head, label="Yulcer", tag="h4", text="Yulcer")
    b.add("text-basic", yc_head, css="duo-badge duo-badge--lilac", label="CREATIVE LEAD", tag="span", text="CREATIVE LEAD")
    b.add("text-basic", yc_info, css="duo-role", label="Role YC", tag="p",
          text="Co-Lead • Visual Design, Video & Commercial Photography", attrs={"data-i18n": "studio.yulcerRole"})
    yc_tags = b.add("block", yc_info, css="duo-tags", label="Tags YC")
    for t in ["Art Direction", "Video", "Photo"]:
        b.add("text-basic", yc_tags, label=t, tag="span", text=t)

    foot = b.add("block", copy_col, css="manifesto-footer", label="Studio Footer")
    b.add("text-basic", foot, css="manifesto-caption manifesto-caption--dark", label="Response Time Caption", tag="p",
          text="Respuesta directa en menos de 2 horas hábiles.", attrs={"data-i18n": "manifesto2.caption"})
    b.add("text-link", foot, css="btn-pastel-blue", label="Cotizar CTA", text="Cotizar mi proyecto",
          attrs={"data-i18n": "manifesto2.cta"}, extra_settings={"link": {"type": "external", "url": "#inquiry"}})


# ---------------------------------------------------------------------------
# 6. SPLIT ROCKET CTA + INQUIRY FORM SECTION (`inquiry.json`)
# ---------------------------------------------------------------------------
def append_inquiry_section(b):
    sec = b.add("section", 0, css="light-zone cta-banner-section", label="Split Rocket CTA & Inquiry Form", extra_settings={"_cssId": "inquiry"})
    cnt = b.add("container", sec, css="container", label="Inquiry Container")

    split = b.add("block", cnt, css="split-rocket-card", label="Split Rocket Card")
    left = b.add("block", split, css="split-rocket-card__left", label="Split Left Copy")
    b.add("text-basic", left, css="split-kicker", label="Kicker", tag="span",
          text="¿LISTO PARA DESPEGAR?", attrs={"data-i18n": "ctaBanner.kicker"})
    b.add("heading", left, css="split-title", label="Split Title", tag="h2",
          text='¿Necesitas un<br><span class="doodle-word">sitio web</span> de alto nivel?', attrs={"data-i18n": "ctaBanner.title"})
    b.add("text-basic", left, css="split-desc", label="Split Description", tag="p",
          text="Completa tus datos abajo para enviarnos un resumen directo por WhatsApp o mensaje directo.",
          attrs={"data-i18n": "ctaBanner.desc"})

    badges = b.add("block", left, css="split-badges", label="Location Badges")
    for loc in ["Guatemala", "Houston, TX"]:
        sp = b.add("block", badges, label=loc, tag="span")
        b.icon(sp, "fa-solid fa-check", size="12")
        b.add("text-basic", sp, label=loc, tag="span", text=loc)

    right = b.add("block", split, css="split-rocket-card__right", label="Split Right Rocket Art")
    b.shortcode(right, "[up_rocket_illustration]", label="Rocket Vector Illustration")

    # Interactive Inquiry Form Shortcode
    b.shortcode(cnt, "[up_inquiry_form]", label="Interactive Project Inquiry Form")


# ---------------------------------------------------------------------------
# 7. FOOTER TEMPLATE (`footer.json`)
# ---------------------------------------------------------------------------
def build_footer():
    b = BricksTreeBuilder("ftr")
    sec = b.add("section", 0, css="morez-footer", label="Footer Section", tag="footer", extra_settings={"_cssId": "contact"})
    cnt = b.add("container", sec, css="container", label="Footer Container")

    # 3 Outlined Contact Boxes (No exposed phone/email)
    boxes = b.add("block", cnt, css="footer-boxes", label="Top 3 Outlined Boxes")

    box1 = b.add("block", boxes, css="footer-box", label="WhatsApp Box", tag="a", extra_settings={
        "link": {"type": "external", "url": "https://wa.me/50237556857?text=Hola%20UP%20Group%20Studio,%20quisiera%20conversar%20sobre%20un%20proyecto.", "newTab": True}
    })
    box1_txt = b.add("block", box1, css="footer-box__text", label="WA Text", tag="span")
    b.icon(box1_txt, "fa-brands fa-whatsapp", size="17")
    b.add("text-basic", box1_txt, label="Chatear por WhatsApp", tag="span", text="Chatear por WhatsApp", attrs={"data-i18n": "footer.box1"})

    box2 = b.add("block", boxes, css="footer-box", label="Locations Box")
    box2_txt = b.add("block", box2, css="footer-box__text", label="Locations Text", tag="span")
    b.icon(box2_txt, "fa-solid fa-location-dot", size="17")
    b.add("text-basic", box2_txt, label="Guatemala • Houston, Texas", tag="span", text="Guatemala • Houston, Texas", attrs={"data-i18n": "footer.box2"})

    box3 = b.add("block", boxes, css="footer-box", label="Domain Box", tag="a", extra_settings={
        "link": {"type": "external", "url": "#inquiry"}
    })
    box3_txt = b.add("block", box3, css="footer-box__text", label="Domain Text", tag="span")
    b.icon(box3_txt, "fa-regular fa-paper-plane", size="17")
    b.add("text-basic", box3_txt, label="Iniciar Proyecto • studio.up.gt", tag="span", text="Iniciar Proyecto • studio.up.gt", attrs={"data-i18n": "footer.box3"})

    # Center Brand Wordmark
    center_brand = b.add("block", cnt, css="footer-center-brand", label="Center Brand Wrapper")
    b.add("text-link", center_brand, css="footer-wordmark", label="UP GROUP STUDIO", text="UP GROUP STUDIO", extra_settings={
        "link": {"type": "external", "url": "#hero"}
    })

    # Main Footer Columns
    main_grid = b.add("block", cnt, css="footer-main-grid", label="Footer Main Grid")
    cta_col = b.add("block", main_grid, css="footer-cta-col", label="Footer CTA Column")
    b.add("heading", cta_col, css="footer-big-title", label="Footer Big Title", tag="h2",
          text='<span data-i18n="footer.bigTitle">Es ahora que<br>todo comienza</span><span class="footer-script-accent" data-i18n="footer.scriptAccent">con nosotros</span>')
    b.add("text-link", cta_col, css="btn-gradient-pill", label="Iniciar un proyecto", text="Iniciar un proyecto",
          attrs={"data-i18n": "footer.ctaBtn"}, extra_settings={"link": {"type": "external", "url": "#inquiry"}})

    col1 = b.add("block", main_grid, css="footer-nav-col", label="Footer Studio Links")
    b.add("heading", col1, css="footer-col-title", label="Estudio", tag="h4", text="Estudio", attrs={"data-i18n": "footer.col1Title"})
    ul1 = b.add("block", col1, label="Studio List", tag="ul")
    for text, url, i18n in [
        ("Proyectos", "#works", "nav.works"),
        ("El Estudio", "#studio", "nav.studio"),
        ("Portafolio Rodrigo", "https://rodri8.com", None),
        ("Contacto", "#inquiry", "nav.contact")
    ]:
        li = b.add("block", ul1, label=text, tag="li")
        b.add("text-link", li, label=text, text=text, attrs=({"data-i18n": i18n} if i18n else None),
              extra_settings={"link": {"type": "external", "url": url}})

    col2 = b.add("block", main_grid, css="footer-nav-col", label="Footer Services Links")
    b.add("heading", col2, css="footer-col-title", label="Servicios & Soluciones", tag="h4", text="Servicios & Soluciones", attrs={"data-i18n": "footer.col2Title"})
    ul2 = b.add("block", col2, label="Services List", tag="ul")
    for text, i18n in [
        ("Desarrollo Web a Medida", "services.f1"),
        ("Diseño UI/UX & Branding", "services.f2"),
        ("E-Commerce & Pagos", "services.f3"),
        ("Optimización & Velocidad", "services.f4"),
        ("Automatizaciones & IA", "services.f5"),
    ]:
        li = b.add("block", ul2, label=text, tag="li")
        b.add("text-link", li, label=text, text=text, attrs={"data-i18n": i18n},
              extra_settings={"link": {"type": "external", "url": "#services"}})

    # Geometric Shapes + Floating WhatsApp Shortcode
    b.shortcode(cnt, "[up_footer_shapes]", label="Footer Shapes & Floating WhatsApp")

    # Legal Bar
    legal = b.add("block", cnt, css="footer-legal", label="Footer Legal Bar")
    b.add("text-basic", legal, label="Copyright", tag="span", text="© 2026 UP GROUP STUDIO (STUDIO.UP.GT) • GUATEMALA & HOUSTON")
    b.add("text-basic", legal, label="Rights", tag="span", text="TODOS LOS DERECHOS RESERVADOS", attrs={"data-i18n": "footer.rights"})

    els = b.validate()
    return {
        "id": 2002,
        "name": "up-global-footer",
        "title": "UP Group Studio — Global Footer",
        "type": "footer",
        "templateType": "footer",
        "global_classes": [],
        "footer": els,
        "content": els
    }


# ---------------------------------------------------------------------------
# 8. SINGLE PORTFOLIO / CASE STUDY TEMPLATE (`single-portfolio.json`)
# ---------------------------------------------------------------------------
def build_single_portfolio():
    b = BricksTreeBuilder("case")

    # Section 1: Full-Bleed Visual Cover Stage
    sec_cover = b.add("section", 0, css="case-hero-cover", label="Case Study Hero Cover", extra_settings={"_cssId": "caseHeroCover"})
    stage = b.add("block", sec_cover, css="cover-stage-art", label="Cover Stage Art")
    b.add("block", stage, css="cover-stage-art__bokeh", label="Bokeh Overlay")
    cnt_cover = b.add("container", stage, css="container cover-stage-art__inner", label="Cover Container")
    comp = b.add("block", cnt_cover, css="cover-Floating-composition", label="Floating Multi-Device Stage")

    # Left Tilted Device
    dev_l = b.add("block", comp, css="cover-device cover-device--left", label="Left Tilted Card")
    scr_l = b.add("block", dev_l, css="cover-device__screen", label="Left Screen")
    b.icon(scr_l, "fa-solid fa-anchor", size="32", css="cover-device__icon")
    b.add("heading", scr_l, label="Project Badge", tag="h4", text="{post_title}")

    # Center Main Display
    dev_c = b.add("block", comp, css="cover-device cover-device--center", label="Center Flagship Display")
    scr_c = b.add("block", dev_c, css="cover-device__screen cover-device__screen--main", label="Main Screen")
    b.add("text-basic", scr_c, css="cover-chip", label="Project Category", tag="span", text="UP GROUP STUDIO CASE STUDY")
    b.add("heading", scr_c, label="Main Display Title", tag="h2", text="{post_title}")
    b.add("text-basic", scr_c, label="Main Display Excerpt", tag="p", text="{post_excerpt}")

    # Right Mobile Device
    dev_r = b.add("block", comp, css="cover-device cover-device--right", label="Right Mobile Card")
    scr_r = b.add("block", dev_r, css="cover-device__screen", label="Right Screen")
    b.add("text-basic", scr_r, css="cover-mobile-tag", label="Mobile Tag", tag="span", text="MOBILE FIRST")
    b.add("heading", scr_r, label="Metric Highlight", tag="h4", text="98/100")
    b.add("text-basic", scr_r, label="Metric Label", tag="p", text="Google PageSpeed")

    # Section 2: Colored Editorial Intro Band (VML Style)
    sec_band = b.add("section", 0, css="case-intro-band", label="Colored Editorial Intro Band", extra_settings={"_cssId": "caseIntroBand"})
    b.add("block", sec_band, css="case-intro-band__halftone", label="Halftone Pattern Overlay")
    cnt_band = b.add("container", sec_band, css="container", label="Intro Band Container")
    top_bar = b.add("block", cnt_band, css="case-intro-band__top", label="Top Kicker Divider")
    b.add("text-basic", top_bar, css="case-kicker-label", label="Kicker Text", tag="span", text="{post_title} × UP Group Studio")

    offset = b.add("block", cnt_band, css="case-intro-band__Offset", label="Indented Editorial Content")
    b.add("heading", offset, css="case-headline", label="Case Study Headline", tag="h1",
          text="Experiencia digital inmersiva y arquitectura a medida diseñada para liderar su industria")

    meta_grid = b.add("block", offset, css="case-meta-grid", label="Case Metadata Row")
    for lbl, val in [
        ("Estudio", "Guatemala & Houston"),
        ("Cliente", "{post_title}"),
        ("Especialidad", "UI/UX & Custom Web Dev"),
        ("Año", "2025 — 2026")
    ]:
        m_item = b.add("block", meta_grid, css="case-meta-item", label=f"Meta {lbl}")
        b.add("text-basic", m_item, css="case-meta-label", label=lbl, tag="span", text=lbl)
        b.add("text-basic", m_item, css="case-meta-value", label=val, tag="span", text=val)

    # Section 3: White Editorial Content Zone (Summary, Video, 4 Accordions, Metrics, Gallery, Keep Reading)
    sec_body = b.add("section", 0, css="case-light-canvas", label="Case Study Editorial Body")
    cnt_body = b.add("container", sec_body, css="container", label="Case Body Container")
    ed_col = b.add("block", cnt_body, css="case-editorial-col", label="Narrow Editorial Column")

    b.add("text-basic", ed_col, css="case-lead-copy", label="Lead Overview Paragraph", tag="p",
          text="Diseñamos una plataforma digital sensorial que combina dirección de arte, velocidad de carga instantánea y un flujo de conversión sin fricciones pensado para usuarios en Guatemala y Estados Unidos.")

    # Featured Video / Interactive Reel Frame
    vid_frame = b.add("block", ed_col, css="case-video-frame", label="Featured Video Frame", extra_settings={"_cssId": "caseVideoFrame"})
    vid_overlay = b.add("block", vid_frame, css="case-video-frame__overlay", label="Video Play Overlay")
    play_box = b.add("block", vid_overlay, css="case-play-box", label="Square Play Button", tag="span")
    b.icon(play_box, "fa-solid fa-chevron-right", size="22")
    b.add("text-basic", vid_overlay, css="case-video-caption", label="Video Caption", tag="span", text="Ver recorrido interactivo del sitio (01:24)")

    # 4-Row Case Study Accordion (Challenge, Inspiration, Idea, Growth)
    acc_wrap = b.add("block", ed_col, css="case-accordion", label="4-Row Case Accordion")
    acc_rows = [
        ("El Reto (Challenge)", True, "Modernizar la presencia digital eliminando fricciones técnicas y transmitiendo el valor real de la marca desde el primer segundo."),
        ("Inspiración (Inspiration)", False, "Un sistema de diseño editorial donde la tipografía, el contraste y el contenido audiovisual respiran con claridad."),
        ("La Solución (Idea)", False, "Arquitectura web a medida de alto rendimiento con flujos de conversión directa e integración inteligente con WhatsApp y CRM."),
        ("Impacto (Growth)", False, "Incremento sostenido en conversiones directas, reducción en tiempos de carga y puntuación superior a 96/100 en Google PageSpeed.")
    ]
    for title_txt, is_open, body_txt in acc_rows:
        item_cls = "case-acc-item open" if is_open else "case-acc-item"
        acc_item = b.add("block", acc_wrap, css=item_cls, label=title_txt)
        # Rule #11: Use `block` with `tag: "button"` so children render!
        trig = b.add("block", acc_item, css="case-acc-trigger", label=f"Trigger {title_txt}", tag="button",
                     attrs={"aria-expanded": "true" if is_open else "false"})
        b.add("text-basic", trig, css="case-acc-title", label=title_txt, tag="span", text=title_txt)
        b.icon(trig, "fa-solid fa-chevron-down", size="13", css="case-acc-icon")
        panel = b.add("block", acc_item, css="case-acc-panel", label=f"Panel {title_txt}")
        b.add("text-basic", panel, label="Panel Copy", tag="p", text=body_txt)

    # 3-Column Key Impact Metrics Strip
    metrics_block = b.add("block", ed_col, css="case-metrics-block", label="Impact Metrics Strip")
    metrics_grid = b.add("block", metrics_block, css="case-metrics-grid", label="Metrics 3-Column Grid")
    for num, lbl in [
        ("+185%", "Incremento en conversión directa"),
        ("98/100", "Google PageSpeed Performance"),
        ("1.1s", "Tiempo de carga inicial (LCP)")
    ]:
        m_card = b.add("block", metrics_grid, css="case-metric-card", label=f"Metric {num}")
        b.add("text-basic", m_card, css="case-metric-number", label=num, tag="span", text=num)
        b.add("text-basic", m_card, css="case-metric-label", label=lbl, tag="span", text=lbl)

    # Keep Reading Related Projects Section
    keep = b.add("block", cnt_body, css="case-keep-reading", label="Keep Reading Section")
    b.add("heading", keep, css="case-keep-reading__heading", label="Seguir explorando", tag="h2", text="Seguir explorando", attrs={"data-i18n": "case.keepReading"})
    rel_grid = b.add("block", keep, css="case-related-grid", label="Related 2-Column Grid")
    for r_title, r_sub, r_desc, r_url in [
        ("Grand Tikal Futura", "HOTEL & CONVENTION CENTER", "Renovación integral del centro de convenciones y complejo hotelero más icónico de Guatemala.", "/project/?id=tikal-futura"),
        ("INDE Guatemala", "PLATAFORMA INSTITUCIONAL", "Plataforma de alto tráfico con visualización energética nacional y estándares AA+ de accesibilidad.", "/project/?id=inde")
    ]:
        r_card = b.add("block", rel_grid, css="related-case-card", label=f"Related {r_title}", tag="article")
        r_thumb = b.add("block", r_card, css="related-case-card__thumb bento-card--blue", label="Related Thumbnail", tag="a",
                        extra_settings={"link": {"type": "external", "url": r_url}})
        r_emb = b.add("block", r_thumb, css="related-case-card__emblem", label="Related Emblem")
        b.add("text-basic", r_emb, label=r_title, tag="span", text=r_title)
        b.add("text-basic", r_emb, label=r_sub, tag="small", text=r_sub)
        b.add("heading", r_card, css="related-case-card__title", label=r_title, tag="h3", text=r_title)
        b.add("text-basic", r_card, css="related-case-card__desc", label=r_desc, tag="p", text=r_desc)

    els = b.validate()
    return {
        "id": 2009,
        "name": "up-single-portfolio",
        "title": "UP Group Studio — Single Portfolio Case Study (VML Layout)",
        "type": "content",
        "templateType": "content",
        "global_classes": [],
        "content": els
    }


def save_json(filename, data):
    path = os.path.join(OUT_DIR, filename)
    with open(path, "w", encoding="utf-8") as f:
        json.dump(data, f, ensure_ascii=False, indent=2)
    print(f"✓ Saved & validated {filename} ({len(data.get('content', []))} elements)")


def main():
    # 1. Header
    save_json("header.json", build_header())

    # 2. Footer
    save_json("footer.json", build_footer())

    # 3. Individual Sections
    b_hero = BricksTreeBuilder("hero")
    append_hero_section(b_hero)
    save_json("hero.json", {
        "id": 2003, "name": "up-section-hero", "title": "UP Group Studio — 01 Hero & Clients",
        "type": "section", "templateType": "section", "global_classes": [], "content": b_hero.validate()
    })

    b_works = BricksTreeBuilder("wrk")
    append_works_section(b_works)
    save_json("works.json", {
        "id": 2004, "name": "up-section-works", "title": "UP Group Studio — 02 Portfolio Bento & Manifesto",
        "type": "section", "templateType": "section", "global_classes": [], "content": b_works.validate()
    })

    b_srv = BricksTreeBuilder("srv")
    append_services_section(b_srv)
    save_json("services.json", {
        "id": 2005, "name": "up-section-services", "title": "UP Group Studio — 03 Services À La Carte",
        "type": "section", "templateType": "section", "global_classes": [], "content": b_srv.validate()
    })

    b_stu = BricksTreeBuilder("stu")
    append_studio_section(b_stu)
    save_json("studio.json", {
        "id": 2006, "name": "up-section-studio", "title": "UP Group Studio — 04 Studio Leadership",
        "type": "section", "templateType": "section", "global_classes": [], "content": b_stu.validate()
    })

    b_inq = BricksTreeBuilder("inq")
    append_inquiry_section(b_inq)
    save_json("inquiry.json", {
        "id": 2007, "name": "up-section-inquiry", "title": "UP Group Studio — 05 Split Rocket CTA & Inquiry Form",
        "type": "section", "templateType": "section", "global_classes": [], "content": b_inq.validate()
    })

    # 4. Complete Home Page Template (All Sections Combined)
    b_home = BricksTreeBuilder("home")
    append_hero_section(b_home)
    append_works_section(b_home)
    append_services_section(b_home)
    append_studio_section(b_home)
    append_inquiry_section(b_home)
    save_json("page-home.json", {
        "id": 2008, "name": "up-page-home", "title": "UP Group Studio — Complete Home Page",
        "type": "content", "templateType": "content", "global_classes": [], "content": b_home.validate()
    })

    # 5. Single Portfolio Case Study Template (VML Layout)
    save_json("single-portfolio.json", build_single_portfolio())


if __name__ == "__main__":
    main()
