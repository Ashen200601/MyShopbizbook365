<?php
if ( ! function_exists( 'the_retail_storefront_setup' ) ) :
function the_retail_storefront_setup() {

// Root path/URI.
define( 'THE_RETAIL_STOREFRONT_PARENT_DIR', get_template_directory() );
define( 'THE_RETAIL_STOREFRONT_PARENT_URI', get_template_directory_uri() );

// Root path/URI.
define( 'THE_RETAIL_STOREFRONT_PARENT_INC_DIR', THE_RETAIL_STOREFRONT_PARENT_DIR . '/inc');
define( 'THE_RETAIL_STOREFRONT_PARENT_INC_URI', THE_RETAIL_STOREFRONT_PARENT_URI . '/inc');

	// Add default posts and comments RSS feed links to head.
load_theme_textdomain('the-retail-storefront', get_template_directory() . '/languages');
	add_theme_support( 'automatic-feed-links' );
	add_theme_support( 'wc-product-gallery-zoom' );
	add_theme_support( 'wc-product-gallery-slider' );

	/*
	 * Let WordPress manage the document title.
	 */
	add_theme_support( 'title-tag' );

	add_theme_support( 'responsive-embeds' );
	
	/*
	 * Enable support for Post Thumbnails on posts and pages.
	 */
	add_theme_support( 'post-thumbnails' );
	
	//Add selective refresh for sidebar widget
	add_theme_support( 'customize-selective-refresh-widgets' );
	
	/*
	 * Make theme available for translation.
	 */
	load_theme_textdomain( 'the-retail-storefront', get_stylesheet_directory() . '/languages' );
		
	// This theme uses wp_nav_menu() in one location.
	register_nav_menus( array(
		'primary'  => esc_html__( 'Primary Menu', 'the-retail-storefront' ),
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
		
	add_theme_support('custom-logo');

	/*
	 * WooCommerce Plugin Support
	 */
	add_theme_support( 'woocommerce' );
	
	// Gutenberg wide images.
	add_theme_support( 'align-wide' );
	
	/*
	 * This theme styles the visual editor to resemble the theme style,
	 * specifically font, colors, icons, and column width.
	 */
	add_editor_style( array( 'assets/css/editor-style.css', the_retail_storefront_google_font_url() ) );
	
	//Set up the WordPress core custom background feature.
	add_theme_support( 'custom-background', apply_filters( 'the_retail_storefront_custom_background_args', array(
		'default-color' => 'ffffff',
		'default-image' => '',
	) ) );

    add_theme_support( 'custom-header', apply_filters( 'the_retail_storefront_custom_header_args', array(
		'default-image'          => get_template_directory_uri() . '/assets/images/Product-Title-Here-1.png',
		'default-text-color'     => 'ffffff',
		'width'                  => 2000, 
		'height'                 => 200,
		'flex-width'    		 => true,
		'flex-height'    		 => true,
        'uploads'            => true,
	)));


    /*
    * Enable support for Post Formats.
    *
    * See: https://codex.wordpress.org/Post_Formats
    */
    add_theme_support( 'post-formats', array('image','video','gallery','audio',) );


    //  --------------------------------------------- ENQUEUE ----------------------------------------------------- //

    /**
     * Implement the Custom Header feature.
     */
    require_once get_template_directory() . '/inc/custom-header.php';

    /**
     * Demo Import
     */
    require get_parent_theme_file_path( '/demo-import/demo-import-settings.php' );

    	if ( ! defined( 'THE_RETAIL_STOREFRONT_FREE_THEME_URL' ) ) {
		define( 'THE_RETAIL_STOREFRONT_FREE_THEME_URL', 'https://www.seothemesexpert.com/products/free-storefront-wordpress-theme' );
	}
	if ( ! defined( 'THE_RETAIL_STOREFRONT_PRO_THEME_URL' ) ) {
		define( 'THE_RETAIL_STOREFRONT_PRO_THEME_URL', 'https://www.seothemesexpert.com/products/storefront-website-template' );
	}
	if ( ! defined( 'THE_RETAIL_STOREFRONT_FREE_DOCS_THEME_URL' ) ) {
		define( 'THE_RETAIL_STOREFRONT_FREE_DOCS_THEME_URL', 'https://demo.seothemesexpert.com/documentation/retail-storefront/' );
	}
	if ( ! defined( 'THE_RETAIL_STOREFRONT_DEMO_THEME_URL' ) ) {
		define( 'THE_RETAIL_STOREFRONT_DEMO_THEME_URL', 'https://demo.seothemesexpert.com/retail-storefront/' );
	}
	if ( ! defined( 'THE_RETAIL_STOREFRONT_RATE_THEME_URL' ) ) {
		define( 'THE_RETAIL_STOREFRONT_RATE_THEME_URL', 'https://wordpress.org/support/theme/the-retail-storefront/reviews/#new-post' );
	}
	if ( ! defined( 'THE_RETAIL_STOREFRONT_SUPPORT_THEME_URL' ) ) {
		define( 'THE_RETAIL_STOREFRONT_SUPPORT_THEME_URL', 'https://wordpress.org/support/theme/the-retail-storefront/' );
	}
	if ( ! defined( 'THE_RETAIL_STOREFRONT_THEME_BUNDLE_URL' ) ) {
		define( 'THE_RETAIL_STOREFRONT_THEME_BUNDLE_URL', 'https://www.seothemesexpert.com/products/wordpress-theme-bundle' );
	}
    if ( ! defined( 'THE_RETAIL_STOREFRONT_DEMO_IMPORT_URL' ) ) {
        define( 'THE_RETAIL_STOREFRONT_DEMO_IMPORT_URL', esc_url( admin_url( 'themes.php?page=theretailstorefront-wizard' ) ) );
    }

}
endif;
add_action( 'after_setup_theme', 'the_retail_storefront_setup' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function the_retail_storefront_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'the_retail_storefront_content_width', 1170 );
}
add_action( 'after_setup_theme', 'the_retail_storefront_content_width', 0 );


/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */

function the_retail_storefront_widgets_init() {
	
	register_sidebar( array(
		'name' => __( 'Sidebar Widget Area', 'the-retail-storefront' ),
		'id' => 'the-retail-storefront-sidebar-primary',
		'description' => __( 'The Primary Widget Area', 'the-retail-storefront' ),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget' => '</aside>',
		'before_title' => '<h4 class="widget-title">',
		'after_title' => '</h4><div class="title"><span class="shap"></span></div>',
	) );
	
	register_sidebar( array(
		'name' => __( 'Footer Widget Area', 'the-retail-storefront' ),
		'id' => 'the-retail-storefront-footer-widget-area',
		'description' => __( 'The Footer Widget Area', 'the-retail-storefront' ),
		'before_widget' => '<div class="footer-widget col-lg-3 col-sm-6 wow fadeIn" data-wow-delay="0.2s"><aside id="%1$s" class="widget %2$s">',
		'after_widget' => '</aside></div>',
		'before_title' => '<h5 class="widget-title w-title">',
		'after_title' => '</h5><span class="shap"></span>',
	) );
}
add_action( 'widgets_init', 'the_retail_storefront_widgets_init' );

/**
 * All Styles & Scripts.
 */

require_once get_template_directory() . '/inc/enqueue.php';

/**
 * Nav Walker fo Bootstrap Dropdown Menu.
 */

require_once get_template_directory() . '/inc/class-wp-bootstrap-navwalker.php';

/**
 * Custom template tags for this theme.
 */
require_once get_template_directory() . '/inc/template-tags.php';

/**
 * Custom functions that act independently of the theme templates.
 */
require_once get_template_directory() . '/inc/extras.php';

/**
 * Customizer additions.
 */
require_once get_template_directory() . '/inc/customizer.php';

require_once get_template_directory() . '/inc/fonts.php';

require_once get_template_directory() . '/wptt-webfont-loader.php';


/* Excerpt Limit Begin */
function the_retail_storefront_string_limit_words($the_retail_storefront_string, $the_retail_storefront_word_limit) {
    $the_retail_storefront_words = explode(' ', $the_retail_storefront_string, ($the_retail_storefront_word_limit + 1));
    if(count($the_retail_storefront_words) > $the_retail_storefront_word_limit)
    array_pop($the_retail_storefront_words);
    return implode(' ', $the_retail_storefront_words);
}

function the_retail_storefront_sanitize_select( $the_retail_storefront_input, $the_retail_storefront_setting ) {
	$the_retail_storefront_input = sanitize_key( $the_retail_storefront_input );
	$the_retail_storefront_choices = $the_retail_storefront_setting->manager->get_control( $the_retail_storefront_setting->id )->choices;
	return ( array_key_exists( $the_retail_storefront_input, $the_retail_storefront_choices ) ? $the_retail_storefront_input : $the_retail_storefront_setting->default );
}


function the_retail_storefront_sanitize_phone_number( $the_retail_storefront_phone ) {
	return preg_replace( '/[^\d+]/', '', $the_retail_storefront_phone );
}

// Sanitize the input
function the_retail_storefront_sanitize_sidebar_position( $the_retail_storefront_input ) {
    $the_retail_storefront_valid = array( 'right', 'left' );

    if ( in_array( $the_retail_storefront_input, $the_retail_storefront_valid ) ) {
        return $the_retail_storefront_input;
    } else {
        return 'right';
    }
}

function the_retail_storefront_custom_controls() {
	load_template( trailingslashit( get_template_directory() ) . '/inc/customizer/customizer-custom-controls.php' );
}
add_action( 'customize_register', 'the_retail_storefront_custom_controls' );

add_filter( 'nav_menu_link_attributes', 'the_retail_storefront_dropdown_data_attribute', 20, 3 );
/**
 * Use namespaced data attribute for Bootstrap's dropdown toggles.
 *
 * @param array    $atts HTML attributes applied to the item's `<a>` element.
 * @param WP_Post  $item The current menu item.
 * @param stdClass $args An object of wp_nav_menu() arguments.
 * @return array
 */
function the_retail_storefront_dropdown_data_attribute( $atts, $item, $args ) {
    if ( is_a( $args->walker, 'WP_Bootstrap_Navwalker' ) ) {
        if ( array_key_exists( 'data-toggle', $atts ) ) {
            unset( $atts['data-toggle'] );
            $atts['data-bs-toggle'] = 'dropdown';
        }
    }
    return $atts;
}

function the_retail_storefront_remove_theme_customizer_setting($wp_customize) {
    // Remove the setting
    $wp_customize->remove_setting('display_header_text');
    // Remove the control
    $wp_customize->remove_control('display_header_text');
}
add_action('customize_register', 'the_retail_storefront_remove_theme_customizer_setting', 20); 
// Use a priority greater than the one used for adding the setting


// Set the number of products per row to 3 on the shop page
add_filter('loop_shop_columns', 'the_retail_storefront_custom_shop_loop_columns');

if (!function_exists('the_retail_storefront_custom_shop_loop_columns')) {
    function the_retail_storefront_custom_shop_loop_columns() {
        // Retrieve the number of columns from theme customizer setting (default: 3)
        $the_retail_storefront_columns = get_theme_mod('the_retail_storefront_custom_shop_per_columns', 3);
        return $the_retail_storefront_columns;
    }
}

// Set the number of products per page on the shop page
add_filter('loop_shop_per_page', 'the_retail_storefront_custom_shop_per_page', 20);

if (!function_exists('the_retail_storefront_custom_shop_per_page')) {
    function the_retail_storefront_custom_shop_per_page($the_retail_storefront_products_per_page) {
        // Retrieve the number of products per page from theme customizer setting (default: 9)
        $the_retail_storefront_products_per_page = get_theme_mod('the_retail_storefront_custom_shop_product_per_page', 9);
        return $the_retail_storefront_products_per_page;
    }
}

function the_retail_storefront_customize_css() {
    $the_retail_storefront_dynamic_color = get_theme_mod( 'the_retail_storefront_dynamic_color_one', '#FE816D' );
    $the_retail_storefront_custom_css = ":root { --color-primary1: {$the_retail_storefront_dynamic_color}; }";
    wp_add_inline_style( 'the-retail-storefront-style', $the_retail_storefront_custom_css );
}
add_action( 'wp_enqueue_scripts', 'the_retail_storefront_customize_css' );

/**
 * Enqueue theme copyright alignment style.
 */
function the_retail_storefront_copyright_alignment_option() {
    // Get the alignment setting from the theme customizer.
    $the_retail_storefront_copyright_alignment = get_theme_mod('the_retail_storefront_copyright_alignment', 'center');

    // Start building the CSS string for the alignment.
    $the_retail_storefront_copyright_alignment_css = '
        .copyright-text, .footer-copyright, .footer-copyright a, p.copyright-text {
            text-align: ' . esc_attr($the_retail_storefront_copyright_alignment) . ';
        }
    ';

    // Add the inline style to the theme's main stylesheet.
    wp_add_inline_style('the-retail-storefront-style', $the_retail_storefront_copyright_alignment_css);
}

add_action('wp_enqueue_scripts', 'the_retail_storefront_copyright_alignment_option');

/**
 * Generate Google fonts URL.
 */
function the_retail_storefront_google_font_url() {
    $the_retail_storefront_font_family = array(
        'Inter:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900'
    );

    $the_retail_storefront_query_args = array(
        'family' => implode('|', $the_retail_storefront_font_family), // No need for rawurlencode in this case
        'display' => 'swap' // Add display=swap to improve loading performance
    );

    return esc_url(add_query_arg($the_retail_storefront_query_args, 'https://fonts.googleapis.com/css2')); // Use https://fonts.googleapis.com/css2 for variable fonts
}

/**
 * Enqueue theme styles and scripts.
 */

 function the_retail_storefront_scripts_styles() {
	$the_retail_storefront_headings_font = esc_html(get_theme_mod('the_retail_storefront_headings_text'));
	$the_retail_storefront_body_font = esc_html(get_theme_mod('the_retail_storefront_body_text'));

	if( $the_retail_storefront_headings_font ) {
		wp_enqueue_style( 'the-retail-storefront-headings-fonts', '//fonts.googleapis.com/css?family='. $the_retail_storefront_headings_font );
	} else {
		// Enqueue Google Fonts
        wp_enqueue_style('the-retail-storefront-google-fonts', the_retail_storefront_google_font_url(), array(), null);
	}
	if( $the_retail_storefront_body_font ) {
		wp_enqueue_style( 'the-retail-storefront-body-fonts', '//fonts.googleapis.com/css?family='. $the_retail_storefront_body_font );
	} else {
		// Enqueue other styles and scripts as needed
        wp_enqueue_style('the-retail-storefront-main-style', get_stylesheet_uri(), array(), '1.0.0');
        // Add more enqueuing here if needed
	}
}
add_action( 'wp_enqueue_scripts', 'the_retail_storefront_scripts_styles' );

// Helper function to get page ID by slug
function get_page_id_by_slug($the_retail_storefront_slug) {
    $the_retail_storefront_page = get_page_by_path($the_retail_storefront_slug); // Get the page by slug
    return $the_retail_storefront_page ? $the_retail_storefront_page->ID : 0;   // Return the page ID or 0 if not found
}

add_filter( 'woocommerce_enable_setup_wizard', '__return_false' );

// Show Admin Notice
function the_retail_storefront_promo_notice() {
    if (get_option('the_retail_storefront_notice_dismissed')) {
        return;
    }

    if (isset($_GET['page']) && in_array($_GET['page'], ['theretailstorefront-wizard'])) {
        return;
    }
    

    $the_retail_storefront_theme = wp_get_theme();
    $the_retail_storefront_theme_title = $the_retail_storefront_theme->get( 'Name' );
    $the_retail_storefront_theme_version = $the_retail_storefront_theme->get( 'Version' );

    ?>
    <div class="notice the-retail-storefront-notice is-dismissible">
        <div>
            <h3>
                <span><?php echo esc_html( '(Version: ' . $the_retail_storefront_theme_version . ')' ); ?></span><br>
                <?php esc_html_e( 'Thank you for choosing,', 'the-retail-storefront'); ?>
                <?php echo esc_html( $the_retail_storefront_theme_title ); ?> <?php esc_html_e( '!!!', 'the-retail-storefront'); ?>
            </h3>
            <p><?php esc_html_e( 'Welcome! You can now easily start building your website using our beautiful and user-friendly themes. No need to worry about setup — with our one-click demo importer, your site can look just like the demo in minutes. All the tools and information you need to get started are right here!', 'the-retail-storefront'); ?></p>
            <a class="button button-primary the-retail-storefront-buy-now" href="<?php echo esc_url( THE_RETAIL_STOREFRONT_DEMO_IMPORT_URL ); ?>" target="_blank">
                <?php esc_html_e( 'One Click Demo Import', 'the-retail-storefront') ?>
            </a>
            <a class="button button-primary the-retail-storefront-bundle-button" target="_blank" href="<?php echo esc_url( THE_RETAIL_STOREFRONT_THEME_BUNDLE_URL ); ?>">
                <?php echo esc_html__( 'Get All 50+ Themes @ $79', 'the-retail-storefront' ); ?>
            </a>
        </div>
        <div class="the-retail-storefront-image-wrap">
            <img src="<?php echo esc_url(get_stylesheet_directory_uri() . '/screenshot.png'); ?>">
        </div>
        <canvas id="the-retail-storefront-notice-confetti"></canvas>
    </div>
    <?php
}
add_action('admin_notices', 'the_retail_storefront_promo_notice');

add_action('wp_ajax_the_retail_storefront_dismiss_notice', 'the_retail_storefront_dismiss_notice');
function the_retail_storefront_dismiss_notice() {
    update_option('the_retail_storefront_notice_dismissed', true);
    wp_send_json_success();
}

add_action('after_switch_theme', 'the_retail_storefront_reset_notice_on_activation');
function the_retail_storefront_reset_notice_on_activation() {
    delete_option('the_retail_storefront_notice_dismissed');
}

function the_retail_storefront_enqueue_admin_assets() {
    wp_enqueue_script(
        'the-retail-storefront-confetti',
        get_template_directory_uri() . '/demo-import/assets/js/confetti/confetti.min.js',
        ['jquery'],
        null,
        true
    );

    wp_enqueue_script(
        'the-retail-storefront-notice-confetti-js',
        get_template_directory_uri() . '/demo-import/assets/js/plugin-update-notice.js',
        ['the-retail-storefront-confetti'],
        null,
        true
    );

    wp_enqueue_script(
        'the-retail-storefront-notice-dismiss',
        get_template_directory_uri() . '/demo-import/assets/js/notice-dismiss.js',
        ['jquery'],
        null,
        true
    );
}
add_action('admin_enqueue_scripts', 'the_retail_storefront_enqueue_admin_assets');