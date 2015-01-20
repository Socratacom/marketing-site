<?php

// Enqueue Scripts
add_action('wp_enqueue_scripts', 'customer_summit_scripts');
function customer_summit_scripts() {
  if (is_page(array('customer-summit', 'customer-summit-subscribe'))) {
    wp_register_script( 'twitter-widget', '//platform.twitter.com/widgets.js', false, null);
    wp_enqueue_script('twitter-widget');
    wp_register_script( 'full-width-container', get_stylesheet_directory_uri() . '/custom/customer_summit/scripts/full-width-container.js', false, null, true);
    wp_enqueue_script('full-width-container');
    wp_register_script( 'lightbox', get_stylesheet_directory_uri() . '/custom/customer_summit/scripts/featherlight.js', false, null, true);
    wp_enqueue_script('lightbox');
    wp_register_style( 'cs-styles', get_stylesheet_directory_uri() . '/custom/customer_summit/css/styles.css' );
    wp_enqueue_style( 'cs-styles' );
  }
}

add_action('thesis_hook_after_html', 'cs_videos');
function cs_videos() {
  if (is_page('customer-summit')) { ?>
  <iframe id="hero-vid" class="lightbox" src="//www.youtube.com/embed/aOmcN3Iwi7w?rel=0&amp;showinfo=0" frameborder="0" allowfullscreen ></iframe>
  <iframe id="vid-1" class="lightbox" width="560" height="315" src="//www.youtube.com/embed/7F6z_jt6iXs?rel=0&amp;showinfo=0" frameborder="0" allowfullscreen ></iframe>
  <iframe id="vid-2" class="lightbox" width="560" height="315" src="//www.youtube.com/embed/AvU3gf9m7SQ?rel=0&amp;showinfo=0" frameborder="0" allowfullscreen ></iframe>
  <iframe id="vid-3" class="lightbox" width="560" height="315" src="//www.youtube.com/embed/K49WtVlve68?rel=0&amp;showinfo=0" frameborder="0" allowfullscreen ></iframe>
  <iframe id="vid-4" class="lightbox" width="560" height="315" src="//www.youtube.com/embed/_6LYkGR1I3k?rel=0&amp;showinfo=0" frameborder="0" allowfullscreen ></iframe>
  <iframe id="vid-5" class="lightbox" width="560" height="315" src="//www.youtube.com/embed/JHKwY103Tbg?rel=0&amp;showinfo=0" frameborder="0" allowfullscreen ></iframe>
  <iframe id="vid-6" class="lightbox" width="560" height="315" src="//www.youtube.com/embed/fA5RUIw6xjE?rel=0&amp;showinfo=0" frameborder="0" allowfullscreen ></iframe>
  <iframe id="vid-7" class="lightbox" width="560" height="315" src="//www.youtube.com/embed/n5-bC1lT5LA?rel=0&amp;showinfo=0" frameborder="0" allowfullscreen ></iframe>
  <iframe id="vid-8" class="lightbox" width="560" height="315" src="//www.youtube.com/embed/Xmnt9_MBpWU?rel=0&amp;showinfo=0" frameborder="0" allowfullscreen ></iframe>
  <iframe id="vid-9" class="lightbox" width="560" height="315" src="//www.youtube.com/embed/ImAh_ZmCFkI?rel=0&amp;showinfo=0" frameborder="0" allowfullscreen ></iframe>
  <iframe id="vid-10" class="lightbox" width="560" height="315" src="//www.youtube.com/embed/MYEDX4fCn_M?rel=0&amp;showinfo=0" frameborder="0" allowfullscreen ></iframe>
  <iframe id="vid-11" class="lightbox" width="560" height="315" src="//www.youtube.com/embed/ux9T_YXZdYc?rel=0&amp;showinfo=0" frameborder="0" allowfullscreen ></iframe>
  <iframe id="vid-12" class="lightbox" width="560" height="315" src="//www.youtube.com/embed/XNrX4RnJzJc?rel=0&amp;showinfo=0" frameborder="0" allowfullscreen ></iframe>
  <iframe id="vid-13" class="lightbox" width="560" height="315" src="//www.youtube.com/embed/4MuAkLZ1lRM?rel=0&amp;showinfo=0" frameborder="0" allowfullscreen ></iframe>
  <iframe id="vid-14" class="lightbox" width="560" height="315" src="//www.youtube.com/embed/HV0Lf-Cd-gs?rel=0&amp;showinfo=0" frameborder="0" allowfullscreen ></iframe>
    <?php }
}

// Body Classes for Sidebar Styling
add_filter('thesis_body_classes', 'customer_summit_styling');
function customer_summit_styling($classes) {
  if (is_page('customer-summit-subscribe')) { 
    $classes[] = 'customer-summit'; 
  }
  return $classes; 
}