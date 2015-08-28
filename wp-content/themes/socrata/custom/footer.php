<?php

add_action('thesis_hook_after_html', 'custom_footer',1);
function custom_footer() { ?>
<footer>
	<div class="wrapper format_text">
		<div class="one_fourth">
			<h4>Contact</h4>
			<ul style="list-style-type:none; margin:0; padding:0;">
				<li><span>Phone:</span> <a href="tel://1-206-340-8008">+1 (206) 340-8008</a></li>
				<li><span>Support:</span> <a href="tel://1-888-997-6762">+1 (888) 997-6762</a></li>
				<li><span>Fax:</span> <a href="tel://1-206-452-2010">+1 (206) 452-2010</a></li>
				<li><span>Email:</span> <a href="mailto:info@socrata.com">info@socrata.com</a></li>
				<li><a href="/contact-us/">More Options</a></li>
			</ul>
		</div>
		<div class="one_fourth">
			<h4>Seattle</h4>
			<p>83 S. King St.<br>Suite 107<br>Seattle, WA 98104</p>
		</div>
		<div class="one_fourth">
			<h4>Washington DC</h4>
			<p>1150 17th Street, NW<br>Suite 200<br>Washington, D.C. 20036</p>
		</div>
		<div class="one_fourth last">
			<h4>United Kingdom</h3>
			<p>14-22 Elder St.<br>London E1 6BT<br>UK</p>
		</div>
		<div class="clearboth"></div>
		<div class="social-icons">
			<h3>Folow Us</h3>
			<ul>
				<li class="facebook"><a href="https://www.facebook.com/socrata" target="_blank">facebook</a></li>
				<li class="twitter"><a href="https://twitter.com/socrata" class="" target="_blank">twitter</a></li>
				<li class="linkedin"><a href="https://www.linkedin.com/company/socrata" class="" target="_blank">linkedin</a></li>
				<li class="google"><a href="https://plus.google.com/+Socrata/about" class="" target="_blank">googleplus</a></li>
				<li class="youtube"><a href="https://www.youtube.com/user/socratavideos" class="" target="_blank">youtube</a></li>
			</ul>
		</div>	
		<p class="center copyright">Copyright &copy; <?php echo date("Y");?> Socrata, Inc. All rights reserved. &bull; <a href="/privacy/">Privacy Policy</a> &bull; <a href="/terms-of-service/">Terms of Service</a></p>
		<div class="white-logo logo"></div>
	</div>
</footer>
<script>
    $("nav:first").accessibleMegaMenu({
    uuidPrefix: "accessible-megamenu",
    menuClass: "nav-menu",
    topNavItemClass: "nav-item",
    panelClass: "sub-nav",
    panelGroupClass: "sub-nav-group",
    hoverClass: "hover",
    focusClass: "focus",
    openClass: "open"
    });
</script>
<script>
	new gnMenu( document.getElementById( 'gn-menu' ) );
</script>
<script>
	new UISearch( document.getElementById( 'sb-search' ) );
</script>
<?php
}