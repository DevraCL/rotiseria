<?php
/**
 * Implement Custom Header functionality for Fresh
 *
 * @package WpOpal
 * @subpackage Fresh
 * @since Fresh 1.0
 */

/**
 * Set up the WordPress core custom header settings.
 *
 * @since Fresh 1.0
 *
 * @uses fresh_fnc_header_style()
 * @uses fresh_fnc_admin_header_style()
 * @uses fresh_fnc_admin_header_image()
 */
function fresh_fnc_custom_header_setup() {
	/**
	 * Filter Fresh custom-header support arguments.
	 *
	 * @since Fresh 1.0
	 *
	 * @param array $args {
	 *     An array of custom-header support arguments.
	 *
	 *     @type bool   $header_text            Whether to display custom header text. Default false.
	 *     @type int    $width                  Width in pixels of the custom header image. Default 1260.
	 *     @type int    $height                 Height in pixels of the custom header image. Default 240.
	 *     @type bool   $flex_height            Whether to allow flexible-height header images. Default true.
	 *     @type string $admin_head_callback    Callback function used to style the image displayed in
	 *                                          the Appearance > Header screen.
	 *     @type string $admin_preview_callback Callback function used to create the custom header markup in
	 *                                          the Appearance > Header screen.
	 * }
	 */
	add_theme_support( 'custom-header', apply_filters( 'fresh_fnc_custom_header_args', array(
		'default-text-color'     => 'fff',
		'width'                  => 1260,
		'height'                 => 240,
		'flex-height'            => true,
		'wp-head-callback'       => 'fresh_fnc_header_style',
		'admin-head-callback'    => 'fresh_fnc_admin_header_style',
		'admin-preview-callback' => 'fresh_fnc_admin_header_image',
	) ) );
}
add_action( 'after_setup_theme', 'fresh_fnc_custom_header_setup' );

if ( ! function_exists( 'fresh_fnc_header_style' ) ) :
/**
 * Styles the header image and text displayed on the blog
 *
 * @see fresh_fnc_custom_header_setup().
 *
 */
