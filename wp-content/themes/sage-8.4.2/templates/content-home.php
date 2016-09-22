<section class="home-masthead">
<div class="slider" style="height:720px; width:100%;">
	<div class="slide" style="height:720px; width:100%; background-repeat:no-repeat; background-size:cover; background-position:center center; background-image:url(http://placehold.it/560x315?text=slideOne)"></div>
	<div class="slide" style="height:720px; width:100%; background-repeat:no-repeat; background-size:cover; background-position:center center; background-image:url(http://placehold.it/560x315?text=slideTwo)"></div>
</div>
</section>

	<script>
	jQuery(function ($){
          $('.slider').slick({
            arrows: false,
            dots: true,
            autoplay: true,
            autoplaySpeed: 5000,
            infinite:true,
            fade:true,
            cssEase: 'linear',
            pauseOnHover:false,
            pauseOnDotsHover:true,
          });
          $('.slider').show();
        });
	</script>




<section class="section-padding">
	<div class="container">
		<div class="row margin-bottom-30">
			<div class="col-sm-12">
				<h2 class="text-center section-title">Trusted by over 1,000 government organizations</h2>
			</div>
			<div class="col-sm-6 col-md-3 match-height margin-bottom-30">
				<p><a href="#"><img src="http://placehold.it/560x315" class="img-responsive"></a></p>
				<h5 class="text-center">Federal Governmentt</h5>
			</div>
			<div class="col-sm-6 col-md-3 match-height margin-bottom-30">
				<p><a href="#"><img src="http://placehold.it/560x315" class="img-responsive"></a></p>
				<h5 class="text-center">State Government</h5>
			</div>
			<div class="col-sm-6 col-md-3 match-height margin-bottom-30">
				<p><a href="#"><img src="http://placehold.it/560x315" class="img-responsive"></a></p>
				<h5 class="text-center">County Government</h5>
			</div>
			<div class="col-sm-6 col-md-3 match-height margin-bottom-30">
				<p><a href="#"><img src="http://placehold.it/560x315" class="img-responsive"></a></p>
				<h5 class="text-center">City Government</h5>
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
						<p class="lead color-white">Socrata's cloud-based solution allows government organizations to put their data online, make data-driven decisions, operate more efficiently, and share insights with citizens.</p>
						<p><a href="https://www.youtube.com/watch?v=IICDU-UKrZQ" role="button"><i class="fa fa-play-circle-o"></i></a></p>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div id="myvideo" class="image" style="background-image:url(https://img.youtube.com/vi/IICDU-UKrZQ/maxresdefault.jpg)"></div>
	<div id="video" class="player" data-property="{videoURL:'IICDU-UKrZQ',containment:'#myvideo', showControls:false, autoPlay:true, loop:true, mute:true, startAt:9, stopAt:23, opacity:1, addRaster:true, quality:'default'}"></div>
	<script>jQuery(function(e){e("#video").YTPlayer()});</script>
</section>
<section class="section-padding">
	<div class="container">
		<div class="row">
			<div class="col-sm-12">
				<h2 class="text-center section-title">A proven solution for data democratization</h2>
			</div>
			<div class="col-sm-6 col-md-3 match-height margin-bottom-30">
				<p><a href="#"><img src="http://placehold.it/560x315" class="img-responsive"></a></p>
				<h5 class="text-center margin-bottom-15">Publica Open Data Cloud</h5>
				<p class="text-center">Provide public access to government data that can spur innovation and insight</p>
				
			</div>
			<div class="col-sm-6 col-md-3 match-height margin-bottom-30">
				<p><a href="#"><img src="http://placehold.it/560x315" class="img-responsive"></a></p>
				<h5 class="text-center margin-bottom-15">Performance Data Cloud</h5>
				<p class="text-center">Monitor government performance and track progress towards operational goals</p>
				
			</div>
			<div class="col-sm-6 col-md-3 match-height margin-bottom-30">
				<p><a href="#"><img src="http://placehold.it/560x315" class="img-responsive"></a></p>
				<h5 class="text-center margin-bottom-15">Public Finance Data Cloud</h5>
				<p class="text-center">Communicate clearly and interactively around fiscal priorities, income, and spending</p>
				
			</div>
			<div class="col-sm-6 col-md-3 match-height margin-bottom-30">
				<p><a href="#"><img src="http://placehold.it/560x315" class="img-responsive"></a></p>
				<h5 class="text-center margin-bottom-15">Public Safety Data Cloud</h5>
				<p class="text-center">Provide transparency into policing statistics and public safety using data as an objective foundation</p>
				
			</div>
		</div>
	</div>
</section>
<?php echo do_shortcode("[match-height]"); ?>
<?php echo do_shortcode("[youtube-modal]"); ?>