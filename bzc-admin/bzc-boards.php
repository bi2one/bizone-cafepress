<?php
if ( !defined( 'ABSPATH' ) ) exit;
if ( !class_exists( 'BZC_Boards_Admin' ) ) :
	/**
	 * Loads bizone cafepress boards admin area
	 */
	class BZC_Boards_Admin {
		public function __construct() {
			$this->setup_globals();
			$this->setup_menus();
			$this->setup_actions();
		}

		private function setup_menus() {
			add_menu_page( 'Boards', 'Boards', 'activate_plugins', 'boardpage', null, '', 25 );
			$this->menu_boards = add_submenu_page( 'boardpage', 'All Boards', 'All Boards', 'activate_plugins', $this->page_read, array( $this, 'render_board_menu' ) );
			$this->menu_new = add_submenu_page( 'boardpage', 'Add New', 'Add New', 'activate_plugins', $this->page_new, array( $this, 'render_board_menu_insert' ) );
		}

		private function setup_actions() {
			add_action( 'bzc_admin_menu', array( $this, 'setup_menus') );

			// Style and Script
			add_action( 'bzc_admin_head', array( $this, 'admin_head' ) );

			// Contextual Help
			add_action( 'admin_print_styles-' . $this->menu_boards, array( $this, 'help_new' ) );
			add_action( 'admin_print_styles-' . $this->menu_new, array( $this, 'help_new' ) );
		}

		public function new_url( $id = '' ) {
			echo get_new_url( $id );
		}

		public function get_new_url( $id = '' ) {
			if ( empty ( $id ) ) {
				return admin_url( 'admin.php?page=' . $this->menu_new );
			} else {
				return admin_url( 'admin.php?page=' . $this->menu_new . '&board=' . $id );
			}
		}

		public function admin_head() {
			$bzc = bizone_cafepress();
			?>
			<link rel="stylesheet" href="<?php $bzc->admin->style_url( 'bzc_common.css' ); ?>" type="text/css" media="all">
			<?php
		}

		private function setup_globals() {
			$this->page_new = 'boardpage_new';
			$this->page_read = 'boardpage';
		}

		private function bail() {

		}

		public function render_board_menu() {
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

		public function attributes_metabox_save() {
			?>
			<div class="submitbox" id="submitboard">
				<div id="minor-publishing">
					<div style="display:none;">
						<?php submit_button( 'Save', 'button', 'save' ); ?>
					</div>
				</div>
				<div id="major-publishing-actions">
					<div id="delete-action">
						<a class="submitdelete deletion" href="<?php echo bzc_get_delete_board_link( $_REQUEST['board'] ) ?>">Delete</a>
					</div>
					<div id="publishing-action">
						<img src="<?php echo esc_url( admin_url( 'images/wpspin_light.gif' ) ); ?>" class="ajax-loading" id="ajax-loading" alt="" />
						<input name="original_publish" type="hidden" id="original_publish" value="<?php esc_attr_e('Publish') ?>" />
						<?php submit_button( 'Publish', 'primary', 'publish', false, array( 'tabindex' => '5', 'accesskey' => 'p' ) ); ?>
					</div>
					<div class="clear"></div>
				</div>
			</div>
			<?php
		}

		public function render_board_menu_insert() {
			$bzc = bizone_cafepress();
			add_meta_box( 'submitdiv', 'Publish', array( $this, 'attributes_metabox_save' ), null, 'side', 'core' );
			?>
			<div class="wrap">
				<div id="icon-edit-pages" class="icon32 icon32-posts-page"><br></div>
				<h2>Add New Board</h2>
			</div>
			<form name="post" action="<?php $bzc->admin->board_action_url('save'); ?>" method="post" id="post">
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

		public function help_new() {
			if ( $this->bail() ) return;
			global $current_screen;
			$about_boards = '<p>' . 'To activate board. fill here! help test!' . '</p>';
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
	}

endif; // class_exists check

function bzc_admin_boards() {
	bizone_cafepress()->admin->boards = new BZC_Boards_Admin();
}
?>
