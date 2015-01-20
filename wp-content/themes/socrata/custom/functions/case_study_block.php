<?php
// [case study block]

function case_study_block_shortcode($atts, $content = null) {
  ob_start();
  ?> 

<?php $cstudy_query = new WP_Query('post_type=case_study&orderby=desc&showposts=4');
    while ($cstudy_query->have_posts()) : $cstudy_query->the_post(); ?>

      <div class="one_fourth<?php if($counter==3) { echo ' last'; $counter=0; } else { $counter++; } ?>">
        <p>
          <a href="<?php the_permalink() ?>"><img src="<?php echo tuts_custom_img('full', 300, 300);?>" style="width:100%;" /></a>
        </p>
        <h3><a href="<?php the_permalink() ?>" style="text-decoration:none; color:#111;"><?php the_title(); ?></a></h3>
        <p>
        <?php
          $theexcerpt = get_the_excerpt();
          $getlength = strlen($theexcerpt);
          $thelength = 140;
          echo substr($theexcerpt, 0, $thelength);
          if ($getlength > $thelength) echo "...";
        ?><br/><a href="<?php the_permalink() ?>">Read More</a>
        </p>
      </div>

    <?php endwhile; ?>
    <?php wp_reset_query(); ?>
    <div class="clearboth"></div>

  <?php
  $content = ob_get_contents();
  ob_end_clean();
  return $content;
}

add_shortcode('case study block','case_study_block_shortcode');







