/**
 * UP Group Studio — Single Portfolio Case Study Engine (VML Layout)
 * Supports all 6 flagship projects in ES & EN:
 *  - nanajuana (Nanajuana Río Dulce)
 *  - tikal-futura (Grand Tikal Futura)
 *  - inde (INDE Guatemala)
 *  - hyundai (Hyundai Comerciales)
 *  - coastal-debt (Coastal Debt USA)
 *  - bbdo (BBDO Guatemala)
 */

const uiLabels = {
  es: {
    'nav.works': 'Proyectos',
    'nav.services': 'Servicios',
    'nav.studio': 'El Estudio',
    'nav.contact': 'Contacto',
    'case.backToWorks': 'Volver a Proyectos',
    'case.metaOfficeLabel': 'Estudio',
    'case.metaClientLabel': 'Cliente',
    'case.metaServiceLabel': 'Especialidad',
    'case.metaYearLabel': 'Año',
    'case.accChallenge': 'El Reto (Challenge)',
    'case.accInspiration': 'Inspiración (Inspiration)',
    'case.accIdea': 'La Solución (Idea)',
    'case.accGrowth': 'Impacto (Growth)',
    'case.keepReading': 'Seguir explorando',
    'footer.box1': 'Chatear por WhatsApp',
    'footer.box2': 'Guatemala • Houston, Texas',
    'footer.box3': 'Iniciar Proyecto • studio.up.gt',
    'footer.bigTitle': 'Es ahora que<br>todo comienza',
    'footer.scriptAccent': 'con nosotros',
    'footer.ctaBtn': 'Iniciar un proyecto',
    'footer.col1Title': 'Estudio',
    'footer.col2Title': 'Servicios & Soluciones',
    'footer.rights': 'TODOS LOS DERECHOS RESERVADOS',
    'services.f1': 'Desarrollo Web a Medida',
    'services.f2': 'Diseño UI/UX & Branding',
    'services.f3': 'E-Commerce & Pagos',
    'services.f4': 'Optimización & Velocidad',
    'services.f5': 'Automatizaciones & IA',
    'floating.whatsappTooltip': '¿Hablamos por WhatsApp?'
  },
  en: {
    'nav.works': 'Work',
    'nav.services': 'Services',
    'nav.studio': 'The Studio',
    'nav.contact': 'Contact',
    'case.backToWorks': 'Back to Work',
    'case.metaOfficeLabel': 'Office',
    'case.metaClientLabel': 'Client',
    'case.metaServiceLabel': 'Discipline',
    'case.metaYearLabel': 'Year',
    'case.accChallenge': 'Challenge',
    'case.accInspiration': 'Inspiration',
    'case.accIdea': 'Idea',
    'case.accGrowth': 'Growth',
    'case.keepReading': 'Keep reading',
    'footer.box1': 'Chat on WhatsApp',
    'footer.box2': 'Guatemala • Houston, Texas',
    'footer.box3': 'Start a Project • studio.up.gt',
    'footer.bigTitle': 'Now is when<br>everything begins',
    'footer.scriptAccent': 'with us',
    'footer.ctaBtn': 'Start a project',
    'footer.col1Title': 'Studio',
    'footer.col2Title': 'Services & Solutions',
    'footer.rights': 'ALL RIGHTS RESERVED',
    'services.f1': 'Custom Web Development',
    'services.f2': 'UI/UX Design & Branding',
    'services.f3': 'E-Commerce & Payments',
    'services.f4': 'Speed & Optimization',
    'services.f5': 'AI & Automations',
    'floating.whatsappTooltip': 'Chat with us on WhatsApp'
  }
};

