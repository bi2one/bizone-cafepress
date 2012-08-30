<?php
if ( ! defined( 'ABSPATH' ) ) exit;

function bzc_get_delete_board_link($board_id) {
	if ( ! empty( $board_id ) ) {
		// return sprintf( '?page=%s&action=%s&board=%s', $_REQUEST['page'], 'delete', $board_id );
		return sprintf( '?page=%s&action=%s&board=%s', 'boardpage', 'delete', $board_id );
	} else {
		return sprintf( '?page=%s', 'boardpage' );
	}
}

function bzc_get_board( $board_id ) {
	global $wpdb;
	$bzc = bizone_cafepress();
	$sql = $wpdb->prepare( 'SELECT * FROM ' . $bzc->board_table . ' WHERE id=%d', $board_id );
	return $wpdb->get_row( $sql );
}

function bzc_insert_board( $title, $content, $type, $id='' ) {
	global $wpdb;
	$bzc = bizone_cafepress();
	if ( ! empty( $id ) ) {
		return $wpdb->update(
			$bzc->board_table,
			array(
				'user_id' => wp_get_current_user()->ID,
				'title' => $title,
				'content' => $content,
				'type' => $type,
			),
			array( 'id' => $id ),
			array(
				'%d',
				'%s',
				'%s',
				'%s'
			),
			array( '%d' )
		);
	} else {
		return $wpdb->insert(
			$bzc->board_table,
			array(
				'user_id' => wp_get_current_user()->ID,
				'title' => $title,
				'content' => $content,
				'type' => $type,
			),
			array(
				'%d',
				'%s',
				'%s',
				'%s'
			)
		);
	}
}

function bzc_delete_board( $id ) {
	global $wpdb;
	$bzc = bizone_cafepress();
	$wpdb->query(
		$wpdb->prepare( 'DELETE FROM ' . $bzc->board_table . ' WHERE id = %d', $id )
	);
}
?>