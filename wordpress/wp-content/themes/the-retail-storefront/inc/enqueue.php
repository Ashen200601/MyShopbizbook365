<?php

// Load the JS and CSS.
add_action( 'customize_controls_enqueue_scripts', function() {

	$version = wp_get_theme()->get( 'Version' );

	wp_enqueue_script(
		'the-retail-storefront-customize-section-button',
		get_theme_file_uri( 'assets/js/customize-controls.js' ),
		[ 'customize-controls' ],
		$version,
		true
	);
	wp_localize_script(
		'the-retail-storefront-customize-section-button',
		'the_retail_storefront_customizer_params',
		array(
			'ajaxurl' =>	admin_url( 'admin-ajax.php' )
		)
	);

	wp_enqueue_style(
		'the-retail-storefront-customize-section-button',
		get_theme_file_uri( 'assets/css/customize-controls.css' ),
		[ 'customize-controls' ],
 		$version
	);

} );

 /**
 * Enqueue scripts and styles.
 */
function the_retail_storefront_scripts() {
	
	// Styles	 

	wp_enqueue_style('all-min',get_template_directory_uri().'/assets/css/all.min.css');
	
	wp_enqueue_style('owl-carousel-min',get_template_directory_uri().'/assets/css/owl.carousel.min.css');

	wp_enqueue_style('bootstrap-min',get_template_directory_uri().'/assets/css/bootstrap.min.css');

	wp_enqueue_style( 'font-awesome', get_template_directory_uri().'/assets/css/fontawesome-all.css' );
	
	wp_enqueue_style('the-retail-storefront-editor-style',get_template_directory_uri().'/assets/css/editor-style.css');

	wp_enqueue_style('the-retail-storefront-main', get_template_directory_uri() . '/assets/css/main.css');

	wp_enqueue_style('the-retail-storefront-woo', get_template_directory_uri() . '/assets/css/woo.css');
	
	wp_enqueue_style( 'the-retail-storefront-style', get_stylesheet_uri() );

    wp_enqueue_style('the-retail-storefront-main', get_stylesheet_uri(), array() );
		wp_style_add_data('the-retail-storefront-main', 'rtl', 'replace');
	
	// Scripts

	wp_enqueue_script('bootstrap', get_template_directory_uri() . '/assets/js/bootstrap.bundle.min.js', array('jquery'), false, true);

	wp_enqueue_script('the-retail-storefront-theme-js', get_template_directory_uri() . '/assets/js/theme.js', array('jquery'), false, true);

	wp_enqueue_script('owl-carousel', get_template_directory_uri() . '/assets/js/owl.carousel.min.js', array('jquery'), false, true);

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'the_retail_storefront_scripts' );


// Function to enqueue custom CSS
function the_retail_storefront_enqueue_custom_css() {
    // Define a unique handle for your inline stylesheet
    $handle = 'the-retail-storefront-style';
    
    // Get the generated custom CSS
    $the_retail_storefront_custom_css = "";

    $the_retail_storefront_blog_layouts = get_theme_mod('the_retail_storefront_blog_layout_option_setting', 'Default');
    if ($the_retail_storefront_blog_layouts == 'Default') {
        $the_retail_storefront_custom_css .= '.blog-item{';
        $the_retail_storefront_custom_css .= 'text-align:center;';
        $the_retail_storefront_custom_css .= '}';
    } elseif ($the_retail_storefront_blog_layouts == 'Left') {
        $the_retail_storefront_custom_css .= '.blog-item{';
        $the_retail_storefront_custom_css .= 'text-align:Left;';
        $the_retail_storefront_custom_css .= '}';
    } elseif ($the_retail_storefront_blog_layouts == 'Right') {
        $the_retail_storefront_custom_css .= '.blog-item{';
        $the_retail_storefront_custom_css .= 'text-align:Right;';
        $the_retail_storefront_custom_css .= '}';
    }

    // Enqueue the inline stylesheet
    wp_add_inline_style($handle, $the_retail_storefront_custom_css);

    // Add inline style for Scroll to Top
    $the_retail_storefront_scroll_top_bg_color = get_theme_mod('the_retail_storefront_scroll_top_bg_color', '#FE816D');
    $the_retail_storefront_scroll_top_color = get_theme_mod('the_retail_storefront_scroll_top_color', '#fff');

    // Use global if still default
    if ( $the_retail_storefront_scroll_top_bg_color === '#FE816D' ) {
        $the_retail_storefront_scroll_top_bg_color = get_theme_mod('the_retail_storefront_dynamic_color_one');
    }

    $the_retail_storefront_scroll_custom_css = "
        #scrolltop {
            background-color: {$the_retail_storefront_scroll_top_bg_color};
        }
        #scrolltop span {
            color: {$the_retail_storefront_scroll_top_color};
        }
    ";
    wp_add_inline_style('the-retail-storefront-style', $the_retail_storefront_scroll_custom_css);

    // Add inline style for Preloader
    $the_retail_storefront_preloader_bg_color = get_theme_mod('the_retail_storefront_preloader_bg_color', '#ffffff');
    $the_retail_storefront_preloader_color = get_theme_mod('the_retail_storefront_preloader_color', '#FE816D');

    // Use global if still default
    if ( $the_retail_storefront_preloader_color === '#FE816D' ) {
        $the_retail_storefront_preloader_color = get_theme_mod('the_retail_storefront_dynamic_color_one');
    }

    $the_retail_storefront_preloader_custom_css = "
        .loading {
            background-color: {$the_retail_storefront_preloader_bg_color};
        }
        .loader {
            border-color: {$the_retail_storefront_preloader_color};
            color: {$the_retail_storefront_preloader_color};
            text-shadow: 0 0 10px {$the_retail_storefront_preloader_color};
        }
        .loader::before {
            border-top-color: {$the_retail_storefront_preloader_color};
            border-right-color: {$the_retail_storefront_preloader_color};
        }
        .loader span::before {
            background: {$the_retail_storefront_preloader_color};
            box-shadow: 0 0 10px {$the_retail_storefront_preloader_color};
        }
    ";
    wp_add_inline_style('the-retail-storefront-style', $the_retail_storefront_preloader_custom_css);

}

// Hook the function to the 'wp_enqueue_scripts' action
add_action('wp_enqueue_scripts', 'the_retail_storefront_enqueue_custom_css');