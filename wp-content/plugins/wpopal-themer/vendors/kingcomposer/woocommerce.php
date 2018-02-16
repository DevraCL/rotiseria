<?php 
		
	function wpopal_themer_woocommerce_getcategorychilds( $parent_id, $pos, $array, $level, &$select ) {

		for ( $i = 0; $i < count( $array ); $i ++ ) {
		    if ( isset($array[ $i ]) && $array[ $i ]->category_parent == $parent_id ) {
		        $data = array(
		             $array[ $i ]->slug => str_repeat( "- ", $level ) . $array[ $i ]->name,
		        );
		        $select = array_merge( $select, $data );
		        wpopal_themer_woocommerce_getcategorychilds( $array[ $i ]->term_id, $i, $array, $level + 1, $select );
		    }
		}
	}


	add_action('init', 'wpopal_woocommerce_kingcomposer_map', 99 );
 	
 	add_filter( 'kc_autocomplete_woocategory', 'woocommerce_autocomplete_woocategory' );


 	function woocommerce_autocomplete_woocategory( $query ){

 		if( isset($_POST['s']) ){
 			$output = array();
			$vc_taxonomies_types = array('product_cat');
			$search_string = trim( $_POST['s']);  
			$vc_taxonomies = get_terms( 'product_cat', array(
				'hide_empty' => false,
				'search' => $search_string
			) );	 


			if ( is_array( $vc_taxonomies ) && ! empty( $vc_taxonomies ) ) {
				foreach ( $vc_taxonomies as $t ) {
					if ( is_object( $t ) ) {

						$output[] = $t->slug.':'.$t->name;
					}
				}
			}


	 		return array( "Category" =>  $output );
	 	}
 	}

	function wpopal_woocommerce_kingcomposer_map(){
	 	
	    global $kc;
	    
	    $order_by_options = array(
			'',
			'date'     	     =>  esc_html__( 'Date', 'wpopal-themer' ) ,
			'ID'  	    	 =>  esc_html__( 'ID', 'wpopal-themer' ),
			'author'    	 =>  esc_html__( 'Author', 'wpopal-themer' ) ,
			'title'  	  	 =>  esc_html__( 'Title', 'wpopal-themer' ) ,
			'modified'  	 =>  esc_html__( 'Modified', 'wpopal-themer' ),
			'rand'           =>  esc_html__( 'Random', 'wpopal-themer' ),
			'comment_count'  =>  esc_html__( 'Comment count', 'wpopal-themer' ),
			'menu_order'  	 => esc_html__( 'Menu order', 'wpopal-themer' ),
		);

		$order_way_options = array(
			'DESC' =>  esc_html__( 'Descending', 'wpopal-themer' ) ,
			'ASC'  =>  esc_html__( 'Ascending', 'wpopal-themer' ),
		);

		$product_categories_select = array( 'none'=> esc_html__('None', 'wpopal-themer') );
		
		if( is_admin() ){
			$args = array(
				'type' => 'post',
				'child_of' => 0,
				'parent' => '',
				'orderby' => 'name',
				'order' => 'ASC',
				'hide_empty' => false,
				'hierarchical' => 1,
				'exclude' => '',
				'include' => '',
				'number' => '',
				'taxonomy' => 'product_cat',
				'pad_counts' => false,

			);

			$categories = get_categories( $args );
			wpopal_themer_woocommerce_getcategorychilds( 0, 0, $categories, 0, $product_categories_select );
		}
		
		$layout_type = array(
        	'carousel' => esc_html__('Carousel', 'wpopal-themer') ,
        	 'grid' => esc_html__('Grid', 'wpopal-themer') 
    	);
		$product_layouts = array(
        	'grid' 	=> esc_html__('Grid', 'wpopal-themer') ,
        	 'list' => esc_html__('List', 'wpopal-themer') 
    	);
	    ////////// ///
	    $kc->add_map(
	        array(
	            'woo_grid_products' => array(
	                'name' => 'Grid Products',
	                'description' => __('Display Bestseller, Latest, Most Review ... in grid', 'wpopal-themer'),
	                'icon' => 'sl-paper-plane',
	                'category' => 'Woocommerce',

	                'params' => array(
	                	
	                    array(
	                        'name' => 'type',
	                        'label' => 'Product Type',
	                        'type' => 'select',
	                        'admin_label' => true,
                            'options' => array(  // THIS FIELD REQUIRED THE PARAM OPTIONS
						        'recent_products'   	=> __( 'Recent Products', 'wpopal-themer' ),
						        'sale_products' 		=> __( 'Sale Products', 'wpopal-themer' ),
						        'featured_products' 	=> __( 'Featured Products', 'wpopal-themer' ),
						        'best_selling_products'	=> __( 'Best Selling Products', 'wpopal-themer' ),
						        'top_rate'				=> __( 'Top Rate', 'wpopal-themer' ),
						    )
	                    ),
                        array(
							'type'           => 'autocomplete',
							'label'          => __( 'Select Category', 'wpopal-themer' ),
							'name'           => 'woocategory',
							'description'    => __( 'Select Category to display', 'wpopal-themer' ),
							'admin_label'    => true,
							'options' => array( 'category_name' => 'product_cat' )

	                    ),

	                    array(
	                        'name' => 'per_page',
	                        'label' => 'Number post show',
	                        'type' => 'number_slider',
	                        'value' => 10,
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
	                        'label' => __( 'Grid Column' ,'wpopal-themer' ),
	                        'type' => 'number_slider',
	                        'value' => 4,
	                        'options' => array(
	                            'min' => 1,
	                            'max' => 6,
	                            'unit' => '',
	                            'show_input' => true
	                        ),
	                        'description' => 'Display number of post'
	                    ),
	                )
	            )
	        )
	    );
		/// 
		$kc->add_map(
	         array(
	            'woo_carousel_products' => array(
	                'name' => 'Carousel Products',
	                'description' => __('Display Bestseller, Latest, Most Review ... in grid', 'wpopal-themer'),
	                'icon' => 'sl-paper-plane',
	                'category' => 'Woocommerce',

	                'params' => array(
	                    array(
	                        'name' => 'type',
	                        'label' => 'Product Type',
	                        'type' => 'select',
	                        'admin_label' => true,
                            'options' => array(  // THIS FIELD REQUIRED THE PARAM OPTIONS
						        'recent_products'   	=> __( 'Recent Products', 'wpopal-themer' ),
						        'sale_products' 		=> __( 'Sale Products', 'wpopal-themer' ),
						        'featured_products' 	=> __( 'Featured Products', 'wpopal-themer' ),
						        'best_selling_products'	=> __( 'Best Selling Products', 'wpopal-themer' ),
						        'top_rate'				=> __( 'Top Rate', 'wpopal-themer' ),
						    )
	                    ),
                        array(
							'type'           => 'autocomplete',
							'label'          => __( 'Select Category', 'wpopal-themer' ),
							'name'           => 'woocategory',
							'description'    => __( 'Select Category to display', 'wpopal-themer' ),
							'admin_label'    => true,
							'options' => array( 'taxonomy' => 'product_cat' )

	                    ),

	                    array(
	                        'name' => 'number_post',
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
	                        'label' => __( 'Grid Column' ,'wpopal-themer' ),
	                        'type' => 'number_slider',
	                        'value' => 4,
	                        'options' => array(
	                            'min' => 1,
	                            'max' => 6,
	                            'unit' => '',
	                            'show_input' => true
	                        ),
	                        'description' => 'Display number of post'
	                    ),
	                )
	            )
	        )
	    );
		///
		$kc->add_map(
	         array(
	            'woo_deal_products' => array(
	                'name' => 'Deal Products',
	                'description' => __('Display Bestseller, Latest, Most Review ... in grid', 'wpopal-themer'),
	                'icon' => 'sl-paper-plane',
	                'category' => 'Woocommerce',

	                'params' => array(
                        array(
							'type'           => 'autocomplete',
							'label'          => __( 'Select Category', 'wpopal-themer' ),
							'name'           => 'woocategory',
							'description'    => __( 'Select Category to display', 'wpopal-themer' ),
							'admin_label'    => true,
							'options' => array( 'category_name' => 'product_cat' )

	                    ),
	                    array(
	                        'name' => 'number_post',
	                        'label' => 'Number post show',
	                        'type' => 'number_slider',
	                        'value' => 4,
	                        'admin_label'    => true,
	                        'options' => array(
	                            'min' => 1,
	                            'max' => 8,
	                            'unit' => '',
	                            'show_input' => true
	                        ),
	                        'description' => 'Display number of post'
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
	                        'description' => 'Display number of post'
	                    ),
	                )
	            )
	        )
	    );
		//// /// //////
		$kc->add_map(
	         array(
	            'woo_category_products' => array(
	                'name' => 'Category Products',
	                'description' => __('Please select parent of categories', 'wpopal-themer'),
	                'icon' => 'sl-paper-plane',
	                'category' => 'Woocommerce',

	                'params' => array(
              		 array(
						"type" => "textfield",
						"class" => "",
						"label" => esc_html__('Title', 'wpopal-themer'),
						"name" => "title",
						"options"      => '',
					), 	
              		 array(
						'type' => 'autocomplete',
						'label' => esc_html__( 'Category', 'wpopal-themer' ),
						'options' => array( 'category_name' => 'product_cat' ),
						"admin_label" => true,
						'name' => 'woocategory',
						'description' => esc_html__( 'Product category list', 'wpopal-themer' ),
					),
					array(
						 
						'label' => esc_html__( 'Per page', 'wpopal-themer' ),
						 'type' => 'number_slider',
						 'value' => 10,
	                        'options' => array(
	                            'min' => 1,
	                            'max' => 24,
	                            'unit' => '',
	                            'show_input' => true
	                        ),
						'name' => 'per_page',
						'description' => esc_html__( 'How much items per page to show', 'wpopal-themer' ),
					),
					array(
						"type"        => "attach_image",
						"description" => esc_html__("Upload an image for categories (190px x 190px)", 'wpopal-themer'),
						"name"  => "image_cat",
						"options"       => '',
						'label'     => esc_html__('Image', 'wpopal-themer' )
					),
					array(
						'type' => 'textfield',
						'label' => esc_html__( 'Columns', 'wpopal-themer' ),
						 'type' => 'number_slider',
						 'value' => 4,
	                        'options' => array(
	                            'min' => 1,
	                            'max' => 6,
	                            'unit' => '',
	                            'show_input' => true
	                        ),
						'name' => 'columns',
						'description' => esc_html__( 'How much columns grid', 'wpopal-themer' ),
					),
					array(
						'type' => 'select',
						'label' 		=> esc_html__( 'Order by', 'wpopal-themer' ),
						'name' 	=> 'orderby',
						'std' 	  		=> 'date',
						'options' 		=> $order_by_options,
						'description'   => sprintf( esc_html__( 'Select how to sort retrieved products. More at %s.', 'wpopal-themer' ), '<a href="http://codex.wordpress.org/Class_Reference/WP_Query#Order_.26_Orderby_Parameters" target="_blank">WordPress codex page</a>' )
					),
					array(
						'type' => 'select',
						'label' => esc_html__( 'Order way', 'wpopal-themer' ),
						'name' => 'order',
						'std' => 'DESC',
						'options' => $order_way_options,
						'description' => sprintf( esc_html__( 'Designates the ascending or descending order. More at %s.', 'wpopal-themer' ), '<a href="http://codex.wordpress.org/Class_Reference/WP_Query#Order_.26_Orderby_Parameters" target="_blank">WordPress codex page</a>' )
					),
				
					array(
						'type' => 'select',
						'label' => esc_html__( 'Layout Type', 'wpopal-themer' ),
						'name' => 'layout_type',
						'std' => 'carousel',
						'options' => $layout_type,
						'description' => sprintf( esc_html__( 'Select how to sort retrieved products. More at %s.', 'wpopal-themer' ), '<a href="http://codex.wordpress.org/Class_Reference/WP_Query#Order_.26_Orderby_Parameters" target="_blank">WordPress codex page</a>' )
					),
					array(
						"type" => "select",
						"label" => esc_html__("Style",'emarket'),
						"name" => "style",
						"options" => $product_layouts
					),
				)
	            )
	        )
	    );
		//// /// //////
		$kc->add_map(
	         array(
	            'woo_category_subs' => array(
	                'name' => 'Category Subs',
	                'description' => __('Display Sub Category and Couting Products', 'wpopal-themer'),
	                'icon' => 'sl-paper-plane',
	                'category' => 'Woocommerce',

	                "params" => array(
			    
				    	 		array(
									"type" => "select",
									"label" => esc_html__('Category', 'wpopal-themer'),
									"name" => "term_id",
									"options" =>$product_categories_select,	
									"admin_label" => true
								),
								array(
									"type" => "select",
									"label" => esc_html__("Style", 'wpopal-themer'),
									"name" => "style",
									'options' 	=> array(
										'default' => esc_html__('Default', 'wpopal-themer'), 
										 'style1' => esc_html__('style 1', 'wpopal-themer'),
									),
									'std' => ''
								),
								array(
									"type"        => "attach_image",
									"description" => esc_html__("Upload an image for categories (190px x 190px)", 'wpopal-themer'),
									"name"  => "image_cat",
									"options"       => '',
									'label'     => esc_html__('Image', 'wpopal-themer' )
								),

								array(
									"type"       => "textfield",
									"label"    => esc_html__("Number of categories to show",'emarket'),
									"name" => "number",
									"options"   => 5,

								),

								array(
									"type"        => "textfield",
									"label"     => esc_html__("Extra class name",'emarket'),
									"name"  => "el_class",
									"description" => esc_html__("If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.",'emarket')
								)
			   		) 
	              		 
	        ) )
	    );
		//////
		//// /// //////
		$kc->add_map(
	         array(
	            'woo_category_products_v2' => array(
	                'name' => 'Category Products 2',
	                'description' => __('Display Category Banner + Product with latest + special products', 'wpopal-themer'),
	                'icon' => 'sl-paper-plane',
	                'category' => 'Woocommerce',

	           	'params' => array(
	           		array(
						'type' => 'select',
						'label' => esc_html__( 'Category', 'wpopal-themer' ),
						'options' => $product_categories_select,
						"admin_label" => true,
						'name' => 'category',
						'description' => esc_html__( 'Product category list', 'wpopal-themer' ),
					),

					array(
						 
						'label' => esc_html__( 'Per page', 'wpopal-themer' ),
						'type' => 'number_slider',
						'value' => 8,
	                    'options' => array(
		                        'min' => 1,
		                        'max' => 12,
		                        'unit' => '',
		                        'show_input' => true
	                    ),
						'name' => 'per_page',
						'description' => esc_html__( 'How much items per page to show', 'wpopal-themer' ),
					),
					array(
 
						'label' => esc_html__( 'Number sub categories', 'wpopal-themer' ),
						'type' => 'number_slider',
						'value' => 8,
	                    'options' => array(
		                        'min' => 1,
		                        'max' => 12,
		                        'unit' => '',
		                        'show_input' => true
	                    ),
						'name' => 'nb_subcategories',
						'description' => esc_html__( 'How much sub categories to show', 'wpopal-themer' ),
					),
					array(
						"type"        => "attach_image",
						"description" => esc_html__("Upload an image for categories (190px x 190px)", 'wpopal-themer'),
						"name"  => "image_cat",
						"value"       => '',
						'label'     => esc_html__('Image', 'wpopal-themer' )
					),
					array(
					 
						'label' => esc_html__( 'Columns', 'wpopal-themer' ),
				 
						'type' => 'number_slider',
						'value' => 4,
	                    'options' => array(
		                        'min' => 1,
		                        'max' => 6,
		                        'unit' => '',
		                        'show_input' => true
	                    ),
						'name' => 'columns',
						'description' => esc_html__( 'How much columns grid', 'wpopal-themer' ),
					),
					array(
						'type' => 'select',
						'label' => esc_html__( 'Order by', 'wpopal-themer' ),
						'name' => 'orderby',
						'std' => 'date',
						'options' => $order_by_options,
						'description' => sprintf( esc_html__( 'Select how to sort retrieved products. More at %s.', 'wpopal-themer' ), '<a href="http://codex.wordpress.org/Class_Reference/WP_Query#Order_.26_Orderby_Parameters" target="_blank">WordPress codex page</a>' )
					),
					array(
						'type' => 'select',
						'label' => esc_html__( 'Order way', 'wpopal-themer' ),
						'name' => 'order',
						'std' => 'DESC',
						'options' => $order_way_options,
						'description' => sprintf( esc_html__( 'Designates the ascending or descending order. More at %s.', 'wpopal-themer' ), '<a href="http://codex.wordpress.org/Class_Reference/WP_Query#Order_.26_Orderby_Parameters" target="_blank">WordPress codex page</a>' )
					),
					
					
					array(
						'type' => 'select',
						'label' => esc_html__( 'Style', 'wpopal-themer' ),
						'options' => $product_layouts,
						"admin_label" => true,
						'name' => 'style'
					),
					array(
						'type' => 'select',
						'label' => esc_html__( 'Layout Type', 'wpopal-themer' ),
						'name' => 'layout_type',
						'std' => 'carousel',
						'options' => $layout_type,
						'description' => sprintf( esc_html__( 'Select how to sort retrieved products. More at %s.', 'wpopal-themer' ), '<a href="http://codex.wordpress.org/Class_Reference/WP_Query#Order_.26_Orderby_Parameters" target="_blank">WordPress codex page</a>' )
					),
				
	              		 
	        ) ))
	    );

	/////
	}  
?>