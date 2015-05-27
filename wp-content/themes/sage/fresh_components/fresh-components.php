<?php

// include fresh components here
require_once 'text-image.php';

// check for components
function get_fresh_components() {
    // check if the flexible content field has rows of data
    if( have_rows('components') ):
        // loop through the rows of data
        while ( have_rows('components') ) : the_row();
            if( get_row_layout() == 'text_image' ):
                get_text_image();
            endif;
        endwhile;
    else :
        // no layouts found
    endif;
}
