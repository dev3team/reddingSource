<script setup>
import { onMounted, ref } from 'vue';

const props = defineProps({
  itineraryId: Number,
});

const apiUrl = tofinoJS.siteURL + '/wp-json/wp/v2/itinerary/';

const svgUrl = tofinoJS.themeUrl + '/dist/svg/itinerary-numbered-icon-default.svg';

const getSvgIcon = (stopNumber) => {
  if (stopNumber === seletedStop.value) {
    return tofinoJS.themeUrl + `/dist/svg/itinerary-numbered-icon-${stopNumber+1}-selected.svg`;
    // return tofinoJS.themeUrl + `/dist/svg/itinerary-numbered-icon-selected.svg`;
  } else {
    // return tofinoJS.themeUrl + `/dist/svg/itinerary-numbered-icon-default.svg`;
    return tofinoJS.themeUrl + `/dist/svg/itinerary-numbered-icon-${stopNumber+1}-default.svg`;
  }
}

const itinerary = ref({});

const seletedStop = ref(0);

const getItinerary = async (itineraryId) => {
  const response = await fetch(apiUrl + `${itineraryId}`);
  const result = await response.json();

  itinerary.value = result.acf;

  return result;
};

const createMarkers = () => {
  const markers = [];

  itinerary.value.itinerary_stops.forEach((stop, index) => {
    const marker = {
      id: index,
      position: {
        lat: parseFloat(stop.stop_coordinates.lat),
        lng: parseFloat(stop.stop_coordinates.long),
      },
      title: stop.stop_title,
    };

    markers.push(marker);
  });

  return markers;
}

const fitBoundsToVisibleMarkers = () => {
  const bounds = new google.maps.LatLngBounds();

  markers.value.forEach((marker) => {
    bounds.extend(marker.position);
  });

  map.value.fitBounds(bounds);
}

const map = ref(null)

const markers = ref([]);

const onMarkerClick = (markerId) => {
  // center map on marker
  // map.value.panTo(marker.position);

  seletedStop.value = markerId;
};

onMounted(() => {
  getItinerary(props.itineraryId).then(itinerary => {
    markers.value = createMarkers();

    fitBoundsToVisibleMarkers();

  });
}); 

</script>

