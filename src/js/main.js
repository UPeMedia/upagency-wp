/**
 * UP Group Studio (up.gt) — Interactive Preview & WordPress Bricks Builder Script
 * Features:
 *  - ES / EN Bilingual Switcher (Preserving inline SVG doodles & formatting)
 *  - Service & Portfolio Card pre-selection into Inquiry Form
 *  - Direct WhatsApp (+50237556857) & Form Inquiry Handler (no exposed email/phone text)
 *  - Sticky Header & Mobile Menu
 */

const i18nData = {
  es: {
    'nav.works': 'Proyectos',
    'nav.services': 'Servicios',
    'nav.studio': 'El Estudio',
    'nav.contact': 'Contacto',

    'hero.title': 'Enciende tu<br>Potencial Digital',
    'hero.desc': 'Somos <strong>UP Group Studio</strong>, un estudio digital en Guatemala y Houston, TX. Llevamos más de 15 años creando sitios web a medida, identidades visuales y estrategias digitales que cautivan y convierten.',

    'works.cta': 'Explorar caso',
    'works.p1Tag': 'UI/UX • Booking Engine • Brand Content',
    'works.p1Desc': 'Experiencia digital inmersiva y reservas directas para el destino náutico más exclusivo de Guatemala.',
    'works.p1Cat': 'Diseño Web & Motor de Reservas',

    'works.p2Tag': 'Arquitectura Corporativa • Portal de Eventos',
    'works.p2Desc': 'Renovación integral del centro de convenciones y complejo hotelero más icónico de Guatemala.',
    'works.p2Cat': 'Portal Corporativo & Convenciones',

    'works.p3Tag': 'Portal Institucional • Alta Disponibilidad',
    'works.p3Desc': 'Plataforma de alto tráfico con visualización energética nacional, estándares de accesibilidad y ciberseguridad.',
    'works.p3Cat': 'Plataforma Institucional & Datos',

    'works.p4Tag': 'Catálogo B2B • Embudo de Leads',
    'works.p4Desc': 'Catálogo interactivo y cotizador en tiempo real para la línea de camiones y autobuses Hyundai.',
    'works.p4Cat': 'Catálogo Digital & Lead Generation',

    'works.p5Tag': 'US Fintech Market • Speed Optimization',
    'works.p5Desc': 'Plataforma financiera para el mercado de EE.UU. con calculadoras interactivas y conversión de alto rendimiento.',
    'works.p5Cat': 'Fintech Web & Optimización',

    'works.p6Tag': 'Creative Showcase • Video Portfolio',
    'works.p6Desc': 'Showcase editorial multipremiado exhibiendo campañas regionales con fluidez y velocidad instantánea.',
    'works.p6Cat': 'Diseño Editorial & Portafolio',

    'manifesto1.p1': 'No solo hacemos <span class="doodle-word doodle-word--yellow">sitios web.<svg class="doodle-svg" viewBox="0 0 120 14" fill="none"><path d="M2 10 Q15 2 30 10 T60 10 T90 10 T118 8" stroke="#FBBF24" stroke-width="3.5" stroke-linecap="round"/></svg></span> Los hacemos visibles ante los ojos de todos y en Google. Hablamos geek, pero te explicamos cada paso sin tecnicismos incomprensibles para que tu proyecto digital sea <span class="doodle-word doodle-word--mint">genial.<svg class="doodle-sparkle" viewBox="0 0 36 36" fill="none"><path d="M18 2L21 14L33 17L21 20L18 32L15 20L3 17L15 14L18 2Z" fill="#96C594"/></svg></span>',
    'manifesto1.p2': 'Hemos trabajado en proyectos que salen de lo ordinario: retos que nos impulsan a <span class="doodle-word doodle-word--blue">crear a medida<svg class="doodle-svg" viewBox="0 0 140 16" fill="none"><path d="M3 12 C25 2, 45 16, 70 8 C95 0, 115 14, 137 6" stroke="#669ACA" stroke-width="3.5" stroke-linecap="round"/></svg></span> y superar expectativas. Eso es lo que amamos <span class="doodle-heart">💖</span>: la excelencia técnica y visual, jamás el copiar y pegar.',
    'manifesto1.caption': '¿Tienes un proyecto en mente? Cuéntanos tus objetivos.',
    'manifesto1.cta': 'Iniciar una conversación',

    'services.kicker': 'SOLUCIONES A LA MEDIDA DE TU NEGOCIO',
    'services.title': 'Nuestros servicios<br>à la carte',
    'services.subtitle': 'Sin ataduras a un solo CMS ni plantillas prefabricadas. Elegimos la tecnología exacta que tu empresa necesita para escalar en Guatemala o Estados Unidos.',
    'services.btn': 'Cotizar',

    'services.s1Title': 'Desarrollo de<br>sitios web a medida',
    'services.s1Desc': 'Portales corporativos, sitios institucionales y plataformas web rápidas, seguras y adaptadas al 100% a tus objetivos comerciales.',

    'services.s2Title': 'Diseño UI/UX &<br>Identidad visual',
    'services.s2Desc': 'Interfaces memorables, sistemas de diseño, dirección de arte, fotografía comercial y producción audiovisual de alto impacto.',

    'services.s3Title': 'Tiendas Online &<br>E-Commerce',
    'services.s3Desc': 'Comercio electrónico diseñado para vender 24/7 con pasarelas locales (Guatemala) e internacionales (Stripe, PayPal en EE.UU.).',

    'services.s4Title': 'Mantenimiento &<br>Optimización Web',
    'services.s4Desc': 'Aceleración de Core Web Vitals (95+ en Google PageSpeed), blindaje de seguridad, backups y soporte técnico continuo.',

    'services.s5Title': 'Automatización &<br>Inteligencia Artificial',
    'services.s5Desc': 'Conexión inteligente de formularios a WhatsApp y CRM, agentes de IA de atención al cliente y optimización de flujos operativos.',

    'services.f1': 'Desarrollo Web a Medida',
    'services.f2': 'Diseño UI/UX & Branding',
    'services.f3': 'E-Commerce & Pagos',
    'services.f4': 'Optimización & Velocidad',
    'services.f5': 'Automatizaciones & IA',

    'manifesto2.p1': 'No nos gustan los sitios creados en serie. Cada proyecto es diseñado artesanalmente para reflejar tu identidad y responder a tus <span class="doodle-word">objetivos.<svg class="doodle-svg" viewBox="0 0 120 14" fill="none"><path d="M2 10 Q15 2 30 10 T60 10 T90 10 T118 8" stroke="#F59E0B" stroke-width="3.5" stroke-linecap="round"/></svg></span>',
    'manifesto2.p2': 'Colaborar con UP Group Studio es elegir una dupla <span class="doodle-word">humana y senior<svg class="doodle-svg" viewBox="0 0 140 16" fill="none"><path d="M3 12 C25 2, 45 16, 70 8 C95 0, 115 14, 137 6" stroke="#3B82F6" stroke-width="3.5" stroke-linecap="round"/></svg></span> que domina su oficio, responde directo por WhatsApp y te acompaña a largo plazo desde <strong>Guatemala</strong> y <strong>Houston, Texas</strong> <span class="doodle-star">✹</span>',
    'manifesto2.caption': 'Respuesta directa en menos de 2 horas hábiles.',
    'manifesto2.cta': 'Cotizar mi proyecto',

    'studio.rodrigoRole': 'Founder • Desarrollo Web & Diseño de Producto Digital',
    'studio.yulcerRole': 'Co-Lead • Diseño Visual, Video & Fotografía Comercial',

    'ctaBanner.kicker': '¿LISTO PARA DESPEGAR?',
    'ctaBanner.title': '¿Necesitas un<br><span class="doodle-word">sitio web<svg class="doodle-svg" viewBox="0 0 120 14" fill="none"><path d="M2 10 Q20 2 40 10 T80 10 T118 8" stroke="#EB5F69" stroke-width="4" stroke-linecap="round"/></svg></span> de alto nivel?',
    'ctaBanner.desc': 'Completa tus datos abajo para enviarnos un resumen directo por WhatsApp o mensaje directo.',

    'form.title': 'Cuéntanos sobre tu proyecto',
    'form.desc': 'Selecciona los servicios que te interesan y conversemos hoy mismo.',
    'form.pill1': 'Desarrollo Web',
    'form.pill2': 'UI/UX & Branding',
    'form.pill3': 'E-Commerce',
    'form.pill4': 'Velocidad / Soporte',
    'form.pill5': 'Automatización & IA',
    'form.nameLabel': 'Tu Nombre *',
    'form.companyLabel': 'Empresa / Marca',
    'form.emailLabel': 'Correo Electrónico *',
    'form.phoneLabel': 'WhatsApp / Teléfono *',
    'form.detailsLabel': 'Resumen de tu idea o necesidades',
    'form.consent': 'Acepto que <strong>UP Group Studio</strong> almacene mis datos y me envíe seguimiento por correo electrónico o WhatsApp respecto a mi solicitud. Cero spam.',
    'form.btnSendWhatsApp': 'Enviar resumen por WhatsApp',
    'form.btnSendEmail': 'Enviar Solicitud',

    'footer.box1': 'Chatear por WhatsApp',
    'footer.box2': 'Guatemala • Houston, Texas',
    'footer.box3': 'Iniciar Proyecto • up.gt',
    'footer.bigTitle': 'Es ahora que<br>todo comienza',
    'footer.scriptAccent': 'con nosotros',
    'footer.ctaBtn': 'Iniciar un proyecto',
    'footer.col1Title': 'Estudio',
    'footer.col2Title': 'Servicios & Soluciones',
    'footer.rights': 'TODOS LOS DERECHOS RESERVADOS',

    'floating.whatsappTooltip': '¿Hablamos por WhatsApp?'
  },

  en: {
    'nav.works': 'Work',
    'nav.services': 'Services',
    'nav.studio': 'The Studio',
    'nav.contact': 'Contact',

    'hero.title': 'Ignite Your<br>Online Potential',
    'hero.desc': 'We are <strong>UP Group Studio</strong>, a digital studio in Guatemala and Houston, TX. For over 15 years we have crafted bespoke websites, visual identities, and digital strategies that captivate and convert.',

    'works.cta': 'Explore Case',
    'works.p1Tag': 'UI/UX • Booking Engine • Brand Content',
    'works.p1Desc': 'Immersive digital experience and direct booking engine for Guatemala’s premier nautical resort.',
    'works.p1Cat': 'Web Design & Booking Engine',

    'works.p2Tag': 'Corporate Architecture • Events Portal',
    'works.p2Desc': 'Full digital overhaul for Guatemala’s most iconic hotel and convention complex.',
    'works.p2Cat': 'Corporate Portal & Conventions',

    'works.p3Tag': 'Institutional Portal • High Availability',
    'works.p3Desc': 'High-traffic national energy platform engineered with strict accessibility and cybersecurity standards.',
    'works.p3Cat': 'Institutional Platform & Data',

    'works.p4Tag': 'B2B Catalog • Lead Funnel',
    'works.p4Desc': 'Interactive vehicle catalog and real-time fleet quoting system for Hyundai Commercial Vehicles.',
    'works.p4Cat': 'Digital Catalog & Lead Generation',

    'works.p5Tag': 'US Fintech Market • Speed Optimization',
    'works.p5Desc': 'High-converting US financial relief platform featuring interactive calculators and 98+ PageSpeed.',
    'works.p5Cat': 'Fintech Web & Performance',

    'works.p6Tag': 'Creative Showcase • Video Portfolio',
    'works.p6Desc': 'Award-winning editorial showcase presenting regional campaigns with instant video playback.',
    'works.p6Cat': 'Editorial Design & Portfolio',

    'manifesto1.p1': 'We don’t just build <span class="doodle-word doodle-word--yellow">websites.<svg class="doodle-svg" viewBox="0 0 120 14" fill="none"><path d="M2 10 Q15 2 30 10 T60 10 T90 10 T118 8" stroke="#FBBF24" stroke-width="3.5" stroke-linecap="round"/></svg></span> We make them visible to everyone and on Google. We speak geek, but we guide you clearly without confusing jargon so your digital project turns out <span class="doodle-word doodle-word--mint">brilliant.<svg class="doodle-sparkle" viewBox="0 0 36 36" fill="none"><path d="M18 2L21 14L33 17L21 20L18 32L15 20L3 17L15 14L18 2Z" fill="#96C594"/></svg></span>',
    'manifesto1.p2': 'We thrive on projects that break the mold: challenges that push us to <span class="doodle-word doodle-word--blue">build custom<svg class="doodle-svg" viewBox="0 0 140 16" fill="none"><path d="M3 12 C25 2, 45 16, 70 8 C95 0, 115 14, 137 6" stroke="#669ACA" stroke-width="3.5" stroke-linecap="round"/></svg></span> and exceed expectations. That is what we love <span class="doodle-heart">💖</span>: technical and visual excellence, never copy-paste.',
    'manifesto1.caption': 'Have a project in mind? Tell us about your goals.',
    'manifesto1.cta': 'Start a conversation',

    'services.kicker': 'TAILORED SOLUTIONS FOR YOUR BUSINESS',
    'services.title': 'Our services<br>à la carte',
    'services.subtitle': 'Never locked into a single CMS or rigid templates. We choose the exact technology stack your company needs to scale in the US or Latin America.',
    'services.btn': 'Get a Quote',

    'services.s1Title': 'Custom Web<br>Development',
    'services.s1Desc': 'Corporate portals, institutional sites, and fast, secure web platforms 100% tailored to your business goals.',

    'services.s2Title': 'UI/UX Design &<br>Visual Identity',
    'services.s2Desc': 'Memorable interfaces, design systems, art direction, commercial photography, and high-impact video production.',

    'services.s3Title': 'Online Stores &<br>E-Commerce',
    'services.s3Desc': 'E-commerce engineered to sell 24/7 with US (Stripe, PayPal) and Latin American payment gateways.',

    'services.s4Title': 'Maintenance &<br>Speed Optimization',
    'services.s4Desc': 'Core Web Vitals acceleration (95+ Google PageSpeed), security hardening, automated backups, and ongoing support.',

    'services.s5Title': 'AI & Workflow<br>Automations',
    'services.s5Desc': 'Smart form-to-WhatsApp & CRM integrations, AI customer support agents, and automated business workflows.',

    'services.f1': 'Custom Web Development',
    'services.f2': 'UI/UX Design & Branding',
    'services.f3': 'E-Commerce & Payments',
    'services.f4': 'Speed & Optimization',
    'services.f5': 'AI & Automations',

    'manifesto2.p1': 'We don’t believe in assembly-line websites. Every project is handcrafted to reflect your brand identity and achieve your <span class="doodle-word">goals.<svg class="doodle-svg" viewBox="0 0 120 14" fill="none"><path d="M2 10 Q15 2 30 10 T60 10 T90 10 T118 8" stroke="#F59E0B" stroke-width="3.5" stroke-linecap="round"/></svg></span>',
    'manifesto2.p2': 'Partnering with UP Group Studio means working directly with a <span class="doodle-word">senior, human duo<svg class="doodle-svg" viewBox="0 0 140 16" fill="none"><path d="M3 12 C25 2, 45 16, 70 8 C95 0, 115 14, 137 6" stroke="#3B82F6" stroke-width="3.5" stroke-linecap="round"/></svg></span> who masters their craft, replies directly on WhatsApp, and supports you long-term from <strong>Guatemala</strong> and <strong>Houston, Texas</strong> <span class="doodle-star">✹</span>',
    'manifesto2.caption': 'Direct senior response in under 2 business hours.',
    'manifesto2.cta': 'Quote my project',

    'studio.rodrigoRole': 'Founder • Web Development & Digital Product Design',
    'studio.yulcerRole': 'Co-Lead • Visual Design, Video & Commercial Photography',

    'ctaBanner.kicker': 'READY FOR LIFTOFF?',
    'ctaBanner.title': 'Need a high-performing<br><span class="doodle-word">website<svg class="doodle-svg" viewBox="0 0 120 14" fill="none"><path d="M2 10 Q20 2 40 10 T80 10 T118 8" stroke="#EB5F69" stroke-width="4" stroke-linecap="round"/></svg></span> that stands out?',
    'ctaBanner.desc': 'Fill out the brief below to send us a direct summary via WhatsApp or direct inquiry.',

    'form.title': 'Tell us about your project',
    'form.desc': 'Select the services you need and let’s talk today.',
    'form.pill1': 'Web Development',
    'form.pill2': 'UI/UX & Branding',
    'form.pill3': 'E-Commerce',
    'form.pill4': 'Speed / Support',
    'form.pill5': 'AI & Automation',
    'form.nameLabel': 'Your Name *',
    'form.companyLabel': 'Company / Brand',
    'form.emailLabel': 'Email Address *',
    'form.phoneLabel': 'WhatsApp / Phone *',
    'form.detailsLabel': 'Project summary or goals',
    'form.consent': 'I agree that <strong>UP Group Studio</strong> may store my details and contact me via email or WhatsApp regarding my project inquiry. Zero spam.',
    'form.btnSendWhatsApp': 'Send summary via WhatsApp',
    'form.btnSendEmail': 'Submit Inquiry',

    'footer.box1': 'Chat on WhatsApp',
    'footer.box2': 'Guatemala • Houston, Texas',
    'footer.box3': 'Start a Project • up.gt',
    'footer.bigTitle': 'Now is when<br>everything begins',
    'footer.scriptAccent': 'with us',
    'footer.ctaBtn': 'Start a project',
    'footer.col1Title': 'Studio',
    'footer.col2Title': 'Services & Solutions',
    'footer.rights': 'ALL RIGHTS RESERVED',

    'floating.whatsappTooltip': 'Chat with us on WhatsApp'
  }
};

