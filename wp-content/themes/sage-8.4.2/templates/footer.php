<footer role="contentinfo" class="section-padding">
	<div class="container">
		<div class="row">
			<div class="col-sm-3">
				<ul class="social-icons clearfix">
					<li class="facebook"><a href="https://www.facebook.com/socrata" target="_blank">facebook</a></li>
					<li class="twitter"><a href="https://twitter.com/socrata" class="" target="_blank">twitter</a></li>
					<li class="linkedin"><a href="https://www.linkedin.com/company/socrata" class="" target="_blank">linkedin</a></li>
					<li class="youtube"><a href="https://www.youtube.com/user/socratavideos" class="" target="_blank">youtube</a></li>
				</ul>
				<div class="footer-logo color-logo"></div>
				<ul class="copyright">
					<li>&copy; <?php echo date("Y");?> Socrata. All rights reserved.</li>
					<li>Phone: <a href="tel://1-206-340-8008">+1 (206) 340-8008</a></li>
					<li>Support: <a href="tel://1-888-997-6762">+1 (888) 997-6762</a></li>
					<li><a href="/privacy/">Privacy Policy</a> | <a href="/terms-of-service/">Terms of Service</a></li>
				</ul>
			</div>
			<div class="col-sm-3">
				<h4>Solutions</h4>
				<?php wp_nav_menu( array( 'theme_location' => 'site_nav_solutions' ) ); ?>				
			</div>
			<div class="col-sm-3">
				<h4>Segments</h4>				
				<?php wp_nav_menu( array( 'theme_location' => 'site_nav_segments' ) ); ?>
			</div>
			<div class="col-sm-3">
				<h4>Popular Links</h4>				
				<?php wp_nav_menu( array( 'theme_location' => 'site_nav_popular_links' ) ); ?>
			</div>
		</div>
	</div>
</footer>