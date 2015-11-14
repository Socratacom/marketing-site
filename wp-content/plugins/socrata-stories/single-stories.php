<?php $thumb = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'feature-image' ); $url = $thumb['0']; ?>
<div class="feature-image hidden-xs" style="background-image: url(<?=$url?>);">
  <div class="pattern-overlay"></div>  
  <?php echo do_shortcode('[image-attribution]'); ?>
</div>
<div class="container">
  <div class="row">
    <div class="col-sm-3 col-md-2 sidebar hidden-xs">
<?php 
  $meta = get_socrata_stories_meta(); 
  $thumb = wp_get_attachment_image_src( $meta[6], 'full-width-ratio' ); 
  $url_logo = $thumb['0']; ?>




      <p class="text-center"><img src="<?=$url_logo?>" class="img-responsive"></p>
      <hr/>
      <?php $meta = get_socrata_stories_meta();
      if ($meta[12]) { ?>
        <div class="quote-block">
          <p>&quot;<?php echo $meta[10]; ?>&quot;</p>
          <ul class="author-w-image clearfix">
            <li><?php echo wp_get_attachment_image($meta[12], 'thumbnail', false, array('class' => 'img-circle headshot')); ?></li>
            <li><?php echo $meta[11]; ?></li>
          </ul>
        </div>
        <?php
      }
      elseif ($meta[11]) { ?>
        <div class="quote-block">
          <p>&quot;<?php echo $meta[10]; ?>&quot;</p>
          <ul>
            <li><?php echo $meta[11]; ?></li>
          </ul>
        </div>
        <?php
      }    
      elseif ($meta[10]) {echo "<div class='quote-block'><p>&quot;$meta[10]&quot;</p></div>";}
      ?>

      <?php $meta = get_socrata_stories_meta(); if ($meta[7]) { ?>
        <ul class="screens">
          <?php echo '<li>' . wp_get_attachment_image($meta[7], 'medium', false, array('class' => 'img-responsive')) . '</li>'; ?>
          <?php echo '<li>' . wp_get_attachment_image($meta[8], 'medium', false, array('class' => 'img-responsive')) . '</li>'; ?>
          <?php echo '<li>' . wp_get_attachment_image($meta[9], 'medium', false, array('class' => 'img-responsive')) . '</li>'; ?>
        </ul>
        <?php
        }
      ?>
    </div>
    <div class="col-sm-9 col-md-7 article-content">
      <div class="wrapper">
        <?php while (have_posts()) : the_post(); ?>
          <article <?php post_class(); ?>>
            <small class="category-name"><?php stories_the_categories(); ?></small>
            <h1 class="entry-title"><?php the_title(); ?></h1>
            <ul class="meta">
              <?php $meta = get_socrata_stories_meta();
                if ($meta[2]) {echo "<li><a href='$meta[2]' target='_blank'>$meta[1]</a></li>";}
                elseif ($meta[1]) {echo "<li>$meta[1]</li>";}
              ?>
              <?php $meta = get_socrata_stories_meta(); if ($meta[3]) {echo "<li><i>Live Since</i> $meta[3]</li>";} ?>
              <?php $meta = get_socrata_stories_meta(); if ($meta[4]) {echo "<li><a href='$meta[5]' target='_blank'>$meta[4]</a></li>";} ?>
            </ul>
            <hr/>
            <div class="entry-content">
              <?php the_content(); ?>
            </div>

            <?php $meta = get_socrata_stories_meta(); if ($meta[13]) { ?>     
            <hr/>
            <h3>Press</h3>
            <ul class="press">         
            <?php $meta = get_socrata_stories_meta(); if ($meta[13]) {echo "<li><a href='$meta[14]' target='_blank'>$meta[13]</a><small>- $meta[20]</small></li>";} ?>
            <?php $meta = get_socrata_stories_meta(); if ($meta[15]) {echo "<li><a href='$meta[16]' target='_blank'>$meta[15]</a><small>- $meta[21]</small></li>";} ?>
            <?php $meta = get_socrata_stories_meta(); if ($meta[17]) {echo "<li><a href='$meta[18]' target='_blank'>$meta[17]</a><small>- $meta[22]</small></li>";} ?>
            </ul>         
            <?php } ?>

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
    <div class="col-md-3 sidebar hidden-xs hidden-sm">
        <?php
          //list terms in a given taxonomy using wp_list_categories  (also useful as a widget)
          $orderby = 'name';
          $show_count = 0; // 1 for yes, 0 for no
          $pad_counts = 0; // 1 for yes, 0 for no
          $hide_empty = 1;
          $hierarchical = 1; // 1 for yes, 0 for no
          $taxonomy = 'stories_type';
          $title = 'Stories Categories';

          $args = array(
            'orderby' => $orderby,
            'show_count' => $show_count,
            'pad_counts' => $pad_counts,
            'hide_empty' => $hide_empty,
            'hierarchical' => $hierarchical,
            'taxonomy' => $taxonomy,
            'title_li' => '<h5 class="background-nephritis">'. $title .'</h5>'
          );
        ?>
        <ul class="category-nav">
          <?php wp_list_categories($args); ?>
        </ul>
        <?php echo do_shortcode('[newsletter-sidebar]'); ?>
    </div>
  </div>
</div>
