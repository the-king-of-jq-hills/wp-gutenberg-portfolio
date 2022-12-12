<?php
/**
 * Plugin Name:       WP Gutenberg Portfolio
 * Description:       A gutenberg portfolio block plugin to create and showcase portfolio items.
 * Requires at least: 6.1
 * Requires PHP:      7.0
 * Version:           0.1.0
 * Author:            marsian
 * License:           GPL-2.0-or-later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:       wp-gutenberg-portfolio
 *
 * @package           create-block
 */


// Disable direct file access.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
} 

// Define Global Variables
define( 'WPG_PORTFOLIO_DIR', plugin_dir_path( __FILE__ ) );
define( 'WPG_PORTFOLIO_URL', plugins_url( '/', __FILE__ ) );
define( 'WPG_PORTFOLIO_VERSION', '0.1.0' );


/**
 * Registers the block using the metadata loaded from the `block.json` file.
*/
function wpgo_create_block_init() {
	register_block_type( __DIR__ . '/build/showcase' );
	register_block_type( __DIR__ . '/build/slider' );
}
add_action( 'init', 'wpgo_create_block_init' );


// Add Meta Boxes
require_once('inc/meta-box-options.php');

// Embed plugin meta-box if plugin not installed and active
include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
if ( !is_plugin_active( 'meta-box/meta-box.php' ) && !function_exists( 'rwmb_meta' ) ) {
	require_once('inc/meta-box/meta-box.php');
}

// Custom post type and taxonomy
require plugin_dir_path( __FILE__ ) . 'inc/custom-post-type-portfolio.php';

// Custom REST route for portfolio post type
require plugin_dir_path( __FILE__ ) . 'inc/custom-portfolio-rest-route.php';
