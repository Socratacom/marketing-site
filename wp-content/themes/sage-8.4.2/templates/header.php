<header class="banner" role="banner" canvas>
  <div class="container">
    <nav class="navbar navbar-default">
      <div class="navbar-header">
        <button id="menuToggle" class="navbar-toggle toggle-id-1">
          <span class="sr-only">Toggle navigation</span>
          <span class="ui-menu__content">
            <i class="ui-menu__line ui-menu__line_1"></i>
            <i class="ui-menu__line ui-menu__line_2"></i>
            <i class="ui-menu__line ui-menu__line_3"></i>
          </span>
        </button>
        <a href="<?php echo home_url('/'); ?>" class="navbar-brand"></a>
      </div>
      <ul class="nav navbar-nav hidden-xs hidden-sm">



        <li class="dropdown">
          <a data-toggle="dropdown" data-submenu>Solutions &amp; Products</a>
          <ul class="dropdown-menu">
            <li class="dropdown-submenu">
              <a>Solutions</a>
              <?php wp_nav_menu( array( 
                  'theme_location' => 'site_nav_solutions',
                  'container'       => '',
                  'menu_class' => 'dropdown-menu' 
                ) ); ?>
            </li>
            <li class="dropdown-submenu">
              <a>Products</a>
              <?php wp_nav_menu( array( 
                  'theme_location' => 'site_nav_products',
                  'container'       => '',
                  'menu_class' => 'dropdown-menu' 
                ) ); ?>
            </li>
          </ul>
        </li>






<!--
        <li class="dropdown">
          <a data-toggle="dropdown">Solutions</a>
          <?php wp_nav_menu( array( 
              'theme_location' => 'site_nav_solutions',
              'container'       => '',
              'menu_class' => 'dropdown-menu' 
            ) ); ?>
        </li>



-->
        <li class="dropdown">
          <a data-toggle="dropdown">Services</a>
          <?php wp_nav_menu( array( 
              'theme_location' => 'site_nav_services',
              'container'       => '',
              'menu_class' => 'dropdown-menu' 
            ) ); ?>
        </li>
        <li class="dropdown">
          <a data-toggle="dropdown" data-submenu>More</a>
          <ul class="dropdown-menu">
            <li><a href="/blog">Blog</a></li>
            <li class="dropdown-submenu">
              <a>Resources</a>
              <?php wp_nav_menu( array( 
                  'theme_location' => 'site_nav_resources',
                  'container'       => '',
                  'menu_class' => 'dropdown-menu' 
                ) ); ?>
            </li>
            <li class="dropdown-submenu">
              <a>Community</a>
              <?php wp_nav_menu( array( 
                  'theme_location' => 'site_nav_community',
                  'container'       => '',
                  'menu_class' => 'dropdown-menu' 
                ) ); ?>
            </li>
          </ul>
        </li>
      </ul>
      <ul class="header-search navbar-right hidden-xs hidden-sm">
        <li>
          <form role="search" method="get" class="search-form" action="<?php echo home_url( '/' ); ?>" >
            <label class="sr-only">Search for:</label>
            <input type="search" class="search-field" placeholder="Search Socrata" value="" name="s" title="Search for:" data-swplive="true" data-swpconfig />
            <button type="submit" class="btn btn-default"><i class="fa fa-search" aria-hidden="true"></i></button>
          </form>
        </li>
        <li><a href="/contact-us" class="btn btn-primary">Contact us</a></li>
      </ul>
    </nav>
  </div>
</header>

<div off-canvas="id-1 left overlay">
  <div class="mobile-search">
    <form role="search" method="get" class="search-form" action="<?php echo home_url( '/' ); ?>" >
      <label class="sr-only">Search for:</label>
      <input type="search" class="search-field" placeholder="Search Socrata" value="" name="s" title="Search for:" />
      <button type="submit" class="btn btn-primary"><i class="fa fa-search" aria-hidden="true"></i></button>
    </form>
  </div>

  <ul class="mobile-nav">
    <li><a href="<?php echo home_url('/'); ?>">Home</a></li>
    <li class="submenu">
      <a data-toggle="collapse" data-target="#collapseSolutions" aria-expanded="false" aria-controls="collapseSolutions">Solutions</a>
      <?php wp_nav_menu( array( 
            'theme_location' => 'site_nav_solutions',
            'container'       => '',              
            'menu_id' => 'collapseSolutions', 
            'menu_class' => 'collapse' 
          ) ); ?>
    </li>
    <li class="submenu">
      <a data-toggle="collapse" data-target="#collapseProducts" aria-expanded="false" aria-controls="collapseProducts">Products</a>
      <?php wp_nav_menu( array( 
            'theme_location' => 'site_nav_products',
            'container'       => '',              
            'menu_id' => 'collapseProducts', 
            'menu_class' => 'collapse' 
          ) ); ?>
    </li>
    <li class="submenu">
      <a data-toggle="collapse" data-target="#collapseServices" aria-expanded="false" aria-controls="collapseServices">Services</a>
      <?php wp_nav_menu( array( 
            'theme_location' => 'site_nav_services',
            'container'       => '',              
            'menu_id' => 'collapseServices', 
            'menu_class' => 'collapse' 
          ) ); ?>
    </li>
    <li><a href="/blog">Blog</a></li>
    <li class="submenu">
      <a data-toggle="collapse" data-target="#collapseResources" aria-expanded="false" aria-controls="collapseResources">Resources</a>
      <?php wp_nav_menu( array( 
            'theme_location' => 'site_nav_resources',
            'container'       => '',              
            'menu_id' => 'collapseResources', 
            'menu_class' => 'collapse' 
          ) ); ?>
    </li>
    <li class="submenu">
      <a data-toggle="collapse" data-target="#collapseCommunity" aria-expanded="false" aria-controls="collapseCommunity">Community</a>
      <?php wp_nav_menu( array( 
            'theme_location' => 'site_nav_community',
            'container'       => '',              
            'menu_id' => 'collapseCommunity', 
            'menu_class' => 'collapse' 
          ) ); ?>
    </li>
    <li class="submenu">
      <a data-toggle="collapse" data-target="#collapseCompany" aria-expanded="false" aria-controls="collapseCompany">Company</a>
      <?php wp_nav_menu( array( 
            'theme_location' => 'site_nav_company',
            'container'       => '',              
            'menu_id' => 'collapseCompany', 
            'menu_class' => 'collapse' 
          ) ); ?>
    </li>
  </ul>             

</div>



