<?php 
function wpopal_themer_enable_team_setting_fields( ) { 
    add_settings_field(
            'enable_team', // ID
            'Enable Team', // Title ,
             'wpopal_themer_enable_team_callback', // Callback
            'wpopalframework-setting-admin', // Page
            'setting_section_id' // Section           
        );  
}
add_action( 'wpopal_themer_add_setting_field', 'wpopal_themer_enable_team_setting_fields' ); 

/** 
 * Get the settings option array and print one of its values
 */
function wpopal_themer_enable_team_callback()
{
	$options = get_option( 'wpopal_themer_posttype' );
    printf(
        '<input type="checkbox" id="enable_team" name="wpopal_themer_posttype[enable_team]"  %s />',
        isset( $options['enable_team'] ) && $options['enable_team'] ?  'checked="checked"'  : ''
    );
}

