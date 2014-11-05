<?php
/**
 * File for registering AJAX handlers.
 *
 * @package    EasyEmailCollection
 * @subpackage Includes
 * @since      1.0.0
 * @author     Chris Aprea <chris@wpaxl.com>
 * @copyright  Copyright (c) 2014, Chris Aprea
 * @link       http://wpaxl.com
 * @license    http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
 */

add_action( 'wp_ajax_eec_subscribe',        'eec_subscribe_ajax' );
add_action( 'wp_ajax_nopriv_eec_subscribe', 'eec_subscribe_ajax' );

function eec_subscribe_ajax() {

	// Removes slashes from $_POST data
	$data = wp_unslash( $_POST );

	$return = array();

	if ( empty( $_POST['eec-email'] ) ) {
		wp_send_json_error( __( 'Email address was empty, please try again.', 'easy-email-collection' ) );
	}

	$email = trim( $_POST['eec-email'] );

	if ( ! is_email( $email ) ) {
		wp_send_json_error( __( 'Please enter a valid email address.', 'easy-email-collection' ) );
	}

	$args = array(
		'meta_key'       => 'eec_email',
		'meta_value'     => $email,
		'post_type'      => eec_get_subscriber_post_type(),
		'post_status'    => 'publish',
		'posts_per_page' => 1,
	);

	$posts = get_posts( $args );

	// This visitor has already subscribed, exit early
	if ( ! empty( $posts ) ) {
		wp_send_json_success();
	}

	// Create post object
	$args = array(
		'post_status' => 'publish',
		'post_type'   => eec_get_subscriber_post_type(),
	);

	// Insert the post into the database
	$post_id = wp_insert_post( $args );

	if ( 0 === $post_id || is_wp_error( $post_id ) ) {
		wp_send_json_error( __( 'Error occurred when attempting to save your details, please try again later.', 'easy-email-collection' ) );
	}

	add_post_meta( $post_id, 'eec_email', $email, true );

	wp_send_json_success();
}