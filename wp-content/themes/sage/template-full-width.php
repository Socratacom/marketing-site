<?php
/**
 * Template Name: Full Width
 */
?>
<?php while (have_posts()) : the_post(); ?>
	<?php get_template_part('templates/content', 'page'); ?>
<?php endwhile; ?>