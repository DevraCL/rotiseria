<?php 
function wpopal_themer_enable_faq_setting_fields( ) { 
    add_settings_field(
            'enable_faq', // ID
            'Enable Faq', // Title ,
             'wpopal_themer_enable_faq_callback', // Callback
            'wpopalframework-setting-admin', // Page
            'setting_section_id' // Section           
        );  
}
add_action( 'wpopal_themer_add_setting_field', 'wpopal_themer_enable_faq_setting_fields' ); 

/** 
 * Get the settings option array and print one of its values
 */
function wpopal_themer_enable_faq_callback()
{
	$options = get_option( 'wpopal_themer_posttype' );
    printf(
        '<input type="checkbox" id="enable_faq" name="wpopal_themer_posttype[enable_faq]"  %s />',
        isset( $options['enable_faq'] ) && $options['enable_faq'] ?  'checked="checked"'  : ''
    );
}

