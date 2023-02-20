<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<table class="shop_table websites-depot-checkout-review-shipping-table">

    <thead>
    <tr>
        <th scope="col"><?php echo esc_html__('[:en]Shipping method[:ua]Спосіб доставки[:ru]Способ доставки[:]'); ?></th>
    </tr>
    </thead>



	<?php do_action( 'woocommerce_review_order_before_shipping' ); ?>

	<?php wc_cart_totals_shipping_html(); ?>

	<?php do_action( 'woocommerce_review_order_after_shipping' ); ?>

</table>