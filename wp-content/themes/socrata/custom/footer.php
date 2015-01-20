<?php

add_action('thesis_hook_after_html', 'custom_footer',1);
function custom_footer() { ?>
<footer>
	<div class="wrapper format_text">
		<div class="one_fourth">
			<h4>Contact</h4>
			<p><span>Phone:</span> <a href="206-340-8008" target="_blank" rel="nofollow">206.340.8008</a><br><span>Fax:</span> <a href="206-452-2010" target="_blank" rel="nofollow">206.452.2010</a><br>Email: <a href="mailto:info@socrata.com">info@socrata.com</a><br><a href="/contact-us/">More Options</a></p>
		</div>
		<div class="one_fourth">
			<h4>Seattle</h4>
			<p>83 S. King St.<br>Suite 107<br>Seattle, WA 98104</p>
		</div>
		<div class="one_fourth">
			<h4>Washington DC</h4>
			<p>1150 17th Street<br>Suite 200<br>Washington, D.C. 20036</p>
		</div>
		<div class="one_fourth last">
			<h4>United Kingdom</h3>
			<p>14-22 Elder St.<br>London E1 6BT<br>UK</p>
		</div>
		<div class="clearboth"></div>		
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