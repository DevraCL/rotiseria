<?php 
function wpopal_themer_enable_megamenu_setting_fields( ) { 
    add_settings_field(
            'enable_megamenu', // ID
            'Enable Megamenu', // Title ,
             'wpopal_themer_enable_megamenu_callback', // Callback
            'wpopalframework-setting-admin', // Page
            'setting_section_id' // Section           
        );  
}
add_action( 'wpopal_themer_add_setting_field', 'wpopal_themer_enable_megamenu_setting_fields' ); 

/** 
 * Get the settings option array and print one of its values
 */
function wpopal_themer_enable_megamenu_callback()
{
	$options = get_option( 'wpopal_themer_posttype' );
    printf(
        '<input type="checkbox" id="enable_megamenu" name="wpopal_themer_posttype[enable_megamenu]"  %s />',
        isset( $options['enable_megamenu'] ) && $options['enable_megamenu'] ?  'checked="checked"'  : ''
    );
}

