<?php

namespace Roots\Sage\Extras;

use Roots\Sage\Setup;

/**
 * Add <body> classes
 */
function body_class($classes) {
  // Add page slug if it doesn't exist
  if (is_single() || is_page() && !is_front_page()) {
    if (!in_array(basename(get_permalink()), $classes)) {
      $classes[] = basename(get_permalink());
    }
  }

  // Add class if sidebar is active
  if (Setup\display_sidebar()) {
    $classes[] = 'sidebar-primary';
  }

  return $classes;
}
add_filter('body_class', __NAMESPACE__ . '\\body_class');

/**
 * Clean up the_excerpt()
 */
function excerpt_more() {
  return ' &hellip; <a href="' . get_permalink() . '">' . __('Continued', 'sage') . '</a>';
}
add_filter('excerpt_more', __NAMESPACE__ . '\\excerpt_more');

/**
 * Next Previous nav
 */
add_filter('next_post_link', __NAMESPACE__ . '\\next_post_link_attributes');
function next_post_link_attributes($output) {
    $code = 'class="next-post-button"';
    return str_replace('<a href=', '<a '.$code.' href=', $output);
}

add_filter('previous_post_link', __NAMESPACE__ . '\\previous_post_link_attributes');
function previous_post_link_attributes($output) {
    $code = 'class="previous-post-button"';
    return str_replace('<a href=', '<a '.$code.' href=', $output);
}

/**
 * Adds responisve image class to images
 */
function WPTime_add_custom_class_to_all_images($content){
    /* Filter by Qassim Hassan - http://wp-time.com */
    $my_custom_class = "img-responsive"; // your custom class
    $add_class = str_replace('<img class="', '<img class="'.$my_custom_class.' ', $content); // add class

    return $add_class; // display class to image
}
add_filter('the_content', __NAMESPACE__ . '\\WPTime_add_custom_class_to_all_images');


/**
 * Adds category name to blog
 */
function blog_the_categories() {
  // get all categories for this post
  global $cats;
  $cats = get_the_category();
  // echo the first category
  echo $cats[0]->cat_name;
  // echo the remaining categories, appending separator
  for ($i = 1; $i < count($cats); $i++) {echo ', ' . $cats[$i]->cat_name ;}
}

// SHARED TAXONOMIES
add_action( 'init', __NAMESPACE__ . '\\shared_segment', 0 );
function shared_segment() {
  register_taxonomy(
    'segment',
    array('od_directory','case_study','socrata_videos','socrata_downloads','socrata_webinars','post'),
    array(
      'labels' => array(
        'name' => 'Segment',
        'menu_name' => 'Segment',
        'add_new_item' => 'Add New Segment',
        'new_item_name' => "New Segment"
      ),
      'show_ui' => true,
      'show_tagcloud' => false,
      'hierarchical' => true,
      'sort' => true,      
      'args' => array( 'orderby' => 'term_order' ),
      'show_admin_column' => true,
      'rewrite' => array('with_front' => false, 'slug' => 'segment'),
    )
  );
}

add_action( 'init', __NAMESPACE__ . '\\shared_product', 0 );
function shared_product() {
  register_taxonomy(
    'product',
    array('case_study','socrata_videos','socrata_downloads','socrata_webinars','post'),
    array(
      'labels' => array(
        'name' => 'Product',
        'menu_name' => 'Product',
        'add_new_item' => 'Add New Product',
        'new_item_name' => "New Product"
      ),
      'show_ui' => true,
      'show_tagcloud' => false,
      'hierarchical' => true,
      'sort' => true,      
      'args' => array( 'orderby' => 'term_order' ),
      'show_admin_column' => true,
      'rewrite' => array('with_front' => false, 'slug' => 'product'),
    )
  );
}

/** SHORTCODES **/

/**
 * Open Data Sub Nav
 */
function open_data_subnav ($atts, $content = null) {
  ob_start();
  ?>
  <section class="product-subnav">
    <div class="container">
      <div class="row">
        <div class="col-sm-12">
          <h3><a href="/products/open-data">Open Data</a></h3>
          <?php wp_nav_menu( array( 
              'theme_location' => 'product_nav_open_data',
              'container'       => '',
              'menu_class' => 'subnav' 
            ) ); ?>
        </div>
      </div>
    </div>
  </section>
  <?php
  $content = ob_get_contents();
  ob_end_clean();
  return $content;
}
add_shortcode('open-data-subnav', __NAMESPACE__ . '\\open_data_subnav');

