<?php
/*
Plugin Name: Socrata Events
Plugin URI: http://socrata.com
Description: This plugin is a companion plugin for the The Events Calendar. It enables additional custom functionality.
Version: 1.0
Author: Michael Church
Author URI: http://socrata.com/
License: GPLv2
*/

// Print Taxonomy Categories
function events_the_categories() {
    // get all categories for this post
    global $terms;
    $terms = get_the_terms($post->ID , 'tribe_events_cat');
    // echo the first category
    echo $terms[0]->name;
    // echo the remaining categories, appending separator
    for ($i = 1; $i < count($terms); $i++) {echo ', ' . $terms[$i]->name ;}
}

// Shortcode [tribe-events]
function tribe_events_posts($atts, $content = null) {
  ob_start();
  ?>
  <section class="section-padding">
    <div class="container">
      <div class="row no-gutters">
        <div class="col-sm-6">
          <div class="background-sun-flower padding-30" style="height:400px;">
            <p>test</p>
          </div>
        </div>
        <div class="col-sm-6">
          <div class="background-midnight-blue padding-30" style="height:400px;">
            <p>test</p>
          </div>
        </div>
      </div>
    </div>
  </section>
  <section>
    <div class="container">
      <div class="row">
        <div class="col-sm-8">
          <h3>Upcoming Events</h3>
          <ul>

          <?php
            $paged = ( get_query_var('paged') ) ? get_query_var('paged') : 1;
            $args = array(
            'post_type' => 'tribe_events',
            'paged' => $paged
            );
            $query = new WP_Query( $args );

            // The Loop
            while ( $query->have_posts() ) {
            $query->the_post(); ?>

              <?php
                if( has_term( 'webinars','tribe_events_cat' ) ) { ?>
                  <li>
                    <div><small><?php events_the_categories(); ?></small></div>
                    <h4><?php the_title(); ?></h4>
                    <?php echo tribe_events_event_schedule_details( $event_id, '<p>', '</p>' ); ?>
                    <?php the_excerpt(); ?>
                  </li>
                <?php
                }
                elseif ( has_term( 'lunch-and-learn','tribe_events_cat' ) ) { ?>
                  <li>
                    <div><small><?php events_the_categories(); ?></small></div>
                    <h4><?php the_title(); ?></h4>
                    <?php echo tribe_events_event_schedule_details( $event_id, '<p>', '</p>' ); ?>
                    <?php the_excerpt(); ?>
                  </li>
                <?php
                }
                else { ?>
                  <li>
                    <div><small><?php events_the_categories(); ?></small></div>
                    <h4><?php the_title(); ?></h4>
                    <?php echo tribe_events_event_schedule_details( $event_id, '<p>', '</p>' ); ?>
                    <?php the_excerpt(); ?>
                  </li>
                <?php
                }
              ?>
            <?php
            }

          // Pagination
          if (function_exists("pagination")) {pagination($query->max_num_pages,$pages);} 

          // Restore original Post Data
          wp_reset_postdata();

          ?>
          </ul>
        </div>      

<div class="col-sm-4">
<?php
//list terms in a given taxonomy using wp_list_categories  (also useful as a widget)
$orderby = 'name';
$show_count = 0; // 1 for yes, 0 for no
$pad_counts = 0; // 1 for yes, 0 for no
$hide_empty = 1;
$hierarchical = 1; // 1 for yes, 0 for no
$taxonomy = 'tribe_events_cat';
$title = 'Event Categories';

$args = array(
'orderby' => $orderby,
'show_count' => $show_count,
'pad_counts' => $pad_counts,
'hide_empty' => $hide_empty,
'hierarchical' => $hierarchical,
'taxonomy' => $taxonomy,
'title_li' => '<h5 class="background-wisteria">'. $title .'</h5>'
);
?>
<ul class="category-nav">
<?php wp_list_categories($args); ?>
</ul>
<?php echo do_shortcode('[newsletter-sidebar]'); ?>
</div>
</div>
</div>

</section>


  <?php
  $content = ob_get_contents();
  ob_end_clean();
  return $content;
}
add_shortcode('tribe-events', 'tribe_events_posts');

