<?php
/**
 * adventure Theme Customizer
 *
 * @package adventure
 */

/**
 * Add postMessage support for site title and description for the Theme Customizer.
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function adventure_customize_register( $wp_customize ) {
	$wp_customize->get_setting( 'blogname' )->transport         = 'postMessage';
	$wp_customize->get_setting( 'blogdescription' )->transport  = 'postMessage';
	$wp_customize->get_setting( 'header_textcolor' )->transport = 'postMessage';

  $wp_customize->add_setting( 'link_color', 
    array( 'default'   => "#D9B54B", 
           'transport' => 'postMessage',
           )
    );
  $wp_customize->add_control(
    new WP_Customize_Color_Control(
      $wp_customize,
      'link_color',
      array(
        'label'    => __( 'Link Color', 'adventure' ),
        'section'  => 'colors',
        'settings' => 'link_color'
        )
      )
    );

  $wp_customize-> get_setting( 'link_color' )->transport = 'postMessage';
}
add_action( 'customize_register', 'adventure_customize_register' );

/**
 * Binds JS handlers to make Theme Customizer preview reload changes asynchronously.
 */
function adventure_customize_preview_js() {
	wp_enqueue_script( 'adventure_customizer', get_template_directory_uri() . '/js/customizer.js', array( 'customize-preview' ), '20130508', true );
}
add_action( 'customize_preview_init', 'adventure_customize_preview_js' );
