<?php
$data = (!empty($template_args) ? $template_args : null);

if ($data) : ?>
  <a href="<?php echo $data['permalink']; ?>" target="<?php echo $data['target'] ?>" class="relative block col-span-12 prose-mobile md:col-span-6 md:prose-tablet xl:col-span-4 xl:prose-desktop offset-frame-right offset-frame-light-green page-link-tile">
    <div class="relative w-full bg-green-800 aspect-w-16 aspect-h-12 md:aspect-h-13 after:absolute after:inset-0 after:bg-black tile-aspect"><?php

      if ($data['image_src']) : ?>
        <!-- BG Image -->
        <img
          src="<?php echo $data['image_src']; ?>"
          srcset="<?php echo $data['image_srcset']; ?>"
          sizes="<?php echo $data['image_sizes']; ?>"
          loading="lazy"
          alt="<?php echo $data['image_alt']; ?>"
          class="absolute inset-0 block object-cover w-full h-full">
        <!-- Close BG Image --><?php
      endif; ?>

      <!-- Inner Content -->
      <div class="absolute inset-0 z-10 flex items-center justify-center w-full h-full">
        <div class="flex flex-col px-10 py-6 text-center text-white md:px-6 lg:px-14 xl:px-6 2xl:px-10">
          <h3 class="uppercase">
            <?php echo $data['title']; ?>
          </h3>
          <!-- Hover Content-->
          <div class="flex flex-col pt-2 hover-content">
            <span class="text-sm 2xl:text-base">
              <?php echo \Tofino\Helpers\fix_text_orphan($data['excerpt']); ?>
            </span>
            <span class="flex items-center self-center px-4 py-3 mt-4 text-xs font-bold tracking-wider uppercase bg-yellow-500 rounded-lg whitespace-nowrap 2xl:text-sm">
              <?php echo $data['tagline']; ?>
              <span class="w-4 h-4 ml-2">
                <?php echo svg(['sprite' => 'icon-arrow', 'class' => 'w-full h-full fill-current']); ?>
              </span>
            </span>
          </div>
          <!-- Close Hover Content-->
        </div>
      </div>
      <!-- Close Inner Content -->

    </div>
  </a><?php
endif; ?>