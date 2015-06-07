<?php

function get_cloud_option($i, $selected_option) {
    // get layout choice
    $layout = get_sub_field('layout');
    echo '<div id="section-'. $i .'" class="clouds '.$layout.'">';
        echo '<div class="container"><div class="row">';
            if( have_rows('cloud', 'option') ):
                $c = true;
                while ( have_rows('cloud', 'option') ) : the_row();
                    if ($layout === 'full' || $layout === 'overview') {
                        // display all clouds
                        $oddeven = $c = !$c;
                        echo output_cloud($oddeven);
                    } else {
                        $oddeven = false;
                        // display only the cloud that matches layout selection
                        $cloud = str_replace('icon-', '', get_sub_field('cloud_icon', 'option'));
                        if ( $cloud === $layout ) {
                            echo output_cloud($oddeven, 'single-cloud');
                        }
                    }
                endwhile;
            endif;
        echo '</div></div>';
    echo '</div>';
}

function output_cloud($oddeven, $single = '') {
    // Get Vars
    $title = get_sub_field('title');
    $icon = get_sub_field('cloud_icon');
    $headline = get_sub_field('headline');
    $content = get_sub_field('content');
    $link_text = get_sub_field('link_text');
    $link = get_sub_field('link');
    $infographic = get_sub_field('infographic', 'option');

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
    echo '<div class="col-sm-12 cloud '.$single.'" id="'.$icon.'"><div class="col-md-4 col-sm-3 '.$push.' cloud-icon-wrapper">';
        echo '<a class="cloud-link" href="'.$link.'">';
        if ($icon) {
            echo '<span class="cloud-icon '.$icon.'"></span>';
        }
        if ($title) {
            echo '<h2>'.$title.'</h2>';
        }
        echo '</a>';
    echo '</div>';
    echo '<div class="col-md-8 col-sm-9 '.$pull.' cloud-detail">';
        if ($headline) {
            echo '<h3>'.$headline.'</h3>';
        }
        if ($content) {
            echo $content;
        }
        if ($infographic && '' !== $single ) {
            echo '<img src="'.$infographic.'" class="img-responsive">';
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
        if( have_rows('logos', 'option') && '' !== $single ):
            while( have_rows('logos', 'option') ): the_row();
                    $logo = get_sub_field('logo_image');
                    $logolink = '';
                    $linkstart = '';
                    $linkend = '';
                    if( have_rows('logo_link') ):
                        while( have_rows('logo_link') ): the_row();
                            if( get_row_layout() == 'internal_link' ):
                                $logolink = get_sub_field('link_url');
                                $linkstart = '<a href="'.$logolink.'">';
                                $linkend = '</a>';
                            elseif( get_row_layout() == 'external_link' ):
                                $logolink = get_sub_field('link_url');
                                $linkstart = '<a href="'.$logolink.'" target="_blank">';
                                $linkend = '</a>';
                            endif;
                        endwhile;
                    endif;

                    if ($logo) {
                        echo '<div class="slide col-sm-2">'.$linkstart.'<img src="'.$logo['url'].'" alt="'.$logo['title'].'" class="grayscale">'.$linkend.'</div>';
                    }
            endwhile;
        endif;
        echo '</div>';
        if( have_rows('logos', 'option') && '' !== $single ):
            echo '<script type="text/javascript"> document.addEventListener("DOMContentLoaded", function() {
                slider(".logos", false, 4000, 6, 5, 3);
            }, false);</script>';
        endif;
    echo '</div>';
}
