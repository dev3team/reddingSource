<script setup>
import { onMounted } from 'vue';
import { useDatabaseStore } from '../stores/databaseStore';

import DatabaseGrid from './DatabaseGrid';
import DatabaseMap from './DatabaseMap';

const store = useDatabaseStore();

const urlArr = location.href.split('/').filter(item => item.length > 0).pop();

const props = defineProps({
  terms: Array,
  hotelTerms: Array,
  view: String,
  hideFilter: Boolean
});

onMounted(() => {
  // Update the store with the terms
  store.terms = props.terms;
  store.activeTerms = []; //props.terms;

  store.hotelTerms = [];

  // Update view in store
  store.view = props.view;

  // Hide filter button
  store.hideFilter = props.hideFilter;

  // Get Terms
  store.getTerms();

  // Fetch all items
  store.getPosts();


});
</script>

<template>
  <!-- Loading -->
  <svg v-if="!store.loaded"
    xmlns="http://www.w3.org/2000/svg"
    class="w-12 h-12 mx-auto my-6 text-green-500 stroke-current stroke-3"
    viewBox="0 0 38 38"
    >
    <g transform="translate(1 1)" fill="none">
      <circle stroke-opacity="0.5" cx="18" cy="18" r="17" />
      <path d="M35 18c0-9.3-7.6-17-17-17">
        <animateTransform
          attributeName="transform"
          type="rotate"
          from="0 18 18"
          to="360 18 18"
          dur="1s"
          repeatCount="indefinite"
        />
      </path>
    </g>
  </svg>

  <keep-alive>
    <component v-if="store.loaded" :is="( store.view === 'grid' ) ? DatabaseGrid : DatabaseMap" :key="store.view"></component>
  </keep-alive>
</template>
