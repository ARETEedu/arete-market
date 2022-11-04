<?php
/**
 * Submit ARLEM Page.
 * KB 
 * @package King
 * 
 * SNAGS: arlem folder, category & thumbnail deselect on save/ submit when have error
 * 
 */

// Prevent direct script access.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
$GLOBALS['hide'] = 'hide';
global $king_submit_errors;

//The verification for submitting a post
if ( isset( $_POST['king_post_upload_form_submitted'] ) && wp_verify_nonce( $_POST['king_post_upload_form_submitted'], 'king_post_upload_form' ) ) {

	//Video uploads
	$video_url    = '';
	$video_upload = '';
	$video_embed  = '';
	//ARLEM upload
	$arlem_upload = '';

	//Get the title, tags, content and thumbnail from the post
	$title    = sanitize_text_field( $_POST['king_post_title'] );
	$tags     = sanitize_text_field( $_POST['king_post_tags'] );
	$content  = sanitize_text_field( $_POST['king_post_content'] );
	$thumb    = sanitize_text_field( $_POST['acf']['field_58f5594a975cb'] );
	//Get the category and licence
	$category = isset( $_POST['king_post_category'] ) ? $_POST['king_post_category'] : '';
	$licence = isset( $_POST['king_post_licence'] ) ? $_POST['king_post_licence'] : '';
	
	$pluginlog = plugin_dir_path(__FILE__).'debug.log';
	//Set licence (is a repeater field, needs values from all)
	$licence_name = $licence[0];
	
	//If the user has added a video via URL, get it 
	if ( isset( $_POST['video_url'] ) ) {
		$video_url = wp_unslash( $_POST['video_url'] ); 
	}
	//If the user has uploaded a video, get it 
	if ( isset( $_POST['acf']['field_58f5335001eed'] ) ) {
		$video_upload = esc_url( wp_unslash( $_POST['acf']['field_58f5335001eed'] ) ); // Input var okey.
	}
	//If the user has embedded a video, get it 
	if ( isset( $_POST['acf']['field_59c9812458fe6'] ) ) {
		$video_embed = wp_unslash( $_POST['acf']['field_59c9812458fe6'] ); // Input var okey.
	}
	//Get the ARLEM upload
	if ( isset( $_POST['acf']['field_99f5335001eed'] ) ) {
		$arlem_upload = wp_unslash( $_POST['acf']['field_99f5335001eed'] ); 
	}

	/**Validation**/
	//Keep track of any errors
	$king_submit_errors = array();
	$thumbnail_in_arlem = false;

	//There must be arlem files
	if ( trim( $arlem_upload ) === '') {
		$king_submit_errors['arlem_empty'] = esc_html__( 'There is no ARLEM folder.', 'king' );
	} 
	else  {
		//Extract the thumbnail
		$thumbnail_in_arlem = apply_filters( 'check_arlem_thumbnail', $arlem_upload );
		//Verify the upload
		$retval = apply_filters( 'verify_arlem_file', $arlem_upload );
		if (trim( $retval ) !== '') {
			$king_submit_errors['arlem_unverified'] = esc_html__( 'The ARLEM folder contains '.$retval, 'king' );	
		}
	}
	
	//Title must not be too long
	if ( get_field( 'maximum_title_length', 'option' ) ) {
		$title_length = get_field( 'maximum_title_length', 'option' );
	} else {
		$title_length = '140';
	}
	//Title must be set
	if ( trim( $title ) === '' ) {
		$king_submit_errors['title_empty'] = esc_html__( 'Title is required.', 'king' );
	} elseif ( strlen( $title ) > $title_length ) {
		$king_submit_errors['title_empty'] = esc_html__( 'Title is too long.', 'king' );
	}
	//Content must not be too long
	if ( get_field( 'maximum_content_length', 'option' ) ) {
		$content_length = get_field( 'maximum_content_length', 'option' );
	} else {
		$content_length = '2000';
	}
	//Content must be set
	if ( trim( $content ) === '' ) {
		$king_submit_errors['content_empty'] = esc_html__( 'Content is required.', 'king' );
	} elseif ( strlen( $content ) > $content_length ) {
		$king_submit_errors['content_empty'] = esc_html__( 'Content is too long.', 'king' );
	}
	$no_video =  (trim( $video_url ) === '') && (trim( $video_upload ) === '') && (trim( $video_embed ) === '' );
	$no_thumbnail = trim( $thumb ) === '' && !$thumbnail_in_arlem;
	//There must be a thumbnail image OR a video
	if ($no_thumbnail && $no_video) {
		$king_submit_errors['image_empty'] = esc_html__( 'Either a thumbnail or video is required.', 'king' );
	}		
	
	//Licence must be selected
	if ( trim( $licence ) === '' ) {
		$king_submit_errors['licence_empty'] = esc_html__( 'You must select a licence.', 'king' );
	}
	if ( ! isset( $_POST['king-consent-t-and-cs'] ) ) {
		$king_submit_errors['consent_empty'] = esc_html__( 'You must consent to T&Cs.', 'king' );
	}
	if ( ! isset( $_POST['king-consent-gdpr'] ) ) {
		$king_submit_errors['consent_empty'] = esc_html__( 'You must consent to GDPR.', 'king' );
	}

	//If there are no errors, set the post status
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
	
		$posttype = 'arlem';
		//Insert the post
		$post_id = wp_insert_post(
			array(
				'post_title'    => wp_strip_all_tags( $title ),
				'post_content'  => $content,
				'tags_input'    => $tags,
				'post_category' => $category,
				'post_status'   => $poststatus,
				'post_type'     => $posttype,
			)
		);

		if (!$post_id) {
			error_log("No post id ".$post_id);
		}

		//Set it as type arlem
		set_post_format( $post_id, 'arlem' );

		//Update the ARLEM field
		update_field( 'arlem_upload', $arlem_upload, $post_id );
		update_post_meta( $post_id, '_arlem_upload', 'field_99f5335001eed' );

		//Update the licence field
		update_field( 'licence_name', $licence_name, $post_id );
		update_post_meta( $post_id, '_licence_name', 'field_5aaalicencenn' );

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
		
		do_action( 'acf/save_post', $post_id );

		//For some reason, have to set the thumbnail post save when it's from an arlem upload,
		// or it wipes the _thumbnail_id field
		// Turns out acf/save_post can undo some custom fields
		// See https://support.advancedcustomfields.com/forums/topic/update_post_meta-not-working-with-acf/
		if ($thumbnail_in_arlem) {
			$thumb = apply_filters( 'set_arlem_thumbnail', $arlem_upload, $post_id );
			update_post_meta( $post_id, '_thumbnail_id', 'field_58f5594a975cb' );
			set_post_thumbnail( $post_id, $thumb );
		} else {
			set_post_thumbnail( $post_id, $thumb );
		}

		//and redirect to the published post
		if ( $post_id ) {
			$permalink = get_permalink( $post_id );
			wp_safe_redirect( $permalink );
			exit;
		}
	}
}

