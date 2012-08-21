<?php
add_action( 'init', 'bzc_init', 10 );
add_action( 'widgets_init', 'bzc_widgets_init', 10 );

add_action( 'bzc_widgets_init', array( 'BZC_Counter_Widget', 'register_widget' ), 10 );

add_action( 'bzc_init', 'bzc_register_shortcodes' );

function bzc_init() {
	do_action ( 'bzc_init' );
}

function bzc_widgets_init() {
	do_action ( 'bzc_widgets_init' );
}
?>