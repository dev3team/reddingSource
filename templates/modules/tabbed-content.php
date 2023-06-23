<?php
$tabbed_content = get_sub_field('tab_setup');

if ($tabbed_content) : ?>
  <!-- Tabbed Content -->
  <section tabbed-content class="py-10 overflow-hidden md:py-14 xl:py-20 bg-beige-200">
    
    <!-- Container -->
    <div class="container">

      <!-- Flex Wrapper -->
      <div class="md:flex-wrap md:flex w-10/12 mx-auto max-w-[85rem] xl:w-full">

        <!-- Tablet+ Labels -->
        <ul class="md:w-[30%] xl:w-[17%] flex flex-col md:order-2 xl:order-1 xl:pt-14" v-if="currentBreakpoint !== 'small'"><?php

          foreach ($tabbed_content as $index => $item) : ?>
            <li @click="setTab('<?php echo $index ?>')"
              :class="isTabActive('<?php echo $index ?>') ? 'js-active-tab bg-blue-700 text-white' : 'text-beige-800'"
              class="flex items-center py-4 mb-2 min-h-[4rem] text-sm font-bold leading-none tracking-wider uppercase rounded-lg cursor-pointer px-7">
              <!-- Label -->
              <span class="w-2/3 xl:w-3/4">
                <?php echo $item['tab_label']; ?>
              </span>

              <!-- Graphic -->
              <div class="w-1/3 xl:w-1/4">
                <span v-if="isTabActive('<?php echo $index ?>')">
                  <?php echo svg(['sprite' => 'icon-arrow', 'class' => 'w-5 h-5 ml-7 fill-current']); ?>
                </span>
                <span v-else>
                  <?php echo svg(['sprite' => 'icon-carrot', 'class' => 'w-4 h-4 ml-2 xl:ml-5 fill-current']); ?>
                </span>
              </div>
            </li><?php
          endforeach; ?>

        </ul>
        <!-- Close Tablet+ Labels --><?php

        // Loop through content
        foreach ($tabbed_content as $index => $item) :
          $tab_image = $item['tab_image'];
          $tab_title = $item['tab_title'];
          $tab_label = $item['tab_label'];
          $top_small_label = $item['top_small_label'];?>

          <!-- Mobile Labels -->
          <div v-if="currentBreakpoint === 'small'"
            @click="setTab('<?php echo $index; ?>')"
            :ref="isTabActive('<?php echo $index; ?>') ? 'activeTab' : ''"
            :class="isTabActive('<?php echo $index ?>') ? 'js-active-tab mb-6 bg-blue-700 text-white' : 'bg-white text-beige-800'"
            class="flex items-center justify-center p-5 mb-3 text-sm font-bold tracking-wider uppercase rounded-lg cursor-pointer"
            >
            <!-- Label -->
            <span class="font-bold">
              <?php echo $tab_label; ?>
            </span>

            <!-- Icon -->
            <span
              class="self-center w-4 h-4 ml-4 transform"
              :class="currentTab < <?php echo $index; ?> ? '-rotate-90' : 'rotate-90'"
              >
              <?php echo svg(['sprite' => 'icon-carrot', 'class' => 'w-full h-full fill-current']); ?>
            </span>
          </div>
          <!-- Close Mobile Labels -->
          
          <!-- Content Wrapper -->
          <div class="md:contents" v-if="isTabActive('<?php echo $index; ?>')">
            
            <!-- Image -->
            <div class="relative self-start z-10 mb-6 md:mb-10 xl:mx-auto md:w-full xl:w-[45%] md:order-1 xl:order-3 offset-frame-right offset-frame-light-blue">
              <div class="aspect-w-4 aspect-h-3 md:aspect-w-3 md:aspect-h-2 xl:aspect-w-4 xl:aspect-h-3"><?php
                if ($tab_image) :
                  $image_values = \Tofino\Helpers\responsive_image_attribute_values($tab_image['id']); ?>
                  <img
                    src="<?php echo $image_values['src']; ?>"
                    srcset="<?php echo $image_values['srcset']; ?>"
                    sizes="<?php echo $image_values['sizes']; ?>"
                    alt="<?php echo $image_values['alt']; ?>"
                    loading="lazy"
                    width="300" 
                    height="230"
                    class="object-cover w-full h-full"
                    >
                  <?php
                endif; ?>
              </div>
            </div>
            <!-- Close Image -->

            <!-- Content -->
            <div class="prose-mobile md:prose-tablet xl:prose-desktop md:order-3 md:w-[70%] xl:w-[34%] md:pl-14 xl:pl-8 xl:pr-4 xl:order-2 2xl:pl-10">

              <!-- Label -->
              <span class="block mb-2 font-bold leading-none uppercase text-beige-800">
                <?php echo ($top_small_label ? $top_small_label : $tab_label); ?>
              </span>

              <!-- Title -->
              <h3 class="mb-3 text-green-800 uppercase md:mb-4">
                <?php echo ($tab_title ? $tab_title : $tab_label); ?>
              </h3>

              <!-- Copy -->
              <div class="mb-10 tabbed-content">
                <?php echo $item['tab_copy']; ?>
              </div>

            </div>
            <!-- Close Content -->

          </div>
          <!-- Close Content Wrapper --><?php

        // End Loop through content
        endforeach;?>
        
      </div>
      <!-- Close Flex Wrapper -->

    </div>
    <!-- Close Container -->

  </section>
  <!-- Close Tabbed Content --><?php
endif; ?>
