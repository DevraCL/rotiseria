<?php global $product; ?>

<?php
	$class=$attrs='';
	if(isset($animate) && $animate){
		$class= 'wow fadeInUp';
		//$attrs = 'data-wow-duration="0.6s" data-wow-delay="'.$delay.'ms"';
	}
?>

<li class="media product-block widget-product <?php echo esc_attr($class); ?> <?php echo (isset($item_order) && ($item_order%2)) ?'first':'last'; ?>" <?php echo trim($attrs); ?>>
	<?php if((isset($item_order) && $item_order==1) || !isset($item_order)) : ?>
		<a href="<?php echo esc_url( get_permalink( $product->get_id() ) ); ?>" title="<?php echo esc_attr( $product->get_name() ); ?>" class="image pull-left">
			<?php echo trim( $product->get_image() ); ?>
			<?php if(isset($item_order) && $item_order==1) { ?> 
				<span class="first-order"><?php echo trim($item_order); ?></span>
			<?php } ?>
		</a>
	<?php endif; ?>
	<?php if(isset($item_order) && $item_order > 1){ ?>
		<div class="order"><span><?php echo trim($item_order); ?></span></div>
	<?php }?>
	<div class="media-body meta">
		<h3 class="name">
			<a href="<?php echo esc_url( get_permalink( $product->get_id() ) ); ?>"><?php echo trim( $product->get_name() ); ?></a>
		</h3>
		<?php if ( ! empty( $show_rating ) ){ ?>
			<div class="rating clearfix">
	            <?php if ( ! empty( $show_rating ) ){
	            	if($rating_html = wc_get_rating_html( $product->get_average_rating() )){
	            		echo trim( wc_get_rating_html( $product->get_average_rating() ) );

	            	}else{
	            		echo '<div class="star-rating"></div>';
	            	}
	            } ?>
	        </div>
		<?php }?>
		<?php do_action( 'fresh_woocommerce_before_shop_loop_item_title'); ?>
            <div class="bottom">
                <?php do_action( 'woocommerce_after_shop_loop_item' ); ?>
                <div class="price-all">
                <?php 
                    /**
                    * woocommerce_after_shop_loop_item_title hook
                    *
                    * @hooked woocommerce_template_loop_rating - 5
                    * @hooked woocommerce_template_loop_price - 10
                    */
                    do_action( 'woocommerce_after_shop_loop_item_title');

                ?>
                </div>
                
            </div>
	</div>
</li>


