<?php
/**
 * Post Edit template
 *
 * Allow edits to:
 *  - Title
 *  - Content
 *  - Tags
 *  - Category
 *  - Thumbnail
 *  - Video
 *  - License
 * Do not allow edits to
 *  - ARLEM folder
 *  - Consent to GDPR and T&Cs
 * @package king
 */

// Prevent direct script access.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
$GLOBALS['hide'] = 'hide';
global $king_submit_errors;
$postid = $_GET["post"];
$format = get_post_format( $postid );
$status = get_post_status( $postid );

if ( isset( $_POST['king_edit_post_upload_form_submitted'] ) && wp_verify_nonce( $_POST['king_edit_post_upload_form_submitted'], 'king_edit_post_upload_form' ) ) { // input var okay; sanitization okay.

	if ( 'delete' === $_POST['king-editpost'] ) {
		wp_delete_post( $postid );
		wp_redirect( home_url() );
		exit;
	}
	if ( 'cancel' === $_POST['king-editpost'] ) {
		wp_redirect( home_url() );
		exit;
	}

	// Get clean input variables
	$edit_title         = sanitize_text_field( $_POST['king_post_title'] );
	$tags               = sanitize_text_field( $_POST['king_post_tags'] );
	$edit_content       = stripslashes( $_POST['king_post_content'] );
	$category           = isset( $_POST['king_post_category'] ) ? $_POST['king_post_category'] : '';
	$licence 			= isset( $_POST['king_post_licence'] ) ? $_POST['king_post_licence'] : '';

	$video_url    = '';
	$video_upload = '';
	$video_embed  = '';
	if ( isset( $_POST['video_url'] ) ) {
		$video_url = wp_unslash( $_POST['video_url'] ); // Input var okey.
	}
	if ( isset( $_POST['acf']['field_58f5335001eed'] ) ) {
		$video_upload = esc_url( wp_unslash( $_POST['acf']['field_58f5335001eed'] ) ); // Input var okey.
	}
	if ( isset( $_POST['acf']['field_59c9812458fe6'] ) ) {
		$video_embed = wp_unslash( $_POST['acf']['field_59c9812458fe6'] ); // Input var okey.
	}

	$king_submit_errors = array();
	//Title must not be too long
	if ( get_field( 'maximum_title_length', 'option' ) ) {
		$title_length = get_field( 'maximum_title_length', 'option' );
	} else {
		$title_length = '140';
	}
	//Title must be set
	if ( trim( $edit_title ) === '' ) {
		$king_submit_errors['title_empty'] = esc_html__( 'Title is required.', 'king' );
	} elseif ( strlen( $edit_title ) > $title_length ) {
		$king_submit_errors['title_empty'] = esc_html__( 'Title is too long.', 'king' );
	}
	//Content must not be too long
	if ( get_field( 'maximum_content_length', 'option' ) ) {
		$content_length = get_field( 'maximum_content_length', 'option' );
	} else {
		$content_length = '2000';
	}
	//Content must be set
	if ( trim( $edit_content ) === '' ) {
		$king_submit_errors['content_empty'] = esc_html__( 'Content is required.', 'king' );
	} elseif ( strlen( $edit_content ) > $content_length ) {
		$king_submit_errors['content_empty'] = esc_html__( 'Content is too long.', 'king' );
	}
	$no_video =  (trim( $video_url ) === '') && (trim( $video_upload ) === '') && (trim( $video_embed ) === '' );
	$no_thumbnail = trim( $thumb ) === '' && empty( $post_thumb );
	//There must be a thumbnail image OR a video
	if ($no_thumbnail && $no_video) {
		$king_submit_errors['image_empty'] = esc_html__( 'Either a thumbnail or video is required.', 'king' );
	}		
	//Licence must be selected
	if ( trim( $licence ) === '' ) {
		$king_submit_errors['licence_empty'] = esc_html__( 'You must select a licence.', 'king' );
	}
	
	if ( empty( $king_submit_errors ) ) {

		if ( is_super_admin() ) {
			$poststatus = 'publish';
		} elseif ( get_field( 'moderate_posts_edit', 'option' ) ) {
			$poststatus = 'pending';
		} elseif ( 'save' === $_POST['king-editpost'] ) {
			$poststatus = $status;
		} elseif ( 'publish' === $_POST['king-editpost'] ) {
			$poststatus = 'publish';
		}
		
		$post_information = array(
			'ID'            => $postid,
			'post_title'    =>  wp_strip_all_tags( $edit_title ),
			'post_content'  => $edit_content,
			'tags_input'    => $tags,
			'post_category' => $category,
			'post_status'   => $poststatus,
		);

		$post_id = wp_update_post( $post_information );
		
		//$no_thumbnail : user hasn't uploaded, and there isn't one in the ARLEM folder
		//If there is a video, get the thumbnail for it
		if (trim( $video_url !== '')) {
			update_field( 'video-url', $video_url, $post_id );
			update_post_meta( $post_id, '_video-url', 'field_587be2665e807' );
		
			if ($no_thumbnail) {
				require_once KING_INCLUDES_PATH . 'videothumbs.php';
				$ktype = king_source( $video_url );

				if ( 'vimeo.com' === $ktype || 'dailymotion.com' === $ktype || 'metacafe.com' === $ktype || 'vine.co' === $ktype || 'instagram.com' === $ktype || 'vid.me' === $ktype || 'tiktok.com' === $ktype || 'soundcloud.com' === $ktype ) {
					$image_url = king_get_thumb( $video_url );
				} elseif ( 'youtube.com' === $ktype || 'youtu.be' === $ktype ) {
					$image_url = king_youtube( $video_url );
				} elseif ( 'facebook.com' === $ktype ) {
					$image_url = king_facebook( $video_url );
				} else {
					$image_url = king_get_thumb( $video_url );
				}
				$attach_id = king_upload_user_file_video( $image_url , $post_id );
				set_post_thumbnail( $post_id, $attach_id );
			}
		} 
		
		//Update the licence field
		update_field( 'licence', $licence, $post_id );
		update_post_meta( $post_id, '_licence', 'field_5aaalicencesc' );

		do_action( 'acf/save_post' , $postid );
		if ( $post_id ) {
			$permalink = get_permalink( $post_id );
			wp_redirect( $permalink );
			exit;
		}
	}
}



