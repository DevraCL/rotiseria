<?php 
/**
 * Register meta boxes
 *
 * Remember to change "your_prefix" to actual prefix in your project
 *
 * @param array $meta_boxes List of meta boxes
 *
 * @return array
 */
function wpopal_themer_fnc_register_meta_boxes( $meta_boxes )
{
	global $wp_registered_sidebars;	 // echo '<pre>'.print_r($wp_registered_sidebars, 1 ); die; 
	/**
	 * prefix of meta keys (optional)
	 * Use underscore (_) at the beginning to make keys hidden
	 * Alt.: You also can make prefix empty to disable it 
	 */
	$sidebars = array();
	if( $wp_registered_sidebars){
		foreach( $wp_registered_sidebars  as $key => $value ){
			$sidebars[$key] = $value['name'];
		}
	}
	// Better has an underscore as last sign
	$prefix = apply_filters( 'wpopal_themer_get_theme_prefix', 'wpopal_themer_' );  
	$layouts = array(
	    'leftmain' => esc_html__('Left - Main Sidebar', 'wpopal-themer'),
	    'mainright' => esc_html__('Main - Right Sidebar', 'wpopal-themer'),
	    'fullwidth' => esc_html__('Fullwidth', 'wpopal-themer'),

	);
	$footers = array( 'global' => esc_html__( 'Global', 'wpopal-themer' ) ) + wpopal_themer_fnc_get_footer_profiles();
	
	// 1st meta box
	$meta_boxes[] = array(
		// Meta box id, UNIQUE per meta box. Optional since 4.1.5
		'id'         => 'standard',
		// Meta box title - Will appear at the drag and drop handle bar. Required.
		'title'      => esc_html__( 'Page Layout Setting', 'wpopal-themer' ),
		// Post types, accept custom post types as well - DEFAULT is 'post'. Can be array (multiple post types) or string (1 post type). Optional.
		'post_types' => array( 'page' ),
		// Where the meta box appear: normal (default), advanced, side. Optional.
		'context'    => 'normal',
		// Order of meta box: high (default), low. Optional.
		'priority'   => 'low',
		// Auto save: true, false (default). Optional.
		'autosave'   => true,
		// List of meta fields
		'fields'     => array(
	 	
			// CHECKBOX
			array(
				'name' => esc_html__( 'Enable Fullwidth Layout', 'wpopal-themer' ),
				'id'   => "{$prefix}enable_fullwidth_layout",
				'type' => 'checkbox',
				// Value can be 0 or 1
				'std'  => 0,
			),		
			// HEADER SELECT BOX
			array(
				'name'        => esc_html__( 'Header Layout', 'wpopal-themer' ),
				'id'          => "{$prefix}header_layout",
				'type'        => 'select',
				// Array of 'value' => 'Label' pairs for select box
				'options'     =>  wpopal_themer_fnc_get_header_layouts(),
				// Select multiple values, optional. Default is false.
				'multiple'    => false,
				'std'         => '',
				'placeholder' => esc_html__( 'Global', 'wpopal-themer' ),
			),

			array(
				'name'        => esc_html__( 'Footer Layout', 'wpopal-themer' ),
				'id'          => "{$prefix}footer_profile",
				'type'        => 'select',
				'options'     => $footers,
				'multiple'    => false,
			),

			// CHECKBOX
			array(
				'name' => esc_html__( 'Disable Breadscrumb', 'wpopal-themer' ),
				'id'   => "{$prefix}disable_breadscrumb",
				'type' => 'checkbox',
				// Value can be 0 or 1
				'std'  => 1,
			),	

			// COLOR
			array(
				'name' => esc_html__( 'Breadcrumbs Text Color', 'wpopal-themer' ),
				'id'   => "{$prefix}color_breadscrumb",
				'type' => 'color',
				'description' => esc_html__('Custom Text Color for breadscrumb','wpopal-themer')
			), 
			 

			// COLOR
			array(
				'name' => esc_html__( 'Breadcrumbs Background Color', 'wpopal-themer' ),
				'id'   => "{$prefix}bgcolor_breadscrumb",
				'type' => 'color',
				'description' => esc_html__('Custom Background for breadscrumb','wpopal-themer')
			), 
			 
			 // THICKBOX IMAGE UPLOAD (WP 3.3+)
			// FILE ADVANCED (WP 3.5+)
			array(
				'name'             => esc_html__( 'Breadscrumb Background', 'wpopal-themer' ),
				'id'               => "{$prefix}image_breadscrumb",
				'type'             => 'file_advanced',
				'max_file_uploads' => 1,
				'mime_type'        => 'image', // Leave blank for all file types
			),

			array(
				'name'        => esc_html__( 'Layout', 'wpopal-themer' ),
				'id'          => "{$prefix}page_layout",
				'type'        => 'select',
				// Array of 'value' => 'Label' pairs for select box
				'options'     =>   $layouts,
				// Select multiple values, optional. Default is false.
				'multiple'    => false,
				'std'         => '',

			),

			// HEADER SELECT BOX
			array(
				'name'        => esc_html__( 'Left Sidebar', 'wpopal-themer' ),
				'id'          => "{$prefix}leftsidebar",
				'type'        => 'select',
				// Array of 'value' => 'Label' pairs for select box
				'options'     => $sidebars,
				// Select multiple values, optional. Default is false.
				'multiple'    => false,
				'std'         => '',
				'placeholder' => esc_html__( 'Global', 'wpopal-themer' ),
			),

			// HEADER SELECT BOX
			array(
				'name'        => esc_html__( 'Right Sidebar', 'wpopal-themer' ),
				'id'          => "{$prefix}rightsidebar",
				'type'        => 'select',
				// Array of 'value' => 'Label' pairs for select box
				'options'     => $sidebars,
				// Select multiple values, optional. Default is false.
				'multiple'    => false,
				'std'         => '',
				'placeholder' => esc_html__( 'Global', 'wpopal-themer' ),
			),

			// HEADER SELECT BOX
			array(
				'name'        => esc_html__( 'Addition class', 'wpopal-themer' ),
				'id'          => "{$prefix}additionclass",
				'type'        => 'select',
				// Array of 'value' => 'Label' pairs for select box
				'options'     => array( 'home-background' => esc_html__( 'Home Background', 'wpopal-themer' ) ),
				// Select multiple values, optional. Default is false.
				'multiple'    => false,
				'std'         => '',
				'placeholder' => esc_html__( 'None', 'wpopal-themer' ),
			),
		),
		'validation' => array(
			 
		)
	);	
 	 
	return $meta_boxes;
}
add_filter( 'rwmb_meta_boxes', 'wpopal_themer_fnc_register_meta_boxes' , 102 );


