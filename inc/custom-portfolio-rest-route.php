<?php

/**
 * Custom REST Rout
 *
 * @since    1.0.0
 */ 

//Register REST route for the portfolio post type
//url would be https://www.example.com/wp-json/wpportfolio/v1/portfolio
function register_wpgp_rest_route()
{
    register_rest_route('wpportfolio/v1', 'portfolio', [
        'methods'  => 'GET',
        'callback' => 'wpgp_custom_rest_route',
        'permission_callback' => '__return_true',
    ]);
}
add_action('rest_api_init', 'register_wpgp_rest_route');

// Custom REST Route callback function
function wpgp_custom_rest_route()
{

	$results = [];

    $portfolio_query = new WP_Query([
        'post_type' => 'portfolio',
        'posts_per_page' => -1,
    ]);

 
    // proceed to database query
    while ($portfolio_query->have_posts()) {

        $img_urls = [];
        
        $portfolio_query->the_post();

		//Get the portfolio category list and strip the link
        $portfolio_terms = get_the_terms(get_the_ID(), 'portfolio-category');
		$portfolio_categories = wp_list_pluck($portfolio_terms, 'name'); 


        //get the images ids and create an array of image urls from it
        $img_ids = get_post_meta(get_the_ID(), 'wpgp_portfolio_featuredimage', false);

        foreach ( $img_ids as $imgid ) {
            array_push( $img_urls, wp_get_attachment_image_url( $imgid, 'medium', false ) );
        }

        // Creating the REST Route
        array_push($results, [
			'ID'                    => get_the_ID(),
            'title'                 => get_the_title(),
            'details'               => get_the_content(),			
            'subtitle'              => get_post_meta(get_the_ID(), 'wpgp_portfolio_subtitle', true),
            'link'                  => get_post_meta(get_the_ID(), 'wpgp_portfolio_url', true),
            'featured Image'        => get_the_post_thumbnail_url( get_the_ID(), 'full' ),
            'mediaurls'                 => $img_urls,
			'categories'		    => $portfolio_categories,

        ]);
    }
 
    wp_reset_postdata(); 
    return $results;
}
