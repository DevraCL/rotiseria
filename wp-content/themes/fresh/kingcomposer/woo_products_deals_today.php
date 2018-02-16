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

    
    $atts  = array_merge( array(
        'title' => 'Deals of today',
        'woocategory'  => '',
        'main_position'   => 'center',
    ), $atts); 

    extract( $atts );


    $number_post = 7;   
    $loop = wpopal_themer_woocommerce_query('deals', $number_post);
    $_id = wpopal_themer_makeid();

    if($loop->have_posts()):
?>
<div class="widget widget-deals">
    <h1 class="widget-title">
        <?php echo trim($title); ?>
    </h1>

    <?php
        $cats = array();
        if ( isset($woocategory) && !empty($woocategory) ){
            $categories = wpopal_themer_autocomplete_options_helper( $woocategory );
            if(is_array( $categories)){
                foreach( $categories as $key => $name):
                    $cats[] = $key;
                endforeach;
            }
        }

    ?>
    <?php if( !empty($cats)): ?>
        <div class="tab-categories">
            <ul class="nav nav-tabs" role="tablist">
                <li role="presentation" class="active"><a href="#all-deals_<?php echo esc_attr($_id);?>" aria-controls="all-deals_<?php echo esc_attr($_id);?>" role="tab" data-toggle="tab"><?php esc_html_e('All', 'fresh');?></a></li>
                <?php foreach($cats as $cat): ?>
                    <?php $category = get_term_by('slug', $cat, 'product_cat', 'ARRAY_A'); ?>
                    <li role="presentation"><a href="#<?php echo esc_attr($cat).'_'.$_id; ?>" aria-controls="<?php echo esc_attr($cat).'_'.$_id; ?>" role="tab" data-toggle="tab"><?php echo esc_attr($category['name']); ?></a></li>
                <?php endforeach; ?>
            </ul>
        </div>

        <!-- Tab panes -->
        <div class="tab-content">
            <div role="tabpanel" class="tab-pane active" id="all-deals_<?php echo esc_attr($_id);?>">
                <div class="row">
                    <?php $_count = 0; ?>
                    <?php while ( $loop->have_posts() ) : $loop->the_post();  
                        $product = wc_get_product();  
                        $time_sale = get_post_meta( $product->get_id(), '_sale_price_dates_to', true );
                    ?>
                    <?php switch ($main_position) {
                        case 'left':

                            if($_count %3 == 1): ?>
                                <div class="col-lg-3 col-md-3 col-xs-12 left">
                            <?php elseif( $_count == 0): ?>
                                <div class="col-lg-6 col-md-6 col-xs-12 column">
                            <?php endif; ?>
                            <?php if($_count ==0): ?>
                                <div class="product-deals product">
                                    <?php wc_get_template_part( 'content', 'product-inner' ); ?>
                                    <div class="time">
                                        <?php if( $time_sale ) { ?>
                                        <div class="pts-countdown clearfix" data-countdown="countdown"
                                             data-date="<?php echo date('m',$time_sale).'-'.date('d',$time_sale).'-'.date('Y',$time_sale).'-'. date('H',$time_sale) . '-' . date('i',$time_sale) . '-' .  date('s',$time_sale) ; ?>">
                                        </div>
                                        <?php } ?>
                                    </div>
                                </div>
                            <?php else: ?>
                                <?php wc_get_template_part( 'content', 'product-list_grid' ); ?>
                            <?php endif; ?>                               
                            <?php if($_count%3 == 0 || $_count == $loop->post_count-1 ): ?>    
                                </div>
                            <?php endif; ?>
                            <?php $_count++;

                            break;
                        
                        case 'right':
                            if($_count %3 == 0 && $_count !=6): ?>
                                <div class="col-lg-3 col-md-3 col-xs-12 right">
                            <?php elseif($_count == 6): ?>
                                <div class="col-lg-6 col-md-6 col-xs-12 column">
                            <?php endif; ?>

                            <?php if($_count ==6): ?>
                                <div class="product-deals product">
                                    <?php wc_get_template_part( 'content', 'product-inner' ); ?>
                                    <div class="time">
                                        <?php if( $time_sale ) { ?>
                                        <div class="pts-countdown clearfix" data-countdown="countdown"
                                             data-date="<?php echo date('m',$time_sale).'-'.date('d',$time_sale).'-'.date('Y',$time_sale).'-'. date('H',$time_sale) . '-' . date('i',$time_sale) . '-' .  date('s',$time_sale) ; ?>">
                                        </div>
                                        <?php } ?>
                                    </div>
                                </div>
                            <?php else: ?>
                                <?php wc_get_template_part( 'content', 'product-list_grid' ); ?>
                            <?php endif; ?>                               
                            <?php if($_count ==6 || $_count%3 ==2 || $_count == $loop->post_count-1 ): ?>    
                                </div>
                            <?php endif; ?>
                            <?php $_count++;
                            break;

                        default:
                            if($_count == 0 || $_count == 4 ): ?>
                                <div class="col-lg-3 col-md-3 col-xs-12">
                            <?php elseif( $_count == 3): ?>
                                <div class="col-lg-6 col-md-6 col-xs-12 column">
                            <?php endif; ?>
                            <?php if($_count ==3): ?>
                                <div class="product-deals product">
                                    <?php wc_get_template_part( 'content', 'product-inner' ); ?>
                                    <div class="time">
                                        <?php if( $time_sale ) { ?>
                                        <div class="pts-countdown clearfix" data-countdown="countdown"
                                             data-date="<?php echo date('m',$time_sale).'-'.date('d',$time_sale).'-'.date('Y',$time_sale).'-'. date('H',$time_sale) . '-' . date('i',$time_sale) . '-' .  date('s',$time_sale) ; ?>">
                                        </div>
                                        <?php } ?>
                                    </div>
                                </div>
                            <?php else: ?>
                                <?php wc_get_template_part( 'content', 'product-list_grid' ); ?>
                            <?php endif; ?>                               
                            <?php if($_count ==2 || $_count%3 == 0 && $_count!=0|| $_count == $loop->post_count-1 ): ?>    
                                </div>
                            <?php endif; ?>
                            <?php $_count++;

                            break;
                    }?>
                    <?php endwhile; ?>
                    <?php wp_reset_postdata(); ?>
                </div>
            </div>
            <?php foreach($cats as $key=>$cat): ?>
                <?php $loop_1 = wpopal_themer_woocommerce_query('deals', $number_post, $cat); ?>

                <?php if($loop_1->have_posts()): ?>
                    <div role="tabpanel" class="tab-pane" id="<?php echo esc_attr($cat).'_'.$_id; ?>">
                        <div class="row">
                        <?php $_count = 0; ?>
                        <?php while ( $loop_1->have_posts() ) : $loop_1->the_post();  
                            $product = wc_get_product();  
                            $time_sale = get_post_meta( $product->get_id(), '_sale_price_dates_to', true );
                        ?>
                        <?php switch ($main_position) {
                            case 'left':

                                if($_count %3 == 1): ?>
                                <div class="col-lg-3 col-md-3 col-xs-12">
                                <?php elseif( $_count == 0): ?>
                                    <div class="col-lg-6 col-md-6 col-xs-12 column">
                                <?php endif; ?>
                                <?php if($_count ==0): ?>
                                    <div class="product-deals product">
                                        <?php wc_get_template_part( 'content', 'product-inner' ); ?>
                                        <div class="time">
                                            <?php if( $time_sale ) { ?>
                                            <div class="pts-countdown clearfix" data-countdown="countdown"
                                                 data-date="<?php echo date('m',$time_sale).'-'.date('d',$time_sale).'-'.date('Y',$time_sale).'-'. date('H',$time_sale) . '-' . date('i',$time_sale) . '-' .  date('s',$time_sale) ; ?>">
                                            </div>
                                            <?php } ?>
                                        </div>
                                    </div>
                                <?php else: ?>
                                    <?php wc_get_template_part( 'content', 'product-list_grid' ); ?>
                                <?php endif; ?>                               
                                <?php if($_count%3 == 0 || $_count == $loop_1->post_count-1 ): ?>    
                                    </div>
                                <?php endif; ?>
                                <?php $_count++;

                                break;
                            
                            case 'right':
                                if($_count %3 == 0 && $_count !=6): ?>
                                <div class="col-lg-3 col-md-3 col-xs-12">
                                <?php elseif($_count == 6): ?>
                                    <div class="col-lg-6 col-md-6 col-xs-12 column">
                                <?php endif; ?>

                                <?php if($_count ==6): ?>
                                    <div class="product-deals product">
                                        <?php wc_get_template_part( 'content', 'product-inner' ); ?>
                                        <div class="time">
                                            <?php if( $time_sale ) { ?>
                                            <div class="pts-countdown clearfix" data-countdown="countdown"
                                                 data-date="<?php echo date('m',$time_sale).'-'.date('d',$time_sale).'-'.date('Y',$time_sale).'-'. date('H',$time_sale) . '-' . date('i',$time_sale) . '-' .  date('s',$time_sale) ; ?>">
                                            </div>
                                            <?php } ?>
                                        </div>
                                    </div>
                                <?php else: ?>
                                    <?php wc_get_template_part( 'content', 'product-list_grid' ); ?>
                                <?php endif; ?>                               
                                <?php if($_count ==6 || $_count%3 ==2 || $_count == $loop_1->post_count-1 ): ?>    
                                    </div>
                                <?php endif; ?>
                                <?php $_count++;
                                break;

                            default:
                                if($_count == 0 || $_count == 4 ): ?>
                                <div class="col-lg-3 col-md-3 col-xs-12">
                                <?php elseif( $_count == 3): ?>
                                    <div class="col-lg-6 col-md-6 col-xs-12 column">
                                <?php endif; ?>
                                <?php if($_count ==3): ?>
                                    <div class="product-deals product">
                                        <?php wc_get_template_part( 'content', 'product-inner' ); ?>
                                        <div class="time">
                                            <?php if( $time_sale ) { ?>
                                            <div class="pts-countdown clearfix" data-countdown="countdown"
                                                 data-date="<?php echo date('m',$time_sale).'-'.date('d',$time_sale).'-'.date('Y',$time_sale).'-'. date('H',$time_sale) . '-' . date('i',$time_sale) . '-' .  date('s',$time_sale) ; ?>">
                                            </div>
                                            <?php } ?>
                                        </div>
                                    </div>
                                <?php else: ?>
                                    <?php wc_get_template_part( 'content', 'product-list_grid' ); ?>
                                <?php endif; ?>                               
                                <?php if($_count ==2 || $_count%3 == 0 && $_count!=0|| $_count == $loop_1->post_count-1 ): ?>    
                                    </div>
                                <?php endif; ?>
                                <?php $_count++;

                                break;
                        }?>
                        <?php endwhile; ?>
                        <?php wp_reset_postdata(); ?>

                        </div>
                    </div>
                <?php endif; ?>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
    </div>
<?php endif; ?>