<?php
/* Template Name: Contacts Page */

get_header(); ?>

            <div class="contacts-page">

                <div class="cp-form">

                    <div class="left-part">

                        <div class="cp-breadcrumbs">
                            <div class="col-full">
                                <div class="custom-breadcrumb">
                                    <a href="<?php echo home_url(); ?>"><?php echo esc_html__( '[:en]Home[:ua]Головна[:ru]Главная[:]' ) ?></a>
                                    <span class="breadcrumb-separator"> / </span>
                                    <?php echo esc_html__( the_title() ); ?>
                                </div>
                            </div>
                        </div>


                        <?php

                        while ( have_posts() ) :
                            the_post();

                            do_action( 'storefront_page_before' );

                            get_template_part( 'content', 'page' );

                            /**
                             * Functions hooked in to storefront_page_after action
                             *
                             * @hooked storefront_display_comments - 10
                             */
                            do_action( 'storefront_page_after' );

                        endwhile; // End of the loop.
                        ?>

                    </div>

                    <div class="cp-widget-area">
                        <h2><?php echo esc_html__( '[:en]Contacts[:ua]Контакти[:ru]Контакты[:]' ); ?></h2>
	                    <?php dynamic_sidebar( 'notd-contact-page-widget' ); ?>
                    </div>

                </div>


            </div><!-- .contacts-page -->


<?php
get_footer();