let currentLang = (
  (window.upPolylang && window.upPolylang.current) ||
  document.documentElement.lang ||
  'es'
).toLowerCase().startsWith('en') ? 'en' : 'es';

function setLanguage(lang) {
  if (!i18nData[lang]) return;
  currentLang = lang;
  document.documentElement.lang = lang;

  document.querySelectorAll('[data-i18n]').forEach((el) => {
    const key = el.getAttribute('data-i18n');
    if (i18nData[lang][key]) {
      el.innerHTML = i18nData[lang][key];
    }
  });

  document.querySelectorAll('.lang-btn').forEach((btn) => {
    btn.classList.toggle('active', btn.getAttribute('data-lang') === lang);
  });
}

function getSelectedServices() {
  const checked = Array.from(document.querySelectorAll('input[name="services"]:checked'));
  return checked.map((input) => input.value);
}

// ─── Lead Session Token & Smart Partial / Completed Capture ──────────────
function getOrCreateLeadToken(forceNew = false) {
  const key = 'up_lead_session_token';
  try {
    let token = forceNew ? null : sessionStorage.getItem(key);
    if (!token) {
      token = 'upl_' + Date.now().toString(36) + '_' + Math.random().toString(36).substring(2, 10);
      sessionStorage.setItem(key, token);
    }
    return token;
  } catch (e) {
    return 'upl_' + Date.now().toString(36);
  }
}

