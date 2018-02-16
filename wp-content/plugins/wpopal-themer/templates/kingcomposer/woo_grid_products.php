<?php 
	$atts  = array_merge( array(
		'per_page'  => 8,
		'columns'	=> 4,
		'type'		=> 'recent_products',
		'category'	=> '',
		'woocategory' => '',
	), $atts); 
	extract( $atts );	
	if( empty($type) ){
		return ;
	}
	if( $columns == 5 ){
		$columns = 4;
	}

	if ( isset($woocategory) && !empty($woocategory) ){
		$categories = wpopal_themer_autocomplete_options_helper( $woocategory );
		$categories = 'category="'.implode( ',', array_keys($categories)).'"'; 
	}else {
		$categories = '';
	}
 
	echo do_shortcode(  '['.$type.' per_page="'.$per_page.'" columns="'.$columns.'" '.$categories.']' );
