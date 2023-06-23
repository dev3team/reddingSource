import { createApp } from 'vue';

import Itineraries from '../../vue/Itineraries.vue';

import  VueGoogleMaps from '@fawmi/vue-google-maps'

const Itinerary = () => {
  createApp({
    components: {
      Itineraries
    },
  })
  .use(VueGoogleMaps, {
    load: {
      key: 'AIzaSyBnRUL975hLefHeLsbcgbU0G-05G4o7VsU',
    },
  })
  .mount('.js-itineraries');
};

export default Itinerary;