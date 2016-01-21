<section class="section-padding">
  <div class="container">
    <div class="row">
      <div class="col-sm-12 col-md-7 col-md-offset-1">
        <?php the_content(); ?>
        <hr/>
        <div><?php next_post_link( '%link', 'PREVIOUS CHAPTER: %title', TRUE, '', 'guide_category' ); ?></div>
        <div><?php previous_post_link( '%link', 'NEXT CHAPTER: %title', TRUE, '', 'guide_category' ); ?></div>
        <!--<?php if( get_posts() ) {
        previous_post_link('<p><strong><small>NEXT CHAPTER:</small><br>%link</strong></p>');
        next_post_link('<p><strong><small>PREVIOUS CHAPTER:</small><br>%link</strong></p>');
        }?>-->
      </div>
      <div class="col-md-3 hidden-sm hidden-xs">
        <div class="category-nav">
          <h5 class="background-wet-asphalt" >Guide Chapters</h5>
          <?php wp_nav_menu( array( 'theme_location' => 'field_guide' ) ); ?>
        </div>
        <?php echo do_shortcode('[newsletter-sidebar]'); ?> 
      </div>
    </div>
  </div>
</section>