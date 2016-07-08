<?php
/*
Plugin Name: Socrata Newsroom
Plugin URI: http://fishinglounge.com/
Description: This plugin adds the Newsroom for press releases.
Version: 1.0
Author: Michael Church
Author URI: http://fishinglounge.com/
License: GPLv2
*/


// REGISTER POST TYPE
add_action( 'init', 'news_post_type' );

function news_post_type() {
  register_post_type( 'news',
    array(
      'labels' => array(
        'name' => 'Newsroom',
        'singular_name' => 'Newsroom',
        'add_new' => 'Add New Post',
        'add_new_item' => 'Add New Post',
        'edit' => 'Edit Post',
        'edit_item' => 'Edit Post',
        'new_item' => 'New Post',
        'view' => 'View',
        'view_item' => 'View Post',
        'search_items' => 'Search Posts',
        'not_found' => 'Not found',
        'not_found_in_trash' => 'Not found in Trash',
        'parent' => 'Parent Socrata News'
      ),
      'public' => true,
      'menu_position' => 5,
      'supports' => array( 'title','thumbnail' ),
      'taxonomies' => array( '' ),
      'menu_icon' => '',
      'has_archive' => true,
      'rewrite' => array('with_front' => false, 'slug' => 'newsroom-article')
    )
  );
}

// MENU ICON
//Using Dashicon Font http://melchoyce.github.io/dashicons/
add_action( 'admin_head', 'add_news_icon' );
function add_news_icon() { ?>
  <style>
    #adminmenu .menu-icon-news div.wp-menu-image:before {
      content: '\f123';
    }
  </style>
  <?php
}

// TAXONOMIES
add_action( 'init', 'create_news_taxonomies', 0 );
function create_news_taxonomies() {
  register_taxonomy(
    'news_category',
    'news',
    array (
    'labels' => array(
    'name' => 'Newsroom Category',
    'add_new_item' => 'Add New Category',
    'new_item_name' => "New Category"
  ),
    'show_ui' => true,
    'show_tagcloud' => false,
    'hierarchical' => true,
    'sort' => true,      
    'args' => array( 'orderby' => 'term_order' ),
    'show_admin_column' => true,    
    'capabilities'=>array(
      'manage_terms' => 'manage_options',//or some other capability your clients don't have
      'edit_terms' => 'manage_options',
      'delete_terms' => 'manage_options',
      'assign_terms' =>'edit_posts'
    ),
    'rewrite' => array('with_front' => false, 'slug' => 'newsroom')
    )
  );
}

// Print Taxonomy Categories
function news_the_categories() {
    // get all categories for this post
    global $terms;
    $terms = get_the_terms($post->ID , 'news_category');
    // echo the first category
    echo $terms[0]->name;
    // echo the remaining categories, appending separator
    for ($i = 1; $i < count($terms); $i++) {echo ', ' . $terms[$i]->name ;}
}

// Template Paths
add_filter( 'template_include', 'news_single_template', 1 );
function news_single_template( $template_path ) {
  if ( get_post_type() == 'news' ) {
    if ( is_single() ) {
      // checks if the file exists in the theme first,
      // otherwise serve the file from the plugin
      if ( $theme_file = locate_template( array ( 'single-news.php' ) ) ) {
        $template_path = $theme_file;
      } else {
        $template_path = plugin_dir_path( __FILE__ ) . 'single-news.php';
      }
    }
    if ( is_archive() ) {
      // checks if the file exists in the theme first,
      // otherwise serve the file from the plugin
      if ( $theme_file = locate_template( array ( 'archive-news.php' ) ) ) {
        $template_path = $theme_file;
      } else {
        $template_path = plugin_dir_path( __FILE__ ) . 'archive-news.php';
      }
    }
  }
  return $template_path;
}

// Custom Body Class
add_action( 'body_class', 'news_body_class');
function news_body_class( $classes ) {
  if ( is_page('newsroom') || get_post_type() == 'news' && is_single() || get_post_type() == 'news' && is_archive() )
    $classes[] = 'news';
  return $classes;
}

// CUSTOM EXCERPT
function news_excerpt() {
  global $post;
  $text = rwmb_meta( 'news_wysiwyg' );
  if ( '' != $text ) {
    $text = strip_shortcodes( $text );
    $text = apply_filters('the_content', $text);
    $text = str_replace(']]>', ']]>', $text);
    $excerpt_length = 20; // 20 words
    $excerpt_more = apply_filters('excerpt_more', ' ' . ' ...');
    $text = wp_trim_words( $text, $excerpt_length, $excerpt_more );
  }
  return apply_filters('get_the_excerpt', $text);
}


