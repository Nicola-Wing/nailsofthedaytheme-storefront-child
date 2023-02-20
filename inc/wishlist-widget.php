<?php

function notd_wishlist_register_widget() {
	register_widget( 'notd_wishlist_widget' );
}
add_action( 'widgets_init', 'notd_wishlist_register_widget' );


class notd_wishlist_widget extends WP_Widget {
	function __construct() {
		parent::__construct(
			// widget ID
			'notd_wishlist_widget',
			// widget name
			__('NOTD Wishlist Widget', ' notd_wishlist_widget_domain'),
			// widget description
			array( 'description' => __( 'NOTD Wishlist Widget', 'notd_wishlist_widget_domain' ), )
		);
	}
	public function widget( $args, $instance ) {
		$title = apply_filters( 'widget_title', $instance['title'] );
		echo $args['before_widget'];
		//output?>
		<a href="<?php echo addonify_wishlist_get_wishlist_page_url(); ?>"><img src="<?php echo get_stylesheet_directory_uri() . '/assets/images/wishlist-icon.svg'; ?>"></a>
		<?php
		echo $args['after_widget'];
	}

	public function form( $instance ) { ?>
		<p>Wishlist icon is activated.</p>
		<?php
	}
	public function update( $new_instance, $old_instance ) {
		$instance = array();
		$instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
		return $instance;
	}
}