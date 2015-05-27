<?php while (have_posts()) : the_post(); ?>
<?php get_fresh_components(); ?>
<div class="container">
  <?php get_template_part('templates/content', 'page'); ?>
</div>
<?php endwhile; ?>
