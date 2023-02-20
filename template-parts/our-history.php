<div class="gray-wide-content-block">
    <div class="narrow-content-block">
        <?php
        $image_desktop = get_field('our_history_img_desktop', 'option');
        $image_mobile = get_field('our_history_img_mobile', 'option');
        $our_history_title = get_field('our_history_title', 'option');
        $text_col_1 = get_field('text_column_1', 'option');
        $text_col_2 = get_field('text_column_2', 'option');
        $button_more_about_us = get_field('button_more_about_us', 'option');
        ?>
	    <?php if( $image_desktop ): ?>
            <img id="desktop" src="<?php echo esc_url( $image_desktop ); ?>">
	    <?php endif; ?>
	    <?php if( $image_mobile ): ?>
            <img id="mobile" src="<?php echo esc_url( $image_mobile ); ?>">
	    <?php endif; ?>
	    <?php if( $our_history_title ): ?>
            <h3><?php echo esc_html__( $our_history_title ); ?></h3>
	    <?php endif; ?>
        <div class="set-of-2-col">
	        <?php if( $text_col_1 ): ?>
                <div class="col-half">
                    <p>
                        <?php echo esc_html__( $text_col_1 ); ?>
                    </p>
                </div>
	        <?php endif; ?>
	        <?php if( $text_col_2 ): ?>
                <div class="col-half">
                    <p>
                        <?php echo esc_html__( $text_col_2 ); ?>
                    </p>
                </div>
	        <?php endif; ?>
        </div>
	    <?php if( $button_more_about_us ):
		    $link_url = $button_more_about_us['url'];
		    $link_title = $button_more_about_us['title'];
		    $link_target = $button_more_about_us['target'] ? $button_more_about_us['target'] : '_self';
            ?>
            <button class="about-us front-about-page-button">
                <a href="<?php echo esc_url( $link_url ); ?>" target="<?php echo esc_attr( $link_target ); ?>"><p><?php echo esc_html__( $link_title ); ?></p></a>
            </button>
	    <?php endif; ?>
    </div>
</div>

<?php
