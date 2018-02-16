<?php
/**
 * Single Product Image
 *
 * @author        WooThemes
 * @package    WooCommerce/Templates
 * @version     3.0.8
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}
$productConfig = apply_filters('wpopal_filter_product_config_zoom', array(
    'product_enablezoom' => 1,
    'product_zoommode' => 'inner',
    'product_zoomeasing' => 1,
    'product_zoomlensshape' => "round",
    'product_zoomlenssize' => "150",
    'product_zoomgallery' => 0,
    'enable_product_customtab' => 0,
    'product_customtab_name' => '',
    'product_customtab_content' => '',
    'product_related_column' => 0,
));

global $post, $woocommerce, $product;

$columns = apply_filters('woocommerce_product_thumbnails_columns', 4);
$post_thumbnail_id = get_post_thumbnail_id($post->ID);
$full_size_image = wp_get_attachment_image_src($post_thumbnail_id, 'full');
$image_title = get_post_field('post_excerpt', $post_thumbnail_id);
$placeholder = has_post_thumbnail() ? 'with-images' : 'without-images';
$wrapper_classes = apply_filters('woocommerce_single_product_image_gallery_classes', array(
    'woocommerce-product-gallery',
    'woocommerce-product-gallery--' . $placeholder,
    'woocommerce-product-gallery--columns-' . absint($columns),
    'images',
));
?>
<div class="images row <?php echo esc_attr(implode(' ', array_map('sanitize_html_class', $wrapper_classes))); ?>"
     data-columns="<?php echo esc_attr($columns); ?>" style="opacity: 0; transition: opacity .25s ease-in-out;">
    <div class="col-lg-9 col-md-9 woocommerce-product-gallery__wrapper">
        <?php
        if (has_post_thumbnail()) {
            $attributes = array(
                'title' => $image_title,
                'data-src' => $full_size_image[0],
                'data-large_image' => $full_size_image[0],
                'data-large_image_width' => $full_size_image[1],
                'data-large_image_height' => $full_size_image[2],
            );

            $image_title = esc_attr(get_the_title(get_post_thumbnail_id()));
            $image_caption = get_post(get_post_thumbnail_id())->post_excerpt;
            $image_link = wp_get_attachment_url(get_post_thumbnail_id());

            list($popupsrc, $popup_width, $popup_height) = wp_get_attachment_image_src(get_post_thumbnail_id(), "shop_magnifier");

            $image = get_the_post_thumbnail($post->ID, apply_filters('single_product_large_thumbnail_size', 'shop_single'), array(
                'title' => $image_title,
                'alt' => $image_title,
                'data-zoom-image' => $image_link,
                'id' => 'image'
            ));

            $attachment_count = count($product->get_gallery_image_ids());

            if ($attachment_count > 0) {
                $gallery = '[product-gallery]';
            } else {
                $gallery = '';
            }
            echo '<div data-thumb="' . get_the_post_thumbnail_url($post->ID, 'shop_thumbnail') . '" class="woocommerce-product-gallery__image"><a href="' . esc_url($full_size_image[0]) . '">';
            echo apply_filters('woocommerce_single_product_image_html', sprintf('<div class="woocommerce-main-image ">%s</div>', $image), $post->ID);
            echo '</a></div>';
        } else {
            echo apply_filters('woocommerce_single_product_image_html', sprintf('<img src="%s" alt="%s" />', wc_placeholder_img_src(), __('Placeholder', 'wpopal-themer')), $post->ID);
        }
        ?>
    </div>
    <div class="col-lg-3 col-md-3">
        <?php do_action('woocommerce_product_thumbnails'); ?>
    </div>

</div>
<?php
wc_enqueue_js("
    (function ($, window, document) {

        var zoomImage = $('#image');
        var zoomConfig = {
            zoomType: '". $productConfig['product_zoommode'] ."',
            lensShape: '". $productConfig['product_zoomlensshape'] ."',
            lensSize: '". (int)$productConfig['product_zoomlenssize'] ."',
            easing: true,
            cursor: 'pointer',
            galleryActiveClass: 'active',
            zoomWindowPosition: 11
        };
        zoomImage.elevateZoom(zoomConfig);
        var setImage = function (image) {
            // Update source for images
            zoomImage.attr('src', $(this).data('image'));
            zoomImage.data('zoom-image', image);
            // Reinitialize EZ
            zoomImage.elevateZoom(zoomConfig);
        }


        $('.image-additional').on('click', 'a', function (event) {
            event.preventDefault();
            var image = $(this).data('image');
            var srcset = $(this).find('>img').attr('srcset');
            if (image) {
                $('.woocommerce-main-image img').attr('src', image);
                setImage(image);
            }
            if(srcset){
                $('.woocommerce-main-image img').attr('srcset', srcset);
            }
        });


        $('.single-product-summary').on('change', '.variations select', function (event) {
            setTimeout(function () {
                var form = $(event.currentTarget).closest('form');
                var dataVariables = form.data('product_variations');
                var imageId = form.attr('current-image');
                $('.zoomContainer').remove();
                zoomImage.removeData('elevateZoom');
                var image = '';
                $.each(dataVariables, function (key, value) {
                    if (imageId == value.image_id) {
                        image = value.image.full_src;
                    }
                });
                if (image) {
                    setImage(image);
                }

            }, 100);
        })

    })(jQuery);
");