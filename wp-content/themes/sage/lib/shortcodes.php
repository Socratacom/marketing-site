<?php

/**
 * Shortcodes for CTAs and Video blocks
 */
function cta_shortcode( $atts, $content = null ) {
  $a = shortcode_atts( array(
    'icon' => '',
    'title' => '',
    'url' => '',
    'label' => '',
    'color' => 'blue'
  ), $atts );
  $color = !in_array($a['color'], array('green', 'red', 'yellow')) ? 'blue' : $a['color'];

  $shortcode = '<div class="cta">';
  $shortcode .= '<i class="fa '.$a['icon'].' '.$color.'"></i>';
  $shortcode .= '<h3>'.$a['title'].'</h3>';
  $shortcode .= '<p>'.$content.'</p>';
  $shortcode .= '<a href="'.$a['url'].'" class="button">'.$a['label'].'</a>';
  $shortcode .= '</div>';

  return $shortcode;
}
add_shortcode( 'CTA', 'cta_shortcode' );

function video_shortcode( $atts, $content = null ) {
  $a = shortcode_atts( array(
    'title' => '',
    'copy' => '',
    'video' => '',
    'rtp' => ''
  ), $atts );

  if (!empty($a['video'])) {
      $video = apply_filters('the_content', "[embed]" . $a['video'] . "[/embed]");
      preg_match('/src="(.+?)"/', $video, $matches);
      $src = $matches[1];
      $params = array(
          'enablejsapi'   => 1,
          'rel'   => 0,
          'controls'  => 0,
          'html5'     => 1,
          'showinfo'  =>0,
          'playsinline' => 1,
          'autoplay' => 1
      );
      $new_src = add_query_arg($params, $src);
  }

  $shortcode = '<div id="'.$a['rtp'].'" class="video_slide"><a href="#" data-toggle="modal" data-target="#videoModal" data-content="'.$new_src.'">';
  $shortcode .= '<div class="play-btn"></div><h3 class="visible">'.$a['title'].'</h3>';
  $shortcode .= '<div class="video-content"><h3>'.$a['title'].'</h3><p>'.$a['copy'].'</p></div>';
  $shortcode .= $content;
  $shortcode .= '</a></div>';

  $shortcode .= '<script>document.addEventListener("DOMContentLoaded", function() { init_modal(); });</script>';

  return $shortcode;
}
add_shortcode( 'vid', 'video_shortcode' );
