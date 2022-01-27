<?php
/**
 * User Liked Posts page.
 *
 * @package King
 */

// Prevent direct script access.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
$GLOBALS['hide']  = 'hide';
$GLOBALS['likes'] = 'active';
$profile_id = get_query_var( 'profile_id' );
if ( $profile_id ) {
	$this_user = get_user_by( 'login', $profile_id );
} else {
	$this_user = wp_get_current_user();
}
if ( ! $this_user->ID ) {
	wp_redirect(site_url());
}
$htemplate = get_field( 'profile_template', 'options' );
if ( $htemplate ) {
	$column = ' ' . $htemplate['column'];
} else {
	$column = '';
}
?>
<?php get_header(); ?>
<?php $GLOBALS['hide'] = 'hide'; ?>
<?php get_template_part( 'template-parts/king-profile-header' ); ?>
<div id="primary" class="site-main-top kflex <?php echo esc_attr( $column ); ?> lr-padding">
	<main id="main" class="site-main">
		<ul class="king-posts">
			<li class="grid-sizer"></li>
			<?php
			$pages = isset( $_GET['page'] ) ? $_GET['page'] : 0;
			if ( get_field( 'length_of_users_liked_posts', 'options' ) ) {
				$length_user_likes = get_field( 'length_of_users_liked_posts', 'option' );
			} else {
				$length_user_likes = '10';
			}

			$fav_posts = get_user_meta( $this_user->ID, 'king_favorites', true );


			if ( $fav_posts ) :
				$the_query = new WP_Query(
					[
						'post__in'       => array_reverse( $fav_posts ),
						'orderby'        => 'post__in',
						'posts_per_page' => $length_user_likes,
						'paged'          => $pages,
						'post__not_in'   => get_option( 'sticky_posts' ),
						'post_type'      => king_post_types(),
					]
				);

				$count = $the_query->found_posts;
				if ( $the_query->have_posts() ) :
					while ( $the_query->have_posts() ) :
						$the_query->the_post();
						get_template_part( 'template-parts/content', get_post_format() );
					endwhile;
					wp_reset_postdata();
				endif;
		else :
			?>
				<div class="no-follower"><i class="fab fa-slack-hash fa-2x"></i><?php esc_html_e( 'Sorry, no posts were found', 'king' ); ?> </div>
		<?php endif; ?>
				<div class="king-pagination">
					<?php
					$format = '?page=%#%';
					if ( $profile_id ) {
						$url = site_url() . '/' . $GLOBALS['king_likes'] . '/' . $profile_id . '%_%';
					} else {
						$url = site_url() . '/' . $GLOBALS['king_likes'] . '/%_%';
					}
							$big = 999999999; // need an unlikely integer.
							echo paginate_links(
								array(
									'base'      => $url,
									'format'    => $format,
									'current'   => max( 1, $pages ),
									'total'     => $the_query->max_num_pages,
									'prev_next' => true,
									'prev_text' => '<i class="fa fa-chevron-left" aria-hidden="true"></i>',
									'next_text' => '<i class="fa fa-chevron-right" aria-hidden="true"></i>',
								)
							);
							?>
					</div>
				</ul>
			</main><!-- #main -->
		</div><!-- #primary -->
<?php get_footer(); ?>
