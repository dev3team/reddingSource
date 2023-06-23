<?php
$team = get_sub_field('team');

if ($team) : ?>
  <!-- Team -->
  <section class="py-20 js-team bg-beige-200">

    <!-- Container -->
    <div class="container">

      <!-- Tiles Wrapper -->
      <div class="grid w-10/12 grid-cols-1 gap-8 mx-auto xl:w-10/12 lg:w-11/12 lg:grid-cols-2"><?php

        $i = 0;
        foreach ($team as $post) : setup_postdata ($post);
          $i++;

          $image_id = get_post_thumbnail_id();
          $image_values = \Tofino\Helpers\responsive_image_attribute_values($image_id); ?>

          <!-- Tile -->
          <div class="z-10">
            <div class="relative grid grid-cols-1 bg-white auto-cols-auto md:grid-cols-2 js-team-tile">

              <!-- Image -->
              <div class="md:pr-10 lg:pr-5 xl:pr-8 2xl:pr-10">
                <div class="aspect-w-1 aspect-h-1"><?php
                  if ($image_values['src']) : ?>
                    <img
                      src="<?php echo $image_values['src']; ?>"
                      srcset="<?php echo $image_values['srcset']; ?>"
                      sizes="<?php echo $image_values['sizes']; ?>"
                      loading="lazy"
                      alt="<?php echo $image_values['alt']; ?>"
                      width="300"
                      height="300"
                      class="object-cover w-full h-full"><?php
                  endif; ?>
                </div>
              </div>
              <!-- Close Image -->
              
              <!-- Contact Info / Toggle Bio -->
              <div class="flex flex-col p-8 md:justify-between md:pr-8 md:pt-10 md:pb-10 md:pl-0 lg:pr-5 lg:pt-5 lg:pb-5 xl:pr-8 xl:pt-8 xl:pb-8 2xl:pr-8 2xl:pt-10 2xl:pb-10">
                
                <!-- Contact Info -->
                <div class="flex flex-col">
                  
                  <!-- Name -->
                  <h5 class="text-green-800 leading-6 uppercase duration-500 text-1.75 md:text-2 lg:text-1.75 2xl:text-2">
                    <?php the_title(); ?>
                  </h5>

                  <!-- Job Title -->
                  <span class="mb-2 uppercase md:text-lg">
                    <?php the_field('team_job_title'); ?>
                  </span>

                  <!-- Email -->
                  <a href="mailto:<?php the_field('team_email'); ?>">
                    <?php the_field('team_email'); ?>
                  </a>

                  <!-- Phone -->
                  <a href="tel:<?php the_field('team_phone'); ?>" class="mb-6 md:mb-0">
                    <?php the_field('team_phone'); ?>  
                  </a>
                </div>
                <!-- Close Contact Info -->

                <!-- Toggle Bio -->
                <button class="flex items-center justify-between w-full duration-500 js-toggle-team-bio team-bio-button hover:text-green-800">

                  <span class="text-lg font-bold uppercase md:text-xl">
                    Bio
                  </span>

                  <span class="flex">
                    <!-- Open -->
                    <svg class="w-5 h-5 fill-current" viewBox="0 0 20 20">
                      <title>Open</title>
                      <path d="M18.3 8.3h-6.4V1.9c0-1-.7-1.8-1.7-1.9S8.3.7 8.3 1.7V8.3H1.9C.9 8.2.1 9 0 10s.7 1.8 1.7 1.9H8.3v6.4c0 1 .9 1.8 1.9 1.7.9 0 1.7-.8 1.7-1.7v-6.4h6.4c1 0 1.8-.9 1.7-1.9 0-.9-.8-1.7-1.7-1.7"/>
                    </svg>
                    <!-- Close -->
                    <svg class="w-5 h-5 fill-current" viewBox="0 0 20 20">
                      <title>Close</title>
                      <path d="M18.3 11.7H1.7c-1 0-1.7-.8-1.7-1.7 0-.9.7-1.7 1.7-1.7h16.7c.9 0 1.7.7 1.7 1.7-.1.9-.8 1.7-1.8 1.7z"/>
                    </svg>                  
                  </span>

                </button>
                <!-- Toggle Bio -->

              </div>
              <!-- Close Contact Info / Toggle Bio -->
              
              <!-- Bio -->
              <div class="hidden js-team-bio md:col-span-2">
                <p class="pb-8 pl-8 pr-8 md:pb-10 md:pr-8 md:pl-0 lg:py-5 lg:px-8 xl:pb-10 xl:pl-0 md:w-1/2 lg:w-full xl:w-1/2 md:ml-auto">
                  <?php the_field('team_bio'); ?>
                </p>
              </div>
              <!-- Close Bio -->

            </div>
          </div>
          <!-- Close Tile -->
          
          <?php
        endforeach;
        wp_reset_postdata(); ?>

      </div>
      <!-- Close Tiles Wrapper -->

    </div>
    <!-- Close Container -->

  </section>
  <!-- Close Team -->
<?php endif;

