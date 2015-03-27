<?php
/**
 * e_shopper setup functions
 *
 * @package e_shopper
 */

/**
 * Set the content width based on the theme's design and stylesheet.
 */
if ( ! isset( $content_width ) ) {
	$content_width = 654; /* pixels */
}

// Define path
define('THEMECSS', get_template_directory_uri().'/css/');
define('THEMEJS', get_template_directory_uri().'/js/');

if ( ! function_exists( 'e_shopper_setup' ) ) :
	/**
	 * Sets up theme defaults and registers support for various WordPress features.
	 *
	 * Note that this function is hooked into the after_setup_theme hook, which
	 * runs before the init hook. The init hook is too late for some features, such
	 * as indicating support for post thumbnails.
	 */
	function e_shopper_setup() {

		/*
		 * Load Localisation files.
		 *
		 * Note: the first-loaded translation file overrides any following ones if the same translation is present.
		 */

		// wp-content/languages/theme-name/it_IT.mo
		load_theme_textdomain( 'e_shopper', trailingslashit( WP_LANG_DIR ) . 'themes/' );

		// wp-content/themes/child-theme-name/languages/it_IT.mo
		load_theme_textdomain( 'e_shopper', get_stylesheet_directory() . '/languages' );

		// wp-content/themes/theme-name/languages/it_IT.mo
		load_theme_textdomain( 'e_shopper', get_template_directory() . '/languages' );

		/**
		 * Add default posts and comments RSS feed links to head.
		 */
		add_theme_support( 'automatic-feed-links' );

		/*
		 * Enable support for Post Thumbnails on posts and pages.
		 *
		 * @link http://codex.wordpress.org/Function_Reference/add_theme_support#Post_Thumbnails
		 */
		add_theme_support( 'post-thumbnails' );

		// This theme uses wp_nav_menu() in two locations.
		register_nav_menus( array(
			'primary'		=> __( 'Primary Menu', 'e_shopper' ),
		) );

		/*
		 * Switch default core markup for search form, comment form, and comments
		 * to output valid HTML5.
		 */
		add_theme_support( 'html5', array(
			'search-form', 'comment-form', 'comment-list', 'gallery', 'caption',
		) );

		// Setup the WordPress core custom background feature.
		add_theme_support( 'custom-background', apply_filters( 'e_shopper_custom_background_args', array(
			'default-color' => apply_filters( 'storefront_default_background_color', 'fcfcfc' ),
			'default-image' => '',
		) ) );

		// Add support for the Site Logo plugin and the site logo functionality in JetPack
		// https://github.com/automattic/site-logo
		// http://jetpack.me/
		add_theme_support( 'site-logo', array( 'size' => 'full' ) );

		// Declare WooCommerce support
		add_theme_support( 'woocommerce' );

		// Declare support for title theme feature
		add_theme_support( 'title-tag' );
	}
endif; // storefront_setup

add_action( 'after_setup_theme', 'e_shopper_setup' );

// Automatic HomePage Publish
add_action('after_setup_theme', 'create_pages'); 

function create_pages(){
    $e_shopper_page_id = get_option("e_shopper_page_id");
    if (!$e_shopper_page_id) {
        //create a new page and automatically assign the page template
        $post = array(
            'post_title' => "HomePage",
            'post_content' => "",
            'post_status' => "publish",
            'post_type' => 'page',
        );
        $postID = wp_insert_post($post, $error);
        update_post_meta($postID, "_wp_page_template", "front-page.php");
        update_option("e_shopper_page_id", $postID);
    }
}

/**
 * Register widget area.
 *
 * @link http://codex.wordpress.org/Function_Reference/register_sidebar
 */
function e_shopper_widgets_init() {
	register_sidebar( array(
		'name'          => __( 'Sidebar', 'e_shopper' ),
		'id'            => 'sidebar-1',
		'description'   => '',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h1 class="widget-title">',
		'after_title'   => '</h1>',
	) );

	register_sidebar( array(
		'name'          => __( 'Footer Sidebar 1', 'e_shopper' ),
		'id'            => 'footer-1',
		'description'   => '',
		'before_widget' => '<div id="%1$s" class="single-widget widget %2$s">',
		'after_widget'  => '</div>',
		'before_title'  => '<h2>',
		'after_title'   => '</h2>',
	) );

	register_sidebar( array(
		'name'          => __( 'Footer Sidebar 2', 'e_shopper' ),
		'id'            => 'footer-2',
		'description'   => '',
		'before_widget' => '<div id="%1$s" class="single-widget widget %2$s">',
		'after_widget'  => '</div>',
		'before_title'  => '<h2>',
		'after_title'   => '</h2>',
	) );

	register_sidebar( array(
		'name'          => __( 'Footer Sidebar 3', 'e_shopper' ),
		'id'            => 'footer-3',
		'description'   => '',
		'before_widget' => '<div id="%1$s" class="single-widget widget %2$s">',
		'after_widget'  => '</div>',
		'before_title'  => '<h2>',
		'after_title'   => '</h2>',
	) );

	register_sidebar( array(
		'name'          => __( 'Footer Sidebar 4', 'e_shopper' ),
		'id'            => 'footer-4',
		'description'   => '',
		'before_widget' => '<div id="%1$s" class="single-widget widget %2$s">',
		'after_widget'  => '</div>',
		'before_title'  => '<h2>',
		'after_title'   => '</h2>',
	) );

}
add_action( 'widgets_init', 'e_shopper_widgets_init' );

