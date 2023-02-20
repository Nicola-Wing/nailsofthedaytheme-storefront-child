<?php

if(get_field('additional_products_by_color')) : ?>
	<div class="additional-products-by-color-wrapper">
		<?php $colors_list = get_field('additional_products_by_color');
		foreach( $colors_list as $item_id):

			$product = wc_get_product($item_id);
			$attributes = $product->get_attributes();
			$pa_color = $attributes["pa_color"];
			$pa_color_slug = '';
			$pa_color_name = $product->get_attribute( 'pa_color' );;
			if( $pa_color ) :
				$pa_color_slug = $pa_color->get_slugs()[0];
            endif;

			$class_is_current = "additional-product";
			if( $item_id == $args['current-product-id'] ) {
				$class_is_current = "current-product";
			} ?>

			<div class="colors-product-list-item container" id="<?php echo $class_is_current; ?>">
                <a href="<?php echo get_permalink( $item_id ); ?>">
                    <?php

                    echo get_the_post_thumbnail(
                        $item_id,
                        'thumbnail',
                        $attr = array(
                            'src' => get_permalink( $item_id ),
                            'class' => "image item-$item_id",
                            'alt' => get_the_title( $item_id ),
                            'title' => get_the_title( $item_id ),
                        )
                    ); ?>
                </a>

                    <a href="<?php echo get_permalink( $item_id ); ?>">
                        <div class="overlay-color-slug">
                        <?php echo $pa_color_name; ?>
                        <?php /*echo "#". $pa_color_slug; */?>
                        </div>
                    </a>



			</div>
		<?php endforeach; ?>
	</div>
<?php endif; ?>
<?php

