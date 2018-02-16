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
                        <span class="fa fa-angle-left"></span>
                    </a>
                    <a class="right carousel-control" href="#carousel-<?php the_ID(); ?>" data-slide="next">
                            <span class="fa fa-angle-right"></span>
                    </a>

                <?php } ?>
                 <div class="owl-carousel rows-products" data-slide="<?php echo esc_attr($columns); ?>" data-pagination="false" data-navigation="true">
                    <?php 
                         while ( $loop->have_posts() ) : $loop->the_post();  
                            $product = wc_get_product();  
                             $time_sale = get_post_meta( $product->get_id(), '_sale_price_dates_to', true );

                       
                    ?>
            
                            <div class="product <?php if($_count%$columns==0) echo ' last'; ?>">
                                <div class="product-block">
                                    <figure class="image pull-left">
                                        <span class="sale-off">
                                            <?php
                                            $percentage = round( ( ( $product->get_regular_price() - $product->get_sale_price() ) / $product->get_regular_price() ) * 100 );
                                                echo '-' . trim( $percentage ) . '%';
                                             ?>
                                        </span>
                                        <?php echo trim( $product->get_image('image-widgets') ); ?>
                                        <div class="button-action button-groups clearfix">
                                                                                        
                                            <?php
                                                if( class_exists( 'YITH_WCWL' ) ) {
                                                    echo do_shortcode( '[yith_wcwl_add_to_wishlist]' );
                                                }
                                            ?>   
                                    
                                            <?php if( class_exists( 'YITH_Woocompare' ) ) { ?>
                                                <?php
                                                    $action_add = 'yith-woocompare-add-product';
                                                    $url_args = array(
                                                        'action' => $action_add,
                                                        'id' => $product->get_id()
                                                    );
                                                ?>
                                                <div class="yith-compare">
                                                    <a title="<?php esc_html_e( 'Add to compare', 'wpopal-themer' ); ?>" href="<?php echo wp_nonce_url( add_query_arg( $url_args ), $action_add ); ?>" class="compare" data-product_id="<?php echo esc_attr($product->get_id()); ?>">
                                                        <i class="fa fa-exchange"></i>
                                                    </a>
                                                </div>
                                            <?php } ?>
                                            <?php if(wpopal_themer_fnc_theme_options('is-quickview', true)){ ?>
                                                <div class="quick-view hidden-xs">
                                                    <a title="<?php esc_html_e( 'Quick view', 'wpopal-themer' ); ?>" href="#" class="quickview" data-productslug="<?php echo trim($product->get_slug()); ?>" data-toggle="modal" data-target="#opal-quickview-modal">
                                                       <span><i class="fa fa-eye"> </i></span>
                                                    </a>
                                                </div>
                                            <?php } ?>
                                            <?php do_action( 'woocommerce_after_shop_loop_item' ); ?>
                                            <?php
                                                $action_add = 'yith-woocompare-add-product';
                                                $url_args = array(
                                                    'action' => $action_add,
                                                    'id' => $product->get_id()
                                                );
                                            ?>
                                        </div>
                                    </figure>

                                    <div class="caption media-body">
                                        <div class="deals-information">
                                            <h3 class="name">
                                                <a href="<?php echo esc_url( get_permalink( $product->get_id() ) ); ?>"><?php echo esc_attr( $product->get_title() ); ?></a>
                                            </h3>

                                            <div class="rating clearfix ">
                                                <?php if ( $rating_html = wc_get_rating_html( $product->get_average_rating() ) ) { ?>
                                                    <div><?php echo trim( $rating_html ); ?></div>
                                                <?php }else{ ?>
                                                    <div class="star-rating"></div>
                                                <?php } ?>
                                            </div>                                                                                    
                                            
                                            <div class="price"><?php echo trim( $product->get_price_html() ); ?></div>
                                            <div class="description"><?php echo wpopal_themer_excerpt(30,'...');; ?></div>        
                                        </div>
                                        <div class="time">
                                            <?php if( $time_sale ) { ?>
                                            <div class="pts-countdown clearfix" data-countdown="countdown"
                                                 data-date="<?php echo date('m',$time_sale).'-'.date('d',$time_sale).'-'.date('Y',$time_sale).'-'. date('H',$time_sale) . '-' . date('i',$time_sale) . '-' .  date('s',$time_sale) ; ?>">
                                            </div>
                                            <?php } ?>
                                        </div>                                        
                                    </div>
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
                                    <div class="product-block">
                                        <figure class="image">
                                            <div class="sale-off">
                                                <?php
                                                $percentage = round( ( ( $product->get_regular_price() - $product->get_sale_price() ) / $product->get_regular_price() ) * 100 );
                                                    echo '-' . trim( $percentage ) . '%';
                                                 ?>
                                            </div>
                                            <?php echo trim( $product->get_image('image-widgets') ); ?>                                            
                                        </figure>

                                        <div class="caption">
                                            <div class="deals-information">                                                
                                                <div class="rating clearfix ">
                                                    <?php if ( $rating_html = wc_get_rating_html( $product->get_average_rating() ) ) { ?>
                                                        <div><?php echo trim( $rating_html ); ?></div>
                                                    <?php }else{ ?>
                                                        <div class="star-rating"></div>
                                                    <?php } ?>
                                                </div>
                                                <h3 class="name">
                                                    <a href="<?php echo esc_url( get_permalink( $product->get_id() ) ); ?>"><?php echo esc_attr( $product->get_title() ); ?></a>
                                                </h3>
                                                <div class="price"><?php echo trim( $product->get_price_html() ); ?></div>
                                            </div>
                                            <div class="time">
                                                <?php if( $time_sale ) { ?>
                                                <div class="pts-countdown clearfix" data-countdown="countdown"
                                                     data-date="<?php echo date('m',$time_sale).'-'.date('d',$time_sale).'-'.date('Y',$time_sale).'-'. date('H',$time_sale) . '-' . date('i',$time_sale) . '-' .  date('s',$time_sale) ; ?>">
                                                </div>
                                                <?php } ?>
                                            </div>
                                        </div>
                                        <div class="button-action button-groups clearfix">
                                            <?php do_action( 'woocommerce_after_shop_loop_item' ); ?>
                                            <?php
                                                $action_add = 'yith-woocompare-add-product';
                                                $url_args = array(
                                                    'action' => $action_add,
                                                    'id' => $product->get_id()
                                                );
                                            ?>
                                            <?php
                                                if( class_exists( 'YITH_WCWL' ) ) {
                                                    echo do_shortcode( '[yith_wcwl_add_to_wishlist]' );
                                                }
                                            ?>   
                                    
                                            <?php if( class_exists( 'YITH_Woocompare' ) ) { ?>
                                                <?php
                                                    $action_add = 'yith-woocompare-add-product';
                                                    $url_args = array(
                                                        'action' => $action_add,
                                                        'id' => $product->get_id()
                                                    );
                                                ?>
                                                <div class="yith-compare">
                                                    <a title="<?php esc_html_e( 'Add to compare', 'wpopal-themer' ); ?>" href="<?php echo wp_nonce_url( add_query_arg( $url_args ), $action_add ); ?>" class="compare" data-product_id="<?php echo esc_attr($product->get_id()); ?>">
                                                        <i class="fa fa-exchange"></i>
                                                        <!-- <span><?php //esc_html_e('add to compare','wpopal-themer'); ?></span> -->
                                                    </a>
                                                </div>
                                            <?php } ?>
                                            <?php if(wpopal_themer_fnc_theme_options('is-quickview', true)){ ?>
                                                <div class="quick-view hidden-xs">
                                                    <a title="<?php esc_html_e( 'Quick view', 'wpopal-themer' ); ?>" href="#" class="quickview" data-productslug="<?php echo trim($product->get_slug()); ?>" data-toggle="modal" data-target="#pbr-quickview-modal">
                                                       <i class="fa fa-eye"> </i><span><?php esc_html_e( 'Quick view', 'wpopal-themer' ); ?></span>
                                                    </a>
                                                </div>
                                            <?php } ?>
                                        </div>
                                    
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
 
    <?php }

     
