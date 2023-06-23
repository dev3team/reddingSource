<?php
$option_type = get_sub_field('option_type');
$poster_image_id = get_sub_field('video_poster_image');
$poster_image = \Tofino\Helpers\responsive_image_attribute_values($poster_image_id);
$video_mp4 = get_sub_field('video_mp4');

$top_label = get_sub_field('top_label');
$marquee_title = get_sub_field('marquee_title');
$marquee_copy = get_sub_field('marquee_copy');
$marquee_cta = get_sub_field( 'marquee_cta' );
$image_values = \Tofino\Helpers\responsive_image_attribute_values();
$image_alignment = get_sub_field('image_alignment'); ?>

<section class="relative flex items-end min-h-screen"><?php
  if ($option_type === 'featured_image' && $image_values['src']) : ?>
    <!-- Marquee Image -->
    <div class="absolute inset-0 w-full h-full bg-green-800 after:absolute after:inset-0 after:bg-black after:bg-opacity-25">
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
  endif;

  if ($option_type === 'video') : ?>
    <!-- Marquee Video -->
    <div class="absolute inset-0 w-full h-full bg-green-800 after:absolute after:inset-0 after:bg-black after:bg-opacity-10">
      <div class="w-full h-full motion-reduce:hidden">
        <label for="home-marquee-video" class="sr-only"><?php echo $marquee_title; ?></label>
        <video id="home-marquee-video" playsinline autoplay loop muted poster="<?php echo $poster_image['src']; ?>"
        class="object-cover w-full h-full">
          <source src="<?php echo esc_url($video_mp4['url']); ?>" type="video/mp4">
        </video>
      </div>
      <!-- Reduced motion -->
      <div class="hidden w-full h-full motion-reduce:block"><?php
        if ($poster_image['src']) : ?>
          <img
            src="<?php echo $poster_image['src']; ?>"
            srcset="<?php echo $poster_image['srcset']; ?>"
            sizes="<?php echo $poster_image['sizes']; ?>"
            loading="lazy"
            alt="<?php echo $poster_image['alt']; ?>"
            width="375"
            height="320"
            class="object-cover w-full h-full"><?php
        endif; ?>
      </div>
    </div>
    <!-- Close Marquee Video --><?php
  endif; ?>

  <!-- Marquee Content -->
  <div class="container relative z-10 pt-24 pb-32 md:pt-32 md:pb-36 lg:pb-40 xl:pb-44 narrow:pt-40">
    <div class="flex flex-col w-10/12 mx-auto text-white"><?php
      if ($top_label) : ?>
        <span class="font-poppins font-extrabold text-[2.8125rem] leading-[2.5rem] uppercase md:text-[5.3125rem] md:leading-[4.25rem] xl:text-[5.625rem] xl:leading-[5rem]">
          <?php echo $top_label; ?>
        </span><?php
      endif;
      if ($marquee_title) : ?>
        <h1 class="font-extrabold text-[4.6875rem] leading-[3.75rem] uppercase md:text-[8.75rem] md:leading-[7.0625rem] xl:text-[9.375rem] xl:leading-[7.5rem]">
          <?php echo $marquee_title; ?>
        </h1><?php
      endif;
      if ($marquee_copy) : ?>
        <div class="mt-4 text-lg font-bold leading-[1.375rem] md:w-10/12 md:text-1.375 md:leading-[1.75rem] lg:w-7/12 xl:w-1/2 xl:text-2xl xl:leading-[1.875rem]">
          <?php echo $marquee_copy; ?>
        </div><?php
      endif;
      if ($marquee_cta) :
        $cta_target = esc_attr($marquee_cta['target']); ?>
        <div class="inline-flex">
          <a href="<?php echo esc_url($marquee_cta['url']); ?>" target="<?php echo ($cta_target === '_blank' ? $cta_target : '_self'); ?>"
            class="flex items-center whitespace-nowrap justify-center w-full px-6 py-4 mt-10 text-lg font-black tracking-wider uppercase md:text-1.375 md:w-auto md:self-start md:px-16 md:py-5 xl:text-2xl group text-white rounded-lg transition-button duration-500 ease-in-out button-green"
            >
            <span class="pl-1 transition-button duration-500 ease-in-out translate-x-1.5 group-hover:translate-x-0">
              <?php echo esc_html($marquee_cta['title']); ?>
            </span>
            <?php echo svg(['file' => 'button-arrow-lg']); ?>
          </a>
        </div><?php
      endif; ?>
    </div>
  </div>
  <!-- Close Marquee Content -->
</section>
