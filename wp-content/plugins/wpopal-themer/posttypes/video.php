<?php
 /**
  * $Desc
  *
  * @version    $Id$
  * @package    wpbase
  * @author      Team <opalwordpress@gmail.com >
  * @copyright  Copyright (C) 2015  prestabrain.com. All Rights Reserved.
  * @license    GNU/GPL v2 or later http://www.gnu.org/licenses/gpl-2.0.html
  *
  * @website  http://www.wpopal.com
  * @support  http://www.wpopal.com/questions/
  */

if(!function_exists('wpopal_create_type_video')   ){
  function wpopal_create_type_video(){
    $labels = array(
      'name' => __( 'Video', "wpopal-themer" ),
      'singular_name' => __( 'Video', "wpopal-themer" ),
      'add_new' => __( 'Add New Video', "wpopal-themer" ),
      'add_new_item' => __( 'Add New Video', "wpopal-themer" ),
      'edit_item' => __( 'Edit Video', "wpopal-themer" ),
      'new_item' => __( 'New Video', "wpopal-themer" ),
      'view_item' => __( 'View Video', "wpopal-themer" ),
      'search_items' => __( 'Search Videos', "wpopal-themer" ),
      'not_found' => __( 'No Videos found', "wpopal-themer" ),
      'not_found_in_trash' => __( 'No Videos found in Trash', "wpopal-themer" ),
      'parent_item_colon' => __( 'Parent Video:', "wpopal-themer" ),
      'menu_name' => __( 'Videos', "wpopal-themer" ),
    );

    $args = array(
        'labels' => $labels,
        'hierarchical' => true,
        'description' => 'List Video',
        'supports' => array( 'title', 'thumbnail','comments', 'excerpt' ),
        'public' => true,
        'show_ui' => true,
        'show_in_menu' => true,
        'menu_position' => 5,
        'show_in_nav_menus' => true,
        'publicly_queryable' => true,
        'exclude_from_search' => false,
        'has_archive' => true,
        'query_var' => true,
        'can_export' => true,
        'rewrite' => true,
        'capability_type' => 'post'
    );
    register_post_type( 'video', $args );

    $labels = array(
        'name'              => __( 'Categories Video', "wpopal-themer" ),
        'singular_name'     => __( 'Category', "wpopal-themer" ),
        'search_items'      => __( 'Search Category', "wpopal-themer" ),
        'all_items'         => __( 'All Categories', "wpopal-themer" ),
        'parent_item'       => __( 'Parent Category', "wpopal-themer" ),
        'parent_item_colon' => __( 'Parent Category:', "wpopal-themer" ),
        'edit_item'         => __( 'Edit Category', "wpopal-themer" ),
        'update_item'       => __( 'Update Category', "wpopal-themer" ),
        'add_new_item'      => __( 'Add New Category', "wpopal-themer" ),
        'new_item_name'     => __( 'New Category Name', "wpopal-themer" ),
        'menu_name'         => __( 'Categories Video', "wpopal-themer" ),
      );
      // Now register the taxonomy
      register_taxonomy('category_video',array('video'),
          array(
              'hierarchical'      => true,
              'labels'            => $labels,
              'show_ui'           => true,
              'show_admin_column' => true,
              'query_var'         => true,
              'rewrite'           => array( 'slug' => 'video'
          ),
      ));
  }
  add_action( 'init', 'wpopal_create_type_video' );
}


//-- Register metabox
if(!function_exists('wpopal_video_metaboxes_fields')){
  function wpopal_video_metaboxes_fields(){
      $prefix = 'video_';
      $fields =  array(
          array(
            'name' => __( 'Video Link', "wpopal-themer" ),
            'id'   => "{$prefix}video_link",
            'type' => 'text',
            'description' => __('Support Show Video From Youtube and Vimeo', "wpopal-themer")
          ), 
      ); 
      return apply_filters( 'wpopal_video_metaboxes_fields', $fields );
  }
}
if(!function_exists('wpopal_themer_func_video_register_meta_boxes')){
  function wpopal_themer_func_video_register_meta_boxes( $meta_boxes ){
      $meta_boxes[] = array(
        'id'         => 'standard',
        'title'      => __( 'Video Setting', "wpopal-themer" ),
        'post_types' => array( 'video' ),
        'context'    => 'normal',
        'priority'   => 'high',
        'autosave'   => true,
        'fields'     =>  wpopal_video_metaboxes_fields()
      );
      return $meta_boxes;
  }
  add_filter( 'rwmb_meta_boxes', 'wpopal_themer_func_video_register_meta_boxes', 16 );
}


