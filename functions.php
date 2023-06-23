<?php
/**
 * Tofino includes
 *
 * The $tofino_includes array determines the code library included in your theme.
 * Add or remove files to the array as needed.
 *
 * Missing files will produce a fatal error.
 *
 */
$tofino_includes = [
  "inc/lib/init.php",
  "inc/lib/assets.php",
  "inc/lib/helpers.php",
  "inc/lib/clean.php",
  "inc/lib/CustomizrTextEditor.php",
  "inc/lib/AjaxForm.php",
  "inc/lib/FragmentCache.php",
  "inc/lib/event-form.php",
  "inc/shortcodes/copyright.php",
  "inc/shortcodes/social-icons.php",
  "inc/shortcodes/svg.php",
  "inc/shortcodes/theme-option.php",
  "inc/shortcodes/crowd-riff.php",
  "inc/theme-options/admin.php",
  "inc/theme-options/advanced.php",
  "inc/theme-options/client-data.php",
  "inc/theme-options/contact-form.php",
  "inc/theme-options/dashboard-widget.php",
  "inc/theme-options/footer.php",
  "inc/theme-options/google-analytics.php",
  "inc/theme-options/init.php",
  "inc/theme-options/maintenance-mode.php",
  "inc/theme-options/menu.php",
  "inc/theme-options/newsletter-form.php",
  "inc/theme-options/notifications.php",
  "inc/theme-options/social-networks.php",
  "inc/theme-options/theme-tracker.php",
];

foreach ($tofino_includes as $file) {
  if (!$filepath = locate_template($file)) {
    trigger_error(sprintf(__('Error locating %s for inclusion', 'tofino'), $file), E_USER_ERROR);
  }
  require_once $filepath;
}
unset($file, $filepath);


/**
 * Composer dependencies
 *
 * External dependencies are defined in the composer.json and autoloaded.
 * Use 'composer dump-autoload -o' after adding new files.
 *
 */
if (file_exists(get_template_directory() . '/vendor/autoload.php')) { // Check composer autoload file exists. Result is cached by PHP.
  require_once 'vendor/autoload.php';
} else {
  if (is_admin()) {
    add_action('admin_notices', 'composer_error_notice');
  } else {
    wp_die(composer_error_notice(), __('An error occured.', 'tofino'));
  }
}

// Check for missing dist directory. Result is cached by PHP.
if (!is_dir(get_template_directory() . '/dist')) {
  if (is_admin()) {
    add_action('admin_notices', 'missing_dist_error_notice');
  } else {
    wp_die(missing_dist_error_notice(), __('An error occured.', 'tofino'));
  }
}

// Admin notice for missing composer autoload.
function composer_error_notice() {
?><div class="error notice">
    <p><?php _e('Composer autoload file not found. Run composer install on the command line.', 'tofino'); ?></p>
  </div><?php
}

// Admin notice for missing dist directory.
function missing_dist_error_notice() {
?><div class="error notice">
    <p><?php _e('/dist directory not found. You probably want to run yarn install and npm run dev on the command line.', 'tofino'); ?></p>
  </div><?php
}

// Set ACF JSON save path
function acf_json_save_point($path) {
  $path = get_stylesheet_directory() . '/inc/acf-json'; // Update path

  return $path;
}
add_filter('acf/settings/save_json', 'acf_json_save_point');

// Set ACF JSON load path
function acf_json_load_point($paths) {
  unset($paths[0]); // Remove original path (optional)

  $paths[] = get_stylesheet_directory() . '/inc/acf-json';

  return $paths;
}
add_filter('acf/settings/load_json', 'acf_json_load_point');


/**
 * Turn off YYYY/MM Media folders
 *
 */
add_filter('option_uploads_use_yearmonth_folders', '__return_false', 100);


/**
 * Prefetch_scripts that might be needed later
 *
 * @since 3.3.0
 */
function prefetch_scripts() {
  $scripts = [
    'tabbed-content',
    'newsletter-form',
    'posts-feed',
    'event-form',
    'faq',
    'content-carousel',
    'contact-form'
  ];

  foreach ($scripts as $script) {
    echo '<link rel="prefetch" as="script" href="' . mix('js/chunks/' . $script .  '.js', 'dist') . '" crossorigin="anonymous"/>';
  }
}
add_action('wp_head', 'prefetch_scripts');