/**
 * Marketo Social Sharing
 */
function marketo_share($atts, $content = null) {
  ob_start();
  ?>
  <div class="cf_widgetLoader cf_w_e136d060830c4c6c86672c9eb0182397"></div>
  <script type="text/javascript" src="//b2c-msm.marketo.com/jsloader/54782eb9-758c-41a0-baac-4a7ead980cba/loader.php.js"></script>
  <?php
  $content = ob_get_contents();
  ob_end_clean();
  return $content;
}
add_shortcode('marketo-share', __NAMESPACE__ . '\\marketo_share');

function marketo_share_custom($atts, $content = null) {
  ob_start();
  ?>
  <div class="cf_widgetLoader cf_w_e136d060830c4c6c86672c9eb0182397"></div>
  <div class="rss-button"><a href="<?php bloginfo('rss2_url'); ?>" title="<?php _e('Syndicate this site using RSS'); ?>" target="_blank"></a></div>
  <script type="text/javascript" src="//b2c-msm.marketo.com/jsloader/54782eb9-758c-41a0-baac-4a7ead980cba/loader.php.js"></script>
  
  <?php
  $content = ob_get_contents();
  ob_end_clean();
  return $content;
}
add_shortcode('marketo-share-custom', __NAMESPACE__ . '\\marketo_share_custom');



/**
 * Carousel Script. This temporary till I can figure out the frick'n plugin
 */
function carousel_script( $atts ) {
  extract( shortcode_atts( array(
    'id' => '',
  ), $atts ) );
  ob_start(); 
  ?>
  <script>
  jQuery(function ($){
          $(<?php echo $id; ?>).slick({
            arrows: true,
            dots: true,
            appendArrows: $('.carousel'),
            prevArrow: '<div class="toggle-left"><i class="fa slick-prev fa-chevron-left"></i></div>',
            nextArrow: '<div class="toggle-right"><i class="fa slick-next fa-chevron-right"></i></div>',
            autoplay: true,
            autoplaySpeed: 8000,
            speed: 800,
            slidesToShow: 1,
            slidesToScroll: 1,
            accessibility:false
          });
          $(<?php echo $id; ?>).show();
        });
  </script>
  <?php
  $content = ob_get_contents();
  ob_end_clean();
  return $content;
}
add_shortcode('carousel-script', __NAMESPACE__ . '\\carousel_script');

/**
 * Responsive Carousel [responsive-carousel id="" slide_id=""]
 */
function carousel_script_responsive( $atts ) {
  extract( shortcode_atts( array(
    'id' => '',
    'slide_id' => '',
  ), $atts ) );
  ob_start(); 
  ?>
  <script>
  jQuery(function ($){
    $(<?php echo "'#$slide_id'"; ?>).slick({
    arrows: true,
    appendArrows: $(<?php echo "'#$id'"; ?>),
    prevArrow: '<div class="toggle-left"><i class="fa slick-prev fa-chevron-left"></i></div>',
    nextArrow: '<div class="toggle-right"><i class="fa slick-next fa-chevron-right"></i></div>',
    autoplay: false,
    autoplaySpeed: 8000,
    speed: 800,
    slidesToShow: 4,
    slidesToScroll: 4,
    accessibility:false,
    dots:false,

      responsive: [
        {
          breakpoint: 992,
          settings: {
            slidesToShow: 3,
            slidesToScroll: 3
          }
        },
        {
          breakpoint: 768,
          settings: {
            slidesToShow: 2,
            slidesToScroll: 2
          }
        },
        {
          breakpoint: 480,
          settings: {
            slidesToShow: 1,
            slidesToScroll: 1
          }
        }
      ]
    });
    $(<?php echo "'#$slide_id'"; ?>).show();
  });
  </script>


  <?php
  $content = ob_get_contents();
  ob_end_clean();
  return $content;
}
add_shortcode('responsive-carousel', __NAMESPACE__ . '\\carousel_script_responsive');

