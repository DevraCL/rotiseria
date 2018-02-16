<?php

$icon = $style = $class = $align = $css = $title_style = '';
$atts  = array_merge( array(
        'title'          => '',
        'subtitle'       => '',
        'style'          => '',
        'info'           => '',
        'box_wrap_class' => '',
        'show_image'     => '',
        'featured_image' => '',
        'bg_color'       => '',
        'sub_color'      => '',
        'info_color'     => '',
    ), $atts); 
extract( $atts );

// size
if( isset( $atts['icon_size'] ) && !empty( $atts['icon_size'] ) ){
    $style .= 'font-size: '.$atts['icon_size'];
    if( is_numeric( $atts['icon_size'] ) )
        $style .= 'px;';
    else $style .= ';';
}
if( !empty( $atts['icon_color'] ) )
    $style .= 'color: '.$atts['icon_color'].';';

if( !empty( $atts['icon'] ) )
    $icon = '<i class="'.esc_attr($atts['icon']).'" style="'.trim($style).'"></i>';

// style color title
if( !empty( $atts['title_color'] ) )
    $title_style .= 'style="color: '.$atts['title_color'].';"';

if( !empty( $atts['bg_color'] ) )
    $bg_color = 'style="background-color: '.$atts['bg_color'].';"';
if( !empty( $atts['sub_color'] ) )
    $sub_color = 'style="color: '.$atts['sub_color'].';"';
if( !empty( $atts['info_color'] ) )
    $info_color = 'style="color: '.$atts['info_color'].';"';

$image_full_width = wp_get_attachment_image_src( $featured_image, 'full' );
$image_full = $image_full_width[0];
?>

<div <?php echo trim( $bg_color); ?> class="feature-box feature-box-<?php echo esc_attr($box_style); ?> <?php echo esc_attr($box_wrap_class) ?>">

    <?php if($show_image === 'yes'){ ?>
        <div class="fbox-img"><img src="<?php echo esc_url( $image_full ); ?>" alt="<?php echo trim($title); ?>"/></div>
    <?php } else { ?>
        <?php if(!empty($icon) || $icon){ ?>
            <div class="fbox-icon"><?php echo trim( $icon ); ?></div>
        <?php } ?>
    <?php } ?>

      <div class="fbox-content">  
         <div class="fbox-body"> 
             <?php if( $subtitle ) { ?>
                <small <?php echo trim( $sub_color); ?>><?php echo esc_html($subtitle); ?></small>  
            <?php } ?>                             
            <h4 <?php echo trim( $title_style); ?>><?php echo trim($title); ?></h4> 
                                 
         </div>
         <?php if(trim($info)!=''){ ?>
           <div <?php echo trim( $info_color); ?> class="description"><?php echo trim( $info );?></div>  
         <?php } ?>
      </div>      
</div>
