<?php
global $wp_query;

if (!empty($wp_query->query_vars['s'])) {
  $paged = !empty($wp_query->query_vars['paged']) ? $wp_query->query_vars['paged'] : 1;
  $prev_posts = ($paged - 1) * $wp_query->query_vars['posts_per_page'];
  $from = 1 + $prev_posts;
  $to = count($wp_query->posts) + $prev_posts;
  $of = $wp_query->found_posts;
  $total_string = sprintf('%s - %s of %s', $from, $to, $of);
} ?>

<main>
  <div class="hidden pt-24 md:block">
    <?php get_template_part('templates/partials/breadcrumb'); ?>
  </div>
  <section class="container pt-44 md:pt-40">

    <!-- Widths -->
    <div class="w-10/12 max-w-3xl mx-auto">

      <!-- Results Summary / Page indicator -->
      <div class="flex items-end justify-between mb-5">
        <h2 class="w-3/4 pr-10 text-2xl leading-5 text-green-800 uppercase font-runda">
          <?php echo $of; ?> Search Results for: <?php the_search_query(); ?>
        </h2>
        <span class="w-1/4 text-sm leading-3 text-right md:leading-3 md:text-base">
          <?php echo $total_string; ?>
        </span>
      </div>
      <!-- Close Results Summary / Page indicator -->

      <!-- Search Loop -->
      <div><?php
      if (have_posts() && get_search_query()) : 
        while (have_posts()) : the_post();
          $permalink = get_permalink();
          $title = get_the_title();
          $excerpt = get_the_excerpt(); 

          if (!$excerpt) {
            $excerpt = get_post_meta(get_the_ID(), '_yoast_wpseo_metadesc', true);
          } ?>

          <!-- Search Result -->
          <a href="<?php echo esc_url($permalink); ?>" class="flex justify-between border-t border-gray-100 last:border-b py-7 md:py-8">
            
            <div class="w-11/12">
              <!-- Title -->
              <h3 class="mb-1.5 text-2xl leading-6 text-green-800 capitalize">
                <?php echo ucwords(strtolower($title)); ?>
              </h3>

              <!-- Excerpt -->
              <span>
                <?php echo $excerpt; ?>
              </span>
            </div>

            <div class="flex items-center justify-end w-1/12">
              <?php echo svg(['sprite' => 'arrow-head', 'class' => 'w-3 h-4 text-beige-800 fill-current']); ?>
            </div>

          </a>
          <!-- Close Search Result --><?php
        endwhile; 

        $args = wp_parse_args(
          $args, [
            'mid_size' => 2,
            'prev_next' => true,
            'prev_text' => svg(['sprite' => 'arrow-head', 'class' => 'w-4 h-4 rotate-180 fill-current mr-1.5']) . "<span>Prev</span>",
            'next_text' => "<span>Next</span>" . svg(['sprite' => 'arrow-head', 'class' => 'w-4 h-4 fill-current ml-1.5']),
            'screen_reader_text' => __('Posts navigation'),
            'type' => 'array',
            'current' => max(1, get_query_var('paged')),
          ]
        );
        
        $links = paginate_links($args); 

        if ($links) :
          $links_count = count($links);
          $i = 1;  ?>
          <!-- Pagination -->
          <nav aria-label="pagination" class="w-10/12 pt-10 mx-auto mb-10 border-t border-gray-100 md:pt-12 md:mb-24">
            <ul class="flex items-center justify-center font-bold uppercase search-pagination"><?php

              foreach ($links as $key => $link) :
              ?>
                <li class="flex items-center mx-1.5 rounded-md text-beige-800">
                  <?php echo str_replace('page-numbers', 'page-link', $link); ?>
                </li><?php 
              endforeach; ?>       
            </ul>
          </nav>
          <!-- Close Pagination -->
          <?php
        endif; //  End in links

      endif; // End if search loop ?>
      </div>
      <!-- Close Search Loop -->

    </div>
    <!-- Close Widths -->

  </section>
</main>
