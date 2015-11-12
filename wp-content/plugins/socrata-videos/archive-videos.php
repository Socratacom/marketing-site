<div class="container page-padding">
	<div class="row">
		<div class="col-sm-12">
			<h3 class="archive-title">Videos: <?php single_cat_title(); ?></h3>
		</div>
	</div>

	<div class="row">
		<div class="col-sm-9">
			<div class="row">

				<?php while ( have_posts() ) : the_post();  ?>

<div class="col-sm-6 col-lg-4">
<article class="card card-video">
<div class="card-image">
<img src="http://img.youtube.com/vi/<?php $meta = get_socrata_videos_meta(); echo $meta[1]; ?>/mqdefault.jpg" class="img-responsive">
<a class="link" href="<?php the_permalink() ?>"></a>
</div>
<div class="card-text truncate">
<p class="categories"><?php videos_the_categories(); ?></p>
<h4><a href="<?php the_permalink() ?>"><?php the_title(); ?></a></h4>
<?php $meta = get_socrata_videos_meta(); if ($meta[2]) {echo "$meta[2]";} ?>
</div>
</article>
</div>

				<?php endwhile; ?>

				<?php if (function_exists("pagination")) {pagination($additional_loop->max_num_pages);} ?>

			</div>
		</div>
		<div class="col-sm-3">
        <?php
          //list terms in a given taxonomy using wp_list_categories  (also useful as a widget)
          $orderby = 'name';
          $show_count = 0; // 1 for yes, 0 for no
          $pad_counts = 0; // 1 for yes, 0 for no
          $hide_empty = 1;
          $hierarchical = 1; // 1 for yes, 0 for no
          $taxonomy = 'socrata_videos_category';
          $title = 'Video Categories';

          $args = array(
            'orderby' => $orderby,
            'show_count' => $show_count,
            'pad_counts' => $pad_counts,
            'hide_empty' => $hide_empty,
            'hierarchical' => $hierarchical,
            'taxonomy' => $taxonomy,
            'title_li' => '<h5 class="background-carrot">'. $title .'</h5>'
          );
        ?>
        <ul class="category-nav">
          <?php wp_list_categories($args); ?>
        </ul>
      
        <?php echo do_shortcode('[newsletter-sidebar]'); ?>
      </div>

	</div>
</div>