<?php
/**
 * File for registering custom post types.
 *
 * @package    EasyEmailCollection
 * @subpackage Includes
 * @since      1.0.0
 * @author     Chris Aprea <chris@wpaxl.com>
 * @copyright  Copyright (c) 2014, Chris Aprea
 * @link       http://wpaxl.com
 * @license    http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
 */

/* Register custom post types on the 'init' hook. */
add_action( 'init', 'eec_register_post_types' );

/**
 * Registers post types needed by the plugin.
 *
 * @since  1.0.0
 * @access public
 * @return void
 */
function eec_register_post_types() {

	/* Set up the arguments for the post type. */
	$subscriber_args = array(
		'description'         => '',
		'public'              => false,
		'publicly_queryable'  => false,
		'exclude_from_search' => true,
		'show_in_nav_menus'   => false,
		'show_ui'             => false,
		'show_in_menu'        => false,
		'show_in_admin_bar'   => false,
		'menu_position'       => null,
		'menu_icon'           => false,
		'can_export'          => true,
		'delete_with_user'    => false,
		'hierarchical'        => false,
		'has_archive'         => false,
		'query_var'           => false,
		'map_meta_cap'        => false,
		'rewrite'             => false,
		'supports'            => true, // only easy way to specify no support for all default features
		'labels'              => false,
	);

	/* Register post types. */
	register_post_type( eec_get_subscriber_post_type(), $subscriber_args );
}