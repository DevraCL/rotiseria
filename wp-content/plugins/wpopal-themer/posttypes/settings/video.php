<?php 
function wpopal_themer_enable_video_setting_fields( ) { 
    add_settings_field(
            'enable_video', // ID
            'Enable Video', // Title ,
             'wpopal_themer_enable_video_callback', // Callback
            'wpopalframework-setting-admin', // Page
            'setting_section_id' // Section           
        );  
}
add_action( 'wpopal_themer_add_setting_field', 'wpopal_themer_enable_video_setting_fields' ); 

/** 
 * Get the settings option array and print one of its values
 */
function wpopal_themer_enable_video_callback()
{
	$options = get_option( 'wpopal_themer_posttype' );
    printf(
        '<input type="checkbox" id="enable_video" name="wpopal_themer_posttype[enable_video]"  %s />',
        isset( $options['enable_video'] ) && $options['enable_video'] ?  'checked="checked"'  : ''
    );
}

