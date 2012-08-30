<?php
if ( !defined( 'ABSPATH' ) ) exit;

if ( ! class_exists( 'BBP_Twenty_Ten' ) ) :
	class BZC_Twenty_Ten extends BZC_Theme_Compat {
		public function __construct() {
			$this->setup_globals();
			$this->setup_actions();
		}

		private function setup_globals() {
			$bzc = bizone_cafepress();
			$this->id = 'bzc-twentyten';
			$this->name = 'Twenty Ten (cafePress)';
			$this->version = bzc_get_version();
			$this->dir = trailingslashit( $bzc->themes_dir . 'bzc-twentyten' );
			$this->url = trailingslashit( $bzc->themes_url . 'bzc-twentyten' );
		}

		private function setup_actions() {
			add_action( 'bzc_enqueue_scripts', array( $this, 'enqueue_styles' ) );
			add_action( 'bzc_enqueue_scripts', array( $this, 'enqueue_scripts' ) );
		}

		public function enqueue_styles() {
			if ( 'twentyten' == get_template() ) {
				wp_enqueue_style( 'twentyten', get_template_directory_uri() . '/style.css', '', $this->version, 'screen' );
			}
			wp_enqueue_style( 'bzc-twentyten-cafepress', $this->url, 'css/cafepress.css', 'twentyten', $this->version, 'screen' );
		}

		public function enqueue_scripts() {
		}
	}
new BZC_Twenty_Ten();
endif;
?>