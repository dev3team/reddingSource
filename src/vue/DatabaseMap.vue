<script setup>
import { ref, watch, nextTick, computed, onActivated, onDeactivated } from 'vue';
import { storeToRefs } from 'pinia';
import { useDatabaseStore } from '../stores/databaseStore';
import { breakpointsTailwind, useBreakpoints } from '@vueuse/core';

import DatabaseItemMeta from './DatabaseItemMeta.vue';
import DatabaseFilterBar from './DatabaseFilterBar';

const isTouchDevice = "ontouchstart" in document.documentElement;
const breakpoints = useBreakpoints(breakpointsTailwind);
const lgAndSmaller = breakpoints.smaller('lg');

const store = useDatabaseStore();
const map = ref(null);
const markers = ref([]);
const { items, loaded } = storeToRefs(store); // Store properties available as vue refs
const activeMarker = ref({});
const itemsLength = ref(20);
const mapListWrapper = ref(null);
const mapWrapper = ref(null);
const mapActive = ref(false);

// create paged items
const pagedItems = computed(() => {
  return items.value.slice(0, itemsLength.value);
});

// create load more method
const loadMore = () => {
  itemsLength.value += 20;
};

const createMarkers = (items) => {
  const markers = [];

  items.forEach((item) => {
    const marker = {
      id: item.id,
      position: {
        lat: parseFloat(item.acf.database_coordinates.lat),
        lng: parseFloat(item.acf.database_coordinates.long),
      },
    };

    markers.push(marker);
  });

  return markers;
};

const fitBoundsToVisibleMarkers = () => {
  const bounds = new google.maps.LatLngBounds();

  markers.value.forEach((marker) => {
    bounds.extend(marker.position);
  });

  map.value.fitBounds(bounds);
};

// Set item to active
const selectItem = (id, e) => {
  // Marker pin was clicked
  if (e && e.hasOwnProperty('latLng')) {
    // Update the max items to be full list
    itemsLength.value = items.value.length;
  }

  // Set active marker
  const marker = markers.value.find((marker) => marker.id === id);

  // If same item selected
  if (store.selectedItem === marker.id && !isTouchDevice) {
    store.selectedItem = null;

    activeMarker.value = {};

    fitBoundsToVisibleMarkers();
  } else {
    store.selectedItem = marker.id;

    // Set zoom level
    map.value.$mapObject.setZoom(12);

    // Pan to the selected marker
    map.value.panTo(marker.position);

    // Set active marker
    activeMarker.value = marker;

    nextTick(() => {
      scrollToItem(id);
    });
  }
};

const hoverMarker = (id, e) => {
  const marker = markers.value.find((marker) => marker.id === id);

  // Set active marker
  if (!isTouchDevice) {
    activeMarker.value = marker;
  }
};

// Watch items in store for changes
watch(items, (items) => {
  // Create markers from items
  markers.value = createMarkers(items);

  if (map.value) {
    fitBoundsToVisibleMarkers();
  }
});

// Watch map for changes
watch(map, (googleMap) => {
  if (googleMap) {
    googleMap.$mapPromise.then((map) => {
      fitBoundsToVisibleMarkers();
    });
  }
});

// Scroll window to item
const scrollToItem = (id) => {
  const itemElm = document.querySelector(`[data-item-id="${id}"]`);
  const itemTop = itemElm.offsetTop; // Get top of item

  if (lgAndSmaller.value) {
    const yOffset = document.getElementById('header-nav').getBoundingClientRect().height
    const el = mapWrapper.value;
    const y = el.getBoundingClientRect().top + window.pageYOffset - yOffset;

    window.scrollTo({top: y, behavior: 'smooth'});
    mapListWrapper.value.scrollTop = itemTop - 480;
  } else {
    mapListWrapper.value.scroll({
      top: itemTop,
      behavior: 'smooth',
      block: 'start'
    });
  }
};

onActivated(() => {
  mapActive.value = true;

  // Create markers from items
  markers.value = createMarkers(items.value);

  if (map.value) {
    fitBoundsToVisibleMarkers();
  }
});

onDeactivated(() => {
  mapActive.value = false;
});
</script>

