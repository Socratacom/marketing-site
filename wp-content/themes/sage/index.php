<?php get_template_part('templates/page', 'header'); ?>

<?php if (!have_posts()) : ?>
  <div class="alert alert-warning">
    <?php _e('Sorry, no results were found.', 'sage'); ?>
  </div>
  <?php get_search_form(); ?>
<?php endif; ?>
<div class="container page-padding">
	<div class="row">
		<div class="col-sm-9">
			<div class="row">
			<?php while (have_posts()) : the_post(); ?>
			<?php get_template_part('templates/content', get_post_type() != 'post' ? get_post_type() : get_post_format()); ?>
			<?php endwhile; ?>
			</div>
		</div>
		<div class="col-sm-3">
			<?php echo do_shortcode('[newsletter-sidebar]'); ?>
		</div>
	</div>
	<div class="row">
		<div class="col-sm-12">
			<?php if (function_exists("pagination")) {pagination($additional_loop->max_num_pages);} ?>
		</div>
	</div>
</div>


