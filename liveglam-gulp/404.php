<?php
/**
 * The template for displaying 404 pages (not found).
 *
 * @link https://codex.wordpress.org/Creating_an_Error_404_Page
 *
 * @package Liveglam
 */
if ( ! defined( 'ABSPATH' ) ) {
  exit; // Exit if accessed directly
}
get_header(); ?>

<section class="error-404 not-found">
    <div class="page-container">
        <img class="show-desktop" src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/404-bg-desktop.png"/>
        <img class="show-mobile" src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/404-bg-mobile.png"/>
        <div class="text text-center">
            <h2 class="text-big nd19-hero-title"><?php esc_html_e('We can’t seem to find the page you’re looking for!', 'liveglam_gulp'); ?></h2>
            <p class="nd19-section-subtitle"><?php esc_html_e("It may be broken or this page has hit pan.", 'liveglam_gulp'); ?><br><br class="show-mobile"><?php esc_html_e("Let's get you back to the glam!", 'liveglam_gulp'); ?></p>
            <div class="return_null">
                <a href="<?php echo home_url(); ?>">
                    <button class="btn-primary">Return home</button>
                </a>
            </div>
        </div>
    </div><!-- .page-content -->
</section><!-- .error-404 -->
<?php get_footer(); ?>