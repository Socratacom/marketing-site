<?php

// Blog All Articles Page
add_action('thesis_hook_custom_template', 'blog_all_articles');
function blog_all_articles() {
  if (is_home()) { ?>
  <div class="two_third format_text">
    <h1 class="page-title" style="font-weight:600;">All Articles</h1>
  <?php    
      $page = (get_query_var('paged')) ? get_query_var('paged') : 1;
       query_posts(array(
        'order' => 'desc',
        'posts_per_page' => 12, 
        'paged' => $page
      ));
    ?>
    <?php if (have_posts()) : ?>
    <?php
      $count = 0;
      while (have_posts()) : the_post(); 
      $count++;
      $third_div = ($count%3 == 0) ? 'last' : '';
      $third_div_clear = ($count%3 == 0) ? '<div class="clearboth"></div>' : '';
    ?>
  <div class="one_third <?php echo $third_div; ?>" style="margin-bottom:4%; line-height:normal;">
    <a href="<?php the_permalink() ?>"><img src="<?php echo tuts_custom_img('full', 260, 180); ?>" style="width:100%;"></a>
    <h4><a href="<?php the_permalink() ?>"><?php the_title(); ?></a><h4>
    <p><small><strong>By</strong> <?php the_author(); ?> &bull; <strong>Posted</strong> <?php the_time('F jS, Y') ?></small></p>
  </div>
  <?php echo $third_div_clear; ?>
  <?php endwhile; ?>
  <?php endif; ?>
  <?php wp_reset_query(); ?>
  <?php if (function_exists("pagination")) {pagination($additional_loop->max_num_pages);} ?>
  </div>
  <!-- Right Column -->
  <div class="blog_one_third last format_text blog-right-column">
    <div class="blog-right-column-wrapper">
      <?php echo do_shortcode('[newsletter-sidebar]'); ?> 
      <?php $blog_query = new WP_Query('post_type=tech_blog&orderby=desc&showposts=2'); 
        if (have_posts()) : while ($blog_query->have_posts()) : $blog_query->the_post();
      ?>
      <div class="sidebar-post">    
        <a href="<?php the_permalink() ?>"><img src="<?php echo tuts_custom_img('full', 300, 100);?>" style="width:100%;" /></a>
        <p><small>Tech Blog</small><a href="<?php the_permalink() ?>"><?php the_title(); ?></a></p>
      </div>
      <?php endwhile; ?>
      <?php endif; ?>
      <?php wp_reset_postdata(); ?>
      <?php $blog_query = new WP_Query('post_type=news&orderby=desc&showposts=2'); 
        if (have_posts()) : while ($blog_query->have_posts()) : $blog_query->the_post();
      ?>
      <div class="sidebar-post">    
        <a href="<?php the_permalink() ?>"><img src="<?php echo tuts_custom_img('full', 300, 100);?>" style="width:100%;" /></a>
        <p><small>Press Releases</small><a href="<?php the_permalink() ?>"><?php the_title(); ?></a></p>
      </div>
      <?php endwhile; ?>
      <?php endif; ?>
      <?php wp_reset_postdata(); ?>
    </div>  
  </div>
  <div class="clearboth"></div>

  <?php }
}

