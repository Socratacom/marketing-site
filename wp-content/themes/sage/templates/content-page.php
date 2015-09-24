<div class="container page-padding">
	<div class="row">
		<div class="col-sm-12">
			<?php the_content(); ?>
			<?php wp_link_pages(['before' => '<nav class="page-nav"><p>' . __('Pages:', 'sage'), 'after' => '</p></nav>']); ?>
		</div>
	</div>
</div>