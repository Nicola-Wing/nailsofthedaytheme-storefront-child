<?php
/**
 * Template used to display post content on single pages.
 *
 * @package storefront
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

	<?php do_action( 'storefront_single_post_top' ); ?>

    <!-- Track each of page views even after caching enabled. -->
    <!-- mfunc setPostViews(get_the_ID()); --><!-- /mfunc -->
    <?php setPostViews(get_the_ID()); ?>

	<header class="entry-header">
		<?php
		if ( is_single() ) {
			the_title( '<h1 class="entry-title">', '</h1>' );
		} else {
			the_title( sprintf( '<h2 class="alpha entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h2>' );
		}

		notd_get_author_and_date();

		?>
    </header><!-- .entry-header -->
	<?php

	storefront_post_content();

    echo do_shortcode( '[ratemypost]' );


	/**
	 * Functions hooked in to storefront_single_post_bottom action
	 *
	 * @hooked storefront_post_nav         - 10
	 * @hooked storefront_display_comments - 20
	 */
	do_action( 'storefront_single_post_bottom' );
	?>

</article><!-- #post-## -->
