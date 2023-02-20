// get JSON url
let WpJsonUrl = document.querySelector('link[rel="https://api.w.org/"]').href
// then take out the '/wp-json/' part
let homeUrl = WpJsonUrl.replace('/wp-json/','');


/* Move Side Cart Icon to div in header widget. */
jQuery(".vi-wcaio-sidebar-cart-icon-wrap").appendTo(".side-cart-header-widget");
/* Check count of items in catr and change the icon if needed. */
/*let cartCount = document.getElementsByClassName('vi-wcaio-sidebar-cart-count')[0].innerHTML.trim().toLowerCase();

if (cartCount == "0" ) {
    jQuery(".vi-wcaio-sidebar-cart-icon").prepend("<img class='header-menu-cart-icon empty-cart' src='" + homeUrl + "/wp-content/themes/storefront-child/assets/images/shopping_bag.svg'>");
    jQuery(".vi-wcaio-sidebar-cart-count-wrap").hide();
} else {
    jQuery(".vi-wcaio-sidebar-cart-icon").prepend("<img class='header-menu-cart-icon full-cart' src='" + homeUrl + "/wp-content/themes/storefront-child/assets/images/shopping_bag_red.svg'>");
    jQuery(".vi-wcaio-sidebar-cart-count-wrap").show();
}

jQuery('.vi-wcaio-sidebar-cart-count').on('change', function(){
    alert('changed');
});
*/

/* Move Mobile Lang Widget to ul in header mobile widget. */
/*jQuery(".lang-mobile-widget").appendTo(".mobile-main-menu .mega-menu-wrap ul");*/
jQuery(".lang-mobile-widget").appendTo(".mobile-main-menu .mega-menu-wrap .mega-menu-toggle");

/* Make Categories tab in Mobile Main Manu active */

jQuery(document).ready(function() {
    let catTab = document.getElementById("mega-menu-item-66");
    setTimeout(function(){
        jQuery(catTab).addClass("mega-toggle-on");
    }, 1000);
});

jQuery('.mega-menu-toggle').click(function() {
    let menuTab = document.getElementById("mega-menu-item-67");
    let catTab = document.getElementById("mega-menu-item-66");
    if (!jQuery(menuTab).hasClass("mega-toggle-on")) {
        jQuery(catTab).addClass("mega-toggle-on");
    }
});


/*let catTab = document.getElementById("mega-menu-item-66");
alert(catTab.className);
jQuery(catTab).addClass("mega-toggle-on");
alert(catTab.className);*/

/*
let alreadyActivated = document.getElementsByClassName("mega-menu-item-66 mega-toggle-on")[0];
if( alreadyActivated == null ) {
    let catTab = document.getElementsByClassName("mega-menu-item-66")[0];
    jQuery(catTab).addClass("mega-toggle-on");
}
*/

/* Move Price to "Buy" button on single product page. */
jQuery(".single-product-page .summary p.price").appendTo(".single-product-page .summary button.single_add_to_cart_button");


/* Insert referenceNode after newNode. */
/*function insertAfter(newNode, referenceNode) {
    referenceNode.parentNode.insertBefore(newNode, referenceNode.nextSibling);
}

let billingForm = document.getElementsByClassName("woocommerce-billing-fields__field-wrapper")[0];
let billingFormSurname = billingForm.getElementById("billing_last_name_field");
let billingFormPhone = billingForm.getElementById("billing_phone_field");
insertAfter(billingFormSurname, billingFormPhone);*/






/*let alreadyOpenedMenu = document.getElementsByClassName("mega-menu-toggle mega-menu-open")[0];
if( alreadyOpenedMenu != null ) {
    let catTab = document.getElementsByClassName("mega-menu-item-66")[0];
    catTab.className += " mega-toggle-on";
    alert(catTab.className);
}*/

/*let btn = document.getElementById("mega-toggle-block-1");
jQuery(btn).on("click", function() {
    alert('Click!');
});*/



/*let mobileMainMenu = document.getElementsByClassName("mobile-main-menu")[0];
let megaMenuWrapMaxMegaMenu1 = mobileMainMenu.getElementById("mega-menu-wrap-max_mega_menu_1");
let megaMenuToggleMegaMenuOpen = megaMenuWrapMaxMegaMenu1.getElementsByClassName("mega-menu-toggle mega-menu-open")[0];
let megaToggleBlocksLeft = megaMenuToggleMegaMenuOpen.getElementsByClassName("mega-toggle-blocks-left")[0];
let megaToggleBlock1 = megaToggleBlocksLeft. getElementById("mega-toggle-block-1");
let toggleButton = megaToggleBlock1.getElementsByClassName("mega-toggle-animated")[0];*/

/*jQuery(toggleButton).click(function() {
    alert("hello");
    /!*catTab.className += " mega-toggle-on";*!/
    /!*element.classList.remove(" mega-toggle-on");*!/
})*/


/* Add mobile icon in header */
/*jQuery('#mega-menu-wrap-max_mega_menu_1').append('' +
    '<div class="mobile-site-branding">' +
        '<a href="' + homeUrl + '">' +
            '<img src="' + homeUrl + '/wp-content/themes/storefront-child/assets/images/logo-mobile.png" alt="mobile-logo">' +
        '</a>' +
    '</div>');*/

