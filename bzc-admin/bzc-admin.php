<?php
if ( ! defined( 'ABSPATH' ) ) exit;
if ( ! class_exists( 'BZC_Admin' ) ) :
	class BZC_Admin {
		public $admin_dir = '';
		public $admin_url = '';
		public $images_url = '';
		public $styles_url = '';

		public function __construct() {
			$this->setup_globals();
			$this->includes();
			$this->setup_actions();
		}

		private function setup_globals() {
			$bzc = bizone_cafepress();
			$this->admin_dir = trailingslashit( $bzc->plugin_dir . 'bzc-admin' );
			$this->admin_url = trailingslashit( $bzc->plugin_url . 'bzc-admin' );
			$this->images_url = trailingslashit( $this->admin_dir . 'images' );
			$this->styles_url = trailingslashit( $this->admin_url . 'styles' );
		}

		public function style_url( $filename ) {
			echo $this->get_style_url( $filename );
		}

		public function get_style_url( $filename ) {
			return home_url( $this->styles_url . $filename );
		}

		public function board_action_url( $action ) {
			echo $this->get_board_action_url( $action );
		}

		public function get_board_action_url( $action ) {
			return $this->admin_url . 'bzc-action-boards.php?action=' . $action;
		}

		private function includes() {
			/** Admins ********************************************************/
			require( $this->admin_dir . 'bzc-boards.php' );

			/** List Tables ***************************************************/
			require( $this->admin_dir . 'class-bzc-board-list-table.php' );
		}

		private function setup_actions() {
			add_action( 'bzc_activation', array( $this, 'new_install' ) );
		}

		public function new_install() {
		}
	}
endif;

function bzc_admin() {
	bizone_cafepress()->admin = new BZC_Admin;
}
?>