// Metabox

add_filter( 'rwmb_meta_boxes', 'news_register_meta_boxes' );
function news_register_meta_boxes( $meta_boxes )
{
  $prefix = 'news_';

  $meta_boxes[] = array(
    'title'  => __( 'News Details', 'news' ),
    'post_types' => array( 'news' ),
    'context'    => 'normal',
    'priority'   => 'high',
    'fields' => array(
      // HEADING
      array(
        'type' => 'heading',
        'name' => __( 'Featured News', 'news' ),
        'id'   => 'fake_id', // Not used but needed for plugin
      ),
      // CHECKBOX
      array(
        'name' => __( 'Featured', 'news' ),
        'id'   => "{$prefix}featured",
        'desc' => __( 'Yes. This is a featured article.', 'news' ),
        'type' => 'checkbox',
        // Value can be 0 or 1
        'std'  => 0,
      ),
      // HEADING
      array(
        'type' => 'heading',
        'name' => __( 'External News Info', 'news' ),
        'id'   => 'fake_id', // Not used but needed for plugin
      ),
      // TEXT
      array(
        'name'  => __( 'Source', 'news' ),
        'id'    => "{$prefix}source",
        'desc' => __( 'Eample: Wall Street Journal', 'news' ),
        'type'  => 'text',
      ),
      // URL
      array(
        'name' => __( 'Source URL', 'news' ),
        'id'   => "{$prefix}url",
        'desc' => __( 'Include the http:// or https://', 'news' ),
        'type' => 'url',
      ),
      // IMAGE ADVANCED (WP 3.5+)
      array(
        'name'             => __( 'Logo', 'news' ),
        'id'               => "{$prefix}logo",
        'desc' => __( 'NOT FOR PRESS RELEASES', 'news' ),
        'type'             => 'image_advanced',
        'max_file_uploads' => 1,
      ),
      // HEADING
      array(
        'type' => 'heading',
        'name' => __( 'Press Release Content', 'news' ),
        'id'   => 'fake_id', // Not used but needed for plugin
      ),
      array(
        'name'    => __( 'Press Release Content', 'news' ),
        'id'      => "{$prefix}wysiwyg",
        'type'    => 'wysiwyg',
        // Set the 'raw' parameter to TRUE to prevent data being passed through wpautop() on save
        'raw'     => false,
        // Editor settings, see wp_editor() function: look4wp.com/wp_editor
        'options' => array(
          'textarea_rows' => 15,
          'teeny'         => true,
          'media_buttons' => false,
        ),
      ),
    )
  );
  return $meta_boxes;
}


// Shortcode [newsroom-posts]
function newsroom_posts($atts, $content = null) {
  ob_start();
  ?>

<?php
  $args = array(
  'post_type'             => 'news',
  'meta_query' => array(
    array(
        'key' => 'news_featured',
        'value' => '1'
    )
  ),
  'posts_per_page'        => 3,
  'post_status'           => 'publish',
  );

  // The Query
  $the_query = new WP_Query( $args );

// The Loop
if ( $the_query->have_posts() ) { ?>
  <section class="section-padding background-light-grey-4 hidden-xs">
    <div class="container">
      <div class="row">
        <div class="col-sm-12">
          <h2 class="text-center margin-bottom-60">Featured articles</h2>
        </div>
      </div>
    <div class="row row-centered">
    <?php
    while ( $the_query->have_posts() ) {
      $the_query->the_post();
      $logo = rwmb_meta( 'news_logo', 'size=medium' );
      $link = rwmb_meta( 'news_url' );
      $source = rwmb_meta( 'news_source' );
      $thumb = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'post-image-small' );
      $url = $thumb['0']; { ?>

        <?php if ( ! empty( $logo ) ) { ?> 
          <div class="col-sm-4 col-centered">
            <div class="thumbnail">
              <div class="sixteen-nine">
                <div class="aspect-content logo-background" style="background-image:url(<?php foreach ( $logo as $image ) { echo $image['url']; } ?>);"></div>
                <a href="<?php echo $link;?>" target="_blank" class="link"></a>
              </div>
              <div class="caption">
                <p class="margin-bottom-0 color-secondary text-uppercase text-semi-bold"><small><?php news_the_categories(); ?></small></p>
                <h4 class="margin-bottom-5"><a href="<?php echo $link;?>" target="_blank" title="<?php the_title_attribute(); ?>" class="link-black"><?php the_title(); ?></a></h4>
                <p class="margin-bottom-5"><small><?php echo $source;?> | <?php the_time('F j, Y') ?></small></p>
                <p class="margin-bottom-0"><a href="<?php echo $link;?>" target="_blank">Read article <i class="fa fa-arrow-circle-o-right" aria-hidden="true"></i></a></p>
              </div>
            </div>
          </div>

          <?php } else { ?> 

          <div class="col-sm-4 col-centered">
            <div class="thumbnail">
              <?php
                if ( ! empty( $thumb ) ) { ?>
                  <div class="sixteen-nine" style="border:none;">
                    <div class="aspect-content post-background" style="background-image:url(<?php echo $url;?>);"></div>
                    <a href="<?php echo $link;?>" target="_blank" class="link"></a>
                  </div> 
                  <?php
                }     
                else { ?>
                  <div class="sixteen-nine" style="border:none;">
                    <div class="aspect-content post-background" style="background-image:url(/wp-content/uploads/no-image.png);"></div>
                    <a href="<?php echo $link;?>" target="_blank" class="link"></a>
                  </div>
                  <?php
                }
              ?>
              <div class="caption">
                <p class="margin-bottom-0 color-secondary text-uppercase text-semi-bold"><small><?php news_the_categories(); ?></small></p>
                <h4 class="margin-bottom-5"><a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>" class="link-black"><?php the_title(); ?></a></h4>
                <p class="margin-bottom-5"><small><?php the_time('F j, Y') ?></small></p>
                <p class="margin-bottom-0"><a href="<?php the_permalink(); ?>">Learn more <i class="fa fa-arrow-circle-o-right" aria-hidden="true"></i></a></p>
              </div>
            </div>
          </div>

          <?php } 
        ?>
      <?php }
    } ?>
    
    </div>
    </div>
    </section>

    <?php
  } 
  else {
  // no posts found
  }
  /* Restore original Post Data */
  wp_reset_postdata(); 
