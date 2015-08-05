<div class="format_text">
  <div class="magazine-content">
    <div class="one_fourth left-rail">
      <img src="/wp-content/themes/socrata/custom/images/open-innovation-title.png" class="img-responsive">
      <h2><?php the_title(); ?></h2>
      <h3>In This Issue</h3>
      <ul class="highlights">  
        <?php $meta = get_socrata_magazine_meta(); if ($meta[0]) echo '<li><span class="ss-icon">check</span>'.$meta[0].'</li>'; ?>
        <?php $meta = get_socrata_magazine_meta(); if ($meta[1]) echo '<li><span class="ss-icon">check</span>'.$meta[1].'</li>'; ?>
        <?php $meta = get_socrata_magazine_meta(); if ($meta[2]) echo '<li><span class="ss-icon">check</span>'.$meta[2].'</li>'; ?>
        <?php $meta = get_socrata_magazine_meta(); if ($meta[3]) echo '<li><span class="ss-icon">check</span>'.$meta[3].'</li>'; ?>
        <?php $meta = get_socrata_magazine_meta(); if ($meta[4]) echo '<li><span class="ss-icon">check</span>'.$meta[4].'</li>'; ?>
        <?php $meta = get_socrata_magazine_meta(); if ($meta[5]) echo '<li><span class="ss-icon">check</span>'.$meta[5].'</li>'; ?>
      </ul>
    </div>
    <div class="one_half">
        <!-- AddThis Button BEGIN -->
        <div class="addthis_toolbox addthis_32x32_style addthis">
          <a class="addthis_button_facebook"></a>
          <a class="addthis_button_twitter"></a>
          <a class="addthis_button_google_plusone_share"></a>
          <a class="addthis_button_compact"></a>
        </div>
        <script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js#pubid=ra-4e590fc12e22e79e"></script>
        <!-- AddThis Button END --> 
      <div class="cover">      
        <img src="<?php echo tuts_custom_img('full', 600 ); ?>" class="img-responsive"> 
        <!-- START RIBBON -->
        <div class="ribbon ribbon-large ribbon-black">
          <div class="banner">
            <div class="text">Read This Issue</div>
          </div>
        </div>
        <!-- END RIBBON -->
        <?php $meta = get_socrata_magazine_meta(); if ($meta[6]) echo '<a href="'.$meta[6].'" target="_blank"></a>'; ?>

      </div>
    </div>
    <div class="one_fourth last">
      <div class="reg-form">
        <h3>Subscribe to Open Innovation</h2>
        <script src="//app-abk.marketo.com/js/forms2/js/forms2.js"></script>
        <form id="mktoForm_<?php $meta = get_socrata_magazine_meta(); if ($meta[7]) echo $meta[7]; ?>"></form>    
        <script>MktoForms2.loadForm("//app-abk.marketo.com", "851-SII-641", <?php $meta = get_socrata_magazine_meta(); if ($meta[7]) echo $meta[7]; ?>);</script>
        <script language="javascript" type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.0/jquery.min.js"></script>
        <script language="javascript" type="text/javascript">var sfjq$ = jQuery.noConflict(true);</script>
        <script language="javascript" type="text/javascript" src="http://d12ulf131zb0yj.cloudfront.net/SmartForms3-0/SmartForms.js"></script>
      </div>
    </div>
    <div class="clearboth"></div>
  </div>
  <hr/>
  <div class="additional-issues">
    <h3>Additional Issues</h3>
    <a href="/open-innovation-magazine">View All</a>
  </div>
  <?php $query = new WP_Query('post_type=oi_magazine&orderby=desc&showposts=1'); 
    if (have_posts()) : while ($query->have_posts()) : $query->the_post();
    ?>
  <div class="one_fourth issue-landing">
    <a href="<?php the_permalink() ?>"><img src="<?php echo tuts_custom_img('full', 282);?>" class="magazine-thumb img-responsive"></a>
    <h3><a href="<?php the_permalink() ?>"><?php the_title(); ?></a></h3>
    <p><strong>IN THIS ISSUE:</strong> <?php $meta = get_socrata_magazine_meta(); if ($meta[0]) {echo "$meta[0]";} ?><?php $meta = get_socrata_magazine_meta(); if ($meta[1]) {echo ", $meta[1]";} ?><?php $meta = get_socrata_magazine_meta(); if ($meta[2]) {echo ", $meta[2]";} ?><?php $meta = get_socrata_magazine_meta(); if ($meta[3]) {echo ", $meta[3]";} ?><?php $meta = get_socrata_magazine_meta(); if ($meta[4]) {echo ", $meta[4]";} ?><?php $meta = get_socrata_magazine_meta(); if ($meta[5]) {echo ", $meta[5]";} ?></p>
    <div class="ribbon ribbon-small ribbon-black">
      <div class="banner">
        <div class="text">Current Issue</div>
      </div>
    </div>
  </div>
  <?php endwhile; ?>
  <?php endif; ?>
  <?php wp_reset_postdata(); ?>
  <?php $query = new WP_Query('post_type=oi_magazine&orderby=desc&showposts=3&offset=-1'); 
    if (have_posts()) : $count = 0;
    while ($query->have_posts()) : $query->the_post();    
    $count++;
    $fourth_div = ($count%3 == 0) ? 'last' : '';
    $fourth_div_clear = ($count%3 == 0) ? '<div class="clearboth"></div>' : '';
  ?>
  <div class="one_fourth <?php echo $fourth_div; ?> issue-landing">
    <a href="<?php the_permalink() ?>"><img src="<?php echo tuts_custom_img('full', 282);?>" class="magazine-thumb img-responsive"></a>
    <h3><a href="<?php the_permalink() ?>"><?php the_title(); ?></a></h3>
    <p><strong>IN THIS ISSUE:</strong> <?php $meta = get_socrata_magazine_meta(); if ($meta[0]) {echo "$meta[0]";} ?><?php $meta = get_socrata_magazine_meta(); if ($meta[1]) {echo ", $meta[1]";} ?><?php $meta = get_socrata_magazine_meta(); if ($meta[2]) {echo ", $meta[2]";} ?><?php $meta = get_socrata_magazine_meta(); if ($meta[3]) {echo ", $meta[3]";} ?><?php $meta = get_socrata_magazine_meta(); if ($meta[4]) {echo ", $meta[4]";} ?><?php $meta = get_socrata_magazine_meta(); if ($meta[5]) {echo ", $meta[5]";} ?></p>
  </div>
  <?php echo $fourth_div_clear; ?>
  <?php endwhile; ?>
  <?php endif; ?>
  <?php wp_reset_postdata(); ?>
  <hr/>
  <?php echo do_shortcode('[cta-group category="open-innovation-magazine"]'); ?>
</div>