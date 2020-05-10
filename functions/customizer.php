<?php
/**
 * Customizer additions.
 * 
 * @package uk_scouts_understrap
 */

 // Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

/**
 * Set the default value for the Theme Credits
 */
if ( ! function_exists( 'uk_scouts_theme_credits_default' ) ) {
    function uk_scouts_theme_credits_default() {
        $the_theme = wp_get_theme();

        return sprintf(
            '<a href="%1$s">%2$s</a><span class="sep"> | </span>%3$s',
            esc_url( __( 'http://wordpress.org/', 'understrap' ) ),
            sprintf(
                /* translators:*/
                esc_html__( 'Proudly powered by %s', 'understrap' ),
                'WordPress'
            ),
            sprintf( // WPCS: XSS ok.
                /* translators:*/
                esc_html__( '%1$s theme based on %2$s.', 'understrap' ),
                '<strong><a href="' . esc_url( $the_theme->get( 'ThemeURI' ) ) . '">' . $the_theme->get( 'Name' ) . '</a></strong>',
                '<a href="' . esc_url( __( 'http://understrap.com', 'understrap' ) ) . '">understrap.com</a>'
            )
        );
    }
}


/**
 * Add support for the Theme Customizer.
 * 
 * Extra options:
 * - Copyright Entity
 * - Charity Number
 * - Customizable Theme Credits
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
if ( ! function_exists( 'uk_scouts_theme_customize_register' ) ) {
	/**
	 * Register basic customizer support.
	 *
	 * @param object $wp_customize Customizer reference.
	 */
	function uk_scouts_theme_customize_register( $wp_customize ) {
		$wp_customize->get_setting( 'blogname' )->transport         = 'postMessage';
		$wp_customize->get_setting( 'blogdescription' )->transport  = 'postMessage';
        $wp_customize->get_setting( 'header_textcolor' )->transport = 'postMessage';
        

        // Site Info settings.
		$wp_customize->add_section(
			'uk_scouts_siteinfo_options',
			array(
				'title'       => __('Site Info Settings', 'uk-scouts-understrap'),
				'capability'  => 'edit_theme_options',
				'priority'    => 30,
			)
        );

        $wp_customize->add_setting(
			'uk_scouts_copyright_entity',
			array(
				'default'           => get_bloginfo( 'name' ),
				'sanitize_callback' => 'sanitize_text_field',
			)
		);
        
        $wp_customize->add_control(
            'uk_scouts_copyright_entity',
            array(
                'label' => __( 'Copyright Entity Name', 'uk-scouts-understrap' ),
                'type' => 'text',
                'section' => 'uk_scouts_siteinfo_options',
            )
        );

        $wp_customize->add_setting(
			'uk_scouts_charity_number',
			array(
				'sanitize_callback' => 'sanitize_text_field',
			)
		);
        
        $wp_customize->add_control(
            'uk_scouts_charity_number',
            array(
                'label' => __( 'Charity Number', 'uk-scouts-understrap' ),
                'description' => __( 'Can include any text in case you need to specify multiple numbers', 'uk-scouts-understrap'),
                'type' => 'text',
                'section' => 'uk_scouts_siteinfo_options',
            )
        );

        $wp_customize->add_setting(
			'uk_scouts_theme_credits',
			array(
				'default'           => uk_scouts_theme_credits_default(),
				'sanitize_callback' => 'wp_filter_post_kses',
			)
		);
        
        $wp_customize->add_control(
            'uk_scouts_theme_credits',
            array(
                'label' => __( 'Theme Credits', 'uk-scouts-understrap' ),
                'description' => __( 'Let other Scout Groups find this theme so we can all have great looking websites!', 'uk-scouts-understrap'),
                'type' => 'text',
                'section' => 'uk_scouts_siteinfo_options',
            )
        );
	}
}
add_action( 'customize_register', 'uk_scouts_theme_customize_register' );
