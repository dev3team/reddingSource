<?php
/**
 *
 * Helper functions
 *
 * @package Tofino
 * @since 1.0.0
 */

namespace Tofino\Helpers;

/**
 * Page titles
 *
 * @since 1.7.0
 * @return string
 */
function title() {
  if (is_home()) {
    if ($home = get_option('page_for_posts', true)) {
      return get_the_title($home);
    }
    return __('Latest Posts', 'tofino');
  }

  if (is_archive()) {
    return get_the_archive_title();
  }

  if (is_search()) {
    return sprintf(__('Search Results for %s', 'tofino'), get_search_query());
  }

  if (is_404()) {
    return __('Not Found', 'tofino');
  }
  return get_the_title();
}


/**
 * Like get_template_part() put lets you pass args to the template file
 * Args are available in the tempalte as $template_args array
 * From https://github.com/humanmade/hm-core/blob/master/hm-core.functions.php
 *
 * @since 1.7.0
 *
 * @param string filepart
 * @param mixed wp_args style argument list
 */
function hm_get_template_part($file, $template_args = []) {
  $template_args = wp_parse_args($template_args);

  if (file_exists(get_template_directory() . '/' . $file . '.php')) {
    $file = get_template_directory() . '/' . $file . '.php';
  }

  ob_start();

  $return = require($file);
  $data   = ob_get_clean();

  if (!empty($template_args['return'])) {
    if ($return === false) {
      return false;
    } else {
      return $data;
    }
  }

  echo $data;
}


/**
 * Gets the page name
 *
 * Looks up the pagename (slug). If not found in the query_var it uses the $page_id
 * if passed or falls back to the get_the_ID() function. Used by templates.
 *
 * @since 1.0.0
 *
 * @global string $pagename The pagename string (slug) from the query_var
 *
 * @param integer $page_id The id of the page
 * @return string pagename (slug)
 */
function get_page_name($page_id = null) {
  global $pagename;
  if (!$pagename || $page_id) { // Not found in the query_var. Permalinks probably not enabled.
    $page_id  = ($page_id ? $page_id : get_the_ID());
    $post     = get_post($page_id);
    $pagename = $post->post_name;
  }
  return $pagename;
}


/**
 * Gets the page / post ID from slug.
 *
 * If WPML is active and the function fails to find a valid page ID it will look
 * for the translated version.
 *
 * @since 1.0.0
 *
 * @param  string $slug The slug to search against
 * @param  string $post_type page, post etc
 * @return integer|null
 */
function get_id_by_slug($slug, $post_type = 'page') {
  $page = get_page_by_path($slug, 'OBJECT', $post_type);
  if ($page) {
    return $page->ID;
  } else {
    if (function_exists('icl_object_id')) { //WPML installed
      $page = get_page(icl_object_id($page->ID, 'page', true, ICL_LANGUAGE_CODE));
      if ($page) {
        return $page->ID;
      } else {
        return null;
      }
    } else {
      return null;
    }
  }
}


/**
 * Get Complete Meta
 *
 * Gets the complete meta data attached to a post for a meta key.
 *
 * @since 1.6.0
 *
 * @param  integer $post_id  The post id
 * @param  string  $meta_key The meta key to search
 * @return object  A PHP Object containing the meta data with key value pairs
 */
function get_complete_meta($post_id, $meta_key) {
  global $wpdb;
  $mid = $wpdb->get_results($wpdb->prepare("SELECT * FROM $wpdb->postmeta WHERE post_id = %d AND meta_key = %s", $post_id, $meta_key));
  if ($mid != '') {
    return $mid;
  } else {
    return false;
  }
}


/**
 * Sanitizes choices (selects / radios)
 *
 * Checks that the input matches one of the available choices

 * @param string $input The input.
 * @param object $setting The setting to validate.
 * @since 1.2.0
 */
function sanitize_choices($input, $setting) {
  global $wp_customize;
  $control = $wp_customize->get_control($setting->id);
  if (array_key_exists($input, $control->choices)) {
    return $input;
  } else {
    return $setting->default;
  }
}


/**
 * Sanitize textarea
 *
 * Keeps line breaks
 * Replace once this patch merged: https://core.trac.wordpress.org/ticket/32257
 *
 * @since 1.6.0
 * @param string $input The input.
 * @return string Sanitized string.
 */
function sanitize_textarea($input) {
  return implode("\n", array_map('sanitize_text_field', explode("\n", $input)));
}


/**
 * Fix text orphan
 *
 * Make last space in a sentence a non breaking space to prevent typographic widows.
 *
 * @since 3.2.0
 * @param type $str
 * @return string
 */
function fix_text_orphan($str = '') {
  $str   = trim($str); // Strip spaces.
  $space = strrpos($str, ' '); // Find the last space.

  // If there's a space then replace the last on with a non breaking space.
  if (false !== $space) {
    $str = substr($str, 0, $space) . '&nbsp;' . substr($str, $space + 1);
  }

  // Return the string.
  return $str;
}


