/**
 * spin.js jQuery support
 */
(function(factory) {

	if (typeof exports == 'object') {
		// CommonJS
		factory(require('jquery'), require('spin'))
	}
	else if (typeof define == 'function' && define.amd) {
		// AMD, register as anonymous module
		define(['jquery', 'spin'], factory)
	}
	else {
		// Browser globals
		if (!window.Spinner) throw new Error('Spin.js not present')
			factory(window.jQuery, window.Spinner)
	}

	}(function($, Spinner) {

	$.fn.spin = function(opts, color) {

	return this.each(function() {
	var $this = $(this),
	data = $this.data();

	if ( data.spinner ) {
		data.spinner.stop();
		delete data.spinner;
	}

	if ( opts !== false ) {
		opts = $.extend(
			{ color: color || $this.css('color') },
				$.fn.spin.presets[opts] || opts
			)
				data.spinner = new Spinner(opts).spin(this)
			}
		} )
	}

	$.fn.spin.presets = {
		tiny: { lines: 8, length: 2, width: 2, radius: 3 },
		small: { lines: 8, length: 4, width: 3, radius: 5 },
		large: { lines: 10, length: 8, width: 4, radius: 8 }
	}

} ) );

( function( $ ) {

	/**
	 * Spin.js options
	 */
	var spin_opts = {
		lines:     10, // The number of lines to draw
		length:    3, // The length of each line
		width:     1, // The line thickness
		radius:    3, // The radius of the inner circle
		corners:   0, // Corner roundness (0..1)
		rotate:    0, // The rotation offset
		direction: 1, // 1: clockwise, -1: counterclockwise
		color:     '#000000', // #rgb or #rrggbb or array of colors
		speed:     1, // Rounds per second
		trail:     60, // Afterglow percentage
		shadow:    false, // Whether to render a shadow
		hwaccel:   false, // Whether to use hardware acceleration
		className: 'spinner', // The CSS class to assign to the spinner
		zIndex:    2e9, // The z-index (defaults to 2000000000)
		top:       '50%', // Top position relative to parent
		left:      '50%' // Left position relative to parent
	};

	$( '.eec-spinner' ).spin( spin_opts );

	var doing_ajax = false;

	// On subscribe form submit
	$( '#eec-subscribe-form' ).submit( function( event ) {

		if ( true === doing_ajax ) {
			return;
		}

		doing_ajax = true;

		event.preventDefault();

		var email = $( '#eec-email' ).val();

		$( '#eec-subscribe-form' ).hide();
		$( '.eec-message' ).hide();
		$( '.eec-submitting').show();

		$.ajax( {
			url:		eec_js.ajax_url,
			type:		'POST',
			dataType:	'json',
			cache:		false,
			data: {
				'action'      : 'eec_subscribe',
				'eec-email'   : email
			},
			error: function( jqXHR, textStatus, errorThrown ) {

				$( '.eec-message' ).hide();
				$( '.eec-failure' ).empty().html( eec_js.error ).show();
				$( '#eec-subscribe-form' ).show();
				doing_ajax = false;
			},
			success: function( data ) {

				$( '.eec-message' ).hide();
				doing_ajax = false;

				if ( false === data.success ) {
					$( '.eec-failure' ).empty().html( data.data ).show();
					$( '#eec-subscribe-form' ).show();
					return;
				}

				$( '.eec-success' ).show();
			}
		} );
	} );

} )( jQuery );