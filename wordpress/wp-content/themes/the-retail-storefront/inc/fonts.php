<?php

/*
 * Props to the BLDR Theme: https://wordpress.org/themes/bldr/
 * */

function the_retail_storefront_custom_styles($the_retail_storefront_custom) {


	//Fonts

	$the_retail_storefront_headings_font = esc_html(get_theme_mod('the_retail_storefront_headings_text'));

	$the_retail_storefront_body_font = esc_html(get_theme_mod('the_retail_storefront_body_text'));

	if ( $the_retail_storefront_headings_font ) {

		$the_retail_storefront_font_pieces = explode(":", $the_retail_storefront_headings_font);

		$the_retail_storefront_custom .= "h1, h2, h3, h4, h5, h6 { font-family: {$the_retail_storefront_font_pieces[0]}; }"."\n";

	}

	if ( $the_retail_storefront_body_font ) {

		$the_retail_storefront_font_pieces = explode(":", $the_retail_storefront_body_font);

		$the_retail_storefront_custom .= "body, button, input, select, textarea { font-family: {$the_retail_storefront_font_pieces[0]} !important; }"."\n";

	}

	//Output all the styles

	wp_add_inline_style( 'the-retail-storefront-style', $the_retail_storefront_custom );

}

add_action( 'wp_enqueue_scripts', 'the_retail_storefront_custom_styles' );


//Sanitizes Fonts
function the_retail_storefront_sanitize_fonts( $the_retail_storefront_input ) {
	$the_retail_storefront_valid = array(
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

	if ( array_key_exists( $the_retail_storefront_input, $the_retail_storefront_valid ) ) {
		return $the_retail_storefront_input;
	} else {
		return '';
	}
}