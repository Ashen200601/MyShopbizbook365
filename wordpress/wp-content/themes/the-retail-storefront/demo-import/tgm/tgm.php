<?php

	require get_template_directory() . '/demo-import/tgm/class-tgm-plugin-activation.php';
/**
 * Recommended plugins.
 */
function the_retail_storefront_register_recommended_plugins() {
	$plugins = array(
		
		array(
			'name'             => __( 'WooCommerce', 'the-retail-storefront' ),
			'slug'             => 'woocommerce',
			'required'         => false,
			'force_activation' => false,
		),
		array(
			'name'             => __( 'YITH WooCommerce Wishlist', 'the-retail-storefront' ),
			'slug'             => 'yith-woocommerce-wishlist',
			'source'           => '',
			'required'         => false,
			'force_activation' => false,
		),
		array(
			'name'             => __( 'Translate WordPress with GTranslate', 'the-retail-storefront' ),
			'slug'             => 'gtranslate',
			'source'           => '',
			'required'         => false,
			'force_activation' => false,
		),
		array(
		    'name'             => __( 'FOX - Currency Switcher', 'the-retail-storefront' ),
		    'slug'             => 'woocommerce-currency-switcher',
		    'required'         => false,
		    'force_activation' => false,
		),

		array(
			'name'             => __( 'FAQly – Ultimate FAQ', 'the-retail-storefront' ),
			'slug'             => 'faqly-ultimate-faq',
			'required'         => false,
			'force_activation' => false,
		)

	);
	$config = array();
	tgmpa( $plugins, $config );
}
add_action( 'tgmpa_register', 'the_retail_storefront_register_recommended_plugins' );