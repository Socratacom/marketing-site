<?php
/*
Plugin Name: Socrata CTA
Plugin URI: http://socrata.com
Description: This adds a CTA metabox to the blog.
Version: 1.0
Author: Michael Church
Author URI: http://socrata.com/
License: GPLv2
*/

// METABOXES
add_filter( 'rwmb_meta_boxes', 'socrata_cta_register_meta_boxes' );
function socrata_cta_register_meta_boxes( $meta_boxes )
{
  $prefix = 'cta_';

  $meta_boxes[] = array(
    'title'         => 'CTA Content',   
    'post_types'    => 'post',
    'context'       => 'normal',
    'priority'      => 'high',
    'fields' => array(
      // WYSIWYG/RICH TEXT EDITOR
      array(
        'id'      => "{$prefix}content",
        'type'    => 'wysiwyg',
        'raw'     => false,
        'options' => array(
          'textarea_rows' => 4,
          'teeny'         => true,
          'media_buttons' => false,
        ),
      ),
    ),
  );

  return $meta_boxes;
}



