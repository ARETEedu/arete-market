<?php
/**
 * King functions and definitions.
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package king
 */

// Prevent direct script access.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * King Paths.
 */
define( 'KING_THEME_DIR', get_template_directory() );
define( 'KING_INCLUDES_PATH', get_template_directory() . '/includes/' );
define( 'KING_THEME_URI', get_template_directory_uri() );
define( 'THEME_VERSION', wp_get_theme()->Version );

/**
 * Register ACF
 */
if ( class_exists( 'Acf' ) ) {
	define( 'ACF_LITE', true );
}

/**
 * Acf options page settings.
 */
if ( function_exists( 'acf_add_options_page' ) ) {

	// King.
	$parent = acf_add_options_page(
		array(
			'page_title' => esc_html__( 'Theme General Settings', 'king' ),
			'menu_title' => 'King',
			'capability' => 'manage_options',
			'icon_url'   => KING_THEME_URI . '/layouts/imgs/kinglogo.svg',
			'redirect'   => true,
			'position'   => 59.3,
		)
	);

	// Settings.
	acf_add_options_sub_page(
		array(
			'page_title'  => esc_html__( 'King Settings', 'king' ),
			'menu_title'  => 'Settings',
			'parent_slug' => $parent['menu_slug'],
			'capability'  => 'manage_options',
		)
	);
	// Layout.
	acf_add_options_sub_page(
		array(
			'page_title'  => esc_html__( 'King Layout', 'king' ),
			'menu_title'  => 'Layout',
			'parent_slug' => $parent['menu_slug'],
			'capability'  => 'manage_options',
		)
	);
	// Templates.
	acf_add_options_sub_page(
		array(
			'page_title'  => esc_html__( 'King Templates', 'king' ),
			'menu_title'  => 'Templates',
			'parent_slug' => $parent['menu_slug'],
			'capability'  => 'manage_options',
		)
	);
	// Lists.
	acf_add_options_sub_page(
		array(
			'page_title'  => esc_html__( 'King Lists', 'king' ),
			'menu_title'  => 'Lists',
			'parent_slug' => $parent['menu_slug'],
			'capability'  => 'manage_options',
		)
	);
	// Customize.
	acf_add_options_sub_page(
		array(
			'page_title'  => esc_html__( 'King Customize', 'king' ),
			'menu_title'  => 'Customize',
			'parent_slug' => $parent['menu_slug'],
			'capability'  => 'manage_options',
		)
	);
	// KB: Licences.
	acf_add_options_sub_page(
		array(
			'page_title'  => esc_html__( 'King Licences', 'king' ),
			'menu_title'  => 'Licences',
			'parent_slug' => $parent['menu_slug'],
			'capability'  => 'manage_options',
		)
	);

}

/**
 * TGM Plugin.
 */
require_once KING_INCLUDES_PATH . 'plugins/class-tgm-plugin-activation.php';

/**
 * TGM options.
 */
function king_register_required_plugins() {
	/*
	 * Array of plugin arrays. Required keys are name and slug.
	 * If the source is NOT from the .org repo, then source is also required.
	 */
	$plugins = array(
		// This is an example of how to include a plugin bundled with a theme.
		array(
			'name'               => 'ACF Pro Plugin', // The plugin name.
			'slug'               => 'advanced-custom-fields-pro', // The plugin slug (typically the folder name).
			'source'             => KING_INCLUDES_PATH . 'plugins/zip/advanced-custom-fields-pro.zip', // The plugin source.
			'required'           => true, // If false, the plugin is only 'recommended' instead of required.
			'version'            => '5.11.4', // E.g. 1.0.0. If set, the active plugin must be this version or higher. If the plugin version is higher than the plugin version installed, the user will be notified to update the plugin.
			'force_activation'   => false, // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch.
			'force_deactivation' => false, // If true, plugin is deactivated upon theme switch, useful for theme-specific plugins.
		),
		array(
			'name'               => 'Envato Market', // The plugin name.
			'slug'               => 'envato-market', // The plugin slug (typically the folder name).
			'source'             => KING_INCLUDES_PATH . 'plugins/zip/envato-market.zip', // The plugin source.
			'required'           => true, // If false, the plugin is only 'recommended' instead of required.
			'version'            => '2.0.6', // E.g. 1.0.0. If set, the active plugin must be this version or higher. If the plugin version is higher than the plugin version installed, the user will be notified to update the plugin.
			'force_activation'   => false, // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch.
			'force_deactivation' => false, // If true, plugin is deactivated upon theme switch, useful for theme-specific plugins.
		),
		array(
			'name'               => 'King Demo Import', // The plugin name.
			'slug'               => 'one-click-demo-import', // The plugin slug (typically the folder name).
			'required'           => false, // If false, the plugin is only 'recommended' instead of required.
			'version'            => '3.0.2', // E.g. 1.0.0. If set, the active plugin must be this version or higher. If the plugin version is higher than the plugin version installed, the user will be notified to update the plugin.
			'force_activation'   => false, // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch.
			'force_deactivation' => false, // If true, plugin is deactivated upon theme switch, useful for theme-specific plugins.
		),
	);
	$config  = array(
		'id'           => 'king',                 // Unique ID for hashing notices for multiple instances of TGMPA.
		'default_path' => '',                      // Default absolute path to bundled plugins.
		'menu'         => 'install-plugins', // Menu slug.
		'has_notices'  => true,                    // Show admin notices or not.
		'dismissable'  => false,                    // If false, a user cannot dismiss the nag message.
		'dismiss_msg'  => '',                      // If 'dismissable' is false, this message will be output at top of nag.
		'is_automatic' => false,                   // Automatically activate plugins after installation or not.
		'message'      => '',                      // Message to output right before the plugins table.
	);

	tgmpa( $plugins, $config );
}
add_action( 'tgmpa_register', 'king_register_required_plugins' );


