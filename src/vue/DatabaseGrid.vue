<script setup>
import { onMounted, ref, watch } from 'vue';
import { storeToRefs } from 'pinia';
import { breakpointsTailwind, useBreakpoints } from '@vueuse/core';
import { useDatabaseStore } from '../stores/databaseStore';

import DatabaseItemMeta from './DatabaseItemMeta.vue';
import DatabaseFilterBar from './DatabaseFilterBar';

const breakpoints = useBreakpoints(breakpointsTailwind);
const smAndSmaller = breakpoints.smaller('sm');

const store = useDatabaseStore();

const { items } = storeToRefs(store);

const toggleItem = (id) => {
  if (store.selectedItem === id) {
    store.selectedItem = 0;
  } else {
    store.selectedItem = id;
  }
};

const paginate = (page = 1, perPage = 6, maxVisibleButtons = 5) => {
  // If mobile breakpoint reduce number of pagination items
  if (smAndSmaller.value) {
    maxVisibleButtons = 3;
  }

  const offset = perPage * (page - 1);
  const totalPages = Math.ceil(items.value.length / perPage);
  const paginatedItems = items.value.slice(offset, perPage * page);

  const startPage = Math.max(1, page - Math.floor(maxVisibleButtons / 2));
  const endPage = Math.min(totalPages, startPage + maxVisibleButtons - 1);
  const pages = Array.from({ length: endPage - startPage + 1 }, (_, i) => startPage + i);

  const targetNavHeight = document.getElementById('header-nav');
  const navHeight = targetNavHeight.offsetHeight;

  if (page > 1) {
    // Scroll to Element
    document.querySelector('.js-database').scrollIntoView(true);

    const scrolledY = window.scrollY; // Offset Nav Bar

    if (scrolledY) {
      window.scroll({
        top: scrolledY - navHeight,
        behavior: 'smooth',
      });
    }
  }
 
  pagedItems.value = {
    previousPage: page - 1 ? page - 1 : null,
    nextPage: totalPages > page ? page + 1 : null,
    from: offset + 1,
    to: offset + paginatedItems.length,
    currentPage: page,
    total: items.value.length,
    totalPages: totalPages,
    items: paginatedItems,
    maxVisibleButtons: maxVisibleButtons,
    pages: pages,
  };
};

const pagedItems = ref([]);

watch(items, (items) => {
  paginate();
});

onMounted(() => {
  paginate();
});
</script>

