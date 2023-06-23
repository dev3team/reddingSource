<!-- Static Map -->
<section class="relative overflow-hidden bg-blue-700 pb-18 pt-[36rem] md:pb-20 md:pt-40 lg:pt-28 lg:pb-32"><?php
  // Get the SVG map from ACF field
  $image_id = get_sub_field('map_image'); ?>

  <!-- Map -->
  <div class="static-map-vector-container absolute right-0 top-0 h-[40rem] lg:h-[50rem]">
    <?php echo svg(['file' => $image_id]); ?>
  </div>

  <!-- Container -->
  <div class="container">

    <!-- Content Wrapper -->
    <div class="w-10/12 mx-auto text-white xl:w-8/12 prose-mobile md:prose-tablet xl:prose-desktop">
      <div class="md:w-10/12 lg:w-6/12 xl:w-7/12">

        <!-- Label -->
        <span class="block mb-2 text-sm font-bold uppercase md:text-base">
          <?php the_sub_field('top_small_label'); ?>
        </span>
        
        <!-- Title -->
        <h2 class="mb-3.5 uppercase">
          <?php the_sub_field('map_title'); ?>
        </h2>

        <!-- Text -->
        <p class="mb-6 md:mb-7">
          <?php the_sub_field('map_copy'); ?>
        </p><?php
        
        $map_cta = get_sub_field('map_cta');

        if ($map_cta) : ?>
          <!-- CTA -->
          <div class="inline-flex"><?php
            \Tofino\Helpers\hm_get_template_part('templates/partials/button', [
              'url'    => $map_cta['url'],
              'target' => $map_cta['target'],
              'text'   => $map_cta['title'],
              'color'  => 'yellow',
            ]); ?>
          </div><?php
        endif; ?>

      </div>
    </div>
    <!-- Close Content Wrapper -->

  </div>
  <!-- Container -->

</section>
<!-- Static Map -->