?>
<!-- page-header -->
<?php acf_form_head(); get_header(); ?>
<?php $GLOBALS['hide'] = 'hide'; ?>
<header class="page-top-header">
	<h1 class="page-title"><?php echo esc_html_e( 'Submit AR Learning Experience Model', 'king' ); ?></h1>
</header><!-- .page-header -->

<?php get_template_part( 'template-parts/king-header-nav' ); ?>

<!-- Initial checks -->
<!-- Initial check: is the user logged in -->
<?php if ( ! is_user_logged_in() ) : ?>
	<div class="king-alert"><i class="fa fa-bell fa-lg" aria-hidden="true"></i><?php esc_html_e( 'Please log in or register to upload content', 'king' ); ?>
		<a href="<?php echo esc_url( site_url() . '/' . $GLOBALS['king_login'] ); ?>" class="king-alert-button"><?php esc_html_e( 'Log in ', 'king' ); ?></a>
		<a href="<?php echo esc_url( site_url() . '/' . $GLOBALS['king_register'] ); ?>"><?php esc_html_e( 'Register', 'king' ); ?></a>
	</div>
<!-- Initial check: has an admin disabled adding ARLEM posts -->
<?php elseif ( get_field( 'disable_arlem', 'options' ) !== false || get_field( 'disable_users_submit', 'options' ) !== false ) : ?>
	<div class="king-alert"><i class="fa fa-bell fa-lg" aria-hidden="true"></i>
		<?php esc_html_e( 'You do not have permission to view this page!', 'king' ); ?></div>
