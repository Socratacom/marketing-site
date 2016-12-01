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

<div id="popup" class="popup hidden-xs" style="display:none;">
	<div class="dialog">
		<button class="close-me"><i class="icon-close"></i></button>
		<h5 class="margin-bottom-5">Socrata Transform</h5>
		<p style="font-size:14px;">Join government leaders sharing best practices on open data and more. Get biweekly updates on top trends and success stories in digital government.</p>
		<?php echo do_shortcode('[marketo-form id="3137"]');?>
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
<script type="text/JavaScript">
  jQuery(function($) {
    // COOKIES
    // if the cookie is true, hide the initial message and show the other one
    if (Cookies.set('popup_v3') == 'yes') {
      $('#popup').addClass('hide-me');
    }
    // when clicked on “X” icon do something
    $('.close-me').click(function() {
      // check that “X” icon was not cliked before (hidden)
      if (!$('#popup').is('hide-me')) {
        $('#popup').addClass('hide-me');

        // add cookie setting that user has clicked
        Cookies.set('popup_v3', 'yes', {expires: 30 });
      }
      return false;
    })
  });
</script>









