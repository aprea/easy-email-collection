<?php
/**
 * Plugin Name: Easy Email Collection
 * Plugin URI:  http://wpaxl.com
 * Description: Easily collect the email addresses of your visitors.
 * Version:     1.0.0-pre-alpha
 * Author:      Chris Aprea
 * Author URI:  http://twitter.com/chrisaprea
 * Text Domain: easy-email-collection
 * Domain Path: /languages
 */

/**
 * Sets up and initializes the Easy Email Collection plugin.
 *
 * @since  1.0.0
 * @access public
 * @return void
 */
final class Easy_Email_Collection {

	public $version    = '1.0.0';
	public $db_version = 1;
	public $dir_path   = '';
	public $dir_uri    = '';


	/**
	 * Returns the instance.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return object
	 */
	public static function get_instance() {

		static $instance = null;

		if ( is_null( $instance ) ) {
			$instance = new Easy_Email_Collection;
			$instance->setup();
			$instance->includes();
			$instance->setup_actions();
		}

		return $instance;
	}

	private function __construct() {}

	private function setup() {

		$this->dir_path = trailingslashit( plugin_dir_path( __FILE__ ) );
		$this->dir_uri  = trailingslashit( plugin_dir_url(  __FILE__ ) );
	}

	private function includes() {

		require_once( $this->dir_path . 'inc/functions-ajax.php'       );
		require_once( $this->dir_path . 'inc/functions-common.php'     );
		require_once( $this->dir_path . 'inc/functions-frontend.php'   );
		require_once( $this->dir_path . 'inc/functions-post-types.php' );

		/* Load template files. */
		require_once( $this->dir_path . 'inc/template.php' );

		/* Load widget files. */
		require_once( $this->dir_path . 'inc/widget.php' );

		/* Load subscriber files. */
		require_once( $this->dir_path . 'inc/subscriber/functions.php' );

		if ( is_admin() ) {
			require_once( $this->dir_path . 'inc/admin/class-eec-subscriber-table.php' );
			require_once( $this->dir_path . 'inc/admin/functions.php'                  );
		}
	}

	private function setup_actions() {

		/* Provide hook for add-on plugins to execute before the plugin runs. */
		add_action( 'plugins_loaded', array( $this, 'setup_early' ), 0 );

		/* Internationalize the text strings used. */
		add_action( 'plugins_loaded', array( $this, 'i18n' ), 2 );

		/* Provide hook for add-on plugins after the plugin has been set up. */
		add_action( 'plugins_loaded', array( $this, 'setup_late' ), 15 );

		/* Register activation hook. */
		register_activation_hook( __FILE__, array( $this, 'activation' ) );
	}

	/**
	 * Pre-setup hook.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return void
	 */
	public function setup_early() { do_action( 'eec_setup_early' ); }

	/**
	 * Post-setup hook.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return void
	 */
	public function setup_late() { do_action( 'eec_setup_late' ); }

	/**
	 * Loads the translation files.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return void
	 */
	public function i18n() {
		load_plugin_textdomain( 'easy-email-collection', false, 'easy-email-collection/languages' );
	}

	/**
	 * Method that runs only when the plugin is activated.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return void
	 */
	public function activation() {
		// activation code here
	}
}

function easy_email_collection() {
	return Easy_Email_Collection::get_instance();
}

easy_email_collection();
