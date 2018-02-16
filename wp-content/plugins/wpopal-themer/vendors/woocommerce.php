<?php
/**
 * Class Wpopal_Themer Woocommerce
 *
 */
class Wpopal_ThemerWoocommerce{

    /**
     * Constructor to create an instance of this for processing logics render content and modules.
     */
    public function __construct(){

        remove_action( 'woocommerce_before_shop_loop_item', 'woocommerce_template_loop_product_link_open', 10 );
        remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_product_link_close', 5 );

        add_action( 'customize_register',  array( $this, 'registerCustomizer' ), 9 );


        if( wpopal_themer_fnc_theme_options('is-quickview',true) ){
            add_action( 'wp_ajax_wpopal_themer_quickview', array($this,'quickview') );
            add_action( 'wp_ajax_nopriv_wpopal_themer_quickview', array($this,'quickview') );
            add_action( 'wp_footer', array($this,'quickviewModal') );
        }

        if( wpopal_themer_fnc_theme_options( 'is-swap-effect',true ) ){
            remove_action('woocommerce_before_shop_loop_item_title', 'woocommerce_template_loop_product_thumbnail', 10);
            add_action('woocommerce_before_shop_loop_item_title',   array($this,'swapImages'),10);

        }


    }

    /**
     * Enable product swap image
     *
     * @static
     * @access public
     * @since Wpopal_Themer 1.0
     */
    public function swapImages(){
        global $post, $product, $woocommerce;
        $placeholder_width = get_option('shop_catalog_image_size');
        $placeholder_width = $placeholder_width['width'];

        $placeholder_height = get_option('shop_catalog_image_size');
        $placeholder_height = $placeholder_height['height'];

        $output='';
        $class = 'image-no-effect';
        if(has_post_thumbnail()){
            $attachment_ids = $product->get_gallery_image_ids ();
            if(is_array($attachment_ids) && isset( $attachment_ids[0] )) {
                $class = 'image-hover';
                $output.=wp_get_attachment_image($attachment_ids[0],'shop_catalog',false,array('class'=>"attachment-shop_catalog image-effect"));
            }
            $output.=get_the_post_thumbnail( $post->ID,'shop_catalog',array('class'=>$class) );
        }else{
            $output .= '<img src="'.wc_placeholder_img_src().'" alt="'.esc_html__('Placeholder' , 'wpopal-themer').'" class="'.$class.'" width="'.$placeholder_width.'" height="'.$placeholder_height.'" />';
        }
        echo trim($output);
    }


