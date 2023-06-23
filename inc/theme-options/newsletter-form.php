<?php
/**
 * Newsletter Form
 *
 * Theme options and form processing for the Newsletter Form.
 *
 * @package Tofino
 * @since 1.2.0
 */

namespace Tofino\NewsletterForm;

use \Respect\Validation\Validator as v;
use \Respect\Validation\Exceptions\NestedValidationExceptionInterface;


/**
 * Newsletter Form theme options
 *
 * @since 1.2.0
 * @param object $wp_customize Instance of WP_Customize_Manager class.
 * @return void
 */
function newsletter_form_settings($wp_customize) {
  $wp_customize->add_section('tofino_newsletter_form_settings', [
    'title' => __('Newsletter Form', 'tofino'),
    'priority' => 200
  ]);

  $wp_customize->add_setting('newsletter_form_to_address', ['default' => '']);

  $wp_customize->add_control('newsletter_form_to_address', [
    'label'       => __('To', 'tofino'),
    'description' => __('Email address used in the TO field. Leave blank to use the email address defined in Client Data settings.', 'tofino'),
    'section'     => 'tofino_newsletter_form_settings',
    'type'        => 'text'
  ]);

  $wp_customize->add_setting('newsletter_form_cc_address', ['default' => '']);

  $wp_customize->add_control('newsletter_form_cc_address', [
    'label'       => __('CC', 'tofino'),
    'description' => __('Add CC email address, seperate with a comma and a space (", ") to use multiple addresses.', 'tofino'),
    'section'     => 'tofino_newsletter_form_settings',
    'type'        => 'text'
  ]);

  $wp_customize->add_setting('newsletter_form_from_address', ['default' => '']);

  $wp_customize->add_control('newsletter_form_from_address', [
    'label'       => __('From', 'tofino'),
    'description' => __('Email address used in the FROM field. Leave blank for server default.', 'tofino'),
    'section'     => 'tofino_newsletter_form_settings',
    'type'        => 'text'
  ]);

  $wp_customize->add_setting('newsletter_form_subject', ['default' => '']);

  $wp_customize->add_control('newsletter_form_subject', [
    'label'       => __('Subject', 'tofino'),
    'description' => __('The subject field. Leave blank for "Form submission from SERVER_NAME".', 'tofino'),
    'section'     => 'tofino_newsletter_form_settings',
    'type'        => 'text'
  ]);

  $wp_customize->add_setting('newsletter_form_success_message', [
    'default' => __("Thanks, we'll be in touch soon.", 'tofino')
  ]);

  $wp_customize->add_control('newsletter_form_success_message', [
    'label'       => __('Success Message', 'tofino'),
    'description' => __('Message displayed to use after form action is successful.', 'tofino'),
    'section'     => 'tofino_newsletter_form_settings',
    'type'        => 'text'
  ]);

  $wp_customize->add_setting('newsletter_form_captcha', ['default' => '']);

  $wp_customize->add_control('newsletter_form_captcha', [
    'label'       => __('Enable reCAPTCHA', 'tofino'),
    'description' => __('Enable Google reCAPTCHA "I am not a robot".', 'tofino'),
    'section'     => 'tofino_newsletter_form_settings',
    'type'        => 'checkbox'
  ]);
}
add_action('customize_register', __NAMESPACE__ . '\\newsletter_form_settings');


/**
 * Ajax newsletter
 *
 * Process the ajax request.
 * Called via JavaScript.
 *
 * @since 1.2.0
 * @return void
 */
function ajax_newsletter_form() {
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
    'name'          => v::notEmpty()->setName('Name'),
    'email'         => v::email()->setName('Email'),
    'zip'           => v::alwaysValid()->setName('Zip'),
    'interestedIn'  => v::notEmpty()->setName('Interested In'),
    'optIn'         => v::notEmpty()->setName('Opt In'),
  ];

  $form->validate($fields); // Required  Call validate

  $data = $form->getData(); // Do what you want with the sanitized form data

  $post = [
    'ID'           => null,
    'post_title'   => sanitize_text_field($data['name']) . ' - ' . sanitize_text_field($data['email']),
    'post_excerpt' => '',
    'post_content' => null,
    'post_type'    => 'newsletter_form',
    'post_status'  => 'publish',
  ];

  $post_id = wp_insert_post($post);

  $post_meta = [
    'newsletter_form_name' => sanitize_text_field($data['name']),
    'newsletter_form_email' => sanitize_text_field($data['email']),
    'newsletter_form_zip' => sanitize_text_field($data['zip']),
  ];

  // Convert strings to integers
  $interested_in_ids = array_map('intval', $data['interestedIn']);

  // Update post terms
  $terms_added = wp_set_post_terms($post_id, $interested_in_ids, 'categories_of_interest');

  // Update the post meta
  foreach ($post_meta as $key => $value) {
    update_field($key, $value, $post_id);
  }

  $admin_email_success = $form->sendEmail([ // Send out an email
    'to'                 => get_theme_mod('newsletter_form_to_address'),
    'reply-to'           => $data['name'] . ' - ' . $data['email'] . '>', // Name <email@domain.com>
    'subject'            => get_theme_mod('newsletter_form_email_subject'),
    'cc'                 => get_theme_mod('newsletter_form_cc_address'),
    'from'               => get_theme_mod('newsletter_form_from_address'), // If not defined or blank the server default email address will be used
    'remove_submit_data' => false,
    'user_email'         => false,
    'message'            => null,
    'template'           => 'default-form.html',
    'remove_keys'        => ['ip_address', 'referrer']
  ]);

  if (!$admin_email_success) {
    $form->respond(
      false,
      __('Unable to complete request due to a system error. Send mail failed.', 'tofino')
    );
  }

  // Get custom message from general options
  $success_message = get_field('form_thank_you_message', 'option');

  // Custom message does not exist, use default
  if (!$success_message) {
    $success_message = __("You're signed up to receive news from Visit Redding. We'll be in touch with updates on events and things to do in Redding. Feel free to unsubscribe at any time.", 'tofino');
  }
  // Custom Message
  $form->respond(true, $success_message);
}
add_action('wp_ajax_ajax_newsletter_form', __NAMESPACE__ . '\\ajax_newsletter_form');
add_action('wp_ajax_nopriv_ajax_newsletter_form', __NAMESPACE__ . '\\ajax_newsletter_form');
