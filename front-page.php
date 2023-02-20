<?php
get_header(); ?>

<?php


echo get_template_part( 'template-parts/shop', 'upper-content' );

echo get_template_part( 'template-parts/our', 'history' );

echo do_shortcode( '[notd_slider_posts]' );

echo get_template_part( 'template-parts/subscribe', 'insta-banner' );




?>

<?php


if ( have_posts() ) {
	while ( have_posts() ) : the_post();
		the_content();
	endwhile;
}

?>
<?php


get_footer();




