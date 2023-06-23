<?php
$overview_image = \Tofino\Helpers\responsive_image_attribute_values(get_sub_field('overview_image')); ?>

<section class="container py-10 prose-mobile md:prose-tablet xl:prose-desktop">
  <div class="flex flex-col w-11/12 mx-auto xl:flex-row-reverse">

    <!-- Image Wrapper -->
    <div class="w-full xl:w-1/2">
      <div class="relative bg-green-400 aspect-w-16 aspect-h-15 md:aspect-h-10 lg:aspect-h-9 xl:p-0 xl:h-full"><?php
        if ($overview_image) : ?>
          <img
            src="<?php echo $overview_image['src']; ?>"
            srcset="<?php echo $overview_image['srcset']; ?>"
            sizes="<?php echo $overview_image['sizes']; ?>"
            loading="lazy"
            alt="<?php echo $overview_image['alt']; ?>"
            width="375"
            height="320"
            class="absolute inset-0 object-cover w-full h-full"><?php
        endif; ?>
      </div>
    </div>
    <!-- Close Image Wrapper -->

    <!-- Content Wrapper -->
    <div class="relative w-full bg-beige-200 xl:w-1/2">
      <div class="relative z-10 flex flex-col px-8 pb-16 pt-14 md:px-18 md:py-20 lg:px-24 xl:px-16 2xl:p-24">
        <h2 class="mb-6 text-green-800 uppercase md:mb-2 lg:mb-4">
          <?php the_sub_field('overview_title'); ?>
        </h2>
        <div class="content-green">
          <?php echo \Tofino\Helpers\fix_text_orphan(get_sub_field('overview_copy')); ?>
        </div>
      </div>
      <!-- Mountains Background -->
      <span class="absolute bottom-0 left-0 block w-[97%] md:w-80 lg:w-96 2xl:w-[26rem]">
        <?php echo svg(['file' => 'mountains-overview']); ?>
      </span>
      <!-- Close Mountains Background -->
    </div>
     <!-- Close Content Wrapper -->

  </div>
</section>