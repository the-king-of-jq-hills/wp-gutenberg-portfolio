<?php
/**
 * Functions for the frontend
 *
 * @since    1.0.0
 */ 


// Disable direct file access.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
} 

function wpg_portfolio_render_front( $attr, $content, $block ) {

    $output = '';
    $portfolio_categories = '';
    $img_url = WPG_PORTFOLIO_URL . 'assets/missing.webp';

    $output .= '<div ' . get_block_wrapper_attributes() . '>';
    $output .= '<div class="wpg-portfolio wpg-portfolio-front wpgp-column-' . $attr["numberOfColumns"] . '">';


    $portfolio_query = new WP_Query([
        'post_type' => 'portfolio',
        'posts_per_page' => $attr["numberOfItems"],
    ]);

 
    // proceed to database query
    while ($portfolio_query->have_posts()) {

        $img_urls = [];
        $portfolio_query->the_post();


		//Get the portfolio category list and strip the link
        $portfolio_terms = get_the_terms(get_the_ID(), 'portfolio-category');

        if( $portfolio_terms ){
            $portfolio_categories = wp_list_pluck($portfolio_terms, 'name');
            $portfolio_categories = implode(", ", $portfolio_categories);
        }


        //get the images ids and create an array of image urls from it
        $img_ids = get_post_meta(get_the_ID(), 'wpgp_portfolio_featuredimage', false);

        if ( $img_ids ) {
            foreach ( $img_ids as $imgid ) {
                array_push( $img_urls, wp_get_attachment_image_url( $imgid, 'medium', false ) );
            }
            $img_url = $img_urls[0];
        }

        $output .= '<div class="portfolio-item">';
        $output .= '<div class="wpgp-item-container">';

        $output .= '<div class="image-container">';
        $output .= '<a href='.get_the_permalink().' rel="nofollow" target="_blank">';
        $output .= '<img src='.$img_url.' alt='.get_the_title().' class="portfolio-image" />';
        $output .= '</a>';
        $output .= '</div>';
        $output .= '<div class="wpgp-link">';
        $output .= '<a href="'.get_post_meta(get_the_ID(), 'wpgp_portfolio_url', true).'" target="_blank" aria-label="External Link"></a>';
        $output .= '</div>';
        $output .= '<h3>'.get_the_title().'</h3>';
        $output .= '<h4>'.get_post_meta(get_the_ID(), 'wpgp_portfolio_subtitle', true).'</h4>';
        $output .= '<div class="wpgp-cat-list">'.$portfolio_categories.'</div>';

        $output .= '</div>';
        $output .= '</div>';

    }

    $output .= '</div>';        
    $output .= "</div>";    
 
    wp_reset_postdata(); 
    
    return $output ?? '<strong>Sorry! Could not find any portfolio Item.</strong>';
}