    /**
     * Add settings to the Customizer.
     *
     * @static
     * @access public
     * @since Wpopal_Themer 1.0
     *
     * @param WP_Customize_Manager $wp_customize Customizer object.
     */
    public function registerCustomizer( $wp_customize ){
        $wp_customize->add_panel( 'panel_woocommerce', array(
            'priority' => 70,
            'capability' => 'edit_theme_options',
            'theme_supports' => '',
            'title' => esc_html__( 'Woocommerce', 'wpopal-themer' ),
            'description' =>esc_html__( 'Make default setting for page, general', 'wpopal-themer' ),
        ) );

        /**
         * General Setting
         */
        $wp_customize->add_section( 'wc_general_settings', array(
            'priority' => 1,
            'capability' => 'edit_theme_options',
            'theme_supports' => '',
            'title' => esc_html__( 'General Setting', 'wpopal-themer' ),
            'description' => '',
            'panel' => 'panel_woocommerce',
        ) );

        //config mini cart
        $wp_customize->add_setting('wpopal_theme_options[woo-show-minicart]', array(
            'capability' => 'manage_options',
            'type'       => 'option',
            'default'   => 1,
            'checked' => 1,
            'sanitize_callback' => 'sanitize_text_field'
        ) );

        $wp_customize->add_control('wpopal_theme_options[woo-show-minicart]', array(
            'settings'  => 'wpopal_theme_options[woo-show-minicart]',
            'label'     => esc_html__('Enable Mini Basket', 'wpopal-themer'),
            'section'   => 'wc_general_settings',
            'type'      => 'checkbox'
        ) );


        $wp_customize->add_setting('wpopal_theme_options[is-quickview]', array(
            'capability' => 'edit_theme_options',
            'type'       => 'option',
            'default'   => 1,
            'checked' => 1,
            'sanitize_callback' => 'sanitize_text_field'
        ) );

        $wp_customize->add_control('wpopal_theme_options[is-quickview]', array(
            'settings'  => 'wpopal_theme_options[is-quickview]',
            'label'     => esc_html__('Enable QuickView', 'wpopal-themer'),
            'section'   => 'wc_general_settings',
            'type'      => 'checkbox',
            'transport' => 4,
        ) );



        $wp_customize->add_setting('wpopal_theme_options[is-swap-effect]', array(
            'capability' => 'edit_theme_options',
            'type'       => 'option',
            'default'   => 1,
            'checked' => 1,
            'sanitize_callback' => 'sanitize_text_field'
        ) );

        $wp_customize->add_control('wpopal_theme_options[is-swap-effect]', array(
            'settings'  => 'wpopal_theme_options[is-swap-effect]',
            'label'     => esc_html__('Enable Swap Image', 'wpopal-themer'),
            'section'   => 'wc_general_settings',
            'type'      => 'checkbox',
            'transport' => 4,
        ) );

        $wp_customize->add_setting('wpopal_theme_options[fillter-producttype]', array(
            'capability' => 'edit_theme_options',
            'type'       => 'option',
            'default'   => 1,
            'checked' => 1,
            'sanitize_callback' => 'sanitize_text_field'
        ) );

        $wp_customize->add_control('wpopal_theme_options[fillter-producttype]', array(
            'settings'  => 'wpopal_theme_options[fillter-producttype]',
            'label'     => esc_html__('Enable Fillter Product Type', 'wpopal-themer'),
            'section'   => 'wc_general_settings',
            'type'      => 'checkbox',
            'transport' => 5,
        ) );

        $wp_customize->add_setting('wpopal_theme_options[product-perpage]', array(
            'capability' => 'edit_theme_options',
            'type'       => 'option',
            'default'   => 1,
            'checked' => 1,
            'sanitize_callback' => 'sanitize_text_field'
        ) );

        $wp_customize->add_control('wpopal_theme_options[product-perpage]', array(
            'settings'  => 'wpopal_theme_options[product-perpage]',
            'label'     => esc_html__('Enable Product Per Page', 'wpopal-themer'),
            'section'   => 'wc_general_settings',
            'type'      => 'checkbox',
            'transport' => 6,
        ) );

        /**
         * Archive Page Setting
         */
        $wp_customize->add_section( 'wc_archive_settings', array(
            'priority' => 2,
            'capability' => 'edit_theme_options',
            'theme_supports' => '',
            'title' => esc_html__( 'Archive Page Setting', 'wpopal-themer' ),
            'description' => 'Configure categories, search, shop page setting',
            'panel' => 'panel_woocommerce',
        ) );

         ///  Archive layout setting
        $wp_customize->add_setting( 'wpopal_theme_options[woocommerce-archive-layout]', array(
            'capability' => 'edit_theme_options',
            'type'       => 'option',
            'default'   => 'mainright',
            'checked' => 1,
            'sanitize_callback' => 'sanitize_text_field'
        ) );

        $wp_customize->add_control( new Wpopal_Themer_Layout_DropDown( $wp_customize,  'wpopal_theme_options[woocommerce-archive-layout]', array(
            'settings'  => 'wpopal_theme_options[woocommerce-archive-layout]',
            'label'     => esc_html__('Archive Layout', 'wpopal-themer'),
            'section'   => 'wc_archive_settings',
            'priority' => 1

        ) ) );

       //sidebar archive left
        $wp_customize->add_setting( 'wpopal_theme_options[woocommerce-archive-left-sidebar]', array(
            'capability' => 'edit_theme_options',
            'type'       => 'option',
            'default'   => 'sidebar-left',
            'checked' => 1,
            'sanitize_callback' => 'sanitize_text_field'
        ) );

        $wp_customize->add_control( new Wpopal_Themer_Sidebar_DropDown( $wp_customize,  'wpopal_theme_options[woocommerce-archive-left-sidebar]', array(
            'settings'  => 'wpopal_theme_options[woocommerce-archive-left-sidebar]',
            'label'     => esc_html__('Archive Left Sidebar', 'wpopal-themer'),
            'section'   => 'wc_archive_settings' ,
             'priority' => 3
        ) ) );

          //sidebar archive right
        $wp_customize->add_setting( 'wpopal_theme_options[woocommerce-archive-right-sidebar]', array(
            'capability' => 'edit_theme_options',
            'type'       => 'option',
            'default'   => 'sidebar-right',
            'checked' => 1,
            'sanitize_callback' => 'sanitize_text_field'
        ) );

        $wp_customize->add_control( new Wpopal_Themer_Sidebar_DropDown( $wp_customize,  'wpopal_theme_options[woocommerce-archive-right-sidebar]', array(
            'settings'  => 'wpopal_theme_options[woocommerce-archive-right-sidebar]',
            'label'     => esc_html__('Archive Right Sidebar', 'wpopal-themer'),
            'section'   => 'wc_archive_settings',
             'priority' => 4
        ) ) );

        //list-grid  style archive
        $wp_customize->add_setting( 'wpopal_theme_options[wc_listgrid]', array(
            'type'       => 'option',
            'default'    => 'product',
            'capability' => 'manage_options',
            'sanitize_callback' => 'sanitize_text_field'
        ) );

        $wp_customize->add_control( 'wpopal_theme_options[wc_listgrid]', array(
            'label'      => esc_html__( 'List Grid', 'wpopal-themer' ),
            'section'    => 'wc_archive_settings',
            'type'       => 'select',
            'choices'     => array(
                'list' => esc_html__('List', 'wpopal-themer' ),
                'grid' => esc_html__('Grid', 'wpopal-themer' ),
            ),
            'description' => 'Select default layout archive product',
            'priority' => 5
        ) );

        //number product per page
        $wp_customize->add_setting( 'wpopal_theme_options[woo-number-page]', array(
            'type'       => 'option',
            'default'    => 12,
            'capability' => 'manage_options',
            'sanitize_callback' => 'sanitize_text_field'
        ) );
        $wp_customize->add_control( 'wpopal_theme_options[woo-number-page]', array(
            'label'      => esc_html__( 'Number of Products Per Page', 'wpopal-themer' ),
            'section'    => 'wc_archive_settings',
            'priority' => 6
        ) );

        //number product per row
        $wp_customize->add_setting( 'wpopal_theme_options[wc_itemsrow]', array(
            'type'       => 'option',
            'default'    => 4,
            'capability' => 'manage_options',
            'sanitize_callback' => 'sanitize_text_field'
        ) );

        $wp_customize->add_control( 'wpopal_theme_options[wc_itemsrow]', array(
            'label'      => esc_html__( 'Number of Products Per Row', 'wpopal-themer' ),
            'section'    => 'wc_archive_settings',
            'type'       => 'select',
            'choices'     => array(
                '2' => esc_html__('2 Items', 'wpopal-themer' ),
                '3' => esc_html__('3 Items', 'wpopal-themer' ),
                '4' => esc_html__('4 Items', 'wpopal-themer' ),
                '6' => esc_html__('6 Items', 'wpopal-themer' ),
            ),
            'priority' => 7
        ) );


        /**
         * Product Single Setting
         */
        $wp_customize->add_section( 'wc_product_settings', array(
            'priority' => 12,
            'capability' => 'edit_theme_options',
            'theme_supports' => '',
            'title' => esc_html__( 'Single Product Page Setting', 'wpopal-themer' ),
            'description' => 'Configure single product page',
            'panel' => 'panel_woocommerce',
        ) );
        // Check Exits multi layouts
        if(is_dir(get_template_directory().'/woocommerce/single-product/layouts')){
            ///  single layout setting
            $wp_customize->add_setting( 'wpopal_theme_options[woocommerce-single-content-layout]', array(
                'capability' => 'edit_theme_options',
                'type'       => 'option',
                'default'   => '1',
                'sanitize_callback' => 'sanitize_text_field'
            ) );


            //Select layout
            $wp_customize->add_control( new Wpopal_Themer_Layout_Content_Radio( $wp_customize,  'wpopal_theme_options[woocommerce-single-content-layout]', array(
                'settings'  => 'wpopal_theme_options[woocommerce-single-content-layout]',
                'label'     => esc_html__('Product Content Layout', 'wpopal-themer'),
                'section'   => 'wc_product_settings',
                'priority' => 1
            ) )
            );

            //Tabs Layout
            $wp_customize->add_setting( 'wpopal_theme_options[woocommerce-single-tab-style]', array(
                'type'       => 'option',
                'default'    => 'tabs-h',
                'capability' => 'manage_options',
                'sanitize_callback' => 'sanitize_text_field'
            ) );

            $wp_customize->add_control( 'wpopal_theme_options[woocommerce-single-tab-style]', array(
                'label'      => esc_html__( 'Extra Information Style', 'wpopal-themer' ),
                'section'    => 'wc_product_settings',
                'type'       => 'select',
                'choices'     => apply_filters('wc_filter_single_tab_style',array(
                    'tabs-h' => esc_html__('Horizontal Tabs', 'wpopal-themer' ),
                    'tabs-v' => esc_html__('Vertical Tabs', 'wpopal-themer' ),
                    'accordions' => esc_html__('Accordions', 'wpopal-themer' ),
                    'fulltext' => esc_html__('Full Text', 'wpopal-themer' ),
                )),
                'priority' => 2
            ) );

        }//end check Layouts


        ///  single layout sidebar setting
        $wp_customize->add_setting( 'wpopal_theme_options[woocommerce-single-layout]', array(
            'capability' => 'edit_theme_options',
            'type'       => 'option',
            'default'   => 'mainright',
            'sanitize_callback' => 'sanitize_text_field'
        ) );

        //Select sidebar layout
        $wp_customize->add_control( new Wpopal_Themer_Layout_DropDown( $wp_customize,  'wpopal_theme_options[woocommerce-single-layout]', array(
            'settings'  => 'wpopal_theme_options[woocommerce-single-layout]',
            'label'     => esc_html__('Product Sidebar Layout', 'wpopal-themer'),
            'section'   => 'wc_product_settings',
            'priority' => 2
        ) ) );


        $wp_customize->add_setting( 'wpopal_theme_options[woocommerce-single-left-sidebar]', array(
            'capability' => 'edit_theme_options',
            'type'       => 'option',
            'default'   => 2,
            'sanitize_callback' => 'sanitize_text_field'
        ) );

        //Sidebar left
        $wp_customize->add_control( new Wpopal_Themer_Sidebar_DropDown( $wp_customize,  'wpopal_theme_options[woocommerce-single-left-sidebar]', array(
            'settings'  => 'wpopal_theme_options[woocommerce-single-left-sidebar]',
            'label'     => esc_html__('Product Left Sidebar', 'wpopal-themer'),
            'section'   => 'wc_product_settings',
            'priority' => 2
        ) ) );

         $wp_customize->add_setting( 'wpopal_theme_options[woocommerce-single-right-sidebar]', array(
            'capability' => 'edit_theme_options',
            'type'       => 'option',
            'default'   => 'sidebar-right',
            'sanitize_callback' => 'sanitize_text_field'
        ) );

        //Sidebar right
        $wp_customize->add_control( new Wpopal_Themer_Sidebar_DropDown( $wp_customize,  'wpopal_theme_options[woocommerce-single-right-sidebar]', array(
            'settings'  => 'wpopal_theme_options[woocommerce-single-right-sidebar]',
            'label'     => esc_html__('Product Right Sidebar', 'wpopal-themer'),
            'section'   => 'wc_product_settings',
            'priority' => 3
        ) ) );

        //Number of product thumbnail to show
        $wp_customize->add_setting( 'wpopal_theme_options[woo-number-thumbnail-single]', array(
            'type'       => 'option',
            'default'    => 3,
            'capability' => 'manage_options',
            'sanitize_callback' => 'sanitize_text_field'
        ) );

        $wp_customize->add_control( 'wpopal_theme_options[woo-number-thumbnail-single]', array(
            'label'      => esc_html__( 'Number of Thumbnail to Show', 'wpopal-themer' ),
            'section'    => 'wc_product_settings',
            'priority' => 3
        ) );

        //Show related product
        $wp_customize->add_setting('wpopal_theme_options[wc_show_related]', array(
            'capability' => 'edit_theme_options',
            'type'       => 'option',
            'default'   => 0,
            'checked' => 1,
            'sanitize_callback' => 'sanitize_text_field'
        ) );

        $wp_customize->add_control('wpopal_theme_options[wc_show_related]', array(
            'settings'  => 'wpopal_theme_options[wc_show_related]',
            'label'     => esc_html__('Disable show related product', 'wpopal-themer'),
            'section'   => 'wc_product_settings',
            'type'      => 'checkbox',
            'priority' => 4
        ) );
         //Show upsells product
        $wp_customize->add_setting('wpopal_theme_options[wc_show_upsells]', array(
            'capability' => 'edit_theme_options',
            'type'       => 'option',
            'default'   => 0,
            'checked' => 1,
            'sanitize_callback' => 'sanitize_text_field'
        ) );

        $wp_customize->add_control('wpopal_theme_options[wc_show_upsells]', array(
            'settings'  => 'wpopal_theme_options[wc_show_upsells]',
            'label'     => esc_html__('Disable show upsells product', 'wpopal-themer'),
            'section'   => 'wc_product_settings',
            'type'      => 'checkbox',
            'transport' => 3,
            'priority' => 5
        ) );

        //number of product per row
        $wp_customize->add_setting( 'wpopal_theme_options[product-number-columns]', array(
            'type'       => 'option',
            'default'    => 3,
            'capability' => 'manage_options',
            'sanitize_callback' => 'sanitize_text_field'
        ) );

        $wp_customize->add_control( 'wpopal_theme_options[product-number-columns]', array(
            'label'      => esc_html__( 'Number of Product Per Row', 'wpopal-themer' ),
            'section'    => 'wc_product_settings',
            'type'       => 'select',
            'choices'     => array(
                '2' => esc_html__('2 Items', 'wpopal-themer' ),
                '3' => esc_html__('3 Items', 'wpopal-themer' ),
                '4' => esc_html__('4 Items', 'wpopal-themer' ),
                '5' => esc_html__('5 Items', 'wpopal-themer' ),
                '6' => esc_html__('6 Items', 'wpopal-themer' )
            ),
            'priority' => 6
        ) );

        //Number of product to show
        $wp_customize->add_setting( 'wpopal_theme_options[woo-number-product-single]', array(
            'type'       => 'option',
            'default'    => 6,
            'capability' => 'manage_options',
            'sanitize_callback' => 'sanitize_text_field'
        ) );

        $wp_customize->add_control( 'wpopal_theme_options[woo-number-product-single]', array(
            'label'      => esc_html__( 'Number of Products to Show', 'wpopal-themer' ),
            'section'    => 'wc_product_settings',
            'priority' => 7
        ) );

         //Show Social share product
        $wp_customize->add_setting('wpopal_theme_options[wc_show_share_social]', array(
            'capability' => 'edit_theme_options',
            'type'       => 'option',
            'default'   => 1,
            'checked' => 1,
            'sanitize_callback' => 'sanitize_text_field'
        ) );

        $wp_customize->add_control('wpopal_theme_options[wc_show_share_social]', array(
            'settings'  => 'wpopal_theme_options[wc_show_share_social]',
            'label'     => esc_html__('Show Social share product', 'wpopal-themer'),
            'section'   => 'wc_product_settings',
            'type'      => 'checkbox',
            'priority' => 8
        ) );

        /*
         * Custom breadcrumb
         */
         $wp_customize->add_setting('wpopal_theme_options[woocommerce-single-breadcrumb]', array(
            'default'    => '',
            'type'       => 'option',
            'capability' => 'manage_options',
            'sanitize_callback' => 'esc_url_raw',
        ) );

        $wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'wpopal_theme_options[woocommerce-single-breadcrum]', array(
            'label'    => esc_html__('Breadcrumb background', 'wpopal-themer'),
            'section'  => 'wc_product_settings',
            'settings' => 'wpopal_theme_options[woocommerce-single-breadcrumb]',
            'priority' => 10,
        ) ) );
    }


    public function quickview(){
        $args = array(
                'post_type'=>'product',
                'product'=>$_GET['productslug']
            );
        $query = new WP_Query($args);
        if($query->have_posts()){
            while($query->have_posts()): $query->the_post(); global $product;
                if(is_file( get_template_directory().'/woocommerce/quickview.php')){
                     get_template_part( 'woocommerce/quickview');
                }
            endwhile;
        }

        wp_reset_postdata();
        die;
    }

    public function quickviewModal(){
    ?>
    <div class="modal fade" id="opal-quickview-modal" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close btn btn-close" data-dismiss="modal" aria-hidden="true">
                            <i class="fa fa-times"></i>
                        </button>
                    </div>
                    <div class="modal-body"><span class="spinner"></span></div>
                </div>
            </div>
        </div>

    <?php
    }
}

