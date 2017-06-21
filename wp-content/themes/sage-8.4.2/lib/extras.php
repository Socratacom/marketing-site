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


//Prevent Empty Search Results
add_filter( 'posts_search', function( $search, \WP_Query $q )
{
    if( ! is_admin() && empty( $search ) && $q->is_search() && $q->is_main_query() )
        $search .=" AND 0=1 ";

    return $search;
}, 10, 2 );



//Live Search Config
function my_searchwp_live_search_configs( $configs ) {
  // override some defaults
  $configs['default'] = array(
    'engine' => 'default',                      // search engine to use (if SearchWP is available)
    'input' => array(
      'delay'     => 500,                 // wait 500ms before triggering a search
      'min_chars' => 3,                   // wait for at least 3 characters before triggering a search
    ),
    'results' => array(
      'position'  => 'bottom',            // where to position the results (bottom|top)
      'width'     => 'auto',              // whether the width should automatically match the input (auto|css)
      'offset'    => array(
        'x' => 0,                   // x offset (in pixels)
        'y' => 5                    // y offset (in pixels)
      ),
    ),
    'spinner' => array(                   // powered by http://fgnass.github.io/spin.js/
      'lines'         => 10,              // number of lines in the spinner
      'length'        => 8,               // length of each line
      'width'         => 4,               // line thickness
      'radius'        => 8,               // radius of inner circle
      'corners'       => 1,               // corner roundness (0..1)
      'rotate'        => 0,               // rotation offset
      'direction'     => 1,               // 1: clockwise, -1: counterclockwise
      'color'         => '#000',          // #rgb or #rrggbb or array of colors
      'speed'         => 1,               // rounds per second
      'trail'         => 60,              // afterglow percentage
      'shadow'        => false,           // whether to render a shadow
      'hwaccel'       => false,           // whether to use hardware acceleration
      'className'     => 'spinner',       // CSS class assigned to spinner
      'zIndex'        => 2000000000,      // z-index of spinner
      'top'           => '50%',           // top position (relative to parent)
      'left'          => '50%',           // left position (relative to parent)
    ),
  );

  
  return $configs;
}
add_filter( 'searchwp_live_search_configs', __NAMESPACE__ . '\\my_searchwp_live_search_configs' );


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
 * Shorten excerpt length and truncate
 */
add_filter('excerpt_length', __NAMESPACE__ . '\\my_excerpt_length');
function my_excerpt_length($length) {
return 20; }
add_filter( 'excerpt_more', __NAMESPACE__ . '\\wpdocs_excerpt_more' );
function wpdocs_excerpt_more( $more ) {
return ' ...';
}

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
add_action( 'init', __NAMESPACE__ . '\\shared_solution', 0 );
function shared_solution() {
  register_taxonomy(
    'solution',
    array('case_study','socrata_videos','socrata_downloads','socrata_webinars','post','news','socrata_logos'),
    array(
      'labels' => array(
        'name' => 'Solution',
        'menu_name' => 'Solution',
        'add_new_item' => 'Add New Solution',
        'new_item_name' => "New Solution"
      ),
      'show_ui' => true,
      'show_in_menu' => true,
      'show_tagcloud' => false,
      'hierarchical' => true,
      'sort' => true,      
      'args' => array( 'orderby' => 'term_order' ),
      'show_admin_column' => false,
      'capabilities'=>array(
        'manage_terms' => 'manage_options',//or some other capability your clients don't have
        'edit_terms' => 'manage_options',
        'delete_terms' => 'manage_options',
        'assign_terms' =>'edit_posts'),
      'rewrite' => array('with_front' => false, 'slug' => 'solution'),
    )
  );
}

add_action( 'init', __NAMESPACE__ . '\\shared_segment', 0 );
function shared_segment() {
  register_taxonomy(
    'segment',
    array('od_directory','case_study','socrata_videos','socrata_downloads','socrata_webinars','post','news','socrata_logos'),
    array(
      'labels' => array(
        'name' => 'Segment',
        'menu_name' => 'Segment',
        'add_new_item' => 'Add New Segment',
        'new_item_name' => "New Segment"
      ),
      'show_ui' => true,
      'show_in_menu' => false,
      'show_tagcloud' => false,
      'hierarchical' => true,
      'sort' => true,      
      'args' => array( 'orderby' => 'term_order' ),
      'show_admin_column' => false,
      'capabilities'=>array(
        'manage_terms' => 'manage_options',//or some other capability your clients don't have
        'edit_terms' => 'manage_options',
        'delete_terms' => 'manage_options',
        'assign_terms' =>'edit_posts'),
      'rewrite' => array('with_front' => false, 'slug' => 'segment'),
    )
  );
}

