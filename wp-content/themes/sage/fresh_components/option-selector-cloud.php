<?php

function get_cloud_option($i, $selected_option) {
    // get layout choice
    $layout = get_sub_field('layout') && !is_array(get_sub_field('layout')) ? get_sub_field('layout') : null;
    $output = '';
    $output .= '<div id="section-'. $i .'" class="clouds '.$layout.'">';
        if( have_rows('cloud', 'option') ):
            $c = true;
            if ($layout === 'full') {
                 $output .= cloud_intro();
            }
            $output .= '<div class="container"><div class="row">';
            while ( have_rows('cloud', 'option') ) : the_row();
                if ($layout === 'full' || $layout === 'overview') {
                    // display all clouds
                    $oddeven = $c = !$c;
                    $output .= output_cloud($oddeven);
                } else {
                    $oddeven = false;
                    // display only the cloud that matches layout selection
                    $cloud = str_replace('icon-', '', get_sub_field('cloud_icon', 'option'));
                    if ( $cloud === $layout ) {
                        $output .= output_cloud($oddeven, 'single-cloud');
                    }
                }
            endwhile;
            $output .= '</div></div>';
        endif;
    $output .= '</div>';
    return $output;
}

function cloud_intro() {
    $content = get_field('intro_content', 'option');
    $cloud_intro = '<section class="cloud-overview hidden-xs">
        <div class="container">
            <div class="row">
                <div class="col-sm-12">'.
                   $content
                .'</div>';
                if( have_rows('cloud', 'option') ):
                    $count = 0;
                    while ( have_rows('cloud', 'option') ) : the_row();
                        $title = get_sub_field('title');
                        $icon = get_sub_field('cloud_icon');
                        $offset = '';
                        if ($count == 0 ) {
                            $offset = 'col-sm-offset-1';
                        }
                        $cloud_intro .= '<div class="col-sm-2 col-xs-6 '.$offset.'">';
                            $cloud_intro .= '<a href="#'.$icon.'"><span class="'.$icon.'"></span></a>';
                            $cloud_intro .= '<h3>'.$title.'</h3>';
                        $cloud_intro .= '</div>';
                        $count++;
                    endwhile;
                else :
                    // no rows found
                endif;
    $cloud_intro .= '</div></div></section>';
    return $cloud_intro;
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
    $cloud_row = '';

    $cloud_row .= '<div class="col-sm-12 cloud '.$single.'" id="'.$icon.'"><div class="col-md-4 col-sm-3 '.$push.' cloud-icon-wrapper">';
        $cloud_row .= '<a class="cloud-link" href="'.$link.'">';
        if ($icon) {
            $cloud_row .= '<span class="cloud-icon '.$icon.'"></span>';
        }
        if ($title) {
            $cloud_row .= '<h3>'.$title.'</h3>';
        }
        $cloud_row .= '</a>';
    $cloud_row .= '</div>';
    $cloud_row .= '<div class="col-md-8 col-sm-9 '.$pull.' cloud-detail">';
        if ($headline) {
            $cloud_row .= '<h4>'.$headline.'</h4>';
        }
        if ($content) {
            $cloud_row .= $content;
        }
        if ($infographic && '' !== $single ) {
            $cloud_row .= '<img src="'.$infographic.'" class="img-responsive">';
        }
        if ($link) {
            $cloud_row .= '<a href="'.$link.'" class="button">';
            if ($link_text) {
                $cloud_row .= $link_text;
            } else {
                $cloud_row .= 'Learn More';
            }
            $cloud_row .= '</a>';
        }
    $cloud_row .= '</div>';
    $cloud_row .= '<div class="col-sm-12 logos hidden-xs">';
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
                        $cloud_row .= '<div class="slide col-sm-2">'.$linkstart.'<img src="'.$logo['url'].'" alt="'.$logo['title'].'" class="grayscale">'.$linkend.'</div>';
                    }
            endwhile;
        endif;
        $cloud_row .= '</div>';
        if( have_rows('logos', 'option') && '' !== $single ):
            $cloud_row .= '<script type="text/javascript"> document.addEventListener("DOMContentLoaded", function() {
                slider(".logos", false, 4000, 6, 5, 3);
            }, false);</script>';
        endif;
    $cloud_row .= '</div>';
    return $cloud_row;
}