new Wpopal_ThemerWoocommerce();



/**
 *
 */
function wpopal_themer_woocommerce_scripts(){
    wp_enqueue_script( 'woosa-woocommerce', get_template_directory_uri() . '/js/woocommerce.js', array( 'jquery', 'suggest' ), '20131022', true );
    wp_enqueue_script( 'wpopal-themer-elevatezoom', WPOPAL_THEMER_PLUGIN_THEMER_URL.'assets/js/elevatezoom/elevatezoom-min.js' );
}

function wpopal_themer_load_zoom_images(){
      if ( function_exists('yith_wcmg_is_enabled') && yith_wcmg_is_enabled () && ! apply_filters ( 'yith_wczm_featured_video_enabled', false ) ) {

    }else {

        add_action( 'wp_enqueue_scripts', 'wpopal_themer_woocommerce_scripts', 999 );
        remove_action('woocommerce_before_single_product_summary', 'woocommerce_show_product_images', 20);
        remove_action('woocommerce_product_thumbnails', 'woocommerce_show_product_thumbnails', 20);

        add_action('woocommerce_before_single_product_summary', 'wpopal_themer_woocommerce_show_product_images', 20);
        add_action('woocommerce_product_thumbnails', 'wpopal_themer_woocommerce_show_product_thumbnails', 20);
    }    
}

