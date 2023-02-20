<?php
/**
 * The template for displaying product content in the single-product.php template
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/content-single-product.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 3.6.0
 */

defined( 'ABSPATH' ) || exit;

global $product;

/**
 * Hook: woocommerce_before_single_product.
 *
 * @hooked woocommerce_output_all_notices - 10
 */
do_action( 'woocommerce_before_single_product' );

if ( post_password_required() ) {
	echo get_the_password_form(); // WPCS: XSS ok.
	return;
}
?>

<div id="product-<?php the_ID(); ?>" <?php wc_product_class( '', $product ); ?>>

	<?php
	/**
	 * Hook: woocommerce_before_single_product_summary.
	 *
	 * @hooked woocommerce_show_product_sale_flash - 10
	 * @hooked woocommerce_show_product_images - 20
	 */
	do_action( 'woocommerce_before_single_product_summary' );
	?>

	<div class="summary entry-summary">
		<?php notd_product_breadcrumbs(); ?>
		<?php
		/**
		 * Hook: woocommerce_single_product_summary.
		 *
		 * @hooked woocommerce_template_single_title - 5
		 * @hooked woocommerce_template_single_rating - 10
		 * @hooked woocommerce_template_single_price - 10
		 * @hooked woocommerce_template_single_excerpt - 20
		 * @hooked woocommerce_template_single_add_to_cart - 30
		 * @hooked woocommerce_template_single_meta - 40
		 * @hooked woocommerce_template_single_sharing - 50
		 * @hooked WC_Structured_Data::generate_product_data() - 60
		 */

		woocommerce_template_single_title(); ?>
        <div class="product-additional-info">
            <?php notd_get_product_sku($product); ?>
            <span class="bold-dot"> • </span>
            <?php notd_stock_catalog(); ?>
        </div>
        <?php

        $current_product_id = $product->get_id();

        $attributes = $product->get_attributes();
        $current_pa_color = $attributes["pa_color"];
        $current_pa_color_name = $product->get_attribute( 'pa_color' );

        if( $current_pa_color ) :
	        $current_pa_color_slug = $current_pa_color->get_slugs()[0]; ?>

            <div class="current-color-wrapper">
               <span class="attr-name"> <?php echo esc_html__( "[:ua]Колір:[:en]Color:[:ru]Цвет:[:]" ) ?> </span>
                <span class="attr-value"> <?php echo $current_pa_color_name; ?> </span>
                <!--<span class="attr-slug"> ( #<?php /*echo $current_pa_color_slug; */?> )</span>-->
            </div>

        <?php endif;

        woocommerce_template_single_price();
        get_template_part("template-parts/additional", "products-by-color", array( 'current-product-id' => $current_product_id )); ?>

        <?php if ( $product->is_in_stock() ): ?>
            <div class="prod-quantity"><?php echo esc_html__( "[:ua]Кількість:[:en]Quantity:[:ru]Количество:[:]" ) ?></div>
        <?php endif; ?>

		<?php

		woocommerce_template_single_add_to_cart();
        ?>
        <div class="mobile-buy-button"><?php
	        echo apply_filters( 'woocommerce_loop_add_to_cart_link',
		        sprintf( '<a href="%s" rel="nofollow" data-product_id="%s" data-product_sku="%s" class="button %s product_type_%s"><span>%s</span><span>%s</span></a>',
			        esc_url( $product->add_to_cart_url() ),
			        esc_attr( $product->get_id() ),
			        esc_attr( $product->get_sku() ),
			        $product->is_purchasable() ? 'add_to_cart_button' : '',
			        esc_attr( $product->get_type() ),
			        esc_html( $product->add_to_cart_text() ),
			        $product->get_price_html()
		        ),
		        $product );
        ?></div>
        <?php
		woocommerce_template_single_sharing();

		/*woocommerce_output_product_data_tabs();*/

		/*do_action( 'woocommerce_single_product_summary' );*/
		?>
	</div>

	<?php
	/**
	 * Hook: woocommerce_after_single_product_summary.
	 *
	 * @hooked woocommerce_output_product_data_tabs - 10
	 * @hooked woocommerce_upsell_display - 15
	 * @hooked woocommerce_output_related_products - 20
	 */
	do_action( 'woocommerce_after_single_product_summary' );

	/*woocommerce_upsell_display();*/

	?>
</div>

<?php do_action( 'woocommerce_after_single_product' ); ?>
