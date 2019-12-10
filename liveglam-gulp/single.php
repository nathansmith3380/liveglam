<?php
if(!defined('ABSPATH')){
  exit; // Exit if accessed directly
}
/**
 * The template for displaying all single posts.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package Liveglam_gulp
 */
$img_broken = get_stylesheet_directory_uri().'/assets/img/image-broken-small.jpg';
get_header(); ?>
<?php lgs_set_post_views(); ?>
<?php //echo do_shortcode('[lgs_holiday_countdown_homepage]'); ?>
<?php while(have_posts()) : the_post(); ?>

  <?php $readTime = !empty($readTime = get_post_meta(get_the_ID(), 'read_time', true))?' - '.$readTime:'';
  $post_date = get_the_date( 'M j, Y' );
  ?>

    <section class="blog_header auto-height nd19-section-title">
        <div class="container">
            <p class="type nd19-block-content"><?php echo get_the_category_list(',&nbsp;&nbsp;&nbsp;&nbsp;'); ?></p>
            <div class="title-container">
                <?php the_title('<h1 class="nd19-section-title">', '</h1>'); ?>
            </div>
            <p class="date nd19-block-content">Posted by <span class="author_name"><?php echo get_the_author(); ?></span> on <?php echo $post_date; ?></p>
        </div>
    </section>

    <section class="blog_content auto-height">
        <div class="container">
          <?php if(has_post_thumbnail()):
            $attr = array(
              'class' => 'blog_hero'
            );
            if( !empty( $_thumbnail_id = get_post_meta( get_the_ID(), '_thumbnail_id', true ) ) ){
              if( empty( get_post_meta( $_thumbnail_id, '_wp_attachment_image_alt',true ) ) ){
                $attr['alt'] = get_the_title();
              }
            } else {
              $attr['alt'] = get_the_title();
            }
            echo get_the_post_thumbnail(null, 'post-thumbnail',$attr);
          endif; ?>
            <div class="row">
                <div class="col-md-8 blog_main_content">
                    <div class="content">
                      <?php the_content(); ?>

                        <div id="bloglovin_follow" class="row d-none">
                            <div class="col-xl-12">
                                <p style="text-align: center; margin: 15px 0;">
                                    <a href="https://www.bloglovin.com/blog/18313489/" target="blank"><img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/bloglovin-button.jpg" alt="Follow us on BlogLovin"></a>
                                </p>
                            </div>
                        </div>

                        <!--<div class="join-card d-none">
                          <img src="assets/img/join-card.png">
                          <div class="inner">
                            <p class="title">Join Brush Club Today</p>
                            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vivamus convallis tempus augue vel blandit.</p>
                            <a href="">Start Getting Brushes</a>
                          </div>
                        </div>-->

                        <div class="share-article nd19-block-content">
                            <div class="share-header">
                                <p class="share">Share</p>
                                <span class="share-dash"></span>
                            </div>
                          <?php $url = urlencode(get_permalink());
                          remove_filter('the_title', 'wptexturize');
                          $title = urlencode(html_entity_decode(get_the_title()));
                          add_filter('the_title', 'wptexturize');
                          $thumb = wp_get_attachment_image_src(get_post_thumbnail_id(get_the_ID()), 'medium');
                          $thumb_url = $thumb['0'];
                          if($thumb_url == ''){
                            $thumb_url = SS_PLUGIN_URL.'static/blank.jpg';
                          }
                          $thumb_url = urlencode($thumb_url);
                          $twitter_username = 'LiveGlamCo'; ?>
                            <ul>
                                <li>
                                    <a href="http://www.facebook.com/sharer/sharer.php?u=<?php echo $url; ?>"><i class="fab fa-facebook-f" aria-hidden="true"></i></a>
                                </li>
                                <li>
                                    <a href="http://twitter.com/intent/tweet/?text=<?php echo $title; ?>&url=<?php echo $url; ?><?php if(!empty($twitter_username)){
                                      echo '&via='.$twitter_username;
                                    } ?>"><i class="fab fa-twitter" aria-hidden="true"></i></a>
                                </li>
                                <li>
                                    <a href="http://pinterest.com/pin/create/button/?url=<?php echo $url; ?>&media=<?php echo $thumb_url; ?>&description=<?php echo $title; ?>"><i class="fab fa-pinterest-p" aria-hidden="true"></i></a>
                                </li>
                            </ul>
                          <?php //echo do_shortcode("[wp_social_sharing social_options='facebook,twitter,googleplus,pinterest' twitter_username='LiveGlamCo' facebook_text='Share' twitter_text='Tweet' googleplus_text='Google+' pinterest_text='Pin' icon_order='f,t,g,p' show_icons='0' before_button_text='' text_position='left']");?>
                        </div>

                        <!--post author about -->
                      <?php $customer_id = get_the_author_meta('ID');
                      $LG_userAvata = $url_avatar = lg_get_avatar_for_user($customer_id, 300);
                      ?>
                        <div class="post-user">
                            <div class="head-author-block">
                                <div class="user-comment">
                                    <img src="<?php echo $url_avatar; ?>">
                                    <div class="user-bio">
                                        <p class="name nd19-block-content"><?php the_author(); ?></p>
                                        <!--<span class="related-link"><a href="<?php /*echo get_author_posts_url(get_the_author_meta('ID'), get_the_author_meta('user_nicename')); */?>">View all the posts <span class="author_name show-desktop"> by <?php /*the_author(); */?> ></span></a></span>-->
                                    </div>
                                </div>
                            </div>
                            <div class="body-author-block">
                                <p class="user-description">
                                  <?php echo get_the_author_meta('description'); ?>
                                </p>
                            </div>
                            </div>
                        </div>
                        <!--end post author about -->

                      <?php
                      // If comments are open or we have at least one comment, load up the comment template.
                      if(comments_open() || get_comments_number()) :
                        comments_template();
                      endif;
                      ?>

                    </div>
                <div class="col-md-4">
                    <div class="editors">

                      <?php dynamic_sidebar( 'sidebar-1' ); ?>

                        <!--<div class="editors-block social-connect">
                            <p class="block-title">Let's Connect <span>Get the Latest Beauty Scoops</span>
                            <ul class="social-links">
                                <li>
                                    <a href="https://www.instagram.com/liveglam.co" target="_blank" rel="noopener"><i class="fab fa-instagram" aria-hidden="true"></i></a>
                                </li>
                                <li>
                                    <a href="https://www.facebook.com/LiveGlam-1640749179506616/" target="_blank" rel="noopener"><i class="fab fa-facebook-f" aria-hidden="true"></i></a>
                                </li>
                                <li>
                                    <a href="https://twitter.com/LiveGlamCo" target="_blank" rel="noopener"><i class="fab fa-twitter" aria-hidden="true"></i></a>
                                </li>
                                <li>
                                    <a href="https://www.snapchat.com/add/liveglamco" target="_blank" rel="noopener"><i class="fab fa-snapchat-ghost" aria-hidden="true"></i></a>
                                </li>
                                <li>
                                    <a href="https://www.pinterest.com/liveglam/" target="_blank" rel="noopener"><i class="fab fa-pinterest-p" aria-hidden="true"></i></a>
                                </li>
                            </ul>
                        </div>-->
                    </div>
                </div>
                </div>
            </div>
        </div>
    </section>

      <?php $lg_query = new WP_Query(array('post_status' => 'publish', 'posts_per_page' => 3, 'post_type' => 'post', 'orderby' => 'ID', 'order' => 'DESC', 'tax_query' => array(array('taxonomy' => 'category', 'field' => 'slug', 'terms' => 'liveglam'),),));
  $lg_posts = LGS_WIDGET_CUSTOM::lgs_get_post_by_query($lg_query);
  if(!empty($lg_posts)): ?>
        <section class="blog liveglam-posts auto-height">
          <div class="container">
            <p class="article_type nd19-section-title">You Might Also Like:</p>
            <div class="row posts">
              <?php foreach($lg_posts as $lg_post): ?>
                <div class="col-md-4 post">
                  <div class="article">
                    <div class="article_image">
                      <a href="<?php echo $lg_post['post_permalink']; ?>" title="<?php echo $lg_post['post_title']; ?>"><?php echo $lg_post['post_thumbnail']; ?></a>
                    </div>
                    <div class="content">
                      <p class="post-header"><?php echo $lg_post['posted_in']; ?></p>
                      <h3 class="post-title nd19-block-title-20"><?php echo $lg_post['post_title']; ?></h3>
                      <p class="post-comment"><?php echo substr($lg_post['post_excerpt'], 0, 140).' ...'; ?></p>
                      <div class="post-footer">
                        <p class="poster-name">
                          <span><img class="image-blog-author" src="<?php echo $lg_post['post_author-avatar']; ?>"></span><?php echo $lg_post['post_author']; ?><!--<a href="<?php /*echo $lg_post['post_author-link']; */?>"></a>-->
                        </p>
                        <p class="float-right"><?php echo $lg_post['post_date']; ?></p>
                        <a href="<?php echo $lg_post['post_permalink']; ?>" class="btn-read">Read More</a>
                      </div>
                    </div>
                  </div>
                </div>
              <?php endforeach; ?>
            </div>
          </div>
        </section>
      <?php endif; ?>

