<?php
function the_retail_storefront_header_settings( $wp_customize ) {
$selective_refresh = isset( $wp_customize->selective_refresh ) ? 'postMessage' : 'refresh';

    // Site Title Hide/ Show Setting // 
	$wp_customize->add_setting( 
		'the_retail_storefront_site_title_setting' , 
			array(
			'default' => '1',
			'sanitize_callback' => 'the_retail_storefront_sanitize_checkbox',
			'capability' => 'edit_theme_options',
		) 
	);
	
	$wp_customize->add_control(
	'the_retail_storefront_site_title_setting', 
		array(
			'label'	      => esc_html__( 'Hide / Show Site Title', 'the-retail-storefront' ),
			'section'     => 'title_tagline',
			'settings'    => 'the_retail_storefront_site_title_setting',
			'type'        => 'checkbox'
		) 
	);

	// Tagline Hide/ Show Setting // 
	$wp_customize->add_setting( 
		'the_retail_storefront_tagline_setting' , 
			array(
			'sanitize_callback' => 'the_retail_storefront_sanitize_checkbox',
			'capability' => 'edit_theme_options',
		) 
	);
	
	$wp_customize->add_control(
	'the_retail_storefront_tagline_setting', 
		array(
			'label'	      => esc_html__( 'Hide / Show Tagline', 'the-retail-storefront' ),
			'section'     => 'title_tagline',
			'settings'    => 'the_retail_storefront_tagline_setting',
			'type'        => 'checkbox'
		) 
	);

	// Add the setting for logo width
	$wp_customize->add_setting(
	    'the_retail_storefront_logo_width',
	    array(
	        'default'           => '100',
	        'sanitize_callback' => 'the_retail_storefront_sanitize_logo_width',
	        'priority'          => 2,
	    )
	);

	// Add control for logo width
	$wp_customize->add_control( 
	    'the_retail_storefront_logo_width',
	    array(
	        'label'     => __('Logo Width', 'the-retail-storefront'),
	        'section'   => 'title_tagline',
	        'type'      => 'number',
	        'input_attrs' => array(
	            'min'   => 1,
	            'max'   => 150,
	            'step'  => 1,
	        ),
	        'transport' => $selective_refresh,
	    )  
	);

	$wp_customize->add_setting( 'the_retail_storefront_upgrade_page_settings_101',
        array(
            'sanitize_callback' => 'sanitize_text_field'
        )
    );
    $wp_customize->add_control( new The_Retail_Storefront_Control_Upgrade(
        $wp_customize, 'the_retail_storefront_upgrade_page_settings_101',
            array(
                'priority'      => 200,
                'section'       => 'title_tagline',
                'settings'      => 'the_retail_storefront_upgrade_page_settings_101',
                'label'         => __( 'The Retail Storefront Pro comes with additional features.', 'the-retail-storefront' ),
                'choices'       => array( __( '15+ Ready-Made Sections', 'the-retail-storefront' ), __( 'One-Click Demo Import', 'the-retail-storefront' ), __( 'WooCommerce Integrated', 'the-retail-storefront' ), __( 'Drag & Drop Section Reordering', 'the-retail-storefront' ),__( 'Advanced Typography Control', 'the-retail-storefront' ),__( 'Intuitive Customization Options', 'the-retail-storefront' ),__( '24/7 Support', 'the-retail-storefront' ), )
            )
        )
    ); 

	/*=========================================
	The Retail Storefront Site Identity
	=========================================*/
	$wp_customize->add_section(
        'title_tagline',
        array(
        	'priority'      => 1,
            'title' 		=> __('Site Identity','the-retail-storefront'),
			'panel'  		=> 'the_retail_storefront_frontpage_sections',
		)
    );    

	/*=========================================
	Top header
	=========================================*/
	$wp_customize->add_section(
        'the_retail_storefront_top_header',
        array(
        	'priority'      => 2,
            'title' 		=> __('Header Section','the-retail-storefront'),
			'panel'  		=> 'the_retail_storefront_frontpage_sections',
		)
    );

    $wp_customize->add_setting( 
		'the_retail_storefront_currency_switcher' , 
			array(
			'default' => true,
			'sanitize_callback' => 'the_retail_storefront_sanitize_checkbox',
			'capability' => 'edit_theme_options',
			'priority' => 2,
		) 
	);
	
	$wp_customize->add_control(
	'the_retail_storefront_currency_switcher', 
		array(
			'label'	      => esc_html__( 'Show / Hide Currency Switcher', 'the-retail-storefront' ),
			'section'     => 'the_retail_storefront_top_header',
			'settings'    => 'the_retail_storefront_currency_switcher',
			'type'        => 'checkbox'
		) 
	);

	$wp_customize->add_setting( 
		'the_retail_storefront_cart_language_translator' , 
			array(
			'default' => true,
			'sanitize_callback' => 'the_retail_storefront_sanitize_checkbox',
			'capability' => 'edit_theme_options',
			'priority' => 2,
		) 
	);
	
	$wp_customize->add_control(
	'the_retail_storefront_cart_language_translator', 
		array(
			'label'	      => esc_html__( 'Show / Hide Language Translator Option', 'the-retail-storefront' ),
			'section'     => 'the_retail_storefront_top_header',
			'settings'    => 'the_retail_storefront_cart_language_translator',
			'type'        => 'checkbox'
		) 
	);

	$wp_customize->add_setting('the_retail_storefront_topbar_text',array(
		'default'=> 'Welcome to Storefront. We provides best E-Commerce products',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('the_retail_storefront_topbar_text',array(
		'label'	=> __('Topbar Text','the-retail-storefront'),
		'section'=> 'the_retail_storefront_top_header',
		'type'=> 'text'
	));

	$wp_customize->add_setting('the_retail_storefront_call',array(
		'default'=> '1800 1200 110',
		'sanitize_callback'	=> 'the_retail_storefront_sanitize_phone_number'
	));
	$wp_customize->add_control('the_retail_storefront_call',array(
		'label'	=> __('Add Phone Number','the-retail-storefront'),
		'section'=> 'the_retail_storefront_top_header',
		'type'=> 'text'
	));

	$wp_customize->add_setting('the_retail_storefront_mail',array(
		'default'=> 'info@example.com',
		'sanitize_callback'	=> 'sanitize_email'
	));
	$wp_customize->add_control('the_retail_storefront_mail',array(
		'label'	=> __('Add Mail Address','the-retail-storefront'),
		'section'=> 'the_retail_storefront_top_header',
		'type'=> 'text'
	));

	$wp_customize->add_setting( 'the_retail_storefront_upgrade_page_settings_589',
	array(
		'sanitize_callback' => 'sanitize_text_field'
	)
	);
	$wp_customize->add_control( new The_Retail_Storefront_Control_Upgrade(
		$wp_customize, 'the_retail_storefront_upgrade_page_settings_589',
			array(
				'priority'      => 200,
				'section'       => 'the_retail_storefront_top_header',
				'settings'      => 'the_retail_storefront_upgrade_page_settings_589',
				'label'         => __( 'The Retail Storefront Pro comes with additional features.', 'the-retail-storefront' ),
				'choices'       => array( __( '15+ Ready-Made Sections', 'the-retail-storefront' ), __( 'One-Click Demo Import', 'the-retail-storefront' ), __( 'WooCommerce Integrated', 'the-retail-storefront' ), __( 'Drag & Drop Section Reordering', 'the-retail-storefront' ),__( 'Advanced Typography Control', 'the-retail-storefront' ),__( 'Intuitive Customization Options', 'the-retail-storefront' ),__( '24/7 Support', 'the-retail-storefront' ), )
			)
		)
	);

	$wp_customize->register_panel_type( 'The_Retail_Storefront_WP_Customize_Panel' );
	$wp_customize->register_section_type( 'The_Retail_Storefront_WP_Customize_Section' );

}
add_action( 'customize_register', 'the_retail_storefront_header_settings' );


if ( class_exists( 'WP_Customize_Panel' ) ) {
  	class The_Retail_Storefront_WP_Customize_Panel extends WP_Customize_Panel {
	   public $panel;
	   public $type = 'the_retail_storefront_panel';
	   public function json() {

	      $array = wp_array_slice_assoc( (array) $this, array( 'id', 'description', 'priority', 'type', 'panel', ) );
	      $array['title'] = html_entity_decode( $this->title, ENT_QUOTES, get_bloginfo( 'charset' ) );
	      $array['content'] = $this->get_content();
	      $array['active'] = $this->active();
	      $array['instanceNumber'] = $this->instance_number;
	      return $array;
    	}
  	}
}

if ( class_exists( 'WP_Customize_Section' ) ) {
  	class The_Retail_Storefront_WP_Customize_Section extends WP_Customize_Section {
	   public $section;
	   public $type = 'the_retail_storefront_section';
	   public function json() {

	      $array = wp_array_slice_assoc( (array) $this, array( 'id', 'description', 'priority', 'panel', 'type', 'description_hidden', 'section', ) );
	      $array['title'] = html_entity_decode( $this->title, ENT_QUOTES, get_bloginfo( 'charset' ) );
	      $array['content'] = $this->get_content();
	      $array['active'] = $this->active();
	      $array['instanceNumber'] = $this->instance_number;

	      if ( $this->panel ) {
	        $array['customizeAction'] = sprintf( 'Customizing &#9656; %s', esc_html( $this->manager->get_panel( $this->panel )->title ) );
	      } else {
	        $array['customizeAction'] = 'Customizing';
	      }
	      return $array;
    	}
  	}
}