<template>
  <DatabaseFilterBar></DatabaseFilterBar>
  <!-- Database Tiles -->
  <section class="bg-beige-200" v-if="items.length">

    <!-- Container -->
    <div class="container py-20 lg:py-24">
      <!-- Widths -->
      <div class="relative w-11/12 mx-auto">
        <!-- Current Tile Range / Count -->
        <div class="absolute right-0 h-20 text-right -top-8 text-beige-800">
          {{ pagedItems.from }} - {{ pagedItems.to }} of {{ pagedItems.total }}
        </div>

        <!-- Tiles Wrapper -->
        <div class="grid gap-6 md:grid-cols-2 lg:gap-8 xl:grid-cols-3">

          <!-- Tile -->
          <div v-for="item in pagedItems.items"
            :key="item.id"
            @click="toggleItem(item.id)"
            :class="{
              'after:opacity-0 after:duration-500 group lg:hover:after:opacity-100 cursor-pointer':
              store.selectedItem != item.id,
            }"
            class="relative z-10 flex flex-col self-start select-none offset-frame-right offset-frame-light-green"
            >

            <!-- Image Wrapper -->
            <div class="relative">
              <!-- Featured -->
              <span
                v-if="item.acf.database_featured && !item.acf.database_hide_featured_label"
                class="absolute inset-x-0 top-0 left-0 z-10 flex items-center justify-center h-8 bg-orange-500 w-28"
                >
                <p class="font-bold text-center text-white uppercase leading-2">
                  {{ store.label }}
                </p>
              </span>
              <div class="aspect-w-5 aspect-h-4">
                <img
                  :src="item.featured_img_url ? item.featured_img_url : store.getPlaceholderImage(item.database_categories)"
                  :alt="item.title.rendered"
                  loading="lazy"
                  width="370"
                  height="295"
                  class="absolute inset-0 object-cover w-full h-full"
                />
              </div>
            </div>
            <!-- Close Image Wrapper -->

            <!-- Tile Content -->
            <div class="p-8 bg-white">
              <!-- Title / Toggle Open -->
              <div
                class="min-h-[3rem] md:min-h-[3.5rem] xl:min-h-[4rem] flex items-center justify-between"
              >
                <h5
                  class="lg:w-[93%] pr-4 w-11/12 group-hover:text-green-800 text-xl leading-4 uppercase duration-500 lg:text-2xl lg:leading-5"
                  :class="store.selectedItem == item.id ? 'text-green-800' : 'text-gray-300'"
                  v-html="item.title.rendered"
                ></h5>
                <svg
                  v-if="store.selectedItem != item.id"
                  class="w-5 h-5 text-gray-200 duration-500 fill-current group-hover:text-green-800"
                  viewBox="0 0 20 20"
                >
                  <title>Open</title>
                  <path
                    d="M18.3 8.3h-6.4V1.9c0-1-.7-1.8-1.7-1.9S8.3.7 8.3 1.7V8.3H1.9C.9 8.2.1 9 0 10s.7 1.8 1.7 1.9H8.3v6.4c0 1 .9 1.8 1.9 1.7.9 0 1.7-.8 1.7-1.7v-6.4h6.4c1 0 1.8-.9 1.7-1.9 0-.9-.8-1.7-1.7-1.7"
                  />
                </svg>
                <button v-else>
                  <svg
                    class="w-5 h-5 text-green-800 cursor-pointer fill-current"
                    viewBox="0 0 20 20"
                  >
                    <title>Close</title>
                    <path
                      d="M18.3 11.7H1.7c-1 0-1.7-.8-1.7-1.7 0-.9.7-1.7 1.7-1.7h16.7c.9 0 1.7.7 1.7 1.7-.1.9-.8 1.7-1.8 1.7z"
                    />
                  </svg>
                </button>
              </div>
              <!-- Close Title / Toggle Open -->

              <!-- Text / CTA Wrapper -->
              <div v-if="store.selectedItem == item.id">
                <!-- Copy -->
                <p
                  v-if="item.acf.database_description"
                  v-html="item.acf.database_description"
                  class="block mb-5">
                </p>

                <DatabaseItemMeta :item="item.acf"></DatabaseItemMeta>
              </div>
            </div>
            <!-- Close Tile Content -->
            
          </div>
          <!-- Close Tile -->

        </div>
        <!-- Close Tiles Wrapper -->

        <!-- Pagination -->
        <nav v-if="pagedItems.totalPages > 1" aria-label="pagination" class="w-11/12 mx-auto mt-12 md:mt-20 md:w-10/12">
          <ul class="flex items-center justify-center text-beige-800">

            <!-- Previous -->
            <li v-if="pagedItems.previousPage">
              <button @click="paginate(pagedItems.previousPage)" class="flex items-center mr-3 font-bold uppercase select-none md:mr-6">
                <svg viewBox="0 0 7.094 13" class="w-4 h-4 fill-current rotate-180 md:mr-1.5">
                  <path
                    d="m.678 12.915 6.414-6.413L.678.09a.29.29 0 0 0-.484.125 5.226 5.226 0 0 0 2.592 6.031.291.291 0 0 1 0 .519A5.226 5.226 0 0 0 .198 12.79a.29.29 0 0 0 .484.125"
                  />
                </svg>
                <span class="hidden md:inline-flex">Prev</span>
              </button>
            </li>

            <!-- Pages -->
            <li v-if="pagedItems.currentPage > (pagedItems.maxVisibleButtons - 1)  && pagedItems.totalPages >= pagedItems.maxVisibleButtons" class="flex mx-2">
              <button @click="paginate(1)" class="flex items-center mr-3 font-bold md:mr-6">
                1
              </button>
              <span class="ml-2 font-bold">...</span>
            </li>

            <li v-for="index in pagedItems.pages" :key="index" class="flex mx-2">
              <button
                @click="paginate(index)"
                class="px-4 py-2 font-bold rounded-md cursor-pointer md:px-5 md:py-3"
                :class="{ 'text-white bg-green-500': pagedItems.currentPage == index }"
                aria-current="page"
              >
                {{ index }}
              </button>
            </li>

            <li v-if="pagedItems.currentPage < (pagedItems.totalPages - 2) && pagedItems.totalPages > pagedItems.maxVisibleButtons" class="flex mx-2">
              <span class="ml-2 font-bold">...</span>
              <button @click="paginate(pagedItems.totalPages)" class="flex items-center ml-3 font-bold md:ml-6">
                {{ pagedItems.totalPages }}
              </button>
            </li>

            <!-- Next -->
            <li v-if="pagedItems.nextPage">
              <button @click="paginate(pagedItems.nextPage)" class="flex items-center ml-3 font-bold uppercase select-none md:ml-6">
                <span class="hidden md:inline-flex">Next</span>
                <svg viewBox="0 0 7.094 13" class="w-4 h-4 fill-current md:ml-1.5">
                  <path
                    d="m.678 12.915 6.414-6.413L.678.09a.29.29 0 0 0-.484.125 5.226 5.226 0 0 0 2.592 6.031.291.291 0 0 1 0 .519A5.226 5.226 0 0 0 .198 12.79a.29.29 0 0 0 .484.125"
                  />
                </svg>
              </button>
            </li>
          </ul>
        </nav>
        <!-- Close Pagination -->
      </div>
      <!-- Close Widths -->
    </div>
    <!-- Close Container -->
  </section>
  <!-- Close Database Tiles -->
</template>
