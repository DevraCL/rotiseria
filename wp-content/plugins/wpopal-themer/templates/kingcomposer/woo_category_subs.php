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

if( $term_id && !empty($term_id) ){ 
    $term = get_term_by( 'slug', $term_id, 'product_cat' );
    if( empty($term) ){ return ; }
    $term_id = $term->term_id; 
    $args = array(
              'taxonomy'     => 'product_cat',
              'child_of'     => 0,
              'parent'       => $term_id,
              'number'       => $number,
            );
    $sub_cats = get_categories( $args );
    if( $image_cat && !empty( $image_cat ))
        $image = wp_get_attachment_image_src( $image_cat, 'postthumb-grid');
    else {
        $thumbnail_id = get_woocommerce_term_meta( $term_id, 'thumbnail_id', true );
        $image = wp_get_attachment_image_src( $thumbnail_id, 'full');
    }

?>
<?php if($term):
     $category_link = get_term_link( $term->term_id, 'product_cat' );
 ?>
    <div class="opal-category-subs woocommerce <?php echo (($el_class!='')?' '.esc_attr( $el_class ):''); ?>">
        <div class="inner nopadding">
            <?php if($style == 'style1') { ?>
                <div class="category-filter-v1">
                    <div class="category-filter-content">
                        <h4 class="category-filter-title">
                                <span><?php echo trim($term->name); ?></span>
                        </h4>
                         <small><?php echo trim($term->count); ?> <?php esc_html_e( 'Products', 'wpopal-themer' );?></small>  

                    
                        <?php
                        if( $sub_cats && !empty($sub_cats)) { ?>
                            <ul class="list-unstyled category-filter-list">
                                <?php
                                    foreach( $sub_cats as $cat){
                                        $sub_link = get_term_link( $cat->slug, 'product_cat');
                                        $cat_name = $cat->name ;// .' ('. $cat->count .')';
                                    ?>
                                    <li class="category-filter-list-item">
                                        <a href="<?php echo esc_url( $sub_link ); ?>">
                                            <?php echo trim( $cat_name ); ?>
                                        </a>
                                    </li>
                                <?php } ?>
                            </ul>
                        <?php } ?>
                        <div class="category-filter-link">
                            <a href="<?php echo esc_url( $category_link ); ?>" title="<?php esc_html_e( 'more', 'wpopal-themer'); ?>" class=""><?php esc_html_e( '+ more...', 'wpopal-themer' ); ?></a>
                        </div>
                    </div>

                    <?php if( $image ) { ?>
                        <div class="category-image">
                            <img src="<?php echo esc_url_raw( $image[0] ); ?>" title="<?php echo esc_attr($term->name); ?>" style="max-width: 100%" alt="">
                        </div>
                    <?php } ?>
                </div>
            <?php } else { ?>
                <div class="category-filter-default">
                    <?php if( $image ) { ?>
                        <img src="<?php echo esc_url_raw( $image[0] ); ?>" title="<?php echo esc_attr($term->name); ?>" style="max-width: 100%" alt="">
                    <?php } ?>
                    <div class="category-caption">
                        <h4>
                            <span><?php echo trim($term->name); ?></span>
                        </h4>
                         <small><?php echo trim($term->count); ?> <?php esc_html_e( 'Products', 'wpopal-themer' );?></small>  

                        <div class="category-filter-content">
                            <?php
                            if( $sub_cats && !empty($sub_cats)) { ?>
                                <ul class="list-unstyled category-filter-list">
                                    <?php
                                        foreach( $sub_cats as $cat){
                                            $sub_link = get_term_link( $cat->slug, 'product_cat');
                                            $cat_name = $cat->name ;// .' ('. $cat->count .')';
                                        ?>
                                        <li class="category-filter-list-item">
                                            <a href="<?php echo esc_url( $sub_link ); ?>">
                                                <?php echo trim( $cat_name ); ?>
                                            </a>
                                        </li>
                                    <?php } ?>
                                </ul>
                            <?php } ?>
                            <div class="category-filter-link">
                                <a href="<?php echo esc_url( $category_link ); ?>" title="<?php esc_html_e( 'more', 'wpopal-themer'); ?>" class=""><?php esc_html_e( '+ more...', 'wpopal-themer' ); ?></a>
                            </div>
                        </div>
                    </div>
                </div>
            <?php } ?>
        </div>
    </div>
<?php endif; ?>
<?php }   
