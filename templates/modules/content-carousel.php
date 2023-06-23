<?
$carousel_title = get_sub_field('carousel_title');
$cta_button = get_sub_field('cta_button');
$carousel_type = get_sub_field('carousel_type');

$default_args = [
  'posts_per_page' => -1,
  'order' => 'ASC'
];

if ($carousel_type === 'child_pages') {
  $parent_page = get_sub_field('carousel_parent_page');

  $args = [
    'post_type' => 'page',
    'post_parent' => $parent_page
  ];
} else {
  $carousel_post_type = get_sub_field('carousel_post_type');

  $args = [
    'post_type' => $carousel_post_type->name,
  ];
}

$args = array_merge($default_args, $args);

$query = new WP_Query($args); ?>

<section class="overflow-hidden bg-beige-200 prose-mobile md:prose-tablet xl:prose-desktop content-carousel">
  <div class="container py-20 md:py-24 xl:pb-28">
    <div class="flex flex-col w-10/12 mx-auto md:w-11/12 lg:flex-row">

      <!-- Copy Wrapper -->
      <div class="relative z-10 flex flex-col bg-beige-200 md:w-10/12 lg:w-[43%] lg:pt-7 lg:pr-10 xl:w-[35%] 2xl:w-[32%] lg:after:absolute lg:after:top-0 lg:after:-bottom-3 lg:after:right-0 lg:after:-left-999 lg:after:bg-beige-200 lg:after:-z-10"><?php
        if ($carousel_title) : ?>
          <h3 class="mb-4 text-green-800 uppercase">
            <?php echo $carousel_title; ?>
          </h3><?php
        endif; ?>
        <div>
          <?php the_sub_field('carousel_copy'); ?>
        </div><?php
        if ($cta_button) : ?>
          <!-- Desktop CTA -->
          <div class="hidden mt-10 lg:flex"><?php
            \Tofino\Helpers\hm_get_template_part('templates/partials/button', [
              'url'    => $cta_button['url'],
              'target' => $cta_button['target'],
              'text'   => $cta_button['title'],
              'color'  => 'yellow'
            ]); ?>
          </div><?php
        endif; ?>
        <!-- Controls -->
        <div class="hidden mt-auto text-beige-800 lg:flex">
          <button class="w-8 h-8 transform rotate-180 swiper-button-prev" aria-label="Previous">
            <?php echo svg (['sprite' => 'carousel-arrow', 'class' => 'fill-current w-full h-full']); ?>
          </button>
          <button class="w-8 h-8 ml-3 swiper-button-next" aria-label="Next">
          <?php echo svg (['sprite' => 'carousel-arrow', 'class' => 'fill-current w-full h-full']); ?>
          </button>
        </div>
      </div>
      <!-- Close Copy Wrapper --><?php

      if ($query->have_posts()) : ?>
        <!-- Carousel Wrapper -->
        <div class="mt-10 md:mt-12 lg:w-[57%] lg:mt-0 xl:w-[65%] 2xl:w-[68%] content-carousel-swiper-js">
          <div class="flex flex-no-wrap swiper-wrapper"><?php

            while ($query->have_posts()) : $query->the_post();
              $image_values = \Tofino\Helpers\responsive_image_attribute_values(null, 'medium'); ?>
              <!-- Carousel Item -->
              <a href="<?php the_permalink(); ?>" class="relative flex flex-col flex-shrink-0 w-10/12 min-h-full mr-7 md:w-[45%] md:mr-9 lg:w-7/12 lg:mr-7 xl:w-5/12 2xl:w-[35%] offset-frame-right offset-frame-light-green after:opacity-0 after:duration-500 lg:hover:after:opacity-100 swiper-slide">
                <!-- Image -->
                <div class="relative bg-green-800 aspect-w-16 aspect-h-16"><?php
                  if ($image_values['src']) : ?>
                    <img
                      src="<?php echo $image_values['src']; ?>"
                      srcset="<?php echo $image_values['srcset']; ?>"
                      sizes="<?php echo $image_values['sizes']; ?>"
                      alt="<?php echo $image_values['alt']; ?>"
                      loading="lazy"
                      width="375"
                      height="320"
                      class="absolute inset-0 block object-cover w-full h-full"><?php
                  endif; ?>
                </div>

                <!-- Content -->
                <div class="flex flex-col h-full bg-white p-7">
                  <div class="mb-4 text-2xl font-bold leading-none text-green-800 uppercase font-poppins">
                    <?php the_title(); ?>
                  </div>
                  <div class="text-base">
                    <?php the_excerpt(); ?>
                  </div>
                </div>
              </a>
              <!-- Close Carousel Item --><?php
            endwhile;
            wp_reset_query();
            wp_reset_postdata(); ?>

          </div>
        </div>
        <!-- Close Carousel Wrapper --><?php
      endif;

      if ($cta_button) : ?>
        <!-- Mobile CTA -->
        <div class="mt-14 md:flex md:mt-16 lg:hidden"><?php
          \Tofino\Helpers\hm_get_template_part('templates/partials/button', [
            'url'    => $cta_button['url'],
            'target' => $cta_button['target'],
            'text'   => $cta_button['title'],
            'color'  => 'yellow'
          ]); ?>
        </div>
        <!-- Close Mobile CTA --><?php
      endif; ?>

    </div>
  </div>
</section>