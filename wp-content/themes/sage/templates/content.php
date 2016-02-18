<?php $thumb = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'post-thumbnail' ); $url = $thumb['0']; ?>
<div class="col-sm-6 col-lg-4">
	<div class="card">
		<div class="card-image hidden-xs">			
			<?php if ( has_post_thumbnail() ) { ?>
				<img src="<?=$url?>" class="img-responsive">
			<?php
			} else { ?>
				<img src="/wp-content/uploads/no-image.png" class="img-responsive">
			<?php
			}
			?>
			<div class="card-avatar">
				<?php echo get_avatar( get_the_author_meta('ID'), 60 ); ?>
			</div>
			<a href="<?php the_permalink() ?>"></a>
		</div>
		<div class="card-text truncate">
			<p class="categories"><small><?php Roots\Sage\Extras\blog_the_categories(); ?><small></p>
			<h4><a href="<?php the_permalink() ?>"><?php the_title(); ?></a></h4>
			<p class="meta"><small>By <strong><?php the_author(); ?></strong>, <?php the_time('F j, Y') ?></small></p>
			<?php the_excerpt(); ?> 
		</div>
	</div>
</div>