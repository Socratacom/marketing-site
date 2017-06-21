<?php
/**
 * Template Name: Home Page Takeover
 */
?>

<?php while (have_posts()) : the_post(); ?>
  <?php get_template_part('templates/content', 'home-takeover'); ?>
<?php endwhile; ?>