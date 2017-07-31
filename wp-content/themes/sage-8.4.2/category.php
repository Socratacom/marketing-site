<section class="section-padding background-light-grey-5">
    <div class="container">
      <div class="row">
        <div class="col-sm-12">
          <h1 class="margin-bottom-60 font-light"><?php single_cat_title(); ?></h1>
        </div>
      </div>
      <div class="row hidden-lg">
        <div class="col-sm-12 margin-bottom-30">
          <div class="padding-15 background-light-grey-4">
            <ul class="filter-bar">
              <li><?php echo facetwp_display( 'facet', 'solution_dropdown' ); ?></li>
              <li><?php echo facetwp_display( 'facet', 'segment_dropdown' ); ?></li>
              <li><?php echo facetwp_display( 'facet', 'product_dropdown' ); ?></li>
              <li><button onclick="FWP.reset()" class="btn btn-primary"><i class="fa fa-undo" aria-hidden="true"></i> Reset</button></li>
            </ul>
          </div>          
        </div>
      </div>
      <div class="row">
        <div class="col-lg-3 hidden-xs hidden-sm hidden-md facet-sidebar">
          <button onclick="FWP.reset()" class="btn btn-primary btn-block margin-bottom-30"><i class="fa fa-undo" aria-hidden="true"></i> Reset Filters</button>
          <div class="filter-list">
            <button type="button" data-toggle="collapse" data-target="#solution">Solution</button>
            <div id="solution" class="collapse in"><?php echo facetwp_display( 'facet', 'solution' ); ?></div>
            <button type="button" data-toggle="collapse" data-target="#segment">Segment</button>
            <div id="segment" class="collapse in"><?php echo facetwp_display( 'facet', 'segment' ); ?></div>
            <button type="button" data-toggle="collapse" data-target="#product">Product</button>
            <div id="product" class="collapse in"><?php echo facetwp_display( 'facet', 'products' ); ?></div>
          </div>            
        </div>
        <div class="col-sm-12 col-lg-9">
          <div class="row">
            <div class="col-sm-12 margin-bottom-30">
              <ul class="list-table">
                <li><small>Showing: <?php echo do_shortcode('[facetwp counts="true"]') ;?></small></li>
                <li class="text-right"><?php echo do_shortcode('[facetwp sort="true"]') ;?></li>
              </ul>
            </div>
            <div class="facetwp-template">
            <?php if ( have_posts() ) : while ( have_posts() ) : the_post();
              $thumb = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'post-image-small' );
                $url = $thumb['0'];
            ?>

 <div class="col-sm-6 col-md-4">
      <div class="card margin-bottom-30 match-height">
        <div class="card-header">
          <?php if ( ! empty( $thumb ) ) { ?>
            <div class="sixteen-nine img-background" style="background-image:url(<?php echo $url;?>);"></div>
          <?php } else { ?>
            <div class="sixteen-nine img-background" style="background-image:url(/wp-content/uploads/no-image.png);"></div>
          <?php } ?>
        </div>
        <div class="card-body">
          <h5><?php the_title(); ?></h5>
          <p><?php echo (get_the_excerpt()); ?></p>
        </div>
        <div class="card-footer" style="padding:10px 20px;">
          <ul class="author">
            <li><?php  global $post; $author_id=$post->post_author; foreach( get_coauthors() as $coauthor ): echo get_avatar( $coauthor->user_email, '32' ); endforeach; ?></li>
            <li><?php if(function_exists('coauthors')) coauthors();?><br><?php the_time('F j, Y') ?></li>
          </ul>
        </div>
        <a href="<?php the_permalink(); ?>"></a>
      </div>
    </div>

 <?php endwhile; else : ?>

  <p><?php _e( 'Sorry, no posts matched your criteria.' ); ?></p>

 <?php endif; ?>
 </div>
            <div class="col-sm-12 margin-top-30">
              <ul class="list-table">
                <li><small>Showing: <?php echo do_shortcode('[facetwp counts="true"]') ;?></small></li>
                <li class="text-right"><?php echo do_shortcode('[facetwp per_page="true"]') ;?></li>
              </ul>
            </div>
          </div>
        </div>
      </div>
    </div>
</section>
<?php echo do_shortcode('[match-height]');?>
<script>!function(n){n(function(){FWP.loading_handler=function(){}})}(jQuery);</script>