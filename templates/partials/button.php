<?php
$data = (!empty($template_args) ? $template_args : null);

if ($data) : ?>
  <a href="<?php echo esc_url($data['url']); ?>"
    target="<?php echo esc_attr($data['target'] === '_blank' ? $data['target'] : '_self'); ?>"
    class="flex whitespace-nowrap items-center justify-center px-5 py-3 text-base font-bold tracking-wider text-white uppercase duration-500 ease-in-out rounded-lg group md:w-auto button-<?php echo $data['color']; ?>"
    >
    <span class="pl-1 duration-500 ease-in-out translate-x-1.5 group-hover:translate-x-0">
      <?php echo esc_html($data['text']); ?>
    </span>
    <?php echo svg(['file' => 'button-arrow']); ?>
  </a><?php
endif; ?>
