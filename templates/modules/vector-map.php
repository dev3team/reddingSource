<?php
$vector_map_svg = get_sub_field('vector_map_svg');
$vector_pins_array = get_sub_field('vector_map_pins');

if ($vector_pins_array) : ?>
  <style><?php
    foreach ($vector_pins_array as $pin) : ?>
      button[data-map-key="<?php echo $pin['key']; ?>"].active,
      button[data-map-key="<?php echo $pin['key']; ?>"]:hover {
        color: <?php echo $pin['color']; ?>;
      }<?php
    endforeach; ?>
  </style><?php
endif; ?>

<!-- Vector Map -->
<section class="pt-20 2xl:pt-0 js-vector-map prose-mobile md:prose-tablet xl:prose-desktop">

  <!-- Container -->
  <div class="container lg:flex">

    <!-- Content -->
    <div class="w-10/12 mx-auto lg:w-1/2 lg:order-last lg:p-10 xl:p-20 2xl:p-24">

      <!-- Title -->
      <h2 class="mb-4 text-green-800 uppercase lg:text-6xl lg:leading-[3.25rem] xl:text-[4.125rem]">
        <?php the_sub_field('vector_map_title'); ?>
      </h2>

      <!-- Text -->
      <p class="text-black mb-7 md:mb-8 lg:max-w-md md:pr-10">
        <?php the_sub_field('vector_map_description'); ?>
      </p><?php

      // CTA / Map Vector Pins
      if (have_rows('vector_map_pins')) :
        $i = 1;
        while (have_rows('vector_map_pins')) : the_row();
          $link = get_sub_field('link');

          if ($link) : ?>
            <!-- CTA -->
            <div class="js-map-cta mb-12 md:mb-16 inline-flex <?php echo $i !== 1 ? 'hidden' : ''; ?>" 
              data-map-key="<?php the_sub_field('key'); ?>"><?php
              \Tofino\Helpers\hm_get_template_part('templates/partials/button', [
                'url'    => $link['url'],
                'target' => $link['target'],
                'text'   => $link['title'],
                'color'  => 'green',
              ]); ?>
            </div><?php
          endif;

          $i++;
        endwhile; ?>

        <!-- Pins -->
        <ul class="flex justify-between mb-4 md:justify-start vector-map-pins">
          <?php
          $i = 1;
          while (have_rows('vector_map_pins')) : the_row(); ?>
            <li>
              <button class="<?php echo $i == 1 ? 'active ' : ''; ?>w-11 md:w-14 md:mr-11 lg:mr-9 xl:mr-11 text-gray-400 group"
                data-map-key="<?php the_sub_field('key'); ?>">
                <svg class="w-8 mx-auto md:w-12" viewBox="0 0 32 40" fill="currentColor">
                  <path d="M16 0C7.2 0 0 7.2 0 16.2 0 22.4 14.3 39.8 16 40c1 .1 16-17.6 16-23.8C32 7.2 24.8 0 16 0m0 22.5c-3.4 0-6.2-2.8-6.2-6.3s2.8-6.3 6.2-6.3c3.4 0 6.2 2.8 6.2 6.3s-2.7 6.3-6.2 6.3"/>
                </svg>
                <span class="block mt-3 md:leading-none text-[11px] font-bold leading-none text-center text-gray-400 uppercase md:text-base group-hover:text-green-800">
                  <?php the_sub_field('title'); ?>
                </span>
              </button>
            </li><?php
            $i++;
          endwhile; ?>
        </ul>
        <!-- Close Pins --><?php
      endif; ?>
      
    </div>
    <!-- Close Content --><?php

    if ($vector_map_svg) : 
      $location_map = svg(['file' => 'redding-location-map']); ?>
      <!-- Map -->
      <div id="vector-map-container" class="relative w-full lg:w-1/2 lg:order-first"><?php
        
        // Interactive Map
        echo svg(['file' => $vector_map_svg]);

        if ($location_map) : ?>
          <!-- Static Map -->
          <div class="mx-auto my-0 w-[7rem] lg:w-[8rem] xl:w-[9rem] xl:right-12 2xl:w-[10.625rem] absolute bottom-3 lg:bottom-[8.5rem] xl:bottom-18 2xl:bottom-3 2xl:right-11 right-8">
            <?php echo $location_map; ?>
          </div><?php
        endif; ?>
      </div>
      <!-- Close Map --><?php
    endif; ?>

  </div>
  <!-- Close Container -->

</section>
<!-- Close Vector Map -->
