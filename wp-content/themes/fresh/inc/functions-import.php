<?php

function fresh_fnc_import_remote_demos() {
	return array(
		 'fresh' => array(
			'name' 		=>  'fresh',
		 	'source'	=> 'http://wpsampledemo.com/fresh/fresh.zip',
		 	'preview'   => 'http://wpsampledemo.com/fresh/preview.jpg'
		),
	);
}

add_filter( 'wpopal_themer_import_remote_demos', 'fresh_fnc_import_remote_demos' );



function fresh_fnc_import_theme() {
	return  'fresh';
}
add_filter( 'wpopal_themer_import_theme', 'fresh_fnc_import_theme' );

function fresh_fnc_import_demos() {
	$folderes = glob( get_template_directory() .'/inc/import/*', GLOB_ONLYDIR );

	$output = array();

	foreach( $folderes as $folder ){
		$output[basename( $folder )] = basename( $folder );
	}

 	return $output;
}
add_filter( 'wpopal_themer_import_demos', 'fresh_fnc_import_demos' );

function fresh_fnc_import_types() {
	return array(
			'all' => 'All',
			'content' => 'Content',
			'widgets' => 'Widgets',
			'page_options' => 'Theme + Page Options',
			'menus' => 'Menus',
			'rev_slider' => 'Revolution Slider',
			'vc_templates' => 'VC Templates'
		);
}
add_filter( 'wpopal_themer_import_types', 'fresh_fnc_import_types' );


/**
 * Matching and resizing images with url.
 *
 *  $ouput = array(
 *        'allowed' => 1, // allow resize images via using GD Lib php to generate image
 *        'height'  => 900,
 *        'width'   => 800,
 *        'file_name' => 'blog_demo.jpg'
 *   );
 */
function fresh_import_attachment_image_size( $url ){

   $name = basename( $url );

   $ouput = array(
         'allowed' => 0
   );

   if( preg_match("#product#", $name) ) {
      $ouput = array(
         'allowed' => 1,
         'height'  => 502,
         'width'   => 502,
         'file_name' => 'product_demo.jpg'
      );
   }
   elseif( preg_match("#blog#", $name) || preg_match("#news-#", $name) || preg_match("#612YntpjodL#", $name) ){
      $ouput = array(
         'allowed' => 1,
         'height'  => 683,
         'width'   => 1024,
         'file_name' => 'blog_demo.jpg'
      );
   }
   elseif( preg_match("#portfolio#", $name) ){
      $ouput = array(
         'allowed' => 1,
         'height'  => 500,
         'width'   => 890,
         'file_name' => 'portfolio_demo.png'
      );
   }
   

   return $ouput;
}

add_filter( 'pbrthemer_import_attachment_image_size', 'fresh_import_attachment_image_size' , 1 , 999 );
