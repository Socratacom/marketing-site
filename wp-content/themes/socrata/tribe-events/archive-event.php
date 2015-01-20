<?php
/**
 * Single Event Template
 * A single event. This displays the event title, description, meta, and
 * optionally, the Google map for the event.
 * 
 * Override this template in your own theme by creating a file at [your-theme]/tribe-events/single-event.php
 *
 * @package TribeEventsCalendar
 * @since  2.1
 * @author Modern Tribe Inc.
 *
 */

if ( !defined('ABSPATH') ) { die('-1'); }

$event_id = get_the_ID();

?>
<p class="tribe-events-back"><a href="/events" class="button"><span class="ss-icon">back</span> All Events</a></p>
<div class="two_third">

	<!-- Notices -->
	<?php tribe_events_the_notices() ?>
	<?php the_title( '<h1>', '</h1>' ); ?>
	<h3 style="font-weight: 300"><span class="ss-icon" style="color:#999;">calendar</span> <?php echo tribe_events_event_schedule_details(); ?></h3>
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

	<?php while ( have_posts() ) :  the_post(); ?>
		<div id="post-<?php the_ID(); ?>" <?php post_class('vevent'); ?>>
			<!-- Event featured image -->
			<?php if(has_post_thumbnail()) :?>
    		<?php $thumb = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'feature-image' ); $url = $thumb['0']; ?>
    		<img src="<?=$url?>" style="width:100%;">
    		<?php endif;?>

    		<hr/>		

			<!-- Event content -->
			<?php do_action( 'tribe_events_single_event_before_the_content' ) ?>
			<div class="tribe-events-single-event-description tribe-events-content entry-content description">
				<?php the_content(); ?>
			</div><!-- .tribe-events-single-event-description -->
			<?php do_action( 'tribe_events_single_event_after_the_content' ) ?>

			<!-- Event meta -->
			<?php do_action( 'tribe_events_single_event_before_the_meta' ) ?>
				<?php echo tribe_events_single_event_meta() ?>
			<?php do_action( 'tribe_events_single_event_after_the_meta' ) ?>

		</div>
		<?php if( get_post_type() == TribeEvents::POSTTYPE && tribe_get_option( 'showComments','no' ) == 'yes' ) { comments_template(); } ?>
	<?php endwhile; ?>

	
</div><!-- End Two Third -->
<div class="one_third last event-sidebar">	
	<div class='lead-gen-form <?php $meta = get_event_meta(); if ($meta[0]) echo "$meta[0]"; ?>'>
		<h3>Talk With Us</h3>
		<p>Want to speak with Socrata at this event? Let us know where you’ll be, and we can set up a one-on-one.</p>
		<form class="lpeRegForm formNotEmpty" method="post" enctype="application/x-www-form-urlencoded" action="http://discover.socrata.com/index.php/leadCapture/save" id="mktForm_1153" name="mktForm_1153"><ul class="mktLblLeft"><li class="mktFormReq mktField"><label>First Name:</label><span class="mktInput"><input class="mktFormText mktFormString mktFReq" name="FirstName" id="FirstName" type="text" value="" maxlength="255" tabindex="1"><span class="mktFormMsg"></span></span></li>
<li class="mktFormReq mktField"><label>Last Name:</label><span class="mktInput"><input class="mktFormText mktFormString mktFReq" name="LastName" id="LastName" type="text" value="" maxlength="255" tabindex="2"><span class="mktFormMsg"></span></span></li>
<li class="mktFormReq mktField"><label>Company Name:</label><span class="mktInput"><input class="mktFormText mktFormString mktFReq" name="Company" id="Company" type="text" value="<?php the_title(); ?>" maxlength="255" tabindex="3"><span class="mktFormMsg"></span></span></li>
<li class="mktFormReq mktField"><label>Phone Number:</label><span class="mktInput"><input class="mktFormText mktFormPhone mktFReq" name="Phone" id="Phone" type="text" value="" maxlength="255" tabindex="4"><span class="mktFormMsg"></span></span></li>
<li class="mktFormReq mktField"><label>Email Address:</label><span class="mktInput"><input class="mktFormText mktFormEmail mktFReq" name="Email" id="Email" type="text" value="" maxlength="255" tabindex="5"><span class="mktFormMsg"></span></span></li>
<li class="mktField" style="display: none;"><label>SPAM Blocker:</label><span class="mktInput"><input class="mktFormHidden" name="SPAM_Blocker__c" id="SPAM_Blocker__c" type="hidden" value=""><span class="mktFormMsg"></span></span></li>
<li class="mktField" style="display: none;"><label>UTM - Campaign:</label><span class="mktInput"><input class="mktFormHidden" name="UTM_Campaign__c" id="UTM_Campaign__c" type="hidden" value="N/A"><span class="mktFormMsg"></span></span></li>
<li id="mktFrmButtons"><label>&nbsp;</label><input id="mktFrmSubmit" type="submit" style="width: auto; overflow: visible; padding-left: .25em; padding-right: .25em;" value="Submit" name="submitButton" onclick="formSubmit(document.getElementById(&quot;mktForm_1153&quot;)); return false;">&nbsp;<input style="display: none;" id="mktFrmReset" type="reset" value="Clear" name="resetButton" onclick="formReset(document.getElementById(&quot;mktForm_1153&quot;)); return false;"></li>  </ul>
  <span style="display:none;"><input type="text" name="_marketo_comments" value=""></span>
  <input type="hidden" name="lpId" value="-1">
  <input type="hidden" name="subId" value="147">
  <input type="hidden" name="munchkinId" value="851-SII-641">
  <input type="hidden" name="kw" value="">
  <input type="hidden" name="cr" value="">
  <input type="hidden" name="searchstr" value="">
  <input type="hidden" name="lpurl" value="http://discover.socrata.com/SocrataEvents_LandingPage.html?cr={creative}&amp;kw={keyword}">
  <input type="hidden" name="formid" value="1153">
  <input type="hidden" name="returnURL" value="socrata.com">
  <input type="hidden" name="retURL" value="socrata.com">
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
		
	</div>
	<div class="green-banner">
		<h3><span class="ss-icon">quill</span> Invite Socrata</h3>
		<p>Have an event that you think Socrata should attend? We’ll put it on our calendars and see if we can make it.</p>
		<p><a href="#" class="white-button">Invite</a></p>
	</div>
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





