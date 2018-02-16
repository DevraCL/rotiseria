<?php
/**
 * $Desc
 *
 * @version    $Id$
 * @package    wpbase
 * @author     WpOpal Team <opalwordpress@gmail.com>
 * @copyright  Copyright (C) 2016 http://www.wpopal.com. All Rights Reserved.
 * @license    GNU/GPL v2 or later http://www.gnu.org/licenses/gpl-2.0.html
 *
 * @website  http://www.wpopal.com
 * @support  http://www.wpopal.com/questions/
 */

extract( $atts );
 
$_id = wpopal_themer_makeid();
if($category == '' ) return;

$scolumns = $columns > 0 ? 12/$columns : 4;
$ocategory = get_term_by( 'slug', $category, 'product_cat' );
?>
<?php if ( !empty($ocategory) && !is_wp_error($ocategory) ): ?>
<div class="widget-productcats-tabs no-space-row woocommerce <?php echo isset($style) ? esc_attr($style) : ''; ?>">
 	<div class="row">
 		<div class="col-xs-12 col-sm-2 col-md-2 col-lg-2 product-tabs">
 			<h3 class="heading-text"><span><?php echo trim($ocategory->name); ?></span></h3>	
			
		  	<?php
		  	$args = array(
		       'hierarchical' => 1,
		       'show_option_none' => '',
		       'hide_empty' => 0,
		       'parent' => $ocategory->term_id,
		       'taxonomy' => 'product_cat',
		       'number' => $nb_subcategories
		    );
			$subcats = get_categories($args);

			if ( $subcats ) { ?>
				<div class="sub-categories">
					<ul class="bullets">
						<?php 
						foreach ( $subcats as $term ) {
						    $category_id = $term->term_id;
						    $category_name = $term->name;
						    $category_slug = $term->slug;

						    echo '<li><a href="'. esc_url( get_term_link($term->slug, 'product_cat') ) .'" title="'.esc_attr( $category_name).'">'.esc_html( $category_name ).'</a></li>';
						} ?>
				 	</ul>
				</div>
			<?php } ?>
 		</div>
	 	
		<?php if( !empty($image_cat) ) { ?>
			<div class="col-xs-12 col-md-3 col-lg-3 hidden-sm">
				<?php $img = wp_get_attachment_image_src($image_cat,'full'); ?>
				<div class="clearfix">
					<img src="<?php echo esc_url_raw($img[0]); ?>" title="<?php echo esc_attr($ocategory->name); ?>" alt="">
				</div>
			</div>
		<?php } ?>
		<div class="col-xs-12 col-sm-<?php echo !empty($image_cat) ? '10' : '10'; ?> col-md-<?php echo !empty($image_cat) ? '7' : '10'; ?> col-lg-<?php echo !empty($image_cat) ? '7' : '10'; ?>" >
			<div class="nav-inner">
		    	<ul role="tablist" class="links nav nav-tabs">
		      		<li class="active" data-action="wooloadproducts" data-slug="<?php echo trim( $category );?>" data-type="best_selling" data-show="<?php echo esc_attr( $columns );?>" data-limit="<?php echo esc_attr( $per_page );?>" data-href="#tab-<?php echo esc_attr($_id);?>1">
		        		<a  aria-expanded="false" data-toggle="tab" role="tab" href="#tab-<?php echo esc_attr($_id);?>1" ><?php esc_html_e( 'Best Seller', 'wpopal-themer'); ?></a>
		      		</li>
		      		<li  data-action="wooloadproducts" data-slug="<?php echo trim( $category );?>" data-type="newarrivals" data-show="<?php echo esc_attr( $columns );?>" data-limit="<?php echo esc_attr( $per_page );?>" data-href="#tab-<?php echo esc_attr($_id);?>2">
		        		<a aria-expanded="true" data-toggle="tab" role="tab" href="#tab-<?php echo esc_attr($_id);?>2" ><?php esc_html_e( 'New Arrivals', 'wpopal-themer'); ?></a>
		      		</li>
		    	</ul>
			</div>
		  	<div class="tab-content products products-grid">
			    <div id="tab-<?php echo esc_attr($_id);?>1" class="tab-pane active">
		    		<?php 
					$loop = wpopal_themer_woocommerce_query( 'best_selling', $per_page , array($ocategory->slug) );
					if ( $loop->have_posts() ) : ?>
						<?php if ($layout_type == 'carousel') : ?>
							<div class="owl-carousel-play" data-ride="owlcarousel">
								<div class="owl-carousel row-products" data-slide="<?php echo esc_attr( $columns );?>" data-pagination="false" data-navigation="true">
									 <?php $_count=0; while ( $loop->have_posts() ) : $loop->the_post(); ?>
									 		<div <?php post_class( 'product-wrapper' ); ?>><?php wc_get_template_part( 'content', 'product-inner' ); ?></div>
									 <?php  $_count++ ; endwhile; ?>
									 
								</div>
								<?php if( $columns  < $loop->post_count) { ?>
								<div class="carousel-controls carousel-hidden">
									<a class="left carousel-control" href="#carousel-<?php the_ID(); ?>" data-slide="prev">
											<span class="fa fa-angle-left"></span>
									</a>
									<a class="right carousel-control" href="#carousel-<?php the_ID(); ?>" data-slide="next">
											<span class="fa fa-angle-right"></span>
									</a>
								</div>
							 <?php } ?>
							</div>
						 
						<?php else : ?>
							<div class="row">
								<?php $_count=0; while ( $loop->have_posts() ) : $loop->the_post(); ?>
							 		<div class="col-sm-<?php echo esc_attr( $scolumns );?> product"><?php wc_get_template_part( 'content', 'product-inner' ); ?></div>
								<?php  $_count++ ; endwhile; ?>
								 
							</div>	
						<?php endif; ?>
					<?php endif; ?>

			    </div>
			    <div id="tab-<?php echo esc_attr($_id);?>2" class="tab-pane">
			    	<?php 

						 $loop2 = wpopal_themer_woocommerce_query( 'recent_product', $per_page , array($ocategory->slug) );
						 if ( $loop2->have_posts() ) : ?>
							<?php if ($layout_type == 'carousel') : ?>	 
								<div class="owl-carousel-play" data-ride="owlcarousel">
									<div class="owl-carousel row-products" data-slide="<?php echo esc_attr( $columns );?>" data-pagination="false" data-navigation="true">
										 <?php $_count=0; while ( $loop2->have_posts() ) : $loop2->the_post(); ?>
										 		<div class="product-wrapper product"><?php wc_get_template_part( 'content', 'product-inner' ); ?></div>
										 <?php  $_count++ ; endwhile; ?>
										 
									</div>
									<?php if( $columns  < $loop2->post_count) { ?>
									<div class="carousel-controls carousel-hidden">
										<a class="left carousel-control" href="#carousel-<?php the_ID(); ?>" data-slide="prev">
												<span class="fa fa-angle-left"></span>
										</a>
										<a class="right carousel-control" href="#carousel-<?php the_ID(); ?>" data-slide="next">
												<span class="fa fa-angle-right"></span>
										</a>
									</div>
								 <?php } ?>
								</div>
								 	
							<?php else : ?>
								<div class="row">
									<?php $_count=0; while ( $loop2->have_posts() ) : $loop2->the_post();?>
									 		<div class="col-sm-<?php echo esc_attr( $scolumns );?> product"><?php wc_get_template_part( 'content', 'product-inner' ); ?></div>
									<?php  $_count++ ; endwhile; ?>
									 
								</div>
							<?php endif; ?>
						<?php endif; ?>
			    </div>
		  	</div>
	  	</div>
  	</div>
</div>
<?php wp_reset_postdata(); ?>
<?php else : ?>
<div class="alert alert-warning"><?php _e( 'Please select category(ies) to display products in this module', 'wpopal-themer');?></div>    
<?php endif; ?>