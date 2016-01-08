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
  <section class="section-padding background-clouds featured">
    <div class="container">
      <div class="row">
        <div class="col-sm-10 col-sm-offset-1">
          <h1 class="text-center margin-bottom-15">Socrata Events</h1>
          <h3 class="text-center margin-bottom-60">Donec id elit non mi porta gravida at eget metus. Cras mattis consectetur purus sit amet fermentum.</h3>
        </div>
        <div class="col-sm-6">

          <div class="img-background" style="background-image: url(/wp-content/uploads/webinar-police.jpg); margin-bottom:30px;">
            <div class="box-black padding-30" style="min-height:350px;">
              <h3 class="text-reverse margin-bottom-15">Lunch &amp; Learn</h3>
              <p class="text-reverse">Aenean lacinia bibendum nulla sed consectetur. Maecenas sed diam eget risus varius blandit sit amet non magna. Morbi leo risus, porta ac consectetur ac, vestibulum at eros.</p>
              <dl>
                <dt class="text-reverse">Next Lunch &amp; Learn:</dt>
                <?php
                $args = array(
                'post_type' => 'tribe_events',
                'tribe_events_cat' => 'lunch-and-learn',
                'posts_per_page' => 1
                );
                $query = new WP_Query( $args );

                // The Loop
                while ( $query->have_posts() ) {
                $query->the_post(); ?>
                <?php echo tribe_events_event_schedule_details( $event_id, '<dd class="text-reverse">', '</dd>' ); ?>
                <?php
                }
                ?>
              </dl>
              <p><a href="/events/lunch-and-learn" class="btn btn-primary btn-lg">View All <i class="fa fa-arrow-circle-o-right"></i></a></p>
            </div>
          </div>

        </div>
        <div class="col-sm-6">

          <div class="img-background" style="background-image: url(/wp-content/uploads/webinar-police.jpg); margin-bottom:30px;">
            <div class="box-black padding-30" style="min-height:350px;">
              <h3 class="text-reverse margin-bottom-15">Webinars</h3>
              <p class="text-reverse">Maecenas faucibus mollis interdum. Duis mollis, est non commodo luctus, nisi erat porttitor ligula. Cras justo odio, dapibus ac facilisis in, egestas eget quam.</p>
              <dl>
                <dt class="text-reverse">Next Webinar:</dt>
                <?php
                $args = array(
                'post_type' => 'tribe_events',
                'tribe_events_cat' => 'webinar',
                'posts_per_page' => 1
                );
                $query = new WP_Query( $args );

                // The Loop
                while ( $query->have_posts() ) {
                $query->the_post(); ?>
                <?php echo tribe_events_event_schedule_details( $event_id, '<dd class="text-reverse">', '</dd>' ); ?>
                <?php
                }
                ?>
              </dl>
              <p><a href="/events/webinars" class="btn btn-primary btn-lg">View All <i class="fa fa-arrow-circle-o-right"></i></a></p>
            </div>
          </div>

        </div>
      </div>
    </div>
  </section>
  <section class="section-padding">
    <div class="container">
      <div class="row">
        <div class="col-sm-8">
          <h3>Upcoming Events</h3>

          <div class="dropdown">
            <button class="btn btn-primary dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">Event Type <span class="caret"></span></button>
            <ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
              <li><a href="/events/webinars">Webinar</a></li>
              <li><a href="/events/lunch-and-learn">Lunch and Learn</a></li>
            </ul>
          </div>

          <ul class="event-list">

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
                if( has_term( 'webinar','tribe_events_cat' ) ) { ?>
                  <li>
                    <p class="categories"><?php events_the_categories(); ?></p>
                    <?php $meta = get_marketo_meta(); 
                      if ($meta[0]) { ?>
                        <h4><a href="<?php echo $meta[0];?>" target="_blank"><?php the_title(); ?></a></h4>
                        <?php
                      }
                      else { ?>
                        <h4><?php the_title(); ?></h4>
                      <?php
                      }
                    ?>                    
                    <?php echo tribe_events_event_schedule_details( $event_id, '<p class="date">', '</p>' ); ?>
                    <?php the_excerpt(); ?>
                  </li>
                <?php
                }
                elseif ( has_term( 'lunch-and-learn','tribe_events_cat' ) ) { ?>
                  <li>
                    <p class="categories"><?php events_the_categories(); ?></p>
                    <?php $meta = get_marketo_meta(); 
                      if ($meta[0]) { ?>
                        <h4><a href="<?php echo $meta[0];?>" target="_blank"><?php the_title(); ?></a></h4>
                        <?php
                      }
                      else { ?>
                        <h4><?php the_title(); ?></h4>
                      <?php
                      }
                    ?>
                    <?php echo tribe_events_event_schedule_details( $event_id, '<p class="date">', '</p>' ); ?>
                    <?php the_excerpt(); ?>
                  </li>
                <?php
                }
                else { ?>
                  <li>
                    <p class="categories"><?php events_the_categories(); ?></p>
                    <h4><?php the_title(); ?></h4>
                    <?php echo tribe_events_event_schedule_details( $event_id, '<p class="date">', '</p>' ); ?>
                    <?php the_excerpt(); ?>
                  </li>
                <?php
                }
              ?>
            <?php
            }        

          // Restore original Post Data
          wp_reset_postdata();
          ?>
          </ul>
          <?php if (function_exists("pagination")) {pagination($query->max_num_pages,$pages);}; ?> 
        </div>      

        <div class="col-sm-4">
          <div class="padding-15 background-clouds">
            <h4>Let's meet up.</h4>
            <p>See an event you'd like to attend or want to suggest an event we should attend... drop us a line.</p>
          </div>
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