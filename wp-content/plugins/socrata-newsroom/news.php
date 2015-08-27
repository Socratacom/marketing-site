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
        'name' => 'Socrata News',
        'singular_name' => 'Socrata News',
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
      'supports' => array( 'title', 'editor', 'author', 'thumbnail', 'excerpt', 'comments', 'revisions' ),
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
    'rewrite' => array('with_front' => false, 'slug' => 'newsroom-category')
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

// Display Post Type Query on main page
add_action('thesis_hook_custom_template', 'news_main_page');
function news_main_page(){
if (is_page('newsroom')) { ?>
<div class="two_third format_text">
    <?php
      $number_of_feature_posts = 1;
      $number_of_secondary_posts = 6;
      $how_many_secondary_posts_past = ($number_of_secondary_posts * ($paged - 1));
      $off = $number_of_feature_posts + (($paged > 1) ? $how_many_secondary_posts_past : 0);
    ?>
    <?php $feature_query = new WP_Query("post_type=news&posts_per_page=$number_of_feature_posts");
    while ($feature_query->have_posts()) : $feature_query->the_post(); ?>
    <div class="blog-feature-post">
      <a href="<?php the_permalink() ?>"><img src="<?php echo tuts_custom_img('full', 834, 344); ?>" style="width:100%;"></a>
      <div class="blog-feature-post-wrapper">
      <small style="text-transform: uppercase; font-size: .7em;"><?php $terms_as_text = get_the_term_list( $post->ID, 'news_category', '', ', ', '' ) ; echo strip_tags($terms_as_text, ''); ?></small>
      <h1><a href="<?php the_permalink() ?>"><?php the_title(); ?></a></h1>
      <div class="blog-feature-post-avatar">
        <?php echo get_avatar( get_the_author_meta('ID'), 50 ); ?>
        <p><strong>By</strong> <?php the_author(); ?><br><strong>Posted</strong> <?php the_time('F jS, Y') ?></p>
      </div>
    </div>
  </div>
<?php endwhile; ?>
<?php wp_reset_query(); ?>

<?php $guide_query = new WP_Query("post_type=news&posts_per_page=$number_of_secondary_posts&offset=$off&showposts=$number_of_secondary_posts"); 
    if (have_posts()) : 
    $count = 0;
    while ($guide_query->have_posts()) : $guide_query->the_post(); 
    $count++;
    $second_div = ($count%2 == 0) ? 'last' : '';
    $second_div_clear = ($count%2 == 0) ? '<div class="clearboth"></div>' : '';
  ?>
  <div class="one_half <?php echo $second_div; ?>" style="line-height: normal;">
    <a href="<?php the_permalink() ?>"><img src="<?php echo tuts_custom_img('full', 410, 300); ?>" style="width:100%;"></a>
    <small style="text-transform: uppercase; font-size: .7em;"><?php $terms_as_text = get_the_term_list( $post->ID, 'news_category', '', ', ', '' ) ; echo strip_tags($terms_as_text, ''); ?></small>
    <h4><a href="<?php the_permalink() ?>"><?php the_title(); ?></a><h4>
      <p><small><strong>By</strong> <?php the_author(); ?> &bull; <strong>Posted</strong> <?php the_time('F jS, Y') ?></small></p>
  </div>
  <?php echo $second_div_clear; ?>
  <?php endwhile; ?>
  <?php endif; ?>
  <?php wp_reset_postdata(); ?>
  <div class="center" style="padding:4% 0;"><a href="/newsroom/press-releases/" class="button">View Press Releases</a> <a href="/newsroom/socrata-in-the-media/" class="button">View Socrata in the Media</a></div>
</div>
  <!-- Right Column -->
  <div class="blog_one_third last format_text blog-right-column">
    <div class="blog-right-column-wrapper">
      <?php echo do_shortcode('[newsletter-sidebar]'); ?> 
      <?php $blog_query = new WP_Query('post_type=post&orderby=desc&showposts=2'); 
        if (have_posts()) : while ($blog_query->have_posts()) : $blog_query->the_post();
      ?>
      <div class="sidebar-post">    
        <a href="<?php the_permalink() ?>"><img src="<?php echo tuts_custom_img('full', 300, 100);?>" style="width:100%;" /></a>
        <p><small>Open Data Blog</small><a href="<?php the_permalink() ?>"><?php the_title(); ?></a></p>
      </div>
      <?php endwhile; ?>
      <?php endif; ?>
      <?php wp_reset_postdata(); ?><?php $blog_query = new WP_Query('post_type=tech_blog&orderby=desc&showposts=2'); 
        if (have_posts()) : while ($blog_query->have_posts()) : $blog_query->the_post();
      ?>
      <div class="sidebar-post">    
        <a href="<?php the_permalink() ?>"><img src="<?php echo tuts_custom_img('full', 300, 100);?>" style="width:100%;" /></a>
        <p><small>Tech Blog</small><a href="<?php the_permalink() ?>"><?php the_title(); ?></a></p>
      </div>
      <?php endwhile; ?>
      <?php endif; ?>
      <?php wp_reset_postdata(); ?>
    </div>  
  </div>
  <div class="clearboth"></div>
<?php }
}

