<?php
/**
 *
 * Events Form functions
 *
 * @package Tofino
 * @since 1.0.0
 */

namespace Tofino\Events;

use \Respect\Validation\Validator as v;

/**
 * Ajax Event Form
 *
 * Process the ajax request.
 * Called via JavaScript.
 *
 * @since 1.2.0
 * @return void
 */
function ajax_event_form() {
  // check_ajax_referer('next_nonce', 'security');

  $form = new \Tofino\AjaxForm(); // Required

  $referrer_path = parse_url($_SERVER['HTTP_REFERER'], PHP_URL_PATH);
  $real_referrer = get_site_url() . $referrer_path;
  $post_id = url_to_postid($real_referrer); // Get the post_id from the referring page

  // Define empty array for populate validation rules
  $fields = [];

  // Defined expected fields. Keys should match the input field names.
  // Add validation rules. See: https://respect-validation.readthedocs.io/en/latest/
  // setName is used for the return error messages
  $fields = [
    'title'        => v::alwaysValid()->setName('Event Title'),
    'description'  => v::alwaysValid()->setName('Event Description'),
    'categories'   => v::notEmpty()->setName('Choose Categories'),
    'eventWebsite' => v::alwaysValid()->setName('Event Website'),
    'eventCost'    => v::alwaysValid()->setName('Event Cost'),

    // Date / Time
    'startDate' => v::date('Y-m-d')->setName('Start Date'),
    'startTime' => v::optional(v::time('g:i A'))->setName('Start Time'),
    'endDate'   => v::date('Y-m-d')->setName('End Date'),
    'endTime'   => v::optional(v::time('g:i A'))->setName('End Time'),

    // All Day
    'allDay' => v::boolVal()->setName('All Day'),
    
    // Image
    'imageString' => v::notEmpty()->setName('Image'),

    // Organizer
    'organizerName'    => v::notEmpty()->setName('Organizer Name'),
    'organizerPhone'   => v::phone()->setName('Organizer Phone'),
    'organizerEmail'   => v::email()->setName('Organizer Email'),
    'organizerWebsite' => v::alwaysValid()->setName('Organizer Website'),
  ];

  // error_log('Form Data: ' . print_r($form->form_data, true));

  // Check if venue is a NOT an integer
  if (!is_numeric($form->form_data['venuePostId'])) {
    // Add venue fields to the validation rules
    $venue_fields = [
      'venueName'    => v::notEmpty()->setName('Venue Name'),
      'venueAddress' => v::notEmpty()->setName('Venue Address'),
      'venueCity'    => v::notEmpty()->setName('Venue City'),
      'venueCountry' => v::notEmpty()->setName('Venue Country'),
      'venueState'   => v::notEmpty()->setName('Venue State'),
      'venueZip'     => v::notEmpty()->setName('Venue Zip'),
      'venuePhone'   => v::alwaysValid()->setName('Venue Phone'),
      'venueWebsite' => v::alwaysValid()->setName('Venue Website'),
    ];
  } else {
    $venue_fields = [
      'venuePostId' => v::intVal()->setName('Venue Post ID'),
    ];
  }

  // Merge validation rules
  $fields = array_merge($fields, $venue_fields);

  $form->validate($fields); // Required Call validate
  $data = $form->getData(); // Do what you want with the sanitized form data

  if ($data['allDay']) {
    $data['startTime'] = '12:00 AM';
    $data['endTime'] = '11:59 PM';
  }

  $start_date_time = new \DateTime($data['startDate'] . ' ' . $data['startTime']);
  $end_date_time = new \DateTime($data['endDate'] . ' ' . $data['endTime']);

  if (!is_numeric($form->form_data['venuePostId'])) {
    $venue_meta = [
      'Venue'   => $data['venueName'],
      'Country' => $data['venueCountry'],
      'Address' => $data['venueAddress'],
      'City'    => $data['venueCity'],
      'State'   => $data['venueState'], // Must be two letter state abbreviation.
      'Zip'     => $data['venueZip'],
      'Phone'   => $data['venuePhone'],
      'URL'     => $data['venueWebsite'],
    ]; // Array of data to create or update an Venue to be associated with the Event {@link tribe_create_venue(}.
  
    $venue_id = tribe_create_venue($venue_meta); // Create a Venue to be associated with the Event {@link tribe_create_venue}.
  
    // Check we have a venue ID
    // if ($venue_id) {
    //   // Update the post to be status 'draft' due to bug in plugin.
    //   // Ref: https://wordpress.org/support/topic/tribe_create_venue-doesnt-take-care-of-post_status/
    //   // See: https://github.com/the-events-calendar/the-events-calendar/blob/69e4426d02b72ffafbeb6daead09247e3f05b430/src/functions/advanced-functions/venue.php#L38
    //   wp_update_post([
    //     'ID' => $venue_id,
    //     'post_status' => 'draft',
    //   ]);
    // }
  } else {
    $venue_id = $data['venuePostId'];
  }

  $organizer_meta = [
    'Organizer' => $data['organizerName'],
    'Phone'     => $data['organizerPhone'],
    'Email'     => $data['organizerEmail'],
    'EventURL'  => (isset($data['organizerWebsite']) ? $data['organizerWebsite'] : null),
  ]; // Array of data to create or update an Organizer to be associated with the Event {@link tribe_create_organizer}.

  $organizer_id = tribe_create_organizer($organizer_meta); // Create an Organizer to be associated with the Event {@link tribe_create_organizer}.

  $event_meta = [
    'post_title'   => $data['title'],
    'post_excerpt' => '',
    'post_content' => $data['description'],
    'EventAllDay' => $data['allDay'],
    'EventShowMapLink' => 1,
    'EventShowMap' => 1,
    'EventVenueID' => $venue_id, // ID of a Venue to be associated with the Event {@link tribe_create_venue}.
    'EventOrganizerID' => $organizer_id, // ID of an Organizer to be associated with the Event {@link tribe_create_organizer}.
    'EventStartDate' => $start_date_time->format('Y-m-d'),
    'EventStartTime' => $start_date_time->format('H:i:s'),
    'EventEndDate'   => $end_date_time->format('Y-m-d'),
    'EventEndTime'   => $end_date_time->format('H:i:s'),
    'EventURL'       => $data['eventWebsite'],
    'EventCost'      => $data['eventCost'],
  ];

  $result = tribe_create_event($event_meta);

  // Check for image upload string
  if ($data['imageString']) {
    $event_image = \Tofino\Helpers\upload_user_file($data['imageString'], 'event_image_' . $result, $result);

    // Add image id to post meta
    add_post_meta($result, '_thumbnail_id', $event_image, true);
  }

  // Update to include the categories
  wp_set_post_terms($result, $data['categories'], 'tribe_events_cat');

  // error_log(print_r($result, true));

  if (!$result) {
    $form->respond(false, 'There was an error creating the event.');
  } else {
    $form->respond(true, 'Thank You for submitting your event!');
  }
}
add_action('wp_ajax_ajax_event_form', __NAMESPACE__ . '\\ajax_event_form');
add_action('wp_ajax_nopriv_ajax_event_form', __NAMESPACE__ . '\\ajax_event_form');
