<?php
 /**
  * $Desc
  *
  * @version    $Id$
  * @package    wpbase
  * @author     Wordpress Opal  Team <opalwordpress@gmail.com>
  * @copyright  Copyright (C) 2015 www.wpopal.com. All Rights Reserved.
  * @license    GNU/GPL v2 or later http://www.gnu.org/licenses/gpl-2.0.html
  *
  * @website  http://www.wpopal.com
  * @support  http://www.wpopal.com/questions/
  */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class wpopal_themer_Import_Ajax{

	public static $batch;
	/**
	 * Init ajax function to import data
	 */
	public static function init(){

		$actions = array(
			'wpopal_themer_contentImport',
			'wpopal_themer_allImport',
			'wpopal_themer_metaImport',
			'wpopal_themer_vc_templatesImport',
			'wpopal_themer_rev_sliderImport',
			'wpopal_themer_essential_gridImport',
			'wpopal_themer_customizer_optionsImport',
			'wpopal_themer_page_optionsImport',
			'wpopal_themer_menusImport',
			'wpopal_themer_widgetsImport'
		);

		foreach( $actions as $action ){
			add_action('wp_ajax_' . trim($action) ,  array( __CLASS__ , trim($action) ) );
			add_action( 'wp_ajax_nopriv_'.trim($action), array( __CLASS__, trim($action)) );

		}
		self::$batch = false ;
	}

	/**
	 *
	 */
	public static function wpopal_themer_allImport(){
		return self::wpopal_themer_contentImport();
	}

	/**
	 *
	 */
	public static function wpopal_themer_contentImport(){

		$importObj = wpopal_themer_Import::getInstance();

		if ($_POST['import_attachments'] == 1)
			{$importObj->attachments = true;}
		else
			{$importObj->attachments = false;}

		$folder = $_POST['demo_source']."/";

		$ouput = $importObj->import_content($folder.$_POST['xml']);
		echo json_encode( $ouput );
		die();
	}

	/**
	 *
	 */
	public static function wpopal_themer_metaImport()
	{
		self::$batch = true ;
		$importObj = wpopal_themer_Import::getInstance();



		$folder = $_POST['demo_source'] . "/";

		$import_types = apply_filters( 'wpopal_themer_import_types', array() );
		if( isset($import_types['content']) ){
			unset( $import_types['content'] );
		}
		if( isset($import_types['all']) ){
			unset( $import_types['all'] );
		}


		if( $import_types ){
			foreach(  $import_types as $type => $value ){
				$method =  "wpopal_themer_".$type."Import";
				if( method_exists( __CLASS__ , $method) ){
					 wpopal_themer_Import_Ajax::$method();
				}
			}
		}

		die('okokokok');
	}

	/**
	 *
	 */
	public static function wpopal_themer_vc_templatesImport()
	{
		$importObj = wpopal_themer_Import::getInstance();

		$importObj->attachments = true;

		$ouput  = $importObj->import_content_vc($_POST['demo_source'] . "/vc_templates.xml");

		echo json_encode( $ouput ); exit;
	}

	/**
	 *
	 */
	public static function wpopal_themer_rev_sliderImport()
	{
		$importObj = wpopal_themer_Import::getInstance();

		$ouput = $importObj->import_rev_slider($_POST['demo_source']);

		echo json_encode( $ouput ); exit;
	}

	/**
	 *
	 */
	public static function wpopal_themer_essential_gridImport()
	{
		$importObj = wpopal_themer_Import::getInstance();

		$ouput = $importObj->import_essential_grid($_POST['demo_source'] . '/essential_grid.txt');

		echo json_encode( $ouput ); exit;
	}

	/**
	 *
	 */
	public function wpopal_themer_customizer_optionsImport()
	{
		$importObj = wpopal_themer_Import::getInstance();

		$ouput = $importObj->import_customizer_options($_POST['demo_source'] . '/skins/Skin 1.txt');

		echo json_encode( $ouput ); exit;
	}

	/**
	 *
	 */
	public static function wpopal_themer_page_optionsImport()
	{
		$importObj = wpopal_themer_Import::getInstance();

		$importObj->import_page_options($_POST['demo_source'] . '/page_options.txt');

		$ouput = $importObj->import_theme_options( $_POST['demo_source'] . '/options.txt' );

		echo json_encode( $ouput ); exit;
	}

	/**
	 *
	 */
	public static function wpopal_themer_menusImport()
	{
		$importObj = wpopal_themer_Import::getInstance();

		$ouput  = $importObj->import_menus($_POST['demo_source'] . '/menus.txt');

		echo json_encode( $ouput ); exit;
	}

	/**
	 *
	 */
	public static function wpopal_themer_widgetsImport() {

		$importObj = wpopal_themer_Import::getInstance();

		$folder = $_POST['demo_source']."/";

		$importObj->import_widgets($folder.'widgets.txt');

		// Import widget logic
		$ouput = $importObj->import_widget_logic( $folder.'widget_logic_options.txt' );

		echo json_encode( $ouput ); exit;
	}
}

wpopal_themer_Import_Ajax::init();