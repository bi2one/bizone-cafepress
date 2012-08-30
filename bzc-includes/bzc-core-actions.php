<?php
// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) exit;

$bzc = bizone_cafepress();

add_action( 'activate_' . $bzc->basename, 'bzc_activation' );
add_action( 'plugins_loaded', 'bzc_loaded', 10 );
add_action( 'init', 'bzc_init', 10 );
add_action( 'setup_theme', 'bzc_setup_theme', 10 );
add_action( 'after_setup_theme', 'bzc_after_setup_theme', 10 );
add_action( 'template_redirect', 'bzc_template_redirect', 10);

add_action( 'bzc_activation', 'bzc_install_db' );
add_action( 'bzc_activation', 'bzc_insert_initial_data' );
// add_action( 'bzc_activation', 'bzc_flush_rewrite_rules' );

// add_action( 'bzc_admin_menu', 'bzc_add_board_menu' );
// add_action( 'load-index_bzc_boards', 'bzc_render_board' );

// add_filter( 'rewrite_rules_array', 'bzc_add_rewrite_rules' );
add_action( 'generate_rewrite_rules', 'bzc_add_rewrite_rules' );

/* template redirect */
add_filter( 'bzc_template_redirect', 'bzc_board_handler' );
add_filter( 'bzc_template_redirect', 'bzc_guestbook_post_handler' );
add_filter( 'bzc_template_redirect', 'bzc_guestbook_remove_handler' );

function bzc_template_redirect() {
	do_action( 'bzc_template_redirect' );
}

function bzc_activation() {
	do_action( 'bzc_activation' );
}

function bzc_loaded() {
	do_action( 'bzc_loaded' );
}

function bzc_init() {
	do_action( 'bzc_init' );
}

function bzc_setup_theme() {
	do_action( 'bzc_setup_theme' );
}

function bzc_after_setup_theme() {
	do_action( 'bzc_after_setup_theme' );
}

function bzc_flush_rewrite_rules() {
	global $wp_rewrite;
	$wp_rewrite->flush_rules();
}

function bzc_add_rewrite_rules( $wp_rewrite ) {
	$bzc = bizone_cafepress();

	$new_rules = array(
		'^' . $bzc->board_slug . '/([0-9^/]+)/?$' => sprintf( 'index.php?pagename=%s&board=%s', $bzc->board_slug, $wp_rewrite->preg_index(1) ),
		'^' . $bzc->board_slug . '/([0-9^/]+)/([^/]+)/?$' => sprintf( 'index.php?pagename=%s&board=%s&action=%s', $bzc->board_slug, $wp_rewrite->preg_index(1), $wp_rewrite->preg_index(2) )
	);
	// Add the new rewrite rule into the top of the global rules array
	$wp_rewrite->rules = $new_rules + $wp_rewrite->rules;
}
?>