<section events>
  <!-- Filters -->
  <?php get_template_part('templates/partials/events-filter'); ?>

  <div class="container pb-20 prose-mobile md:prose-tablet md:pb-28 xl:prose-desktop">
    <div v-if="events" class="flex flex-col w-10/12 mx-auto md:w-11/12 lg:w-10/12 xl:w-3/4 2xl:w-2/3">

      <!-- Event Item -->
      <a :href="event.url" class="flex flex-col w-full mb-16 group md:flex-row md:mb-18" v-for="event, index in events">
        <!-- Image -->
        <div class="w-full md:w-5/12 lg:w-auto">
          <div class="relative bg-green-800 aspect-w-16 aspect-h-16 transition-all duration-500 offset-frame-left offset-frame-light-green lg:p-0 lg:w-[300px] lg:h-[300px] lg:transform lg:group-hover:scale-[1.1] xl:group-hover:scale-[1.12] after:opacity-0 after:transition-all after:duration-500 lg:group-hover:after:opacity-100">
            <img :src="event.image.url" srcset="" sizes="" alt="alt text" loading="lazy" width="375" height="320" class="absolute inset-0 block object-cover w-full h-full">
          </div>
        </div>
        <!-- Close Image -->

        <!-- Inner Content -->
        <div class="flex flex-col w-full pt-6 md:w-7/12 md:pl-8 md:pt-0 lg:w-auto lg:flex-grow lg:pl-12">
          <span class="mb-2 leading-tight text-green-800 uppercase group-hover:text-orange-500">
            {{ formatDate(event.start_date) }} - {{ formatDate(event.end_date) }}
          </span>
          <h3 class="mb-2 text-green-800 uppercase" v-html="event.title">
          </h3>
          <span v-if="event.venue" class="mb-4 text-sm text-gray-800">
            <strong v-html="event.venue.venue"></strong> {{ event.venue.address }} {{ event.venue.city }}
          </span>
          <div class="mb-6 text-base text-gray-800 md:mb-4 content-green" v-html="event.excerpt"></div>

          <button class="flex items-center self-start justify-center px-5 py-3 text-sm font-bold tracking-wider text-white uppercase duration-500 ease-in-out bg-green-400 rounded-lg whitespace-nowrap group md:w-auto group-hover:bg-yellow-500">
            <span class="pl-1 duration-500 ease-in-out translate-x-1.5 group-hover:translate-x-0">
              View Details
            </span>
            <?php echo svg(['file' => 'button-arrow']); ?>
          </button>

        </div>
        <!-- Close Inner Content -->
      </a>
      <!-- Close Event Item -->

    </div>

    <!-- Buttons Wrapper -->
    <div class="flex flex-col items-center w-10/12 mx-auto mt-5 md:mt-6 lg:mt-10">
      <!-- More -->
      <button v-if="nextPage" @click="loadMore()" class="flex items-center justify-center w-full px-6 py-4 mb-12 text-base font-bold tracking-wider text-white uppercase transition duration-500 rounded-lg md:w-auto md:pl-18 md:mb-14 group button-dark-green">
        More
        <span class="w-4 h-4 ml-8 group-hover:hidden">
          <?php echo svg(['sprite' => 'icon-carrot', 'class' => 'w-full h-full fill-current']); ?>
        </span>
        <span class="hidden w-4 h-4 ml-8 group-hover:flex">
          <?php echo svg(['sprite' => 'icon-arrow', 'class' => 'w-full h-full fill-current']); ?>
        </span>
      </button>
      <!-- To Top -->
      <button @click="scrollToTop()" class="flex flex-col items-center text-sm font-bold tracking-wider uppercase text-beige-800">
        <span class="w-4 h-4 transform -rotate-90">
          <?php echo svg(['sprite' => 'icon-carrot', 'class' => 'w-full h-full fill-current']); ?>
        </span>
        Back to Top
      </button>
    </div>
    <!-- Close Buttons Wrapper -->
  </div>

</section>