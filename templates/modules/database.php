<?php
$database_terms = get_sub_field('database_terms');

//$page = end(explode('/', trim($_SERVER['REQUEST_URI'], '/')));

foreach ($database_terms as $term) {
//    if (intval($term) !== 99) continue;
    $database_terms_int[] = intval($term);
}

// Layout Style
$database_view = get_sub_field('layout_style');

// Hide Filter
$hide_filter = get_sub_field('database_hide_filter');

if ($database_terms) : ?>
  <div class="pt-7 prose-mobile md:prose-tablet md:pt-14 xl:prose-desktop xl:pt-20 md:pb-7 xl:pb-10">
    <h2 class="mb-6 text-center text-green-800 uppercase">
      Explore More in Redding
    </h2>
  </div>
  <div class="js-database">
    <database :hide-filter="<?php echo $hide_filter ? 'true' : 'false'; ?>" :terms='<?php echo json_encode($database_terms_int); ?>' view="<?php echo $database_view; ?>"></database>
  </div><?php
endif; ?>