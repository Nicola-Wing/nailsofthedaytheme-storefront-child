<?php

/**
 * Disable Gutenberg
 */

// Disable Gutenberg on the back end.
add_filter( 'use_block_editor_for_post', '__return_false' );

// Disable Gutenberg for widgets.
add_filter( 'use_widgets_blog_editor', '__return_false' );

add_action( 'wp_enqueue_scripts', function() {
	// Remove CSS on the front end.
	wp_dequeue_style( 'wp-block-library' );

	// Remove Gutenberg theme.
	wp_dequeue_style( 'wp-block-library-theme' );

	// Remove inline global CSS on the front end.
	wp_dequeue_style( 'global-styles' );
}, 20 );

/**
 * Include additional functionality.
 */

add_theme_support( 'woocommerce' );
require_once ('inc/shortcodes.php');
require_once ( 'inc/wishlist-widget.php' );

/**
 * Enqueue project styles.
 */

function notd_register_styles() {
	$parent_style = 'parent-style';
	wp_enqueue_style( $parent_style, get_template_directory_uri() . '/style.css' );
	wp_enqueue_style( 'flickity-min-css', 'https://unpkg.com/flickity@2/dist/flickity.min.css', array( ), '1.0.0' );
/*	wp_enqueue_style( 'notd-reset-css', get_stylesheet_directory_uri() . '/assets/css/reset.css', array( ), '1.0.0' );*/
	wp_enqueue_style( 'notd-child-style', get_stylesheet_directory_uri() . '/style.css', array( $parent_style, 'notd-fonts' ), '12.0.1' );
	wp_enqueue_style( 'notd-large-css', get_stylesheet_directory_uri() . '/assets/css/large.css', array( ), '11.0.1', '(min-width: 1730px)' );
	wp_enqueue_style( 'notd-media-css', get_stylesheet_directory_uri() . '/assets/css/media.css', array( ), '11.0.4', '(max-width: 1600px)' );
	wp_enqueue_style( 'notd-mobile-css', get_stylesheet_directory_uri() . '/assets/css/mobile.css', array( ), '11.0.8', '(max-width: 920px)' );
	wp_enqueue_style( 'notd-fonts', get_stylesheet_directory_uri() . '/assets/fonts/fonts.css', array(  ), '4.0.0' );
	/*wp_enqueue_style( 'notd-archive-product-css', get_stylesheet_directory_uri() . '/assets/css/archive-product.css', array( ), '1.0.2' );*/

	if(is_checkout()) {
		wp_enqueue_style( 'notd-checkout-css', get_stylesheet_directory_uri() . '/assets/css/checkout.css', array( ), '1.0.0', '(max-width: 768px)' );
	}

}

add_action( 'wp_enqueue_scripts', 'notd_register_styles' );

/**
 * Enqueue project js files.
 */

function notd_register_scripts() {
	wp_enqueue_script( 'notd-main-js', get_stylesheet_directory_uri() . '/assets/js/main.js', array( 'jquery' ), '1.0.22', true );
	wp_enqueue_script( 'flickity-min-js', 'https://unpkg.com/flickity@2/dist/flickity.pkgd.min.js', array( 'jquery' ), '1.0.0', true );

    if(is_checkout()) {
	    wp_enqueue_script( 'notd-checkout-js', get_stylesheet_directory_uri() . '/assets/js/checkout.js', array( 'jquery' ), '1.0.6', true );
    }
	if(is_product()) {
		wp_enqueue_script( 'notd-single-product-js', get_stylesheet_directory_uri() . '/assets/js/single-product.js', array( 'jquery' ), '1.0.1', true );
	}

}

add_action( 'wp_enqueue_scripts', 'notd_register_scripts' );

/**
 * Add a demo store banner (Top Notice String) to the site if enabled.
 */

if ( ! function_exists( 'notd_wc_demo_store' ) ) {
	function notd_wc_demo_store() {
		if ( get_option( 'woocommerce_demo_store' ) == 'no' ) {
			return;
		}
		/*$notice = get_option( 'woocommerce_demo_store_notice' );
		if ( !empty( $notice ) ) {
			echo apply_filters( 'woocommerce_demo_store', '<p class="demo_store">' . $notice . '</p>' );
		}*/
		$store_notice_text = get_field('store_notice_text', 'option');
		$store_notice_link = get_field('store_notice_link', 'option');

		if( $store_notice_text  ):
			$store_notice_link_url = $store_notice_link['url'];
			$store_notice_link_target = $store_notice_link['target'] ? $store_notice_link['target'] : '_self';

			echo apply_filters( 'woocommerce_demo_store', '<a class="demo_store" href="' . esc_url( $store_notice_link_url ) . '" target="' . esc_attr( $store_notice_link_target ) . '"><p>' . esc_html__( $store_notice_text ) . '</p></a>' );
		endif;

	}
}

/**
 * Register Widgets.
 */

