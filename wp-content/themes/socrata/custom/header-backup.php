<?php

// Header
add_action('thesis_hook_before_html', 'custom_header',1);
function custom_header() {?>
<?php global $wp_google_tag_manager;
if(is_object($wp_google_tag_manager) && is_a($wp_google_tag_manager,"WpGoogleTagManager")){
$wp_google_tag_manager->output_manual();
} ?>

<header>
    <div class="wrapper format_text">
        <div class="logo color-logo"></div>
        <div class="logo-link"><a href="/" class="logo-link" title="Socrata, The Data Experience Company"></a></div>
        <nav>
        <ul class="nav-menu">
            <li class="nav-item">
                <a href="/products/">Products <span class="ss-icon">descend</span></a>
                <div class="sub-nav sub-nav-full">
                    <div class="sub-nav-group one_third">
                        <h4><a href="/products/open-data-portal/">Open Data Portal</a></h4>
                        <p>The Socrata Open Data Portal&trade; simplifies data movement by making it easy to upload, query, analyze, visualize, and share.</p>                      
                    </div>
                    <div class="sub-nav-group one_third">
                        <h4><a href="/products/govstat/">Open Performance (GovStat)</a></h4>
                        <p>Socrata Open Performance&trade; not only helps you set goals, but measure their impact against data, perform broad analysis, and share your results automatically.</p> 
                    </div>
                    <div class="sub-nav-group one_third last">
                        <h4><a href="/products/custom-web-and-mobile-apps-government-data/">Open Data Apps</a></h4>
                        <p>Data hosted on Socrata enters an ecosystem where the brightest minds in the world can analyze it, create products, and share it back again.</p> 
                    </div>
                    <div class="clearboth"></div>
                    <div class="sub-nav-group one_third">
                        <h4><a href="/apps" target="_blank">Socrata Apps Marketplace</a></h4>
                        <p>The Socrata Apps Marketplace features innovative applications for citizens, businesses, and local government. Find the best services Socrata and the open data community have to offer.</p> 
                    </div>
                    <div class="sub-nav-group one_third">
                        <h4><a href="/products/open-data-network-ecosystem/">Open Data Network</a></h4>
                        <p>The Open Data Network™ brings together a vast ecosystem of participants, taking an industry-specific approach to streamline the access and syndication of open data.</p> 
                    </div>
                    <div class="sub-nav-group one_third last">
                        <h4><a href="/products/open-data-cloud-platform/ ">Socrata Platform</a></h4>
                        <p>The Socrata Platform makes it easy to put your data where researchers, developers, and entrepreneurs can access it and create new products.</p> 
                    </div>
                    <div class="clearboth"></div>
                    <div class="sub-nav-group one_third">
                        <h4><a href="/products/open-data-api">Open Data API</a></h4>
                        <p>Socrata Open Data API&trade; (SODA) makes every Socrata-hosted dataset uniformly accessible, searchable, and easy to combine with other web services.</p>
                    </div>
                    <div class="sub-nav-group one_third">
                        <h4><a href="/products/api-foundry/">API Foundry</a></h4>
                        <p>With Socrata API Foundry&trade; you can build robust, flexible, customized APIs in minutes, and ensure that your data is easily available to developers.</p> 
                    </div>
                    <div class="sub-nav-group one_third last">
                        <h4><a href="/products/open-source-development-community/ ">Open Source</a></h4>
                        <p>Socrata &lt;3 open source. Learn about our commitment to the open source community, open standards, and data portability and interoperability.</p> 
                    </div>
                    <div class="clearboth"></div>
                </div>
            </li>
            <li class="nav-item">
                <a href="/industries/">Industries <span class="ss-icon">descend</span></a>
                <div class="sub-nav sub-nav-full">
                    <div class="sub-nav-group one_third">
                        <h3>Industry Solutions</h3>
                        <?php wp_nav_menu( array( 'theme_location' => 'industry-solutions' ) ); ?>
                    </div>
                    <div class="sub-nav-group one_third">
                        <h3>Recent Case Study</h3>                        
                        <?php echo do_shortcode('[recent-case-study]');?>
                    </div>
                    <div class="sub-nav-group one_third last">
                        <h3>Open Data Field Guide</h3>
                        <div class="one_third"><a href="/open-data-field-guide/"><img src="/wp-content/uploads/open-data-standards-thumb.jpg" style="width:90%;"></a></div>
                        <div class="two_third last"><h4><a href="/open-data-field-guide/">Read the Definitive Guide on Achieving Open Data Success</a></h4><p>We've worked with leading open data experts to compile the industry's best practices. Learn how to ensure you and your citizens can get the most out of open data at every stage.</p></div>
                        <div class="clearboth"></div>
                    </div>
                    <div class="clearboth"></div>
                </div>
            </li>
            <li class="nav-item">
                <a href="/resources">Learning <span class="ss-icon">descend</span></a>
                <div class="sub-nav sub-nav-full">
                    <div class="sub-nav-group one_fourth">
                        <h3>By Topic</h3>
                        <?php wp_nav_menu( array( 'theme_location' => 'learning-by-topic' ) ); ?>
                    </div>
                    <div class="sub-nav-group one_fourth">
                        <h3>By Content Type</h3>
                        <?php wp_nav_menu( array( 'theme_location' => 'learning-by-content-type' ) ); ?>
                    </div>
                    <div class="sub-nav-group one_fourth">
                        <h3>Open Innovation Magazine</h3>
                        <?php echo do_shortcode('[menu-magazine]');?>
                    </div>
                    <div class="sub-nav-group one_fourth last">
                        <h3>Recent Blog Post</h3>
                        <?php echo do_shortcode('[menu-blog]');?>
                    </div>
                    <div class="clearboth"></div>
                </div>
            </li>
            <li class="nav-item">
                <a href="/partner">Partners <span class="ss-icon">descend</span></a>
                <div class="sub-nav sub-nav-full">
                    <div class="sub-nav-group one_third">
                        <h3>Work with Us</h3>
                        <?php wp_nav_menu( array( 'theme_location' => 'partner-links' ) ); ?>
                    </div>
                    <div class="sub-nav-group one_third">
                        <h3>Sell Your App</h3>
                        <div class="one_third"><a href="/apps/submit-app" target="_blank"><img src="/wp-content/uploads/app-icons.png" style="width:90%;"></a></div>
                        <div class="two_third last"><h4><a href="/apps/submit-app" target="_blank">
                            Promote and Sell through the Socrata Apps Marketplace</a></h4><p>The Socrata Apps Marketplace features some of the best applications from the open data community. It is an ideal vehicle to help you promote and even monetize your civic app.</p></div>
                        <div class="clearboth"></div>
                    </div>
                    <div class="sub-nav-group one_third last">
                        <h3>Demo for Partners</h3>
                        <div class="one_third"><a href="/partner/demo" target="_blank"><img src="/wp-content/uploads/register-icon.png" style="width:90%;"></a></div>
                        <div class="two_third last"><h4><a href="/partner/demo" target="_blank">Register for the Next Monthly Demo</a></h4><p>See Socrata's technology in action through real customer stories, and discover opportunities to grow your business by partnering with us.</p></div>
                        <div class="clearboth"></div>
                    </div>
                    <div class="clearboth"></div>
                </div>
            </li>
            <!--<li class="nav-item">
                <a href="#" class="nav-link">Services</a>
            </li>-->
            <li class="nav-item">
                <a href="/company-info">Company <span class="ss-icon">descend</span></a>
                <div class="sub-nav sub-nav-full">
                    <div class="sub-nav-group one_fourth">
                        <h3>Company Links</h3>
                        <?php wp_nav_menu( array( 'theme_location' => 'company-links' ) ); ?>
                    </div>
                    <div class="sub-nav-group one_fourth">
                        <h3>Additional Links</h3>
                        <?php wp_nav_menu( array( 'theme_location' => 'company-additional-links' ) ); ?>
                    </div>
                    <div class="sub-nav-group one_fourth">
                        <h3>Recent Press Release</h3>
                        <?php echo do_shortcode('[menu-news category="press-releases"]');?>
                    </div>
                    <div class="sub-nav-group one_fourth last">
                        <h3>Contact Us</h3>
                        <p><strong>Headquartered in Seattle, WA</strong><br><strong>Phone:</strong> 206.340.8008<br><strong>Support:</strong> 206.340.8008 ext. 3<br><strong>Fax:</strong> 206.452.2010<br><strong>Outside U.S.:</strong> +44.7827.966.852</p>
                        <p><a href="/contact-us">Contact Us</a></p>
                    </div>
                    <div class="clearboth"></div>
                </div>
            </li>
        </ul>
        </nav>
        <section class="search">
        <div id="sb-search" class="sb-search">
            <form role="search" method="get" class="search-form" action="<?php echo home_url( '/' ); ?>">
                <input type="search" class="search-field sb-search-input" placeholder="Enter your search term..." value="" name="s" title="Search for:" id="search" />
                <input type="submit" class="search-submit sb-search-submit" value="Search" />
                <span class="sb-icon-search ss-icon">search</span> 
            </form>
        </div>
        </section>
        <ul class="social-icons">
            <li><a href="https://www.facebook.com/socrata" class="ss-icon ss-social-regular" target="_blank">facebook</a></li>
            <li><a href="https://twitter.com/socrata" class="ss-icon ss-social-regular" target="_blank">twitter</a></li>
            <li><a href="https://www.linkedin.com/company/socrata" class="ss-icon ss-social-regular" target="_blank">linkedin</a></li>
            <li><a href="https://plus.google.com/+Socrata/about" class="ss-icon ss-social-regular" target="_blank">googleplus</a></li>
            <li><a href="https://www.youtube.com/user/socratavideos" class="ss-icon ss-social-regular" target="_blank">youtube</a></li>
        </ul>
    </div>  
</header>
<ul id="gn-menu" class="gn-menu-main">
    <li class="gn-trigger">
        <a class="gn-icon-menu ss-icon">rows</a>
        <nav class="gn-menu-wrapper">
            <div class="gn-scroller">
                <ul class="gn-menu">
                    <li><a href="/products/"><span class="ss-icon">box</span> Products</a></li>
                    <li><a href="/industries/"><span class="ss-icon">office</span> Industries</a></li>
                    <li><a href="/blog/"><span class="ss-icon">apple</span> Learning</a></li>
                    <li><a href="/partner/"><span class="ss-icon">usergroup</span> Partners</a></li> 
                    <!--<li><a href="#"><span class="ss-icon">puzzle</span> Services</a></li>-->
                    <li><a href="/company-info/"><span class="ss-icon">bank</span> Company</a></li> 
                    <li><a href="/contact-us/"><span class="ss-icon">headset</span> Contact Us</a></li>
                    <li><a href="https://www.facebook.com/socrata"><span class="ss-icon ss-social-regular" target="_blank">facebook</span> Facebook</a></li>
                    <li><a href="https://twitter.com/socrata"><span class="ss-icon ss-social-regular" target="_blank">twitter</span> Twitter</a></li>
                    <li><a href="https://www.linkedin.com/company/socrata"><span class="ss-icon ss-social-regular" target="_blank">linkedin</span> LinkedIn</a></li>
                    <li><a href="https://plus.google.com/+Socrata/about"><span class="ss-icon ss-social-regular" target="_blank">googleplus</span> Google Plus</a></li>
                    <li><a href="https://www.youtube.com/user/socratavideos"><span class="ss-icon ss-social-regular" target="_blank">youtube</span> YouTube</a></li>         
                </ul>
            </div><!-- /gn-scroller -->
        </nav>
    </li>
</ul>
<?php
}

