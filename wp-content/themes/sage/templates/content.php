
<div class="col-sm-4 col-md-3">
<article <?php post_class(); ?> style="background:#ccc; height:200px; overflow:hidden; margin-bottom:30px;">
  <header>
    <h2 class="entry-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
   
  </header>
  <div class="entry-summary">
    <?php the_excerpt(); ?>
  </div>
</article>
</div>
