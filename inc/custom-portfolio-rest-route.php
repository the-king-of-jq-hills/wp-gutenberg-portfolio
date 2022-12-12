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