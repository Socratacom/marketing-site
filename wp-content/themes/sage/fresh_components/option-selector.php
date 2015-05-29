<?php

require_once 'option-selector-cloud.php';

function get_custom_option($i) {
    // Get vars
    $selected_option = get_sub_field('option');

    if ($selected_option == 'cloud' ) {
        get_cloud_option($i, $selected_option);
    }
}
