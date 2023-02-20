<?php
/**
 * The Template for displaying product archives, including the main shop page which is a post type archive
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/archive-product.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 3.4.0
 */

defined( 'ABSPATH' ) || exit;

get_header( 'shop' );
echo "<div class='archive-product-page'>";
echo "<div class='archive-product-grid-wrapper'>";?>
        <div class="sidebar-breadcrumbs">
            <?php woocommerce_breadcrumb(); ?>
        </div>
<?php

/**
 * Hook: woocommerce_before_main_content.
 *
 * @hooked woocommerce_output_content_wrapper - 10 (outputs opening divs for the content)
 * @hooked woocommerce_breadcrumb - 20
 * @hooked WC_Structured_Data::generate_website_data() - 30
 */

do_action( 'woocommerce_before_main_content' );
?>


    <script>

        if (jQuery(window).width() <= 768) {

/*
            jQuery('<div class="upper-menu-filters-mobile-button"><a onclick="closeFilters();"><span><?php /*echo esc_html__("[:ua]Фільтри[:en]Filters[:ru]Фильтры[:]"); */?></span></a></div>').appendTo(".site-main");
*/

            /* Close mobile filters */
            jQuery("body").on('click', "span.gamma.widget-title", function(){
                let secondary = document.getElementById("secondary");
                let widgetProductCategories = document.getElementsByClassName("widget_product_categories")[0];

                widgetProductCategories.style.visibility = "hidden";
                secondary.style.visibility = "hidden";

                jQuery(widgetProductCategories).fadeOut(10);
                jQuery(secondary).fadeOut(200);
            });

            /* Add filter button on mobile */
            jQuery('<div class="filters-mobile-button" id="notd-filter-black-btn"><a onclick="openFilters();"><span><?php echo esc_html__("[:ua]Фільтри[:en]Filters[:ru]Фильтры[:]"); ?></span></a></div>').appendTo(".site-main");

            /* Add sort button on mobile */
            jQuery('<div class="sorting-mobile-button" id="notd-sorting-black-btn"><a onclick="openFilters();"><span><?php echo esc_html__("[:ua]Фільтри[:en]Filters[:ru]Фильтры[:]"); ?></span></a></div>').appendTo(".site-main");

        }

        function openFilters() {

            let secondary = document.getElementById("secondary");
            let widgetProductCategories = document.getElementsByClassName("widget_product_categories")[0];
            secondary.style.visibility = "visible";
            widgetProductCategories.style.visibility = "visible";
            jQuery(secondary).fadeIn(100);
            jQuery(widgetProductCategories).fadeIn(200);

            /*let archiveProductGridWrapper1 = document.getElementsByClassName("archive-product-grid-wrapper")[0];
			let widgetWpcFiltersWidget1 = archiveProductGridWrapper1.getElementsByClassName("widget_wpc_filters_widget")[0];
			let wpcFiltersWidgetMainWrapper1 = widgetWpcFiltersWidget1.getElementsByClassName("wpc-filters-widget-main-wrapper")[0];
			wpcFiltersWidgetMainWrapper1.style.visibility = "visible";
			jQuery(wpcFiltersWidgetMainWrapper1).fadeIn(200);

			let upperMenuFiltersMobileButton1 = document.getElementsByClassName("upper-menu-filters-mobile-button")[0];
			upperMenuFiltersMobileButton1.style.visibility = "visible";
			jQuery(upperMenuFiltersMobileButton1).fadeIn(200);

			let blackFilterButton1 = document.getElementsByClassName("filters-mobile-button")[0];
			let blackSortingButton1 = document.getElementsByClassName("soring-wrapper")[0];

			blackFilterButton1.style.visibility = "hidden";
			blackSortingButton1.style.visibility = "hidden";*/

        }

        /*function closeFilters() {

			let archiveProductGridWrapper2 = document.getElementsByClassName("archive-product-grid-wrapper")[0];
			let widgetWpcFiltersWidget2 = archiveProductGridWrapper2.getElementsByClassName("widget_wpc_filters_widget")[0];
			let wpcFiltersWidgetMainWrapper2 = widgetWpcFiltersWidget2.getElementsByClassName("wpc-filters-widget-main-wrapper")[0];
			wpcFiltersWidgetMainWrapper2.style.visibility = "hidden";
			jQuery(wpcFiltersWidgetMainWrapper2).fadeOut(100);

			let upperMenuFiltersMobileButton2 = document.getElementsByClassName("upper-menu-filters-mobile-button")[0];
			upperMenuFiltersMobileButton2.style.visibility = "hidden";
			jQuery(upperMenuFiltersMobileButton2).fadeOut(100);

			let blackFilterButton2 = document.getElementsByClassName("filters-mobile-button")[0];
			let blackSortingButton2 = document.getElementsByClassName("soring-wrapper")[0];

			blackFilterButton2.style.visibility = "visible";
			blackSortingButton2.style.visibility = "visible";
		}*/


    </script>


