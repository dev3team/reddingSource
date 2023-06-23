<?php
$logo = get_sub_field('logo');
$image_values = \Tofino\Helpers\responsive_image_attribute_values($logo); 
$file_type = pathinfo($image_values['src'], PATHINFO_EXTENSION); ?>

<img
  src="<?php echo $image_values['src']; ?>"<?php
  if ($file_type !== 'svg'): ?>
    srcset="<?php echo $image_values['srcset']; ?>"<?php
  endif;
  if ($file_type !== 'svg'): ?>
    sizes="<?php echo $image_values['sizes']; ?>"<?php
  endif; ?>
  alt="<?php echo $image_values['alt']; ?>"
  loading="lazy"
  width="300" 
  height="230"
  class="object-contain w-24 h-20 mx-auto md:w-28 md:h-28" />
