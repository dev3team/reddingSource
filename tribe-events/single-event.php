<?php
/**
 * Single Event Template
 * A single event. This displays the event title, description, meta, and
 * optionally, the Google map for the event.
 *
 * Override this template in your own theme by creating a file at [your-theme]/tribe-events/single-event.php
 *
 * @package TribeEventsCalendar
 * @version 4.6.19
 *
 */

if ( ! defined( 'ABSPATH' ) ) {
	die( '-1' );
}

$events_label_singular = tribe_get_event_label_singular();
$events_label_plural   = tribe_get_event_label_plural();
$event_id = get_the_ID();
$custom_button_text = tribe_get_event_meta(get_the_ID(), '_ecp_custom_2', true);
$button_text = ($custom_button_text ? $custom_button_text : 'Register Here'); ?>

<article class="container">
  <div class="events-flex-wrapper">

    <!-- Back Button -->
    <a href="<?php echo (get_permalink(get_page_by_path('/events-calendar'))); ?>" class="flex items-center self-start mb-8 text-sm font-bold tracking-wider uppercase text-beige-800 all-events-button">
      <span>
        <?php echo svg(['sprite' => 'icon-carrot', 'class' => 'w-full h-full fill-current']); ?>
      </span>
      All Events
    </a>
    <!-- Close Back Button -->

    <!-- Content Wrapper -->
    <div class="event-content-wrapper">
      <!-- Featured Image -->
      <div class="event-image-wrapper">
        <div class="event-featured-image">
          <?php echo tribe_event_featured_image($event_id, 'full', false); ?>
        </div>
      </div>

      <!-- Inner Content -->
      <div class="event-inner-content">
        <span class="event-date">
          <?php echo tribe_events_event_schedule_details($event_id); ?>
        </span>
        <h2 class="event-main-title">
          <?php the_title(); ?>
        </h2>
        <div class="event-main-description">
          <?php the_content(); ?>
        </div>
        <div class="event-register-cta"><?php
          \Tofino\Helpers\hm_get_template_part('templates/partials/button', [
            'url'    => tribe_get_event_meta(get_the_ID(), '_EventURL', true),
            'target' => '_blank',
            'text'   => $button_text,
            'color'  => 'green',
          ]); ?>
        </div>
      </div>
    </div>
    <!-- Close Content Wrapper -->

    <!-- Map Wrapper -->
    <div class="event-map-wrapper">
      <?php do_action( 'tribe_events_single_event_before_the_meta' ) ?>
      <?php tribe_get_template_part( 'modules/meta' ); ?>
      <?php do_action( 'tribe_events_single_event_after_the_meta' ) ?>
    </div>
    <!-- Close Map Wrapper -->

    <!-- Save the Date -->
    <div class="save-the-date">
      <h2 class="save-the-date-title">
        Save The Date
      </h2>
      <?php do_action( 'tribe_events_single_event_after_the_content' ) ?>
    </div>
    <!-- Close Save the Date -->

    <!-- Register Here -->
    <div class="register-here">
      <div class="register-here-cta"><?php
        \Tofino\Helpers\hm_get_template_part('templates/partials/button', [
          'url'    => tribe_get_event_meta(get_the_ID(), '_EventURL', true),
          'target' => '_blank',
          'text'   => $button_text,
          'color'  => 'green',
        ]); ?>
      </div>
      <a href="<?php echo (get_permalink(get_page_by_path('/events-calendar'))); ?>" class="flex items-center self-start text-sm font-bold tracking-wider uppercase text-beige-800 all-events-button">
        <span>
          <?php echo svg(['sprite' => 'icon-carrot', 'class' => 'w-full h-full fill-current']); ?>
        </span>
        All Events
      </a>
    </div>
    <!-- Register Here -->

  </div>
</article>
