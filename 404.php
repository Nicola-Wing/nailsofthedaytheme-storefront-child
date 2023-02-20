<?php
/**
 * The template for displaying 404 pages (not found).
 *
 * @package storefront
 */

get_header(); ?>

	<div class="notd-404-page ">
        <div class="center-content">
            <h3>404</h3>
            <p><?php echo esc_html__( '[:en]Sorry, this page does not exist. But you are in the right direction.[:ua]Вибачте, такої сторінки не знайдено. Але ви у вірному напрямку.[:ru]Извините, такой страницы не существует. Но вы в правильном направлении.[:]' ) ?></p>
            <a href="<?php echo home_url(); ?>"><?php echo esc_html__( '[:en]To home[:ua]На головну[:ru]На главную[:]' ); ?></a>
        </div>

        <?php
        if( have_rows( 'flying_images', 'option' ) ):
            $item_number = 1;
	        while( have_rows( 'flying_images', 'option' ) ) : the_row();
	            $flying_image_item = get_sub_field( 'flying_image_item', 'option' );
		        echo '<div class="flier flier-' . $item_number . '"><img src="' . esc_url( $flying_image_item ) . '"></div>';
		        ++$item_number;
            endwhile;
        endif;
        ?>


    </div>

<?php
get_footer();
