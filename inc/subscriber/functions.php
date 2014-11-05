<?php
/**
 * Subscriber functions.
 *
 * @package    EasyEmailCollection
 * @subpackage Includes
 * @since      1.0.0
 * @author     Chris Aprea <chris@wpaxl.com>
 * @copyright  Copyright (c) 2014, Chris Aprea
 * @link       http://wpaxl.com
 * @license    http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
 */

function eec_get_subscriber_post_type() {
	return apply_filters( 'eec_get_subscriber_post_type', 'eec_subscriber' );
}