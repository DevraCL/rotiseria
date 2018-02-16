<?php global $product; ?>

<?php
	$class=$attrs='';
	if(isset($animate) && $animate){
		$class= 'wow fadeInUp';
		//$attrs = 'data-wow-duration="0.6s" data-wow-delay="'.$delay.'ms"';
	}
?>
<div class="product-block-list no-space-row">
	<div class="product-block">
		<div class="row widget-product <?php echo esc_attr($class); ?> <?php echo (isset($item_order) && ($item_order%2)) ?'first':'last'; ?>" <?php echo trim($attrs); ?>>
			<div class="col-md-5 col-sm-5 col-xs-5">
				<!--span class="onsale">
                    <?php
                    $percentage = round( ( ( $product->get_regular_price() - $product->get_sale_price() ) / $product->get_regular_price() ) * 100 );
                        echo '-' . trim( $percentage ) . '%';
                     ?>
                </span-->
				<?php if((isset($item_order) && $item_order==1) || !isset($item_order)) : ?>
					<a href="<?php echo esc_url( get_permalink( $product->get_id() ) ); ?>" title="<?php echo esc_attr( $product->get_name() ); ?>" class="image">
						<?php echo trim( $product->get_image('full') ); ?>
						<?php if(isset($item_order) && $item_order==1) { ?> 
							<span class="first-order"><?php echo trim($item_order); ?></span>
						<?php } ?>
					</a>
				<?php endif; ?>
				<?php if(isset($item_order) && $item_order > 1){ ?>
					<div class="order"><span><?php echo trim($item_order); ?></span></div>
				<?php }?>
			</div>
			<div class="col-md-7 col-sm-7 col-xs-7">
				<div class="meta text-left">	
					<h3 class="name">
						<a href="<?php echo esc_url( get_permalink( $product->get_id() ) ); ?>"><?php echo trim( $product->get_name() ); ?></a>
					</h3>		
					<?php do_action( 'fresh_woocommerce_before_shop_loop_item_title'); ?>			
				</div>
			</div>
			<div class="groups">
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
		</div>
	</div>
</div>


