<li class="notd-post-slider-cell carousel-cell">
	<div class="cs-post-item">
		<div class="post-img-cat">
			<div class="cs-post-category-icon">
				<?php notd_get_post_category(); ?>
			</div>
			<div class="cs-post-thumb">
                <?php
                $image = get_field('post_preview_image');
                $size = 'full'; // (thumbnail, medium, large, full or custom size)
                if( $image ) {
                    echo '<a href="' . get_permalink() . '">';
                    echo wp_get_attachment_image( $image, $size );
                    echo '</a>';
                } else {?>
                    <a href="<?php the_permalink();?>"><img src="<?php echo get_stylesheet_directory_uri();?>/assets/images/default-post-img.png" alt="<?php the_title();?>"></a>
                <?php }?>
			</div>
		</div>
		<div class="cs-post-inner">
			<div class="cs-post-meta cs-clearfix">
<!--				<span class="cs-post-meta-author"><a href="<?php /*echo get_author_posts_url(get_the_author_meta('ID'));*/?>"><?php /*the_author();*/?></a></span>-->
                <span class="cs-post-meta-author"><?php notd_get_post_author();?></span>
				<span class="bold-dot"> • </span>
				<span class="cs-post-meta-date"><?php the_date('j F, Y');?></span>
			</div>
			<h4><a href="<?php the_permalink(); ?>"><?php the_title();?></a></h4>
		</div>
	</div>
</li>