<?php endwhile; // End of the loop. ?>

<div class="benefits-page benefits-join-now m-fixed-height">
  <img class="subscribe-left-img hide-mobile" src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/subscribe-lippies.png" alt="" />
  <div class="subscribe-content">
    <div class="section-title nd19-block-title">Subscribe for more exclusive beauty products!</div>
    <p class="nd19-section-subtitle">Join our <strong>#LiveGlamFam</strong> and get new beauty products delivered straight to your door monthly.</p>
    <div class="section-cta d-desktop"><a href="<?php echo home_url(PAGE_PRE_CHECKOUT); ?>" class="btn-primary">Subscribe</a></div>
    <div class="section-cta d-mobile"><a href="<?php echo home_url(PAGE_PRE_CHECKOUT); ?>" class="btn-secondary">join now</a></div>
  </div>
  <img class="subscribe-right-img hide-mobile" src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/subscribe-brushes.png" alt="" />
</div>

<?php get_footer(); ?>

<style>

</style>

<script type="text/javascript">
    jQuery(document).ready(function () {
        //issue #932 disable load instagram post
        //load_instagram();
        function load_instagram() {
            var data = {
                'action': 'load_instaglam_blog_single',
                'media': 6,
                'lm_num': 6
            };
            jQuery.post(ajaxurl, data, function (response) {
                jQuery('ul.instagram-users').html(response);
                jQuery('a.fancybox-inline, area.fancybox-inline, li.fancybox-inline a').fancybox(jQuery.extend({}, fb_opts, {
                    'type': 'inline',
                    'autoDimensions': true,
                    'scrolling': 'no',
                    'transitionIn': 'none',
                    'easingIn': 'linear',
                    'transitionOut': 'none',
                    'easingOut': 'linear',
                    'opacity': false,
                    'hideOnContentClick': false
                }));
            });
        }
    });
</script>