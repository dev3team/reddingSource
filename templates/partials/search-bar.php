<!-- search -->
<section id="js-search" class="absolute hidden inset-x-0 top-0 z-10 flex w-full bg-white h-[4.75rem] md:justify-end md:h-24 lg:h-[6.5rem]">

  <form class="flex w-full py-4 pl-6 pr-2 md:w-auto md:py-6 md:pr-3 lg:p-7" id="searchform" role="search" method="get" action="<?php echo home_url(); ?>">

    <label for="search-input" class="sr-only"><?php _e('Search', 'tofino'); ?></label>

    <!-- Input -->
    <input
      name="s"
      id="search-input"
      type="text"
      placeholder="Search Redding..."
      value="<?php echo esc_attr(get_search_query()); ?>"
      class="w-full mr-3 placeholder-green-800 bg-transparent border border-gray-100 rounded-md md:w-72 lg:w-80 focus:outline-none focus:ring-transparent focus:border-green-500"
    >

    <!-- Search Button -->
    <button class="flex items-center justify-center px-3 py-3 text-base font-bold tracking-wider text-white uppercase duration-500 ease-in-out rounded-lg md:px-5 focus:outline-none whitespace-nowrap group md:w-auto button-green">
      <span class="pl-1 hidden md:block duration-500 ease-in-out translate-x-1.5 group-hover:translate-x-0">
        Search
      </span>
      <span class="hidden md:block">
        <?php echo svg(['file' => 'button-arrow']); ?>
      </span>
      <!-- Mobile -->
      <svg viewBox="0 0 26 26" class="w-6 h-6 fill-current md:hidden">
        <title>Search Icon</title>
        <path d="m25.5 23.2-5.8-5.8s-.1 0-.1-.1c1.4-1.9 2.1-4.1 2.1-6.4 0-2.9-1.1-5.6-3.2-7.7-2-2.1-4.7-3.2-7.6-3.2S5.2 1.1 3.2 3.2C1.1 5.2 0 8 0 10.9s1.1 5.6 3.2 7.7c2.1 2.1 4.8 3.2 7.7 3.2 2.4 0 4.6-.8 6.4-2.1 0 0 0 .1.1.1l5.8 5.8c.3.3.7.5 1.2.5.4 0 .8-.2 1.2-.5.6-.7.6-1.8-.1-2.4zm-14.6-4.8c-2 0-3.9-.8-5.3-2.2s-2.2-3.3-2.2-5.3.7-3.9 2.1-5.4 3.3-2.2 5.3-2.2 3.9.8 5.3 2.2 2.2 3.3 2.2 5.3-.8 3.9-2.2 5.3-3.2 2.3-5.2 2.3z"/>
      </svg>
    </button>

  </form>

  <!-- Close -->
  <button class="mr-7 md:mr-8 lg:mr-[3.75rem] focus:outline-none js-search-toggle">
    <?php echo svg(['sprite' => 'icon-close', 'class' => 'w-5 h-5 fill-current']); ?>
    <span class="sr-only"><?php _e('Close Search Bar', 'tofino'); ?></span>
  </button>

</section>
<!-- Close search -->
