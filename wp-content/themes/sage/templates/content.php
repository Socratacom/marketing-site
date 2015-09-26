<div class="col-sm-6 col-lg-4">
	<div class="card">
		<div class="card-image hidden-xs">
			<img src="<?php echo Roots\Sage\Extras\custom_feature_image('full', 360, 180); ?>" class="img-responsive">	
			<div class="card-avatar">
				<?php echo get_avatar( get_the_author_meta('ID'), 60 ); ?>
			</div>
			<a href="<?php the_permalink() ?>"></a>
		</div>
		<div class="card-text">
			<h4><a href="<?php the_permalink() ?>"><?php the_title(); ?></a></h4>
			<small class="card-meta">By <strong><?php the_author(); ?></strong>, <?php the_time('F jS, Y') ?></small>
			<?php the_excerpt(); ?> 
		</div>
	</div>
</div>