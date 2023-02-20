<?php

/**
 * Popular categories - slider.
 */

function notd_popular_product_cats( $atts )
{
	extract( shortcode_atts( array(
		'limit' => '6'
	), $atts ) );

	$arr_cat_count = notd_get_best_selling_product_categories( $limit );
	ob_start(); ?>
	<div class="pop-prod-cats-wrapper main-carousel" data-flickity='{ "groupCells": 2, "prevNextButtons": false, "pageDots": true, "freeScroll": true, "cellAlign": "left", "contain": true, "autoPlay": "1000" }'>
		<?php foreach ( $arr_cat_count as $cat_count => $value ) {
			echo notd_get_product_cat_info_by_id($cat_count);
	/*		echo ' Count of Sales - ' . $value . '</p>';*/
		}
		echo '</div>';
	return ob_get_clean();
}

add_shortcode('notd_popular_product_categories', 'notd_popular_product_cats');

/**
 * Bestsellers products - slider.
 */

function notd_slider_bestsellers_products( $atts ) {
    extract( shortcode_atts( array( 'limit' => '10' ), $atts ) );
	return notd_show_bestsellers_poducts_in_slider( $limit );
}

add_shortcode( 'notd_slider_bestsellers_products', 'notd_slider_bestsellers_products' );

/**
 * Featured products - slider.
 */

function notd_slider_featured_products( ) {
	return notd_show_featured_products_in_slider();
}

add_shortcode( 'notd_slider_featured_products', 'notd_slider_featured_products' );

/**
 * New products - slider.
 */

function notd_slider_new_products( $atts ) {
	extract( shortcode_atts( array( 'limit' => '10' ), $atts ) );
	return notd_show_new_products_in_slider( $limit );
}

add_shortcode( 'notd_slider_new_products', 'notd_slider_new_products' );

/**
 * Sale products - slider.
 */

function notd_slider_sale_products( $atts ) {
	extract( shortcode_atts( array( 'limit' => '10' ), $atts ) );
	return notd_show_sale_products_in_slider( $limit );
}

add_shortcode( 'notd_slider_sale_products', 'notd_slider_sale_products' );

/**
 * Sale products - grid.
 */

function notd_grid_sale_products( $atts ) {
	extract( shortcode_atts( array( 'limit' => '-1' ), $atts ) );
	return notd_show_sale_products_in_grid( $limit );
}

add_shortcode( 'notd_grid_sale_products', 'notd_grid_sale_products' );

/**
 * Blog posts - slider.
 */

function notd_slider_posts( $atts ) {
	extract( shortcode_atts( array( 'limit' => '10' ), $atts ) );
	return notd_show_posts_in_slider( $limit );
}

add_shortcode( 'notd_slider_posts', 'notd_slider_posts' );

/*[sale_products per_page="24" columns="4" orderby="date" order="DESC"]*/

/**
 * Our history.
 */

function notd_our_history( ) {
    return get_template_part("template-parts/our", "history");
}

add_shortcode( 'notd_our_history', 'notd_our_history' );


/**
 *  Full width button for post content.
 */

function notd_clasic_editor_button_in_post($atts, $content = null) {
	$default = array(
		'link' => '#',
	);
	$a = shortcode_atts($default, $atts);
	$content = do_shortcode($content);
	return '<div class="notd-button-in-post"><a href="' . esc_attr__($a['link']) . '" >' . esc_html__($content) . '</a></div>';
}
add_shortcode('notd_button_in_post', 'notd_clasic_editor_button_in_post');