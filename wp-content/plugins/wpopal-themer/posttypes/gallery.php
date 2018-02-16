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
if(!function_exists('wpopal_create_type_gallery')   ){
    function wpopal_create_type_gallery(){
      $labels = array(
          'name'               => __( 'Galleries', "wpopal-themer" ),
          'singular_name'      => __( 'Gallery', "wpopal-themer" ),
          'add_new'            => __( 'Add New Gallery', "wpopal-themer" ),
          'add_new_item'       => __( 'Add New Gallery', "wpopal-themer" ),
          'edit_item'          => __( 'Edit Gallery', "wpopal-themer" ),
          'new_item'           => __( 'New Gallery', "wpopal-themer" ),
          'view_item'          => __( 'View Gallery', "wpopal-themer" ),
          'search_items'       => __( 'Search Galleries', "wpopal-themer" ),
          'not_found'          => __( 'No Galleries found', "wpopal-themer" ),
          'not_found_in_trash' => __( 'No Galleries found in Trash', "wpopal-themer" ),
          'parent_item_colon'  => __( 'Parent Gallery:', "wpopal-themer" ),
          'menu_name'          => __( 'Galleries', "wpopal-themer" ),
      );

      $args = array(
          'labels'              => $labels,
          'hierarchical'        => false,
          'description'         => 'List Gallery',
          'supports'            => array( 'title', 'editor', 'author', 'thumbnail','excerpt','custom-fields' ), //page-attributes, post-formats
          'taxonomies'          => array( 'gallery_category' ),
          'public'              => true,
          'show_ui'             => true,
          'show_in_menu'        => true,
          'menu_position'       => 5,
          'menu_icon'           => '',
          'show_in_nav_menus'   => false,
          'publicly_queryable'  => true,
          'exclude_from_search' => false,
          'has_archive'         => true,
          'query_var'           => true,
          'can_export'          => true,
          'rewrite'             => array('slug'=>'gallery'),
          'capability_type'     => 'post',
      );
      register_post_type( 'gallery', $args );

      //Add Port folio Skill
      // Add new taxonomy, make it hierarchical like categories
      //first do the translations part for GUI
      $labels = array(
        'name'              => __( 'Categories', "wpopal-themer" ),
        'singular_name'     => __( 'Category', "wpopal-themer" ),
        'search_items'      => __( 'Search Category', "wpopal-themer" ),
        'all_items'         => __( 'All Categories', "wpopal-themer" ),
        'parent_item'       => __( 'Parent Category', "wpopal-themer" ),
        'parent_item_colon' => __( 'Parent Category:', "wpopal-themer" ),
        'edit_item'         => __( 'Edit Category', "wpopal-themer" ),
        'update_item'       => __( 'Update Category', "wpopal-themer" ),
        'add_new_item'      => __( 'Add New Category', "wpopal-themer" ),
        'new_item_name'     => __( 'New Category Name', "wpopal-themer" ),
        'menu_name'         => __( 'Categories', "wpopal-themer" ),
      );
      // Now register the taxonomy
      register_taxonomy('gallery_category',array('gallery'),
          array(
              'hierarchical'      => true,
              'labels'            => $labels,
              'show_ui'           => true,
              'show_admin_column' => true,
              'query_var'         => true,
              'show_in_nav_menus' => false,
              'rewrite'           => array( 'slug' => 'gallery-category'
          ),
      ));



      

  }
  add_action( 'init','wpopal_create_type_gallery' );
}