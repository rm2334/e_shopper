<?php
/**
 * @package e_shopper
 */
 
if ( !function_exists('themes_option') ) {
	function themes_option($id, $fallback = false, $param = false) {
		global $themes_option;
		if ( $fallback == false ) $fallback = '';
		$output = ( isset($themes_option[$id]) && $themes_option[$id] !== '' ) ? $themes_option[$id] : $fallback;
		if (!empty($themes_option[$id]) && $param) {
			$output = $themes_option[$id][$param];
		}
		return $output;
	}
}