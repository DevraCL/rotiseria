<?php   global $woocommerce; ?>
<div class="opal-topcart">
    <div id="cart" class="dropdown">
        <a class="dropdown-toggle mini-cart btn btn-primary" data-toggle="dropdown" aria-expanded="true" role="button" aria-haspopup="true" data-delay="0" href="#" title="<?php esc_html_e('View your shopping cart', 'fresh'); ?>">
            <i class="icon fa-fw fa fa-shopping-basket"></i>            
        	<?php echo sprintf(_n(' <span class="mini-cart-items"> %d item</span> ', ' <span class="mini-cart-items"> %d item </span> ', $woocommerce->cart->cart_contents_count, 'fresh'), $woocommerce->cart->cart_contents_count);?> 
            <?php echo trim( $woocommerce->cart->get_cart_total() ); ?>
            <i class="icon fa-fw fa fa-caret-down"></i>
        </a>
        <div class="dropdown-menu"><div class="widget_shopping_cart_content">
            <?php woocommerce_mini_cart(); ?>
        </div></div>
    </div>
</div>
