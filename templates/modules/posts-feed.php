<?php
$posts = get_field('post_feed', 'option');

if ($posts) : ?>
  <!-- Posts Feed -->
  <section class="container prose-mobile md:prose-tablet xl:prose-desktop posts-feed">

    <!-- Width Wrapper -->
    <div class="w-11/12 mx-auto lg:w-10/12">

      <!-- Title -->
      <h2 class="mb-6 text-center text-green-800 uppercase">
        <?php echo \Tofino\Helpers\fix_text_orphan(get_sub_field('posts_title')); ?>
      </h2>

      <!-- Tags -->
      <ul class="flex flex-wrap justify-center mb-6 md:flex-nowrap md:justify-around"><?php
        foreach ($posts as $index => $post) : ?>
          <li class="w-1/3 py-3 md:w-auto md:py-0">
            <button
              data-id="<?php echo $index; ?>"
              class="w-full font-bold text-green-500 uppercase duration-500 ease-in-out cursor-pointer js-crowdriff-tag font-runda hover:text-orange-500 <?php echo ($index === 0 ? 'js-active-tag' : null); ?>"
              >
              <?php echo $post['category_tag']; ?>
            </button>
          </li><?php
        endforeach; ?>
      </ul>
      <!-- Tags -->

      <!-- Grid --><?php 
      foreach ($posts as $index => $post) : ?>
        <div data-id="<?php echo $index; ?>"
          class="<?php echo ($index > 0 ? 'hidden ' : null); ?> js-crowdriff-grid"
          >
          <script id="<?php echo $post['category_id']; ?>" src="https://starling.crowdriff.com/js/crowdriff.js" async></script>
        </div><?php
      endforeach; ?>
      <!-- Grid -->

    </div>
    <!-- Close Width Wrapper -->

  </section>
  <!-- Close Posts Feed --><?php
  wp_reset_postdata();
endif; ?>
