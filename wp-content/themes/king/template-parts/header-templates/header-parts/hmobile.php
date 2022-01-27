<?php
/**
 * The header part - mobile menu.
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

<div class="king-head-mobile">
	<button class="king-head-mobile-close" type="button" data-toggle="dropdown" data-target=".king-head-mobile" aria-expanded="false"><i class="fa fa-times fa-2x" aria-hidden="true"></i></button>
		<form role="search" method="get" class="king-mobile-search" action="<?php echo esc_url( home_url( '/' ) ); ?>">
			<input type="search" class="king-mobile-search-field"
			placeholder="<?php echo esc_html_e( 'Search …', 'king' ); ?>"
			value="<?php echo get_search_query(); ?>" name="s" autocomplete="off"
			title="<?php echo esc_html_e( 'Search', 'king' ); ?>" />
		</form>
	<?php get_template_part( 'template-parts/header-templates/header-parts/format-links' ); ?>
	<?php get_template_part( 'template-parts/header-templates/header-parts/newnav' ); ?>
	<div class="king-cat-list-mobile">
		<?php wp_nav_menu( array( 'theme_location' => 'header-menu' ) ); ?>
	</div>
</div><!-- .king-head-mobile -->