// Register Menus

add_action( 'init', 'register_my_menus' );
function register_my_menus() {
  register_nav_menus(
    array(
        'industry-solutions' => __( 'Industry Solutions' ),
        'learning-by-topic' => __( 'Learning By Topic' ),
        'learning-by-content-type' => __( 'Learning By Content Type' ),
        'company-links' => __( 'Company Links' ),
        'company-additional-links' => __( 'Company Additional Links' ),
        'partner-links' => __( 'Partner Links' )
    )
  );
}

// SHORTCODE FOR PRESS RELEASE MENU DISPLAY
// [menu-news category="ENTER CATAGORY SLUG"]
add_shortcode('menu-news','menu_news_shortcode');
function menu_news_shortcode( $atts ) {
  ob_start();
  extract( shortcode_atts( array (
    'type' => 'news',
    'order' => 'date',
    'orderby' => 'desc',
    'posts' => 1,
    'category' => '',
  ), $atts ) );
  $options = array(
    'post_type' => $type,
    'order' => $order,
    'orderby' => $orderby,
    'posts_per_page' => $posts,
    'news_category' => $category,
  );
  $query = new WP_Query( $options );
  if ( $query->have_posts() ) { ?>  
    <?php while ( $query->have_posts() ) : $query->the_post(); ?>
    <?php if(has_post_thumbnail()) :?>
    <?php $thumb = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'thumbnail' ); $url = $thumb['0']; ?>
    <?php endif;?>  
    <div class="one_third" style="padding-top:5px;">
        <a href="<?php the_permalink() ?>"><img src="<?=$url?>" style="width:90%"></a>
    </div>
    <div class="two_third last">
        <h4><a href="<?php the_permalink() ?>"><?php the_title(); ?></a></h4>
        <p><?php
          $theexcerpt = get_the_excerpt();
          $getlength = strlen($theexcerpt);
          $thelength = 140;
          echo substr($theexcerpt, 0, $thelength);
          if ($getlength > $thelength) echo "...";
        ?></p>
    </div>
    <div class="clearboth"></div>    
    <?php endwhile;
    wp_reset_postdata(); ?>     
  <?php $myvariable = ob_get_clean();
  return $myvariable;
  } 
}