const projectsCatalog = {
  'nanajuana': {
    id: 'nanajuana',
    bandBg: '#C87D55',      // Warm Terracotta / Sunset Bronze like VML screenshot
    bandText: '#14110F',
    accentColor: '#C87D55',
    coverGradient: 'radial-gradient(circle at 20% 30%, #EB5F69 0%, transparent 55%), radial-gradient(circle at 80% 35%, #BC80BB 0%, transparent 55%), linear-gradient(135deg, #1E1324 0%, #3E2137 50%, #162436 100%)',
    icon: 'fa-anchor',
    badgeTitle: 'NANAJUANA RÍO DULCE',
    badgeSub: 'LUXURY MARINA & ECO-RESORT',
    year: '2025 — 2026',
    related: ['tikal-futura', 'inde'],
    es: {
      kicker: 'Nanajuana × UP Group Studio — Marina & Resort Experience',
      headline: 'Experiencia digital inmersiva y reservas directas que transformaron el destino náutico más exclusivo de Guatemala',
      office: 'Guatemala',
      client: 'Hotel & Marina Nanajuana',
      service: 'UI/UX, Desarrollo Web & Booking Engine',
      lead: 'Para posicionar a Nanajuana Río Dulce como el resort y marina líder del Caribe guatemalteco, creamos una plataforma digital sensorial que combina dirección de arte tropical, velocidad de carga instantánea y un motor de reservación directa pensado para viajeros nacionales e internacionales.',
      videoCaption: 'Recorrido interactivo: Experiencia de Reserva & Marina (01:24)',
      challenge: 'El sitio anterior dependía excesivamente de agencias externas (OTAs) con altas comisiones y no transmitía la majestuosidad natural de Río Dulce, su marina privada para yates ni sus experiencias gastronómicas y ecológicas.',
      inspiration: 'Nos inspiramos en la bruma matutina del cañón de Río Dulce, las texturas orgánicas del agua y la arquitectura cálida del hotel para diseñar una interfaz editorial limpia donde la fotografía y el video respiran sin saturar al usuario.',
      idea: 'Desarrollamos una arquitectura web a medida con buscador de disponibilidad en tiempo real flotante, catálogo interactivo de habitaciones, mapa de amenidades náuticas y conexión directa con WhatsApp Concierge para reservas de grupos y eventos.',
      growth: 'En los primeros 90 días tras el lanzamiento, el canal directo web incrementó sus conversiones en un +185%, reduciendo la dependencia de intermediarios y logrando una puntuación de 98/100 en Google PageSpeed.',
      metrics: [
        [
          { value: '+185%', label: 'Incremento en reservas directas' },
          { value: '98/100', label: 'Google PageSpeed Performance' },
          { value: '1.1s', label: 'Tiempo de carga inicial (LCP)' }
        ],
        [
          { value: '+64%', label: 'Tiempo de permanencia en móvil' },
          { value: '-42%', label: 'Tasa de rebote en campañas' },
          { value: '3.4x', label: 'Leads para eventos y bodas' }
        ]
      ],
      slides: [
        { title: 'AWAKEN YOUR PARADISE', sub: 'Hero cinemático con buscador de reservas integrado y disponibilidad en tiempo real', tag: '01 / DESKTOP HERO & BOOKING', theme: 'sunset' },
        { title: 'SUITES & MARINA SLIPS', sub: 'Comparador visual de habitaciones, villas y amarres de yates con galería inmersiva', tag: '02 / ROOMS & YACHT MARINA', theme: 'ocean' },
        { title: 'MOBILE-FIRST CONCIERGE', sub: 'Flujo de reserva en 3 pasos optimizado para viajeros desde iOS y Android', tag: '03 / MOBILE UX FLOW', theme: 'lilac' },
        { title: 'GASTRONOMÍA & EXPEDICIONES', sub: 'Guía interactiva de tours por el Castillo de San Felipe, Livingston y el cañón', tag: '04 / EXPERIENCES & DINING', theme: 'emerald' }
      ],
      cardSummary: 'Experiencia digital inmersiva y reservas directas para el destino náutico más exclusivo de Guatemala.'
    },
    en: {
      kicker: 'Nanajuana × UP Group Studio — Marina & Resort Experience',
      headline: 'Immersive digital experience and direct booking engine that transformed Guatemala’s premier nautical destination',
      office: 'Guatemala',
      client: 'Nanajuana Hotel & Marina',
      service: 'UI/UX, Custom Web & Booking Engine',
      lead: 'To position Nanajuana Río Dulce as the leading resort and yacht marina in the Guatemalan Caribbean, we crafted a sensory digital platform combining tropical art direction, instant page loads, and a frictionless direct booking engine.',
      videoCaption: 'Interactive Walkthrough: Booking & Marina Experience (01:24)',
      challenge: 'The legacy website relied heavily on third-party OTAs charging steep commissions and failed to capture the natural majesty of Río Dulce, its private yacht marina, and its curated eco-luxury experiences.',
      inspiration: 'Inspired by the morning mist of the Río Dulce canyon, organic water textures, and warm resort architecture, we designed a clean editorial interface where photography and video breathe effortlessly.',
      idea: 'We engineered a bespoke web platform featuring a floating real-time availability engine, an interactive suite & marina slip showcase, and a direct WhatsApp Concierge integration for weddings and corporate retreats.',
      growth: 'Within the first 90 days post-launch, direct online bookings surged by +185%, significantly reducing OTA commission costs while achieving a 98/100 Google PageSpeed score.',
      metrics: [
        [
          { value: '+185%', label: 'Direct online booking growth' },
          { value: '98/100', label: 'Google PageSpeed Performance' },
          { value: '1.1s', label: 'Largest Contentful Paint (LCP)' }
        ],
        [
          { value: '+64%', label: 'Mobile session duration' },
          { value: '-42%', label: 'Paid campaign bounce rate' },
          { value: '3.4x', label: 'Wedding & corporate event leads' }
        ]
      ],
      slides: [
        { title: 'AWAKEN YOUR PARADISE', sub: 'Cinematic hero with integrated real-time booking engine and instant availability', tag: '01 / DESKTOP HERO & BOOKING', theme: 'sunset' },
        { title: 'SUITES & MARINA SLIPS', sub: 'Visual room, villa, and yacht slip comparator with immersive high-res gallery', tag: '02 / ROOMS & YACHT MARINA', theme: 'ocean' },
        { title: 'MOBILE-FIRST CONCIERGE', sub: '3-step mobile booking flow engineered for travelers on iOS and Android', tag: '03 / MOBILE UX FLOW', theme: 'lilac' },
        { title: 'DINING & EXPEDITIONS', sub: 'Interactive guide to Río Dulce canyon tours, Livingston, and fine dining', tag: '04 / EXPERIENCES & DINING', theme: 'emerald' }
      ],
      cardSummary: 'Immersive digital experience and direct booking engine for Guatemala’s premier nautical resort.'
    }
  },

  'tikal-futura': {
    id: 'tikal-futura',
    bandBg: '#5B8EC0',
    bandText: '#09131E',
    accentColor: '#4A7FB3',
    coverGradient: 'radial-gradient(circle at 75% 25%, #669ACA 0%, transparent 55%), radial-gradient(circle at 20% 70%, #F4A261 0%, transparent 55%), linear-gradient(135deg, #0B1528 0%, #1B3556 55%, #0F172A 100%)',
    icon: 'fa-gem',
    badgeTitle: 'GRAND TIKAL FUTURA',
    badgeSub: 'HOTEL & CONVENTION CENTER',
    year: '2025',
    related: ['inde', 'hyundai'],
    es: {
      kicker: 'Grand Tikal Futura × UP Group Studio — Corporate & Conventions',
      headline: 'Renovación digital integral para el complejo hotelero y centro de convenciones más icónico de Guatemala',
      office: 'Guatemala',
      client: 'Grand Tikal Futura Hotel',
      service: 'Arquitectura Web, UI/UX & Portal B2B',
      lead: 'Transformamos el ecosistema digital de Grand Tikal Futura para atender simultáneamente a dos audiencias clave: viajeros ejecutivos internacionales y organizadores de grandes congresos, exposiciones y eventos corporativos en Centroamérica.',
      videoCaption: 'Recorrido interactivo: Cotizador de Salones & Habitaciones (01:40)',
      challenge: 'Unificar bajo una misma experiencia digital la oferta hotelera de 5 estrellas y las especificaciones técnicas de más de 15 salones de convenciones y el centro de exposiciones Expocenter.',
      inspiration: 'La geometría monumental de la arquitectura maya contemporánea del edificio sirvió como base para un sistema de grillas modulares, tipografía audaz y navegación ultra clara.',
      idea: 'Creamos un configurador interactivo de salones (capacidad en montaje auditorio, banquete, escuela y coctel) conectado directamente al equipo comercial B2B, junto con una experiencia de reserva hotelera bilingüe.',
      growth: 'Las solicitudes de cotización para congresos y eventos corporativos aumentaron un +140%, reduciendo el ciclo de respuesta comercial de días a minutos.',
      metrics: [
        [
          { value: '+140%', label: 'Cotizaciones de eventos B2B' },
          { value: '15+', label: 'Salones interactivos mapeados' },
          { value: '96/100', label: 'Rendimiento Core Web Vitals' }
        ],
        [
          { value: '2.8x', label: 'Tráfico orgánico internacional' },
          { value: '0.9s', label: 'Respuesta del servidor (TTFB)' },
          { value: '+78%', label: 'Conversión en dispositivos móviles' }
        ]
      ],
      slides: [
        { title: 'ICONIC HOSPITALITY', sub: 'Portada arquitectónica con acceso dual para Huéspedes y Organizadores de Eventos', tag: '01 / DUAL AUDIENCE HERO', theme: 'ocean' },
        { title: 'EXPOCENTER PLANNER', sub: 'Visualizador interactivo de capacidades, planos y montajes para congresos', tag: '02 / CONVENTION CONFIGURATOR', theme: 'sunset' },
        { title: 'EXECUTIVE SUITES', sub: 'Presentación editorial de habitaciones ejecutivas, spa y alta gastronomía', tag: '03 / LUXURY ACCOMMODATIONS', theme: 'lilac' },
        { title: 'INSTANT RFP FUNNEL', sub: 'Formulario inteligente conectado a CRM y WhatsApp para cotización de salones', tag: '04 / B2B LEAD ENGINE', theme: 'emerald' }
      ],
      cardSummary: 'Renovación integral del centro de convenciones y complejo hotelero más icónico de Guatemala.'
    },
    en: {
      kicker: 'Grand Tikal Futura × UP Group Studio — Corporate & Conventions',
      headline: 'Comprehensive digital transformation for Guatemala’s most iconic hotel and convention complex',
      office: 'Guatemala',
      client: 'Grand Tikal Futura Hotel',
      service: 'Web Architecture, UI/UX & B2B Portal',
      lead: 'We reimagined Grand Tikal Futura’s digital ecosystem to seamlessly serve two distinct audiences: international business travelers and global event planners organizing large-scale conventions across Central America.',
      videoCaption: 'Interactive Walkthrough: Venue Planner & Suite Booking (01:40)',
      challenge: 'Unifying a 5-star hotel booking experience with detailed technical specifications for over 15 convention halls and the massive Expocenter exhibition complex.',
      inspiration: 'The monumental contemporary Mayan geometry of the landmark building inspired a modular grid system, bold typography, and effortless navigation.',
      idea: 'We built an interactive venue capacity planner (theater, banquet, classroom, and cocktail layouts) wired directly to the B2B sales team alongside a bilingual guest booking flow.',
      growth: 'Corporate event RFP inquiries increased by +140%, cutting commercial response times from days to minutes.',
      metrics: [
        [
          { value: '+140%', label: 'B2B convention RFP inquiries' },
          { value: '15+', label: 'Interactive venue halls mapped' },
          { value: '96/100', label: 'Core Web Vitals score' }
        ],
        [
          { value: '2.8x', label: 'International organic traffic' },
          { value: '0.9s', label: 'Server response time (TTFB)' },
          { value: '+78%', label: 'Mobile booking conversion' }
        ]
      ],
      slides: [
        { title: 'ICONIC HOSPITALITY', sub: 'Architectural hero with dual pathways for Hotel Guests and Event Planners', tag: '01 / DUAL AUDIENCE HERO', theme: 'ocean' },
        { title: 'EXPOCENTER PLANNER', sub: 'Interactive capacity, floorplan, and layout visualizer for major conventions', tag: '02 / CONVENTION CONFIGURATOR', theme: 'sunset' },
        { title: 'EXECUTIVE SUITES', sub: 'Editorial showcase of executive suites, wellness spa, and fine dining', tag: '03 / LUXURY ACCOMMODATIONS', theme: 'lilac' },
        { title: 'INSTANT RFP FUNNEL', sub: 'Smart RFP funnel connected to CRM and WhatsApp for rapid venue quoting', tag: '04 / B2B LEAD ENGINE', theme: 'emerald' }
      ],
      cardSummary: 'Full digital overhaul for Guatemala’s most iconic hotel and convention complex.'
    }
  },

  'inde': {
    id: 'inde',
    bandBg: '#DF525C',
    bandText: '#FFFFFF',
    accentColor: '#DF525C',
    coverGradient: 'radial-gradient(circle at 25% 25%, #EB5F69 0%, transparent 55%), radial-gradient(circle at 80% 70%, #FBBF24 0%, transparent 55%), linear-gradient(135deg, #180A0D 0%, #3B1219 50%, #0D131A 100%)',
    icon: 'fa-bolt-lightning',
    badgeTitle: 'INDE GUATEMALA',
    badgeSub: 'NATIONAL ELECTRIFICATION INSTITUTE',
    year: '2025',
    related: ['nanajuana', 'coastal-debt'],
    es: {
      kicker: 'INDE × UP Group Studio — Plataforma Institucional & Energía',
      headline: 'Arquitectura de alto tráfico, transparencia de datos y accesibilidad ciudadana para la matriz energética nacional',
      office: 'Guatemala',
      client: 'INDE Guatemala',
      service: 'Desarrollo Web a Medida, UI/UX & Seguridad',
      lead: 'Rediseñamos y blindamos la plataforma digital del Instituto Nacional de Electrificación (INDE), facilitando el acceso ciudadano a información de generación limpia, licitaciones públicas, tarifa social y proyectos hidroeléctricos.',
      videoCaption: 'Recorrido interactivo: Portal Ciudadano & Matriz Energética (01:30)',
      challenge: 'Organizar miles de documentos técnicos, estadísticas de generación energética e información de transparencia institucional en una interfaz veloz, segura y fácil de consultar desde cualquier dispositivo del país.',
      inspiration: 'El flujo de la energía hidroeléctrica y solar de Guatemala inspiró una interfaz dinámica, luminosa y estructurada con buscadores instantáneos y visualización de datos.',
      idea: 'Implementamos una arquitectura desacoplada de alto rendimiento con caché distribuido, buscador predictivo de normativas y licitaciones, y tableros visuales del aporte de energía renovable al país.',
      growth: 'El portal soporta picos masivos de tráfico simultáneo con 99.99% de disponibilidad, reduciendo el tiempo de búsqueda de documentos públicos en un 70%.',
      metrics: [
        [
          { value: '99.99%', label: 'Uptime y alta disponibilidad' },
          { value: '-70%', label: 'Tiempo para hallar información' },
          { value: 'AA+', label: 'Estándar de accesibilidad web' }
        ],
        [
          { value: '450K+', label: 'Consultas ciudadanas mensuales' },
          { value: '97/100', label: 'Seguridad y performance técnico' },
          { value: '100%', label: 'Adaptado a conectividad móvil' }
        ]
      ],
      slides: [
        { title: 'CLEAN ENERGY MATRIX', sub: 'Visualización en tiempo real del impacto hidroeléctrico y solar en Guatemala', tag: '01 / ENERGY DATA DASHBOARD', theme: 'sunset' },
        { title: 'CITIZEN TRANSPARENCY', sub: 'Buscador instantáneo de licitaciones, tarifa social y memoria de labores', tag: '02 / PUBLIC TRANSPARENCY HUB', theme: 'ocean' },
        { title: 'HIGH-SECURITY ARCHITECTURE', sub: 'Infraestructura blindada contra ataques DDoS y optimizada para carga ultrarrápida', tag: '03 / CLOUD SECURITY', theme: 'emerald' },
        { title: 'UNIVERSAL ACCESSIBILITY', sub: 'Diseño inclusivo con alto contraste y navegación asistida para todo el país', tag: '04 / AA+ ACCESSIBILITY', theme: 'lilac' }
      ],
      cardSummary: 'Plataforma de alto tráfico con visualización energética nacional, estándares de accesibilidad y ciberseguridad.'
    },
    en: {
      kicker: 'INDE × UP Group Studio — Institutional Platform & Energy',
      headline: 'High-traffic web architecture, open data transparency, and universal accessibility for Guatemala’s national energy grid',
      office: 'Guatemala',
      client: 'INDE Guatemala',
      service: 'Custom Web Dev, UI/UX & Cybersecurity',
      lead: 'We redesigned and hardened the digital platform for the National Electrification Institute (INDE), streamlining citizen access to clean energy data, public tenders, social tariffs, and hydroelectric projects.',
      videoCaption: 'Interactive Walkthrough: Citizen Portal & Energy Matrix (01:30)',
      challenge: 'Structuring thousands of technical documents, energy generation statistics, and institutional transparency records into a fast, secure interface accessible across all mobile networks.',
      inspiration: 'Guatemala’s hydroelectric and solar energy flows inspired a clean, structured interface featuring instant search and interactive data visualizations.',
      idea: 'We deployed a high-availability architecture with edge caching, predictive document search, and interactive dashboards showcasing renewable energy contributions.',
      growth: 'The platform handles massive concurrent traffic spikes with 99.99% uptime while cutting document discovery time by 70%.',
      metrics: [
        [
          { value: '99.99%', label: 'High-availability uptime' },
          { value: '-70%', label: 'Document search time reduction' },
          { value: 'AA+', label: 'Web accessibility compliance' }
        ],
        [
          { value: '450K+', label: 'Monthly citizen sessions' },
          { value: '97/100', label: 'Security & performance score' },
          { value: '100%', label: 'Optimized for 3G/4G/5G mobile' }
        ]
      ],
      slides: [
        { title: 'CLEAN ENERGY MATRIX', sub: 'Interactive visualization of hydroelectric and solar impact across Guatemala', tag: '01 / ENERGY DATA DASHBOARD', theme: 'sunset' },
        { title: 'CITIZEN TRANSPARENCY', sub: 'Instant search engine for public tenders, social tariffs, and annual reports', tag: '02 / PUBLIC TRANSPARENCY HUB', theme: 'ocean' },
        { title: 'HIGH-SECURITY ARCHITECTURE', sub: 'DDoS-hardened infrastructure engineered for sub-second page loads', tag: '03 / CLOUD SECURITY', theme: 'emerald' },
        { title: 'UNIVERSAL ACCESSIBILITY', sub: 'Inclusive high-contrast UI with full keyboard and screen-reader support', tag: '04 / AA+ ACCESSIBILITY', theme: 'lilac' }
      ],
      cardSummary: 'High-traffic national energy platform engineered with strict accessibility and cybersecurity standards.'
    }
  },

  'hyundai': {
    id: 'hyundai',
    bandBg: '#8C6FD1',
    bandText: '#FFFFFF',
    accentColor: '#8C6FD1',
    coverGradient: 'radial-gradient(circle at 75% 30%, #9B7EDE 0%, transparent 55%), radial-gradient(circle at 25% 75%, #669ACA 0%, transparent 55%), linear-gradient(135deg, #0D0B18 0%, #231B42 55%, #0F172A 100%)',
    icon: 'fa-truck-fast',
    badgeTitle: 'HYUNDAI COMERCIALES',
    badgeSub: 'TRUCKS, BUSES & FLEET SOLUTIONS',
    year: '2024 — 2025',
    related: ['coastal-debt', 'bbdo'],
    es: {
      kicker: 'Hyundai × UP Group Studio — Catálogo B2B & Lead Generation',
      headline: 'Catálogo interactivo de camiones y flotillas con cotizador en tiempo real que aceleró las ventas B2B',
      office: 'Guatemala',
      client: 'Hyundai Vehículos Comerciales',
      service: 'Desarrollo Web, UI/UX & Automatización CRM',
      lead: 'Diseñamos la plataforma digital comercial para la división de camiones, microbuses y autobuses de Hyundai, convirtiendo fichas técnicas complejas en una herramienta de ventas B2B ágil y conectada con asesores de flotillas.',
      videoCaption: 'Recorrido interactivo: Configurador de Flotillas B2B (01:18)',
      challenge: 'Los compradores corporativos necesitaban comparar capacidades de carga, motorizaciones y chasis de forma rápida antes de solicitar una cotización formal de flotilla.',
      inspiration: 'La ingeniería de precisión automotriz de Hyundai inspiró una interfaz robusta, limpia y orientada a la conversión en pocos clics.',
      idea: 'Construimos un catálogo filtrable por tonelaje y giro de negocio, con comparador de modelos, descarga instantánea de fichas técnicas y enrutamiento automático de leads a WhatsApp y CRM.',
      growth: 'Incremento del +210% en leads calificados de flotillas empresariales durante el primer semestre de operación.',
      metrics: [
        [
          { value: '+210%', label: 'Leads calificados de flotillas' },
          { value: '45s', label: 'Tiempo promedio para cotizar' },
          { value: '96/100', label: 'Google PageSpeed Score' }
        ],
        [
          { value: '100%', label: 'Integración automática a CRM' },
          { value: '+88%', label: 'Descargas de fichas técnicas' },
          { value: '2.9x', label: 'Retorno en campañas de búsqueda' }
        ]
      ],
      slides: [
        { title: 'BUILT FOR HEAVY DUTY', sub: 'Showcase de línea pesada y utilitaria con filtros por capacidad de carga', tag: '01 / FLEET CATALOG', theme: 'lilac' },
        { title: 'MODEL COMPARATOR', sub: 'Comparativa lado a lado de torque, dimensiones y rendimiento de combustible', tag: '02 / TECH SPECS ENGINE', theme: 'ocean' },
        { title: 'INSTANT FLEET QUOTE', sub: 'Cotizador B2B por volumen conectado en tiempo real con ejecutivos de ventas', tag: '03 / B2B QUOTE FLOW', theme: 'sunset' },
        { title: 'AFTER-SALES & PARTS', sub: 'Agendamiento de talleres certificados y repuestos originales para flotillas', tag: '04 / SERVICE NETWORK', theme: 'emerald' }
      ],
      cardSummary: 'Catálogo interactivo y cotizador en tiempo real para la línea de camiones y autobuses Hyundai.'
    },
    en: {
      kicker: 'Hyundai × UP Group Studio — B2B Catalog & Lead Generation',
      headline: 'Interactive truck and fleet catalog with real-time quoting that accelerated commercial B2B sales',
      office: 'Guatemala',
      client: 'Hyundai Commercial Vehicles',
      service: 'Web Development, UI/UX & CRM Automation',
      lead: 'We built the digital sales platform for Hyundai’s commercial truck, van, and bus division, transforming complex technical spec sheets into a high-converting B2B fleet quoting engine.',
      videoCaption: 'Interactive Walkthrough: B2B Fleet Configurator (01:18)',
      challenge: 'Corporate fleet buyers needed a fast way to compare payload capacities, engine specs, and chassis configurations before requesting a commercial quote.',
      inspiration: 'Hyundai’s automotive precision inspired a clean, rugged interface engineered to convert fleet managers in just a few clicks.',
      idea: 'We created an interactive catalog filterable by payload and industry, complete with a side-by-side model comparator, instant PDF spec sheets, and automated CRM/WhatsApp lead routing.',
      growth: 'Qualified corporate fleet leads grew by +210% within the first six months of launch.',
      metrics: [
        [
          { value: '+210%', label: 'Qualified B2B fleet leads' },
          { value: '45s', label: 'Average time to request a quote' },
          { value: '96/100', label: 'Google PageSpeed Score' }
        ],
        [
          { value: '100%', label: 'Automated CRM lead routing' },
          { value: '+88%', label: 'Technical spec sheet downloads' },
          { value: '2.9x', label: 'Search campaign ROAS' }
        ]
      ],
      slides: [
        { title: 'BUILT FOR HEAVY DUTY', sub: 'Commercial lineup showcase with instant payload and industry filters', tag: '01 / FLEET CATALOG', theme: 'lilac' },
        { title: 'MODEL COMPARATOR', sub: 'Side-by-side comparison of torque, dimensions, and fuel efficiency', tag: '02 / TECH SPECS ENGINE', theme: 'ocean' },
        { title: 'INSTANT FLEET QUOTE', sub: 'Volume B2B quoting funnel wired directly to fleet sales executives', tag: '03 / B2B QUOTE FLOW', theme: 'sunset' },
        { title: 'AFTER-SALES & PARTS', sub: 'Certified service booking and genuine parts portal for commercial fleets', tag: '04 / SERVICE NETWORK', theme: 'emerald' }
      ],
      cardSummary: 'Interactive vehicle catalog and real-time fleet quoting system for Hyundai Commercial Vehicles.'
    }
  },

  'coastal-debt': {
    id: 'coastal-debt',
    bandBg: '#6CA689',
    bandText: '#081810',
    accentColor: '#4E8F6E',
    coverGradient: 'radial-gradient(circle at 25% 30%, #8CC099 0%, transparent 55%), radial-gradient(circle at 75% 65%, #669ACA 0%, transparent 55%), linear-gradient(135deg, #071A14 0%, #12352B 55%, #0B1622 100%)',
    icon: 'fa-chart-line',
    badgeTitle: 'COASTAL DEBT RESOLVE',
    badgeSub: 'US FINTECH & BUSINESS RELIEF',
    year: '2025',
    related: ['bbdo', 'nanajuana'],
    es: {
      kicker: 'Coastal Debt (USA) × UP Group Studio — US Fintech Platform',
      headline: 'Plataforma financiera de alto rendimiento y calculadoras interactivas para el mercado empresarial de Estados Unidos',
      office: 'Houston, TX & Guatemala',
      client: 'Coastal Debt Resolve (USA)',
      service: 'Desarrollo Web, Optimización & Calculadoras UI',
      lead: 'Colaboramos con Coastal Debt en Estados Unidos para diseñar y optimizar una plataforma fintech enfocada en reestructuración financiera empresarial (MCA Debt Relief), priorizando confianza, velocidad extrema y conversión de leads.',
      videoCaption: 'Recorrido interactivo: Calculadora de Alivio Financiero (01:12)',
      challenge: 'En el competitivo mercado financiero de EE.UU., cada milisegundo de carga impacta directamente el costo por adquisición (CPA) en campañas de Google Ads y Meta.',
      inspiration: 'Combinamos la claridad de las grandes plataformas fintech norteamericanas con herramientas interactivas que entregan valor inmediato al empresario.',
      idea: 'Desarrollamos calculadoras interactivas de ahorro mensual, embudos multistep sin recarga de página y una optimización profunda de Core Web Vitals.',
      growth: 'Logramos un puntaje de 99/100 en rendimiento web y un aumento del +68% en la tasa de conversión de formularios financieros en EE.UU.',
      metrics: [
        [
          { value: '+68%', label: 'Tasa de conversión en EE.UU.' },
          { value: '99/100', label: 'Google PageSpeed Performance' },
          { value: '-34%', label: 'Reducción en Costo por Lead (CPL)' }
        ],
        [
          { value: '0.8s', label: 'First Contentful Paint (FCP)' },
          { value: '15K+', label: 'Simulaciones mensuales en calculadora' },
          { value: '100%', label: 'Integración con HubSpot / Salesforce' }
        ]
      ],
      slides: [
        { title: 'FINANCIAL CLARITY', sub: 'Landing de alta conversión diseñada para dueños de negocios en Estados Unidos', tag: '01 / US FINTECH HERO', theme: 'emerald' },
        { title: 'DEBT RELIEF CALCULATOR', sub: 'Simulador interactivo en tiempo real de reducción de pagos semanales y mensuales', tag: '02 / INTERACTIVE CALCULATOR', theme: 'ocean' },
        { title: 'MULTI-STEP QUALIFIER', sub: 'Embudo progresivo de pre-calificación conectado instantáneamente al equipo en Florida/Texas', tag: '03 / LEAD QUALIFICATION', theme: 'sunset' },
        { title: 'SUB-SECOND PERFORMANCE', sub: 'Código limpio y ligero optimizado para maximizar el ROI de campañas PPC', tag: '04 / SPEED OPTIMIZATION', theme: 'lilac' }
      ],
      cardSummary: 'Plataforma financiera para el mercado de EE.UU. con calculadoras interactivas y conversión de alto rendimiento.'
    },
    en: {
      kicker: 'Coastal Debt (USA) × UP Group Studio — US Fintech Platform',
      headline: 'High-converting financial relief platform and interactive calculators engineered for the US business market',
      office: 'Houston, TX & Guatemala',
      client: 'Coastal Debt Resolve (USA)',
      service: 'Custom Web Dev, Speed Optimization & Fintech UI',
      lead: 'We partnered with Coastal Debt in the United States to design and optimize a high-performing fintech platform focused on business debt restructuring, prioritizing trust, sub-second speed, and lead conversion.',
      videoCaption: 'Interactive Walkthrough: Business Relief Calculator (01:12)',
      challenge: 'In the ultra-competitive US fintech space, every millisecond of page load directly impacts Cost Per Acquisition (CPA) across paid search and social campaigns.',
      inspiration: 'We blended modern American fintech clarity with interactive self-service calculators that deliver immediate value to business owners.',
      idea: 'We engineered real-time savings calculators, zero-reload multi-step qualification funnels, and deep Core Web Vitals optimizations.',
      growth: 'Achieved a 99/100 performance score and a +68% lift in qualified US business lead conversions.',
      metrics: [
        [
          { value: '+68%', label: 'US lead conversion rate lift' },
          { value: '99/100', label: 'Google PageSpeed Performance' },
          { value: '-34%', label: 'Reduction in Cost Per Lead (CPL)' }
        ],
        [
          { value: '0.8s', label: 'First Contentful Paint (FCP)' },
          { value: '15K+', label: 'Monthly calculator simulations' },
          { value: '100%', label: 'Real-time CRM integration' }
        ]
      ],
      slides: [
        { title: 'FINANCIAL CLARITY', sub: 'High-trust landing experience tailored for US small and medium business owners', tag: '01 / US FINTECH HERO', theme: 'emerald' },
        { title: 'DEBT RELIEF CALCULATOR', sub: 'Real-time interactive simulator estimating weekly and monthly cash-flow savings', tag: '02 / INTERACTIVE CALCULATOR', theme: 'ocean' },
        { title: 'MULTI-STEP QUALIFIER', sub: 'Frictionless pre-qualification funnel wired directly to US debt specialists', tag: '03 / LEAD QUALIFICATION', theme: 'sunset' },
        { title: 'SUB-SECOND PERFORMANCE', sub: 'Lean, custom-engineered frontend built to maximize paid media ROAS', tag: '04 / SPEED OPTIMIZATION', theme: 'lilac' }
      ],
      cardSummary: 'High-converting US financial relief platform featuring interactive calculators and 98+ PageSpeed.'
    }
  },

  'bbdo': {
    id: 'bbdo',
    bandBg: '#E7924E',
    bandText: '#140D06',
    accentColor: '#D97B29',
    coverGradient: 'radial-gradient(circle at 30% 25%, #F4A261 0%, transparent 55%), radial-gradient(circle at 75% 70%, #EB5F69 0%, transparent 55%), linear-gradient(135deg, #1A1008 0%, #3D2010 55%, #121216 100%)',
    icon: 'fa-award',
    badgeTitle: 'BBDO GUATEMALA',
    badgeSub: 'CREATIVE AGENCY NETWORK',
    year: '2024 — 2025',
    related: ['nanajuana', 'tikal-futura'],
    es: {
      kicker: 'BBDO × UP Group Studio — Creative Showcase & Video Portfolio',
      headline: 'Showcase editorial y portafolio audiovisual de reproducción instantánea para la red creativa más premiada',
      office: 'Guatemala',
      client: 'BBDO Guatemala',
      service: 'Diseño Editorial, Video Streaming & Web Dev',
      lead: 'Creamos el portafolio digital de BBDO Guatemala con una premisa clara: "The Work, The Work, The Work". Una plataforma donde los casos de éxito en video de alta definición cobran vida al instante sin tiempos de espera.',
      videoCaption: 'Recorrido interactivo: Reel & Casos Premiados (01:08)',
      challenge: 'Exhibir decenas de comerciales y casos de estudio en video de alta resolución sin sacrificar la velocidad de carga ni la fluidez en dispositivos móviles.',
      inspiration: 'La estética audaz de los festivales internacionales de creatividad (Cannes Lions, Effie Awards) combinada con transiciones suaves y tipografía expresiva.',
      idea: 'Implementamos reproducción de video adaptativa (lazy-streaming), pre-carga inteligente al pasar el cursor y páginas de caso dinámicas para destacar premios y métricas de efectividad.',
      growth: 'El sitio se convirtió en la carta de presentación regional de la agencia ante clientes globales y jurados de festivales creativos.',
      metrics: [
        [
          { value: '0.4s', label: 'Inicio de reproducción de video' },
          { value: '40+', label: 'Campañas regionales exhibidas' },
          { value: '97/100', label: 'Fluidez de interfaz y performance' }
        ],
        [
          { value: '3.2x', label: 'Visualizaciones completas de casos' },
          { value: '100%', label: 'Administrable por el equipo creativo' },
          { value: '+95%', label: 'Retención en el reel principal' }
        ]
      ],
      slides: [
        { title: 'THE WORK COMES FIRST', sub: 'Portada inmersiva con reel interactivo de campañas multipremiadas', tag: '01 / SHOWCASE REEL', theme: 'sunset' },
        { title: 'INSTANT VIDEO GRID', sub: 'Grilla editorial con previsualización en vivo al pasar el cursor', tag: '02 / INTERACTIVE WORK GRID', theme: 'lilac' },
        { title: 'AWARDS & EFFIE CASES', sub: 'Fichas de efectividad publicitaria con resultados medibles de negocio', tag: '03 / CASE STUDY LAYOUT', theme: 'ocean' },
        { title: 'CULTURE & TALENT', sub: 'Sección de liderazgo creativo, prensa y captación de talento regional', tag: '04 / AGENCY CULTURE', theme: 'emerald' }
      ],
      cardSummary: 'Showcase editorial multipremiado exhibiendo campañas regionales con fluidez y velocidad instantánea.'
    },
    en: {
      kicker: 'BBDO × UP Group Studio — Creative Showcase & Video Portfolio',
      headline: 'Editorial showcase and instant-play video portfolio for the region’s most awarded creative network',
      office: 'Guatemala',
      client: 'BBDO Guatemala',
      service: 'Editorial UI, Video Streaming & Web Dev',
      lead: 'We crafted BBDO Guatemala’s digital portfolio around a single mantra: "The Work, The Work, The Work"—an editorial stage where high-definition campaign films play instantaneously.',
      videoCaption: 'Interactive Walkthrough: Agency Reel & Awarded Cases (01:08)',
      challenge: 'Showcasing dozens of high-bitrate commercial films and case studies without compromising initial page load speed or mobile smoothness.',
      inspiration: 'The bold editorial aesthetic of global creativity festivals (Cannes Lions, Effie Awards) paired with fluid transitions and expressive typography.',
      idea: 'We engineered adaptive video lazy-streaming, hover-to-play previews, and dynamic case study templates highlighting awards and business effectiveness.',
      growth: 'The platform serves as the agency’s flagship regional credential for global brands and festival juries.',
      metrics: [
        [
          { value: '0.4s', label: 'Instant video playback start' },
          { value: '40+', label: 'Regional campaigns showcased' },
          { value: '97/100', label: 'UI smoothness & performance' }
        ],
        [
          { value: '3.2x', label: 'Full case study completion rate' },
          { value: '100%', label: 'Self-managed by creative team' },
          { value: '+95%', label: 'Main agency reel retention' }
        ]
      ],
      slides: [
        { title: 'THE WORK COMES FIRST', sub: 'Immersive cover stage featuring an interactive reel of award-winning campaigns', tag: '01 / SHOWCASE REEL', theme: 'sunset' },
        { title: 'INSTANT VIDEO GRID', sub: 'Editorial campaign grid with zero-lag hover video previews', tag: '02 / INTERACTIVE WORK GRID', theme: 'lilac' },
        { title: 'AWARDS & EFFIE CASES', sub: 'Effectiveness case studies highlighting measurable brand growth', tag: '03 / CASE STUDY LAYOUT', theme: 'ocean' },
        { title: 'CULTURE & TALENT', sub: 'Creative leadership spotlight, press hub, and regional talent portal', tag: '04 / AGENCY CULTURE', theme: 'emerald' }
      ],
      cardSummary: 'Award-winning editorial showcase presenting regional campaigns with instant video playback.'
    }
  }
};

