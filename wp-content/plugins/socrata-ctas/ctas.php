<?php
/*
Plugin Name: Socrata CTAs
Plugin URI: http://fishinglounge.com/
Description: This plugin enables you to easily add and manage Call-To-Actions.
Version: 1.0
Author: Michael Church
Author URI: http://fishinglounge.com/
License: GPLv2
*/

include_once("meta-boxes.php");


// REGISTER POST TYPE
add_action( 'init', 'create_ctas' );

function create_ctas() {
  register_post_type( 'ctas',
    array(
      'labels' => array(
        'name' => 'CTAs',
        'singular_name' => 'CTA',
        'add_new' => 'Add New CTA',
        'add_new_item' => 'Add New CTA',
        'edit' => 'Edit CTA',
        'edit_item' => 'Edit CTA',
        'new_item' => 'New CTA',
        'view' => 'View',
        'view_item' => 'View CTA',
        'search_items' => 'Search CTAs',
        'not_found' => 'Not found',
        'not_found_in_trash' => 'Not found in Trash',
        'parent' => 'Parent CTAs'
      ),
      'public' => true,
      'menu_position' => 5,
      'supports' => array( 'title', 'revisions' ),
      'taxonomies' => array( '' ),
      'menu_icon' => plugins_url( 'images/image.png', __FILE__ ),
      'has_archive' => true,
      'rewrite' => array('with_front' => false, 'slug' => 'ctas')
    )
  );
}

// TAXONOMIES
add_action( 'init', 'cta_taxonomies', 0 );

function cta_taxonomies() {
    register_taxonomy(
        'cta_category',
        'ctas',
        array(
            'labels' => array(
                'name' => 'CTA Category',
                'add_new_item' => 'Add New Category',
                'new_item_name' => "New CTA Category"
            ),
            'show_ui' => true,
            'show_tagcloud' => false,
            'hierarchical' => true,
            'rewrite' => array( 'slug' => 'cta-category' )
        )
    );
}

// ASSIGN DEFAULT CATEGORY
add_action( 'save_post', 'cta_set_default_object_terms', 100, 2 );

function cta_set_default_object_terms( $post_id, $post ) {
  if( 'publish' === $post->post_status ) {
    $defaults = array(
      'app_category' => array( 'other-ctas' ),
      );
    $taxonomies = get_object_taxonomies( $post->post_type );
    foreach( (array) $taxonomies as $taxonomy ) {
      $terms = wp_get_post_terms( $post_id, $taxonomy );
      if( empty( $terms ) && array_key_exists( $taxonomy, $defaults ) ) {
        wp_set_object_terms( $post_id, $defaults[$taxonomy], $taxonomy );
      }
    }
  }
}

// CUSTOM COLUMS FOR ADMIN
add_filter( 'manage_edit-ctas_columns', 'cta_columns' ) ;
function cta_columns( $columns ) {
  $columns = array(
    'cb' => '<input type="checkbox" />',
    'title' => __( 'Name' ),
    'cta_category' => __( 'Ctaegory' ),
    'date' => __( 'Date' )
  );
  return $columns;
}
// Get Content for Custom Colums
add_action( 'manage_ctas_posts_custom_column', 'my_manage_cta_columns', 10, 2 );
function my_manage_cta_columns( $column, $post_id ) {
  global $post;
  switch( $column ) {
    case 'cta_category' :
      $terms = get_the_terms( $post_id, 'cta_category' );
      /* If terms were found. */
      if ( !empty( $terms ) ) {
        $out = array();
        /* Loop through each term, linking to the 'edit posts' page for the specific term. */
        foreach ( $terms as $term ) {
          $out[] = sprintf( '<a href="%s">%s</a>',
            esc_url( add_query_arg( array( 'post_type' => $post->post_type, 'cta_category' => $term->slug ), 'edit.php' ) ),
            esc_html( sanitize_term_field( 'name', $term->name, $term->term_id, 'cta_category', 'display' ) )
          );
        }
        /* Join the terms, separating them with a comma. */
        echo join( ', ', $out );
      }
      /* If no terms were found, output a default message. */
      else {
        _e( 'No CTA Assigned' );
      }
      break;
    /* Just break out of the switch statement for everything else. */
    default :
      break;
  }
}
// Add Sort Filter
add_action( 'restrict_manage_posts', 'filter_ctas' );
function filter_ctas() {

    // only display these taxonomy filters on desired custom post_type listings
    global $typenow;
    if ($typenow == 'ctas') {

        // create an array of taxonomy slugs you want to filter by - if you want to retrieve all taxonomies, could use get_taxonomies() to build the list
        $filters = array('cta_category');

        foreach ($filters as $tax_slug) {
            // retrieve the taxonomy object
            $tax_obj = get_taxonomy($tax_slug);
            $tax_name = $tax_obj->labels->name;
            // retrieve array of term objects per taxonomy
            $terms = get_terms($tax_slug);

            // output html for taxonomy dropdown filter
            echo "<select name='$tax_slug' id='$tax_slug' class='postform'>";
            echo "<option value=''>Show All</option>";
            foreach ($terms as $term) {
                // output each select option line, check against the last $_GET to show the current option selected
                echo '<option value='. $term->slug, $_GET[$tax_slug] == $term->slug ? ' selected="selected"' : '','>' . $term->name .' (' . $term->count .')</option>';
            }
            echo "</select>";
        }
    }
}

