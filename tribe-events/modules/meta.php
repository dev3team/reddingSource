<?php
/**
 * Single Event Meta Template
 *
 * Override this template in your own theme by creating a file at:
 * [your-theme]/tribe-events/modules/meta.php
 *
 * @version 4.6.10
 *
 * @package TribeEventsCalendar
 */

do_action( 'tribe_events_single_meta_before' );

// Do we want to group venue meta separately?
$set_venue_apart = apply_filters( 'tribe_events_single_event_the_meta_group_venue', false, get_the_ID() );
?>

<?php
do_action( 'tribe_events_single_event_meta_primary_section_start' );

// Include venue meta if appropriate.
if ( tribe_get_venue_id() ) {
	// If we have no map to embed
	if ( ! tribe_embed_google_map() ) {
		tribe_get_template_part( 'modules/meta/venue' );
	} else {
		tribe_get_template_part( 'modules/meta/venue' );
		echo '<div class="tribe-events-meta-group tribe-events-meta-group-gmap">';
		tribe_get_template_part( 'modules/meta/map' );
		echo '</div>';
	}
}

do_action( 'tribe_events_single_event_meta_primary_section_end' );
?>