let currentLang = 'es';
let currentProjectId = 'nanajuana';
let currentMetricsPage = 0;
let currentGalleryIndex = 0;

function getProjectFromUrl() {
  const params = new URLSearchParams(window.location.search);
  const id = params.get('id');
  return (id && projectsCatalog[id]) ? id : 'nanajuana';
}

function buildCoverArtworkHTML(project, copy) {
  return `
    <div class="cover-stage-art" style="background: ${project.coverGradient};">
      <div class="cover-stage-art__bokeh"></div>
      <div class="container cover-stage-art__inner">
        <!-- Floating Multi-Device Showcase Composition (Inspired by VML Hero) -->
        <div class="cover-Floating-composition">
          <!-- Left Tilted Card -->
          <div class="cover-device cover-device--left">
            <div class="cover-device__bar"><span></span><span></span><span></span></div>
            <div class="cover-device__screen" style="background: linear-gradient(145deg, ${project.bandBg}, #111118);">
              <i class="fa-solid ${project.icon} cover-device__icon"></i>
              <strong>${project.badgeTitle}</strong>
              <small>${copy.service}</small>
            </div>
          </div>

          <!-- Center Main Flagship Display -->
          <div class="cover-device cover-device--center">
            <div class="cover-device__bar"><span></span><span></span><span></span><em>studio.up.gt / ${project.id}</em></div>
            <div class="cover-device__screen cover-device__screen--main">
              <span class="cover-chip">${project.badgeSub}</span>
              <h2>${project.badgeTitle}</h2>
              <p>${copy.slides[0].sub}</p>
              <div class="cover-mock-ui">
                <span class="cover-mock-pill" style="background:${project.bandBg}; color:${project.bandText};">98+ PageSpeed</span>
                <span class="cover-mock-pill">UI/UX Custom</span>
              </div>
            </div>
          </div>

          <!-- Right Tilted Mobile Device -->
          <div class="cover-device cover-device--right">
            <div class="cover-device__notch"></div>
            <div class="cover-device__screen" style="background: linear-gradient(165deg, #1F2937, ${project.bandBg});">
              <span class="cover-mobile-tag">MOBILE FIRST</span>
              <h4>${copy.metrics[0][0].value}</h4>
              <p>${copy.metrics[0][0].label}</p>
            </div>
          </div>
        </div>
      </div>
    </div>
  `;
}

