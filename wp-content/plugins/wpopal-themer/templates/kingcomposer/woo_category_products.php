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

$layout_type = 'carousel';
$style 		 = 'grid';

extract( $atts ); 
$_id = wpopal_themer_makeid();

if (isset($woocategory) && !empty($woocategory)):

    $categories = wpopal_themer_autocomplete_options_helper( $woocategory );
    $i = 0;
    $scolumn = $columns > 0 ? 12/$columns : 3;


?>
    <div class="widget widget-categoriestabs woocommerce">
        <div class="block-top clearfix">
        <?php if( !empty($title)): ?>
            <h3 class="widget-title pull-left">
                <span><?php echo esc_attr( $title ); ?></span>
            </h3>
        <?php endif; ?>
	        <div class="hidden-xs sub-categories">
	            <ul role="tablist" class="nav nav-tabs links">
	                <?php foreach ($categories as $category_slug => $name ) : ?>
	                    <?php $category = get_term_by( 'slug', $category_slug, 'product_cat' ); ?>
	                    <li<?php echo ($i == 0 ? ' class="active"' : ''); ?>>
	                        <a href="#tab-<?php echo esc_attr($_id);?>-<?php echo esc_attr($category_slug); ?>" data-toggle="tab"><?php echo trim( $category->name ); ?></a>
	                    </li>
	                <?php $i++; endforeach; ?>
	            </ul>
	        </div>
        </div>
       
        <div class="row">
            <?php if( !empty($image_cat) ) : ?>
                <?php $img = wp_get_attachment_image_src($image_cat,'full'); ?>
                <div class="col-lg-4 hidden-md hidden-sm hidden-xs banner-category effect-v10">
                    <img src="<?php echo esc_url_raw($img[0]); ?>" alt="">
                </div>
            <?php endif; ?>
            <div class="<?php echo !empty($image_cat) ? 'col-lg-8 col-xs-12' : 'col-xs-12'; ?>">
                <div class="tab-content">
                    <?php if ($layout_type == 'carousel'): ?>
                        <?php $i = 0; foreach ($categories as $category_slug => $name ) : ?>
                            <div id="tab-<?php echo esc_attr($_id);?>-<?php echo esc_attr($category_slug); ?>" class="tab-pane <?php echo ($i == 0 ? 'active' : ''); ?>">
                                <?php
                                    $_count = 0;
                                    $loop = wpopal_themer_woocommerce_query( $orderby, $per_page , array($category_slug) );
                                ?>
                                    
                                <div class="owl-carousel-play" data-ride="owlcarousel">
                                    <div class="owl-carousel grist-style" data-slide="<?php echo esc_attr($columns); ?>" data-pagination="false" data-navigation="true">
                                        <?php while ( $loop->have_posts() ) : $loop->the_post(); ?>
                                            <?php if ( $style == 'list' ):?>
                                            <div class="product-wrapper">
                                    	      	<?php wpopal_themer_get_template_part( 'woocommerce/content', 'product-list-inner' ); ?>
                                            </div>
                                            <?php else: ?>
                                            <div <?php post_class( 'product-wrapper' ); ?>><?php wc_get_template_part( 'content', 'product-inner' ); ?></div>
                                            <?php endif; ?>
                                        <?php  $_count++ ; endwhile; ?>
                                       
                                    </div>
                                    <?php if( $columns  < $_count) { ?>
                                    <div class="carousel-controls">
                                        <a class="left carousel-control" href="#" data-slide="prev">
                                            <span class="fa fa-angle-left"></span>
                                        </a>
                                        <a class="right carousel-control" href="#" data-slide="next">
                                            <span class="fa fa-angle-right"></span>
                                        </a>
                                    </div>
                                    <?php } ?>
                                </div>  
                                    
                            </div>
                        <?php $i++; endforeach; ?>
                    <?php else: ?>
                        <?php $i = 0; foreach ($categories as $category_slug => $name ) : ?>
                            <div id="tab-<?php echo esc_attr($_id);?>-<?php echo esc_attr($category_slug); ?>" class="tab-pane <?php echo ($i == 0 ? 'active' : ''); ?>">
                                <?php
                                    $_count = 0;
                                    $loop = wpopal_themer_woocommerce_query( $orderby, $per_page , array($category_slug) );
                                ?>
                                <div class="row list-style">
                                    <?php while ( $loop->have_posts() ) : $loop->the_post(); ?>
                                        <div class="col-sm-<?php echo esc_attr( $scolumn ); ?>">
                                            <?php if ( $style == 'list' ):?>
                                            <div class="product-wrapper">
                                                <?php wpopal_themer_get_template_part( 'woocommerce/content', 'product-list-inner' ); ?>
                                            </div>
                                            <?php else: ?>
                                            <div <?php post_class( 'product-wrapper' ); ?>><?php wc_get_template_part( 'content', 'product-inner' ); ?></div>
                                            <?php endif; ?>
                                        </div>
                                    <?php  $_count++ ; endwhile; ?>
                                   
                                </div>
                            </div>
                        <?php $i++; endforeach; ?>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
    <?php wp_reset_postdata(); ?>
<?php else : ?>
<div class="alert alert-warning"><?php _e( 'Please select category(ies) to display products in this module', 'wpopal-themer');?></div>    
<?php endif; ?>