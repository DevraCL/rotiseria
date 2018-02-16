<div class="hidden-lg hidden-md">
    <div class="topbar-mobile">
        <div class="active-mobile pull-left">
            <button data-toggle="offcanvas" class="btn btn-offcanvas btn-toggle-canvas offcanvas" type="button">
               <i class="icon zmdi zmdi-menu"></i>
            </button>
        </div>
        <div class="topbar-inner pull-left">
            <div class="active-mobile search-popup pull-left">
                <i class="icon zmdi zmdi-search"></i>
                <div class="active-content">
                    <?php fresh_fnc_categories_searchform(); ?>
                </div>
            </div>
            <div class="active-mobile setting-popup pull-left">
                <i class="icon zmdi zmdi-account"></i>
                <div class="active-content">
                    <?php if(has_nav_menu( 'topmenu' )){ ?>
                        <div class="pull-left">
                            <?php
                                $args = array(
                                    'theme_location'  => 'topmenu',
                                    'container_class' => '',
                                    'menu_class'      => 'menu-topbar'
                                );
                                wp_nav_menu($args);
                            ?>
                        </div>
                    <?php } ?>
                </div>
            </div>
            <?php if( class_exists('WooCommerce') ): ?>
                <div class="active-mobile pull-left cart-popup">
                    <i class="icon zmdi zmdi-shopping-cart"></i>
                    <div class="active-content">
                        <div class="widget_shopping_cart_content"></div>
                    </div>
                </div>
            <?php endif; ?>
        </div>        
    </div>
</div>