function buildVideoPreviewHTML(project, copy) {
  return `
    <div class="video-mock-canvas" style="background: ${project.coverGradient};">
      <div class="video-mock-browser">
        <div class="video-mock-browser__top">
          <span class="dot-r"></span><span class="dot-y"></span><span class="dot-g"></span>
          <span class="video-mock-url">https://${project.id}.com — Designed by UP Group Studio</span>
        </div>
        <div class="video-mock-browser__body">
          <div class="video-mock-badge" style="background:${project.bandBg}; color:${project.bandText};">
            <i class="fa-solid ${project.icon}"></i> ${project.badgeTitle}
          </div>
          <h3>${copy.slides[0].title}</h3>
          <p>${copy.slides[0].sub}</p>
        </div>
      </div>
    </div>
  `;
}

function renderMetrics(project, copy) {
  const grid = document.getElementById('caseMetricsGrid');
  const countEl = document.getElementById('metricsPageCount');
  if (!grid || !countEl) return;

  const pages = copy.metrics;
  const set = pages[currentMetricsPage] || pages[0];

  grid.innerHTML = set.map((m) => `
    <div class="case-metric-card">
      <span class="case-metric-number" style="color: ${project.accentColor};">${m.value}</span>
      <span class="case-metric-label">${m.label}</span>
    </div>
  `).join('');

  countEl.textContent = `${currentMetricsPage + 1} / ${pages.length}`;
}

