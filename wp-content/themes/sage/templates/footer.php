<footer class="content-info" role="contentinfo">
  <div class="container">
    <div class="col-md-2 col-sm-12 contact">
      <h3>Contact</h3>
      <p><strong>Phone:</strong> 206.340.8008</p>
      <p><strong>Fax:</strong> 206.452.2010</p>
      <p><strong>Email:</strong> info@socrata.com</p>
      <p><strong><a href="#">Contact Us</a></strong></p>
    </div>
    <div class="col-md-10 col-sm-12 footer-nav hidden-xs">
     <?php
      if (has_nav_menu('primary_navigation')) :
        wp_nav_menu(['theme_location' => 'primary_navigation', 'menu_class' => 'hidden-xs', 'depth' => 3]);
      endif;
      ?>
    </div>
  </div>
  <div class="container">
    <p class="copyright">Copyright &copy; <?php echo date("Y");?> Socrata, Inc. All rights reserved. &bull; <a href="/privacy/">Privacy Policy</a> &bull; <a href="/terms-of-service/">Terms of Service</a></p>
    <a class="white-logo header-logo" href="<?php echo home_url('/'); ?>"></a>
  </div>
</footer>
