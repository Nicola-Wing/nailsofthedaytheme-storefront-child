<?php echo do_shortcode( '[wp1s id="102"]' ); ?>

<hr>

<h2><?php echo esc_html__( '[:ua]Популярні категорії[:en]Popular categories[:ru]Популярные категории[:]' ); ?></h2>

<?php
if( have_rows('popular_categories_slider', 'option') ):
    while( have_rows('popular_categories_slider', 'option') ):
        the_row();
        $show_cats_automate = get_sub_field( 'show_cats_automate' );
        $show_categories_from_chosen = get_sub_field( 'show_categories_from_chosen' );

        if ( $show_cats_automate ) {
            $count_of_categories_in_slider = get_sub_field( 'count_of_categories_in_slider' );
	        echo do_shortcode( '[notd_popular_product_categories limit=' . $count_of_categories_in_slider . ']' );
        }

	    if ( $show_categories_from_chosen ) {
            $choose_categories_that_should_show_in_slider = get_sub_field( 'choose_categories_that_should_show_in_slider' );
		    notd_show_featured_product_cats( $choose_categories_that_should_show_in_slider );
	    }


    endwhile;
endif;

?>


<hr>

<h2 id="products-title"><?php echo esc_html__( '[:ua]Товари[:en]Products[:ru]Товары[:]' ); ?></h2>

<?php

if( have_rows( 'sale_products_slider', 'option' ) ):
	while ( have_rows( 'sale_products_slider', 'option' ) ):
		the_row();
		$sale_products = get_sub_field( 'sale_products' );

		if ( $sale_products ) {
			echo do_shortcode( '[notd_slider_sale_products]' );
		}

	endwhile;
endif;

if( have_rows('top_sells_products_slider', 'option') ):
    while( have_rows('top_sells_products_slider', 'option') ):
        the_row();
        $best_sellers_field = get_sub_field( 'best_sellers' );
        $top_selling_field = get_sub_field( 'top_selling' );

        if ( $best_sellers_field ) {
            $count_of_products_in_slider_field = get_sub_field( 'count_of_products_in_slider' );
            echo do_shortcode( '[notd_slider_bestsellers_products limit=' . $count_of_products_in_slider_field . ']' );
        }
        if ( $top_selling_field ) {
            echo do_shortcode( '[notd_slider_featured_products]' );
        }
    endwhile;
endif;

echo do_shortcode( '[notd_slider_new_products]' );

if( have_rows('sale_products_slider', 'option') ):
    while( have_rows('sale_products_slider', 'option') ):
        the_row();
        $sale_products = get_sub_field( 'sale_products' );

        if ( $best_sellers_field ) {
            echo do_shortcode( '[notd_slider_sale_products]' );
        }
	endwhile;
endif;

?>

<div class="space-130"></div>

