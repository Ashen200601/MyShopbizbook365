<?php
function the_retail_storefront_typography_setting( $wp_customize ) {
$selective_refresh = isset( $wp_customize->selective_refresh ) ? 'postMessage' : 'refresh';
	$wp_customize->add_panel(
		'the_retail_storefront_typography', array(
			'priority' => 31,
			'title' => esc_html__( 'Typography Options', 'the-retail-storefront' ),
		)
	);

	/*=========================================
	Archive Post  Section
	=========================================*/
	$wp_customize->add_section(
		'the_retail_storefront_typography_settings', array(
			'title' => esc_html__( 'Heading/Content Typography Options', 'the-retail-storefront' ),
			'priority' => 1,
			'panel' => 'the_retail_storefront_typography',
		)
	);
	$the_retail_storefront_font_choices = array(
		'' => 'Select',
		'Source Sans Pro:400,700,400italic,700italic' => 'Source Sans Pro',
		'Open Sans:400italic,700italic,400,700' => 'Open Sans',
		'Oswald:400,700' => 'Oswald',
		'Playfair Display:400,700,400italic' => 'Playfair Display',
		'Montserrat:400,700' => 'Montserrat',
		'Raleway:400,700' => 'Raleway',
		'Droid Sans:400,700' => 'Droid Sans',
		'Lato:400,700,400italic,700italic' => 'Lato',
		'Arvo:400,700,400italic,700italic' => 'Arvo',
		'Lora:400,700,400italic,700italic' => 'Lora',
		'Merriweather:400,300italic,300,400italic,700,700italic' => 'Merriweather',
		'Oxygen:400,300,700' => 'Oxygen',
		'PT Serif:400,700' => 'PT Serif',
		'PT Sans:400,700,400italic,700italic' => 'PT Sans',
		'PT Sans Narrow:400,700' => 'PT Sans Narrow',
		'Cabin:400,700,400italic' => 'Cabin',
		'Fjalla One:400' => 'Fjalla One',
		'Francois One:400' => 'Francois One',
		'Josefin Sans:400,300,600,700' => 'Josefin Sans',
		'Libre Baskerville:400,400italic,700' => 'Libre Baskerville',
		'Arimo:400,700,400italic,700italic' => 'Arimo',
		'Ubuntu:400,700,400italic,700italic' => 'Ubuntu',
		'Bitter:400,700,400italic' => 'Bitter',
		'Droid Serif:400,700,400italic,700italic' => 'Droid Serif',
		'Roboto:400,400italic,700,700italic' => 'Roboto',
		'Open Sans Condensed:700,300italic,300' => 'Open Sans Condensed',
		'Roboto Condensed:400italic,700italic,400,700' => 'Roboto Condensed',
		'Roboto Slab:400,700' => 'Roboto Slab',
		'Yanone Kaffeesatz:400,700' => 'Yanone Kaffeesatz',
		'Rokkitt:400' => 'Rokkitt',
		'Inter:400,500,600,700' => 'Inter'
	);

	$wp_customize->add_setting( 'the_retail_storefront_headings_text', array(
		'sanitize_callback' => 'the_retail_storefront_sanitize_fonts',
	));

	$wp_customize->add_control( 'the_retail_storefront_headings_text', array(
		'type' => 'select',
		'description' => __('Select your appropriate font for the headings.', 'the-retail-storefront'),
		'section' => 'the_retail_storefront_typography_settings',
		'choices' => $the_retail_storefront_font_choices

	));

	$wp_customize->add_setting( 'the_retail_storefront_body_text', array(
		'sanitize_callback' => 'the_retail_storefront_sanitize_fonts'
	));

	$wp_customize->add_control( 'the_retail_storefront_body_text', array(
		'type' => 'select',
		'description' => __( 'Select your appropriate font for the body.', 'the-retail-storefront' ),
		'section' => 'the_retail_storefront_typography_settings',
		'choices' => $the_retail_storefront_font_choices
	) );
	
	$wp_customize->add_section(
	'the_retail_storefront_dynamic_color_settings', array(
		'title' => esc_html__( 'Dynamic Color Options', 'the-retail-storefront' ),
		'priority' => 1,
		'panel' => 'the_retail_storefront_typography',
		)
	);

	$wp_customize->add_setting('the_retail_storefront_dynamic_color_one', array(
        'default'           => '#FE816D',
        'sanitize_callback' => 'sanitize_hex_color',
    ));
    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'the_retail_storefront_dynamic_color_one', array(
        'label'    => __('First Dynamic Color', 'the-retail-storefront'),
        'section'  => 'the_retail_storefront_dynamic_color_settings',
    )));

	$wp_customize->add_setting( 'the_retail_storefront_upgrade_page_settings_20_color',
        array(
            'sanitize_callback' => 'sanitize_text_field'
        )
    );
    $wp_customize->add_control( new The_Retail_Storefront_Control_Upgrade(
        $wp_customize, 'the_retail_storefront_upgrade_page_settings_20_color',
            array(
                'priority'      => 200,
                'section'       => 'the_retail_storefront_dynamic_color_settings',
                'settings'      => 'the_retail_storefront_upgrade_page_settings_20_color',
                'label'         => __( 'The Retail Storefront Pro comes with additional features.', 'the-retail-storefront' ),
                'choices'       => array( __( '15+ Ready-Made Sections', 'the-retail-storefront' ), __( 'One-Click Demo Import', 'the-retail-storefront' ), __( 'WooCommerce Integrated', 'the-retail-storefront' ), __( 'Drag & Drop Section Reordering', 'the-retail-storefront' ),__( 'Advanced Typography Control', 'the-retail-storefront' ),__( 'Intuitive Customization Options', 'the-retail-storefront' ),__( '24/7 Support', 'the-retail-storefront' ), )
            )
        )
    ); 

	$wp_customize->add_setting( 'the_retail_storefront_upgrade_page_settings_20',
        array(
            'sanitize_callback' => 'sanitize_text_field'
        )
    );
    $wp_customize->add_control( new The_Retail_Storefront_Control_Upgrade(
        $wp_customize, 'the_retail_storefront_upgrade_page_settings_20',
            array(
                'priority'      => 200,
                'section'       => 'the_retail_storefront_typography_settings',
                'settings'      => 'the_retail_storefront_upgrade_page_settings_20',
                'label'         => __( 'The Retail Storefront Pro comes with additional features.', 'the-retail-storefront' ),
                'choices'       => array( __( '15+ Ready-Made Sections', 'the-retail-storefront' ), __( 'One-Click Demo Import', 'the-retail-storefront' ), __( 'WooCommerce Integrated', 'the-retail-storefront' ), __( 'Drag & Drop Section Reordering', 'the-retail-storefront' ),__( 'Advanced Typography Control', 'the-retail-storefront' ),__( 'Intuitive Customization Options', 'the-retail-storefront' ),__( '24/7 Support', 'the-retail-storefront' ), )
            )
        )
    ); 

}

add_action( 'customize_register', 'the_retail_storefront_typography_setting' );