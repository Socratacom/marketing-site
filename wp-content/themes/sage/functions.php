<?php
/**
 * Sage includes
 *
 * The $sage_includes array determines the code library included in your theme.
 * Add or remove files to the array as needed. Supports child theme overrides.
 *
 * Please note that missing files will produce a fatal error.
 *
 * @link https://github.com/roots/sage/pull/1042
 */
$sage_includes = [
  'lib/utils.php',                 // Utility functions
  'lib/init.php',                  // Initial theme setup and constants
  'lib/wrapper.php',               // Theme wrapper class
  'lib/conditional-tag-check.php', // ConditionalTagCheck class
  'lib/config.php',                // Configuration
  'lib/assets.php',                // Scripts and stylesheets
  'lib/titles.php',                // Page titles
  'lib/nav.php',                   // Custom nav modifications
  'lib/gallery.php',               // Custom [gallery] modifications
  'lib/extras.php',                // Custom functions
  'lib/custom-post-types.php'      // Custom functions
];

foreach ($sage_includes as $file) {
  if (!$filepath = locate_template($file)) {
    trigger_error(sprintf(__('Error locating %s for inclusion', 'sage'), $file), E_USER_ERROR);
  }

  require_once $filepath;
}
unset($file, $filepath);


//Bootstrapping ACF functions if ACF isn't activated

add_action('plugins_loaded', 'bootstrap_acf');

function bootstrap_acf() {
  if(!function_exists('get_field')) {
    function get_field($field_name, $post_id = 0, $format_value = true) {
      return false;
    }
  }

  if(!function_exists('have_rows')) {
    function have_rows($field_name, $post_id = 0) {
      return false;
    }
  }

  if(!function_exists('the_field')) {
    function the_field($field_name, $post_id = 0) {
      echo '';
      return false;
    }
  }
}