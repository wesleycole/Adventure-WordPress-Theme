<?php
/**
 * Jetpack Compatibility File
 * See: http://jetpack.me/
 *
 * @package adventure
 */

/**
 * Add theme support for Infinite Scroll.
 * See: http://jetpack.me/support/infinite-scroll/
 */
function adventure_jetpack_setup() {
	add_theme_support( 'infinite-scroll', array(
		'container' => 'content',
		'footer'    => 'page',
	) );
}
add_action( 'after_setup_theme', 'adventure_jetpack_setup' );
