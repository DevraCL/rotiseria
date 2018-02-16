<?php 
if(  class_exists("WP_Customize_Control") ){
  class Wpopal_Themer_Sidebar_DropDown extends WP_Customize_Control{
     
        public function render_content(){
            
            global $wp_registered_sidebars;
            
            $output = array();
            
            $output[] = '<option value="">'.esc_html__( 'No Sidebar', 'wpopal-themer' ).'</option>';

            foreach( $wp_registered_sidebars as $sidebar ){ 
                $selected = ($this->value() == $sidebar['id'])?' selected="selected" ': '';
                $output[] = '<option value="'.$sidebar['id'].'" '.$selected.'>'.$sidebar['name'].'</option>';
            }

            $dropdown = '<select>'.implode( " ", $output ).'</select>';
            $dropdown = str_replace('<select', '<select ' . $this->get_link(), $dropdown );

            printf( 
                '<label class="customize-control-select"><span class="customize-control-title">%s</span> %s</label>',
                $this->label,
                $dropdown
            );
     
        }
    }

    ///
    class Wpopal_Themer_Layout_DropDown extends WP_Customize_Control{
        public $type="PBR_Layout";
        public function render_content(){
            
            $layouts = array(
                'leftmain' => esc_html__('Left - Main Sidebar', 'wpopal-themer'),
                'mainright' => esc_html__('Main - Right Sidebar', 'wpopal-themer'),
                'fullwidth' => esc_html__('Fullwidth', 'wpopal-themer'),
        
            );
             printf( 
                '<label class="customize-control-select"><span class="customize-control-title">%s</span>',
                 $this->label
               
            );
            ?>
            <div class="page-layout">
               

            <?php
            $output = array();
            
            foreach( $layouts as $key => $layout ){ 
                $v = $this->value() ? $this->value() : 'fullwidth' ;   
                $selected = ( $v == $key)?' selected="selected" ': '';
                $output[] = '<option value="'.$key.'" '.$selected.'>'.$layout.'</option>';
            }

            $dropdown = '<select>'.implode( " ", $output ).'</select>';
            $dropdown = str_replace('<select', '<select ' . $this->get_link(), $dropdown );

            printf( 
                '%s</label>',
                
                $dropdown
            ).'</div>';
        }
    }

    ///
    class Wpopal_Themer_Layout_Content_Radio extends WP_Customize_Control{
        public $type="radio-image";
        /**
         * Enqueue control related scripts/styles.
         *
         * @return  void
         */
        public function enqueue() {
            static $enqueued;

            if ( ! isset( $enqueued ) ) {
                wp_enqueue_script( 'opal-customize', WPOPAL_THEMER_PLUGIN_THEMER_URL.'assets/js/customizer_icon.js', array(), '1.0.0', true );
                $enqueued = true;
            }
        }
        public function render_content(){
            
            $layouts = apply_filters('wpopal_filter_layout_content_dropdown',array(
                '1' => esc_html__('Layout 1 (Right Image)', 'wpopal-themer'),
                '2' => esc_html__('Layout 2 ', 'wpopal-themer'),
                '3' => esc_html__('Layout 3 ', 'wpopal-themer'),
                '4' => esc_html__('Layout 4 ', 'wpopal-themer'),
                '5' => esc_html__('Layout 5 ', 'wpopal-themer'),
        
            ));

             printf( 
                '<label class="customize-control-select"><span class="customize-control-title">%s</span>',
                 $this->label
               
            );
            ?>
            <div id="opal-<?php echo esc_attr( $this->type ); ?>-<?php echo esc_attr( $this->id ); ?>" class="customize-control-content">
                <?php 
                $value = $this->value();
                foreach ( $layouts as $val => $label ) { 
                $image = WPOPAL_THEMER_PLUGIN_THEMER_URL.'assets/img/layout_'.$val.'.png'; ?> 
                <div class="opal-radio-image <?php if ( checked( $value, $val, false ) ) echo 'selected'; ?>">
                    <img src="<?php echo $image; ?>" alt="<?php echo esc_attr( $label );?>">
                    <input <?php echo  $this->get_link(); ?> type="radio"  name="<?php echo esc_attr( $this->id ); ?>" title="<?php echo esc_attr( $label );?>" value="<?php echo esc_attr( $val ); ?>" <?php
                        checked( $value, $val );
                    ?>>
                </div>
            <?php } ?>
            </div>
        <?php
        }
    }

}

if ( class_exists( 'WP_Customize_Control' ) ) {
    class Wpopal_Themer_WP_Customize_Dropdown_Categories_Control extends WP_Customize_Control {
        public $type = 'dropdown-categories';   

        public function render_content() {
            $dropdown = wp_dropdown_categories( 
                array( 
                    'name'             => '_customize-dropdown-categories-' . $this->id,
                    'echo'             => 0,
                    'hide_empty'       => false,
                    'show_option_none' => '&mdash; ' . esc_html__('Select', 'wpopal-themer') . ' &mdash;',
                    'hide_if_empty'    => false,
                    'selected'         => $this->value(),
                )
            );

            $dropdown = str_replace('<select', '<select ' . $this->get_link(), $dropdown );

            printf( 
                '<label class="customize-control-select"><span class="customize-control-title">%s</span> %s</label>',
                $this->label,
                $dropdown
            );
        }
    }
}

