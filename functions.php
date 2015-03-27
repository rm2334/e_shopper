<?php
/**
 * storefront engine room
 *
 * @package storefront
 */

/**
 * Initialize all the things.
 */
require get_template_directory() . '/inc/init.php';

/**
 * Include the Redux theme options Framework.
 */
if ( !class_exists( 'ReduxFramework' ) ) {
	require_once( get_template_directory() . '/inc/admin/framework.php' );
}

/**
 * Register all the theme options.
 */
require_once( get_template_directory() . '/inc/redux-config.php' );

/**
 * Theme options functions.
 */
require_once( get_template_directory() . '/inc/themes-option.php' );

/**
 * Note: Do not add any custom code here. Please use a child theme so that your customizations aren't lost during updates.
 * http://codex.wordpress.org/Child_Themes
 */