function renderGallerySlide(project, copy) {
  const viewport = document.getElementById('caseGalleryViewport');
  const captionEl = document.getElementById('caseGalleryCaption');
  const countEl = document.getElementById('galleryPageCount');
  if (!viewport || !captionEl || !countEl) return;

  const slides = copy.slides;
  const slide = slides[currentGalleryIndex] || slides[0];

  const themeGradients = {
    sunset: 'radial-gradient(circle at 20% 25%, #EB5F69 0%, transparent 50%), radial-gradient(circle at 80% 75%, #FBBF24 0%, transparent 55%), linear-gradient(135deg, #140D1B 0%, #2D162C 60%, #0F172A 100%)',
    ocean: 'radial-gradient(circle at 80% 25%, #669ACA 0%, transparent 55%), radial-gradient(circle at 20% 75%, #8CC099 0%, transparent 55%), linear-gradient(135deg, #091526 0%, #163252 60%, #0A0F1A 100%)',
    lilac: 'radial-gradient(circle at 25% 30%, #BC80BB 0%, transparent 55%), radial-gradient(circle at 75% 70%, #9B7EDE 0%, transparent 55%), linear-gradient(135deg, #160F24 0%, #2C1D47 60%, #0B0B12 100%)',
    emerald: 'radial-gradient(circle at 75% 25%, #8CC099 0%, transparent 55%), radial-gradient(circle at 25% 75%, #F4A261 0%, transparent 55%), linear-gradient(135deg, #081C15 0%, #183E30 60%, #0B1218 100%)'
  };

  const bg = themeGradients[slide.theme] || project.coverGradient;

  viewport.innerHTML = `
    <div class="gallery-slide-card" style="background: ${bg};">
      <div class="gallery-slide-card__inner">
        <span class="gallery-slide-tag">${slide.tag}</span>
        <h3 class="gallery-slide-headline">${slide.title}</h3>
        <p class="gallery-slide-sub">${slide.sub}</p>
        <div class="gallery-slide-mock">
          <div class="gallery-slide-mock__win">
            <i class="fa-solid ${project.icon}"></i>
            <span>${project.badgeTitle}</span>
          </div>
          <div class="gallery-slide-mock__stat" style="background: ${project.bandBg}; color: ${project.bandText};">
            <strong>${copy.metrics[0][0].value}</strong>
            <small>${copy.metrics[0][0].label}</small>
          </div>
        </div>
      </div>
    </div>
  `;

  captionEl.textContent = `${slide.tag} — ${slide.sub}`;
  countEl.textContent = `${currentGalleryIndex + 1} / ${slides.length}`;
}

