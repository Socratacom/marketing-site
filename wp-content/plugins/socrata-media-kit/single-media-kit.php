<?php 
  $thumb = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'post-image' );
  $url = $thumb['0'];
  $img_id = get_post_thumbnail_id(get_the_ID());
  $alt_text = get_post_meta($img_id , '_wp_attachment_image_alt', true);
  $quote = rwmb_meta( 'case_study_quote' );
  $name = rwmb_meta( 'case_study_name' );
  $title = rwmb_meta( 'case_study_title' );
  $customer = rwmb_meta( 'case_study_customer' );
  $site_name = rwmb_meta( 'case_study_site_name' );
  $site = rwmb_meta( 'case_study_url' );
  $highlight = rwmb_meta( 'case_study_highlight' );
  $headshot = rwmb_meta( 'case_study_headshot', 'size=thumbnail' );
  $content = rwmb_meta( 'case_study_wysiwyg' );
?>
<section class="section-padding">
  <div class="container">
    <div class="row">
      <div class="col-sm-12">
        <h1 class="font-light text-center"><?php the_title(); ?></h1>
        <p class="lead margin-bottom-60 text-center">Donec ullamcorper nulla non metus auctor fringilla. Donec sed odio dui.</p>
      </div>


<ul class="nav nav-tabs responsive-tabs">
  <li class="active"><a data-toggle="tab" href="#home">Coverage</a></li>
  <li><a data-toggle="tab" href="#menu1">About Socrata</a></li>
  <li><a data-toggle="tab" href="#menu2">Digital Assets</a></li>
  <li><a data-toggle="tab" href="#menu3">Socrata Connect</a></li>
</ul>

<div class="tab-content">
  <div id="home" class="tab-pane active">
    <h3>HOME</h3>
    <p>Some content.</p>
  </div>
  <div id="menu1" class="tab-pane">
    <h3>Menu 1</h3>
    <p>Vestibulum id ligula porta felis euismod semper. Maecenas sed diam eget risus varius blandit sit amet non magna. Sed posuere consectetur est at lobortis. Donec ullamcorper nulla non metus auctor fringilla. Donec id elit non mi porta gravida at eget metus.</p>
  </div>
  <div id="menu2" class="tab-pane">
    <h3>Menu 2</h3>
    <p>Some content in menu 2.</p>
  </div>
  <div id="menu3" class="tab-pane">
    <h3>Menu 2</h3>
    <p>Some content in menu 3.</p>
  </div>
</div>






    </div>
  </div>
</section>
<style>html[style] {margin-top:0 !important;}</style>
<script>
$(document).ready(function(){
$('.responsive-tabs').responsiveTabs({
  accordionOn: ['xs', 'sm'] // xs, sm, md, lg
});
});
</script>