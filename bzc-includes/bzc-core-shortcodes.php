<?php
/**
 * bizone-cafepress Shortcodes
 *
 * @package bizone-cafepress
 * @subpackage Shortcodes
 */

// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) exit;

/**
 * bizone-cafepress Shortcode Class
 *
 * @since bizone-cafepress (v0.1)
 */
class BZC_Shortcodes {
	/** Vars ******************************************************************/

	/**
	 * @var array Shortcode => function
	 */
	public $codes = array();

	/** Functions *************************************************************/
	public function __construct() {
		$this->setup_globals();
		$this->add_shortcodes();
	}

	private function setup_globals() {
		$this->codes = apply_filters( 'bzc_shortcodes', array(
			// Board
			'bzc-board' => array( $this, 'display_board' ),
		) );
	}

	private function add_shortcodes() {
		foreach( $this->codes as $code => $function ) {
			add_shortcode( $code, $function );
		}

		do_action( 'bzc_register_shortcodes');
	}

	private function start( $query_name = '' ) {
		ob_start();
	}

	private function end() {
		$output = ob_get_contents();
		ob_end_clean();
		return $output;
	}

	/** shortcodes ************************************************************/
	
	public function display_board() {
		$this->start();
		$cafepress = bizone_cafepress();
		$cafepress->board_query->query_vars['name'] = "hello cafepress.";
		
		bzc_get_template_part( 'content', 'board' );
		return $this->end();
	}
}

function bzc_register_shortcodes() {
	bizone_cafepress()->shortcodes = new BZC_Shortcodes();
}
?>