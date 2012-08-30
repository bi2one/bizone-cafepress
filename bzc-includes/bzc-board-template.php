<?php
if ( !defined( 'ABSPATH' ) ) exit;

class BZC_Board_Builder {
	public function __construct( $board ) {
		$type = $board->type;
		switch( $type ) {
			case 'guestbook':
			default:
				$this->type = 'guestbook';
		}
	}

	public function render_board() {
		$bzc = bizone_cafepress();
?>
		<div id="container">
			<div id="content" role="main">
		<?php include( $bzc->plugin_dir . 'bzc-templates/board-posts-message.php' ); ?>
		<?php include( $bzc->plugin_dir . 'bzc-templates/' . $this->type . '-posts-loop.php' ); ?>
		<?php include( $bzc->plugin_dir . 'bzc-templates/' . $this->type . '-posts-form.php' ); ?>
			</div>
		</div>
<?php
	}
}

function bzc_get_board_url( $board_id, $message_id ) {
	$bzc = bizone_cafepress();
	return home_url( sprintf( $bzc->board_slug . '/%d/?message=%d', $board_id, $message_id ) );
}

function bzc_board_handler() {
	global $wp;
	$bzc = bizone_cafepress();
	$pagename = $wp->query_vars['pagename'];
	if ( $bzc->board_slug !== $pagename || ! empty( $wp->query_vars['action'] ) )
		return;
	$board = bzc_get_board( $wp->query_vars['board'] );
	if ( empty( $board ) ) {
		return;
	}
	$builder = new BZC_Board_Builder( $board );

	/* render */
	get_header();
	$builder->render_board();
	get_footer();
	exit();
}
?>