// Correct Image Sizes
function correct_image_sizes() {
  remove_image_size('thumbnail');
  remove_image_size('medium_large');
  remove_image_size('large');
  remove_image_size('1536x1536');

  update_option('thumbnail_size_h', 0);
  update_option('thumbnail_size_w', 0);

  update_option('medium_size_h', 0);
  update_option('medium_size_w', 565);

  update_option('medium_large_size_h', 0);
  update_option('medium_large_size_w', 0);
  
  update_option('large_size_h', 0);
  update_option('large_size_w', 1152);

  update_option('1536x1536_size_h', 0);
  update_option('1536x1536_size_w', 0);

  update_option('2048x2048_size_h', 0);
  update_option('2048x2048_size_w', 2048);
}
add_action('init', 'correct_image_sizes');


function preload_marquee_image() {
  $featured_img_url    = get_the_post_thumbnail_url(get_the_ID(), 'full');
  $featured_img_srcset = wp_get_attachment_image_srcset(get_post_thumbnail_id());

  if ($featured_img_url && $featured_img_srcset) {
    echo '<link rel="preload" as="image" href="' . $featured_img_url . '" imagesrcset="' . $featured_img_srcset . '"/>';
  }
}
add_action('wp_head', 'preload_marquee_image');


// Filter events args
function filter_events_args($args, $data, $request) {
  $parameters = $request->get_query_params(); 

  if (array_key_exists('first_load', $parameters) && $parameters['first_load'] == 'true') {
    unset($args['start_date']);
    unset($args['end_date']);

    $args['ends_after'] = date('Y-m-d');
  }

  return $args;
}
add_action('tribe_events_archive_get_args', 'filter_events_args', 10, 3);


// Add Google Tag code which is supposed to be placed after opening body tag.
function add_custom_body_open_code() {
  if (function_exists('gtm4wp_the_gtm_tag')) {
    gtm4wp_the_gtm_tag();
  } 
}
add_action('wp_body_open', 'add_custom_body_open_code');


/*
	Get Script and Style IDs
	Adds inline comment to your frontend pages
	View source code near the <head> section
	Lists only properly registered scripts
	@ https://digwp.com/2018/08/disable-script-style-added-plugins/
*/
function shapeSpace_inspect_script_style() {
	
	global $wp_scripts, $wp_styles;
	
	echo "\n" .'<!--'. "\n\n";
	
	echo 'SCRIPT IDs:'. "\n";
	
	foreach($wp_scripts->queue as $handle) echo $handle . "\n";
	
	echo "\n" .'STYLE IDs:'. "\n";
	
	foreach($wp_styles->queue as $handle) echo $handle . "\n";
	
	echo "\n" .'-->'. "\n\n";
	
}
// add_action('wp_print_scripts', 'shapeSpace_inspect_script_style');


function remove_tribe_event_scripts() {
  $scripts = [
    'tribe-events-views-v2-events-bar-inputs',
    'tribe-events-views-v2-datepicker',
    'tribe-events-views-v2-breakpoints',
    'tribe-events-views-v2-events-bar',
    'tribe-events-views-v2-tooltip',
    'tribe-events-views-v2-month-grid',
    'tribe-events-views-v2-month-mobile-events',
    'tribe-events-views-v2-multiday-events',
    'tribe-events-views-v2-navigation-scroll',
    'tribe-events-views-v2-ical-links',
    'tribe-events-views-v2-view-selector',
    'tribe-events-pro',
    'tribe-events-views-v2-viewport',
    'tribe-events-views-v2-accordion',
    'tribe-events-views-v2-bootstrap-datepicker',
    'tribe-events-pro-views-v2-week-grid-scroller',
    'tribe-events-pro-views-v2-week-day-selector',
    'tribe-events-pro-views-v2-week-event-link',
    'tribe-events-pro-views-v2-map-events-scroller',
    'tribe-events-pro-views-v2-map-events',
    'tribe-events-pro-views-v2-week-multiday-toggle',
    'tribe-events-pro-views-v2-map-provider-google-maps',
    'tribe-events-pro-views-v2-map-no-venue-modal',
    'tribe-events-pro-views-v2-datepicker-pro',
    'tribe-events-pro-views-v2-toggle-recurrence',
    'tribe-events-pro-views-v2-tooltip-pro',
    'tribe-events-pro-views-v2-multiday-events-pro',
    // 'underscore-js',
    // 'tribe-common-js',
    // 'tribe-query-string-js',
    // 'tribe-events-views-v2-manager-js',
    // 'tribe-events-pro-views-v2-multiday-events-pro',
    // 'tribe-events-pro-views-v2-multiday-events-pro'
  ];

  foreach ($scripts as $script) {
    wp_dequeue_script($script);
    
    tribe('assets')->remove($script);
  }
}
add_action('wp_enqueue_scripts', 'remove_tribe_event_scripts', 10);


