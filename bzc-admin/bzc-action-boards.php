<?php
require( 'admin.php' );
$action = $_GET['action'];

if ( 'save' === $action ) {
	global $wpdb;
	echo 'a';
	print_r($wpdb);
	echo 'b';
	/* TODO: check permission */
	exit;
}
/* $message = 0; */
/* if ( 'POST' == $_SERVER['REQUEST_METHOD'] ) { */
/* 	$id = $_GET['board']; */
/* 	$title = $_POST['board_title']; */
/* 	$content = $_POST['content']; */
/* 	$type = 'guestbook'; */
/* 	if ( bzc_insert_board( $title, $content, $type, $id ) ) */
/* 		if ( $id ) */
/* 			$message_code = 1; // update success */
/* 		else */
/* 			$message_code = 2; // save success */
/* 	else */
/* 		$message_code = 3; // save failed */
/* } */
/* $message = $messages[ $message_code ]; */
?>