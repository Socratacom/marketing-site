<div class="feature-image hidden-xs" style="background-image: url(<?php echo Roots\Sage\Extras\custom_feature_image('full', 1600, 400); ?>);">
  <div class="pattern-overlay"></div>
  <?php echo do_shortcode('[image-attribution]'); ?>
</div>
<div class="container">
  <div class="row">
    <div class="col-sm-8 col-md-7 col-md-offset-1 article-content">
      <div class="wrapper">
        <?php while (have_posts()) : the_post(); ?>
          <article <?php post_class(); ?>>
            <small class="category-name"><?php Roots\Sage\Extras\blog_the_categories(); ?></small>
            <h1 class="entry-title"><?php the_title(); ?></h1>
            <?php get_template_part('templates/entry-meta'); ?>
            <div class="entry-content">
              <?php the_content(); ?>
            </div>
            <hr/>
            <div>
              <?php if( get_posts() ) {
              previous_post_link('<p><strong><small>NEXT POST:</small><br>%link</strong></p>');
              next_post_link('<p><strong><small>PREVIOUS POST:</small><br>%link</strong></p>');
              }?>
            </div>
            <hr/>
            <!-- Begin Outbrain -->
            <!--<div class="OUTBRAIN" data-widget-id="NA"></div> 
            <script type="text/javascript" async="async" src="http://widgets.outbrain.com/outbrain.js"></script>-->
            <?php comments_template('/templates/comments.php'); ?>
          </article>
          <?php endwhile; ?>
          <div class="marketo-share">
            <?php echo do_shortcode( '[marketo-share]' ); ?>
          </div>        
      </div>
    </div>
    <div class="col-sm-4 col-md-3 sidebar hidden-xs">
      <?php echo do_shortcode('[newsletter-sidebar]'); ?>
    </div>
  </div>
</div>