<div class="relative z-10 flex flex-col mx-auto mb-10 max-w-screen-2xl md:flex-row md:flex-wrap md:mb-14">

  <!-- Add Event -->
  <div class="w-full border-b border-gray-100 py-7 lg:py-4">
    <div class="flex max-w-screen-sm mx-auto md:max-w-none md:justify-end md:pr-5">

      <!-- Button -->
      <a href="<?php echo get_permalink(\Tofino\Helpers\get_id_by_slug('events-calendar/add-event', 'page')) ?>" target="_self"
        class="flex items-center justify-center w-10/12 py-4 pr-5 mx-auto text-base font-bold tracking-wider text-white uppercase transition duration-500 bg-green-400 rounded-lg pl-7 md:w-auto md:m-0 hover:bg-yellow-500">
        <span class="w-4 h-4 mr-3">
          <?php echo svg(['sprite' => 'plus-icon', 'class' => 'w-full h-full stroke-current']); ?>
        </span>
        Add Your Event
      </a>

    </div>
  </div>
  <!-- Close Add Event -->

  <!-- Category -->
  <div class="relative w-full border-b border-gray-100 py-7 md:w-1/2 lg:w-1/4 lg:flex lg:items-center lg:py-4 2xl:border-l 2xl:border-gray-100 after:absolute after:hidden after:right-0 after:top-4 after:bottom-4 after:w-px after:bg-gray-100 md:after:block">
    <div class="flex max-w-screen-sm mx-auto md:max-w-none md:w-full">
      <form class="flex items-center w-10/12 mx-auto">

        <span class="w-8 h-8 mr-1">
          <?php echo svg(['file' => 'category-icon', 'class' => 'w-full h-full']); ?>
        </span>

        <!-- Category Select -->
        <label for="category-select" class="sr-only">Select Category</label><?php
        // Get all categories from the taxonomy tribe_events_cat and loop them
        $terms = get_terms([
          'taxonomy' => 'tribe_events_cat',
          'hide_empty' => false,
        ]);

        if (!empty($terms) && !is_wp_error($terms)) : ?>

          <select v-model.number="category" name="category-select" id="category-select" class="flex-grow text-sm tracking-wide text-gray-500 uppercase border-none appearance-none cursor-pointer ring-0 focus:ring-0 select-bg-arrow">
            <option value='' disabled selected>Category</option><?php

            foreach ($terms as $term) : ?>
              <option value="<?php echo $term->term_id; ?>"><?php echo $term->name; ?></option><?php
            endforeach; ?>
          </select><?php
        endif; ?>
      </form>
    </div>
  </div>
  <!-- Close Category -->

  <!-- Dates -->
  <div class="relative w-full border-b border-gray-100 py-7 md:w-1/2 lg:w-1/4 lg:flex lg:items-center lg:py-4 after:absolute after:hidden after:right-0 after:top-4 after:bottom-4 after:w-px after:bg-gray-100 lg:after:block">
    <div class="flex max-w-screen-sm mx-auto md:max-w-none md:w-full">
      <v-date-picker class="w-10/12 mx-auto" 
        is-required 
        v-model="range" 
        is-range 
        :max-date="new Date(new Date().setFullYear(new Date().getFullYear() + 1))" 
        :min-date='new Date()'
        :select-attribute="attribute"
        :drag-attribute="attribute">
        <template v-slot="{ togglePopover }">
          <div class="flex items-center cursor-pointer" @click="togglePopover()">
            <span class="block w-8 h-8 mr-1">
              <?php echo svg(['file' => 'dates-icon', 'class' => 'w-full h-full']); ?>
            </span>

            <!-- Date Select -->
            <span class="pt-1 pl-3 text-sm tracking-wide text-gray-500 uppercase">
              <span v-if="filterDate">
                {{ filterDate }}
              </span>
              <span v-else>
                Select Dates
              </span>
            </span>
          </div>
        </template>
      </v-date-picker>
    </div>
  </div>
  <!-- Close Dates -->

  <!-- Search -->
  <div class="w-full border-b border-gray-100 py-7 md:w-1/2 md:flex md:items-center md:py-4 lg:w-1/4">
    <div class="flex max-w-screen-sm mx-auto md:max-w-none md:w-full">
      <form id="search-events-form" class="flex items-center w-10/12 mx-auto">

        <span class="w-8 h-8 mr-1 lg:mr-0">
          <?php echo svg(['file' => 'search-icon', 'class' => 'w-full h-full']); ?>
        </span>

        <!-- Search Field -->
        <label for="search-events" class="sr-only">Search Events</label>
        <input v-model="search" type="text" name="search-events" id="search-events" placeholder="Search For Events" class="flex-grow text-sm tracking-wide text-gray-500 uppercase border-none appearance-none ring-0 focus:ring-0">

      </form>
    </div>
  </div>
  <!-- Close Search -->

  <!-- Find -->
  <div class="w-full py-7 md:w-1/2 md:py-4 md:border-b md:border-gray-100 lg:w-1/4 2xl:border-r 2xl:border-gray-100">
    <div class="flex max-w-screen-sm mx-auto md:max-w-none md:justify-end md:pr-5">

      <!-- Button -->
      <button type="submit" @click="findEvents" form="search-events-form"
        class="flex items-center justify-center w-10/12 py-4 mx-auto text-base font-bold tracking-wider text-white uppercase transition duration-500 rounded-lg px-7 bg-beige-800 md:w-auto md:m-0 hover:bg-green-800">
        Find Events
      </button>

    </div>
  </div>
  <!-- Close Find -->

</div>