/**
 * Responsive Carousel [partner-logos-carousel-js id=""]
 */
function partner_logos_carousel_js( $atts ) {
  extract( shortcode_atts( array(
    'id' => '',
  ), $atts ) );
  ob_start(); 
  ?>

<script>
jQuery(function ($){
$(<?php echo "'#$id'"; ?>).slick({
arrows: false,
autoplay: true,
autoplaySpeed: 3000,
slidesToShow: 6,
slidesToScroll: 1,
accessibility:false,
pauseOnHover:false,
responsive: [
  {
    breakpoint: 992,
    settings: {
      slidesToShow: 4
    }
  },
  {
  breakpoint: 768,
    settings: {
      slidesToShow: 3
    }
  },
  {
  breakpoint: 480,
    settings: {
      slidesToShow: 2
    }
  }
]
});
$(<?php echo "'#$id'"; ?>).show();
});
</script>

  <?php
  $content = ob_get_contents();
  ob_end_clean();
  return $content;
}
add_shortcode('partner-logos-carousel-js', __NAMESPACE__ . '\\partner_logos_carousel_js');

/**
 * YouTube Modal
 */
function youtube_modal( $atts ) {
  ob_start(); 
  ?>

<!-- Video / Generic Modal -->
<div class="modal video-modal" id="mediaModal" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
        <button type="button" data-dismiss="modal"><i class="icon-close"></i></button>
      <div class="modal-body">
        <!-- content dynamically inserted -->
      </div>
    </div>
  </div>
</div>

<script>
// REQUIRED: Include "jQuery Query Parser" plugin here or before this point: 
// https://github.com/mattsnider/jquery-plugin-query-parser
 (function($){var pl=/\+/g,searchStrict=/([^&=]+)=+([^&]*)/g,searchTolerant=/([^&=]+)=?([^&]*)/g,decode=function(s){return decodeURIComponent(s.replace(pl," "));};$.parseQuery=function(query,options){var match,o={},opts=options||{},search=opts.tolerant?searchTolerant:searchStrict;if('?'===query.substring(0,1)){query=query.substring(1);}while(match=search.exec(query)){o[decode(match[1])]=decode(match[2]);}return o;};$.getQuery=function(options){return $.parseQuery(window.location.search,options);};$.fn.parseQuery=function(options){return $.parseQuery($(this).serialize(),options);};}(jQuery));

// YOUTUBE VIDEO CODE
jQuery(document).ready(function($){
  
// BOOTSTRAP 3.0 - Open YouTube Video Dynamicaly in Modal Window
// Modal Window for dynamically opening videos
$('a[href^="https://www.youtube.com"]').on('click', function(e){
  // Store the query string variables and values
  // Uses "jQuery Query Parser" plugin, to allow for various URL formats (could have extra parameters)
  var queryString = $(this).attr('href').slice( $(this).attr('href').indexOf('?') + 1);
  var queryVars = $.parseQuery( queryString );
 
  // if GET variable "v" exists. This is the Youtube Video ID
  if ( 'v' in queryVars )
  {
    // Prevent opening of external page
    e.preventDefault();
 
    // Variables for iFrame code. Width and height from data attributes, else use default.
    var vidWidth = 1280; // default
    var vidHeight = 720; // default
    if ( $(this).attr('data-width') ) { vidWidth = parseInt($(this).attr('data-width')); }
    if ( $(this).attr('data-height') ) { vidHeight =  parseInt($(this).attr('data-height')); }
    var iFrameCode = '<div class="container"><div class="row"><div class="col-sm-10 col-sm-offset-1"><div class="frame"><div class="video-container"><iframe width="' + vidWidth + '" height="'+ vidHeight +'" scrolling="no" allowtransparency="true" allowfullscreen="true" src="https://www.youtube.com/embed/'+  queryVars['v'] +'?rel=0&wmode=transparent&showinfo=0&autoplay=1" frameborder="0"></iframe></div></div></div></div></div>';
 
    // Replace Modal HTML with iFrame Embed
    $('#mediaModal .modal-body').html(iFrameCode);

 
    // Open Modal
    $('#mediaModal').modal();
  }
});
 
// Clear modal contents on close. 
// There was mention of videos that kept playing in the background.
$('#mediaModal').on('hidden.bs.modal', function () {
  $('#mediaModal .modal-body').html('');
});
 
}); 
</script>


  <?php
  $content = ob_get_contents();
  ob_end_clean();
  return $content;
}
add_shortcode('youtube-modal', __NAMESPACE__ . '\\youtube_modal');

