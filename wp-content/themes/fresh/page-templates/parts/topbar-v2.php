<div id="opal-topbar" class="opal-topbar topbar-v2 hidden-xs hidden-sm">
    <div class="inner">
        <div class="row">
            <div class="col-lg-8 col-md-7 topbar-left">
                <?php if ( is_active_sidebar( 'header-top-custom' ) ) : ?>
                    <?php dynamic_sidebar('header-top-custom'); ?>
                <?php endif; ?>        
                <div class="quick-setting">
                    <div data-toggle="dropdown" class="btn btn-link dropdown-toggle" aria-expanded="false">
                        <span class=""><?php esc_html_e('My Account ', 'fresh'); ?></span><i class="fa-fw fa fa-angle-down"></i>
                    </div>
                    <div class="dropdown-menu">
                        <ul class="list-unstyled">
                            <?php if( !is_user_logged_in() ){ ?>
                            <?php do_action( 'opal-account-buttons' ); ?>
                            <?php }else{ ?>
                                <?php $current_user = wp_get_current_user(); ?>
                              <li>  <span class="hidden-xs"><?php esc_html_e('Welcome ', 'fresh'); ?><?php echo esc_html( $current_user->display_name); ?> !</span></li>
                              <li><a href="<?php echo esc_url( wp_logout_url( home_url() ) ); ?>"><?php esc_html_e('Logout', 'fresh'); ?></a></li>
                            <?php } ?>
                        </ul>
                    </div>
                </div>
                <!--div class="quick-setting">
                    <div data-toggle="dropdown" class="btn btn-link dropdown-toggle" aria-expanded="false">
                        <span class=""><?php esc_html_e('Setting ', 'fresh'); ?></span><i class="fa-fw fa fa-angle-down"></i>
                    </div>
                    <div class="dropdown-menu">
                        <?php
                             // WPML - Custom Languages Menu
                            fresh_fnc_wpml_language_buttons();
                        ?>
                        <?php if(has_nav_menu( 'topmenu' )): ?>
                        <nav class="opal-topmenu" role="navigation">
                            <?php
                                $args = array(
                                    'theme_location'  => 'topmenu',
                                    'menu_class'      => 'opal-menu-top list-unstyled',
                                    'fallback_cb'     => '',
                                    'menu_id'         => 'main-topmenu'
                                );
                                wp_nav_menu($args);
                            ?>
                        </nav>
                        <?php endif; ?>
                    </div>
                </div-->
            </div>
            <div class="col-lg-4 col-md-5">
                <div class="pull-right">
                    <?php do_action( "fresh_template_header_right" ); ?>
                </div>
                <div id="search-container" class="search-box-wrapper pull-right">
                    <div class="opal-dropdow-search dropdown">
                        <a data-target=".bs-search-modal-lg" data-toggle="modal" class="btn btn-link search-focus dropdown-toggle dropdown-toggle-overlay">
                            <i class="icon fa fa-search"></i>
                        </a>
                        <div class="modal fade bs-search-modal-lg" tabindex="-1" role="dialog" aria-hidden="true">
                          <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                                <div class="modal-header">
                                  <button aria-label="Close" data-dismiss="modal" class="close btn btn-sm btn-primary pull-right" type="button"><span aria-hidden="true">x</span></button>
                                  <h4 id="gridSystemModalLabel" class="modal-title"><?php esc_html_e( 'Search', 'fresh' ); ?></h4>
                                </div>
                                <div class="modal-body">
                                  <?php get_template_part( 'page-templates/parts/search-overlay' ); ?>
                                </div>
                            </div>
                          </div>
                        </div>
                    </div>
                </div>                    
            </div>
        </div>
    </div>

</div>