// SHORTCODE FOR BLOG MENU DISPLAY
// [menu-blog]
add_shortcode('menu-blog','menu_blog_shortcode');
function menu_blog_shortcode( $atts ) {
  ob_start();
  extract( shortcode_atts( array (
    'type' => 'post',
    'order' => 'date',
    'orderby' => 'desc',
    'posts' => 1,
    'category' => '',
  ), $atts ) );
  $options = array(
    'post_type' => $type,
    'order' => $order,
    'orderby' => $orderby,
    'posts_per_page' => $posts,
    'category' => $category,
  );
  $query = new WP_Query( $options );
  if ( $query->have_posts() ) { ?>  
    <?php while ( $query->have_posts() ) : $query->the_post(); ?>
    <?php if(has_post_thumbnail()) :?>
    <?php $thumb = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'thumbnail' ); $url = $thumb['0']; ?>
    <?php endif;?>  
    <div class="one_third" style="padding-top:5px;">
        <a href="<?php the_permalink() ?>"><img src="<?=$url?>" style="width:90%"></a>
    </div>
    <div class="two_third last">
        <h4><a href="<?php the_permalink() ?>"><?php the_title(); ?></a></h4>
        <p><?php
          $theexcerpt = get_the_excerpt();
          $getlength = strlen($theexcerpt);
          $thelength = 140;
          echo substr($theexcerpt, 0, $thelength);
          if ($getlength > $thelength) echo "...";
        ?></p>
    </div>
    <div class="clearboth"></div>    
    <?php endwhile;
    wp_reset_postdata(); ?>     
  <?php $myvariable = ob_get_clean();
  return $myvariable;
  } 
}

