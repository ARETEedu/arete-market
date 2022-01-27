<?php
/**
 * The header part - left menu.
 *
 * This is the header template part.
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

<div class="king-leftnav">
	<div class="king-menu-left">
	<?php get_template_part( 'template-parts/header-templates/header-parts/format-links' ); ?>
	<?php get_template_part( 'template-parts/header-templates/header-parts/newnav' ); ?>
	</div>
	<?php wp_nav_menu( array( 'theme_location' => 'header-menu' ) ); ?>
		<?php if ( ! is_user_logged_in() ) : ?>
			<?php if ( get_option( 'permalink_structure' ) ) :
				global $wp;
				?>
				<a data-toggle="modal" data-target="#myModal" href="#" class="header-login"><i class="fa fa-user" aria-hidden="true"></i><?php esc_html_e( ' Login ', 'king' ); ?></a>
				<?php else : ?>
					<a href="<?php echo esc_url( wp_login_url( home_url() ) ); ?>" class="header-login"><i class="fa fa-user" aria-hidden="true"></i><?php esc_html_e( ' Login ', 'king' ); ?></a>
				<?php endif; ?>
				<?php if ( get_option( 'users_can_register' ) && get_option( 'permalink_structure' ) ) : ?>
					<a href="<?php echo esc_url( site_url() . '/' . $GLOBALS['king_register'] ); ?>" class="header-register"><i class="fas fa-globe-africa"></i><?php esc_html_e( ' Register ', 'king' ); ?></a>
				<?php endif; ?>
		<?php else : ?>
			<?php if ( get_option( 'permalink_structure' ) ) : ?>
				<a href="<?php echo esc_url( site_url() . '/' . $GLOBALS['king_account'] . '/settings' ); ?>" class="user-header-settings"><i class="fas fa-cog"></i><?php echo esc_html_e( 'My Settings','king' ); ?></a>
				<?php if ( get_field( 'enable_membership', 'option' ) && king_plugin_active( 'WooCommerce' ) ) : ?>
					<a href="<?php echo esc_url( add_query_arg( array( 'template' => 'myplan' ), site_url() . '/' . $GLOBALS['king_dashboard'] ) ); ?>"><i class="fas fa-fingerprint"></i><?php echo esc_html_e( 'My Membership', 'king' ); ?></a>
				<?php endif; ?>
				<?php if ( get_field( 'enable_private_messages', 'options' ) ) : ?>
					<a href="<?php echo esc_url( site_url() . '/' . $GLOBALS['king_prvtmsg'] ); ?>" class="user-header-prvtmsg"><i class="far fa-envelope-open"></i><?php echo esc_html_e( 'Inbox','king' ); ?><?php if ( $prvt_msg ) : ?><span class="header-prvtmsg-nmbr"><?php echo esc_attr( $prvt_msg ); ?></span><?php endif; ?></a>
				<?php endif; ?>
				<a href="<?php echo esc_url( site_url() . '/' . $GLOBALS['king_dashboard'] ); ?>" class="user-header-dashboard"><i class="fas fa-id-card-alt"></i><?php echo esc_html_e( 'My Dashboard','king' ); ?></a>
			<?php endif; ?>	
			<?php if ( is_super_admin() || current_user_can( 'editor' ) ) : ?>
				<a href="<?php echo esc_url( get_admin_url() ); ?>" class="user-header-admin"><i class="fas fa-users-cog"></i><?php echo esc_html_e( 'Admin Panel','king' ); ?></a>
			<?php endif; ?>
				<a href="<?php echo esc_url( wp_logout_url( site_url() ) ); ?>" class="user-header-logout"><i class="fas fa-sign-out-alt"></i><?php echo esc_html_e( 'Logout','king' ); ?></a>
		<?php endif; ?>
</div><!-- .king-leftnav -->
