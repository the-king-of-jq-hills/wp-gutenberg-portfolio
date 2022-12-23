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
	
	register_block_type( __DIR__ . '/build', array( 'render_callback' => 'wpg_portfolio_render_front' ) );

	// site-url requred to access REST API
	wp_localize_script( 'create-block-portfolio-showcase-editor-script', 'wpgp_data', [ 'siteUrl' => get_site_url() ] );
}
add_action( 'init', 'wpgo_create_block_init' );


// enque block assets for back and front
function wpg_portfolio_block_assets() {

    // enque dashicons
    wp_enqueue_style( 'dashicons' );

	// enque portfolio style
    wp_enqueue_style( 'portfolio-style',  WPG_PORTFOLIO_URL . 'assets/css/portfolio-style.css', array(), WPG_PORTFOLIO_VERSION, false  );

    // Swiper Style
    wp_enqueue_style( 'swiper-style',  WPG_PORTFOLIO_URL . 'assets/css/swiper-bundle.min.css', array(), WPG_PORTFOLIO_VERSION, false  );

    // enque masonry script from WP Library
    wp_enqueue_script( 'jquery-masonry' );

    // swiper js
    wp_enqueue_script( 'swiperjs',  WPG_PORTFOLIO_URL . 'assets/js/swiper-bundle.min.js', array(), WPG_PORTFOLIO_VERSION, false  );    

	// enque custom stripts
	wp_enqueue_script( 'jquery-inview',  WPG_PORTFOLIO_URL . 'assets/js/jquery.inview.min.js', array('jquery'), WPG_PORTFOLIO_VERSION, true );

	// enque custom stripts
	wp_enqueue_script( 'portfolio-script',  WPG_PORTFOLIO_URL . 'assets/js/portfolio-script.js', array('jquery'), WPG_PORTFOLIO_VERSION, true );
}
add_action( 'enqueue_block_assets', 'wpg_portfolio_block_assets' );


/* Filter the single_template */
add_filter('single_template', 'wpgp_single_template');

function wpgp_single_template($single) {

    global $post;

    /* Checks for single template by post type */
    if ( $post->post_type == 'portfolio' ) {
        if ( plugin_dir_path( __FILE__ ) . 'templates/single-portfolio.php' ) {
            return plugin_dir_path( __FILE__ ) . 'templates/single-portfolio.php';
        }
    }

    return $single;
}

/* Filter the archive_template function */
add_filter('archive_template', 'wpgp_archive_template');

function wpgp_archive_template($single) {

    global $post;

    /* Checks for single template by post type */
    if ( $post->post_type == 'portfolio' ) {
        if ( plugin_dir_path( __FILE__ ) . 'templates/archive-portfolio.php' ) {
            return plugin_dir_path( __FILE__ ) . 'templates/archive-portfolio.php';
        }
    }

    return $single;
}


// Embed plugin meta-box if plugin not installed and active
include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
if ( !is_plugin_active( 'meta-box/meta-box.php' ) && !function_exists( 'rwmb_meta' ) ) {
	require_once('inc/meta-box/meta-box.php');
}

// Add Meta Boxes
require_once('inc/meta-box-options.php');


// Custom post type and taxonomy
require plugin_dir_path( __FILE__ ) . 'inc/custom-post-type-portfolio.php';

// Custom REST route for portfolio post type
require plugin_dir_path( __FILE__ ) . 'inc/custom-portfolio-rest-route.php';

// Frontend
require plugin_dir_path( __FILE__ ) . 'inc/wpg-portfolio-front.php';
