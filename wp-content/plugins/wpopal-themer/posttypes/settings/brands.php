<?php 
function wpopal_themer_enable_brands_setting_fields( ) { 
    add_settings_field(
            'enable_brands', // ID
            'Enable Brand', // Title ,
             'wpopal_themer_enable_brands_callback', // Callback
            'wpopalframework-setting-admin', // Page
            'setting_section_id' // Section           
        );  
}
add_action( 'wpopal_themer_add_setting_field', 'wpopal_themer_enable_brands_setting_fields' ); 

/** 
 * Get the settings option array and print one of its values
 */
function wpopal_themer_enable_brands_callback()
{
	$options = get_option( 'wpopal_themer_posttype' );
    printf(
        '<input type="checkbox" id="enable_brands" name="wpopal_themer_posttype[enable_brands]"  %s />',
        isset( $options['enable_brands'] ) && $options['enable_brands'] ?  'checked="checked"'  : ''
    );
}

