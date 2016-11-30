<?php
  $content = rwmb_meta( 'downloads_wysiwyg' );
  $description = rwmb_meta( 'downloads_asset_description' );
  $link = rwmb_meta( 'downloads_link' );
  $thumb = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'post-image' );
  $url = $thumb['0'];
  $img_id = get_post_thumbnail_id(get_the_ID());
  $alt_text = get_post_meta($img_id , '_wp_attachment_image_alt', true);
  $cover = rwmb_meta( 'downloads_asset_image', 'size=medium' );
  $gated = rwmb_meta( 'downloads_gated' );
  $asset_url = rwmb_meta( 'downloads_asset' );
  $marketo = rwmb_meta( 'downloads_marketo_form' );
?>

<section class="section-padding">
  <div class="container">
    <div class="row">
      <div class="col-sm-8">
        <h1 class="margin-bottom-15"><?php the_title(); ?></h1>
        <div class="color-grey margin-bottom-15"><?php downloads_the_categories(); ?></div>
        <div class="margin-bottom-30"><?php echo do_shortcode('[addthis]');?></div>
        <div class="margin-bottom-30"><img src="<?php echo $url;?>" <?php if ( ! empty($alt_text) ) { ?> alt="<?php echo $alt_text;?>" <?php } ;?> class="img-responsive"><?php echo do_shortcode('[image-attribution]'); ?></div>
        <?php if ( ! empty( $content) ) { ?> <?php echo $content;?> <?php } else { ?> <?php echo $description;?> <?php } ?>
        
      </div>
      <div class="col-sm-4">
        <div class="margin-bottom-30 text-center hidden-xs">
          <img src="<?php foreach ( $cover as $image ) { echo $image['url']; } ?>" class="img-responsive" style="box-shadow: 0px 0px 15px #ccc">
        </div>
        <?php if ( ! empty( $gated ) ) { ?>
          <?php if ( ! empty( $marketo ) ) { ?>
            <div class="marketo-form-labels padding-30 background-light-grey-4">
              <h4 class="margin-bottom-15">Download <?php downloads_the_categories(); ?></h4>
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