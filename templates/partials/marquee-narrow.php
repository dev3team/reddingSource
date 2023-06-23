<?php
$top_label = get_sub_field('top_label');
$marquee_title = get_sub_field('marquee_title');
$marquee_cta = get_sub_field( 'marquee_cta' );
$image_values = \Tofino\Helpers\responsive_image_attribute_values();
$image_alignment = get_sub_field('image_alignment'); ?>

<section class="relative min-h-[22rem] flex items-end prose-mobile overflow-hidden md:min-h-[37rem] md:prose-tablet lg:min-h-[32rem] xl:prose-desktop"><?php

  if ($image_values['src']) : ?>
    <!-- Marquee Image -->
    <div class="absolute inset-0 w-full h-full bg-green-800 after:absolute after:inset-0 after:bg-black after:bg-opacity-20">
      <img
        src="<?php echo $image_values['src']; ?>"
        srcset="<?php echo $image_values['srcset']; ?>"
        sizes="<?php echo $image_values['sizes']; ?>"
        loading="lazy"
        alt="<?php echo $image_values['alt']; ?>"
        width="375"
        height="320"
        class="object-cover w-full h-full"
        <?php echo !empty($image_alignment) ? ' style="object-position: ' . $image_alignment . ';"' : null; ?>>
    </div>
    <!-- Close Marquee Image --><?php
  endif; ?>

  <div class="container relative z-10 pt-14">
    <div class="flex flex-col w-[95%] mx-auto text-white"><?php
      if ($top_label) : ?>
        <span class="font-black uppercase font-poppins text-[1.65rem] leading-[1.625rem] md:text-2.75 md:leading-[2.125rem]">
          <?php echo $top_label; ?>
        </span><?php
      endif;
      if ($marquee_title) : ?>
        <h1 class="uppercase transform translate-y-[0.35rem] md:translate-y-1">
          <?php echo $marquee_title; ?>
        </h1><?php
      endif; ?>
    </div>
  </div>

</section>