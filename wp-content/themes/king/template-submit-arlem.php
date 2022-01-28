<?php
/**
 * Submit ARLEM Page.
 * KB 
 * @package King
 */

// Prevent direct script access.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
$GLOBALS['hide'] = 'hide';
global $king_submit_errors;


if ( isset( $_POST['king_post_upload_form_submitted'] ) && wp_verify_nonce( $_POST['king_post_upload_form_submitted'], 'king_post_upload_form' ) ) {

	$title    = sanitize_text_field( $_POST['king_post_title'] );
	$tags     = sanitize_text_field( $_POST['king_post_tags'] );
	$content  = stripslashes( $_POST['king_post_content'] );
	//$thumb    = sanitize_text_field( $_POST['acf']['field_60ae46d02f589'][0] );
	$category = isset( $_POST['king_post_category'] ) ? $_POST['king_post_category'] : '';

	$king_submit_errors = array();

	if ( get_field( 'maximum_title_length', 'option' ) ) {
		$title_length = get_field( 'maximum_title_length', 'option' );
	} else {
		$title_length = '140';
	}

	if ( get_field( 'maximum_content_length', 'option' ) ) {
		$content_length = get_field( 'maximum_content_length', 'option' );
	} else {
		$content_length = '2000';
	}

	if ( trim( $title ) === '' ) {
		$king_submit_errors['title_empty'] = esc_html__( 'Title is required.', 'king' );
	} elseif ( strlen( $title ) > $title_length ) {
		$king_submit_errors['title_empty'] = esc_html__( 'Title is too long.', 'king' );
	}

	if ( trim( $content ) === '' ) {
		$king_submit_errors['content_empty'] = esc_html__( 'Content is required.', 'king' );
	} elseif ( strlen( $content ) > $content_length ) {
		$king_submit_errors['content_empty'] = esc_html__( 'Content is too long.', 'king' );
	}

if ( trim( $thumb ) === '' ) {
		$king_submit_errors['image_empty'] = esc_html__( 'Thumbnail is required.', 'king' );
	}

	if ( empty( $king_submit_errors ) ) {
		switch ( $_POST['submit_type'] ) {
			case 'send':
				if ( is_super_admin() ) {
					$poststatus = 'publish';
				} elseif ( get_field( 'verified_posts', 'option' ) === true && get_field( 'verified_account', 'user_' . get_current_user_id() ) ) {
					$poststatus = 'publish';
				} elseif ( get_field( 'disable_post_moderation', 'option' ) ) {
					$poststatus = 'publish';
				} elseif ( get_field( 'enable_user_groups', 'options' ) && king_groups_permissions( 'groups_create_posts_without_approval' ) && get_field( 'groups_create_posts_without_approval', 'options' ) ) {
					$poststatus = 'publish';
				} else {
					$poststatus = 'pending';
				}
				break;
			case 'save':
				$poststatus = 'draft';
				break;
		}

		$postid    = wp_insert_post(
			array(
				'post_title'    => wp_strip_all_tags( $title ),
				'post_content'  => $content,
				'tags_input'    => $tags,
				'post_category' => $category,
				'post_status'   => $poststatus,
			)
		);
		$ftag      = 'post-format-arlem';
		$ftaxonomy = 'post_format';
		wp_set_post_terms( $postid, $ftag, $ftaxonomy );

		do_action( 'acf/save_post', $postid );

		set_post_thumbnail( $postid, $thumb );
		if ( $postid ) {
			$permalink = get_permalink( $postid );
			wp_safe_redirect( $permalink );
			exit;
		}
	}
}
?>

<?php acf_form_head(); get_header(); ?>
<?php $GLOBALS['hide'] = 'hide'; ?>
<header class="page-top-header">
	<h1 class="page-title"><?php echo esc_html_e( 'Submit AR Learning Experience Model', 'king' ); ?></h1>
</header><!-- .page-header -->

<?php get_template_part( 'template-parts/king-header-nav' ); ?>

<?php if ( ! is_user_logged_in() ) : ?>
	<div class="king-alert"><i class="fa fa-bell fa-lg" aria-hidden="true"></i><?php esc_html_e( 'You do not have permission to create a post !', 'king' ); ?>
		<a href="<?php echo esc_url( site_url() . '/' . $GLOBALS['king_login'] ); ?>" class="king-alert-button"><?php esc_html_e( 'Log in ', 'king' ); ?></a>
		<a href="<?php echo esc_url( site_url() . '/' . $GLOBALS['king_register'] ); ?>"><?php esc_html_e( 'Register', 'king' ); ?></a>
	</div>

