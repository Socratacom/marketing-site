<div class="container page-padding">
	<div class="row">
		<div class="col-sm-9">
			<div class="row">
				<?php $my_query = new WP_Query( 'post_type=post&posts_per_page=1' );
				while ( $my_query->have_posts() ) : $my_query->the_post();
				$do_not_duplicate = $post->ID; ?>
				<div class="col-sm-12">
					<div class="featured-post" style="background-image: url(<?php echo Roots\Sage\Extras\custom_feature_image('full', 850, 400); ?>);">						
						<h2><a href="<?php the_permalink() ?>"><?php the_title(); ?></a></h2>					
						<?php get_template_part('templates/entry-meta'); ?>
						<div class="overlay"></div>
						<a href="<?php the_permalink() ?>"></a>
					</div>
				</div>
				<?php endwhile; ?>
				<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); 
				if ( $post->ID == $do_not_duplicate ) continue; ?>
					<?php get_template_part('templates/content', get_post_type() != 'post' ? get_post_type() : get_post_format()); ?>
				<?php endwhile; endif; ?>
			</div>
			
					<?php if (function_exists("pagination")) {pagination($additional_loop->max_num_pages);} ?>

		</div>
		<div class="col-sm-3">
			<?php echo do_shortcode('[newsletter-sidebar]'); ?>
		</div>
	</div>
</div>





