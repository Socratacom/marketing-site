<div class="container page-padding">
  <div class="row">   
    <div class="col-sm-12">
      <?php while (have_posts()) : the_post(); ?>
      <article <?php post_class(); ?>>
        <div class="video-container">
          <iframe width="853" height="480" src="https://www.youtube.com/embed/<?php $meta = get_socrata_videos_meta(); echo $meta[1]; ?>?rel=0&amp;showinfo=0&autoplay=1" frameborder="0" allowfullscreen></iframe>
        </div>
        <div class="row">
          <div class="col-sm-10 col-sm-offset-1">
            <h1 class="entry-title"><?php the_title(); ?></h1>
            <div class="marketo-share">
              <?php echo do_shortcode( '[marketo-share]' ); ?>
            </div>
            <?php $meta = get_socrata_videos_meta(); if ($meta[2]) {echo "$meta[2]";} ?>
          </div>
        </div>
      </article>      
      <?php endwhile; ?>
    </div>
  </div>    
</div>
