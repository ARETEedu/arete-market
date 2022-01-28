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

//https://www.cloudways.com/blog/how-to-create-custom-post-types-in-wordpress/
/* Custom Post Type: Augmented Reality Learning Experience Models (ARLEM) */
function cw_post_type_arlem() {

	$supports = array(
		'title', // post title
		'editor', // post content
		'author', // post author
		'thumbnail', // featured images
		'excerpt', // post excerpt
		'custom-fields', // custom fields
		'comments', // post comments
		'revisions', // post revisions
		'post-formats', // post formats
	);
	
	$labels = array(
		'name' => _x('ARLEMs', 'plural'),
		'singular_name' => _x('ARLEM', 'singular'),
		'menu_name' => _x('AR Learning Experience Model', 'admin menu'),
		'name_admin_bar' => _x('ARLEM', 'admin bar'),
		'add_new' => _x('Add New', 'add new'),
		'add_new_item' => __('Add New ARLEM Post'),
		'new_item' => __('New ARLEM'),
		'edit_item' => __('Edit ARLEM'),
		'view_item' => __('View ARLEM'),
		'all_items' => __('All ARLEMs'),
		'search_items' => __('Search ARLEMs'),
		'not_found' => __('No ARLEM found.'),
	);
	
	$args = array(
		'supports' => $supports,
		'labels' => $labels,
		'public' => true,
		'query_var' => true,
		'rewrite' => array('slug' => 'arlem'),
		'has_archive' => true,
		'hierarchical' => false,
	);
	register_post_type('arlem', $args);
}

add_action('init', 'cw_post_type_arlem');
	
/*Custom Post type end*/

add_theme_support(
	'post-formats',
	array(
		'quote',
		'image',
		'video',
		'link',
		'audio',
		'arlem'
	)
);