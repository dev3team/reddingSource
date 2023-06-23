<?php
use \Tofino\ThemeOptions\Menu as m;
use \Tofino\ThemeOptions\Notifications as n; ?>
<!doctype html>
<html <?php language_attributes(); ?>>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>

<?php wp_body_open(); ?>

<?php n\notification('top'); ?>

<header id="header-nav" class="<?php echo m\menu_sticky(); ?> z-40">
  <nav class="w-full relative flex justify-between px-6 py-4 md:px-7 md:py-5 lg:py-0 lg:pr-14<?php echo (is_front_page() ? ' nav-home' : ' nav-default'); ?>">
    <!-- Logo -->
    <a href="<?php echo home_url(); ?>" title="<?php echo esc_attr(bloginfo('name')); ?>" class="self-center w-32 md:z-20 h-11 md:w-40 md:h-14 js-header-logo">
      <?php echo svg(['sprite' => 'header-logo', 'class' => 'w-full h-full fill-current']); ?>
    </a>

    <!-- Hamburger Icon -->
    <button class="flex self-center lg:hidden js-menu-toggle" aria-controls="main-menu" aria-expanded="false" aria-label="Toggle navigation">
      <span class="w-8 h-8">
        <?php echo svg(['sprite' => 'icon-hamburger', 'class' => 'w-full h-full fill-current']); ?>
      </span>
      <span class="sr-only"><?php _e('Toggle Navigation Button', 'tofino'); ?></span>
    </button>

    <!-- Menu Wrapper -->
    <div id="main-menu" class="fixed inset-0 z-10 hidden w-full h-screen lg:relative lg:flex lg:h-auto lg:w-auto lg:items-center">
      <!-- Mobile Logo -->
      <a href="<?php echo home_url(); ?>" title="<?php echo esc_attr(bloginfo('name')); ?>" class="absolute w-32 top-4 left-6 h-11 text-beige-200 md:top-5 md:left-7 md:w-40 md:h-14 lg:hidden js-header-logo">
        <?php echo svg(['sprite' => 'header-logo', 'class' => 'w-full h-full fill-current']); ?>
      </a>

      <!-- Close Icon -->
      <button class="absolute w-6 h-6 top-6 right-7 text-beige-200 md:top-9 md:right-8 lg:hidden js-menu-toggle">
        <?php echo svg(['sprite' => 'icon-close', 'class' => 'w-full h-full fill-current']); ?>
        <span class="sr-only"><?php _e('Toggle Navigation Button', 'tofino'); ?></span>
      </button>

      <?php
      if (has_nav_menu('header_navigation')) :
        wp_nav_menu([
          'menu'            => 'nav_menu',
          'theme_location'  => 'header_navigation',
          'depth'           => 3,
          'container'       => '',
          'container_class' => '',
          'container_id'    => '',
          'menu_class'      => 'navbar-nav',
          'items_wrap'      => '<ul id="%1$s" class="%2$s">%3$s</ul>',
        ]);
      endif; ?>

      <!-- Tree BG -->
      <div class="absolute inset-0 w-full h-full -z-10 lg:hidden">
        <span class="block fixed bottom-0 -right-16 w-44 h-[30rem] text-green-600 md:w-48 md:h-[35rem]">
          <?php echo svg(['file' => 'tree', 'class' => 'w-full h-full']); ?>
        </span>
      </div>

    </div>
    <!-- Close Menu Wrapper -->

    <!-- Search Icon -->
    <button class="absolute z-10 inset-y-5 right-16 md:right-18 lg:right-14 lg:inset-y-10 focus:outline-none js-search-toggle">
      <svg viewBox="0 0 26 26" class="w-6 h-6 fill-current">
        <title>Search Icon</title>
        <path d="m25.5 23.2-5.8-5.8s-.1 0-.1-.1c1.4-1.9 2.1-4.1 2.1-6.4 0-2.9-1.1-5.6-3.2-7.7-2-2.1-4.7-3.2-7.6-3.2S5.2 1.1 3.2 3.2C1.1 5.2 0 8 0 10.9s1.1 5.6 3.2 7.7c2.1 2.1 4.8 3.2 7.7 3.2 2.4 0 4.6-.8 6.4-2.1 0 0 0 .1.1.1l5.8 5.8c.3.3.7.5 1.2.5.4 0 .8-.2 1.2-.5.6-.7.6-1.8-.1-2.4zm-14.6-4.8c-2 0-3.9-.8-5.3-2.2s-2.2-3.3-2.2-5.3.7-3.9 2.1-5.4 3.3-2.2 5.3-2.2 3.9.8 5.3 2.2 2.2 3.3 2.2 5.3-.8 3.9-2.2 5.3-3.2 2.3-5.2 2.3z"/>
      </svg>
      <span class="sr-only"><?php _e('Open Search Bar', 'tofino'); ?></span>
    </button>

  </nav>
  <!-- Search Bar -->
  <?php get_template_part('templates/partials/search-bar'); ?>
</header>

<div class="wrapper">
