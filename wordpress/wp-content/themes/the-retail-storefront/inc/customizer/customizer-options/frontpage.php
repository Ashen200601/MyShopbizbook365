<?php
function the_retail_storefront_blog_setting( $wp_customize ) {

$wp_customize->register_control_type( 'The_Retail_Storefront_Control_Upgrade' );

$selective_refresh = isset( $wp_customize->selective_refresh ) ? 'postMessage' : 'refresh';
	$wp_customize->add_panel(
		'the_retail_storefront_frontpage_sections', array(
			'priority' => 1,
			'title' => esc_html__( 'Frontpage Sections', 'the-retail-storefront' ),
		)
	);

	//home page category
	$wp_customize->add_section( 'the_retail_storefront_home_category_section' , array(
    	'title'      => __( 'Products Category Section', 'the-retail-storefront' ),
    	'description' => __('Activate Woocommerce Plugin >> Create Product Categories','the-retail-storefront'),
    	'priority' => 12,
		'panel' => 'the_retail_storefront_frontpage_sections'
	) );

	$wp_customize->add_setting('the_retail_storefront_category_text',array(
		'default' => 'Top Best Category',
		'sanitize_callback' => 'sanitize_text_field',
		'capability' => 'edit_theme_options',
	));
	$wp_customize->add_control( 'the_retail_storefront_category_text', array(
	   'settings' => 'the_retail_storefront_category_text',
	   'section'   => 'the_retail_storefront_home_category_section',
	   'label' => __('Add Category Text', 'the-retail-storefront'),
	   'type'      => 'text'
	));

	$wp_customize->add_setting('the_retail_storefront_product_category_number',array(
		'default' => '12',
		'sanitize_callback' => 'the_retail_storefront_sanitize_number_absint',
		'capability' => 'edit_theme_options',
	));
	$wp_customize->add_control( 'the_retail_storefront_product_category_number', array(
	   'settings' => 'the_retail_storefront_product_category_number',
	   'section'   => 'the_retail_storefront_home_category_section',
	   'label' => __('Add Category Limit', 'the-retail-storefront'),
	   'type'      => 'number'
	));

	$wp_customize->add_setting( 'the_retail_storefront_upgrade_page_settings_122',
        array(
            'sanitize_callback' => 'sanitize_text_field'
        )
    );
    $wp_customize->add_control( new The_Retail_Storefront_Control_Upgrade(
        $wp_customize, 'the_retail_storefront_upgrade_page_settings_122',
            array(
                'priority'      => 200,
                'section'       => 'the_retail_storefront_home_category_section',
                'settings'      => 'the_retail_storefront_upgrade_page_settings_122',
                'label'         => __( 'The Retail Storefront Pro comes with additional features.', 'the-retail-storefront' ),
                'choices'       => array( __( '15+ Ready-Made Sections', 'the-retail-storefront' ), __( 'One-Click Demo Import', 'the-retail-storefront' ), __( 'WooCommerce Integrated', 'the-retail-storefront' ), __( 'Drag & Drop Section Reordering', 'the-retail-storefront' ),__( 'Advanced Typography Control', 'the-retail-storefront' ),__( 'Intuitive Customization Options', 'the-retail-storefront' ),__( '24/7 Support', 'the-retail-storefront' ), )
            )
        )
    ); 
	
	/*=========================================
	Slider Section
	=========================================*/
	$wp_customize->add_section(
		'the_retail_storefront_slider_section', array(
			'title' => esc_html__( 'Slider Section', 'the-retail-storefront' ),
			'priority' => 13,
			'panel' => 'the_retail_storefront_frontpage_sections',
		)
	);

	// Slider Hide/ Show Setting // 
	$wp_customize->add_setting( 
		'the_retail_storefront_slider_setting' , 
			array(
			'default' => true,
			'sanitize_callback' => 'the_retail_storefront_sanitize_checkbox',
			'capability' => 'edit_theme_options',
			'priority' => 2,
		) 
	);
	
	$wp_customize->add_control(
	'the_retail_storefront_slider_setting', 
		array(
			'label'	      => esc_html__( 'Hide / Show Section', 'the-retail-storefront' ),
			'section'     => 'the_retail_storefront_slider_section',
			'settings'    => 'the_retail_storefront_slider_setting',
			'type'        => 'checkbox'
		) 
	);
	
	for ( $the_retail_storefront_count = 1; $the_retail_storefront_count <= 3; $the_retail_storefront_count++ ) {

	// Add color scheme setting and control.
	$wp_customize->add_setting( 'the_retail_storefront_slider_page' . $the_retail_storefront_count, array(
		'sanitize_callback' => 'the_retail_storefront_sanitize_dropdown_pages'
	) );

	$wp_customize->add_control( 'the_retail_storefront_slider_page' . $the_retail_storefront_count, array(
		'label'    => __( 'Select Slide Image Page', 'the-retail-storefront' ),
		'section'  => 'the_retail_storefront_slider_section',
		'type'     => 'dropdown-pages'
	) );
	}

	// Slider Text
	$wp_customize->add_setting( 
    	'the_retail_storefront_slider_short_heading',
    	array(
			'capability'     	=> 'edit_theme_options',
			'sanitize_callback' => 'sanitize_text_field',
			'priority'      => 1,
		)
	);	

	$wp_customize->add_control( 
		'the_retail_storefront_slider_short_heading',
		array(
		    'label'   		=> __('Slider Top Text','the-retail-storefront'),
		    'section'		=> 'the_retail_storefront_slider_section',
			'type' 			=> 'text',
			'transport'         => $selective_refresh,
		)
	);

	$wp_customize->add_setting(
    	'the_retail_storefront_slider_btn_text',
    	array(
			'default' => 'Shop Now',
			'sanitize_callback' => 'sanitize_text_field',
		)
	);
	$wp_customize->add_control(
		'the_retail_storefront_slider_btn_text',
		array(
		    'label'   		=> __('Slider Button Text','the-retail-storefront'),
		    'section'		=> 'the_retail_storefront_slider_section',
			'type' 			=> 'text',
			'transport'         => $selective_refresh,
		)  
	);

	$wp_customize->add_setting(
    	'the_retail_storefront_slider_btn_link',
    	array(
			'default' => '',
			'sanitize_callback' => 'esc_url_raw',
		)
	);
	$wp_customize->add_control( 
		'the_retail_storefront_slider_btn_link',
		array(
		    'label'   		=> __('Slider Button Link','the-retail-storefront'),
		    'section'		=> 'the_retail_storefront_slider_section',
			'type' 			=> 'url',
			'transport'         => $selective_refresh,
		)
	);

	$wp_customize->add_setting('the_retail_storefront_discount_sale_img1',array(
		'default'	=> '',
		'sanitize_callback'	=> 'esc_url_raw',
	));
	$wp_customize->add_control( new WP_Customize_Image_Control($wp_customize,'the_retail_storefront_discount_sale_img1',array(
	    'label' => __('Select Sale Banner Image','the-retail-storefront'),
	     'section' => 'the_retail_storefront_slider_section'
	)));

	$wp_customize->add_setting('the_retail_storefront_product_sale_discount_title1',array(
		'default'=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('the_retail_storefront_product_sale_discount_title1',array(
		'label'	=> __('Add Sale Title','the-retail-storefront'),
		'section'=> 'the_retail_storefront_slider_section',
		'type'=> 'text'
	));

	$wp_customize->add_setting('the_retail_storefront_topproduct_price',array(
		'default'=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('the_retail_storefront_topproduct_price',array(
		'label'	=> __('Add Sale Price','the-retail-storefront'),
		'section'=> 'the_retail_storefront_slider_section',
		'type'=> 'text'
	));

	$wp_customize->add_setting('the_retail_storefront_product_btn_text1',array(
		'default'=> 'Shop Now',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('the_retail_storefront_product_btn_text1',array(
		'label'	=> esc_html__('Add Sale Button Text','the-retail-storefront'),
		'section'=> 'the_retail_storefront_slider_section',
		'type'=> 'text'
	));

	$wp_customize->add_setting('the_retail_storefront_product_btn_link1',array(
		'default'=> '',
		'sanitize_callback'	=> 'esc_url_raw'
	));
	$wp_customize->add_control('the_retail_storefront_product_btn_link1',array(
		'label'	=> esc_html__('Add Sale Button link','the-retail-storefront'),
		'section'=> 'the_retail_storefront_slider_section',
		'type'=> 'url'
	));

	$wp_customize->add_setting( 'the_retail_storefront_upgrade_page_settings_12ad',
        array(
            'sanitize_callback' => 'sanitize_text_field'
        )
    );
    $wp_customize->add_control( new The_Retail_Storefront_Control_Upgrade(
        $wp_customize, 'the_retail_storefront_upgrade_page_settings_12ad',
            array(
                'priority'      => 200,
                'section'       => 'the_retail_storefront_slider_section',
                'settings'      => 'the_retail_storefront_upgrade_page_settings_12ad',
                'label'         => __( 'The Retail Storefront Pro comes with additional features.', 'the-retail-storefront' ),
                'choices'       => array( __( '15+ Ready-Made Sections', 'the-retail-storefront' ), __( 'One-Click Demo Import', 'the-retail-storefront' ), __( 'WooCommerce Integrated', 'the-retail-storefront' ), __( 'Drag & Drop Section Reordering', 'the-retail-storefront' ),__( 'Advanced Typography Control', 'the-retail-storefront' ),__( 'Intuitive Customization Options', 'the-retail-storefront' ),__( '24/7 Support', 'the-retail-storefront' ), )
            )
        )
    ); 

	/*=========================================
	Product deatil
	=========================================*/
	$wp_customize->add_section(
		'the_retail_storefront_product_service', array(
			'title' => esc_html__( 'About Products Delivery & Services Section', 'the-retail-storefront' ),
			'priority' => 13,
			'panel' => 'the_retail_storefront_frontpage_sections',
		)
	);

	$wp_customize->add_setting('the_retail_storefront_add_support_heading',array(
		'default'	=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('the_retail_storefront_add_support_heading',array(
		'label'	=> __('Add Support Heading','the-retail-storefront'),
		'section'	=> 'the_retail_storefront_product_service',
		'type'		=> 'text'
	));

	$wp_customize->add_setting('the_retail_storefront_add_support_details',array(
		'default'	=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('the_retail_storefront_add_support_details',array(
		'label'	=> __('Add Support Details','the-retail-storefront'),
		'section'	=> 'the_retail_storefront_product_service',
		'type'		=> 'text'
	));

	$wp_customize->add_setting('the_retail_storefront_add_payment_heading',array(
		'default'	=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('the_retail_storefront_add_payment_heading',array(
		'label'	=> __('Add Payment Heading','the-retail-storefront'),
		'section'	=> 'the_retail_storefront_product_service',
		'type'		=> 'text'
	));

	$wp_customize->add_setting('the_retail_storefront_add_payment_details',array(
		'default'	=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('the_retail_storefront_add_payment_details',array(
		'label'	=> __('Add Payment Details','the-retail-storefront'),
		'section'	=> 'the_retail_storefront_product_service',
		'type'		=> 'text'
	));

	$wp_customize->add_setting('the_retail_storefront_add_shipping_heading',array(
		'default'	=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('the_retail_storefront_add_shipping_heading',array(
		'label'	=> __('Add Shipping Heading','the-retail-storefront'),
		'section'	=> 'the_retail_storefront_product_service',
		'type'		=> 'text'
	));

	$wp_customize->add_setting('the_retail_storefront_add_shipping_details',array(
		'default'	=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('the_retail_storefront_add_shipping_details',array(
		'label'	=> __('Add Shipping Details','the-retail-storefront'),
		'section'	=> 'the_retail_storefront_product_service',
		'type'		=> 'text'
	));

	$wp_customize->add_setting('the_retail_storefront_add_return_heading',array(
		'default'	=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('the_retail_storefront_add_return_heading',array(
		'label'	=> __('Add Return Heading','the-retail-storefront'),
		'section'	=> 'the_retail_storefront_product_service',
		'type'		=> 'text'
	));

	$wp_customize->add_setting('the_retail_storefront_add_return_details',array(
		'default'	=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('the_retail_storefront_add_return_details',array(
		'label'	=> __('Add Return Details','the-retail-storefront'),
		'section'	=> 'the_retail_storefront_product_service',
		'type'		=> 'text'
	));

	$wp_customize->add_setting( 'the_retail_storefront_upgrade_page_settings_12adsa',
        array(
            'sanitize_callback' => 'sanitize_text_field'
        )
    );
    $wp_customize->add_control( new The_Retail_Storefront_Control_Upgrade(
        $wp_customize, 'the_retail_storefront_upgrade_page_settings_12adsa',
            array(
                'priority'      => 200,
                'section'       => 'the_retail_storefront_product_service',
                'settings'      => 'the_retail_storefront_upgrade_page_settings_12adsa',
                'label'         => __( 'The Retail Storefront Pro comes with additional features.', 'the-retail-storefront' ),
                'choices'       => array( __( '15+ Ready-Made Sections', 'the-retail-storefront' ), __( 'One-Click Demo Import', 'the-retail-storefront' ), __( 'WooCommerce Integrated', 'the-retail-storefront' ), __( 'Drag & Drop Section Reordering', 'the-retail-storefront' ),__( 'Advanced Typography Control', 'the-retail-storefront' ),__( 'Intuitive Customization Options', 'the-retail-storefront' ),__( '24/7 Support', 'the-retail-storefront' ), )
            )
        )
    ); 

	/*=========================================
	product Section
	=========================================*/
	$wp_customize->add_section(
		'the_retail_storefront_our_products_section', array(
			'title' => esc_html__( 'Top Selling Products Section', 'the-retail-storefront' ),
			'priority' => 13,
			'panel' => 'the_retail_storefront_frontpage_sections',
		)
	);

	// About Us Hide/ Show Setting // 
	$wp_customize->add_setting( 
		'the_retail_storefront_our_products_show_hide_section' , 
			array(
			'default' => true,
			'sanitize_callback' => 'the_retail_storefront_sanitize_checkbox',
			'capability' => 'edit_theme_options',
			'priority' => 2,
		) 
	);
	$wp_customize->add_control(
	'the_retail_storefront_our_products_show_hide_section', 
		array(
			'label'	      => esc_html__( 'Hide / Show Section', 'the-retail-storefront' ),
			'section'     => 'the_retail_storefront_our_products_section',
			'settings'    => 'the_retail_storefront_our_products_show_hide_section',
			'type'        => 'checkbox'
		) 
	);

	// About Heading
	$wp_customize->add_setting( 
    	'the_retail_storefront_our_products_heading_section',
    	array(
			'capability'     	=> 'edit_theme_options',
			'sanitize_callback' => 'sanitize_text_field',
		)
	);	

	$wp_customize->add_control( 
		'the_retail_storefront_our_products_heading_section',
		array(
		    'label'   		=> __('Add Heading','the-retail-storefront'),
		    'section'		=> 'the_retail_storefront_our_products_section',
			'type' 			=> 'text',
		)
	);

	$wp_customize->add_setting( 
    	'the_retail_storefront_our_products_short_heading_section',
    	array(
			'capability'     	=> 'edit_theme_options',
			'sanitize_callback' => 'sanitize_text_field',
		)
	);	

	$wp_customize->add_control( 
		'the_retail_storefront_our_products_short_heading_section',
		array(
		    'label'   		=> __('Add Short Heading','the-retail-storefront'),
		    'section'		=> 'the_retail_storefront_our_products_section',
			'type' 			=> 'text',
		)
	);

	$the_retail_storefront_args = array(
	    'type'           => 'product',
	    'child_of'       => 0,
	    'parent'         => '',
	    'orderby'        => 'term_group',
	    'order'          => 'ASC',
	    'hide_empty'     => false,
	    'hierarchical'   => 1,
	    'number'         => '',
	    'taxonomy'       => 'product_cat',
	    'pad_counts'     => false
	);
	$the_retail_storefront_categories = get_categories($the_retail_storefront_args);
	$the_retail_storefront_cats = array();
	$the_retail_storefront_i = 0;
	foreach ($the_retail_storefront_categories as $the_retail_storefront_category) {
	    if ($the_retail_storefront_i == 0) {
	        $the_retail_storefront_default = $the_retail_storefront_category->slug;
	        $the_retail_storefront_i++;
	    }
	    $the_retail_storefront_cats[$the_retail_storefront_category->slug] = $the_retail_storefront_category->name;
	}

	// Set the default value to "none"
	$the_retail_storefront_default_value = 'product_cat1';

	$wp_customize->add_setting(
	    'the_retail_storefront_our_product_product_category',
	    array(
	        'default'           => $the_retail_storefront_default_value,
	        'sanitize_callback' => 'the_retail_storefront_sanitize_select',
	    )
	);

	// Add "None" as an option in the select dropdown
	$the_retail_storefront_cats_with_none = array_merge(array('none' => 'None'), $the_retail_storefront_cats);

	$wp_customize->add_control(
	    'the_retail_storefront_our_product_product_category',
	    array(
	        'type'    => 'select',
	        'choices' => $the_retail_storefront_cats_with_none,
	        'label'   => __('Select Trending Products Category', 'the-retail-storefront'),
	        'section' => 'the_retail_storefront_our_products_section',
	    )
	);

	$wp_customize->add_setting( 'the_retail_storefront_upgrade_page_settings_1',
        array(
            'sanitize_callback' => 'sanitize_text_field'
        )
    );
    $wp_customize->add_control( new The_Retail_Storefront_Control_Upgrade(
        $wp_customize, 'the_retail_storefront_upgrade_page_settings_1',
            array(
                'priority'      => 200,
                'section'       => 'the_retail_storefront_our_products_section',
                'settings'      => 'the_retail_storefront_upgrade_page_settings_1',
                'label'         => __( 'The Retail Storefront Pro comes with additional features.', 'the-retail-storefront' ),
                'choices'       => array( __( '15+ Ready-Made Sections', 'the-retail-storefront' ), __( 'One-Click Demo Import', 'the-retail-storefront' ), __( 'WooCommerce Integrated', 'the-retail-storefront' ), __( 'Drag & Drop Section Reordering', 'the-retail-storefront' ),__( 'Advanced Typography Control', 'the-retail-storefront' ),__( 'Intuitive Customization Options', 'the-retail-storefront' ),__( '24/7 Support', 'the-retail-storefront' ), )
            )
        )
    ); 

}

add_action( 'customize_register', 'the_retail_storefront_blog_setting' );

// service selective refresh
function the_retail_storefront_blog_section_partials( $wp_customize ){	
	// blog_title
	$wp_customize->selective_refresh->add_partial( 'blog_title', array(
		'selector'            => '.home-blog .title h6',
		'settings'            => 'blog_title',
		'render_callback'  => 'the_retail_storefront_blog_title_render_callback',
	
	) );
	
	// blog_subtitle
	$wp_customize->selective_refresh->add_partial( 'blog_subtitle', array(
		'selector'            => '.home-blog .title h2',
		'settings'            => 'blog_subtitle',
		'render_callback'  => 'the_retail_storefront_blog_subtitle_render_callback',
	
	) );
	
	// blog_description
	$wp_customize->selective_refresh->add_partial( 'blog_description', array(
		'selector'            => '.home-blog .title p',
		'settings'            => 'blog_description',
		'render_callback'  => 'the_retail_storefront_blog_description_render_callback',
	
	) );	
	}

add_action( 'customize_register', 'the_retail_storefront_blog_section_partials' );

// blog_title
function the_retail_storefront_blog_title_render_callback() {
	return get_theme_mod( 'blog_title' );
}

// blog_subtitle
function the_retail_storefront_blog_subtitle_render_callback() {
	return get_theme_mod( 'blog_subtitle' );
}

// service description
function the_retail_storefront_blog_description_render_callback() {
	return get_theme_mod( 'blog_description' );
}