<?php
if ( ! defined( 'ABSPATH' ) ) {
	die( '-1' );
}

/**
 * Shortcode attributes
 * @var $atts
 * @var $title
 * @var $alias
 * @var $el_class
 * Shortcode class
 * @var $this WPBakeryShortCode_Rev_Slider_Vc
 */
$title = $alias = $class = '';
 
extract( $atts );
 
$output = ''; 
$output .= '<div class="' . esc_attr( $class ) . '">';
$output .= apply_filters( 'wpopalthemer_revslider_shortcode', do_shortcode( '[rev_slider ' . $alias . ']' ) );
$output .= '</div>';

echo $output;
