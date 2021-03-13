<?php
/**
 * UK Scouts Understrap functions and definitions
 *
 * @package uk_scouts_understrap
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

$uk_scouts_understrap_includes = array(
    '/child.php',                           // Default UnderStrap child class code.
    '/customizer.php',                      // Customizer additions.
    '/custom-header.php',                   // Header customisation.
    '/page-attributes.php',                 // Additional attributes for pages.
    '/widgets.php',                         // Widget declarations and extensions.
    '/gutenberg.php',                       // Customizations for the Gutenberg Editor.
);

foreach ( $uk_scouts_understrap_includes as $file ) {
	require_once 'functions' . $file;
}
