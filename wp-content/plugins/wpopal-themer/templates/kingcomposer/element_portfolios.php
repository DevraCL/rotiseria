<?php
/**
 * $Desc
 *
 * @version    $Id$
 * @package    wpbase
 * @author     Wpopal Team <opalwordpress@gmail.com>
 * @copyright  Copyright (C) 2015 wpopal.com. All Rights Reserved.
 * @license    GNU/GPL v2 or later http://www.gnu.org/licenses/gpl-2.0.html
 *
 * @website  http://www.wpopal.com
 * @support  http://www.wpopal.com/questions/
 */
wp_enqueue_style( 'isotope-css' );
wp_enqueue_script( 'isotope' );
$style = $remove_padding = '';
 
extract( $atts );

$_id = time()+rand();
$col = floor(12/$columns);
$smcol = ($col > 2)? 6: $col;
$class_column='col-lg-'.$col.' col-md-'.$col.' col-sm-'.$smcol;

$terms = get_terms('category_portfolio',array('orderby'=>'id'));
$args = array(
  'post_type' 		=> 'portfolio',
  'posts_per_page'  => $items
);
$loop = new WP_Query($args); ?>

  <?php if( $loop->have_posts()): ?>
	  <!-- filters category -->
		<div id="filters"  class="tab-v8 space-50">
		    <div class="nav-inner">
			      <ul class="nav nav-tabs isotope-filter categories_filter" data-related-grid="isotope-<?php echo esc_attr( $_id ); ?>">
			        <?php
			       
			        echo '<li class="active"><a href="javascript:void(0)" title="" data-option-value=".all">'.__('All', 'wpopal-themer'	).'</a></li>';

			        if ( !empty($terms) && !is_wp_error($terms) ){
			          	foreach ( $terms as $term ) {
			            	echo '<li><a href="javascript:void(0)" title="" data-option-value=".'.esc_attr( $term->slug ).'">'.esc_html($term->name).'</a></li>';
			            }
			        }
			        ?>
			      </ul>
		    </div>
		</div>

	   <div class="isotope-masonry portfolio-entries clearfix masonry-spaced" data-isotope-duration="400" id="isotope-<?php echo esc_attr( $_id ); ?>">
		<?php while($loop->have_posts()): $loop->the_post();

		$item_classes = 'all ';
		$item_cats = get_the_terms( $loop->post->ID, 'category_portfolio' );
		$cats_name = '';
		foreach((array)$item_cats as $item_cat){
			if(!empty($item_cats) && !is_wp_error($item_cats)){
				$item_classes .= $item_cat->slug . ' ';
				$cats_name .= $item_cat->name . ', ';
			}
		}
		if($cats_name) $cats_name = trim($cats_name, ', ');
			$image_attributes = wp_get_attachment_image_src( get_post_thumbnail_id( $loop->post->ID ), 'blog-thumbnails' );
		?>
		 <div class="portfolio-entries-masonry-entry masonry-item <?php echo esc_attr( $class_column ); ?> <?php echo esc_attr( $item_classes ); ?>">
		    <?php  wpopal_themer_get_template_part( 'content-portfolio',  $style ); ?>
		</div>
		<?php endwhile; ?>

	</div>
<?php endif; 
wp_reset_postdata();