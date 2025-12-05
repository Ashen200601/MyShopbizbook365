<?php
function the_retail_storefront_sidebar_setting( $wp_customize ) {
$selective_refresh = isset( $wp_customize->selective_refresh ) ? 'postMessage' : 'refresh';
	$wp_customize->add_panel(
		'the_retail_storefront_sidebar', array(
			'priority' => 31,
			'title' => esc_html__( 'Sidebar Options', 'the-retail-storefront' ),
		)
	);

	/*=========================================
	Archive Post  Section
	=========================================*/
	$wp_customize->add_section(
		'the_retail_storefront_sidebar_settings', array(
			'title' => esc_html__( 'Sidebar Options', 'the-retail-storefront' ),
			'priority' => 1,
			'panel' => 'the_retail_storefront_general',
		)
	);
	
	// Archive Post Settings 
	$wp_customize->add_setting(
		'archive_post_settings'
			,array(
			'capability'     	=> 'edit_theme_options',
			'sanitize_callback' => 'the_retail_storefront_sanitize_text',
			'priority' => 1,
		)
	);

	$wp_customize->add_control(
	'archive_post_settings',
		array(
			'type' => 'hidden',
			'label' => __('All Sidebar Setting','the-retail-storefront'),
			'section' => 'the_retail_storefront_sidebar_settings',
		)
	);
	

	// Archive Sidebar Hide/ Show Setting // 
	$wp_customize->add_setting( 
		'the_retail_storefront_archive_sidebar_setting' , 
			array(
			'default' => '1',
			'sanitize_callback' => 'the_retail_storefront_sanitize_checkbox',
			'capability' => 'edit_theme_options',
			'priority' => 2,
		) 
	);
	
	$wp_customize->add_control(
	'the_retail_storefront_archive_sidebar_setting', 
		array(
			'label'	      => esc_html__( 'Hide / Show Archive Sidebar', 'the-retail-storefront' ),
			'section'     => 'the_retail_storefront_sidebar_settings',
			'settings'    => 'the_retail_storefront_archive_sidebar_setting',
			'type'        => 'checkbox'
		) 
	);

	// Index Sidebar Hide/ Show Setting // 
	$wp_customize->add_setting( 
		'the_retail_storefront_index_sidebar_setting' , 
			array(
			'default' => '1',
			'sanitize_callback' => 'the_retail_storefront_sanitize_checkbox',
			'capability' => 'edit_theme_options',
			'priority' => 2,
		) 
	);
	
	$wp_customize->add_control(
	'the_retail_storefront_index_sidebar_setting', 
		array(
			'label'	      => esc_html__( 'Hide / Show Index Sidebar', 'the-retail-storefront' ),
			'section'     => 'the_retail_storefront_sidebar_settings',
			'settings'    => 'the_retail_storefront_index_sidebar_setting',
			'type'        => 'checkbox'
		) 
	);

	// Pages Sidebar Hide/ Show Setting // 
	$wp_customize->add_setting( 
		'the_retail_storefront_paged_sidebar_setting' , 
			array(
			'default' => '1',
			'sanitize_callback' => 'the_retail_storefront_sanitize_checkbox',
			'capability' => 'edit_theme_options',
			'priority' => 2,
		) 
	);
	
	$wp_customize->add_control(
	'the_retail_storefront_paged_sidebar_setting', 
		array(
			'label'	      => esc_html__( 'Hide / Show Pages Sidebar', 'the-retail-storefront' ),
			'section'     => 'the_retail_storefront_sidebar_settings',
			'settings'    => 'the_retail_storefront_paged_sidebar_setting',
			'type'        => 'checkbox'
		) 
	);

	// Search Result Sidebar Hide/ Show Setting // 
	$wp_customize->add_setting( 
		'the_retail_storefront_search_result_sidebar_setting' , 
			array(
			'default' => '1',
			'sanitize_callback' => 'the_retail_storefront_sanitize_checkbox',
			'capability' => 'edit_theme_options',
			'priority' => 2,
		) 
	);
	
	$wp_customize->add_control(
	'the_retail_storefront_search_result_sidebar_setting', 
		array(
			'label'	      => esc_html__( 'Hide / Show Search Result Sidebar', 'the-retail-storefront' ),
			'section'     => 'the_retail_storefront_sidebar_settings',
			'settings'    => 'the_retail_storefront_search_result_sidebar_setting',
			'type'        => 'checkbox'
		) 
	);

	// Single Post Sidebar Hide/ Show Setting // 
	$wp_customize->add_setting( 
		'the_retail_storefront_single_post_sidebar_setting' , 
			array(
			'default' => '1',
			'sanitize_callback' => 'the_retail_storefront_sanitize_checkbox',
			'capability' => 'edit_theme_options',
			'priority' => 2,
		) 
	);
	
	$wp_customize->add_control(
	'the_retail_storefront_single_post_sidebar_setting', 
		array(
			'label'	      => esc_html__( 'Hide / Show Single Post Sidebar', 'the-retail-storefront' ),
			'section'     => 'the_retail_storefront_sidebar_settings',
			'settings'    => 'the_retail_storefront_single_post_sidebar_setting',
			'type'        => 'checkbox'
		) 
	);

	// Sidebar Page Sidebar Date Hide/ Show Setting // 
	$wp_customize->add_setting( 
		'the_retail_storefront_single_page_sidebar_setting' , 
			array(
			'default' => '1',
			'sanitize_callback' => 'the_retail_storefront_sanitize_checkbox',
			'capability' => 'edit_theme_options',
			'priority' => 2,
		) 
	);
	
	$wp_customize->add_control(
	'the_retail_storefront_single_page_sidebar_setting', 
		array(
			'label'	      => esc_html__( 'Hide / Show Page Width Sidebar', 'the-retail-storefront' ),
			'section'     => 'the_retail_storefront_sidebar_settings',
			'settings'    => 'the_retail_storefront_single_page_sidebar_setting',
			'type'        => 'checkbox'
		) 
	);

	$wp_customize->add_setting( 'the_retail_storefront_sidebar_position', array(
        'default'   => 'right',
        'sanitize_callback' => 'the_retail_storefront_sanitize_sidebar_position',
    ));

    $wp_customize->add_control( 'the_retail_storefront_sidebar_position', array(
        'label'    => __( 'Sidebar Position', 'the-retail-storefront' ),
        'section'  => 'the_retail_storefront_sidebar_settings',
        'settings' => 'the_retail_storefront_sidebar_position',
        'type'     => 'radio',
        'choices'  => array(
            'right' => __( 'Right Sidebar', 'the-retail-storefront' ),
            'left'  => __( 'Left Sidebar', 'the-retail-storefront' ),
        ),
    ));

	 $wp_customize->add_setting( 'the_retail_storefront_upgrade_page_settings_15',
        array(
            'sanitize_callback' => 'sanitize_text_field'
        )
    );
    $wp_customize->add_control( new The_Retail_Storefront_Control_Upgrade(
        $wp_customize, 'the_retail_storefront_upgrade_page_settings_15',
            array(
                'priority'      => 200,
                'section'       => 'the_retail_storefront_sidebar_settings',
                'settings'      => 'the_retail_storefront_upgrade_page_settings_15',
                'label'         => __( 'The Retail Storefront Pro comes with additional features.', 'the-retail-storefront' ),
                'choices'       => array( __( '15+ Ready-Made Sections', 'the-retail-storefront' ), __( 'One-Click Demo Import', 'the-retail-storefront' ), __( 'WooCommerce Integrated', 'the-retail-storefront' ), __( 'Drag & Drop Section Reordering', 'the-retail-storefront' ),__( 'Advanced Typography Control', 'the-retail-storefront' ),__( 'Intuitive Customization Options', 'the-retail-storefront' ),__( '24/7 Support', 'the-retail-storefront' ), )
            )
        )
    ); 
}

add_action( 'customize_register', 'the_retail_storefront_sidebar_setting' );