<?php
// [countdown day="" month="" year="" time="11:00:00"]
function countdown_timer($atts) {
  extract(shortcode_atts(array(
    "day"  => '',
    "month"  => '',
    "year"  => '',
    "time"  => '',
  ), $atts));
  return '<p class="center"><strong>The hangout will start in:</strong></p>
  <ul class="countdown">
    <li><span class="days">00</span>
      <p class="timeRefDays">days</p>
    </li>
    <li><span class="hours">00</span>
      <p class="timeRefHours">hours</p>
    </li>
    <li><span class="minutes">00</span>
      <p class="timeRefMinutes">minutes</p>
    </li>
    <li><span class="seconds">00</span>
      <p class="timeRefSeconds">seconds</p>
    </li>
  </ul>
  <div class="center" style="background:#fffcdf; border:#e0d886 solid 1px; padding:10px;"><small><span class="ss-icon">alert</span> Please refresh your browser once the timer has expired.</small></div>
  <script type="text/javascript" src="/wp-content/themes/socrata/custom/scripts/jquery.jCounter-0.1.4.js"></script>
  <script type="text/javascript">
    $(document).ready(function() {
      $(".countdown").jCounter({
        date: "'.$day.' '.$month.' '.$year.' '.$time.'",
        timezone: "America/Los_Angeles",
        format: "dd:hh:mm:ss",
        twoDigits: "on",
        fallback: function() { console.alert("Counter finished!") }
      });     
    });
  </script>
  ';
}
add_shortcode('countdown', 'countdown_timer');