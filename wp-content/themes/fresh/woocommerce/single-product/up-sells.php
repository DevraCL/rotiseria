<?php
/**
 * Cross-sells
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/cart/cross-sells.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see         https://docs.woocommerce.com/document/template-structure/
 * @author         WooThemes
 * @package     WooCommerce/Templates
 * @version 3.1.0
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

$_id = rand();
$columns_count = 3;

if ( $upsells ) : ?>
			<div class="widget products-upsells">

					<h3 class="widget-title">
				        <span><?php esc_html_e( 'You may also like&hellip;', 'fresh' ); ?></span>
					</h3>
					<div class="woocommerce owl-carousel-play"  id="postcarousel-<?php echo esc_attr($_id); ?>" data-ride="carousel">
						<div class="widget-content <?php echo isset($style) ? esc_attr( $style ): ''; ?>">
                    <?php   if( count($upsells) > $columns_count ) { ?>
							<div class="carousel-controls">
								<a href="#postcarousel-<?php echo esc_attr($_id); ?>" data-slide="prev" class="left carousel-control">
									<i aria-hidden="true" class="fa fa-arrow-circle-o-left"></i>
								</a>
								<a href="#postcarousel-<?php echo esc_attr($_id); ?>" data-slide="next" class="right carousel-control">
									<i class="fa fa-arrow-circle-o-right" aria-hidden="true"></i>
								</a>
							</div>
							<?php } ?>

						    <div class="owl-carousel" data-slide="<?php echo esc_attr($columns_count); ?>"  data-singleItem="true" data-navigation="false" data-pagination="false">						    	
                        <?php foreach ( $upsells as $upsells ) : ?>
                            <?php
                                 $post_object = get_post( $upsells->get_id() );

                                setup_postdata( $GLOBALS['post'] =& $post_object );
                            ?>
                                <div class="product-carousel-item">    <?php wc_get_template_part( 'content', 'product-inner' ); ?></div>
                        <?php endforeach; ?>
							</div>

						</div>
					</div>

			</div>
  
		<?php endif;

	wp_reset_postdata();