<template>
  <DatabaseFilterBar v-if="!lgAndSmaller.value && loaded"></DatabaseFilterBar>
  <!-- Database Map -->
  <section v-if="loaded" class="relative flex flex-col lg:container lg:flex-row lg:flex-wrap">

    <!-- Map -->
    <div ref="mapWrapper" v-if="mapActive" class="z-10 lg:sticky lg:top-[6.25rem] lg:w-[53%] h-96 lg:h-[50rem] lg:order-3">
      <GMapMap
        v-if="markers"
        ref="map"
        class="h-96 lg:h-full"
        :center="{ lat: 51.093048, lng: 6.84212 }"
        map-type-id="terrain"
        :options="{
          zoomControl: true,
          mapTypeControl: false,
          scaleControl: false,
          streetViewControl: false,
          rotateControl: false,
          fullscreenControl: true,
          disableDefaultUi: true,
          scrollwheel: false,
          draggable: true,
          gestureHandling: 'cooperative'
          // gestureHandling: lgAndSmaller ? 'none' : 'cooperative'
        }"
      >
        <GMapMarker
          :key="'marker_' + marker.id"
          v-for="marker in markers"
          :position="marker.position"
          :zIndex="activeMarker.id === marker.id ? 2 : 1"
          @click="selectItem(marker.id, $event)"
          @mouseover="hoverMarker(marker.id, $event)"
          :icon="{
            path: 'M10.518,0A10.518,10.518,0,0,0,0,10.518C0,14.538,9.4,25.89,10.518,26c.631.1,10.518-11.461,10.518-15.481A10.518,10.518,0,0,0,10.518,0m0,14.616a4.1,4.1,0,1,1,4.1-4.1,4.1,4.1,0,0,1-4.1,4.1',
            fillColor: activeMarker.id === marker.id ? '#FF4C00' : '#35584e',
            fillOpacity: 1,
            strokeWeight: 2,
            strokeColor: '#fff',
            anchor: { x: 10.5, y: 26 },
            scale: activeMarker.id === marker.id ? 1.5 : 1,
          }"
        />
      </GMapMap>
    </div>
    <!-- Close Map -->

    <!-- Filter Bar -->
    <div v-if="lgAndSmaller" class="lg:order-1 lg:w-full">
      <DatabaseFilterBar></DatabaseFilterBar>
    </div>

    <!-- Rows Wrapper -->
    <div ref="mapListWrapper" class="h-[25rem] lg:h-[50rem] mx-auto py-10 w-11/12 md:mb-10 md:w-10/12 overflow-scroll lg:pr-7 lg:w-[47%] xl:p-10 lg:order-2">
      <!-- Row -->
      <div
        v-for="item in pagedItems"
        :key="item.id"
        :data-item-id="item.id"
        class="mb-4"
        :class="{ 'cursor-pointer group': store.selectedItem != item.id }"
      >
        <!-- Image / Title -->
        <div class="flex items-center select-none" @click="selectItem(item.id)">

          <!-- Image Wrapper -->
          <div class="w-1/5 md:p-4 lg:p-0 xl:p-3">
            <div class="relative">
              <!-- Featured -->
              <span
                v-if="item.acf.database_featured && !item.acf.database_hide_featured_label"
                class="absolute top-0 z-10 flex items-center justify-center w-full h-5 bg-orange-500"
                >
                <p class="text-xs font-bold leading-none text-center text-white uppercase">
                  {{ store.label }}
                </p>
              </span>
              <div class="bg-green-900 aspect-w-1 aspect-h-1">
                <img
                  :src="item.featured_img_url ? item.featured_img_url : store.getPlaceholderImage(item.database_categories)"
                  :alt="item.title.rendered"
                  loading="lazy"
                  width="375"
                  height="320"
                  class="absolute inset-0 block object-cover w-full h-full"
                />
              </div>
            </div>
          </div>
          <!-- Close Image Wrapper -->

          <!-- Title / Toggle Open -->
          <div class="w-4/5 pl-3 font-bold uppercase duration-500 md:pl-5 xl:pl-3 2xl:pl-4 group-hover:text-green-800"
            :class="store.selectedItem == item.id ? 'text-green-800' : 'text-gray-300'">
            <span class="block text-sm md:-mb-1 md:text-base" v-html="item.categories_names[0]">
            </span>
            <div class="flex items-center justify-between">
              <h5 class="w-11/12 pr-3 text-xl font-black leading-4 uppercase md:leading-6.25 md:pr-16 xl:pr-8 md:text-2"
                v-html="item.title.rendered">
              </h5>
              <span>
                <svg
                  v-if="store.selectedItem != item.id"
                  class="w-5 h-5 text-gray-200 duration-500 cursor-pointer fill-current group-hover:text-green-800"
                  viewBox="0 0 20 20"
                >
                  <title>Open</title>
                  <path
                    d="M18.3 8.3h-6.4V1.9c0-1-.7-1.8-1.7-1.9S8.3.7 8.3 1.7V8.3H1.9C.9 8.2.1 9 0 10s.7 1.8 1.7 1.9H8.3v6.4c0 1 .9 1.8 1.9 1.7.9 0 1.7-.8 1.7-1.7v-6.4h6.4c1 0 1.8-.9 1.7-1.9 0-.9-.8-1.7-1.7-1.7"
                  />
                </svg>
                <svg
                  v-else
                  class="w-5 h-5 text-green-800 cursor-pointer fill-current"
                  viewBox="0 0 20 20"
                >
                  <title>Close</title>
                  <path
                    d="M18.3 11.7H1.7c-1 0-1.7-.8-1.7-1.7 0-.9.7-1.7 1.7-1.7h16.7c.9 0 1.7.7 1.7 1.7-.1.9-.8 1.7-1.8 1.7z"
                  />
                </svg>
              </span>
            </div>
          </div>
          <!-- Close Title / Toggle Open -->

        </div>
        <!-- Image / Title -->

        <!-- Text / CTA Wrapper -->
        <div v-if="store.selectedItem == item.id" class="mb-10 md:w-4/5 md:pl-5 xl:pl-3 2xl:pl-4 md:ml-auto">

          <!-- Copy -->
          <p
            v-if="item.acf.database_description"
            v-html="item.acf.database_description"
            class="mt-5 mb-5 md:pr-16 md:mt-0">
          </p>
          
          <DatabaseItemMeta :item="item.acf"></DatabaseItemMeta>
        </div>
        <!-- Close Text / CTA Wrapper -->
      </div>
      <!-- Close Row -->

      <button
        v-if="items.length > itemsLength"
        @click="loadMore()"
        class="flex items-center justify-center px-8 py-3 mx-auto text-base font-bold tracking-wider text-white uppercase duration-500 ease-in-out rounded-lg group button-green whitespace-nowrap md:w-auto"
      >
        Load More
      </button>
    </div>
    <!-- Close Rows Wrapper -->

  </section>
  <!-- Close Database Map -->
</template>
