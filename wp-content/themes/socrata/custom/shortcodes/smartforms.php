<?php
// SHORTCODE FOR SMART FORMS
// [smartforms id="PASTE ID HERE"]
add_shortcode("smartforms", "marketo");
function marketo($atts) {
  wp_enqueue_script( 'smartform_script_one' );
  wp_enqueue_script( 'smartform_script_two' );
  wp_enqueue_script( 'smartform_script_three' );
  wp_enqueue_script( 'smartform_script_four' );
  extract(shortcode_atts(array(
    "id" => '',
  ), $atts));
  return '<script src="//app-abk.marketo.com/js/forms2/js/forms2.js"></script>
    <form id="mktoForm_'.$id.'"></form>
    <script>MktoForms2.loadForm("//app-abk.marketo.com", "851-SII-641", '.$id.');</script>
  <style type="text/css">
  .divDisplayFrame {
    visibility:hidden; 
    border-color:#C9FFFF; 
    border-width:1px !important;
    background-color:#ffffff !important;
    text-align:left;
    -webkit-border-radius:3px;
    -moz-border-radius:3px;
    border-radius:3px;
    -moz-box-shadow:5px 5px 7px 3px #888888;
    -webkit-box-shadow:5px 5px 7px 3px #888888;
    box-shadow:5px 5px 7px 3px #888888;
  }
  .divDisplayFrame hr {
    margin:0 !important;
  }
  .tabCompList {
    border:0;
    margin-bottom:10px;
  }
  .tabCompList caption {
    line-height:95%;
    padding:0;
  }
  .tabCompList h3 {
    padding:20px;
    color:#222;
    border-width:0;
  }
  .tabCompList td {
    line-height:115%;
    font-size:14px;
    border-width:0;
  }
  .tabCompTR {}
  .tabCompTD {}
  .tabCompNATR {}
  .tabCompNATD {}
  .divCompList {}
  .divCompName {
    color:#15317E;
  }
  .divCompDetails {
    color:#606060;
  }
  .divCompNAList {}
  .divCompNAName {
    color:#15317E;
    font-weight:bold;
    font-size:12px;
  }
  .divCompNADetails {}
  .divLoadingFrame {}
  </style>
  ';

}