/**
 * Responsive Image Attrs
 *
 * Returns a clean array of the values needed for a responsive image
 *
 * @since 3.2.1
 * @param integer $image_id (optional) Defaults to post featured image id
 * @param string $size (optional) The image sized used for the main src
 * @return array Values to populate into an img tag
 */
function responsive_image_attribute_values($image_id = null, $size = 'full') {
  if (!$image_id) {
    $image_id = get_post_thumbnail_id();
  }

  // var_dump($image_id);

  $meta = wp_get_attachment_metadata($image_id);
  $url = wp_get_attachment_image_src($image_id, $size);
  $sizes = wp_calculate_image_sizes($size, $url, $meta, $image_id);
  $srcset = wp_get_attachment_image_srcset($image_id, $size);
  $alt = get_post_meta($image_id, '_wp_attachment_image_alt', true);

  return [
    'srcset' => $srcset,
    'sizes' => $sizes,
    'src' => ($url ? $url[0] : null),
    'alt' => $alt
  ];
}


// File Upload
function upload_user_file($encoded_string, $filename, $post_id = null) {
  // if (!current_user_can('upload_files')) {
  //   error_log('[' . __('Theme File Upload Error', 'tofino') . ']  Invalid Permissions. User cannot upload files.' . $filename); // Log error in webservers errorlog
  //   return false;
  // }

  list($type, $encoded_string) = explode(';', $encoded_string);
  list(, $encoded_string)      = explode(',', $encoded_string);

  $data          = base64_decode($encoded_string);
  $f             = finfo_open();
  $mime_type     = finfo_buffer($f, $data, FILEINFO_MIME_TYPE);
  $file_ext      = mime2ext($mime_type);
  $allowed_mimes = ['image/png', 'image/jpeg', 'image/svg', 'image/eps', 'application/postscript', 'application/pdf'];

  if (!in_array($mime_type, $allowed_mimes)) {
    error_log('[' . __('Theme File Upload Error', 'tofino') . ']  Invalid MIME type:' . $mime_type . ' for filename:' . $filename); // Log error in webservers errorlog
    return false;
  }

  $file_name = $filename . '.' . $file_ext;
  $uploads   = wp_upload_dir();
  $dir       = $uploads['path'];
  $file_url  = $dir . '/' . $file_name;

  file_put_contents($file_url, $data);

  $attachment = [
    'post_mime_type' => $mime_type,
    'post_parent'    => $post_id,
    'post_title'     => preg_replace('/\.[^.]+$/', '', basename($file_url)),
    'post_content'   => '',
    'post_status'    => 'inherit',
    'guid'           => $uploads['url'] . '/' . basename($file_url)
  ];

  $attachment_id = wp_insert_attachment($attachment, $file_url, $post_id);

  if (!is_wp_error($attachment_id)) {
    $attachment_data = wp_generate_attachment_metadata($attachment_id, $file_url);
    wp_update_attachment_metadata($attachment_id, $attachment_data);

    return $attachment_id;
  } else {
    $error_string = $attachment_id->get_error_message();
    error_log('[' . __('Theme File Upload Error', 'tofino') . ']  ' . $error_string . ' for filename:' . $filename); // Log error in webservers errorlog

    return false;
  }
}

