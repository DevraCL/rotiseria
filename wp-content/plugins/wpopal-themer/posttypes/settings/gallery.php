<?php 
function wpopal_themer_enable_gallery_setting_fields( ) { 
    add_settings_field(
            'enable_gallery', // ID
            'Enable Gallery', // Title ,
             'wpopal_themer_enable_gallery_callback', // Callback
            'wpopalframework-setting-admin', // Page
            'setting_section_id' // Section           
        );  
}
add_action( 'wpopal_themer_add_setting_field', 'wpopal_themer_enable_gallery_setting_fields' ); 

/** 
 * Get the settings option array and print one of its values
 */
function wpopal_themer_enable_gallery_callback()
{
	$options = get_option( 'wpopal_themer_posttype' );
    printf(
        '<input type="checkbox" id="enable_gallery" name="wpopal_themer_posttype[enable_gallery]"  %s />',
        isset( $options['enable_gallery'] ) && $options['enable_gallery'] ?  'checked="checked"'  : ''
    );
}

