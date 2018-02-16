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

$fresh_page_layouts = apply_filters( 'fresh_fnc_get_woocommerce_sidebar_configs', null );

get_header( apply_filters( 'fresh_fnc_get_header_layout', null ) );

?>
<?php do_action( 'fresh_woo_template_main_before' ); ?>

<div id="main-container">
	<div class="<?php echo apply_filters('fresh_template_woocommerce_main_container_class','container');?>">
		<div class="row">

			<?php if( isset($fresh_page_layouts['sidebars']) && !empty($fresh_page_layouts['sidebars']) ) : ?>
				<?php get_sidebar(); ?>
			<?php endif; ?>

			<div id="main-content" class="main-content col-xs-12 <?php echo esc_attr($fresh_page_layouts['main']['class']); ?>">
				<div id="primary" class="content-area">
					<div id="content" class="site-content" role="main">

						 <?php fresh_fnc_woocommerce_content(); ?>

					</div><!-- #content -->
				</div><!-- #primary -->


				<?php    get_sidebar( 'content' ); ?>
			</div><!-- #main-content -->

		</div>
	</div>
	<?php if(is_singular( 'product' )): ?>
	    <div class="content-after-product">
	    <?php
	        add_action( 'fresh_fnc_woocommerce_after_single_product', 'woocommerce_output_related_products', 10 );
	        add_action( 'fresh_fnc_woocommerce_after_single_product', 'woocommerce_upsell_display', 20 ); 
	        do_action( 'fresh_fnc_woocommerce_after_single_product' ); 
	    ?>
	    </div>
	    <div class="<?php echo apply_filters('fresh_template_woocommerce_main_container_class','container');?>">
		    <div class="product-single-image">
		    	<?php if ( is_active_sidebar( 'image-product' ) ): ?>
		    		<?php dynamic_sidebar( 'image-product' ); ?>
		    	<?php endif; ?>
		    </div>   
	    </div>
	<?php endif; ?>
</div>
<?php

get_footer();
