/**
 * File customizer.js.
 *
 * Theme Customizer enhancements for a better user experience.
 *
 * Contains handlers to make Theme Customizer preview reload changes asynchronously.
 */

( function( $ ) {
	
	// Site title and description.
	wp.customize( 'blogname', function( value ) {
		value.bind( function( to ) {
			$( '.site-title' ).text( to );
		} );
	} );
	wp.customize( 'blogdescription', function( value ) {
		value.bind( function( to ) {
			$( '.site-description' ).text( to );
		} );
	} );

	wp.customize( 'the_retail_storefront_logo_width', function( value ) {
		value.bind( function( to ) {
			$( '.main-header .logo a.custom-logo-link img' ).css( "max-width", to + 'px' );
		} );
	} );

	// top header.
	wp.customize( 'top_header_txt', function( value ) {
		value.bind( function( to ) {
			$( '.site-title' ).text( to );
		} );
	} );


	// Header text color.
	wp.customize( 'header_textcolor', function( value ) {
		value.bind( function( to ) {
			if ( 'blank' === to ) {
				$( '.site-title, .site-description' ).css( {
					'clip': 'rect(1px, 1px, 1px, 1px)',
					'position': 'absolute'
				} );
			} else {
				$( '.site-title, .site-description' ).css( {
					'clip': 'auto',
					'position': 'relative'
				} );
				$( '.site-title, .site-description' ).css( {
					'color': to
				} );
			}
		} );
	} );
	
	$(document).ready(function ($) {
        $('input[data-input-type]').on('input change', function () {
            var val = $(this).val();
            $(this).prev('.cs-range-value').html(val);
            $(this).val(val);
        });
    })
	
	/**
	 * logo_width
	 */
	wp.customize( 'logo_width', function( value ) {
		value.bind( function( width ) {
			jQuery( '.logo img, .mobile-logo img' ).css( 'max-width', width + 'px' );
		} );
	} );
	
} )( jQuery );