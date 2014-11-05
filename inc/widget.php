<?php
/**
 * File for registering the widget.
 *
 * @package    EasyEmailCollection
 * @subpackage Includes
 * @since      1.0.0
 * @author     Chris Aprea <chris@wpaxl.com>
 * @copyright  Copyright (c) 2014, Chris Aprea
 * @link       http://wpaxl.com
 * @license    http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
 */

final class EEC_Widget extends WP_Widget {

	/**
	 * Sets up the widgets name etc
	 */
	public function __construct() {

		$id_base = 'eec_subscribe';
		$name    = __( 'Easy Email Collection', 'easy-email-collection' );
		$options = array( 'description' => __( 'Easily collect the email addresses of your visitors.', 'easy-email-collection' ) );

		parent::__construct( $id_base, $name, $options );
	}

	/**
	 * Outputs the content of the widget
	 *
	 * @param array $args
	 * @param array $instance
	 */
	public function widget( $args, $instance ) {
		eec_subscribe_form();
	}
}

// Register the widget
function register_eec_widget() {
    register_widget( 'EEC_Widget' );
}
add_action( 'widgets_init', 'register_eec_widget' );