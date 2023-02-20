<?php
/**
 * The header for our theme.
 *
 * Displays all of the <head> section and everything up till <div id="content">
 *
 * @package storefront
 */

?><!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="http://gmpg.org/xfn/11">
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">

	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>

<?php wp_body_open(); ?>

<?php do_action( 'storefront_before_site' ); ?>

<div id="page" class="hfeed site">
	<?php do_action( 'storefront_before_header' ); ?>

    <?php  notd_wc_demo_store(); ?>

	<header id="masthead" class="site-header" role="banner" style="<?php storefront_header_styles(); ?>">

        <?php storefront_site_branding(); ?>
        <!-- Show desktop menu -->
		<?php wp_nav_menu( array( 'theme_location' => 'primary' ) ); ?>
        <!-- Show mobile menu -->
        <div class="mobile-main-menu">
	        <?php wp_nav_menu( array( 'theme_location' => 'max_mega_menu_1' ) ); ?>
            <div class="lang-mobile-widget">
	            <?php the_widget('qTranslateXWidget', array('type' => 'text', 'hide-title' => true) ); ?>
            </div>
        </div>
	

        <!-- Mobile logo -->
        <div class="mobile-site-logo"><a href="<?php echo home_url(); ?>"><img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/logo-mobile.svg" alt="Nails Of The Day"></a></div>

        <div class="header-widgets">
            <ul id="widgets-menu">

	            <?php /*wp_nav_menu( array( 'theme_location' => 'max_mega_menu_3' ) );*/ ?>

                <?php dynamic_sidebar( 'notd-header-widets' ); ?>
                <div class="side-cart-header-widget"></div>


            </ul>
        </div>

	</header><!-- #masthead -->

    <div id="borders-for-sub-menu" class="borders-for-sub-menu"></div>

	<?php
	/**
	 * Functions hooked in to storefront_before_content
	 *
	 * @hooked storefront_header_widget_region - 10
	 * @hooked woocommerce_breadcrumb - 10
	 */
	do_action( 'storefront_before_content' );
	?>

	<?php if(is_single() && !is_product()) { echo '<div class="notd-content-without-borders">';} else { echo '<div class="notd-content">'; } ?>




	<!--<div id="content" class="site-content" tabindex="-1">
		<div class="col-full">-->

<?php
do_action( 'storefront_content_top' );