// Blog Page
add_action('thesis_hook_custom_template', 'blog_page');
function blog_page() {
  if (is_page('blog')) { ?>
  <div class="two_third format_text">
    <?php
      $number_of_feature_posts = 1;
      $number_of_secondary_posts = 6;
      $how_many_secondary_posts_past = ($number_of_secondary_posts * ($paged - 1));
      $off = $number_of_feature_posts + (($paged > 1) ? $how_many_secondary_posts_past : 0);
    ?>
    <?php $feature_query = new WP_Query("posts_per_page=$number_of_feature_posts");
    while ($feature_query->have_posts()) : $feature_query->the_post(); ?>
    <div class="blog-feature-post">
      <a href="<?php the_permalink() ?>"><img src="<?php echo tuts_custom_img('full', 834, 344); ?>" style="width:100%;"></a>
      <div class="blog-feature-post-wrapper">
      <h1><a href="<?php the_permalink() ?>"><?php the_title(); ?></a></h1>
      <div class="blog-feature-post-avatar">
        <?php echo get_avatar( get_the_author_meta('ID'), 50 ); ?>
        <p><strong>By</strong> <?php the_author(); ?><br><strong>Posted</strong> <?php the_time('F jS, Y') ?></p>
      </div>
    </div>
  </div>
<?php endwhile; ?>
<?php wp_reset_postdata(); ?>

<?php $guide_query = new WP_Query("posts_per_page=$number_of_secondary_posts&offset=$off&showposts=$number_of_secondary_posts"); 
    if (have_posts()) : 
    $count = 0;
    while ($guide_query->have_posts()) : $guide_query->the_post(); 
    $count++;
    $second_div = ($count%2 == 0) ? 'last' : '';
    $second_div_clear = ($count%2 == 0) ? '<div class="clearboth"></div>' : '';
  ?>
  <div class="one_half <?php echo $second_div; ?>" style="line-height: normal;">
    <a href="<?php the_permalink() ?>"><img src="<?php echo tuts_custom_img('full', 410, 300); ?>" style="width:100%;"></a>
    <h4><a href="<?php the_permalink() ?>"><?php the_title(); ?></a><h4>
      <p><small><strong>By</strong> <?php the_author(); ?> &bull; <strong>Posted</strong> <?php the_time('F jS, Y') ?></small></p>
  </div>
  <?php echo $second_div_clear; ?>
  <?php endwhile; ?>
  <?php endif; ?>
  <?php wp_reset_postdata(); ?>
  <div class="center" style="padding:4% 0;"><a href="/all-articles/" class="button">View All Articles</a></div>
</div>
  <!-- Right Column -->
  <div class="blog_one_third last format_text blog-right-column">
    <div class="blog-right-column-wrapper">
      <?php echo do_shortcode('[newsletter-sidebar]'); ?> 
      <?php $blog_query = new WP_Query('post_type=tech_blog&orderby=desc&showposts=2'); 
        if (have_posts()) : while ($blog_query->have_posts()) : $blog_query->the_post();
      ?>
      <div class="sidebar-post">    
        <a href="<?php the_permalink() ?>"><img src="<?php echo tuts_custom_img('full', 300, 100);?>" style="width:100%;" /></a>
        <p><small>Tech Blog</small><a href="<?php the_permalink() ?>"><?php the_title(); ?></a></p>
      </div>
      <?php endwhile; ?>
      <?php endif; ?>
      <?php wp_reset_postdata(); ?>
      <?php $blog_query = new WP_Query('post_type=news&orderby=desc&showposts=2'); 
        if (have_posts()) : while ($blog_query->have_posts()) : $blog_query->the_post();
      ?>
      <div class="sidebar-post">    
        <a href="<?php the_permalink() ?>"><img src="<?php echo tuts_custom_img('full', 300, 100);?>" style="width:100%;" /></a>
        <p><small>Press Releases</small><a href="<?php the_permalink() ?>"><?php the_title(); ?></a></p>
      </div>
      <?php endwhile; ?>
      <?php endif; ?>
      <?php wp_reset_postdata(); ?>
    </div>  
  </div>
  <div class="clearboth"></div>
  <?php }
}


/**
 * Change the post menu to article
 */
function change_post_menu_text() {
  global $menu;
  global $submenu;

  // Change menu item
  $menu[5][0] = 'Articles';

  // Change post submenu
  $submenu['edit.php'][5][0] = 'Articles';
  $submenu['edit.php'][10][0] = 'Add Articles';
  $submenu['edit.php'][16][0] = 'Articles Tags';
}

add_action( 'admin_menu', 'change_post_menu_text' );

/*** Change the post type labels */
function change_post_type_labels() {
  global $wp_post_types;

  // Get the post labels
  $postLabels = $wp_post_types['post']->labels;
  $postLabels->name = 'Articles';
  $postLabels->singular_name = 'Articles';
  $postLabels->add_new = 'Add Articles';
  $postLabels->add_new_item = 'Add Articles';
  $postLabels->edit_item = 'Edit Articles';
  $postLabels->new_item = 'Articles';
  $postLabels->view_item = 'View Articles';
  $postLabels->search_items = 'Search Articles';
  $postLabels->not_found = 'No Articles found';
  $postLabels->not_found_in_trash = 'No Articles found in Trash';
}
add_action( 'init', 'change_post_type_labels' );

/**
 * Change the pages labels
 */
function change_pages_labels() {
  global $wp_post_types;

  // Get the post labels
  $pageLabels = $wp_post_types['page']->labels;
}
add_action( 'init', 'change_pages_labels' );


