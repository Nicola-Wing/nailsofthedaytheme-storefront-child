<?php
/**
 * Single Product Up-Sells
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/up-sells.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see         https://docs.woocommerce.com/document/template-structure/
 * @package     WooCommerce\Templates
 * @version     3.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( $upsells ) : ?>

	<section class="up-sells upsells products">

		<?php
		echo '<div class="product-slider slider-wrapper close-2">';
		echo '<h3 class="constant-block close-2">' . esc_html__( '[:ua]Схожі[:en]Similar[:ru]Похожие[:]' ) . '</h3>';
		?>

		<?php echo '<div class="carousel" data-flickity=\'{ "cellAlign": "left", "wrapAround": true }\' >'; ?>


        <?php foreach ( $upsells as $upsell ) : ?>

				<?php
				$post_object = get_post( $upsell->get_id() );

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