// Shortcode [lunch-and-learn]
function events_lunch_learn_posts($atts, $content = null) {
  ob_start();
  ?>

  <div class="container page-padding">
    <div class="row">
      <div class="col-sm-9">
        <div class="row">

          <?php

          $paged = ( get_query_var('paged') ) ? get_query_var('paged') : 1;
          $args = array(
                'post_type' => 'tribe_events',
                'tribe_events_cat' => 'lunch-and-learn',
                'paged' => $paged
              );
          $query = new WP_Query( $args );

          // The Loop
          while ( $query->have_posts() ) {
            $query->the_post(); ?>
            <?php $thumb = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'post-thumbnail' ); $url = $thumb['0']; ?>  
            
<div class="col-sm-12">
<p class="categories"><small><?php events_the_categories(); ?><small></p>
<h4><a href="<?php the_permalink() ?>"><?php the_title(); ?></a></h4>
<p class="meta"><?php echo tribe_events_event_schedule_details( $event_id, '<small style="font-weight:400;">', '</small>' ); ?></p>
<?php the_excerpt(); ?> 
</div>

            <?php
          }

          // Pagination
          if (function_exists("pagination")) {pagination($query->max_num_pages,$pages);} 

          // Restore original Post Data
          wp_reset_postdata();

          ?>

        </div>      
      </div>
      <div class="col-sm-3">
        <?php
          //list terms in a given taxonomy using wp_list_categories  (also useful as a widget)
          $orderby = 'name';
          $show_count = 0; // 1 for yes, 0 for no
          $pad_counts = 0; // 1 for yes, 0 for no
          $hide_empty = 1;
          $hierarchical = 1; // 1 for yes, 0 for no
          $taxonomy = 'tribe_events_cat';
          $title = 'Event Categories';

          $args = array(
            'orderby' => $orderby,
            'show_count' => $show_count,
            'pad_counts' => $pad_counts,
            'hide_empty' => $hide_empty,
            'hierarchical' => $hierarchical,
            'taxonomy' => $taxonomy,
            'title_li' => '<h5 class="background-wisteria">'. $title .'</h5>'
          );
        ?>
        <ul class="category-nav">
          <?php wp_list_categories($args); ?>
        </ul>
        <?php echo do_shortcode('[newsletter-sidebar]'); ?>
      </div>
    </div>
  </div>

  <?php
  $content = ob_get_contents();
  ob_end_clean();
  return $content;
}
add_shortcode('lunch-and-learn', 'events_lunch_learn_posts');

// Shortcode [webinar-archives]
function events_webinar_archives($atts, $content = null) {
  ob_start();
  ?>

  <div class="container page-padding">
    <div class="row">
      <div class="col-sm-9">
        <div class="row">

          <?php

          $paged = ( get_query_var('paged') ) ? get_query_var('paged') : 1;
          $args = array(
                'post_type' => 'tribe_events',
                'tribe_events_cat' => 'lunch-and-learn',
                'paged' => $paged
              );
          $query = new WP_Query( $args );

          // The Loop
          while ( $query->have_posts() ) {
            $query->the_post(); ?>
            <?php $thumb = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'post-thumbnail' ); $url = $thumb['0']; ?>  
            
<div class="col-sm-12">
<p class="categories"><small><?php events_the_categories(); ?><small></p>
<h4><a href="<?php the_permalink() ?>"><?php the_title(); ?></a></h4>
<p class="meta"><?php echo tribe_events_event_schedule_details( $event_id, '<small style="font-weight:400;">', '</small>' ); ?></p>
<?php the_excerpt(); ?> 
</div>

            <?php
          }

          // Pagination
          if (function_exists("pagination")) {pagination($query->max_num_pages,$pages);} 

          // Restore original Post Data
          wp_reset_postdata();

          ?>

        </div>      
      </div>
      <div class="col-sm-3">
        <?php
          //list terms in a given taxonomy using wp_list_categories  (also useful as a widget)
          $orderby = 'name';
          $show_count = 0; // 1 for yes, 0 for no
          $pad_counts = 0; // 1 for yes, 0 for no
          $hide_empty = 1;
          $hierarchical = 1; // 1 for yes, 0 for no
          $taxonomy = 'tribe_events_cat';
          $title = 'Event Categories';

          $args = array(
            'orderby' => $orderby,
            'show_count' => $show_count,
            'pad_counts' => $pad_counts,
            'hide_empty' => $hide_empty,
            'hierarchical' => $hierarchical,
            'taxonomy' => $taxonomy,
            'title_li' => '<h5 class="background-wisteria">'. $title .'</h5>'
          );
        ?>
        <ul class="category-nav">
          <?php wp_list_categories($args); ?>
        </ul>
        <?php echo do_shortcode('[newsletter-sidebar]'); ?>
      </div>
    </div>
  </div>

  <?php
  $content = ob_get_contents();
  ob_end_clean();
  return $content;
}
add_shortcode('webinar-archives', 'events_webinar_archives');




