<?php
/*
Plugin Name: Socrata Content Discovery Tool
Plugin URI: http://socrata.com
Description: This plugin adds the ability to search multiple post types for related content.
Version: 1.0
Author: Michael Church
Author URI: http://socrata.com/
License: GPLv2
*/

// Shortcode [events-map]
function content_discovery_list($atts, $content = null) {
  ob_start();
  ?>
    <section class="filter-bar hidden-sm hidden-md hidden-lg">
    <div class="container">
      <div class="row">
        <div class="col-sm-12">
          <ul>
            <li><?php echo do_shortcode('[facetwp facet="post_type_dropdown"]') ;?></li>
            <li><?php echo do_shortcode('[facetwp facet="segment_dropdown"]') ;?></li>
            <li><?php echo do_shortcode('[facetwp facet="product_dropdown"]') ;?></li>
            <li><button onclick="FWP.reset()" class="facetwp-reset">Reset</button></li>
          </ul>
        </div>
      </div>
    </div>
  </section>
  <section class="section-padding background-light-grey-5">
    <div class="container">
      <div class="row margin-bottom-30 results-bar">
        <div class="col-sm-4 col-md-3 hidden-xs">
          <button onclick="FWP.reset()" class="btn btn-default btn-block"><i class="fa fa-undo" aria-hidden="true"></i> Reset Filters</button>          
        </div>
        <div class="col-sm-8 col-md-9">
          <ul class="list-table">
            <li><small>Showing: <?php echo do_shortcode('[facetwp counts="true"]') ;?></small></li>
            <li class="text-right"><?php echo do_shortcode('[facetwp sort="true"]') ;?></li>
          </ul>        
        </div>
      </div>
      <div class="row">
        <div class="col-sm-4 col-md-3 hidden-xs facet-sidebar">
          <div class="filter-list">
            <button type="button" data-toggle="collapse" data-target="#type">Resource</button>
            <div id="type" class="collapse in"><?php echo do_shortcode('[facetwp facet="post_types"]') ;?></div>
            <button type="button" data-toggle="collapse" data-target="#segment">Segment</button>
            <div id="segment" class="collapse in"><?php echo do_shortcode('[facetwp facet="segment"]') ;?></div>
            <button type="button" data-toggle="collapse" data-target="#product">Product</button>
            <div id="product" class="collapse in"><?php echo do_shortcode('[facetwp facet="products"]') ;?></div>  
          </div>            
        </div>
        <div class="col-sm-8 col-md-9">          
          <?php echo do_shortcode('[facetwp template="content_discovery_tool"]') ;?>
        </div>
      </div>
      <div class="row display-settings-bar">
        <div class="col-sm-12">
          <ul class="list-table">
            <li><?php echo do_shortcode('[facetwp per_page="true"]') ;?></li>
            <li class="text-right"><small>Showing: <?php echo do_shortcode('[facetwp counts="true"]') ;?></small></li>
          </ul>          
        </div>
      </div>
    </div>
  </section>
  <script>!function(n){n(function(){FWP.loading_handler=function(){}})}(jQuery);</script>

  <?php
  $content = ob_get_contents();
  ob_end_clean();
  return $content;
}
add_shortcode('content-discovery', 'content_discovery_list');