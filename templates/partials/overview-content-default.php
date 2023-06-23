<?php
$overview_image = get_sub_field('overview_image');
$overview_accent = get_sub_field('overview_accent');

if ($overview_image) {
  $overview_image = \Tofino\Helpers\responsive_image_attribute_values($overview_image);
} ?>

<section class="container pb-12 pt-14 md:pt-20 prose-mobile md:pb-16 md:prose-tablet lg:pb-18 xl:prose-desktop xl:pb-24">
  <div class="flex flex-col w-10/12 mx-auto xl:w-11/12 xl:flex-row-reverse xl:px-8"><?php

    if ($overview_image) : ?>
      <!-- Image Wrapper -->
      <div class="w-full xl:w-1/2">
        <div class="relative bg-green-800 aspect-w-16 aspect-h-13 md:aspect-h-10 lg:aspect-h-9 xl:aspect-h-14 offset-frame-right<?php echo ($overview_accent === 'green' ? ' after:bg-green-400' : ' after:bg-blue-400'); ?>">
            <img
              src="<?php echo $overview_image['src']; ?>"
              srcset="<?php echo $overview_image['srcset']; ?>"
              sizes="<?php echo $overview_image['sizes']; ?>"
              loading="lazy"
              alt="<?php echo $overview_image['alt']; ?>"
              width="375"
              height="320"
              class="absolute inset-0 object-cover w-full h-full">
        </div>
      </div>
      <!-- Close Image Wrapper --><?php
    endif; ?>

    <!-- Content Wrapper -->
    <div class="w-full<?php echo ($overview_image ? ' mt-14 md:mt-16 xl:w-1/2 xl:mt-0 xl:pt-8' : ' mt-8 md:mt-14 lg:w-3/4 lg:mx-auto xl:w-7/12 2xl:w-1/2'); ?>">
      <div class="flex flex-col<?php echo ($overview_image ? ' xl:pr-20 2xl:pr-24' : ''); ?>">
        <h2 class="mb-4 text-green-800 uppercase md:mb-6">
          <?php the_sub_field('overview_title'); ?>
        </h2>
        <div class="content-green">
          <?php echo \Tofino\Helpers\fix_text_orphan(get_sub_field('overview_copy')); ?>
        </div>
      </div>
    </div>
    <!-- Close Content Wrapper -->

  </div>
</section>