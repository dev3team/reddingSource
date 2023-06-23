<div class="container pt-16 h-[60rem] prose-mobile md:prose-tablet md:pt-24 md:h-[65rem] lg:h-[38rem] xl:prose-desktop xl:h-[45rem]">

  <!-- Title -->
  <h2 class="w-10/12 mx-auto mb-8 text-center text-green-800 uppercase lg:mb-14">
    <?php the_sub_field('featured_links_title'); ?>
  </h2>
  <!-- Close Title --><?php

  if (have_rows('featured_links_setup')) : ?>
    <!-- Links Wrapper -->
    <div class="flex flex-col w-11/12 mx-auto lg:w-full lg:flex-row lg:justify-center"><?php

      // Start Loop
      while (have_rows('featured_links_setup')) : the_row();
        $featured_link = get_sub_field('featured_link'); 
        
        if ($featured_link) :
          $post = $featured_link;
          setup_postdata($post);

          $featured_image_id = get_post_thumbnail_id();
          $featured_image_url = wp_get_attachment_image_src($featured_image_id, 'large')[0];
          $featured_image_alt = get_post_meta($featured_image_id, '_wp_attachment_image_alt', true); ?>
          <a href="<?php echo get_the_permalink(); ?>" class="relative w-10/12 h-[15rem] mx-auto transition-all duration-500 ease-in-out group hover:w-11/12 hover:h-[17rem] md:w-[28.25rem] md:hover:w-[30.3rem] lg:w-[340px] lg:h-[305px] lg:transform lg:m-0 lg:hover:w-[380px] lg:hover:h-[340px] lg:hover:-translate-y-5 xl:w-[400px] xl:h-[360px] xl:hover:w-[460px] xl:hover:h-[420px] xl:hover:-translate-y-7">
            <div class="absolute w-full bg-green-800 top-3 bottom-3 offset-frame-right offset-frame-light-green md:top-4 md:bottom-4 lg:w-auto lg:h-full lg:right-4 lg:left-4 after:opacity-0 after:transition-all after:duration-500 group-hover:after:opacity-100">
              <!-- Image -->
              <img src="<?php echo $featured_image_url; ?>"
                loading="lazy"
                alt="<?php echo $featured_image_alt; ?>"
                width="390"
                height="390"
                class="object-cover w-full h-full" />

              <!-- Overlay Container -->
              <div class="absolute inset-0 z-10 flex flex-col items-center justify-center w-full h-full bg-black bg-opacity-40">
                <!-- Title -->
                <h2 class="mb-4 text-center text-white uppercase"><?php the_sub_field('featured_link_title'); ?></h2>

                <!-- Button -->
                <div class="flex items-center justify-center px-5 py-3 text-sm font-bold tracking-wider text-white uppercase duration-500 ease-in-out bg-green-400 rounded-lg whitespace-nowrap md:w-auto group-hover:bg-yellow-500">
                  <span class="pl-1 duration-500 ease-in-out translate-x-1.5 group-hover:translate-x-0">
                    <?php the_sub_field('featured_link_tagline'); ?>
                  </span>
                  <?php echo svg(['file' => 'button-arrow']); ?>
                </div>

              </div>

            </div>
          </a><?php
          wp_reset_postdata();
        endif;

      endwhile; ?>

    </div>
    <!-- Close Links Wrapper --><?php
  endif; ?>

</div>