function renderRelatedProjects(project) {
  const relatedGrid = document.getElementById('caseRelatedGrid');
  if (!relatedGrid) return;

  relatedGrid.innerHTML = project.related.map((relId) => {
    const rel = projectsCatalog[relId];
    if (!rel) return '';
    const relCopy = rel[currentLang];
    return `
      <article class="related-case-card">
        <a href="?id=${rel.id}" class="related-case-card__thumb" data-switch-project="${rel.id}" style="background: ${rel.coverGradient};">
          <div class="related-case-card__emblem">
            <i class="fa-solid ${rel.icon}"></i>
            <span>${rel.badgeTitle}</span>
            <small>${rel.badgeSub}</small>
          </div>
        </a>
        <h3 class="related-case-card__title">
          <a href="?id=${rel.id}" data-switch-project="${rel.id}">${relCopy.client}</a>
        </h3>
        <p class="related-case-card__desc">${relCopy.cardSummary}</p>
      </article>
    `;
  }).join('');

  // Bind smooth SPA switching on related cards
  relatedGrid.querySelectorAll('[data-switch-project]').forEach((link) => {
    link.addEventListener('click', (e) => {
      e.preventDefault();
      const targetId = link.getAttribute('data-switch-project');
      loadProject(targetId, true);
    });
  });
}

