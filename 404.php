<?php 
$background_image = get_field('404_background', 'option');
$bg_image_values = \Tofino\Helpers\responsive_image_attribute_values($background_image['id']);

get_header(); ?>

<section class="relative min-h-[45rem] flex items-center prose-mobile md:min-h-[60rem] md:prose-tablet lg:min-h-[53rem] xl:min-h-[56rem] xl:prose-desktop">

  <div class="absolute inset-0 bg-green-400 after:absolute after:inset-0 after:bg-black after:bg-opacity-25"><?php
    if ($bg_image_values['src']) : ?>
      <img
        src="<?php echo $bg_image_values['src']; ?>"
        srcset="<?php echo $bg_image_values['srcset']; ?>"
        sizes="<?php echo $bg_image_values['sizes']; ?>"
        loading="lazy"
        alt="<?php echo $bg_image_values['alt']; ?>"
        width="375"
        height="320"
        class="object-cover w-full h-full"><?php
    endif; ?>
  </div>

  <div class="container relative z-10">
    <div class="flex flex-col w-10/12 mx-auto text-center text-white md:w-7/12 lg:w-5/12 xl:w-1/3">
      <h1 class="mb-4 md:mb-6">
        404
      </h1>
      <span class="mb-2 font-black uppercase text-2 font-poppins tracking-wide md:text-4xl md:leading-none md:mb-1 xl:text-2.75">
        <?php _e('Page Not Found', 'tofino'); ?>
      </span>
      <span class="sm:w-2/3 sm:mx-auto md:w-3/4">
        <?php _e('The page that you are looking for has been moved or does not exist.', 'tofino'); ?>
      </span>
    </div>
  </div>

</section>

<?php get_footer(); ?>