?>
  <section class="filter-bar">
    <div class="container">
      <div class="row">
        <div class="col-sm-12">
          <ul>
            <li><?php echo do_shortcode('[facetwp facet="newsroom_categories"]') ;?></li>
            <li class="hidden-xs"><button onclick="FWP.reset()" class="facetwp-reset">Reset</button></li>
          </ul>
        </div>
      </div>
    </div>
  </section>
  <section class="section-padding">
    <div class="container">
      <div class="row">
        <div class="col-sm-8">
          <?php echo do_shortcode('[facetwp template="newsroom"]') ;?>
        </div>
        <div class="col-sm-4">
          <div class="alert alert-info margin-bottom-30">
            <i class="fa fa-info-circle" aria-hidden="true"></i> <strong>Media Contact:</strong> <a href="mailto:press@socrata.com">press@socrata.com</a>
          </div>            
          <?php echo do_shortcode('[newsletter-sidebar]'); ?>

          <?php
          $args = array(
          'post_type'         => 'post',
          'order'             => 'desc',
          'posts_per_page'    => 3,
          'post_status'       => 'publish',
          );

          // The Query
          $the_query = new WP_Query( $args );

          // The Loop
          if ( $the_query->have_posts() ) {
          echo '<ul class="no-bullets sidebar-list">';
          echo '<li><h5>Recent Articles</h5></li>';
          while ( $the_query->have_posts() ) {
          $the_query->the_post(); { ?> 

          <?php $thumb = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'thumbnail' ); $url = $thumb['0'];?>
          <li>
            <div class="article-img-container">
              <img src="<?=$url?>" class="img-responsive">
            </div>
            <div class="article-title-container">
              <a href="<?php the_permalink() ?>"><?php the_title(); ?></a>
            </div>
          </li>

          <?php }
          }
          echo '<li><a href="/blog">View Blog <i class="fa fa-arrow-circle-o-right"></i></a></li>';
          echo '</ul>';
          } else {
          // no posts found
          }
          /* Restore original Post Data */
          wp_reset_postdata(); ?>

        </div>
      </div>
    </div>
  </section>
  <section class="settings-bar">
    <div class="container">
      <div class="row">
        <div class="col-sm-12">
          <ul>
            <li>
              <label>Display settings</label>
              <?php echo do_shortcode('[facetwp per_page="true"]') ;?>
            </li>
            <li>
              <label>Showing</label>
              <?php echo do_shortcode('[facetwp counts="true"]') ;?>
            </li>
          </ul>
        </div>
      </div>
    </div>
  </section>
  <script>!function(n){n(function(){FWP.loading_handler=function(){}})}(jQuery);</script>


  <?php
  $content = ob_get_contents();
  ob_end_clean();
  return $content;
}
add_shortcode('newsroom-posts', 'newsroom_posts');