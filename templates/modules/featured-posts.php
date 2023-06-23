<?php
$post_type = get_sub_field('featured_posts_type');
$posts_title = get_sub_field('posts_title');
$cta_button = get_sub_field('cta_button');
$order_by = get_sub_field('order_by');
$color_pattern = get_sub_field('color_pattern');

// @TODO: Make this more DRY. DH

// Set extra args based on tag or recent posts
if ($order_by === 'tag') {
  $selected_tag = get_sub_field('tag_selection');

  $extra_args = [
    'tax_query' => [
      [
        'taxonomy' => $selected_tag->taxonomy,
        'field'    => 'term_id',
        'terms'    => $selected_tag->term_taxonomy_id
      ]
    ]
  ];
} else {
  $extra_args = null;
}

// Set post type
if ($post_type->name === 'tribe_events') {
  $args = [
    'ends_after'     => 'now',
    'order'          => 'ASC',
    'posts_per_page' => 4,
  ];

  // Combine extra args with posts
  if ($extra_args) {
    $args = wp_parse_args($extra_args, $args);
  }

  $posts = tribe_get_events($args);
} else {
  $args = [
    'post_type'      => $post_type->name,
    'posts_per_page' => 4,
    // 'order'          => 'DESC',
    // 'orderby'        => 'menu_order',
    'post_status'    => 'publish'
  ];

  // Combine extra args with posts
  if ($extra_args) {
    $args = wp_parse_args($extra_args, $args);
  }

  $posts = get_posts($args);
} ?>

<section class="overflow-hidden prose-mobile md:prose-tablet xl:prose-desktop featured-posts<?php echo ($color_pattern === 'light' ? ' bg-beige-200' : ' bg-green-800'); ?>">
  <div class="container py-14 md:pt-18 md:pb-20 xl:pb-24">
    <div class="flex flex-col w-10/12 mx-auto md:w-11/12 md:flex-row md:flex-wrap xl:w-10/12">
    
      <!-- Title Wrapper -->
      <div class="flex flex-col w-full md:w-3/4 md:order-1 md:pr-12 2xl:pr-32">
        <span class="text-base font-bold tracking-wider uppercase<?php echo ($color_pattern === 'light' ? ' text-beige-800' : ' text-white'); ?>">
          <?php echo $post_type->label; ?>
        </span><?php
        if ($posts_title) : ?>
          <h2 class="mt-1 uppercase md:mt-2<?php echo ($color_pattern === 'light' ? ' text-green-800' : ' text-blue-100'); ?>">
            <?php echo $posts_title; ?>
          </h2><?php
        endif; ?>
      </div>
      <!-- Close Title Wrapper --><?php

      if ($posts) : ?>
        <!-- Swiper Wrapper -->
        <div class="w-full mt-6 md:order-last md:mt-10 featured-posts-swiper-js">
          <div class="flex flex-nowrap swiper-wrapper"><?php
            foreach ($posts as $post) :
              setup_postdata($post);

              $image_values = \Tofino\Helpers\responsive_image_attribute_values(null, 'medium');

              if ($post_type->name === 'tribe_events') {
                $start_date = tribe_get_start_date(null, false, 'F j, Y');
              } ?>
              <!-- Post Item -->
              <a href="<?php echo get_the_permalink(); ?>" class="relative z-10 flex flex-col flex-shrink-0 w-10/12 min-h-full mr-7 md:w-5/12 lg:w-[30%] xl:w-[23%] 2xl:mr-8 after:opacity-0 after:duration-500 lg:hover:after:opacity-100 offset-frame-right swiper-slide<?php echo ($color_pattern === 'light' ? ' offset-frame-light-green' : ' offset-frame-white-blue'); ?>">
                <!-- Image -->
                <div class="w-full">
                  <div class="relative aspect-w-16 aspect-h-16<?php echo ($color_pattern === 'light' ? ' bg-green-800' : ' bg-blue-500'); ?>"><?php
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
                </div>
                <!-- Inner Content -->
                <div class="flex flex-col w-full h-full px-8 pt-6 pb-8 bg-white md:px-6 md:pb-10 2xl:px-7">
                  <span class="mb-2 text-sm text-orange-500 uppercase">
                    <?php echo (isset($start_date) ? $start_date : get_the_date()); ?>
                  </span>
                  <div class="text-xl font-bold leading-tight text-green-800">
                    <?php the_title(); ?>
                  </div>
                </div>
              </a>
              <!-- Close Post Item --><?php
            endforeach; 
            wp_reset_postdata(); ?>
         </div>
        </div>
        <!-- Close Swiper Wrapper --><?php
      endif;

      if ($cta_button) : ?>
        <!-- CTA -->
        <div class="flex w-full mt-12 md:w-1/4 md:order-2 md:items-end md:justify-end md:mt-0"><?php
          \Tofino\Helpers\hm_get_template_part('templates/partials/button', [
            'url'    => $cta_button['url'],
            'target' => $cta_button['target'],
            'text'   => $cta_button['title'],
            'color'  => ($color_pattern === 'light' ? 'yellow' : 'green')
          ]); ?>
        </div>
        <!-- Close CTA --><?php
      endif; ?>

    </div>
  </div>
</section>