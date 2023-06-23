<?php
/**
 * CrowdRiff Shortcode
 *
 * @since 1.0.0
 * @return string HTML output of crowdriff embed.
 */
function crowdriff($atts = []) { 
  $atts = shortcode_atts([
    'id'  => '',
  ], $atts, 'crowdriff');

  $output = '<div class="crowdriff-wrapper"><script id="' . $atts['id'] . '" src="https://starling.crowdriff.com/js/crowdriff.js" async></script></div>';

  return $output;
}
add_shortcode('crowdriff', 'crowdriff');
