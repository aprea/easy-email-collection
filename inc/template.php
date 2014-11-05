<?php
/**
 * Template functions.
 *
 * @package    EasyEmailCollection
 * @subpackage Includes
 * @since      1.0.0
 * @author     Chris Aprea <chris@wpaxl.com>
 * @copyright  Copyright (c) 2014, Chris Aprea
 * @link       http://wpaxl.com
 * @license    http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
 */

function eec_subscribe_form( $echo = true ) {

	$email_input_placeholder = apply_filters( 'email_input_placeholder', __( 'Your email&hellip;', 'easy-email-collection' ) );
	$submit_button_text      = apply_filters( 'eec_submit_button_text',  '&#xf429;' ); // Genericon HTML entity

	ob_start(); ?>

		<div class="eec-subscribe-form-wrapper widget">

			<div class="eec-main">
				<?php do_action( 'eec_before_subscribe_form' ); ?>

				<div class="eec-submitting eec-message">
					<span class="eec-spinner"></span>
					<?php _e( "Submitting&hellip;", 'easy-email-collection' ); ?>
				</div>

				<div class="eec-success eec-message">
					<?php _e( "Thanks for subscribing!", 'easy-email-collection' ); ?>
				</div>

				<div class="eec-failure eec-message"></div>

				<form id="eec-subscribe-form" method="post" action="">
					<input type="email" maxlength="150" value="" id="eec-email" name="eec-email" class="eec-input" placeholder="<?php echo $email_input_placeholder; ?>">
					<input type="submit" value="<?php echo $submit_button_text; ?>" class="eec-button">
				</form>

				<?php do_action( 'eec_after_subscribe_form' ); ?>
			</div>

		</div>

	<?php

	$subscribe_form = ob_get_clean();

	if ( $echo ) {
		echo $subscribe_form;
	} else {
		return $subscribe_form;
	}
}