let currentLeadToken = getOrCreateLeadToken(false);
let lastPartialFingerprint = '';
let partialDebounceTimer = null;
let leadAlreadyCompleted = false;

function getCookieValue(name) {
  const match = document.cookie.match(new RegExp('(^| )' + name + '=([^;]+)'));
  return match ? decodeURIComponent(match[2]) : '';
}

function collectFormPayload(submissionType) {
  const name = (document.getElementById('clientName')?.value || '').trim();
  const company = (document.getElementById('clientCompany')?.value || '').trim();
  const email = (document.getElementById('clientEmail')?.value || '').trim();
  const phone = (document.getElementById('clientPhone')?.value || '').trim();
  const scope = (document.getElementById('projectScope')?.value || '').trim();
  const consent = Boolean(document.getElementById('clientConsent')?.checked);
  const honeypot = (document.getElementById('upWebsiteHp')?.value || '').trim();
  const services = getSelectedServices().join(', ') || 'Desarrollo Web a Medida';

  return {
    action: 'up_save_lead',
    nonce: (window.upPolylang && window.upPolylang.leadNonce) ? window.upPolylang.leadNonce : '',
    lead_token: currentLeadToken,
    submission_type: submissionType, // 'partial' | 'whatsapp' | 'completed'
    lang: currentLang,
    name,
    company,
    email,
    phone,
    services,
    scope,
    consent: consent ? '1' : '0',
    up_website_hp: honeypot,
    page_url: window.location.href,
    page_title: document.title,
    hutk: getCookieValue('hubspotutk')
  };
}