function loadProject(projectId, scrollTop = false) {
  if (!projectsCatalog[projectId]) projectId = 'nanajuana';
  currentProjectId = projectId;
  currentMetricsPage = 0;
  currentGalleryIndex = 0;

  const project = projectsCatalog[projectId];
  const copy = project[currentLang];

  // Update URL query string without reload
  const newUrl = `${window.location.pathname}?id=${projectId}`;
  window.history.replaceState({ projectId }, '', newUrl);

  // Page Title
  document.title = `${copy.client} — Caso de Estudio | UP Group Studio`;

  // Highlight active quick switcher pill
  document.querySelectorAll('.case-pill').forEach((pill) => {
    pill.classList.toggle('active', pill.getAttribute('data-project-id') === projectId);
  });

  // 1. Hero Cover Artwork
  const coverEl = document.getElementById('caseCoverArtwork');
  if (coverEl) coverEl.innerHTML = buildCoverArtworkHTML(project, copy);

  // 2. Colored Editorial Intro Band
  const introBand = document.getElementById('caseIntroBand');
  if (introBand) {
    introBand.style.backgroundColor = project.bandBg;
    introBand.style.color = project.bandText;
  }

  document.getElementById('caseKicker').textContent = copy.kicker;
  document.getElementById('caseHeadline').textContent = copy.headline;
  document.getElementById('caseMetaOffice').textContent = copy.office;
  document.getElementById('caseMetaClient').textContent = copy.client;
  document.getElementById('caseMetaService').textContent = copy.service;
  document.getElementById('caseMetaYear').textContent = project.year;

  // 3. Lead Copy & Video Preview
  document.getElementById('caseLeadCopy').textContent = copy.lead;
  document.getElementById('caseVideoVisual').innerHTML = buildVideoPreviewHTML(project, copy);
  document.getElementById('caseVideoCaption').textContent = copy.videoCaption;

  // 4. Accordions
  document.getElementById('caseAccChallengeText').textContent = copy.challenge;
  document.getElementById('caseAccInspirationText').textContent = copy.inspiration;
  document.getElementById('caseAccIdeaText').textContent = copy.idea;
  document.getElementById('caseAccGrowthText').textContent = copy.growth;

  // 5. Metrics & Gallery
  renderMetrics(project, copy);
  renderGallerySlide(project, copy);

  // 6. Keep Reading Related Projects
  renderRelatedProjects(project);

  if (scrollTop) {
    window.scrollTo({ top: 0, behavior: 'smooth' });
  }
}

