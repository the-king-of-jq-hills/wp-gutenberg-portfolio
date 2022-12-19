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
		
		if ( function_exists( 'rwmb_meta' ) ) {
			$sub_title = esc_html(rwmb_meta('idesign_portfolio_subtitle'));
			$folio_url = esc_url(rwmb_meta('idesign_portfolio_url'));
		}
	?>
    
            
	<div id="primary" class="content-area">
		<div id="content" class="site-content" role="main">

			<?php /* The loop */ ?>
			<?php while ( have_posts() ) : the_post(); ?>

				<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                	<?php if ( has_post_thumbnail() && ! post_password_required() ) : ?>
					<header class="entry-header">
						<div class="entry-thumbnail tx-slider" data-delay="8000">
						<?php                        
							$large_image_url = wp_get_attachment_image_src( get_post_thumbnail_id(), 'large' );
							echo '<a href="' . $large_image_url[0] . '" title="' . the_title_attribute( 'echo=0' ) . '" class="tx-colorbox">';
							the_post_thumbnail('idesign-single-thumb');
							echo '</a>';
							
                            if (class_exists('MultiPostThumbnails')) 
							{
								$large_image_url1 = wp_get_attachment_image_src( MultiPostThumbnails::get_post_thumbnail_id( get_post_type(), 'feature-image-2', $post->ID ), 'large' );
								if ($large_image_url1)
								{
									echo '<a href="' . $large_image_url1[0] . '" title="' . the_title_attribute('echo=0') . '" class="tx-colorbox">';
									MultiPostThumbnails::the_post_thumbnail( get_post_type(), 'feature-image-2', NULL, 'idesign-single-thumb' );
									echo '</a>';
								}
								
								$large_image_url2 = wp_get_attachment_image_src( MultiPostThumbnails::get_post_thumbnail_id( get_post_type(), 'feature-image-3', $post->ID ), 'large' );
								if ($large_image_url2)
								{
									echo '<a href="' . $large_image_url2[0] . '" title="' . the_title_attribute('echo=0') . '" class="tx-colorbox">';
									MultiPostThumbnails::the_post_thumbnail( get_post_type(), 'feature-image-3', NULL, 'idesign-single-thumb' );
									echo '</a>';
								}
                            } 							
                        ?>
						</div>
						
					</header><!-- .entry-header -->
                    <?php endif; ?>
                    
                    <div class="folio-meta">
                    <?php if (!empty($sub_title)) : ?>
                    <h2 class="tx-subtitle"><?php echo $sub_title; ?></h2>
                    <?php endif; ?>
                    <?php
					if (!empty($folio_url))
					{
					?>
                        <div class="proj-url">
                        <span class="genericon genericon-external"></span>
                        <a href="<?php echo $folio_url ?>"><?php echo $folio_url; ?></a>
                        </div>
                    <?php
					}
					?>                    
                    
                    <?php if ( function_exists( 'tx_folio_term' ) ) : ?>
                    <?php if (tx_folio_term( 'portfolio-category' )) : ?>
                    	<div class="folio-cat">
                        	<span class="genericon genericon-category"></span>
							<span class="folio-categories"><?php echo tx_folio_term( 'portfolio-category' ); ?></span>
                        </div>
                    <?php endif; ?>
                    <?php endif; ?>
                     
					</div>
                    
					<div class="entry-content">
						<?php the_content(); ?>
						<?php wp_link_pages( array( 'before' => '<div class="page-links"><span class="page-links-title">' . __( 'Pages:', 'i-design' ) . '</span>', 'after' => '</div>', 'link_before' => '<span>', 'link_after' => '</span>' ) ); ?>
					</div><!-- .entry-content -->

					<footer class="entry-meta">
						<?php edit_post_link( __( 'Edit', 'i-design' ), '<span class="edit-link">', '</span>' ); ?>
					</footer><!-- .entry-meta -->
				</article><!-- #post -->

				<?php comments_template(); ?>
			<?php endwhile; ?>

		</div><!-- #content -->
        <?php get_sidebar(); ?>
	</div><!-- #primary -->


<?php get_footer();