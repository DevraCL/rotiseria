<?php 

	$meta = wpopal_func_metaboxes_fields();

	 
?>
<div class="portfolio-meta-info">
	<h4><?php _e( 'Information', 'wpopal-themer' ); ?></h4>	

	<ul>
		<?php foreach( $meta as $key => $item ) { if(  $item['id'] == "portfolio_video_link" ||  $item['id'] == "portfolio_file_advanced" || $item['id'] == 'portfolio_layout' ){ continue; } ?>
		 
		<li class="<?php echo $item['id']; ?>"><span class="meta-label"><?php echo trim( $item['name'] ); ?></span> :<?php echo get_post_meta(get_the_ID(), $item['id'],true); ?></li>
		<?php } ?>
		<li><span class="meta-label"><?php _e( 'Tags:' , 'wpopal-themer'); ?> </span> <?php the_tags( '<span class="tag-links">', '', '</span>' ); ?></li>
	</ul>	
</div>	