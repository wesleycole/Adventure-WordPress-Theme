<?php
/**
 * flatness_factor functions and definitions
 *
 * @package flatness_factor
 */

/**
 * Set the content width based on the theme's design and stylesheet.
 */
if ( ! isset( $content_width ) )
	$content_width = 640; /* pixels */

if ( ! function_exists( 'flatness_factor_setup' ) ) :
/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which runs
 * before the init hook. The init hook is too late for some features, such as indicating
 * support post thumbnails.
 */
function flatness_factor_setup() {

	/**
	 * Make theme available for translation
	 * Translations can be filed in the /languages/ directory
	 * If you're building a theme based on flatness_factor, use a find and replace
	 * to change 'flatness_factor' to the name of your theme in all the template files
	 */
	load_theme_textdomain( 'flatness_factor', get_template_directory() . '/languages' );

	/**
	 * Add default posts and comments RSS feed links to head
	 */
	add_theme_support( 'automatic-feed-links' );

	/**
	 * Enable support for Post Thumbnails on posts and pages
	 *
	 * @link http://codex.wordpress.org/Function_Reference/add_theme_support#Post_Thumbnails
	 */
	//add_theme_support( 'post-thumbnails' );

	/**
	 * This theme uses wp_nav_menu() in one location.
	 */
	register_nav_menus( array(
		'primary' => __( 'Primary Menu', 'flatness_factor' ),
	) );

	/**
	 * Enable support for Post Formats
	 */
	add_theme_support( 'post-formats', array( 'aside', 'image', 'video', 'quote', 'link' ) );

	/**
	 * Setup the WordPress core custom background feature.
	 */
	add_theme_support( 'custom-background', apply_filters( 'flatness_factor_custom_background_args', array(
		'default-color' => 'ffffff',
		'default-image' => '',
	) ) );
}
endif; // flatness_factor_setup
add_action( 'after_setup_theme', 'flatness_factor_setup' );

/**
 * Register widgetized area and update sidebar with default widgets
 */
function flatness_factor_widgets_init() {
	register_sidebar( array(
		'name'          => __( 'Sidebar', 'flatness_factor' ),
		'id'            => 'sidebar-1',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h1 class="widget-title">',
		'after_title'   => '</h1>',
	) );
}
add_action( 'widgets_init', 'flatness_factor_widgets_init' );

/**
 * Enqueue scripts and styles
 */

if (!is_admin()) add_action("wp_enqueue_scripts", "my_jquery_enqueue", 11);
function my_jquery_enqueue() {
   wp_deregister_script('jquery');
   wp_register_script('jquery', "http" . ($_SERVER['SERVER_PORT'] == 443 ? "s" : "") . "://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js", false, null);
   wp_enqueue_script('jquery', '', '', array(), '20130819', true );
}

function flatness_factor_scripts() {
	wp_enqueue_style( 'flatness_factor-style', get_stylesheet_uri() );

	wp_enqueue_script( 'flatness_factor-navigation', get_template_directory_uri() . '/js/navigation.js', array(), '20120206', true );

	wp_enqueue_script( 'flatness_factor-skip-link-focus-fix', get_template_directory_uri() . '/js/skip-link-focus-fix.js', array(), '20130115', true );
	
	wp_enqueue_script( 'flatness_factor_jqslide', get_template_directory_uri() . '/js/jquery.pageslide.min.js', array( 'jquery' ), '20130817', true );

	wp_enqueue_script( 'flatness_factor_main', get_template_directory_uri() . '/js/main.js', array( 'jquery' ), '20130817', true );
	

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}

	if ( is_singular() && wp_attachment_is_image() ) {
		wp_enqueue_script( 'flatness_factor-keyboard-image-navigation', get_template_directory_uri() . '/js/keyboard-image-navigation.js', array( 'jquery' ), '20120202' );
	}
}
add_action( 'wp_enqueue_scripts', 'flatness_factor_scripts' );

function add_pageslide_script() {?>
	<script>
	    $(".menu-toggle").pageslide({ direction: "right", modal: true });
	</script>
<?php }

add_action( 'wp_footer', 'add_pageslide_script', 100 );

function theme_styles()  
{ 
  // Register the style like this for a theme:  
  // (First the unique name for the style (custom-style) then the src, 
  // then dependencies and ver no. and media type)
  wp_register_style( 'pageslide-style', 
    get_template_directory_uri() . '/vendor_css/jquery.pageslide.css', 
    array(), 
    '20120208', 
    'all' );

  // enqueing:
  wp_enqueue_style( 'pageslide-style' );
}
add_action('wp_enqueue_scripts', 'theme_styles');

class Arrow_Walker_Nav_Menu extends Walker_Nav_Menu {
    function display_element($element, &$children_elements, $max_depth, $depth=0, $args, &$output) {
        $id_field = $this->db_fields['id'];
        if (!empty($children_elements[$element->$id_field])) {
            $element->classes[] = 'has-submenu'; //CSS classname here
            $element->title .= '<i class="icon-chevron-down"></i>'; //append html here
        }
        Walker_Nav_Menu::display_element($element, $children_elements, $max_depth, $depth, $args, $output);
    }
}

/**
 * Add Featured Image Support
 */

add_theme_support('post-thumbnails');
set_post_thumbnail_size( 150, 150 );

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
 * Home Bottom Sidebar 
 */
require get_template_directory() . '/inc/home-sidebar.php';
