<?php
/**
 * The template for displaying the footer
 *
 * Contains footer content and the closing of the #main and #page div elements.
 *
 * @package WpOpal
 * @subpackage Liftsupply
 * @since Liftsupply 1.0
 */

?>
		</section><!-- #main -->
		<?php do_action( 'fresh_template_main_after' ); ?>
		<?php do_action( 'fresh_template_footer_before' ); ?>
		<footer id="opal-footer" class="opal-footer">
			<div class="container">
			<div class="inner">
				 <?php fresh_display_footer_content(); ?>


				<?php get_sidebar( 'mass-footer-body' );  ?>

			</div>
			</div>
			
		</footer><!-- #colophon -->
		<div class="opal-copyright clearfix">
			<div class="container"><div class="inner">
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
						<a href="#" class="scrollup"><span class="fa fa-angle-up"></span></a>
                    </div>
                    <div class="col-md-6 col-sm-8 col-xs-12 text-left">
                    	<div class="pull-left">
                        <?php do_action( 'fresh_fnc_credits' ); ?>
				 
						</div>
						<div class="pull-left">
						<?php if ( is_active_sidebar( 'custom-link' ) ) : ?>
	                        <?php dynamic_sidebar('custom-link'); ?>
	                    <?php endif; ?>
	                    </div>
                    </div>
                    <!--div class="col-md-6 col-sm-4 col-xs-12 text-right">
                    	<?php $img_link = fresh_fnc_theme_options('image-payment', ''); ?>
                    	<?php if(!empty( $img_link)): ?>
                        	<img src="<?php echo esc_url_raw($img_link); ?>" alt ="<?php esc_html_e('Payment logo', 'fresh');?>">
                    	<?php endif; ?>
                    </div-->
                </div>
			</div></div>
		</div>

		<?php do_action( 'fresh_template_footer_after' ); ?>
		<?php get_sidebar( 'offcanvas' );  ?>
	</div>
</div>
	<!-- #page -->

<?php wp_footer(); ?>
</body>
</html>
