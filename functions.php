<?php
/**
 * popper functions and definitions.
 *
 * @link    https://codex.wordpress.org/Functions_File_Explained
 *
 * @package popper
 */

add_action( 'after_setup_theme', 'popper_setup' );
if ( ! function_exists( 'popper_setup' ) ) {
	/**
	 * Sets up theme defaults and registers support for various WordPress features.
	 *
	 * Note that this function is hooked into the after_setup_theme hook, which
	 * runs before the init hook. The init hook is too late for some features, such
	 * as indicating support for post thumbnails.
	 */
	function popper_setup() {

		/*
		 * Make theme available for translation.
		 * Translations can be filed in the /languages/ directory.
		 * If you're building a theme based on popper, use a find and replace
		 * to change 'popper' to the name of your theme in all the template files.
		 */
		load_theme_textdomain( 'popper', get_template_directory() . '/languages' );

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
		 * Add new image sizes and theme support for Custom Logo
		 */
		add_theme_support( 'custom-logo', array(
			'height'      => 96,
			'width'       => 96,
			'flex-height' => false,
			'flex-width'  => false,
		) );

		/*
		 * Enable support for Post Thumbnails on posts and pages.
		 *
		 * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
		 */
		add_theme_support( 'post-thumbnails' );
		set_post_thumbnail_size( 828, 360, true );

		// This theme uses wp_nav_menu() in one location.
		register_nav_menus( array(
			'primary' => esc_html__( 'Primary Menu', 'popper' ),
		) );

		/*
		 * Switch default core markup for search form, comment form, and comments
		 * to output valid HTML5.
		 */
		add_theme_support( 'html5', array(
			'search-form',
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
		) );

		/*
		 * Enable support for Post Formats.
		 * See https://developer.wordpress.org/themes/functionality/post-formats/
		 */
		add_theme_support( 'post-formats', array(
			'aside',
			'image',
			'video',
			'quote',
			'link',
		) );

		/*
		 * This theme styles the visual editor to resemble the theme style,
		 * specifically font, colors, icons, and column width.
		 */
		add_editor_style( array(
			'inc/editor-style.css',
			'//fonts.googleapis.com/css?family=Fira+Sans:400,300,300italic,400italic,500,500italic,700,700italic|Merriweather:400,300,300italic,400italic,700,700italic',
			'/icons/style.css'
		) );
	}
} // end if, popper_setup

add_action( 'after_setup_theme', 'popper_content_width', 0 );
/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function popper_content_width() {

	$GLOBALS[ 'content_width' ] = apply_filters( 'popper_content_width', 702 );
}

add_action( 'widgets_init', 'popper_widgets_init' );
/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function popper_widgets_init() {

	register_sidebar( array(
		'name'          => esc_html__( 'Widget Area', 'popper' ),
		'id'            => 'sidebar-1',
		'description'   => '',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );
}

add_action( 'wp_enqueue_scripts', 'popper_scripts' );
/**
 * Enqueue scripts and styles.
 */
function popper_scripts() {

	wp_register_style( 'popper-style', get_template_directory_uri() . '/style.css', array(), '20161208' );
	wp_enqueue_style( 'popper-style' );

	// Fonts: Fira Sans and Merriweather, https://www.google.com/fonts
	wp_register_style(
		'popper-google-fonts',
		'//fonts.googleapis.com/css?family=Fira+Sans:400,300,300italic,400italic,500,500italic,700,700italic|Merriweather:400,300,300italic,400italic,700,700italic'
	);
	wp_enqueue_style( 'popper-google-fonts' );

	// Icon font
	wp_register_style( 'popper-icons', get_template_directory_uri() . '/icons/style.css' );
	wp_enqueue_style( 'popper-icons' );

	wp_register_script( 'popper-functions',
		get_template_directory_uri() . '/js/functions.js', array( 'jquery' ), '20150916', true );
	wp_enqueue_script( 'popper-functions' );

	wp_register_script( 'popper-skip-link-focus-fix',
		get_template_directory_uri() . '/js/skip-link-focus-fix.js', array(), '20130115', true );
	wp_enqueue_script( 'popper-skip-link-focus-fix' );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}

	wp_localize_script( 'popper-functions', 'screenReaderText', array(
		'expand'   => '<span class="screen-reader-text">' . esc_html__( 'expand child menu', 'popper' ) . '</span>',
		'collapse' => '<span class="screen-reader-text">' . esc_html__( 'collapse child menu', 'popper' ) . '</span>',
	) );
}

add_action( 'style_loader_tag', 'popper_custom_attributes' );
/**
 * Change tag of styles. Add custom attributes for preload fonts.
 *
 * @param $tag
 *
 * @return mixed
 */
function popper_custom_attributes( $tag ) {

	$tag = str_replace( 'id=\'popper-google-fonts-css\'', 'id=\'popper-google-fonts-css\' rel=\'preload\'', $tag );
	return $tag;
}

if ( ! function_exists( 'wp_body_open' ) ) {
	/**
	 * Shim for wp_body_open, ensuring backwards compatibility with versions of WordPress older than 5.2.
	 */
	function wp_body_open() {
		do_action( 'wp_body_open' );
	}
}

/**
 * Implement the Custom Header feature.
 */
require get_template_directory() . '/inc/custom-header.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Custom functions that act independently of the theme templates.
 */
require get_template_directory() . '/inc/extras.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Load Jetpack compatibility file.
 */
require get_template_directory() . '/inc/jetpack.php';

/**
 * Load custom widgets
 */
require get_template_directory() . '/widgets/recent-comments.php';
require get_template_directory() . '/widgets/recent-posts.php';
