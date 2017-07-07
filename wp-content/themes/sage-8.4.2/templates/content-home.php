<section class="home-masthead">
<div class="slider">
    <div class="slide" style="background-image:url(/wp-content/uploads/home-hero-cthru.jpg)">
        <div class="text">
            <div class="vertical-center">
                <div class="container">
                    <div class="row">
                        <div class="col-sm-8 col-md-6">
                            <h1 class="color-white margin-bottom-15">Massachusetts Liberates State Finance Data</h1>
                            <h4 class="color-white text-normal hidden-xs margin-bottom-0">CTHRU invites citizens to dig into financial facts online through open access to data.</h4>
                            <ul class="cta-list">
                                <li><a href="/case-study/massachusetts-cuts-costs-invites-citizens-dig-financial-facts-online/" class="btn btn-default outline">Read Story <i class="fa fa-arrow-circle-o-right" aria-hidden="true"></i></a></li>
                                <li><a href="http://www.mass.gov/comptroller/cthru/" target="_blank" class="btn btn-default outline">Visit Site <i class="fa fa-arrow-circle-o-right" aria-hidden="true"></i></a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
	<div class="slide" style="background-image:url(/wp-content/uploads/home-hero-douglas.jpg)">
		<div class="text">
			<div class="vertical-center">
				<div class="container">
					<div class="row">
						<div class="col-sm-8 col-md-6">
							<h1 class="color-white margin-bottom-15">Going Beyond a Hard-Copy Annual Budget</h1>
							<h4 class="color-white text-normal hidden-xs margin-bottom-0">Douglas County, KS created a valuable source of information for citizens, elected officials, and staff.</h4>
							<ul class="cta-list">
								<li><a href="/blog/douglas-county-open-budget-invites-public-explore-annual-budget/" class="btn btn-default outline">Learn More <i class="fa fa-arrow-circle-o-right" aria-hidden="true"></i></a></li>
								<li><a href="http://budget.douglascountyks.org/#!/year/default" class="btn btn-default outline" target="_blank">Visit Site <i class="fa fa-arrow-circle-o-right" aria-hidden="true"></i></a></li>
							</ul>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
</section>
<script>
jQuery(function ($){
      $('.slider').slick({
        arrows: false,
        dots: true,
        autoplay: true,
        autoplaySpeed:5000,
        speed: 500,
        infinite:true,
        fade:true,
        cssEase: 'linear',
        pauseOnHover:true,
        pauseOnDotsHover:true,
      });
      $('.slider').show();
    });
</script>
<section class="section-padding">
	<div class="container">
		<div class="row margin-bottom-30">
			<div class="col-sm-12">
				<h2 class="text-center section-title">Data-driven innovation of government programs</h2>
			</div>
			<div class="col-sm-6 col-md-3 match-height margin-bottom-30">
				<p class="text-center"><a href="/solutions/financial-transparency/"><i class="icon-80 icon-dollar color-primary-alt-1"></i></a></p>
				<h5 class="text-center"><a href="/solutions/financial-transparency/" class="link-black">Financial Transparency</a></h5>
			</div>
			<div class="col-sm-6 col-md-3 match-height margin-bottom-30">
				<p class="text-center"><a href="/solutions/open-data-citizen-engagement/"><i class="icon-80 icon-handshake color-primary-alt-2"></i></a></p>
				<h5 class="text-center"><a href="/solutions/open-data-citizen-engagement/" class="link-black">Open Data &amp; Citizen Engagement</a></h5>
			</div>
			<div class="col-sm-6 col-md-3 match-height margin-bottom-30">
				<p class="text-center"><a href="/solutions/performance-improvement-accountability/"><i class="icon-80 icon-statistics color-primary-alt-3"></i></a></p>
				<h5 class="text-center"><a href="/solutions/performance-improvement-accountability/" class="link-black">Performance Improvement &amp; Accountability</a></h5>
			</div>
			<div class="col-sm-6 col-md-3 match-height margin-bottom-30">
				<p class="text-center"><a href="/solutions/socrata-for-federal-government"><i class="icon-80 icon-capital color-primary"></i></a></p>
				<h5 class="text-center"><a href="/solutions/socrata-for-federal-government" class="link-black">Federal Government</a></h5>
			</div>
		</div>
		<div class="row">
			<div class="col-sm-10 col-sm-offset-1">
				<p class="text-center">Socrata customer sites are powered by: <a href="https://aws.amazon.com/" target="_blank"><img src="/wp-content/uploads/logo-aws-small.png"></a></p>
			</div>
		</div>
	</div>
</section>
<section class="background-video">
	<div class="text">
		<div class="vertical-center">
			<div class="container">
				<div class="row">
					<div class="col-sm-10 col-sm-offset-1">
						<h2 class="section-title color-white">Why Socrata</h2>
						<p class="lead color-white">Socrata's cloud-based solutions allow government organizations to put their data online, make data-driven decisions, operate more efficiently, and share insights with citizens.</p>
						<p><a href="https://www.youtube.com/watch?v=yH4RnuPijZA" role="button"><i class="fa fa-play-circle-o"></i></a></p>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div id="myvideo" class="image" style="background-image:url(https://img.youtube.com/vi/yH4RnuPijZA/maxresdefault.jpg)"></div>
	<div id="video" class="player" data-property="{videoURL:'yH4RnuPijZA',containment:'#myvideo', showControls:false, autoPlay:true, loop:true, mute:true, startAt:9, stopAt:19, opacity:1, addRaster:true, quality:'default'}"></div>
	<script>jQuery(function(e){e("#video").YTPlayer()});</script>
</section>
<?php echo do_shortcode("[youtube-modal]"); ?>