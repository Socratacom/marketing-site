<div class="feature-image" style="background-image: url(<?php echo tuts_custom_img('full', 1600, 400); ?>);"></div>
<?php
  $meta = get_attribution_meta(); 
  if ($meta[1]) {
    echo "<div class='image-attribution'>Photo: <a href='$meta[1]' target='_blank'>$meta[0]</a></div>";
  } elseif ($meta[0]) {
    echo "<div class='image-attribution'>Photo: $meta[0]</div>";
  } 
?>
<div class="container blog-content-wrapper format_text">
  <div class="row">
    <div class="col-sm-7 col-sm-offset-1">
      <small class="category-name"><?php user_the_categories(); ?></small>
      <h1><?php the_title(); ?></h1>
      <div class="row byline">
        <div class="col-sm-8">
          <div><?php echo get_avatar( get_the_author_meta('ID'), 50 ); ?> By <?php the_author(); ?> | Posted: <?php the_time('F jS, Y') ?></div>
        </div>
        <div class="col-sm-4">
          <div class='cf_widgetLoader cf_w_e136d060830c4c6c86672c9eb0182397'></div>
          <script type="text/javascript" src="//b2c-msm.marketo.com/jsloader/54782eb9-758c-41a0-baac-4a7ead980cba/loader.php.js"></script>
        </div>      
      </div>
      <?php thesis_content_column(); ?>
      <hr/>
      <div>
        <?php if( get_posts() ) {
        previous_post_link('<p><strong><small>NEXT POST:</small><br>%link</strong></p>');
        next_post_link('<p><strong><small>PREVIOUS POST:</small><br>%link</strong></p>');
        }?>
      </div>
      <hr/>
      <!-- Begin Outbrain -->
      <div class="OUTBRAIN" data-widget-id="NA"></div> 
      <script type="text/javascript" async="async" src="http://widgets.outbrain.com/outbrain.js"></script>
      <?php comments_template(); ?>
    </div>
    <div class="col-sm-3">
      <ul style="list-style-type: none; margin:0;"><?php thesis_default_widget('shared'); ?></ul>
      <?php $blog_query = new WP_Query('post_type=tech_blog&orderby=desc&showposts=2'); 
        if (have_posts()) : while ($blog_query->have_posts()) : $blog_query->the_post();
      ?>
      <article class="sidebar-post">    
        <a href="<?php the_permalink() ?>"><img src="<?php echo tuts_custom_img('full', 300, 100);?>" style="width:100%;" /></a>
        <p><small>Tech Blog</small><a href="<?php the_permalink() ?>"><?php the_title(); ?></a></p>
      </article>
      <?php endwhile; ?>
      <?php endif; ?>
      <?php wp_reset_postdata(); ?><?php $blog_query = new WP_Query('post_type=news&orderby=desc&showposts=2'); 
        if (have_posts()) : while ($blog_query->have_posts()) : $blog_query->the_post();
      ?>
      <article class="sidebar-post">    
        <a href="<?php the_permalink() ?>"><img src="<?php echo tuts_custom_img('full', 300, 100);?>" style="width:100%;" /></a>
        <p><small>Press Releases</small><a href="<?php the_permalink() ?>"><?php the_title(); ?></a></p>
      </article>
      <?php endwhile; ?>
      <?php endif; ?>
      <?php wp_reset_postdata(); ?>
    </div>
  </div>
</div>