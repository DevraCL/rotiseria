<?php
/**
 * mode Customizer support
 *
 * @package WpOpal
 * @subpackage fresh
 * @since fresh 1.0
 */

/**
 * Implement Customizer additions and adjustments.
 *
 * @since fresh 1.0
 *
 * @param WP_Customize_Manager $wp_customize Customizer object.
 */
function fresh_fnc_customize_register( $wp_customize ) {
	// Add postMessage support for site title and description.
	$wp_customize->get_setting( 'blogname' )->transport         = 'postMessage';
	$wp_customize->get_setting( 'blogdescription' )->transport  = 'postMessage';
	$wp_customize->get_setting( 'header_textcolor' )->transport = 'postMessage';

	// Rename the label to "Site Title Color" because this only affects the site title in this theme.
	$wp_customize->get_control( 'header_textcolor' )->label = esc_html__( 'Site Title Color', 'fresh' );

	// Rename the label to "Display Site Title & Tagline" in order to make this option extra clear.
	$wp_customize->get_control( 'display_header_text' )->label = esc_html__( 'Display Site Title &amp; Tagline', 'fresh' );

	// Add custom description to Colors and Background controls or sections.
	if ( property_exists( $wp_customize->get_control( 'background_color' ), 'description' ) ) {
		$wp_customize->get_control( 'background_color' )->description = esc_html__( 'May only be visible on wide screens.', 'fresh' );
		$wp_customize->get_control( 'background_image' )->description = esc_html__( 'May only be visible on wide screens.', 'fresh' );
	} else {
		$wp_customize->get_section( 'colors' )->description           = esc_html__( 'Background may only be visible on wide screens.', 'fresh' );
		$wp_customize->get_section( 'background_image' )->description = esc_html__( 'Background may only be visible on wide screens.', 'fresh' );
	} 

    // // / // 
    $wp_customize->add_setting('theme_color', array( 
        'default'    => get_option('theme_color'),
        'type'       => 'option',
        'capability' => 'manage_options',
        'transport'  => 'postMessage',
        'sanitize_callback' => 'sanitize_text_field'
    ) );
    
    $wp_customize->add_control('theme_color', array( 
        'label'    => esc_html__('Theme Color', 'fresh'),
        'section'  => 'colors',
        'type'      => 'color',
    ) );

    $wp_customize->add_setting('second_color', array( 
        'default'    => get_option('second_color'),
        'type'       => 'option',
        'capability' => 'manage_options',
        'transport'  => 'postMessage',
        'sanitize_callback' => 'sanitize_text_field'
    ) );
    
    $wp_customize->add_control('second_color', array( 
        'label'    => esc_html__('Second Color', 'fresh'),
        'section'  => 'colors',
        'type'      => 'color',
    ) );    
     
}

add_action( 'customize_register', 'fresh_fnc_customize_register' );