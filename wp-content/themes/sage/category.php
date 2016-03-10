

<div class="container page-padding">
	<div class="row">
		<div class="col-sm-12">
			<?php 
			$cat = get_category( get_query_var( 'cat' ) );
			$category = $cat->slug;
			echo do_shortcode('[ajax_load_more category="'.$category.'" posts_per_page="6"]');
			?>
		</div>
	</div>
</div>