// SHORTCODE FOR MAGAZINE
// [menu-magazine]
add_shortcode('menu-magazine','menu_magazine_shortcode');
function menu_magazine_shortcode( $atts ) {
  ob_start();
  extract( shortcode_atts( array (
    'type' => 'oi_magazine',
    'order' => 'date',
    'orderby' => 'desc',
    'posts' => 1,
    'category' => '',
  ), $atts ) );
  $options = array(
    'post_type' => $type,
    'order' => $order,
    'orderby' => $orderby,
    'posts_per_page' => $posts,
    'category' => $category,
  );
  $query = new WP_Query( $options );
  if ( $query->have_posts() ) { ?>  
    <?php while ( $query->have_posts() ) : $query->the_post(); ?>
    <?php if(has_post_thumbnail()) :?>
    <?php $thumb = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'small' ); $url = $thumb['0']; ?>
    <?php endif;?>  
    <div class="one_third" style="padding-top:5px;">
        <a href="<?php the_permalink() ?>"><img src="<?=$url?>" style="width:90%; border:#d1d1d1 solid 1px; padding:3px; -webkit-box-sizing: border-box; -moz-box-sizing:border-box; box-sizing:border-box;"></a>
    </div>
    <div class="two_third last">
        <h4><a href="<?php the_permalink() ?>"><?php the_title(); ?></a></h4>
        <p><strong>In this issue:</strong><br/>
            <?php $meta = get_magazine_meta(); if ($meta[2]) echo "$meta[2]";?><?php $meta = get_magazine_meta(); if ($meta[3]) echo ", $meta[3]";?><?php $meta = get_magazine_meta(); if ($meta[4]) echo ", $meta[4]";?><?php $meta = get_magazine_meta(); if ($meta[5]) echo ", $meta[5]";?><?php $meta = get_magazine_meta(); if ($meta[6]) echo ", $meta[6]";?><?php $meta = get_magazine_meta(); if ($meta[7]) echo ", $meta[7]";?></p>
    </div>
    <div class="clearboth"></div>    
    <?php endwhile;
    wp_reset_postdata(); ?>     
  <?php $myvariable = ob_get_clean();
  return $myvariable;
  } 
}

