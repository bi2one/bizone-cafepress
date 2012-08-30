<?php

/**
 * cafepress Updater
 *
 * @package cafepress
 * @subpackage Updater
 */

if ( !defined( 'ABSPATH' ) ) exit;

function bzc_is_deactivation( $basename = '' ) {
	$bzc = bizone_cafepress();
	
	$action = false;
	if ( ! empty( $_REQUEST['action'] ) && ( '-1' != $_REQUEST['action'] ) )
		$action = $_REQUEST['action'];
	elseif ( ! empty( $_REQUEST['action2'] ) && ( '-1' != $_REQUEST['action2'] ) )
		$action = $_REQUEST['action2'];

	// Bail if not deactivating
	if ( empty( $action ) || !in_array( $action, array( 'deactivate', 'deactivate-selected' ) ) )
		return false;

	// The plugin(s) being deactivated
	if ( $action == 'deactivate' )
		$plugins = isset( $_GET['plugin'] ) ? array( $_GET['plugin'] ) : array();
	else
		$plugins = isset( $_POST['checked'] ) ? (array) $_POST['checked'] : array();

	// Set basename if empty
	if ( empty( $basename ) && !empty( $bzc->basename ) )
		$basename = $bzc->basename;

	// Bail if no basename
	if ( empty( $basename ) )
		return false;

	// Is cafepress being deactivated?
	return in_array( $basename, $plugins );
}

?>