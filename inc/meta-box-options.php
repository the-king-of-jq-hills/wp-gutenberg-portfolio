<?php
/**
 * Registering meta boxes
 *
 * @link https://docs.metabox.io/
 */

// Disable direct file access.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
} 


add_filter( 'rwmb_meta_boxes', 'wpgp_register_meta_boxes' );

/**
 * Register meta boxes
 *
 * @return void
 */
function wpgp_register_meta_boxes( $meta_boxes )
{
	/**
	 * Prefix of meta keys (optional)
	 * Use underscore (_) at the beginning to make keys hidden
	 * Alt.: You also can make prefix empty to disable it
	 */
	// Better has an underscore as last sign
	$prefix = 'wpgp_';
	

	
	$meta_boxes[] = array(
		// Meta box id, UNIQUE per meta box. Optional since 4.1.5
		'id' => 'portfoliometa2',

		// Meta box title - Will appear at the drag and drop handle bar. Required.
		'title' => __( 'Portfolio Options', 'wp-gutenberg-portfolio' ),

		// Post types, accept custom post types as well - DEFAULT is array('post'). Optional.
		'pages' => array( 'portfolio' ),

		// Where the meta box appear: normal (default), advanced, side. Optional.
		'context' => 'normal',

		// Order of meta box: high (default), low. Optional.
		'priority' => 'high',

		// Auto save: true, false (default). Optional.
		'autosave' => true,

		// List of meta fields
		'fields' => array(

			// name
			array(
                'id'               => "{$prefix}portfolio_featuredimage",
                'name'             => __( 'Portfolio Images', 'wp-gutenberg-portfolio' ),
                'type'             => 'image_advanced',
                'force_delete'     => false,
                'max_file_uploads' => 4,
                'max_status'       => false,
                'image_size'       => 'full',
				'desc'             => __( 'Drop or select maximum 4 images.', 'wp-gutenberg-portfolio' ), 
			),

			// Subtitle
			array(
				'name'  => __( 'Subtitle', 'wp-gutenberg-portfolio' ),
				'id'    => "{$prefix}portfolio_subtitle",
				'desc'  => __( 'Enter a subtitle for use within the portfolio item index (optional).', 'wp-gutenberg-portfolio' ),				
				'type'  => 'text',
			),
			// Portfolio Link
			array(
				'name'  => __( 'Portfolio Link(External)', 'wp-gutenberg-portfolio' ),
				'id'    => "{$prefix}portfolio_url",
				'desc'  => __( 'Enter an external link for the item (optional) (NOTE: INCLUDE HTTP://).', 'wp-gutenberg-portfolio' ),				
				'type'  => 'text',
			),
        
		)
	);		
	return $meta_boxes;
}

// Register The Meta Fields For REST API
add_action( 'rest_api_init', 'wpgp_register_portfolio_meta_fields');
function wpgp_register_portfolio_meta_fields(){

    register_meta( 'post', 'wpgp_portfolio_featuredimage', array(
        'type' => 'string',
        'description' => 'Featured Image',
        'single' => false,
        'show_in_rest' => true
    ));

    register_meta( 'post', 'wpgp_portfolio_subtitle', array(
        'type' => 'string',
        'description' => 'Portfolio Subtitle',
        'single' => true,
        'show_in_rest' => true
    ));
    
    register_meta( 'post', 'wpgp_portfolio_url', array(
        'type' => 'string',
        'description' => 'Portfolio URL',
        'single' => true,
        'show_in_rest' => true
    ));
}

