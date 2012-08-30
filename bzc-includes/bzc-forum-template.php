<?php
/**
 * cafePress Forum Template Tags
 *
 * @package cafePress
 * @subpackage TemplateTags
 */
if ( !defined( 'ABSPATH' ) ) exit;

function bzc_get_guestbook_post_type() {
	return apply_filters( 'bzc_get_guestbook_post_type', bizone_cafepress()->guestbook_post_type );
}
?>