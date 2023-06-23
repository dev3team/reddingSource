<?php
$overview_type = get_sub_field('overview_type');

if (!$overview_type) {
  $overview_type = 'default';
}

get_template_part('templates/partials/overview-content', $overview_type);