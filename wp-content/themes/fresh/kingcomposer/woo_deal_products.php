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
        'number_post'  => 8,
        'columns'   => 4,
        'type'      => 'recent_products',
        'category'  => '',
        'subtitle'  => '',
        'layout'    => 'carousel'
    ), $atts); 

    extract( $atts );   

    $deals = array();
    $loop = wpopal_themer_woocommerce_query('deals', $number_post);
    $_id = wpopal_themer_makeid();
    $_count = 1;  
    switch ($columns) {
        case '5':
        case '4':
            $class_column='col-sm-6 col-md-3';
            $columns = 4; 
            break;
        case '3':
            $class_column='col-sm-4';
            break;
        case '2':
            $class_column='col-sm-6';
            break;
        default:
            $class_column='col-sm-12';
            break;
    }

    

    $_total =  $loop->found_posts;   

    if( $loop->have_posts()  ) {  ?> 
        <div class="woocommerce woo-deals">
        <?php if($layout == 'carousel'):?>
            <div id="carousel-<?php echo esc_attr($_id); ?>" class="inner owl-carousel-play" data-ride="owlcarousel">   
              
                <?php if( $_total > $columns ) {  ?>
                    <a class="left carousel-control" href="#carousel-<?php the_ID(); ?>" data-slide="prev">
                        <i aria-hidden="true" class="fa fa-arrow-circle-o-left"></i>
                    </a>
                    <a class="right carousel-control" href="#carousel-<?php the_ID(); ?>" data-slide="next">
                        <i aria-hidden="true" class="fa fa-arrow-circle-o-right"></i>
                    </a>

                <?php } ?>
                 <div class="owl-carousel rows-products" data-slide="<?php echo esc_attr($columns); ?>" data-pagination="false" data-navigation="true">
                    <?php 
                         while ( $loop->have_posts() ) : $loop->the_post();  
                            $product = wc_get_product();  
                             $time_sale = get_post_meta( $product->get_id(), '_sale_price_dates_to', true );

                       
                    ?>
            
                            <div class="product <?php if($_count%$columns==0) echo ' last'; ?>">                                
                                <?php wc_get_template_part( 'content', 'product-inner' ); ?>
                                <div class="time">
                                    <?php if( $time_sale ) { ?>
                                    <div class="pts-countdown clearfix" data-countdown="countdown"
                                         data-date="<?php echo date('m',$time_sale).'-'.date('d',$time_sale).'-'.date('Y',$time_sale).'-'. date('H',$time_sale) . '-' . date('i',$time_sale) . '-' .  date('s',$time_sale) ; ?>">
                                    </div>
                                    <?php } ?>
                                </div>
                            </div>
                         
                <?php 
                        $_count++; 
                    endwhile; 
                ?>
               <?php wp_reset_postdata(); ?>
                </div>
            </div>
            <?php elseif($layout == 'grid') : ?>
                 <div class="widget_products" id="<?php echo esc_attr($_id); ?>">
                    <div class="products-grid">
                        <?php     while ( $loop->have_posts() ) : $loop->the_post(); 

                            $product = wc_get_product();   
                          
                            $time_sale = get_post_meta( $product->get_id(), '_sale_price_dates_to', true );     
                        ?>
                        <?php if( $_count%$columns == 1 || $columns == 1 ) echo '<div class="item'.(($_count==1)?" active":"").'"><div class="row-products row">'; ?>
                       
                                <div class="product-wrapper product <?php echo esc_attr( $class_column ); if($_count%$columns==0) echo ' last'; ?>">
                                    <?php wc_get_template_part( 'content', 'product-inner' ); ?>
                                    <div class="time">
                                        <?php if( $time_sale ) { ?>
                                        <div class="pts-countdown clearfix" data-countdown="countdown"
                                             data-date="<?php echo date('m',$time_sale).'-'.date('d',$time_sale).'-'.date('Y',$time_sale).'-'. date('H',$time_sale) . '-' . date('i',$time_sale) . '-' .  date('s',$time_sale) ; ?>">
                                        </div>
                                        <?php } ?>
                                    </div>
                                </div>
                            <?php if( ($_count%$columns==0 && $_count!=1) || $_count== $_total || $columns ==1 ) echo '</div></div>'; ?>
                    <?php 
                            $_count++; 
                        endwhile; 
                    ?>
                    <?php wp_reset_postdata(); ?>
                    </div>
                </div>     

            <?php endif ?>    
        </div>
 
    <?php } ?>

     
