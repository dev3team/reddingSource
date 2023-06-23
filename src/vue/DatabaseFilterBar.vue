<script setup>
import { onMounted, ref } from 'vue';
import { useDatabaseStore } from '../stores/databaseStore';

const store = useDatabaseStore()

const filterOpen = ref(false);

onMounted(() => {
  // Get terms for filter bar
  store.getTerms();
});
</script>

<template>
  <!-- Filter Bar -->
  <section class="flex items-center py-3.5 text-sm border-t border-b border-gray-100 text-beige-800"
    :class="store.hideFilter ? 'justify-center md:justify-end' : 'md:justify-between'"
    >

    <!-- Filter -->
    <button v-if="!store.hideFilter" @click="filterOpen = !filterOpen" class="flex items-center px-3 md:px-8 py-2.5 uppercase hover:text-green-500 duration-500 border-r md:border-none border-gray-100 w-1/3 md:w-auto justify-center"
      :class="{ 'text-green-500' : filterOpen }">
      <svg viewBox="0 0 28 28" class="w-8 h-8 mr-3 fill-current">
        <path d="M14 8.8c-1 0-1.9-.5-2.4-1.2-1.2-1.6-3.4-1.9-4.9-.7-.3.2-.5.4-.7.7-.6.7-1.5 1.2-2.5 1.2H0v2.1h3.8c.9 0 1.7.4 2.3 1.1 1.3 1.5 3.5 1.6 4.9.4l.4-.4c.6-.7 1.4-1.1 2.3-1.1H28V8.8H14zM18.6 14.8c-1.1 0-2.1.5-2.8 1.4-.6.8-1.5 1.2-2.4 1.2H0v2.1h13.6c.9 0 1.7.4 2.3 1.1 1.3 1.5 3.5 1.6 4.9.4l.4-.4c.6-.7 1.4-1.1 2.3-1.1H28v-2.1h-4.2c-1 0-1.9-.5-2.4-1.2-.7-.9-1.7-1.4-2.8-1.4"/>
      </svg>
      <span>
        Filter
      </span>
    </button>
    <!-- Close Filter -->

    <!-- Map / Grid -->
    <div class="contents md:flex">
      <!-- Map -->
      <button @click="store.view = 'map'" 
        class="flex items-center px-3 md:px-8 py-2.5 md:border-l border-r border-gray-100 uppercase hover:text-green-500 duration-500 w-1/3 md:w-auto justify-center"
        :class="{ 'text-green-500': store.view === 'map' }"
      >
        <svg viewBox="0 0 28 28" class="w-8 h-8 mr-3 fill-current">
          <path d="M14 28h-.2c-1.4-.1-4.6-4.2-6.4-6.6-2.3-3-5-7.2-5-9.8C2.4 5.2 7.6 0 14 0c6.4 0 11.6 5.2 11.6 11.6 0 4.4-8.7 14.5-10.3 15.8-.2.2-.7.6-1.3.6zm0-26.6v1.4c-4.8 0-8.7 3.9-8.7 8.7 0 2.6 6.3 10.9 8.6 13.1 1-1 2.8-3.1 4.6-5.6 3.1-4.1 4.2-6.6 4.2-7.6 0-4.8-3.9-8.7-8.7-8.7V1.4zM14 17c-3 0-5.4-2.4-5.4-5.4 0-3 2.4-5.4 5.4-5.4 3 0 5.4 2.4 5.4 5.4 0 3-2.4 5.4-5.4 5.4zm0-7.9c-1.4 0-2.5 1.1-2.5 2.5s1.1 2.5 2.5 2.5 2.5-1.1 2.5-2.5-1.1-2.5-2.5-2.5z"/>
        </svg>
        <span>
          Map
        </span>
      </button>

      <!-- Grid -->
      <button @click="store.view = 'grid'" 
        class="flex items-center px-3 md:px-8 py-2.5 uppercase hover:text-green-500 duration-500 w-1/3 md:w-auto justify-center"
        :class="{ 'text-green-500': store.view === 'grid' }"
      >
        <svg viewBox="0 0 28 28" class="w-8 h-8 mr-3 fill-current">
          <path d="M10.9 13H1.6C.7 13 0 12.3 0 11.4V2.1C0 1.2.7.5 1.6.5h9.3c.9 0 1.6.7 1.6 1.6v9.3c-.1.9-.8 1.6-1.6 1.6zM3.1 9.9h6.2V3.6H3.1v6.3zM26.4 13h-9.3c-.9 0-1.6-.7-1.6-1.6V2.1c0-.9.7-1.6 1.6-1.6h9.3c.9 0 1.6.7 1.6 1.6v9.3c0 .9-.7 1.6-1.6 1.6zm-7.7-3.1h6.2V3.6h-6.2v6.3zM10.9 27.5H1.6c-.9 0-1.6-.7-1.6-1.6v-9.3c0-.9.7-1.6 1.6-1.6h9.3c.9 0 1.6.7 1.6 1.6v9.3c-.1.9-.8 1.6-1.6 1.6zm-7.8-3.1h6.2v-6.2H3.1v6.2zM26.4 27.5h-9.3c-.9 0-1.6-.7-1.6-1.6v-9.3c0-.9.7-1.6 1.6-1.6h9.3c.9 0 1.6.7 1.6 1.6v9.3c0 .9-.7 1.6-1.6 1.6zm-7.7-3.1h6.2v-6.2h-6.2v6.2z"/>
        </svg>
        <span>
          Grid
        </span>
      </button>
    </div>
    <!-- Close Map / Grid -->

  </section>
  <!-- Close Filter Bar -->

  <!-- Filter Bar Open -->
  <div v-if="filterOpen" class="w-10/12 mx-auto" :class="store.curUrl === 'stay' ? store.hotelsFilterOpen ? 'pt-16 pb-2' : 'py-16' : store.curUrl === 'hotels' ? 'hidden' : 'py-16'">
     <span v-for="(term) in store.allTerms" :key="term.id">
      <input v-model="store.activeTerms" type="checkbox" :id="'term_' + term.id" :value="term.id" name="selectedTerms">
      <label :for="'term_' + term.id" class="inline-block mr-7 mb-7"><span v-html="term.name"></span></label>
    </span>
  </div>

  <!-- Hotels Filter Open -->
  <div v-if="store.hotelsFilterOpen && filterOpen" class="w-10/12 mx-auto" :class="store.curUrl === 'hotels' ? 'py-16' : 'pt-3 pb-8' ">
    <span v-for="(term) in store.hotelTerms" :key="term.id">
      <input v-model="store.activeTerms" type="checkbox" :id="'term_' + term.id" :value="term.id" name="selectedTerms">
      <label :for="'term_' + term.id" class="inline-block mr-7 mb-7"><span v-html="term.name"></span></label>
    </span>
  </div>
</template>