/**
 * Author Description
 */
function author_description($atts, $content = null) {
  ob_start();
  ?>




<?php  global $post;
$author_id=$post->post_author;
foreach( get_coauthors() as $coauthor ): ?>
<div class="author-description">
  <div class="headshot">
    <?php echo get_avatar( $coauthor->user_email, '70' ); ?>
    <h5><?php echo $coauthor->display_name; ?></h5>
  </div>
  <div class="box-white">
    <p><strong>About <?php echo $coauthor->display_name; ?></strong> - <?php echo $coauthor->description; ?></p>
  </div>
</div>
<?php endforeach; ?>


  <?php
  $content = ob_get_contents();
  ob_end_clean();
  return $content;
}
add_shortcode('author-description', __NAMESPACE__ . '\\author_description');

/**
 * Newsletter Signup Forms
 */
function newsletter_sidebar ($atts, $content = null) {
  ob_start();
  ?>
  <div class="newsletter-sidebar newsletter-form marketo-form">
    <h4 class="margin-bottom-15">Subscribe to our Weekly Newsletter</h4>
    <p>Each week "Transform" delivers essential news from open data events, best practices for data-driven governing, and resources to support digital government innovation.</p>
    <script src="//app-abk.marketo.com/js/forms2/js/forms2.min.js"></script>
    <form id="mktoForm_2306"></form>
    <script>MktoForms2.loadForm("//app-abk.marketo.com", "851-SII-641", 2306);</script>
  </div>
  <?php
  $content = ob_get_contents();
  ob_end_clean();
  return $content;
}
add_shortcode('newsletter-sidebar', __NAMESPACE__ . '\\newsletter_sidebar');

function newsletter_footer ($atts, $content = null) {
  ob_start();
  ?>
  <div class="marketo-form">
    <p><img src="/wp-content/themes/sage/dist/images/transform.jpg" class="img-responsive"></p>
    <h4>Subscribe to the Socrata newsletter</h4>
    <script src="//app-abk.marketo.com/js/forms2/js/forms2.min.js"></script>
    <form id="mktoForm_2306"></form>
    <script>MktoForms2.loadForm("//app-abk.marketo.com", "851-SII-641", 2306);</script>
  </div>
  <?php
  $content = ob_get_contents();
  ob_end_clean();
  return $content;
}
add_shortcode('newsletter-footer', __NAMESPACE__ . '\\newsletter_footer');

/**
 * Marketo Form
 */
function marketo_form($atts) {
extract(shortcode_atts(array(
    "id" => '',
  ), $atts));
  return '
    <div class="marketo-form">
    <script src="//app-abk.marketo.com/js/forms2/js/forms2.min.js"></script>
    <form id="mktoForm_'.$id.'"></form>
    <script>MktoForms2.loadForm("//app-abk.marketo.com", "851-SII-641", '.$id.');</script>
    </div>
  ';
}
add_shortcode('marketo-form', __NAMESPACE__ . '\\marketo_form');

/**
 * Marketo Form with Labels
 */
function marketo_form_labels($atts) {
extract(shortcode_atts(array(
    "id" => '',
  ), $atts));
  return '
    <div class="marketo-form-labels">
    <script src="//app-abk.marketo.com/js/forms2/js/forms2.min.js"></script>
    <form id="mktoForm_'.$id.'"></form>
    <script>MktoForms2.loadForm("//app-abk.marketo.com", "851-SII-641", '.$id.');</script>
    </div>
  ';
}
add_shortcode('marketo-form-labels', __NAMESPACE__ . '\\marketo_form_labels');

/**
 * Query for logos on Solutions Pages
 */
