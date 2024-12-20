<?php
/**
 * Theme functions and definitions.
 *
 * @link https://codex.wordpress.org/Functions_File_Explained
 *
 * @package Clean_Commerce
 */

if ( ! function_exists( 'clean_commerce_setup' ) ) :
	/**
	 * Sets up theme defaults and registers support for various WordPress features.
	 *
	 * Note that this function is hooked into the after_setup_theme hook, which
	 * runs before the init hook. The init hook is too late for some features, such
	 * as indicating support for post thumbnails.
	 */
	function clean_commerce_setup() {

		// Make theme available for translation.
		load_theme_textdomain( 'clean-commerce', get_template_directory() . '/languages' );

		// Add default posts and comments RSS feed links to head.
		add_theme_support( 'automatic-feed-links' );

		// Let WordPress manage the document title.
		add_theme_support( 'title-tag' );

		// Enable support for Post Thumbnails on posts and pages.
		add_theme_support( 'post-thumbnails' );
		add_image_size( 'clean-commerce-carousel', 400, 400, true );

		// Register menu locations.
		register_nav_menus( array(
			'primary'  => esc_html__( 'Primary Menu', 'clean-commerce' ),
			'header'   => esc_html__( 'Header Menu', 'clean-commerce' ),
			'social'   => esc_html__( 'Social Menu', 'clean-commerce' ),
			'notfound' => esc_html__( '404 Menu', 'clean-commerce' ),
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
		add_theme_support( 'custom-background', apply_filters( 'clean_commerce_custom_background_args', array(
			'default-color' => 'FFFFFF',
			'default-image' => '',
		) ) );

		// Enable support for selective refresh of widgets in Customizer.
		add_theme_support( 'customize-selective-refresh-widgets' );

		// Enable support for custom logo.
		add_theme_support( 'custom-logo' );

		add_theme_support( 'wp-block-styles' );

		// Add support for editor styles.
		add_theme_support( 'editor-styles' );

		// Add support for full and wide align images.
		add_theme_support( 'align-wide' );

		// Add support for responsive embeds.
		add_theme_support( 'responsive-embeds' );

		// Add custom editor font sizes.
		add_theme_support(
			'editor-font-sizes',
			array(
				array(
					'name'      => esc_html__( 'Small', 'clean-commerce' ),
					'shortName' => esc_html__( 'S', 'clean-commerce' ),
					'size'      => 13,
					'slug'      => 'small',
				),
				array(
					'name'      => esc_html__( 'Normal', 'clean-commerce' ),
					'shortName' => esc_html__( 'M', 'clean-commerce' ),
					'size'      => 16,
					'slug'      => 'normal',
				),
				array(
					'name'      => esc_html__( 'Large', 'clean-commerce' ),
					'shortName' => esc_html__( 'L', 'clean-commerce' ),
					'size'      => 42,
					'slug'      => 'large',
				),
				array(
					'name'      => esc_html__( 'Huge', 'clean-commerce' ),
					'shortName' => esc_html__( 'XL', 'clean-commerce' ),
					'size'      => 56,
					'slug'      => 'huge',
				),
			)
		);

		// Add support for custom color scheme.
		add_theme_support( 'editor-color-palette', array(
			array(
				'name'  => esc_html__( 'White', 'clean-commerce' ),
				'slug'  => 'white',
				'color' => '#ffffff',
			),
			array(
				'name'  => esc_html__( 'Black', 'clean-commerce' ),
				'slug'  => 'black',
				'color' => '#111111',
			),
			array(
				'name'  => esc_html__( 'Gray', 'clean-commerce' ),
				'slug'  => 'gray',
				'color' => '#f4f4f4',
			),
			array(
				'name'  => esc_html__( 'Yellow', 'clean-commerce' ),
				'slug'  => 'yellow',
				'color' => '#ff7d06',
			),
			array(
				'name'  => esc_html__( 'Blue', 'clean-commerce' ),
				'slug'  => 'blue',
				'color' => '#1b8be0',
			),

			array(
				'name'  => esc_html__( 'Red Orange', 'clean-commerce' ),
				'slug'  => 'red-orange',
				'color' => '#ff4922',
			),
		) );

		// Enable support for footer widgets.
		add_theme_support( 'footer-widgets', 4 );

		// Enable support for WooCommerce.
		add_theme_support( 'woocommerce' );
		add_theme_support( 'wc-product-gallery-lightbox' );

		// Load Supports.
		require_once get_template_directory() . '/inc/support.php';

	}
endif;

add_action( 'after_setup_theme', 'clean_commerce_setup' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function clean_commerce_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'clean_commerce_content_width', 640 );
}
add_action( 'after_setup_theme', 'clean_commerce_content_width', 0 );

/**
 * Register widget area.
 */
function clean_commerce_widgets_init() {
	register_sidebar( array(
		'name'          => esc_html__( 'Primary Sidebar', 'clean-commerce' ),
		'id'            => 'sidebar-1',
		'description'   => esc_html__( 'Add widgets here to appear in your Primary Sidebar.', 'clean-commerce' ),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );
}
add_action( 'widgets_init', 'clean_commerce_widgets_init' );

/**
 * Enqueue scripts and styles.
 */
function clean_commerce_scripts() {

	$min = defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ? '' : '.min';

	wp_enqueue_style( 'font-awesome', get_template_directory_uri() . '/third-party/font-awesome/css/font-awesome' . $min . '.css', '', '4.7.0' );

	$fonts_url = clean_commerce_fonts_url();
	if ( ! empty( $fonts_url ) ) {
		wp_enqueue_style( 'clean-commerce-google-fonts', $fonts_url, array(), null );
	}

	wp_enqueue_style( 'jquery-sidr', get_template_directory_uri() . '/third-party/sidr/css/jquery.sidr.dark' . $min . '.css', '', '2.2.1' );

	wp_enqueue_style( 'jquery-slick', get_template_directory_uri() . '/third-party/slick/slick' . $min . '.css', '', '1.6.0' );

	wp_enqueue_style( 'clean-commerce-style', get_stylesheet_uri(), null, date( 'Ymd-Gis', filemtime( get_template_directory() . '/style.css' ) ) );

	// Theme block stylesheet.
	wp_enqueue_style( 'clean-commerce-block-style', get_theme_file_uri( 'css/blocks.css' ), array( 'clean-commerce-style' ), filemtime( get_template_directory() . '/css/blocks.css' ) );

	wp_enqueue_script( 'clean-commerce-skip-link-focus-fix', get_template_directory_uri() . '/js/skip-link-focus-fix' . $min . '.js', array(), '20130115', true );

	wp_enqueue_script( 'jquery-sidr', get_template_directory_uri() . '/third-party/sidr/js/jquery.sidr' . $min . '.js', array( 'jquery' ), '2.2.1', true );

	wp_enqueue_script( 'jquery-slick', get_template_directory_uri() . '/third-party/slick/slick' . $min . '.js', array( 'jquery' ), '1.6.0', true );

	wp_enqueue_script( 'clean-commerce-custom', get_template_directory_uri() . '/js/custom' . $min . '.js', array( 'jquery' ), '1.0.1', true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'clean_commerce_scripts' );

/**
 * Enqueue editor styles for Gutenberg
 */
function clean_commerce_block_editor_styles() {
	// Block styles.
	wp_enqueue_style( 'clean-commerce-block-editor-style', get_theme_file_uri( 'css/editor-blocks.css' ) );

	// Add custom fonts.
	wp_enqueue_style( 'clean-commerce-fonts', clean_commerce_fonts_url(), array(), null );
}
add_action( 'enqueue_block_editor_assets', 'clean_commerce_block_editor_styles' );

/**
 * Enqueue admin scripts and styles.
 */
function clean_commerce_admin_scripts( $hook ) {

	$min = defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ? '' : '.min';

	if ( in_array( $hook, array( 'post.php', 'post-new.php' ) ) ) {
		wp_enqueue_style( 'clean-commerce-metabox', get_template_directory_uri() . '/css/metabox' . $min . '.css', '', '1.0.0' );
		wp_enqueue_script( 'clean-commerce-custom-admin', get_template_directory_uri() . '/js/admin' . $min . '.js', array( 'jquery', 'jquery-ui-core', 'jquery-ui-tabs' ), '1.0.0', true );
	}

	if ( 'widgets.php' === $hook ) {
		wp_enqueue_style( 'wp-color-picker' );
	    wp_enqueue_script( 'wp-color-picker' );
	    wp_enqueue_media();
		wp_enqueue_style( 'clean-commerce-custom-widgets-style', get_template_directory_uri() . '/css/widgets' . $min . '.css', array(), '1.0.0' );
		wp_enqueue_script( 'clean-commerce-custom-widgets', get_template_directory_uri() . '/js/widgets' . $min . '.js', array( 'jquery' ), '1.0.0', true );
	}

}
add_action( 'admin_enqueue_scripts', 'clean_commerce_admin_scripts' );

/**
 * Load init.
 */
require_once get_template_directory() . '/inc/init.php';
