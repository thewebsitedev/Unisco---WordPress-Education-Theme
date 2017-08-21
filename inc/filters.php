<?php
/**
 * Theme Filters
 */

/**
 *  Front slider filter
 */
if( !function_exists( 'unisco_header_front_slider' ) ) {
	function unisco_header_front_slider() {
		return apply_filters( 'unisco_header_front_slider', true );
	}
}

/**
 * Header image filter
 */
if( !function_exists( 'unisco_header_image' ) ) {
	function unisco_header_image() {
		// default image --> get_template_directory_uri() . '/images/slider.jpg'
		return apply_filters( 'unisco_header_image', get_header_image() );
	}
}

/**
 * Menu class filter
 */
if( !function_exists( 'unisco_header_menu_class' ) ) {
	function unisco_header_menu_class() {
		$menu_class = apply_filters( 'unisco_header_menu_class', ''  );
		$display_front_slider = get_theme_mod( 'unisco_slider_front', 'no' );

		if( unisco_header_front_slider() && $display_front_slider === 'yes' && is_front_page() ) {
			$menu_class = ' nav-menu';
		}

		return $menu_class;
	}
}

if( !function_exists( 'unisco_hide_title' ) ) {
	function unisco_hide_title( $post ) {
		$meta = get_post_meta( $post->ID, 'unisco_options', true );
		$display_title = apply_filters( 'unisco_hide_title', isset( $meta['hide_title']) ? $meta['hide_title'] : 'no' );

		return $display_title;
	}
}