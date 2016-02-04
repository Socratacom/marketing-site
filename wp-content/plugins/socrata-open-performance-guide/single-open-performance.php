<section class="section-padding hero-opg-single img-background" style="background-image:url(/wp-content/uploads/opg-hero.jpg);">
  <div class="container">
    <div class="row">
      <div class="col-sm-12 col-md-8 col-lg-6">
        <h1><?php the_title();?></h1>
        <?php echo do_shortcode('[marketo-share]');?>
      </div>
    </div>
  </div>
  <div class="bar"></div>
</section>
<?php the_content(); ?>
<section class="section-padding">
  <div class="container">
    <div class="row">
      <div class="col-sm-6">
        <div class="chapter-button">

<?php if(get_adjacent_post(false, '', true)) { }
            else { ?>
            <a href="/open-performance-guide">PREVIOUS: Open Performance Guide Intro</a>
            <?php
            } ; ?>

          <?php previous_post_link( '%link', 'PREVIOUS: %title', TRUE, '', 'socrata_opg_cat' ); ?>
        </div>
      </div>
      <div class="col-sm-6">
        <div class="chapter-button">          
          <?php next_post_link( '%link', 'NEXT: %title', TRUE, '', 'socrata_opg_cat' ); ?>
        </div>        
      </div>
    </div>
  </div>
</section>
<section class="background-clouds section-padding opg-footer">
    <div class="container">
      <div class="row">
        <div class="col-sm-4">
          <h4>Table of Contents</h4>
          <p>test</p>
        </div>
        <div class="col-sm-4">
          <h2>Request a Demo of Open Performance</h2>            
          <p>Interested in seeing how your Government performs? Send us your contact information to get started with a personalized demo and pricing.</p>
        </div>
        <div class="col-sm-4">
          <?php echo do_shortcode('[marketo-form id="2710"]');?>
        </div>
      </div>
    </div>
</section>
