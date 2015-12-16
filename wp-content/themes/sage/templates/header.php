<header class="banner" role="banner">
  <nav class="navbar navbar-default ">
    <div class="container">
      <!-- Brand and toggle get grouped for better mobile display -->
      <div class="navbar-header">
        <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
          <span class="sr-only">Toggle navigation</span>
          <span class="ui-menu__content">
            <i class="ui-menu__line ui-menu__line_1"></i>
            <i class="ui-menu__line ui-menu__line_2"></i>
            <i class="ui-menu__line ui-menu__line_3"></i>
          </span>
        </button>
        <a class="white-logo header-logo" href="<?php echo home_url('/'); ?>"></a>
      </div>

      <!-- Collect the nav links, forms, and other content for toggling -->
      <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
        <ul class="nav navbar-nav navbar-right">
          <li class="dropdown">
            <a href="/products" class="hidden-xs hidden-sm hidden-md">Products</a>
            <a href="#" class="dropdown-toggle hidden-lg" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Products</a>
            <?php wp_nav_menu( array( 
              'theme_location' => 'site_nav_products',
              'container'       => '',
              'menu_class' => 'dropdown-menu' 
            ) ); ?>
          </li>
          <li class="dropdown">
            <a href="/solutions" class="hidden-xs hidden-sm hidden-md">Solutions</a>
            <a href="#" class="dropdown-toggle hidden-lg" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Solutions</a>
            <?php wp_nav_menu( array( 
              'theme_location' => 'site_nav_solutions',
              'container'       => '',
              'menu_class' => 'dropdown-menu' 
            ) ); ?>
          </li>
          <li class="dropdown">
            <a href="#" class="hidden-xs hidden-sm hidden-md">Resources</a>
            <a href="#" class="dropdown-toggle hidden-lg" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Resources</a>
            <?php wp_nav_menu( array( 
              'theme_location' => 'site_nav_resources',
              'container'       => '',
              'menu_class' => 'dropdown-menu' 
            ) ); ?>
          </li>
          <li class="dropdown">
            <a href="#" class="hidden-xs hidden-sm hidden-md">Community</a>
            <a href="#" class="dropdown-toggle hidden-lg" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Community</a>
            <?php wp_nav_menu( array( 
              'theme_location' => 'site_nav_community',
              'container'       => '',
              'menu_class' => 'dropdown-menu' 
            ) ); ?>
          </li>
          <li class="dropdown">
            <a href="#" class="hidden-xs hidden-sm hidden-md">About</a>
            <a href="#" class="dropdown-toggle hidden-lg" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">About</a>
            <?php wp_nav_menu( array( 
              'theme_location' => 'site_nav_about',
              'container'       => '',
              'menu_class' => 'dropdown-menu' 
            ) ); ?>
          </li>
          <li id="header-cta-button" class="hidden-xs hidden-sm"><a href="/request-a-demo/" class="btn btn-default">Schedule a Meeting</a></li>
        </ul>
      </div><!-- /.navbar-collapse -->
    </div><!-- /.container-fluid -->
  </nav>
</header>
