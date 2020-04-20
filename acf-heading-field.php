<?php
/*
	Plugin Name: Advanced Custom Fields: Heading Field
	Plugin URI: https://oxwebdev.com
	Description: A simple text field that includes a selection for heading type (h1, h2... h6)
	Version: 0.0.1
	Author: OxWebDev
	Author URI: https://oxwebdev.com
	License: GPLv2 or later
	License URI: http://www.gnu.org/licenses/gpl-2.0.html
*/


// 1. Include field type for ACF5
// $version = 5 and can be ignored until ACF6 exists
function include_field_types_heading_field( $version ) {

	include_once('acf-heading-field-v5.php');

}

add_action('acf/include_field_types', 'include_field_types_heading_field');

