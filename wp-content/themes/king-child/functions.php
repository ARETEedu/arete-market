<?php
// Prevent direct script access.
if ( ! defined( 'ABSPATH' ) ) {
	die( 'No direct script access allowed' );
}
/**
 * { function_description }
 */
function enqueue_parent_styles() {
	wp_enqueue_style( 'parent-style', get_template_directory_uri() . '/style.css' );
}
add_action( 'wp_enqueue_scripts', 'enqueue_parent_styles' );
