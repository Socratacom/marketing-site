<?php

// YouTube Button and Shorcode for TinyMCE
add_shortcode("youtube", "cwc_youtube");
function cwc_youtube($atts) {
  extract(shortcode_atts(array(
    "id" => '',
  ), $atts));
  return '<div class="video-wrapper">
  <iframe src="http://www.youtube.com/embed/'.$id.'?rel=0" frameborder="0" allowfullscreen></iframe>
  </div>'
  ;
}

add_action('init', 'add_youtube_button');
function add_youtube_button() {
   if ( current_user_can('edit_posts') &&  current_user_can('edit_pages') )
   {
     add_filter('mce_external_plugins', 'add_youtube_plugin');
     add_filter('mce_buttons', 'register_youtube_button');
   }
}

function register_youtube_button($buttons) {
   array_push($buttons, "youtube");
   return $buttons;
}

function add_youtube_plugin($plugin_array) {
   $plugin_array['youtube'] = get_stylesheet_directory_uri().'/custom/scripts/customcodes.js';
   return $plugin_array;
}