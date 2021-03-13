<?php
/**
 * Default UnderStrap child class code.
 * 
 * @package uk_scouts_understrap
 */

 // Exit if accessed directly.
defined( 'ABSPATH' ) || exit;



/* Setup our custom colors in the Editor */
if ( ! function_exists( 'uk_scouts_color_palette_setup' ) ) {
    function uk_scouts_color_palette_setup() {
        $colors = array(
            'light' => '#f1f1f1',
            'dark' => '#404040',
            'blue' => '#0061c',
            'purple' => '#490499',
            'pink' => '#ffb4e5',
            'red' => '#ca1a10',
            'yellow' => '#ffe627',
            'green' => '#008a1c',
            'teal' => '#00a794',
            'navy' => '#002F6C',
            'black' => '#000',
            'white' => '#fff',
        );
        add_theme_support( 'editor-color-palette', array_map(
            function($slug, $hex) {
                return array(
                    'name' => __( ucfirst($slug), 'uk-scouts-understrap' ),
                    'slug' => $slug,
                    'color' => $hex,
                );
            }, array_keys($colors), $colors)
        );
    }
}
add_action( 'after_setup_theme', 'uk_scouts_color_palette_setup' );
