<?php
/*----------------------------------
 * Single image shortcode
 *--------------------------------*/

$output = $image_effect = $image = $image_title = $image_source = $image_external_link = $image_size = $image_size_el = $caption = $image_align = $on_click_action = $custom_link = $class = $ieclass = $image_full = $html = $css = $_html = '';
$size_array = array('full', 'medium', 'large', 'thumbnail');

$image_wrap = 'yes';

extract( $atts );

$default_src = kc_asset_url('images/get_start.jpg');

$image_source = $atts['image_source'];

$element_attributes = array();
$image_attributes = array();
$image_classes = array();
$image_url = '';
$image_id = $atts['image'];
$image_size = $atts['image_size'];
$on_click_action = $atts['on_click_action'];
$data_lightbox = '';
$_html = '';

$css_classes = array(
	'kc_shortcode',
	'kc_single_image',
	$atts['class']
);


if ( !empty( $css ) )
	$css_classes[] = $css;

$image_url = '';
$image_id = $atts['image'];
$image_size = $atts['image_size'];
$on_click_action = $atts['on_click_action'];
$data_lightbox = '';

if( !empty( $ieclass ) ){
	$image_classes[] = $ieclass;
}

if( $image_source == 'external_link' )
{

	$image_full = $atts['image_external_link'];
	$image_url = $image_full;
	$size = $atts['image_size_el'];

	if( !empty( $image_url ) )
		$image_attributes[] = 'src="'.$image_url.'"';
	else
		$image_attributes[] = 'src="'.$default_src.'"';

	if( empty( $image_full ) )
		$image_full = $default_src;

	if ( preg_match( '/(\d+)x(\d+)/', $size, $matches ) ) {
		$width = $matches[1];
		$height = $matches[2];
		$image_attributes[] = 'width="'.$width.'"';
		$image_attributes[] = 'height="'.$height.'"';
	}
}
else
{

	if( $image_source == 'media_library' )
	{
		$image_id = preg_replace( '/[^\d]/', '', $image_id );
	}
	else
	{
		$post_id = get_the_ID();
		if ( $post_id && has_post_thumbnail( $post_id ) ) {
			$image_id = get_post_thumbnail_id( $post_id );
		} else {
			$image_id = 0;
		}
	}

	$image_full_width = wp_get_attachment_image_src( $image_id, 'full' );
	$image_full = $image_full_width[0];
	

	if( in_array( $image_size, $size_array ) ){
		$image_data       = wp_get_attachment_image_src( $image_id, $image_size );
		$image_url        = $image_data[0];
	}else{
		$image_url 	= kc_tools::createImageSize( $image_full, $image_size );
	}


	if( !empty( $image_url ) )
	{
		$image_attributes[] = 'src="'.$image_url.'"';
	}
	else
	{
		$image_attributes[] = 'src="'.$default_src.'"';
		$image_classes[] = 'kc_image_empty';
	}


	if( empty( $image_full ) )
		$image_full = $default_src;

}

$image_attributes[] = 'class="'.implode( ' ', $image_classes ).'"';

if( !empty( $alt ) )
	$image_attributes[] = 'alt="'. trim(esc_attr($alt)) .'"';
else
	$image_attributes[] = 'alt=""';


$title_link = $alt;

if( $on_click_action == 'lightbox' )
{
	$data_lightbox = 'rel="prettyPhoto" class="kc-pretty-photo"';
	wp_enqueue_script('prettyPhoto');
	wp_enqueue_style( 'prettyPhoto' );
}
else if( $on_click_action == 'open_custom_link' )
{
	$custom_link	= ( '||' === $custom_link ) ? '' : $custom_link;
    $custom_link	= kc_parse_link($custom_link);
    
    if ( strlen( $custom_link['url'] ) > 0 ) {
        $image_full 	= $custom_link['url'];
        $title_link 	= $custom_link['title'];
        $target 	= strlen( $custom_link['target'] ) > 0 ? $custom_link['target'] : '_self';
    }
}

// Check Disable Image Effect
if( $atts['image_effect_option'] != 'yes' )
{
	$image_effect = '';
}

//overlay layer
if( !empty( $overlay ) ){
    $_html = '<div class="kc-image-overlay">';
    if( !empty( $icon ) )
        $_html .= '<i class="' . $icon . '"></i>';
    $_html .= '</div>';
}


$css_class = implode(' ', $css_classes);
$element_attributes[] = 'class="' . esc_attr( trim( $css_class ) ) . ' ' . esc_attr( trim( $image_effect ) ) . '"';
if(!empty($image_align)){
	$element_attributes[] = 'style="text-align: ' . esc_attr( $image_align ) . ';"';
}

if( !empty($on_click_action) ){
	$html .= '<a '.$data_lightbox.' href="'.esc_url($image_full).'" title="'. strip_tags($title_link) .'" target="'.esc_attr( $target ). '"><img '. implode( ' ', $image_attributes ) .' />'.$_html.'</a>';
}else{
	$html .= '<img '. implode( ' ', $image_attributes ) .' />'.$_html;
}

if(!empty($caption)){
	$html .= '<p class="scapt">'.html_entity_decode( $caption ).'</p>';
}

if( $image_wrap === 'yes' )
	$output .= '<div ' . implode( ' ', $element_attributes ) . '>'.$html.'</div>';
else $output .= $html;

echo $output;
