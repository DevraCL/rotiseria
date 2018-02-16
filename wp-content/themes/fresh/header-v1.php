<?php
/**
 * The Header for our theme: Main Darker Background. Logo left + Main menu and Right sidebar. Below Category Search + Mini Shopping basket.
 * Displays all of the <head> section and everything up till <div id="main">
 *
 * @package WpOpal
 * @subpackage Fresh
 * @since Fresh 1.0
 */
?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta name="viewport" content="width=device-width">
    <link rel="profile" href="http://gmpg.org/xfn/11">
    <link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">

    <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<div id="page" class="hfeed site"><div class="opal-page-inner row-offcanvas row-offcanvas-left">
    <?php if ( get_header_image() ) : ?>
    <div id="site-header" class="hidden-xs hidden-sm">
        <a href="<?php echo esc_url( get_option('header_image_link','#') ); ?>" rel="home">
            <img src="<?php header_image(); ?>" width="<?php echo get_custom_header()->width; ?>" height="<?php echo get_custom_header()->height; ?>" alt="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>">
        </a>
    </div>
    <?php endif; ?>
    <?php get_template_part( 'page-templates/parts/topbar', 'mobile' ); ?>    
    <?php get_template_part( 'page-templates/parts/topbar'); ?>

    <header id="opal-masthead" class="site-header header-v1">
        <div class="header-main text-center">
            <div class="container">
                <?php get_template_part( 'page-templates/parts/logo'); ?>
            
                <div id="opal-mainmenu" class="opal-mainmenu">
                    <?php get_template_part( 'page-templates/parts/nav' ); ?>
                </div>
            </div>
        </div>
    </header><!-- #masthead -->

    <?php do_action( 'fresh_template_header_after' ); ?>

    <section id="main" class="site-main">
