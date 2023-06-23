import { defineStore } from 'pinia'

export const useDatabaseStore = defineStore('database', {
  state: () => ({
    view: '',
    terms: [],
    allTerms: [],
    allItems: [],
    activeTerms: [],
    loaded: false,
    hideFilter: false,
    selectedItem: null,
    hotelTerms: [],
    curUrl: location.href.split('/').filter(item => item.length > 0).pop(),
    hotelsFilterOpen: false,
    label: tofinoJS.databaseLabel,
    apiUrl: tofinoJS.siteURL + '/wp-json/wp/v2/'
  }),
  getters: {
    items: (state) => {
      let items = state.allItems;

      const sorting = len => {
          if (state.activeTerms !== state.terms && state.activeTerms.length > len) { // Different terms that inital load
              items = state.allItems.filter(item => {
                  return state.activeTerms.some(termId => {
                      if(state.curUrl === 'hotels') {
                          if (termId !== 99) return item.database_categories.includes(termId);
                      } else if(state.curUrl === 'stay') {
                          if (termId !== 99) {
                              return item.database_categories.includes(termId);
                          } else {
                              const subCategory = state.activeTerms.some(item => item < 99 || item > 102);
                              if (!subCategory) return item.database_categories.includes(termId);
                          }
                      } else {
                          return item.database_categories.includes(termId);
                      }
                  });
              });
          } else {
              items = state.allItems;
          }
      };

      sorting(state.curUrl === 'hotels' ? 1 : 0);

      if(state.curUrl === 'hotels' || state.curUrl === 'stay') { // Open Hotels filter
        if(state.activeTerms.includes(99)) {
            state.hotelsFilterOpen = true;
        } else {
            state.hotelsFilterOpen = false;
            state.activeTerms = state.activeTerms.filter(item => 99 <= item && item <= 102);
        }
      }

      // sort items by name alphabetically
      items.sort((a, b) => {
        if (a.title.rendered < b.title.rendered) {
          return -1;
        }
        if (a.title.rendered > b.title.rendered) {
          return 1;
        }
        return 0;
      });

      // order items by featured value
      items = items.sort((a, b) => {
        if (a.acf.database_featured === b.acf.database_featured) {
          return 0;
        }
        return a.acf.database_featured ? -1 : 1;
      });

      return items;
    },
    getPlaceholderImage: (state) => {
      return (terms) => {
        let placeholder_image = false;

        terms.filter((value) => {
          const term = state.allTerms.find((term) => term.id == value);

          if (term) {
            placeholder_image = term.placeholder_image;

            return true;
          }
        });

        return placeholder_image;
      }
    }
  },
  actions: {
    async getTerms() {
      const response = await fetch(this.apiUrl + 'database_categories?per_page=100&hide_empty=false');
     //  this.allTerms = await response.json();

      const data = await response.json();

      // remove all items that are not in the selected terms
     if (this.curUrl === 'hotels' || this.curUrl === 'stay') {
          this.allTerms = data.filter(item => {
            if(item.id >= 99 && item.id <= 102){
                return this.terms.some(termId => {
                    return item.id == termId;
                });
            }
          });
          this.hotelTerms = data.filter(item => {
              if(item.id !== 99 && item.id !== 100 && item.id !== 101 && item.id !== 102){
                  return this.terms.some(termId => {
                      return item.id == termId;
                  });
              }
          });

        if (this.curUrl === 'hotels') {
            this.activeTerms = [99];
            this.hotelsFilterOpen = true;
        }
      } else {
         this.allTerms = data.filter(item => {
             return this.terms.some(termId => {
                 return item.id == termId;
             });
         });
     }
    },

    async getPosts() {
      try {
        if (this.terms.length) {
          // console.log("terms: ", this.terms);
          const response = await fetch(this.apiUrl + 'database?per_page=500&database_categories=' + this.terms);
          this.allItems = await response.json();
          // console.log("this.allItems : ", this.allItems );
        }
        this.loaded = true;
      } catch (error) {
        console.log(error);
        return error
      }
    },
  },
});
