<?php
// Social Links
function social_links() {
    return '<!-- AddThis Button BEGIN -->
    <div class="addthis_toolbox addthis_counter_style social-links">
    <ul>
      <li style="margin-right:10px;"><a class="addthis_button_facebook_like" fb:like:layout="box_count"></a></li>
      <li><a class="addthis_button_tweet" tw:count="vertical"></a></li>
      <li><a class="addthis_button_google_plusone" g:plusone:size="tall"></a></li>
      <li><a class="addthis_counter"></a></li>
    </ul>
    </div>
    <script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js#pubid=ra-4e590fc12e22e79e"></script>
    <!-- AddThis Button END -->';
}
add_shortcode('social links', 'social_links');

//SOCIAL LINKS TWO
function share_this() {
  wp_enqueue_script( 'addthisfire' ); 
  return '<!-- AddThis Button BEGIN -->
<div class="addthis_toolbox addthis_default_style ">
<a class="addthis_button_facebook_like" fb:like:layout="button_count"></a>
<a class="addthis_button_tweet"></a>
<a class="addthis_button_pinterest_pinit" pi:pinit:layout="horizontal"></a>
<a class="addthis_counter addthis_pill_style"></a>
</div>
<script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js#pubid=ra-4e590fc12e22e79e#async=1"></script>
<!-- AddThis Button END -->';
}
add_shortcode('share this', 'share_this');

// Marketo Sharing
function marketo_share() {
  return '<div class="cf_widgetLoader cf_w_e136d060830c4c6c86672c9eb0182397"></div><script type="text/javascript" src="//b2c-msm.marketo.com/jsloader/54782eb9-758c-41a0-baac-4a7ead980cba/loader.php.js"></script>';
}
add_shortcode('marketo-share', 'marketo_share');