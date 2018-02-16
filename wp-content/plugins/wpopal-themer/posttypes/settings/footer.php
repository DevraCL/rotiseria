<?php 
function wpopal_themer_enable_footer_setting_fields( ) { 
    add_settings_field(
            'enable_footer', // ID
            'Enable Footer', // Title ,
             'wpopal_themer_enable_footer_callback', // Callback
            'wpopalframework-setting-admin', // Page
            'setting_section_id' // Section           
        );  
}
add_action( 'wpopal_themer_add_setting_field', 'wpopal_themer_enable_footer_setting_fields' ); 

/** 
 * Get the settings option array and print one of its values
 */
function wpopal_themer_enable_footer_callback()
{
	$options = get_option( 'wpopal_themer_posttype' );
    printf(
        '<input type="checkbox" id="enable_footer" name="wpopal_themer_posttype[enable_footer]"  %s />',
        isset( $options['enable_footer'] ) && $options['enable_footer'] ?  'checked="checked"'  : ''
    );
}

