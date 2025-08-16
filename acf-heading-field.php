<?php
/*
	Plugin Name: Advanced Custom Fields: Heading Field
	Plugin URI: https://github.com/boostmetrica/acf-heading-field
	Description: A simple text field and heading level selector.
	Version: 1.0.2
	Author: boost.dev
	Author URI: https://boost.dev
	License: GPLv2 or later
	License URI: http://www.gnu.org/licenses/gpl-2.0.html
	Requires PHP: 7.4
*/

// Exit if accessed directly
if (!defined('ABSPATH')) {
	exit;
}

// Check PHP version compatibility
if (version_compare(PHP_VERSION, '7.4', '<')) {
	add_action('admin_notices', function() {
		echo '<div class="notice notice-error"><p>';
		echo __('ACF Heading Field requires PHP 7.4 or higher. You are running PHP ' . PHP_VERSION, 'acf-heading-field');
		echo '</p></div>';
	});
	return;
}

// 1. Include field type for ACF5
// $version = 5 and can be ignored until ACF6 exists
function include_field_types_heading_field( $version ) {

	include_once('acf-heading-field-v5.php');

}

add_action('acf/include_field_types', 'include_field_types_heading_field');
