<?php
/**
 * Theme options.
 *
 * @package King.
 */

// Prevent direct script access.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
if ( get_field( 'enable_text_translation', 'options' ) ) :
	/**
	 * Translate some texts in theme.
	 *
	 * @param string $translated_text  The translated text.
	 *
	 * @return string ( description_of_the_return_value )
	 */
	function king_change_text( $translated_text ) {
		if ( 'News' === $translated_text && get_field( 'news_text', 'options' ) ) {
			$translated_text = get_field( 'news_text', 'options' );
		}
		if ( 'Submit News' === $translated_text && get_field( 'submit_news_text', 'options' ) ) {
			$translated_text = get_field( 'submit_news_text', 'options' );
		}
		if ( 'Video' === $translated_text && get_field( 'videos_text', 'options' ) ) {
			$translated_text = get_field( 'videos_text', 'options' );
		}
		if ( 'Submit Video' === $translated_text && get_field( 'submit_video_text', 'options' ) ) {
			$translated_text = get_field( 'submit_video_text', 'options' );
		}
		if ( 'Image' === $translated_text && get_field( 'image_text', 'options' ) ) {
			$translated_text = get_field( 'image_text', 'options' );
		}
		if ( 'Submit Image' === $translated_text && get_field( 'submit_image_text', 'options' ) ) {
			$translated_text = get_field( 'submit_image_text', 'options' );
		}
		if ( 'Music' === $translated_text && get_field( 'music_text', 'options' ) ) {
			$translated_text = get_field( 'music_text', 'options' );
		}
		if ( 'Submit Music' === $translated_text && get_field( 'submit_music_text', 'options' ) ) {
			$translated_text = get_field( 'submit_music_text', 'options' );
		}
		if ( 'List' === $translated_text && get_field( 'list_text', 'options' ) ) {
			$translated_text = get_field( 'list_text', 'options' );
		}
		if ( 'Submit List' === $translated_text && get_field( 'submit_list_text', 'options' ) ) {
			$translated_text = get_field( 'submit_list_text', 'options' );
		}
		if ( 'Poll' === $translated_text && get_field( 'poll_text', 'options' ) ) {
			$translated_text = get_field( 'poll_text', 'options' );
		}
		if ( 'Submit Poll' === $translated_text && get_field( 'submit_poll_text', 'options' ) ) {
			$translated_text = get_field( 'submit_poll_text', 'options' );
		}
		if ( 'Trivia Quiz' === $translated_text && get_field( 'trivia_quiz_text', 'options' ) ) {
			$translated_text = get_field( 'trivia_quiz_text', 'options' );
		}
		if ( 'Submit Trivia Quiz' === $translated_text && get_field( 'submit_trivia_quiz_text', 'options' ) ) {
			$translated_text = get_field( 'submit_trivia_quiz_text', 'options' );
		}
		if ( 'featured' === $translated_text && get_field( 'featured_text', 'options' ) ) {
			$translated_text = get_field( 'featured_text', 'options' );
		}
		if ( 'trending' === $translated_text && get_field( 'trending_text', 'options' ) ) {
			$translated_text = get_field( 'trending_text', 'options' );
		}
		if ( 'My Settings' === $translated_text && get_field( 'my_settings_text', 'options' ) ) {
			$translated_text = get_field( 'my_settings_text', 'options' );
		}
		if ( 'Inbox' === $translated_text && get_field( 'inbox_text', 'options' ) ) {
			$translated_text = get_field( 'inbox_text', 'options' );
		}
		if ( 'Private Messages' === $translated_text && get_field( 'private_messages_text', 'options' ) ) {
			$translated_text = get_field( 'private_messages_text', 'options' );
		}
		if ( 'My Dashboard' === $translated_text && get_field( 'my_dashboard_text', 'options' ) ) {
			$translated_text = get_field( 'my_dashboard_text', 'options' );
		}
		if ( 'Submit Post' === $translated_text && get_field( 'submit_post_text', 'options' ) ) {
			$translated_text = get_field( 'submit_post_text', 'options' );
		}
		if ( 'Save' === $translated_text && get_field( 'save_text', 'options' ) ) {
			$translated_text = get_field( 'save_text', 'options' );
		}
		if ( 'Add New' === $translated_text && get_field( 'add_new_text', 'options' ) ) {
			$translated_text = get_field( 'add_new_text', 'options' );
		}
		if ( 'Select Image' === $translated_text && get_field( 'select_image_text', 'options' ) ) {
			$translated_text = get_field( 'select_image_text', 'options' );
		}
		if ( 'Bookmark' === $translated_text && get_field( 'bookmark_text', 'options' ) ) {
			$translated_text = get_field( 'bookmark_text', 'options' );
		}
		if ( 'My Bookmarks' === $translated_text && get_field( 'my_bookmarks_text', 'options' ) ) {
			$translated_text = get_field( 'my_bookmarks_text', 'options' );
		}
		if ( 'Stories' === $translated_text && get_field( 'stories_text', 'options' ) ) {
			$translated_text = get_field( 'stories_text', 'options' );
		}
		if ( 'Create Story' === $translated_text && get_field( 'create_story_text', 'options' ) ) {
			$translated_text = get_field( 'create_story_text', 'options' );
		}
		if ( 'Story' === $translated_text && get_field( 'story_text', 'options' ) ) {
			$translated_text = get_field( 'story_text', 'options' );
		}
		return $translated_text;
	}
	add_filter( 'gettext', 'king_change_text', 20 );
