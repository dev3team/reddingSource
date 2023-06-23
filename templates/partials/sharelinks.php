<?php
$post_id       = get_the_ID();
$url           = get_permalink($post_id);

$platforms = [
  'facebook' => 'Facebook',
  'twitter' => 'Twitter',
  'linkedin' => 'LinkedIn',
  'pinterest' => 'Pinterest',
];

if ($platforms) : ?>
  <div class="share-wrapper">
    <span class="share-title">
      Share
    </span>
    <ul class="flex share-links"><?php
      foreach ($platforms as $key => $value) : ?>
        <li>
          <a href="<?php echo $url; ?>"
            rel="nofollow noreferrer"
            data-platform="<?php echo $key; ?>"
            title="<?php _e('Share on'); ?> <?php echo $value; ?>"
            class="share">
              <?php echo svg(['sprite' => $key, 'class' => 'w-full h-full']); ?>
          </a>
        </li><?php
      endforeach; ?>
    </ul>
  </div><?php
endif; ?>