<!-- Initial check: IF an admin has turned on verified accounts are turned on, is the user verified -->
<?php elseif ( get_field( 'only_verified', 'options' ) === true && ! get_field( 'verified_account', 'user_' . get_current_user_id() ) && ! is_super_admin() ) : ?>  
		<div class="king-alert"><i class="fa fa-bell fa-lg" aria-hidden="true"></i><?php esc_html_e( 'You must be a verified user to create an ARLEM: complete your profile to apply', 'king' ); ?></div>
<!-- Initial check: Does the user have the right permissions (i.e. are they an "author") -->
<?php elseif ( get_field( 'enable_user_groups', 'options' ) && ! king_groups_permissions( 'groups_create_posts' ) && ! is_super_admin() ) : ?>
	<div class="king-alert"><i class="fa fa-bell fa-lg" aria-hidden="true"></i><?php esc_html_e( 'You do not have permission to view this page!', 'king' ); ?></div>
<!-- Checks met, good to go -->
<?php else : ?>

	<!-- #primary BEGIN -->
	<div id="primary" class="page-content-area">
		<main id="main" class="page-news-main king-submit-arlem">
			<?php if ( get_field( 'custom_message_arlem', 'options' ) ) : ?>
				<div class="king-custom-message">
					<?php the_field( 'custom_message_arlem', 'options' ); ?>
				</div>
			<?php endif; ?>
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
				<!-- Check there is an ARLEM upload -->
				<?php if ( isset( $king_submit_errors['arlem_empty'] )  ) : ?>
					<div class="king-error"><?php echo esc_attr( $king_submit_errors['arlem_empty'] ); ?></div>
				<?php endif; ?>
				<?php if ( isset( $king_submit_errors['arlem_unverified'] )  ) : ?>
					<div class="king-error"><?php echo esc_attr( $king_submit_errors['arlem_unverified'] ); ?></div>
				<?php endif; ?>
				<!-- Check there is an image -->
				<?php if ( isset( $king_submit_errors['image_empty'] ) ) : ?>
					<div class="king-error"><?php echo esc_attr( $king_submit_errors['image_empty'] ); ?></div>
				<?php endif; ?>	
				<!-- Check there is a description (content) -->
				<?php if ( isset( $king_submit_errors['content_empty'] ) ) : ?>
					<div class="king-error"><?php echo esc_attr( $king_submit_errors['content_empty'] ); ?></div>
				<?php endif; ?>
				<!-- Check for T&Cs and consent -->
				<?php if ( isset( $king_submit_errors['consent_empty'] ) ) : ?>
					<div class="king-error"><?php echo esc_attr( $king_submit_errors['consent_empty'] ); ?></div>
				<?php endif; ?>

				<!-- TITLE -->
				<div class="king-form-group">
					<label for="king_post_title"><?php esc_html_e( 'Title', 'king' ); ?></label>
					<input class="form-control bpinput" name="king_post_title" id="king_post_title" type="text" value="<?php echo esc_attr( isset( $_POST['king_post_title'] ) ? $_POST['king_post_title'] : '' ); ?>" maxlength="<?php the_field( 'maximum_title_length', 'option' ); ?>" required />
				</div>
				
				<!-- CATEGORIES -->
				<span class="info-block"><?php esc_html_e( 'Please select one or more categories', 'king' ) ?></span>
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
					<span class="form-label"><?php esc_html_e( 'Select Categories', 'king' ); ?></span>
					<ul>
						<?php
						$preset_categories = isset( $_POST['king_post_category'] ) ? $_POST['king_post_category'] : '';
						foreach ( $categories as $cat ) {
							if ( $cat->parent == 0 ) {
								$catsfor = get_field( 'category_for', $cat );
								if ( $catsfor && in_array( 'for_arlem', $catsfor, true ) || ! $catsfor ) :
									$checked = '';
									if ( in_array(strval($cat->term_id), $preset_categories, true) ) {
										$checked = 'checked';
									}
									echo '<li class="form-categories-item"><input type="checkbox" id="king_post_cat-' . esc_attr( $cat->term_id ) . '" name="king_post_category[]" value="' . esc_attr( $cat->term_id ) . '" '. esc_attr( $checked ) .'/><label for="king_post_cat-' . esc_attr( $cat->term_id ) . '">' . esc_attr( $cat->name ) . '</label></li>';
							endif;
							foreach ( $categories as $subcategory ) {
								if ( $subcategory->parent == $cat->term_id ) {
										$scatsfor = get_field( 'category_for', $subcategory );
										if ( $scatsfor && in_array( 'for_arlem', $scatsfor, true ) || ! $scatsfor ) :
											$checked = '';
											if ( in_array(strval($cat->term_id), $preset_categories, true) ) {
												$checked = 'checked';
											}
											echo '<li class="form-categories-item"><input type="checkbox" id="king_post_cat-' . esc_attr( $subcategory->term_id ) . '" name="king_post_category[]" value="' . esc_attr( $subcategory->term_id ) . '" '. esc_attr( $checked ) .'/><label class="king-post-subcat" for="king_post_cat-' . esc_attr( $subcategory->term_id ) . '">' . esc_attr( $subcategory->name ) . '</label></li>';
								endif;
									}
								}
							}
						}
						?>
					</ul>
				</div>
				<!-- LICENCES --> 
				<span class="info-block"><?php esc_html_e( 'Please select a licence', 'king' ) ?></span>
				<?php if( have_rows('licences', 'option') ): ?>
				<div class="king-form-group form-licences" >
					<span class="form-label"><?php esc_html_e( 'Select Licence', 'king' ); ?></span>
					<ul>
					<?php 
						$licence = isset( $_POST['king_post_licence'] ) ? $_POST['king_post_licence'] : '';
						//Get licence name out of string
						$licence_name =  $licence[0];
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
				<!-- Upload AR Files -->
				<span class="info-block"><?php esc_html_e( 'Add your zipped ARLEM folder', 'king' ) ?></span>
				<div class="acf-field acf-field-file acf-field-5ee7d4327603e" data-name="arlem_upload" data-type="file" data-key="field_99f5335001eed" data-conditions="[[{&quot;field&quot;:&quot;field_5ee7d3c77603d&quot;,&quot;operator&quot;:&quot;==&quot;,&quot;value&quot;:&quot;1&quot;}]]">
					<div class="acf-input">
						<div class="acf-file-uploader" data-library="uploadedTo" data-mime_types="zip" data-uploader="wp">
						<input type="hidden" name="acf[field_99f5335001eed]" value="<?php echo esc_attr( isset( $_POST['acf']['field_99f5335001eed'] ) ? $_POST['acf']['field_99f5335001eed'] : '' ); ?>" data-name="id" disabled="">	<div class="show-if-value file-wrap">
								<div class="file-icon">
									<img data-name="icon" src="" alt="">
								</div>
								<div class="file-info">
									<p>
										<strong data-name="title"></strong>
									</p>
									<p>
										<strong><?php esc_html_e( 'File name:', 'king' ); ?></strong>
										<a data-name="filename" href="" target="_blank"></a>
									</p>
									<p>
										<strong><?php esc_html_e( 'File size:', 'king' ); ?></strong>
										<span data-name="filesize"></span>
									</p>
								</div>
								<div class="acf-actions -hover">
									<a class="acf-icon -pencil dark" data-name="edit" href="#" title="<?php esc_html_e( 'Edit', 'king' ); ?>"></a>
									<a class="acf-icon -cancel dark" data-name="remove" href="#" title="<?php esc_html_e( 'Remove', 'king' ); ?>"></a>
								</div>
							</div>
							<div class="hide-if-value">
								<p><a data-name="add" class="acf-button button" href="#"><?php esc_html_e( 'Add ARLEM File', 'king' ); ?></a></p>
							</div>
						</div>
					</div>
				</div>	
			
				<!-- CONTENT -->	
				<span class="info-block"><?php esc_html_e( 'Describe your ARLEM content', 'king' ) ?></span>
				<?php $content = isset($_POST['king_post_content']) ? $_POST['king_post_content'] : ''; ?>
				<div class="king-form-group">
					<label for="king_post_content"><?php esc_html_e( 'Content', 'king' ); ?></label>
					<div class="tinymce" id="king_post_content"><?php echo( wp_kses_post( html_entity_decode( $content ) ) ); ?></div>
				</div>
				<span class="help-block"><?php esc_html_e( 'Max length is 2000 characters', 'king' ) ?></span>
				
				<!-- TAGS -->
				<div class="king-form-group">
					<label for="king_post_tags"><?php esc_html_e( 'Tags', 'king' ); ?></label>
					<input class="form-control bpinput" name="king_post_tags" id="king_post_tags" type="text" value="<?php echo esc_attr( isset( $_POST['king_post_tags'] ) ? $_POST['king_post_tags'] : '' ); ?>" />
				</div>
				<span class="help-block"><?php esc_html_e( 'Separate each tag by comma. (tag1, tag2, tag3)', 'king' ) ?></span>
				
				<!-- T&CS -->
				<span class="info-block"><?php esc_html_e( 'You must agree to the Terms & Conditions and certify that your content abides by GDPR legislation', 'king' ) ?></span>
				<div class="king-consent">
					<input id="king-consent-t-and-cs" type="checkbox" name="king-consent-t-and-cs" value="0">
					<label for="king-consent-t-and-cs">I agree to Terms & Conditions</label>
					<a href="https://arete.market/terms-and-conditions/">(Terms & Conditions)</a>
				</div>
				<br>	
				<!-- GDPR -->
				<div class="king-consent">
					<input id="king-consent-gdpr" type="checkbox" name="king-consent-gdpr" value="0">
					<label for="king-consent-gdpr">I certify that this content is GDPR compliant</label>
					<a href="https://arete.market/gdpr/">(GDPR Details)</a>
				</div>

				<!-- SUBMIT OR SAVE -->
				<button class="king-submit-button" data-loading-text="<?php esc_html_e( 'Loading...', 'king' ) ?>" type="submit" value="send" name="submit_type" id="submit-loading"><?php esc_html_e( 'Submit Post', 'king' ); ?></button>
				<?php if ( get_field( 'enable_save_posts', 'options' ) ) : ?>
					<button class="king-submit-button" data-loading-text="<?php esc_html_e( 'Loading...', 'king' ) ?>" name="submit_type" type="submit" id="submit-loading2" value="save"><?php esc_html_e( 'Save', 'king' ); ?></button>
				<?php endif; ?>							
				<?php echo wp_nonce_field( 'king_post_upload_form', 'king_post_upload_form_submitted', true, false ); ?>

			<?php endif; ?>
			</div>
			<div class="submit-news-right">
			<div class="submit-news-right-fixed">
				<div class="king-form-group">
				<!-- Upload Image (optional) -->
				<label for="king_post_content"><?php esc_html_e( 'Thumbnail', 'king' ); ?></label>
				<span class="info-block"><?php esc_html_e( 'Add a thumbnail image to your post. If the uploaded zip contains a file named thumbnail.jpg, or you are adding a video, you do not need to add an image', 'king' ) ?></span>
				<?php
				$post_thumb = '';
				$post_thumb_url = '';
				if ( isset( $_POST['acf']['field_58f5594a975cb'] )) {
					$post_thumb = $_POST['acf']['field_58f5594a975cb'];
					$post_thumb_url = wp_get_attachment_url( $_POST['acf']['field_58f5594a975cb'] );
					?>
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
				<?php
				} else {
					?>
					<div class="acf-field acf-field-image acf-field-58f5594a975cb" data-name="_thumbnail_id" data-type="image" data-key="field_58f5594a975cb">
					<div class="acf-input">
						<div class="acf-image-uploader" data-preview_size="medium" data-library="uploadedTo" data-mime_types="jpg, png, gif, jpeg, webp" data-uploader="wp">
							<input type="hidden" name="acf[field_58f5594a975cb]" value="" required="required">
							<div class="show-if-value image-wrap" style="width: 100%;">
								<img src="" alt="" data-name="image" style="width: 100%;border-radius: 10px;">
									<div class="acf-actions -hover">
										<a class="acf-icon -pencil dark" data-name="edit" href="#" title="Edit"></a>
										<a class="acf-icon -cancel dark" data-name="remove" href="#" title="Remove"></a>
									</div>
							</div>
						<div class="hide-if-value inputprev-span">
							<a data-name="add" class="acf-button button featured-image-upload" href="#"><?php esc_html_e( 'Select thumbnail', 'king' ); ?></a>
						</div>
						</div>
					</div>
				</div>
					<?php
				}
				?>
				
				<!-- Upload Video (optional, also can be disabled) -->
				<label for="king_post_content"><?php esc_html_e( 'Video', 'king' ); ?></label>
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
		</form>
	</main><!-- #main -->
</div><!-- .main-column -->

<?php endif; ?>
<?php wp_enqueue_media(); ?>
<?php get_footer(); ?>
