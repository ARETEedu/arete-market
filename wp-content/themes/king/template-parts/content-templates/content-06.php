<?php
/**
 * Post Templates 01.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package king
 */

// Prevent direct script access.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>

<li class="king-post-item">
	<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
		<?php if ( get_field( 'nsfw_post' ) && ! is_user_logged_in() ) : ?>
		<div class="nsfw-post">
			<a href="<?php echo esc_url( site_url() . '/' . $GLOBALS['king_login'] ); ?>">
				<i class="fa fa-paw fa-3x"></i>
				<div><h1><?php echo esc_html_e( 'Not Safe For Work', 'king' ); ?></h1></div>
				<span><?php echo esc_html_e( 'Click to view this post.', 'king' ); ?></span>
			</a>	
		</div>
		<?php else : ?>
				<?php get_template_part( 'template-parts/content-templates/content-parts/content-thumb' ); ?>
		<?php endif; ?>
			<div class="article-meta">
				<?php get_template_part( 'template-parts/content-templates/content-parts/content-meta' ); ?>
				<header class="entry-header">
					<?php
					if ( is_single() ) {
						the_title( '<h1 class="entry-title">', '</h1>' );
					} else {
						the_title( '<h2 class="entry-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h2>' );
					}
					?>
				</header><!-- .entry-header -->
			</div><!-- .article-meta -->	
		</article><!--#post-##-->
	</li>
