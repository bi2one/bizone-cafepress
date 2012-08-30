<?php

/**
 * bizone-cafepress Options
 *
 * @package bizone-cafepress
 * @subpackage Options
 */

if ( ! defined( 'ABSPATH' ) ) exit;

function bzc_get_default_options() {
	return apply_filters( 'bzc_get_default_options', array(
		'_bbp_db_version' => bizone_cafepress()->db_version
	) );
}

function bzc_get_theme_package_id( $default = 'default' ) {
	return apply_filters ( 'bzc_get_theme_package_id', get_option( '_bzc_theme_package_id', $default ) );
}

function bzc_get_root_slug( $default = 'boards' ) {
	return apply_filters( 'bzc_get_root_slug', get_option( '_bzc_root_slug', $default ) );
}

function bzc_include_root_slug( $default = 1 ) {
	return (bool) apply_filters( 'bzc_include_root_slug', (bool) get_option( '_bzc_include_root', $default ) );
}

function bzc_maybe_get_root_slug() {
	$retval = '';

	if ( bzc_get_root_slug() && bzc_include_root_slug() )
		$retval = trailingslashit( bzc_get_root_slug() );

	return apply_filters( 'bzc_maybe_get_root_slug', $retval );
}

function bzc_get_guestbook_slug( $default = 'guestbook' ) {
	return apply_filters( 'bzc_get_root_slug', bzc_maybe_get_root_slug() . get_option( '_bzc_guestbook_slug', $default ) );
}

function bzc_get_board_slug( $default = 'board' ) {
	return apply_filters( 'bzc_get_root_slug', bzc_maybe_get_root_slug() . get_option( '_bzc_board_slug', $default ) );
}
?>