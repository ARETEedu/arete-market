<?php
/**
 * The content part - thumb.
 *
 * This is a content template part.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package king
 */

// Prevent direct script access.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<div class="post-featured-trending">	
	<?php if ( get_field( 'featured-post' ) ) : ?>
		<div class="featured" data-toggle="tooltip" data-placement="bottom" title="<?php echo esc_html_e( 'featured', 'king' ); ?>"><i class="fa fa-rocket fa-lg" aria-hidden="true"></i></div><!-- .featured -->
	<?php endif; ?>
	<?php if ( get_field( 'keep_trending' ) ) : ?>
		<div class="trending" data-toggle="tooltip" data-placement="bottom" title="<?php echo esc_html_e( 'trending', 'king' ); ?>"><i class="fa fa-bolt fa-lg" aria-hidden="true"></i></div><!-- .trending -->
	<?php endif; ?>
	<?php if ( is_sticky() ) : ?>
		<div class="trending sticky" data-toggle="tooltip" data-placement="bottom" title="<?php echo esc_html_e( 'sticky', 'king' ); ?>"><i class="fa fa-paperclip fa-lg" aria-hidden="true"></i></div><!-- .trending -->
	<?php endif; ?>
	<?php
	if ( get_field( 'enable_bookmarks', 'options' ) && is_user_logged_in() ) :
		echo wp_kses_post( king_bookmark_button( get_current_user_id(), get_the_ID() ) );
	endif;
	?>
</div>
