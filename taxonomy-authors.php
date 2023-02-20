<?php
/* Template Name: Custom Authors taxonomy type Page */

get_header(); ?>

    <div class="blog-page author-page">
        <?php

        global $post;
        $terms = get_the_terms( $post, 'authors' );
        foreach ( $terms as $term ) {
            $term_n_id = $term->taxonomy . '_' . $term->term_id;
            $user_name_to_display = $term->name;
            $some_about_user = $term->description;
            $user_profile_image = get_field( 'user_profile_image', $term_n_id );
            $user_instagram_url = get_field('user_instagram_url', $term_n_id );
            $user_facebook_url = get_field('user_facebook_url', $term_n_id );
        }

        /* Breadcrumbs */
        notd_author_breadcrumbs( $user_name_to_display );

        /* Page header */
        ?>
        <div class="author-page-header">
            <?php
            if( $user_profile_image ): ?>
                <div class="profile-image"><img src="<?php echo esc_url( $user_profile_image ); ?>"></div>
            <?php endif; ?>
            <?php if( $user_name_to_display ): ?>
                <h1><?php echo esc_html__( $user_name_to_display ); ?></h1>
            <?php endif;?>
            <?php if( $some_about_user ): ?>
                <p><?php echo esc_html__( $some_about_user ); ?></p>
            <?php endif;?>
            <div class="social-buttons">
                <?php if( $user_instagram_url ): ?>
                    <a class="insta-link" href="<?php echo esc_url( $user_instagram_url ) ?>"></a>
                <?php endif;?>
                <?php if( $user_facebook_url ): ?>
                    <a class="fb-link" href="<?php echo esc_url( $user_facebook_url ) ?>"></a>
                <?php endif;?>
            </div>
        </div>

        <h2><?php echo esc_html__( '[:en]Author\'s articles[:ua]Статті автора[:ru]Статьи автора[:]' )?></h2>
        <?php
        /* Loop for posts */
        $paged = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1;

        $the_query = new WP_Query( array(
            'post_type'=> 'post',
            'tax_query' => [
                [
                    'taxonomy' => $term->taxonomy,
                    'field' => 'term_id',
                    'terms' => $term->term_id
                ]
            ],
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
        ?>

        <?php
        echo get_template_part( 'template-parts/subscribe', 'insta-banner' );
        ?>
    </div><!-- .blog-page -->

<?php

get_footer();