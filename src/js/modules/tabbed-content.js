import { createApp, ref, onMounted, onBeforeUnmount, nextTick } from 'vue';
import { debounce } from 'lodash-es';

const fullConfig = {
  theme: {
    screens: {
      sm: '640px',
      md: '768px',
      lg: '1024px',
      xl: '1280px',
    },
  },
};

export default () => {
  const elements = document.querySelectorAll('[tabbed-content]');

  elements.forEach(el => {
    createApp({
      setup() {
        const currentBreakpoint = ref(null);
        const currentTab = ref('0');
        const activeTab = ref(null);

        const isTabActive = (tabName) => {
          return currentTab.value === tabName;
        }

        const setTab = (tabName) => {
          currentTab.value = tabName;

          if (currentBreakpoint.value === 'small') {
            nextTick(() => {
              const targetNavHeight = document.getElementById('header-nav');
              const navHeight = targetNavHeight.offsetHeight;

              // Scroll to Element
              activeTab.value.scrollIntoView(true);

              const scrolledY = window.scrollY; // Offset Nav Bar

              if (scrolledY) {
                window.scroll({
                  top: scrolledY - navHeight,
                  behavior: 'smooth',
                });
              }
            });
          }
        }

        const resize = () => {
          let viewportWidth = window.innerWidth || document.documentElement.clientWidth;

          if (viewportWidth < parseInt(fullConfig.theme.screens.md, 10)) {
            currentBreakpoint.value = 'small';
          } else if (
            viewportWidth > parseInt(fullConfig.theme.screens.sm, 10) &&
            viewportWidth < parseInt(fullConfig.theme.screens.lg, 10)
          ) {
            currentBreakpoint.value = 'medium';
          } else {
            currentBreakpoint.value = 'large';
          }
        }

        // Lifecycle Hooks
        onMounted(() => {
          window.addEventListener('resize', debounce(resize, 100));

          resize(); 
        })

        onBeforeUnmount(() => {
          window.removeEventListener('resize', resize);
        })

        return {
          currentBreakpoint,
          currentTab,
          activeTab,
          isTabActive,
          setTab,
          resize
        }
      }
    }).mount(el, true);
  });
};
