<?php
if ( ! defined( 'ABSPATH' ) ) exit;

if ( ! class_exists( 'WP_List_Table' ) ) {
	require_once( ABSPATH . 'wp-admin/includes/class-wp-list-table.php' );
}

class BZC_Board_List_Table extends WP_List_Table {
	function __construct() {
		global $status, $page;

		parent::__construct( array(
			'singular' => 'board',
			'plural'   => 'boards',
			'ajax'     => false
		) );
	}

	function column_default( $item, $column_name ) {
		switch( $column_name ) {
			case 'title':
			case 'content':
			case 'type':
				return $item[ $column_name ];
			default:
				return print_r( $item );
		}
	}

	function column_title( $item ) {
		$bzc = bizone_cafepress();
		$edit_url = home_url( sprintf( $bzc->board_slug . '/%s/', $item['id'] ) );
		$actions = array(
			'edit' => sprintf( '<a href="?page=%s&action=%s&board=%s">Edit</a>', $_REQUEST['page'], 'edit', $item['id'] ),
			'delete' => sprintf( '<a href="?page=%s&action=%s&board[]=%s">Delete</a>', $_REQUEST['page'], 'delete', $item['id'] ),
			'view' => sprintf( '<a href="%s">View</a>', $edit_url )
		);

		return sprintf( '<strong><a href="?page=%1$s&action=%2$s&board=%3$s">%4$s</a> <span style="color:silver">(id:%5$s)</span>%6$s</strong>',
						$_REQUEST['page'],
						'edit',
						$item['id'],
						$item['title'],
						$item['id'],
						$this->row_actions( $actions )
		);
	}

	function column_cb( $item ) {
		return sprintf(
			'<input type="checkbox" name="%1$s[]" value="%2$s" />',
			$this->_args['singular'],
			$item['id']
		);
	}

	function get_columns() {
		$columns = array(
			'cb' => '<input type="checkbox" />',
			'title' => 'Title',
			'content' => 'Contents',
			'type' => 'Type'
		);
		return $columns;
	}

	function get_sortable_columns() {
		$sortable_columns = array(
			'title' => array( 'title', false ),
			'type' => array( 'type', false)
		);
		return $sortable_columns;
	}

	function get_bulk_actions() {
		$actions = array(
			'delete' => 'Delete'
		);
		return $actions;
	}

	function process_bulk_action() {
		if ( 'delete' === $this->current_action() && ! empty ( $_REQUEST['board'] ) ) {
			foreach ( $_REQUEST['board'] as $board ) {
				bzc_delete_board( $board );
			}
		}
	}

	function prepare_items() {
		global $wpdb;
		$bzc = bizone_cafepress();
		$per_page = 2;

		$columns = $this->get_columns();
		$hidden = array();
		$sortable = $this->get_sortable_columns();

		$this->_column_headers = array( $columns, $hidden, $sortable );
		$this->process_bulk_action();

		$orderby = ( ! empty( $_REQUEST['orderby'] ) ) ? $_REQUEST['orderby'] : 'pub_date';
		$order = ( ! empty( $_REQUEST['order'] ) ) ? $_REQUEST['order'] : 'desc';
		$sql = $wpdb->prepare( 'SELECT * FROM ' . $bzc->board_table . ' ORDER BY ' . $orderby . ' ' . $order . ';' );
		$data = $wpdb->get_results( $sql, ARRAY_A );

		$current_page = $this->get_pagenum();
		$total_items = count($data);

		$data = array_slice($data, ( $current_page - 1 ) * $per_page, $per_page );

		$this->items = $data;

		$this->set_pagination_args( array(
			'total_items' => $total_items,
			'per_page'    => $per_page,
			'total_pages' => ceil( $total_items / $per_page )
		) );
	}
}
?>