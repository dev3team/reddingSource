// Import Alert
import Alert from './modules/alert';

// Menu
import Menu from './modules/menu';
import MenuScroll from './modules/menu-scroll';

// Sharelinks
import Sharelinks from 'sharelinks';

// Import Font loader
import WebFont from 'webfontloader';

// Search
import Search from './modules/search'

export default {
  init () {
    // JavaScript to be fired on all pages

    // Load Fonts
    WebFont.load({
      classes: true,
      events: false,
      typekit: {
        id: 'yqt4jru',
      },
      google: {
        families: ['Poppins:wght@800;900'],
        display: 'swap',
        version: 2,
      },
    });

    // Alert
    if (document.getElementById('tofino-notification')) {
      Alert();
    }

    // Menu
    if (document.getElementById('main-menu')) {
      Menu();
      MenuScroll();
    }

    // Featured Posts
    if (document.querySelector('.featured-posts')) {
      import('./modules/featured-posts' /* webpackChunkName: "featured-posts" */).then(Module => {
        Module.default();
      });
    }

    // Content Carousel
    if (document.querySelector('.content-carousel')) {
      import('./modules/content-carousel' /* webpackChunkName: "content-carousel" */).then(Module => {
        Module.default();
      });
    }

    // Tabbed Content
    if (document.querySelector('[tabbed-content]')) {
      import('./modules/tabbed-content' /* webpackChunkName: "tabbed-content" */).then(Module => {
        Module.default();
      });
    }

    // Newsletter Form
    if (document.getElementById('js-newsletter-form')) {
      import('./modules/newsletter-form' /* webpackChunkName: "newsletter-form" */).then(Module => {
        Module.default();
      });
    }

    // Events
    if (document.querySelector('[events]')) {
      import('./modules/events' /* webpackChunkName: "events" */).then(Module => {
        Module.default();
      });
    }

    // Posts Feed
    if (document.querySelector('.posts-feed')) {
      import('./modules/posts-feed' /* webpackChunkName: "posts-feed" */).then(Module => {
        Module.default();
      });
    }

    // Add Event Form
    if (document.getElementById('js-event-form')) {
      import('./modules/event-form' /* webpackChunkName: "event-form" */).then(Module => {
        Module.default();
      });
    }

     // Add Database
    if (document.querySelector('.js-database')) {
      import('./modules/database' /* webpackChunkName: "database" */).then(Module => {
        Module.default();
      });
    }

    // Vector Map
    if (document.querySelector('.js-vector-map')) {
      import('./modules/vector-map' /* webpackChunkName: "vector-map" */).then(Module => {
        Module.default();
      });
    }

    if (document.querySelector('.js-itineraries')) {
      import('./modules/itineraries' /* webpackChunkName: "itineraries" */).then(Module => {
        Module.default();
      });
    }

    // Faqs
    if (document.querySelector('[faq-section]')) {
      import('./modules/faq' /* webpackChunkName: "faq" */).then(Module => {
        Module.default();
      });
    }

    new Sharelinks('.share', {
      platforms: ['email']
    });

    // Add Blog
    if (document.querySelector('.js-blog')) {
      import('./modules/blog' /* webpackChunkName: "blog" */).then(Module => {
        Module.default();
      });
    }

    // Contact Form
    if (document.querySelector('.js-contact-form')) {
      import('./modules/contact-form' /* webpackChunkName: "contact-form" */).then(Module => {
        Module.default();
      });
    }

    // Search
    if (document.getElementById('js-search')) {
      Search();
    }

    // // Team
    if (document.querySelector('.js-team')) {
      import('./modules/team' /* webpackChunkName: "team" */).then(Module => {
        Module.default();
      });
    }
  },
  finalize () {
    // JavaScript to be fired after init
  },
  loaded () {
    // Javascript to be fired once fully loaded
  },
};
