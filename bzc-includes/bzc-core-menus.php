<?php
if ( ! defined( 'ABSPATH' ) ) exit;

function bzc_add_board_menu() {
	add_menu_page( 'Boards', 'Boards', 'add_users', 'boardpage', 'bzc_render_board_menu', '', 30 );
	add_submenu_page( 'boardpage', 'All Boards', 'All Boards', 'add_users', 'boardpage', 'bzc_render_board_menu' );
	$hook = add_submenu_page( 'boardpage', 'Add New', 'Add New', 'add_users', 'boardpage_new', 'bzc_render_board_menu_insert' );
	add_action( 'admin_print_styles-' . $hook, 'bzc_insert_help' );
}

function bzc_render_board_menu() {
	$list_table = new BZC_Board_List_Table;
	$list_table->prepare_items();
	?>
	<div class="wrap">
		<div id="icon-users" class="icon32"><br/></div>
		<h2>Boards</h2>
		<form id="boards-filter" method="get">
			<input type="hidden" name="page" value="<?php echo $_REQUEST['page'] ?>" />
			<?php $list_table->display() ?>
		</form>
	</div>
	<?php
}

function do_rewrite() {
	add_rewrite_rule('^guestbook/([^/]+)/?$', 'index.php?pagename=guestbook&myvar=$matches[1]','top');
	add_rewrite_tag('%myvar%','([^&]+)');
	flush_rewrite_rules();
}
add_action('init', 'do_rewrite');

function bzc_insert_help() {
	global $current_screen;
	$about_boards = '<p>' . 'To activate board. fill here! 박웅엽 바보' . '</p>';
	$current_screen->add_help_tab( array(
		'id' => 'about-boards',
		'title' => 'About Boards',
		'content' => $about_boards
	) );
	$current_screen->set_help_sidebar(
		'<p><strong>' . 'For more information:' . '</strong></p>' .
		'<p><a href="http://twitter.com/bi2one/" target="_blank">bi2one Twitter</a></p>'
	);
}

function bzc_render_board_menu_insert() {
	add_meta_box( 'submitdiv', 'Publish', 'bzc_submit_meta_box', null, 'side', 'core' );
?>
	<div class="wrap">
		<div id="icon-edit-pages" class="icon32 icon32-posts-page"><br></div>
		<h2>Add New Board</h2>
	</div>
	<form name="post" action="#" method="post" id="post">
		<div id="poststuff">
			<div id="post-body" class="metabox-holder columns-2">
				<div id="post-body-content">
					<div id="titlediv">
						<div id="titlewrap">
							<label class="hide-if-no-js" style="visibility:hidden" id="title-prompt-text" for="title"><?php echo apply_filters( 'bzc_enter_title_here', 'Enter title here' ); ?></label>
							<input type="text" name="board_title" size="30" tabindex="1" id="title" autocomplete="off" />
						</div>
					</div>

					<div id="postdivrich" class="postarea">
						<?php wp_editor('', 'content', array('dfw' => true, 'tabindex' => 1) ); ?>
					</div>
				</div>

				<div id="postbox-container-1" class="postbox-container">
					<?php do_meta_boxes( null, 'side', null ); ?>
				</div>
			</div> <!-- post-body -->
			<br class="clear" />
		</div> <!-- /poststuff -->
	</form>
	<?php
}
?>
