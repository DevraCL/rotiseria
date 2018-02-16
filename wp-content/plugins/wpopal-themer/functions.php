<?php
/**
 * Template Functions
 *
 * @package     Give
 * @subpackage  Functions/Templates
 * @copyright   Copyright (c) 2015, WordImpress
 * @license     http://opensource.org/licenses/gpl-2.0.php GNU Public License
 * @since       1.0
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
/**
 * Get option value by key follow theme setting.
 */
function wpopal_themer_fnc_theme_options($name, $default = false) {
  
    // get the meta from the database
    $options = ( get_option( 'wpopal_theme_options' ) ) ? get_option( 'wpopal_theme_options' ) : null;

    
   
    // return the option if it exists
    if ( isset( $options[$name] ) ) {
        return apply_filters( 'wpopal_theme_options_$name', $options[ $name ] );
    }
    if( get_option( $name ) ){
        return get_option( $name );
    }
    // return default if nothing else
    return apply_filters( 'wpopal_theme_options_$name', $default );
}


/**
 * Returns the path to the Give templates directory
 *
 * @since 1.0
 * @return string
 */
function wpopal_themer_get_templates_dir() {
	return WPOPAL_THEMER_PLUGIN_THEMER_DIR . 'templates';
}

/**
 * Returns the URL to the Give templates directory
 *
 * @since 1.0
 * @return string
 */
function wpopal_themer_get_templates_url() {
	return WPOPAL_THEMER_PLUGIN_THEMER_URL . 'templates';
}

/**
 * Retrieves a template part
 *
 * @since v1.0
 *
 * Taken from bbPress
 *
 * @param string $slug
 * @param string $name Optional. Default null
 * @param bool   $load
 *
 * @return string
 *
 * @uses  wpopal_themer_locate_template()
 * @uses  load_template()
 * @uses  get_template_part()
 */
//add_filter( 'template_include', 'wpopal_themer_get_template_part' );

function wpopal_themer_get_template_part( $slug, $name = null, $load = true ) {

	// Execute code for this part
	do_action( 'get_template_part_' . $slug, $slug, $name );

	// Setup possible parts
	$templates = array();
	if ( isset( $name ) ) {
		$templates[] = $slug . '-' . $name . '.php';
	}

	$templates[] = $slug . '.php';

	// Allow template parts to be filtered
	$templates = apply_filters( 'wpopal_themer_get_template_part', $templates, $slug, $name );

	// Return the part that is found
	return wpopal_themer_locate_template( $templates, $load, false );
}

/**
 * Retrieve the name of the highest priority template file that exists.
 *
 * Searches in the STYLESHEETPATH before TEMPLATEPATH so that themes which
 * inherit from a parent theme can just overload one file. If the template is
 * not found in either of those, it looks in the theme-compat folder last.
 *
 * Forked from bbPress
 *
 * @since 1.0
 *
 * @param string|array $template_names Template file(s) to search for, in order.
 * @param bool         $load           If true the template file will be loaded if it is found.
 * @param bool         $require_once   Whether to require_once or require. Default true.
 *                                     Has no effect if $load is false.
 *
 * @return string The template filename if one is located.
 */
function wpopal_themer_locate_template( $template_names, $load = false, $require_once = true ) {
	// No file found yet
	$located = false;

	// Try to find a template file
	foreach ( (array) $template_names as $template_name ) {

		// Continue if template is empty
		if ( empty( $template_name ) ) {
			continue;
		}

		// Trim off any slashes from the template name
		$template_name = ltrim( $template_name, '/' );

		// try locating this template file by looping through the template paths
		foreach ( wpopal_themer_get_theme_template_paths() as $template_path ) {

			if ( file_exists( $template_path . $template_name ) ) {
				$located = $template_path . $template_name;
				break;
			}
		}

		if ( $located ) {
			break;
		}
	}
	 	
	if ( ( true == $load ) && ! empty( $located ) ) {
		load_template( $located, $require_once );
	}

	return $located;
}

/**
 * Returns a list of paths to check for template locations
 *
 * @since 1.0
 * @return mixed|void
 */
function wpopal_themer_get_theme_template_paths() {

	$template_dir = wpopal_themer_get_theme_template_dir_name();

	$file_paths = array(
		1   => trailingslashit( get_stylesheet_directory() ),
		10  => trailingslashit( get_template_directory() ) . $template_dir,
		100 => wpopal_themer_get_templates_dir()
	);

	$file_paths = apply_filters( 'wpopal_themer_template_paths', $file_paths );

	// sort the file paths based on priority
	ksort( $file_paths, SORT_NUMERIC );

	return array_map( 'trailingslashit', $file_paths );
}

/**
 * Returns the template directory name.
 *
 * Themes can filter this by using the wpopal_themer_templates_dir filter.
 *
 * @since 1.0
 * @return string
 */
function wpopal_themer_get_theme_template_dir_name() {
	return trailingslashit( apply_filters( 'wpopal_themer_templates_dir', 'wpopal-themer' ) );
}

