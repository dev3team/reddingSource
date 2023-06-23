<?php
use \Tofino\ThemeOptions\Notifications as n;

if (!is_page('newsletter')) :
  get_template_part('templates/partials/newsletter');
endif; ?>

<footer>

  <!-- Nav Menu -->
  <div class="flex flex-col w-full py-12 bg-green-800">

    <!-- Logo -->
    <a href="<?php echo home_url(); ?>" title="<?php echo esc_attr(bloginfo('name')); ?>" class="w-64 h-20 mx-auto mb-12 text-beige-200 md:w-72 md:h-24">
      <?php echo svg(['sprite' => 'redding-set-go', 'class' => 'w-full h-full fill-current']); ?>
    </a>

    <div class="container"><?php
      if (has_nav_menu('footer_navigation')) :
        wp_nav_menu([
          'menu'            => 'nav_menu',
          'theme_location'  => 'footer_navigation',
          'depth'           => 2,
          'container'       => '',
          'container_class' => '',
          'container_id'    => '',
          'menu_class'      => 'footer-nav',
          'items_wrap'      => '<ul id="%1$s" class="%2$s">%3$s</ul>',
        ]);
      endif; ?>
    </div>
  </div>
  <!-- Close Nav Menu -->

  <!-- Partners / Social Links -->
  <div class="pt-12 pb-4 text-center bg-green-900 prose-mobile md:prose-tablet xl:prose-desktop text-beige-200">

    <!-- Container -->
    <div class="container">

      <h3 class="mb-3 uppercase md:mb-2">
        Our Partners
      </h3><?php
      
      if (have_rows('logos', 'option')) : ?>
        
        <!-- Logos -->
        <div class="flex flex-wrap justify-center w-10/12 max-w-4xl mx-auto mb-3"><?php

          while (have_rows('logos', 'option')) : the_row();
            
            $url = get_sub_field('url');
            if ($url) : ?>
              <a href="<?php echo $url; ?>" class="w-1/3 md:w-1/5" target="_blank" rel="noopener">
                <?php get_template_part('templates/partials/footer-logo'); ?>
              </a>
              <?php
            else : ?>
              <div class="w-1/3 md:w-1/5">
                <?php get_template_part('templates/partials/footer-logo'); ?>
              </div><?php
            endif;
            
          endwhile; ?>

        </div>
        <!-- Close Logos --><?php

      endif; ?>
      
      <!-- Contact Info -->
      <div class="flex flex-col w-11/12 mx-auto mb-10 leading-tight"><?php

        $company_name = get_theme_mod('company_name');
        $address = get_theme_mod('address');
        $phone = get_theme_mod('telephone_number'); 
        $footer_text = get_theme_mod('footer_text');

        if ($company_name) : ?>
          <span>
            <?php echo $company_name; ?>
          </span><?php
        endif;
        if ($address) : ?>
          <span>
            <?php echo $address; ?>
          </span><?php
        endif;
        if ($phone) : ?>
          <span>
            <a href="tel:<?php echo $phone; ?>"><?php echo $phone; ?></a>
          </span><?php
        endif; ?>

      </div>
      <!-- Close Contact Info -->

      <!-- Social Links -->
      <?php echo do_shortcode('[social_icons platforms="facebook,instagram,twitter,youtube"]'); ?>

      <!-- Bottom Text -->
      <div class="text-xs text-center text-green-500"><?php
        if ($footer_text) : ?>
          <span>
            <?php echo do_shortcode($footer_text); ?>
          </span>
          <span class="mx-1">|</span><?php
        endif; ?>
        <a href="<?php echo get_privacy_policy_url(); ?>" class="underline">Privacy Policy</a>
      </div>
      <!-- Close Bottom Text -->

    </div>
    <!-- Close Container -->

  </div>
  <!-- Partners / Social Links -->

</footer>

<?php wp_footer(); ?>

<?php n\notification('bottom'); ?>

</div>

</body>
</html>