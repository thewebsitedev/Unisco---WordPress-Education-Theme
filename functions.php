<?php
/**
 * unisco functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package unisco
 */

if ( ! function_exists( 'unisco_setup' ) ) :
	/**
	 * Sets up theme defaults and registers support for various WordPress features.
	 *
	 * Note that this function is hooked into the after_setup_theme hook, which
	 * runs before the init hook. The init hook is too late for some features, such
	 * as indicating support for post thumbnails.
	 */
	function unisco_setup() {
		/*
		 * Make theme available for translation.
		 * Translations can be filed in the /languages/ directory.
		 * If you're building a theme based on unisco, use a find and replace
		 * to change 'unisco' to the name of your theme in all the template files.
		 */
		load_theme_textdomain( 'unisco', get_template_directory() . '/languages' );

		// Add default posts and comments RSS feed links to head.
		add_theme_support( 'automatic-feed-links' );

		// add support for quote post type
		add_theme_support( 'post-formats', array( 'quote' ) );

		/*
		 * Let WordPress manage the document title.
		 * By adding theme support, we declare that this theme does not use a
		 * hard-coded <title> tag in the document head, and expect WordPress to
		 * provide it for us.
		 */
		add_theme_support( 'title-tag' );

		// Add theme support for Custom Logo.
		add_theme_support( 'custom-logo', array(
			'width'      => 250,
			'height'     => 250,
			'flex-width' => true,
		) );

		/*
		 * Enable support for Post Thumbnails on posts and pages.
		 *
		 * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
		 */
		add_theme_support( 'post-thumbnails' );

		// This theme uses wp_nav_menu() in one location.
		register_nav_menus( array(
			'top-left'  => esc_html__( 'Top Left', 'unisco' ),
			'top-right' => esc_html__( 'Top Right', 'unisco' ),
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

		// Set up the WordPress core custom background feature.
		add_theme_support( 'custom-background', apply_filters( 'unisco_custom_background_args', array(
			'default-color' => 'ffffff',
			'default-image' => '',
		) ) );

		// Add theme support for selective refresh for widgets.
		add_theme_support( 'customize-selective-refresh-widgets' );

		/*
		 * This theme styles the visual editor to resemble the theme style,
		 * specifically font, colors, icons, and column width.
		 */
		add_editor_style( array( 'css/editor-style.css', unisco_fonts_url() ) );

		add_image_size( 'unisco-160x160', 160, 160, true );
		add_image_size( 'unisco-263x169', 263, 169, true );
		add_image_size( 'unisco-257x277', 257, 277, true );
		add_image_size( 'unisco-361x224', 361, 224, true );
		add_image_size( 'unisco-751x224', 751, 224, true );
		add_image_size( 'unisco-1110x440', 1110, 440, true );
	}
endif;
add_action( 'after_setup_theme', 'unisco_setup' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function unisco_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'unisco_content_width', 640 );
}
add_action( 'after_setup_theme', 'unisco_content_width', 0 );

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function unisco_widgets_init() {
	register_sidebar( array(
		'name'          => esc_html__( 'Sidebar', 'unisco' ),
		'id'            => 'sidebar-1',
		'description'   => esc_html__( 'This is the default sidebar.', 'unisco' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h3>',
	) );
	register_sidebar( array(
		'name'          => esc_html__( 'Course', 'unisco' ),
		'id'            => 'course',
		'description'   => esc_html__( 'This sidebar will be shown on single course page.', 'unisco' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h3>',
	) );
	register_sidebar( array(
		'name'          => esc_html__( 'Footer', 'unisco' ),
		'id'            => 'footer',
		'description'   => esc_html__( 'Add widgets here.', 'unisco' ),
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget'  => '</div>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h3>',
	) );
}
add_action( 'widgets_init', 'unisco_widgets_init' );

/**
 * Register fonts.
 * @since 1.0.0
 */
function unisco_fonts_url() {
	$fonts_url = '';
	$fonts     = array();
	$subsets   = 'latin,latin-ext';

	/* translators: If there are characters in your language that are not supported by Merriweather, translate this to 'off'. Do not translate into your own language. */
	if ( 'off' !== _x( 'on', 'Lora font: on or off', 'unisco' ) ) {
		$fonts[] = 'Lora:400,700,400italic,700italic';
	}

	if ( $fonts ) {
		$fonts_url = add_query_arg( array(
			'family' => urlencode( implode( '|', $fonts ) ),
			'subset' => urlencode( $subsets ),
		), 'https://fonts.googleapis.com/css' );
	}

	return $fonts_url;
}

/**
 * Enqueue scripts and styles.
 */
function unisco_scripts() {
	wp_enqueue_style( 'unisco-google-fonts', unisco_fonts_url(), false, '1.0.0' );

	wp_enqueue_style( 'unisco-bootstrap', get_theme_file_uri( '/css/bootstrap.min.css' ), false, '4.0.0' );

	wp_enqueue_style( 'unisco-simple-line-icons', get_theme_file_uri( '/css/simple-line-icons.css' ), false, '2.4.0' );

	wp_enqueue_style( 'unisco-font-awesome', get_theme_file_uri( '/css/font-awesome.min.css' ), false, '4.7.0' );

	wp_enqueue_style( 'unisco-style', get_stylesheet_uri(), false, '1.0.0' );

	wp_enqueue_script( 'unisco-tether', get_theme_file_uri( '/js/tether.min.js' ), array( 'jquery' ), '1.3.3', true );

	wp_enqueue_script( 'unisco-bootstrap', get_theme_file_uri( '/js/bootstrap.min.js' ), array( 'jquery' ), '4.0.0', true );

	wp_enqueue_script( 'unisco-skip-link-focus-fix', get_theme_file_uri( '/js/skip-link-focus-fix.js' ), array(), '1.0', true );

	wp_enqueue_script( 'unisco-script', get_theme_file_uri( '/js/scripts.js' ), array(), '1.0.0', true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}

add_action( 'wp_enqueue_scripts', 'unisco_scripts' );

/**
 * Developer hooks.
 */
require get_template_directory() . '/inc/hooks.php';

/**
 * Developer filters.
 */
require get_template_directory() . '/inc/filters.php';

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
 * Custom menu walker class.
 */
require get_template_directory() . '/inc/bs4Navwalker.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Load Jetpack compatibility file.
 */
require get_template_directory() . '/inc/jetpack.php';

/**
 * Additional features to allow styling of the templates.
 */
require get_template_directory() . '/inc/template-functions.php';