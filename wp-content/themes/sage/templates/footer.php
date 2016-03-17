<footer role="contentinfo">
	<div class="container">
		<div class="row">
			<div class="col-sm-4 col-md-3 margin-bottom-30">
				<ul class="social-icons clearfix">
					<li class="facebook"><a href="https://www.facebook.com/socrata" target="_blank">facebook</a></li>
					<li class="twitter"><a href="https://twitter.com/socrata" class="" target="_blank">twitter</a></li>
					<li class="linkedin"><a href="https://www.linkedin.com/company/socrata" class="" target="_blank">linkedin</a></li>
					<li class="google"><a href="https://plus.google.com/+Socrata/about" class="" target="_blank">googleplus</a></li>
					<li class="youtube"><a href="https://www.youtube.com/user/socratavideos" class="" target="_blank">youtube</a></li>
				</ul>
				<div class="footer-logo gray-logo"></div>
				<ul class="copyright">
					<li>&copy; <?php echo date("Y");?> Socrata. All rights reserved.</li>
					<li>Phone: <a href="tel://1-206-340-8008">+1 (206) 340-8008</a></li>
					<li>Support: <a href="tel://1-888-997-6762">+1 (888) 997-6762</a></li>
					<li><a href="/privacy/">Privacy Policy</a> | <a href="/terms-of-service/">Terms of Service</a></li>
				</ul>
				<div class="footer-form">
					<h4>Subscribe to the Socrata newsletter</h4>
					<?php echo do_shortcode('[marketo-form id="2745"]'); ?>
				</div>
			</div>
			<div class="col-sm-8 col-md-9">
				<div class="row">
					<div class="col-sm-4">
						<h4>Products</h4>
						<?php wp_nav_menu( array( 'theme_location' => 'site_nav_products' ) ); ?>
						<h4>Solutions</h4>				
						<?php wp_nav_menu( array( 'theme_location' => 'site_nav_solutions' ) ); ?>
					</div>
					<div class="col-sm-4">
						<h4>Resources</h4>				
						<?php wp_nav_menu( array( 'theme_location' => 'site_nav_resources' ) ); ?>
						<h4>About</h4>				
						<?php wp_nav_menu( array( 'theme_location' => 'site_nav_about' ) ); ?>
					</div>
					<div class="col-sm-4">
						<h4>Community</h4>				
						<?php wp_nav_menu( array( 'theme_location' => 'site_nav_community' ) ); ?>
						<h4>Additional Links</h4>				
						<?php wp_nav_menu( array( 'theme_location' => 'site_nav_additional_links' ) ); ?>
					</div>
				</div>
			</div>
		</div>
	</div>
</footer>