<?php
/**
 * Template part for displaying single posts.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Liveglam
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
    <header class="entry-header">

        <?php
        if ( has_post_thumbnail() ) { // check if the post has a Post Thumbnail assigned to it.
            the_post_thumbnail();
        }
        ?>
        <?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>

        <div class="entry-meta col-xl-12">
            <div class="col-xl-4 no-padding">
                <?php liveglam_posted_on(); ?>
            </div>
            <div class="col-xl-8 no-padding">
                <p class="col-xl-2 luvthispost"><i class="fas fa-heart" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="" data-original-title="love this post?"></i></p>
                <?php echo do_shortcode("[wp_social_sharing social_options='facebook,twitter,pinterest' twitter_username='LiveGlamCo' facebook_text='Share' twitter_text='Tweet' pinterest_text='Pin' icon_order='f,t,p' show_icons='0' before_button_text='' text_position='left']");?>
            </div>
        </div><!-- .entry-meta -->
    </header><!-- .entry-header -->

    <div class="entry-content">
        <?php the_content(); ?>
        <div id="bloglovin_follow" class="row d-none">
            <div class="col-xl-12">
                <p style="text-align: center; margin: 15px 0;"><a href="https://www.bloglovin.com/blog/18313489/" target="blank"><img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/bloglovin-button.jpg" alt="Follow us on BlogLovin"></a></p><p>
                </p></div>
        </div>

        <div id="author_block" class="row">

            <div class="col-xl-12">
                <div class="col-xl-3">
                    <?php
                    $customer_id = get_the_author_meta( 'ID' );
                    $url_avatar = lg_get_avatar_for_user($customer_id, 64);
                    ?>
                    <div class="author_pic"><img src="<?php echo $url_avatar; ?>" title="<?php the_author(); ?> | LiveGlam" alt="<?php the_author(); ?> | LiveGlam"/></div>
                </div>
                <div class="col-xl-9 author-bio">
                    <h3>About the Author</h3>
                    <h2><a href="<?php echo get_author_posts_url( get_the_author_meta( 'ID' ), get_the_author_meta( 'user_nicename' ) ); ?>"><?php the_author(); ?></a></h2>
                    <p><?php echo get_the_author_meta('description'); ?> | <a href="<?php echo get_author_posts_url( get_the_author_meta( 'ID' ), get_the_author_meta( 'user_nicename' ) ); ?>">View all the posts by <?php the_author(); ?></a></p>
                    <?php echo do_shortcode('[show_sociallink_author]');?>
                </div>
            </div>
        </div>
        <?php
        wp_link_pages( array(
            'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'liveglam_gulp' ),
            'after'  => '</div>',
        ) );
        ?>
    </div><!-- .entry-content -->

    <footer class="entry-footer">
        <?php liveglam_entry_footer(); ?>
    </footer><!-- .entry-footer -->
</article><!-- #post-## -->

