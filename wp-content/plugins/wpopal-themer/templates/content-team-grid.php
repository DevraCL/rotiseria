<div class="item">  

	<!-- start items -->
	<?php 
	$data = array( 'google', 'job', 'phone_number', 'facebook', 'twitter', 'pinterest' );
	foreach( $data as $item ){
		$$item =  get_post_meta( get_the_ID(), 'team_'.$item, true ); 
	} 
	?>
	<div class="team-v1">
		<?php if( has_post_thumbnail() ): ?>
			<div class="team-header">
				<a href="<?php echo esc_url( get_permalink() );?>"><?php the_post_thumbnail('full', '', 'class="radius-x"');?> </a>
			</div>	 
		<?php endif;  ?>
		<div class="team-body">
			<div class="team-body-content">
				<h3 class="team-name"><a href="<?php echo esc_url( get_permalink() );?>"><?php the_title(); ?></a></h3>
				<p><?php echo esc_html( $job ); ?></p>
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
		<div class="team-info">
			<?php echo wpopal_themer_fnc_excerpt(10,'...'); ?>
		</div>
		<div class="readmore">
        	<a class="read-link" href="<?php the_permalink(); ?>" title="<?php esc_html_e( 'Read More', 'wpopal-themer' ); ?>"><?php esc_html_e( 'Read More', 'wpopal-themer' ); ?><i class="fa fa-angle-double-right"></i></a>
	    </div>
	</div>
</div>
<!-- end items -->