function mime2ext($mime){
  $all_mimes = '{"png":["image\/png","image\/x-png"],"bmp":["image\/bmp","image\/x-bmp","image\/x-bitmap","image\/x-xbitmap","image\/x-win-bitmap","image\/x-windows-bmp","image\/ms-bmp","image\/x-ms-bmp","application\/bmp","application\/x-bmp","application\/x-win-bitmap"],"gif":["image\/gif"],"jpg":["image\/jpeg","image\/pjpeg"],"xspf":["application\/xspf+xml"],"vlc":["application\/videolan"],"wmv":["video\/x-ms-wmv","video\/x-ms-asf"],"au":["audio\/x-au"],"ac3":["audio\/ac3"],"flac":["audio\/x-flac"],"ogg":["audio\/ogg","video\/ogg","application\/ogg"],"kmz":["application\/vnd.google-earth.kmz"],"kml":["application\/vnd.google-earth.kml+xml"],"rtx":["text\/richtext"],"rtf":["text\/rtf"],"jar":["application\/java-archive","application\/x-java-application","application\/x-jar"],"zip":["application\/x-zip","application\/zip","application\/x-zip-compressed","application\/s-compressed","multipart\/x-zip"],"7zip":["application\/x-compressed"],"xml":["application\/xml","text\/xml"],"svg":["image\/svg"],"3g2":["video\/3gpp2"],"3gp":["video\/3gp","video\/3gpp"],"mp4":["video\/mp4"],"m4a":["audio\/x-m4a"],"f4v":["video\/x-f4v"],"flv":["video\/x-flv"],"webm":["video\/webm"],"aac":["audio\/x-acc"],"m4u":["application\/vnd.mpegurl"],"pdf":["application\/pdf","application\/octet-stream"],"pptx":["application\/vnd.openxmlformats-officedocument.presentationml.presentation"],"ppt":["application\/powerpoint","application\/vnd.ms-powerpoint","application\/vnd.ms-office","application\/msword"],"docx":["application\/vnd.openxmlformats-officedocument.wordprocessingml.document"],"xlsx":["application\/vnd.openxmlformats-officedocument.spreadsheetml.sheet","application\/vnd.ms-excel"],"xl":["application\/excel"],"xls":["application\/msexcel","application\/x-msexcel","application\/x-ms-excel","application\/x-excel","application\/x-dos_ms_excel","application\/xls","application\/x-xls"],"xsl":["text\/xsl"],"mpeg":["video\/mpeg"],"mov":["video\/quicktime"],"avi":["video\/x-msvideo","video\/msvideo","video\/avi","application\/x-troff-msvideo"],"movie":["video\/x-sgi-movie"],"log":["text\/x-log"],"txt":["text\/plain"],"css":["text\/css"],"html":["text\/html"],"wav":["audio\/x-wav","audio\/wave","audio\/wav"],"xhtml":["application\/xhtml+xml"],"tar":["application\/x-tar"],"tgz":["application\/x-gzip-compressed"],"psd":["application\/x-photoshop","image\/vnd.adobe.photoshop"],"exe":["application\/x-msdownload"],"js":["application\/x-javascript"],"mp3":["audio\/mpeg","audio\/mpg","audio\/mpeg3","audio\/mp3"],"rar":["application\/x-rar","application\/rar","application\/x-rar-compressed"],"gzip":["application\/x-gzip"],"hqx":["application\/mac-binhex40","application\/mac-binhex","application\/x-binhex40","application\/x-mac-binhex40"],"cpt":["application\/mac-compactpro"],"bin":["application\/macbinary","application\/mac-binary","application\/x-binary","application\/x-macbinary"],"oda":["application\/oda"],"ai":["application\/postscript"],"smil":["application\/smil"],"mif":["application\/vnd.mif"],"wbxml":["application\/wbxml"],"wmlc":["application\/wmlc"],"dcr":["application\/x-director"],"dvi":["application\/x-dvi"],"gtar":["application\/x-gtar"],"php":["application\/x-httpd-php","application\/php","application\/x-php","text\/php","text\/x-php","application\/x-httpd-php-source"],"swf":["application\/x-shockwave-flash"],"sit":["application\/x-stuffit"],"z":["application\/x-compress"],"mid":["audio\/midi"],"aif":["audio\/x-aiff","audio\/aiff"],"ram":["audio\/x-pn-realaudio"],"rpm":["audio\/x-pn-realaudio-plugin"],"ra":["audio\/x-realaudio"],"rv":["video\/vnd.rn-realvideo"],"jp2":["image\/jp2","video\/mj2","image\/jpx","image\/jpm"],"tiff":["image\/tiff"],"eml":["message\/rfc822"],"pem":["application\/x-x509-user-cert","application\/x-pem-file"],"p10":["application\/x-pkcs10","application\/pkcs10"],"p12":["application\/x-pkcs12"],"p7a":["application\/x-pkcs7-signature"],"p7c":["application\/pkcs7-mime","application\/x-pkcs7-mime"],"p7r":["application\/x-pkcs7-certreqresp"],"p7s":["application\/pkcs7-signature"],"crt":["application\/x-x509-ca-cert","application\/pkix-cert"],"crl":["application\/pkix-crl","application\/pkcs-crl"],"pgp":["application\/pgp"],"gpg":["application\/gpg-keys"],"rsa":["application\/x-pkcs7"],"ics":["text\/calendar"],"zsh":["text\/x-scriptzsh"],"cdr":["application\/cdr","application\/coreldraw","application\/x-cdr","application\/x-coreldraw","image\/cdr","image\/x-cdr","zz-application\/zz-winassoc-cdr"],"wma":["audio\/x-ms-wma"],"vcf":["text\/x-vcard"],"srt":["text\/srt"],"vtt":["text\/vtt"],"ico":["image\/x-icon","image\/x-ico","image\/vnd.microsoft.icon"],"csv":["text\/x-comma-separated-values","text\/comma-separated-values","application\/vnd.msexcel"],"json":["application\/json","text\/json"], "eps":["text\/eps"]}';
  $all_mimes = json_decode($all_mimes, true);
  foreach ($all_mimes as $key => $value) {
    if (array_search($mime, $value) !== false) {
      return $key;
    }
  }
  return false;
}