/* Make filter wrapper hidden and black bottom buttons visible. */

if (jQuery(window).width() <= 768) {

    /*let upperMenuFiltersMobileButton = document.getElementsByClassName("upper-menu-filters-mobile-button")[0];
    upperMenuFiltersMobileButton.style.visibility = "hidden";
    jQuery(upperMenuFiltersMobileButton).fadeOut(0);

    let archiveProductGridWrapper = document.getElementsByClassName("archive-product-grid-wrapper")[0];
    let widgetWpcFiltersWidget = archiveProductGridWrapper.getElementsByClassName("widget_wpc_filters_widget")[0];
    let wpcFiltersWidgetMainWrapper = widgetWpcFiltersWidget.getElementsByClassName("wpc-filters-widget-main-wrapper")[0];
    wpcFiltersWidgetMainWrapper.style.visibility = "hidden";
    jQuery(wpcFiltersWidgetMainWrapper).fadeOut(0);

    let blackFilterButton = document.getElementsByClassName("filters-mobile-button")[0];
    let blackSortingButton = document.getElementsByClassName("soring-wrapper")[0];

    blackFilterButton.style.visibility = "visible";
    blackSortingButton.style.visibility = "visible";*/

    let upperMenuFiltersMobileButton = document.getElementsByClassName("upper-menu-filters-mobile-button")[0];
    upperMenuFiltersMobileButton.style.visibility = "hidden";
    jQuery(upperMenuFiltersMobileButton).fadeOut(0);

    let archiveProductGridWrapper = document.getElementsByClassName("archive-product-grid-wrapper")[0];
    let widgetWpcFiltersWidget = archiveProductGridWrapper.getElementsByClassName("widget_wpc_filters_widget")[0];
    let wpcFiltersWidgetMainWrapper = widgetWpcFiltersWidget.getElementsByClassName("wpc-filters-widget-main-wrapper")[0];
    wpcFiltersWidgetMainWrapper.style.visibility = "hidden";
    jQuery(wpcFiltersWidgetMainWrapper).fadeOut(0);

    let blackFilterButton = document.getElementsByClassName("filters-mobile-button")[0];
    let blackSortingButton = document.getElementsByClassName("soring-wrapper")[0];

    blackFilterButton.style.visibility = "visible";
    blackSortingButton.style.visibility = "visible";

}


/*let wpcFiltersSubmitButton = document.getElementsByClassName("wpc-filters-submit-button")[0];

wpcFiltersSubmitButton.addEventListener('click', function (){
    alert("))))))");
    let archiveProductGridWrapper3 = document.getElementsByClassName("archive-product-grid-wrapper")[0];
    let widgetWpcFiltersWidget3 = archiveProductGridWrapper3.getElementsByClassName("widget_wpc_filters_widget")[0];
    let wpcFiltersWidgetMainWrapper3 = widgetWpcFiltersWidget3.getElementsByClassName("wpc-filters-widget-main-wrapper")[0];

    wpcFiltersWidgetMainWrapper3.style.visibility = "hidden";
}); */



/* Check if "Filter" name is in it's div or disappeared */

/*jQuery(".wpc-filters-submit-button").click(function(event) {
    location.reload();
})

jQuery(document).ready(function()
{

    jQuery(".wpc-filters-submit-button").click(function(event) {
        location.reload();
    })*/

    /*spanAlert();
    function spanAlert() {
        if( spanExists() ) {
            alert('Span Exists');
        } else {
            alert('Span not exists');
        }
    }

    function spanExists(){
        return jQuery(".wpc-open-close-filters-button span").length > 0;
    }*/

    /*let text = jQuery("p.woocommerce-result-count").text();
    alert( text );

    jQuery("p.woocommerce-result-count").on("change", function() {
        alert('Text content changed!');
    });*/

    /*let span = jQuery(".wpc-open-close-filters-button span").html();
    jQuery("<div class='additional-span'>" + span + "</div>").appendTo(".wpc-open-close-filters-button");*/



    /*jQuery("p.woocommerce-result-count").on("change", function() {
        alert('Text content changed!');
    });*/

    /*jQuery(".wpc-filters-submit-button").click(function(event) {
        let timeout = setTimeout(function() {
            alert("Foo");
        }, 3000)
    });*/

    /*jQuery("a.wpc-filters-submit-button").click(function() {
        if (jQuery(".wpc-filters-overlay").offset().top == 0) {
            alert("Element Visible.");
            spanAlert();
        } else {
            alert(" Hidden Element.");
            spanAlert();
        }
        spanAlert();
    });*/

/*

})*/


/* Put product sliders prev next buttons in additional div */
/*jQuery('.flickity-prev-next-button.previous, .flickity-prev-next-button.next').wrapAll('<div class="prew-next-btns-wrapper">');*/


/* If mobile then move brice to "Buy" button */
/*if (jQuery(window).width() <= 1140) {
    let sliders = document.getElementsByClassName('.product-slider li');
    for(let i = 0; i < sliders.length; i++){
        alert(sliders[i]);
    }
    /!*jQuery(".product-slider li a span.price").appendTo(".product-slider li a.add_to_cart_button");*!/
}
else {
    alert('More than 1140');
}*/