<?php
?>
    <header class="woocommerce-products-header">
        <div class="product-cat-banner-image">
	        <?php
            // get the current taxonomy term
            $term = get_queried_object();

            /* Show desktop banner image. */
            $product_cat_banner_image_desktop = get_field('product_cat_banner_image_desktop', $term);
            if( !empty( $product_cat_banner_image_desktop ) ):
                ?>
                <img class="cat-banner-img" id="desktop-banner-cat-img" src="<?php echo esc_url($product_cat_banner_image_desktop['url']); ?>" alt="<?php echo esc_attr($product_cat_banner_image_desktop['alt']); ?>" />
            <?php endif; ?>

            <?php /* Show mobile banner image. */
            $product_cat_banner_image_mobile = get_field('product_cat_banner_image_mobile', $term);
            if( !empty( $product_cat_banner_image_mobile ) ):
            ?>
            <img class="cat-banner-img" id="mobile-banner-cat-img" src="<?php echo esc_url($product_cat_banner_image_mobile['url']); ?>" alt="<?php echo esc_attr($product_cat_banner_image_mobile['alt']); ?>" />
            <?php endif; ?>

	        <?php
            /* Show slider for category. */
	        $banner_slider_shortcode = get_field( 'banner_slider_shortcode', $term );
	        if( !empty( $banner_slider_shortcode ) ) {
		        echo do_shortcode(  '[wp1s id="' . $banner_slider_shortcode . '"]' );
	        }
	        ?>
        </div>

		<?php if ( apply_filters( 'woocommerce_show_page_title', true ) ) : ?>
            <h1 class="woocommerce-products-header__title page-title"><?php woocommerce_page_title(); ?></h1>
		<?php endif; ?>

		<?php
		/**
		 * Hook: woocommerce_archive_description.
		 *
		 * @hooked woocommerce_taxonomy_archive_description - 10
		 * @hooked woocommerce_product_archive_description - 10
		 */
		do_action( 'woocommerce_archive_description' );
		?>
    </header>

    <!-- For sorting using Filter Everything plugin. -->
    <!--<div class="soring-wrapper"><?php /*dynamic_sidebar( 'notd-filter-sort-widets' ); */?></div>-->
<?php
if ( woocommerce_product_loop() ) {

	/**
	 * Hook: woocommerce_before_shop_loop.
	 *
	 * @hooked woocommerce_output_all_notices - 10
	 * @hooked woocommerce_result_count - 20
	 * @hooked woocommerce_catalog_ordering - 30
	 */
	do_action( 'woocommerce_before_shop_loop' );

	woocommerce_product_loop_start();

	if ( wc_get_loop_prop( 'total' ) ) {

		echo '<div class="product-slider tmpl-with-sidebar-grid-wrapper">';
		echo '<div class="archive-product-wrapper carousel" >';

		while ( have_posts() ) {
			the_post();

			/**
			 * Hook: woocommerce_shop_loop.
			 */
			do_action( 'woocommerce_shop_loop' );

			wc_get_template_part( 'content', 'product' );
		}

		echo '</div>';
		echo '</div>';
	}

	woocommerce_product_loop_end();

	/**
	 * Hook: woocommerce_after_shop_loop.
	 *
	 * @hooked woocommerce_pagination - 10
	 */
	do_action( 'woocommerce_after_shop_loop' );
} else {
	/**
	 * Hook: woocommerce_no_products_found.
	 *
	 * @hooked wc_no_products_found - 10
	 */
	do_action( 'woocommerce_no_products_found' );
}

/**
 * Hook: woocommerce_after_main_content.
 *
 * @hooked woocommerce_output_content_wrapper_end - 10 (outputs closing divs for the content)
 */
do_action( 'woocommerce_after_main_content' );

/**
 * Hook: woocommerce_sidebar.
 *
 * @hooked woocommerce_get_sidebar - 10
 */
do_action( 'woocommerce_sidebar' );
echo "</div>"; /* close archive-product-grid-wrapper */
    echo get_template_part( 'template-parts/our', 'history' );
    echo do_shortcode( '[notd_slider_posts]' );
    echo get_template_part( 'template-parts/subscribe', 'insta-banner' );

echo "</div>"; /* close archive-product-page */

get_footer( 'shop' );