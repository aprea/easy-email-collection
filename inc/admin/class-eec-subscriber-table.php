<?php
/**
 * Subscriber list table.
 *
 * @package    EasyEmailCollection
 * @subpackage Includes
 * @since      1.0.0
 * @author     Chris Aprea <chris@wpaxl.com>
 * @copyright  Copyright (c) 2014, Chris Aprea
 * @link       http://wpaxl.com
 * @license    http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
 */

// WP_List_Table is not loaded automatically so we need to load it manually
if ( ! class_exists( 'WP_List_Table' ) ) {
	require_once( ABSPATH . 'wp-admin/includes/class-wp-list-table.php' );
}

/**
 * Create a new table class that will extend the WP_List_Table
 */
class EEC_Subscriber_Table extends WP_List_Table {

	/**
	 * Prepare the items for the table to process
	 *
	 * @return Void
	 */
	public function prepare_items() {

		$columns  = $this->get_columns();
		$hidden   = $this->get_hidden_columns();
		$sortable = $this->get_sortable_columns();

		$data = $this->table_data();
		usort( $data, array( &$this, 'sort_data' ) );

		$per_page     = 20;
		$current_page = $this->get_pagenum();
		$total_items  = count( $data );

		$this->set_pagination_args( array(
			'total_items' => $total_items,
			'per_page'    => $per_page
		) );

		$data = array_slice( $data, ( ( $current_page - 1 ) * $per_page ), $per_page );

		$this->_column_headers = array( $columns, $hidden, $sortable );
		$this->items = $data;
	}

	/**
	 * Override the parent columns method. Defines the columns to use in your listing table
	 *
	 * @return Array
	 */
	public function get_columns() {

		$columns = array(
			'ID'    => __( 'ID', 'easy-email-collection' ),
			'email' => __( 'Email', 'easy-email-collection' ),
			'date'  => __( 'Date', 'easy-email-collection' ),
		);

		return $columns;
	}

	/**
	 * Define which columns are hidden
	 *
	 * @return Array
	 */
	public function get_hidden_columns() {
		return array();
	}

	/**
	 * Define the sortable columns
	 *
	 * @return Array
	 */
	public function get_sortable_columns() {
		return array(
			'date'	=> array( 'date', true ),
			'email' => array( 'email', false )
		);
	}

	/**
	 * Get the table data
	 *
	 * @return Array
	 */
	private function table_data() {
		global $wpdb;

		$sql = <<<SQL
			SELECT     wp_posts.ID,
				       m1.meta_value          AS email,
				       wp_posts.post_date_gmt AS date
			FROM       wp_posts
			INNER JOIN wp_postmeta m1 ON ( wp_posts.ID = m1.post_id )
			WHERE      wp_posts.post_type   = 'subscriber'
			AND        wp_posts.post_status = 'publish'
			AND        m1.meta_key          = 'eec_email'
			GROUP BY   wp_posts.ID
SQL;

		$sql = str_replace(
			array( 'wp_', 'subscriber' ),
			array( $wpdb->prefix, eec_get_subscriber_post_type() ),
			$sql
		);

		$results = $wpdb->get_results( $sql, ARRAY_A );

		return $results;
	}

	/**
	 * Define what data to show on each column of the table
	 *
	 * @param  Array  $item        Data
	 * @param  String $column_name Current column name
	 *
	 * @return Mixed
	 */
	public function column_default( $item, $column_name ) {

		switch( $column_name ) {
			case 'ID':
			case 'email':
			case 'date':
				return $item[ $column_name ];

			default:
				return print_r( $item, true ) ;
		}
	}

	/**
	 * Allows you to sort the data by the variables set in the $_GET
	 *
	 * @return Mixed
	 */
	private function sort_data( $a, $b ) {

		// Set defaults
		$orderby = 'date';
		$order   = 'desc';

		// If orderby is set, use this as the sort column
		if ( ! empty( $_GET['orderby'] ) ) {
			$orderby = $_GET['orderby'];
		}

		// If order is set use this as the order
		if ( ! empty( $_GET['order'] ) ) {
			$order = $_GET['order'];
		}

		$result = strnatcmp( $a[ $orderby ], $b[ $orderby ] );

		if ( $order === 'asc' ) {
			return $result;
		}

		return -$result;
	}
}