add_action('init','wpopal_themer_load_zoom_images', 99);


/**
 *
 */
function wpopal_themer_woocommerce_show_product_images(){
    $layout = apply_filters( 'wpopal_themer_woocommerce_show_product_images', 'product-image' );
    wpopal_themer_get_template_part('woocommerce/'.$layout);
}

/**
 *
 */
function wpopal_themer_woocommerce_show_product_thumbnails(){
    $layout = apply_filters( 'wpopal_themer_woocommerce_show_product_thumbnails', 'product-thumbnails' );
    wpopal_themer_get_template_part('woocommerce/'.$layout);
}


/* ---------------------------------------------------------------------------
 * WooCommerce - Function get Query
 * --------------------------------------------------------------------------- */
function wpopal_themer_woocommerce_query( $type, $post_per_page=-1, $cat='',$offset='', $paged=null){
    global $woocommerce, $wp_query;

    if(empty($paged)){
        $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
    }
    
    $orderby = (get_query_var('orderby')) ? get_query_var('orderby') : null;
    $args = array(
        'post_type' => 'product',
        'posts_per_page' => $post_per_page,
        'post_status' => 'publish',
        'paged' => $paged,
        'offset' => $offset,
        'orderby'   => $orderby
    );

    if ( isset( $args['orderby'] ) ) {
        if ( 'price' == $args['orderby'] ) {
            $args = array_merge( $args, array(
                'meta_key'  => '_price',
                'orderby'   => 'meta_value_num'
            ) );
        }
        if ( 'featured' == $args['orderby'] ) {
            $args = array_merge( $args, array(
                'meta_key'  => '_featured',
                'orderby'   => 'meta_value'
            ) );
        }
        if ( 'sku' == $args['orderby'] ) {
            $args = array_merge( $args, array(
                'meta_key'  => '_sku',
                'orderby'   => 'meta_value'
            ) );
        }
    }



    switch ($type) {

        case 'best_selling_products':
            $args['meta_key']   ='total_sales';
            $args['orderby']    ='meta_value_num';
            $args['order']      = 'DESC';
            $args['meta_query'] = WC()->query->get_meta_query();
            $args['tax_query']  = WC()->query->get_tax_query();
            break;

        case 'featured_products':
            
            $args['meta_query']     = WC()->query->get_meta_query();
            $args['tax_query']      = WC()->query->get_tax_query();
            $args['tax_query'][]    = array(
                'taxonomy' => 'product_visibility',
                'field'    => 'name',
                'terms'    => 'featured',
                'operator' => 'IN',
            );
            break;

        case 'top_rate':
            $args['meta_query']     = WC()->query->get_meta_query();
            $args['tax_query']      = WC()->query->get_tax_query();
            $args['meta_key']       = '_wc_average_rating';
            $args['orderby']        = 'meta_value_num';
            $args['order']          = 'DESC';
            break;

        case 'recent_products':

            $args['orderby']    = 'date';
            $args['order']      =  'DESC';
            $args['meta_query'] = WC()->query->get_meta_query();
            $args['tax_query']  = WC()->query->get_tax_query();

            break;

        case 'deals': 
            $args['meta_query']     = WC()->query->get_meta_query();
            $args['tax_query']      = WC()->query->get_tax_query();
            $args['meta_query'][]   =  array(
                array( // Variable products type
                    'key'           => '_sale_price_dates_to',
                    'value'         => time(),
                    'compare'       => '>',
                    'type'          => 'numeric'
                )
            );

            break;

        case 'sale_products':
            $args['meta_query']     = WC()->query->get_meta_query();
            $args['tax_query']      = WC()->query->get_tax_query();
            $args['post__in']       = array_merge( array( 0 ), wc_get_product_ids_on_sale() );
            break;

        case 'recent_review':

            if($post_per_page == -1) $_limit = 4;
            else $_limit = $post_per_page;
            global $wpdb;
            $query = "SELECT c.comment_post_ID FROM {$wpdb->prefix}posts p, {$wpdb->prefix}comments c
                WHERE p.ID = c.comment_post_ID AND c.comment_approved > 0 AND p.post_type = 'product' AND p.post_status = 'publish' AND p.comment_count > 0
                ORDER BY c.comment_date ASC";
            $results = $wpdb->get_results($query, OBJECT);
            $_pids = array();
            foreach ($results as $re) {
                if(!in_array($re->comment_post_ID, $_pids))
                    $_pids[] = $re->comment_post_ID;
                if(count($_pids) == $_limit)
                    break;
            }

            $args['meta_query'] = WC()->query->get_meta_query();
            $args['tax_query']  = WC()->query->get_tax_query();
            $args['post__in']   = $_pids;

            break;
    }

    if( !empty($cat) && !is_array($cat) ){
        $cat = array( $cat );
    }
    if( !empty($cat) && is_array($cat) ){

        if( isset($cat[0]) && !is_numeric($cat[0]) ){
            $terms = array();
            foreach( $cat as $ct ){
                $ocategory = get_term_by( 'slug', $ct, 'product_cat' );

                if( $ocategory ){
                    $terms[] = $ocategory->term_id;
                }
            }
            $cat = $terms;
        }

        $args['tax_query'][]    = array(
            array(
                'taxonomy'      => 'product_cat',
                'field'         => 'term_id', //This is optional, as it defaults to 'term_id'
                'terms'         =>  $cat,
                'operator'      => 'IN' // Possible values are 'IN', 'NOT IN', 'AND'.
            )
        );
    }

    return new WP_Query($args);
    
}
/**
 * Creat Post Type Product Tabs which display in product detail
 */
