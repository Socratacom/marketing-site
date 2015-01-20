<?php

// Header
add_action('thesis_hook_before_html', 'custom_header');
function custom_header() {?>
<?php global $wp_google_tag_manager;
if(is_object($wp_google_tag_manager) && is_a($wp_google_tag_manager,"WpGoogleTagManager")){
$wp_google_tag_manager->output_manual();
} ?>
	<header>
		<div class="wrapper">
			<h1><a href="http://www.socrata.com" class="logo ir">Socrata - The Data Experience Company</a></h1>
			<ul class="company-links">
				<li><a href="tel:2063408008" class="phone">(206) 340-8008</a></li>
				<li><a href="/contact-us">Contact Us</a></li>
				<li><a href="http://support.socrata.com/home">Support</a></li>
				<li><a href="https://opendata.socrata.com/">OpenData</a></li>
			</ul>
			<nav>
				<ul><?php thesis_default_widget('main-navigation'); ?></ul>
				<ul class="social-sites">
					<li><a href="http://www.facebook.com/socrata"><span class="icon-facebook"></span></a></li>
					<li><a href="https://twitter.com/socrata"><span class="icon-twitter"></span></a></li>
					<li><a href="https://plus.google.com/+Socrata/about"><span class="icon-google-plus"></span></a></li>
					<li><a href="http://www.youtube.com/socratavideos"><span class="icon-youtube"></span></a></li>
					<li><a href="http://www.linkedin.com/company/socrata"><span class="icon-linkedin"></span></a></li>				
				</ul>			
			</nav>
		</div>
	</header>
	<?php
}

// Register Sidebars
register_sidebar(array(
	'name' => 'Main Navigation',
	'id' => 'main-navigation',
	'before_title'=>'<h3>',
	'after_title'=>'</h3>'
	));