/**
 * get list content blog layout
 */
function wpopal_themer_get_content_blog_layouts(){
	$files = glob( get_stylesheet_directory().'/content-blog*.php' );

	$output = array();
	$output['blog'] = 'blog';
	if( $files ){
		foreach( $files as $file ){
			$name =  str_replace('content-', '',str_replace( '.php', '', basename( $file ) ) ) ;
			$output[$name] = $name;
		}
	}
	return $output;
}

/**
 * create a random key to use as primary key.
 */
function wpopal_themer_makeid( $length = 5 ){
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, strlen($characters) - 1)];
    }
    return $randomString;
}

/**
 * Helper for get list of array of key and value
 */
function wpopal_themer_autocomplete_options_helper( $options ){
	$output = array();
   $options = array_map('trim', explode(',', $options));
	foreach( $options as $option ){
		$tmp = explode( ":", $option );
		$output[$tmp[0]] = $tmp[1];
	}
	return $output; 
} 


if(!function_exists('wpopal_themer_excerpt')){
    //Custom Excerpt Function
    function wpopal_themer_excerpt($limit,$afterlimit='[...]') {
        $excerpt = get_the_excerpt();
        if( $excerpt != ''){
           $excerpt = explode(' ', strip_tags( $excerpt ), $limit);
        }else{
            $excerpt = explode(' ', strip_tags(get_the_content( )), $limit);
        }
        if (count($excerpt)>=$limit) {
            array_pop($excerpt);
            $excerpt = implode(" ",$excerpt).' '.$afterlimit;
        } else {
            $excerpt = implode(" ",$excerpt);
        }
        $excerpt = preg_replace('`[[^]]*]`','',$excerpt);
        return strip_shortcodes( $excerpt );
    }
}


if(!function_exists('wpopal_themer_string_limit_words')){
    function wpopal_themer_string_limit_words($string, $word_limit)
    {
      $words = explode(' ', $string, ($word_limit + 1));

      if(count($words) > $word_limit) {
        array_pop($words);
      }

      return implode(' ', $words);
    }
}




/**
  * find all header files with prefix name having header-
  */
function wpopal_themer_fnc_get_header_layouts(){
    $path = get_template_directory().'/header-*.php';
    $files = glob( $path  );
    $headers = array( 'default' => esc_html__('Default', 'wpopal-themer') );
    if( count($files)>0 ){
        foreach ($files as $key => $file) {
            $header = str_replace( "header-", '', str_replace( '.php', '', basename($file) ) );
            $headers[$header] = esc_html__( 'Header', 'wpopal-themer' ) . ' ' .str_replace( '-',' ', ucfirst( $header ) );
        }
    }

    return $headers;
}

 /**
  * Get list of footer profile as array. they are post from  post type 'footer'
  */
function wpopal_themer_fnc_get_footer_profiles(){
    
    $footers_type = get_posts( array('posts_per_page' => -1, 'post_type' => 'footer') );
    $footers = array(  'default' => esc_html__('Default', 'wpopal-themer') );
    foreach ($footers_type as $key => $value) {
        $footers[$value->post_name] = $value->post_title;
    }

    wp_reset_postdata();


    return $footers;
}

/**
 * get list of menu group
 */
function wpopal_themer_fnc_get_menugroups(){
    $menus       = wp_get_nav_menus( );
    $option_menu = array( '' => '---Select Menu---' );
    foreach ($menus as $menu) {
        $option_menu[$menu->term_id]=$menu->name;
    }
    return $option_menu;
}

/**
 *
 */
function wpopal_themer_fnc_cst_skins(){
    $path = get_template_directory().'/css/skins/*';
    $files = glob($path , GLOB_ONLYDIR );
    $skins = array( 'default' => 'default' );
    if( is_array($files) && count($files) > 0 ){
      foreach ($files as $key => $file) {
          $skin = str_replace( '.css', '', basename($file) );
          $skins[$skin] =  $skin;
      }
    }
    return $skins;
}


if(!function_exists('wpopal_themer_fnc_excerpt')){
    //Custom Excerpt Function
    function wpopal_themer_fnc_excerpt($limit,$afterlimit='[...]') {
        $excerpt = get_the_excerpt();
        if( $excerpt != ''){
           $excerpt = explode(' ', strip_tags( $excerpt ), $limit);
        }else{
            $excerpt = explode(' ', strip_tags(get_the_content( )), $limit);
        }
        if (count($excerpt)>=$limit) {
            array_pop($excerpt);
            $excerpt = implode(" ",$excerpt).' '.$afterlimit;
        } else {
            $excerpt = implode(" ",$excerpt);
        }
        $excerpt = preg_replace('`[[^]]*]`','',$excerpt);
        return strip_shortcodes( $excerpt );
    }
}
if(!function_exists('wpopal_getMetaboxValue')){
    function wpopal_getMetaboxValue( $post_id ,$key, $single = true ) {
      return get_post_meta( $post_id, $key, $single ); 
    }
}