function hasContactableInfo(payload) {
  const validEmail = /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(payload.email);
  const digitsOnly = payload.phone.replace(/\D+/g, '');
  const validPhone = digitsOnly.length >= 7;
  return validEmail || validPhone;
}

function syncLeadToServer(submissionType = 'partial', useBeacon = false) {
  const ajaxUrl = (window.upPolylang && window.upPolylang.ajaxUrl) ? window.upPolylang.ajaxUrl : '';
  if (!ajaxUrl) {
    return Promise.resolve({ ok: true, localPreview: true });
  }

  const payload = collectFormPayload(submissionType);
  if (payload.up_website_hp) {
    return Promise.resolve({ ok: true });
  }

  // For partial auto-save, only save if we have at least a valid email or phone, and something changed
  if (submissionType === 'partial') {
    if (leadAlreadyCompleted || !hasContactableInfo(payload)) {
      return Promise.resolve({ skipped: true });
    }
    const fingerprint = [payload.name, payload.company, payload.email, payload.phone, payload.services, payload.scope, payload.consent].join('|');
    if (fingerprint === lastPartialFingerprint) {
      return Promise.resolve({ skipped: true });
    }
    lastPartialFingerprint = fingerprint;
  }

  const formData = new FormData();
  Object.entries(payload).forEach(([k, v]) => formData.append(k, v));

  if (useBeacon && navigator.sendBeacon) {
    navigator.sendBeacon(ajaxUrl, formData);
    return Promise.resolve({ ok: true, beacon: true });
  }

  return fetch(ajaxUrl, {
    method: 'POST',
    body: formData,
    keepalive: true,
    credentials: 'same-origin'
  })
    .then((res) => res.json())
    .catch(() => ({ ok: false }));
}

