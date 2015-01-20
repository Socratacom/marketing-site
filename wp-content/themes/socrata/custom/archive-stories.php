<?php echo do_shortcode( '[archive-filter-stories]' ) ?>
<?php if (have_posts()) : ?>
<?php
  $count = 0;
  while (have_posts()) : the_post(); 
  $count++;
  $third_div = ($count%3 == 0) ? 'last' : '';
  $third_div_clear = ($count%3 == 0) ? '<div class="clearboth"></div>' : '';
?>
<?php $meta = get_socrata_stories_meta();
  if ($meta[19]) { ?>  
  <article class="one_third <?php echo $third_div; ?>" style="background-image: url(<?php echo tuts_custom_img('full', 392, 250); ?>)">    
    <div class="thumb-content">
      <div class="truncate content-excerpt">
        <h4><?php the_title(); ?></h4>
        <?php $meta = get_socrata_stories_meta();
        if ($meta[23]) {echo "<p>$meta[23]</p>";}
        else { ?> 
        <?php the_excerpt(); ?> 
        <?php }
        ?>
      </div>
      <?php $meta = get_socrata_stories_meta(); if ($meta[2]) {echo "<a href='$meta[2]' class='button' target='_blank'>Visit Site</a>";} ?>
      <div class="small-logo-wrapper">
        <?php $meta = get_socrata_stories_meta(); if ($meta[6]) echo wp_get_attachment_image($meta[6], 'small', false, array('class' => 'img-responsive small-logo')); ?>
      </div>
    </div>
    <?php $meta = get_socrata_stories_meta(); if ($meta[2]) {echo "<a href='$meta[2]' target='_blank'></a>";} ?>
  </article>

  <?php }
  else { ?>

  <article class="one_third <?php echo $third_div; ?>" style="background-image: url(<?php echo tuts_custom_img('full', 392, 250); ?>)">
    <div class="thumb-content">
      <div class="truncate content-excerpt">
        <h4><?php the_title(); ?></h4>
        <?php $meta = get_socrata_stories_meta();
        if ($meta[23]) {echo "<p>$meta[23]</p>";}
        else { ?> 
        <?php the_excerpt(); ?> 
        <?php }
        ?>
      </div>
      <a href="<?php the_permalink() ?>" class="button">Read Story</a>
      <div class="small-logo-wrapper">
        <?php $meta = get_socrata_stories_meta(); if ($meta[6]) echo wp_get_attachment_image($meta[6], 'small', false, array('class' => 'img-responsive small-logo')); ?>
      </div>
    </div>
    <a href="<?php the_permalink() ?>"></a>
  </article>

  <?php }
?>

<?php echo $third_div_clear; ?>
<?php endwhile; ?>
<?php endif; ?>
<?php wp_reset_query(); ?>
<?php if(function_exists('wp_pagenavi')) { wp_pagenavi(); } ?>
<script>$("article").delay(1000).animate({"opacity": "1"}, 700);</script>
