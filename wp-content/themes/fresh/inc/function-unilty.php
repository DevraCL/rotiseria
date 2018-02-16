<?php

/**
*  Function Customize add new field for nav menu option
*
*/
add_action( 'admin_enqueue_scripts','loadAdminStyles');
function loadAdminStyles(){
  wp_enqueue_script( 'custom-admin-scripts', get_template_directory_uri() . '/js/custom-admin.js', array( 'jquery'  ), '20131022', true );
}

function fresh_themer_fnc_megamenu_item_config_toplevel( $item ) {

  $item_id = esc_attr( $item->ID );
  ?>
  <p class="field-upload_icon description description-wide">   
    <label for="edit-menu-item-upload_icon-<?php echo esc_attr($item_id); ?>"><?php esc_html_e( 'Icon Upload:', "fresh" ); ?> <br>
      <input type="file" name="menu-item-upload_icon-<?php echo esc_attr($item_id); ?>" value="<?php echo esc_attr($item->upload_icon); ?>">
      <?php if(isset($item->upload_icon) && !empty($item->upload_icon)): ?>
        <br><img class="menu-item-icon-img-<?php echo esc_attr($item_id); ?>" src="<?php echo $item->upload_icon; ?>" alt="">
        <a data-id="<?php echo esc_attr($item_id); ?>" class="btn-remove-icon"><i class="icon-remove-sign"></i><?php esc_html_e('Remove');?> </a>
        <input type="hidden" class="menu-item-upload_icon-old-<?php echo esc_attr($item_id); ?>" name="menu-item-upload_icon-old-<?php echo esc_attr($item_id); ?>" value="<?php echo esc_attr($item->upload_icon); ?>">
      <?php endif;?>
    </label>
  </p>
  <?php 
}
add_action( 'wpopal_megamenu_item_config_toplevel', 'fresh_themer_fnc_megamenu_item_config_toplevel' );


add_action('wp_update_nav_menu_item', 'fresh_themer_fnc_custom_nav_update',10, 3);
function fresh_themer_fnc_custom_nav_update($menu_id, $menu_item_db_id, $args ) {
  
  if(isset($_POST["menu-item-upload_icon-old-".$menu_item_db_id]) && !empty($_POST["menu-item-upload_icon-old-".$menu_item_db_id])){
    update_post_meta( $menu_item_db_id,'upload_icon', $_POST["menu-item-upload_icon-old-".$menu_item_db_id] );
  }else{
    update_post_meta( $menu_item_db_id,'upload_icon', "");
  }
    if ( ! function_exists( 'wp_handle_upload' ) ) {
      require_once( ABSPATH . 'wp-admin/includes/file.php' );
    }

    if(!isset($_FILES['menu-item-upload_icon-'.$menu_item_db_id])){
      $_FILES['menu-item-upload_icon-'.$menu_item_db_id] = "";
    }
    $uploadedfile = $_FILES['menu-item-upload_icon-'.$menu_item_db_id];

    $upload_overrides = array( 'test_form' => false );

    $movefile = @wp_handle_upload( $uploadedfile, $upload_overrides );

    if ( $movefile && ! isset( $movefile['error'] ) ) {
     update_post_meta( $menu_item_db_id,'upload_icon', $movefile['url'] );
    }
}


/**
 * function to integrate with WPML which will display languages as buttons
 */

if( !function_exists("fresh_fnc_wpml_language_buttons") ){
   function fresh_fnc_wpml_language_buttons(){
     if( function_exists( 'icl_get_languages' ) ){
       $languages = icl_get_languages('skip_missing=N&orderby=KEY&order=DIR&link_empty_to=str');
       if( is_array( $languages ) ){

          foreach( $languages as $lang_k=>$lang ){
              if( $lang['active'] ){
                  $active_lang = $lang;
                  unset( $languages[$lang_k] );
              }
          }

          // disabled
          if( count( $languages ) ){
              $lang_status = 'enabled';
          } else {
              $lang_status = 'disabled';
          }

          echo '<div class="language wpml-languages quick-button box-group '. $lang_status .'">';

              echo '<div class="heading active" href="'. esc_url( $active_lang['url'] ).'" ontouchstart="this.classList.toggle(\'hover\');">';
                  echo '<img src="'. esc_url( $active_lang['country_flag_url'] ) .'" alt="'. esc_attr( $active_lang['translated_name'] ) .'"/>';
                  echo esc_attr( $active_lang['translated_name'] );
                  if( count( $languages ) ) echo '<i class="icon-down-open-mini"></i>';
              echo '</div>';

              if( count( $languages ) ){
                  echo '<ul class="wpml-lang-dropdown dropdown-menu list">';
                      foreach( $languages as $lang ){
                          echo '<li><a href="'. esc_url( $lang['url'] ) .'"><img src="'. esc_url( $lang['country_flag_url'] ) .'" alt="'. esc_attr( $lang['translated_name'] ) .'"/>'. esc_attr( $lang['translated_name'] ) .'</a></li>';
                      }
                  echo '</ul>';
              }

          echo '</div>';
        }
      }
   }
}


/**
 * Footer builder profile is custom post type, its content is shortcode rendering with visual composer
 *
 * @param $footer
 *
 */
if(function_exists('fresh_fnc_get_footer_profile_postdata')){
  function fresh_fnc_get_footer_profile_postdata( $footer ){

    if( is_numeric($footer) ){
        $post = get_post( $footer );
    }else {
        $post =  get_posts( array(
            'name' =>  $footer,
            'numberposts' => 1,
            'post_type' => 'footer' ) );
         $post = count($post) && $post?$post[0] :null;
    }
    wp_reset_postdata();
    return $post;
  }
}
if(function_exists('fresh_fnc_render_post_content')){
  function fresh_fnc_render_post_content( $post ){

    global $fresh_wpopconfig;

    $fresh_wpopconfig['type'] = 'footer';
    if($post){
        echo do_shortcode( $post->post_content );
    }

    $fresh_wpopconfig['type'] = '';
  }
}

/**
 * create a random key to use as primary key.
 */
if(!function_exists('fresh_fnc_makeid')){
    function fresh_fnc_makeid($length = 5){
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, strlen($characters) - 1)];
        }
        return $randomString;
    }
}



if(!function_exists('fresh_fnc_excerpt')){
    //Custom Excerpt Function
    function fresh_fnc_excerpt($limit,$afterlimit='[...]') {
        $excerpt = get_the_excerpt();
        if( $excerpt != ''){
           $excerpt = explode(' ', strip_tags( $excerpt ), $limit);
        }else{
            $excerpt = explode(' ', strip_tags(get_the_content( )), $limit);
        }
        if (count($excerpt)>=$limit) {
            array_pop($excerpt);
            $excerpt = implode(" ",$excerpt).' '.$afterlimit;
        } else {
            $excerpt = implode(" ",$excerpt);
        }
        $excerpt = preg_replace('`[[^]]*]`','',$excerpt);
        return strip_shortcodes( $excerpt );
    }
}

if(function_exists('fresh_fnc_get_widget_block_styles')){
function fresh_fnc_get_widget_block_styles(){
   return array(  'default' , 'primary', 'danger' , 'success', 'warning', 'coffe', 'bluesky' );
}
}
