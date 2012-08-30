<?php
function bzc_load_theme_functions() {
	global $pagenow;
	if ( ! defined( 'WP_INSTALLING' ) || ( ! empty( $pagenow ) && ( 'wp-activate.php' !== $pagenow ) ) ) {
		bzc_locate_template( 'cafepress-functions.php', true );
	}
}
?>