<!-- Trail Map -->
<section class="pb-12 bg-beige-200">

  <!-- Container -->
  <div class="container max-w-[83.5rem] relative"><?php

    $trail_map_image_id = get_sub_field('trail_map_image');
    $image_values = \Tofino\Helpers\responsive_image_attribute_values($trail_map_image_id);

    if ($image_values['src']) : ?>
      <!-- Map -->
      <img
        src="<?php echo $image_values['src']; ?>"
        srcset="<?php echo $image_values['srcset']; ?>"
        sizes="<?php echo $image_values['sizes']; ?>"
        loading="lazy"
        alt="<?php echo $image_values['alt']; ?>"
        width="340"
        height="250"
        class="object-contain w-10/12 h-auto mx-auto 2xl:w-full"
      ><?php
    endif;

    $trail_map_download_link = get_sub_field('trail_map_download_link');
    
    if ($trail_map_download_link) : ?>
      <!-- Download -->
      <div class="justify-center w-10/12 mx-auto mt-10 md:mt-7 lg:mt-10 md:w-full xl:w-auto md:inline-flex xl:absolute xl:right-40 2xl:right-10 xl:bottom-10"><?php
        \Tofino\Helpers\hm_get_template_part('templates/partials/button', [
          'url'    => $trail_map_download_link['url'],
          'target' => "_blank",
          'text'   => "Download PDF",
          'color'  => 'orange',
        ]); ?>
      </div><?php
    endif; ?>

  </div>
  <!-- Close Container -->

</section>
<!-- Close Trail Map -->