add_action( 'init', __NAMESPACE__ . '\\shared_product', 0 );
function shared_product() {
  register_taxonomy(
    'product',
    array('case_study','socrata_videos','socrata_downloads','socrata_webinars','post','news'),
    array(
      'labels' => array(
        'name' => 'Product',
        'menu_name' => 'Product',
        'add_new_item' => 'Add New Product',
        'new_item_name' => "New Product"
      ),
      'show_ui' => true,
      'show_in_menu' => false,
      'show_tagcloud' => false,
      'hierarchical' => true,
      'sort' => true,      
      'args' => array( 'orderby' => 'term_order' ),
      'show_admin_column' => false,
      'capabilities'=>array(
        'manage_terms' => 'manage_options',//or some other capability your clients don't have
        'edit_terms' => 'manage_options',
        'delete_terms' => 'manage_options',
        'assign_terms' =>'edit_posts'),
      'rewrite' => array('with_front' => false, 'slug' => 'product'),
    )
  );
}

// PRINT TAXONOMY CATEGORIES
function segment_the_categories() {
  // get all categories for this post
  global $terms;
  $terms = get_the_terms($post->ID , 'segment');
  // echo the first category
  echo $terms[0]->name;
  // echo the remaining categories, appending separator
  for ($i = 1; $i < count($terms); $i++) {echo ', ' . $terms[$i]->name ;}
}

function product_the_categories() {
  // get all categories for this post
  global $terms;
  $terms = get_the_terms($post->ID , 'product');
  // echo the first category
  echo $terms[0]->name;
  // echo the remaining categories, appending separator
  for ($i = 1; $i < count($terms); $i++) {echo ', ' . $terms[$i]->name ;}
}

// Function to change "posts" to "blog" in the admin side menu
function change_post_menu_label() {
  global $menu;
  global $submenu;
  $menu[5][0] = 'Blog';
  $submenu['edit.php'][5][0] = 'Blog';
  $submenu['edit.php'][10][0] = 'Add Post';
  $submenu['edit.php'][16][0] = 'Tags';
  echo '';
}
add_action( 'admin_menu', __NAMESPACE__ . '\\change_post_menu_label' );

// Function to change post object labels to "blog"
function change_post_object_label() {
  global $wp_post_types;
  $labels = &$wp_post_types['post']->labels;
  $labels->name = 'Blog';
  $labels->singular_name = 'Blog';
  $labels->add_new = 'Add Post';
  $labels->add_new_item = 'Add Post';
  $labels->edit_item = 'Edit Post';
  $labels->new_item = 'Post';
  $labels->view_item = 'View Post';
  $labels->search_items = 'Search Posts';
  $labels->not_found = 'No Posts found';
  $labels->not_found_in_trash = 'No Posts found in Trash';
}
add_action( 'init', __NAMESPACE__ . '\\change_post_object_label' );

// Remove metaboxes from the blog
function remove_blog_meta_boxes() {
  remove_meta_box( 'tagsdiv-post_tag', 'post', 'normal' );
  remove_meta_box( 'formatdiv', 'post', 'normal' );
}
add_action( 'admin_menu', __NAMESPACE__ . '\\remove_blog_meta_boxes' );

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

// Responsive Carousel [responsive-carousel id="" slide_id=""]

