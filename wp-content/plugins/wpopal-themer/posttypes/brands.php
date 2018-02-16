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

if(!function_exists('wpopal_create_type_brands')  ){ 
  function wpopal_create_type_brands(){
    $labels = array(
      'name' => __( 'Brand Logos', "wpopal-themer" ),
      'singular_name' => __( 'Brand', "wpopal-themer" ),
      'add_new' => __( 'Add New Brand', "wpopal-themer" ),
      'add_new_item' => __( 'Add New Brand', "wpopal-themer" ),
      'edit_item' => __( 'Edit Brand', "wpopal-themer" ),
      'new_item' => __( 'New Brand', "wpopal-themer" ),
      'view_item' => __( 'View Brand', "wpopal-themer" ),
      'search_items' => __( 'Search Brands', "wpopal-themer" ),
      'not_found' => __( 'No Brands found', "wpopal-themer" ),
      'not_found_in_trash' => __( 'No Brands found in Trash', "wpopal-themer" ),
      'parent_item_colon' => __( 'Parent Brand:', "wpopal-themer" ),
      'menu_name' => __( 'Brands', "wpopal-themer" ),
    );

    $args = array(
        'labels' => $labels,
        'hierarchical' => true,
        'description' => 'List Brand',
        'supports' => array( 'title', 'thumbnail'),
        'public' => true,
        'show_ui' => true,
        'show_in_menu' => true,
        'menu_position' => 5,
        'show_in_nav_menus' => false,
        'publicly_queryable' => true,
        'exclude_from_search' => false,
        'has_archive' => true,
        'query_var' => true,
        'can_export' => true,
        'rewrite' => true,
        'capability_type' => 'post'
    );
    register_post_type( 'brands', $args );
    
  }

  add_action('init','wpopal_create_type_brands');


///////
function wpopal_func_metaboxes_brands_fields(){
     
     /**
       * prefix of meta keys (optional)
       * Use underscore (_) at the beginning to make keys hidden
       * Alt.: You also can make prefix empty to disable it
       */

         // Better has an underscore as last sign
      $prefix = 'brands_';
      $fields =  array(
     
           // COLOR
          array(
            'name' => __( 'Brand Link', "wpopal-themer" ),
            'id'   => "{$prefix}brand_link",
            'type' => 'text',
            'default' => '#',
            'description' => __('Enter Link To', "wpopal-themer")
          ), 

          
          
        ); 
       return apply_filters( 'wpopal_brand_metaboxes_fields', $fields );
  }

  /**
   *
   */
  function wpopal_themer_func_brand_register_meta_boxes( $meta_boxes ){

      // 1st meta box
      $meta_boxes[] = array(
        // Meta box id, UNIQUE per meta box. Optional since 4.1.5
        'id'         => 'standard',
        // Meta box title - Will appear at the drag and drop handle bar. Required.
        'title'      => __( 'Brand Setting', "wpopal-themer" ),
        // Post types, accept custom post types as well - DEFAULT is 'post'. Can be array (multiple post types) or string (1 post type). Optional.
        'post_types' => array( 'brands' ),
        // Where the meta box appear: normal (default), advanced, side. Optional.
        'context'    => 'normal',
        // Order of meta box: high (default), low. Optional.
        'priority'   => 'low',
        // Auto save: true, false (default). Optional.
        'autosave'   => true,
        // List of meta fields
        'fields'     =>  wpopal_func_metaboxes_brands_fields()
      );


      return $meta_boxes;
  }

  /**
   * Register Metabox 
   */

  add_filter( 'rwmb_meta_boxes', 'wpopal_themer_func_brand_register_meta_boxes', 11);
}
