<?php
/**
 * Template to display event
 *
 * @since wpgp 1.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

get_header(); ?>

	<?php 
		global $post;
		
		$sub_title = get_post_meta(get_the_ID(), 'wpgp_portfolio_subtitle', true);
		$folio_url = get_post_meta(get_the_ID(), 'wpgp_portfolio_url', true);
		$categories_list = wp_get_post_terms(get_the_ID(), 'portfolio-category');
		
	?>
    
            
	<div id="primary" class="content-area">
		<div id="content" class="site-content" role="main">

			<?php /* The loop */ ?>
			<?php while ( have_posts() ) : the_post(); ?>

				<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                	<?php if ( get_post_meta(get_the_ID(), 'wpgp_portfolio_featuredimage', false) ) : ?>
					<header class="entry-header">
						<div class="entry-thumbnail" >

							<div class="swiper mySwiper">
								<div class="swiper-wrapper">
									<?php
										$img_ids = get_post_meta(get_the_ID(), 'wpgp_portfolio_featuredimage', false);
										
										if ( is_array($img_ids) )
										{
											foreach ( $img_ids as $imgid ) {
												$imgURL = wp_get_attachment_image_url( $imgid, 'full', false );
												?>
													<div class="swiper-slide" style="background-image: url(<?php echo esc_url($imgURL); ?>)">
													</div>
												<?php
											}
										}
										
									?>
								</div>
								<div class="swiper-pagination"></div>
								<div class="swiper-button-prev"></div>
								<div class="swiper-button-next"></div>
							</div>

						</div>
						
					</header><!-- .entry-header -->
                    <?php endif; ?>
                    
                    <div class="folio-meta">
						<?php if (!empty($sub_title)) : ?>
							<h2 class="wpgp-subtitle"><?php echo esc_html($sub_title); ?></h2>
						<?php endif; ?>
						<?php
						if (!empty($folio_url))
						{
						?>
							<div class="proj-url">
							<span class="genericon genericon-external"></span>
							<a href="<?php echo esc_url($folio_url); ?>"><?php echo esc_html($folio_url); ?></a>
							</div>
						<?php
						}
						?>                    
						
						<div>
						<?php
							if ( $categories_list ) {
								foreach ( $categories_list as $category) {
									?>
										<a href="<?php echo esc_url( get_term_link( $category )) ?>"><?php esc_html_e($category->name); ?></a> 
									<?php
								}
							}					
						?>
						</div>                  
					</div>
                    
					<div class="entry-content">
						<?php the_content(); ?>
						<?php wp_link_pages( array( 'before' => '<div class="page-links"><span class="page-links-title">' . __( 'Pages:', 'i-design' ) . '</span>', 'after' => '</div>', 'link_before' => '<span>', 'link_after' => '</span>' ) ); ?>
					</div><!-- .entry-content -->
				</article><!-- #post -->

				<?php comments_template(); ?>
			<?php endwhile; ?>

		</div><!-- #content -->
        <?php get_sidebar(); ?>
	</div><!-- #primary -->


<?php get_footer();