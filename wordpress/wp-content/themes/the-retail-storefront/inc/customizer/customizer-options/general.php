<?php
function the_retail_storefront_general_setting( $wp_customize ) {
    $selective_refresh = isset( $wp_customize->selective_refresh ) ? 'postMessage' : 'refresh';

    // Add General Panel
    $wp_customize->add_panel(
        'the_retail_storefront_general', array(
            'priority' => 2,
            'title' => esc_html__( 'General Options', 'the-retail-storefront' ),
        )
    );

    /*=========================================
    Breadcrumb Options
    =========================================*/
    $wp_customize->add_section(
        'the_retail_storefront_breadcrumb_setting', array(
            'title' => esc_html__( 'Breadcrumb Options', 'the-retail-storefront' ),
            'priority' => 1,
            'panel' => 'the_retail_storefront_general',
        )
    );

    // Settings 
    $wp_customize->add_setting(
        'the_retail_storefront_breadcrumb_settings',
        array(
            'capability'     	=> 'edit_theme_options',
            'sanitize_callback' => 'the_retail_storefront_sanitize_text',
            'priority' => 1,
        )
    );

    $wp_customize->add_control(
        'the_retail_storefront_breadcrumb_settings',
        array(
            'type' => 'hidden',
            'label' => __('Settings','the-retail-storefront'),
            'section' => 'the_retail_storefront_breadcrumb_setting',
        )
    );

    // Breadcrumb Hide/Show Setting
    $wp_customize->add_setting( 
        'the_retail_storefront_hs_breadcrumb',
        array(
            'default' => '1',
            'sanitize_callback' => 'the_retail_storefront_sanitize_checkbox',
            'capability' => 'edit_theme_options',
            'priority' => 2,
        ) 
    );

    $wp_customize->add_control(
        'the_retail_storefront_hs_breadcrumb', 
        array(
            'label'	      => esc_html__( 'Hide / Show Section', 'the-retail-storefront' ),
            'section'     => 'the_retail_storefront_breadcrumb_setting',
            'settings'    => 'the_retail_storefront_hs_breadcrumb',
            'type'        => 'checkbox'
        ) 
    );

    $wp_customize->add_setting(
        'the_retail_storefront_breadcrumb_seprator',
        array(
            'default' => '/',
            'sanitize_callback' => 'sanitize_text_field',
        )
    );
    $wp_customize->add_control(
        'the_retail_storefront_breadcrumb_seprator',
        array(
            'label'         => __('Breadcrumb separator','the-retail-storefront'),
            'section'       => 'the_retail_storefront_breadcrumb_setting',
            'type'          => 'text',
        )  
    );

    $wp_customize->add_setting( 
        'the_retail_storefront_upgrade_page_settings_5',
        array(
            'sanitize_callback' => 'sanitize_text_field'
        )
    );

    $wp_customize->add_control( 
        new The_Retail_Storefront_Control_Upgrade(
            $wp_customize, 'the_retail_storefront_upgrade_page_settings_5',
            array(
                'priority'      => 200,
                'section'       => 'the_retail_storefront_breadcrumb_setting',
                'settings'      => 'the_retail_storefront_upgrade_page_settings_5',
                'label'         => __( 'The Retail Storefront Pro comes with additional features.', 'the-retail-storefront' ),
                'choices'       => array( __( '15+ Ready-Made Sections', 'the-retail-storefront' ), __( 'One-Click Demo Import', 'the-retail-storefront' ), __( 'WooCommerce Integrated', 'the-retail-storefront' ), __( 'Drag & Drop Section Reordering', 'the-retail-storefront' ),__( 'Advanced Typography Control', 'the-retail-storefront' ),__( 'Intuitive Customization Options', 'the-retail-storefront' ),__( '24/7 Support', 'the-retail-storefront' ), )
            )
        )
    ); 

    /*=========================================
    Preloader Section
    =========================================*/
    $wp_customize->add_section(
        'the_retail_storefront_preloader_section_setting', array(
            'title' => esc_html__( 'Preloader Options', 'the-retail-storefront' ),
            'priority' => 3,
            'panel' => 'the_retail_storefront_general',
        )
    );

    // Preloader Hide/Show Setting
    $wp_customize->add_setting( 
        'the_retail_storefront_preloader_setting', 
        array(
            'default' => '',
            'sanitize_callback' => 'the_retail_storefront_sanitize_checkbox',
            'capability' => 'edit_theme_options',
        ) 
    );

    $wp_customize->add_control(
        'the_retail_storefront_preloader_setting', 
        array(
            'label'	      => esc_html__( 'Hide / Show Preloader', 'the-retail-storefront' ),
            'section'     => 'the_retail_storefront_preloader_section_setting',
            'settings'    => 'the_retail_storefront_preloader_setting',
            'type'        => 'checkbox'
        ) 
    );

    $wp_customize->add_setting(
    	'the_retail_storefront_preloader_text',
    	array(
			'default' => 'Loading',
			'sanitize_callback' => 'sanitize_text_field',
		)
	);
	$wp_customize->add_control(
		'the_retail_storefront_preloader_text',
		array(
		    'label'   		=> __('Preloader Text','the-retail-storefront'),
		    'section'		=> 'the_retail_storefront_preloader_section_setting',
			'type' 			=> 'text',
			'transport'         => $selective_refresh,
		)
	);

    // Preloader Background Color Setting
    $wp_customize->add_setting(
        'the_retail_storefront_preloader_bg_color',
        array(
            'default' => '#ffffff',
            'sanitize_callback' => 'sanitize_hex_color',
            'capability' => 'edit_theme_options',
        )
    );

    $wp_customize->add_control(
        new WP_Customize_Color_Control(
            $wp_customize,
            'the_retail_storefront_preloader_bg_color',
            array(
                'label' => esc_html__('Preloader Background Color', 'the-retail-storefront'),
                'section' => 'the_retail_storefront_preloader_section_setting', 
                'settings' => 'the_retail_storefront_preloader_bg_color',
            )
        )
    );

    // Preloader Color Setting
    $wp_customize->add_setting(
        'the_retail_storefront_preloader_color',
        array(
            'default' => '#FE816D',
            'sanitize_callback' => 'sanitize_hex_color',
            'capability' => 'edit_theme_options',
        )
    );

    $wp_customize->add_control(
        new WP_Customize_Color_Control(
            $wp_customize,
            'the_retail_storefront_preloader_color',
            array(
                'label' => esc_html__('Preloader Color', 'the-retail-storefront'),
                'section' => 'the_retail_storefront_preloader_section_setting', 
                'settings' => 'the_retail_storefront_preloader_color',
            )
        )
    );

    $wp_customize->add_setting( 
        'the_retail_storefront_upgrade_page_settings_6',
        array(
            'sanitize_callback' => 'sanitize_text_field'
        )
    );

    $wp_customize->add_control( 
        new The_Retail_Storefront_Control_Upgrade(
            $wp_customize, 'the_retail_storefront_upgrade_page_settings_6',
            array(
                'priority'      => 200,
                'section'       => 'the_retail_storefront_preloader_section_setting',
                'settings'      => 'the_retail_storefront_upgrade_page_settings_6',
                'label'         => __( 'The Retail Storefront Pro comes with additional features.', 'the-retail-storefront' ),
                'choices'       => array( __( '15+ Ready-Made Sections', 'the-retail-storefront' ), __( 'One-Click Demo Import', 'the-retail-storefront' ), __( 'WooCommerce Integrated', 'the-retail-storefront' ), __( 'Drag & Drop Section Reordering', 'the-retail-storefront' ),__( 'Advanced Typography Control', 'the-retail-storefront' ),__( 'Intuitive Customization Options', 'the-retail-storefront' ),__( '24/7 Support', 'the-retail-storefront' ), )
            )
        )
    );

    /*=========================================
    Scroll To Top Section
    =========================================*/
    $wp_customize->add_section(
        'the_retail_storefront_scroll_to_top_section_setting', array(
            'title' => esc_html__( 'Scroll To Top Options', 'the-retail-storefront' ),
            'priority' => 3,
            'panel' => 'the_retail_storefront_footer_section',
        )
    );

    // Scroll To Top Hide/Show Setting
    $wp_customize->add_setting( 
        'the_retail_storefront_scroll_top_setting', 
        array(
            'default' => '1',
            'sanitize_callback' => 'the_retail_storefront_sanitize_checkbox',
            'capability' => 'edit_theme_options',
        ) 
    );

    $wp_customize->add_control(
        'the_retail_storefront_scroll_top_setting', 
        array(
            'label'	      => esc_html__( 'Hide / Show Scroll To Top', 'the-retail-storefront' ),
            'section'     => 'the_retail_storefront_scroll_to_top_section_setting',
            'settings'    => 'the_retail_storefront_scroll_top_setting',
            'type'        => 'checkbox'
        ) 
    );

    // Scroll To Top Color Setting
    $wp_customize->add_setting(
        'the_retail_storefront_scroll_top_color',
        array(
            'default'           => '#fff',
            'sanitize_callback' => 'sanitize_hex_color',
            'capability'        => 'edit_theme_options',
        )
    );

    $wp_customize->add_control(
        new WP_Customize_Color_Control(
            $wp_customize,
            'the_retail_storefront_scroll_top_color',
            array(
                'label'    => esc_html__( 'Scroll To Top Color', 'the-retail-storefront' ),
                'section'  => 'the_retail_storefront_scroll_to_top_section_setting',
                'settings' => 'the_retail_storefront_scroll_top_color',
            )
        )
    );

    // Scroll To Top Background Color Setting
    $wp_customize->add_setting(
        'the_retail_storefront_scroll_top_bg_color',
        array(
            'default'           => '#FE816D',
            'sanitize_callback' => 'sanitize_hex_color',
            'capability'        => 'edit_theme_options',
        )
    );

    $wp_customize->add_control(
        new WP_Customize_Color_Control(
            $wp_customize,
            'the_retail_storefront_scroll_top_bg_color',
            array(
                'label'    => esc_html__( 'Scroll To Top Background Color', 'the-retail-storefront' ),
                'section'  => 'the_retail_storefront_scroll_to_top_section_setting',
                'settings' => 'the_retail_storefront_scroll_top_bg_color',
            )
        )
    );

    $wp_customize->add_setting( 
        'the_retail_storefront_upgrade_page_settings_7',
        array(
            'sanitize_callback' => 'sanitize_text_field'
        )
    );

    $wp_customize->add_control( 
        new The_Retail_Storefront_Control_Upgrade(
            $wp_customize, 'the_retail_storefront_upgrade_page_settings_7',
            array(
                'priority'      => 200,
                'section'       => 'the_retail_storefront_scroll_to_top_section_setting',
                'settings'      => 'the_retail_storefront_upgrade_page_settings_7',
                'label'         => __( 'The Retail Storefront Pro comes with additional features.', 'the-retail-storefront' ),
                'choices'       => array( __( '15+ Ready-Made Sections', 'the-retail-storefront' ), __( 'One-Click Demo Import', 'the-retail-storefront' ), __( 'WooCommerce Integrated', 'the-retail-storefront' ), __( 'Drag & Drop Section Reordering', 'the-retail-storefront' ),__( 'Advanced Typography Control', 'the-retail-storefront' ),__( 'Intuitive Customization Options', 'the-retail-storefront' ),__( '24/7 Support', 'the-retail-storefront' ), )
            )
        )
    ); 

    /*=========================================
    Sticky Header Section
    =========================================*/
    $wp_customize->add_section(
        'the_retail_storefront_sticky_header_section_setting', array(
            'title' => esc_html__( 'Sticky Header Options', 'the-retail-storefront' ),
            'priority' => 3,
            'panel' => 'the_retail_storefront_general',
        )
    );

    // Sticky Header Hide/Show Setting
    $wp_customize->add_setting( 
        'the_retail_storefront_sticky_header', 
        array(
            'sanitize_callback' => 'the_retail_storefront_sanitize_checkbox',
            'capability' => 'edit_theme_options',
        ) 
    );

    $wp_customize->add_control(
        'the_retail_storefront_sticky_header', 
        array(
            'label'	      => esc_html__( 'Hide / Show Sticky Header', 'the-retail-storefront' ),
            'section'     => 'the_retail_storefront_sticky_header_section_setting',
            'settings'    => 'the_retail_storefront_sticky_header',
            'type'        => 'checkbox'
        ) 
    );

    $wp_customize->add_setting( 
        'the_retail_storefront_upgrade_page_settings_8',
        array(
            'sanitize_callback' => 'sanitize_text_field'
        )
    );

    $wp_customize->add_control( 
        new The_Retail_Storefront_Control_Upgrade(
            $wp_customize, 'the_retail_storefront_upgrade_page_settings_8',
            array(
                'priority'      => 200,
                'section'       => 'the_retail_storefront_sticky_header_section_setting',
                'settings'      => 'the_retail_storefront_upgrade_page_settings_8',
                'label'         => __( 'The Retail Storefront Pro comes with additional features.', 'the-retail-storefront' ),
                'choices'       => array( __( '15+ Ready-Made Sections', 'the-retail-storefront' ), __( 'One-Click Demo Import', 'the-retail-storefront' ), __( 'WooCommerce Integrated', 'the-retail-storefront' ), __( 'Drag & Drop Section Reordering', 'the-retail-storefront' ),__( 'Advanced Typography Control', 'the-retail-storefront' ),__( 'Intuitive Customization Options', 'the-retail-storefront' ),__( '24/7 Support', 'the-retail-storefront' ), )
            )
        )
    );

    /*=========================================
	404 Page Options
	=========================================*/
	$wp_customize->add_section(
		'the_retail_storefront_404_section', array(
			'title' => esc_html__( '404 Page Options', 'the-retail-storefront' ),
			'priority' => 1,
			'panel' => 'the_retail_storefront_general',
		)
	);

	$wp_customize->add_setting(
    	'the_retail_storefront_404_title',
    	array(
			'default' => '404',
			'sanitize_callback' => 'sanitize_text_field',
			'priority' => 2,
		)
	);	
	$wp_customize->add_control( 
		'the_retail_storefront_404_title',
		array(
		    'label'   		=> __('404 Heading','the-retail-storefront'),
		    'section'		=> 'the_retail_storefront_404_section',
			'type' 			=> 'text',
			'transport'         => $selective_refresh,
		)  
	);

	$wp_customize->add_setting(
    	'the_retail_storefront_404_Text',
    	array(
			'default' => 'Page Not Found',
			'sanitize_callback' => 'sanitize_text_field',
			'priority' => 2,
		)
	);	
	$wp_customize->add_control( 
		'the_retail_storefront_404_Text',
		array(
		    'label'   		=> __('404 Title','the-retail-storefront'),
		    'section'		=> 'the_retail_storefront_404_section',
			'type' 			=> 'text',
			'transport'         => $selective_refresh,
		)  
	);

	$wp_customize->add_setting(
    	'the_retail_storefront_404_content',
    	array(
			'default' => 'The page you were looking for could not be found.',
			'sanitize_callback' => 'sanitize_text_field',
			'priority' => 2,
		)
	);	
	$wp_customize->add_control( 
		'the_retail_storefront_404_content',
		array(
		    'label'   		=> __('404 Content','the-retail-storefront'),
		    'section'		=> 'the_retail_storefront_404_section',
			'type' 			=> 'text',
			'transport'         => $selective_refresh,
		)  
	);

	 $wp_customize->add_setting( 'the_retail_storefront_upgrade_page_settings_10',
        array(
            'sanitize_callback' => 'sanitize_text_field'
        )
    );
    $wp_customize->add_control( new The_Retail_Storefront_Control_Upgrade(
        $wp_customize, 'the_retail_storefront_upgrade_page_settings_10',
            array(
                'priority'      => 200,
                'section'       => 'the_retail_storefront_404_section',
                'settings'      => 'the_retail_storefront_upgrade_page_settings_10',
                'label'         => __( 'The Retail Storefront Pro comes with additional features.', 'the-retail-storefront' ),
                'choices'       => array( __( '15+ Ready-Made Sections', 'the-retail-storefront' ), __( 'One-Click Demo Import', 'the-retail-storefront' ), __( 'WooCommerce Integrated', 'the-retail-storefront' ), __( 'Drag & Drop Section Reordering', 'the-retail-storefront' ),__( 'Advanced Typography Control', 'the-retail-storefront' ),__( 'Intuitive Customization Options', 'the-retail-storefront' ),__( '24/7 Support', 'the-retail-storefront' ), )
            )
        )
    ); 

    /*=========================================
	Woocommerce Section
	=========================================*/
	$wp_customize->add_section(
		'woocommerce_section_setting', array(
			'title' => esc_html__( 'Woocommerce Additional Settings', 'the-retail-storefront' ),
			'priority' => 3,
			'panel' => 'woocommerce',
		)
	);

	// Add the setting for product columns
	$wp_customize->add_setting(
	    'the_retail_storefront_custom_shop_per_columns',
	    array(
	        'default'           => '3',
	        'sanitize_callback' => 'the_retail_storefront_sanitize_numeric_input',
	    )
	);

	// Add control for product columns
	$wp_customize->add_control( 
	    'the_retail_storefront_custom_shop_per_columns',
	    array(
	        'label'     => __('Product Per Columns', 'the-retail-storefront'),
	        'section'   => 'woocommerce_section_setting',
	        'type'      => 'number', // Change type to number
	        'input_attrs' => array(
	            'min'   => 1, // Optional: set minimum allowed value
	            'max'	=> 4,
	            'step'  => 1, // Optional: set step size
	        ),
	        'transport' => $selective_refresh,
	    )  
	);

	$wp_customize->add_setting(
    	'the_retail_storefront_custom_shop_product_per_page',
    	array(
			'default' => '9',
			'sanitize_callback' => 'the_retail_storefront_sanitize_numeric_input',
		)
	);	
	$wp_customize->add_control( 
		'the_retail_storefront_custom_shop_product_per_page',
		array(
		    'label'   		=> __('Product Per Page','the-retail-storefront'),
		    'section'		=> 'woocommerce_section_setting',
			'type'      => 'number', // Change type to number
	        'input_attrs' => array(
	            'min'   => 1, // Optional: set minimum allowed value
	            'step'  => 1, // Optional: set step size
	        ),
	        'transport' => $selective_refresh,
		)  
	);

	// Woocommerce Sidebar Hide/ Show Setting // 
	$wp_customize->add_setting( 
		'the_retail_storefront_wocommerce_sidebar_setting' , 
			array(
			'default' => '1',
			'sanitize_callback' => 'the_retail_storefront_sanitize_checkbox',
			'capability' => 'edit_theme_options',
		) 
	);
	
	$wp_customize->add_control(
	'the_retail_storefront_wocommerce_sidebar_setting', 
		array(
			'label'	      => esc_html__( 'Hide / Show Woocommerce Sidebar', 'the-retail-storefront' ),
			'section'     => 'woocommerce_section_setting',
			'settings'    => 'the_retail_storefront_wocommerce_sidebar_setting',
			'type'        => 'checkbox'
		) 
	);

	 $wp_customize->add_setting( 'the_retail_storefront_upgrade_page_settings_89',
        array(
            'sanitize_callback' => 'sanitize_text_field'
        )
    );
    $wp_customize->add_control( new The_Retail_Storefront_Control_Upgrade(
        $wp_customize, 'the_retail_storefront_upgrade_page_settings_89',
            array(
                'priority'      => 200,
                'section'       => 'woocommerce_section_setting',
                'settings'      => 'the_retail_storefront_upgrade_page_settings_89',
                'label'         => __( 'The Retail Storefront Pro comes with additional features.', 'the-retail-storefront' ),
                'choices'       => array( __( '15+ Ready-Made Sections', 'the-retail-storefront' ), __( 'One-Click Demo Import', 'the-retail-storefront' ), __( 'WooCommerce Integrated', 'the-retail-storefront' ), __( 'Drag & Drop Section Reordering', 'the-retail-storefront' ),__( 'Advanced Typography Control', 'the-retail-storefront' ),__( 'Intuitive Customization Options', 'the-retail-storefront' ),__( '24/7 Support', 'the-retail-storefront' ), )
            )
        )
    ); 
}
add_action( 'customize_register', 'the_retail_storefront_general_setting' );
?>
