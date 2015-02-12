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

    <a href="<?php the_permalink() ?>"><img src="<?php echo tuts_custom_img('full', 260, 180); ?>" style="width:100%;"></a>
    <small style="text-transform: uppercase; font-size: .7em;"><?php single_cat_title(); ?></small>
    <h4><a href="<?php the_permalink() ?>"><?php the_title(); ?></a><h4>
    <p><small><strong>By</strong> <?php the_author(); ?> &bull; <strong>Posted</strong> <?php the_time('F jS, Y') ?></small></p>
  </div>
  <?php echo $third_div_clear; ?>
  <?php endwhile; ?>
  <?php endif; ?>
  <?php wp_reset_query(); ?>
  <?php if(function_exists('wp_pagenavi')) { wp_pagenavi(); } ?>  
  </div>

  <!-- Right Column -->
  <div class="blog_one_third last format_text blog-right-column">
    <div class="blog-right-column-wrapper">
      <ul><?php thesis_default_widget('shared'); ?></ul>
      <?php $blog_query = new WP_Query('post_type=tech_blog&orderby=desc&showposts=2'); 
        if (have_posts()) : while ($blog_query->have_posts()) : $blog_query->the_post();
      ?>
      <div class="sidebar-post">    
        <a href="<?php the_permalink() ?>"><img src="<?php echo tuts_custom_img('full', 300, 100);?>" style="width:100%;" /></a>
        <p><small>Tech Blog</small><a href="<?php the_permalink() ?>"><?php the_title(); ?></a></p>
      </div>
      <?php endwhile; ?>
      <?php endif; ?>
      <?php wp_reset_postdata(); ?><?php $blog_query = new WP_Query('post_type=news&orderby=desc&showposts=2'); 
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