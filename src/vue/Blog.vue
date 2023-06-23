<script setup>
import { onMounted } from 'vue';
import { useBlogStore } from '../stores/blogStore';

import BlogFilters from './BlogFilters.vue';
import Pagination from './Pagination.vue';

const store = useBlogStore()

const props = defineProps({
  postType: String,
});

const dateString = (date) => {
  const dateObject = new Date(date);
  const month = dateObject.toLocaleString("default", { month: "long" });
  
  return (
    month + " " + dateObject.getDate() + ", " + dateObject.getFullYear()
  );
}

onMounted(() => {
  // Update the store with the terms
  store.postType = props.postType;

  // Get all the posts on load
  store.getPosts();
});
</script>

<template>
  <blog-filters></blog-filters>

  <div class="pt-12 pb-20 bg-beige-200 md:pt-16 md:pb-24">
    <!-- Posts Container -->
    <div class="container">
      <!-- Count -->
      <div class="flex justify-end w-11/12 mx-auto mb-3">
        <span class="text-sm text-beige-800 md:text-base">
          {{ store.pagination.from }}-{{ store.pagination.to }} of {{ store.pagination.total }}
        </span>
      </div>
      <!-- Grid Wrapper -->
      <div class="grid w-11/12 grid-cols-12 gap-6 mx-auto lg:gap-7">
        <!-- Grid Item -->
        <div v-for="(item, index) in store.items"
          :key="item.id"
          class="relative z-10 col-span-12 offset-frame-right offset-frame-light-green after:opacity-0 after:duration-500 hover:after:opacity-100"
          :class="{ 'md:col-span-6 xl:col-span-4' : index > 0 }">

          <a :href="item.link" class="flex flex-col h-full">
            <!-- Image -->
            <div class="relative bg-green-800 aspect-w-16 aspect-h-11"
              :class="{ 'md:aspect-h-7' : index === 0 }">

              <img
                v-if="item.featured_img_url"
                :src="index === 0 ? item.featured_img_url_large : item.featured_img_url"
                alt=""
                loading="lazy"
                width="375"
                height="320"
                class="absolute inset-0 block object-cover w-full h-full">

            </div>

            <!-- Content -->
            <div class="flex flex-col py-8 bg-white px-7 md:h-full lg:p-9">
              <span
                v-html="item.categories_names.join(', ')"
                class="text-sm font-bold tracking-wider uppercase text-beige-800">
              </span>

              <!-- Title -->
              <h4 v-html="item.title.rendered"
                class="mb-3 font-bold leading-none text-green-800 font-runda"
                :class="index === 0 ? 'text-2xl' : 'text-xl'">
              </h4>

              <!-- Excerpt -->
              <div class="mb-6" v-html="item.excerpt.rendered"></div>
              
              <!-- Date -->
              <span class="mt-auto text-sm uppercase">
                {{ dateString(item.date) }}
              </span>
            </div>
          </a>

        </div>
        <!-- Close Grid Item -->

      </div>
      <!-- Close Grid Wrapper -->

      <!-- Pagination -->
      <div v-if="store.pagination.totalPages > 1">
        <pagination></pagination>
      </div>

    </div>
    <!-- Close Posts Container -->
  </div>
</template>