<?php elseif ( get_field( 'disable_arlem', 'options' ) !== false || get_field( 'disable_users_submit', 'options' ) !== false ) : ?>
	<div class="king-alert"><i class="fa fa-bell fa-lg" aria-hidden="true"></i>
		<?php esc_html_e( 'You do not have permission to view this page!', 'king' ); ?></div>

<?php elseif ( get_field( 'only_verified', 'options' ) === true && ! get_field( 'verified_account', 'user_' . get_current_user_id() ) && ! is_super_admin() ) : ?>  
		<div class="king-alert"><i class="fa fa-bell fa-lg" aria-hidden="true"></i><?php esc_html_e( 'You do not have permission to view this page!', 'king' ); ?></div>
<?php elseif ( get_field( 'enable_user_groups', 'options' ) && ! king_groups_permissions( 'groups_create_posts' ) && ! is_super_admin() ) : ?>
	<div class="king-alert"><i class="fa fa-bell fa-lg" aria-hidden="true"></i><?php esc_html_e( 'You do not have permission to view this page!', 'king' ); ?></div>
<?php else : ?>

			<!-- #primary BEGIN -->
			<div id="primary" class="page-content-area">
				<main id="main" class="page-site-main king-submit-arlem">
					<?php if ( get_field( 'custom_message_arlem', 'options' ) ) : ?>
						<div class="king-custom-message">
							<?php the_field( 'custom_message_arlem', 'options' ); ?>
						</div>
					<?php endif; ?>
					<form id="king_posts_form" action="" method="POST" enctype="multipart/form-data">

						<div class="king-form-group">
							<label for="king_post_title"><?php esc_html_e( 'Title', 'king' ); ?></label>
							<input class="form-control bpinput" name="king_post_title" id="king_post_title" type="text" value="<?php echo esc_attr( isset( $_POST['king_post_title'] ) ? $_POST['king_post_title'] : '' ); ?>" maxlength="<?php the_field( 'maximum_title_length', 'option' ); ?>" required />
						</div>
						<?php if ( isset( $king_submit_errors['title_empty'] ) ) : ?>
							<div class="king-error"><?php echo esc_attr( $king_submit_errors['title_empty'] ); ?></div>
						<?php endif; ?>
						<?php
						$include    = array();
						$categories = get_terms(
							'category',
							array(
								'include'    => $include,
								'hide_empty' => false,
							)
						);

						$categories_count = count( $categories );
						if ( $categories_count > 1 ) :
							?>
						<div class="king-form-group form-categories">
							<span class="form-label"><?php esc_html_e( 'Select Category', 'king' ); ?></span>
							<ul>
								<?php
								foreach ( $categories as $cat ) {
									if ( $cat->parent == 0 ) {
										$catsfor = get_field( 'category_for', $cat );
										if ( $catsfor && in_array( 'for_arlem', $catsfor, true ) || ! $catsfor ) :
											echo '<li class="form-categories-item"><input type="checkbox" id="king_post_cat-' . esc_attr( $cat->term_id ) . '" name="king_post_category[]" value="' . esc_attr( $cat->term_id ) . '" /><label for="king_post_cat-' . esc_attr( $cat->term_id ) . '">' . esc_attr( $cat->name ) . '</label></li>';
									endif;
									foreach ( $categories as $subcategory ) {
										if ( $subcategory->parent == $cat->term_id ) {
												$scatsfor = get_field( 'category_for', $subcategory );
												if ( $scatsfor && in_array( 'for_arlem', $scatsfor, true ) || ! $scatsfor ) :
												echo '<li class="form-categories-item"><input type="checkbox" id="king_post_cat-' . esc_attr( $subcategory->term_id ) . '" name="king_post_category[]" value="' . esc_attr( $subcategory->term_id ) . '" /><label class="king-post-subcat" for="king_post_cat-' . esc_attr( $subcategory->term_id ) . '">' . esc_attr( $subcategory->name ) . '</label></li>';
										endif;
											}
										}
									}
								}
								?>
							</ul>
						</div>
					<?php endif; ?>
					
				</form>
			</main><!-- #main -->
		</div><!-- .main-column -->

	<?php endif; ?>
<?php wp_enqueue_media(); ?>
<?php get_footer(); ?>