function remove_tribe_styles() {
  $styles = [
    'tribe-events-pro-views-v2-skeleton',
    'tribe-events-calendar-full-pro-mobile-style',
    'tribe-events-calendar-pro-mobile-style',
    'tribe-events-calendar-pro-style',
    'tribe-events-pro-mini-calendar-block-styles',
    'tribe-events-views-v2-skeleton',
    'tribe-events-views-v2-bootstrap-datepicker-styles',
    // 'tribe-events-v2-single-skeleton',
    'tec-variables-skeleton-css'
  ];

  foreach ($styles as $style) {
    wp_dequeue_style($style);

    tribe('assets')->remove($style);
  }
}
add_action('wp_enqueue_scripts', 'remove_tribe_styles', 100);


// Disable Tribe Events Calendar Archive Page
function disable_tribe_events_archive_template() {
  if (is_post_type_archive('tribe_events')) {
    global $wp_query;
    $wp_query->set_404();

    status_header(404);
    get_template_part(404);

    exit();
  }
}
add_filter('archive_template', 'disable_tribe_events_archive_template', 10);


// Hide Tribe Events Additional Fields from the front-end
function tribe_hide_custom_meta() {
  // If on the front-end, return no data.
  if (!is_admin()) {
    return '';
  }
}
add_action('tribe_get_custom_fields', 'tribe_hide_custom_meta', 100);

// Responsive Embed
function video_embed_wrapper($html, $url, $attr, $post_id) {
  if (strpos($html, 'youtube') !== false) {
    $html = '<div class="mb-5 aspect-w-16 aspect-h-10">' . $html . '</div>';
  }

  return $html;
}
add_filter('embed_oembed_html', 'video_embed_wrapper', 10, 4);


// Register new featured image field in rest api
function register_rest_images()
{
  register_rest_field(['database', 'post'],
    'featured_img_url',
    [
      'get_callback' => 'get_rest_featured_image',
      'update_callback' => null,
      'schema' => null,
    ]
  );

  register_rest_field(['post'],
    'featured_img_url_large',
    [
      'get_callback' => function($object) {
        $img = wp_get_attachment_image_src($object['featured_media'], '2048x2048');

        return $img[0];
      },
      'update_callback' => null,
      'schema' => null,
    ]
  );
}
add_action('rest_api_init', 'register_rest_images');


function get_rest_featured_image($object)
{
  if ($object['featured_media']) {
    $img = wp_get_attachment_image_src($object['featured_media'], 'large');

    return $img[0];
  }

  return false;
}


// Function to get category names for REST API callback
function get_categories_names($object, $field_name, $request)
{
  $formatted_categories = [];

  if (get_post_type() == 'database') {
    $taxonomy = 'database_categories';
  } else {
    $taxonomy = 'category';
  }

  $categories = get_the_terms($object['id'], $taxonomy);

  if ($categories) {
    foreach ($categories as $category) {
      $singular_name = get_field('category_singular_name', 'category_' . $category->term_id);

      if ($singular_name) {
        $formatted_categories[] = $singular_name;
      } else {
        $formatted_categories[] = $category->name;
      }
    }
  }

  return $formatted_categories;
}


// Add category names field to REST API
function register_categories_names_field() {
  register_rest_field(['post', 'database'],
    'categories_names',
    [
      'get_callback' => 'get_categories_names',
      'update_callback' => null,
      'schema' => null,
    ]
  );
}
add_action('rest_api_init', 'register_categories_names_field');


