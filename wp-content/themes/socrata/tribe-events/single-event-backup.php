
<div class="format_text">
<p class="tribe-events-back"><a href="/events" class="button"><span class="ss-icon">back</span> All Events</a></p>
<div class="two_third">
	<!-- Notices -->
	<?php tribe_events_the_notices() ?>
	<?php the_title( '<h1>', '</h1>' ); ?>
	<div style="font-weight:300; margin-top:-.5em; margin-bottom:1.5em"><span class="ss-icon" style="color:#999;">calendar</span> <?php echo tribe_events_event_schedule_details(); ?></div>
	<?php echo tribe_events_event_recurring_info_tooltip(); ?>

	<!-- AddThis Button BEGIN -->
	<div class="addthis_toolbox addthis_default_style" style="margin-bottom: 1em;">
	<a class="addthis_button_facebook_like" fb:like:layout="button_count"></a>
	<a class="addthis_button_tweet"></a>
	<a class="addthis_button_pinterest_pinit" pi:pinit:layout="horizontal"></a>
	<a class="addthis_counter addthis_pill_style"></a>
	</div>
	<script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js#pubid=ra-4e590fc12e22e79e"></script>
	<!-- AddThis Button END -->

	<!-- Event featured image -->
	<?php if(has_post_thumbnail()) :?>
    <?php $thumb = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'feature-image' ); $url = $thumb['0']; ?>
    <img src="<?=$url?>" style="width:100%;">
    <?php endif;?>
	<hr/>		

	<?php the_content(); ?>

	<!-- Begin Details -->
	<?php if (tribe_get_start_date()) {
  	echo "<h3>Details</h3><dl class='event-details'>" ;
	} ?>
	<?php if (tribe_get_start_date()) {
  	echo "<dt>Start</dt><dd>", tribe_get_start_date(), "</dd>" ;
  	echo "<dt>End</dt><dd>", tribe_get_end_date(), "</dd>" ;
	} ?>
	<?php if (tribe_get_cost()) {
  	echo "<dt>Cost</dt><dd>$", tribe_get_cost(), "</dd>" ;
	} ?>
	<?php if (tribe_get_event_website_url()) {
  	echo "<dt>Website</dt><dd><a href=",tribe_get_event_website_url()," target='_blank'>Visit Event Site</a></dd>" ;
	} ?>
	<?php if (tribe_get_start_date()) {
  	echo "</dl>" ;
	} ?>
	<!-- End Details -->


	<!-- Begin Organizer -->
	<?php if (tribe_get_organizer()) {
  	echo "<h3>Organizer</h3><dl class='event-organizer'>" ;
	} ?>
	<?php if (tribe_get_organizer()) {
  	echo "<dt>Organizer Name</dt><dd>", tribe_get_organizer(), "</dd>" ;
	} ?>
	<?php if (tribe_get_organizer_phone()) {
  	echo "<dt>Phone Number</dt><dd>", tribe_get_organizer_phone(), "</dd>" ;
	} ?>
	<?php if (tribe_get_organizer_website_url()) {
  	echo "<dt>Website</dt><dd><a href=",tribe_get_organizer_website_url()," target='_blank'>Visit Organizer Site</a></dd>" ;
	} ?>
	<?php if (tribe_get_organizer_email()) {
  	echo "<dt>Email</dt><dd><a href=mailto:",tribe_get_organizer_email(),">Email Organizer</a></dd>" ;
	} ?>
	<?php if (tribe_get_organizer()) {
  	echo "</dl>" ;
	} ?>
	<!-- End Organizer -->

	<!-- Begin Venue -->
	<?php if (tribe_get_venue()) {
  	echo "<h3>Venue</h3><dl class='event-venue'>" ;
	} ?>
	<?php if (tribe_get_venue()) {
  	echo "<dt>Venue Name</dt><dd>", tribe_get_venue(), "</dd>" ;
	} ?>
	<?php if (tribe_get_address()) {
  	echo "<dt>Address</dt><dd>", tribe_get_full_address(), "<a href=",tribe_get_map_link()," target='_blank'>Map</a></dd>"; 
	} ?>
	<?php if (tribe_get_phone()) {
  	echo "<dt>Phone Number</dt><dd>", tribe_get_phone(), "</dd>" ;
	} ?>
	<?php if (tribe_get_venue()) {
  	echo "</dl>" ;
	} ?>
	<!-- End Venue -->

	<?php if (tribe_get_venue()) {
  	echo tribe_get_embedded_map();
	} ?>

		

	
