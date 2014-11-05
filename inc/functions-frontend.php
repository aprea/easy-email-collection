<?php
/**
 * Frontend functions.
 *
 * @package    EasyEmailCollection
 * @subpackage Includes
 * @since      1.0.0
 * @author     Chris Aprea <chris@wpaxl.com>
 * @copyright  Copyright (c) 2014, Chris Aprea
 * @link       http://wpaxl.com
 * @license    http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
 */

/**
 * Enqueue scripts and styles.
 */
function eec_scripts() {

	// Only load styles and scripts when the widget is active.
	if ( ! is_active_widget( false, false, 'eec_subscribe', true ) ) {
		return;
	}

	$dir_uri  = eec_uri();
	$version  = eec_version();

	// Scripts
	wp_enqueue_script( 'eec-spin',   $dir_uri . 'asset/js/spin.min.js', array(), $version, true );
	wp_enqueue_script( 'eec-script', $dir_uri . 'asset/js/script.js', array( 'jquery' ), $version, true );

	// Localized strings
	wp_localize_script( 'eec-script', 'eec_js', array(
		'ajax_url'   => admin_url( 'admin-ajax.php' ),
		'submitting' => __( 'Submitting, please wait&hellip;', 'easy-email-collection' ),
		'error'      => __( 'Error occurred when attempting to save your details, please try again later.', 'easy-email-collection' ),
	) );

	// Styles
	wp_enqueue_style( 'eec-style', $dir_uri . 'asset/css/style.css' );
}
add_action( 'wp_enqueue_scripts', 'eec_scripts' );