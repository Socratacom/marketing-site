

<div class="container page-padding">
	<div class="row">
		<div class="col-sm-12">
			<?php get_template_part('templates/content', get_post_type() != 'post' ? get_post_type() : get_post_format()); ?>
		</div>
	</div>
</div>