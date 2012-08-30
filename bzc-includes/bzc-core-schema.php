<?php
if ( ! defined( 'ABSPATH' ) ) exit;

function bzc_install_db() {
	$bzc = bizone_cafepress();
	global $wpdb;
	// board table
	$sql = 'CREATE TABLE ' . $bzc->board_table . ' (
          id int(11) NOT NULL AUTO_INCREMENT,
          user_id int(11) NOT NULL,
          title VARCHAR(100) NOT NULL,
          content TEXT NULL,
          type VARCHAR(100) NULL,
          pub_date TIMESTAMP DEFAULT now(),
          UNIQUE KEY id (id)
        );';
	require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
	dbDelta($sql);

	// guestbook post table
	$table_name = $bzc->prefix . 'guestbook_posts';
	$sql = 'CREATE TABLE ' . $bzc->guestbook_table . ' (
          id int(11) NOT NULL AUTO_INCREMENT,
          user_id int(11) NOT NULL,
          board_id int(11) NOT NULL,
          content TEXT NULL,
          pub_date TIMESTAMP DEFAULT now(),
          UNIQUE KEY id (id)
        );';
	require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
	dbDelta($sql);
}
?>