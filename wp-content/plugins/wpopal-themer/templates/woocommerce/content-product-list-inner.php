<?php 
global $product;
$image_attributes = wp_get_attachment_image_src( get_post_thumbnail_id($product->get_id() ), 'blog-thumbnails' );

?>
<div class="product-block" data-product-id="<?php echo esc_attr($product->get_id()); ?>">
	<div class="row">
		<div class="col-lg-6 col-md-6">
		    <figure class="image">
		        
		        <a title="<?php the_title(); ?>" href="<?php echo (get_option( 'woocommerce_enable_lightbox' )=='yes' && is_product()) ? $image_attributes[0] : the_permalink(); ?>" class="product-image <?php echo (get_option( 'woocommerce_enable_lightbox' )=='yes' &&  is_product())?'zoom':'zoom-2' ;?>">
		            <?php
		                /**
		                * woocommerce_before_shop_loop_item_title hook
		                *
		                * @hooked woocommerce_show_product_loop_sale_flash - 10
		                * @hooked woocommerce_template_loop_product_thumbnail - 10
		                */
		                remove_action('woocommerce_before_shop_loop_item_title','woocommerce_show_product_loop_sale_flash', 10);
		                do_action( 'woocommerce_before_shop_loop_item_title' );
		            ?>
		        </a>		        
		    </figure>
		</div>    
	    <div class="col-lg-6 col-md-6">
		    <div class="caption-list">
		        
		        <div class="meta">
		        <?php do_action( 'emarket_woocommerce_before_shop_loop_item_title'); ?>
		        <h3 class="name"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
		        	<?php do_action( 'woocommerce_after_shop_loop_item' ); ?>
		            <?php
		                /**
		                * woocommerce_after_shop_loop_item_title hook
		                *
		                * @hooked woocommerce_template_loop_rating - 5
		                * @hooked woocommerce_template_loop_price - 10
		                */
		                do_action( 'woocommerce_after_shop_loop_item_title');

		            ?>
		            <?php the_excerpt();  ?>
		        </div>

		        <div class="button-action button-groups clearfix">
		        <?php woocommerce_show_product_loop_sale_flash(); ?>                
		            
		            <?php
		                $action_add = 'yith-woocompare-add-product';
		                $url_args = array(
		                    'action' => $action_add,
		                    'id' => $product->get_id()
		                );
		            ?>
		            <?php
		                if( class_exists( 'YITH_WCWL' ) ) {
		                    echo do_shortcode( '[yith_wcwl_add_to_wishlist]' );
		                }
		            ?>   
		    
		             <?php if( class_exists( 'YITH_Woocompare' ) ) { ?>
	                <?php
	                    $action_add = 'yith-woocompare-add-product';
	                    $url_args = array(
	                        'action' => $action_add,
	                        'id' => $product->get_id()
	                    );
	                ?>
	                <div class="yith-compare">
	                    <a href="<?php echo wp_nonce_url( add_query_arg( $url_args ), $action_add ); ?>" class="compare" data-product_id="<?php echo esc_attr($product->get_id()); ?>">
	                        <em class="fa fa-exchange"></em>
	                        <span><?php esc_html_e( 'Compare', 'wpopal-themer' ); ?></span>
	                    </a>
	                </div>
	            <?php } ?>
		       
		        </div>
		    </div>
		</div>    
	</div>	    
</div>
