<div class="two_third">
  <div class="format_text">
        

  <?php if (have_posts()) : ?>
  <?php while (have_posts()) : the_post(); ?>
  <article class="box">
    <a href="<?php the_permalink() ?>"><?php the_post_thumbnail('thumbnail'); ?></a>
      <h2 style="font-size:1.2em;"><a title="<?php the_title(); ?>" href="<?php the_permalink() ?>" rel="bookmark"><?php the_title(); ?></a></h2>      
      <div class="author-small clearfix" style="font-size:.75em; line-height: normal !important;">
        <?php echo get_avatar( get_the_author_meta('ID'), 24 ); ?>
        <div class="byline">Shared by <?php the_author(); ?><br/><?php the_time('F jS, Y') ?></div>
      </div>
    <p style="font-size:.8em; line-height: normal;">
      <?php
        $theexcerpt = get_the_excerpt();
        $getlength = strlen($theexcerpt);
        $thelength = 140;
        echo substr($theexcerpt, 0, $thelength);
        if ($getlength > $thelength) echo "...";
      ?>
    </p>
  <p style="font-size:.8em; line-height: normal;"><small><?php the_taxonomies('post'); ?></small></p>
  </article>
  <?php endwhile; ?>
  <?php endif; ?>

  <div><?php if(function_exists('wp_pagenavi')) { wp_pagenavi(); } ?></div>
  </div>
</div>
<div class="one_third last">
  <div class="format_text">



  <ul><?php thesis_default_widget('newsroom'); ?></ul>
  <h3>From the Blog</h3>
  <ul class="blog-feed">
    <?php $my_query = new WP_Query('posts_per_page=5');
    while ($my_query->have_posts()) : $my_query->the_post(); ?>
    <li class="clearfix">
      <?php if(has_post_thumbnail()) :?>
      <?php $thumb = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'thumbnail'); $url = $thumb['0']; ?>
        <a href="<?php the_permalink() ?>" style="background-image:url(<?=$url?>);" class="blog-thumb"></a>
        <?php else :?>
        <a href="<?php the_permalink() ?>" class="blog-thumb-no-image"></a>
        <?php endif;?>
        <div class="blog-post-container">
          <p style="font-size: .8em; line-height: normal;">
          <a href="<?php the_permalink() ?>" title="<?php the_title(); ?>">
          <?php
                $thetitle = get_the_title();
                $getlength = strlen($thetitle);
                $thelength = 82;
                echo substr($thetitle, 0, $thelength);
                if ($getlength > $thelength) echo "..."; ?></a>
          <small><?php the_time('F jS, Y') ?></small>
        </p>
        </div>
    </li>
    <?php endwhile; ?>
    <?php wp_reset_query(); ?>
  </ul>
  </div>
</div>
<div class="clearboth"></div>





