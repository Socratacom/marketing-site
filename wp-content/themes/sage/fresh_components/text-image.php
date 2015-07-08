<?php

function get_text_image($i) {

    // Get vars
    $header = get_sub_field('component_header');
    $content = get_sub_field('text_content');
    $image = get_sub_field('image');
    $alignment = get_sub_field('image_alignment');
    $bg_image = get_sub_field('component_background_image');
    $bg_color = get_sub_field('component_background_color');

    $background = '';
    if ($bg_image) {
        $background = 'background-image: url('.$bg_image['url'].');';
    }
    $push = '';
    $pull = '';
    if ('right' == $alignment) {
        $push = 'col-sm-push-8';
        $pull = 'col-sm-pull-4';
    }
    $output = '';

    // Output
    $output .= '<div id="section-'. $i .'" class="section-textimage" style="'.$background.' background-color: '.$bg_color.'">';
    $output .= '<div class="container"><div class="row">';
    if ($header) {
        $output .= '<h2>'.$header.'</h2>';
    }
    $output .= '<div class="col-sm-4 '.$push.'">';
        if ($image) {
            $output .= '<img src="'.$image['url'].'" alt="'.$image['title'].'" class="img-responsive">';
        }
    $output .= '</div><div class="col-sm-8 '.$pull.'">';
        if ($content) {
            $output .= $content;
        }
    $output .= '</div></div></div>';
    $output .='</div>';

    echo $output;
}
