<?php

add_shortcode("wistia", "cwc_wistia");
function cwc_wistia($atts) {
  extract(shortcode_atts(array(
    "id" => '',
  ), $atts));
  return '<iframe src="http://fast.wistia.net/embed/iframe/'.$id.'?playerColor=222222&version=v1&videoHeight=304&videoWidth=540&videoFoam=true&volumeControl=true" allowtransparency="true" frameborder="0" scrolling="no" class="wistia_embed" name="wistia_embed" width="540" height="304"></iframe>
<script src="//fast.wistia.com/static/iframe-api-v1.js"></script>'
  ;
}

add_action('init', 'add_wistia_button');
function add_wistia_button() {
   if ( current_user_can('edit_posts') &&  current_user_can('edit_pages') )
   {
     add_filter('mce_external_plugins', 'add_wistia_plugin');
     add_filter('mce_buttons', 'register_wistia_button');
   }
}

function register_wistia_button($buttons) {
   array_push($buttons, "wistia");
   return $buttons;
}

function add_wistia_plugin($plugin_array) {
   $plugin_array['wistia'] = get_stylesheet_directory_uri().'/custom/scripts/customcodes.js';
   return $plugin_array;
}