if ( ! is_admin() && ! function_exists( 'get_field' ) ) {
	function get_field( $key ) {
		return get_post_meta( get_the_ID(), $key, true );
	}
	function the_field( $key ) {
		return get_post_meta( get_the_ID(), $key, true );
	}
	function acf_form_head() {
		return false;
	}
	function have_rows() {
		return false;
	}
	function get_field_object() {
		return false;
	}
}

if ( ! function_exists( 'king_setup' ) ) :
	/**
	 * Sets up theme defaults and registers support for various WordPress features.
	 *
	 * Note that this function is hooked into the after_setup_theme hook, which
	 * runs before the init hook. The init hook is too late for some features, such
	 * as indicating support for post thumbnails.
	 */
	function king_setup() {
		/*
		 * Make theme available for translation.
		 * Translations can be filed in the /languages/ directory.
		 * If you're building a theme based on king, use a find and replace
		 * to change 'king' to the name of your theme in all the template files.
		 */
		load_theme_textdomain( 'king', get_template_directory() . '/languages' );

		// Add default posts and comments RSS feed links to head.
		add_theme_support( 'automatic-feed-links' );

		/*
		 * Let WordPress manage the document title.
		 * By adding theme support, we declare that this theme does not use a
		 * hard-coded <title> tag in the document head, and expect WordPress to
		 * provide it for us.
		 */
		add_theme_support( 'title-tag' );

		/*
		 * Enable support for Post Thumbnails on posts and pages.
		 *
		 * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
		 */
		add_theme_support( 'post-thumbnails' );

		// This theme uses wp_nav_menu() in one location.
		register_nav_menus(
			array(
				'primary'     => esc_html__( 'Navigation', 'king' ),
				'header-menu' => esc_html__( 'Header Menu', 'king' ),
				'header-nav' => esc_html__( 'Header Nav', 'king' ),
			)
		);
		if ( king_plugin_active( 'ACF' ) ) :
			if ( get_field( 'header_templates', 'options' ) === 'header-template-03' ) {
				register_nav_menus(
					array(
						'top-header-menu' => esc_html__( 'Header Top Menu', 'king' ),
					)
				);
			}
		endif;

		/*
		 * Switch default core markup for search form, comment form, and comments
		 * to output valid HTML5.
		 */
		add_theme_support(
			'html5',
			array(
				'search-form',
				'comment-form',
				'comment-list',
				'gallery',
				'caption',
			)
		);

		/*
		 * Enable support for Post Formats.
		 * See https://developer.wordpress.org/themes/functionality/post-formats/
		 */
		add_theme_support(
			'post-formats',
			array(
				'quote',
				'image',
				'video',
				'link',
				'audio',
				'arlem',
			)
		);

		// Set up the WordPress core custom background feature.
		add_theme_support(
			'custom-background',
			apply_filters(
				'king_custom_background_args',
				array(
					'default-color' => 'ffffff',
					'default-image' => '',
				)
			)
		);
	}
endif;
add_action( 'after_setup_theme', 'king_setup' );

/**
 * Social Login Files.
 */
require_once KING_INCLUDES_PATH . 'social/facebookoauth.php';
require_once KING_INCLUDES_PATH . 'social/googleplusoauth.php';

/**
 * Widgets
 */
require_once KING_INCLUDES_PATH . 'widgets/class-king-recent-widget.php';
require_once KING_INCLUDES_PATH . 'widgets/class-king-mostcommented-widget.php';
require_once KING_INCLUDES_PATH . 'widgets/class-king-trending-widget.php';
require_once KING_INCLUDES_PATH . 'widgets/class-king-hot-widget.php';
require_once KING_INCLUDES_PATH . 'widgets/class-king-related-widget.php';
require_once KING_INCLUDES_PATH . 'widgets/class-king-topusers-widget.php';
require_once KING_INCLUDES_PATH . 'widgets/class-king-leaderboard-widget.php';
require_once KING_INCLUDES_PATH . 'widgets/class-king-youtube.php';
require_once KING_INCLUDES_PATH . 'widgets/class-king-instagram.php';
/**
 * Check whether the plugin is active and theme can rely on it
 *
 * @param string $plugin Base plugin path.
 * @return bool
 */
function king_plugin_active( $plugin ) {
	if ( class_exists( $plugin ) ) {
		return true;
	} else {
		return false;
	}
}

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function king_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'king_content_width', 640 );
}
add_action( 'after_setup_theme', 'king_content_width', 0 );


/**
 * King Js files
 */
