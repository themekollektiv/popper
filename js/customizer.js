/**
 * customizer.js
 *
 * Theme Customizer enhancements for a better user experience.
 *
 * Contains handlers to make Theme Customizer preview reload changes asynchronously.
 */

( function( $ ) {
	// Site title and description.
	wp.customize( 'blogname', function( value ) {
		value.bind( function( to ) {
			$( '.site-title a' ).text( to );
		} );
	} );
	wp.customize( 'blogdescription', function( value ) {
		value.bind( function( to ) {
			console.log(to);
			$( '.site-description' ).text( to );
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
				$( '.site-title a, .site-description' ).css( {
					'clip': 'auto',
					'color': to,
					'position': 'relative'
				} );
				$( '.site-title::after' ).css( {
					'border-color': to
				} );
			}
		} );
	} );
	// Header background color.
	wp.customize( 'header_color', function( value ) {
		value.bind( function( to ) {
			$( '.site-header' ).css( {
				'background-color': to
			} );
		} );
	} );

	// Condition for when header background is white
	wp.customize( 'header_color', function( value ) {
		value.bind( function( to ) {
			if ( '#ffffff' === to ) {
				style = $( 'head' ).append( '<style type="text/css" id="whiteout"> .main-navigation { background-color: transparent; } @media screen and (min-width: 50em) {.main-navigation.toggled { background-color: transparent; }.main-navigation a,.main-navigation a:hover,.main-navigation a:focus,.dropdown-toggle { color: #000; outline-color: #000;}.dropdown-toggle {background-color: transparent;}.dropdown-toggle:hover,.dropdown-toggle:focus {background-color: #fff;outline: 1px solid #000;}.main-navigation ul ul a,ul ul .dropdown-toggle {color: #fff;}.main-navigation ul ul a:hover,.main-navigation ul ul a:focus {outline-color: #B3B3B3;}}</style>' );
			} else {
				$('#whiteout').remove();
			}
		} );
	} );

	// Sidebar position
	wp.customize( 'layout_setting', function( value ) {
		value.bind( function( to ) {
			// Remove whatever layout class was there before
			$( '#page' ).removeClass( 'no-sidebar sidebar-left sidebar-right');
			// Add new layout class
			$( '#page' ).addClass( to );
		} );
	} );
} )( jQuery );
