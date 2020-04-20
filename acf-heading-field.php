<?php
/*
	Plugin Name: Advanced Custom Fields: Heading Field
	Plugin URI: https://github.com/digitalbeast-co-uk/acf-heading-field
	Description: A simple text field and heading level selector.
	Version: 0.0.1
	Author: Digital Beast
	Author URI: https://github.com/digitalbeast-co-uk
	License: GPLv2 or later
	License URI: http://www.gnu.org/licenses/gpl-2.0.html
*/


// 1. Include field type for ACF5
// $version = 5 and can be ignored until ACF6 exists
function include_field_types_heading_field( $version ) {

	include_once('acf-heading-field-v5.php');

}

add_action('acf/include_field_types', 'include_field_types_heading_field');

