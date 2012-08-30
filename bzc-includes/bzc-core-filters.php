<?php
if ( !defined ( 'ABSPATH' ) ) exit;

add_filter( 'query_vars', 'bzc_insert_query_vars' );

function bzc_insert_query_vars( $vars ) {
	$vars[] = 'board';
	$vars[] = 'action';
	return $vars;
}
?>