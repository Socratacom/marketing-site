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

  <div class="container page-padding">
    <div class="row">
      <div class="col-sm-9">
        <div class="row">

          <?php

          $do_not_duplicate = array();

          // The Query
          $args = array(
                'post_type' => 'tribe_events',
                'posts_per_page' => 1
              );
          $query1 = new WP_Query( $args );

          // The Loop
          while ( $query1->have_posts() ) {
            $query1->the_post();
            $do_not_duplicate[] = get_the_ID(); ?>

            <div class="col-sm-12">
              <div class="featured-post overlay-black" style="background-image: url(<?php echo Roots\Sage\Extras\custom_feature_image('full', 850, 400); ?>);">
                <div class="text truncate">
                  <div class="post-category background-wisteria">Events</div>
                  <h2><a href="<?php the_permalink() ?>"><?php the_title(); ?></a></h2>                                
                </div>
                <p class="meta"><?php echo tribe_events_event_schedule_details( $event_id, '<strong>', '</strong>' ); ?>    </p>
                <a href="<?php the_permalink() ?>" class="link"></a>
              </div>
            </div>
            <?php
          }

          wp_reset_postdata();

          /* The 2nd Query (without global var) */
          $paged = ( get_query_var('paged') ) ? get_query_var('paged') : 1;
          $args2 = array(
                'post_type' => 'tribe_events',
                'paged' => $paged,
                'post__not_in' => $do_not_duplicate 
              );
          $query2 = new WP_Query( $args2 );

          // The 2nd Loop
          while ( $query2->have_posts() ) {
            $query2->the_post(); ?>
            
            <div class="col-sm-6 col-lg-4">
              <div class="card">
                <div class="card-image hidden-xs">
                  <?php if ( has_post_thumbnail() ) { ?>
                    <img src="<?php echo Roots\Sage\Extras\custom_feature_image('full', 360, 180); ?>" class="img-responsive">
                  <?php
                  } else { ?>
                    <img src="/wp-content/uploads/no-image.png" class="img-responsive">
                  <?php
                  }
                  ?>
                  <a href="<?php the_permalink() ?>"></a>
                </div>
                <div class="card-text truncate">
                  <p class="categories"><small><?php events_the_categories(); ?><small></p>
                  <h4><a href="<?php the_permalink() ?>"><?php the_title(); ?></a></h4>
                  <p class="meta"><?php echo tribe_events_event_schedule_details( $event_id, '<small style="font-weight:400;">', '</small>' ); ?></p>
                  <?php the_excerpt(); ?> 
                </div>
              </div>
            </div>

            <?php
          }

          // Pagination
          if (function_exists("pagination")) {pagination($query2->max_num_pages,$pages);} 

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
add_shortcode('tribe-events', 'tribe_events_posts');