<?php
	add_action('init', 'fresh_element_kingcomposer_map', 99 );

	function fresh_element_kingcomposer_map(){
		global $kc;

		$maps = array();
		// Degree-360
 		$maps['element_degree_360'] =  array(
				"name"        => esc_html__("Degree-360", 'fresh'),
				"class"       => "",
				"description" => 'Show Degree-360',
				"category"    => esc_html__('Elements', 'fresh'),
				"icon"        => 'kc-icon-gallery',
				"params"      => array(

				array(
					'type'           => 'autocomplete',
					'label'          => esc_html__( 'Select posts', 'fresh' ),
					'name'           => 'product_ids',
					'description'    => esc_html__( 'Select posts to display', 'fresh' ),
					'admin_label'    => true,
					'options' => array(
						'post_type'     => 'product',
					),
					'description' => esc_html__( 'Only get a product for show.', 'fresh' ),
                ),

                array(
					'name' => 'flag',
					'label' => esc_html__( 'Show Images by product', 'fresh' ),
					'type' => 'checkbox',
					'options' => array(
						'yes' =>  esc_html__( 'Yes, Please!', 'fresh' ),
					),
					'description' => esc_html__( 'Are you sure use Images of Product ?', 'fresh' )
				),

		    	array(
					"type"        => "textfield",
					"label"       => esc_html__("Title", 'fresh'),
					"name"        => "title",
					"value"       => '',
					"admin_label" => true
				),
				array(
					"type"        => "textfield",
					"label"       => esc_html__("Prefix Class", 'fresh'),
					"name"        => "class",
					"value"       => '',
					"admin_label" => true
				),
				array(
					"type"        => "attach_images",
					"label"       => esc_html__("Images", 'fresh'),
					"name"        => "images",
					'description' => esc_html__( 'Upload multiple image to the carousel with the SHIFT key holding.', 'fresh' ),
					'admin_label' => true
				),
			  )
		);

		//Grid product
		$maps['woo_grid_products'] =
			array(
	                'name' => 'Grid Products',
	                'description' => esc_html__('Display Bestseller, Latest, Most Review ... in grid', 'fresh'),
	                'icon' => 'sl-paper-plane',
	                'category' => 'Woocommerce',

	                'params' => array(
	                	
	                    array(
	                        'name' => 'type',
	                        'label' => 'Product Type',
	                        'type' => 'select',
	                        'admin_label' => true,
                            'options' => array(  // THIS FIELD REQUIRED THE PARAM OPTIONS
						        'recent_products'   	=> esc_html__( 'Recent Products', 'fresh' ),
						        'sale_products' 		=> esc_html__( 'Sale Products', 'fresh' ),
						        'featured_products' 	=> esc_html__( 'Featured Products', 'fresh' ),
						        'best_selling_products'	=> esc_html__( 'Best Selling Products', 'fresh' ),
						        'products'				=> esc_html__( 'Products', 'fresh' ),
						    )
	                    ),
                        array(
							'type'           => 'autocomplete',
							'label'          => esc_html__( 'Select Category', 'fresh' ),
							'name'           => 'woocategory',
							'description'    => esc_html__( 'Select Category to display', 'fresh' ),
							'admin_label'    => true,
							'options' => array( 'category_name' => 'product_cat' )

	                    ),
	                    array(
	                        'name' => 'layout',
	                        'label' => 'Product layout',
	                        'type' => 'select',
	                        'admin_label' => true,
                            'options' => array(  // THIS FIELD REQUIRED THE PARAM OPTIONS
						        'list_grid'   	=> esc_html__( 'Products List', 'fresh' ),
						        'inner' 		=> esc_html__( 'Products Grid', 'fresh' ),
						    )
	                    ),

	                    array(
	                        'name' => 'per_page',
	                        'label' => 'Number post show',
	                        'type' => 'number_slider',
	                        'options' => array(
	                            'min' => 1,
	                            'max' => 24,
	                            'unit' => '',
	                            'show_input' => true
	                        ),
	                        'description' => 'Display number of post'
	                    ),
	                    array(
	                        'name' => 'columns',
	                        'label' => esc_html__( 'Grid Column' , 'fresh' ),
	                        'type' => 'number_slider',
	                        'options' => array(
	                            'min' => 1,
	                            'max' => 6,
	                            'unit' => '',
	                            'show_input' => true
	                        ),
	                        'description' => 'Display number of post'
	                    ),
	                )
	    );

		//product deals of today
		$maps['woo_products_deals_today'] =
			array(
	                'name' => 'Products Deals of today',
	                'description' => esc_html__('Display list product deals', 'fresh'),
	                'icon' => 'sl-paper-plane',
	                'category' => 'Woocommerce',

	                'params' => array(

	                	array(
							"type" => "textfield",
							"label" => esc_html__("Title", 'fresh'),
							"name" => "title",
							"value" => '',
							"admin_label" => true
						),
	                	
	                    array(
							'type'           => 'autocomplete',
							'label'          => esc_html__( 'Select Category', 'fresh' ),
							'name'           => 'woocategory',
							'description'    => esc_html__( 'Select Category to display', 'fresh' ),
							'admin_label'    => true,
							'options' => array( 'category_name' => 'product_cat' )

	                    ),
	                    array(
	                        'name' => 'main_position',
	                        'label' => 'Select main position',
	                        'type' => 'select',
	                        'admin_label' => true,
                            'options' => array(  // THIS FIELD REQUIRED THE PARAM OPTIONS
						        'left'   	=> esc_html__( 'Left', 'fresh' ),
						        'center' 	=> esc_html__( 'Center', 'fresh' ),
						        'right' 	=> esc_html__( 'Right', 'fresh' ),
						    )
	                    ),
	                )
	    );
		// Featured Box
		$maps['element_featured_box'] =  array(
			'name' => esc_html__( 'Featured Box', 'fresh' ),
			'title' => 'Featured Box',
			'icon' => 'kc-icon-icon',
			'category' => 'Elements',
			'wrapper_class' => 'clearfix',
			'description' => esc_html__( 'Featured box.', 'fresh' ),
			'params' => array(
				array(
					'name' => 'show_image',
					'label' => 'Show Image ?',
					'type' => 'checkbox',
					'value' => 'no',
					'options' => array(
						'yes' => esc_html__('Yes, Please!', 'fresh')
					),
					'description' => esc_html__('If you want more flexible options to display Image instead of icon', 'fresh')
				),
				array(
					'name' => 'featured_image',
					'label' => 'Image',
					'type' => 'attach_image',
					'value' => '',
					'relation' => array(
						'parent' => 'show_image',
						'show_when' => 'yes'
					),
				),

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
					'description' => esc_html__('Enter the font-size of the icon such as: 15px, 1em, etc.', 'fresh')
				),
				array(
					'name'	      => 'icon_color',
					'label'	      => 'Icon Color',
					'type'	      => 'color_picker',
					'admin_label' => true,
					'description' => esc_html__('Color of the icon.', 'fresh')
				),

				array(
					'name'	      => 'title',
					'label'	      => esc_html__('Title', 'fresh'),
					'type'	      => 'text',
					'admin_label' => true,
					'description' => esc_html__('', 'fresh')
				),
				array(
					'name'	      => 'title_color',
					'label'	      => esc_html__('Title Color', 'fresh'),
					'type'	      => 'color_picker',
					'admin_label' => true,
					'description' => esc_html__('Color of the Title.', 'fresh')
				),


				array(
					'name'	      => 'subtitle',
					'label'	      => esc_html__('Sub Title', 'fresh'),
					'type'	      => 'text',
					'admin_label' => true,
					'description' => esc_html__('', 'fresh')
				),
				array(
					'name'	      => 'sub_color',
					'label'	      => 'Sub-Title Color',
					'type'	      => 'color_picker',
					'admin_label' => true,
					'description' => esc_html__('Sub-Title Color.', 'fresh')
				),

				array(
					'name'	  => 'box_style',
					'label'   => esc_html__('Style', 'fresh'), 
					'type'	  => 'select',
					'options' => array(
						'nostyle'    => esc_html__('None', 'fresh'),
						'v1' => esc_html__('Version 1', 'fresh'),
						'v2' => esc_html__('Version 2', 'fresh'),
						'v3' => esc_html__('Version 3', 'fresh'),
						'v4' => esc_html__('Version 4', 'fresh'),
					)
				),

				array(
					'name'	      => 'info',
					'label'	      => esc_html__('Information', 'fresh'),
					'type'	      => 'textarea',
					'admin_label' => true,
					'description' => esc_html__('', 'fresh')
				),
				array(
					'name'	      => 'info_color',
					'label'	      => 'Information Color',
					'type'	      => 'color_picker',
					'admin_label' => true,
					'description' => esc_html__('Information Color.', 'fresh')
				),

				array(
					'name'	      => 'bg_color',
					'label'	      => 'Bg Color',
					'type'	      => 'color_picker',
					'admin_label' => true,
					'description' => esc_html__('Background Color.', 'fresh')
				),

				array(
					'name'	        => 'box_wrap_class',
					'label'	        => 'Wrapper class name',
					'type'	        => 'text',
					'description'   => esc_html__('Enter class name for wrapper', 'fresh'),
				),
             // end params
			)
		);
		$maps = apply_filters( 'fresh_element_kingcomposer_map', $maps );
	    $kc->add_map( $maps );
	} // end class
?>