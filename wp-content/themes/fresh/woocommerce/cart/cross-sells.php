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
$columns_count = 2;

if ( $cross_sells ) : ?>

    <div class="cross-sells">

        <h2><?php esc_html_e( 'You may be interested in&hellip;', 'fresh' ) ?></h2>

        <?php woocommerce_product_loop_start(); ?>

        <div class="widget products-collection owl-carousel-play woocommerce" id="postcarousel-<?php echo esc_attr($_id); ?>" data-ride="carousel">
            <div class="woocommerce">
                <div class="widget-content">
                    <?php   if( count($cross_sells) > $columns_count ) { ?>
                    <div class="carousel-controls carousel-controls-v1 carousel-hidden">
                        <a href="#postcarousel-<?php echo esc_attr($_id); ?>" data-slide="prev" class="left carousel-control">
                            <span class="fa fa-angle-left"></span>
                        </a>
                        <a href="#postcarousel-<?php echo esc_attr($_id); ?>" data-slide="next" class="right carousel-control">
                            <span class="fa fa-angle-right"></span>
                        </a>
                    </div>
                    <?php } ?>

                    <div class="owl-carousel " data-slide="<?php echo esc_attr($columns_count); ?>"  data-singleItem="true" data-navigation="false" data-pagination="false">
                        <?php foreach ( $cross_sells as $cross_sell ) : ?>
                            <?php
                                 $post_object = get_post( $cross_sell->get_id() );

                                setup_postdata( $GLOBALS['post'] =& $post_object );
                            ?>
                                <div class="product-carousel-item">    <?php wc_get_template_part( 'content', 'product-inner' ); ?></div>
                        <?php endforeach; ?>
                    </div>

                </div>
            </div>

    </div>
    <?php woocommerce_product_loop_end(); ?>
</div>
<?php endif;
wp_reset_postdata();