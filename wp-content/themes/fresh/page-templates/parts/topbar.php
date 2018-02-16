<div id="opal-topbar" class="opal-topbar hidden-xs hidden-sm">
    <div class="container">
        <div class="inner">
            <div class="row">
                <div class="col-lg-8 col-md-8 topbar-left">
                    <?php if ( is_active_sidebar( 'header-top-custom' ) ) : ?>
                        <?php dynamic_sidebar('header-top-custom'); ?>
                    <?php endif; ?>        
                    <ul class="list-inline">
                        <?php if( !is_user_logged_in() ){ ?>
                        <?php do_action( 'opal-account-buttons' ); ?>
                        <?php }else{ ?>
                            <?php $current_user = wp_get_current_user(); ?>
                          <li>  <span class="hidden-xs"><?php esc_html_e('Welcome ', 'fresh'); ?><?php echo esc_html( $current_user->display_name); ?> !</span></li>
                          <li><a href="<?php echo esc_url( wp_logout_url( home_url() ) ); ?>"><?php esc_html_e('Logout', 'fresh'); ?></a></li>
                        <?php } ?>
                    </ul>
                    <div class="custom-menu">
                        <?php
                             // WPML - Custom Languages Menu
                            fresh_fnc_wpml_language_buttons();
                        ?>
                        <?php if(has_nav_menu( 'topmenu' )): ?>
                        <nav class="opal-topmenu" role="navigation">
                            <?php
                                $args = array(
                                    'theme_location'  => 'topmenu',
                                    'menu_class'      => 'opal-menu-top list-inline',
                                    'fallback_cb'     => '',
                                    'menu_id'         => 'main-topmenu'
                                );
                                wp_nav_menu($args);
                            ?>
                        </nav>
                        <?php endif; ?>
                    </div>
                </div>
                <div class="col-lg-4 col-md-4">
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
</div>