/**
 * Wpopal TextArea Control Class
 * create custom textarea input field
 *
 * @since Wpopal v0.5
 **/

if ( class_exists( 'WP_Customize_Control' ) ) {
    # Adds textarea support to the theme customizer
    class Wpopal_Themer_PBRTextAreaControl extends WP_Customize_Control {
        public $type = 'textarea'; # can change to 'number' for input[type=number] field
        public function __construct( $manager, $id, $args = array() ) {
            $this->statuses = array( '' => esc_html__( 'Default', 'wpopal-themer' ) );
            parent::__construct( $manager, $id, $args );
        }

        public function render_content() {
            echo '<label>
                <span class="customize-control-title">' . esc_html( $this->label ) . '</span>
                <textarea rows="5" style="width:100%;" ';
            $this->link();
            echo '>' . esc_textarea( $this->value() ) . '</textarea>
                </label>';
        }
    }

}

if (  class_exists( 'WP_Customize_Control' ) ) {
     

    /**
     * Class to create a custom tags control
     */
    class Wpopal_Themer_Text_Editor_Custom_Control extends WP_Customize_Control
    {
          /**
           * Render the content on the theme customizer page
           */
          public function render_content()
           {
                ?>
                    <label>
                      <span class="customize-text_editor"><?php echo esc_html( $this->label ); ?></span>
                      <?php
                        $settings = array(
                          'textarea_name' => $this->id
                          );

                        wp_editor($this->value(), $this->id, $settings );
                      ?>
                    </label>
                <?php
           }
    }

}

/**
 * Wpopal Google Front Control Class
 *
 * @since Wpopal v2.1
 **/
if ( class_exists( 'WP_Customize_Control' ) ) {
    # Adds textarea support to the theme customizer
    class Wpopal_Themer_GoogleFontControl extends WP_Customize_Control {
    
        private $fonts = false;

        public function __construct($manager, $id, $args = array(), $options = array()){
            $this->fonts = get_transient( 'google_font_names_');

            if ( ! is_array( $this->fonts ) )
                $this->fonts = $this->get_font_names();

            if ( ! $this->fonts ) return;
            
            parent::__construct( $manager, $id, $args );

        }
    
        public function render_content() {
            if(!empty($this->fonts)) { ?>
                <label>
                    <span class="customize-category-select-control"><?php echo esc_html( $this->label ); ?></span>
                    <select <?php $this->link(); ?>>
                <?php
                foreach ( $this->fonts as $key => $value ) {
                    printf('<option value="%s">%s</option>',
                        $key,
                        $value);
                }
                ?>
                    </select>
                </label>
            <?php
            }
        }

        public function get_font_names() {
            
            $font_name_list = get_transient( 'google_font_names_');

            if ( $font_name_list )
                return $font_name_list;

            $json_name_list = @wp_remote_get( 'https://www.googleapis.com/webfonts/v1/webfonts?sort=popularity&key=AIzaSyBWVfrVgpz5SYM-inIZL4SpzCzTPi4Dhrg' );

            if ( !isset( $json_name_list ) )
                return;

            $decoded_name_list = @json_decode( $json_name_list[ 'body'] );

            $font_name_list[ 'none' ] = 'none';

            if ( is_object( $decoded_name_list ) )
                foreach ( $decoded_name_list->items as $font_name )
                    $font_name_list[ str_replace( ' ', '+', $font_name->family ) ] = $font_name->family;

            set_transient( 'google_font_names_', $font_name_list, 60 * 60 *24 );
            return $font_name_list;
        }
    }
}
?>
<?php
/**
 * Wpopal_Themer Customizer support
 *
 * @package WpOpal
 * @subpackage Wpopal_Themer
 * @since Wpopal_Themer 1.0
 */

/**
 * Implement Customizer additions and adjustments.
 *
 * @since Wpopal_Themer 1.0
 *
 * @param WP_Customize_Manager $wp_customize Customizer object.
 */
