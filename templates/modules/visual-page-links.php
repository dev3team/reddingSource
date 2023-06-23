<?php
// TODO: Write a function to return this data in a clean array -BH
// Page links type
$list_title = get_sub_field('page_links_title');
$list_type = get_sub_field('list_type');

if ($list_title) : ?>
  <div class="container prose-mobile md:prose-tablet xl:prose-desktop">
    <h2 class="w-10/12 pt-10 mx-auto leading-none text-center text-green-800 uppercase md:pt-12 xl:w-3/4">
      <?php echo $list_title; ?>
    </h2>
  </div><?php
endif;

if ($list_type === 'children') { // Child Pages
  $args = [
    'post_type'      => 'page',
    'posts_per_page' => -1,
    'order'          => 'ASC',
    'orderby'        => 'menu_order',
    'post_status'    => 'publish',
    'post_parent'    => $post->ID
  ];

  $query = new WP_Query($args);

  $count = $query->found_posts;

  if ($query->have_posts()) : ?>
    <section class="container py-10 overflow-hidden md:py-12">
      <div class="grid w-11/12 grid-cols-12 mx-auto gap-y-6 md:gap-5 lg:gap-6<?php echo ($count == 2 ? ' page-link-tiles-center' : ''); ?>"><?php

        while ($query->have_posts()) : $query->the_post();
          $image_values = \Tofino\Helpers\responsive_image_attribute_values();
          \Tofino\Helpers\hm_get_template_part('templates/partials/page-link-tile', [
            'permalink'    => get_the_permalink(),
            'target'       => '_self',
            'title'        => get_the_title(),
            'image_src'    => $image_values['src'],
            'image_srcset' => $image_values['srcset'],
            'image_sizes'  => $image_values['sizes'],
            'image_alt'    => $image_values['alt'],
            'tagline'      => get_field('tagline'),
            'excerpt'      => (!get_the_excerpt() ? null : get_the_excerpt()),
          ]);
          
        endwhile;

        wp_reset_query();
        wp_reset_postdata(); ?>

      </div>
    </section><?php
  endif;
} elseif ($list_type === 'custom') { // Custom List
    if (have_rows('page_links_setup')) : ?>
      <section class="container py-10 overflow-hidden md:py-12">
        <div class="grid w-11/12 grid-cols-12 mx-auto gap-y-6 md:gap-5 lg:gap-6"><?php

          while (have_rows('page_links_setup')) : the_row();
            $link_type = get_sub_field('link_type');
            $title = get_sub_field('custom_title');
            $image = get_sub_field('custom_image');
            $image_values = \Tofino\Helpers\responsive_image_attribute_values($image);
            $excerpt = get_sub_field('custom_excerpt');
            $tagline = get_sub_field('cta_tagline');

            if ($link_type === 'internal') { // Internal Link
              $page = get_sub_field('page_link');
              $post = $page; setup_postdata($post);
              $url = get_the_permalink();

              if (!$image) { // Use featured image if custom image field empty
                $image_values = \Tofino\Helpers\responsive_image_attribute_values();
              }
            } else { // External Link
              $url = get_sub_field('external_url');
            }

            \Tofino\Helpers\hm_get_template_part('templates/partials/page-link-tile', [
              'permalink'    => $url,
              'target'       => ($link_type === 'external' ? '_blank' : '_self'),
              'title'        => ($title ? $title : get_the_title()),
              'image_src'    => $image_values['src'],
              'image_srcset' => $image_values['srcset'],
              'image_sizes'  => $image_values['sizes'],
              'image_alt'    => $image_values['alt'],
              'tagline'      => ($tagline ? $tagline : get_field('tagline')),
              'excerpt'      => ($excerpt ? $excerpt : get_the_excerpt())
            ]);

            wp_reset_postdata();
          endwhile; ?>

        </div>
      </section><?php
    endif;
} ?>