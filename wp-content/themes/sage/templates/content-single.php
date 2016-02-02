<?php $thumb = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'feature-image' ); $url = $thumb['0']; ?>
<div class="feature-image hidden-xs" style="background-image: url(<?=$url?>);">
  <div class="pattern-overlay"></div>
  <?php echo do_shortcode('[image-attribution]'); ?>
</div>
<div class="container">
  <div class="row">
    <div class="col-sm-8 col-md-7 col-md-offset-1 article-content">
      <div class="wrapper">
        <?php while (have_posts()) : the_post(); ?>
          <article <?php post_class(); ?>>
            <small class="category-name"><?php Roots\Sage\Extras\blog_the_categories(); ?></small>
            <h1 class="entry-title"><?php the_title(); ?></h1>
            <?php get_template_part('templates/entry-meta'); ?>
            <div class="entry-content">
              <?php the_content(); ?>
            </div>
            <hr/>
            <div>
              <?php if( get_posts() ) {
              previous_post_link('<p><strong><small>NEXT POST:</small><br>%link</strong></p>');
              next_post_link('<p><strong><small>PREVIOUS POST:</small><br>%link</strong></p>');
              }?>
            </div>
            <hr/>
            <!-- Begin Outbrain -->
            <div class="OUTBRAIN hidden-xs" data-widget-id="NA"></div> 
            <script type="text/javascript" async="async" src="https://widgets.outbrain.com/outbrain.js"></script>
            <?php comments_template('/templates/comments.php'); ?>
          </article>
          <?php endwhile; ?>
          <div class="marketo-share">
            <?php echo do_shortcode( '[marketo-share]' ); ?>
          </div>        
      </div>
    </div>
    <div class="col-sm-4 col-md-3 sidebar hidden-xs">
      <?php
      //list terms in a given taxonomy using wp_list_categories  (also useful as a widget)
      $orderby = 'name';
      $show_count = 0; // 1 for yes, 0 for no
      $pad_counts = 0; // 1 for yes, 0 for no
      $hide_empty = 1;
      $hierarchical = 1; // 1 for yes, 0 for no
      $taxonomy = 'category';
      $title = 'Blog Categories';

      $args = array(
      'orderby' => $orderby,
      'show_count' => $show_count,
      'pad_counts' => $pad_counts,
      'hide_empty' => $hide_empty,
      'hierarchical' => $hierarchical,
      'taxonomy' => $taxonomy,
      'title_li' => '<h5 class="background-peter-river">'. $title .'</h5>'
      );
      ?>
      <ul class="category-nav blog-nav">
        <?php wp_list_categories($args); ?>
      </ul>
      <?php echo do_shortcode('[newsletter-sidebar]'); ?>
    </div>
  </div>
</div>