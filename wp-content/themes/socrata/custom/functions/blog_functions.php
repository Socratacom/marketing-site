<?php

// Template Blog
add_action('thesis_hook_custom_template', 'custom_blog');
function custom_blog() {
  if (is_home()) { ?>
<div class="two_third" style="background:#ccc; width:60%; padding:0; margin:0;">shit</div>
<div class="one_third last" style="background:#ddd; width:40%; padding:0; margin:0;">poop</div>
<div class="clearboth"></div>

<div class="two_third">

  <div class="format_text">

  <?php
  $number_of_feature_posts = 1;
  $number_of_secondary_posts = 8;
  $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
  $how_many_secondary_posts_past = ($number_of_secondary_posts * ($paged - 1));
  $off = $number_of_feature_posts + (($paged > 1) ? $how_many_secondary_posts_past : 0);
  ?>

  <?php
  $feature_query = new WP_Query("posts_per_page=$number_of_feature_posts");
  while ($feature_query->have_posts()) : $feature_query->the_post(); ?>
  <h1><a href="<?php the_permalink() ?>"><?php the_title(); ?></a></h1>
  <?php endwhile; ?>
  <?php wp_reset_query(); ?>

  <?php
  $guide_query = new WP_Query("posts_per_page=$number_of_secondary_posts&offset=$off&showposts=$number_of_secondary_posts");
  while ($guide_query->have_posts()) : $guide_query->the_post(); ?>
  <p><a href="<?php the_permalink() ?>"><?php the_title(); ?></a></p>
  <?php endwhile; ?>
  <?php wp_reset_query(); ?>
  
  </div>
</div>

<div class="one_third last">
  <div class="format_text">shit</div>
</div>
<div class="clearboth"></div>
  <?php if(function_exists('wp_pagenavi')) { wp_pagenavi(); } ?>
  <?php }
}

// Body Classes for Sidebar Styling
add_filter('thesis_body_classes', 'blog_styling');
function blog_styling($classes) {
  if (is_home()) { 
    $classes[] = 'blog'; 
  }
  if (is_single()) { 
    $classes[] = 'single'; 
  }  
  if (is_archive()) { 
    $classes[] = 'blog'; 
  }
  return $classes; 
}

// Author Box Contact Info
add_filter( 'user_contactmethods', 'wptuts_contact_methods' );
function wptuts_contact_methods( $contactmethods ) {
  unset( $contactmethods[ 'aim' ] );
  unset( $contactmethods[ 'yim' ] );
  unset( $contactmethods[ 'jabber' ] );

  $contactmethods[ 'twitter' ] = 'Twitter Username';
  $contactmethods[ 'facebook' ] = 'Facebook Profile URL';
  $contactmethods[ 'linkedin' ] = 'LinkedIn Public Profile URL';
  $contactmethods[ 'googleplus' ] = 'Google+ Profile URL';
 
  return $contactmethods;
}
 
function my_get_display_author_posts() {
    global $authordata, $post;

    $authors_posts = get_posts( array( 'author' => $authordata->ID, 'post__not_in' => array( $post->ID ) ) );

    $output = '<ul>';
    foreach ( $authors_posts as $authors_post ) {
        $output .= '<li><a href="' . get_permalink( $authors_post->ID ) . '">' . apply_filters( 'the_title', $authors_post->post_title, $authors_post->ID ) . '</a></li>';
    }
    $output .= '</ul>';

    return $output;
}