function fresh_fnc_header_style() {
	$text_color = get_header_textcolor();

	// If no custom color for text is set, let's bail.


	// If we get this far, we have custom styles.
	?>
	<style type="text/css" id="fresh-header-css">
		<?php
		$page_bg = get_option('page_bg');
		if( !empty($page_bg) && preg_match("#\##", $page_bg) ) :  ?>
		#page{
			background-color:<?php echo trim($page_bg); ?>;
		}
		<?php endif; ?>

		<?php
		$footer_bg = get_option('footer_bg');
		if( !empty($footer_bg) && preg_match("#\##", $footer_bg) ) :  ?>
		#opal-footer {
			background-color:<?php echo trim($footer_bg); ?> ;
		}
		<?php endif; ?>
		<?php
		$footer_color = get_option('footer_color');
		if( !empty($footer_color) && preg_match("#\##", $footer_color) ) :  ?>
		#opal-footer , #opal-footer a{
			color: <?php echo trim($footer_color); ?>
		}
		<?php endif; ?>
		<?php
		$footer_color = get_option('footer_heading_color');
		if( !empty($footer_color) && preg_match("#\##", $footer_color) ) :  ?>
		#opal-footer h2, #opal-footer h3, #opal-footer h4{
			color: <?php echo trim($footer_color); ?>
		}
		<?php endif; ?>
		<?php $topbar_bg = get_option('topbar_bg'); if( !empty($topbar_bg) && preg_match("#\##", $topbar_bg) ) :  ?>
		#opal-topbar {
			background-color:<?php echo trim($topbar_bg); ?> ;
		}
		<?php endif; ?>
		<?php $topbar_color = get_option('topbar_color'); if( !empty($topbar_color) && preg_match("#\##", $topbar_color) ) :  ?>
		#opal-topbar , #opal-topbar a{
			color: <?php echo trim($topbar_color); ?>
		}
		<?php endif; ?>

		<?php $theme_color = get_option('theme_color'); if( !empty($theme_color) && preg_match("#\##", $theme_color) ) :  ?>
		.navbar-mega .navbar-nav > li > a:hover, .navbar-mega .navbar-nav > li > a:focus,.navbar-mega .navbar-nav > li .dropdown-menu li.active a,
		.product-block .add-cart > a.button,.call-to-action .kc_box_wrap p,
		.products-bottom-wrap nav.woocommerce-pagination ul span.current, .products-bottom-wrap nav.woocommerce-pagination ul li span.current,
		.navbar-mega .navbar-nav > li .dropdown-menu li a:hover,.navbar-mega .navbar-nav li.active > a,
		.navbar-mega .navbar-nav li.active > a .caret,.opal-topbar .list-inline a:hover{
			color: <?php echo trim($theme_color); ?>
		}
		<?php endif; ?>

		<?php $theme_color = get_option('theme_color'); if( !empty($theme_color) && preg_match("#\##", $theme_color) ) :  ?>
		.product-block .add-cart > a.button:hover,article.post.blog-v1 .readmore,ul.product-categories > li.current-cat, ul.product-categories > li.current-cat-parent,
		.woocommerce #respond input#submit, .woocommerce button.button, .woocommerce input.button, .widget_price_filter .ui-slider .ui-slider-handle,
		.navbar-mega .navbar-nav > li > a:after,.product-block .add-cart > a.button:hover{
			background-color: <?php echo trim($theme_color); ?>
		}
		<?php endif; ?>

		<?php $second_color = get_option('second_color'); if( !empty($second_color) && preg_match("#\##", $second_color) ) :  ?>
		.opal-copyright a:hover, .opal-copyright a:focus, .opal-copyright a:active,.kc_tabs.product-tabs .kc_tabs_nav > li.ui-tabs-active a,
		a:hover, a:focus,.text-primary,.single-product.woocommerce div.product p.price,ul.product-categories > li li a:hover,
		.nav-tabs > li.active > a, .nav-tabs > li.active > a:hover, .nav-tabs > li.active > a:focus,
		.kc_tabs.product-tabs .kc_tabs_nav > li a:hover, .kc_tabs.product-tabs .kc_tabs_nav > li a:focus{
			color: <?php echo trim($second_color); ?>
		}
		<?php endif; ?>

		<?php $second_color = get_option('second_color'); if( !empty($second_color) && preg_match("#\##", $second_color) ) :  ?>
		.btn-primary,.widget-deals .product-deals:before{
			background-color: <?php echo trim($second_color); ?>
		}
		<?php endif; ?>

	</style>

	<?php if ( display_header_text() && $text_color === get_theme_support( 'custom-header', 'default-text-color' ) )
		return; ?>
	<?php
}
endif; // fresh_fnc_header_style


if ( ! function_exists( 'fresh_fnc_admin_header_style' ) ) :
/**
 * Style the header image displayed on the Appearance > Header screen.
 *
 * @see fresh_fnc_custom_header_setup()
 *
 * @since Fresh 1.0
 */
function fresh_fnc_admin_header_style() {
?>
	<style type="text/css" id="fresh-admin-header-css">
	.appearance_page_custom-header #headimg {
		background-color: #000;
		border: none;
		max-width: 1260px;
		min-height: 48px;
	}
	#headimg h1 {
		font-family: Lato, sans-serif;
		font-size: 18px;
		line-height: 48px;
		margin: 0 0 0 30px;
	}
	.rtl #headimg h1  {
		margin: 0 30px 0 0;
	}
	#headimg h1 a {
		color: #fff;
		text-decoration: none;
	}
	#headimg img {
		vertical-align: middle;
	}

<?php
}
endif; // fresh_fnc_admin_header_style

if ( ! function_exists( 'fresh_fnc_admin_header_image' ) ) :
/**
 * Create the custom header image markup displayed on the Appearance > Header screen.
 *
 * @see fresh_fnc_custom_header_setup()
 *
 * @since Fresh 1.0
 */
function fresh_fnc_admin_header_image() {
?>
	<div id="headimg">
		<?php if ( get_header_image() ) : ?>
		<img src="<?php header_image(); ?>" alt="">
		<?php endif; ?>
		<h1 class="displaying-header-text"><a id="name" style="<?php echo esc_attr( sprintf( 'color: #%s;', get_header_textcolor() ) ); ?>" onclick="return false;" href="<?php echo esc_url( home_url( '/' ) ); ?>" tabindex="-1"><?php bloginfo( 'name' ); ?></a></h1>
	</div>
<?php
}
endif; // fresh_fnc_admin_header_image