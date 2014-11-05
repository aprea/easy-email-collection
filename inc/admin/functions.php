<?php
/**
 * Admin functionality.
 *
 * @package    EasyEmailCollection
 * @subpackage Includes
 * @since      1.0.0
 * @author     Chris Aprea <chris@wpaxl.com>
 * @copyright  Copyright (c) 2014, Chris Aprea
 * @link       http://wpaxl.com
 * @license    http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
 */

/* Register custom menu page on the 'init' hook. */
add_action( 'admin_menu', 'eec_add_subscribers_menu_page' );

function eec_add_subscribers_menu_page() {

	$args = array(
		__( 'Subscribers', 'easy-email-collection' ),
		__( 'Subscribers', 'easy-email-collection' ),
		'manage_options',
		'eec-subscribers',
		'eec_subscribers_menu_page',
		'dashicons-email-alt',
	);

	call_user_func_array( 'add_menu_page', $args );
}

function eec_subscribers_menu_page() {

	$subscriber_table = new EEC_Subscriber_Table();
	$subscriber_table->prepare_items();

	ob_start(); ?>

		<div class="wrap eec-admin-page">

			<h2><?php _e( 'Subscribers', 'easy-email-collection' ); ?></h2>

			<?php $subscriber_table->display(); ?>

		</div>

	<?php
	echo ob_get_clean();
}