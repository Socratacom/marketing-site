<?php
// Googl Remarketing
add_action('wp_head', 'marketing_somerville');
function marketing_somerville() {
  if(is_page('webinar-small-town-big-vision')) { ?>
  <script language="Javascript" src="http://discover.socrata.com/js/public/jquery-latest.min.js" type="text/javascript"></script><br />
  <script src="http://discover.socrata.com/js/public/jQueryString-2.0.2-Min.js" type="text/javascript" ></script><br />
  <script src="http://discover.socrata.com/js/public/jquery.cookie.js" type="text/javascript"></script><br />
  <script>
  // to set cookies.  Uses noConflict just in case
  var $jQ = jQuery.noConflict();</p>
  <p>  // grab the URL parameter (repeat for additional parameters)
  var paramvalue = $jQ.getQueryString({ ID: "utm_content" });
  var paramvalue1 = $jQ.getQueryString({ ID: "utm_term" });
  var paramvalue2 = $jQ.getQueryString({ ID: "utm_medium" });
  var paramvalue3 = $jQ.getQueryString({ ID: "utm_campaign" });
  var paramvalue4 = $jQ.getQueryString({ ID: "utm_source" });</p>
  <p>  // set the cookies via jquery. expire time is in days (repeat for additional cookies)
  $jQ.cookie("source", paramvalue, {expires: 1, domain: '.socrata.com'});
  $jQ.cookie("source1", paramvalue1, {expires: 1, domain: '.socrata.com'});
  $jQ.cookie("source2", paramvalue2, {expires: 1, domain: '.socrata.com'});
  $jQ.cookie("source3", paramvalue2, {expires: 1, domain: '.socrata.com'});
  $jQ.cookie("source4", paramvalue2, {expires: 1, domain: '.socrata.com'});
  </script>
<?php }
}