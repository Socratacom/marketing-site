<?php

function get_cloud_option($i, $selected_option) {
    echo '<div id="section-'. $i .'" class="clouds">';
        echo '<div class="container"><div class="row">';
            if( have_rows('cloud', 'option') ):
                $c = true;
                while ( have_rows('cloud', 'option') ) : the_row();
                    // Get Vars
                    $oddeven = $c = !$c;
                    $title = get_sub_field('title');
                    $icon = get_sub_field('cloud_icon');
                    $headline = get_sub_field('headline');
                    $content = get_sub_field('content');
                    $link_text = get_sub_field('link_text');
                    $link = get_sub_field('link');

                    // odd/even classes for alignment
                    $push = '';
                    $pull = '';
                    if ( false == $oddeven ) {
                        //$pull = 'col-md-offset-1';
                    } else if ( true == $oddeven ) {
                        $push = 'col-md-push-8 col-sm-push-9';
                        $pull = 'col-md-pull-4 col-sm-pull-3';
                    }

                    // Output
                    echo '<div class="col-sm-12 cloud" id="'.$icon.'"><div class="col-md-4 col-sm-3 '.$push.' cloud-icon-wrapper">';
                        echo '<a class="cloud-link" href="'.$link.'">';
                        if ($icon) {
                            echo '<span class="cloud-icon '.$icon.'"></span>';
                        }
                        if ($title) {
                            echo '<h2>'.$title.'</h2>';
                        }
                        echo '</a>';
                    echo '</div>';
                    echo '<div class="col-md-8 col-sm-9 '.$pull.'">';
                        if ($headline) {
                            echo '<h3>'.$headline.'</h3>';
                        }
                        if ($content) {
                            echo $content;
                        }
                        if ($link) {
                            echo '<a href="'.$link.'" class="button">';
                            if ($link_text) {
                                echo $link_text;
                            } else {
                                echo 'Learn More';
                            }
                            echo '</a>';
                        }
                    echo '</div>';
                    echo '<div class="col-sm-12 logos hidden-xs">';
                    echo '</div></div>';
                endwhile;
            endif;
        echo '</div></div>';
    echo '</div>';
}