function carousel_script_responsive( $atts ) {
  extract( shortcode_atts( array(
    'id' => '',
    'slide_id' => '',
  ), $atts ) );
  ob_start(); 
  ?>
  <script>
  $(document).ready(function(){
    $(<?php echo "'#$slide_id'"; ?>).slick({
    arrows: true,
    appendArrows: $(<?php echo "'#$id'"; ?>),
    prevArrow: '<div class="toggle-left"><i class="fa slick-prev fa-long-arrow-left"></i></div>',
    nextArrow: '<div class="toggle-right"><i class="fa slick-next fa-long-arrow-right"></i></div>',
    autoplay: false,
    autoplaySpeed: 8000,
    speed: 800,
    slidesToShow: 4,
    slidesToScroll: 1,
    accessibility:false,
    dots:false,
      responsive: [
        {
          breakpoint: 992,
          settings: {
            slidesToShow: 3,
            slidesToScroll: 1
          }
        },
        {
          breakpoint: 768,
          settings: {
            slidesToShow: 2,
            slidesToScroll: 1
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

// Quotes Carousel [quotes-carousel id="" slide_id=""]

function quotes_carousel( $atts ) {
  extract( shortcode_atts( array(
    'id' => '',
    'slide_id' => '',
  ), $atts ) );
  ob_start(); 
  ?>
  <script>
  $(document).ready(function(){
    $(<?php echo "'#$slide_id'"; ?>).slick({
    arrows: true,
    appendArrows: $(<?php echo "'#$id'"; ?>),
    prevArrow: '<div class="toggle-left"><i class="fa slick-prev fa-long-arrow-left"></i></div>',
    nextArrow: '<div class="toggle-right"><i class="fa slick-next fa-long-arrow-right"></i></div>',
    autoplay: true,
    autoplaySpeed: 8000,
    speed: 800,
    slidesToShow: 4,
    slidesToScroll: 1,
    accessibility:false,
    dots:false,
      responsive: [
        {
          breakpoint: 992,
          settings: {
            slidesToShow: 3,
            slidesToScroll: 1
          }
        },
        {
          breakpoint: 768,
          settings: {
            slidesToShow: 2,
            slidesToScroll: 1
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
add_shortcode('quotes-carousel', __NAMESPACE__ . '\\quotes_carousel');

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
 * Match Height
 */
function match_height( $atts ) {
  ob_start(); 
  ?>

  <script type="text/javascript">
    $(function() {
      $('.match-height').matchHeight([{byRow:true}]);
    });
  </script>
  <?php
  $content = ob_get_contents();
  ob_end_clean();
  return $content;
}
add_shortcode('match-height', __NAMESPACE__ . '\\match_height');


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
    var iFrameCode = '<div class="container"><div class="row"><div class="col-sm-10 col-sm-offset-1"><div class="video-container"><iframe width="' + vidWidth + '" height="'+ vidHeight +'" scrolling="no" allowtransparency="true" allowfullscreen="true" src="https://www.youtube.com/embed/'+  queryVars['v'] +'?rel=0&wmode=transparent&showinfo=0&autoplay=0" frameborder="0"></iframe></div></div></div></div>';
 
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
 * Addthis Sharing
 */
function addthis_sharing ($atts, $content = null) {
  ob_start();
  ?>
  <div class="addthis_inline_share_toolbox"></div>
  <?php
  $content = ob_get_contents();
  ob_end_clean();
  return $content;
}
add_shortcode('addthis', __NAMESPACE__ . '\\addthis_sharing');

/**
 * Add Load more results pagination to FacetWP
 */
function fwp_load_more() {
?>
<script>
(function($) {
    $(function() {
        if ('object' != typeof FWP) {
            return;
        }

        wp.hooks.addFilter('facetwp/template_html', function(resp, params) {
            if (FWP.is_load_more) {
                FWP.is_load_more = false;
                $('.facetwp-template').append(params.html);
                return true;
            }
            return resp;
        });

        $(document).on('click', '.fwp-load-more', function() {
            $('.fwp-load-more').html('Loading...');
            FWP.is_load_more = true;
            FWP.paged = parseInt(FWP.settings.pager.page) + 1;
            FWP.soft_refresh = true;
            FWP.refresh();
        });

        $(document).on('facetwp-loaded', function() {
            if (FWP.settings.pager.page < FWP.settings.pager.total_pages) {
                if (! FWP.loaded && 1 > $('.fwp-load-more').length) {
                    $('.facetwp-template').after('<div class="col-sm-12 text-center padding-30"><button class="fwp-load-more btn btn-primary">Show more results</button></div>');
                }
                else {
                    $('.fwp-load-more').html('Show more results').show();
                }
            }
            else {
                $('.fwp-load-more').hide();
            }
        });
    });
})(jQuery);
</script>
<?php
}
add_action( 'wp_head', __NAMESPACE__ . '\\fwp_load_more', 99 );

/**
 * Adjust default per-page results
 */
add_filter( 'facetwp_per_page_options', function( $options ) {
    return array( 12, 24, 48, 100 );
});


/**
 * Modify Media Mime Types
 */
function modify_post_mime_types( $post_mime_types ) {
 
    // select the mime type, here: 'application/pdf'
    // then we define an array with the label values
 
    $post_mime_types['application/pdf'] = array( __( 'PDFs' ), __( 'Manage PDFs' ), _n_noop( 'PDF <span class="count">(%s)</span>', 'PDFs <span class="count">(%s)</span>' ) );
 
    // then we return the $post_mime_types variable
    return $post_mime_types;
 
}
 
// Add Filter Hook
add_filter( 'post_mime_types', __NAMESPACE__ . '\\modify_post_mime_types' );


/**
 * Contact Form 1 (Request a Meeting)
 */
function contact_form_1($atts) {
extract(shortcode_atts(array(
    "url" => '',
  ), $atts));
  return '
  <form action="'.$url.'" method="post">
  <div class="row">
  <div class="col-sm-6">
  <div class="form-group">
  <label class="sr-only">First Name</label><input class="form-control" type="text" name="firstname" required="required" placeholder="First Name" />
  </div>      
  </div>
  <div class="col-sm-6">
  <div class="form-group">
  <label class="sr-only">Last Name</label><input class="form-control" type="text" name="lastname" required="required" placeholder="Last Name" />
  </div>      
  </div>
  </div>
  <div class="form-group">
  <label class="sr-only">Email Address</label><input class="form-control" type="email" name="email" required="required" placeholder="Email Address" />
  </div>
  <div class="form-group">
  <label class="sr-only">Company</label><input class="form-control" type="text" name="company" required="required" placeholder="Company" />
  </div>
  <div class="form-group">
  <label class="sr-only">Job Title</label><input class="form-control" type="text" name="jobtitle" required="required" placeholder="Job Title" />
  </div>
  <div style="position:absolute; left:-9999px; top: -9999px;">
  <label for="pardot_extra_field">Comments</label>
  <input type="text" id="pardot_extra_field" name="pardot_extra_field">
  </div>
  <button type="submit" class="btn btn-primary" value="submit" required="required" />Request a Meeting</button>
  </form>
  ';
}
add_shortcode('contact-form-1', __NAMESPACE__ . '\\contact_form_1');


/**
 * Newsletter Signup Forms
 */
function newsletter_sidebar ($atts, $content = null) {
  ob_start();
  ?>
  <div class="background-light-grey-4 padding-30 margin-bottom-30 newsletter-form marketo-form">
    <h4 class="margin-bottom-15">Subscribe to our Newsletter</h4>
    <p>"Transform" delivers essential news from open data events, best practices for data-driven governing, and resources to support digital government innovation.</p>    

  <form action="https://go.pardot.com/l/303201/2017-02-22/8vs" method="post">

  <div class="form-group">
  <label class="sr-only">First Name</label><input class="form-control" type="text" name="firstname" required="required" placeholder="First Name" />
  </div> 
  <div class="form-group">
  <label class="sr-only">Last Name</label><input class="form-control" type="text" name="lastname" required="required" placeholder="Last Name" />
  </div>
  <div class="form-group">
  <label class="sr-only">Email Address</label><input class="form-control" type="email" name="email" required="required" placeholder="Email Address" />
  </div>
  <div class="checkbox">
  <label><input type="checkbox" name="opt_in" value="">I would like a demo of Socrata solutions for my government organization.</label>
  </div>
  <div style="position:absolute; left:-9999px; top: -9999px;">
  <label for="pardot_extra_field">Comments</label>
  <input type="text" id="pardot_extra_field" name="pardot_extra_field">
  </div>
  <button type="submit" class="btn btn-primary" value="submit" required="required" />Subscribe</button>
  </form>

  </div>
  <?php
  $content = ob_get_contents();
  ob_end_clean();
  return $content;
}
add_shortcode('newsletter-sidebar', __NAMESPACE__ . '\\newsletter_sidebar');



// Content Query [content-query post-type="'POST TYPE','POST TYPE'" segment="SEGMENT SLUG"]
function content_query($atts, $content = null) {
  extract( shortcode_atts( array(
    'solution' => '',
    'segment' => '',
  ), $atts ) );
  ob_start();
  ?>
   
  <?php
  $args = array(
  'post_type' => array('post','case_study','socrata_videos','socrata_webinars'),
  'solution' => $solution,
  'segment' => $segment,
  'posts_per_page' => 4,
  'orderby' => 'date',
  'order'   => 'desc',
  );
  $myquery = new \WP_Query($args);
  // The Loop
  while ( $myquery->have_posts() ) { $myquery->the_post();
  $customer = rwmb_meta( 'case_study_customer' );
  $thumb = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'post-image-small' );
  $url = $thumb['0'];
  ?>

  <?php if ( get_post_type() == 'socrata_webinars' ) { ?>

    <div class="col-sm-6 col-md-3">
      <div class="card no-footer margin-bottom-30 match-height" style="padding:0;">
        <div class="card-header">
          <?php if ( ! empty( $thumb ) ) { ?>
            <div class="sixteen-nine img-background" style="background-image:url(<?php echo $url;?>);">
              <label>Webinar</label>
              <a href="<?php the_permalink(); ?>" class="link"></a>
            </div>
          <?php } else { ?>
            <div class="sixteen-nine img-background" style="background-image:url(/wp-content/uploads/no-image.png);">
              <label>Webinar</label>
              <a href="<?php the_permalink(); ?>" class="link"></a>
            </div>
          <?php } ?>
        </div>
        <div class="card-body">
          <h5><a href="<?php the_permalink() ?>" class="link-black"><?php the_title(); ?></a></h5>
          <p class="margin-bottom-0"><?php echo webinars_excerpt(); ?></p>
        </div>
      </div>
    </div>

  <?php } 

    elseif ( get_post_type() == 'case_study' ) { ?>

    <div class="col-sm-6 col-md-3">
      <div class="card no-footer margin-bottom-30 match-height" style="padding:0;">
        <div class="card-header">
          <?php if ( ! empty( $thumb ) ) { ?>
            <div class="sixteen-nine img-background" style="background-image:url(<?php echo $url;?>);">
              <label>Case Study</label>
              <a href="<?php the_permalink(); ?>" class="link"></a>
            </div>
          <?php } else { ?>
            <div class="sixteen-nine img-background" style="background-image:url(/wp-content/uploads/no-image.png);">
              <label>Case Study</label>
              <a href="<?php the_permalink(); ?>" class="link"></a>
            </div>
          <?php } ?>
        </div>
        <div class="card-body">
          <h5><a href="<?php the_permalink() ?>" class="link-black"><?php the_title(); ?></a></h5>
          <p class="margin-bottom-0"><?php echo case_studies_excerpt(); ?></p>
        </div>
      </div>
    </div>

  <?php }

    elseif ( get_post_type() == 'socrata_videos' ) { ?>

    <div class="col-sm-6 col-md-3">
      <div class="card no-footer margin-bottom-30 match-height" style="padding:0;">
         <div class="card-header">
            <div class="sixteen-nine img-background" style="background-image:url(https://img.youtube.com/vi/<?php $meta = get_socrata_videos_meta(); echo $meta[1]; ?>/mqdefault.jpg);">
              <label>Video</label>
              <a href="<?php the_permalink(); ?>" class="link"></a>
            </div>
        </div>
        <div class="card-body">
          <h5><a href="<?php the_permalink() ?>" class="link-black"><?php the_title(); ?></a></h5>
          <p><?php echo videos_excerpt(); ?></p>         
        </div>
      </div>
    </div>

  <?php }

    else { ?>

    <div class="col-sm-6 col-md-3">
      <div class="card margin-bottom-30 match-height" style="padding:0;">
        <div class="card-header">
          <?php if ( ! empty( $thumb ) ) { ?>
            <div class="sixteen-nine img-background" style="background-image:url(<?php echo $url;?>);">
              <label>Blog</label>
              <a href="<?php the_permalink(); ?>" class="link"></a>
            </div>
          <?php } else { ?>
            <div class="sixteen-nine img-background" style="background-image:url(/wp-content/uploads/no-image.png);">
              <label>Blog</label>
              <a href="<?php the_permalink(); ?>" class="link"></a>
            </div>
          <?php } ?>
        </div>
        <div class="card-body">
          <h5><a href="<?php the_permalink() ?>" class="link-black"><?php the_title(); ?></a></h5>
          <p><?php echo (get_the_excerpt()); ?></p>
        </div>
      </div>
    </div>

  <?php } 

  ?>


  <?php
  }
  wp_reset_postdata();
  ?>



  <?php
  $content = ob_get_contents();
  ob_end_clean();
  return $content;
}
add_shortcode('content-query', __NAMESPACE__ . '\\content_query');



