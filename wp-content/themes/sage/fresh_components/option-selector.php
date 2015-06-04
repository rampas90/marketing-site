<?php

require_once 'option-selector-cloud.php';
require_once 'option-selector-pain-points.php';

function get_custom_option($i) {
    // Get vars
    $selected_option = get_sub_field('option');

    if ($selected_option == 'cloud') {
        get_cloud_option($i, $selected_option);
    } else if ($selected_option == 'pain_points_slider') {
		get_pain_points_option($i, $selected_option);
    }
}
