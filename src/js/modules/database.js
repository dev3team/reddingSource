import { createApp } from 'vue';

import { createPinia } from 'pinia';

import Database from '../../vue/Database.vue';

import VueGoogleMaps from '@fawmi/vue-google-maps'

export default () => {
  createApp({
    components: {
      Database
    },
  })
  .use(createPinia())
  .use(VueGoogleMaps, {
    load: {
      key: 'AIzaSyBnRUL975hLefHeLsbcgbU0G-05G4o7VsU',
    },
  })
  .mount('.js-database');
};