function king_scripts_enqueue() {
	global $wp_query;
	if ( get_field( 'enable_night_mode', 'options' ) ) {
		wp_enqueue_script( 'king_night_js', KING_THEME_URI . '/layouts/js/kingnight.js', array( 'jquery' ), '1.0', false );
	}
	if ( get_field( 'enable_notification', 'options' ) || get_field( 'enable_flags_for_posts', 'options' ) || get_field( 'enable_flags_for_comments', 'options' ) && is_user_logged_in() ) {
		wp_enqueue_script( 'king-notifications', KING_THEME_URI . '/layouts/js/king-notify.js', array( 'jquery' ), THEME_VERSION, true );
		wp_localize_script(
			'king-notifications',
			'kingNotify',
			array(
				'ajaxurl' => admin_url( 'admin-ajax.php' ),
			)
		);
	}

	wp_enqueue_script( 'bootstrap-js', KING_THEME_URI . '/layouts/js/bootstrap.min.js', array( 'jquery' ), THEME_VERSION, true );
	//KB CHANGE
	if ( $wp_query->get( 'bpsnews' ) || $wp_query->get( 'bpsvideo' ) || $wp_query->get( 'bpsaudio' ) || $wp_query->get( 'bpsimage' ) || $wp_query->get( 'bpsarlem' ) || $wp_query->get( 'bpupdte' ) ) {
		wp_enqueue_script( 'tagsinput', KING_THEME_URI . '/layouts/js/jquery.tagsinput.min.js', array(), THEME_VERSION, true );
		wp_enqueue_script( 'wp-tinymce' );
		wp_enqueue_script( 'king_submit_script', KING_THEME_URI . '/layouts/js/submit.js', array( 'jquery' ), THEME_VERSION, true );
	}
	wp_enqueue_script( 'infinite_ajax', KING_THEME_URI . '/layouts/js/jquery-ias.min.js', array( 'jquery' ), THEME_VERSION, true );
	wp_enqueue_script( 'sticky-kit', KING_THEME_URI . '/layouts/js/sticky-kit.min.js', array( 'jquery' ), THEME_VERSION, true );
	wp_enqueue_script( 'owl_carousel', KING_THEME_URI . '/layouts/js/owl.carousel.min.js', array( 'jquery' ), THEME_VERSION, true );
	if ( $wp_query->get( 'bpregister' ) ) {
		wp_enqueue_script( 'recaptcha', 'https://www.google.com/recaptcha/api.js', array(), 1.0, true );
	}
	if ( ! is_front_page() && ! is_single() || $wp_query->get( 'bpaccount' ) || $wp_query->get( 'bplike' ) || $wp_query->get( 'bpfollower' ) || $wp_query->get( 'bpfollowing' ) ) {
		wp_enqueue_script( 'king_simple-follows-public-js', KING_THEME_URI . '/layouts/js/user-follow.js', array( 'jquery' ), '0.5', false );
		wp_localize_script(
			'king_simple-follows-public-js',
			'simpleFollows',
			array(
				'ajaxurl'  => admin_url( 'admin-ajax.php' ),
				'follow'   => esc_html__( 'Follow', 'king' ),
				'unfollow' => esc_html__( 'Unfollow', 'king' ),
			)
		);
	}
	if ( get_field( 'enable_bookmarks', 'options' ) ) {
		wp_enqueue_script( 'king_readlater', KING_THEME_URI . '/layouts/js/king-readlater.js', array( 'jquery' ), THEME_VERSION, true );
		wp_localize_script(
			'king_readlater',
			'readlater',
			array(
				'ajaxurl'  => admin_url( 'admin-ajax.php' ),
			)
		);
	}
	$display_option = get_field( 'select_default_display_option', 'options' );
	if ( is_single() || 'king-list' === $display_option ) {
		if ( get_field( 'enable_ad_video', 'options' ) ) {
			wp_enqueue_script( 'loading_ad', get_template_directory_uri() . '/layouts/js/loading-ad.js', array( 'jquery' ), '1.0', true );
			wp_localize_script( 'loading_ad', 'loadingad', array( 'second' => get_field( 'skip_ad_after', 'options' ) ) );
		}
		wp_enqueue_script( 'single_js', get_template_directory_uri() . '/layouts/js/single.js', array( 'jquery' ), '1.0', true );

		wp_localize_script(
			'single_js',
			'singlejs',
			array(
				'ajaxurl' => admin_url( 'admin-ajax.php' ),
				'like'    => esc_html__( 'Like', 'king' ),
				'unlike'  => esc_html__( 'Unlike', 'king' ),
			)
		);
	}
	if ( get_field( 'enable_live_search', 'options' ) ) {
		wp_enqueue_script( 'king_live_search', KING_THEME_URI . '/layouts/js/live-search.js', array( 'jquery' ), THEME_VERSION, true );
		wp_localize_script( 'king_live_search', 'liveSeach', array( 'ajaxurl' => admin_url( 'admin-ajax.php' ) ) );
	}

	$enable_mas = false;
	if ( 'king-grid-07' === get_field( 'select_default_display_option', 'options' ) || 'king-grid-03' === get_field( 'select_default_display_option', 'options' ) || 'king-grid-10' === get_field( 'select_default_display_option', 'options' ) && ! is_single() ) {
		wp_enqueue_script( 'king_masonry', KING_THEME_URI . '/layouts/js/masonry.pkgd.min.js', array( 'jquery' ), '4.2.2', true );
		$enable_mas = true;
	}
	wp_enqueue_script( 'king_main_script', KING_THEME_URI . '/layouts/js/main.js', array( 'jquery' ), THEME_VERSION, true );
	wp_localize_script(
		'king_main_script',
		'mainscript',
		array(
			'itemslength'     => get_field( 'items_length', 'options' ),
			'miniitemslength' => get_field( 'mini_items_length', 'options' ),
			'infinitenumber'  => get_field( 'load_more_button_show', 'options' ),
			'lmore'           => esc_html__( 'Load More', 'king' ),
			'lmoref'          => esc_html__( 'There are no more pages left to load.', 'king' ),
			'enablemas'       => $enable_mas,
		)
	);
	if ( get_field( 'enable_headerstrip', 'options' ) || get_field( 'enable_gdpr_cookie', 'options' ) || get_field( 'enable_newsletter_popup', 'options' ) ) {
		wp_enqueue_script( 'king_cookie', KING_THEME_URI . '/layouts/js/js.cookie.min.js', array( 'jquery' ), '3.0.0', true );
		wp_enqueue_script( 'king_hscookie', KING_THEME_URI . '/layouts/js/hs-cookie.js', array( 'jquery' ), '1', true );
		wp_localize_script(
			'king_hscookie',
			'kinghscookie',
			array(
				'ajaxurl'  => admin_url( 'admin-ajax.php' ),
			)
		);
	}
	if ( is_page_template( 'king_page_kingflix.php' ) || get_field( 'enable_stories', 'options' ) ) {
		wp_enqueue_script( 'magnefic-popup', KING_THEME_URI . '/layouts/js/magnific-popup/jquery.magnific-popup.min.js', array( 'jquery' ), '1', true );
		wp_enqueue_style( 'magnefic-popup-css', KING_THEME_URI . '/layouts/js/magnific-popup/magnific-popup.css', array(), THEME_VERSION );
	}
}
add_action( 'wp_enqueue_scripts', 'king_scripts_enqueue' );
/**
 * ACF custom style
 */