function wpopal_themer_fnc_customize_register( $wp_customize ) {
    // Add postMessage support for site title and description.
    $wp_customize->get_setting( 'blogname' )->transport         = 'postMessage';
    $wp_customize->get_setting( 'blogdescription' )->transport  = 'postMessage';
    $wp_customize->get_setting( 'header_textcolor' )->transport = 'postMessage';

    // Rename the label to "Site Title Color" because this only affects the site title in this theme.
    $wp_customize->get_control( 'header_textcolor' )->label = esc_html__( 'Site Title Color', 'wpopal-themer' );

    // Rename the label to "Display Site Title & Tagline" in order to make this option extra clear.
    $wp_customize->get_control( 'display_header_text' )->label = esc_html__( 'Display Site Title &amp; Tagline', 'wpopal-themer' );

    // Add custom description to Colors and Background controls or sections.
    if ( property_exists( $wp_customize->get_control( 'background_color' ), 'description' ) ) {
        $wp_customize->get_control( 'background_color' )->description = esc_html__( 'May only be visible on wide screens.', 'wpopal-themer' );
        $wp_customize->get_control( 'background_image' )->description = esc_html__( 'May only be visible on wide screens.', 'wpopal-themer' );
    } else {
        $wp_customize->get_section( 'colors' )->description           = esc_html__( 'Background may only be visible on wide screens.', 'wpopal-themer' );
        $wp_customize->get_section( 'background_image' )->description = esc_html__( 'Background may only be visible on wide screens.', 'wpopal-themer' );
    } 


    $wp_customize->add_setting('topbar_bg', array( 
        'default'    => get_option('topbar_bg'),
        'type'       => 'option',
        'capability' => 'manage_options',
        'transport'  => 'postMessage',
        'sanitize_callback' => 'sanitize_text_field'
    ) );
    
    $wp_customize->add_control('topbar_bg', array( 
        'label'    => esc_html__('Topbar Background', 'wpopal-themer'),
        'section'  => 'colors',
        'type'      => 'color',
    ) );
    $wp_customize->add_setting('topbar_color', array( 
        'default'    => get_option('footer_color'),
        'type'       => 'option',
        'capability' => 'manage_options',
        'transport'  => 'postMessage',
        'sanitize_callback' => 'sanitize_text_field'
    ) );
    
    $wp_customize->add_control('topbar_color', array( 
        'label'    => esc_html__('Topbar Text Color', 'wpopal-themer'),
        'section'  => 'colors',
        'type'      => 'color',
    ) );


    ///// 
    $wp_customize->add_setting('page_bg', array( 
        'default'    => get_option('page_bg'),
        'type'       => 'option',
        'capability' => 'manage_options',
        'transport'  => 'postMessage',
        'sanitize_callback' => 'sanitize_text_field'
    ) );
    
    $wp_customize->add_control('page_bg', array( 
        'label'    => esc_html__('Page Container Background', 'wpopal-themer'),
        'section'  => 'colors',
        'type'      => 'color',
        'default'   => '#FFFFFF'
    ) );
    
    //

    $wp_customize->add_setting('footer_bg', array( 
        'default'    => get_option('footer_bg'),
        'type'       => 'option',
        'capability' => 'manage_options',
        'transport'  => 'postMessage',
        'sanitize_callback' => 'sanitize_text_field'
    ) );
    
    $wp_customize->add_control('footer_bg', array( 
        'label'    => esc_html__('Footer Background', 'wpopal-themer'),
        'section'  => 'colors',
        'type'      => 'color',
    ) );

    $wp_customize->add_setting('footer_heading_color', array( 
        'default'    => get_option('footer_heading_color'),
        'type'       => 'option',
        'capability' => 'manage_options',
        'transport'  => 'postMessage',
        'sanitize_callback' => 'sanitize_text_field'
    ) );
    
    $wp_customize->add_control('footer_heading_color', array( 
        'label'    => esc_html__('Footer Heading Color', 'wpopal-themer'),
        'section'  => 'colors',
        'type'      => 'color',
    ) );


    $wp_customize->add_setting('footer_color', array( 
        'default'    => get_option('footer_color'),
        'type'       => 'option',
        'capability' => 'manage_options',
        'transport'  => 'postMessage',
        'sanitize_callback' => 'sanitize_text_field'
    ) );
    
    $wp_customize->add_control('footer_color', array( 
        'label'    => esc_html__('Footer Text Color', 'wpopal-themer'),
        'section'  => 'colors',
        'type'      => 'color',
    ) );


    ///

    $wp_customize->add_setting('header_image_link', array( 
        'default'    => get_option('footer_color'),
        'type'       => 'option',
        'capability' => 'manage_options',
        'transport'  => 'postMessage',
        'sanitize_callback' => 'esc_url_raw',
        'default'   => '#'
    ) );
    
    $wp_customize->add_control('header_image_link', array( 
        'label'    => esc_html__('Image Link', 'wpopal-themer'),
        'section'  => 'header_image',
        'type'      => 'text',
        'default'   => '#'
    ) );
}

add_action( 'customize_register', 'wpopal_themer_fnc_customize_register' );


function wpopal_themer_fnc_sanitize_textarea( $content ){
    return wp_kses_post( force_balance_tags( $content ) );
}


/**
 *
 */
add_action( 'customize_register', 'wpopal_themer_fnc_cst_customizer' );