acf_form_head();
get_header(); ?>
<?php
$title          = get_the_title( $postid );
$content        = apply_filters( 'the_content', get_post_field( 'post_content', $postid ) );
$tags           = strip_tags( get_the_term_list( $postid, 'post_tag', '', ', ', '' ) );
$post_thumb     = get_post_thumbnail_id( $postid );
$post_thumb_url = get_the_post_thumbnail_url( $postid, 'medium' );
$post_author    = get_post_field( 'post_author', $postid );
$current_user   = wp_get_current_user();
$licence 		= get_post_meta( $postid, 'licence', true );
//Get licence name out of string
$licence_name =  $licence[0];

?>
<header class="page-top-header">
	<h1 class="page-title"><?php echo esc_html_e( 'Edit '.$title, 'king' ); ?></h1>
</header><!-- .page-header -->

<?php get_template_part( 'template-parts/king-header-nav' ); ?>

<!-- Initial checks: does the user have permission, are they logged in, etc -->
<?php if ( ! is_user_logged_in() || empty( $title ) || empty( $postid ) || ! get_field( 'enable_post_edit', 'options' )  ): ?>
	<div class="king-alert"><i class="fa fa-bell fa-lg" aria-hidden="true"></i><?php esc_html_e( 'You do not have permission to edit this post !', 'king' ); ?></div>
<?php elseif ( esc_attr( $post_author ) !== esc_attr( $current_user->ID ) && ! is_super_admin() ) : ?>
	<div class="king-alert"><i class="fa fa-bell fa-lg" aria-hidden="true"></i><?php esc_html_e( 'You do not have permission to edit this post !', 'king' ); ?></div>
<?php elseif ( ( get_field( 'verified_edit_posts', 'options' ) && ! get_field( 'verified_account', 'user_' . $current_user->ID ) ) && ( get_field( 'enable_user_groups', 'options' ) && ! king_groups_permissions( 'groups_edit_their_own_posts' ) ) && ! is_super_admin() ) : ?>
	<div class="king-alert"><i class="fa fa-bell fa-lg" aria-hidden="true"></i><?php esc_html_e( 'You do not have permission to edit this post !', 'king' ); ?></div>
<?php else : ?>

