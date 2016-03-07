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
<section class="section-padding">
  <div class="container">
    <div class="row">
      <div class="col-sm-8 col-md-6">
        <?php while (have_posts()) : the_post(); ?>
          <article <?php post_class(); ?>>
            <div class="social-sharing">
              <?php echo do_shortcode('[marketo-share-custom]');?>
            </div>
            <!--<small class="category-name"><?php Roots\Sage\Extras\blog_the_categories(); ?></small>-->         
            <div style="float:left; margin:0 15px 15px 0;">
            <?php get_template_part('templates/entry-meta'); ?>
            </div>
            <?php the_content(); ?>
            <hr/>
              <?php if( get_posts() ) {
              previous_post_link('<p><strong><small>NEXT POST:</small><br>%link</strong></p>');
              next_post_link('<p><strong><small>PREVIOUS POST:</small><br>%link</strong></p>');
              }?>
            <hr/>
            <!-- Begin Outbrain -->
            <div class="OUTBRAIN hidden-xs" data-widget-id="NA"></div> 
            <script type="text/javascript" async="async" src="https://widgets.outbrain.com/outbrain.js"></script>
            <?php comments_template('/templates/comments.php'); ?>
          </article>
          <?php endwhile; ?>                 
      </div>


<div class="col-sm-4 col-md-3 hidden-xs">

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
'post_type'         => 'socrata_events',
'posts_per_page'    => 3,
'post_status' => 'publish',
'ignore_sticky_posts' => true,  
'meta_key' => 'socrata_events_endtime',
'orderby' => 'meta_value_num',
'order' => 'asc',
'meta_query' => $event_meta_query
);

// The Query
$the_query = new WP_Query( $args );

// The Loop
if ( $the_query->have_posts() ) {
echo '<ul class="no-bullets sidebar-list">';
echo '<li><h5>Upcoming Events</h5></li>';
while ( $the_query->have_posts() ) {
$the_query->the_post(); { ?> 

<li><?php the_title(); ?></li>

<?php }
}
echo '<li><a href="/events">View All Events <i class="fa fa-arrow-circle-o-right"></i></a></li>';
echo '</ul>';
} else { ?>
<ul class="no-bullets sidebar-list">
<li><h5>Upcoming Events</h5></li>
<li>No Events</li>
</ul>
<?php
}
/* Restore original Post Data */
wp_reset_postdata(); ?>



 
</div>

<div class="col-md-3 hidden-xs hidden-sm">
<?php echo do_shortcode('[newsletter-sidebar]'); ?> 
</div>





    


    <!--
    <div class="col-sm-4 col-md-3 sidebar hidden-xs">
      

      <?php echo do_shortcode('[newsletter-sidebar]'); ?>
      

      <div class="subscribe">
        <ul>                
          <li><a class="twitter-follow-button" href="https://twitter.com/socrata" data-size="large">Follow @Socrata</a></li>
          <li><a href="<?php bloginfo('rss2_url'); ?>" title="<?php _e('Syndicate this site using RSS'); ?>" target="_blank" class="btn btn-warning"><i class="fa fa-rss"></i> <?php _e('FEED'); ?></a></li>
        </ul>
        <script>window.twttr = (function(d, s, id) {
        var js, fjs = d.getElementsByTagName(s)[0],
        t = window.twttr || {};
        if (d.getElementById(id)) return t;
        js = d.createElement(s);
        js.id = id;
        js.src = "https://platform.twitter.com/widgets.js";
        fjs.parentNode.insertBefore(js, fjs);

        t._e = [];
        t.ready = function(f) {
        t._e.push(f);
        };

        return t;
        }(document, "script", "twitter-wjs"));</script>
      </div>





    </div>
    -->
  </div>
</div>
</section>