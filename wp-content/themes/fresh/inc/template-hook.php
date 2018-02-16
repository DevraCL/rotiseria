<?php
/**
 * Remove javascript and css files not use
 */
if( is_admin() ){
	function fresh_setup_admin_setting(){

		global $pagenow;
		if ( is_admin() && isset($_GET['activated'] ) && $pagenow == 'themes.php' ) {
			/**
			 *
			 */
			$pts = array( 'brands', 'footer', 'megamenu', 'portfolio');

			$options = array();

			foreach( $pts as $key ){
				$options['enable_'.$key] = 'on';
			}

			update_option( 'wpopal_themer_posttype', $options );

			do_action( 'fresh_setup_theme_actived' );
		}
	}
	add_action( 'init', 'fresh_setup_admin_setting'  );
}


/**
 * Hoo to top bar layout
 */
function fresh_fnc_topbar_layout(){
	$layout = fresh_fnc_get_header_layout();
	get_template_part( 'page-templates/parts/topbar', $layout );
	get_template_part( 'page-templates/parts/topbar', 'mobile' );
}

add_action( 'fresh_template_header_before', 'fresh_fnc_topbar_layout' );

/**
 * Hook to select header layout for archive layout
 */
function fresh_fnc_get_header_layout( $layout='' ){
	global $post;

	$layout = $post && get_post_meta( $post->ID, 'fresh_header_layout', 1 ) ? get_post_meta( $post->ID, 'fresh_header_layout', 1 ) : fresh_fnc_theme_options( 'headerlayout' );

 	if( $layout == 'default' ){
 		return '';
 	}elseif( $layout){
 		return trim( $layout );
 	}elseif ( $layout = fresh_fnc_theme_options('header_skin','') ){
 		return trim( $layout );
 	}

	return $layout;
}

add_filter( 'fresh_fnc_get_header_layout', 'fresh_fnc_get_header_layout' );

/**
 * Hook to select header layout for archive layout
 */
function fresh_fnc_get_footer_profile( $profile='default' ){

	global $post;

	$profile =  $post? get_post_meta( $post->ID, 'fresh_footer_profile', 1 ):null ;

 	if ( $profile && $profile != 'global' ) {
 		return trim( $profile );
 	} elseif ( $profile = fresh_fnc_theme_options('footer-style', $profile ) ) {
 		return trim( $profile );
 	}

	return $profile;
}

add_filter( 'fresh_fnc_get_footer_profile', 'fresh_fnc_get_footer_profile' );


/**
 * Hook to show breadscrumbs
 */
function fresh_fnc_render_breadcrumbs(){

	global $post;

	if( is_object($post) ){
		$disable = get_post_meta( $post->ID, 'fresh_disable_breadscrumb', 1 );
		if(  $disable || is_front_page() ){
			return true;
		}
		$bgimage = get_post_meta( $post->ID, 'fresh_image_breadscrumb', 1 );
		$color 	 = get_post_meta( $post->ID, 'fresh_color_breadscrumb', 1 );
		$bgcolor = get_post_meta( $post->ID, 'fresh_bgcolor_breadscrumb', 1 );
		$style = array();

		if( $bgcolor  ){
			$style[] = 'background-color:'.$bgcolor;
		}

		if( $bgimage  ){
			$style[] = 'background-image:url(\''.wp_get_attachment_url($bgimage).'\')';
		}else{
			$bgimage = fresh_fnc_theme_options( 'breadcrumb-bg' );
			$style[] =  $bgimage  ? 'background-image:url(\''.$bgimage.'\')' : "";
		}

		if( $color  ){
			$style[] = 'color:'.$color;
		}

		$estyle = !empty($style)? 'style="'.implode(";", $style).'"':"";
	} else {

		$bgimage = fresh_fnc_theme_options( 'breadcrumb-bg' );
		if( !empty($bgimage)  ){
			$style[] = 'background-image:url(\''.$bgimage.'\')';
		}
		$estyle = !empty($style)? 'style="'.implode(";", $style).'"':"";
	}

	echo '<section id="opal-breadscrumb" class="opal-breadscrumb" '.$estyle.'><div class="container">';
			fresh_fnc_breadcrumbs();
	echo '</div></section>';

}

