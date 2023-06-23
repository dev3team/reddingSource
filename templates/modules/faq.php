<?php
$faq_title = get_sub_field('faq_title');

$args = [
  'post_type'      => 'faqs',
  'posts_per_page' => -1,
  'order_by'       => 'DESC'
];

$query = new WP_Query($args);
$count = $query->found_posts;
$keys = range(1, $count); ?>

<section faq-section class="bg-beige-200 prose-mobile md:prose-tablet xl:prose-desktop">
  <div class="container pt-12 pb-14 md:py-20 xl:pb-24"><?php

    if ($faq_title) : ?>
      <h2 class="w-10/12 mx-auto mb-6 text-center text-green-800 uppercase md:mb-10 lg:w-3/4 xl:w-2/3 xl:mb-14 2xl:w-7/12">
        <?php echo $faq_title; ?>
      </h2><?php
    endif;

    if ($query->have_posts()) : ?>
      <!-- Expand All Button -->
      <div class="flex justify-end w-10/12 mx-auto mb-3 lg:w-3/4 xl:w-2/3 2xl:w-7/12">
        <button @click="toggleAll(<?php echo json_encode($keys); ?>)" class="text-sm font-bold tracking-wide uppercase text-beige-800">
        {{ active.length == <?php echo $count; ?> ? 'Close All' : 'Expand All' }}
        </button>
      </div>
      <!-- Close Expand All Button -->

      <!-- Flex Wrapper -->
      <div class="relative z-10 flex flex-col w-10/12 mx-auto border-t border-beige-500 lg:w-3/4 xl:w-2/3 2xl:w-7/12"><?php

        $x = 1;
        while ($query->have_posts()) : $query->the_post();
          $answer_text = get_field('answer_text'); ?>
          <!-- FAQ Item -->
          <div
            v-on:click="toggle(<?php echo $x; ?>)"
            :aria-expanded="isOpen(<?php echo $x; ?>) ? 'true' : 'false' "
            class="relative w-full px-4 py-6 border-b cursor-pointer select-none border-beige-500 md:px-6 md:py-8 xl:px-8 group"
            :class="{'bg-white offset-frame-right offset-frame-light-green' : isOpen(<?php echo $x; ?>)}"
          >

            <!-- Question Title -->
            <div
              class="flex justify-between font-black group-hover:text-orange-500"
              :class="{'text-green-800' : isOpen(<?php echo $x; ?>), 'text-beige-800' : !isOpen(<?php echo $x; ?>)}"
            >
              <span class="self-center pr-6 leading-none md:text-lg md:leading-none md:pr-20 lg:pr-32 xl:pr-24 xl:text-2xl xl:leading-none">
                <?php the_title(); ?>
              </span>

              <span  class="self-center flex-shrink-0 w-3 h-3 md:w-4 md:h-4 xl:w-5 xl:h-5">
                <span v-if="!isOpen(<?php echo $x; ?>)">
                  <?php echo svg(['sprite' => 'faq-plus-icon', 'class' => 'fill-current w-full h-full']); ?>
                </span>
                <span v-else>
                  <?php echo svg(['sprite' => 'faq-minus-icon', 'class' => 'fill-current w-full h-full']); ?>
                </span>
              </span>
            </div>
            <!-- Close Question Title -->

            <!-- Question Answer -->
            <div
              role="region"
              v-if="isOpen(<?php echo $x; ?>)"
              class="w-11/12 pt-4 text-base"
            >
              <div class="content-green bold-hyperlinks">
                <?php echo $answer_text; ?>
              </div>
            </div>
            <!-- Close Question Answer -->

          </div>
          <!-- Close FAQ Item --><?php
          $x++;
        endwhile;
        wp_reset_query();
        wp_reset_postdata(); ?>

      </div>
      <!-- Close Flex Wrapper --><?php
    endif; ?>

  </div>
</section>