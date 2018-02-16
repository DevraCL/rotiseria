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
if(!function_exists('wpopal_create_type_portfolio')  ){
    function wpopal_create_type_portfolio(){
      $labels = array(
          'name'               => __( 'Portfolios', "wpopal-themer" ),
          'singular_name'      => __( 'Portfolio', "wpopal-themer" ),
          'add_new'            => __( 'Add New Portfolio', "wpopal-themer" ),
          'add_new_item'       => __( 'Add New Portfolio', "wpopal-themer" ),
          'edit_item'          => __( 'Edit Portfolio', "wpopal-themer" ),
          'new_item'           => __( 'New Portfolio', "wpopal-themer" ),
          'view_item'          => __( 'View Portfolio', "wpopal-themer" ),
          'search_items'       => __( 'Search Portfolios', "wpopal-themer" ),
          'not_found'          => __( 'No Portfolios found', "wpopal-themer" ),
          'not_found_in_trash' => __( 'No Portfolios found in Trash', "wpopal-themer" ),
          'parent_item_colon'  => __( 'Parent Portfolio:', "wpopal-themer" ),
          'menu_name'          => __( 'Portfolios', "wpopal-themer" ),
      );

      $args = array(
          'labels'              => $labels,
          'hierarchical'        => true,
          'description'         => 'List Portfolio',
          'supports'            => array( 'title', 'editor', 'author', 'thumbnail','excerpt'  ), //page-attributes, post-formats
          'taxonomies'          => array( 'portfolio_category'  ),
          'post-formats'      => array( 'aside', 'image', 'quote' ) ,
          'public'              => true,
          'show_ui'             => true,
          'show_in_menu'        => true,
          'menu_position'       => 5,
          'show_in_nav_menus'   => false,
          'publicly_queryable'  => true,
          'exclude_from_search' => false,
          'has_archive'         => true,
          'query_var'           => true,
          'can_export'          => true,
          'rewrite'             => true,
          'capability_type'     => 'post'
      );
      register_post_type( 'portfolio', $args );

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
      register_taxonomy('category_portfolio',array('portfolio'),
          array(
              'hierarchical'      => true,
              'labels'            => $labels,
              'show_ui'           => true,
              'show_admin_column' => true,
              'query_var'         => true,
              'show_in_nav_menus' =>false,
              'rewrite'           => array( 'slug' => 'category-portfolio'
          ),
      ));

       // add_post_type_support( 'portfolio', 'post-formats', array( 'aside', 'image', 'quote' ) );

  }
  add_action( 'init','wpopal_create_type_portfolio' );
}

/**
 * Register Metabox 
 */



function wpopal_func_metaboxes_fields(){
   /**
     * prefix of meta keys (optional)
     * Use underscore (_) at the beginning to make keys hidden
     * Alt.: You also can make prefix empty to disable it
     */

       // Better has an underscore as last sign
    $prefix = 'portfolio_';
    $fields =  array(
        array(
          'name'        => __( 'Layout Fullwidth ?', "wpopal-themer" ),
          'id'          => "{$prefix}check",
          'type'        => 'checkbox',
        ),

        array(
          'name'        => __( 'Select', "wpopal-themer" ),
          'id'          => "{$prefix}layout",
          'type'        => 'select',
          // Array of 'value' => 'Label' pairs for select box
          'options'     => array(
            'default'    => __( 'Default'    , "wpopal-themer" ),
            'video'      => __( 'Video'      , "wpopal-themer" ),
            'gallery'    => __( 'Gallery'    , "wpopal-themer" ),  
            'slideshow'  => __( 'Slideshow'  , "wpopal-themer" ),  
          ),
          // Select multiple values, optional. Default is false.
          'multiple'    => false,
          'std'         => 'default', // Default value, optional
        ),


        // COLOR
        array(
          'name' => __( 'Video Link', "wpopal-themer" ),
          'id'   => "{$prefix}video_link",
          'type' => 'text',
          'description' => __('Support Show Video From Youtube and Vimeo', "wpopal-themer")
        ), 
         
         // THICKBOX IMAGE UPLOAD (WP 3.3+)
        // FILE ADVANCED (WP 3.5+)
        array(
          'name'             => __( 'Images', "wpopal-themer" ),
          'id'               => "{$prefix}file_advanced",
          'type'             => 'file_advanced',
          'max_file_uploads' => 10,
          'mime_type'        => 'image', // Leave blank for all file types
        ),

         // COLOR
        array(
          'name' => __( 'Author FullName', "wpopal-themer" ),
          'id'   => "{$prefix}author",
          'type' => 'text',
          'description' => __('Enter Full Name For Author', "wpopal-themer")
        ), 

        array(
          'name' => __( 'Showcase Link', "wpopal-themer" ),
          'id'   => "{$prefix}link",
          'type' => 'text',
          'description' => __('Enter the link to showcase site', "wpopal-themer")
        ), 

        array(
          'name' => __( 'Client', "wpopal-themer" ),
          'id'   => "{$prefix}client",
          'type' => 'text',
          'description' => __('Enter Full Name For Author', "wpopal-themer")
        ), 

        array(
          'name' => __( 'Date Created', "wpopal-themer" ),
          'id'   => "{$prefix}date",
          'type' => 'date',
          'description' => __('Enter date released the project', "wpopal-themer")
        ), 

      ); 


     return apply_filters( 'wpopal_portfolio_metaboxes_fields', $fields );


}
function wpopal_themer_func_portfolios_register_meta_boxes( $meta_boxes ){




 
    // 1st meta box
    $meta_boxes[] = array(
      // Meta box id, UNIQUE per meta box. Optional since 4.1.5
      'id'         => 'standard',
      // Meta box title - Will appear at the drag and drop handle bar. Required.
      'title'      => __( 'Portfolio Setting', "wpopal-themer" ),
      // Post types, accept custom post types as well - DEFAULT is 'post'. Can be array (multiple post types) or string (1 post type). Optional.
      'post_types' => array( 'portfolio' ),
      // Where the meta box appear: normal (default), advanced, side. Optional.
      'context'    => 'normal',
      // Order of meta box: high (default), low. Optional.
      'priority'   => 'high',
      // Auto save: true, false (default). Optional.
      'autosave'   => true,
      // List of meta fields
      'fields'     =>  wpopal_func_metaboxes_fields()
    );

    return $meta_boxes;
}

add_filter( 'rwmb_meta_boxes', 'wpopal_themer_func_portfolios_register_meta_boxes', 16 );

if( !function_exists("wpopal_fnc_portfolio_information") ){

    function wpopal_fnc_portfolio_information(){
         wpopal_themer_get_template_part( 'portfolio/portfolio-information' )  ;
    }
}

if( !function_exists("portfolio_jquery") ){
  function portfolio_jquery($hook) {
      wp_enqueue_script( 'portfolio_js',  WPOPAL_THEMER_PLUGIN_THEMER_URL.'assets/js/portfolio.js' );
  }
  add_action( 'admin_enqueue_scripts', 'portfolio_jquery' );
}


