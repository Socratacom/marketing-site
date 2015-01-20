<?php

add_action('thesis_hook_before_html', 'custom_ndoch_hero');
function custom_ndoch_hero() {
  if (is_page('ndoch')) { ?>
  <div id="full_hero" class="container intro-effect-push">
    <div class="full-hero-image">
      <div class="bg-img"><img src="/wp-content/themes/socrata/custom/ndoch/images/ndoch.jpg"></div>
      <div class="title">
        <div class="title-inner format_text">
          <h1 style="color:#fff; font-size: 4em; font-weight: 600; line-height: 1em; text-shadow: 0px 0px 10px #000; letter-spacing: -2px; padding-top: 2%; margin-bottom:.2em; text-transform: uppercase; ">National Day of Civic Hacking</h1>
          <p class="highlight-text"><span class="highlight">Socrata will be involved with over 40 events across the United States. Find out where we'll be, access useful resources, and talk to us through our virtual support portal to get the help you need.</span></p>
          <p><a href="https://plus.google.com/events/ctgbej1ttlt7pnltjb75sjm68n0" target="_blank" class="button">Get Support Here</a> <a href="http://dev.socrata.com/" target="_blank" class="button">Access Developer Portal</a></p>
        </div>
      </div>
      <p style="position: fixed; bottom: 20px; left: 20px; z-index: 1000; color:#fff; font-size: .5em; margin:0; text-shadow: 0px 0px 10px #000; max-width: 640px; ">PHOTO BY: <a href="https://www.flickr.com/photos/city_of_seattle/" target="_blank" style="color:#fff;">City of Seattle</a></p>
    </div>
    <button class="trigger" data-info="CLICK OR SCROLL"><span>&nbsp;</span></button>
    <?php }
}

add_action('thesis_hook_custom_template', 'custom_ndoch');
function custom_ndoch() {
  if (is_page('ndoch')) { ?>
  <div class="content">
    <?php thesis_content_column(); ?>
  </div>
</div>
    <?php }
}

// SHORTCODE TO DISPLAY BLOG NDOCH POSTS
// [ndoch-posts]
add_shortcode('ndoch-posts','ndoch_posts_shortcode');
function ndoch_posts_shortcode( $atts ) {
  ob_start();
  extract( shortcode_atts( array (
    'type' => 'post',
    'tag' => 'ndoch',
    'order' => 'date',
    'orderby' => 'desc',
    'posts' => 10,
  ), $atts ) );
  $options = array(
    'post_type' => $type,
    'tag' => $tag,
    'order' => $order,
    'orderby' => $orderby,
    'posts_per_page' => $posts,
  );
  $query = new WP_Query( $options );
  if ( $query->have_posts() ) { ?>
  <?php $ndoch_query = new WP_Query($options); while ($ndoch_query->have_posts()) : $ndoch_query->the_post(); ?>
  <div style="border-bottom:#e9e9e9 solid 1px; padding:2% 0;">
    <div class="one_third">
      <a href="<?php the_permalink() ?>"><img src="<?php echo tuts_custom_img('full', 300, 300);?>" style="width:100%;" /></a>
    </div>
    <div class="two_third last" style="padding:2% 0;">
      <h2 style="font-size:1.5em; margin-bottom:0;"><a href="<?php the_permalink() ?>"><?php the_title(); ?></a></h2>
      <p><small><strong>By</strong> <?php the_author(); ?> &bull; <strong>Posted</strong> <?php the_time('F jS, Y') ?></p></small></p>
      <p style="line-height: normal;"><?php
          $theexcerpt = get_the_excerpt();
          $getlength = strlen($theexcerpt);
          $thelength = 140;
          echo substr($theexcerpt, 0, $thelength);
          if ($getlength > $thelength) echo "...";
          ?></p>
    </div>
    <div class="clearboth"></div>
  </div>
  <?php endwhile; wp_reset_query(); ?>
  <?php $myvariable = ob_get_clean();
  return $myvariable;
  } 
}

// SHORTCODE TO DISPLAY NDOCH PRESS RELEASE
// [ndoch-press]
add_shortcode('ndoch-press','ndoch_press_shortcode');
function ndoch_press_shortcode( $atts ) {
  ob_start();
  extract( shortcode_atts( array (
    'type' => 'news',
    'tag' => 'ndoch',
    'order' => 'date',
    'orderby' => 'desc',
    'posts' => 1,
  ), $atts ) );
  $options = array(
    'post_type' => $type,
    'tag' => $tag,
    'order' => $order,
    'orderby' => $orderby,
    'posts_per_page' => $posts,
  );
  $query = new WP_Query( $options );
  if ( $query->have_posts() ) { ?>
  <?php $query = new WP_Query($options); while ($query->have_posts()) : $query->the_post(); ?>
  <div style="border-bottom:#e9e9e9 solid 1px; padding:2% 0;">
    <div class="one_third">
      <a href="<?php the_permalink() ?>"><img src="<?php echo tuts_custom_img('full', 300, 300);?>" style="width:100%;" /></a>
    </div>
    <div class="two_third last" style="padding:2% 0;">
      <h2 style="font-size:1.5em; margin-bottom:0;"><a href="<?php the_permalink() ?>"><?php the_title(); ?></a></h2>
      <p><small><strong>By</strong> <?php the_author(); ?> &bull; <strong>Posted</strong> <?php the_time('F jS, Y') ?></p></small></p>
      <p style="line-height: normal;"><?php
          $theexcerpt = get_the_excerpt();
          $getlength = strlen($theexcerpt);
          $thelength = 140;
          echo substr($theexcerpt, 0, $thelength);
          if ($getlength > $thelength) echo "...";
          ?></p>
    </div>
    <div class="clearboth"></div>
  </div>
  <?php endwhile; wp_reset_query(); ?>
  <?php $myvariable = ob_get_clean();
  return $myvariable;
  } 
}

// SHORTCODE TO DISPLAY HACKFORCHANGE TWITTER
// [twitter-hackforchange]
add_shortcode('twitter-hackforchange','twitter_hackforchange_shortcode');
function twitter_hackforchange_shortcode() {
  return '
  <a class="twitter-timeline" href="https://twitter.com/search?q=%23hackforchange" data-widget-id="471725477338439680"  data-chrome="nofooter transparent" data-tweet-limit="5">Tweets about "#hackforchange"</a>
<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?"http":"https";if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+"://platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>
  '; 
}

// Enqueue Scripts
add_action('wp_enqueue_scripts', 'ndoch_scripts');
function ndoch_scripts() {
  if (is_page('ndoch')) {
    wp_register_style( 'component', get_stylesheet_directory_uri() . '/custom/ndoch/css/component.css' );
    wp_register_script( 'fullhero', get_stylesheet_directory_uri() . '/custom/ndoch/scripts/full-hero.js','','1.1', true); 
    wp_enqueue_style( 'component' );
    wp_enqueue_script( 'fullhero' );
  }
}

// Body Classes for Sidebar Styling
add_filter('thesis_body_classes', 'full_hero_styling');
function full_hero_styling($classes) {
  if (is_page('ndoch')) { 
    $classes[] = 'full-hero'; 
  }
  return $classes; 
}