function wpopal_themer_fnc_register_postformat_meta_boxes(  $meta_boxes  ){
	 
	// Better has an underscore as last sign
	$prefix = 'wpopal_themer_';

	$layouts = array(
	    'leftmain' => esc_html__('Left - Main Sidebar', 'wpopal-themer'),
	    'mainright' => esc_html__('Main - Right Sidebar', 'wpopal-themer'),
	    'fullwidth' => esc_html__('Fullwidth', 'wpopal-themer'),

	);

	// 1st meta box
	$meta_boxes[] = array(
		// Meta box id, UNIQUE per meta box. Optional since 4.1.5
		'id'         => 'post_format_standard_post_meta',
		// Meta box title - Will appear at the drag and drop handle bar. Required.
		'title'      => esc_html__( 'Format Setting', 'wpopal-themer' ),
		// Post types, accept custom post types as well - DEFAULT is 'post'. Can be array (multiple post types) or string (1 post type). Optional.
		'post_types' => array(  'post' ),
		// Where the meta box appear: normal (default), advanced, side. Optional.
		'context'    => 'normal',
		// Order of meta box: high (default), low. Optional.
		'priority'   => 'low',
		// Auto save: true, false (default). Optional.
		'autosave'   => true,
		// List of meta fields
		'fields'     => array(
	 	
			// CHECKBOX
			
			array(
				'id'   => "{$prefix}gallery_files",
				'name' => esc_html__( 'Images Gallery', 'wpopal-themer' ),
				'type' => 'file_advanced',
				'description'  => esc_html__( 'Select one or more images to show as gallery', 'wpopal-themer' ),
			),

			array(
				'id'   => "{$prefix}video_link",
				'name' => esc_html__( 'Video Link', 'wpopal-themer' ),
				'type' => 'oembed',
				'description'  => esc_html__( 'Select one or more images to show as gallery', 'wpopal-themer' ),
			),
			
			array(
				'id'   => "{$prefix}link_text",
				'name' => esc_html__( 'Link Text', 'wpopal-themer' ),
				'type' => 'text',
				'description'  => esc_html__( 'Select one or more images to show as gallery', 'wpopal-themer' ),
			), 
			array(
				'id'   => "{$prefix}link_link",
				'name' => esc_html__( 'Link To Redirect', 'wpopal-themer' ),
				'type' => 'text',
				'description'  => esc_html__( 'Select one or more images to show as gallery', 'wpopal-themer' ),
			), 
			 
			array(
				'id'   => "{$prefix}audio_link",
				'name' => esc_html__( 'Audio Link', 'wpopal-themer' ),
				'type' => 'text',
				'description'  => esc_html__( 'Select one or more images to show as gallery', 'wpopal-themer' ),
			),  
		),
		'validation' => array(
			 
		)
	);	
 	 
	return $meta_boxes;
}


