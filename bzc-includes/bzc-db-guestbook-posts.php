<?php
if ( ! defined( 'ABSPATH' ) ) exit;

function bzc_get_guestbook_posts( $board_id ) {
	global $wpdb;
	$bzc = bizone_cafepress();
	$sql = $wpdb->prepare( 'SELECT * FROM ' . $bzc->guestbook_table . ' WHERE board_id=%d', $board_id);
	return $wpdb->get_results( $sql );
}

function bzc_get_guestbook_posts_with_user( $board_id ) {
	global $wpdb;
	$bzc = bizone_cafepress();
	$sql = sprintf( 'SELECT * FROM %1$s LEFT JOIN %2$s ON %1$s.user_id=%2$s.ID', $bzc->guestbook_table, $wpdb->users );
	$sql = $wpdb->prepare( $sql . ' WHERE board_id=%d ORDER BY pub_date DESC', $board_id);
	return $wpdb->get_results( $sql );
}

function bzc_delete_guestbook_post( $post_id ) {
	global $wpdb;
	$bzc = bizone_cafepress();
	$sql = $wpdb->prepare( 'DELETE FROM ' . $bzc->guestbook_table . ' WHERE id=%d;', $post_id );
	return $wpdb->query( $sql );
}

function bzc_insert_guestbook_post( $user_id, $board_id, $content ) {
	global $wpdb;
	$bzc = bizone_cafepress();
	$content = trim( $content );
	if ( empty( $content ) )
		$content = 'Hello, CafePress!';

	return $wpdb->insert(
		$bzc->guestbook_table,
		array(
			'user_id' => $user_id,
			'board_id' => $board_id,
			'content' => $content
		),
		array(
			'%d',
			'%d',
			'%s'
		)
	);
}
?>