window.sendInquiryViaWhatsApp = function () {
  const payload = collectFormPayload('whatsapp');
  const services = payload.services || 'Desarrollo Web / Consultoría';

  // Save lead in WP + Google Sheets + HubSpot before opening WhatsApp
  if (payload.name || payload.email || payload.phone || payload.scope) {
    leadAlreadyCompleted = true;
    syncLeadToServer('whatsapp', true);
  }

  const greeting = currentLang === 'en'
    ? `Hello UP Group Studio! I'd like to discuss a project.`
    : `¡Hola UP Group Studio! Me gustaría cotizar un proyecto.`;

  const lines = [
    greeting,
    `• *Servicios:* ${services}`,
    payload.name ? `• *Nombre:* ${payload.name}` : '',
    payload.company ? `• *Empresa:* ${payload.company}` : '',
    payload.email ? `• *Email:* ${payload.email}` : '',
    payload.phone ? `• *Tel/WA:* ${payload.phone}` : '',
    payload.scope ? `• *Detalles:* ${payload.scope}` : ''
  ].filter(Boolean);

  const url = `https://wa.me/50237556857?text=${encodeURIComponent(lines.join('\n'))}`;
  window.open(url, '_blank', 'noopener,noreferrer');
};

window.submitInquiryForm = function () {
  const payload = collectFormPayload('completed');
  const feedback = document.getElementById('formFeedback');
  const submitBtn = document.getElementById('btnSubmitInquiry');

  if (!payload.consent) {
    if (feedback) {
      feedback.classList.add('form-feedback--error');
      feedback.textContent = currentLang === 'en'
        ? 'Please accept the contact agreement checkbox before submitting.'
        : 'Por favor acepta la casilla de consentimiento de contacto antes de enviar.';
    }
    return;
  }

  if (feedback) {
    feedback.classList.remove('form-feedback--error');
    feedback.textContent = currentLang === 'en'
      ? 'Sending your project inquiry...'
      : 'Enviando tu solicitud...';
  }
  if (submitBtn) {
    submitBtn.setAttribute('disabled', 'disabled');
  }

  leadAlreadyCompleted = true;
  if (partialDebounceTimer) {
    clearTimeout(partialDebounceTimer);
  }

  syncLeadToServer('completed', false).then(() => {
    if (submitBtn) {
      submitBtn.removeAttribute('disabled');
    }
    if (feedback) {
      feedback.classList.remove('form-feedback--error');
      feedback.textContent = currentLang === 'en'
        ? `✓ Thank you${payload.name ? ', ' + payload.name : ''}! Your project brief has been received by UP Group Studio. We will reply shortly.`
        : `✓ ¡Gracias${payload.name ? ', ' + payload.name : ''}! Hemos recibido tu solicitud en UP Group Studio. Te contactaremos muy pronto.`;
    }
    // Prepare a fresh token in case the user submits another inquiry later
    currentLeadToken = getOrCreateLeadToken(true);
    lastPartialFingerprint = '';
  });
};

