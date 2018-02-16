<?php
/**
 * The template for displaying Category pages
 *
 * @link http://www.wpopal.com/theme/ecopark/
 *
 * @package WpOpal
 * @subpackage Crewteam
 * @since Crewteam 1.0
 */

get_header();
$column = get_option('column_team') ? get_option('column_team') : 4;
$colclass = floor(12/$column); 
$showmode = get_option('team_view') ? get_option('team_view') : "grid"; 
?>
<section id="main-container" class="container">
	<div class="row">
		<div id="main-content" class="main-content  col-md-12">
			<div id="primary" class="content-area">
			 	<div id="content" class="site-content" role="main">
			 				<?php if ( have_posts() ) : ?>

								<div class="team-archive">
									<div class="row">
									<?php $cnt=0; while ( have_posts() ) : the_post();
											$cls = '';

											if( $cnt++%$column==0 ){
												$cls .= ' first-child';
											}
											if ($showmode == "grid") : ?>
											<div class="col-lg-<?php echo esc_attr($colclass); ?> col-md-<?php echo esc_attr($colclass); ?> col-sm-<?php echo esc_attr($colclass); ?> <?php echo esc_attr($cls); ?>">
												<?php  wpopal_themer_get_template_part( 'content-team-grid' ); ?>
											</div>
											<?php else: ?>
												<div class="col-md-12">
											   <?php  wpopal_themer_get_template_part( 'content-team-list' ); ?>
											   </div>
											<?php endif; ?>
										<?php endwhile; ?>
									</div>
								</div>
								<?php the_posts_pagination( array(
									'prev_text'          => esc_html__( 'Previous page', 'wpopal-themer' ),
									'next_text'          => esc_html__( 'Next page', 'wpopal-themer' ),
									'before_page_number' => '<span class="meta-nav screen-reader-text">' . esc_html__( 'Page', 'wpopal-themer' ) . ' </span>',
								) ); ?>
							<?php else : ?>
								<?php get_template_part( 'content', 'none' ); ?>
							<?php endif; ?>

					 
				</div><!-- #content -->
			</div><!-- #primary -->
			<?php get_sidebar( 'content' ); ?>

		</div><!-- #main-content -->
		<?php get_sidebar( 'right' ); ?>
	</div>	
</section>
<?php
get_footer();
 
 