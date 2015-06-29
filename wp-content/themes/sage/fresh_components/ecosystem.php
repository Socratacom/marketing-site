<?php

function get_ecosystem($i) {

    // Get vars
    $title = get_sub_field('title');
    $copy = get_sub_field('copy');
    $graphic = get_sub_field('ecosystem_graphic');
    $mobile_graphic = get_sub_field('mobile_ecosystem_graphic');

    $output = '';
    $output .= '<div id="section-'. $i .'" class="section-ecosystem">';
    $output .= '<div class="container"><div class="row">';
        $output .= '<div class="col-md-3 col-md-offset-1 col-sm-4">';
        if ($title) {
            $output .= '<h2>'.$title.'</h2>';
        }
        $output .= '</div><div class="col-md-7 col-sm-8">';
        if ($copy) {
            $output .= $copy;
        }
    $output .= '</div></div>';
    $output .= '<div class="row"><div class="col-md-10 col-md-offset-1 col-sm-12">';
        if ($graphic) {
            $output .= '<img src="'.$graphic['url'].'" alt="" class="img-responsive hidden-xs">';
            $output .= '<img src="'.$mobile_graphic['url'].'" alt="" class="img-responsive visible-xs">';
        }
    $output .= '</div></div>';
    $output .='</div></div>';

    echo $output;
}
