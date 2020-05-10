<?php
/**
 * Customizer additions.
 * 
 * @package uk_scouts_understrap
 */

 // Exit if accessed directly.
defined( 'ABSPATH' ) || exit;


if ( ! function_exists( 'uk_scouts_theme_credits_default' ) ) {
    /**
     * Set the default value for the Theme Credits
     */
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

if ( ! function_exists( 'uk_scouts_theme_customize_register_siteinfo' ) ) {
	/**
     * Add siteinfo support for the Theme Customizer.
     * 
     * Extra options:
     * - Copyright Entity
     * - Charity Number
     * - Customizable Theme Credits
     *
     * @param WP_Customize_Manager $wp_customize Theme Customizer object.
     */
	function uk_scouts_theme_customize_register_siteinfo( $wp_customize ) {
    
		$wp_customize->add_section(
			'uk_scouts_siteinfo_options',
			array(
				'title'       => __('Site Info Settings', 'uk-scouts-understrap'),
				'capability'  => 'edit_theme_options',
				'priority'    => 190,
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
add_action( 'customize_register', 'uk_scouts_theme_customize_register_siteinfo' );


if ( ! function_exists( 'uk_scouts_theme_homepage_header_text_default' ) ) {
    /**
     * Set the default value for the Theme Homepage Header Text
     */
    function uk_scouts_theme_homepage_header_text_default() {

        return "As Scouts, we believe in preparing young people with skills for life. We encourage our young people to do more, learn more and be more.";
    }
}

if ( ! function_exists( 'uk_scouts_theme_homepage_header_button_text_default' ) ) {
    /**
     * Set the default value for the Theme Homepage Header Button Text
     */
    function uk_scouts_theme_homepage_header_button_text_default() {

        return "Get Involved";
    }
}

if ( ! function_exists( 'uk_scouts_theme_customize_register_homepage' ) ) {
	/**
     * Add homepage support for the Theme Customizer.
     * 
     * Extra options:
     * - Header title
     * - Header text
     * - Header button with link
     *
     * @param WP_Customize_Manager $wp_customize Theme Customizer object.
     */
	function uk_scouts_theme_customize_register_homepage( $wp_customize ) {
    
        $wp_customize->add_setting(
			'uk_scouts_homepage_header_title',
			array(
				'default'           => get_bloginfo( 'name' ),
				'sanitize_callback' => 'sanitize_text_field',
			)
		);
        
        $wp_customize->add_control(
            'uk_scouts_homepage_header_title',
            array(
                'label' => __( 'Header Title', 'uk-scouts-understrap' ),
                'type' => 'text',
                'section' => 'static_front_page',
            )
        );

        $wp_customize->add_setting(
			'uk_scouts_homepage_header_text',
			array(
                'default'           => uk_scouts_theme_homepage_header_text_default(),
				'sanitize_callback' => 'wp_filter_post_kses',
			)
		);
        
        $wp_customize->add_control(
            'uk_scouts_homepage_header_text',
            array(
                'label' => __( 'Header Text', 'uk-scouts-understrap' ),
                'description' => __( 'Text to display below the header title. Can inlcude HTML.', 'uk-scouts-understrap'),
                'type' => 'textarea',
                'section' => 'static_front_page',
            )
        );

        $wp_customize->add_setting(
			'uk_scouts_homepage_header_button_text',
			array(
				'default'           => uk_scouts_theme_homepage_header_button_text_default(),
				'sanitize_callback' => 'sanitize_text_field',
			)
		);
        
        $wp_customize->add_control(
            'uk_scouts_homepage_header_button_text',
            array(
                'label' => __( 'Header Button Text', 'uk-scouts-understrap' ),
                'description' => __( 'Ne text causes the button to be hidden.', 'uk-scouts-understrap'),
                'type' => 'text',
                'section' => 'static_front_page',
            )
        );

        $wp_customize->add_setting(
			'uk_scouts_homepage_header_button_link',
			array(
				'sanitize_callback' => 'absint',
			)
		);
        
        $wp_customize->add_control(
            'uk_scouts_homepage_header_button_link',
            array(
                'label' => __( 'Header Button Link', 'uk-scouts-understrap' ),
                'type' => 'dropdown-pages',
                'allow_addition' => true,
                'section' => 'static_front_page',
            )
        );

        foreach ( array('beavers', 'cubs', 'scouts', 'explorers', 'network', 'volunteer') as $section ) {
            $wp_customize->add_setting(
                'uk_scouts_homepage_header_' . $section . '_link',
                array(
                    'sanitize_callback' => 'absint',
                )
            );
            
            $wp_customize->add_control(
                'uk_scouts_homepage_header_' . $section . '_link',
                array(
                    'label' => __( ucfirst( $section ) . ' Link', 'uk-scouts-understrap' ),
                    'type' => 'dropdown-pages',
                    'allow_addition' => true,
                    'section' => 'static_front_page',
                )
            );
        }
	}
}
add_action( 'customize_register', 'uk_scouts_theme_customize_register_homepage' );