<?php
/**
 * The header for our theme.
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package king
 */

// Prevent direct script access.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<?php if ( get_field( 'custom_html_head', 'options' ) ) : ?>
		<?php the_field( 'custom_html_head', 'options' ); ?>
	<?php endif; ?>
	<?php
	if ( get_field( 'enable_meta_tags', 'options' ) ) :
		king_meta_tags();
	endif;
	?>
	<?php if ( is_singular() && pings_open( get_queried_object() ) ) : ?>
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
<?php endif; ?>
<?php wp_head(); ?>
<?php //KB change
	king_dublin_core_tags();
?>
</head>
<body <?php body_class(); ?>>
<?php
// Header templates.
$headtemplate = get_field( 'header_templates', 'options' );
if ( $headtemplate ) :
	get_template_part( 'template-parts/header-templates/' . $headtemplate . '' );
else :
	get_template_part( 'template-parts/header-templates/header-template-01' );
endif;

// Display options.
if ( is_single() || is_post_type_archive( 'stories' ) ) {
	$display_option = '';
} elseif ( get_field( 'select_default_display_option', 'options' ) ) {
	$display_option = ' ' . get_field( 'select_default_display_option', 'options' );
} else {
	$display_option = ' king-grid-01';
}
?>

	<div id="content" class="site-content<?php echo esc_attr( $display_option ); ?>">
