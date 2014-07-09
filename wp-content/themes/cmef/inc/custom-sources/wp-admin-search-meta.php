<?php
/**
 * This was pulled from the WP-Admin Search Post Meta plugin written by MELONIO.NET.
 * The reason why I pulled this is because I'm very weary about old plugins.
 */


/**
 * Avoid calling file directly
 */
if ( ! function_exists( 'add_action' ) )
	die( 'Whoops! You shouldn\'t be doing that.' );


/**
 * Plugin version and textdomain constants.
 */
define( 'WPASM_VERSION', '0.1' );
define( 'WPASM_TD', 'wp-admin-search-meta' );


/**
 * Include and initialize class.
 */
if ( ! class_exists( 'WPASM_Search' ) )
	require_once( dirname( __FILE__ ) . '/wpasm-class.php' );

WPASM_Search::init();
