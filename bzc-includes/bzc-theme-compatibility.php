<?php
/**
 * cafepress Core Theme Compatibility
 *
 * @package cafepress
 * @subpackage ThemeCompatibility
 */

if ( ! defined( 'ABSPATH' ) ) exit;

class BZC_Theme_Compat {
	private $_data = array();

	public function __construct( Array $properties = array() ) {
		$this->_data = $properties;
	}

	public function __set( $property, $value ) {
		return $this->_data[$property] = $value;
	}

	public function __get( $property ) {
		return array_key_exists( $property, $this->_data ) ? $this->_data[$property] : '';
	}
}

function bzc_setup_theme_compat( $theme = '' ) {
	$bzc = bizone_cafepress();
	// Make sure theme package is available, set to default if not
	if ( ! isset( $bzc->theme_compat->packages[$theme] ) || ! is_a( $bzc->theme_compat->packages[$theme], 'BZC_Theme_Compat' ) ) {
		$theme = 'default';
	}

	// Set the active theme compat theme
	$bzc->theme_compat->theme = $bzc->theme_compat->packages[$theme];
}

/**
 * Register a new cafepress theme package to the active theme packages array
 *
 * @since cafepress (v0.1)
 * @param array $theme
 */
function bzc_register_theme_package( $theme = array(), $override = true ) {
	// Create new BZC_Theme_Compat object from the $theme array
	if ( is_array( $theme ) )
		$theme = new BZC_Theme_Compat( $theme );

	// Bail if $theme isn't a proper object
	if ( ! is_a( $theme, 'BZC_Theme_Compat' ) )
		return;
	// Load up cafepress
	$bzc = bizone_cafepress();

	// Only override if the flag is set and not previously registered
	if ( empty( $bzc->theme_compat->packages[$theme->id] ) || ( true === $override ) ) {
		$bzc->theme_compat->packages[$theme->id] = $theme;
	}
}

/**
 * Gets the cafepress compatable theme used in the event the currently active
 * WordPress theme does not explicitly support cafepress. This can be filtered,
 * or set manually. Tricky theme authors can override the default and include
 * their own cafepress compatability layers for their themes.
 *
 * @since cafepress (v0.1)
 * @uses apply_filters()
 * @return string
 */
function bzc_get_theme_compat_dir() {
	return apply_filters( 'bzc_get_theme_compat_dir', bizone_cafepress()->theme_compat->theme->dir );
}
?>