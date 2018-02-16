<?php
 /**
  * $Desc
  *
  * @version    $Id$
  * @package    wpbase
  * @author      Team <opalwordpress@gmail.com >
  * @copyright  Copyright (C) 2015 prestabrain.com. All Rights Reserved.
  * @license    GNU/GPL v2 or later http://www.gnu.org/licenses/gpl-2.0.html
  *
  * @website  http://www.wpopal.com
  * @support  http://www.wpopal.com/questions/
  */

if(!function_exists('wpopal_create_type_faq')   ){
  	function wpopal_create_type_faq(){
		register_post_type(
			'faq',
			array(
				'labels' => array(
					'name' => 'FAQs',
					'singular_name' => 'FAQ',
					'menu_name' => __('FAQs', "wpopal-themer")
				),
				'menu_position' => 8,
				'public' => true,
				'has_archive' => false,
				'rewrite' => array('slug' => 'faq-items'),
				'supports' => array('title', 'editor', 'excerpt', 'author', 'thumbnail', 'comments', 'revisions', 'custom-fields', 'page-attributes', 'post-formats'),
				'can_export' => true,
				'show_in_nav_menus'=>false
			)
		);

		register_taxonomy('faq_category', 'faq', array(
				'hierarchical' => true,
				'label' => 'Categories',
				'query_var' => true,
				'show_in_nav_menus'=>false,
				'rewrite' => true)
		);
	}

	add_action( 'init','wpopal_create_type_faq' );
}


