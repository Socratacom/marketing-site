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
  <section class="section-padding background-light-grey-4">
    <div class="container">
      <div class="row margin-bottom-30">
        <div class="col-sm-3">
          <button onclick="FWP.reset()" class="btn btn-default btn-block">Reset Filters</button>          
        </div>
        <div class="col-sm-9">
          <?php echo do_shortcode('[facetwp counts="true"]') ;?>
          <?php echo do_shortcode('[facetwp per_page="true"]') ;?>
          <?php echo do_shortcode('[facetwp sort="true"]') ;?>          
        </div>
      </div>
      <div class="row">
        <div class="col-sm-3">          
          <button type="button" data-toggle="collapse" data-target="#type">Content Type</button>
          <div id="type" class="collapse in">
            <?php echo do_shortcode('[facetwp facet="post_types"]') ;?>
          </div>
          <button type="button" data-toggle="collapse" data-target="#segment">Segment</button>
          <div id="segment" class="collapse in">
            <?php echo do_shortcode('[facetwp facet="segment"]') ;?>
          </div>
          <button type="button" data-toggle="collapse" data-target="#product">Product</button>
          <div id="product" class="collapse in">
            <?php echo do_shortcode('[facetwp facet="products"]') ;?>
          </div>              
        </div>
        <div class="col-sm-9">          
          <?php echo do_shortcode('[facetwp template="content_discovery_tool"]') ;?>
        </div>
      </div>
    </div>
  </section>

  <?php
  $content = ob_get_contents();
  ob_end_clean();
  return $content;
}
add_shortcode('content-discovery', 'content_discovery_list');