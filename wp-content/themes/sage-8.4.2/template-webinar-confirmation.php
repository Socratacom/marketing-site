<?php
/**
 * Template Name: Webinar Confirmation
 */
?>

<?php while (have_posts()) : the_post(); ?>
  <?php get_template_part('templates/content', 'webinar-confirmation'); ?>
<?php endwhile; ?>
