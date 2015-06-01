<?php
/*------------------------------------------------------*/
// Bootstrapping ACF functions if ACF isn't activated
/*------------------------------------------------------*/

//Usage:
//    -include the class in your functions.php or in a plugin
//    -call its static mathods using colon syntax (ie: acfHelper::acf_is_active() )

class acfHelper {

    //functions use underscores to keep in style with acf base functions

    public static function acf_is_active() {
        //If any of these functions don't exist, acf is probably broken or disabled.
        if(!function_exists('get_field') || !function_exists('have_rows') || !function_exists('the_field')) {
            return false;
        }
        //if it gets this far then the functions are defined and acf is activated
        return true;
    }

    //format_value unimplemented so far
    public static function get_field($field_name, $post_id = -1, $format_value = true) {
        if(!function_exists('get_field')) {
            return false;
        } else {
            if($post_id === -1) {
                return get_field($field_name);
            } else {
                return get_field($field_name, $post_id);
            }
        }
    }

    public static function have_rows($field_name, $post_id = -1) {
        if(!function_exists('have_rows')) {
            return false;
        } else {
            if($post_id === -1) {
                return have_rows($field_name);
            } else {
                return have_rows($field_name, $post_id);
            }
        }
    }

    public static function the_field($field_name, $post_id = -1) {
        if(!function_exists('the_field')) {
            echo '';
            return false;
        } else {
            if($post_id === -1) {
                echo the_field($field_name);
                return;
            } else {
                echo the_field($field_name, $post_id);
                return;
            }
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
