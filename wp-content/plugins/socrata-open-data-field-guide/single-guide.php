<div class="container page-padding">
  <div class="row content">
    <div class="col-sm-8 col-md-9">      
      <h1><?php the_title(); ?></h1>
      <?php echo do_shortcode( '[marketo-share]' ); ?>
      <hr/>
      <?php the_content(); ?>
      <hr/>
       <div>
            <?php if( get_posts() ) {
            previous_post_link('<p><strong><small>NEXT CHAPTER:</small><br>%link</strong></p>');
            next_post_link('<p><strong><small>PREVIOUS CHAPTER:</small><br>%link</strong></p>');
            }?>
        </div>
    </div>
    <div class="col-sm-4 col-md-3 hidden-xs">
      <div class="chapters">
        <?php wp_nav_menu( array( 'theme_location' => 'field_guide' ) ); ?>
      </div>
      <?php echo do_shortcode('[newsletter-sidebar]'); ?> 
    </div>
  </div>
</div>
