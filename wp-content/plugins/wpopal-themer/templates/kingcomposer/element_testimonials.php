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

$items = 10;
$columns = 4;
extract( $atts );

$_id = rand();

$args = array(
	'post_type' => 'testimonial',
	'posts_per_page' => $items,
	'post_status' => 'publish',
);

$query = new WP_Query($args);  	 
$_count = $query->post_count;
?>

	<?php if($query->have_posts()){ ?>
		<div class="testimonial-collection">
			<!-- Skin 1 -->
			<div id="carousel-<?php echo esc_attr($_id); ?>" class="owl-carousel-play" data-ride="owlcarousel">

				<?php if( $_count > $columns ) {  ?>
				<a class="left carousel-control" href="#carousel-<?php the_ID(); ?>" data-slide="prev">
					<span class="fa fa-angle-left"></span>
				</a>
				<a class="right carousel-control" href="#carousel-<?php the_ID(); ?>" data-slide="next">
					<span class="fa fa-angle-right"></span>
				</a>
				<?php } ?>

				<div class="owl-carousel " data-slide="<?php echo esc_attr($columns); ?>" data-pagination="true" data-navigation="true">
				<?php  $_count=0; while($query->have_posts()):$query->the_post(); ?>
					<!-- Wrapper for slides -->
					<div class="item">  
						<?php  wpopal_themer_get_template_part( 'content-testimonial'); ?>
					</div>
					<?php $_count++; ?>
				<?php endwhile; ?>
			</div>
			</div>
		</div>	
	<?php }

wp_reset_postdata();