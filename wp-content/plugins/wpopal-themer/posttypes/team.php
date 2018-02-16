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
if ( class_exists( 'RWMB_Field' ) ) {  

  class RWMB_skills_Field extends RWMB_Field
  {
      /**
       * Get field HTML
       *
       * @param mixed $meta
       * @param array $field
       *
       * @return string
       */
      static public function html( $meta, $field )
      {
          return sprintf(
            '<input type="tel" name="%s" id="%s" value="%s" pattern="\d{3}-\d{4}">',
            $field['field_name'],
            $field['id'],
            $meta
          );
      }
  }
}

if(!function_exists('wpopal_create_type_team')   ){ 
    function wpopal_create_type_team(){
      $labels = array(
        'name' => __( 'Team', "wpopal-themer" ),
        'singular_name' => __( 'Team', "wpopal-themer" ),
        'add_new' => __( 'Add New Team', "wpopal-themer" ),
        'add_new_item' => __( 'Add New Team', "wpopal-themer" ),
        'edit_item' => __( 'Edit Team', "wpopal-themer" ),
        'new_item' => __( 'New Team', "wpopal-themer" ),
        'view_item' => __( 'View Team', "wpopal-themer" ),
        'search_items' => __( 'Search Teams', "wpopal-themer" ),
        'not_found' => __( 'No Teams found', "wpopal-themer" ),
        'not_found_in_trash' => __( 'No Teams found in Trash', "wpopal-themer" ),
        'parent_item_colon' => __( 'Parent Team:', "wpopal-themer" ),
        'menu_name' => __( 'Teams', "wpopal-themer" ),
      );

      $args = array(
          'labels' => $labels,
          'hierarchical' => false,
          'description' => 'List Team',
          'supports' => array( 'title', 'editor', 'thumbnail','excerpt'),
          'public' => true,
          'show_ui' => true,
          'show_in_menu' => true,
          'menu_position' => 5,
          'show_in_nav_menus' => false,
          'publicly_queryable' => true,
          'exclude_from_search' => true,
          'has_archive' => true,
          'query_var' => true,
          'can_export' => true,
          'rewrite' => true,
          'capability_type' => 'post'
      );
      register_post_type( 'team', $args );

      $labels = array(
        'name'              => __( 'Teacher Categories', "wpopal-themer" ),
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
      register_taxonomy('category_teachers',array('team'),
          array(
              'hierarchical'      => true,
              'labels'            => $labels,
              'show_ui'           => true,
              'show_admin_column' => true,
              'query_var'         => true,
              'show_in_nav_menus' =>true,
              'rewrite'           => array( 'slug' => 'team-category'
          ),
      ));



}

add_action( 'init','wpopal_create_type_team' );




function wpopal_func_metaboxes_team_fields(){
     /**
       * prefix of meta keys (optional)
       * Use underscore (_) at the beginning to make keys hidden
       * Alt.: You also can make prefix empty to disable it
       */

         // Better has an underscore as last sign
      $prefix = 'team_';
      $fields =  array(
          array(
            'name' => __( 'Job', "wpopal-themer" ),
            'id'   => "{$prefix}job",
            'type' => 'text',
            'description' => __('Enter Job example CEO, CTO', "wpopal-themer")
          ), 

          array(
            'name'             => __( 'Address', "wpopal-themer" ),
            'id'               => "{$prefix}address",
            'type'             => 'textarea',
            'cols'             => '30'
          ),

          array(
            'name'             => __( 'Phone Number', "wpopal-themer" ),
            'id'               => "{$prefix}phone_number",
            'type'             => 'text',
          ),

          array(
            'name'             => __( 'Mobile Number', "wpopal-themer" ),
            'id'               => "{$prefix}mobile",
            'type'             => 'text',
          ),

          array(
            'name'             => __( 'Fax Number', "wpopal-themer" ),
            'id'               => "{$prefix}fax",
            'type'             => 'text',
          ),

          array(
            'name'             => __( 'Email', "wpopal-themer" ),
            'id'               => "{$prefix}email",
            'type'             => 'text',
          ),

          array(
            'name'             => __( 'Web', "wpopal-themer" ),
            'id'               => "{$prefix}web",
            'type'             => 'text',
          ),

          array(
            'name' => __( 'Google Plus Link', "wpopal-themer" ),
            'id'   => "{$prefix}google",
            'type' => 'text',
            'description' => __('Enter google', "wpopal-themer")
          ), 

          array(
            'name' => __( 'Facebook Link', "wpopal-themer" ),
            'id'   => "{$prefix}facebook",
            'type' => 'text',
            'description' => __('Enter facebook', "wpopal-themer")
          ), 

          array(
            'name' => __( 'Twitter', "wpopal-themer" ),
            'id'   => "{$prefix}twitter",
            'type' => 'text',
            'description' => __('Enter Twitter', "wpopal-themer")
          ), 

          array(
            'name' => __( 'Printest', "wpopal-themer" ),
            'id'   => "{$prefix}pinterest",
            'type' => 'text',
            'description' => __('Enter pinterest', "wpopal-themer")
          ),
        ); 
       return apply_filters( 'wpopal_team_metaboxes_fields', $fields );
  }

  /**
   *
   */
  function wpopal_themer_func_team_register_meta_boxes( $meta_boxes ){

      // 1st meta box
      $meta_boxes[] = array(
        // Meta box id, UNIQUE per meta box. Optional since 4.1.5
        'id'         => 'standard',
        // Meta box title - Will appear at the drag and drop handle bar. Required.
        'title'      => __( 'Team Setting', "wpopal-themer" ),
        // Post types, accept custom post types as well - DEFAULT is 'post'. Can be array (multiple post types) or string (1 post type). Optional.
        'post_types' => array( 'team' ),
        // Where the meta box appear: normal (default), advanced, side. Optional.
        'context'    => 'normal',
        // Order of meta box: high (default), low. Optional.
        'priority'   => 'low',
        // Auto save: true, false (default). Optional.
        'autosave'   => true,
        // List of meta fields
        'fields'     =>  wpopal_func_metaboxes_team_fields()
      );

      return $meta_boxes;
  }

  /**
   * Register Metabox 
   */

  add_filter( 'rwmb_meta_boxes', 'wpopal_themer_func_team_register_meta_boxes', 9);

 
  function wpopal_fnc_team_query($args = array()){
    $default = array(
      'post_type' => 'team',
    );

    $args = array_merge( $default, $args );
    return new WP_Query( $args );  
  } 
}


