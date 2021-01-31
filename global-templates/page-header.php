<?php
/**
 * Custom header template.
 *
 * @package uk_scouts_understrap
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

$container = get_theme_mod( 'understrap_container_type' );

?>

<!-- ******************* The Page Header Area ******************* -->
<?php if ( function_exists('yoast_breadcrumb') ): ?>
    <div class="bg-light">
        <div class="<?php echo esc_attr( $container ); ?>">
            <?php yoast_breadcrumb('<p id="breadcrumbs">','</p>'); ?>
        </div>
    </div>
<?php endif ?>
<?php if ( is_page() ): ?>
    <?php if ( has_post_thumbnail() ): ?>
        <div>
            <?php the_post_thumbnail( "full", ["id" => "page-header-image", "class" => "cover-image"] ); ?>
        </div>
    <?php endif ?>
    <div class="wrapper bg-<?php echo esc_attr( Page_Attributes_Uk_Scouts_Theme::getHeaderBackgroundColor( $post ) ) ?>
                text-<?php echo esc_attr( Page_Attributes_Uk_Scouts_Theme::getHeaderTextColor( $post ) ) ?>">
        <div class="<?php echo esc_attr( $container ); ?>">
            <div class="col-md-12 col-lg-8">
                <header><h1><?php echo esc_html( get_the_title() ); ?></h1></header>
            </div>
        </div>
    </div>
<?php endif ?>