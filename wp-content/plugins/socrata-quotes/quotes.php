<?php
/*
Plugin Name: Socrata Quotes
Plugin URI: http://fishinglounge.com/
Description: Add Quotes to the site.
Version: 1.0
Author: Michael Church
Author URI: http://fishinglounge.com/
License: GPLv2
*/

include_once("meta-boxes.php");


// REGISTER POST TYPE
add_action( 'init', 'create_quotes' );

function create_quotes() {
  register_post_type( 'quotes',
    array(
      'labels' => array(
        'name' => 'Quotes',
        'singular_name' => 'Quote',
        'add_new' => 'Add New Quote',
        'add_new_item' => 'Add New Quote',
        'edit' => 'Edit Quote',
        'edit_item' => 'Edit Quote',
        'new_item' => 'New Quote',
        'view' => 'View',
        'view_item' => 'View Quote',
        'search_items' => 'Search Quotes',
        'not_found' => 'Not found',
        'not_found_in_trash' => 'Not found in Trash',
        'parent' => 'Parent Quotes'
      ),
      'public' => true,
      'menu_position' => 100,
      'supports' => array( 'title', 'thumbnail', 'revisions' ),
      'taxonomies' => array( '' ),
      'menu_icon' => '',
      'has_archive' => true,
      'rewrite' => array('with_front' => false, 'slug' => 'quotes')
    )
  );
}

// MENU ICON
//Using Dashicon Font http://melchoyce.github.io/dashicons/
add_action( 'admin_head', 'add_quotes_icon' );
function add_quotes_icon() { ?>
  <style>
    #adminmenu .menu-icon-quotes div.wp-menu-image:before {
      content: '\f122';
    }
  </style>
  <?php
}

// CUSTOM COLUMS FOR ADMIN
add_filter( 'manage_edit-quotes_columns', 'quotes_edit_columns' ) ;
function quotes_edit_columns( $columns ) {
  $columns = array(
    'cb'                   => '<input type="checkbox" />',    
    'title'                => __( 'Name' ),
    'quote'                => 'Quote',
    'quote-author'         => 'Quote Author',
    'shortcode'            => 'Shortcode'
  );
  return $columns;
}
// Get Content for Custom Colums
add_action("manage_quotes_posts_custom_column",  "quotes_columns");
function quotes_columns($column){
  global $post;

  switch ($column) {    
    case 'quote':
      $meta = get_quote_meta(); if ($meta[0]) echo "$meta[0]";
      break;
    case 'quote-author':
      $meta = get_quote_meta(); if ($meta[1]) echo "$meta[1]";
      break;
    case 'shortcode':
      echo '[socrata-quote id="' . $post->ID . '"]';
      break;
  }
}


// SHORTCODE TO DISPLAY Quoates GROUP
// [socrata-quote category="ENTER CATAGORY SLUG"]
add_shortcode('socrata-quote','quote_shortcode');
function quote_shortcode( $atts ) {
  wp_enqueue_style( 'quote_styles' );
  ob_start();
  extract( shortcode_atts( array (
    'type' => 'quotes',
    'id' => '',
  ), $atts ) );
  $options = array(
    'post_type' => $type,
    'p' => $id,
  );
  $query = new WP_Query( $options );
  if ( $query->have_posts() ) { ?>
<div>
    <?php while ( $query->have_posts() ) : $query->the_post(); ?>    
    <div class="socrata-quote">
      <p class="socrata-triangle-border">"<?php $meta = get_quote_meta(); if ($meta[0]) echo "$meta[0]"; ?>"</p>
      <table>
        <tr>
          <?php if(has_post_thumbnail()) :?>
          <?php $thumb = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'thumbnail' ); $url = $thumb['0']; ?>
          <td style="width:1px; padding-left:5px;"><div style="background-image:url(<?=$url?>);" class="socrata-quote-thumb"></div></td>
          <?php endif;?>
          <td style="padding-left:20px;"><?php $meta = get_quote_meta(); if ($meta[1]) echo "<strong>$meta[1]</strong>"; ?><?php $meta = get_quote_meta(); if ($meta[2]) echo ", $meta[2]"; ?></td>
        </tr>
      </table>      
    </div>
      <?php endwhile;
      wp_reset_postdata(); ?>
  </div>
  <?php $myvariable = ob_get_clean();
  return $myvariable;
  } 
}

// ADD STYLESHEET TO PAGE
add_action( 'init', 'register_quote_styles' ); 
function register_quote_styles() {
    wp_register_style( 'quote_styles', plugins_url( 'css/quote-styles.css' , __FILE__ ) );
}