<template>
  <!-- Itineraries -->
  <section class="container py-12 md:py-24 xl:py-32 lg:flex lg:flex-row-reverse">

    <!-- Map -->
    <div class="lg:sticky xl:pl-7 mb-16 md:mb-28 lg:mb-0 lg:top-[6.25rem] h-96 lg:w-1/2 xl:w-7/12 md:h-[36rem] lg:h-[50rem]">
      <GMapMap
        ref="map"
        class="h-full"
        :center="{lat: 40.5741238, lng: -122.5028146}"
        :zoom="7"
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
        }"
        >

        <GMapMarker
          :key="marker.id"
          v-for="(marker, index) in markers"
          :position="marker.position"
          :zIndex="index === seletedStop ? 2 : 1"
          :clickable="true"
          @click="onMarkerClick(marker.id)"
          :icon='{
            url: getSvgIcon(index),
            // url: index === seletedStop ? getSvgIcon(index) : getSvgIcon(index, true),
            scaledSize: { width: index === seletedStop ? 60 : 40, height: index === seletedStop ? 60 : 40 },
          }'
        />
      </GMapMap>
    </div>
    <!-- Close Map -->
    
    <!-- Content Wrapper -->
    <div class="w-10/12 mx-auto lg:w-1/2 xl:w-5/12 lg:pr-7 xl:pr-9 lg:ml-10">
      
      <!-- Intro -->
      <div class="mb-14">
        <h3 class="text-4xl md:mb-5 md:text-[4.125rem] text-green-800 uppercase">
          Itinerary
        </h3>
        <p class="text-lg"
          v-html="itinerary.itinerary_description">
        </p>
        <!-- Close Intro -->
      </div>
      
      <!-- Rows Wrapper -->
      <div>
        
        <!-- Row -->
        <div v-for="(stop, index) in itinerary.itinerary_stops" :key="index"
          :class="[(index === seletedStop ? 'before:bg-orange-500 pb-18' : 'before:bg-gray-400'), ((index + 1) === markers.length ? 'pb-0' : 'pb-8 md:pb-14')]"
          class="relative before:w-[3px] before:h-full before:absolute before:top-0 before:inset-x-0 lg:before:-left-0.5"
          >

          <!-- Indicator / Title -->
          <div class="relative flex items-center" @click="onMarkerClick(index)">

            <!-- Indicator -->
            <div 
              :class="index === seletedStop ? 'items-start' : 'items-center'"
              class="flex h-full cursor-pointer">
              <span :class="index === seletedStop ? 'bg-orange-500 text-white border-orange-500 md:scale-150' : 'text-gray-400 border-gray-400 bg-white'"
                class="flex items-center justify-center w-8 h-8 font-black leading-3 text-center transform -translate-x-3.5 border-4 rounded-full md:-translate-x-5 font-runda md:text-lg md:w-10 md:h-10">
                {{ index + 1 }}
              </span>
            </div>

            <!-- Title / Toggle Open -->
            <h4 class="w-full">
              <button
                class="flex items-center justify-between w-full duration-500 hover:text-green-800"
                :class="index === seletedStop ? 'text-green-800' : 'text-gray-400'"
                >

                <!-- Title -->
                <span class="pr-10 text-xl font-black leading-4 text-left uppercase md:leading-6.25 md:pr-20 md:text-2"
                  v-html="stop.stop_title">
                </span>
                
                <!-- Icon -->
                <span>
                  <svg v-if="index !== seletedStop" class="w-5 h-5 fill-current" viewBox="0 0 20 20">
                    <title>Open</title>
                    <path d="M18.3 8.3h-6.4V1.9c0-1-.7-1.8-1.7-1.9S8.3.7 8.3 1.7V8.3H1.9C.9 8.2.1 9 0 10s.7 1.8 1.7 1.9H8.3v6.4c0 1 .9 1.8 1.9 1.7.9 0 1.7-.8 1.7-1.7v-6.4h6.4c1 0 1.8-.9 1.7-1.9 0-.9-.8-1.7-1.7-1.7"/>
                  </svg>
                  <svg v-else class="w-5 h-5 text-green-800 fill-current" viewBox="0 0 20 20">
                    <title>Close</title>
                    <path d="M18.3 11.7H1.7c-1 0-1.7-.8-1.7-1.7 0-.9.7-1.7 1.7-1.7h16.7c.9 0 1.7.7 1.7 1.7-.1.9-.8 1.7-1.8 1.7z"/>
                  </svg>
                </span>

              </button>
            </h4>
            <!-- Close Title / Toggle Open -->

          </div>
          <!-- Indicator / Title -->

          <!-- Content Wrapper -->
          <div v-if="index === seletedStop" class="mt-2 md:mt-2.5 lg:mt-3 ml-8 md:ml-10">

            <!-- Image Wrapper -->
            <div v-if="stop.stop_image" class="my-6 md:mb-10 aspect-w-7 aspect-h-4">
              <img
                :src="stop.stop_image"
                alt=""
                loading="lazy"
                width="370"
                height="295"
                class="object-cover w-full h-full"
              >
            </div>
            <!-- Close Image Wrapper -->

            <!-- Content Title
            <h5 class="text-2 uppercase mb-3.5 md:mb-5 md:pr-10 text-green-800 leading-7 md:leading-9 font-black md:text-2.75"
              v-html="stop.stop_title">
            </h5> -->

            <!-- Copy -->
            <p class="mb-8 md:mb-10 md:text-lg"
              v-html="stop.stop_description">
            </p>

            <!-- CTA -->
            <div v-if="stop.stop_website_url" class="md:inline-flex">
              <a :href="stop.stop_website_url"
                target="_blank"
                class="flex items-center justify-center px-5 py-3 text-base font-bold tracking-wider text-white uppercase duration-500 ease-in-out rounded-lg group whitespace-nowrap md:w-auto button-green"
                >
                <span class="pl-1 duration-500 ease-in-out translate-x-1.5 group-hover:translate-x-0">
                  Visit Website
                </span>
                <svg class="h-3.5 ml-2.5 text-white duration-500 ease-in-out fill-current -translate-x-1.5 group-hover:translate-x-0" viewBox="0 0 33.31 22.02">
                  <title>Button Arrow</title>
                  <!-- Arrow Head -->
                  <path d="M22.44 21.88 33.3 11.02 22.44.15a.489.489 0 0 0-.69 0c-.06.06-.1.13-.13.21-1.12 4.01.7 8.27 4.39 10.22.24.12.34.42.22.66-.05.09-.12.17-.22.22a8.857 8.857 0 0 0-4.39 10.22c.08.26.35.41.61.34.08-.04.16-.09.21-.14" />
                  <!-- Arrow Body -->
                  <path class="duration-500 ease-in-out opacity-0 group-hover:opacity-100" d="M27.3 12.2V9.82c0-.55-.45-1-1-1H.99c-.55 0-1 .45-1 1v2.39c0 .55.45 1 1 1H26.3c.55-.01 1-.45 1-1.01" />
                </svg>
              </a>
            </div>
            <!-- Close CTA -->

          </div>
          <!-- Close Content Wrapper -->

        </div>
        <!-- Close Row -->

      </div>
      <!-- Close Rows Wrapper -->

      <!-- Download PDF -->
      <div v-if="itinerary.itinerary_download_pdf" class="pt-12 mt-12 border-t border-gray-100 lg:pl-10">

        <span class="mb-4 text-xl font-black text-green-800 uppercase md:text-2xl">
          Download this Itinerary:
        </span>

        <p class="text-sm md:text-lg mb-7"
          v-html="itinerary.itinerary_download_description">
        </p>

        <!-- Download -->
        <div class="md:inline-flex">
          <a :href="itinerary.itinerary_download_pdf"
            target="_blank"
            class="flex items-center justify-center px-5 py-3 text-base font-bold tracking-wider text-white uppercase duration-500 ease-in-out rounded-lg group whitespace-nowrap md:w-auto button-green"
            >
            <span class="pl-1 duration-500 ease-in-out translate-x-1.5 group-hover:translate-x-0">
              Download PDF
            </span>
            <svg class="h-3.5 ml-2.5 text-white duration-500 ease-in-out fill-current -translate-x-1.5 group-hover:translate-x-0" viewBox="0 0 33.31 22.02">
              <title>Button Arrow</title>
              <!-- Arrow Head -->
              <path d="M22.44 21.88 33.3 11.02 22.44.15a.489.489 0 0 0-.69 0c-.06.06-.1.13-.13.21-1.12 4.01.7 8.27 4.39 10.22.24.12.34.42.22.66-.05.09-.12.17-.22.22a8.857 8.857 0 0 0-4.39 10.22c.08.26.35.41.61.34.08-.04.16-.09.21-.14" />
              <!-- Arrow Body -->
              <path class="duration-500 ease-in-out opacity-0 group-hover:opacity-100" d="M27.3 12.2V9.82c0-.55-.45-1-1-1H.99c-.55 0-1 .45-1 1v2.39c0 .55.45 1 1 1H26.3c.55-.01 1-.45 1-1.01" />
            </svg>
          </a>
        </div>
        <!-- Close Download -->

      </div>
      <!-- Close Download PDF -->

    </div>
    <!-- Close Content Wrapper -->
    
  </section>
  <!-- Close Itineraries -->
</template>
