<?php

function get_uber_personas_option($i, $selected_option) {
    $output = '';
    $output .= '<div id="section-'. $i .'" class="uber-personas">';
        if( have_rows('uber_persona_slider', 'option') ) {
            $output .= '<div class="container arrowsContainer"></div>';
            $output .= '<div class="row uber-personas-slider">';
            while ( have_rows('uber_persona_slider', 'option') ) { the_row();
                $subhead = get_sub_field('subhead');
                $header = get_sub_field('header');
                $content = get_sub_field('content');
                $background_image = get_sub_field('background_image');

                if($background_image) {
                    $output .= '<div class="col-sm-12 slide" style="background-image: url('.$background_image['url'].');">';
                        $output .= '<div class="container"><div class="row">';
                            $output .= '<div class="col-lg-offset-6 col-md-5 col-md-offset-7 slide-content">';
                                    $output .= '<h4>';
                                        if($subhead) { $output .= $subhead; }
                                    $output .= '</h4>';
                                    $output .= '<h3>';
                                        if($header) { $output .= $header; }
                                    $output .= '</h3>';
                                    if($content) { $output .= $content; }
                            $output .= '</div>';
                        $output .= '</div></div>';
                    $output .= '</div>';
                }
            }
        }
        $output .= '</div>';
    $output .= '</div>';
    $output .= '<script type="text/javascript"> document.addEventListener("DOMContentLoaded", function() {
                slider(".uber-personas-slider", true, 4800,"","","","","",".arrowsContainer");
            }, false);</script>';
    echo $output;
}
