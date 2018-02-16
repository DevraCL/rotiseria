<?php
/**
 * Related Products
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/related.php.
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

if( !(fresh_fnc_theme_options('wc_show_related', false)) ){
    if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

        $posts_per_page = fresh_fnc_theme_options('woo-number-product-single',6);

        $columns_count = fresh_fnc_theme_options('product-number-columns',3);
        $class_column = 'col-md-' . floor( 12/$columns_count );
        $style= '';
        if(fresh_fnc_theme_options('wc_show_background_related')){
            $style = 'style="background-image: url('.esc_url_raw( fresh_fnc_theme_options('wc_show_background_related') ).');"';
        }
        $_id = rand();
        if ( $related_products ) : ?>
            <div class="widget product-related  woocommerce">
                <h3 class="widget-title">
                    <?php esc_html_e( 'Related Products', 'fresh' ); ?>
                </h3>
                <?php woocommerce_product_loop_start(); ?>
                    <div class="owl-carousel-play woocommerce" id="postcarousel-<?php echo esc_attr($_id); ?>" data-ride="carousel">
						<div class="widget-content <?php echo isset($style) ? esc_attr( $style ): ''; ?>">
                            <?php   if( count($related_products) > $columns_count ) { ?>
                            <div class="carousel-controls">
                                <a href="#postcarousel-<?php echo esc_attr($_id); ?>" data-slide="prev" class="left carousel-control">
                                    <i aria-hidden="true" class="fa fa-arrow-circle-o-left"></i>
                                </a>
                                <a href="#postcarousel-<?php echo esc_attr($_id); ?>" data-slide="next" class="right carousel-control">
                                    <i class="fa fa-arrow-circle-o-right" aria-hidden="true"></i>
                                </a>
                            </div>
                            <?php } ?>

                            <div class="owl-carousel " data-slide="<?php echo esc_attr($columns_count); ?>"  data-singleItem="true" data-navigation="false" data-pagination="false">
                                <?php foreach ( $related_products as $related_product ) : ?>
                                        <?php
                                             $post_object = get_post( $related_product->get_id() );

                                            setup_postdata( $GLOBALS['post'] =& $post_object );

                                        ?>
                                        <div class="product-carousel-item">
                                            <?php wc_get_template_part( 'content', 'product-inner' ); ?>
                                        </div>
                                <?php endforeach; ?>
                            </div>

                        </div>
                    </div>
                <?php woocommerce_product_loop_end(); ?>
            </div>

        <?php endif;

        wp_reset_postdata();
    }