<?php
// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

// Init admin area
add_action( 'admin_menu', 'bzc_admin_menu' );
add_action( 'admin_init', 'bzc_admin_init' );
add_action( 'admin_head', 'bzc_admin_head' );

add_action( 'bzc_init', 'bzc_admin' );

add_action( 'bzc_admin_menu', 'bzc_admin_boards' );

function bzc_admin_menu() {
	do_action( 'bzc_admin_menu' );
}

function bzc_admin_init() {
	do_action( 'bzc_admin_init' );
}

function bzc_admin_head() {
	do_action( 'bzc_admin_head' );
}
?>