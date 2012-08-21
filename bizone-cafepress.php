<?php
/*
  Plugin Name: Bizone Cafepress
  Plugin URI: http://twitter.com/bi2one
  Description: cafepress prototype
  Author: JungGyun Lee
  Version: 0.1
  Author URI: http://twitter.com/bi2one
 */

define( 'WP_DEBUG', true );
define( 'BIZONE_CAFEPRESS_LATE_LOAD', '100' );
define( 'BIZONE_CAFEPRESS_VERSION', '0.1' );

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
			
			self::$instance->setup_actions();
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
		require( $this->plugin_dir . 'bzc-includes/bzc-core-actions.php' );
		require( $this->plugin_dir . 'bzc-includes/bzc-core-shortcodes.php' );
		require( $this->plugin_dir . 'bzc-includes/bzc-core-widgets.php' );
		
		/** Templates *********************************************************/
		require( $this->plugin_dir . 'bzc-includes/bzc-template-functions.php');
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
		$this->version         = BIZONE_CAFEPRESS_VERSION;
		$this->file            = __FILE__;
		
		$this->basename        = apply_filters( 'bzc_plugin_basename', plugin_basename( $this->file ) );
		$this->plugin_dir      = apply_filters( 'bzc_plugin_dir_path',  plugin_dir_path( $this->file ) );
		$this->plugin_url      = apply_filters( 'bzc_plugin_dir_url', plugin_dir_url( $this->file ) );
		$this->media_admin_dir = apply_filters( 'bzc_admin_media_dir', trailingslashit( $this->plugin_dir . 'admin-media' ) );
		$this->template_dir = apply_filters( 'bzc_template_dir', trailingslashit( $this->plugin_dir . 'bzc-templates' ) );

		/* setup admin */
		/* add_action( 'admin_init', array( $this, 'apply_admin_menu' ) ); */
		/* add_action( 'admin_head', array( $this, 'apply_admin_script' ), 100 ); */

		/* Queries ************************************************************/

		$this->board_query = new stdClass;
	}

	/**
	 * Set media files
	 *
	 * @since bizone-cafepress (v0.1)
	 * @access private
	 */
	private function setup_medias() {
		wp_register_style( 'bzc-admin-style', $this->media_admin_dir . 'style.css' );
	}

	/**
	 * Setup the default hooks and actions
	 *
	 * @since bizone-cafepress (v0.1)
	 * @access private
	 * @uses Bizone_Cafepress::admin_style()
	 * @uses Bizone_Cafepress::admin_reg_menu()
	 * @uses add_action() To add various actions
	 */
	private function setup_actions() {
		add_action( 'admin_init', array( $this, 'admin_style' ) );
		// add_action( 'admin_menu', array( $this, 'apply_admin_menu' ) );
		add_action( 'admin_head', array( $this, 'apply_admin_script' ), 100 );
	}

	public function cafeboard_figure($atts) {
		
	}

	/**
	 * Setup styles for admin
	 *
	 * @since bizone-cafepress (v0.1)
	 * @uses wp_enqueue_style()
	 */
	public function admin_style() {
		wp_enqueue_style( 'bzc-admin-style' );
	}

	/**
	 * Register admin menu
	 *
	 * @since bizone-cafepress (v0.1)
	 */
	public function apply_admin_menu() {
		if ( current_user_can( 'edit_posts' ) && current_user_can( 'edit_pages' ) ) {
			/* TODO ==================================== */
			/* add_filter( 'mce_buttons', array( $this, 'filter_mce_button' ) ); */
			/* add_filter( 'mce_external_plugins', 'simplr_filter_mce_plugin' ); */
		}
	}

	public function apply_admin_script() {
		?>
		<script type="text/javascript">
		//<![CDATA[	  //]]>
		</script> 
		<?php
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