function king_generate_options_css() {
	global $wp_filesystem;
	if ( empty( $wp_filesystem ) ) {
		require_once ABSPATH . '/wp-admin/includes/file.php';
		WP_Filesystem();
	}
	$css_dir     = KING_THEME_DIR . '/layouts/';
	$css_php_dir = KING_THEME_DIR . '/layouts/';
	ob_start();
	require_once $css_php_dir . 'custom-styles.php';
	$css = ob_get_clean();
	if ( $wp_filesystem ) {
		$wp_filesystem->put_contents( $css_dir . 'custom-styles.css', $css, FS_CHMOD_FILE );
	}
}
add_action( 'acf/save_post', 'king_generate_options_css' ); // Parse the output and write the CSS file on post save.

/**
 * Acf admin panel styles.
 */
function king_acf_style() {
	wp_enqueue_script( 'king_ad', KING_THEME_URI . '/layouts/js/admin.js', array( 'jquery' ), '3.0.0', true );
	wp_enqueue_style( 'acf_styles', get_template_directory_uri() . '/layouts/acf-styles.css', array(), THEME_VERSION );
	wp_enqueue_style( 'font-awesome-admin', KING_THEME_URI . '/layouts/font-awesome/css/all.min.css', array(), THEME_VERSION );
}
add_action( 'admin_enqueue_scripts', 'king_acf_style' );

/**
 * Post format links rewrite.
 */
function king_get_post_format_slugs() {

	$slugs = array(
		'aside'   => 'asides',
		'audio'   => 'music',
		'chat'    => 'chats',
		'gallery' => 'galleries',
		'image'   => 'images',
		'link'    => 'links',
		'quote'   => 'news',
		'status'  => 'status-updates',
		'video'   => 'videos',
		'arlem'	  => 'arlem', //KB changes
	);

	return $slugs;
}
/* Remove core WordPress filter. */
remove_filter( 'term_link', '_post_format_link', 10 );

/* Add custom filter. */
add_filter( 'term_link', 'king_post_format_link', 10, 3 );

/**
 * Filters post format links to use a custom slug.
 *
 * @param string $link The permalink to the post format archive.
 * @param object $term The term object.
 * @param string $taxnomy The taxonomy name.
 * @return string
 */
function king_post_format_link( $link, $term, $taxonomy ) {
	global $wp_rewrite;

	if ( 'post_format' !== $taxonomy ) {
		return $link;
	}

	$slugs = king_get_post_format_slugs();

	$slug = str_replace( 'post-format-', '', $term->slug );
	$slug = isset( $slugs[ $slug ] ) ? $slugs[ $slug ] : $slug;

	if ( $wp_rewrite->get_extra_permastruct( $taxonomy ) ) {
		$link = str_replace( "/{$term->slug}", '/' . $slug, $link );
	} else {
		$link = add_query_arg( 'post_format', $slug, remove_query_arg( 'post_format', $link ) );
	}

	return $link;
}
/* Remove the core WordPress filter. */
remove_filter( 'request', '_post_format_request' );

/* Add custom filter. */
add_filter( 'request', 'king_post_format_request' );

/**
 * Changes the queried post format slug to the slug saved in the database.
 *
 * @param array $qvs The queried variables.
 * @return array
 */
function king_post_format_request( $qvs ) {

	if ( ! isset( $qvs['post_format'] ) ) {
		return $qvs;
	}

	$slugs = array_flip( king_get_post_format_slugs() );

	if ( isset( $slugs[ $qvs['post_format'] ] ) ) {
		$qvs['post_format'] = 'post-format-' . $slugs[ $qvs['post_format'] ];
	}

	$tax = get_taxonomy( 'post_format' );

	if ( ! is_admin() ) {
		$qvs['post_type'] = $tax->object_type;
	}

	return $qvs;
}

/**
 * Footer Widgets Area
 */