function wpopal_themer_fnc_cst_customizer($wp_customize){

    # General Settings
    // Panel Header
    $wp_customize->add_section('pbr_cst_general_settings', array(
        'title'      => esc_html__('General Settings', 'wpopal-themer'),
        'description'    => esc_html__('Website General Settings', 'wpopal-themer'),
        'transport'  => 'postMessage',
        'priority'   => 10,
    ));

    // Parameter Options
    $wp_customize->add_setting('blogname', array( 
        'default'    => get_option('blogname'),
        'type'       => 'option',
        'capability' => 'manage_options',
        'transport'  => 'postMessage',
        'sanitize_callback' => 'sanitize_text_field'
    ) );

    $wp_customize->add_control('blogname', array( 
        'label'    => esc_html__('Site Title', 'wpopal-themer'),
        'section'  => 'pbr_cst_general_settings',
        'priority' => 1,
    ) );
     
    //
    $wp_customize->add_setting('blogdescription', array( 
        'default'    => get_option('blogdescription'),
        'type'       => 'option',
        'capability' => 'manage_options',
        'transport'  => 'postMessage',
        'sanitize_callback' => 'sanitize_text_field'
    ) );
    
    $wp_customize->add_control('blogdescription', array( 
        'label'    => esc_html__('Tagline', 'wpopal-themer'),
        'section'  => 'pbr_cst_general_settings',
        'priority' => 2,
    ) );

   
    // 
    $wp_customize->add_setting('display_header_text', array( 
        'default'    => 1,
        'type'       => 'option',
        'capability' => 'manage_options',
        'transport'  => 'postMessage',
        'sanitize_callback' => 'sanitize_text_field'
    ) );    
    $wp_customize->add_control( 'display_header_text', array(
        'settings' => 'header_textcolor',
        'label'    => esc_html__( 'Show Title & Tagline', 'wpopal-themer' ),
        'section'  => 'pbr_cst_general_settings',
        'type'     => 'checkbox',
        'priority' => 4,
    ) );

  
    
     /* 
     * Custom payment 
     */
     $wp_customize->add_setting('wpopal_theme_options[image-payment]', array(
        'default'    => '',
        'type'       => 'option',
        'capability' => 'manage_options',
        'sanitize_callback' => 'esc_url_raw',
    ) );

    $wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'wpopal_theme_options[image-payment]', array(
        'label'    => esc_html__('Payment Logo', 'wpopal-themer'),
        'section'  => 'pbr_cst_general_settings',
        'settings' => 'wpopal_theme_options[image-payment]',
        'priority' => 11,
    ) ) );

    //
    $wp_customize->add_setting('wpopal_theme_options[copyright_text]', array(
        'default'    => 'Copyright 2016 - WPOPAL - All Rights Reserved.',
        'type'       => 'option',
        'transport'=>'refresh',
         'sanitize_callback' => 'wpopal_themer_fnc_sanitize_textarea',
    ) );

    $wp_customize->add_control( new Wpopal_Themer_PBRTextAreaControl( $wp_customize, 'wpopal_theme_options[copyright_text]', array(
        'label'    => esc_html__('Copyright text', 'wpopal-themer'),
        'section'  => 'pbr_cst_general_settings',
        'settings' => 'wpopal_theme_options[copyright_text]',
        'priority' => 12,
    ) ) );


    /* 
     * Custom breadcrumb 
     */
     $wp_customize->add_setting('wpopal_theme_options[breadcrumb-bg]', array(
        'default'    => '',
        'type'       => 'option',
        'capability' => 'manage_options',
        'sanitize_callback' => 'esc_url_raw',
    ) );

    $wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'wpopal_theme_options[breadcrumb-bg]', array(
        'label'    => esc_html__('Breadcrumb background', 'wpopal-themer'),
        'section'  => 'pbr_cst_general_settings',
        'settings' => 'wpopal_theme_options[breadcrumb-bg]',
        'priority' => 10,
    ) ) );
   /***************************************************************************
    * Theme Settings 
    ***************************************************************************/

  
   /**
     * General Setting
     */
    $wp_customize->add_section( 'ts_general_settings', array(
        'priority' => 12,
        'capability' => 'edit_theme_options',
        'theme_supports' => '',
        'title' => esc_html__( 'Themes And Layouts Setting', 'wpopal-themer' ),
        'description' => '',
    ) );

    //
    $wp_customize->add_setting( 'wpopal_theme_options[skin]', array(
        'type'       => 'option',
        'capability' => 'manage_options',
        'default'  => 'default',
         'sanitize_callback' => 'sanitize_text_field'
    ) );

    $wp_customize->add_control( 'wpopal_theme_options[skin]', array(
        'label'      => esc_html__( 'Active Skin', 'wpopal-themer' ),
        'section'    => 'ts_general_settings',
        'type'    => 'select',
        'choices'    => wpopal_themer_fnc_cst_skins(),
    ) );

     $wp_customize->add_setting( 'wpopal_theme_options[headerlayout]', array(
        'type'       => 'option',
        'capability' => 'manage_options',
        'default'  => '',
        'sanitize_callback' => 'sanitize_text_field'
    ) );

    $wp_customize->add_control( 'wpopal_theme_options[headerlayout]', array(
        'label'      => esc_html__( 'Header Layout Style', 'wpopal-themer' ),
        'section'    => 'ts_general_settings',
        'type'    => 'select',
         'choices' => array(''=>'Default'), 
         'choices'    => wpopal_themer_fnc_get_header_layouts(),
    ) );

    /* 
     * Custom Logo 
     */
    $wp_customize->add_setting('wpopal_theme_options[logo2]', array(
        'default'    => '',
        'type'       => 'option',
        'capability' => 'manage_options',
        'sanitize_callback' => 'esc_url_raw',
    ) );

    $wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'wpopal_theme_options[logo2]', array(
        'label'    => esc_html__('Logo For Absolute Header', 'wpopal-themer'),
        'section'  => 'ts_general_settings',
        'settings' => 'wpopal_theme_options[logo2]',
        'priority' => 10,
    ) ) );


    $wp_customize->add_setting('wpopal_theme_options[keepheader]', array(
        'capability' => 'edit_theme_options',
        'type'       => 'option',
        'default'   => 0,
        'checked' => 1,
        'sanitize_callback' => 'sanitize_text_field'
    ) );

    $wp_customize->add_control('wpopal_theme_options[keepheader]', array(
        'settings'  => 'wpopal_theme_options[keepheader]',
        'label'     =>  esc_html__( 'Keep Header', 'wpopal-themer' ),
        'section'   => 'ts_general_settings',
        'type'      => 'checkbox',
        'transport' => 4,
    ) );



    $wp_customize->add_setting( 'wpopal_theme_options[footer-style]', array(
        'type'           => 'option',
        'capability'     => 'manage_options',
        'default'        => 'default'   ,
        'sanitize_callback' => 'sanitize_text_field'
        //  'theme_supports' => 'static-front-page',
    ) );
    
     $wp_customize->add_control( 'wpopal_theme_options[footer-style]', array(
        'label'      => esc_html__( 'Footer Styles Builder', 'wpopal-themer' ),
        'section'    => 'ts_general_settings',
        'type'       => 'select',
        'choices'    => wpopal_themer_fnc_get_footer_profiles()
    ) );
     
 

    /******************************************************************
     * Social share
     ******************************************************************/
    $wp_customize->add_section( 'social_share_settings', array(
        'priority' => 50,
        'capability' => 'edit_theme_options',
        'theme_supports' => '',
        'title' => esc_html__( 'Social Share setting', 'wpopal-themer' ),
        'description' => '',
    ) );

    // Share facebook
    wpopal_themer_fnc_social_config( $wp_customize, 'facebook_share_blog', esc_html__('Share facebook ', 'wpopal-themer'), 'social_share_settings');
    //share twitter
    wpopal_themer_fnc_social_config( $wp_customize, 'twitter_share_blog', esc_html__('Share twitter ', 'wpopal-themer'), 'social_share_settings');
    //share linkedin
    wpopal_themer_fnc_social_config( $wp_customize, 'linkedin_share_blog', esc_html__('Share linkedin ', 'wpopal-themer'), 'social_share_settings');
    //share tumblr
    wpopal_themer_fnc_social_config( $wp_customize, 'tumblr_share_blog', esc_html__('Share tumblr ', 'wpopal-themer'), 'social_share_settings');
    //share google plus
    wpopal_themer_fnc_social_config( $wp_customize, 'google_share_blog', esc_html__('Share google plus ', 'wpopal-themer'), 'social_share_settings');
    //share pinterest
    wpopal_themer_fnc_social_config( $wp_customize, 'pinterest_share_blog', esc_html__('Share pinterest ', 'wpopal-themer'), 'social_share_settings');
    //share mail
    wpopal_themer_fnc_social_config( $wp_customize, 'mail_share_blog', esc_html__('Share mail ', 'wpopal-themer'), 'social_share_settings');


    /******************************************************************
     * Navigation
     ******************************************************************/

     # Sticky Top Bar Option
    $wp_customize->add_setting('wpopal_theme_options[verticalmenu]', array(
        'capability' => 'edit_theme_options',
        'type'       => 'option',
        'sanitize_callback' => 'sanitize_text_field'
    ) );

    $wp_customize->add_control('wpopal_theme_options[verticalmenu]', array(
        'settings'  => 'wpopal_theme_options[verticalmenu]',
        'label'     => esc_html__('Vertical Megamenu', 'wpopal-themer'),
        'section'   => 'nav',
        'type'      => 'select',
        'choices' => wpopal_themer_fnc_get_menugroups(),
    ) );
    


    # Sticky Top Bar Option
    $wp_customize->add_setting('wpopal_theme_options[megamenu-is-sticky]', array(
        'capability' => 'edit_theme_options',
        'type'       => 'option',
        'sanitize_callback' => 'sanitize_text_field'
    ) );

    $wp_customize->add_control('wpopal_theme_options[megamenu-is-sticky]', array(
        'settings'  => 'wpopal_theme_options[megamenu-is-sticky]',
        'label'     => esc_html__('Sticky Top Bar', 'wpopal-themer'),
        'section'   => 'nav',
        'type'      => 'checkbox',
        'transport' => 4,
    ) );   
 
    $wp_customize->add_setting( 'wpopal_theme_options[megamenu-duration]', array(
        'type'       => 'option',
        'capability' => 'manage_options',
        'default'  => '300',
        'sanitize_callback' => 'sanitize_text_field'
    ) );

    $wp_customize->add_control( 'wpopal_theme_options[megamenu-duration]', array(
        'label'      => esc_html__( 'Megamenu Duration', 'wpopal-themer' ),
        'section'    => 'nav',
        'type'    => 'text'
    ) );

    /*****************************************************************
     * Front Page Settings Panel
     *****************************************************************/   
    $wp_customize->add_section( 'static_front_page', array(
        'title'          => esc_html__( 'Front Page Settings', 'wpopal-themer' ),
        'priority'       => 120,
        'description'    => esc_html__( 'Your theme supports a static front page.', 'wpopal-themer'),
    ) );

    $wp_customize->add_setting( 'wpopal_theme_options[sidebar_position]', array(
        'default' => 'left',
        'capability'     => 'edit_theme_options',
        'type'           => 'option',
        'sanitize_callback' => 'sanitize_text_field'
    ) );
 
    $wp_customize->add_control( 'wpopal_theme_options[sidebar_position]', array(
        'type' => 'radio',
        'label' => 'Sidebar Position',
        'section' => 'static_front_page',
        'priority' => 1,
        'choices' => array(
            'left' => 'Left',
            'right' => 'Right',
        ),
    ) );

    $wp_customize->add_setting( 'show_on_front', array(
        'default'        => get_option( 'show_on_front' ),
        'capability'     => 'manage_options',
        'type'           => 'option',
        'sanitize_callback' => 'sanitize_text_field'
    ) );

    $wp_customize->add_control( 'show_on_front', array(
        'label'   => esc_html__( 'Front page displays', 'wpopal-themer' ),
        'section' => 'static_front_page',
        'type'    => 'radio',
        'choices' => array(
            'posts' => esc_html__( 'Your latest posts', 'wpopal-themer' ),
            'page'  => esc_html__( 'A static page', 'wpopal-themer' ),
        ),
    ) );
    
    $wp_customize->add_setting( 'page_on_front', array(
        'type'       => 'option',
        'capability' => 'manage_options',
        'sanitize_callback' => 'sanitize_text_field'
    ) );

    $wp_customize->add_control( 'page_on_front', array(
        'label'      => esc_html__( 'Front page', 'wpopal-themer' ),
        'section'    => 'static_front_page',
        'type'       => 'dropdown-pages',
    ) );

    $wp_customize->add_setting( 'page_for_posts', array(
        'type'           => 'option',
        'capability'     => 'manage_options',
        'sanitize_callback' => 'sanitize_text_field'
    ) );

    $wp_customize->add_control( 'page_for_posts', array(
        'label'      => esc_html__( 'Posts page', 'wpopal-themer' ),
        'section'    => 'static_front_page',
        'type'       => 'dropdown-pages',
    ) );


    /* 
     /*****************************************************************
     * Front Page Settings Panel
     *****************************************************************/   
    $wp_customize->add_section( 'pages_setting', array(
        'title'          => esc_html__( 'Pages Settings', 'wpopal-themer' ),
        'priority'       => 120,
        'description'    => esc_html__( 'Your theme supports a static front page.', 'wpopal-themer'),
    ) );

     
    $wp_customize->add_setting( 'wpopal_theme_options[404_post]', array(
        'type'           => 'option',
        'capability'     => 'manage_options',
        'default'        => ''   ,
        'sanitize_callback' => 'sanitize_text_field'
    ) );
    
     $wp_customize->add_control( 'wpopal_theme_options[404_post]', array(
        'label'      => esc_html__( '404 Page', 'wpopal-themer' ),
        'section'    => 'pages_setting',
        'type'       => 'dropdown-pages',
    ) );

}


