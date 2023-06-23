<script setup>
import { onMounted } from 'vue';
import { useBlogStore } from '../stores/blogStore';

const store = useBlogStore();

const setTerm = (term_id = null) => {
  store.selectedTerm = term_id;
  store.args.page = 1;

  if (!term_id) {
    delete store.args.categories;
  } else {
    store.args = {
      ...store.args,
      categories: term_id,
    }
  }

  store.getPosts();
}

onMounted(() => {
  // Get terms for filter bar
  store.getTerms();
});
</script>

<template>
  <!-- Filters -->
  <div class="border-t border-gray-100">
    <div class="container py-6 md:py-8">

      <!-- Mobile Select Dropdown -->
      <form class="w-10/12 mx-auto md:hidden">
        <label for="category-select" class="sr-only">Select Category</label>
        <select name="category-select" 
          @change="setTerm($event.target.value)"
          id="category-select"
          class="w-full text-sm tracking-wider uppercase bg-no-repeat border-none cursor-pointer focus:border-none focus:ring-0 mobile-select-dropdown"
        >
          <option selected value="">
            View All
          </option>
          <option v-for="(term) in store.allTerms" :key="term.id" :value="term.id">
            {{ term.name }}
          </option>
        </select>
      </form>

      <!-- Tablet/Desktop Buttons -->
      <ul class="justify-center hidden w-11/12 mx-auto text-sm md:flex">
        <li class="mx-3 lg:mx-4">
          <button @click="setTerm()"
            class="tracking-wider uppercase hover:text-green-800"
            :class="{ 'font-bold text-green-800' : store.selectedTerm === null }"
          >
            View All
          </button>
        </li>
        <li v-for="(term) in store.allTerms" :key="term.id" class="mx-3 lg:mx-4">
          <button @click="setTerm(term.id)" 
            class="tracking-wider uppercase hover:text-green-800"
            :class="{ 'font-bold text-green-800' : store.selectedTerm === term.id }"
          >
            {{ term.name }}
          </button>
        </li>
      </ul>

    </div>
  </div>
  <!-- Close Filters -->
</template>