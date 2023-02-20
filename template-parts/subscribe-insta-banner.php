<div class="subscr-insta-banner">
    <?php
    $sbs_insta_sect_img_desktop = get_field('sbs_insta_sect_img_desktop', 'option');
    $sbs_insta_sect_img_mobile = get_field('sbs_insta_sect_img_mobile', 'option');
    $sbs_insta_banner_text = get_field('sbs_insta_banner_text', 'option');
    $sbs_insta_button = get_field('sbs_insta_button', 'option');
    ?>

	<?php if( $sbs_insta_sect_img_desktop ): ?>
        <img id="desktop" src="<?php echo esc_url( $sbs_insta_sect_img_desktop ); ?>">
	<?php endif; ?>
	<?php if( $sbs_insta_sect_img_mobile ): ?>
        <img id="mobile" src="<?php echo esc_url( $sbs_insta_sect_img_mobile ); ?>">
	<?php endif; ?>
    <div class="subscr-text-block">
	    <?php if( $sbs_insta_banner_text ): ?>
            <h2><?php echo esc_html__( $sbs_insta_banner_text ); ?></h2>
	    <?php endif; ?>
	    <?php if( $sbs_insta_button ):
		    $sbs_link_url = $sbs_insta_button['url'];
		    $sbs_link_title = $sbs_insta_button['title'];
		    $sbs_link_target = $sbs_insta_button['target'] ? $sbs_insta_button['target'] : '_self';
            ?>
            <button class="white-btn">
                <a href="<?php echo esc_url( $sbs_link_url ); ?>" target="<?php echo esc_attr( $sbs_link_target ); ?>">
                    <p><?php echo esc_html__( $sbs_link_title ); ?></p>
                </a>
            </button>
	    <?php endif; ?>
    </div>
</div>