function wpopal_themer_fnc_social_config( $wp_customize, $id, $name_social, $section){
    $wp_customize->add_setting('wpopal_theme_options['.$id.']', array(
        'capability' => 'edit_theme_options',
        'type'       => 'option',
        'default'   => 1,
        'checked' => 1,
        'sanitize_callback' => 'sanitize_text_field'
    ) );

    $wp_customize->add_control('wpopal_theme_options['.$id.']', array(
        'settings'  => 'wpopal_theme_options['.$id.']',
        'label'     => $name_social,
        'section'   => $section,
        'type'      => 'checkbox',
        'transport' => 4,
    ) );
}



 
add_action( 'customize_register', 'wpopal_themer_fnc_blog_settings' );
function wpopal_themer_fnc_blog_settings( $wp_customize ){
    
    $wp_customize->add_panel( 'panel_blog', array(
        'priority' => 80,
        'capability' => 'edit_theme_options',
        'theme_supports' => '',
        'title' => esc_html__( 'Blog & Post', 'wpopal-themer' ),
        'description' =>esc_html__( 'Make default setting for page, general', 'wpopal-themer' ),
    ) );


    /**
     * General Setting
     */
    $wp_customize->add_section( 'blog_general_settings', array(
        'priority' => 10,
        'capability' => 'edit_theme_options',
        'theme_supports' => '',
        'title' => esc_html__( 'General Setting', 'wpopal-themer' ),
        'description' => '',
        'panel' => 'panel_blog',
    ) );

    
    

    /**
     * Archive Setting
     */
    $wp_customize->add_section( 'archive_general_settings', array(
        'priority' => 11,
        'capability' => 'edit_theme_options',
        'theme_supports' => '',
        'title' => esc_html__( 'Archive & Categgory Setting', 'wpopal-themer' ),
        'description' => '',
        'panel' => 'panel_blog',
    ) );

    $wp_customize->add_setting('wpopal_theme_options[blog-archive-column]', array(
        'capability' => 'edit_theme_options',
        'type'       => 'option',
        'default'   => '1',
        'sanitize_callback' => 'sanitize_text_field'
    ) );

    $wp_customize->add_control( 'wpopal_theme_options[blog-archive-column]', array(
        'label'      => esc_html__( 'Show Posts In', 'wpopal-themer' ),
        'section'    => 'archive_general_settings',
        'type'       => 'select',
        'choices'     => array(
            '1' => esc_html__('1 column', 'wpopal-themer' ),
            '2' => esc_html__('2 columns', 'wpopal-themer' ),
            '3' => esc_html__('3 columns', 'wpopal-themer' ),
            '4' => esc_html__('4 columns', 'wpopal-themer' ),
            '6' => esc_html__('6 columns', 'wpopal-themer' ),
        )
    ) );

    $wp_customize->add_setting( 'wpopal_theme_options[blog-archive-layout]', array(
        'capability' => 'edit_theme_options',
        'type'       => 'option',
        'default'   => 'fullwidth',
        'sanitize_callback' => 'sanitize_text_field'
    ) );

    $wp_customize->add_control( new Wpopal_Themer_Layout_DropDown( $wp_customize,  'wpopal_theme_options[blog-archive-layout]', array(
        'settings'  => 'wpopal_theme_options[blog-archive-layout]',
        'label'     => esc_html__('Archive Layout', 'wpopal-themer'),
        'section'   => 'archive_general_settings' 
    ) ) );

  
    $wp_customize->add_setting( 'wpopal_theme_options[blog-archive-left-sidebar]', array(
        'capability' => 'edit_theme_options',
        'type'       => 'option',
        'default'   => 'blog-sidebar-left',
        'sanitize_callback' => 'sanitize_text_field'
    ) );

    
    $wp_customize->add_control( new Wpopal_Themer_Sidebar_DropDown( $wp_customize, 'wpopal_theme_options[blog-archive-left-sidebar]', array(
        'settings'  => 'wpopal_theme_options[blog-archive-left-sidebar]',
        'label'     => esc_html__('Archive Left Sidebar', 'wpopal-themer'),
        'section'   => 'archive_general_settings' ,
    ) ) );

     /// 
    $wp_customize->add_setting( 'wpopal_theme_options[blog-archive-right-sidebar]', array(
        'capability' => 'edit_theme_options',
        'type'       => 'option',
        'default'   => 'blog-sidebar-right',
        'sanitize_callback' => 'sanitize_text_field'
    ) );

    $wp_customize->add_control( new Wpopal_Themer_Sidebar_DropDown( $wp_customize, 'wpopal_theme_options[blog-archive-right-sidebar]', array(
        'settings'  => 'wpopal_theme_options[blog-archive-right-sidebar]',
        'label'     => esc_html__('Archive Right Sidebar', 'wpopal-themer'),
        'section'   => 'archive_general_settings',
    ) ) );

    /**
     * Single post Setting
     */
    $wp_customize->add_section( 'blog_single_settings', array(
        'priority' => 12,
        'capability' => 'edit_theme_options',
        'theme_supports' => '',
        'title' => esc_html__( 'Single post Setting', 'wpopal-themer' ),
        'description' => '',
        'panel' => 'panel_blog',
    ) );

    
    $wp_customize->add_setting('wpopal_theme_options[blog-show-share-post]', array(
        'capability' => 'edit_theme_options',
        'type'       => 'option',
        'default'   => 0,
        'checked' => 0,
        'sanitize_callback' => 'sanitize_text_field'
    ) );

    $wp_customize->add_control('wpopal_theme_options[blog-show-share-post]', array(
        'settings'  => 'wpopal_theme_options[blog-show-share-post]',
        'label'     => esc_html__('Show share post', 'wpopal-themer'),
        'section'   => 'blog_single_settings',
        'type'      => 'checkbox',
        'transport' => 4,
    ) );

    $wp_customize->add_setting('wpopal_theme_options[blog-show-related-post]', array(
        'capability' => 'edit_theme_options',
        'type'       => 'option',
        'default'   => 1,
        'checked' => 1,
        'sanitize_callback' => 'sanitize_text_field'
    ) );

    $wp_customize->add_control('wpopal_theme_options[blog-show-related-post]', array(
        'settings'  => 'wpopal_theme_options[blog-show-related-post]',
        'label'     => esc_html__('Show related post', 'wpopal-themer'),
        'section'   => 'blog_single_settings',
        'type'      => 'checkbox',
        'transport' => 4,
    ) );
    

    $wp_customize->add_setting( 'wpopal_theme_options[blog-items-show]', array(
        'type'       => 'option',
        'default'    => 4,
        'capability' => 'edit_theme_options',
        'sanitize_callback' => 'sanitize_text_field'
    ) );

    $wp_customize->add_control( 'wpopal_theme_options[blog-items-show]', array(
        'label'      => esc_html__( 'Number of related posts to show', 'wpopal-themer' ),
        'section'    => 'blog_single_settings',
        'type'       => 'select',
        'choices'     => array(
            2 => esc_html__('2 posts', 'wpopal-themer' ),
            3 => esc_html__('3 posts', 'wpopal-themer' ),
            4 => esc_html__('4 posts', 'wpopal-themer' ),
            5 => esc_html__('5 posts', 'wpopal-themer' ),
            6 => esc_html__('6 posts', 'wpopal-themer' ),
        )
    ) );   
    

       ///  single layout setting
    $wp_customize->add_setting( 'wpopal_theme_options[blog-single-layout]', array(
        'capability' => 'edit_theme_options',
        'type'       => 'option',
        'default'   => '',
        'sanitize_callback' => 'sanitize_text_field'
    ) );

    $wp_customize->add_control( new Wpopal_Themer_Layout_DropDown( $wp_customize,  'wpopal_theme_options[blog-single-layout]', array(
        'settings'  => 'wpopal_theme_options[blog-single-layout]',
        'label'     => esc_html__('Single Blog Layout', 'wpopal-themer'),
        'section'   => 'blog_single_settings' 
    ) ) );

   
    $wp_customize->add_setting( 'wpopal_theme_options[blog-single-left-sidebar]', array(
        'capability' => 'edit_theme_options',
        'type'       => 'option',
        'default'   => '',
        'sanitize_callback' => 'sanitize_text_field'
    ) );

    $wp_customize->add_control( new Wpopal_Themer_Sidebar_DropDown( $wp_customize,  'wpopal_theme_options[blog-single-left-sidebar]', array(
        'settings'  => 'wpopal_theme_options[blog-single-left-sidebar]',
        'label'     => esc_html__('Single blog Left Sidebar', 'wpopal-themer'),
        'section'   => 'blog_single_settings' 
    ) ) );

     $wp_customize->add_setting( 'wpopal_theme_options[blog-single-right-sidebar]', array(
        'capability' => 'edit_theme_options',
        'type'       => 'option',
        'default'   => '',
        'sanitize_callback' => 'sanitize_text_field'
    ) );

    $wp_customize->add_control( new Wpopal_Themer_Sidebar_DropDown( $wp_customize,  'wpopal_theme_options[blog-single-right-sidebar]', array(
        'settings'  => 'wpopal_theme_options[blog-single-right-sidebar]',
        'label'     => esc_html__('Single blog Right Sidebar', 'wpopal-themer'),
        'section'   => 'blog_single_settings' 
    ) ) );



}


