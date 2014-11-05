<?php
/**
 * Common functions.
 *
 * @package    EasyEmailCollection
 * @subpackage Includes
 * @since      1.0.0
 * @author     Chris Aprea <chris@wpaxl.com>
 * @copyright  Copyright (c) 2014, Chris Aprea
 * @link       http://wpaxl.com
 * @license    http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
 */

function eec_dir() {

	static $dir_path = null;

	if ( null === $dir_path ) {
		$dir_path = easy_email_collection()->dir_path;
	}

	return $dir_path;
}

function eec_uri() {

	static $dir_uri = null;

	if ( null === $dir_uri ) {
		$dir_uri = easy_email_collection()->dir_uri;
	}

	return $dir_uri;
}

function eec_version() {

	static $version = null;

	if ( null === $version ) {
		$version = easy_email_collection()->version;
	}

	return $version;
}