// SHORTCODE TO DISPLAY CTA GROUP
// [cta-group category="ENTER CATAGORY SLUG"]
add_shortcode('cta-group','cta_group_shortcode');
function cta_group_shortcode( $atts ) {
  wp_enqueue_style( 'cta_styles' );
  ob_start();
  extract( shortcode_atts( array (
    'type' => 'ctas',
    'order' => 'date',
    'orderby' => 'desc',
    'posts' => 3,
    'category' => '',
  ), $atts ) );
  $options = array(
    'post_type' => $type,
    'order' => $order,
    'orderby' => $orderby,
    'posts_per_page' => $posts,
    'cta_category' => $category,
  );
  $query = new WP_Query( $options );
  if ( $query->have_posts() ) { ?>
  <section class="cta-group clearfix">
    <?php
      $count = 0;
      while ( $query->have_posts() ) : $query->the_post();
      $count++;
      $third_div = ($count%3 == 0) ? 'last' : '';
      $third_div_clear = ($count%3 == 0) ? '<div class="clearboth"></div>' : ''; 
    ?>
      <div class="one_third <?php echo $third_div; ?>">
        <div class="one_fourth">
          <div class="cta-icon ss-icon <?php $meta = get_cta_meta(); if ($meta[6]) echo "ss-social-regular"; ?>" style="color:<?php $meta = get_cta_meta(); if ($meta[1]) echo "$meta[1]"; ?>; "><?php $meta = get_cta_meta(); if ($meta[0]) echo "$meta[0]"; ?><?php $meta = get_cta_meta(); if ($meta[6]) echo "$meta[6]"; ?></div>
        </div>
        <div class="three_fourth last">
          <h3><?php the_title(); ?></h3>      
          <p><?php $meta = get_cta_meta(); if ($meta[5]) echo "$meta[5]"; ?></p>
          <p><a href="<?php $meta = get_cta_meta(); if ($meta[3]) echo "$meta[3]"; ?>" target="<?php $meta = get_cta_meta(); if ($meta[4]) echo "$meta[4]"; ?>" class="button"><?php $meta = get_cta_meta(); if ($meta[2]) echo "$meta[2]"; ?></a></p>
        </div>
        <div class="clearboth"></div>
      </div>
      <?php echo $third_div_clear; ?>
      <?php endwhile;
      wp_reset_postdata(); ?>
      
  </section>
  <?php $myvariable = ob_get_clean();
  return $myvariable;
  } 
}

// SHORTCODE TO DISPLAY CTA SINGLE
// [cta-single category="ENTER CATAGORY SLUG"]
add_shortcode('cta-single','cta_shortcode');
function cta_shortcode( $atts ) {
  wp_enqueue_style( 'cta_styles' );
  ob_start();
  extract( shortcode_atts( array (
    'type' => 'ctas',
    'order' => 'date',
    'orderby' => 'desc',
    'posts' => 1,
    'category' => '',
  ), $atts ) );
  $options = array(
    'post_type' => $type,
    'order' => $order,
    'orderby' => $orderby,
    'posts_per_page' => $posts,
    'cta_category' => $category,
  );
  $query = new WP_Query( $options );
  if ( $query->have_posts() ) { ?>
  <div class="cta-single clearfix">
    <?php while ( $query->have_posts() ) : $query->the_post(); ?>      
        <div class="one_fourth">
          <div class="cta-icon ss-icon <?php $meta = get_cta_meta(); if ($meta[6]) echo "ss-social-regular"; ?>" style="color:<?php $meta = get_cta_meta(); if ($meta[1]) echo "$meta[1]"; ?>; "><?php $meta = get_cta_meta(); if ($meta[0]) echo "$meta[0]"; ?><?php $meta = get_cta_meta(); if ($meta[6]) echo "$meta[6]"; ?></div>
        </div>
        <div class="three_fourth last">
          <h3><?php the_title(); ?></h3>      
          <p><?php $meta = get_cta_meta(); if ($meta[5]) echo "$meta[5]"; ?></p>
          <p><a href="<?php $meta = get_cta_meta(); if ($meta[3]) echo "$meta[3]"; ?>" target="<?php $meta = get_cta_meta(); if ($meta[4]) echo "$meta[4]"; ?>" class="button"><?php $meta = get_cta_meta(); if ($meta[2]) echo "$meta[2]"; ?></a></p>
        </div>
        <div class="clearboth"></div>    
      <?php endwhile;
      wp_reset_postdata(); ?>      
  </div>
  <?php $myvariable = ob_get_clean();
  return $myvariable;
  } 
}

// ADD STYLESHEET TO PAGE
add_action( 'init', 'register_cta_styles' ); 
function register_cta_styles() {
    wp_register_style( 'cta_styles', plugins_url( 'css/cta-styles.css' , __FILE__ ) );
}