<!-- #primary BEGIN -->
<div id="primary" class="page-content-area">
	<main id="main" class="page-news-main king-post-edit">
		<form id="king_posts_form" action="" method="POST" enctype="multipart/form-data">
			<div class="submit-news-left">
				<!--ERRORS -->
				<!-- Check there is a title -->
				<?php if ( isset( $king_submit_errors['title_empty'] ) ) : ?>
					<div class="king-error"><?php echo esc_attr( $king_submit_errors['title_empty'] ); ?></div>
				<?php endif; ?>
				<!-- Check there is a licence -->
				<?php if ( isset( $king_submit_errors['licence_empty'] ) ) : ?>
					<div class="king-error"><?php echo esc_attr( $king_submit_errors['licence_empty'] ); ?></div>
				<?php endif; ?>
				<!-- Check there is an image -->
				<?php if ( isset( $king_submit_errors['image_empty'] ) ) : ?>
					<div class="king-error"><?php echo esc_attr( $king_submit_errors['image_empty'] ); ?></div>
				<?php endif; ?>	
				<!-- Check there is a description (content) -->
				<?php if ( isset( $king_submit_errors['content_empty'] ) ) : ?>
					<div class="king-error"><?php echo esc_attr( $king_submit_errors['content_empty'] ); ?></div>
				<?php endif; ?>
				
				<!-- TITLE -->
				<div class="king-form-group">
					<label for="king_post_title"><?php esc_html_e( 'Title', 'king' ); ?></label>
					<input class="form-control bpinput" name="king_post_title" id="king_post_title" type="text" value="<?php echo esc_attr( $title ); ?>" maxlength="<?php the_field( 'maximum_title_length', 'option' ); ?>" required />
				</div>
				
				<!-- CATEGORIES -->
				<span class="info-block"><?php esc_html_e( 'Please select one or more categories', 'king' ) ?></span>
				<?php
				$include          = array();
				$categories       = get_terms(
					'category',
					array(
						'include'    => $include,
						'hide_empty' => false,
					)
				);
				$categories_count = count( $categories );

				// get post categories.
				$post_cats     = get_the_category( $postid );
				$post_cats_arr = array();

				foreach ( $post_cats as $post_cat ) {
					$post_cats_arr[] = $post_cat->term_id;
				}
				if ( $categories_count > 1 ) :
					?>
				<div class="king-form-group form-categories">
					<span class="form-label"><?php esc_html_e( 'Select Category', 'king' ); ?></span>
					<ul>
						<?php
						foreach ( $categories as $cat ) {
							if ( $format === 'arlem' ) { //KB CHANEGS
								$catsfor = get_field( 'category_for', $cat );
								if ( $catsfor && in_array( 'for_arlem', $catsfor, true ) || ! $catsfor ) :
									$checked = '';
									if ( in_array( $cat->term_id, $post_cats_arr ) ) {
										$checked = 'checked';
									}
									echo '<li class="form-categories-item"><input type="radio" id="king_post_cat-' . esc_attr( $cat->term_id ) . '" name="king_post_category[]" value="' . esc_attr( $cat->term_id ) . '" ' . esc_attr( $checked ) . ' /><label for="king_post_cat-' . esc_attr( $cat->term_id ) . '">' . esc_attr( $cat->name ) . '</label></li>';
								endif;
							} 
						}
						?>
					</ul>
				</div>
				<?php endif; ?>		
				<!-- LICENCES --> 
				<span class="info-block"><?php esc_html_e( 'Please select a licence', 'king' ) ?></span>
				<?php if( have_rows('licences', 'option') ): ?>
				<div class="king-form-group form-licences" >
					<span class="form-label"><?php esc_html_e( 'Select Licence', 'king' ); ?></span>
					<ul>
					<?php 
						while( have_rows('licences', 'option') ) : the_row();
							$lic = get_sub_field('licence_name');
							$checked = '';
							if ( $licence_name == $lic ) {
								$checked = 'checked';
							}
							echo '<li class="form-licences-item"><input type="radio" id="king_post_licence-' . esc_attr( $lic ) . '" name="king_post_licence[]" value="' . esc_attr( $lic ) . '" '. esc_attr( $checked ) .' /><label for="king_post_licence-' . esc_attr( $lic ) . '">' . esc_attr( $lic ) . '</label></li>';	
						endwhile; 
					?>
					</ul>
				</div>
				<?php endif; ?>
				<!-- CONTENT --> 		
				<div class="king-form-group">
					<label for="king_post_content"><?php esc_html_e( 'Content', 'king' ); ?></label>
					<div class="tinymce" id="king_post_content"><?php echo( wp_kses_post( html_entity_decode( $content ) ) ); ?></div>
				</div>
				<?php if ( isset( $king_submit_errors['content_empty'] ) ) : ?>
					<div class="king-error"><?php echo esc_attr( $king_submit_errors['content_empty'] ); ?></div>
				<?php endif; ?>			
						
				<div class="king-form-group">
					<label for="king_post_tags"><?php esc_html_e( 'Tags', 'king' ); ?></label>
					<input class="form-control bpinput" name="king_post_tags" id="king_post_tags" type="text" value="<?php echo esc_attr( $tags ); ?>" />
				</div>
				<span class="help-block"><?php esc_html_e( 'Separate each tag by comma. (tag1, tag2, tag3)', 'king' ); ?></span>
				<!-- SUBMIT/ DELETE /CANCEL-->
				<button class="king-submit-button"  type="submit" value="save" id="king-submitbutton" name="king-editpost"><?php esc_html_e( 'Update Post', 'king' ); ?></button>
				<!-- If post is draft, publish option -->
				<?php if ( $status !== 'publish' )  : ?>
				<button class="king-submit-button"  type="submit" value="publish" id="king-submitbutton" name="king-editpost"><?php esc_html_e( 'Publish Post', 'king' ); ?></button>
				<?php endif; ?>
				<!-- SUBMIT/ DELETE /CANCEL-->
				<?php if ( current_user_can( 'edit_post', $postid ) && get_field( 'allow_users_to_delete_their_posts', 'option' ) ) : ?>
				<button class="king-submit-button king-delete-post" type="submit" value="delete" id="king-submitbutton" name="king-editpost" onclick="return confirm('Are you sure you want to delete this?')" ><?php esc_html_e( 'Delete Post', 'king' ); ?></button>
				<?php endif; ?>
				<button class="king-submit-button" type="submit" value="cancel" id="submit-loading2" name="king-editpost"><?php esc_html_e( 'Cancel', 'king' ); ?></button>
					
			</div>
			
			<div class="submit-news-right">
				<div class="submit-news-right-fixed">
				<!-- IMAGE -->
				<span class="info-block"><?php esc_html_e( 'Edit the thumbnail image of your post. If the uploaded zip contains a file named thumbnail.jpg, or you are adding a video, you do not need to add an image', 'king' ) ?></span>
				<div class="acf-field acf-field-image acf-field-58f5594a975cb" style="width: 100%; min-height: 210px;" data-name="_thumbnail_id" data-type="image" data-key="field_58f5594a975cb" data-width="50">
					<div class="acf-input">
						<div class="acf-image-uploader acf-cf has-value" data-preview_size="medium" data-library="uploadedTo" data-mime_types="jpg, png, gif, jpeg" data-uploader="wp">
							<input name="acf[field_58f5594a975cb]" value="<?php echo esc_attr( $post_thumb ); ?>" type="hidden">	<div class="view show-if-value acf-soh" style="width: 100%;">
							<img data-name="image" src="<?php echo esc_url( $post_thumb_url ); ?>">
							<ul class="acf-hl acf-soh-target">
								<li><a class="acf-icon -pencil dark" data-name="edit" href="#" title="Edit"></a></li>
								<li><a class="acf-icon -cancel dark" data-name="remove" href="#" title="Remove"></a></li>
							</ul>
						</div>
						<div class="view hide-if-value inputprev-span">
							<a data-name="add" class="acf-button button featured-image-upload" href="#"><?php esc_html_e( 'Add Thumbnail', 'king' ); ?></a>
						</div>
						</div>
					</div>
				</div>
				<!-- VIDEO -->
				<span class="info-block"><?php esc_html_e( 'Optional: Upload or link to a video of your AR model in action', 'king' ); ?></span>
				<div class="inside acf-fields">
					<?php $kinghide = '';
					if ( get_field( 'disable_video_and_mp3_upload', 'options' ) ) {
						$kinghide = ' hide';
					}
					?>
					<div class="inside acf-fields -top">
						<div class="acf-field acf-field-true-false acf-field-58f533f201eee<?php echo esc_attr( $kinghide ); ?>" data-name="video_tab" data-type="true_false" data-key="field_58f533f201eee">	
							<div class="acf-input">
								<div class="acf-true-false">
									<input name="acf[field_58f533f201eee]" value="0" type="hidden">
									<label>
										<input type="checkbox" id="acf-field_58f533f201eee" name="acf[field_58f533f201eee]" value="1" class="acf-switch-input" autocomplete="off">
										<div class="acf-switch"><span class="acf-switch-on" style="min-width: 40px;"><?php esc_html_e( 'UPLOAD', 'king' ); ?></span><span class="acf-switch-off" style="min-width: 40px;"><?php esc_html_e( 'URL', 'king' ); ?></span><div class="acf-switch-slider"></div></div>			</label>
									</div>
								</div>
							</div>
							<div class="acf-field acf-field-oembed acf-field-587be2665e807" data-name="video-url" data-type="oembed" data-key="field_587be2665e807" data-conditions="[[{&quot;field&quot;:&quot;field_58f533f201eee&quot;,&quot;operator&quot;:&quot;!=&quot;,&quot;value&quot;:&quot;1&quot;}]]">
								<div class="acf-input">
									<div class="acf-oembed">
										<input class="input-value" name="video_url" value="<?php echo esc_attr( isset( $_POST['video_url'] ) ? $_POST['video_url'] : '' ); ?>" type="hidden">
										<div class="title">
											<input class="input-search" value="<?php echo esc_attr( isset( $_POST['video_url'] ) ? $_POST['video_url'] : '' ); ?>" placeholder="Enter URL" autocomplete="off" type="text">		
											<div class="acf-actions -hover">
												<a data-name="clear-button" href="#" class="acf-icon -cancel grey"></a>
											</div>
										</div>
										<div class="canvas">
											<div class="canvas-media">
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
						<?php if ( ! get_field( 'disable_video_and_mp3_upload', 'options' ) ) : ?>
							<div class="acf-field acf-field-file acf-field-58f5335001eed -c0 acf-hidden" data-name="video_upload" data-type="file" data-key="field_58f5335001eed" data-conditions="[[{&quot;field&quot;:&quot;field_58f533f201eee&quot;,&quot;operator&quot;:&quot;==&quot;,&quot;value&quot;:&quot;1&quot;}]]" hidden="">
								<div class="acf-input">
									<div class="acf-file-uploader" data-library="uploadedTo" data-mime_types="mp4, flv, mp3" data-uploader="wp">
										<input name="acf[field_58f5335001eed]" value="<?php echo esc_attr( isset( $_POST['acf']['field_58f5335001eed'] ) ? $_POST['acf']['field_58f5335001eed'] : '' ); ?>" data-name="id" type="hidden" disabled="">
										<div class="show-if-value file-wrap">
											<div class="file-icon">
												<img data-name="icon" src="">
											</div>
											<div class="file-info">
												<a data-name="filename" href="" target="_blank"></a>
												<strong><?php esc_html_e( 'size:', 'king' ); ?></strong><span data-name="filesize"></span>
											</div>
											<div class="acf-actions -hover">
												<a class="acf-icon -pencil dark" data-name="edit" href="#" title="<?php echo esc_html_e( 'Edit', 'king' ); ?>"></a>
												<a class="acf-icon -cancel dark" data-name="remove" href="#" title="<?php echo esc_html_e( 'Remove', 'king' ); ?>"></a>
											</div>
										</div>
										<div class="hide-if-value">
											<a data-name="add" class="acf-button button" href="#"><?php esc_html_e( 'Upload Video', 'king' ); ?></a>		
										</div>
									</div>
								</div>
							</div>
						<?php if ( get_field( 'enable_embed_code_adding', 'options' ) ) : ?>
							<div class="acf-field acf-field-textarea acf-field-59c9812458fe6 acf-hidden" data-name="media_embed_code" data-type="textarea" data-key="field_59c9812458fe6" data-conditions="[[{&quot;field&quot;:&quot;field_58f533f201eee&quot;,&quot;operator&quot;:&quot;==&quot;,&quot;value&quot;:&quot;1&quot;}]]" hidden="">
								<label for="acf-field_59c9812458fe6"><?php echo esc_html_e( 'Embed Code', 'king' ); ?></label>
								<div class="acf-input">
									<textarea id="acf-field_59c9812458fe6" name="acf[field_59c9812458fe6]" rows="4" disabled=""></textarea>			</div>
								</div>
							<?php endif; ?>
						<?php endif; ?>
					</div>	
				</div>

				
			</div>	
			</div>
			<?php echo wp_nonce_field( 'king_edit_post_upload_form', 'king_edit_post_upload_form_submitted', true, false ); ?>
		</form>	

	</main><!-- #main -->
</div><!-- #primary -->
<?php wp_enqueue_media(); ?>
<?php endif; ?>
<?php get_footer(); ?>
