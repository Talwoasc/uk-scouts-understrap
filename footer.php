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

$charity_number = get_theme_mod( 'uk_scouts_charity_number' );
?>
<footer class="wrapper bg-purple text-white" id="page-footer">

    <div class="container">
        <div class="row">
            <img width="110" height="80" src="<?php echo get_theme_file_uri( '/img/logos/scouts-stack-white.svg' ); ?>" alt="Scouts logo" class="mx-auto">
        </div>
    </div>

    <?php get_template_part( 'sidebar-templates/sidebar', 'footerfull' ); ?>

    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <p class="small">
                    &copy; Copyright <?php echo get_theme_mod( 'uk_scouts_copyright_entity', get_bloginfo( 'name' ) ); ?> 2020. All Rights Reserved.
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

