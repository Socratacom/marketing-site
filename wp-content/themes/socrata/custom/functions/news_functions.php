<?php

// Post Type
add_action( 'init', 'news_post_type' );
function news_post_type() {
  $labels = array(
    'name' => _x('Newsroom', 'post type general name'),
    'singular_name' => _x('News', 'post type singular name'),
    'add_new' => _x('Add New Article', 'News'),
    'add_new_item' => __('Add New Article'),
    'edit_item' => __('Edit Article'),
    'new_item' => __('New Article'),
    'all_items' => __('All Articles'),
    'view_item' => __('View Article'),
    'search_items' => __('Search Newsroom'),
    'not_found' =>  __('No articles found'),
    'not_found_in_trash' => __('No articles found in Trash'), 
    'parent_item_colon' => '',
    'menu_name' => 'Newsroom'

  );
  $args = array(
    'labels' => $labels,
    'public' => true,
    'publicly_queryable' => true,
    'show_ui' => true, 
    'show_in_menu' => true, 
    'query_var' => true,
    'rewrite' => array('with_front' => false, 'slug' => 'newsroom-article'),
    'capability_type' => 'post',
    'has_archive' => true, 
    'hierarchical' => false,
    'menu_icon' => get_stylesheet_directory_uri() .'/custom/images/icons/menu-socrata.png', // 16px16
    'menu_position' => 5,
    'supports' => array( 'title', 'editor', 'author', 'thumbnail', 'excerpt', 'comments', 'revisions' )
  ); 
  register_post_type('news', $args);
}

// Messages
add_filter( 'post_updated_messages', 'codex_news_updated_messages' );
function codex_news_updated_messages( $messages ) {
  global $post, $post_ID;

  $messages['news'] = array(
    0 => '', // Unused. Messages start at index 1.
    1 => sprintf( __('Newsroom updated. <a href="%s">View article</a>'), esc_url( get_permalink($post_ID) ) ),
    2 => __('Custom field updated.'),
    3 => __('Custom field deleted.'),
    4 => __('Newsroom updated.'),
    /* translators: %s: date and time of the revision */
    5 => isset($_GET['revision']) ? sprintf( __('Article restored to revision from %s'), wp_post_revision_title( (int) $_GET['revision'], false ) ) : false,
    6 => sprintf( __('Article published. <a href="%s">View article</a>'), esc_url( get_permalink($post_ID) ) ),
    7 => __('Article saved.'),
    8 => sprintf( __('Article submitted. <a target="_blank" href="%s">Preview article</a>'), esc_url( add_query_arg( 'preview', 'true', get_permalink($post_ID) ) ) ),
    9 => sprintf( __('Article scheduled for: <strong>%1$s</strong>. <a target="_blank" href="%2$s">Preview article</a>'),
      // translators: Publish box date format, see http://php.net/date
      date_i18n( __( 'M j, Y @ G:i' ), strtotime( $post->post_date ) ), esc_url( get_permalink($post_ID) ) ),
    10 => sprintf( __('Draft updated. <a target="_blank" href="%s">Preview article</a>'), esc_url( add_query_arg( 'preview', 'true', get_permalink($post_ID) ) ) ),
  );

  return $messages;
}

// Hook into the init action and call create_news_taxonomies when it fires
add_action( 'init', 'create_news_taxonomies', 0 );

// Create two taxonomies, "catagories" and "tags" for post type "news"
function create_news_taxonomies() 
{
  // Add new taxonomy, make it hierarchical (like categories)
  $labels = array(
    'name' => _x( 'Newsroom Categories', 'taxonomy general name' ),
    'singular_name' => _x( 'Newsroom Category', 'taxonomy singular name' ),
    'search_items' =>  __( 'Search Newsroom Categories' ),
    'all_items' => __( 'All Newsroom Categories' ),
    'parent_item' => __( 'Parent Category' ),
    'parent_item_colon' => __( 'Parent Category:' ),
    'edit_item' => __( 'Edit Category' ), 
    'update_item' => __( 'Update Category' ),
    'add_new_item' => __( 'Add New Category' ),
    'new_item_name' => __( 'New Category Name' ),
    'menu_name' => __( 'Newsroom Category' ),
  );  

  register_taxonomy('news_category',array('news'), array(
    'hierarchical' => true,
    'labels' => $labels,
    'show_ui' => true,
    'query_var' => true,
    'rewrite' => array('with_front' => false, 'slug' => 'newsroom'),
  ));
}


// Display Post Type Query on main page
add_action('thesis_hook_custom_template', 'news_main_page');
function news_main_page(){
if (is_page('newsroom')) { ?>
<div class="two_third format_text">
  <p>test</p>
</div>
<div class="one_third last format_text blog-right-column">
  <ul>
    <li><ul style="list-style-type: none; margin:0; padding: 0;"><?php thesis_default_widget('shared'); ?></ul></li>
    <li>
  <h3>From the Blog</h3>
  <?php $blog_query = new WP_Query('orderby=desc&showposts=6'); 
    if (have_posts()) : 
    $count = 0;
    while ($blog_query->have_posts()) : $blog_query->the_post(); 
    $count++;
    $third_div = ($count%3 == 0) ? 'last' : '';
    $third_div_clear = ($count%3 == 0) ? '<div class="clearboth"></div>' : '';
  ?>
  <div class="one_third <?php echo $third_div; ?>">
    <?php $thumb = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'thumbnail' ); $url = $thumb['0']; ?>
    <a href="<?php the_permalink() ?>"><img src="<?=$url?>" style="width:100%"></a>
    <p style="line-height: normal; font-size: .8em; font-weight:400;"><a href="<?php the_permalink() ?>"><?php the_title(); ?></a></p>
  </div>
  <?php echo $third_div_clear; ?>
  <?php endwhile; ?>
  <?php endif; ?>
  <?php wp_reset_query(); ?>
    </li>
  </ul>
</div>
<div class="clearboth"></div>
<?php }
}

// Body Classes for Styling 
add_filter('thesis_body_classes', 'news_styling');
function news_styling($classes) {
  if ('news' == get_post_type() && is_archive()) { 
    $classes[] = 'newsroom'; 
  }
  return $classes; 
}

register_sidebar(array(
  'name' => 'News Room Sidebar',
  'id' => 'newsroom',
  'before_title'=>'<h3>',
  'after_title'=>'</h3>'
  ));







