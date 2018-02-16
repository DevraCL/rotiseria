<?php
/* ---------------------------------------------------------------------------
 * WooCommerce - Function get Query
 * --------------------------------------------------------------------------- */

function fresh_fnc_get_review_counting(){

    global $post;
    $output = array();

    for($i=1; $i <= 5; $i++){
         $args = array(
            'post_id'      => ( $post->ID ),
            'meta_query' => array(
              array(
                'key'   => 'rating',
                'value' => $i
              )
            ),
            'count' => true
        );
        $output[$i] = get_comments( $args );
    }
    return $output;
}


/* ---------------------------------------------------------------------------
 * WooCommerce - Function get Query
 * --------------------------------------------------------------------------- */



function fresh_fnc_woocommerce_before_shop_loop_item_title(){

    global $product;

    if( $product->get_regular_price() ){
        $percentage = round( ( ( $product->get_regular_price() - $product->get_sale_price() ) / $product->get_regular_price() ) * 100 );
        echo '<span class="product-sale-label">-' . trim( $percentage ) . '%</span>';
    }

}


if ( ! function_exists( 'fresh_fnc_woocommerce_content' ) ) {

    /**
     * Output WooCommerce content.
     *
     * This function is only used in the optional 'woocommerce.php' template
     * which people can add to their themes to add basic woocommerce support
     * without hooks or modifying core templates.
     *
     */
    function fresh_fnc_woocommerce_content() {

        if ( is_singular( 'product' ) ) {


            while ( have_posts() ) : the_post();

                wc_get_template_part( 'content', 'single-product' );

            endwhile; 

        } elseif( is_search() && strlen( trim(get_search_query()) ) == 0 ){    ?>
            <p><?php esc_html_e( 'Sorry, but nothing matched your search terms. Please try again with some different keywords.', 'fresh' ); ?></p>
                <?php fresh_fnc_categories_searchform() ?>    
        <?php
        }else { ?>

            <?php if ( apply_filters( 'woocommerce_show_page_title', true ) ) : ?>

                <h1 class="page-title"><?php woocommerce_page_title(); ?></h1>

            <?php endif; ?>

            <?php do_action( 'woocommerce_archive_description' ); ?>

            <?php if ( have_posts() ) : ?>

                <?php do_action('woocommerce_before_shop_loop'); ?>

                <div class="childrens">
                    <?php woocommerce_product_subcategories(); ?>
                </div>

                <?php woocommerce_product_loop_start(); ?>


                    <?php while ( have_posts() ) : the_post(); ?>

                        <?php wc_get_template_part( 'content', 'product' ); ?>

                    <?php endwhile; // end of the loop. ?>

                <?php woocommerce_product_loop_end(); ?>

                <?php do_action('woocommerce_after_shop_loop'); ?>

        <?php elseif ( ! woocommerce_product_subcategories( array( 'before' => woocommerce_product_loop_start( false ), 'after' => woocommerce_product_loop_end( false ) ) ) ) : ?>

            <?php wc_get_template( 'loop/no-products-found.php' ); ?>

        <?php endif;

        }
    }
}
