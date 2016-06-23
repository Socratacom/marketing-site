<footer role="contentinfo" class="section-padding">
	<div class="container">
		<div class="row">
			<div class="col-sm-4 col-md-3">
				<ul class="social-icons clearfix">
					<li class="facebook"><a href="https://www.facebook.com/socrata" target="_blank">facebook</a></li>
					<li class="twitter"><a href="https://twitter.com/socrata" class="" target="_blank">twitter</a></li>
					<li class="linkedin"><a href="https://www.linkedin.com/company/socrata" class="" target="_blank">linkedin</a></li>
					<li class="google"><a href="https://plus.google.com/+Socrata/about" class="" target="_blank">googleplus</a></li>
					<li class="youtube"><a href="https://www.youtube.com/user/socratavideos" class="" target="_blank">youtube</a></li>
				</ul>
				<div class="footer-logo color-logo"></div>
				<ul class="copyright">
					<li>&copy; <?php echo date("Y");?> Socrata. All rights reserved.</li>
					<li>Phone: <a href="tel://1-206-340-8008">+1 (206) 340-8008</a></li>
					<li>Support: <a href="tel://1-888-997-6762">+1 (888) 997-6762</a></li>
					<li><a href="/privacy/">Privacy Policy</a> | <a href="/terms-of-service/">Terms of Service</a></li>
				</ul>
				<div class="footer-form hidden-xs hidden-sm">
					<h4>Subscribe to the Socrata newsletter</h4>
					<?php echo do_shortcode('[marketo-form id="2745"]'); ?>
				</div>
			</div>
			<div class="col-md-9 hidden-xs hidden-sm">
				<div class="row">
					<div class="col-sm-4 col-md-2 col-md-offset-1">
						<h4>Products</h4>
						<?php wp_nav_menu( array( 'theme_location' => 'site_nav_products' ) ); ?>						
					</div>
					<div class="col-sm-4 col-md-2">
						<h4>Solutions</h4>				
						<?php wp_nav_menu( array( 'theme_location' => 'site_nav_solutions' ) ); ?>						
					</div>
					<div class="col-sm-4 col-md-2">
						<h4>Resources</h4>				
						<?php wp_nav_menu( array( 'theme_location' => 'site_nav_resources' ) ); ?>	
					</div>
					<div class="clearfix visible-sm-block"></div>				
					<div class="col-sm-4 col-md-2">
						<h4>About</h4>				
						<?php wp_nav_menu( array( 'theme_location' => 'site_nav_about' ) ); ?>						
					</div>					
					<div class="col-sm-4 col-md-2">
						<h4>Community</h4>				
						<?php wp_nav_menu( array( 'theme_location' => 'site_nav_community' ) ); ?>
					</div>
				</div>
			</div>
		</div>
	</div>
</footer>

<div id="popup" class="popup hidden-xs" style="display:none;">
	<div class="dialog">
		<button class="close-me"><i class="icon-close"></i></button>
		<h5 class="margin-bottom-5">Socrata Transform</h5>
		<p style="font-size:14px;">Join government leaders sharing best practices on open data and more. Get weekly updates on top trends and success stories in digital government.</p>
		<?php echo do_shortcode('[marketo-form id="3130"]');?>
		<div id="popup-confirmation" class="alert alert-success" style="display:none; margin-top:30px; font-size:14px;" >
		    <strong>Thank you for subscribing to Socrata Transform!</strong>
		</div>
	</div>
</div>
				
<script type="text/javascript">
  jQuery(function($) {
  	setTimeout(function () {
	    $('#popup').delay(60000).fadeIn(500);
	});
	$('.modal').on('shown.bs.modal', function() {
	    $(document).off('focusin.modal');
	});
  });
</script>
<script>
	MktoForms2.whenReady(function (form){
	  form.onSuccess(function(values, followUpUrl){
	   form.getFormElem().hide();
	   document.getElementById('popup-confirmation').style.display = 'block';
	   return false;
	 });
	});
</script>
<script type="text/JavaScript">
  jQuery(function($) {
    // COOKIES
    // if the cookie is true, hide the initial message and show the other one
    if (Cookies.set('popup_v2') == 'yes') {
      $('#popup').addClass('hide-me');
    }
    // when clicked on “X” icon do something
    $('.close-me').click(function() {
      // check that “X” icon was not cliked before (hidden)
      if (!$('#popup').is('hide-me')) {
        $('#popup').addClass('hide-me');

        // add cookie setting that user has clicked
        Cookies.set('popup_v2', 'yes', {expires: 1 });
      }
      return false;
    })
  });
</script>











