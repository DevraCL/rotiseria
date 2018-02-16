<?php 
	
	/**
	 * Posttype Team
	 */
	if( function_exists("wpopal_create_type_team") ){ 
		add_action('init', 'wpopal_posttype_team_kingcomposer_map', 99 );
	 
		function wpopal_posttype_team_kingcomposer_map(){
			global $kc;

			$maps = array(); 

			$maps['element_posttype_our_team'] =  array(
		          "name" => __("Team Grid (From Team Source)", 'wpopal-themer'),
		          'icon' => 'sl-paper-plane',
		          "class" => "",
		          "description" => 'Get data from post type Team',
		          "category" => __('Elements', 'wpopal-themer'),
		          "params" => array(
		            array(
		            "type" => "textfield",
		            "label" => __("Title", 'wpopal-themer'),
		            "name" => "title",
		            "value" => '',
		            "admin_label" => true
		          ),
		           array(
						'name' => 'items',
						'label' => __( 'Items Limit', 'wpopal-themer' ),
						'type' => 'number_slider',
						'value' => '5',
						'options' => array(
							'min' => 1,
							'max' => 16,
							'unit' => '',
							'show_input' => false
						),
						"admin_label" => true,
						'description' => __('Specify number of post that you want to show. Enter -1 to get all team', 'wpopal-themer'),
					),
		          	array(
	                    'name' => 'columns',
	                    'label' => __( 'Grid Column' ,'wpopal-themer' ),
	                    'type' => 'number_slider',
	                    'value' => 4,
	                    'options' => array(
	                        'min' => 1,
	                        'max' => 6,
	                        'unit' => '',
	                        'show_input' => true
	                    ),
	                    "admin_label" => true,
	                    'description' => 'Display number of post'
	                ),   
		          	array(
		                  "type" => "textfield",
		                  "label" => __("Extra class name", 'wpopal-themer'),
		                  "name" => "el_class",
		                  "description" => __("If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.", 'wpopal-themer')
		         	)
		        )
		    ) ;

			$maps = apply_filters( 'wpopal_posttype_team_kingcomposer_map', $maps ); 
	    	$kc->add_map( $maps );

		}

	}	

	/**
	 * Testimonials
	 */

	if( function_exists("wpopal_create_type_testimonial") ){
		add_action('init', 'wpopal_posttype_testimonialkingcomposer_map', 99 );
		function wpopal_posttype_testimonialkingcomposer_map(){
			global $kc;
			$maps = array();
			$maps['element_testimonials'] = array(
	                "name" => __("Testimonials", 'wpopal-themer'),
	                'icon' => 'sl-paper-plane',
	                'description'=> __('Play Testimonials In Carousel', 'wpopal-themer'),
	                "class" => "",
	                "category" => __('Elements', 'wpopal-themer'),
	                "params" => array(
	                  array(
	                  "type" => "textfield",
	                  "label" => __("Title", 'wpopal-themer'),
	                  "name" => "title",
	                  "admin_label" => true,
	                  "value" => '',
	                    "admin_label" => true
	                ),
	                array(
						'name' => 'items',
						'label' => __( 'Items Limit', 'wpopal-themer' ),
						'type' => 'number_slider',
						'value' => '5',
						'options' => array(
							'min' => 1,
							'max' => 16,
							'unit' => '',
							'show_input' => true
						),
						"admin_label" => true,
						'description' => __('Specify number of post that you want to show. Enter -1 to get all team', 'wpopal-themer'),
					),
	                array(
	                    'name' => 'columns',
	                    'label' => __( 'Grid Column' ,'wpopal-themer' ),
	                    'type' => 'number_slider',
	                    'value' => 4,
	                    'options' => array(
	                        'min' => 1,
	                        'max' => 6,
	                        'unit' => '',
	                        'show_input' => true
	                    ),
	                    "admin_label" => true,
	                    'description' => 'Display number of post'
	                ), 
	                array(
	                  "type" => "select",
	                  "label" => __("Skin", 'wpopal-themer'),
	                  "name" => "skin",
	                  "options" => array('left' => 'Version Style left', 'v1' => 'Version Style 1' , 'v2' => 'Version Style 2', 'v3'=> 'Version Style 3'),
	                  "admin_label" => true,
	                  "description" => __("Select Skin layout.", 'wpopal-themer')
	                ),
	                array(
		                  "type" => "textfield",
		                  "label" => __("Extra class name", 'wpopal-themer'),
		                  "name" => "el_class",
		                  "description" => __("If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.", 'wpopal-themer')
		                )
	                )
	        );
			$maps = apply_filters( 'wpopal_posttype_team_kingcomposer_map', $maps ); 
			$kc->add_map( $maps );
		}
	}


	/**
	 * Brands 
	 */
	if( function_exists("wpopal_create_type_brands") ){

		add_action('init', 'wpopal_posttype_brands_kingcomposer_map', 99 );
		function wpopal_posttype_brands_kingcomposer_map(){   
			global $kc; 

			$maps['element_brands'] = array(
				"name" 		  => __("Brands Carousel", 'wpopal-themer'),
				'description' =>'Show Brand Logos, Manufacture Logos From Source: Brands',
				'icon' => 'sl-paper-plane',
				"category"    => __('Elements', 'wpopal-themer'),
				"params" 	  => array(
				    array(
						'name' => 'items',
						'label' => __( 'Items Limit', 'wpopal-themer' ),
						'type' => 'number_slider',
						'value' => '5',
						'admin_label' => 'true',
						'options' => array(
							'min' => 1,
							'max' => 16,
							'unit' => '',
							'show_input' => false
						),
						"admin_label" => true,
						'description' => __('Specify number of post that you want to show. Enter -1 to get all team', 'wpopal-themer'),
					),
				  	array(
				        'name' => 'columns',
				        'label' => __( 'Grid Column' ,'wpopal-themer' ),
				        'type' => 'number_slider',
				        'admin_label' => 'true',
				        'value' => 4,
				        'options' => array(
				            'min' => 1,
				            'max' => 6,
				            'unit' => '',
				            'show_input' => false
				        ),
				        "admin_label" => true,
				        'description' => 'Display number of post'
				    ), 
				    
				    array(
				        "type" => "textfield",
				        "label" => __("Extra class name", 'wpopal-themer'),
				        "name" => "el_class",
				        "description" => __("If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.", 'wpopal-themer')
				    )
				)		    
			);
			$maps = apply_filters( 'wpopal_posttype_brands_kingcomposer_map', $maps ); 
		    $kc->add_map( $maps );	
		}
	}

	/**
	 * Portfolio
	 */
	if( function_exists("wpopal_create_type_portfolio") ){	
		
		add_action('init', 'wpopal_posttype_portfolio_kingcomposer_map', 99 );
	   
	    function wpopal_posttype_portfolio_kingcomposer_map(){ 

	        global $kc; 
			
			$maps['element_portfolios'] =array(
	              "name" 		=> __("Portfolio", 'wpopal-themer'),
	              'icon' 		=> 'sl-paper-plane',
 
	              'description' =>'Portfolio',
	 
	              "category" 	=> __('Elements', 'wpopal-themer'),
	              "params" => array(
	                    array(
	                        "type"  => "textfield",
	                        "label" => __("Title", 'wpopal-themer'),
	                        "name"  => "title",
	                        "value" => '',
	                        "admin_label" => true
	                    ),
	                    array(
	                        "type" => "editor",
	                        'label' => __( 'Description', 'wpopal-themer' ),
	                        "name" => "description",
	                        "value" => ''
	                    ),

	                    array(
                            "type"  => "radio",
                            "label" => __("Item No Padding", 'wpopal-themer'),
                            "name"  => "nopadding",
                           'options' => array(
	                        	0 => __( 'No', 'wpopal-themer' ),
	                          	1 => __( 'Yes', 'wpopal-themer' ),
	                        ),
                            'std'   => true
	                    ),  
	                    array(
	                        'type' => 'select',
	                        'label' => __( 'Display Masonry', 'wpopal-themer' ),
	                        'name' => 'masonry',
	                        'options' => array(
	                        	0 => __( 'No', 'wpopal-themer' ),
	                          	1 => __( 'Yes', 'wpopal-themer' ),
	                        )
	                    ),
						array(
							'name' => 'items',
							'label' => __( 'Items Limit', 'wpopal-themer' ),
							'type' => 'number_slider',
							'value' => '5',
							'admin_label' => 'true',
							'options' => array(
								'min' => 1,
								'max' => 16,
								'unit' => '',
								'show_input' => false
							),
							"admin_label" => true,
							'description' => __('Specify number of post that you want to show. Enter -1 to get all team', 'wpopal-themer'),
						),

						array(
							'name' => 'columns',
							'label' => __( 'Grid Column' ,'wpopal-themer' ),
							'type' => 'number_slider',
							'value' => 4,
							'admin_label' => 'true',
							'options' => array(
								'min' => 1,
								'max' => 6,
								'unit' => '',
								'show_input' => true
							),
							"admin_label" => true,
							'description' => 'Display number of post'
						), 

						array(
							'type' 		  => 'select',
							'label' 	  => __( 'Enable Pagination', 'wpopal-themer' ),
							'name' 		  => 'pagination',
							'options' => array(
	                        	false => __( 'No', 'wpopal-themer' ),
	                          	true => __( 'Yes', 'wpopal-themer' ),
	                        ),
							'std' 		  => 0,
							'description' => __( 'Select style display.', 'wpopal-themer' )
						)
			
	              ) ); 
	        $maps = apply_filters( 'wpopal_posttype_portfolio_kingcomposer_map', $maps ); 
		    $kc->add_map( $maps );	
	    }  
	}                 
?>