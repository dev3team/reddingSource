<script setup>
import { useBlogStore } from '../stores/blogStore';

const store = useBlogStore();

const paginate = (direction = null, page = null) => {
  if (direction === 'next') {
    store.args.page++;
  } else if (direction === 'prev') {
    --store.args.page;
  } else if (page) {
    store.args.page = page;
  }

  store.getPosts();

  scrollToTop();
}

const scrollToTop = () => {
  const blogContainer = document.querySelector('.js-blog');

  blogContainer.scrollIntoView({
    behavior: 'smooth',
    block: 'start',
  });
}
</script>

<template>

  <!-- Pagination -->
  <nav aria-label="pagination" class="w-11/12 mx-auto mt-12 md:w-10/12 md:mt-20">
    <ul class="flex items-center justify-center text-beige-800">

      <!-- Previous -->
      <li v-if="store.pagination.prevPage" class="mr-1 md:mr-4">
        <button @click="paginate('prev')" class="flex items-center font-bold uppercase">
          <svg viewBox="0 0 7.094 13" class="w-4 h-4 rotate-180 fill-current mr-1.5">
            <path d="m.678 12.915 6.414-6.413L.678.09a.29.29 0 0 0-.484.125 5.226 5.226 0 0 0 2.592 6.031.291.291 0 0 1 0 .519A5.226 5.226 0 0 0 .198 12.79a.29.29 0 0 0 .484.125"/>
          </svg>
          <span class="hidden md:inline-flex">Prev</span>
        </button>
      </li>

      <!-- Pages -->
      <li v-for="(totalPages, index) in store.pagination.totalPages"
      :key="index"
      class="flex mx-2 md:mx-3">
        <button
        @click="paginate(null, index + 1)"
        class="px-5 py-3 font-bold rounded-md"
        :class="[
            store.pagination.currentPage == index + 1
              ? 'text-white bg-green-500'
              : ''
          ]"
        aria-current="page">
          {{ index + 1 < 10 ? `${index + 1}` : index + 1 }}
        </button>
      </li>

      <!-- Next -->
      <li v-if="store.pagination.nextPage" class="ml-1 md:ml-4">
        <button @click="paginate('next')" class="flex items-center font-bold uppercase">
          <span class="hidden md:inline-flex">Next</span>
          <svg viewBox="0 0 7.094 13" class="w-4 h-4 fill-current ml-1.5">
            <path d="m.678 12.915 6.414-6.413L.678.09a.29.29 0 0 0-.484.125 5.226 5.226 0 0 0 2.592 6.031.291.291 0 0 1 0 .519A5.226 5.226 0 0 0 .198 12.79a.29.29 0 0 0 .484.125"/>
          </svg>
        </button>
      </li>

    </ul>
  </nav>
  <!-- Close Pagination -->

</template>
