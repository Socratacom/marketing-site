<div class="two_third format_text">
    <h1 class="page-title" style="font-weight:600;"><?php single_cat_title(); ?></h1>
    <?php if (have_posts()) : ?>
    <?php
      $count = 0;
      while (have_posts()) : the_post(); 
      $count++;
      $third_div = ($count%3 == 0) ? 'last' : '';
      $third_div_clear = ($count%3 == 0) ? '<div class="clearboth"></div>' : '';
    ?>
  <div class="one_third <?php echo $third_div; ?>" style="margin-bottom:4%; line-height:normal;">
    <?php
// Must be inside a loop.

if ( has_post_thumbnail() ) {
  echo '<a href="';
  echo the_permalink();
  echo '">'; 
  echo '<img src="' . tuts_custom_img('full', 260, 180) . ' " style="width:100%;" />';
  echo '</a>';
  
}
else {
  echo '<a href="';
  echo the_permalink();
  echo '">'; 
  echo '<img src="' . get_bloginfo( 'stylesheet_directory' ) . '/custom/images/thumbnail-default.png" />';
  echo '</a>';
}
?>
    <small style="text-transform: uppercase; font-size: .7em;"><?php single_cat_title(); ?></small>
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



