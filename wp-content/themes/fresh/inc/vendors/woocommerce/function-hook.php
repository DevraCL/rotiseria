<?php

/**
 * Load woocommerce styles follow theme skin actived
 *
 * @static
 * @access public
 * @since Wpopal_Themer 1.0
 */
function fresh_fnc_woocommerce_load_media() {

    if(isset($_GET['opal-skin']) && $_GET['opal-skin']) {
		$current = $_GET['opal-skin'];
	}else{
		$current = str_replace( '.css','', fresh_fnc_theme_options('skin','default') );
	}

    if($current == 'default'){
        $path =  get_template_directory_uri() .'/css/woocommerce.css';
    }else{
        $path =  get_template_directory_uri() .'/css/skins/'.$current.'/woocommerce.css';
    }
    wp_enqueue_style( 'fresh-woocommerce', $path , 'fresh-woocommerce-front' , FRESH_THEME_VERSION, 'all' );
}
add_action( 'wp_enqueue_scripts','fresh_fnc_woocommerce_load_media', 15 );

/**
 * Auto config product images after the theme actived.
 */
function fresh_fnc_woocommerce_setup(){
	$catalog = array(
		'width' 	=> '465',	// px
		'height'	=> '528',	// px
		'crop'		=> 1 		// true
	);

	$single = array(
		'width' 	=> '550',	// px
		'height'	=> '625',	// px
		'crop'		=> 1 		// true
	);

	$thumbnail = array(
		'width' 	=> '90',	// px
		'height'	=> '102',	// px
		'crop'		=> 1 		// true
	);

	// Image sizes
	update_option( 'shop_catalog_image_size', $catalog );		// Product category thumbs
	update_option( 'shop_single_image_size', $single ); 		// Single product image
	update_option( 'shop_thumbnail_image_size', $thumbnail ); 	// Image gallery thumbs
}

add_action( 'fresh_setup_theme_actived', 'fresh_fnc_woocommerce_setup');

/**
 */
add_filter('woocommerce_add_to_cart_fragments',	'fresh_fnc_woocommerce_header_add_to_cart_fragment' );

function fresh_fnc_woocommerce_header_add_to_cart_fragment( $fragments ){
	global $woocommerce;

	$fragments['#cart .mini-cart-items'] =  sprintf(_n(' <span class="mini-cart-items"> %d item</span> ', ' <span class="mini-cart-items"> %d item </span> ', $woocommerce->cart->cart_contents_count, 'fresh'), $woocommerce->cart->cart_contents_count);
	$fragments['.mini-cart .amount'] = '<span class="mini-cart-total">'.trim( $woocommerce->cart->get_cart_total() ).'</span>';
  

    return $fragments;
}
add_filter( 'yith_wcwl_button_label',          'fresh_fnc_wpo_woocomerce_icon_wishlist'  );
add_filter( 'yith-wcwl-browse-wishlist-label', 'fresh_fnc_wpo_woocomerce_icon_wishlist_add' );

function fresh_fnc_wpo_woocomerce_icon_wishlist( $value='' ){
	return '<i class="fa fa-star"></i><span>'.esc_html__('Wishlist', 'fresh').'</span>';
}

function fresh_fnc_wpo_woocomerce_icon_wishlist_add(){
	return '<i class="fa fa-star"></i><span>'.esc_html__('Wishlist', 'fresh').'</span>';
}
/**
 * Mini Basket
 */
if(!function_exists('fresh_fnc_minibasket')){
    function fresh_fnc_minibasket( $style='' ){
        $template =  apply_filters( 'fresh_fnc_minibasket_template', fresh_fnc_get_header_layout( '' )  );

      //  if( $template == 'v4' ){
        //	$template = 'v3';
     //   }

        return get_template_part( 'woocommerce/cart/mini-cart-button', $template );
    }
}
if(fresh_fnc_theme_options("woo-show-minicart",true)){
	add_action( 'fresh_template_header_right', 'fresh_fnc_minibasket', 30, 0 );
}
/******************************************************
 * 												   	  *
 * Hook functions applying in archive, category page  *
 *												      *
 ******************************************************/
