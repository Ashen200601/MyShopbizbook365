<?php

function the_retail_storefront_footer( $wp_customize ) {
	$selective_refresh = isset( $wp_customize->selective_refresh ) ? 'postMessage' : 'refresh';
	// Footer Panel // 
	$wp_customize->add_panel( 
		'the_retail_storefront_footer_section', 
		array(
			'priority'      => 34,
			'capability'    => 'edit_theme_options',
			'title'			=> __('Footer Options', 'the-retail-storefront'),
		) 
	);

	// Footer Widgets // 
	$wp_customize->add_section(
        'the_retail_storefront_footer_top',
        array(
            'title' 		=> __('Footer Widgets','the-retail-storefront'),
			'panel'  		=> 'the_retail_storefront_footer_section',
			'priority'      => 3,
		)
    );

    // Footer Widgets Hide/ Show Setting // 
	$wp_customize->add_setting( 
		'the_retail_storefront_footer_widgets_setting' , 
			array(
			'default' => '1',
			'sanitize_callback' => 'the_retail_storefront_sanitize_checkbox',
			'capability' => 'edit_theme_options',
		) 
	);
	
	$wp_customize->add_control(
	'the_retail_storefront_footer_widgets_setting', 
		array(
			'label'	      => esc_html__( 'Hide / Show Footer Widgets', 'the-retail-storefront' ),
			'section'     => 'the_retail_storefront_footer_top',
			'settings'    => 'the_retail_storefront_footer_widgets_setting',
			'type'        => 'checkbox'
		) 
	);

	// Footer Background Image Setting
	$wp_customize->add_setting('the_retail_storefront_footer_bg_image',array(
		'default'	=> '',
		'sanitize_callback'	=> 'esc_url_raw',
	));
	$wp_customize->add_control( new WP_Customize_Image_Control($wp_customize,'the_retail_storefront_footer_bg_image',array(
	'label' => __('Footer Background Image','the-retail-storefront'),
	'section' => 'the_retail_storefront_footer_top'
	)));

	// Footer Background Image Opacity
	$wp_customize->add_setting('the_retail_storefront_footer_bg_image_opacity', array(
		'default'           => 50,
		'sanitize_callback' => 'absint',
		'capability'        => 'edit_theme_options',
	));

	$wp_customize->add_control('the_retail_storefront_footer_bg_image_opacity', array(
		'label'    => __('Footer Background Image Opacity (%)', 'the-retail-storefront'),
		'section'  => 'the_retail_storefront_footer_top',
		'type'     => 'range',
		'input_attrs' => array(
			'min'  => 0,
			'max'  => 100,
			'step' => 1,
		),
	));

	// Footer Background Color Setting
    $wp_customize->add_setting('the_retail_storefront_footer_bg_color',array(
		'default' => '#151515',
		'sanitize_callback' => 'sanitize_hex_color',
		'capability' => 'edit_theme_options',
	));

    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize,'the_retail_storefront_footer_bg_color',array(
		'label' => esc_html__('Footer Background Color', 'the-retail-storefront'),
		'section' => 'the_retail_storefront_footer_top', // Adjust section if needed
		'settings' => 'the_retail_storefront_footer_bg_color',
	)));

	$wp_customize->add_setting( 'the_retail_storefront_upgrade_page_settings_3',
        array(
            'sanitize_callback' => 'sanitize_text_field'
        )
    );
    $wp_customize->add_control( new The_Retail_Storefront_Control_Upgrade(
        $wp_customize, 'the_retail_storefront_upgrade_page_settings_3',
            array(
                'priority'      => 200,
                'section'       => 'the_retail_storefront_footer_top',
                'settings'      => 'the_retail_storefront_upgrade_page_settings_3',
                'label'         => __( 'The Retail Storefront Pro comes with additional features.', 'the-retail-storefront' ),
                'choices'       => array( __( '15+ Ready-Made Sections', 'the-retail-storefront' ), __( 'One-Click Demo Import', 'the-retail-storefront' ), __( 'WooCommerce Integrated', 'the-retail-storefront' ), __( 'Drag & Drop Section Reordering', 'the-retail-storefront' ),__( 'Advanced Typography Control', 'the-retail-storefront' ),__( 'Intuitive Customization Options', 'the-retail-storefront' ),__( '24/7 Support', 'the-retail-storefront' ), )
            )
        )
    ); 

	// Footer Bottom // 
	$wp_customize->add_section(
        'the_retail_storefront_footer_bottom',
        array(
            'title' 		=> __('Footer Bottom','the-retail-storefront'),
			'panel'  		=> 'the_retail_storefront_footer_section',
			'priority'      => 3,
		)
    );

	// Site Title Hide/ Show Setting // 
	$wp_customize->add_setting( 
		'the_retail_storefront_footer_copyright_setting' , 
			array(
			'default' => '1',
			'sanitize_callback' => 'the_retail_storefront_sanitize_checkbox',
			'capability' => 'edit_theme_options',
		) 
	);
	
	$wp_customize->add_control(
	'the_retail_storefront_footer_copyright_setting', 
		array(
			'label'	      => esc_html__( 'Hide / Show Footer Copytight', 'the-retail-storefront' ),
			'section'     => 'the_retail_storefront_footer_bottom',
			'settings'    => 'the_retail_storefront_footer_copyright_setting',
			'type'        => 'checkbox'
		) 
	);
	
	// Footer Copyright 
	$wp_customize->add_setting(
    	'the_retail_storefront_footer_copyright',
    	array(
			'capability'     	=> 'edit_theme_options',
			'sanitize_callback' => 'wp_kses_post',
			'priority'      => 4,
		)
	);

	$wp_customize->add_control( 
		'the_retail_storefront_footer_copyright',
		array(
		    'label'   		=> __('Edit Copyright Text','the-retail-storefront'),
		    'section'		=> 'the_retail_storefront_footer_bottom',
			'type' 			=> 'text',
			'transport'         => $selective_refresh,
		)  
	);

	$wp_customize->add_setting( 'the_retail_storefront_copyright_alignment', array(
        'default'   => 'center',
        'sanitize_callback' => 'the_retail_storefront_sanitize_copyright_position',
    ));

    $wp_customize->add_control( 'the_retail_storefront_copyright_alignment', array(
        'label'    => __( 'Copyright Position', 'the-retail-storefront' ),
        'section'  => 'the_retail_storefront_footer_bottom',
        'settings' => 'the_retail_storefront_copyright_alignment',
        'type'     => 'radio',
        'choices'  => array(
            'right' => __( 'Right Align', 'the-retail-storefront' ),
            'left'  => __( 'Left Align', 'the-retail-storefront' ),
            'center'  => __( 'Center Align', 'the-retail-storefront' ),
        ),
    ));

	$wp_customize->add_setting( 'the_retail_storefront_upgrade_page_settings_4',
        array(
            'sanitize_callback' => 'sanitize_text_field'
        )
    );
    $wp_customize->add_control( new The_Retail_Storefront_Control_Upgrade(
        $wp_customize, 'the_retail_storefront_upgrade_page_settings_4',
            array(
                'priority'      => 200,
                'section'       => 'the_retail_storefront_footer_bottom',
                'settings'      => 'the_retail_storefront_upgrade_page_settings_4',
                'label'         => __( 'The Retail Storefront Pro comes with additional features.', 'the-retail-storefront' ),
                'choices'       => array( __( '15+ Ready-Made Sections', 'the-retail-storefront' ), __( 'One-Click Demo Import', 'the-retail-storefront' ), __( 'WooCommerce Integrated', 'the-retail-storefront' ), __( 'Drag & Drop Section Reordering', 'the-retail-storefront' ),__( 'Advanced Typography Control', 'the-retail-storefront' ),__( 'Intuitive Customization Options', 'the-retail-storefront' ),__( '24/7 Support', 'the-retail-storefront' ), )
            )
        )
    ); 
}
add_action( 'customize_register', 'the_retail_storefront_footer' );

// Footer selective refresh
function the_retail_storefront_footer_partials( $wp_customize ){
	// footer_copyright
	$wp_customize->selective_refresh->add_partial( 'footer_copyright', array(
		'selector'            => '.copy-right .copyright-text',
		'settings'            => 'footer_copyright',
		'render_callback'  => 'the_retail_storefront_footer_copyright_render_callback',
	) );
}
add_action( 'customize_register', 'the_retail_storefront_footer_partials' );

// copyright_content
function the_retail_storefront_footer_copyright_render_callback() {
	return get_theme_mod( 'footer_copyright' );
}