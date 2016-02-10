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
            <small class="category-name"><?php case_study_the_categories(); ?></small>
            <h1 class="entry-title"><?php the_title(); ?></h1>
            <!--<p class="meta"><small><strong>Posted</strong>, <?php the_time('F j, Y') ?></small></p>-->

          <?php $meta = get_case_study_meta(); if ($meta[0]) { ?>
            <p class="meta"><?php echo $meta[0];?> <?php if ($meta[2]) { echo "| <a href='$meta[2]' target='_blank'>$meta[1]</a>"; } else { echo "| $meta[1]"; }?>
          <?php
          }
          ?>


            <hr/>
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
          </article>
          <div class="marketo-share">
            <?php echo do_shortcode( '[marketo-share]' ); ?>
          </div>
        <?php endwhile; ?>
      </div>
    </div>
    <div class="col-sm-4 col-md-3 sidebar">

      <?php $meta = get_case_study_meta(); if ($meta[3]) { ?>
        <p>"<span style="font-style: italic; font-weight: 400;"><?php echo $meta[3];?></span>"<?php if ($meta[4]) { echo "<br>- $meta[4]"; } ?></p>
        <?php if ($meta[3]) { echo "<hr/>"; } ?>
      <?php 
        } ?>
      <?php $meta = get_case_study_meta(); if ($meta[5]) { echo $meta[5]; }  ?>



        <?php
          //list terms in a given taxonomy using wp_list_categories  (also useful as a widget)
          $orderby = 'name';
          $show_count = 0; // 1 for yes, 0 for no
          $pad_counts = 0; // 1 for yes, 0 for no
          $hide_empty = 1;
          $hierarchical = 1; // 1 for yes, 0 for no
          $taxonomy = 'case_study_category';
          $title = 'Case Study Categories';

          $args = array(
            'orderby' => $orderby,
            'show_count' => $show_count,
            'pad_counts' => $pad_counts,
            'hide_empty' => $hide_empty,
            'hierarchical' => $hierarchical,
            'taxonomy' => $taxonomy,
            'title_li' => '<h5 class="background-green-sea">'. $title .'</h5>'
          );
        ?>
        <ul class="category-nav">
          <?php wp_list_categories($args); ?>
        </ul>
        <?php echo do_shortcode('[newsletter-sidebar]'); ?>
      </div>
  </div>
</div>