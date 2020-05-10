<?php
/**
 * Header customisation.
 * 
 * @package uk_scouts_understrap
 */

 // Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

/**
 * Enable the custom-header theme support and provide defaults
 */
if ( ! function_exists( 'understrap_custom_header_setup' ) ) {
	function understrap_custom_header_setup() {

        add_theme_support(
            'custom-header',
            array(
                // Default Header Image to display
                'default-image'          => get_theme_file_uri('/img/headers/default.jpg'),
                // Display the header text along with the image
                'header-text'           => false,
                // Header image width (in pixels)
                'width'                  => 1920,
                'flex-width'             => true,
                // Header image height (in pixels)
                'height'                 => 540,
                'flex-height'            => true,
                // function to be called in theme head section
                //'wp-head-callback'       => 'wphead_cb',
                //  function to be called in preview page head section
                //'admin-head-callback'    => 'adminhead_cb',
                // function to produce preview markup in the admin screen
                //'admin-preview-callback' => 'adminpreview_cb',
            )
        );

    }
}
add_action( 'after_setup_theme', 'understrap_custom_header_setup' );

/**
 * Remove the hero sidebars
 */
if ( ! function_exists( 'uk_scouts_custom_header_widgets_init' ) ) {
	function uk_scouts_custom_header_widgets_init() {

        unregister_sidebar('hero');
        unregister_sidebar('herocanvas');
        unregister_sidebar('statichero');
    }
}
add_action( 'widgets_init', 'uk_scouts_custom_header_widgets_init', 20 );