// Add category placeholder image field to REST API
function register_database_term_image_field() {
  register_rest_field(['database_categories'],
    'placeholder_image',
    [
      'get_callback' => 'get_category_placeholder_image',
      'update_callback' => null,
      'schema' => null,
    ]
  );
}
add_action('rest_api_init', 'register_database_term_image_field');


// Return the terms placeholder image in REST
function get_category_placeholder_image($object)
{
  $term_id = $object['id'];
  $placeholder_image = get_field('database_category_placeholder_image', 'database_categories_' . $term_id);

  if ($placeholder_image) {
    return $placeholder_image;
  }

  return false;
}


// Alter search posts per page
function search_posts_per_page($query) {
  if ($query->is_search() && $query->is_main_query() && ! is_admin()) {
    $query->set('posts_per_page', '20');
  }
}
add_filter('pre_get_posts', 'search_posts_per_page');


// Cleaner search url
function change_search_url() {
  if (is_search() && !empty($_GET['s'])) {
    wp_redirect(home_url("/search/") . urlencode(get_query_var('s')));
    exit();
  }
}
add_action('template_redirect', 'change_search_url');


// Set REST API output to standard
add_filter('acf/settings/rest_api_format', function () {
  return 'standard';
});


// Enable REST API increase of posts per page
function increase_per_page_max($params)
{
  $params['per_page']['maximum'] = 500;
  return $params;
}

add_filter('rest_database_collection_params', 'increase_per_page_max');


/**
* If The Events Calendar is active, restores the default exclude_from_search
* property of the venue post type.
*/
function disable_public_venue_search() {
  if (!class_exists('Tribe__Events__Main')) {
    return;
  }

  $tec = Tribe__Events__Main::instance();
  $venue_args = $tec->postVenueTypeArgs;
  $venue_args['exclude_from_search'] = true;

  register_post_type(Tribe__Events__Main::VENUE_POST_TYPE, apply_filters('tribe_events_register_venue_type_args', $venue_args));
}
add_action('wp_loaded', 'disable_public_venue_search', 50); // ECP enables search for venues during wp_loaded:10 so we need this to run just after that


// Add custom event button text field to REST API
function add_event_custom_button_text ($data, $request) {
  foreach ($data['events'] as $key => $value) {
    $custom_button_text = tribe_get_event_meta($value['id'], '_ecp_custom_2', true);
    $button_text = ($custom_button_text ? $custom_button_text : 'View Details'); 

    $data['events'][$key]['button_text'] = $button_text;
  }

  return $data;
}
add_filter('tribe_rest_events_archive_data', 'add_event_custom_button_text', 10, 2);


// First, this will disable support for comments and trackbacks in post types
function df_disable_comments_post_types_support() {
  $post_types = get_post_types();
  foreach ($post_types as $post_type) {
    if(post_type_supports($post_type, 'comments')) {
      remove_post_type_support($post_type, 'comments');
      remove_post_type_support($post_type, 'trackbacks');
    }
  }
}

add_action('admin_init', 'df_disable_comments_post_types_support');

// Then close any comments open comments on the front-end just in case
function df_disable_comments_status() {
  return false;
}
add_filter('comments_open', 'df_disable_comments_status', 20, 2);
add_filter('pings_open', 'df_disable_comments_status', 20, 2);

// Finally, hide any existing comments that are on the site.
function df_disable_comments_hide_existing_comments($comments) {
  $comments = array();
  return $comments;
}
add_filter('comments_array', 'df_disable_comments_hide_existing_comments', 10, 2);


// Update Post tags to use the correct checkbox fields in admin
function wpse_modify_taxonomy() {
  // get the arguments of the already-registered taxonomy
  $post_tag_args = get_taxonomy('post_tag'); // returns an object
  $post_tag_args->meta_box_cb = "post_categories_meta_box";
  $post_tag_args->hierarchical = true;

  // re-register the taxonomy
  register_taxonomy('post_tag', ['tribe_events', 'post'], (array) $post_tag_args);
}
add_action('init', 'wpse_modify_taxonomy', 11);
