<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the #content div and all content after
 *
 * @package storefront
 */

?>

		<!--</div>--><!-- .col-full -->
	</div><!-- .notd-content -->
</div>

	<?php do_action( 'storefront_before_footer' ); ?>

	<footer id="colophon" class="site-footer" role="contentinfo">
		<div class="col-full">
            <div class="mobile-footer"><?php wp_nav_menu( array( 'theme_location' => 'max_mega_menu_4' ) ); /* Show Footer Mobile Menu */ ?></div>
            <div class="desktop-footer">
                <?php
                /**
                 * Functions hooked in to storefront_footer action
                 *
                 * @hooked storefront_footer_widgets - 10
                 * @hooked storefront_credit         - 20
                 */
                do_action( 'storefront_footer' );
                ?>
            </div>
            <div class="mobile-after-footer"><p>© 2022 Nails Of The Day. All Rights Reserved </p></div>
		</div><!-- .col-full -->
	</footer><!-- #colophon -->

	<?php do_action( 'storefront_after_footer' ); ?>

</div><!-- #page -->

<?php wp_footer(); ?>

</body>
</html>