function wpopal_themer_fnc_standard_post_meta( $post_id ){
		
	global $post; 
	$prefix = apply_filters( 'wpopal_themer_get_theme_prefix', 'wpopal_themer_' );
	$type = get_post_format();

	$old = array(
		'gallery_files',
		'video_link',
		'link_text',
		'link_link',
		'audio_link',
	);
	
	$data = array( 'gallery' => array('gallery_files'), 
				   'video' =>  array('video_link'), 
				   'audio' =>  array('audio_link'), 
				   'link' => array('link_link','link_text') ); 

	$new = array();

	if( isset($data[$type]) ){
		foreach( $data[$type] as $key => $value ){
			if(isset($_POST[$prefix.$value])){
				$new[$prefix.$value] = $_POST[$prefix.$value];
			}
		}
	}


	foreach( $old as $key => $value ){
		if( isset($_POST[$prefix.$value]) ){
			unset( $_POST[$prefix.$value] );
		}
	}
	if( $new ){
		$_POST = array_merge( $_POST, $new );
	}


}
add_action( "rwmb_post_format_standard_post_meta_before_save_post", 'wpopal_themer_fnc_standard_post_meta' , 9  );

add_filter( 'rwmb_meta_boxes', 'wpopal_themer_fnc_register_postformat_meta_boxes' , 100 );


function wpopal_themer_fnc_register_footer_meta_boxes(  $meta_boxes  ){
	 
	// Better has an underscore as last sign
	$prefix = 'wpopal_themer_';

	$fullwidths = array(
	    'fullwidth' => esc_html__('Fullwidth', 'wpopal-themer'),
	    'boxed' => esc_html__('Boxed', 'wpopal-themer')
	);

	// 1st meta box
	$meta_boxes[] = array(
		// Meta box id, UNIQUE per meta box. Optional since 4.1.5
		'id'         => 'post_format_standard_post_meta',
		// Meta box title - Will appear at the drag and drop handle bar. Required.
		'title'      => esc_html__( 'Format Setting', 'wpopal-themer' ),
		// Post types, accept custom post types as well - DEFAULT is 'post'. Can be array (multiple post types) or string (1 post type). Optional.
		'post_types' => array(  'footer' ),
		// Where the meta box appear: normal (default), advanced, side. Optional.
		'context'    => 'normal',
		// Order of meta box: high (default), low. Optional.
		'priority'   => 'low',
		// Auto save: true, false (default). Optional.
		'autosave'   => true,
		// List of meta fields
		'fields'     => array(
			// CHECKBOX
			array(
				'name'        => esc_html__( 'Layout', 'wpopal-themer' ),
				'id'          => "{$prefix}footerfullwidth",
				'type'        => 'select',
				// Array of 'value' => 'Label' pairs for select box
				'options'     => $fullwidths,
				// Select multiple values, optional. Default is false.
				'multiple'    => false,
				'std'         => '',
			), 
		),
		'validation' => array(
			 
		)
	);	
 	 
	return $meta_boxes;
}

add_filter( 'rwmb_meta_boxes', 'wpopal_themer_fnc_register_footer_meta_boxes' , 100 );