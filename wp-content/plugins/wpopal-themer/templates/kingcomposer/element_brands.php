<?php
/**
 * $Desc
 *
 * @version    $Id$
 * @package    wpbase
 * @author     WPOpal  Team <opalwordpress@gmail.com?>
 * @copyright  Copyright (C) 2015 wpopal.com. All Rights Reserved.
 * @license    GNU/GPL v2 or later http://www.gnu.org/licenses/gpl-2.0.html
 *
 * @website  http://www.wpopal.com
 * @support  http://www.wpopal.com/questions/
 */

extract( $atts );

$_id = rand();

$args = array(
	'post_type'	     => 'brands',
	'posts_per_page' => $items
);

$loop = new WP_Query( $args );

if ( $loop->have_posts() ) :
	$_count = 0; 
?>
	<div class="brands-collection owl-carousel-play" id="productcarouse-<?php echo esc_attr($_id); ?>" data-ride="carousel">
		<?php   if( $loop->post_count > $columns ) { ?>
		<div class="carousel-controls carousel-controls-v1 carousel-hidden">
			<a href="#productcarouse-<?php echo esc_attr($_id); ?>" data-slide="prev" class="left carousel-control carousel-xs">
				<span class="fa fa-angle-left"></span>
			</a>
			<a href="#productcarouse-<?php echo esc_attr($_id); ?>" data-slide="next" class="right carousel-control carousel-xs">
				<span class="fa fa-angle-right"></span>
			</a>
		</div>
		<?php } ?>
		<div class="owl-carousel" data-slide="<?php echo esc_attr($columns); ?>"  data-singleItem="true" data-navigation="false" data-pagination="false">
		<?php while ( $loop->have_posts() ) : $loop->the_post();  ?>
				<?php
					$link = get_post_meta(get_the_ID(),'brands_brand_link',true);
					$link = $link ? $link : '#';
				?>
		 		<?php if ( has_post_thumbnail() ): ?>
		 		<a href="<?php echo esc_url($link); ?>" class="item-brand text-center" title="<?php the_title(); ?>">
					<?php the_post_thumbnail( 'brand-logo' ); ?>
				</a>
				<?php endif ; ?>
		<?php endwhile; ?>
		</div>
	</div>		
<?php endif; ?>
<?php wp_reset_postdata();