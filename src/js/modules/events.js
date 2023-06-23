import { createApp, ref, computed, onMounted } from 'vue';
import { createStore } from 'vuex';

import VCalendar from 'v-calendar';
import 'v-calendar/dist/style.css';

const store = createStore({
  state: {
    count: 0,
    events: [],
    args: {
      per_page: 8,
      page: 1,
      first_load: true,
    },
    pagination: {
      totalPages: null,
      nextPage: null,
    },
    range: {},
  },
  mutations: {
    setEvents (state, events) {
      state.events = events;
    },
    setPagination (state, data) {
      state.pagination = data;
    },
    loadMorePosts (state) {
      state.args.per_page += 4;
    },
    updateCategory (state, category) {
      state.args = { ...state.args, categories: [category] };
    },
    setSearch (state, search) {
      if (search === '') {
        delete state.args.search;
      } else {
        state.args = { ...state.args, search };
      }
    },
    setDates (state, dates) {
      const options = {
        year: 'numeric',
        month: '2-digit',
        day: 'numeric',
      };

      state.args = {
        ...state.args,
        first_load: false,
        start_date: dates.start.toLocaleString('en-US', options),
        end_date: dates.end.toLocaleString('en-US', options),
      };
      state.range = dates;
    },
  },
  actions: {
    getEvents (context) {
      // console.log(context.state.args);

      fetch(
        tofinoJS.siteURL +
          '/wp-json/tribe/events/v1/events?' +
          new URLSearchParams(context.state.args)
      )
        .then(response => response.json())
        .then(response => {
          // console.log(response);

          context.commit('setEvents', response.events);

          // Get pages from response
          const totalPages = response.total_pages;

          // Calculate next page
          const nextPage =
            context.state.args.page < totalPages ? context.state.args.page + 1 : null;

          // Update total pages
          context.commit('setPagination', {
            totalPages: totalPages,
            nextPage: nextPage,
          });
        });
    },
  },
});

export default () => {
  const elements = document.querySelectorAll('[events]');

  elements.forEach(el => {
    let App = createApp({
      setup() {
        const attribute = ref({
          highlight: {
            start: {
              style: {
                backgroundColor: '#2A4A41'
              },
              contentStyle: {
                color: '#ffffff'
              }
            },
            base: {
              style: {
                backgroundColor: '#D9F0E6'
              }
            },
            end: {
              style: {
                backgroundColor: '#2A4A41'
              },
              contentStyle: {
                color: '#ffffff'
              }
            }
          }
        })

        const events = computed(() => {
          return store.state.events;
        })

        const nextPage = computed(() => {
          return store.state.pagination.nextPage;
        })

        const category = computed({
          get () {
            const args = store.state.args;

            if (args.hasOwnProperty('categories')) {
              return [...args.categories].shift();
            } else {
              return '';
            }
          },
          set (value) {
            store.commit('updateCategory', value);
          }
        })

        const search = computed({
          get () {
            return store.state.args.search;
          },
          set (value) {
            store.commit('setSearch', value);
          },
        })

        const range = computed({
          get () {
            return store.state.range;
          },
          set (value) {
            store.commit('setDates', value);
          },
        })

        const filterDate = computed(() => {
          const dateOptions = { day: 'numeric', month: 'long' };

          // if range has start and end dates
          if (range.value.start && range.value.end) {
            return (
              range.value.start.toLocaleString('en-US', dateOptions) +
              ' - ' +
              range.value.end.toLocaleString('en-US', dateOptions)
            );
          }
        })

        const loadMore = () => {
          store.commit('loadMorePosts');

          store.dispatch('getEvents');
        }

        const findEvents = (e) => {
          e.preventDefault();

          store.dispatch('getEvents');
        }

        const formatDate = (date) => {
          date = date.replace(/ /g, 'T'); // Safari hack fix.

          const createDate = new Date(date);
          const dateOptions = { day: 'numeric', month: 'long' };
          const timeOptions = { hour: 'numeric', minute: 'numeric' };

          return (
            createDate.toLocaleString('en-US', dateOptions) +
            ' @ ' +
            createDate.toLocaleString('en-US', timeOptions)
          );
        }

        const scrollToTop = () => {
          const elm = document.querySelectorAll('.module')[1];
          const headerNav = document.getElementById('header-nav');
          const navHeight = headerNav.offsetHeight;

          elm.scrollIntoView(true);
          const scrolledY = window.scrollY; // Offset Nav

          if (scrolledY) {
            window.scroll({
              top: scrolledY - navHeight,
              behavior: 'smooth',
            });
          }
        }

        // Lifecycle Hooks
        onMounted(() => {
          store.dispatch('getEvents');
        })

        return {
          attribute,
          events,
          nextPage,
          category,
          search,
          range,
          filterDate,
          loadMore,
          findEvents,
          formatDate,
          scrollToTop
        }
      }
    });
    App.use(store);

    App.use(VCalendar, {});

    App.mount(el, true);
  });
};
