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
 * @author Fresh Consulting <freshconsulting.com>
 * @since  1.0
 *
 */

require_once 'init.php';

// include fresh components here
require_once 'text-image.php';
require_once 'option-selector.php';

// check for components
function get_fresh_components() {
    // check if the flexible content field has rows of data
    if( acfHelper::have_rows('components') ) {
        $i = 0;
        echo '<div class="components">';
        // loop through the rows of data
        while ( have_rows('components') ) { the_row();

            if( get_row_layout() == 'text_image' ) {
                get_text_image($i);

            } elseif( get_row_layout() == 'option_selector' ) {
                get_custom_option($i);

            }
            $i++;
        }
        echo '</div>'; // close .components
    } else {
        // no layouts found
    }
}
