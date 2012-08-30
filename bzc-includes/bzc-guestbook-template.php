<?php
if ( !defined( 'ABSPATH' ) ) exit;

class BZC_Guestbook_Template {
	var $current_post = -1;
	var $post_count;
	var $posts;
	var $post;

	var $in_the_loop;

	var $pag_page;
	var $pag_num;
	var $pag_links;
	var $total_post_count;

	function __construct( $board ) {
		$this->posts = bzc_get_guestbook_posts_with_user( $board->id );
		//$this->total_post_count = (int)$this->posts['total'];
		//echo $this->total_post_count;
		$this->post_count = count( $this->posts );
		//echo $this->post_count;
	}

	function has_posts() {
		if ( $this->post_count )
			return true;
		return false;
	}

	function next_post() {
		$this->current_post++;
		$this->post = $this->posts[ $this->current_post ];
		return $this->post;
	}

	function rewind_posts() {
		$this->current_post = -1;
		if ( $this->post_count > 0) {
			$this->post = $this->posts[0];
		}
	}

	function posts() {
		if ( $this->current_post + 1 < $this->post_count ) {
			return true;
		} elseif ( $this->current_post + 1 == $this->post_count ) {
			$this->rewind_posts();
		}
		$this->in_the_loop = false;
		return false;
	}

	function the_post() {
		$this->in_the_loop = true;
		$this->next_post();
	}
}

function bzc_has_guestbook_posts() {
	global $guestbook_post_template, $wp;
	$guestbook_post_template = new BZC_Guestbook_Template( bzc_get_board( $wp->query_vars['board'] ) );
	return $guestbook_post_template->has_posts();
}

function bzc_guestbook_posts() {
	global $guestbook_post_template;
	return $guestbook_post_template->posts();
}

function bzc_the_guestbook_post() {
	global $guestbook_post_template;
	return $guestbook_post_template->the_post();
}

function bzc_guestbook_post_content() {
	echo bzc_get_guestbook_post_content();
}

function bzc_guestbook_post_user_nicename() {
	echo bzc_get_guestbook_post_user_nicename();
}

function bzc_guestbook_post_pub_date() {
	echo bzc_get_guestbook_post_pub_date();
}

function bzc_get_guestbook_post_content() {
	global $guestbook_post_template;
	return $guestbook_post_template->post->content;
}

function bzc_get_guestbook_post_user_nicename() {
	global $guestbook_post_template;
	return $guestbook_post_template->post->user_nicename;
}

function bzc_get_guestbook_post_pub_date() {
	global $guestbook_post_template;
	return $guestbook_post_template->post->pub_date;
}

function bzc_guestbook_posts_form_action() {
	echo bzc_get_guestbook_posts_form_action();
}

function bzc_get_guestbook_posts_form_action() {
	global $wp;
	$bzc = bizone_cafepress();
	return home_url( sprintf( $bzc->board_slug . '/%s/%s/', $wp->query_vars['board'], $bzc->guestbook_post_action_slug ) );
}

function bzc_guestbook_post_remove_url() {
	echo bzc_get_guestbook_post_remove_url();
}

function bzc_get_guestbook_post_remove_url() {
	global $wp, $guestbook_post_template;
	$bzc = bizone_cafepress();
	return home_url( sprintf( $bzc->board_slug . '/%s/%s/?post=%s', $guestbook_post_template->post->board_id, $bzc->guestbook_remove_action_slug, $guestbook_post_template->post->id ) );
}

function bzc_guestbook_remove_handler() {
	global $wp;
	$bzc = bizone_cafepress();
	$user = wp_get_current_user();
	if ( empty ( $user ) || $bzc->guestbook_remove_action_slug != $wp->query_vars['action'])
		return ;
	/* TODO: check permission */
	$board_id = $wp->query_vars['board'];
	$post_id = $_GET['post'];
	bzc_delete_guestbook_post( $post_id );
	wp_redirect( bzc_get_board_url( $board_id, 2 ) );
}

function bzc_guestbook_post_handler() {
	global $wp;
	$bzc = bizone_cafepress();
	if ( 'GET' == $_SERVER['REQUEST_METHOD'] || $bzc->guestbook_post_action_slug != $wp->query_vars['action'])
		return ;

	$user = wp_get_current_user();
	if ( empty ( $user ) )
		wp_redirect( home_url( 'wp-login.php?redirect_to=' . urlencode( $_SERVER['HTTP_REFERER'] ) ) );
	/* TODO: check permission */
	/* TODO: check board id */
	$board_id = $wp->query_vars['board'];
	$content = $_POST['guestbook-content'];
	bzc_insert_guestbook_post( $user->id, $board_id, $content );

	wp_redirect( bzc_get_board_url( $board_id, 1 ) );
	exit();
}
?>