function fresh_template_woocommerce_main_container_class( $class ){
	if( is_product() ){
		$class .= ' '.  fresh_fnc_theme_options('woocommerce-single-layout') ;
	}else if( is_product_category() || is_archive()  ){
		$class .= ' '.  fresh_fnc_theme_options('woocommerce-archive-layout') ;
	}
	return $class;
}

add_filter( 'fresh_template_woocommerce_main_container_class', 'fresh_template_woocommerce_main_container_class' );
function fresh_fnc_get_woocommerce_sidebar_configs( $configs='' ){

	global $post;
	$right = null; $left = null;

	if( is_product() ){

		$left  =  fresh_fnc_theme_options( 'woocommerce-single-left-sidebar' );
		$right =  fresh_fnc_theme_options( 'woocommerce-single-right-sidebar' );

	}else if( is_product_category() || is_archive() ){
		$left  =  fresh_fnc_theme_options( 'woocommerce-archive-left-sidebar' );
		$right =  fresh_fnc_theme_options( 'woocommerce-archive-right-sidebar' );
	}


	return fresh_fnc_get_layout_configs( $left, $right );
}

add_filter( 'fresh_fnc_get_woocommerce_sidebar_configs', 'fresh_fnc_get_woocommerce_sidebar_configs', 1, 1 );


function fresh_woocommerce_breadcrumb_defaults( $args ){
		$style = array();
		if( is_singular('product') ) {
		 	$bgimage = fresh_fnc_theme_options( 'woocommerce-single-breadcrumb' );
		 
			 if( $bgimage  ){
			  $style[] = 'background:url(\''. $bgimage .'\')';
			 }
		 	$estyle = !empty($style)? 'style="'.implode(";", $style).'"':"";
		}
		if ( !isset($estyle) || !$estyle ) {
		 $bgimage = fresh_fnc_theme_options( 'breadcrumb-bg' );
		 $style = array();
		 if( $bgimage  ){
		  $style[] = 'background:url(\''. $bgimage .'\'); background-size: cover';
		 }
		 $estyle = !empty($style)? 'style="'.implode(";", $style).'"':"";
		}
	$args['wrap_before'] = '<div class="opal-breadscrumb" '.$estyle.'><div class="container"><ol class="opal-woocommerce-breadcrumb breadcrumb" ' . ( is_single() ? 'itemprop="breadcrumb"' : '' ) . '>';
	$args['wrap_after'] = '</ol></div></div>';

	return $args;
}

add_filter( 'woocommerce_breadcrumb_defaults', 'fresh_woocommerce_breadcrumb_defaults' );

add_action( 'fresh_woo_template_main_before', 'woocommerce_breadcrumb', 30, 0 );
/**
 * Remove show page results which display on top left of listing products block.
 */
remove_action( 'woocommerce_before_shop_loop', 'woocommerce_result_count', 20 );
add_action( 'woocommerce_after_shop_loop', 'woocommerce_result_count', 10 );


function fresh_fnc_woocommerce_after_shop_loop_start(){
	echo '<div class="products-bottom-wrap clearfix">';
}

add_action( 'woocommerce_after_shop_loop', 'fresh_fnc_woocommerce_after_shop_loop_start', 1 );

function fresh_fnc_woocommerce_after_shop_loop_after(){
	echo '</div>';
}

add_action( 'woocommerce_after_shop_loop', 'fresh_fnc_woocommerce_after_shop_loop_after', 10000 );


/**
 * Wrapping all elements are wrapped inside Div Container which rendered in woocommerce_before_shop_loop hook
 */
function fresh_fnc_woocommerce_before_shop_loop_start(){
	echo '<div class="products-top-wrap clearfix">';
}

function fresh_fnc_woocommerce_before_shop_loop_end(){
	echo '</div>';
}


add_action( 'woocommerce_before_shop_loop', 'fresh_fnc_woocommerce_before_shop_loop_start' , 0 );
add_action( 'woocommerce_before_shop_loop', 'fresh_fnc_woocommerce_before_shop_loop_end' , 1000 );


