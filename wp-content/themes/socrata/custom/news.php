<?php

// Post Type
add_action( 'init', 'news_post_type' );
function news_post_type() {
  $labels = array(
    'name' => 'Socrata News',
    'singular_name' => 'Socrata News',
    'add_new' => 'Add New Article',
    'add_new_item' => 'Add New Article',
    'edit_item' => 'Edit Article',
    'new_item' => 'New Article',
    'all_items' => 'All Articles',
    'view_item' => 'View Article',
    'search_items' => 'Search Newsroom',
    'not_found' => 'No articles found',
    'not_found_in_trash' => 'No articles found in Trash', 
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
    'supports' => array( 'title', 'editor', 'author', 'thumbnail', 'excerpt', 'comments', 'revisions' ),
    'taxonomies' => array('news_category', 'post_tag')
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
      <ul><?php thesis_default_widget('shared'); ?></ul>
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


