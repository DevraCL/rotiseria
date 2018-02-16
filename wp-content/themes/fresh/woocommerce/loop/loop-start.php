<?php
/**
 * Product Loop Start
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     2.0.0
 */
?>
<div class="products products-<?php if ( isset($_COOKIE['fresh_woo_display']) && $_COOKIE['fresh_woo_display'] == 'list' ) { ?>list<?php }else{ ?>grid<?php } ?>"><div class="row row-products">