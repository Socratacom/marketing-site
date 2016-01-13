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
  <section class="background-gray-dark featured hidden-xs">
    <div class="row no-gutters">
      <div class="col-sm-6 img-background overlay-black" style="background-image: url(/wp-content/uploads/background-lunch-and-learn.jpg);"></div>
      <div class="col-sm-6 img-background overlay-black" style="background-image: url(/wp-content/uploads/background-webinars.jpg);"></div>
    </div>
    <div class="text">
      <div class="container">
        <div class="row">
          <div class="col-sm-6">
            <div class="padding-30">
              <h2 class="text-reverse margin-bottom-15">Lunch and Learn</h2>
              <p class="text-reverse">Aenean lacinia bibendum nulla sed consectetur. Maecenas sed diam eget risus varius blandit sit amet non magna. Morbi leo risus, porta ac consectetur ac, vestibulum at eros.</p>
              <dl>
                <dt class="text-reverse">Next Lunch and Learn:</dt>
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
                wp_reset_postdata();
                ?>
              </dl>
              <p><a href="/events/lunch-and-learn" class="btn btn-primary btn-lg">View All <i class="fa fa-arrow-circle-o-right"></i></a></p>
            </div>
          </div>
          <div class="col-sm-6">
            <div class="padding-30">
              <h2 class="text-reverse margin-bottom-15">Webinars</h2>
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
                wp_reset_postdata();
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
            <button class="btn btn-default dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">Event Type <span class="caret"></span></button>
           <!-- <ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
              <li><a href="/events/webinars">Webinar</a></li>
              <li><a href="/events/lunch-and-learn">Lunch and Learn</a></li>
            </ul> -->

<?php wp_nav_menu( array( 
              'theme_location' => 'events_filter',
              'container'       => '',
              'menu_class' => 'dropdown-menu' 
            ) ); ?>







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
                    <?php $meta = get_marketo_meta(); 
                      if ($meta[0]) { ?>
                        <p style="margin-top:15px;"><a href="<?php echo $meta[0];?>" class="btn btn-primary" target="_blank">Register Now</a></p>
                        <?php
                      }
                    ?>   
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
                    <?php $meta = get_marketo_meta(); 
                      if ($meta[0]) { ?>
                        <p style="margin-top:15px;"><a href="<?php echo $meta[0];?>" class="btn btn-primary" target="_blank">Sign-up Now</a></p>
                        <?php
                      }
                    ?>
                  </li>
                <?php
                }
                elseif ( has_term( 'conference','tribe_events_cat' ) ) { ?>
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
                    <p style="margin-top:15px;"><a href="mailto:events@socrata.com" class="btn btn-primary" target="_blank">Meet Us</a></p>
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

        <div class="col-sm-4 events-sidebar hidden-xs">
          <div class="padding-30 background-clouds">
            <h4>Let's Meet Up</h4>
            <p>See an event you'd like to attend or want to suggest an event we should attend...</p>
            <p><a href="mailto:events@socrata.com" class="btn btn-warning">Email Us</a></p>
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





// Shortcode [webinars]
function events_webinar_posts($atts, $content = null) {
  ob_start();
  ?>
<section class="breadcrumbs">
  <div class="container">
    <div class="row">
      <div class="col-sm-12">
        <?php if ( function_exists('yoast_breadcrumb') ) 
      {yoast_breadcrumb('<div id="breadcrumbs">','</div>');} ?>
      </div>
    </div>
  </div>
</section>
<section class="section-padding">
  <div class="container">
    <div class="row">
      <div class="col-sm-8">
        <h3>Upcoming Webinars</h3>
        <ul class="event-list">
        <?php
        $paged = ( get_query_var('paged') ) ? get_query_var('paged') : 1;
        $args = array(
        'post_type' => 'tribe_events',
        'tribe_events_cat' => 'webinar',
        'paged' => $paged
        );
        $query = new WP_Query( $args );

        // The Loop
        while ( $query->have_posts() ) {
        $query->the_post(); ?>

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
            <?php $meta = get_marketo_meta(); 
              if ($meta[0]) { ?>
                <p style="margin-top:15px;"><a href="<?php echo $meta[0];?>" class="btn btn-primary" target="_blank">Register Now</a></p>
                <?php
              }
            ?>   
          </li>

        <?php
        }

        // Restore original Post Data
        wp_reset_postdata();
        ?>
        </ul>

        <?php if (function_exists("pagination")) {pagination($query->max_num_pages,$pages);}; ?> 

      </div>      
      <div class="col-sm-4 hidden-xs events-sidebar">
        <div class="next-event">
          <h5>Next Lunch and Learn</h5>
          <div class="padding-30">          
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
                <p><strong><?php the_title();?></strong><br><?php echo tribe_events_event_schedule_details( $event_id ); ?></p>

                <?php $meta = get_marketo_meta(); if ($meta[0]) { ?>
                  <p><a href="<?php echo $meta[0];?>" class="btn btn-primary" target="_blank">Sign-up Now</a></p>
                  <?php
                } ?>
              <?php
              }
              wp_reset_postdata();
            ?>
          </div>
        </div>
        <h4>Additional Resources</h4>
        <?php wp_nav_menu( array( 'theme_location' => 'site_nav_resources' ) ); ?>
      </div>


    </div>    
  </div>
</section>

  <?php
  $content = ob_get_contents();
  ob_end_clean();
  return $content;
}
add_shortcode('webinars', 'events_webinar_posts');



// Shortcode [lunch-and-learn]
function events_lunch_and_learn_posts($atts, $content = null) {
  ob_start();
  ?>
<section class="breadcrumbs">
  <div class="container">
    <div class="row">
      <div class="col-sm-12">
        <?php if ( function_exists('yoast_breadcrumb') ) 
      {yoast_breadcrumb('<div id="breadcrumbs">','</div>');} ?>
      </div>
    </div>
  </div>
</section>
<section class="section-padding">
  <div class="container">
    <div class="row">
      <div class="col-sm-8">
        <h3>Upcoming Lunch and Learn</h3>
        <ul class="event-list">
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
            <?php $meta = get_marketo_meta(); if ($meta[0]) { ?>
                <p style="margin-top:15px;"><a href="<?php echo $meta[0];?>" class="btn btn-primary" target="_blank">Sign-up Now</a></p>
                <?php
              } ?>
          </li>

        <?php
        }

        // Restore original Post Data
        wp_reset_postdata();
        ?>
        </ul>

        <?php if (function_exists("pagination")) {pagination($query->max_num_pages,$pages);}; ?> 

      </div>      
      <div class="col-sm-4 hidden-xs events-sidebar">
        <div class="next-event">
          <h5>Next Webinar</h5>
          <div class="padding-30">          
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
                <p><strong><?php the_title();?></strong><br><?php echo tribe_events_event_schedule_details( $event_id ); ?></p>

                <?php $meta = get_marketo_meta(); if ($meta[0]) { ?>
                  <p><a href="<?php echo $meta[0];?>" class="btn btn-primary" target="_blank">Register Now</a></p>
                  <?php
                } ?>
              <?php
              }
              wp_reset_postdata();
            ?>
          </div>
        </div>
        <h4>Additional Resources</h4>
        <?php wp_nav_menu( array( 'theme_location' => 'site_nav_resources' ) ); ?>
      </div>
    </div>    
  </div>
</section>

  <?php
  $content = ob_get_contents();
  ob_end_clean();
  return $content;
}
add_shortcode('lunch-and-learn', 'events_lunch_and_learn_posts');











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