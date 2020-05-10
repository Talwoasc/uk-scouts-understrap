<?php
/**
 * Cusotm header template.
 *
 * @package uk_scouts_understrap
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

$container = get_theme_mod( 'understrap_container_type' );

/**
 * Helper to turn a page id into a permalink or return a default value
 * 
 * @param int $mod The page id
 * @param mixed $default The default value to return
 * 
 * @return string The page permalink or $default
 */
function get_page_link_from_customizer( $mod, $default=false ) {
    $page_id = get_theme_mod( $mod );
    return $page_id ? get_page_link( $page_id ) : $default;
}

$button_text = get_theme_mod( 'uk_scouts_homepage_header_button_text', uk_scouts_theme_homepage_header_button_text_default() );
$button_link = get_page_link_from_customizer( 'uk_scouts_homepage_header_button_link', home_url( '/' ) );

$section_links = array(
    array(
        'text'  => '6-8 yrs',
        'alt'   => 'Beavers',
        'image' => get_theme_file_uri( '/img/logos/logo-beavers.svg' ),
        'link'  => get_page_link_from_customizer( 'uk_scouts_homepage_header_beavers_link' ),
    ),
    array(
        'text'  => '8–10½',
        'alt'   => 'Cubs',
        'image' => get_theme_file_uri( '/img/logos/logo-cubs.svg' ),
        'link'  => get_page_link_from_customizer( 'uk_scouts_homepage_header_cubs_link' ),
    ),
    array(
        'text'  => '10½-14',
        'alt'   => 'Scouts',
        'image' => get_theme_file_uri( '/img/logos/logo-scouts.svg' ),
        'link'  => get_page_link_from_customizer( 'uk_scouts_homepage_header_scouts_link' ),
    ),
    array(
        'text'  => '14-18',
        'alt'   => 'Explorers',
        'image' => get_theme_file_uri( '/img/logos/logo-explorers.svg' ),
        'link'  => get_page_link_from_customizer( 'uk_scouts_homepage_header_explorers_link' ),
    ),
    array(
        'text'  => '18-25',
        'alt'   => 'Network',
        'image' => get_theme_file_uri( '/img/logos/logo-network.svg' ),
        'link'  => get_page_link_from_customizer( 'uk_scouts_homepage_header_network_link' ),
    ),
);
$volunteer = array(
    'text'  => '14 and up',
    'link'  => get_page_link_from_customizer( 'uk_scouts_homepage_header_volunteer_link' ),
);
?>
<!-- ******************* The Custom Header Area ******************* -->
<?php if ( get_header_image() ) : ?>
	<div id="custom-header" class="position-relative">
        <div class="container-cover-image">
            <img src="<?php header_image(); ?>"
                    width="<?php echo absint( get_custom_header()->width ); ?>"
                    height="<?php echo absint( get_custom_header()->height ); ?>"
                    class="cover-image"
            >
        </div>
        <div id="custom-header-content" class="mx-auto py-lg-12 text-light">
            <div class="row mx-0">
                <div class="col-12 col-xl-10 px-0 px-lg-8 mx-auto">
                    <div class="row mx-0">
                        <div class="col-12 col-md-8 p-0 bg-alpha-500">
                            <div class="d-md-none container-cover-image">
                                <img src="<?php header_image(); ?>"
                                        width="<?php echo absint( get_custom_header()->width ); ?>"
                                        height="<?php echo absint( get_custom_header()->height ); ?>"
                                        class="cover-image"
                                >
                            </div>
                            <div class="px-4 py-10 p-lg-12">
                                <h1><?php echo esc_html( get_theme_mod( 'uk_scouts_homepage_header_title', get_bloginfo( 'name', 'display' ) ) ); ?></h1>
                                <p class="lead mt-2 mb-0">
                                    <?php echo get_theme_mod( 'uk_scouts_homepage_header_text', uk_scouts_theme_homepage_header_text_default() ); ?>
                                </p>
                                <?php if ( $button_text ): ?>
                                    <a href="<?php echo esc_url( $button_link ); ?>" class="btn btn-lg btn-outline-light mt-6"><?php echo esc_attr( $button_text ); ?></a>
                                <?php endif ?>
                            </div>
                        </div>
                        <div class="col-12 col-md-4">
                            <div class="row h-100">
                                <div class="col-12 col-sm-6 col-md-12 px-2 py-4 d-flex flex-column justify-content-between bg-purple">
                                <?php foreach ( $section_links as $section ): ?>
                                    <?php if ( $section['link'] ): ?>
                                        <a href="<?php echo esc_url( $section['link'] ); ?>" class="text-reset text-decoration-none d-flex w-100 py-3">
                                    <?php else: ?>
                                        <div class="d-flex align-items-center w-100 py-3">
                                    <?php endif ?>
                                        <div class="w-50 pr-3 pr-lg-4 text-right">
                                            <span class="font-weight-bold"><?php echo esc_html( $section['text'] ); ?></span><i class="fa fa-chevron-right pl-3 pl-lg-4"></i>
                                        </div>
                                        <div class="w-50">
                                            <img src="<?php echo esc_url( $section['image'] ); ?>"
                                                alt="<?php echo esc_attr( $section['alt'] ); ?>"
                                            />
                                        </div>
                                    <?php if ( $section['link'] ): ?>
                                        </a>
                                    <?php else: ?>
                                        </div>
                                    <?php endif ?>
                                <?php endforeach ?>
                                </div>
                                <div class="col-12 col-sm-6 col-md-12 px-2 py-4 d-flex flex-column justify-content-center bg-black">
                                    <span class="text-center"><small><?php _e( 'Gain new skills while helping others' , 'uk-scouts-understrap'); ?></small></span>
                                    <?php if ( $volunteer['link'] ): ?>
                                        <a href="<?php echo esc_url( $volunteer['link'] ); ?>" class="text-reset text-decoration-none d-flex w-100 py-3">
                                    <?php else: ?>
                                        <div class="d-flex align-items-center w-100 py-3">
                                    <?php endif ?>
                                        <div class="w-50 pr-3 pr-lg-4 text-right">
                                            <span class="font-weight-bold"><?php echo esc_html( $volunteer['text'] ); ?></span><i class="fa fa-chevron-right pl-3 pl-lg-4"></i>
                                        </div>
                                        <div class="w-50">
                                            <span class="h4"><?php _e( 'Volunteer' , 'uk-scouts-understrap'); ?></span>
                                        </div>
                                    <?php if ( $section['link'] ): ?>
                                        </a>
                                    <?php else: ?>
                                        </div>
                                    <?php endif ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div><!-- #custom-header end -->
<?php else: ?>
    <div class="wrapper bg-navy text-light">
        <div class="<?php echo esc_attr( $container ); ?>">
            <div class="col-md-12 col-lg-8">
                <h1><?php echo esc_html( get_theme_mod( 'uk_scouts_homepage_header_title', get_bloginfo( 'name', 'display' ) ) ); ?></h1>
                <p class="lead mt-2 mb-0">
                    <?php echo get_theme_mod( 'uk_scouts_homepage_header_text', uk_scouts_theme_homepage_header_text_default() ); ?>
                </p>
                <?php if ( $button_text ): ?>
                    <a href="<?php echo esc_url( $button_link ); ?>" class="btn btn-lg btn-outline-light mt-6"><?php echo esc_attr( $button_text ); ?></a>
                <?php endif ?>
            </div>
        </div>
    </div>
<?php endif ?>
