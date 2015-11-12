<div class="container page-padding">
	<div class="row">
		<div class="col-sm-12">
			<h3 class="archive-title">Customer Stories: <?php single_cat_title(); ?></h3>
		</div>
	</div>

	<div class="row">
		<div class="col-sm-9">
			<div class="row">

				<?php while ( have_posts() ) : the_post();  ?>

				<div class="col-sm-6 col-lg-4">
					<div class="card">
						<div class="card-image hidden-xs">
							<img src="<?php echo stories_logo_home( 'full', 100 ); ?>" class="img-responsive ">                    
							<a href="<?php the_permalink() ?>"></a>
						</div>
						<div class="card-text truncate">
							<p class="categories"><?php stories_the_categories(); ?></p>
							<h4><a href="<?php the_permalink() ?>"><?php the_title(); ?></a></h4>
							<?php the_excerpt(); ?> 
						</div>
					</div>
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