<?php
$orderby = isset($order_by) ? $order_by : 'ID';
$order = isset($order_list) ? $order_list : 'ASC';

$tax_term = $show_date = $order = $main_color = $class = $blog_style = '';
$columns = 4;
$items =  12; 
$atts['post_type'] = 'post';
$atts['taxonomy'] = 'category';

$posts = get_posts( $atts );
$blog_style  = '';

extract( $atts );



$class       = $custom_class = '';
$css_class   = array( 'kc-post-layout-1');
$css_class[] = 'owl-carousel';

array_push( $css_class, $custom_class );

if( isset( $class ) )
	array_push( $css_class, $class );

 
ob_start();
 
 
$args = array(
	'paged' => 1,
	'posts_per_page' =>  $items,
	'post_status' => 'publish',
	'orderby'        	=> $orderby,
	'order' 			=> $order,
);
$loop = new WP_Query($args);
?>
<div class="blog-post">
	<div class="<?php echo esc_attr($blog_style); ?>-layout <?php echo esc_attr( implode( ' ', $css_class ) ) ;?>" data-owl-options='{"items" : <?php echo $columns; ?>, "tablet" : 2, "mobile" : 1, "pagination": "yes"}'>
		 <?php  // wpopal_themer_get_template_part(); ?>
		 	<?php if ( $loop->have_posts() ) : ?>
		 	<?php
					// Start the Loop.
					while ( $loop->have_posts()  ) : $loop->the_post();
						/*
						 * Include the post format-specific template for the content. If you want to
						 * use this in a child theme, then include a file called called content-___.php
						 * (where ___ is the post format) and that will be used instead.
						 */
						wpopal_themer_get_template_part( 'content', $blog_style  );

					endwhile;
					 

				else :
					// If no content, include the "No posts found" template.
					get_template_part( 'content', 'none' );

				endif;
			?>
	</div>	
</div>
<?php
$output = ob_get_clean();

echo $output;

wp_reset_postdata();