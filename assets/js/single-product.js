/* Add class "top-page-span" to sale badge on single product page for curren product. */
let singleProductPage = document.getElementsByClassName("single-product-page")[0];
let saleBadge = singleProductPage.getElementsByClassName("custom-discount-amount-sale-badge")[0];
saleBadge.className += " top-page-span";


/* Make notify form hidden. */

let formNotify = document.getElementById("notd-notify-form");
formNotify.style.display = "none";