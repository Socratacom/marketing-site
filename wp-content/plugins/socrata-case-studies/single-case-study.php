<?php 
$thumb = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'feature-image' );
$url = $thumb['0'];
$quote = rwmb_meta( 'case_study_quote' );
$name = rwmb_meta( 'case_study_name' );
$title = rwmb_meta( 'case_study_title' );
$customer = rwmb_meta( 'case_study_customer' );
$site_name = rwmb_meta( 'case_study_site_name' );
$site = rwmb_meta( 'case_study_url' );
$highlight = rwmb_meta( 'case_study_highlight' );
$headshot = rwmb_meta( 'case_study_headshot', 'size=thumbnail' );
?>
<section class="background-primary-light hidden-xs hidden-sm">
  <div class="container">
    <div class="row">
      <div class="col-sm-12">
        <ol class="breadcrumb">
          <li>RESOURCES</li>
          <li><a href="/resources">Resources Home</a></li>
          <li><a href="/case-studies">Case Studies</a></li>
          <li><?php the_title(); ?></li>
        </ol>
      </div>
    </div>
  </div>
</section>
<section class="hero img-background background-primary-alt-2-light overlay overlay-black" style="background-image: url(<?=$url?>);">
  <div class="outer">
    <div class="inner">
      <div class="container">
        <div class="row">
          <div class="col-sm-10 col-sm-offset-1">
            <h1 class="text-center text-reverse"><?php the_title(); ?></h1>
          </div>
        </div>
      </div>
    </div>
  </div>
<?php echo do_shortcode('[image-attribution]'); ?>
</section>
<section class="section-padding">
  <div class="container">
    <div class="row">
      <div class="col-sm-4 col-md-3 hidden-xs">

        <?php if ( ! empty( $customer ) ) { ?>
          <ul class="no-bullets">
            <li style="font-size: 14px; margin-bottom:5px;"><strong>Customer:</strong> <?php echo $customer;?></li>
            <?php if ( ! empty( $site ) ) { ?> 
            <li style="font-size: 14px;"><strong>Site:</strong> <a href="<?php echo $site;?>" target="_blank"><?php echo $site_name;?></a></li>
            <?php 
            }
            ?>
          </ul>  
          <hr>
        <?php
        } ?>

        <?php if ( ! empty( $quote ) ) { ?>
          <p class="lead">"<?php echo $quote;?>"</p>
          <?php if ( ! empty( $name ) ) { ?>
            <dl class="quote-author">
              <dt><?php echo $name;?><span><?php echo $title;?></span></dt>
              <?php foreach ( $headshot as $image ) {
              echo "<dd><img src='{$image['url']}' width='{$image['width']}' height='{$image['height']}' alt='{$image['alt']}' class='img-circle' /></dd>";
              } ?>
              <?php if ( ! empty( $headshot ) ) { ?> <?php } else { ?> <dd><img src="/wp-content/uploads/no-picture-100x100.png" class="img-circle"></dd><?php } ?>
            </dl>
            <?php } ?>
          <hr>
        <?php } ?>

        <?php if ( ! empty( $highlight ) ) {
          echo '<h5 style="text-transform:uppercase;">Highlights</h5>';
          echo '<ul class="check-mark-list">';
          foreach ( $highlight as $highlights ) { ?> <li><?php echo $highlights;?></li> <?php };
          echo '</ul>';
        } ?>

      </div>
      <div class="col-sm-8 col-md-6">
        <div class="padding-bottom-30 margin-bottom-30" style="border-bottom:#ebebeb solid 1px;">
          <div class="social-sharing-mini"><?php echo do_shortcode('[marketo-share]');?></div>
        </div>
        <?php echo rwmb_meta( 'case_study_wysiwyg' );?>

        <hr/>
        <div class="row next-prev-posts">
        <?php
        $prev_post = get_previous_post();
        if (!empty( $prev_post )): ?>
          <div class="col-sm-6">
            <div class="margin-bottom-15 thumb"><span>Next Case Study</span><a href="<?php echo get_permalink( $prev_post->ID ); ?>"><?php echo get_the_post_thumbnail($prev_post->ID, 'post-thumbnail', array('class'=>'img-responsive')); ?></a></div>
            <h5><a href="<?php echo get_permalink( $prev_post->ID ); ?>" class="link-black"><?php echo get_the_title( $prev_post->ID ); ?></a></h5>
          </div>
        <?php endif; ?>
        <?php
        $next_post = get_next_post();
        if (!empty( $next_post )): ?>
          <div class="col-sm-6">
            <div class="margin-bottom-15 thumb"><span>Previous Case Study</span><a href="<?php echo get_permalink( $next_post->ID ); ?>"><?php echo get_the_post_thumbnail($next_post->ID, 'post-thumbnail', array('class'=>'img-responsive')); ?></a></div>
            <h5><a href="<?php echo get_permalink( $next_post->ID ); ?>" class="link-black"><?php echo get_the_title( $next_post->ID ); ?></a></h5>
          </div>
        <?php endif; ?>
        </div>

      </div>
      <div class="col-md-3 hidden-xs hidden-sm">
        <?php echo do_shortcode('[newsletter-sidebar]'); ?> 

        <?php
        $args = array(
        'post_type'         => 'socrata_webinars',
        'order'             => 'desc',
        'posts_per_page'    => 3,
        'post_status'       => 'publish',
        );

        // The Query
        $the_query = new WP_Query( $args );

        // The Loop
        if ( $the_query->have_posts() ) {
        echo '<ul class="no-bullets sidebar-list">';
        echo '<li><h5>Recent Webinars</h5></li>';
        while ( $the_query->have_posts() ) {
        $the_query->the_post(); { ?> 

        <?php $thumb = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'thumbnail' ); $url = $thumb['0'];?>
        <li>
          <div class="article-img-container">
            <img src="<?=$url?>" class="img-responsive">
          </div>
          <div class="article-title-container">
            <a href="<?php the_permalink() ?>"><?php the_title(); ?></a>
          </div>
        </li>

        <?php }
        }
        echo '<li><a href="/webinars">View all webinars <i class="fa fa-arrow-circle-o-right"></i></a></li>';
        echo '</ul>';
        } else {
        // no posts found
        }
        /* Restore original Post Data */
        wp_reset_postdata(); ?>

        <?php
        $args = array(
        'post_type'         => 'socrata_videos',
        'order'             => 'desc',
        'posts_per_page'    => 3,
        'post_status'       => 'publish',
        );

        // The Query
        $the_query = new WP_Query( $args );

        // The Loop
        if ( $the_query->have_posts() ) {
        echo '<ul class="no-bullets sidebar-list">';
        echo '<li><h5>Recent Videos</h5></li>';
        while ( $the_query->have_posts() ) {
        $the_query->the_post(); { ?> 

        <li>
        <div class="article-img-container">
        <a href="<?php the_permalink() ?>"><img src="https://img.youtube.com/vi/<?php $meta = get_socrata_videos_meta(); echo $meta[1]; ?>/default.jpg" class="img-responsive"></a>
        </div>
        <div class="article-title-container">
        <a href="<?php the_permalink() ?>"><?php the_title(); ?></a>
        </div>
        </li>

        <?php }
        }
        echo '<li><a href="/videos">View all videos <i class="fa fa-arrow-circle-o-right"></i></a></li>';
        echo '</ul>';
        } else {
        // no posts found
        }
        /* Restore original Post Data */
        wp_reset_postdata(); ?>

      </div>
    </div>
  </div>
</section>