function fresh_fnc_woocommerce_display_modes(){
	$woo_display = fresh_fnc_theme_options( 'wc_listgrid', 'grid' );

	if (isset($_GET['display'])){
		$woo_display = $_GET['display'];
	}

	echo '<form class="display-mode" method="get">';
		echo '<button title="'.esc_html__('Grid','fresh').'" class="btn '.($woo_display == 'grid' ? 'active' : '').'" value="grid" name="display" type="submit"><i class="fa fa-th"></i></button>';	
		echo '<button title="'.esc_html__( 'List', 'fresh' ).'" class="btn '.($woo_display == 'list' ? 'active' : '').'" value="list" name="display" type="submit"><i class="fa fa-th-list"></i></button>';	
		// Keep query string vars intact
		foreach ( $_GET as $key => $val ) {
			if ( 'display' === $key || 'submit' === $key ) {
				continue;
			}
			if ( is_array( $val ) ) {
				foreach( $val as $innerVal ) {
					echo '<input type="hidden" name="' . esc_attr( $key ) . '[]" value="' . esc_attr( $innerVal ) . '" />';
				}
			
			} else {
				echo '<input type="hidden" name="' . esc_attr( $key ) . '" value="' . esc_attr( $val ) . '" />';
			}
		}
	echo '</form>';
}

add_action( 'woocommerce_before_shop_loop', 'fresh_fnc_woocommerce_display_modes' , 10 );


/**
 * Processing hook layout content
 */
function fresh_fnc_layout_main_class( $class ){
	$sidebar = fresh_fnc_theme_options( 'woo-sidebar-show', 1 ) ;
	if( is_single() ){
		$sidebar = fresh_fnc_theme_options('woo-single-sidebar-show'); ;
	}
	else {
		$sidebar = fresh_fnc_theme_options('woo-sidebar-show');
	}

	if( $sidebar ){
		return $class;
	}

	return 'col-lg-12 col-md-12 col-xs-12';
}
add_filter( 'fresh_woo_layout_main_class', 'fresh_fnc_layout_main_class', 4 );


/**
 *
 */
function fresh_fnc_woocommerce_archive_image(){
	if ( is_tax( array( 'product_cat', 'product_tag' ) ) && get_query_var( 'paged' ) == 0 ) {
		$thumb =  get_woocommerce_term_meta( get_queried_object()->term_id, 'thumbnail_id', true ) ;

		if( $thumb ){
			$img = wp_get_attachment_image_src( $thumb, 'full' );

			echo '<p class="category-banner"><img src="'.$img[0].'""></p>';
		}
	}
}
add_action( 'woocommerce_archive_description', 'fresh_fnc_woocommerce_archive_image', 9 );
/**
 * Add action to init parameter before processing
 */

function fresh_fnc_before_woocommerce_init(){
	if( isset($_GET['display']) && ($_GET['display']=='list' || $_GET['display']=='grid') ){
		setcookie( 'fresh_woo_display', trim($_GET['display']) , time()+3600*24*100,'/' );
		$_COOKIE['fresh_woo_display'] = trim($_GET['display']);
	}
}

add_action( 'init', 'fresh_fnc_before_woocommerce_init' );
/***************************************************
 * 												   *
 * Hook functions applying in single product page  *
 *												   *
 ***************************************************/


/**
 * Remove review to products tabs. and display this as block below the tab.
 */
function fresh_fnc_woocommerce_product_tabs( $tabs ){

	if( isset($tabs['reviews']) ){
//		unset( $tabs['reviews'] );
	}
	return $tabs;
}
add_filter( 'woocommerce_product_tabs','fresh_fnc_woocommerce_product_tabs', 99 );

 /**
  * Rehook product review products in woocommerce_after_single_product_summary
  */
function fresh_fnc_product_reviews(){
	return comments_template();
}
//add_action('woocommerce_after_single_product_summary','fresh_fnc_product_reviews', 10 );



/**
 * Show/Hide related, upsells products
 */
