<?php 

	add_action('init', 'wpopal_element_kingcomposer_map', 99 );
 
	function wpopal_element_kingcomposer_map(){
		global $kc;

		$maps = array(); 

		/**
		 * Revolutions slider 
		 */
		if( class_exists("RevSlider") ){
			
			$revsliders = array();
			
			if( is_admin() ){
				$slider = new RevSlider();
				$arrSliders = $slider->getArrSliders();

				if ( $arrSliders ) {
					foreach ( $arrSliders as $slider ) {
						/** @var $slider RevSlider */
						$revsliders[$slider->getAlias()] = $slider->getTitle();
					}
				} else {
					$revsliders[ __( 'No sliders found', 'wpopal-themer' ) ] = 0;
				}
			}	
			$maps['element_revolution_slider'] =  array(
				'name' => __( 'Revolution Slider', 'wpopal-themer' ),
				'title' => 'Display revolution Slider',
				'icon' => 'fa fa-newspaper-o',
				'category' => 'Elements',
				'wrapper_class' => 'clearfix',
				'description' => __( 'Display revolution Slider.', 'wpopal-themer' ),
				'params' => array(

					array(
						'type'			=> 'dropdown',
						'label'			=> __( 'Slider', 'wpopal-themer' ),
						'name'			=> 'alias',
						'description'	=> __( '', 'wpopal-themer' ),
						'admin_label'	=> true,
						'options' 		=> $revsliders
					),
					 
					array(
						'type'  => 'text',
						'label' => __( 'Extra Class', 'wpopal-themer' ),
						'name'  => 'class',
						'value' => '',
					),
					 
				)
			);
 	
		}
		/*********************************************************************************************************************
		 * Pricing Table
 		 *********************************************************************************************************************/


		$maps[  'element_pricing_table' ] =  array(
		    "name" => esc_html__("Pricing Table",'wpopal-themer'),
		    "description" => esc_html__('Make Plan for membership', 'wpopal-themer' ),
		    'icon' => 'sl-paper-plane',
		    'category' => 'Elements',
		    "params" => array(
		    	array(
					"type" => "textfield",
					"label" => esc_html__("Title", 'wpopal-themer'),
					"name" => "title",
					"value" => '',
					"admin_label" => true
				),
				array(
					"type" => "textfield",
					"label" => esc_html__("Price", 'wpopal-themer'),
					"name" => "price",
					"value" => '',
					'description'	=> ''
				),
				array(
					"type" => "textfield",
					"label" => esc_html__("Currency", 'wpopal-themer'),
					"name" => "currency",
					"value" => '',
					'description'	=> ''
				),
				array(
					"type" => "textfield",
					"label" => esc_html__("Period", 'wpopal-themer'),
					"name" => "period",
					"value" => '',
					'description'	=> ''
				),
				array(
					"type" => "textfield",
					"label" => esc_html__("Subtitle", 'wpopal-themer'),
					"name" => "subtitle",
					"value" => '',
					'description'	=> ''
				),
				array(
					"type" => "select",
					"label" => esc_html__("Is Featured", 'wpopal-themer'),
					"name" => "featured",
					'options' 	=> array( 
						0 => esc_html__('No', 'wpopal-themer') ,
						1 => esc_html__('Yes', 'wpopal-themer') 
					),
				),
				array(
					"type" => "select",
					"label" => esc_html__("Skin", 'wpopal-themer'),
					"name" => "skin",
					'options' 	=> array( 
						'v1' => esc_html__('Skin 1', 'wpopal-themer'), 
						'v2' => esc_html__('Skin 2', 'wpopal-themer'), 
						'v3' => esc_html__('Skin 3', 'wpopal-themer')
					),
				),
				array(
					"type" => "select",
					"label" => esc_html__("Box Style", 'wpopal-themer'),
					"name" => "style",
					'options' 	=> array( 'boxed' => esc_html__('Boxed', 'wpopal-themer')),
				),

				array(
					"type" => "editor",
					"label" => esc_html__("Content", 'wpopal-themer'),
					"name" => "content_html",
					"value" => '',

					'description'	=> esc_html__('Allow  put html tags', 'wpopal-themer')
				),

				array(
					"type" => "textfield",
					"label" => esc_html__("Link Title", 'wpopal-themer'),
					"name" => "linktitle",
					"value" => 'SignUp',
					'description'	=> ''
				),

				array(
					"type" => "textfield",
					"label" => esc_html__("Link", 'wpopal-themer'),
					"name" => "link",
					"value" => 'http://yourdomain.com',
					'description'	=> ''
				),
				array(
					"type" => "textfield",
					"label" => esc_html__("Extra class name", 'wpopal-themer'),
					"name" => "el_class",
					"description" => esc_html__("If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.", 'wpopal-themer')
				)
		   	)
		);
		
		$maps['element_blog_posts'] =  array(
			'name' => __( 'Blog Posts', 'wpopal-themer' ),
			'title' => 'Blog Posts Settings',
			'icon' => 'fa fa-newspaper-o',
			'category' => 'Elements',
			'wrapper_class' => 'clearfix',
			'description' => __( 'List of latest post with more layouts.', 'wpopal-themer' ),
			'params' => array(
                array(
                    'name' => 'columns',
                    'label' => __( 'Grid Column' ,'wpopal-themer' ),
                    'type' => 'number_slider',
                    'value' => 3,
                    'options' => array(
                        'min' => 1,
                        'max' => 5,
                        'unit' => '',
                        'show_input' => true
                    ),
                    "admin_label" => true,
                    'description' => 'Display number of post'
                ),    
				array(
					'name' => 'items',
					'label' => __( 'Items Limit', 'wpopal-themer' ),
					'type' => 'number_slider',
					'value' => '5',
					'options' => array(
						'min' => 1,
						'max' => 10,
						'unit' => '',
						'show_input' => false
					),
					"admin_label" => true,
					'description' => __('Specify number of post that you want to show. Enter -1 to get all team', 'wpopal-themer'),
				),
			 
				array(
					'type'			=> 'dropdown',
					'label'			=> __( 'Order by', 'wpopal-themer' ),
					'name'			=> 'order_by',
					'description'	=> __( '', 'wpopal-themer' ),
					'admin_label'	=> true,
					'options' 		=> array(
						'ID'		=> __('Post ID', 'wpopal-themer'),
						'author'	=> __('Author', 'wpopal-themer'),
						'title'		=> __('Title', 'wpopal-themer'),
						'name'		=> __('Post name (post slug)', 'wpopal-themer'),
						'type'		=> __('Post type (available since Version 4.0)', 'wpopal-themer'),
						'date'		=> __('Date', 'wpopal-themer'),
						'modified'	=> __('Last modified date', 'wpopal-themer'),
						'rand'		=> __('Random order', 'wpopal-themer'),
						'comment_count'	=> __('Number of comments', 'wpopal-themer')
					)
				),
				array(
					'type' => 'select',
					'label' => __( 'Order By', 'wpopal-themer' ),
					'name' => 'order',
					'options' => array(
						'DESC' => __( 'Descending', 'wpopal-themer' ),
						'ASC' => __( 'Ascending', 'wpopal-themer' )
					),
					'description' => ' &nbsp; '
				),
			
				array(
					'type'  => 'text',
					'label' => __( 'Extra Class', 'wpopal-themer' ),
					'name'  => 'class',
					'value' => '',
				),
				array(
					'name' => 'blog_style',
					'label' => __( 'Blog Style', 'wpopal-themer' ),
					'type' => 'select',
					'value' => 'show',
					'description' => __('Blog styles.', 'wpopal-themer'),
					'options' =>  wpopal_themer_get_content_blog_layouts() ,
				)
			)
		);
 	

 		$maps['element_our_team'] =  array(
		    "name" => esc_html__("Our Team Grid Style", 'wpopal-themer'),
		    "base" => "pbr_team",
		    "class" => "",
		    "description" => 'Show Personal Profile Info',
		    "category" => esc_html__('Elements', 'wpopal-themer'),
		    "params" => array(
		    	array(
					"type" => "textfield",
					"label" => esc_html__("Title", 'wpopal-themer'),
					"name" => "title",
					"value" => '',
					"admin_label" => true
				),
				array(
					"type" => "attach_image",
					"label" => esc_html__("Photo", 'wpopal-themer'),
					"name" => "photo",
					"value" => '',
					'description'	=> ''
				),
				array(
					"type" => "textfield",
					"label" => esc_html__("Job", 'wpopal-themer'),
					"name" => "job",
					"value" => 'CEO',
					'description'	=>  ''
				),
				array(
					"type" => "textfield",
					"label" => esc_html__("Link Job", 'wpopal-themer'),
					"name" => "link_job",
					"value" => '',
					'description'	=>  ''
				),
				array(
					"type" => "editor",
					"label" => esc_html__("information", 'wpopal-themer'),
					"name" => "information",
					"value" => '',
					'description'	=> esc_html__('Allow  put html tags', 'wpopal-themer')
				),
				array(
					"type" => "textfield",
					"label" => esc_html__("Phone", 'wpopal-themer'),
					"name" => "phone",
					"value" => '',
					'description'	=> ''
				),
				array(
					"type" => "textfield",
					"label" => esc_html__("Google Plus", 'wpopal-themer'),
					"name" => "google",
					"value" => '',
					'description'	=> ''
				),
				array(
					"type" => "textfield",
					"label" => esc_html__("Facebook", 'wpopal-themer'),
					"name" => "facebook",
					"value" => '',
					'description'	=> ''
				),

				array(
					"type" => "textfield",
					"label" => esc_html__("Twitter", 'wpopal-themer'),
					"name" => "twitter",
					"value" => '',
					'description'	=> ''
				),

				array(
					"type" => "textfield",
					"label" => esc_html__("Pinterest", 'wpopal-themer'),
					"name" => "pinterest",
					"value" => '',
					'description'	=> ''
				),

				array(
					"type" => "textfield",
					"label" => esc_html__("Linked In", 'wpopal-themer'),
					"name" => "linkedin",
					"value" => '',
					'description'	=> ''
				),

				array(
					"type" => "select",
					"label" => esc_html__("Style", 'wpopal-themer'),
					"name" => "style",
					'options' 	=> array(  'default' => esc_html__('Default', 'wpopal-themer'), 'other-team' => esc_html__('Other Team', 'wpopal-themer'), 'other-team v2'  => esc_html__('Other Team v2', 'wpopal-themer') ),
				),

				array(
					"type" => "textfield",
					"label" => esc_html__("Extra class name", 'wpopal-themer'),
					"name" => "el_class",
					"description" => esc_html__("If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.", 'wpopal-themer')
				)
		   )
		) ;

		// Featured Box
		$maps['element_featured_box'] =  array(
			'name' => __( 'Featured Box', 'wpopal-themer' ),
			'title' => 'Featured Box',
			'icon' => 'kc-icon-icon',
			'category' => 'Elements',
			'wrapper_class' => 'clearfix',
			'description' => __( 'Featured box.', 'wpopal-themer' ),
			'params' => array(
			    array(
					'name'	      => 'icon',
					'label'	      => 'Select Icon',
					'type'	      => 'icon_picker',
					'admin_label' => true,
				),

				array(
					'name'	      => 'icon_size',
					'label'	      => 'Icon Size',
					'type'	      => 'text',
					'admin_label' => true,
					'description' => __('Enter the font-size of the icon such as: 15px, 1em, etc.', 'wpopal-themer')
				),
				array(
					'name'	      => 'icon_color',
					'label'	      => 'Icon Color',
					'type'	      => 'color_picker',
					'admin_label' => true,
					'description' => __('Color of the icon.', 'wpopal-themer')
				),

				array(
					'name'	      => 'title',
					'label'	      => __('Title', 'wpopal-themer'),
					'type'	      => 'text',
					'admin_label' => true,
					'description' => __('', 'wpopal-themer')
				),
				array(
					'name'	      => 'title_color',
					'label'	      => __('Title Color', 'wpopal-themer'),
					'type'	      => 'color_picker',
					'admin_label' => true,
					'description' => __('Color of the Title.', 'wpopal-themer')
				),
				array(
					'name'	      => 'subtitle',
					'label'	      => __('Sub Title', 'wpopal-themer'),
					'type'	      => 'text',
					'admin_label' => true,
					'description' => __('', 'wpopal-themer')
				),
				array(
					'name'	  => 'box_style',
					'label'   => __('Style', 'wpopal-themer'), 
					'type'	  => 'select',
					'options' => array(
						'nostyle'    => __('None', 'wpopal-themer'),
						'v1' => __('Version 1', 'wpopal-themer'),
						'v2' => __('Version 2', 'wpopal-themer'),
						'v3' => __('Version 3', 'wpopal-themer'),
						'v4' => __('Version 4', 'wpopal-themer'),
					)
				),
				array(
					'name'	      => 'info',
					'label'	      => __('Information', 'wpopal-themer'),
					'type'	      => 'textarea',
					'admin_label' => true,
					'description' => __('', 'wpopal-themer')
				),

				array(
					'name'	        => 'box_wrap_class',
					'label'	        => 'Wrapper class name',
					'type'	        => 'text',
					'description'   => __('Enter class name for wrapper', 'wpopal-themer'),
				),
             // end params
			)
		);
		


		$maps = apply_filters( 'wpopal_element_kingcomposer_map', $maps ); 
	    $kc->add_map( $maps );
	}

