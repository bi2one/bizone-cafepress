<?php
/**
 * cafepress Capabilites
 *
 * @package cafepress
 * @subpackage Capabilities
 */

if ( !defined( 'ABSPATH' ) ) exit;

function bzc_get_guestbook_caps() {
	// Forum meta caps
	$caps = array (
		'delete_posts'        => 'delete_guestbook_posts',
		'delete_others_posts' => 'delete_others_guestbook_posts'
	);

	return apply_filters( 'bzc_get_forum_caps', $caps );
}
?>