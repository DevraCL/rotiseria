<?php
	/*
  Plugin Name: WPOPAL Framework For Themes
  Plugin URI: http://www.wpopal.com/
  Description: Implement rich functions for themes base on WP_Opal wordpress framework and load widgets for theme used, this is required.
  Version: 1.3.8
  Author: WPOPAL
  Author URI: http://www.wpopal.com
  License: GPLv2 or later
  Update: 31, October 2017
 */

/**
 *  Class WpopalFrameworkThemer
 */
class WpopalFrameworkThemer{

	public function __construct() {

		add_action( 'template_redirect', array(
			&$this,
			'frontCss',
		) );
		add_action( 'admin_enqueue_scripts', array($this,'adminCss') );

		define( 'WPOPAL_THEMER_PLUGIN_THEMER_URL', plugin_dir_url( __FILE__ ) );
		define( 'WPOPAL_THEMER_PLUGIN_THEMER_DIR', plugin_dir_path( __FILE__ )  );

		add_action( 'widgets_init',  array($this,'loadWidgets') );
		add_action( 'init',  array($this,'_included') );
		add_action( 'init', array($this,'load_textdomain') );

		add_action( 'customize_register',  array( $this, 'registerCustomizer' ), 8 );

		$this->loadPosttypes();
		$this->_included();
		$this->loadVendors();

		require 'plugin-updates/plugin-update-checker.php';
		$ExampleUpdateChecker = Puc_v4_Factory::buildUpdateChecker(
		'http://wpopal.com/_opalfw_/wpopal-themer.json',
		__FILE__,
		'wpopal-themer'
		);
	}

	/**
	 * Enquee Frontend js and css file
	 */
	public function frontCss(){

		wp_register_style( 'isotope-css', WPOPAL_THEMER_PLUGIN_THEMER_URL.( 'assets/css/isotype.min.css' ), array(), 1.0 );
		wp_register_script( 'isotope', WPOPAL_THEMER_PLUGIN_THEMER_URL.( 'assets/js/isotype.min.js' ), array( 'jquery' ) );

	}

	/**
	 * Loading css/thml
	 */
	public function adminCss(){
		  wp_enqueue_style( 'admin_css', WPOPAL_THEMER_PLUGIN_THEMER_URL.'assets/css/admin.css');
	}
	/**
	 * Register Customizer
	 */
	public function registerCustomizer(){
		require_once( WPOPAL_THEMER_PLUGIN_THEMER_DIR .'classes/customizer.php'  );
	}

	/**
	 * load Widgets Supported inside theme.
	 */
	public function _included(){
		require_once( WPOPAL_THEMER_PLUGIN_THEMER_DIR .'classes/template-loader.php'  );
		require_once( WPOPAL_THEMER_PLUGIN_THEMER_DIR .'classes/setting.php'  );
		require_once( WPOPAL_THEMER_PLUGIN_THEMER_DIR .'classes/widget.php'  );
		require_once( WPOPAL_THEMER_PLUGIN_THEMER_DIR .'classes/vertical-megamenu.php'  );

		require_once(  WPOPAL_THEMER_PLUGIN_THEMER_DIR . '/classes/account.php' );
		require_once(  WPOPAL_THEMER_PLUGIN_THEMER_DIR . '/classes/nav.php' );
		require_once(  WPOPAL_THEMER_PLUGIN_THEMER_DIR . '/classes/offcanvas-menu.php' );

		require_once( WPOPAL_THEMER_PLUGIN_THEMER_DIR .'functions.php'  );

		include_once( WPOPAL_THEMER_PLUGIN_THEMER_DIR . '/import/import.php' );
		include_once( WPOPAL_THEMER_PLUGIN_THEMER_DIR. '/export/export.php' );

		if( is_admin() ){
			include_once( WPOPAL_THEMER_PLUGIN_THEMER_DIR. '/admin/function.php' );
			include_once( WPOPAL_THEMER_PLUGIN_THEMER_DIR. '/admin/metabox/pagepost.php' );
		}
	}


	/**
	 * Load plugin textdomain.
	 *
	 * @since 1.0.0
	 */
	public function load_textdomain() {
	  load_plugin_textdomain( 'wpopal-themer', false, dirname( plugin_basename( __FILE__ ) ) . '/languages' );
	}


	/**
	 * load Widgets Supported inside theme.
	 */
	public function loadPosttypes(){

		$opts = apply_filters( 'wpopal_themer_load_posttypes', get_option( 'wpopal_themer_posttype' ) );


	    if( !empty($opts) ){

	          foreach( $opts as $opt => $key ){

	            $file = str_replace( 'enable_', '', $opt );
	            $filepath = WPOPAL_THEMER_PLUGIN_THEMER_DIR.'posttypes/'.$file.'.php';
	            if( file_exists($filepath) ){
	                require_once( $filepath );
	            }
	        }
	    }
	}

	/**
	 * load Widgets Supported inside theme.
	 */
	public function loadWidgets(){

		$widgets = apply_filters( 'wpopal_themer_load_widgets', array( 'contact-info', 'facebook_like','featured_post','flickr','menu_vertical','popupnewsletter','recent_comment','socials','socials_siderbar', 'twitter', 'video', 'latest_posts', 'services') );

	    if( !empty($widgets) ){

	        foreach( $widgets as $opt => $key ){
	            $file = str_replace( 'enable_', '', $key );
	            $filepath =  plugin_dir_path( __FILE__ ).'widgets/'.$file.'.php';
	            if( file_exists($filepath) ){
	                  require_once( $filepath );
	            }
	        }
	    }
	}

	/**
	 * Load Vendor plugins
	 */
	public function loadVendors(){
		if( in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ){
	        require( WPOPAL_THEMER_PLUGIN_THEMER_DIR.'vendors/woocommerce.php' );
	    }

	    if( in_array( 'kingcomposer/kingcomposer.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ){
	        require( WPOPAL_THEMER_PLUGIN_THEMER_DIR.'vendors/kingcomposer.php' );
	    }

	}
}

new WpopalFrameworkThemer();