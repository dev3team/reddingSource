<!-- Newsletter -->
<section class="relative overflow-hidden bg-green-400 py-18 md:py-22 lg:py-28 bridge-graphic">

  <!-- Content Wrapper -->
  <div class="container">
    <div class="w-10/12 px-2 mx-auto text-center md:w-7/12 lg:w-9/12 prose-mobile md:prose-tablet xl:prose-desktop text-beige-200">

      <!-- Title -->
      <h2 class="mb-4 uppercase">
        <?php the_field('newsletter_title', 'option'); ?>
      </h2>

      <!-- Text -->
      <p class="max-w-3xl mx-auto mb-6 md:mb-8">
        <?php the_field('newsletter_copy', 'option'); ?>
      </p>

      <!-- CTA -->
      <div class="relative z-10 inline-flex"><?php
        \Tofino\Helpers\hm_get_template_part('templates/partials/button', [
          'url'    => get_permalink(get_page_by_path('newsletter')),
          'target' => null,
          'text'   => 'Sign Up',
          'color'  => 'dark-green',
        ]); ?>
      </div>
      
    </div>
  </div>
  <!-- Content Wrapper -->

  <!-- Trees Left -->
  <?php echo svg(['file' => 'trees-left']); ?>

  <!-- Trees Right -->
  <?php echo svg(['file' => 'trees-right']); ?>

  <!-- Mountains Left -->
  <?php echo svg(['file' => 'mountains-left']); ?>

  <!-- Mountains Right -->
  <?php echo svg(['file' => 'mountains-right']); ?>

</section>
<!-- Close Newsletter -->
