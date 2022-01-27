<?php
/**
 * The main template file.
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package king
 */

// Prevent direct script access.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header(); ?>
<?php
// Slider.
if ( is_front_page() && is_home() && get_field( 'display_slider', 'options' ) && 'header-template-08' !== get_field( 'header_templates', 'options' ) ) :
	if ( ( get_field( 'slider_template', 'options' ) === 'slider-template-1' || get_field( 'slider_template', 'options' ) === 'slider-template-2' ) ) :
		get_template_part( 'template-parts/king-featured-posts' );
	elseif ( get_field( 'slider_template', 'options' ) === 'slider-template-3' ) :
		get_template_part( 'template-parts/king-featured-video' );
	endif;
endif;
// Header Navigation.
get_template_part( 'template-parts/king-header-nav' );

if ( get_field( 'enable_stories', 'options' ) && get_field( 'display_stories_on_homepage', 'options' ) ) {
	$storyargs['home'] = true;
	get_template_part( 'template-parts/king', 'stories', $storyargs );
}
// Mini Slider.
if ( is_front_page() && is_home() && get_field( 'display_mini_slider', 'options' ) ) :
	if ( get_field( 'show_in_mini_slider', 'options' ) === 'show_categories' ) {
		get_template_part( 'template-parts/king-featured-cats' );
	} else {
		get_template_part( 'template-parts/king-featured-small' );
	}
endif;

// Navigation page id.
if ( get_field( 'pagination_type', 'options' ) ) {
	$pagination_id = get_field( 'pagination_type', 'options' );
} else {
	$pagination_id = 'king-pagination-01';
}
// Sidebar templates.
$htemplate = get_field( 'homepage_template', 'options' );
if ( $htemplate ) {
	$sidebar = $htemplate['sidebar'];
	if ( $htemplate['column'] ) {
		$column = ' ' . $htemplate['column'];
	} else {
		$column = '';
	}
} else {
	$sidebar = 'king-sidebar-01';
	$column  = '';
}
?>
<div id="primary" class="content-area">
	<div id="<?php echo esc_attr( $pagination_id ); ?>" class="site-main-top kflex <?php echo esc_attr( $sidebar . $column ); ?> lr-padding">
		<?php if ( get_field( 'ad_main_area_top', 'options' ) ) : ?>
			<div class="king-ads main-top">
				<?php
				$ad_top = get_field( 'ad_main_area_top', 'options' );
				echo do_shortcode( $ad_top );
				?>
			</div>
		<?php endif; ?>
		<?php
		if ( ( 'king-sidebar-02' === $sidebar ) || ( 'king-sidebar-03' === $sidebar ) ) {
			get_sidebar( '2' );
		}
		?>
		<main id="main" class="site-main">
			<ul class="king-posts">
				<li class="grid-sizer"></li>
				<?php
				if ( have_posts() ) :

					if ( is_home() && ! is_front_page() ) : ?>
						<header>
							<h1 class="page-title screen-reader-text"><?php single_post_title(); ?></h1>
						</header>

						<?php
					endif;
					/* Start the Loop */
					while ( have_posts() ) :
						the_post();

						/*
						 * Include the Post-Format-specific template for the content.
						 * If you want to override this in a child theme, then include a file
						 * called content-___.php (where ___ is the Post Format name) and that will be used instead.
						 */
						get_template_part( 'template-parts/content', get_post_format() );
					endwhile;

					get_template_part( 'template-parts/king-pagination' );

				else :

					get_template_part( 'template-parts/content', 'none' );

				endif;
				?>
			</ul>
		</main><!-- #main -->
		<?php
		if ( ( 'king-sidebar-01' === $sidebar ) || ( 'king-sidebar-03' === $sidebar ) || ( 'king-sidebar-05' === $sidebar ) ) {
			get_sidebar();
			if ( ( 'king-sidebar-05' === $sidebar ) ) {
				get_sidebar( '2' );
			}
		}
		?>
	</div><!-- #king-pagination -->		
</div><!-- #primary -->

<?php get_footer(); ?>
