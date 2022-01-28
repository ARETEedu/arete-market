<?php
/**
 * Single ARLEM.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package king
 */

// Prevent direct script access.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header(); ?>

<?php get_template_part( 'template-parts/king-header-nav' ); ?>
<?php

	$arlemtemplate  = get_field_object( 'arlem_posts_templates', 'options' );
	$arlemtemplate2 = get_field_object( 'arlem_template' );

	if ( ! empty( $arlemtemplate['value'] ) ) {
		get_template_part( 'template-parts/post-templates/single', $arlemtemplate['value'] );
	} elseif ( ! empty( $arlemtemplate2['value'] ) ) {
		get_template_part( 'template-parts/post-templates/single', $arlemtemplate2['value'] );
	} else {
		get_template_part( 'template-parts/post-templates/single', 'arlem-template' );
	}
	get_template_part( 'template-parts/post-templates/single-parts/modal-share' );
	
?>