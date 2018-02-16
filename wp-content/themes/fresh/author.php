<?php
/**
 * The template for displaying Category pages
 *
 * @link http://www.wpopal.com/theme/fresh/
 *
 * @package WpOpal
 * @subpackage Fresh
 * @since Fresh 1.0
 */

$fresh_page_layouts = apply_filters( 'fresh_fnc_get_archive_sidebar_configs', null );
get_header( apply_filters( 'fresh_fnc_get_header_layout', null ) ); ?>
<?php do_action( 'fresh_template_main_before' ); ?>
<section id="main-container" class="<?php echo apply_filters('fresh_template_main_container_class','container');?> inner <?php echo fresh_fnc_theme_options('blog-archive-layout') ; ?>">
	<div class="row">


		<?php if( isset($fresh_page_layouts['sidebars']) && !empty($fresh_page_layouts['sidebars']) ) : ?>
			<?php get_sidebar(); ?>
		<?php endif; ?>
		<div id="main-content" class="main-content col-xs-12 <?php echo esc_attr($fresh_page_layouts['main']['class']); ?>">
			<div id="primary" class="content-area">
				<div id="content" class="site-content" role="main">

					<?php if ( have_posts() ) : ?>

					<header class="archive-header">
						<h1 class="archive-title">
							<?php
								/*
								 * Queue the first post, that way we know what author
								 * we're dealing with (if that is the case).
								 *
								 * We reset this later so we can run the loop properly
								 * with a call to rewind_posts().
								 */
								the_post();

								printf( esc_html__( 'All posts by %s', 'fresh' ), get_the_author() );
							?>
						</h1>
						<?php if ( get_the_author_meta( 'description' ) ) : ?>
						<div class="author-description"><p><?php the_author_meta( 'description' ); ?></p></div>
						<hr>
						<?php endif; ?>

					</header><!-- .archive-header -->

					<?php
							/*
							 * Since we called the_post() above, we need to rewind
							 * the loop back to the beginning that way we can run
							 * the loop properly, in full.
							 */
							rewind_posts();

							// Start the Loop.
							while ( have_posts() ) : the_post();

								/*
								 * Include the post format-specific template for the content. If you want to
								 * use this in a child theme, then include a file called called content-___.php
								 * (where ___ is the post format) and that will be used instead.
								 */
								get_template_part( 'content', get_post_format() );

							endwhile;
							// Previous/next page navigation.
							fresh_fnc_paging_nav();

						else :
							// If no content, include the "No posts found" template.
							get_template_part( 'content', 'none' );

						endif;
					?>

				</div><!-- #content
			</div><!-- #primary -->
			<?php get_sidebar( 'content' ); ?>
		</div><!-- #main-content -->



	</div>
</section>
<?php
get_footer();