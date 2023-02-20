/* Insert text after email field in checkout. */

jQuery('#billing_country').before( '<h3 class="sh-bil-title">2. Доставка та оплата</h3>' );

/* Change state field placeholder. */

/*jQuery('.select2-selection__placeholder').text('Placeholder text');
alert('!');*/


/* Insert shipping table before billing_state_field. */



jQuery(".websites-depot-checkout-review-shipping-table").insertAfter("#billing_country");