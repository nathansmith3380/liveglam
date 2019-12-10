<?php
/**
 * Template Name: Dashboard Content My Account
 *
 * @package Liveglam
 */
if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}
get_header(); ?>

    <?php while ( have_posts() ) : the_post(); ?>
        <?php global $wp;

        $class = '';
        if ( isset( $wp->query_vars['view-subscription'] ) && 'shop_subscription' == get_post_type( absint( $wp->query_vars['view-subscription'] )  ) ) {
            $class= 'view-subscription';
        } elseif ( isset( $wp->query_vars['view-order'] ) && 'shop_order' == get_post_type( absint( $wp->query_vars['view-order'] )  ) ) {
            $class= 'view-order';
        }?>
        <div class="wc-dashboard-content <?php echo $class; ?>">
            <?php the_content( sprintf(
                wp_kses( __( 'Continue reading %s <span class="meta-nav">&rarr;</span>', 'liveglam_gulp' ), array( 'span' => array( 'class' => array() ) ) ),
                the_title( '<span class="screen-reader-text">"', '"</span>', false )
            ) );
            ?>
        </div>
    <?php endwhile; // End of the loop. ?>

<?php get_footer(); ?>
