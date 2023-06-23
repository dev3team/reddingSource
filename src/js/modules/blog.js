import { createApp } from 'vue';

import { createPinia } from 'pinia';

import Blog from '../../vue/Blog.vue';

export default () => {
  createApp({
    components: {
      Blog
    },
  })
  .use(createPinia())
  .mount('.js-blog');
};