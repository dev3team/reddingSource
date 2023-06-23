<?php
$post_type = get_sub_field('blog_display');

$args = [
  'post_type'      => $post_type->name,
  'posts_per_page' => -1,
  'order'          => 'ASC'
];

$query = new WP_Query($args);

if ($post_type = 'post') {
  $post_type = 'posts';
} ?>

<section class="js-blog">
  <blog post-type="<?php echo $post_type; ?>"></blog>
</section>