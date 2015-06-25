<?php
/**
 * Fresh Components
 *
 * The components work with ACF fields and
 * are the building blocks used for building
 * the pages of this site.
 *
 * Current components available:
 * * Slider: Show a slider comprised of multiple slides, each can
 * have multiple rows containing multiple columns
 * * Text-Image: Show image on one side, text on the other, can flip
 * * Options Selector: Shows content from the option pages
 *
 * The components are injected automatically in pages and posts
 * that use them through the loop start hook.
 *
 * @author Fresh Consulting <freshconsulting.com>
 * @since  1.0
 *
 */


// Each component is defined in its own file.
require_once 'slider.php';
require_once 'text-image.php';
require_once 'ecosystem.php';
require_once 'option-selector.php';
require_once 'case-studies.php';
require_once 'news.php';

function components_euqeue_scripts() {
    wp_register_script(
        'fresh-components-main-js',
        get_stylesheet_directory_uri() . '/fresh_components/scripts/main.js',
        false,
        '1.0',
        false
    );

    wp_enqueue_script( 'fresh-components-main-js' );
}
add_action( 'wp_enqueue_scripts', 'components_euqeue_scripts' );


/**
 * Checks if loop has components, if so, display them
 *
 * @param $post_object The post object from the page loop
 * @return string Component markup, or FALSE otherwise.
 */
function inject_fresh_components( $post_object ) {
    if ( get_post_type() === 'page' || get_post_type() === 'post') {

        // check if the flexible content field has rows of data
        if( acfHelper::have_rows('components') ) {
            $i = 0;
            // loop through the rows of data
            while ( have_rows('components') ) { the_row();

                if( get_row_layout() === 'text_image' ) {
                    get_text_image($i);

                } elseif( get_row_layout() === 'slider' ) {
                    get_slider($i);

                } elseif( get_row_layout() === 'ecosystem' ) {
                    get_ecosystem($i);

                } elseif( get_row_layout() === 'option_selector' ) {
                    get_custom_option($i);

                } elseif( get_row_layout() === 'case_studies' ) {
                    echo get_case_studies($i);

                } elseif( get_row_layout() === 'news' ) {
                    echo get_news($i);

                }

                $i++;
            }
        }

        wp_reset_postdata();

    }
}
add_action( 'loop_start', 'inject_fresh_components' );


/**
 * Adding ACF options
 */
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


/**
 * Bootstrapping ACF functions if ACF isn't activated
 *
 * Usage:
 *    - include the class in your functions.php or in a plugin
 *    - call its static mathods using colon syntax (ie: acfHelper::acf_is_active() )
 */
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
