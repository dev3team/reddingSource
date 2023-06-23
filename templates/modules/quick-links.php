<?php
$water_graphic = get_sub_field('enable_water_graphic'); ?>

<!-- Quick Links -->
<section class="flex flex-col mb-10 md:mb-14 lg:flex-row">

  <!-- Content -->
  <div class="py-10 text-white bg-green-400 md:py-16 lg:py-28 lg:w-7/12">

    <!-- Container -->
    <div class="container">
      <div class="w-10/12 mx-auto lg:w-9/12 md:pr-16 lg:pr-0 xl:pl-12 prose-mobile md:prose-tablet xl:prose-desktop">

        <!-- Label -->
        <span class="block mb-2 text-sm font-bold text-green-800 uppercase md:text-base">
          <?php the_sub_field('top_small_label'); ?>
        </span>
        
        <!-- Title -->
        <h2 class="mb-3.5 uppercase">
          <?php the_sub_field('quick_links_title'); ?>
        </h2>

        <!-- Text -->
        <p class="mb-3">
          <?php the_sub_field('quick_links_copy'); ?>
        </p>
    
      </div>
    </div>
    <!-- Close Container -->

  </div>
  <!-- Close Content -->

  <!-- Links -->
  <div class="relative overflow-hidden bg-beige-200 lg:w-5/12<?php echo ($water_graphic ? ' pt-12 pb-36 md:pt-16 lg:pt-28' : ' py-12 md:py-16 lg:py-28') ?>">

    <!-- Container -->
    <div class="container">
      <ul class="grid w-10/12 grid-cols-12 mx-auto font-bold leading-tight tracking-wider text-green-800 uppercase gap-y-7 md:gap-x-8 md:text-lg md:leading-tight lg:w-3/4 lg:gap-x-0"><?php

        // Loop Through Links
        while (have_rows('quick_links_setup')) : the_row();
          $link_item = get_sub_field('link_item');
          if ($link_item) :
            $link_target = esc_attr($link_item['target']); ?>
            <!-- Link -->
            <li class="flex col-span-10 md:col-span-6 md:pr-7 lg:col-span-12 lg:pr-0">
              <a href="<?php echo esc_url($link_item['url']); ?>"
                target="<?php echo ($link_target === '_blank' ? $link_target : '_self'); ?>"
                class="relative group md:self-start hover:underline"
                >
                <?php echo esc_html($link_item['title']); ?>
                <span class="absolute hidden w-5 h-5 text-yellow-500 transform top-[50%] translate-y-[-50%] -right-8 group-hover:flex">
                  <?php echo svg(['sprite' => 'icon-arrow', 'class' => 'w-full h-full fill-current']); ?>
                </span>
              </a>
            </li><?php
          endif;
        endwhile; ?>
      
      </ul>
    </div>
    <!-- Close Container -->
  
    <!-- Waves Graphic -->
    <?php if ($water_graphic) {
      echo svg(['file' => 'waves']);
    } ?>

  </div>
  <!-- Links -->

</section>
<!-- Close Quick Links -->
