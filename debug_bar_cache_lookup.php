<?php

/**
 * Plugin Name: Debug Bar Cache Lookup
 * Plugin URI:  http://wordpress.org/plugins
 * Description: Look up items in object cache. Requires Debug Bar Plugin.
 * Version:     0.1.0
 * Author:      Allan Collins
 * Author URI:  http://www.allancollins.net/
 * License:     GPLv2+
 * Text Domain: dbcl
 * Domain Path: /languages
 */
/**
 * Copyright (c) 2015 Allan Collins (email : allan.collins@10up.com)
 *
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License, version 2 or, at
 * your discretion, any later version, as published by the Free
 * Software Foundation.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
 */
/**
 * Built using grunt-wp-plugin
 * Copyright (c) 2013 10up, LLC
 * https://github.com/10up/grunt-wp-plugin
 */
// Useful global constants
define( 'DBCL_VERSION', '0.1.0' );
define( 'DBCL_URL', plugin_dir_url( __FILE__ ) );
define( 'DBCL_PATH', dirname( __FILE__ ) . '/' );

/**
 * Add the panel to the Debug Bar.
 * @param array $panels Array of panel objects.
 * @return array Array of panel objects.
 */
function dbcl_add_panel( $panels ) {
	require DBCL_PATH . 'includes/class-debug-bar-cache-lookup.php';
	array_push( $panels, new Debug_Bar_Cache_Lookup() );
	return $panels;
}

add_filter( 'debug_bar_panels', 'dbcl_add_panel' );

/**
 * Enqueue JavaScript, localization and stylesheet.
 */
function dbcl_enqueue() {
	wp_enqueue_style( 'dbcl-css', DBCL_URL . 'assets/css/dbcl.css', array(), '20150113' );
	wp_enqueue_script( 'dbcl-js', DBCL_URL . 'assets/js/dbcl.js', array( 'jquery' ), '20150113' );
	wp_localize_script( 'dbcl-js', 'dbcl', array( 'security' => wp_create_nonce( "dbcl_security" ) ) );
}

add_action( 'debug_bar_enqueue_scripts', 'dbcl_enqueue' );

/**
 * Ajax callback that retrieves the cache object information.
 */
function dbcl_ajax() {
	check_ajax_referer( 'dbcl_security', 'security' );
	$dbcl_key	 = filter_input( INPUT_POST, 'dbcl_key', FILTER_SANITIZE_STRING );
	$dbcl_group	 = filter_input( INPUT_POST, 'dbcl_group', FILTER_SANITIZE_STRING );

	$cache = wp_cache_get( $dbcl_key, $dbcl_group );
	if ( !$cache ) {
		return wp_send_json_error();
	}
	ob_start();
	print_r( $cache );
	$cache = ob_get_clean();
	return wp_send_json_success( array( 'cache' => $cache ) );
}

add_action( 'wp_ajax_dbcl', 'dbcl_ajax' );
