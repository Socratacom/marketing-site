<?php
/*------------------------------------------------------*/
// Bootstrapping ACF functions if ACF isn't activated
/*------------------------------------------------------*/

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

/*-----------------------------------*/
// Adding ACF options
/*-----------------------------------*/

if( function_exists('acf_add_options_page') ) {
  acf_add_options_page(array(
    'page_title'  => 'Cloud Product Suites',
    'menu_title'  => 'Cloud Product Suites'
    ));
  acf_add_options_page(array(
    'page_title'  => 'Pain Points Slider',
    'menu_title'  => 'Pain Points Slider'
    ));
  acf_add_options_page(array(
    'page_title'  => 'Uber Persona Slider',
    'menu_title'  => 'Uber Persona Slider'
    ));
}