function solutions_logos( $atts ) {
  extract( shortcode_atts( array(
    'query' => ''
  ), $atts ) );
  $query = html_entity_decode( $query );
  ob_start(); 
  $the_query = new \WP_Query( $query );
  while ( $the_query->have_posts() ) : $the_query->the_post(); ?>
  <?php 
    $meta = get_socrata_stories_meta(); 
    $thumb = wp_get_attachment_image_src( $meta[6], 'full' ); 
    $url = $thumb['0']; ?>
  <div class="col-sm-2 solutions-logos">
    <div class="logo-frame text-center">
    <?php $meta = get_socrata_stories_meta(); 
      if ($meta[2]) { ?>      
        <a href="<?php echo $meta[2]; ?>" target="_blank"><img src="<?=$url?>" class="img-responsive" style="max-height:100px;"></a>
      <?php
      }
      else { ?>
        <img src="<?=$url?>" class="img-responsive ">
      <?php
      }
    ?>
    </div>
    <?php $meta = get_socrata_stories_meta(); 
      if ($meta[2]) { ?>
        <p class="text-center"><a href="<?php echo $meta[2]; ?>" target="_blank"><small><?php the_title();?></small></a></p>
      <?php
      }
      else { ?>
        <p class="text-center"><small><?php the_title();?></small></p>
      <?php
      }
    ?>    
  </div>
  <?php
  endwhile;
  wp_reset_postdata();
  $list = ob_get_clean();
  return $list;
}

add_shortcode( 'solutions-logos', __NAMESPACE__ . '\\solutions_logos' );

/**
 * Query for logos and abstract. Used on the homepage and product pages
 */
function customer_logos_abstract( $atts ) {
  extract( shortcode_atts( array(
    'query' => '',
    'class' => '',
  ), $atts ) );
  $query = html_entity_decode( $query );
  ob_start(); 
  $the_query = new \WP_Query( $query );
  while ( $the_query->have_posts() ) : $the_query->the_post(); ?>
  <?php $thumb = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'post-thumbnail' ); $url = $thumb['0']; ?>

  <div class="<?php echo $class; ?>">
    <article>
      <p><img src="<?=$url?>" class="img-responsive"></p>
      <div class="customer-text truncate">
        <h5><?php the_title(); ?></h5>
        <?php the_excerpt(); ?>
      </div>
      <ul>
        <li><a href="<?php the_permalink() ?>">Read More</a></li>
        <?php $meta = get_socrata_stories_meta(); if ($meta[2]) {echo "<li><a href='$meta[2]' target='_blank'>Visit Site</a></li>";} ?>
      </ul>
    </article>
  </div>

  <?php
  endwhile;
  wp_reset_postdata();
  $list = ob_get_clean();
  return $list;
}

add_shortcode( 'customer-logos-abstract', __NAMESPACE__ . '\\customer_logos_abstract' );

/**
 * Countdown Timer [countdown-timer id="CONTAINER ID" date="YYYY/MM/DD"]
 */
function countdown_timer( $atts ) {
  extract( shortcode_atts( array(
    'id' => '',
    'date' => '',
  ), $atts ) );
  ob_start(); 
  ?>
  <script type="text/javascript">jQuery(document).ready(function(t){t("#<?php echo $id; ?>").countdown("<?php echo $date; ?>").on("update.countdown",function(n){var o="%H:%M:%S";n.offset.days>0&&(o="%-d day%!d "+o),n.offset.weeks>0&&(o="%-w week%!w "+o),t(this).html(n.strftime(o))}).on("finish.countdown",function(n){t(this).html("This event has started!").parent().addClass("disabled")})});</script>
  <?php
  $content = ob_get_contents();
  ob_end_clean();
  return $content;
}
add_shortcode('countdown-timer', __NAMESPACE__ . '\\countdown_timer');

/* Animated Hero Image Script */
function hero_zoom ($atts, $content = null) {
  ob_start();
  ?>
  <script>jQuery(document).ready(function(e){setTimeout(function(){e(".image").addClass("animate")},500)});</script>
  <?php
  $content = ob_get_contents();
  ob_end_clean();
  return $content;
}
add_shortcode('hero-zoom', __NAMESPACE__ . '\\hero_zoom');
