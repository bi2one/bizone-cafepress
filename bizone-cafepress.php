<?php
/*
  Plugin Name: Bizone Cafepress
  Plugin URI: http://twitter.com/bi2one
  Description: cafepress prototype, using bbpress architecture.
  Author: JungGyun Lee
  Version: 0.1
  Author URI: http://twitter.com/bi2one
 */

define( 'WP_DEBUG', true );

/**
 * Main Bizone_Cafepress Class
 *
 * @since bizone-cafepress (v0.1)
 */
final class Bizone_Cafepress {
	private static $instance;

	/**
	 * Main Bizone_Cafepress Instance
	 *
	 * Insures that only one instance of Bizone_Cafepress exists in memory at any one
	 * time. Also prevents needing to define globals all over the place.
	 *
	 * @since bizone-cafepress (v0.1)
	 * @staticvar array $instance
	 * @uses Bizone_Cafepress::setup_globals() Setup the globals needed
	 * @uses Bizone_Cafepress::setup_medias() Include the media files
	 * @uses Bizone_Cafepress::setup_actions() Setup the hooks and actions
	 * @see bizone_cafepress()
	 * @return The one true Bizone_Cafepress
	 */
	public static function instance() {
		if ( ! isset( self::$instance ) ) {
			self::$instance = new Bizone_Cafepress;
			self::$instance->setup_globals();
			self::$instance->includes();
		}
		return self::$instance;
	}

	/**
	 * Include required files
	 *
	 * @since bizone-cafepress (v0.1)
	 * @access private
	 */
	private function includes() {
		/** Core **************************************************************/
		require( $this->plugin_dir . 'bzc-includes/bzc-core-schema.php' );
		require( $this->plugin_dir . 'bzc-includes/bzc-core-actions.php' );
		require( $this->plugin_dir . 'bzc-includes/bzc-core-filters.php' );
		require( $this->plugin_dir . 'bzc-includes/bzc-core-menus.php' );
		require( $this->plugin_dir . 'bzc-includes/bzc-core-meta-boxes.php' );

		/** Models ************************************************************/
		require( $this->plugin_dir . 'bzc-includes/bzc-db-shortcuts.php' );
		require( $this->plugin_dir . 'bzc-includes/bzc-db-boards.php' );
		require( $this->plugin_dir . 'bzc-includes/bzc-db-guestbook-posts.php' );

		/** List Tables *******************************************************/
		// require( $this->plugin_dir . 'bzc-includes/class-bzc-board-list-table.php' );

		/** Templates *********************************************************/
		require( $this->plugin_dir . 'bzc-includes/bzc-board-template.php' );
		require( $this->plugin_dir . 'bzc-includes/bzc-guestbook-template.php' );

		/** Admin *************************************************************/
		if ( is_admin() ) {
			require( $this->plugin_dir . 'bzc-admin/bzc-admin.php' );
			require( $this->plugin_dir . 'bzc-admin/bzc-actions.php' );
		}
	}

	/**
	 * A dummy constructor to prevent Bizone_Cafepress from being loaded more than once.
	 *
	 * @since bizone-cafepress (v0.1)
	 * @see Bizone_Cafepress::instance()
	 * @see bizone_cafepress();
	 */
	public function __construct() { /* do nothing here */ }

	/**
	 * A dummy magic method to prevent Bizone_Cafepress from being cloned
	 *
	 * @since bizone-cafepress (v0.1)
	 */
	public function __clone() { wp_die( __( 'Cheatin&#8217; huh?', 'bizone-cafepress' ) ); }

	/**
	 * A dummy magic method to prevent Bizone_Cafepress from being unserialized
	 *
	 * @since bizone-cafepress (v0.1)
	 */
	public function __wakeup() { wp_die( __( 'Cheatin&#8217; huh?', 'bizone-cafepress' ) ); }

	/**
	 * Set some smart defaults to class variables. Allow some of them to be
	 * filtered to allow for early overriding.
	 *
	 * @since bizone-cafepress (v0.1)
	 * @access private
	 * @uses plugin_basename() To generate bizone-cafepress plugin path
	 * @uses plugin_dir_path() To generate bizone-cafepress plugin path
	 * @uses plugin_dir_url() To generate bizone-cafepress plugin url
	 * @uses apply_filters() Calls various filters
	 */
	private function setup_globals() {
		global $wpdb;
		$this->version         = '0.1';
		$this->db_version      = '1';
		$this->prefix          = $wpdb->prefix . 'bzc_';
		$this->file            = __FILE__;

		$this->basename        = apply_filters( 'bzc_plugin_basename', plugin_basename( $this->file ) );
		$this->plugin_dir      = apply_filters( 'bzc_plugin_dir_path',  plugin_dir_path( $this->file ) );
		$this->plugin_url      = apply_filters( 'bzc_plugin_dir_url', plugin_dir_url( $this->file ) );
		$this->themes_dir = apply_filters( 'bzc_themes_dir', trailingslashit( $this->plugin_dir . 'bzc-themes' ) );
		$this->themes_url = apply_filters( 'bzc_themes_url', trailingslashit( $this->plugin_url . 'bzc-themes' ) );

		/* Queries ************************************************************/

		/* Tables *************************************************************/
		$this->board_table = apply_filters( 'bzc_board_table', $this->prefix . 'boards' );
		$this->guestbook_table = apply_filters( 'bzc_guestbook_table', $this->prefix . 'guestbook_posts' );
		/* Slugs **************************************************************/
		$this->board_slug = apply_filters( 'bzc_board_slug', 'boards' );
		$this->guestbook_post_action_slug = apply_filters( 'bzc_guestbook_post_action_slug', 'guestbook_post' );
		$this->guestbook_remove_action_slug = apply_filters( 'bzc_guestbook_remove_action_slug', 'guestbook_delete' );
	}
}

function bizone_cafepress() {
	return Bizone_Cafepress::instance();
}

/**
 * Hook bizone-cafepress early onto the 'plugins_loaded' action.
 *
 * This gives all other plugins the chance to load before bizone-cafepress, to get their
 * actions, filters, and overrides setup without bizone-cafepress being in the way.
 */
 // dbug('abcde');
if ( defined( 'BIZONE_CAFEPRESS_LATE_LOAD' ) ) {
	add_action( 'plugins_loaded', 'bizone_cafepress', (int) BIZONE_CAFEPRESS_LATE_LOAD );
} else {
	bizone_cafepress();
}
?>