endif;
if ( 'king-grid-10' === get_field( 'select_default_display_option', 'options' ) ) :
	if ( function_exists( 'acf_add_local_field_group' ) ) :
		acf_add_local_field_group(
			array(
				'key'                   => 'group_5ea30e5d50d86',
				'title'                 => 'Post Size',
				'fields'                => array(
					array(
						'key'               => 'field_5ea30e84c5c54',
						'label'             => 'Post Size',
						'name'              => 'post_size',
						'type'              => 'radio',
						'instructions'      => '',
						'required'          => 0,
						'conditional_logic' => 0,
						'wrapper'           => array(
							'width' => '',
							'class' => '',
							'id'    => '',
						),
						'choices'           => array(
							'king-size-1x' => '<img src="../wp-content/themes/king/layouts/imgs/templates/post-size/size-1x.svg" height="150" width="150" />',
							'king-size-2x' => '<img src="../wp-content/themes/king/layouts/imgs/templates/post-size/size-2x.svg" height="150" width="150" />',
							'king-size-2y' => '<img src="../wp-content/themes/king/layouts/imgs/templates/post-size/size-2y.svg" height="150" width="150" />',
							'king-size-4x' => '<img src="../wp-content/themes/king/layouts/imgs/templates/post-size/size-4x.svg" height="150" width="150" />',
							'king-size-6x' => '<img src="../wp-content/themes/king/layouts/imgs/templates/post-size/size-6x.svg" height="150" width="150" />',
						),
						'allow_null'        => 0,
						'other_choice'      => 0,
						'default_value'     => '',
						'layout'            => 'horizontal',
						'return_format'     => 'value',
						'save_other_choice' => 0,
					),
				),
				'location'              => array(
					array(
						array(
							'param'    => 'post_type',
							'operator' => '==',
							'value'    => 'post',
						),
					),
				),
				'menu_order'            => 3,
				'position'              => 'normal',
				'style'                 => 'default',
				'label_placement'       => 'top',
				'instruction_placement' => 'label',
				'hide_on_screen'        => '',
				'active'                => true,
				'description'           => '',
			)
		);
	endif;
