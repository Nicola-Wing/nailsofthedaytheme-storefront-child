<?php
/**
 * The template for displaying all single posts.
 *
 * @package storefront
 */

get_header(); ?>

<style>
    #secondary {
        display: none;
    }

</style>

    <div id="primary" class="content-area single-post-page">
        <main id="main" class="site-main" role="main">

	        <?php woocommerce_breadcrumb(); ?>

	        <?php

	        while ( have_posts() ) :
		        the_post();

		        do_action( 'storefront_single_post_before' );

		        get_template_part( 'content', 'single' );

		        do_action( 'storefront_single_post_after' );

	        endwhile; // End of the loop.
            ?>
            <div class="notd-content">
            <?php
	        echo do_shortcode( '[notd_slider_posts]' );

	        echo get_template_part( 'template-parts/subscribe', 'insta-banner' );
	        ?>
            </div>
		</main><!-- #main -->
	</div><!-- #primary -->

<?php
do_action( 'storefront_sidebar' );
get_footer();
