<?php
/**
 * storefront engine room
 *
 * @package storefront
 */

/**
 * Setup.
 * Enqueue styles, register widget regions, etc.
 */
require get_template_directory() . '/inc/functions/setup.php';

/**
 * Custom functions that act independently of the theme templates.
 */
require get_template_directory() . '/inc/functions/extras.php';


/**
 * Load Jetpack compatibility file.
 */
require get_template_directory() . '/inc/jetpack/jetpack.php';

/**
 * Welcome screen
 */
if ( is_admin() ) {
	require get_template_directory() . '/inc/functions/welcome-screen.php';
}

