<?php
/**
 * Template Name: Home Page Alt
 */
?>

<?php while (have_posts()) : the_post(); ?>
  <?php get_template_part('templates/content', 'home-alt'); ?>
<?php endwhile; ?>