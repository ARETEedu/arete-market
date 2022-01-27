<?php
/**
 * The header part - headnav.
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
<?php
$menu_slug = 'header-nav';
$hnavs     = '';
if ( ( $locations = get_nav_menu_locations() ) && isset( $locations[ $menu_slug ] ) ) {
	$menus = get_term( $locations[ $menu_slug ] );
	$hnavs = wp_get_nav_menu_items( $menus->term_id );
}
$smenu = array();
if ( $hnavs ) :
	foreach ( $hnavs as $key => $hnav ) {
		$pid = $hnav->menu_item_parent;
		if ( $pid ) {
			$smenu[ $pid ]['links_in_mega_menu'][] = array(
				'mega_menu_link_text' => $hnav->title,
				'mega_menu_link_url'  => $hnav->url,
			);
		}
	}
	$hnavs = king_wp_nav_menu_objects( $hnavs, null );
	foreach ( $hnavs as $hnav ) :
		$mtype = ( 'category' === $hnav->object ) ? 'c' : 't';

		?>
		<?php if ( empty( $hnav->menu_item_parent ) ) : ?>
			<li>
				<a class="king-head-nav-a" href="<?php echo esc_url( $hnav->url ); ?>"><?php echo wp_kses_post( $hnav->title ); ?></a>
				<?php if ( get_field( 'enable_mega_menu', $hnav ) ) : ?>
					<?php echo wp_kses_post( king_mega_menu( $smenu[ $hnav->ID ], $hnav->object_id, 5, 'recent', array( 'post', 'list', 'poll', 'trivia' ), $mtype ) ); ?>
				<?php endif; ?>
			</li>
		<?php endif; ?>
	<?php endforeach; ?>
<?php endif; ?>