document.addEventListener('DOMContentLoaded', () => {
  const pll = window.upPolylang || null;

  // Sync active state on ES / EN switcher buttons from Polylang / HTML lang
  document.querySelectorAll('.lang-btn').forEach((btn) => {
    const targetLang = btn.getAttribute('data-lang');
    btn.classList.toggle('active', targetLang === currentLang);

    btn.addEventListener('click', (e) => {
      // 1. If in WordPress with Polylang URLs available, navigate to the real translated URL
      const explicitUrl = btn.getAttribute('data-pll-url') || (pll && pll.urls && pll.urls[targetLang]);
      if (pll && pll.isPolylang && explicitUrl) {
        e.preventDefault();
        window.location.href = explicitUrl;
        return;
      }
      // 2. Fallback for local static preview (localhost:3000) or before Polylang is configured
      if (!pll || !pll.isPolylang) {
        e.preventDefault();
        setLanguage(targetLang);
      }
    });
  });

  // Sticky Header scroll class
  const header = document.getElementById('header');
  window.addEventListener('scroll', () => {
    if (!header) return;
    header.classList.toggle('scrolled', window.scrollY > 30);
  }, { passive: true });

  // Mobile Menu toggle
  const menuToggle = document.getElementById('menuToggle');
  const mobileMenu = document.getElementById('mobileMenu');
  if (menuToggle && mobileMenu) {
    menuToggle.addEventListener('click', () => {
      mobileMenu.classList.toggle('open');
    });
    mobileMenu.querySelectorAll('a').forEach((link) => {
      link.addEventListener('click', () => mobileMenu.classList.remove('open'));
    });
  }

  // Pre-select service pill when clicking "Cotizar" on a service card
  document.querySelectorAll('[data-select-service]').forEach((btn) => {
    btn.addEventListener('click', () => {
      const targetService = btn.getAttribute('data-select-service');
      document.querySelectorAll('input[name="services"]').forEach((checkbox) => {
        checkbox.checked = (checkbox.value === targetService);
      });
    });
  });

  // Pre-fill project reference when clicking a Bento Portfolio Card (supports Bricks Query Loop)
  document.querySelectorAll('.bento-card').forEach((card) => {
    card.addEventListener('click', () => {
      const projectName =
        card.getAttribute('data-project') ||
        card.closest('.bento-item')?.querySelector('.bento-title')?.textContent?.trim() ||
        '';
      const scopeInput = document.getElementById('projectScope');
      if (projectName && scopeInput && !scopeInput.value.includes(projectName)) {
        scopeInput.value = currentLang === 'en'
          ? `Interested in a project similar to ${projectName}. `
          : `Me interesa un proyecto con el nivel visual y técnico de ${projectName}. `;
      }
    });
  });

  // Case Study 4-Row Accordion toggles (Single Portfolio Template)
  document.querySelectorAll('.case-acc-trigger').forEach((trigger) => {
    trigger.addEventListener('click', () => {
      const item = trigger.closest('.case-acc-item');
      if (!item) return;
      const isOpen = item.classList.contains('open');
      item.classList.toggle('open', !isOpen);
      trigger.setAttribute('aria-expanded', String(!isOpen));
    });
  });

  // Support #proyectos hash alias -> smooth scroll to #works
  if (window.location.hash === '#proyectos') {
    const worksSec = document.getElementById('works');
    if (worksSec) {
      setTimeout(() => worksSec.scrollIntoView({ behavior: 'smooth' }), 100);
    }
  }

  // Attach Smart Partial / Abandoned Form Auto-Save Listeners
  const formEl = document.getElementById('projectForm');
  if (formEl) {
    const schedulePartialSave = () => {
      if (leadAlreadyCompleted) return;
      if (partialDebounceTimer) clearTimeout(partialDebounceTimer);
      partialDebounceTimer = setTimeout(() => {
        syncLeadToServer('partial', false);
      }, 2200);
    };

    formEl.querySelectorAll('input, textarea').forEach((input) => {
      input.addEventListener('input', schedulePartialSave);
      input.addEventListener('change', schedulePartialSave);
      input.addEventListener('blur', () => {
        if (!leadAlreadyCompleted) {
          syncLeadToServer('partial', false);
        }
      });
    });

    // If user switches tab or closes window after filling email/phone without clicking Send
    document.addEventListener('visibilitychange', () => {
      if (document.visibilityState === 'hidden' && !leadAlreadyCompleted) {
        syncLeadToServer('partial', true);
      }
    });
  }
});
