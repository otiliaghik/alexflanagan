<?php
/**
 * Template Name: Get a Job Girl Template
 * Description: Used as a page template to format Get a Job Girl category to look like the gajg page.
 */

add_action( 'genesis_meta', 'metro_gajg_genesis_meta' );
/**
 * Add widget support for gajg page. If no widgets active, display the default loop.
 *
 */
function metro_gajg_genesis_meta() {

	if ( is_active_sidebar( 'gajg-top' ) || is_active_sidebar( 'gajg-middle-left' ) || is_active_sidebar( 'gajg-middle-right' ) || is_active_sidebar( 'gajg-bottom' ) ) {

		// Force content-sidebar layout setting
		add_filter( 'genesis_pre_get_option_site_layout', '__genesis_return_content_sidebar' );

		// Add metro-pro-gajg body class
		add_filter( 'body_class', 'metro_body_class' );
		function metro_body_class( $classes ) {
   			$classes[] = 'metro-pro-gajg';
  			return $classes;
		}

		// Remove the default Genesis loop
		remove_action( 'genesis_loop', 'genesis_do_loop' );

		// Add gajg page widgets
		add_action( 'genesis_loop', 'metro_gajgpage_widgets' );

	}
}

function metro_gajgpage_widgets() {

	genesis_widget_area( 'gajg-top', array(
		'before' => '<div class="gajg-top widget-area">',
		'after'  => '</div>',
	) );
	
	if ( is_active_sidebar( 'gajg-middle-left' ) || is_active_sidebar( 'gajg-middle-right' ) ) {

		echo '<div class="gajg-middle">';

		genesis_widget_area( 'gajg-middle-left', array(
			'before' => '<div class="gajg-middle-left widget-area">',
			'after'  => '</div>',
		) );

		genesis_widget_area( 'gajg-middle-right', array(
			'before' => '<div class="gajg-middle-right widget-area">',
			'after'  => '</div>',
		) );

		echo '</div>';
	
	}

	genesis_widget_area( 'gajg-bottom', array(
		'before' => '<div class="gajg-bottom widget-area">',
		'after'  => '</div>',
	) );

}

genesis();