add_action( 'fresh_template_main_before', 'fresh_fnc_render_breadcrumbs' );


/**
 * Main Container
 */

function fresh_template_main_container_class( $class ){
	global $post;
	global $fresh_wpopconfig;

	$layoutcls = get_post_meta( $post->ID, 'fresh_enable_fullwidth_layout', 1 );

	if( $layoutcls ) {
		$fresh_wpopconfig['layout'] = 'fullwidth';
		return 'container-fluid';
	}
	return $class;
}
add_filter( 'fresh_template_main_container_class', 'fresh_template_main_container_class', 1 , 1  );
add_filter( 'fresh_template_main_content_class', 'fresh_template_main_container_class', 1 , 1  );



/**
 * Get Configuration for Page Layout
 *
 */
function fresh_fnc_get_page_sidebar_configs( $configs='' ){

	global $post;

	$left  =  get_post_meta( $post->ID, 'fresh_leftsidebar', 1 );
	$right =  get_post_meta( $post->ID, 'fresh_rightsidebar', 1 );

	return fresh_fnc_get_layout_configs( $left, $right );
}

add_filter( 'fresh_fnc_get_page_sidebar_configs', 'fresh_fnc_get_page_sidebar_configs', 1, 1 );


function fresh_fnc_get_single_sidebar_configs( $configs='' ){

	global $post;

	$left  =  get_post_meta( $post->ID, 'fresh_leftsidebar', 1 );
	$right =  get_post_meta( $post->ID, 'fresh_rightsidebar', 1 );

	if ( empty( $left ) ) {
		$left  =  fresh_fnc_theme_options( 'blog-single-left-sidebar' );
	}

	if ( empty( $right ) ) {
		$right =  fresh_fnc_theme_options( 'blog-single-right-sidebar' );
	}

	return fresh_fnc_get_layout_configs( $left, $right );
}

add_filter( 'fresh_fnc_get_single_sidebar_configs', 'fresh_fnc_get_single_sidebar_configs', 1, 1 );

function fresh_fnc_get_archive_sidebar_configs( $configs='' ){

	global $post;


	$left  =  fresh_fnc_theme_options( 'blog-archive-left-sidebar' );
	$right =  fresh_fnc_theme_options( 'blog-archive-right-sidebar' );

	return fresh_fnc_get_layout_configs( $left, $right );
}

add_filter( 'fresh_fnc_get_archive_sidebar_configs', 'fresh_fnc_get_archive_sidebar_configs', 1, 1 );
add_filter( 'fresh_fnc_get_category_sidebar_configs', 'fresh_fnc_get_archive_sidebar_configs', 1, 1 );

/**
 *
 */
function fresh_fnc_get_layout_configs( $left, $right ){
	$configs = array();
	$configs['main'] = array( 'class' => 'col-lg-9 col-md-9' );

	$configs['sidebars'] = array(
		'left'  => array( 'sidebar' => $left, 'active' => is_active_sidebar( $left ), 'class' => 'col-lg-3 col-md-3 col-xs-12'  ),
		'right' => array( 'sidebar' => $right, 'active' => is_active_sidebar( $right ), 'class' => 'col-lg-3 col-md-3 col-xs-12' )
	);

	if( $left && $right ){
		$configs['main'] = array( 'class' => 'col-lg-6 col-md-6' );
	} elseif( empty($left) && empty($right) ){
		$configs['main'] = array( 'class' => 'col-lg-12 col-md-12' );
	}
	return $configs;
}


function fresh_fnc_sidebars_others_configs(){

	global $fresh_page_layouts;

	return $fresh_page_layouts;
}

add_filter("fresh_fnc_sidebars_others_configs", "fresh_fnc_sidebars_others_configs");