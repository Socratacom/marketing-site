<?php

function get_uber_personas_option($i, $selected_option) {
    echo '<div id="section-'. $i .'" class="uber-personas">';
        if( have_rows('uber_persona_slider', 'option') ) {
            echo '<div class="container arrowsContainer"></div>';
            echo '<div class="row uber-personas-slider">';
            while ( have_rows('uber_persona_slider', 'option') ) { the_row();
                $subhead = get_sub_field('subhead');
                $header = get_sub_field('header');
                $content = get_sub_field('content');
                $background_image = get_sub_field('background_image');

                if($background_image) {
                    echo '<div class="col-sm-12 slide" style="background-image: url('.$background_image['url'].');">';
                        echo '<div class="container"><div class="row">';
                            echo '<div class="col-lg-offset-6 col-md-5 col-md-offset-7 slide-content">';
                                    echo '<h4>';
                                        if($subhead) { echo $subhead; }
                                    echo '</h4>';
                                    echo '<h3>';
                                        if($header) { echo $header; }
                                    echo '</h3>';
                                    if($content) { echo $content; }
                            echo '</div>';
                        echo '</div></div>';
                    echo '</div>';
                }
            }
        }
        echo '</div>';
    echo '</div>';
    echo '<script type="text/javascript"> document.addEventListener("DOMContentLoaded", function() {
                slider(".uber-personas-slider", true, 4800,"","","","","",".arrowsContainer");
            }, false);</script>';
}
