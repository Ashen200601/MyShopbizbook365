<?php
function the_retail_storefront_post_setting( $wp_customize ) {
$selective_refresh = isset( $wp_customize->selective_refresh ) ? 'postMessage' : 'refresh';
	$wp_customize->add_panel(
		'the_retail_storefront_post', array(
			'priority' => 31,
			'title' => esc_html__( 'Post Options', 'the-retail-storefront' ),
		)
	);

	/*=========================================
	Archive Post  Section
	=========================================*/
	$wp_customize->add_section(
		'the_retail_storefront_archive_post_setting', array(
			'title' => esc_html__( 'Archive Post', 'the-retail-storefront' ),
			'priority' => 1,
			'panel' => 'the_retail_storefront_post',
		)
	);

	// Layouts Post
	$wp_customize->add_setting('the_retail_storefront_blog_layout_option_setting',array(
	  'default' => 'Default',
	  'sanitize_callback' => 'the_retail_storefront_sanitize_choices'
	));
	$wp_customize->add_control(new The_Retail_Storefront_Image_Radio_Control($wp_customize, 'the_retail_storefront_blog_layout_option_setting', array(
	  'type' => 'select',
	  'label' => __('Blog Post Layouts','the-retail-storefront'),
	  'section' => 'the_retail_storefront_archive_post_setting',
	  'choices' => array(
		'Default' => esc_url(get_template_directory_uri()).'/assets/images/layout-1.png',
		'Left' => esc_url(get_template_directory_uri()).'/assets/images/layout-2.png',
		'Right' => esc_url(get_template_directory_uri()).'/assets/images/layout-3.png',
	))));
		
	// Post Heading Hide/ Show Setting // 
	$wp_customize->add_setting( 
		'the_retail_storefront_post_heading_settings' , 
			array(
			'default' => '1',
			'sanitize_callback' => 'the_retail_storefront_sanitize_checkbox',
			'capability' => 'edit_theme_options',
			'priority' => 2,
		) 
	);
	
	$wp_customize->add_control(
		'the_retail_storefront_post_heading_settings', 
		array(
			'label'	      => esc_html__( 'Hide / Show Post Heading', 'the-retail-storefront' ),
			'section'     => 'the_retail_storefront_archive_post_setting',
			'settings'    => 'the_retail_storefront_post_heading_settings',
			'type'        => 'checkbox'
		) 
	);

	// Post Content Hide/ Show Setting // 
	$wp_customize->add_setting( 
		'the_retail_storefront_post_content_settings' , 
			array(
			'default' => '1',
			'sanitize_callback' => 'the_retail_storefront_sanitize_checkbox',
			'capability' => 'edit_theme_options',
			'priority' => 2,
		) 
	);
	
	$wp_customize->add_control(
	'the_retail_storefront_post_content_settings', 
		array(
			'label'	      => esc_html__( 'Hide / Show Post Content', 'the-retail-storefront' ),
			'section'     => 'the_retail_storefront_archive_post_setting',
			'settings'    => 'the_retail_storefront_post_content_settings',
			'type'        => 'checkbox'
		) 
	);

	// Post Featured Hide/ Show Setting // 
	$wp_customize->add_setting( 
		'the_retail_storefront_post_featured_image_settings' , 
			array(
			'default' => '1',
			'sanitize_callback' => 'the_retail_storefront_sanitize_checkbox',
			'capability' => 'edit_theme_options',
			'priority' => 2,
		) 
	);
	
	$wp_customize->add_control(
	'the_retail_storefront_post_featured_image_settings', 
		array(
			'label'	      => esc_html__( 'Hide / Show Post Feature Image', 'the-retail-storefront' ),
			'section'     => 'the_retail_storefront_archive_post_setting',
			'settings'    => 'the_retail_storefront_post_featured_image_settings',
			'type'        => 'checkbox'
		) 
	);

	// Post Date Hide/ Show Setting // 
	$wp_customize->add_setting( 
		'the_retail_storefront_post_date_settings' , 
			array(
			'default' => '1',
			'sanitize_callback' => 'the_retail_storefront_sanitize_checkbox',
			'capability' => 'edit_theme_options',
			'priority' => 2,
		) 
	);
	
	$wp_customize->add_control(
	'the_retail_storefront_post_date_settings', 
		array(
			'label'	      => esc_html__( 'Hide / Show Post Date', 'the-retail-storefront' ),
			'section'     => 'the_retail_storefront_archive_post_setting',
			'settings'    => 'the_retail_storefront_post_date_settings',
			'type'        => 'checkbox'
		) 
	);

	// Post Date Hide/ Show Setting // 
	$wp_customize->add_setting( 
		'the_retail_storefront_post_comments_settings' , 
			array(
			'default' => '1',
			'sanitize_callback' => 'the_retail_storefront_sanitize_checkbox',
			'capability' => 'edit_theme_options',
			'priority' => 2,
		) 
	);
	
	$wp_customize->add_control(
	'the_retail_storefront_post_comments_settings', 
		array(
			'label'	      => esc_html__( 'Hide / Show Post Comment', 'the-retail-storefront' ),
			'section'     => 'the_retail_storefront_archive_post_setting',
			'settings'    => 'the_retail_storefront_post_comments_settings',
			'type'        => 'checkbox'
		) 
	);

	// Post Date Hide/ Show Setting // 
	$wp_customize->add_setting( 
		'the_retail_storefront_post_author_settings' , 
			array(
			'default' => '1',
			'sanitize_callback' => 'the_retail_storefront_sanitize_checkbox',
			'capability' => 'edit_theme_options',
			'priority' => 2,
		) 
	);
	
	$wp_customize->add_control(
	'the_retail_storefront_post_author_settings', 
		array(
			'label'	      => esc_html__( 'Hide / Show Post Author', 'the-retail-storefront' ),
			'section'     => 'the_retail_storefront_archive_post_setting',
			'settings'    => 'the_retail_storefront_post_author_settings',
			'type'        => 'checkbox'
		) 
	);

	// Post Timing Hide/ Show Setting // 
	$wp_customize->add_setting( 
		'the_retail_storefront_post_timing_settings' , 
			array(
			'default' => '1',
			'sanitize_callback' => 'the_retail_storefront_sanitize_checkbox',
			'capability' => 'edit_theme_options',
			'priority' => 2,
		) 
	);
	
	$wp_customize->add_control(
	'the_retail_storefront_post_timing_settings', 
		array(
			'label'	      => esc_html__( 'Hide / Show Post Timings', 'the-retail-storefront' ),
			'section'     => 'the_retail_storefront_archive_post_setting',
			'settings'    => 'the_retail_storefront_post_timing_settings',
			'type'        => 'checkbox'
		) 
	);

	// Post Tags Hide/ Show Setting // 
	$wp_customize->add_setting( 
		'the_retail_storefront_post_tags_settings' , 
			array(
			'default' => '1',
			'sanitize_callback' => 'the_retail_storefront_sanitize_checkbox',
			'capability' => 'edit_theme_options',
			'priority' => 2,
		) 
	);
	
	$wp_customize->add_control(
	'the_retail_storefront_post_tags_settings', 
		array(
			'label'	      => esc_html__( 'Hide / Show Post Tags', 'the-retail-storefront' ),
			'section'     => 'the_retail_storefront_archive_post_setting',
			'settings'    => 'the_retail_storefront_post_tags_settings',
			'type'        => 'checkbox'
		) 
	);

	$wp_customize->add_setting('the_retail_storefront_excerpt_limit', array(
        'default'           => 50,
        'sanitize_callback' => 'absint',
    ));

    $wp_customize->add_control('the_retail_storefront_excerpt_limit', array(
        'label'   => __('Excerpt Word Limit', 'the-retail-storefront'),
        'section' => 'the_retail_storefront_archive_post_setting',
        'type'    => 'number',
    ));

	$wp_customize->add_setting( 'the_retail_storefront_upgrade_page_settings_133',
	array(
		'sanitize_callback' => 'sanitize_text_field'
		)
	);
	$wp_customize->add_control( new The_Retail_Storefront_Control_Upgrade(
		$wp_customize, 'the_retail_storefront_upgrade_page_settings_133',
			array(
				'priority'      => 200,
				'section'       => 'the_retail_storefront_archive_post_setting',
				'settings'      => 'the_retail_storefront_upgrade_page_settings_133',
				'label'         => __( 'The Retail Storefront Pro comes with additional features.', 'the-retail-storefront' ),
				'choices'       => array( __( '15+ Ready-Made Sections', 'the-retail-storefront' ), __( 'One-Click Demo Import', 'the-retail-storefront' ), __( 'WooCommerce Integrated', 'the-retail-storefront' ), __( 'Drag & Drop Section Reordering', 'the-retail-storefront' ),__( 'Advanced Typography Control', 'the-retail-storefront' ),__( 'Intuitive Customization Options', 'the-retail-storefront' ),__( '24/7 Support', 'the-retail-storefront' ), )
			)
		)
	); 

	/*=========================================
	Single Post  Section
	=========================================*/
	$wp_customize->add_section(
		'the_retail_storefront_single_post', array(
			'title' => esc_html__( 'Single Post', 'the-retail-storefront' ),
			'priority' => 3,
			'panel' => 'the_retail_storefront_post',
		)
	);
	
	// Post Heading Hide/ Show Setting // 
	$wp_customize->add_setting( 
		'the_retail_storefront_single_post_heading_settings' , 
			array(
			'default' => '1',
			'sanitize_callback' => 'the_retail_storefront_sanitize_checkbox',
			'capability' => 'edit_theme_options',
			'priority' => 2,
		) 
	);
	
	$wp_customize->add_control(
	'the_retail_storefront_single_post_heading_settings', 
		array(
			'label'	      => esc_html__( 'Hide / Show Post Heading', 'the-retail-storefront' ),
			'section'     => 'the_retail_storefront_single_post',
			'settings'    => 'the_retail_storefront_single_post_heading_settings',
			'type'        => 'checkbox'
		) 
	);

	// Post Content Hide/ Show Setting // 
	$wp_customize->add_setting( 
		'the_retail_storefront_single_post_content_settings' , 
			array(
			'default' => '1',
			'sanitize_callback' => 'the_retail_storefront_sanitize_checkbox',
			'capability' => 'edit_theme_options',
			'priority' => 2,
		) 
	);
	
	$wp_customize->add_control(
	'the_retail_storefront_single_post_content_settings', 
		array(
			'label'	      => esc_html__( 'Hide / Show Post Content', 'the-retail-storefront' ),
			'section'     => 'the_retail_storefront_single_post',
			'settings'    => 'the_retail_storefront_single_post_content_settings',
			'type'        => 'checkbox'
		) 
	);

	// Post Featured Hide/ Show Setting // 
	$wp_customize->add_setting( 
		'the_retail_storefront_single_post_featured_image_settings' , 
			array(
			'default' => '1',
			'sanitize_callback' => 'the_retail_storefront_sanitize_checkbox',
			'capability' => 'edit_theme_options',
			'priority' => 2,
		) 
	);
	
	$wp_customize->add_control(
	'the_retail_storefront_single_post_featured_image_settings', 
		array(
			'label'	      => esc_html__( 'Hide / Show Post Feature Image', 'the-retail-storefront' ),
			'section'     => 'the_retail_storefront_single_post',
			'settings'    => 'the_retail_storefront_single_post_featured_image_settings',
			'type'        => 'checkbox'
		) 
	);

	// Post Date Hide/ Show Setting // 
	$wp_customize->add_setting( 
		'the_retail_storefront_single_post_date_settings' , 
			array(
			'default' => '1',
			'sanitize_callback' => 'the_retail_storefront_sanitize_checkbox',
			'capability' => 'edit_theme_options',
			'priority' => 2,
		) 
	);
	
	$wp_customize->add_control(
	'the_retail_storefront_single_post_date_settings', 
		array(
			'label'	      => esc_html__( 'Hide / Show Post Date', 'the-retail-storefront' ),
			'section'     => 'the_retail_storefront_single_post',
			'settings'    => 'the_retail_storefront_single_post_date_settings',
			'type'        => 'checkbox'
		) 
	);

	// Post Date Hide/ Show Setting // 
	$wp_customize->add_setting( 
		'the_retail_storefront_single_post_comments_settings' , 
			array(
			'default' => '1',
			'sanitize_callback' => 'the_retail_storefront_sanitize_checkbox',
			'capability' => 'edit_theme_options',
			'priority' => 2,
		) 
	);
	
	$wp_customize->add_control(
	'the_retail_storefront_single_post_comments_settings', 
		array(
			'label'	      => esc_html__( 'Hide / Show Post Comment', 'the-retail-storefront' ),
			'section'     => 'the_retail_storefront_single_post',
			'settings'    => 'the_retail_storefront_single_post_comments_settings',
			'type'        => 'checkbox'
		) 
	);

	// Post Date Hide/ Show Setting // 
	$wp_customize->add_setting( 
		'the_retail_storefront_single_post_author_settings' , 
			array(
			'default' => '1',
			'sanitize_callback' => 'the_retail_storefront_sanitize_checkbox',
			'capability' => 'edit_theme_options',
			'priority' => 2,
		) 
	);
	
	$wp_customize->add_control(
	'the_retail_storefront_single_post_author_settings', 
		array(
			'label'	      => esc_html__( 'Hide / Show Post Author', 'the-retail-storefront' ),
			'section'     => 'the_retail_storefront_single_post',
			'settings'    => 'the_retail_storefront_single_post_author_settings',
			'type'        => 'checkbox'
		) 
	);

	// Post Date Hide/ Show Setting // 
	$wp_customize->add_setting( 
		'the_retail_storefront_single_post_timing_settings' , 
			array(
			'default' => '1',
			'sanitize_callback' => 'the_retail_storefront_sanitize_checkbox',
			'capability' => 'edit_theme_options',
			'priority' => 2,
		) 
	);
	
	$wp_customize->add_control(
	'the_retail_storefront_single_post_timing_settings', 
		array(
			'label'	      => esc_html__( 'Hide / Show Post Timings', 'the-retail-storefront' ),
			'section'     => 'the_retail_storefront_single_post',
			'settings'    => 'the_retail_storefront_single_post_timing_settings',
			'type'        => 'checkbox'
		) 
	);

	// Post Tags Hide/ Show Setting // 
	$wp_customize->add_setting( 
		'the_retail_storefront_single_post_tags_settings' , 
			array(
			'default' => '1',
			'sanitize_callback' => 'the_retail_storefront_sanitize_checkbox',
			'capability' => 'edit_theme_options',
			'priority' => 2,
		) 
	);
	
	$wp_customize->add_control(
	'the_retail_storefront_single_post_tags_settings', 
		array(
			'label'	      => esc_html__( 'Hide / Show Post Tags', 'the-retail-storefront' ),
			'section'     => 'the_retail_storefront_single_post',
			'settings'    => 'the_retail_storefront_single_post_tags_settings',
			'type'        => 'checkbox'
		) 
	);

	// Related Posts Hide/ Show Setting // 
	$wp_customize->add_setting( 
		'the_retail_storefront_show_hide_related_post' , 
			array(
			'default' => '1',
			'sanitize_callback' => 'the_retail_storefront_sanitize_checkbox',
			'capability' => 'edit_theme_options',
			'priority' => 2,
		) 
	);
	
	$wp_customize->add_control(
	'the_retail_storefront_show_hide_related_post', 
		array(
			'label'	      => esc_html__( 'Hide / Show Related Posts', 'the-retail-storefront' ),
			'section'     => 'the_retail_storefront_single_post',
			'settings'    => 'the_retail_storefront_show_hide_related_post',
			'type'        => 'checkbox'
		) 
	);

	$wp_customize->add_setting( 
    	'the_retail_storefront_related_posts_heading',
    	array(
			'default' => 'Related Posts',
			'capability'     	=> 'edit_theme_options',
			'sanitize_callback' => 'sanitize_text_field',
			'priority'      => 1,
		)
	);	

	$wp_customize->add_control( 
		'the_retail_storefront_related_posts_heading',
		array(
		    'label'   		=> __('Related Post Heading','the-retail-storefront'),
		    'section'		=> 'the_retail_storefront_single_post',
			'type' 			=> 'text',
			'transport'         => $selective_refresh,
		)
	);

	$wp_customize->add_setting('the_retail_storefront_related_post_counts', array(
        'default'           => 3,
        'sanitize_callback' => 'absint',
    ));

    $wp_customize->add_control('the_retail_storefront_related_post_counts', array(
        'label'   => __('Number Of Related Posts To Show', 'the-retail-storefront'),
        'section' => 'the_retail_storefront_single_post',
        'type'    => 'number',
    ));

	$wp_customize->add_setting( 'the_retail_storefront_upgrade_page_settings_58',
	array(
		'sanitize_callback' => 'sanitize_text_field'
	)
	);
	$wp_customize->add_control( new The_Retail_Storefront_Control_Upgrade(
		$wp_customize, 'the_retail_storefront_upgrade_page_settings_58',
			array(
				'priority'      => 200,
				'section'       => 'the_retail_storefront_single_post',
				'settings'      => 'the_retail_storefront_upgrade_page_settings_58',
				'label'         => __( 'The Retail Storefront Pro comes with additional features.', 'the-retail-storefront' ),
				'choices'       => array( __( '15+ Ready-Made Sections', 'the-retail-storefront' ), __( 'One-Click Demo Import', 'the-retail-storefront' ), __( 'WooCommerce Integrated', 'the-retail-storefront' ), __( 'Drag & Drop Section Reordering', 'the-retail-storefront' ),__( 'Advanced Typography Control', 'the-retail-storefront' ),__( 'Intuitive Customization Options', 'the-retail-storefront' ),__( '24/7 Support', 'the-retail-storefront' ), )
			)
		)
	); 
}

add_action( 'customize_register', 'the_retail_storefront_post_setting' );