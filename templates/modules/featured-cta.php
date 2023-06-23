<?php
$feature_type = get_sub_field('feature_type');
$featured_cta = get_sub_field('featured_cta_select');

if ($featured_cta) :
  foreach ($featured_cta as $post) : setup_postdata($post);
    $image_values = \Tofino\Helpers\responsive_image_attribute_values();
    $featured_cta_link = get_field('featured_cta_link'); ?>

    <section class="relative prose-mobile bg-green-800 overflow-hidden md:prose-tablet xl:prose-desktop featured-cta-<?php echo $feature_type; ?>">
      <div class="container">
        <div class="flex flex-col w-10/12 mx-auto xl:w-11/12 xl:flex-row">

          <!-- Image Wrapper -->
          <div class="w-full xl:w-1/2">
            <div class="relative z-10 bg-green-400 aspect-w-16 aspect-h-13 md:aspect-h-10 xl:aspect-h-14 offset-frame-left featured-cta-image"><?php
              if ($image_values['src']) : ?>
                <img
                  src="<?php echo $image_values['src']; ?>"
                  srcset="<?php echo $image_values['srcset']; ?>"
                  sizes="<?php echo $image_values['sizes']; ?>"
                  loading="lazy"
                  alt="<?php echo $image_values['alt']; ?>"
                  width="375"
                  height="320"
                  class="absolute inset-0 block object-cover w-full h-full"><?php
              endif; ?>
            </div>
          </div>
          <!-- Close Image Wrapper -->

          <!-- Content Wrapper -->
          <div class="relative z-10 w-full pt-10 md:w-11/12 md:pt-14 xl:w-1/2 xl:flex xl:items-center xl:py-4 2xl:py-6">
            <div class="flex flex-col w-full xl:px-16 2xl:pl-20 2xl:pr-28">

              <span class="mb-1 text-base font-bold tracking-wider text-white uppercase md:mb-2 xl:mb-1">
                Featured
              </span>

              <h2 class="mb-4 uppercase md:mb-5 featured-cta-title">
                <?php the_field('featured_cta_title'); ?>
              </h2>

              <div class="text-white bold-hyperlinks">
                <?php echo \Tofino\Helpers\fix_text_orphan(get_field('featured_cta_copy')); ?>
              </div><?php

              if ($featured_cta_link) : ?>
                <div class="mt-8 md:self-start"><?php
                  \Tofino\Helpers\hm_get_template_part('templates/partials/button', [
                    'url'    => $featured_cta_link['url'],
                    'target' => $featured_cta_link['target'],
                    'text'   => $featured_cta_link['title'],
                    'color'  => 'green',
                  ]); ?>
                </div><?php
              endif; ?>

            </div>
          </div>
          <!-- Close Content Wrapper -->

        </div>
      </div>

      <!-- SVG Background -->
      <div class="absolute inset-0 w-full h-full svg-background">
        <?php echo svg(['file' => $feature_type]); ?>
      </div>
      <!-- Close SVG Background -->
    </section><?php

  endforeach;
  wp_reset_postdata();
endif; ?>