</div><!-- End Two Third -->
<div class="one_third last event-sidebar">  
  <div class='lead-gen-form <?php $meta = get_event_meta(); if ($meta[0]) echo "$meta[0]"; ?>'>
    <h3>Talk With Us</h3>
    <p>Want to speak with Socrata at this event? Let us know where you’ll be, and we can set up a one-on-one.</p>
    <form class="lpeRegForm formNotEmpty" method="post" enctype="application/x-www-form-urlencoded" action="http://discover.socrata.com/index.php/leadCapture/save" id="mktForm_1153" name="mktForm_1153">
      <ul class="mktLblLeft">
        <li class="mktFormReq mktField">
          <label>First Name:</label>
          <span class="mktInput">
            <input class="mktFormText mktFormString mktFReq" name="FirstName" id="FirstName" type="text" value="" maxlength="255" tabindex="1" placeholder="First Name">
            <span class="mktFormMsg"></span>
          </span>
        </li>
        <li class="mktFormReq mktField">
          <label>Last Name:</label>
          <span class="mktInput">
            <input class="mktFormText mktFormString mktFReq" name="LastName" id="LastName" type="text" value="" maxlength="255" tabindex="2" placeholder="Last Name">
            <span class="mktFormMsg"></span>
          </span>
        </li>
        <li class="mktFormReq mktField">
          <label>Company Name:</label>
          <span class="mktInput">
            <input class="mktFormText mktFormString mktFReq" name="Company" id="Company" type="text" value="" maxlength="255" tabindex="3" placeholder="Company Name">
            <span class="mktFormMsg"></span>
          </span>
        </li>
        <li class="mktFormReq mktField">
          <label>Phone Number:</label>
          <span class="mktInput">
            <input class="mktFormText mktFormPhone mktFReq" name="Phone" id="Phone" type="text" value="" maxlength="255" tabindex="4" placeholder="Pnone Number">
            <span class="mktFormMsg"></span>
          </span>
        </li>
        <li class="mktFormReq mktField">
          <label>Email Address:</label>
          <span class="mktInput">
            <input class="mktFormText mktFormEmail mktFReq" name="Email" id="Email" type="text" value="" maxlength="255" tabindex="5" placeholder="Email Address">
            <span class="mktFormMsg"></span>
          </span>
        </li>
        <li class="mktField mktLblRight">
          <p class="mktInput mktLblRight" style="line-height: normal;">
            <input class="mktFormCheckbox" name="Opt_in_Checkbox__c" id="Opt_in_Checkbox__c" type="checkbox" value="1" tabindex="6" checked="checked" style="display:inline-block; width:25px;">
            <small>I agree to receive communications from Socrata about its products and services.</small>
            <span class="mktFormMsg"></span>
          </p>
        </li>
        <li class="mktField" style="display: none;">
          <label>SPAM Blocker:</label>
          <span class="mktInput">
            <input class="mktFormHidden" name="SPAM_Blocker__c" id="SPAM_Blocker__c" type="hidden" value=""><span class="mktFormMsg"></span>
          </span>
        </li>
        <li class="mktField" style="display: none;">
          <label>UTM - Campaign:</label>
          <span class="mktInput">
            <input class="mktFormHidden" name="UTM_Campaign__c" id="UTM_Campaign__c" type="hidden" value="<?php the_title(); ?>">
            <span class="mktFormMsg"></span>
          </span>
        </li>
        <li id="mktFrmButtons">
          <input id="mktFrmSubmit" type="submit" value="Submit" name="submitButton" onclick="formSubmit(document.getElementById(&quot;mktForm_1153&quot;)); return false;"  class="button">&nbsp;
          <input style="display: none;" id="mktFrmReset" type="reset" value="Clear" name="resetButton" onclick="formReset(document.getElementById(&quot;mktForm_1153&quot;)); return false;">
        </li>
      </ul>
        <span style="display:none;"><input type="text" name="_marketo_comments" value=""></span>
        <input type="hidden" name="lpId" value="-1">
        <input type="hidden" name="subId" value="147">
        <input type="hidden" name="munchkinId" value="851-SII-641">
        <input type="hidden" name="kw" value="">
        <input type="hidden" name="cr" value="">
        <input type="hidden" name="searchstr" value="">
        <input type="hidden" name="lpurl" value="http://discover.socrata.com/SocrataEvents_LandingPage.html?cr={creative}&amp;kw={keyword}">
        <input type="hidden" name="formid" value="1153">
        <input type="hidden" name="returnURL" value="socrata.com/events">
        <input type="hidden" name="retURL" value="socrata.com/events">
        <input type="hidden" name="returnLPId" value="-1">
        <input type="hidden" name="_mkt_disp" value="return">
          <input type="hidden" name="_mkt_trk" value="">
      </form>
      <script type="text/javascript" src="http://discover.socrata.com/js/mktFormSupport.js"></script>
      <script type="text/javascript">
        function formSubmit(elt) {
        return Mkto.formSubmit(elt);
        }
        function formReset(elt) {
        return Mkto.formReset(elt);
        }
      </script>
      <script type="text/javascript">
        $('[placeholder]').focus(function() {
        var input = $(this);
        if (input.val() == input.attr('placeholder')) {
        input.val('');
        input.removeClass('placeholder');
        }
      }).blur(function() {
        var input = $(this);
        if (input.val() == '' || input.val() == input.attr('placeholder')) {
        input.addClass('placeholder');
        input.val(input.attr('placeholder'));
        }
      }).blur().parents('form').submit(function() {
        $(this).find('[placeholder]').each(function() {
        var input = $(this);
        if (input.val() == input.attr('placeholder')) {
          input.val('');
        }
        })
      });
      </script>

  </div>
	<?php echo do_shortcode('[cta icon_color="#659c3d" icon_keyword="feather" title="Invite Socrata" text="Do you have an event you would like Socrata to attend? Please let us know." button_text="Invite" link="mailto:info@socrata.com"]'); ?>
	<h3>More Events</h3>
	<?php
		global $post;
		$all_events = tribe_get_events(array(
		'eventDisplay'=>'upcoming',
		'posts_per_page'=>5
		));

		foreach($all_events as $post) {
		setup_postdata($post);
	?>
	<article class="clearfix">

		<div class="thumb">
		<?php if(has_post_thumbnail()) :?>
    	<?php $thumb = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'thumbnail' ); $url = $thumb['0']; ?>
    	<a href="<?php the_permalink(); ?>"><img src="<?=$url?>" style="width:100%;"></a>
		<?php endif;?>
		</div>
		<div class="link">
		<p><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a><br/><small><?php echo tribe_get_start_date($post->ID, true, 'M j, Y'); ?></small></p>
		</div>

	</article>
<?php } //endforeach ?>
<?php wp_reset_query(); ?>

</div>
<div class="clearboth"></div>
</div>




