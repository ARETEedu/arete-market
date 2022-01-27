<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the #content div and all content after.
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
</div><!-- #content -->
<footer id="colophon" class="site-footer">
	<div class="lr-padding">
		<?php if ( get_field( 'ad_in_footer', 'options' ) ) : ?>
			<div class="king-ads footer-ad">
				<?php
				$ad_footer = get_field( 'ad_in_footer', 'options' );
				echo do_shortcode( $ad_footer );
				?>
			</div>
		<?php endif; ?>		
		<?php
		if ( is_active_sidebar( 'first-footer-widget-area' ) || is_active_sidebar( 'second-footer-widget-area' ) || is_active_sidebar( 'third-footer-widget-area' ) || is_active_sidebar( 'fourth-footer-widget-area' ) ) :
			?>
		<aside class="fatfooter" role="complementary">
			<?php if ( is_active_sidebar( 'first-footer-widget-area' ) ) : ?>
				<div class="first widget-area">
					<?php dynamic_sidebar( 'first-footer-widget-area' ); ?>
				</div><!-- .first .widget-area -->
			<?php endif; ?>
			<?php if ( is_active_sidebar( 'second-footer-widget-area' ) ) : ?>
				<div class="second widget-area">
					<?php dynamic_sidebar( 'second-footer-widget-area' ); ?>
				</div><!-- .second .widget-area -->
			<?php endif; ?>
			<?php if ( is_active_sidebar( 'third-footer-widget-area' ) ) : ?>
				<div class="third widget-area">
					<?php dynamic_sidebar( 'third-footer-widget-area' ); ?>
				</div><!-- .third .widget-area -->
			<?php endif; ?>
			<?php if ( is_active_sidebar( 'fourth-footer-widget-area' ) ) : ?>
				<div class="fourth widget-area">
					<?php dynamic_sidebar( 'fourth-footer-widget-area' ); ?>
				</div><!-- .fourth .widget-area -->
			<?php endif; ?>
		</aside><!-- #fatfooter -->
	<?php endif; ?>
	<div class="footer-info">
		<div class="site-info">
			<?php the_field( 'footer_copyright', 'options' ); ?>
		</div><!-- .site-info -->
		<div class="king-footer-social">
			<ul>
				<?php if ( get_field( 'footer_facebook_link', 'options' ) ) : ?>
					<li><a href="<?php the_field( 'footer_facebook_link', 'options' ); ?>" target="_blank"><i class="fab fa-facebook"></i></a></li>
				<?php endif; ?>
				<?php if ( get_field( 'footer_linkedin_link', 'options' ) ) : ?>
					<li><a href="<?php the_field( 'footer_linkedin_link', 'options' ); ?>"><i class="fab fa-linkedin"></i></a></li>
				<?php endif; ?>
				<?php if ( get_field( 'footer_twitter_link', 'options' ) ) : ?>
					<li><a href="<?php the_field( 'footer_twitter_link', 'options' ); ?>"><i class="fab fa-twitter"></i></a></li>
				<?php endif; ?>
				<?php if ( get_field( 'footer_instagram_link', 'options' ) ) : ?>
					<li><a href="<?php the_field( 'footer_instagram_link', 'options' ); ?>"><i class="fab fa-instagram"></i></a></li>
				<?php endif; ?>
				<?php if ( get_field( 'footer_custom_link', 'options' ) ) : ?>
					<?php the_field( 'footer_custom_link', 'options' ); ?>
				<?php endif; ?>			
			</ul>
		</div>
	</div>
</div>
</footer><!-- #colophon -->
</div><!-- #page -->

<?php wp_footer(); ?>
<?php get_template_part( 'template-parts/king-header-login' ); ?>
<?php
if ( get_field( 'enable_lightbox_gallery', 'option' ) && is_single() && has_post_format( 'image' ) ) {
	get_template_part( 'template-parts/post-templates/single-parts/gallery' );
}
?>
<?php
if ( get_field( 'enable_bookmarks', 'options' ) ) :
	get_template_part( 'template-parts/header-templates/header-parts/readlater' );
endif;
?>
<?php
if ( get_field( 'enable_newsletter_popup', 'options' ) ) :
	get_template_part( 'template-parts/header-templates/header-parts/newsletter' );
endif;
?>
<?php if ( get_field( 'enable_gdpr_cookie', 'options' ) ) : ?>
	<aside id="king-cookie" class="king-cookie" style="display: none;">
		<p class="king-cookie-content"><?php the_field( 'cookie_popup_content', 'options' ); ?></a></p>
		<div class="king-cookie-footer">
			<a id="king-cookie-accept" class="king-cookie-accept" href="#"><?php the_field( 'cookie_button_text', 'options' ); ?></a>
		</div>
	</aside>
<?php endif; ?>
</body>
</html>