function setLanguage(lang) {
  if (!uiLabels[lang]) return;
  currentLang = lang;
  document.documentElement.lang = lang;

  document.querySelectorAll('[data-i18n]').forEach((el) => {
    const key = el.getAttribute('data-i18n');
    if (uiLabels[lang][key]) {
      el.innerHTML = uiLabels[lang][key];
    }
  });

  document.querySelectorAll('.lang-btn').forEach((btn) => {
    btn.classList.toggle('active', btn.getAttribute('data-lang') === lang);
  });

  loadProject(currentProjectId, false);
}

document.addEventListener('DOMContentLoaded', () => {
  // Initialize project from URL ?id=...
  const initialId = getProjectFromUrl();
  loadProject(initialId, false);

  // Quick Switcher Pills
  document.querySelectorAll('.case-pill').forEach((pill) => {
    pill.addEventListener('click', (e) => {
      e.preventDefault();
      loadProject(pill.getAttribute('data-project-id'), true);
    });
  });

  // Language Switcher
  document.querySelectorAll('.lang-btn').forEach((btn) => {
    btn.addEventListener('click', () => {
      setLanguage(btn.getAttribute('data-lang'));
    });
  });

  // Accordion toggles
  document.querySelectorAll('.case-acc-trigger').forEach((trigger) => {
    trigger.addEventListener('click', () => {
      const item = trigger.closest('.case-acc-item');
      const isOpen = item.classList.contains('open');
      item.classList.toggle('open', !isOpen);
      trigger.setAttribute('aria-expanded', String(!isOpen));
    });
  });

  // Interactive Video Frame Click Effect
  const videoFrame = document.getElementById('caseVideoFrame');
  if (videoFrame) {
    videoFrame.addEventListener('click', () => {
      videoFrame.classList.toggle('playing');
      const caption = document.getElementById('caseVideoCaption');
      if (caption) {
        caption.textContent = videoFrame.classList.contains('playing')
          ? (currentLang === 'en' ? '✓ Interactive Preview Active — Click to pause' : '✓ Vista interactiva activa — Clic para pausar')
          : projectsCatalog[currentProjectId][currentLang].videoCaption;
      }
    });
  }

  // Metrics Pagination (< 1 / 2 >)
  document.getElementById('metricsPrevBtn')?.addEventListener('click', () => {
    const pages = projectsCatalog[currentProjectId][currentLang].metrics;
    currentMetricsPage = (currentMetricsPage - 1 + pages.length) % pages.length;
    renderMetrics(projectsCatalog[currentProjectId], projectsCatalog[currentProjectId][currentLang]);
  });

  document.getElementById('metricsNextBtn')?.addEventListener('click', () => {
    const pages = projectsCatalog[currentProjectId][currentLang].metrics;
    currentMetricsPage = (currentMetricsPage + 1) % pages.length;
    renderMetrics(projectsCatalog[currentProjectId], projectsCatalog[currentProjectId][currentLang]);
  });

  // Gallery Carousel Pagination (< 1 / 4 >)
  document.getElementById('galleryPrevBtn')?.addEventListener('click', () => {
    const slides = projectsCatalog[currentProjectId][currentLang].slides;
    currentGalleryIndex = (currentGalleryIndex - 1 + slides.length) % slides.length;
    renderGallerySlide(projectsCatalog[currentProjectId], projectsCatalog[currentProjectId][currentLang]);
  });

  document.getElementById('galleryNextBtn')?.addEventListener('click', () => {
    const slides = projectsCatalog[currentProjectId][currentLang].slides;
    currentGalleryIndex = (currentGalleryIndex + 1) % slides.length;
    renderGallerySlide(projectsCatalog[currentProjectId], projectsCatalog[currentProjectId][currentLang]);
  });

  // Sticky Header & Mobile Menu
  const header = document.getElementById('header');
  window.addEventListener('scroll', () => {
    if (header) header.classList.toggle('scrolled', window.scrollY > 30);
  }, { passive: true });

  const menuToggle = document.getElementById('menuToggle');
  const mobileMenu = document.getElementById('mobileMenu');
  if (menuToggle && mobileMenu) {
    menuToggle.addEventListener('click', () => mobileMenu.classList.toggle('open'));
  }
});