endif;
if ( ! king_theme_register() || ! king_plugin_active( 'envato_market' ) ) :
	if ( function_exists( 'acf_add_local_field_group' ) ) :
		acf_add_local_field_group(
			array(
				'key'    => 'group_5aaacfbca320f',
				'title'  => 'Register Theme',
				'fields' => array(
					array(
						'key' => 'field_5aaad00b6d5ec',
						'label' => 'Register King Theme',
						'name' => '',
						'type' => 'message',
						'instructions' => '',
						'required' => 0,
						'conditional_logic' => 0,
						'wrapper' => array(
							'width' => '',
							'class' => '',
							'id' => '',
						),
						'message' => 'You have to register your King Theme to see theme options ! Go to Envato Market plugin and insert Token !',
						'new_lines' => 'wpautop',
						'esc_html' => 0,
					),
				),
				'location' => array(
					array(
						array(
							'param' => 'options_page',
							'operator' => '==',
							'value' => 'acf-options-settings',
						),
					),
					array(
						array(
							'param' => 'options_page',
							'operator' => '==',
							'value' => 'acf-options-layout',
						),
					),
					array(
						array(
							'param' => 'options_page',
							'operator' => '==',
							'value' => 'acf-options-lists',
						),
					),
					array(
						array(
							'param' => 'options_page',
							'operator' => '==',
							'value' => 'acf-options-customize',
						),
					),
				),
				'menu_order' => 0,
				'position' => 'normal',
				'style' => 'default',
				'label_placement' => 'top',
				'instruction_placement' => 'label',
				'hide_on_screen' => '',
				'active' => 1,
				'description' => '',
			)
		);
	endif;
else :
	/**
	 * Acf options.
	 */
	require KING_INCLUDES_PATH . 'acf-options.php';

endif;
/**
 * Register Theme.
 *
 * @return     boolean  ( description_of_the_return_value )
 */
function king_theme_register() {
	$king_register = get_transient( 'king_theme_registered' );

	if ( $king_register ) {
		return true;
	}
	if ( ! king_plugin_active( 'envato_market' ) ) {
		return true;
	}
	$purchased_themes = envato_market()->api()->themes();
	$my_theme         = wp_get_theme();
	foreach ( $purchased_themes as $purchased_theme ) {
		if ( $my_theme->get( 'TextDomain' ) === strtolower( $purchased_theme['name'] ) ) {
			$king_register = true;
		}
	}

	if ( $king_register ) {
		$expired = 60 * 60 * 24 * 100000000;
		set_transient( 'king_theme_registered', true, $expired );
	}

	return $king_register;
}
if ( ! king_theme_register() || ! king_plugin_active( 'envato_market' ) ) :
	/**
	 * King Admin Notices.
	 */
	function king_admin_notifications2() {
		$class   = 'notice notice-info is-dismissible theme-option-property-search-page-notification';
		$message = esc_html__( 'Required: You have to register King Theme !".', 'king' );
		printf( '<div class="%1$s"><p>%2$s</p></div>', $class, $message );
	}
	add_action( 'admin_notices', 'king_admin_notifications2' );
endif;
if( function_exists('acf_add_local_field_group') ) :
acf_add_local_field_group(array(
    'key' => 'group_58bf2f49e4513',
    'title' => 'Images',
    'fields' => array(
        array(
            'key' => 'field_58bf2f79ed6d3',
            'label' => 'Images Lists',
            'name' => 'images_lists',
            'type' => 'repeater',
            'instructions' => '',
            'required' => 0,
            'conditional_logic' => 0,
            'wrapper' => array(
                'width' => '',
                'class' => 'king-repeater',
                'id' => '',
            ),
            'collapsed' => '',
            'min' => 0,
            'max' => 0,
            'layout' => 'block',
            'button_label' => '',
            'sub_fields' => array(
                array(
                    'key' => 'field_58bf2f96ed6d4',
                    'label' => 'Images list',
                    'name' => 'images_list',
                    'type' => 'image',
                    'instructions' => '',
                    'required' => 0,
                    'conditional_logic' => 0,
                    'wrapper' => array(
                        'width' => '',
                        'class' => '',
                        'id' => '',
                    ),
                    'return_format' => 'array',
                    'preview_size' => 'large',
                    'library' => 'uploadedTo',
                    'min_width' => '',
                    'min_height' => '',
                    'min_size' => '',
                    'max_width' => '',
                    'max_height' => '',
                    'max_size' => 5,
                    'mime_types' => 'jpg, jpeg, png, gif,',
                ),
            ),
        ),
    ),
    'location' => array(
        array(
            array(
                'param' => 'post_format',
                'operator' => '==',
                'value' => 'image',
            ),
        ),
    ),
    'menu_order' => 0,
    'position' => 'normal',
    'style' => 'default',
    'label_placement' => 'top',
    'instruction_placement' => 'label',
    'hide_on_screen' => '',
    'active' => false,
    'description' => '',
));
endif;