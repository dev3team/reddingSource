<?php
$marquee_type = get_sub_field('marquee_type');

if (!$marquee_type) {
  $marquee_type = 'default';
}

get_template_part('templates/partials/marquee', $marquee_type);

// Breadcrumb
if (!is_front_page() && !is_404() && !is_page(\Tofino\Helpers\get_id_by_slug('events-calendar/add-event', 'page')) && !is_page(\Tofino\Helpers\get_id_by_slug('newsletter', 'page'))) :
  get_template_part('templates/partials/breadcrumb');
endif; ?>
