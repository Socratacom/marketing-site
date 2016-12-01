<?php 
  $thumb = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'post-image' );
  $url = $thumb['0'];
  $img_id = get_post_thumbnail_id(get_the_ID());
  $alt_text = get_post_meta($img_id , '_wp_attachment_image_alt', true);
?>
<section class="section-padding">
  <div class="container">
    <div class="row">
      <div class="col-sm-8">
        <?php while (have_posts()) : the_post(); ?>
          <article <?php post_class(); ?>>

            <h1 class="margin-bottom-15"><?php the_title(); ?></h1>
            <div class="date margin-bottom-15"><i class="fa fa-clock-o" aria-hidden="true"></i> <?php the_time('F j, Y g:i a T') ?> | <?php $categories = get_the_category(); $separator = ', '; $output = '';
                if ( ! empty( $categories ) ) {
                    foreach( $categories as $category ) {
                        $output .= '<a href="' . esc_url( get_category_link( $category->term_id ) ) . '" alt="' . esc_attr( sprintf( __( 'View all posts in %s', 'textdomain' ), $category->name ) ) . '">' . esc_html( $category->name ) . '</a>' . $separator;
                    }
                    echo trim( $output, $separator );
                }
                ?>
            </div>
            <div class="margin-bottom-15"><?php echo do_shortcode('[addthis]');?></div>
            <div class="byline">
              <div class="row">
                <?php  global $post;
                $author_id=$post->post_author;
                foreach( get_coauthors() as $coauthor ): ?>
                <div class="col-sm-6 col-md-4">
                  <ul>
                    <li><?php echo get_avatar( $coauthor->user_email, '50' ); ?></li>
                    <li><?php echo $coauthor->display_name; ?></li>
                  </ul>
                </div>
                <?php endforeach; ?>
              </div>
            </div>
            <div class="margin-bottom-30"><img src="<?php echo $url;?>" <?php if ( ! empty($alt_text) ) { ?> alt="<?php echo $alt_text;?>" <?php } ;?> class="img-responsive"><?php echo do_shortcode('[image-attribution]'); ?></div>

            <?php the_content(); ?>

            </article>

            <hr/>
            
            <div class="row next-prev-posts">
            <?php
            $next_post = get_next_post();
            if (!empty( $next_post )): ?>
              <div class="col-sm-6">
                <div class="margin-bottom-15 thumb"><span>Previous Article</span><a href="<?php echo get_permalink( $next_post->ID ); ?>"><?php echo get_the_post_thumbnail($next_post->ID, 'post-thumbnail', array('class'=>'img-responsive')); ?></a></div>
                <div class="category-name">
                    <?php 
                    $cats = get_the_category( $next_post->ID );
                    echo $cats[0]->cat_name;
                    for ($i = 1; $i < count($cats); $i++) {echo ', ' . $cats[$i]->cat_name ;}
                    ?>
                </div>
                <h5><a href="<?php echo get_permalink( $next_post->ID ); ?>"><?php echo get_the_title( $next_post->ID ); ?></a></h5>
                <p><small><?php echo get_the_time( 'F j, Y', $next_post->ID ); ?></small></p>
              </div>
            <?php endif; ?>
            <?php
            $prev_post = get_previous_post();
            if (!empty( $prev_post )): ?>
              <div class="col-sm-6">
                <div class="margin-bottom-15 thumb"><span>Next Article</span><a href="<?php echo get_permalink( $prev_post->ID ); ?>"><?php echo get_the_post_thumbnail($prev_post->ID, 'post-thumbnail', array('class'=>'img-responsive')); ?></a></div>
                <div class="category-name">
                    <?php 
                    $cats = get_the_category( $prev_post->ID );
                    echo $cats[0]->cat_name;
                    for ($i = 1; $i < count($cats); $i++) {echo ', ' . $cats[$i]->cat_name ;}
                    ?>
                </div>
                <h5><a href="<?php echo get_permalink( $prev_post->ID ); ?>"><?php echo get_the_title( $prev_post->ID ); ?></a></h5>
                <p><small><?php echo get_the_time( 'F j, Y', $prev_post->ID ); ?></small></p>
              </div>
            <?php endif; ?>
            
            </div>


            <div class="addthis_relatedposts_inline"></div>
            
            

          
          <?php endwhile; ?>                 
      </div>

      <div class="col-sm-4 hidden-xs">
      <div class="margin-bottom-30">
      <a href="https://socrata.com/feed/" title="Digital Government Transformation" target="_blank" class="btn btn-warning btn-block"><i class="fa fa-rss" aria-hidden="true"></i> Subscribe to our blog</a>
      </div>

      <?php echo do_shortcode('[newsletter-sidebar]'); ?> 

      <?php
      $args = array(
      'post_type'         => 'post',
      'order'             => 'desc',
      'posts_per_page'    => 3,
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
      <img src="<?=$url?>" class="img-responsive">
      </div>
      <div class="article-title-container">
      <a href="<?php the_permalink() ?>"><?php the_title(); ?></a><br><small><?php the_time('F j, Y') ?></small>
      </div>
      </li>
      <?php }
      }
      echo '<li><a href="/blog">View All Articles <i class="fa fa-arrow-circle-o-right"></i></a></li>';
      echo '</ul>';
      } else {
      // no posts found
      }
      /* Restore original Post Data */
      wp_reset_postdata(); ?>

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
      echo '<li><h5>Webinars</h5></li>';
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
      echo '<li><a href="/case-studies">View All Case Studies <i class="fa fa-arrow-circle-o-right"></i></a></li>';
      echo '</ul>';
      } else {
      // no posts found
      }
      /* Restore original Post Data */
      wp_reset_postdata(); ?>

      <?php
      $args = array(
      'post_type'         => 'case_study',
      'order'             => 'desc',
      'posts_per_page'    => 3,
      'post_status'       => 'publish',
      );

      // The Query
      $the_query = new WP_Query( $args );

      // The Loop
      if ( $the_query->have_posts() ) {
      echo '<ul class="no-bullets sidebar-list">';
      echo '<li><h5>Case Studies</h5></li>';
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
      echo '<li><a href="/case-studies">View All Case Studies <i class="fa fa-arrow-circle-o-right"></i></a></li>';
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