// add map param
add_action('init', 'wpopal_kc_single_image_add_map_param', 99 );
function wpopal_kc_single_image_add_map_param(){
    global $kc;
    $kc->add_map_param(
    	'kc_single_image',
        array(
			'name'    => 'image_effect',
			'label'   => 'Image Effect',
			'type'    => 'select',
			'options' => array(
				'effect-default'  => __('Default', 'wpopal-themer'),
				'effect-v1'  => __('Effect v1', 'wpopal-themer'),
				'effect-v2'  => __('Effect v2', 'wpopal-themer'),
				'effect-v3'  => __('Effect v3', 'wpopal-themer'),
				'effect-v4'  => __('Effect v4', 'wpopal-themer'),
				'effect-v5'  => __('Effect v5', 'wpopal-themer'),
				'effect-v6'  => __('Effect v6', 'wpopal-themer'),
				'effect-v7'  => __('Effect v7', 'wpopal-themer'),
				'effect-v8'  => __('Effect v8', 'wpopal-themer'),
				'effect-v9'  => __('Effect v9', 'wpopal-themer'),
				'effect-v10' => __('Effect v10','KingComposer')
			),
			'description' => __('Select the image effect.', 'wpopal-themer'),
			'relation' => array(
				'parent' => 'image_effect_option',
				'show_when' => 'yes'
			),
		)
    , 5);

    $kc->add_map_param(
    	'kc_single_image',
	        array(
				'name' => 'image_effect_option',
				'label' => 'Image Effect?',
				'type' => 'checkbox',
				'description' => __('Disable Image Effect.', 'wpopal-themer'),
				'value' => 'yes',
				'options' => array(
					'yes' => 'Yes, Please!'
				),
			)
    , 5);
    

}


