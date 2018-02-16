<?php
 
extract( $atts );
?>

<div class="pbr-team <?php echo esc_attr($style); ?> <?php echo esc_attr($el_class) ?>">
    <div class="team-header">
       <?php $img = wp_get_attachment_image_src($photo,'full'); ?>
		<?php if( isset($img[0]) )  { ?>
			<img class="img-responsive" src="<?php echo esc_url( $img[0] );?>" alt="<?php echo esc_attr( $title ); ?>"  />
		<?php } ?>   
    </div>     
    <div class="team-body">
      
      <div class="team-body-content">
        <h3 class="team-name"><?php echo trim( $title ); ?></h3>
        <span class="team-job">
        <?php if($link_job){ ?>  
          <a class="btn-link-icon" href="<?php echo esc_url_raw($link_job); ?>">
        <?php } ?>    
          <?php echo esc_html($job); ?>
        <?php if($link_job){ ?>      
          </a>
        <?php } ?>    
         </span>
      </div>      
          
      <div class="bo-social-icons">
         <?php if( $facebook ){  ?>
   			<a class="bo-social-white radius-x" href="<?php echo esc_url( $facebook ); ?>"> <i  class="fa fa-facebook"></i> </a>
   		<?php } ?>
   		<?php if( $twitter ){  ?>
   			<a class="bo-social-white radius-x" href="<?php echo esc_url( $twitter ); ?>"><i  class="fa fa-twitter"></i> </a>
   		<?php } ?>
   		<?php if( $pinterest ){  ?>
   			<a class="bo-social-white radius-x" href="<?php echo esc_url( $pinterest ); ?>"><i  class="fa fa-pinterest"></i> </a>
   		<?php } ?>
   		<?php if( $google ){  ?>
   			<a class="bo-social-white radius-x" href="<?php echo esc_url( $google ); ?>"> <i  class="fa fa-google"></i></a>
   		<?php } ?>
                  
       </div>

    </div>  
    <?php if($information){ ?>
      <div class="team-info">
        <?php echo ($information); ?>
      </div>   
    <?php } ?>                                     
</div>