function notd_widgets_init() {
    register_sidebar(
            array(
                'name' => 'NOTD Header Widgets',
                'id' => 'notd-header-widets',
            )
    );

	register_sidebar(
		array(
			'name' => 'NOTD Filter Sort Widget',
			'id' => 'notd-filter-sort-widets',
		)
	);

	register_sidebar( array(
		'name'          => esc_html__( 'Contact Page Widget' ),
		'id'            => 'notd-contact-page-widget',
		'description'   => esc_html__( 'Add widgets here.' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );

}

add_action( 'widgets_init', 'notd_widgets_init' );

/**
 * Find popular products categories.
 */

// Get the total sales count of a specific product category.

function notd_count_total_sales_by_product_category( $term_id ) {
	global $wpdb;
	$total_sales = $wpdb->get_var("
        SELECT sum(meta_value)
        FROM $wpdb->postmeta
        INNER JOIN {$wpdb->term_relationships} ON ( {$wpdb->term_relationships}.object_id = {$wpdb->postmeta}.post_id )
        WHERE ( {$wpdb->term_relationships}.term_taxonomy_id IN ($term_id) )
        AND {$wpdb->postmeta}.meta_key = 'total_sales'"
	);
	return $total_sales;
}

// Get the n product categories with the best sales.

function notd_get_best_selling_product_categories( $limit ) {

	$total_sales = array();
	$product_categories = get_terms( 'product_cat' );
	foreach ( $product_categories as $product_cat ) {
		$product_cat_id = $product_cat->term_id;
		$total_sales[$product_cat_id] = notd_count_total_sales_by_product_category( $product_cat_id );
	}

	// removes empty values from the array
	$total_sales = array_filter( $total_sales );

	// sorts the array values in descending order
	arsort( $total_sales );

	// gets the first n ($limit) product categories with the most sales
	$best_product_categories = array_slice( $total_sales, 0, $limit, true );

	return $best_product_categories;
}

/**
 * Show featured categories - slider.
 */

function notd_show_featured_product_cats( $array_of_cats_ids ) {

	?>
    <div class="pop-prod-cats-wrapper main-carousel" data-flickity='{ "groupCells": 2, "prevNextButtons": false, "pageDots": true, "freeScroll": true, "cellAlign": "left", "contain": true, "autoPlay": "1000" }'>
	<?php

	foreach ( $array_of_cats_ids as $cat_id) {
		echo notd_get_product_cat_info_by_id($cat_id);
	}
	echo '</div>';
}

/**
 * Get product category title, link, thumbnail by id.
 */

function notd_get_product_cat_info_by_id( $id ){

	// Get the WP_term object
	$term = get_term_by( 'id', $id, 'product_cat' );

	// Get the term link (if needed)
	$term_link = get_term_link( $term, 'product_cat' );

	// Get the thumbnail Id
	$thumbnail_id  = (int) get_woocommerce_term_meta( $term->term_id, 'thumbnail_id', true );

	if( $thumbnail_id > 0 ) {
		// Get the attchement image Url
		$term_img  = wp_get_attachment_url( $thumbnail_id );

		// Formatted thumbnail html
		$img_html = '<img src="' . $term_img . '">';
	} else {
		$img_html = '<img src="' . get_stylesheet_directory_uri() . '/assets/images/product-cat-default.png">';
	}
	echo '<a href="' . $term_link . '" class="carousel-cell"><div class="pop-cat-bg">' . $img_html . '</div><h4>' . $term->name . '</h4>' . '</a>';
}

/**
 * Change site info in the bottom of footer.
 */

function notd_remove_footer_credit () {
	remove_action( 'storefront_footer', 'storefront_credit', 20 );
	add_action( 'storefront_footer', 'notd_storefront_credit', 20 );
}

add_action( 'init', 'notd_remove_footer_credit', 10 );

function notd_storefront_credit() {
	?>
	<div class="site-info">
		<div class="footer-visa-logo"><img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/visa-logo.svg"></div>
        <div class="footer-mastercard-logo"><img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/mastercard-logo.svg"></div>
    </div><!-- .site-info -->
	<?php
}

/**
 * Change currency sign '₴' or 'UAH' to 'грн'.
 */

add_filter('woocommerce_currency_symbol', 'change_existing_currency_symbol', 10, 2);
function change_existing_currency_symbol( $currency_symbol, $currency ) {
	switch( $currency ) {
		case 'UAH': $currency_symbol = 'грн'; break;
	}
	return $currency_symbol;
}

/**
 * Show first category by product array.
 */

function notd_get_first_cat_name_by_product_arr( $product ) {
	$terms = get_the_terms( $product->get_id(), 'product_cat' );
	if ( $terms && ! is_wp_error( $terms ) ) {
		if ( ! empty( $terms ) ) {
			echo $terms[0]->name;
		}
	}
}

/**
 * Show Bestsellers from Products in slider.
 */

function notd_show_bestsellers_poducts_in_slider( $limit ) {
	$args = array(
		'post_type' => 'product',
		'meta_key' => 'total_sales',
		'orderby' => 'meta_value_num',
		'posts_per_page' => $limit,
	);
	$loop = new WP_Query( $args );
    echo '<div class="product-slider slider-wrapper close-2">';
        echo '<h3 class="constant-block close-2">' . esc_html__( '[:ua]Топ продажів[:en]Top selling[:ru]Топ продаж[:]' ) . '<span id="triangle"></span></h3>';

        echo '<div class="best-seller-prod-wrapper carousel" data-flickity=\'{ "cellAlign": "left", "wrapAround": true }\' >';
        while ( $loop->have_posts() ) : $loop->the_post();
            global $product;
            get_template_part( 'template-parts/product', 'slider' );
            ?>
        <?php
        endwhile;
        echo '</div>';
	echo '</div>';
	wp_reset_query();
}

/**
 * Show Featured Products in slider.
 */

function notd_show_featured_products_in_slider( ) {
	$meta_query  = WC()->query->get_meta_query();
	$tax_query   = WC()->query->get_tax_query();
	$tax_query[] = array(
		'taxonomy' => 'product_visibility',
		'field'    => 'name',
		'terms'    => 'featured',
		'operator' => 'IN',
	);

	$args = array(
		'post_type'           => 'product',
		'post_status'         => 'publish',
		'ignore_sticky_posts' => 1,
		'posts_per_page'      => -1,
		'orderby'             => 'date',
		'order'               => 'DESC',
		'meta_query'          => $meta_query,
		'tax_query'           => $tax_query,
	);

	ob_start();
	$loop = new WP_Query( $args );
	echo '<div class="product-slider slider-wrapper close-2">';
	echo '<h3 class="constant-block close-2">' . esc_html__( '[:ua]Топ продажів[:en]Top selling[:ru]Топ продаж[:]' ) . '<span id="triangle"></span></h3>';

	echo '<div class="best-seller-prod-wrapper carousel" data-flickity=\'{ "cellAlign": "left", "wrapAround": true }\' >';
	while ( $loop->have_posts() ) : $loop->the_post();
		global $product;
		get_template_part( 'template-parts/product', 'slider' );
		?>
	<?php
	endwhile;
	echo '</div>';
	echo '</div>';
	wp_reset_query();
	return ob_get_clean();
}

/**
 * Show New from Products in slider.
 */

function notd_show_new_products_in_slider( $limit ) {
	$args = array(
		'post_type' => 'product',
		'visibility' => 'visible',
		'orderby' => 'date',
        'order' => 'DESC',
		'posts_per_page' => $limit,
	);
	$loop = new WP_Query( $args );
	echo '<div class="product-slider slider-wrapper close-4">';
        echo '<h3 class="constant-block close-4">' . esc_html__( '[:ua]Новинки[:en]New[:ru]Новинки[:]' ) . '<span id="dot"></span></h3>';

        echo '<div class="new-prod-wrapper carousel" data-flickity=\'{ "cellAlign": "left", "wrapAround": true }\' >';
        while ( $loop->have_posts() ) : $loop->the_post();
            global $product;
            get_template_part( 'template-parts/product', 'slider' );
            ?>
        <?php
        endwhile;
        echo '</div>';
	echo '</div>';
	wp_reset_query();
}

/**
 * Show Sale from Products in slider.
 */

function notd_show_sale_products_in_slider( $limit ) {
	$args = array(
		'post_type' => 'product',
		'post_status' => 'publish',
		'orderby' => 'date',
		'order' => 'DESC',
		'meta_query' => WC()->query->get_meta_query(),
		'post__in' => array_merge(array(0), wc_get_product_ids_on_sale()),
		'posts_per_page' => $limit,
	);
	$loop = new WP_Query( $args );
	echo '<div id="new-of-the-week" class="product-slider slider-wrapper close-1">';
	echo '<h3 class="constant-block close-1">' . esc_html__( '[:ua]New of the week[:en]New of the week[:ru]New of the week[:]' ) . '<span id="square"></span></h3>';

        echo '<div class="new-prod-wrapper carousel" data-flickity=\'{ "cellAlign": "left", "wrapAround": true }\' >';
        while ( $loop->have_posts() ) : $loop->the_post();
            global $product;
            get_template_part( 'template-parts/product', 'slider' );
            ?>
        <?php
        endwhile;
        echo '</div>';
	echo '</div>';
	wp_reset_query();
}

/**
 * Show Sale from Products in grid.
 */

function notd_show_sale_products_in_grid( $limit ) {
	$args = array(
		'post_type' => 'product',
		'post_status' => 'publish',
		'orderby' => 'date',
		'order' => 'DESC',
		'meta_query' => WC()->query->get_meta_query(),
		'post__in' => array_merge(array(0), wc_get_product_ids_on_sale()),
		'posts_per_page' => $limit,
	);
	$loop = new WP_Query( $args );
    ob_start();

	/**
	 * Hook: woocommerce_before_shop_loop.
	 *
	 * @hooked woocommerce_output_all_notices - 10
	 * @hooked woocommerce_result_count - 20
	 * @hooked woocommerce_catalog_ordering - 30
	 */
	do_action( 'woocommerce_before_shop_loop' );

	woocommerce_product_loop_start();

	if ( $loop->get_posts() ) {

		echo '<div class="product-slider tmpl-full-width-grid-wrapper">';
		echo '<div class="full-width-product-grip archive-product-wrapper carousel" >';

		while ( $loop->have_posts() ) {
			$loop->the_post();
			global $product;

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



	wp_reset_query();
	return ob_get_clean();
}


/**
 * Show posts preview in slider.
 */

function notd_show_posts_in_slider( $limit ) {

	echo '<div class="blog-posts-slider product-slider slider-wrapper close-2">';
	echo '<h3 class="constant-block close-2">' . esc_html__( '[:ua]Блог[:en]Blog[:ru]Блог[:]' ) . '</h3>';

	echo '<div class="posts-slider carousel" data-flickity=\'{ "cellAlign": "left", "wrapAround": true }\' >';
    $the_query = new WP_Query( array( 'posts_per_page' => $limit ) );
    while ($the_query -> have_posts()) : $the_query -> the_post();
        echo get_template_part( 'template-parts/posts', 'slider' );
	endwhile;
	wp_reset_postdata();
	echo '</div>';
	echo '</div>';
}

/**
 * Show post category name with link.
 */

function notd_get_post_category() {
	$categories = get_the_category();
	$separator = ' ';
	$output = '';
	if ( ! empty( $categories ) ) {
		foreach( $categories as $category ) {
			$output .= '<a href="' . esc_url( get_category_link( $category->term_id ) ) . '" alt="' . esc_attr( sprintf( __( 'View all posts in %s', 'textdomain' ), $category->name ) ) . '"><h4>' . esc_html( $category->name ) . '</h4></a>' . $separator;
		}
		echo trim( $output, $separator );
	}
}

/**
 * Show post author (custom taxonomy) name with link.
 */

function notd_get_post_author() {
    global $post;
	$terms = get_the_terms( $post, 'authors' );
	$sep = ' ';
	$output = '';
	if ( ! empty( $terms ) ) {
		foreach( $terms as $author ) {
			$output .= '<a href="' . esc_url( get_category_link( $author->term_id ) ) . '" alt="' . esc_attr( sprintf( __( 'View all posts in %s', 'textdomain' ), $author->name ) ) . '">' . esc_html( $author->name ) . '</a>' . $sep;
		}
		echo trim( $output, $sep );
	}
}

/**
 * Chane "Add to cart" button text.
 */

// To change add to cart text on single product page
add_filter( 'woocommerce_product_single_add_to_cart_text', 'woocommerce_custom_single_add_to_cart_text' );
function woocommerce_custom_single_add_to_cart_text() {
	return __( '[:ua]Купити[:en]Buy[:ru]Купить[:]', 'woocommerce' );
}

// To change add to cart text on product archives(Collection) page
add_filter( 'woocommerce_product_add_to_cart_text', 'woocommerce_custom_product_add_to_cart_text' );
function woocommerce_custom_product_add_to_cart_text() {
	return __( '[:ua]Купити[:en]Buy[:ru]Купить[:]', 'woocommerce' );
}

/**
 * Change "Sale" label.
 */

function notd_custom_discount_amount_sale_badge( $html, $post, $product ) {
	if( $product->is_type('variable')){
		$amount_off = array();

		$prices = $product->get_variation_prices();

		foreach( $prices['price'] as $key => $price ){
			if( $prices['regular_price'][$key] !== $price ){
				$amount_off[] = $prices['regular_price'][$key] - $prices['sale_price'][$key];
			}
		}
		$amount_off_s = esc_html__( "[:ua]до[:en]up to[:ru]до[:]" ) . ' ' . round(max($amount_off)) . ' ' . esc_html__( "[:ua]грн[:en]UAH[:ru]грн[:]" );
	} else {
		$regular_price = (float) $product->get_regular_price();
		$sale_price    = (float) $product->get_sale_price();

		$amount_off_s = ($regular_price - $sale_price) . ' ' . esc_html__( "[:ua]грн[:en]UAH[:ru]грн[:]" );
	}
	return '<div class="custom-discount-amount-sale-badge"><span class="small-square-dot"></span><div><span class="first-text">' . esc_html__( '[:ua]Знижка[:en]Sale[:ru]Скидка[:]', 'woocommerce' ) . '</span><span class="sale-amount"><span id="small-line">-</span> ' . $amount_off_s . '</span></div></div>';
}

add_filter( 'woocommerce_sale_flash', 'notd_custom_discount_amount_sale_badge', 20, 3 );

/**
 * Increase WooCommerce Variation Limit
 */

function notd_wc_ajax_variation_threshold( $qty, $product ) {
	return 100;
}

add_filter( 'woocommerce_ajax_variation_threshold', 'notd_wc_ajax_variation_threshold', 100, 2 );

/**
 * Remove 'Shop' link from breadcrumbs.
 */

function notd_remove_shop_crumb($crumbs, $breadcrumb)
{
	$new_crumbs = array();
	foreach ($crumbs as $key => $crumb) {
		if ($crumb[0] !== __('Shop', 'Woocommerce')) {
			$new_crumbs[] = $crumb;
		}
	}
	return $new_crumbs;
}

add_filter('woocommerce_get_breadcrumb', 'notd_remove_shop_crumb', 20, 2);

/**
 * Remove product name in breadcrumbs.
 */

function notd_child_remove_product_title( $crumbs, $breadcrumb ) {
	if ( is_product() ) {
		array_pop( $crumbs );
	}
	return $crumbs;
}

add_filter( 'woocommerce_get_breadcrumb', 'notd_child_remove_product_title', 10, 2 );

/**
 * Make gallery vertical and on left side on Simple Product page.
 */

add_filter ( 'storefront_product_thumbnail_columns', 'notd_change_gallery_columns_storefront' );

function notd_change_gallery_columns_storefront() {
	return 1;
}

/**
 * Remove breadcrumbs. They will be rewritten in templates.
 */

add_action( 'init', 'bc_remove_storefront_breadcrumbs');

function bc_remove_storefront_breadcrumbs() {
	remove_action( 'storefront_before_content', 'woocommerce_breadcrumb', 10 );
}

/**
 * Get stock status
 */

function notd_stock_catalog() {
	global $product;
	if ( $product->is_in_stock() ) {
		echo '<div class="stock" >' . esc_html__( '[:ua]Є в наявності[:en]In stock[:ru]Есть в наличии[:]' ) . '</div>';
/*		echo '<div class="stock" >' . $product->get_stock_quantity() . __( ' in stock', 'envy' ) . '</div>';*/
	} else {
		echo '<div class="out-of-stock" >' . esc_html__( '[:ua]Немає в наявності[:en]Out of stock[:ru]Нет в наличии[:]' ) . '</div>';
/*		echo '<div class="out-of-stock" >' . __( 'out of stock', 'envy' ) . '</div>';*/
	}
}
/*add_action( 'woocommerce_after_shop_loop_item_title', 'notd_stock_catalog' );*/

function notd_get_product_sku($product){
    echo '<span class="sku">'. $product->get_sku() . '</span>';
}


/**
 * Change price format for variable products. HAS CONFLICT WITH WISHLIST PLUGIN!
 */

/*function notd_change_variable_price_display( $price, $product_obj ) {
	global $product;

	if ( 'variable' !== $product->get_type() || 'product_variation' === $product_obj->post_type ) {
		return $price;
	}

	$prices = array( $product->get_variation_price( 'min', true ), $product->get_variation_price( 'max', true ) );
	// Translators: %s is the lowest variation price.
	$price = $prices[0] !== $prices[1] ? sprintf( esc_html__( '[:ua]Від: %s[:en]From: %s[:ru]От: %s[:]', 'notd' ), wc_price( $prices[0] ) ) : wc_price( $prices[0] );

	return $price;
}

add_filter( 'woocommerce_get_price_html', 'notd_change_variable_price_display', 10, 2 );*/


/**
 * Modify date and time in q-Translate.
 */

remove_filter('get_the_time', 'qtranxf_timeFromPostForCurrentLanguage',0.3);
remove_filter('get_the_date', 'qtranxf_dateFromPostForCurrentLanguage',0.3);
remove_filter('get_the_modified_date', 'qtranxf_dateModifiedFromPostForCurrentLanguage',0.2);

/**
 * Add the + - quantity input buttons to the page.
 */

function mystore_display_quantity_minus() {
	echo '<button type="button" class="minus" >-</button>';
}

add_action( 'woocommerce_before_add_to_cart_quantity', 'mystore_display_quantity_minus' );


function mystore_display_quantity_plus() {
	echo '<button type="button" class="plus" >+</button>';
}

add_action( 'woocommerce_after_add_to_cart_quantity', 'mystore_display_quantity_plus' );


/**
 *  Control changing the quantity when the buttons are clicked.
 */

add_action( 'wp_footer', 'mystore_add_cart_quantity_plus_minus' );

function mystore_add_cart_quantity_plus_minus() {
	// Only run this on the single product page
	if ( ! is_product() ) return;
	?>
    <script type="text/javascript">

        jQuery(document).ready(function($){

            $('form.cart').on( 'click', 'button.plus, button.minus', function() {

// Get current quantity values
                var qty = $( this ).closest( 'form.cart' ).find( '.qty' );
                var val = parseFloat(qty.val());
                var max = parseFloat(qty.attr( 'max' ));
                var min = parseFloat(qty.attr( 'min' ));
                var step = parseFloat(qty.attr( 'step' ));

// Change the value if plus or minus
                if ( $( this ).is( '.plus' ) ) {
                    if ( max && ( max <= val ) ) {
                        qty.val( max );
                    } else {
                        qty.val( val + step );
                    }
                } else {
                    if ( min && ( min >= val ) ) {
                        qty.val( min );
                    } else if ( val > 1 ) {
                        qty.val( val - step );
                    }
                }
            });

        });

    </script>
	<?php
}

/**
 * Remove related products output
 */

remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_output_related_products', 20 );


/**
 * Add Product Image to Checkout in Inline Style.
 */

add_filter( 'woocommerce_cart_item_name', 'quadlayers_product_image_checkout', 9999, 3 );
function quadlayers_product_image_checkout( $name, $cart_item, $cart_item_key ) {
	if ( ! is_checkout() )
	{return $name;}
	$product = $cart_item['data'];
	$thumbnail = $product->get_image( array( '90', '90' ), array( 'class' => 'alignleft' ) );
	return $thumbnail . $name;
}

// Display the sku below under cart item name in checkout
function notd_show_sku_in_cart_items( $item_name, $cart_item, $cart_item_key ) {

    if(is_checkout()) {

	    // The WC_Product object
	    $product = $cart_item['data'];

	    // Get the  SKU
	    $sku = $product->get_sku();

	    // When SKU doesn't exist
	    if ( empty( $sku ) ) {
		    return $item_name;
	    }

	    $item_name = '<a id="checkout-item-name" href="' . get_permalink( $product ) . '">' . $item_name . '</a><br><a id="checkout-item-sku"  href="' . get_permalink( $product ) . '"><span>' . $sku . '</span></a><br>';

    }
	return $item_name;
}

add_filter( 'woocommerce_cart_item_name', 'notd_show_sku_in_cart_items', 99, 3 );

/**
 * Disable comments in Woocommerce.
 */

/*function notd_woo_remove_reviews_tab($tabs) {
	unset($tabs['reviews']);
	return $tabs;
}

add_filter( 'woocommerce_product_tabs', 'notd_woo_remove_reviews_tab', 98);*/

/**
 * Disable comments for Wordpress.
 */

// Add to existing function.php file

// Disable support for comments and trackbacks in post types

/*function notd_disable_comments_post_types_support() {

	$post_types = get_post_types();

	foreach ($post_types as $post_type) {

		if(post_type_supports($post_type, 'comments')) {

            remove_post_type_support($post_type, 'comments');

			remove_post_type_support($post_type, 'trackbacks');
        }
    }
}

add_action('admin_init', 'notd_disable_comments_post_types_support');*/

// Close comments on the front-end

/*function notd_disable_comments_status() {

	return false; }

add_filter('comments_open', 'notd_disable_comments_status', 20, 2);

add_filter('pings_open', 'notd_disable_comments_status', 20, 2);*/

// Hide existing comments

/*function notd_disable_comments_hide_existing_comments($comments) {

	$comments = array();

	return $comments;
}

add_filter('comments_array', 'notd_disable_comments_hide_existing_comments', 10, 2);*/

// Remove comments page in menu

/*function notd_disable_comments_admin_menu() {

	remove_menu_page('edit-comments.php'); }

add_action('admin_menu', 'notd_disable_comments_admin_menu');*/

// Redirect any user trying to access comments page

/*function notd_disable_comments_admin_menu_redirect() {
	global $pagenow;
	if ($pagenow === 'edit-comments.php') {
		wp_redirect(admin_url()); exit;
    }
}

add_action('admin_init', 'notd_disable_comments_admin_menu_redirect');*/

// Remove comments metabox from dashboard

/*function notd_disable_comments_dashboard() {
	remove_meta_box('dashboard_recent_comments', 'dashboard', 'normal');
}

add_action('admin_init', 'notd_disable_comments_dashboard');*/

// Remove comments links from admin bar

/*function notd_disable_comments_admin_bar() {

	if (is_admin_bar_showing()) {

		remove_action('admin_bar_menu', 'wp_admin_bar_comments_menu', 60);
    }
}

add_action('init', 'notd_disable_comments_admin_bar');*/

/**
 * Change the text on the Waitlist buttons.
 */

add_filter( 'wcwl_join_waitlist_button_text', 'notd_change_waitlist_join_button_text' );
function notd_change_waitlist_join_button_text( $text ) {
	return __( '[:en]Notify[:ua]Повідомити[:ru]Уведомить[:]' );
}
add_filter( 'wcwl_leave_waitlist_button_text', 'notd_change_waitlist_leave_button_text' );
function notd_change_waitlist_leave_button_text( $text ) {
	return __( '[:en]Leave waitlist[:ua]Видалити зі списку очікування[:ru]Удалить из списка ожидания[:]' );
}
add_filter( 'wcwl_join_waitlist_success_message_text', 'notd_change_join_waitlist_success_message_text' );
function notd_change_join_waitlist_success_message_text( $text ) {
	return __( '[:en]The email provided is already on the waitlist for this product.[:ua]Надана адреса електронної пошти вже знаходиться у списку очікування для цього товару.[:ru]Предоставленный адрес электронной почты уже находится в списке ожидания для этого товара.[:]' );
}

add_filter( 'wc_add_to_cart_message', 'quadlayers_custom_wc_add_to_cart_message', 10, 2 );

function quadlayers_custom_wc_add_to_cart_message( $message, $product_id ) {
	$message = sprintf(esc_html__('%s [:en]has been added to your cart.[:ua]додано до кошику.[:ru]добавлен в корзину.[:]','tm-organik'), get_the_title( $product_id ) );
	return $message;
}

/**
 * Get post author and date.
 */

function notd_get_author_and_date() {
	// Posted on.
	$time_string = '<time class="entry-date published updated" datetime="%1$s">%2$s</time>';

	if ( get_the_time( 'U' ) !== get_the_modified_time( 'U' ) ) {
		$time_string = '<time class="entry-date published" datetime="%1$s">%2$s</time><time class="updated" datetime="%3$s">%4$s</time>';
	}

	$time_string = sprintf(
		$time_string,
		esc_attr( get_the_date( 'c' ) ),
		esc_html( get_the_date() ),
		esc_attr( get_the_modified_date( 'c' ) ),
		esc_html( get_the_modified_date() )
	);

	$output_time_string = sprintf( '<a href="%1$s" rel="bookmark">%2$s</a>', esc_url( get_permalink() ), $time_string );

	$posted_on = '
			<span class="posted-on">' .
	             /* translators: %s: post date */
	             sprintf( __( '%s', 'storefront' ), $output_time_string ) .
	             '</span>';

	// Author.
	$author = '';

     // Get terms for post
     $terms = get_the_terms( $post->ID , 'authors' );
     // Loop over each item since it's an array
     if ( $terms != null ){
     foreach( $terms as $term ) {
     // Print the name method from $term which is an OBJECT
     $author = '<span class="post-author"><a href="' . get_term_link( $term->term_id ) . '" class="url fn" rel="author">' . $term->name . '</a></span><span class="bold-dot"> • </span>';
     // Get rid of the other data stored in the object, since it's not needed
     unset($term);
    } }


    echo "<div class='notd-post-meta'>";
	echo wp_kses(
		sprintf( '%2$s %1$s %3$s', $posted_on, $author, null ),
		array(
			'span' => array(
				'class' => array(),
			),
			'a'    => array(
				'href'  => array(),
				'title' => array(),
				'rel'   => array(),
			),
			'time' => array(
				'datetime' => array(),
				'class'    => array(),
			),
		)
	);
    echo "</div>";
}

/**
 * Change labels from coupon to promocode.
 */

add_filter( 'gettext', 'notd_rename_coupon_field_on_cart', 10, 3 );
add_filter( 'woocommerce_coupon_error', 'notd_rename_coupon_label', 10, 3 );
add_filter( 'woocommerce_coupon_message', 'notd_rename_coupon_label', 10, 3 );
add_filter( 'woocommerce_cart_totals_coupon_label', 'notd_rename_coupon_label',10, 1 );
add_filter( 'woocommerce_checkout_coupon_message', 'notd_rename_coupon_message_on_checkout' );

/* WooCommerce */

function notd_rename_coupon_field_on_cart( $translated_text, $text, $text_domain ) {
	// bail if not modifying frontend woocommerce text
	if ( is_admin() || 'woocommerce' !== $text_domain ) {
		return $translated_text;
	}
	if ( 'Coupon:' === $text ) {
		$translated_text = '[:en]Promo Code:[:ua]Промокод[:ru]Промокод[:]';
	}
	if ('Coupon has been removed.' === $text){
		$translated_text = '[:en]Promo code has been removed.[:ua]Промокод видалено.[:ru]Промокод удален.[:]';
	}
	if ( 'Apply coupon' === $text ) {
		$translated_text = '[:en]Apply promo code[:ua]Застосувати промокод[:ru]Применить промокод[:]';
	}
	if ( 'Apply' === $text ) {
		$translated_text = '[:en]Apply[:ua]Застосувати[:ru]Применить[:]';
	}
	if ( 'Coupon code' === $text ) {
		$translated_text = '[:en]Promo Code:[:ua]Промокод[:ru]Промокод[:]';
	}
	return esc_html__($translated_text);
}

// Rename the "Have a Coupon?" message on the checkout page

function notd_rename_coupon_message_on_checkout() {
	return esc_html__('[:en]Have a promo code? [:ua]Маєте промокодод? [:ru]Есть промокод? [:]') . ' ' . '<a href="#" class="showcoupon">' . esc_html__( '[:en]Click here to enter your promo code.[:ua]Клікніть тут, щоб ввести Ваш промокод.[:ru]ликните тут, чтобы ввести ваш промокод.[:]', 'woocommerce' ) . '</a>';
}

function notd_rename_coupon_label( $err, $err_code=null, $something=null ){
	$err = str_ireplace( esc_html__("Coupon"), esc_html__("Promo Code"), $err );
	return $err;
}

/**
 * Change text no product in the cart.
 */

function notd_change_cart_is_empty_text( $translated_text, $text, $domain ) {
	switch ( $translated_text ) {
		case "No products in the cart." :
            $translated_text = esc_html__( '[:en]Cart is empty[:ua]Кошик порожній[:ru]Корзина пустая[:]', 'woocommerce' );
        break;
	}
	return $translated_text;
}
add_filter( 'gettext', 'notd_change_cart_is_empty_text', 20, 3 );

/**
 * Options page.
 */

if( function_exists('acf_add_options_page') ) {

	acf_add_options_page(array(
		'page_title'    => 'Theme General Settings',
		'menu_title'    => 'Theme Settings',
		'menu_slug'     => 'theme-general-settings',
		'capability'    => 'edit_posts',
		'redirect'      => false
	));

	acf_add_options_sub_page(array(
		'page_title'    => 'Our History Section Settings',
		'menu_title'    => 'Our History Section',
		'parent_slug'   => 'theme-general-settings',
	));
	acf_add_options_sub_page(array(
		'page_title'    => 'Subscribe Instagram Section Settings',
		'menu_title'    => 'Subscribe Instagram',
		'parent_slug'   => 'theme-general-settings',
	));

	/*acf_add_options_sub_page(array(
		'page_title'    => 'Theme Header Settings',
		'menu_title'    => 'Header',
		'parent_slug'   => 'theme-general-settings',
	));

	acf_add_options_sub_page(array(
		'page_title'    => 'Theme Footer Settings',
		'menu_title'    => 'Footer',
		'parent_slug'   => 'theme-general-settings',
	));*/

}

/**
 * Blog and post category pages. Filter by category.
 */

function notd_filter_by_post_cat( ){
	$current_cat = get_category( get_query_var( 'cat' ) );
	$current_cat_id = $current_cat->cat_ID;

	$categories = get_categories();

    ?>
    <div class="filter-posts-by-category-slider">
        <div class="carousel post-cats-carousel"  data-flickity='{ "cellAlign": "left", "contain": true, "prevNextButtons": false, "pageDots": false }'>
            <div class="carousel-cell all-posts"><a href="<?php echo home_url(); ?>/blog"><span><?php echo esc_html__('[:en]All[:ua]Все[:ru]Всё[:]'); ?></span></a></div>
            <?php

            foreach($categories as $category) {
                if( $category->cat_ID == $current_cat_id) {
                    echo '<div class="current-cat carousel-cell">';
                } else {
                    echo '<div class="cat carousel-cell">';
                }
                echo '<a href="' . get_category_link($category->term_id) . '"><span>' . $category->name . '</span></a></div>';
            }

            ?>
        </div>
    </div>
<?php
}

/**
 * Get pagination.
 */

function notd_get_pagination( $the_query ){

    echo '<div class="pagination">';
	echo paginate_links( array(
		'base'         => str_replace( 999999999, '%#%', esc_url( get_pagenum_link( 999999999 ) ) ),
		'total'        => $the_query->max_num_pages,
		'current'      => max( 1, get_query_var( 'paged' ) ),
		'format'       => '?paged=%#%',
		'show_all'     => false,
		'type'         => 'plain',
		'end_size'     => 2,
		'mid_size'     => 1,
		'prev_next'    => true,
		'prev_text'    => '<i></i>',
		'next_text'    => '<i></i>',
		'add_args'     => false,
		'add_fragment' => '',
	) );
    echo '</div>';
}

/**
 * Custom user options page.
 * Commented because has been created custom taxonomy for this purpose.
 */

/*function notd_user_options_page() {
	$user_id = get_current_user_id();
	$post_id = 'user_'.$user_id;
	$args = array(
		'page_title' => 'User Options Page',
		'post_id' => $post_id,
	);
	acf_add_options_page($args);
}

add_action('init', 'notd_user_options_page');*/

/**
 * Breadcrumbs for product page. There will be displayed one chosen product category.
 */

function notd_product_breadcrumbs() {
	$br_cat = get_field('cat_for_breadcrumbs');
	if( $br_cat ): ?>
        <div class="storefront-breadcrumb">
            <div class="col-full">
                <div class="woocommerce-breadcrumb custom-breadcrumb">
                    <a href="<?php echo home_url(); ?>"><?php echo esc_html__( '[:en]Home[:ua]Головна[:ru]Главная[:]' ) ?></a>
                    <span class="breadcrumb-separator"></span>
                    <a href="<?php echo esc_url( get_term_link( $br_cat ) ); ?>"><?php echo esc_html( $br_cat->name ); ?></a>
                </div>
            </div>
        </div>
	<?php else: woocommerce_breadcrumb();?>
	<?php endif;
}

/**
 * Breadcrumbs for product page. There will be displayed one chosen product category.
 */

function notd_author_breadcrumbs( $author_name ) {
	if( $author_name ): ?>
        <div class="storefront-breadcrumb">
            <div class="col-full">
                <div class="woocommerce-breadcrumb custom-breadcrumb">
                    <a href="<?php echo home_url(); ?>"><?php echo esc_html__( '[:en]Home[:ua]Головна[:ru]Главная[:]' ) ?></a>
                    <span class="breadcrumb-separator"></span>
					<?php echo esc_html__( $author_name ); ?>
                </div>
            </div>
        </div>
	<?php else: woocommerce_breadcrumb();?>
	<?php endif;
}

/**
 * Filters confirmation message output site-wide.
 */

function wpf_dev_frontend_confirmation_message( $message, $form_data, $fields, $entry_id ) {

	// Only run on my form with ID = 25
	if ( absint( $form_data[ 'id' ] ) !== 578 ) {
		return $message;
	}

	// Get the name field ID '0' to set the name for the message
	$contact_name = $fields[ '0' ][ 'value' ];

	// Add the name to the message
	$message = esc_html__('[:en]Thanks [:ua]Дякуємо, [:ru]Спасибо, [:]' . $contact_name .  '[:en] for contacting us![:ua], що зв\'язалися з нами![:ru], что связались с нами![:]', 'plugin-domain');
	return $message;

}

add_filter( 'wpforms_frontend_confirmation_message', 'wpf_dev_frontend_confirmation_message', 10, 4 );

/**
 * Move shipping block in checkout.
 */

// hook into the fragments in AJAX and add our new table to the group
add_filter('woocommerce_update_order_review_fragments', 'websites_depot_order_fragments_split_shipping', 10, 1);

function websites_depot_order_fragments_split_shipping($order_fragments) {

	ob_start();
	websites_depot_woocommerce_order_review_shipping_split();
	$websites_depot_woocommerce_order_review_shipping_split = ob_get_clean();

	$order_fragments['.websites-depot-checkout-review-shipping-table'] = $websites_depot_woocommerce_order_review_shipping_split;

	return $order_fragments;

}

// We'll get the template that just has the shipping options that we need for the new table
function websites_depot_woocommerce_order_review_shipping_split( $deprecated = false ) {
	wc_get_template( 'checkout/shipping-order-review.php', array( 'checkout' => WC()->checkout() ) );
}


// Hook the new table in before the customer details - you can move this anywhere you'd like. Dropping the html into the checkout template files should work too.
add_action('woocommerce_checkout_before_customer_details', 'websites_depot_move_new_shipping_table', 5);

function websites_depot_move_new_shipping_table() {
	echo '<table class="shop_table websites-depot-checkout-review-shipping-table"></table>';
}

/**
 * Change product image size on single product page.
 */

add_filter( 'woocommerce_get_image_size_single', function( $size ) {
	return array(
		'width'  => 950,
		'height' => '',
		'crop'   => 0,
	);
} );

add_filter( 'woocommerce_get_image_size_gallery_thumbnail', function( $size ) {
	return array(
		'width'  => 200,
		'height' => 200,
		'crop'   => 1,
	);
} );

/**
*   Remove Sorting Option @ WooCommerce Shop
*/

add_filter( 'woocommerce_catalog_orderby', 'notd_remove_sorting_option_woocommerce_shop' );

function notd_remove_sorting_option_woocommerce_shop( $options ) {
   unset( $options['rating'] );
   return $options;
}

/**
*      Rename a Sorting Option @ WooCommerce Shop
*/

add_filter( 'woocommerce_catalog_orderby', 'notd_rename_sorting_option_woocommerce_shop' );

function notd_rename_sorting_option_woocommerce_shop( $options ) {
    $options['date'] = esc_html__( '[:en]Recent first[:ua]Спочатку останні[:ru]Сначала последние[:]' );
    $options['popularity'] = esc_html__( '[:en]By popularity[:ua]За популярністю[:ru]По популярности[:]' );
    $options['price-desc'] = esc_html__( '[:en]By price descending[:ua]За спаданням ціни[:ru]По убыванию цены[:]' );
    $options['price'] = esc_html__( '[:en]By price ascending[:ua]За зростанням ціни[:ru]По возрастанию цены[:]' );
    return $options;
}

/**
 * Get menu items.
**/

function  notd_get_menu_items($menu_name){
    if ( ( $locations = get_nav_menu_locations() ) && isset( $locations[ $menu_name ] ) ) {
        $menu = wp_get_nav_menu_object( $locations[ $menu_name ] );
        return wp_get_nav_menu_items($menu->term_id);
    }
}

/**
 * Post views.
 */

/* Count the views when someone refreshes or view the post. */

function setPostViews($postID) {
    $count_key = 'post_views_count';
    $count = get_post_meta($postID, $count_key, true);
    if($count=='') {
        $count = 0;
        delete_post_meta($postID, $count_key);
        add_post_meta($postID, $count_key, '0');
    } else {
        $count++;
        update_post_meta($postID, $count_key, $count);
    }
}
function getPostViews($postID) {
    $count_key = 'post_views_count';
    $count = get_post_meta($postID, $count_key, true);
    if($count=='') {
        delete_post_meta($postID, $count_key);
        add_post_meta($postID, $count_key, '0');
        return "0 View";
    }
    if ($count > 1000) {
        return round ( $count / 1000 , 1 ).'K Views';
    } else {
        return $count.' Views';
    }
}

/* Add column in your WordPress Admin panel. As well as display each post views. */

function add_post_views_column($defaults) {
    $defaults['post_views'] = __('Views');
    return $defaults;
}

add_filter('manage_posts_columns', 'add_post_views_column');

function get_post_views($column_name, $id){
    if($column_name === 'post_views') {
        echo getPostViews(get_the_ID());
    }
}

add_action('manage_posts_custom_column', 'get_post_views', 10, 2);

/**
 * Create file using WP Theme Editor (if can't reach FTP on hosting).
**/ 

/* add_action('after_setup_theme', function() {
	$file = get_stylesheet_directory() . '/my-file.php';
	if(!file_exists($file)) {
		include_once ABSPATH . 'wp-admin/includes/file.php';
		\WP_Filesystem();
		global $wp_filesystem;
		$wp_filesystem->put_contents($file, '', FS_CHMOD_FILE);
	}
});
*/