// Add the Meta Box
function add_marketo_meta_box() {
  $types = array( 'tribe_events' );
  foreach( $types as $type ) {
    add_meta_box(
    'custom_meta_box', // $id
    'Marketo Link', // $title
    'show_marketo_meta_box', // $callback
    $type, // $page
    'side', // $context
    'default'); // $priority
  }
}
add_action('add_meta_boxes', 'add_marketo_meta_box');

// Field Array
$prefix = 'custom_';
$custom_marketo_meta_fields = array(
  array(
    'label'=> 'Link',
    'desc'  => 'Link to the Marketo Landing Page',
    'id'  => $prefix.'link',
    'type'  => 'text'
  ),
);

// The Callback
function show_marketo_meta_box() {
global $custom_marketo_meta_fields, $post;
// Use nonce for verification
echo '<input type="hidden" name="custom_meta_box_nonce" value="'.wp_create_nonce(basename(__FILE__)).'" />';
// Begin the field table and loop
echo '<table>';
foreach ($custom_marketo_meta_fields as $field) {
  // get value of this field if it exists for this post
  $meta = get_post_meta($post->ID, $field['id'], true);
  // begin a table row with
  echo '<tr>
      <td>
      <label for="'.$field['id'].'" style="display:block; font-weight:bold">'.$field['label'].'</label>';
      switch($field['type']) {
      
      // Text
      case 'text':
        echo '<input type="text" name="'.$field['id'].'" id="'.$field['id'].'" value="'.$meta.'" style="width:100%;" /><br /><span class="description"><small>'.$field['desc'].'</small></span>';
      break;
        
      } //end switch
  echo '</td></tr>';
} // end foreach
echo '</table>'; // end table
}

// Save the Data
function save_marketo_meta($post_id) {
    global $custom_marketo_meta_fields;
  // verify nonce
  if (!wp_verify_nonce($_POST['custom_meta_box_nonce'], basename(__FILE__)))
    return $post_id;
  // check autosave
  if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE)
    return $post_id;
  // check permissions
  if ('page' == $_POST['post_type']) {
    if (!current_user_can('edit_page', $post_id))
      return $post_id;
    } elseif (!current_user_can('edit_post', $post_id)) {
      return $post_id;
  }
  // loop through fields and save the data
  foreach ($custom_marketo_meta_fields as $field) {

    $old = get_post_meta($post_id, $field['id'], true);
    $new = $_POST[$field['id']];
    if ($new && $new != $old) {
      update_post_meta($post_id, $field['id'], $new);
    } elseif ('' == $new && $old) {
      delete_post_meta($post_id, $field['id'], $old);
    }
  } // end foreach
}
add_action('save_post', 'save_marketo_meta');

// Get and return the values for the URL and description
function get_marketo_meta() {
  global $post;
  $custom_link = get_post_meta($post->ID, 'custom_link', true); 

  return array(
    $custom_link
  );
}