function king_widgets() {
	// Right sidebar.
	register_sidebar(
		array(
			'name'          => esc_html__( 'Right Sidebar', 'king' ),
			'id'            => 'sidebar-1',
			'description'   => esc_html__( 'Add widgets here.', 'king' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>',
		)
	);
	// Right sidebar.
	register_sidebar(
		array(
			'name'          => esc_html__( 'Left Sidebar', 'king' ),
			'id'            => 'sidebar-2',
			'description'   => esc_html__( 'Add widgets here.', 'king' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>',
		)
	);
	// First footer widget area, located in the footer. Empty by default.
	register_sidebar(
		array(
			'name'          => esc_html__( 'First Footer Widget Area', 'king' ),
			'id'            => 'first-footer-widget-area',
			'description'   => esc_html__( 'The first footer widget area', 'king' ),
			'before_widget' => '<div id="%1$s" class="widget-container %2$s">',
			'after_widget'  => '</div>',
			'before_title'  => '<h3 class="widget-title">',
			'after_title'   => '</h3>',
		)
	);

	// Second Footer Widget Area, located in the footer. Empty by default.
	register_sidebar(
		array(
			'name'          => esc_html__( 'Second Footer Widget Area', 'king' ),
			'id'            => 'second-footer-widget-area',
			'description'   => esc_html__( 'The second footer widget area', 'king' ),
			'before_widget' => '<div id="%1$s" class="widget-container %2$s">',
			'after_widget'  => '</div>',
			'before_title'  => '<h3 class="widget-title">',
			'after_title'   => '</h3>',
		)
	);

	// Third Footer Widget Area, located in the footer. Empty by default.
	register_sidebar(
		array(
			'name'          => esc_html__( 'Third Footer Widget Area', 'king' ),
			'id'            => 'third-footer-widget-area',
			'description'   => esc_html__( 'The third footer widget area', 'king' ),
			'before_widget' => '<div id="%1$s" class="widget-container %2$s">',
			'after_widget'  => '</div>',
			'before_title'  => '<h3 class="widget-title">',
			'after_title'   => '</h3>',
		)
	);

	// Fourth Footer Widget Area, located in the footer. Empty by default.
	register_sidebar(
		array(
			'name'          => esc_html__( 'Fourth Footer Widget Area', 'king' ),
			'id'            => 'fourth-footer-widget-area',
			'description'   => esc_html__( 'The fourth footer widget area', 'king' ),
			'before_widget' => '<div id="%1$s" class="widget-container %2$s">',
			'after_widget'  => '</div>',
			'before_title'  => '<h3 class="widget-title">',
			'after_title'   => '</h3>',
		)
	);

}
// Register sidebars by running king_footer_widgets_init() on the widgets_init hook.
add_action( 'widgets_init', 'king_widgets' );

/**
 * Register Fonts.
 *
 * @return font_url.
 */
function king_google_fonts_url() {
	$font_url = '';
	if ( get_field( 'google_fonts', 'options' ) ) :
		$font       = get_field_object( 'google_fonts', 'options' );
		$value      = $font['value'];
		$fontfamily = $font['choices'][ $value ];
	else :
		$fontfamily = 'Nunito';
	endif;
	$query_args = array(
		'family'    => urlencode( $fontfamily . ':ital,wght@0,300;0,400;0,600;0,700;1,400' ),
		'display'   => 'swap',
	);
	$font_url = add_query_arg( $query_args, '//fonts.googleapis.com/css' );
	return esc_url_raw( $font_url );
}

/**
 * Enqueue scripts and styles.
 */
function king_scripts() {
	wp_enqueue_style( 'king-style', get_stylesheet_uri(), array(), THEME_VERSION );
	if ( king_plugin_active( 'WooCommerce' ) ) {
		wp_enqueue_style( 'king-shop-style', KING_THEME_URI . '/woocommerce/css/woocommerce.css', array(), THEME_VERSION );
	}
	if ( get_field( 'enable_night_mode', 'options' ) ) {
		wp_enqueue_style( 'night-styles', KING_THEME_URI . '/layouts/king-night.css', array(), THEME_VERSION );
	}
	wp_enqueue_style( 'custom-styles', KING_THEME_URI . '/layouts/custom-styles.css', array(), THEME_VERSION );
	wp_enqueue_style( 'googlefont-style', king_google_fonts_url(), array(), '1.0.0' );
	wp_enqueue_style( 'font-awesome-style', KING_THEME_URI . '/layouts/font-awesome/css/all.min.css', array(), THEME_VERSION );
	//KB CHANGES FOLLOW UP?
	if ( is_page_template( 'king_page_kingflix.php' ) || is_singular() && has_post_format( 'video' ) || has_post_format( 'audio' ) ) {
		wp_enqueue_script( 'video-js', KING_THEME_URI . '/layouts/js/videojs/video.min.js', array( 'jquery' ), '1.0', false );
		wp_enqueue_style( 'video-js-style', KING_THEME_URI . '/layouts/js/videojs/video-js.css', array(), THEME_VERSION );
	}
	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
	if ( is_page_template( 'king_page_kingflix.php' ) ) {
		wp_enqueue_script( 'kingflix-js', KING_THEME_URI . '/layouts/js/kingflix.min.js', array( 'jquery' ), '1.0', true );
	}
	if ( 'story' === get_query_var( 'template' ) && get_field( 'enable_stories', 'options' ) ) {
		wp_enqueue_script( 'fabricjs', KING_THEME_URI . '/layouts/js/story/fabric.min.js', array(), THEME_VERSION, false );
		wp_enqueue_script( 'createstoryjs', KING_THEME_URI . '/layouts/js/story/createstory.js', array(), THEME_VERSION, true );
		wp_enqueue_style( 'googlefont-story', 'https://fonts.googleapis.com/css2?family=Amatic+SC&family=Meow+Script&family=Monoton&family=Rubik+Beastly&family=Shadows+Into+Light&family=Ubuntu&display=swap', array(), null );
	}
	if ( get_field( 'enable_stories', 'options' ) ) {
		wp_enqueue_script( 'storyjs', KING_THEME_URI . '/layouts/js/story/story.js', array( 'jquery' ), THEME_VERSION, true );
		wp_localize_script(
			'storyjs',
			'storyaurl',
			array(
				'ajaxurl' => admin_url( 'admin-ajax.php' ),
			)
		);
	}

}
add_action( 'wp_enqueue_scripts', 'king_scripts' );

/**
 * Disable default WP admin bar for users.
 *
 * @param <type> $user_id  The user identifier.
 */
function king_set_user_admin_bar_false_by_default( $user_id ) {
	update_user_meta( $user_id, 'show_admin_bar_front', 'false' );
	update_user_meta( $user_id, 'show_admin_bar_admin', 'false' );
}
add_action( 'user_register', 'king_set_user_admin_bar_false_by_default', 10, 1 );

/**
 * Disable Pesonal Uploads
 *
 * @param [type] $existing_mimes existing mimes.
 * @return array
 */
function king_disallow_personal_uploads( $existing_mimes = array() ) {
	unset( $existing_mimes['zip'] );
	return $existing_mimes;
}
add_filter( 'upload_mimes', 'king_disallow_personal_uploads' );

/**
 * KB: allow additional mime types
 *
 * @param [type] $existing_mimes existing mimes.
 * @return array
 */
function add_custom_upload_mimes( $existing_mimes ){
	$existing_mimes['zip']  = 'application/zip';
	$existing_mimes['json']  = 'application/json';
	$existing_mimes['gzip']  = 'application/gzip';
	return $existing_mimes;
}
add_filter('upload_mimes', 'add_custom_upload_mimes');

/**
 * Implement the Custom Header feature.
 */
require get_template_directory() . '/includes/customizer-head.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/includes/template-tags.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/includes/customizer.php';

/**
 * Theme main functions.
 */
require get_template_directory() . '/includes/theme.php';

/**
 * Post Functions.
 */
require get_template_directory() . '/includes/post.php';

/*Globals*/
global $king_account;
global $king_edit;
global $king_login;
global $king_register;
global $king_reset;
global $king_likes;
global $king_snews;
global $king_svideo;
global $king_saudio;
global $king_simage;
global $king_sarlem; //KB CHANGE
global $king_followers;
global $king_following;
global $king_dashboard;
global $king_prvtmsg;
global $king_updte; 
global $hide;

/**
 * Init globals.
 */
function king_init_globals() {
	global $king_account;
	global $king_likes;
	global $king_edit;
	global $king_login;
	global $king_register;
	global $king_reset;
	global $king_snews;
	global $king_svideo;
	global $king_saudio;
	global $king_simage;
	global $king_sarlem; //KB CHANGE
	global $king_followers;
	global $king_following;
	global $king_dashboard;
	global $king_prvtmsg;
	global $king_updte;
	global $hide;
	$king_account   = 'profile';
	$king_likes     = 'likes';
	$king_followers = 'followers';
	$king_following = 'following';
	$king_edit      = 'settings';
	$king_login     = 'login';
	$king_register  = 'register';
	$king_reset     = 'reset';
	$king_snews     = 'submit-post';
	$king_svideo    = 'submit-video';
	$king_saudio    = 'submit-audio';
	$king_simage    = 'submit-image';
	$king_sarlem	= 'submit-arlem'; //KB CHANGE
	$king_dashboard = 'dashboard';
	$king_prvtmsg   = 'prvtmsg';
	$king_updte     = 'updte'; 
}
add_action( 'init', 'king_init_globals' );
/*Custom Rewrite Rules*/

/**
 * Init globals.
 */
function king_add_rewrite_rules() {
	add_rewrite_rule( '^' . $GLOBALS['king_account'] . '/settings?', 'index.php?bpsettings=1', 'top' );
	add_rewrite_rule( '^' . $GLOBALS['king_account'] . '/([^/]*)/?', 'index.php?bpaccount=1&profile_id=$matches[1]', 'top' );
	add_rewrite_rule( '^' . $GLOBALS['king_account'] . '/?', 'index.php?bpaccount=1', 'top' );
	add_rewrite_rule( '^' . $GLOBALS['king_likes'] . '/([^/]*)/?', 'index.php?bplike=1&profile_id=$matches[1]', 'top' );
	add_rewrite_rule( '^' . $GLOBALS['king_likes'] . '/?', 'index.php?bplike=1', 'top' );
	add_rewrite_rule( '^' . $GLOBALS['king_followers'] . '/([^/]*)/?', 'index.php?bpfollower=1&profile_id=$matches[1]', 'top' );
	add_rewrite_rule( '^' . $GLOBALS['king_followers'] . '/?', 'index.php?bpfollower=1', 'top' );
	add_rewrite_rule( '^' . $GLOBALS['king_following'] . '/([^/]*)/?', 'index.php?bpfollowing=1&profile_id=$matches[1]', 'top' );
	add_rewrite_rule( '^' . $GLOBALS['king_following'] . '/?', 'index.php?bpfollowing=1', 'top' );
	add_rewrite_rule( '^' . $GLOBALS['king_dashboard'] . '/?', 'index.php?bpdashboard=1', 'top' );
	add_rewrite_rule( '^' . $GLOBALS['king_prvtmsg'] . '/([^/]*)/?', 'index.php?bpprvtmsg=1&profile_id=$matches[1]', 'top' );
	add_rewrite_rule( '^' . $GLOBALS['king_prvtmsg'] . '/?', 'index.php?bpprvtmsg=1', 'top' );
	add_rewrite_rule( '^' . $GLOBALS['king_login'] . '/?', 'index.php?bplogin=1', 'top' );
	add_rewrite_rule( '^' . $GLOBALS['king_register'] . '/?', 'index.php?bpregister=1', 'top' );
	add_rewrite_rule( '^' . $GLOBALS['king_reset'] . '/?', 'index.php?bpreset=1', 'top' );
	add_rewrite_rule( '^' . $GLOBALS['king_snews'] . '/([^/]*)/?', 'index.php?bpsnews=1&template=$matches[1]', 'top' );
	add_rewrite_rule( '^' . $GLOBALS['king_snews'] . '/?', 'index.php?bpsnews=1', 'top' );
	add_rewrite_rule( '^' . $GLOBALS['king_svideo'] . '/?', 'index.php?bpsvideo=1', 'top' );
	add_rewrite_rule( '^' . $GLOBALS['king_saudio'] . '/?', 'index.php?bpsaudio=1', 'top' );
	add_rewrite_rule( '^' . $GLOBALS['king_simage'] . '/?', 'index.php?bpsimage=1', 'top' );
	add_rewrite_rule( '^' . $GLOBALS['king_sarlem'] . '/?', 'index.php?bpsarlem=1', 'top' ); //KB CHANGE
	add_rewrite_rule( '^' . $GLOBALS['king_updte'] . '/?', 'index.php?bpupdte=1', 'top' );
}
add_action( 'init', 'king_add_rewrite_rules' );



/**
 * Query vars.
 *
 * @param query $query_vars queries.
 *
 * @return mixed
 */
function king_query_vars( $query_vars ) {
	$query_vars[] = 'list';
	$query_vars[] = 'template';
	$query_vars[] = 'bpaccount';
	$query_vars[] = 'bplike';
	$query_vars[] = 'bpfollower';
	$query_vars[] = 'bpfollowing';
	$query_vars[] = 'bpdashboard';
	$query_vars[] = 'bpprvtmsg';
	$query_vars[] = 'bplogin';
	$query_vars[] = 'bpregister';
	$query_vars[] = 'bpreset';
	$query_vars[] = 'bpsnews';
	$query_vars[] = 'bpsvideo';
	$query_vars[] = 'bpsaudio';
	$query_vars[] = 'bpsimage';
	$query_vars[] = 'bpsarlem'; //KB CHANGE
	$query_vars[] = 'bpsettings';
	$query_vars[] = 'bpupdte';
	$query_vars[] = 'profile_id';
	return $query_vars;
}
add_filter( 'query_vars', 'king_query_vars' );
/**
 * Template redirects
 */
function king_template_redirects() {
	global $wp_query;
	if ( $wp_query->get( 'bpaccount' ) ) :
		get_template_part( 'user', 'profile' );
		exit();
	endif;
	if ( $wp_query->get( 'bplike' ) ) :
		get_template_part( 'user', 'likes' );
		exit();
	endif;
	if ( $wp_query->get( 'bpfollower' ) ) :
		get_template_part( 'user', 'followers' );
		exit();
	endif;
	if ( $wp_query->get( 'bpfollowing' ) ) :
		get_template_part( 'user', 'following' );
		exit();
	endif;
	if ( $wp_query->get( 'bpdashboard' ) ) :
		get_template_part( 'user', 'dashboard' );
		exit();
	endif;
	if ( $wp_query->get( 'bpprvtmsg' ) ) :
		get_template_part( 'template', 'messages' );
		exit();
	endif;
	if ( $wp_query->get( 'bpupdte' ) ) :
		get_template_part( 'template', 'edit-post' );
		exit();
	endif;
	if ( $wp_query->get( 'bplogin' ) ) :
		get_template_part( 'template', 'login' );
		exit();
	endif;
	if ( $wp_query->get( 'bpregister' ) ) :
		get_template_part( 'template', 'register' );
		exit();
	endif;
	if ( $wp_query->get( 'bpreset' ) ) :
		get_template_part( 'template', 'reset' );
		exit();
	endif;
	if ( $wp_query->get( 'bpsnews' ) ) :
		get_template_part( 'template', 'submit-post' );
		exit();
	endif;
	if ( $wp_query->get( 'bpsvideo' ) ) :
		get_template_part( 'template', 'submit-video' );
		exit();
	endif;
	if ( $wp_query->get( 'bpsaudio' ) ) :
		get_template_part( 'template', 'submit-audio' );
		exit();
	endif;
	if ( $wp_query->get( 'bpsimage' ) ) :
		get_template_part( 'template', 'submit-image' );
		exit();
	endif;
	//KB CHANGE
	if ( $wp_query->get( 'bpsarlem' ) ) :
		get_template_part( 'template', 'submit-arlem' );
		exit();
	endif;
	//END KB CHANGE
	if ( $wp_query->get( 'bpsettings' ) ) :
		get_template_part( 'user', 'settings' );
		exit();
	endif;
}
add_filter( 'template_redirect', 'king_template_redirects' );

if ( ! function_exists( 'king_header_metadata' ) ) :
	function king_header_metadata() {
		$output = '<meta name="viewport" content="width=device-width, maximum-scale=1.0, minimum-scale=1.0, initial-scale=1.0" />';
		echo $output;
	}
	add_action( 'wp_head', 'king_header_metadata' );
endif;

/**
 * Google Login Js Files
 */
function king_googleplus_oauth_callback_scripts() {
	global $wp, $wp_query;

	if ( get_field( 'enable_googleplus_login','option' ) ) {
		if ( get_field( 'enable_social_logins_in_modal','option' ) && ! is_user_logged_in() ) {
			wp_enqueue_script( 'googleplatform', 'https://apis.google.com/js/platform.js' );
			wp_enqueue_script( 'googleclient', 'https://apis.google.com/js/client.js?onload=GoggleOnLoad' );
			wp_enqueue_script( 'king-social-login-js', KING_THEME_URI . '/includes/social/googleplusoauth/googleplusoauth.js', array( 'jquery' ), '20160407', true );

			$ajax_auth_object = array(
				'url'                => KING_THEME_URI,
				'ajaxurl'            => admin_url( 'admin-ajax.php' ),
				'login_redirect_url' => apply_filters( 'king_auth_login_redirect_url', site_url() ),
				'google_oauth_id'    => get_field( 'googleplus_client_id', 'option' ),
				'google_api_key'     => get_field( 'googleplus_client_secret', 'option' ),
				'nonce'              => wp_create_nonce( 'social_ajax_nonce' ),
			);
			wp_localize_script( 'king-social-login-js', 'ajax_googleplus_oauth_object', $ajax_auth_object );
		} elseif ( $wp_query->get( 'bplogin' ) || $wp_query->get( 'bpregister' ) ) {
			wp_enqueue_script( 'googleplatform', 'https://apis.google.com/js/platform.js', array(), '1.0', false );
			wp_enqueue_script( 'googleclient', 'https://apis.google.com/js/client.js?onload=GoggleOnLoad', array(), '1.0', false );
			wp_enqueue_script( 'king-social-login-js', KING_THEME_URI . '/includes/social/googleplusoauth/googleplusoauth.js', array(), '1.0', false );

			$ajax_auth_object = array(
				'url'                => KING_THEME_URI,
				'ajaxurl'            => admin_url( 'admin-ajax.php' ),
				'login_redirect_url' => apply_filters( 'king_auth_login_redirect_url', site_url() ),
				'google_oauth_id'    => get_field( 'googleplus_client_id', 'option' ),
				'google_api_key'     => get_field( 'googleplus_client_secret', 'option' ),
				'nonce'              => wp_create_nonce( 'social_ajax_nonce' ),
			);
			wp_localize_script( 'king-social-login-js', 'ajax_googleplus_oauth_object', $ajax_auth_object );
		}
	}
}
add_action( 'wp_enqueue_scripts', 'king_googleplus_oauth_callback_scripts' );

/**
 * Woocommerce functions
 */
if ( king_plugin_active( 'WooCommerce' ) ) {
	require_once KING_INCLUDES_PATH . 'plugins/woocommerce.php';
}

if ( king_plugin_active( 'ACF' ) ) {
	if ( get_field( 'enable_amp', 'option' ) ) {
		require_once KING_INCLUDES_PATH . 'plugins/amp.php';
	}
	require_once KING_INCLUDES_PATH . 'theme-options.php';
	if ( king_plugin_active( 'OCDI_Plugin' ) && king_theme_register() ) {
		require_once KING_INCLUDES_PATH . 'plugins/one-click-demo-import.php';
	}
	if ( function_exists( 'is_woocommerce' ) && get_field( 'enable_membership', 'options' ) ) {
		require get_template_directory() . '/includes/extras.php';
	}
}
if ( function_exists( 'instant_articles_init' ) ) {
	require_once KING_INCLUDES_PATH . 'plugins/facebook-instant-articles.php';
}

/*
 *
 * KB CHANGE
 * Add notification if user hasn't completed thier profile
 * post id is hardcoded to match page id of user settings in database
 */
function user_profile_incomplete($user_id) {
	king_create_notify( 6, 'completeProfile' );		
}

add_action( 'user_register', 'user_profile_incomplete', 10, 1 );

/**
 *
 * KB: modified from core WP link-template, so uses FE editor
 * 
 * Retrieves the edit post link for post.
 *
 * Can be used within the WordPress loop or outside of it. Can be used with
 * pages, posts, attachments, and revisions.
 *
 * @since 2.3.0
 *
 * @param int|WP_Post $id      Optional. Post ID or post object. Default is the global `$post`.
 * @param string      $context Optional. How to output the '&' character. Default '&amp;'.
 * @return string|null The edit post link for the given post. Null if the post type does not exist
 *                     or does not allow an editing UI.
 */
function king_get_edit_post_link( $id = 0, $context = 'display' ) {
	$post = get_post( $id );
	if ( ! $post ) {
		return;
	}

	if ( 'revision' === $post->post_type ) {
		$action = '';
	} elseif ( 'display' === $context ) {
		$action = '&amp;action=edit';
	} else {
		$action = '&action=edit';
	}

	$post_type_object = get_post_type_object( $post->post_type );
	if ( ! $post_type_object ) {
		return;
	}

	if ( ! current_user_can( 'edit_post', $post->ID ) ) {
		return;
	}

	if ( $post_type_object->_edit_link ) {
		//KB change: use front end editor
		$link = esc_url( add_query_arg( 'post', $id, home_url( $GLOBALS['king_updte'] . '/' ) ) ); 
	} else {
		$link = '';
	}

	/**
	 * Filters the post edit link.
	 *
	 * @since 2.3.0
	 *
	 * @param string $link    The edit link.
	 * @param int    $post_id Post ID.
	 * @param string $context The link context. If set to 'display' then ampersands
	 *                        are encoded.
	 */
	return apply_filters( 'king_get_edit_post_link', $link, $post->ID, $context );
}

/**
 * KB: Displays the edit post link for post.
 * @since 1.0.0
 * @since 4.4.0 The `$class` argument was added.
 *
 * @param string      $text   Optional. Anchor text. If null, default is 'Edit This'. Default null.
 * @param string      $before Optional. Display before edit link. Default empty.
 * @param string      $after  Optional. Display after edit link. Default empty.
 * @param int|WP_Post $id     Optional. Post ID or post object. Default is the global `$post`.
 * @param string      $class  Optional. Add custom class to link. Default 'post-edit-link'.
 */
function king_edit_post_link( $text = null, $before = '', $after = '', $id = 0, $class = 'post-edit-link' ) {
	$post = get_post( $id );
	if ( ! $post ) {
		return;
	}

	$url = "";
	$post_type = get_post_type( $id );
	if ( $post_type == "arlem") {
		$url = king_get_edit_post_link( $id );
	} else {
		$url = edit_post_link($text, $before, $after, $id, $class);
	}

	if ( ! $url ) {
		return;
	}

	if ( null === $text ) {
		$text = __( 'Edit This' );
	}

	$link = '<a class="' . esc_attr( $class ) . '" href="' . esc_url( $url ) . '">' . $text . '</a>';

	/**
	 * Filters the post edit link anchor tag.
	 *
	 * @since 2.3.0
	 *
	 * @param string $link    Anchor tag for the edit link.
	 * @param int    $post_id Post ID.
	 * @param string $text    Anchor text.
	 */
	echo $before . apply_filters( 'king_edit_post_link', $link, $post->ID, $text ) . $after;
}