function wpopal_themer_fnc_sanitize_layout( $layout ) {
    if ( ! in_array( $layout, array( 'grid', 'slider' ) ) ) {
        $layout = 'grid';
    }

    return $layout;
}

/**
 * Bind JS handlers to make Customizer preview reload changes asynchronously.
 *
 * @since Wpopal_Themer 1.0
 */
function wpopal_themer_fnc_customize_preview_js() {
    wp_enqueue_script( 'wpopal_themer_fnc_customizer', get_template_directory_uri() . '/js/customizer.js', array( 'customize-preview' ), '20131205', true );
}
add_action( 'customize_preview_init', 'wpopal_themer_fnc_customize_preview_js');

/**
 * Add contextual help to the Themes and Post edit screens.
 *
 * @since Wpopal_Themer 1.0
 */
function wpopal_themer_fnc_contextual_help() {
    if ( 'admin_head-edit.php' === current_filter() && 'post' !== $GLOBALS['typenow'] ) {
        return;
    }

    get_current_screen()->add_help_tab( array(
        'id'      => 'wpopal-themer',
        'title'   => esc_html__( 'Wpopal_Themer', 'wpopal-themer' ),
        'content' =>
            '<ul>' .
                '<li>' . sprintf( wp_kses_post( __( 'The home page features your choice of up to 6 posts prominently displayed in a grid or slider, controlled by a <a href="%1$s">tag</a>; you can change the tag and layout in <a href="%2$s">Appearance &rarr; Customize</a>. If no posts match the tag, <a href="%3$s">sticky posts</a> will be displayed instead.', 'wpopal-themer' ) ), esc_url( add_query_arg( 'tag', _x( 'featured', 'featured content default tag slug', 'wpopal-themer' ), admin_url( 'edit.php' ) ) ), admin_url( 'customize.php' ), admin_url( 'edit.php?show_sticky=1' ) ) . '</li>' .
                '<li>' . sprintf( wp_kses_post( __( 'Enhance your site design by using <a href="%s">Featured Images</a> for posts you&rsquo;d like to stand out (also known as post thumbnails). This allows you to associate an image with your post without inserting it. Wpopal_Themer uses featured images for posts and pages&mdash;above the title&mdash;and in the Featured Content area on the home page.', 'wpopal-themer' ) ), 'https://codex.wordpress.org/Post_Thumbnails#Setting_a_Post_Thumbnail' )  . '</li>' .
                '<li>' . sprintf( wp_kses_post( __( 'For an in-depth tutorial, and more tips and tricks, visit the <a href="%s">Wpopal_Themer documentation</a>.', 'wpopal-themer' ) ), 'https://codex.wordpress.org/Presta_Base' ) . '</li>' .
            '</ul>',
    ) );
}
add_action( 'admin_head-themes.php', 'wpopal_themer_fnc_contextual_help' );
add_action( 'admin_head-edit.php',   'wpopal_themer_fnc_contextual_help' );
