<div class="feature-image" style="background-image: url(<?php echo tuts_custom_img('full', 1600, 400); ?>);">
  <div class="pattern-overlay"></div>
</div>
<?php
  $meta = get_attribution_meta(); 
  if ($meta[1]) {
    echo "<div class='image-attribution'>Photo: <a href='$meta[1]' target='_blank'>$meta[0]</a></div>";
  } elseif ($meta[0]) {
    echo "<div class='image-attribution'>Photo: $meta[0]</div>";
  } 
?>
<div class="container blog-content-wrapper">
  <div class="row">
    <div class="col-sm-8 col-md-7 col-md-offset-1 article-content">
      <small class="category-name">Tech Blog</small>
      <h1><?php the_title(); ?></h1>
      <ul class="byline">
        <li><?php echo get_avatar( get_the_author_meta('ID'), 50 ); ?></li>
        <li>By <?php the_author(); ?>, </li>
        <li><?php the_time('F jS, Y') ?></li>
      </ul>
      <div class="marketo-share">
        <?php echo do_shortcode( '[marketo-share]' ); ?>
      </div>
      <?php thesis_content_column(); ?>
      <hr/>
      <div>
        <?php if( 'tech_blog' == get_post_type() ) {      
        previous_post_link('<p><strong><small>NEXT POST:</small><br>%link</strong></p>');
        next_post_link('<p><strong><small>PREVIOUS POST:</small><br>%link</strong></p>');
        }?>
      </div>
      <hr/>
      <?php comments_template(); ?>
    </div>
    <div class="col-sm-4 col-md-3">
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

</div>