// SHORTCODE FOR CASE STUDY
// [recent-case-study]
add_shortcode('recent-case-study','recent_case_study_shortcode');
function recent_case_study_shortcode( $atts ) {
  ob_start();
  extract( shortcode_atts( array (
    'type' => 'case_study',
    'order' => 'date',
    'orderby' => 'desc',
    'posts' => 1,
    'category' => '',
  ), $atts ) );
  $options = array(
    'post_type' => $type,
    'order' => $order,
    'orderby' => $orderby,
    'posts_per_page' => $posts,
    'category' => $category,
  );
  $query = new WP_Query( $options );
  if ( $query->have_posts() ) { ?>  
    <?php while ( $query->have_posts() ) : $query->the_post(); ?>
    <?php if(has_post_thumbnail()) :?>
    <?php $thumb = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'thumbnail' ); $url = $thumb['0']; ?>
    <?php endif;?>  
    <div class="one_third" style="padding-top:5px;">
        <a href="<?php the_permalink() ?>"><img src="<?=$url?>" style="width:90%"></a>
    </div>
    <div class="two_third last">
        <h4><a href="<?php the_permalink() ?>"><?php the_title(); ?></a></h4>
        <p><?php
          $theexcerpt = get_the_excerpt();
          $getlength = strlen($theexcerpt);
          $thelength = 140;
          echo substr($theexcerpt, 0, $thelength);
          if ($getlength > $thelength) echo "...";
        ?></p>
    </div>
    <div class="clearboth"></div>   
    <?php endwhile;
    wp_reset_postdata(); ?>     
  <?php $myvariable = ob_get_clean();
  return $myvariable;
  } 
}


