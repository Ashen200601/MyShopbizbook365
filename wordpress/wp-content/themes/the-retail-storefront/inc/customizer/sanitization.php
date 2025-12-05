<?php
/**
 * Customizer: Sanitization Callbacks
 *
 * This file demonstrates how to define sanitization callback functions for various data types.
 * 
 * @package   The Retail Storefront
 * @copyright Copyright (c) 2015, WordPress Theme Review Team
 * @license   http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU General Public License, v2 (or newer)
 */

function the_retail_storefront_sanitize_checkbox( $the_retail_storefront_checked ) {
	return ( ( isset( $the_retail_storefront_checked ) && true == $the_retail_storefront_checked ) ? true : false );
}

/* Sanitization Text*/
function the_retail_storefront_sanitize_text( $the_retail_storefront_text ) {
	return wp_filter_post_kses( $the_retail_storefront_text );
}

function the_retail_storefront_sanitize_choices( $the_retail_storefront_input, $the_retail_storefront_setting ) {
    global $wp_customize; 
    $the_retail_storefront_control = $wp_customize->get_control( $the_retail_storefront_setting->id ); 
    if ( array_key_exists( $the_retail_storefront_input, $the_retail_storefront_control->choices ) ) {
        return $the_retail_storefront_input;
    } else {
        return $the_retail_storefront_setting->default;
    }
}

// Sanitization callback function for numeric input
function the_retail_storefront_sanitize_numeric_input($the_retail_storefront_input) {
    // Remove any non-numeric characters
    return preg_replace('/[^0-9]/', '', $the_retail_storefront_input);
}

// Sanitization callback function for logo width
function the_retail_storefront_sanitize_logo_width($the_retail_storefront_input) {
    $the_retail_storefront_input = absint($the_retail_storefront_input); // Convert to integer
    // Ensure the value is between 1 and 150
    return ($the_retail_storefront_input >= 1 && $the_retail_storefront_input <= 300) ? $the_retail_storefront_input : 150; // Default to 270 if out of range
}

function the_retail_storefront_sanitize_copyright_position( $the_retail_storefront_input ) {
    $valid = array( 'right', 'left', 'center' );

    if ( in_array( $the_retail_storefront_input, $valid, true ) ) {
        return $the_retail_storefront_input;
    } else {
        return 'right';
    }
}

function the_retail_storefront_sanitize_dropdown_pages( $the_retail_storefront_page_id, $the_retail_storefront_setting ) {
  // Ensure $the_retail_storefront_input is an absolute integer.
  $the_retail_storefront_page_id = absint( $the_retail_storefront_page_id );
  // If $the_retail_storefront_page_id is an ID of a published page, return it; otherwise, return the default.
  return ( 'publish' == get_post_status( $the_retail_storefront_page_id ) ? $the_retail_storefront_page_id : $the_retail_storefront_setting->default );
}
function the_retail_storefront_sanitize_number_absint( $the_retail_storefront_number, $the_retail_storefront_setting ) {
    // Ensure $the_retail_storefront_number is an absolute integer (whole number, zero or greater).
    $the_retail_storefront_number = absint( $the_retail_storefront_number );

    // If the input is an absolute integer, return it; otherwise, return the default
    return ( $the_retail_storefront_number ? $the_retail_storefront_number : $the_retail_storefront_setting->default );
}
