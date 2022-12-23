<?php
/**
 * The template for displaying EventsArchive pages
 *
 * @since wpgp 1.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

get_header(); ?>

	<div id="primary" class="content-area">
		<div id="content" class="site-content" role="main">
		<?php if ( have_posts() ) : ?>
			<?php /* The loop */ ?>
			<?php while ( have_posts() ) : the_post(); ?>

				
			<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
				<div class="wpgp-archive-row">
					<div class="wpgp-slider-wrap">
						<div class="wpgp-archive-images swiper">
							<div class="swiper-wrapper">
							<?php
								$imgURL = WPG_PORTFOLIO_URL . 'assets/missing.webp';
								$img_ids = get_post_meta(get_the_ID(), 'wpgp_portfolio_featuredimage', false);

								if ( is_array($img_ids) )
								{
									foreach ( $img_ids as $imgid ) {
										$imgURL = wp_get_attachment_image_url( $imgid, 'full', false );
										?>
											<div class="swiper-slide" style="background-image: url(<?php echo esc_url($imgURL); ?>)"></div>
										<?php
									}
								} else {
									?>
										<div class="wpgp-archive-slide" style="background-image: url(<?php echo esc_url($imgURL); ?>)"></div>
									<?php							
								}

							?>
							</div>

						</div>
					</div>	  
					
					<?php
						$sub_title = get_post_meta(get_the_ID(), 'wpgp_portfolio_subtitle', true);
					?>
					<div class="post-mainpart">    
						<header class="entry-header">
							<h2 class="entry-title">
								<a href="<?php the_permalink(); ?>" rel="bookmark"><?php the_title(); ?></a>
							</h2>
							<?php if (!empty($sub_title)) : ?>
								<h4 class="wpgp-subtitle"><?php echo esc_html($sub_title); ?></h4>
							<?php endif; ?>							
						</header><!-- .entry-header -->
					
						<div class="entry-summary">
							<?php the_excerpt(); ?>
						</div><!-- .entry-summary -->
					</div>
				</div>
			</article>



			<?php endwhile; ?>

            <?php the_posts_pagination(); ?>            

		<?php else : ?>
			<?php get_template_part( 'content', 'none' ); ?>
		<?php endif; ?>

		</div><!-- #content -->
        <?php get_sidebar(); ?>
	</div><!-- #primary -->


<?php get_footer(); ?>