<?php
/**
 * Fresh Components
 *
 * The components work with ACF fields and
 * are the building blocks used for building
 * the pages of this site.
 *
 * Current components available:
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

require_once 'init.php';

// Each component is defined in its own file.
require_once 'slider.php';
require_once 'text-image.php';
require_once 'ecosystem.php';
require_once 'option-selector.php';

// Check if loop has components, if so, display them
function inject_fresh_components( $post_object ) {
    if ( get_post_type() === 'page' || get_post_type() === 'post') {

        // check if the flexible content field has rows of data
        if( acfHelper::have_rows('components') ) {
            $i = 0;
            // loop through the rows of data
            while ( have_rows('components') ) { the_row();

                if( get_row_layout() == 'text_image' ) {
                    get_text_image($i);

                } elseif( get_row_layout() == 'slider' ) {
                    get_slider($i);

                } elseif( get_row_layout() == 'ecosystem' ) {
                    get_ecosystem($i);

                } elseif( get_row_layout() == 'option_selector' ) {
                    get_custom_option($i);

                }
                $i++;
            }
        }

    }
}
add_action( 'loop_start', 'inject_fresh_components' );
