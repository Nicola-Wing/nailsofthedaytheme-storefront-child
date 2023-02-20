<?php
/* Template Name: WP Author Page */

get_header(); ?>

    <div class="blog-page author-page">
		<?php

		$curauth = (isset($_GET['author_name'])) ? get_user_by('slug', $author_name) : get_userdata(intval($author));
        $auth_id = $curauth->ID;
		$user_profile_image = get_field('user_profile_image', 'user_' . $auth_id );
		$user_name_to_display = get_field('user_name_to_display', 'user_' . $auth_id );
		$some_about_user = get_field('some_about_user', 'user_' . $auth_id );
		$user_instagram_url = get_field('user_instagram_url', 'user_' . $auth_id );
		$user_facebook_url = get_field('user_facebook_url', 'user_' . $auth_id );


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
			'author' => $auth_id,
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




