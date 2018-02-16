<?php
/**
 * Single Product Thumbnails
 *
 * @author      WooThemes
 * @package     WooCommerce/Templates
 * @version     2.3.0
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}
$id = rand();
global $post, $product, $woocommerce;
$images = $product->get_gallery_image_ids ();
$attachment_ids =  array_merge( $images, array( get_post_thumbnail_id() ) ) ;

if ( $attachment_ids ) {
    $loop       = 0;
    $columns    = wpopal_themer_fnc_theme_options( 'woo-number-thumbnail-single', 3 );

    $classlayout = "";
    $layouts  = isset($_GET['layout']) ? $_GET['layout'] : wpopal_themer_fnc_theme_options('woocommerce-single-content-layout','1');

    $bottoms = array('1','2','5');
    if ( in_array( $layouts, $bottoms ) ) {
       $classlayout = 'thumbnail-bottom';
    } elseif ($layouts == '3') {
        $classlayout= 'thumbnail-left';
    } else {
        $classlayout = 'thumbnail-right';
    }
    ?>
    <div id="image-additional-carousel" class="<?php echo esc_attr($classlayout); ?>" >
         <div class="image-additional olw-carousel owl-carousel-play" id="image-additional" data-ride="owlcarousel">
             <div id="image-additional-carousel" class="owl-carousel" data-slide="<?php echo $columns; ?>" data-pagination="false" data-navigation="true" data-tablet="3"  data-mobile="3">

        <?php

            foreach ( $attachment_ids as $attachment_id ) {

                $classes = array( 'imagezoom' );

                if ( $loop == 0 || $loop % $columns == 0 )
                    $classes[] = 'first';

                if ( ( $loop + 1 ) % $columns == 0 )
                    $classes[] = 'last';

                $image_link = wp_get_attachment_url( $attachment_id );

                if ( ! $image_link )
                    continue;

                $image_title    = esc_attr( get_the_title( $attachment_id ) );
                $image_caption  = esc_attr( get_post_field( 'post_excerpt', $attachment_id ) );

                $image = wp_get_attachment_image( $attachment_id, apply_filters( 'single_product_small_thumbnail_size', 'shop_thumbnail' ), 0, $attr = array(
                        'title' => $image_title,
                        'alt'   => $image_title,
                        'data-zoom-image'=> $image_link
                    ) );

                $image_class = esc_attr( implode( ' ', $classes ) );

                echo apply_filters( 'woocommerce_single_product_image_thumbnail_html', sprintf( '<a href="%s"   data-image="%s" class="%s" title="%s">%s</a>', $image_link, $image_link, $image_class, $image_caption, $image ), $attachment_id, $post->ID, $image_class );

                $loop++;
            }

        ?>
</div>
    <?php if(count($attachment_ids)>$columns) { ?>
    <!-- <div class="carousel-controls"> -->
        <div class="carousel-controls carousel-controls-v3">
            <a class="left carousel-control" href="#carousel-<?php echo $id; ?>" data-slide="prev">
                    <i class="fa fa-angle-left"></i>
            </a>
            <a class="right carousel-control" href="#carousel-<?php echo $id; ?>" data-slide="next">
                    <i class="fa fa-angle-right"></i>
            </a>
        </div>
    <!-- </div> -->
    <?php } ?>

</div>

</div>
    <?php
}
