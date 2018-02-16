<?php
/**
 * The template for displaying all pages
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages and that
 * other 'pages' on your WordPress site will use a different template.
 *
 * @package WpOpal
 * @subpackage Fresh
 * @since Fresh 1.0
 */
/*
*Template Name: 404 Page
*/

get_header( apply_filters( 'fresh_fnc_get_header_layout', null ) ); ?>

<section id="main-container" class="<?php echo apply_filters('fresh_template_main_container_class','container');?> inner clearfix notfound-page">
	<div class="row">
		<div id="main-content" class="main-content">
			<div id="primary" class="content-area">
				 <div id="content" class="site-content text-center" role="main">
                    <div class="row">
                        <div class="col-sm-4 col-xs-12 block-left">
                            <div class="title">
                                <?php esc_html_e( 'Oops!', 'fresh' ); ?>
                            </div>
    						<span class="sub"><?php esc_html_e( 'This Page Could Not Be Found!', 'fresh' ); ?></span>
                            <div class="error-description">
                                <p><?php esc_html_e( 'The page you are looking for might have been removed, had its name changed, or is temporarily unavailable.', 'fresh' ); ?></p>
                            </div><!-- .page-content -->

                            <div class="page-action">
                                <a class="btn theme-color-primary" href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php esc_html_e('Return to homepage', 'fresh'); ?></a>
                                <a class="btn btn-primary" href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php esc_html_e('Go to support', 'fresh'); ?></a>
                            </div>
                        </div>
                        <div class="col-sm-8 col-xs-12 block-right">
                            <div class="image">
                            </div>    						
                        </div>
                    </div>
				</div><!-- #content -->
			</div><!-- #primary -->
			<?php get_sidebar( 'content' ); ?>
		</div><!-- #main-content -->


		<?php get_sidebar(); ?>

	</div>
</section>
<?php

get_footer();

