<?php
    $link = get_post_meta( get_the_ID(), 'testimonials_link', true );
    $job = get_post_meta( get_the_ID(), 'testimonials_job', true );
    $excerpt = explode(' ', strip_tags(get_the_content( )), 15);
    array_pop($excerpt);
    $excerpt = implode(" ",$excerpt).'...';
    $excerpt = preg_replace('`[[^]]*]`','',$excerpt);

?>
<div class="testimonials testimonials-v1">
	<div class="testimonials-body">
	    <div class="testimonial-inner">
	    	<div class="image"><?php the_post_thumbnail('shop_thumbnail');?></div>   
		    <p class="testimonials-description"><?php echo trim( $excerpt ); ?></p>  
		    <div class="testimonials-profile"> 
		        <h5 class="testimonials-name">
		        	<?php the_title(); ?>
		        </h5>
       			<p class="text-muted testimonials-position">
		            <a href="<?php echo empty($link) ? '#' : esc_url( $link ); ?>">
		                <?php echo empty($job) ? '' : trim( $job ); ?>
		            </a>
		        </p>
		    </div>
	    </div>
	</div>		
</div>