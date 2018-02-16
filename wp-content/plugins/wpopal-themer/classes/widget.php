<?php
/**
 * $Desc
 *
 * @version    $Id$
 * @package    wpbase
 * @author      Team <opalwordpress@gmail.com >
 * @copyright  Copyright (C) 2015  wpopal.com. All Rights Reserved.
 * @license    GNU/GPL v2 or later http://www.gnu.org/licenses/gpl-2.0.html
 *
 * @website  http://www.wpopal.com
 * @support  http://www.wpopal.com/questions/
 */
if(!class_exists('Wpopal_Themer_Widget')){
	
abstract class Wpopal_Themer_Widget extends WP_Widget{

	protected $widgetName='';
	/**
	 * this method check overriding layout path in current template
	 */
	public function renderLayout($layout='default' ){  
		$output='';
		$tpl = get_template_directory() .'/widgets/'.$this->widgetName.'/'.$layout.'.php'; 
		$tpl_default = WPOPAL_THEMER_PLUGIN_THEMER_DIR .'/templates/widgets/' .$this->widgetName.'/'.$layout.'.php';
  
		if(  is_file($tpl) ){ 
			return( $tpl );
		}else if( is_file($tpl_default) ){
			return( $tpl_default );
		}
		return  WPOPAL_THEMER_PLUGIN_THEMER_DIR .'templates/widgets/no-layout.php';
	}

	public function selectLayout(){
		$tml_default 	= glob(WPOPAL_THEMER_PLUGIN_THEMER_DIR .$this->widgetName.'/tpl/*.php');
		$tml_new 		= glob(get_template_directory() .'/widgets/'.$this->widgetName.'/*.php');
		$layout = array_merge($tml_default,$tml_new);
		foreach ($layout as $key => $value) {
			$layout[$key] = basename($value,'.php');
		}
		$layout = array_unique($layout);
		return $layout;
	}

}
}