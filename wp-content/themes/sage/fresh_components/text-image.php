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
        $background = 'background-image: url('.$bg_image['url'].')';
    }
    $push = '';
    $pull = '';
    if ('right' == $alignment) {
        $push = 'col-sm-push-8';
        $pull = 'col-sm-pull-4';
    }

    // Output
    echo '<div id="section-'. $i .'" class="section-textimage bg-'.$bg_color.'" style="'.$background.'">';
    echo '<div class="container"><div class="row">';
    if ($header) {
        echo '<h2>'.$header.'</h2>';
    }
    echo '<div class="col-sm-4 '.$push.'">';
        if ($image) {
            echo '<img src="'.$image['url'].'" alt="'.$image['title'].'" class="img-responsive">';
        }
    echo '</div><div class="col-sm-8 '.$pull.'">';
        if ($content) {
            echo $content;
        }
    echo '</div></div></div>';
    echo '</div>';
}
