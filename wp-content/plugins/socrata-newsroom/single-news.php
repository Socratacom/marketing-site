<?php 
  $thumb = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'feature-image' );
  $url = $thumb['0']; 
?>
<section class="background-primary-light hidden-xs hidden-sm">
  <div class="container">
    <div class="row">
      <div class="col-sm-12">
        <ol class="breadcrumb">
          <li>RESOURCES</li>
          <li><a href="/resources">Resources Home</a></li>
          <li><a href="/newsroom">Newsroom</a></li>
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
<section class="content">
  <div class="container">
    <div class="row">
      <div class="col-sm-8">
        <div class="padding-bottom-30 margin-bottom-30" style="border-bottom:#ebebeb solid 1px;">
          <div class="social-sharing-mini"><?php echo do_shortcode('[marketo-share]');?></div>
        </div>
        <?php echo rwmb_meta( 'news_wysiwyg' );?>
        <hr/>
        <div class="row next-prev-posts">
        <?php
        $prev_post = get_previous_post(TRUE, '', 'news_category');
        if (!empty( $prev_post )): ?>
          <div class="col-sm-6">
            <div class="margin-bottom-15 thumb"><span>Next Press Release</span><a href="<?php echo get_permalink( $prev_post->ID ); ?>"><?php echo get_the_post_thumbnail($prev_post->ID, 'post-thumbnail', array('class'=>'img-responsive')); ?></a></div>
            <div class="category-name">
                <?php 
                $cats = get_the_category( $prev_post->ID );
                echo $cats[0]->cat_name;
                for ($i = 1; $i < count($cats); $i++) {echo ', ' . $cats[$i]->cat_name ;}
                ?>
            </div>
            <h5><a href="<?php echo get_permalink( $prev_post->ID ); ?>" class="link-black"><?php echo get_the_title( $prev_post->ID ); ?></a></h5>
            <p><small><?php echo get_the_time( 'F j, Y', $prev_post->ID ); ?></small></p>
          </div>
        <?php endif; ?>
        <?php
        $next_post = get_next_post(TRUE, '', 'news_category');
        if (!empty( $next_post )): ?>
          <div class="col-sm-6">
            <div class="margin-bottom-15 thumb"><span>Previous Press Release</span><a href="<?php echo get_permalink( $next_post->ID ); ?>"><?php echo get_the_post_thumbnail($next_post->ID, 'post-thumbnail', array('class'=>'img-responsive')); ?></a></div>
            <div class="category-name">
                <?php 
                $cats = get_the_category( $next_post->ID );
                echo $cats[0]->cat_name;
                for ($i = 1; $i < count($cats); $i++) {echo ', ' . $cats[$i]->cat_name ;}
                ?>
            </div>
            <h5><a href="<?php echo get_permalink( $next_post->ID ); ?>" class="link-black"><?php echo get_the_title( $next_post->ID ); ?></a></h5>
            <p><small><?php echo get_the_time( 'F j, Y', $next_post->ID ); ?></small></p>
          </div>
        <?php endif; ?>
        </div>
      </div>
      <div class="col-sm-4 hidden-xs">
          <div class="alert alert-info margin-bottom-30">
            <i class="fa fa-info-circle" aria-hidden="true"></i> <strong>Media Contact:</strong> <a href="mailto:press@socrata.com">press@socrata.com</a>
          </div>            
          <?php echo do_shortcode('[newsletter-sidebar]'); ?>

          <?php
          $args = array(
          'post_type'         => 'post',
          'order'             => 'desc',
          'posts_per_page'    => 5,
          'post_status'       => 'publish',
          );

          // The Query
          $the_query = new WP_Query( $args );

          // The Loop
          if ( $the_query->have_posts() ) {
          echo '<ul class="no-bullets sidebar-list">';
          echo '<li><h5>Recent Articles</h5></li>';
          while ( $the_query->have_posts() ) {
          $the_query->the_post(); { ?> 

          <?php $thumb = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'thumbnail' ); $url = $thumb['0'];?>
          <li>
            <div class="article-img-container">
              <a href="<?php the_permalink() ?>"><img src="<?=$url?>" class="img-responsive"></a>
            </div>
            <div class="article-title-container">
              <a href="<?php the_permalink() ?>"><?php the_title(); ?></a><br><small><?php the_time('F j, Y') ?></small>
            </div>
          </li>

          <?php }
          }
          echo '<li><a href="/blog">View blog <i class="fa fa-arrow-circle-o-right"></i></a></li>';
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