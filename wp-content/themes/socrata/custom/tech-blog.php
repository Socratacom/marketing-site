<div class="feature-image" style="background-image: url(<?php echo tuts_custom_img('full', 1600, 400); ?>);"></div>
<?php
  $meta = get_tech_meta(); 
  if ($meta[1]) {
    echo "<div class='image-attribution'>Photo: <a href='$meta[1]' target='_blank'>$meta[0]</a></div>";
  } elseif ($meta[0]) {
    echo "<div class='image-attribution'>Photo: $meta[0]</div>";
  } 
?>
<div class="blog-content-wrapper">
  <!-- Left Column -->
  <div class="blog_one_sixth format_text">
    <div class="blog-avatar">
      <?php echo get_avatar( get_the_author_meta('ID'), 80 ); ?>
      <div class="blog-author"><strong>By</strong> <?php the_author(); ?></div>    
    </div>
  </div>
  <!-- Center Column -->
  <div class="blog_one_half blog-content">
    <div class="blog-title format_text">
      <!-- AddThis Button BEGIN -->
      <div class="addthis_toolbox addthis_32x32_style" style="float:right; margin-left:30px;">
        <a class="addthis_button_facebook"></a>
        <a class="addthis_button_twitter"></a>
        <a class="addthis_button_google_plusone_share"></a>
        <a class="addthis_button_compact"></a>
      </div>
      <script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js#pubid=ra-4e590fc12e22e79e"></script>
      <!-- AddThis Button END -->
      <h1><?php the_title(); ?></h1>
      <div class="blog-date"><strong>Posted</strong> <?php the_time('F jS, Y') ?></div>
    </div>
    <?php thesis_content_column(); ?>
    <hr/>
    <div class="format_text" style="line-height: normal;">
      <?php if( 'tech_blog' == get_post_type() ) {      
      previous_post_link('<p><strong><small>NEXT POST:</small><br>%link</strong></p>');
      next_post_link('<p><strong><small>PREVIOUS POST:</small><br>%link</strong></p>');
      }?>
    </div>
    <hr/>
    <?php comments_template(); ?>
  </div>
  <!-- Right Column -->
  <div class="blog_one_third last format_text blog-right-column">
    <div class="blog-right-column-wrapper">
      <ul style="list-style-type: none; margin:0;"><?php thesis_default_widget('shared'); ?></ul>
      <?php $blog_query = new WP_Query('post_type=post&orderby=desc&showposts=2'); 
        if (have_posts()) : while ($blog_query->have_posts()) : $blog_query->the_post();
      ?>
      <div class="sidebar-post">    
        <a href="<?php the_permalink() ?>"><img src="<?php echo tuts_custom_img('full', 300, 100);?>" style="width:100%;" /></a>
        <p><small>Open Data Blog</small><a href="<?php the_permalink() ?>"><?php the_title(); ?></a></p>
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
</div>