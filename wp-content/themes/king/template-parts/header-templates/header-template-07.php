<?php
/**
 * The header template-05.
 *
 * This is the header template.
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
<?php
$options = get_field( 'header_07_options', 'options' );
if ( $options['position'] ) {
	$leftclass = ' right-header';
} else {
	$leftclass = '';
}
?>
<div id="page" class="site header-template-07<?php echo esc_attr( $leftclass ); ?>">
<?php get_template_part( 'template-parts/header-templates/header-parts/headerstrip' ); ?>
<header id="masthead" class="site-header">
	<div class="king-header header-07">
	<span class="king-leftmenu-toggle" data-toggle="dropdown" data-target=".header-07" aria-expanded="false" role="button"></span>
	<?php get_template_part( 'template-parts/header-templates/header-parts/logo' ); ?>

	<?php get_template_part( 'template-parts/header-templates/header-parts/leftnav' ); ?>

		<div class="header-07-bottom">
		<?php if ( get_field( 'disable_users_submit', 'options' ) !== true ) : ?>
			<?php if ( get_option( 'permalink_structure' ) ) : ?>
				<div class="king-submit-v2-open"  data-toggle="modal" data-target="#submitmodal" role="button"><i class="fa fa-plus fa-lg" aria-hidden="true"></i></div>
			<?php endif; ?>
		<?php endif; ?>
		<?php
		if ( get_field( 'enable_bookmarks', 'options' ) && is_user_logged_in() ) :
			echo king_header_bookmark();
		endif;
		?>
		<?php get_template_part( 'template-parts/header-templates/header-parts/notify' ); ?>
		<div id="searchv2-button"><i class="fa fa-search fa-lg" aria-hidden="true"></i></div>
		</div>
	</div><!-- .king-header -->
	<?php get_template_part( 'template-parts/header-templates/header-parts/submit-v2' ); ?>
	<?php get_template_part( 'template-parts/header-templates/header-parts/search-v2' ); ?>
</header><!-- #masthead -->
