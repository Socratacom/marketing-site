<?php

// include fresh components here
require_once 'text-image.php';
require_once 'option-selector.php';

// check for components
function get_fresh_components() {
    // check if the flexible content field has rows of data
    if( have_rows('components') ):
        $i = 0;
        echo '<div class="components">';
        // loop through the rows of data
        while ( have_rows('components') ) : the_row();
            if( get_row_layout() == 'text_image' ):
                get_text_image($i);
            elseif( get_row_layout() == 'option_selector' ):
                get_custom_option($i);
            endif;
            $i++;
        endwhile;
        echo '</div>'; // close .components
    else :
        // no layouts found
    endif;
}