function fresh_woocommerce_related_upsells_products($located, $template_name) {
	$options      = get_option('wpopal_theme_options');
	$content_none = get_template_directory() . '/woocommerce/content-none.php';

	if ( 'single-product/related.php' == $template_name ) {
		if ( isset( $options['wc_show_related'] ) &&
			( 1 == $options['wc_show_related'] ) ) {
			$located = $content_none;
		}
	} elseif ( 'single-product/up-sells.php' == $template_name ) {
		if ( isset( $options['wc_show_upsells'] ) &&
			( 1 == $options['wc_show_upsells'] ) ) {
			$located = $content_none;
		}
	}

	return apply_filters( 'fresh_woocommerce_related_upsells_products', $located, $template_name );
}

add_filter( 'wc_get_template', 'fresh_woocommerce_related_upsells_products', 10, 2 );

/**
 * Number of products per page
 */
function fresh_woocommerce_shop_per_page($number) {
	$value = fresh_fnc_theme_options('woo-number-page', get_option('posts_per_page'));
	if ( is_numeric( $value ) && $value ) {
		$number = absint( $value );
	}
	return $number;
}

add_filter( 'loop_shop_per_page', 'fresh_woocommerce_shop_per_page' );

/**
 * Number of products per row
 */
function fresh_woocommerce_shop_columns($number) {
	$value = fresh_fnc_theme_options('wc_itemsrow', 4);
	if ( in_array( $value, array(2, 3, 4, 6) ) ) {
		$number = $value;
	}
	return $number;
}

add_filter( 'loop_shop_columns', 'fresh_woocommerce_shop_columns' );

/**
 *

 */
function fresh_fnc_woocommerce_share_box() {
	if ( fresh_fnc_theme_options('wc_show_share_social', 1) ) {
		get_template_part( 'page-templates/parts/sharebox' );
	}
}

/**
 *
 */
function fresh_fnc_woo_product_nav(){
   /*
    echo '<div class="product-nav">';

        previous_post_link('%link', '<i aria-hidden="true" class="fa fa-arrow-circle-o-left"></i>', FALSE);
        next_post_link('%link', '<i aria-hidden="true" class="fa fa-arrow-circle-o-right"></i>', FALSE);

    echo '</div>';*/
}

add_action( 'fresh_woocommerce_after_single_product_title', 'fresh_fnc_woo_product_nav', 1 );


// rating star
remove_action( 'woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_rating', 5 );
add_action( 'fresh_woocommerce_before_shop_loop_item_title', 'woocommerce_template_loop_rating');


remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_title', 5 );
remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_rating', 10 );
//add_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_rating', 8 );
//add_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_price', 10 );

remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_excerpt', 1 );
//remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_meta', 40 );
//add_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_sharing', 50 );
//add_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_add_to_cart', 30 );


//remove_action( 'fresh_woocommerce_single_product_summary', 'woocommerce_template_single_excerpt', 20 );
//add_action( 'fresh_woocommerce_single_product_summary', 'woocommerce_template_single_meta', 25 );

function fresh_woocommerce_show_product_thumbnails( $layout ){
	return $layout;
}

add_filter( 'wpopal_themer_woocommerce_show_product_thumbnails', 'fresh_woocommerce_show_product_thumbnails'  );

function fresh_woocommerce_show_product_images( $layout ){
	return $layout;
}

add_filter( 'wpopal_themer_woocommerce_show_product_images', 'fresh_woocommerce_show_product_images'  );


function fresh_woocommerce_show_product_loop_sale_flash(){
	$product = wc_get_product();
	if($product->get_sale_price()):
?>
		<!--span class="onsale">
	    <?php
	        $percentage = round( ( ( $product->get_regular_price() - $product->get_sale_price() ) / $product->get_regular_price() ) * 100 );
	            echo '-' . trim( $percentage ) . '%';
	         ?>
	    </span-->
<?php
	endif;

}
remove_action('woocommerce_before_shop_loop_item_title','woocommerce_show_product_loop_sale_flash', 10);
add_action( 'woocommerce_before_shop_loop_item_title', 'fresh_woocommerce_show_product_loop_sale_flash', 10, 2); 
