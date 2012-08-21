<?php

/**
 * bizone-cafepress Template Functions
 *
 * This file contains functions necessary to mirror the WordPress core template
 * loading process. Many of those functions are not filterable, and even then
 * would not be robust enough to predict where bizone cafepress templates might exist.
 *
 * @package bizone-cafepress
 * @subpackage TemplateFunctions
 */

/**
 * Adds bizone-cafepress theme support to any active WordPress theme
 *
 * @since bizone-cafepress (v0.1)
 *
 * @param string $slug
 * @param string $name Optional. Default null
 * @uses bzc_locate_template()
 * @uses load_template()
 * @uses get_template_part()
 */
function bzc_get_template_part( $slug, $name = null ) {
	// Execute code for this part
	do_action( 'get_template_part_' . $slug, $slug, $name );

	// Setup possible parts
	$templates = array();
	if ( isset( $name ) )
		$templates[] = $slug . '-' . $name . '.php';
	$templates[] = $slug . '.php';

	// Allow template parst to be filtered
	$templates = apply_filters( 'bzc_get_template_part', $templates, $slug, $name );

	// Return the part that is found
	/* echo isset(bzc_locate_template( $templates, true, false )); */
	return bzc_locate_template( $templates, true, false );
}

/**
 * Retrieve the name of the highest priority template file that exists.
 *
 * Searches in the STYLESHEETPATH before TEMPLATEPATH so that themes which
 * inherit from a parent theme can just overload one file. If the template is
 * not found in either of those, it looks in the theme-compat folder last.
 *
 * @since bizone-cafepress (v0.1)
 *
 * @param string|array $template_names Template file(s) to search for, in order.
 * @param bool $load If true the template file will be loaded if it is found.
 * @param bool $require_once Whether to require_once or require. Default true.
 *                            Has no effect if $load is false.
 * @return string The template filename if one is located.
 */
function bzc_locate_template( $template_names, $load = false, $require_once = true ) {
	// No file found yet
	$located = false;

	// Try to find a template file
	foreach ( (array) $template_names as $template_name ) {
		// Continue if template is empty
		if ( empty( $template_name ) )
			continue;

		// Trim off any slashes from the template name
		$template_name = bizone_cafepress()->template_dir . ltrim( $template_name, '/' );
		
		if ( file_exists( $template_name ) ) {
			$located = $template_name;
			break;
		}
	}

	if ( ( true == $load ) && !empty( $located ) )
		load_template( $located, $require_once );
	
	return $located;
}
?>