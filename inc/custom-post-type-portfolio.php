<?php
/**
 * Functions to register custom post type
 *
 * @since    1.0.0
 */ 

// Disable direct file access.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
} 


/*
* Creating the CPT
*/  
function wpg_custom_post_type() {
  
	// Set UI labels for Custom Post Type
		$labels = array(
			'name'                => _x( 'Portfolio', 'Post Type General Name', 'wp-gutenberg-portfolio' ),
			'singular_name'       => _x( 'Portfolio Item', 'Post Type Singular Name', 'wp-gutenberg-portfolio' ),
			'menu_name'           => __( 'Portfolio', 'wp-gutenberg-portfolio' ),
			'all_items'           => __( 'All Portfolio Items', 'wp-gutenberg-portfolio' ),
			'view_item'           => __( 'View Portfolio', 'wp-gutenberg-portfolio' ),
			'add_new_item'        => __( 'Add New Portfolio Item', 'wp-gutenberg-portfolio' ),
			'add_new'             => __( 'Add New', 'wp-gutenberg-portfolio' ),
			'edit_item'           => __( 'Edit Portfolio Item', 'wp-gutenberg-portfolio' ),
			'update_item'         => __( 'Update Portfolio Item', 'wp-gutenberg-portfolio' ),
			'search_items'        => __( 'Search Portfolio Items', 'wp-gutenberg-portfolio' ),
			'not_found'           => __( 'Not Found', 'wp-gutenberg-portfolio' ),
			'not_found_in_trash'  => __( 'Not found in Trash', 'wp-gutenberg-portfolio' ),
		);
		  
	// Set other options for Custom Post Type
		  
		$args = array(
			'label'               => __( 'portfolio', 'wp-gutenberg-portfolio' ),
			'description'         => __( 'Portfolio', 'wp-gutenberg-portfolio' ),
			'labels'              => $labels,
			'supports'            => array( 'title', 
											'editor',
											'author',
											'comments',
											'revisions', 
											'custom-fields', 
											'tags', 
											'excerpt', 
											//'thumbnail',
											'page-attributes'
										),
			'taxonomies'          => array( 'portfolio-category', 'portfolio-tag' ),
			'hierarchical'        => false,
			'public'              => true,
			'show_in_menu'        => true,
			'query_var'           => true,
			'rewrite'             => array( 'slug' => 'portfolio','with_front' => false ),			
			'show_in_admin_bar'   => true,
			'menu_position'       => 4,
			'can_export'          => true,
			'has_archive'         => true,
			'exclude_from_search' => false,
			'publicly_queryable'  => true,
			'capability_type'     => 'post',
			'show_in_rest' 		  => true,
			'rest_controller_class' => 'WP_REST_Posts_Controller',
			'rest_base'             => 'portfolio',
	  
		);		  
		register_post_type( 'portfolio', $args );

		// Register Portfolio Category
		register_taxonomy('portfolio-category', 'portfolio', array(
			'hierarchical' => true,
			'labels' => array(
				'name'              => esc_html__( 'Category', 'wp-gutenberg-portfolio' ),
				'singular_name'     => esc_html__( 'Category', 'wp-gutenberg-portfolio' ),
				'search_items'      => esc_html__( 'Search Category', 'wp-gutenberg-portfolio' ),
				'all_items'         => esc_html__( 'All Categories', 'wp-gutenberg-portfolio' ),
				'parent_item'       => esc_html__( 'Parent Category', 'wp-gutenberg-portfolio' ),
				'parent_item_colon' => esc_html__( 'Parent Category', 'wp-gutenberg-portfolio' ),
				'edit_item'         => esc_html__( 'Edit Category', 'wp-gutenberg-portfolio' ),
				'update_item'       => esc_html__( 'Update Category', 'wp-gutenberg-portfolio' ),
				'add_new_item'      => esc_html__( 'Add New Category', 'wp-gutenberg-portfolio' ),
				'new_item_name'     => esc_html__( 'New Category', 'wp-gutenberg-portfolio' ),
				'menu_name'         => esc_html__( 'Categories', 'wp-gutenberg-portfolio' ),
			),
			'rewrite' => array(
				'slug'         => 'portfolio-category',
				'with_front'   => true,
				'hierarchical' => true
			),
			'show_in_nav_menus' => true,
			'show_tagcloud'     => true,
			'show_admin_column' => true,
			'show_in_rest'          => true,
			'rest_controller_class' => 'WP_REST_Terms_Controller',
			'rest_base'             => 'portfolio_category',
		));		

	// Register Portfolio Tags
		register_taxonomy('portfolio-tag', 'portfolio', array(
			'hierarchical' => false,
			'labels' => array(
				'name'              => esc_html__( 'Portfolio Tags', 'wp-gutenberg-portfolio' ),
				'singular_name'     => esc_html__( 'Portfolio Tag', 'wp-gutenberg-portfolio' ),
				'search_items'      => esc_html__( 'Search Portfolio Tags', 'wp-gutenberg-portfolio' ),
				'all_items'         => esc_html__( 'All Portfolio Tags', 'wp-gutenberg-portfolio' ),
				'parent_item'       => esc_html__( 'Parent Portfolio Tags', 'wp-gutenberg-portfolio' ),
				'parent_item_colon' => esc_html__( 'Parent Portfolio Tag:', 'wp-gutenberg-portfolio' ),
				'edit_item'         => esc_html__( 'Edit Portfolio Tag', 'wp-gutenberg-portfolio' ),
				'update_item'       => esc_html__( 'Update Portfolio Tag', 'wp-gutenberg-portfolio' ),
				'add_new_item'      => esc_html__( 'Add New Portfolio Tag', 'wp-gutenberg-portfolio' ),
				'new_item_name'     => esc_html__( 'New Portfolio Tag', 'wp-gutenberg-portfolio' ),
				'menu_name'         => esc_html__( 'Tags', 'wp-gutenberg-portfolio' ),
			),
			'rewrite'          => array(
				'slug'         => 'portfolio-tag',
				'with_front'   => true,
				'hierarchical' => false
			),
			'show_in_rest'          => true,
			'rest_controller_class' => 'WP_REST_Terms_Controller',
			'rest_base'             => 'portfolio_tag',
		));
		
		
}

add_action( 'init', 'wpg_custom_post_type', 0 );


