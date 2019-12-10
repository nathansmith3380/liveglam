<?php
/**
 * The template for displaying single testimonials
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Liveglam
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

get_header(); ?>

<section class="sinlge-testimonials-section auto-height">
    <div class="cutes">
        <img class="cute-1 float-cute" src="<?php echo get_stylesheet_directory_uri().'/assets/img/cute-1.png'; ?>">
        <img class="cute-2 float-cute" src="<?php echo get_stylesheet_directory_uri().'/assets/img/cute-2.png'; ?>">
        <img class="cute-3 rotate-cute" src="<?php echo get_stylesheet_directory_uri().'/assets/img/cute-3.png'; ?>">
        <img class="cute-4 rotate-cute" src="<?php echo get_stylesheet_directory_uri().'/assets/img/cute-4.png'; ?>">
    </div>
    <div class="container">

        <?php  while ( have_posts() ) : the_post();

        if ($further_choose = get_field('further_choose')):
            switch ($further_choose) {
                case "Facebook": $img_choose = get_stylesheet_directory_uri()."/assets/img/facebook-facebook.svg"; break;
                case "Yelp": $img_choose = get_stylesheet_directory_uri()."/assets/img/icon-yelp.png"; break;
                case "Google": $img_choose = get_stylesheet_directory_uri()."/assets/img/google_icon.png"; break;
                case "Youtube": $img_choose = get_stylesheet_directory_uri()."/assets/img/youtube.png"; break;
                case "Twitter": $img_choose = get_stylesheet_directory_uri()."/assets/img/icon-twitter2.png"; break;
                case "Instagram": $img_choose = get_stylesheet_directory_uri()."/assets/img/IMG_icon-instagram.svg"; break;
            }
        endif;
        ?>
        <div class="row">
            <div class="col-md-4 col-sm-6">
                <div class="image-box" style="background-image: url(<?php echo wp_get_attachment_image_src( get_post_thumbnail_id( get_the_ID() ), 'single-post-thumbnail', false )[0]; ?>)"></div>                        
            </div>
            <div class="col-md-8 col-sm-6">                            
                <div class="image-content"> 
                    <h1>What Our<br>Clients Are Saying</h1>
                    <div class="quotes">“</div>                           
                    <div class="text">
                        <?php the_content(); ?>
                    </div>
                    <div class="name"><?php echo the_field('testimonial_name'); ?></div>
                    <?php if ($further_choose): ?>
                        <div class="social">
                            <img src="<?php echo $img_choose; ?>" alt="<?php echo strtolower($further_choose); ?>">
                            <div class="handle"><?php the_field('name_handle'); ?></div>
                        </div>
                    <?php endif;?>
                </div>                        
            </div>
        </div>
        <?php endwhile; ?>

    </div>
</section>
<?php get_footer(); ?>
