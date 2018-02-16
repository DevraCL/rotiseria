<?php global $post; $image_attributes = array();  ?>
<div class="portfolio-content thumbnail theme-effect-1 text-center">
  <div class="ih-item">
  
      <div class="img">
          <?php if ( has_post_thumbnail()) {
            	the_post_thumbnail('medium-size');
            	 $image_attributes = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'blog-thumbnails' );
          }?>
      </div>
      <div class="info">
	        <div class="info-inner">
	            <h3><a class="text-white" href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
	 
            	<div class="entry-category">
           			 <?php esc_html_e('in', 'wpopal-themer'); the_category(); ?>
	            </div>
	 			<?php if( isset($image_attributes[0] ) ): ?>
	            <a class="hidden zoom" href="<?php echo esc_url_raw( $image_attributes[0] ); ?>" data-rel="prettyPhoto[pp_gal]"> <i class="fa fa-search radius-x space-padding-10 btn-primary"></i> </a>
	        	<?php endif; ?>
	        </div>    
      </div>
  </div>
</div>