import { createApp, ref} from 'vue';

export default () => {
  const elements = document.querySelectorAll('[faq-section]');

  elements.forEach(el => {
    createApp({
      setup() {
        const active = ref([]);

        const isOpen = (key) => {
          return active.value.includes(key);
        };

        const toggle = (key) => {
          if (isOpen(key)) {
            active.value.splice(active.value.indexOf(key), 1);
          } else {
            active.value.push(key);
          }
        }

        const toggleAll = (keys) => {
          if (active.value.length !== keys.length) {
            // Has all items in it
            active.value.splice(0);
            active.value.push(...keys);
          } else {
            active.value.splice(0);
          }
        }

        return {
          active,
          isOpen,
          toggle,
          toggleAll
        }
      }
    }).mount(el, true);
  });
};