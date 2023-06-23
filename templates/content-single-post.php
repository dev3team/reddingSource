<?php
$featured_img_values = \Tofino\Helpers\responsive_image_attribute_values(null, 'medium');
$source_link = get_field('source_link'); ?>

<article class="container pt-36 pb-28 md:pt-60 lg:pb-32 blog-single">
  <div class="flex flex-col w-10/12 mx-auto lg:w-2/3 xl:w-7/12 2xl:w-1/2">

    <!-- Date -->
    <span class="mb-1.5 text-lg leading-none uppercase">
      <?php echo get_the_date('F j, Y'); ?>
    </span>

    <!-- Title -->
    <h1 class="mb-4 text-2.5 text-green-800 uppercase leading-[2.2rem] md:text-3.75 md:leading-[3.2rem]">
      <?php the_title(); ?>
    </h1><?php

    if ($featured_img_values['src']) : ?>
      <!-- Featured Image -->
      <div class="relative mb-8 aspect-w-16 aspect-h-10">
        <img
          src="<?php echo $featured_img_values['src']; ?>"
          srcset="<?php echo $featured_img_values['srcset']; ?>"
          sizes="<?php echo $featured_img_values['sizes']; ?>"
          alt="<?php echo $featured_img_values['alt']; ?>"
          loading="lazy"
          width="375"
          height="320"
          class="absolute inset-0 block object-cover w-full h-full">
      </div>
      <!-- Close Featured Image --><?php
    endif; ?>

    <!-- Content -->
    <div class="general-content blog-content">
      <?php the_content(); ?>
    </div><?php

    if ($source_link) : ?>
      <!-- Source Button -->
      <div class="mt-3 mb-2 md:flex"><?php
        \Tofino\Helpers\hm_get_template_part('templates/partials/button', [
          'url'    => $source_link['url'],
          'target' => $source_link['target'],
          'text'   => $source_link['title'],
          'color'  => 'dark-green'
        ]); ?>
      </div><?php
    endif; ?>

    <!-- Share Links -->
    <div class="mt-8 md:mt-14">
      <?php get_template_part('templates/partials/sharelinks'); ?>
    </div>

  </div>
</article>