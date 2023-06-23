import { defineStore } from 'pinia'

export const useBlogStore = defineStore('blog', {
  state: () => ({
    postType: '',
    selectedTerm: null,
    allTerms: [],
    items: [],
    loading: true,
    args: {
      page: 1,
      per_page: 10,
    },
    pagination: {
      prevPage: '',
      nextPage: '',
      currentPage: 1,
      totalPages: '',
      from: '',
      to: '',
      total: ''
    },
    apiUrl: tofinoJS.siteURL + '/wp-json/wp/v2/'
  }),
  actions: {
    async getTerms() {
      const response = await fetch(this.apiUrl + 'categories?hide_empty=true');
      this.allTerms  = await response.json();
    },
    async getPosts() {
      try {
        const response = await fetch(this.apiUrl + this.postType + '?' + new URLSearchParams(this.args))
        this.items = await response.json();

        this.configPagination(response.headers)
      } catch (error) {
        console.log(error)
        return error
      }
    },
    configPagination (headers) {
      // @TODO: Refactor this to be a bit cleaner. DH
      this.pagination.total = +headers.get('x-wp-total');
      this.pagination.totalPages = +headers.get('x-wp-totalpages');
      this.pagination.from = this.pagination.total
        ? (this.args.page - 1) * this.args.per_page + 1
        : " ";
      this.pagination.to =
        this.args.page * this.args.per_page > this.pagination.total
          ? this.pagination.total
          : this.args.page * this.args.per_page;
      this.pagination.currentPage = this.args.page;
      this.pagination.prevPage = this.args.page > 1 ? this.args.page : "";
      this.pagination.nextPage =
        this.args.page < this.pagination.totalPages ? this.args.page + 1 : "";
    }
  },
})