<?php
/**
 * Related Products
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/related.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see         https://docs.woocommerce.com/document/template-structure/
 * @package     WooCommerce\Templates
 * @version     3.9.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( $related_products ) : ?>

	<section class="related products">

		<?php
		$heading = apply_filters( 'woocommerce_product_related_products_heading', __( 'Related products', 'woocommerce' ) );

		if ( $heading ) :
			?>
			<h2><?php echo esc_html( $heading ); ?></h2>
		<?php endif; ?>

        <?php
        echo '<div class="product-slider slider-wrapper close-2">';
        echo '<h3 class="constant-block close-2">' . esc_html__( '[:ua]Зв\'язані[:en]Related[:ru]Связанные[:]' ) . '</h3>';
        ?>

		<?php echo '<div class="carousel" data-flickity=\'{ "cellAlign": "left", "wrapAround": true }\' >'; ?>

			<?php foreach ( $related_products as $related_product ) : ?>

					<?php
					$post_object = get_post( $related_product->get_id() );

					setup_postdata( $GLOBALS['post'] =& $post_object ); // phpcs:ignore WordPress.WP.GlobalVariablesOverride.Prohibited, Squiz.PHP.DisallowMultipleAssignments.Found

                    get_template_part( 'template-parts/product', 'slider' );
					?>

			<?php endforeach; ?>
		<?php echo '</div>'; ?>


        <?php echo '</div>'; ?>

	</section>
	<?php
endif;

wp_reset_postdata();
