<?php use Roots\Sage\Nav; ?>

<header class="banner navbar navbar-default navbar-static-top" role="banner">
  <div class="container">
    <div class="navbar-header">
      <a class="white-logo header-logo" href="<?php echo home_url('/'); ?>"></a>
      <ul class="social-icons hidden-xs">
        <li><a href="https://www.facebook.com/socrata" target="_blank"><i class="fa fa-facebook"></i></a></li>
        <li><a href="https://twitter.com/socrata" target="_blank"><i class="fa fa-twitter"></i></a></li>
        <li><a href="https://www.linkedin.com/company/socrata" target="_blank"><i class="fa fa-linkedin"></i></a></li>
        <li><a href="https://plus.google.com/+Socrata/about" target="_blank"><i class="fa fa-google-plus"></i></a></li>
        <li><a href="https://www.youtube.com/user/socratavideos" target="_blank"><i class="fa fa-youtube-play"></i></a></li>
        <li><a href="#"><i class="fa fa-search"></i></a></li>
      </ul>
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target=".navbar-collapse">
        <span class="sr-only"><?= __('Toggle navigation', 'sage'); ?></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
    </div>
    <nav class="collapse navbar-collapse" role="navigation">
      <?php
      if (has_nav_menu('primary_navigation')) :
        wp_nav_menu(['theme_location' => 'primary_navigation', 'walker' => new Nav\SageNavWalker(), 'menu_class' => 'nav navbar-nav hidden-xs']);
      endif;
      ?>
      <?php
      if (has_nav_menu('mobile')) :
        wp_nav_menu(['theme_location' => 'mobile', 'walker' => new Nav\SageNavWalker(), 'menu_class' => 'nav navbar-nav hidden-sm hidden-md hidden-lg']);
      endif;
      ?>
    </nav>
  </div>
</header>