if(!function_exists('wpopal_create_type_producttab')   ){

    function wpopal_create_type_producttab(){
        $labels = array(
            'name' => __( 'Product Info Tab', "wpopal-themer" ),
            'singular_name' => __( 'Product Tab', "wpopal-themer" ),
            'add_new' => __( 'Add New Product Tab', "wpopal-themer" ),
            'add_new_item' => __( 'Add New Product Tab', "wpopal-themer" ),
            'edit_item' => __( 'Edit Product Tab', "wpopal-themer" ),
            'new_item' => __( 'New Product Tab', "wpopal-themer" ),
            'view_item' => __( 'View Product Tab', "wpopal-themer" ),
            'search_items' => __( 'Search Product Tabs', "wpopal-themer" ),
            'not_found' => __( 'No Product Tabs found', "wpopal-themer" ),
            'not_found_in_trash' => __( 'No Product Tabs found in Trash', "wpopal-themer" ),
            'parent_item_colon' => __( 'Parent Product Tab:', "wpopal-themer" ),
            'menu_name' => __( 'Product Info Tabs', "wpopal-themer" ),
        );

        $args = array(
          'labels' => $labels,
          'hierarchical' => true,
          'description' => 'List Product Tab',
          'supports' => array( 'title', 'editor','slug' ),
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
        register_post_type( 'producttab', $args );
    }
    add_action( 'init','wpopal_create_type_producttab' );
}

/**
* get setting files
*/
function wpopal_func_metaboxes_producttab_fields(){

   /**
    * prefix of meta keys (optional)
    * Use underscore (_) at the beginning to make keys hidden
    * Alt.: You also can make prefix empty to disable it
    */

    // Better has an underscore as last sign
    $fields = array();

    return apply_filters( 'wpopal_producttab_metaboxes_fields', $fields );
}

/**
 *
 */
function wpopal_themer_func_producttabs_register_meta_boxes( $meta_boxes ){

    $fields = wpopal_func_metaboxes_producttab_fields();
    if( $fields ){
        // 1st meta box
        $meta_boxes[] = array(
            // Meta box id, UNIQUE per meta box. Optional since 4.1.5
            'id'         => 'standard',
            // Meta box title - Will appear at the drag and drop handle bar. Required.
            'title'      => __( 'Product Tabs Info', "wpopal-themer" ),
            // Post types, accept custom post types as well - DEFAULT is 'post'. Can be array (multiple post types) or string (1 post type). Optional.
            'post_types' => array( 'producttab' ),
            // Where the meta box appear: normal (default), advanced, side. Optional.
            'context'    => 'normal',
            // Order of meta box: high (default), low. Optional.
            'priority'   => 'low',
            // Auto save: true, false (default). Optional.
            'autosave'   => true,
            // List of meta fields
            'fields'     => $fields
        );
    }
    return $meta_boxes;
}

/**
 * Register Metabox
 */
add_filter( 'rwmb_meta_boxes', 'wpopal_themer_func_producttabs_register_meta_boxes', 12);


/**
 * Remove review to products tabs. and display this as block below the tab.
 */
function wpopal_woocommerce_product_tabs( $tabs ){
    $args = array(

    'post_type'        => 'producttab',


    );
    $posts = get_posts( $args );

    if( !empty($posts) ){
        foreach( $posts as $post ){
             $tabs['producttab-'.$post->ID] = array(
                'title'    => $post->post_title,
                'priority' => 20,
                'callback' => 'wpopal_woocommerce_product_tabs_content',
                'post_content'   => $post->post_content
            );
        }
    }

    wp_reset_postdata();

    return $tabs;
}
add_filter( 'woocommerce_product_tabs','wpopal_woocommerce_product_tabs', 99 );

function wpopal_woocommerce_product_tabs_content( $key, $data ){
    if( isset($data['post_content']) ){
        echo '<div class="custom-producttab">'. do_shortcode( $data['post_content'] ).'</div><div class="clear clearfix"></div>';
    }
}

//Render form fillter product
function wpopal_woocommerce_product_fillter($options, $name, $default){
    // Only show on product categories
    if ( ! woocommerce_products_will_display() ) :
        return;
    endif;

    ?>
    <form method="get" class="woocommerce-fillter">
        <select name="<?php echo esc_attr($name); ?>" onchange="this.form.submit()" class="select">
            <?php foreach( $options as $key => $value ) : ?>
                <option value="<?php echo esc_attr( $key ); ?>" <?php selected( $key, wpopal_woocommerce_get_fillter($name, $default) ); ?>>
                    <?php echo trim($value);?>
                </option>
            <?php endforeach; ?>
        </select>
    <?php
        // Keep query string vars intact
        foreach ( $_GET as $key => $val ) :

            if ( $name === $key || 'submit' === $key ) :
                continue;
            endif;
            if ( is_array( $val ) ) :
                foreach( $val as $inner_val ) :
                    ?><input type="hidden" name="<?php echo esc_attr( $key ); ?>[]" value="<?php echo esc_attr( $inner_val ); ?>" /><?php
                endforeach;
            else :
                ?><input type="hidden" name="<?php echo esc_attr( $key ); ?>" value="<?php echo esc_attr( $val ); ?>" /><?php
            endif;
        endforeach;
    ?>
    </form>
<?php

}

//get value fillter
function wpopal_woocommerce_get_fillter($name, $default){

    if ( isset( $_GET[$name] ) ) :
        return $_GET[$name];
    else :
        return $default;
    endif;
}

function wpopal_woocommerce_meta_query($type){
    $args = array();
    switch ($type) {
      
        case 'best_selling_products':
            $args['meta_key']   ='total_sales';
            $args['orderby']    ='meta_value_num';
            $args['order']      = 'DESC';
            $args['meta_query'] = WC()->query->get_meta_query();
            $args['tax_query']  = WC()->query->get_tax_query();
            return $args;
            break;

        case 'featured_products':
            
            $args['meta_query']     = WC()->query->get_meta_query();
            $args['tax_query']      = WC()->query->get_tax_query();
            $args['tax_query'][]    = array(
                'taxonomy' => 'product_visibility',
                'field'    => 'name',
                'terms'    => 'featured',
                'operator' => 'IN',
            );
            return $args;
            break;

        case 'top_rate':
            $args['meta_query']     = WC()->query->get_meta_query();
            $args['tax_query']      = WC()->query->get_tax_query();
            $args['meta_key']       = '_wc_average_rating';
            $args['orderby']        = 'meta_value_num';
            $args['order']          = 'DESC';
            return $args;
            break;

        case 'recent_products':
            $args['orderby']    = 'date';
            $args['order']      =  'DESC';
            $args['meta_query'] = WC()->query->get_meta_query();
            $args['tax_query']  = WC()->query->get_tax_query();
            return $args;
            break;  

        case 'sale_products':
            $args['meta_query']     = WC()->query->get_meta_query();
            $args['tax_query']      = WC()->query->get_tax_query();
            $args['post__in']       = array_merge( array( 0 ), wc_get_product_ids_on_sale() );
            return $args;
            break;
    }
}

//Add query product type
function wpopal_woocommerce_product_type_query( $q ){
    $name = 'product_type';
    $default = 'recent_products';

    $product_type = wpopal_woocommerce_get_fillter($name, $default);
    $args = wpopal_woocommerce_meta_query($product_type);
    $queries = array('meta_key', 'orderby', 'order', 'post__in', 'tax_query', 'meta_query');
    if ( function_exists( 'woocommerce_products_will_display' ) && woocommerce_products_will_display() && $q->is_main_query() ) :
        foreach($queries as $query){
            if(isset($args[$query])){
                $q->set( $query, $args[$query] );
            }
        }
    endif;
}
add_action( 'woocommerce_product_query', 'wpopal_woocommerce_product_type_query' );

//Add query product per page
function wpopal_woocommerce_product_per_page_query( $q ){
    $default = wpopal_themer_fnc_theme_options('woo-number-page', get_option('posts_per_page'));
    $product_per_page = wpopal_woocommerce_get_fillter('product_per_page',$default);
    if ( function_exists( 'woocommerce_products_will_display' ) && woocommerce_products_will_display() && $q->is_main_query() ) :
        $q->set( 'posts_per_page', $product_per_page );
    endif;
}
add_action( 'woocommerce_product_query', 'wpopal_woocommerce_product_per_page_query' );



//Add form fillter by product type
function wpopal_woocommerce_product_type_fillter(){
    $default = 'recent_products';
    $options = array(
        'recent_products'      => esc_html__( 'Latest Products', 'wpopal-themer' ),
        'sale_products'         => esc_html__( 'Sale Products', 'wpopal-themer' ),
        'featured_products'     => esc_html__( 'Featured Products', 'wpopal-themer' ),
        'best_selling_products' => esc_html__( 'Best Selling Products', 'wpopal-themer' ),
        'top_rate'              => esc_html__( 'Top Rate', 'wpopal-themer' ),
    );
    $name = 'product_type';
    wpopal_woocommerce_product_fillter($options, $name, $default);
}
if(wpopal_themer_fnc_theme_options('fillter-producttype')){
    add_action('woocommerce_before_shop_loop', 'wpopal_woocommerce_product_type_fillter', 25);
}


//Add form fillter by product per page
function wpopal_woocommerce_product_per_page_fillter(){
    $columns = wpopal_themer_fnc_theme_options('wc_itemsrow', 4);
    $default = wpopal_themer_fnc_theme_options('woo-number-page', get_option('posts_per_page'));
    $options= array();
    for($i=1; $i<=5; $i++){
        $options[$i*$columns] =  $i*$columns.' '.esc_html__( ' products per page', 'wpopal-themer');
    }
    $options['-1'] = esc_html__('All products', 'wpopal-themer' );
    $name = 'product_per_page';
    wpopal_woocommerce_product_fillter($options, $name, $default);
}
if(wpopal_themer_fnc_theme_options('product-perpage')){
    add_action('woocommerce_before_shop_loop', 'wpopal_woocommerce_product_per_page_fillter', 20);
}