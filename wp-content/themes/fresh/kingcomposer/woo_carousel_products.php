<?php 
$type = 'recent_products';
$number_post = 10;
$category = '';
extract( $atts );
$_id = time().rand();

if( isset($woocategory) && !empty($woocategory) ){
	$category = array_keys( wpopal_themer_autocomplete_options_helper($woocategory) );
} 
$loop = wpopal_themer_woocommerce_query( $type, $number_post , $category  );


?>
<div class="products-collection owl-carousel-play woocommerce" id="postcarousel-<?php echo esc_attr($_id); ?>" data-ride="carousel">
	<?php   if( $loop->post_count > $columns ) { ?>
	<div class="carousel-controls">
		<a href="#postcarousel-<?php echo esc_attr($_id); ?>" data-slide="prev" class="left carousel-control">
			<i aria-hidden="true" class="fa fa-arrow-circle-o-left"></i>
		</a>
		<a href="#postcarousel-<?php echo esc_attr($_id); ?>" data-slide="next" class="right carousel-control">
			<i aria-hidden="true" class="fa fa-arrow-circle-o-right"></i>
		</a>
	</div>
	<?php } ?>
	<div class="owl-carousel" data-slide="<?php echo esc_attr($columns); ?>" data-jumpto="1" data-singleItem="true" data-navigation="false" data-pagination="false">
	<?php while ( $loop->have_posts() ) : $loop->the_post();  ?>
			<div data-test="1" <?php post_class( 'product-carousel-item' ); ?>><?php wc_get_template_part( 'content', 'product-inner' ); ?></div>
	<?php endwhile; ?>
	</div>
</div>	
<?php wp_reset_postdata(); ?>