/**
 * Enqueue scripts and styles.
 * @since  1.0.1
 */
function e_shopper_scripts() {

	wp_enqueue_style( 'e_shopper_style', get_stylesheet_uri() );
	wp_enqueue_style( 'e_shopper_main', THEMECSS. 'main.css', array(), '1.0' );
	wp_enqueue_style( 'e_shopper_responsive', THEMECSS. 'responsive.css', array(), '1.0' );
	wp_enqueue_style( 'e_shopper_bootstrap', THEMECSS. 'bootstrap.min.css', array(), '3.0.3' );
	wp_enqueue_style( 'e_shopper_font-awesome', THEMECSS. 'font-awesome.min.css', array(), '4.0.3' );
	wp_enqueue_style( 'e_shopper_prettyPhoto', THEMECSS. 'prettyPhoto.css', array(), '1.0' );

	wp_enqueue_script( 'e_shopper_jquery', THEMEJS . 'jquery.js', array(), '1.10.2', true );
	wp_enqueue_script( 'e_shopper_main', THEMEJS . 'main.js', array(), '1.0', true );
	wp_enqueue_script( 'e_shopper_bootstrap', THEMEJS . 'bootstrap.min.js', array(), '3.0.3', true );
	wp_enqueue_script( 'e_shopper_gmaps', THEMEJS . 'gmaps.js', array(), '1.0', true );
	wp_enqueue_script( 'e_shopper_gmaps_sensor', 'http://maps.google.com/maps/api/js?sensor=true', array(), '1.0', true);
	wp_enqueue_script( 'e_shopper_prettyPhoto', THEMEJS . 'jquery.prettyPhoto.js', array(), '3.1.5', true );
	wp_enqueue_script( 'e_shopper_scrollUp', THEMEJS . 'jquery.scrollUp.min.js', array(), '2.3.3', true );
	wp_enqueue_script( 'e_shopper_contact', THEMEJS . 'contact.js', array(), '1.0', true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}

add_action( 'wp_enqueue_scripts', 'e_shopper_scripts' );

/**
 * Fucking IE Fix
 * @since  1.0.0
 */
function e_shopper_fucking_ie_fix() {

    echo '<!--[if lt IE 9]>';

    echo '<script type="text/javascript" src="' . THEMEJS . 'html5shiv.js?ver=3.6.2"></script>';
    echo '<script type="text/javascript" src="' . THEMEJS . 'respond.min.js?ver=1.4.2"></script>';
    echo '<![endif]-->';    
}

add_action('wp_head', 'e_shopper_fucking_ie_fix'); 


// Handle cart in header fragment for ajax add to cart
add_filter('add_to_cart_fragments', 'header_add_to_cart_fragment');
function header_add_to_cart_fragment( $fragments ) {
	global $woocommerce;

	ob_start();

	woocommerce_cart_link();

	$fragments['a.cart-button'] = ob_get_clean();

	return $fragments;

}

function woocommerce_cart_link() {
	global $woocommerce;
	?>
	
	<a class="cart-button " title="<?php echo sprintf(_n('%d item', '%d items', $woocommerce->cart->cart_contents_count, 'woothemes'), $woocommerce->cart->cart_contents_count);?> <?php _e('in your shopping cart', 'woothemes'); ?>" href="<?php echo $woocommerce->cart->get_cart_url(); ?>"><i class="fa fa-shopping-cart"></i> Cart - <span class="cart-amunt"><?php echo $woocommerce->cart->get_cart_total();  ?></span> <span class="product-count"><?php echo sprintf(_n('%d', '%d', $woocommerce->cart->cart_contents_count, 'woothemes'), $woocommerce->cart->cart_contents_count); ?></span></a>
	
	<?php
}

add_filter( 'widget_meta', 'wpse_76521_filter_blogroll' );

function wpse_76521_filter_blogroll( $args )
{
    $li_start = isset ( $args['before'] ) ? $args['before'] : '<li>';
    $args['before'] = $li_start . '<i class="icon-ok"></i>';
    return $args;
}