<?php

add_action('wp_head', 'govstat_refresh', 1);
function govstat_refresh() {
  if (is_page('financial-transparency-webinar-montgomery-county-splash-page')) { ?>
  <meta http-equiv="refresh" content="30">
<?php
 }
}

//Live Page ------------//

//GovStat event page
add_action ('wp_head','govstat_event_page');
function govstat_event_page() {
  if (is_page(array('pioneering-government-transparency-open-data', 'employee-hackathon-saved-alameda-county-500000', 'three-building-blocks-performance-measurement', 'how-do-you-hackathon-open-austin', 'how-do-you-hackathon-gocode-colorado', 'organization-ready-performance-measurement','hard-copy-is-history','connected-performance-live','lessons-from-experts','use-311-data-to-make-better-decisions','how-to-comply-with-the-federal-open-data-policy','5-tips-for-getting-citizens-engaged-with-your-data','open-data-cx-creating-great-citizen-experience','open-data-action-leading-governments-measure-performance', 'use-socrata-open-data-connector-microsoft-office-365', 'financial-transparency-apps-government-expenditure-budget-management', 'socrata-open-budget-closer-look', 'financial-transparency-webinar-montgomery-county-finances', 'financial-transparency-trailblazers-new-york-city-boston'))) { ?>
  <meta name="viewport" content="width=device-width">
  <link rel="stylesheet" href="/wp-content/themes/socrata/custom/govstat_event/govstat-event-styles.css" type="text/css">
  <script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
  <script type='text/javascript'>var responsive=function(){$(".vidyard_player").find('span').css({width: '100%', height:$('.embed-container').innerHeight()+"px"});};$(document).ready(responsive);$(window).resize(responsive);</script>
<?php
 }
}

// Custom template
add_action('thesis_hook_custom_template', 'govstat_templates');
function govstat_templates() {
  if (is_page(array('pioneering-government-transparency-open-data', 'employee-hackathon-saved-alameda-county-500000','three-building-blocks-performance-measurement', 'how-do-you-hackathon-open-austin', 'how-do-you-hackathon-gocode-colorado', 'organization-ready-performance-measurement','hard-copy-is-history','connected-performance-live','lessons-from-experts','use-311-data-to-make-better-decisions','how-to-comply-with-the-federal-open-data-policy','5-tips-for-getting-citizens-engaged-with-your-data','open-data-cx-creating-great-citizen-experience','open-data-action-leading-governments-measure-performance', 'use-socrata-open-data-connector-microsoft-office-365', 'financial-transparency-apps-government-expenditure-budget-management', 'socrata-open-budget-closer-look', 'financial-transparency-webinar-montgomery-county-finances', 'financial-transparency-trailblazers-new-york-city-boston'))) require_once STYLESHEETPATH . '/custom/govstat_event/govstat-live.php'; 
} 

// Body Classes for Styling 
add_filter('thesis_body_classes', 'govstat_event_styling');
function govstat_event_styling($classes) {
  if (is_page(array('pioneering-government-transparency-open-data', 'employee-hackathon-saved-alameda-county-500000','three-building-blocks-performance-measurement', 'how-do-you-hackathon-open-austin', 'how-do-you-hackathon-gocode-colorado', 'organization-ready-performance-measurement','hard-copy-is-history','connected-performance-live','lessons-from-experts','use-311-data-to-make-better-decisions','how-to-comply-with-the-federal-open-data-policy','5-tips-for-getting-citizens-engaged-with-your-data','open-data-cx-creating-great-citizen-experience','open-data-action-leading-governments-measure-performance', 'use-socrata-open-data-connector-microsoft-office-365', 'financial-transparency-apps-government-expenditure-budget-management', 'socrata-open-budget-closer-look', 'financial-transparency-webinar-montgomery-county-finances', 'financial-transparency-trailblazers-new-york-city-boston'))) { 
    $classes[] = 'splash'; 
  }
  return $classes; 
}

add_action('thesis_hook_before_html', 'custom_govstat_header');
function custom_govstat_header() {
  if (is_page(array('pioneering-government-transparency-open-data', 'employee-hackathon-saved-alameda-county-500000','three-building-blocks-performance-measurement', 'how-do-you-hackathon-open-austin', 'how-do-you-hackathon-gocode-colorado', 'organization-ready-performance-measurement','hard-copy-is-history','connected-performance-live','lessons-from-experts','use-311-data-to-make-better-decisions','how-to-comply-with-the-federal-open-data-policy','5-tips-for-getting-citizens-engaged-with-your-data','open-data-cx-creating-great-citizen-experience','open-data-action-leading-governments-measure-performance', 'use-socrata-open-data-connector-microsoft-office-365', 'financial-transparency-apps-government-expenditure-budget-management', 'socrata-open-budget-closer-look', 'financial-transparency-webinar-montgomery-county-finances', 'financial-transparency-trailblazers-new-york-city-boston'))) { ?>
  <section id="govstat-header">
    <div class="wrapper format_text">
      <h1 class="headline"><?php the_title(); ?></h1>
    </div>
  </section>
  <?php
 }
}