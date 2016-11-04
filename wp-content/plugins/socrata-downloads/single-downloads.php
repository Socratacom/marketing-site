<?php
$content = rwmb_meta( 'downloads_wysiwyg' );
$description = rwmb_meta( 'downloads_asset_description' );
$link = rwmb_meta( 'downloads_link' );
$thumb = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'feature-image' ); 
$cover = rwmb_meta( 'downloads_asset_image', 'size=medium' );
$gated = rwmb_meta( 'downloads_gated' );
$asset_url = rwmb_meta( 'downloads_asset' );
$url = $thumb['0'];
$marketo = rwmb_meta( 'downloads_marketo_form' );
?>
<section class="background-light-grey-4 masthead">
  <div class="text">
    <div class="container">
      <div class="row">
        <div class="col-sm-12">
          <p class="text-reverse text-uppercase font-semi-bold margin-bottom-5" ><small class="background-primary-alt-2" style="padding:3px 10px;"><?php downloads_the_categories(); ?></small></p>
          <h1 class="text-reverse margin-bottom-0"><?php the_title(); ?></h1>  
        </div>
      </div>    
    </div>
  </div>
  <div class="img img-background" style="background-image:url(<?php echo $url;?>);"></div>
</section>
<section class="cta-bar">
  <div class="container">
    <ul>
      <li class="social-sharing-mini"><?php echo do_shortcode("[marketo-share]");?></li>
    </ul>
  </div>
</section>
<section class="section-padding">
  <div class="container">
    <div class="row">
      
      <?php if ( ! empty( $cover) ) { ?>
        <div class="col-md-3 col-lg-3 text-center hidden-xs hidden-sm">
          <img src="<?php foreach ( $cover as $image ) { echo $image['url']; } ?>" class="img-responsive" style="box-shadow: 0px 0px 15px #ccc">
        </div>
        <div class="col-sm-7 col-md-5 col-lg-6 margin-bottom-60">
      <?php } else { ?>
        <div class="col-sm-7 col-md-6 col-md-offset-1 col-lg-5 col-lg-offset-2 margin-bottom-60">
      <?php } ?> 
        <?php if ( ! empty( $content) ) { ?> <?php echo $content;?> <?php } else { ?> <?php echo $description;?> <?php } ?>        
      </div>
      <div class="col-sm-5 col-md-4 col-lg-3">
        <?php if ( ! empty( $gated ) ) { ?>
          <?php if ( ! empty( $marketo ) ) { ?>
            <div class="marketo-form-labels padding-30 background-light-grey-4">    
              <form id="mktoForm_<?php echo $marketo;?>"></form>
              <script>MktoForms2.loadForm("//app-abk.marketo.com", "851-SII-641", '<?php echo $marketo;?>');</script>
            </div>
          <?php } else { ?>
            <a href="<?php foreach ( $asset_url as $asset ) { echo $asset['url']; } ?>" target="_blank" class="btn btn-primary btn-lg btn-block">Download</a>
          <?php } ?>   
        <?php } elseif ( ! empty( $link ) ) { ?>
          <a href="<?php echo $link;?>" class="btn btn-primary btn-lg btn-block">View</a>
        <?php } else { ?> 
          <a href="<?php foreach ( $asset_url as $asset ) { echo $asset['url']; } ?>" target="_blank" class="btn btn-primary btn-lg btn-block">Download</a>
        <?php } ?>
      </div>
    </div>
  </div>
</section>