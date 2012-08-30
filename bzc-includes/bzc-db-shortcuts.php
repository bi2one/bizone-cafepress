<?php
if ( ! defined( 'ABSPATH' ) ) exit;

function bzc_insert_page($title, $content, $type='') {
	$bzc = bizone_cafepress();
	// $template = $bzc->type_to_template( $type );
	$template = null;

	$current_user = wp_get_current_user();
	$post = array(
		'comment_status' => 'closed',
		'post_author' => $current_user->ID,
		'post_content' => $content,
		'post_name' => $bzc->board_slug,
		'post_status' => 'publish',
		'post_title' => $title,
		'post_type' => 'page'
	);
	$post_id = wp_insert_post( $post );
	if ( $post_id >= 0 && ! is_null( $template ) ) {
		update_post_meta( $post_id, '_wp_page_template', $template );
		bzc_insert_board( $post_id, $title, $content, $type );
	}
	return $post_id;
}

function bzc_insert_initial_data() {
}