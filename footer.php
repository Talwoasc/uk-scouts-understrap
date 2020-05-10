<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the #content div and all content after
 *
 * @package understrap
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

$container = get_theme_mod( 'understrap_container_type' );
$charity_number = get_theme_mod( 'uk_scouts_charity_number' );
?>
<footer class="bg-purple text-white" id="page-footer">

    <div class="<?php echo esc_attr( $container ); ?>">
        <div class="row pt-12 pb-8">
            <img width="110" height="80" src="<?php echo esc_url( get_theme_file_uri( '/img/logos/scouts-stack-white.svg' ) ); ?>" alt="Scouts logo" class="mx-auto">
        </div>
    </div>

    <?php get_template_part( 'sidebar-templates/sidebar', 'footerfull' ); ?>

    <div class="<?php echo esc_attr( $container ); ?>">
        <div class="row">
            <div class="col-md-6">
                <p class="small">
                    &copy; Copyright <?php echo esc_html( get_theme_mod( 'uk_scouts_copyright_entity', get_bloginfo( 'name', 'display' ) ) ); ?> 2020. All Rights Reserved.
                    <?php if ( $charity_number ): ?>
                    <br>
                    Charity number: <?php echo $charity_number; ?>.
                    <?php endif ?>
                </p>
            </div>
            <div class="col-md-6">
                <p class="small"><?php echo get_theme_mod( 'uk_scouts_theme_credits', uk_scouts_theme_credits_default() ); ?></p>
            </div>
    </div>

</footer><!-- footer end -->

</div><!-- #page we need this extra closing tag here -->

<?php wp_footer(); ?>

</body>

</html>

