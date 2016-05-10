<?php $thumb = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'feature-image' ); $url = $thumb['0']; ?>
<div class="hero img-background background-primary-alt-2-light overlay overlay-primary-alt-2" style="background-image: url(<?=$url?>);">
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
</div>
<section class="content">
  <div class="container">
    <div class="row">
      <div class="col-sm-8">
        <?php while (have_posts()) : the_post(); ?>
          <article <?php post_class(); ?>>
            <div class="social-sharing">
              <?php echo do_shortcode('[marketo-share-custom]');?>
            </div>
            <p class="meta"><small><?php news_the_categories(); ?> | Posted: <?php the_time('F jS, Y') ?></small></p>
            <?php echo rwmb_meta( 'news_wysiwyg' );?>
          </article>
        <?php endwhile; ?>
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
            <h5><a href="<?php echo get_permalink( $prev_post->ID ); ?>"><?php echo get_the_title( $prev_post->ID ); ?></a></h5>
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
            <h5><a href="<?php echo get_permalink( $next_post->ID ); ?>"><?php echo get_the_title( $next_post->ID ); ?></a></h5>
            <p><small><?php echo get_the_time( 'F j, Y', $next_post->ID ); ?></small></p>
          </div>
        <?php endif; ?>
        </div>
      </div>
      <div class="col-sm-4 hidden-xs">
        <?php
          //list terms in a given taxonomy using wp_list_categories  (also useful as a widget)
          $orderby = 'name';
          $show_count = 0; // 1 for yes, 0 for no
          $pad_counts = 0; // 1 for yes, 0 for no
          $hide_empty = 1;
          $hierarchical = 1; // 1 for yes, 0 for no
          $taxonomy = 'news_category';
          $title = 'Newsroom Categories';

          $args = array(
            'orderby' => $orderby,
            'show_count' => $show_count,
            'pad_counts' => $pad_counts,
            'hide_empty' => $hide_empty,
            'hierarchical' => $hierarchical,
            'taxonomy' => $taxonomy,
            'title_li' => '<h5>'. $title .'</h5>'
          );
        ?>
        <ul class="category-nav">
          <?php wp_list_categories($args); ?>
        </ul>
        <?php echo do_shortcode('[newsletter-sidebar]'); ?>         
        <div class="alert alert-info">
          <i class="fa fa-info-circle" aria-hidden="true"></i> <strong>Media Contact:</strong> <a href="mailto:press@socrata.com">press@socrata.com</a>
        </div>
        <?php
          $args1 = array(
          'post_type'         => 'news',
          'news_category'     => 'press-releases',
          'order'             => 'desc',
          'posts_per_page'    => 3,
          'post_status'       => 'publish',
          );

          // The Query
          $query1 = new WP_Query( $args1 );

          echo '<ul class="no-bullets sidebar-list">';
          echo '<li><h5>Recent Press Releases</h5></li>';

          // The Loop
          if ( $query1->have_posts() ) {          
          while ( $query1->have_posts() ) {
          $query1->the_post(); { ?> 
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
          } 
          else {
          // no posts found
          }
          echo '<li><a href="/newsroom/press-releases/">View All Press Releases <i class="fa fa-arrow-circle-o-right"></i></a></li>';
          echo '</ul>';
          /* Restore original Post Data */
          wp_reset_postdata();

          $args2 = array(
          'post_type'         => 'news',
          'news_category'     => 'socrata-in-the-news',
          'order'             => 'desc',
          'posts_per_page'    => 3,
          'post_status'       => 'publish',
          );

          // The Query
          $query2 = new WP_Query( $args2 );

          echo '<ul class="no-bullets sidebar-list">';
          echo '<li><h5>Recent Socrata in the News</h5></li>';

          // The Loop
          if ( $query2->have_posts() ) {          
          while ( $query2->have_posts() ) {
          $query2->the_post();
          $link = rwmb_meta( 'news_url' ); { ?> 
            <li>
              <div class="article-title-container">                
                <a href="<?php echo $link;?>" target="_blank"><?php the_title(); ?></a><br><small><?php the_time('F j, Y') ?></small>
              </div>
            </li>
            <?php }
            }          
          } 
          else {
          // no posts found
          }
          echo '<li><a href="/newsroom/socrata-in-the-news/">View All Socrata in the News <i class="fa fa-arrow-circle-o-right"></i></a></li>';
          echo '</ul>';
          /* Restore original Post Data */
          wp_reset_postdata();

          $args3 = array(
          'post_type'         => 'news',
          'news_category'     => 'customer-news',
          'order'             => 'desc',
          'posts_per_page'    => 3,
          'post_status'       => 'publish',
          );

          // The Query
          $query3 = new WP_Query( $args3 );

          echo '<ul class="no-bullets sidebar-list">';
          echo '<li><h5>Recent Customers in the News</h5></li>';

          // The Loop
          if ( $query3->have_posts() ) {          
          while ( $query3->have_posts() ) {
          $query3->the_post();
          $link = rwmb_meta( 'news_url' ); { ?> 
            <li>
              <div class="article-title-container">                
                <a href="<?php echo $link;?>" target="_blank"><?php the_title(); ?></a><br><small><?php the_time('F j, Y') ?></small>
              </div>
            </li>
            <?php }
            }          
          } 
          else {
          // no posts found
          }
          echo '<li><a href="/newsroom/customer-news/">View All Customers in the News <i class="fa fa-arrow-circle-o-right"></i></a></li>';
          echo '</ul>';
          /* Restore original Post Data */
          wp_reset_postdata();

        ?>

      </div>
    </div>
  </div>
</section>