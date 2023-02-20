<?php
/* Template Name: Blog Page */

get_header(); ?>

<div class="blog-page">
    <?php

    /* Breadcrumbs */
    woocommerce_breadcrumb();

    /* Page title */
    echo '<h1 class="desktop-h1">' . get_the_title() . '</h1>';
    echo '<h1 class="mobile-h1">' . esc_html__( '[:en]Get inspired[:ua]Надихайтеся[:ru]Вдохновляйтесь[:]' ) . '</h1>';
    ?>

    <?php

    /* Filter by post category */
    notd_filter_by_post_cat();


    /* Loop for posts */
    $paged = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1;

    $the_query = new WP_Query( array(
        'post_type'=> 'post',
        'orderby'    => 'date',
        'post_status' => 'publish',
        'order'    => 'DESC',
        'posts_per_page' => 20,
        'paged' => $paged
    ) );

    if ( $the_query-> have_posts() ) :
        echo '<div class="blog-posts-slider tmpl-full-width-grid-wrapper slider-wrapper ">';
        echo '<div class="posts-slider full-width-post-grip archive-post-wrapper carousel">';
        while ($the_query -> have_posts()) : $the_query -> the_post();
            echo get_template_part( 'template-parts/posts', 'slider' );
        endwhile;
        echo '</div>';
        echo '</div>';

        notd_get_pagination( $the_query );

        ?>
    <?php endif; ?>

    <?php

    wp_reset_postdata();
    the_content();
    ?>

    <?php
    echo get_template_part( 'template-parts/subscribe', 'insta-banner' );
    ?>

</div><!-- .blog-page -->

<?php

get_footer();




