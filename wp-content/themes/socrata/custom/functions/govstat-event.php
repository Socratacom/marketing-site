<?php
//GovStat Countdown
add_action ('wp_head','govstat_countdown');
function govstat_countdown() {
  if (is_page('connected-performance')) { ?>
  <meta http-equiv="refresh" content="30">
  <script type="text/javascript" src="/wp-content/themes/socrata/custom/scripts/jquery.jCounter-0.1.4.js"></script>
  <script type="text/javascript">
		$(document).ready(function() {
			$(".countdown").jCounter({
				date: "11 april 2013 11:00:00", //add the countdown's end date (i.e. 1 january 1970 12:00:00)
				timezone: "America/Los_Angeles",
				format: "dd:hh:mm:ss",
				twoDigits: 'on',
				fallback: function() { console.alert("Counter finished!") }
			});			
		});
	</script>
  <style>
  ul.countdown {
  margin: auto;
  padding: 0;
  text-align: center;
}
ul.countdown li{
  background-color: #222;
  border: 2px solid #fff;
  color: #fff;
  display: inline-block;
  text-align: center;
  width: 100px;
  border-radius: 6px;
  box-shadow: 0 0 3px #777;
  padding:10px;
  margin:0 5px;
}
ul.countdown span {
  padding-left: 5px;
  font-size: 36px !important;
  font-weight: bold;
  padding:10px;
  display:block;
  letter-spacing: 5px;
}
ul.countdown  p.timeRefDays, ul.countdown  p.timeRefHours, ul.countdown  p.timeRefMinutes, ul.countdown  p.timeRefSeconds{
  font: normal normal 12px Arial !important;
  letter-spacing: 0;
  margin: 0;
  color:#fff;
  text-transform: uppercase;
}
  </style>
<?php
 }
}