<?php $thumb = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'feature-image' ); $url = $thumb['0']; ?>
<div class="feature-image overlay-black" style="background-image: url(<?=$url?>);">
  <div class="vertical-center">
    <div class="container">
      <div class="row">
        <div class="col-sm-10 col-sm-offset-1">
          <h1 class="entry-title text-reverse text-center"><?php the_title(); ?></h1>
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
            <div class="entry-meta">
              <p class="hidden-sm hidden-md hidden-lg">By <span><?php if(function_exists('coauthors')) coauthors();?></span> / <?php the_time('F j, Y') ?> / <?php Roots\Sage\Extras\blog_the_categories(); ?></p>
              <ul class="hidden-xs">
                <li class="categories">
                <?php
                $categories = get_the_category();
                $separator = ', ';
                $output = '';
                if ( ! empty( $categories ) ) {
                    foreach( $categories as $category ) {
                        $output .= '<a href="' . esc_url( get_category_link( $category->term_id ) ) . '" alt="' . esc_attr( sprintf( __( 'View all posts in %s', 'textdomain' ), $category->name ) ) . '">' . esc_html( $category->name ) . '</a>' . $separator;
                    }
                    echo trim( $output, $separator );
                }
                ?>
                </li>
                <li class="date"><?php the_time('F j, Y') ?></li>
                <?php  global $post;
                $author_id=$post->post_author;
                foreach( get_coauthors() as $coauthor ): ?>
                <li class="headshot"><?php echo get_avatar( $coauthor->user_email, '50' ); ?></li>
                <li class="author">By <?php echo $coauthor->display_name; ?></li>
                <?php endforeach; ?>
              </ul>
            </div>
            <?php the_content(); ?>
            <hr/>
            <div class="row next-prev-posts">
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
            </div>





            <!-- Begin Outbrain -->
            <div class="OUTBRAIN hidden-xs" data-widget-id="NA"></div> 
            <script type="text/javascript" async="async" src="https://widgets.outbrain.com/outbrain.js"></script>
            
            

          </article>
          <?php endwhile; ?>                 
      </div>


<div class="col-sm-4 hidden-xs">

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
echo '<li><a href="/digital-government-transformation">View All Articles <i class="fa fa-arrow-circle-o-right"></i></a></li>';
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
    <img src="https://img.youtube.com/vi/<?php $meta = get_socrata_videos_meta(); echo $meta[1]; ?>/default.jpg" class="img-responsive">
  </div>
  <div class="article-title-container">
    <a href="<?php the_permalink() ?>"><?php the_title(); ?></a>
  </div>
</li>

<?php }
}
echo '<li><a href="/videos">View All Videos <i class="fa fa-arrow-circle-o-right"></i></a></li>';
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
echo '<li><h5>Recent Case Studies</h5></li>';
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

$today = strtotime('today UTC');        

$event_meta_query = array( 
  'relation' => 'AND',
  array( 
    'key' => 'socrata_events_endtime', 
    'value' => $today, 
    'compare' => '>=', 
  ) 
); 

$args = array(
'post_type'           => 'socrata_events',
'posts_per_page'      => 3,
'post_status'         => 'publish',
'ignore_sticky_posts' => true,  
'meta_key'            => 'socrata_events_endtime',
'orderby'             => 'meta_value_num',
'order'               => 'asc',
'meta_query'          => $event_meta_query
);

// The Query
$the_query = new WP_Query( $args );

// The Loop
if ( $the_query->have_posts() ) {
echo '<ul class="no-bullets sidebar-list">';
echo '<li><h5>Upcoming Events</h5></li>';
while ( $the_query->have_posts() ) {
$the_query->the_post(); { ?> 

  <?php if ( has_term( 'socrata-event','socrata_events_cat' ) ) { ?>
  <li><small style="text-transform: uppercase;"><?php events_the_categories(); ?></small><br><a href="<?php the_permalink() ?>"><?php the_title(); ?></a><br><small><?php echo rwmb_meta( 'socrata_events_displaydate' );?></small></li>
  <?php }
  else { ?>
  <li><small style="text-transform: uppercase;"><?php events_the_categories(); ?></small><br>

  <?php 
    $url = rwmb_meta( 'socrata_events_url' ); 
    if ($url) { ?>
      <a href="<?php echo $url;?>" target="_blank"><?php the_title(); ?></a>
      <?php 
    }
    else { ?>
      <?php the_title(); ?>
      <?php
    }
  ?>
  <br><small><?php echo rwmb_meta( 'socrata_events_displaydate' );?></small>

  </li>
  <?php
  } ?>

<?php }
}
echo '<li><a href="/events">View All Events <i class="fa fa-arrow-circle-o-right"></i></a></li>';
echo '</ul>';
} else { ?>
<ul class="no-bullets sidebar-list">
<li><h5>Upcoming Events</h5></li>
<li>No events at this time.</li>
</ul>
<?php
}
/* Restore original Post Data */
wp_reset_postdata(); ?>



 
</div>



  </div>
</div>
</section>