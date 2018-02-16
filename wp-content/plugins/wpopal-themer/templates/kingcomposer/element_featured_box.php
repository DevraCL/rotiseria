<?php

$icon = $style = $class = $align = $css = $title_style = '';
$atts  = array_merge( array(
		'title'       => '',
		'subtitle'    => '',
		'style'       => '',
		'info'        => '',
		'box_wrap_class' => '',
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
	$class .= ' '.$atts['icon'];
else $class .= ' fa-leaf';

$icon = '<i class="'.esc_attr($class).'" style="'.trim($style).'"></i>';

// style color title
if( !empty( $atts['title_color'] ) )
	$title_style .= 'style="color: '.$atts['title_color'].';"';
?>

<div class="feature-box feature-box-<?php echo esc_attr($box_style); ?> <?php echo esc_attr($box_wrap_class) ?>">
	<?php if($icon){ ?>
    <div class="fbox-icon">
        <?php echo $icon; ?>
    </div>
    <?php } ?>
      <div class="fbox-content">  
         <div class="fbox-body">                            
            <h4 <?php echo trim( $title_style); ?>><?php echo trim($title); ?></h4> 
            <?php if( $subtitle ) { ?>
            <small><?php echo esc_html($subtitle); ?></small>  
            <?php } ?>                       
         </div>
         <?php if(trim($info)!=''){ ?>
           <p class="description"><?php echo trim( $info );?></p>  
         <?php } ?>
      </div>      
</div>
