<div id="content">
  <div class="post_box top">
  <div class="format_text">
  <h1 class="headline">Open Innovation</h1>
  <h2 class="subhead">As innovators push the open data movement forward, Socrata features their stories, successes, advice, and ideas.</h2>
  <div class="two_third">
    <div class="one_sixth">
      <!-- AddThis Button BEGIN -->
    <div class="addthis_toolbox addthis_32x32_style">
      <a class="addthis_button_facebook"></a>
      <a class="addthis_button_twitter"></a>
      <a class="addthis_button_pinterest_share"></a>
      <a class="addthis_button_google_plusone_share"></a>
      <a class="addthis_button_compact"></a>
    </div>
    <script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js#pubid=ra-4e590fc12e22e79e"></script>
    <!-- AddThis Button END -->
    </div>
    <div class="five_sixth last">
    <div class="magazine-image">
      <div class="ribbon-wrapper-green"><div class="ribbon-green">CLICK TO READ</div></div>
      <a href="<?php $meta = get_magazine_meta(); if ($meta[0]) echo "$meta[0]"; ?>" target="_blank"></a>
      <img src="<?php echo tuts_custom_img('full', 650 );?>" style="width:100%;" />
    </div>
    <div class="issues">
      <h3>Recent Issues</h3>
      <?php echo do_shortcode('[oi-previous-issues]');?>
    </div>
    </div>
  </div>
  <div class="one_third last">
    <div class="magazine-features">
      <h3>In This Issue</h3>
      <ul>  
      <?php $meta = get_magazine_meta(); if ($meta[2]) echo '<li><span class="ss-icon">check</span>'.$meta[2].'</li>'; ?>
      <?php $meta = get_magazine_meta(); if ($meta[3]) echo '<li><span class="ss-icon">check</span>'.$meta[3].'</li>'; ?>
      <?php $meta = get_magazine_meta(); if ($meta[4]) echo '<li><span class="ss-icon">check</span>'.$meta[4].'</li>'; ?>
      <?php $meta = get_magazine_meta(); if ($meta[5]) echo '<li><span class="ss-icon">check</span>'.$meta[5].'</li>'; ?>
      <?php $meta = get_magazine_meta(); if ($meta[6]) echo '<li><span class="ss-icon">check</span>'.$meta[6].'</li>'; ?>
      <?php $meta = get_magazine_meta(); if ($meta[7]) echo '<li><span class="ss-icon">check</span>'.$meta[7].'</li>'; ?>
      </ul>
    </div>
    <div class="subscribe">
      <h3>Subscribe to Open Innovation</h3>
      <?php $meta = get_magazine_meta(); if ($meta[1]) echo do_shortcode('[smartforms id="'.$meta[1].'"]'); ?>
    </div>
  </div>
  <div class="clearboth"></div>
  <hr/>
  <?php echo do_shortcode('[cta-group category="open-innovation-magazine"]'); ?>
</div>
</div>
</div>