<?php

// Shortcode [dau-video]
add_shortcode('dau-video','dau_video_shortcode');
function dau_video_shortcode($atts, $content = null) { ob_start(); ?>


<section id="video_container" class="video">

<div id="text">

<div class="vertical-align">
<div class="container">
<div class="row">
<div class="col-sm-10 col-sm-offset-1">

	<p class="text-center">Just like water, data is a natural resource. And just as water flows from various sources into many channels where it is collected, centralized, and processed for public consumption, Socrata's solution does the same with government data. We collect data, process it, refine it, and funnel it to multiple channels for multiple uses.</p>
	<div>
		<span class="glyphicon glyphicon-play-circle playbutton" aria-hidden="true"></span>
	</div>

</div>
</div>
</div>
</div>

</div>

<div id="cover-all"></div>
<div id="main-image"></div>
<div id="wistia_g92qhkv74k" class="wistia_embed backgroundVideo" ></div>

</section>



<div id="ex"><span class="glyphicon glyphicon-remove" aria-hidden="true" style="color:#fff;"></span></div>
<div id="wistia_of3560a3ee" class="wistia_embed overlayVideo" ></div>


<?php
$content = ob_get_contents();
ob_end_clean();
return $content;
}

// Shortcode [slider-one]
add_shortcode('slider-one','slider_one_shortcode');
function slider_one_shortcode($atts, $content = null) { ob_start(); ?>

<section class="slider-container">
	<div class="arrowsContainer"></div>
	<div class="row personas">
		<div class="col-sm-12 slide program-leaders">
			<div class="container">
				<div class="row">
					<div class="col-lg-offset-6 col-md-5 col-md-offset-7 slide-content">
						<h4>Foster Communication and Collaboration</h4>
						<h3>Program Leaders</h3>
						<p>Socrata transforms all of your relevant data into a powerful information and service delivery platform to give citizens a quality digital experience wherever they are. Sharing data dramatically reduces transaction costs for businesses in your community and taps into the massive opportunity in new data economy for future jobs.</p>
						<p>Socrata makes it easy, fast, and cost-effective to deploy market-tested information interfaces that bring the government-to-citizen experience to modern consumer web and mobile standards.</p>
					</div>
				</div>
			</div>
		</div>
		<div class="col-sm-12 slide citizens">
			<div class="container">
				<div class="row">
					<div class="col-lg-offset-6 col-md-5 col-md-offset-7 slide-content">
						<h4>Improve Quality of Life</h4>
						<h3>Citizens</h3>
						<p>Socrata helps you deliver great government-to-citizen digital experiences that your citizens expect. With Socrata, you can transform scattered, inaccessible assets into a powerful cloud-based digital services platform with ready-to-deploy interfaces that automatically connect you with the people you serve.</p>
						<p>Socrata’s government-to-citizen solutions aren’t just easy and cost-effective; we provide superior outcomes that delight users, drive engagement and expand your reach. Ubiquitous access to relevant data will make your community a great place to live.</p>
					</div>
				</div>
			</div>
		</div>
		<div class="col-sm-12 slide business">
			<div class="container">
				<div class="row">
					<div class="col-lg-offset-6 col-md-5 col-md-offset-7 slide-content">
						<h4>Create Economic Opportunity</h4>
						<h3>Business</h3>
						<p>Socrata makes it easy to deliver the information infrastructure required of a 21st Century digital economy. With easy access to business-focused data, you can attract new information-based ventures, maintain competitiveness in traditional industry, and dramatically reduce business transaction costs in your community.</p>
						<p>At the same time, we connect you to the broader ecosystem of innovators and entrepreneurs via The Open Data Network™, so you can tap into the massive new business opportunities in the information economy.</p>
					</div>
				</div>
			</div>
		</div>
		<div class="col-sm-12 slide officials">
			<div class="container">
				<div class="row">
					<div class="col-lg-offset-6 col-md-5 col-md-offset-7 slide-content">
						<h4>Generate Actionable Insights</h4>
						<h3>Officials</h3>
						<p>Socrata helps accelerate your shift to a data-driven, 21st Century digital economy. Collecting and consolidating key data creates a more actionable, and data-driven decision making process for government or organizational officials that’s not only impactful but also more transparent.</p>
						<p>With an unprecedented return-on-effort, you can automate all your information flows and deliver market-tested digital service interfaces on one platform at a fraction of the cost and time of the prevailing one-off custom development model.</p>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>

<?php
$content = ob_get_contents();
ob_end_clean();
return $content;
}

// Shortcode [slider-two]
add_shortcode('slider-two','slider_two_shortcode');
function slider_two_shortcode($atts, $content = null) { ob_start(); ?>

<section class="slider-container">
	<div class="pain-points-arrows"></div>
	<div class="row pain-points">
		<div class="col-sm-12 slide why">
			<div class="container">
				<div class="row">
					<div class="col-lg-offset-1 col-md-5 slide-content">
						<h4>Challenges</h4>
						<h3>Why can’t they take care of this?</h3>
						<p>In this era of instant access and feedback, citizens expect immediate responses to community issues. Conversely, governments spend thousands each year on service calls and requests, many of which are duplicate inquiries from concerned citizens. Opening data has the power to facilitate government-to-citizen communication and streamline program delivery.</p>
						<p>Socrata can help you unlock, combine, and deliver datasets for citizen and government access to solving community and societal problems.</p>
					</div>
				</div>
			</div>
		</div>
		<div class="col-sm-12 slide building">
			<div class="container">
				<div class="row">
					<div class="col-lg-offset-1 col-md-5 slide-content">
						<h4>Challenges</h4>
						<h3>Is my building permit approved?</h3>
						<p>The 21<sup>st</sup> Century digital economy expects information on demand. Cloud based, shared-services models maximize innovation and reduce risk to virtually zero. Easy access to business data dramatically reduces costs, connects communities and entrepreneurs, and strengthens local economies. There’s no reason your government shouldn’t be involved.</p>
						<p>In partnership with Socrata, you can directly connect citizens and developers to real-time updates for department and program-level activity.</p>
					</div>
				</div>
			</div>
		</div>
		<div class="col-sm-12 slide neighborhood">
			<div class="container">
				<div class="row">
					<div class="col-lg-offset-1 col-md-5 slide-content">
						<h4>Challenges</h4>
						<h3>Is this neighborhood safe?</h3>
						<p>Community perception, budget management, and resource allocation, are equally critical concerns for area leaders. Quick and easy access to the latest data empowers governments to make actionable, fact-based decisions about the issues that affect their constituents the most. Data consolidation and workflow automation expedite this process and save money in turn.</p>
						<p>Use Socrata’s suite of tools to present fact-driven evidence about community details that really matter to citizens and public officials.</p>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>

<?php
$content = ob_get_contents();
ob_end_clean();
return $content;
}


