<?php
if(!defined('ABSPATH')){
  exit; // Exit if accessed directly
}
/**
 * The template for displaying single faqs posts.
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
        <div class="blog_main_content">
          <div class="content">
            <?php the_content(); ?>

            <div id="bloglovin_follow" class="row d-none">
              <div class="col-lg-12">
                <p style="text-align: center; margin: 15px 0;">
                  <a href="https://www.bloglovin.com/blog/18313489/" target="blank"><img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/bloglovin-button.jpg" alt="Follow us on BlogLovin"></a>
                </p>
              </div>
            </div>

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

              <div class="back-to-faq">
                  <a href="<?php echo home_url('/faq'); ?>">
                      <button class="btn newdesign-btn-secondary">Back to FAQ</button>
                  </a>
              </div>

          </div>

          <?php
          // If comments are open or we have at least one comment, load up the comment template.
          if(comments_open() || get_comments_number()) :
            comments_template();
          endif;
          ?>

        </div>
      </div>
    </div>
  </section>


<?php endwhile; // End of the loop. ?>

<div class="benefits-page benefits-join-now m-fixed-height">
  <div>
    <img class="d-mobile subscribe-bg-m-top" src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/subscribe-top.png">
    <div class="section-title nd19-block-title">Subscribe for more exclusive beauty products!</div>
    <p class="nd19-section-subtitle">Join our <strong>#LiveGlamFam</strong> and get new beauty products delivered straight to your door monthly.</p>
    <div class="section-cta d-desktop"><a href="<?php echo home_url(PAGE_PRE_CHECKOUT); ?>" class="btn-primary">Subscribe</a></div>
    <div class="section-cta d-mobile"><a href="<?php echo home_url(PAGE_PRE_CHECKOUT); ?>" class="btn-secondary">join now</a></div>
    <img class="d-mobile subscribe-bg-m-bottom" src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/subscribe-bottom.png">
  </div>
</div>

<?php get_footer(); ?>

<?php function get_post_by_query($query, $widget = false){
  $allposts = array();
  if($query->have_posts()) :
    while($query->have_posts()) : $query->the_post();
      $author_id = get_the_author_meta('ID');
      $readTime = !empty($readTime = get_post_meta(get_the_ID(), 'read_time', true))?' - '.$readTime:'';
      if( $widget ){
        $post_thumbnail = get_the_post_thumbnail(null, 'medium');
        if(empty($post_thumbnail))
          $post_thumbnail = '<img src="'.get_stylesheet_directory_uri().'/assets/img/image-broken-small.jpg"/>';
      } else{
        $attr = array(
          'class' => 'img-post image-blog',
          'alt' =>  get_the_title()
        );
        $post_thumbnail = get_the_post_thumbnail(null, 'post-thumbnail',$attr);
        if(empty($post_thumbnail))
          $post_thumbnail = '<img src="'.get_stylesheet_directory_uri().'/assets/img/image-broken-small.jpg"/>';
      }
      $allposts[] = array('post_id' => get_the_ID(), 'post_title' => get_the_title(), 'post_date' => get_the_date('M d, Y'), 'post_thumbnail' => $post_thumbnail, 'post_excerpt' => get_the_excerpt(), 'posted_in' => get_the_category_list(', '), 'post_author' => get_the_author(), 'post_author-avatar' => lg_get_avatar_for_user($author_id, 64), 'post_author-link' => get_author_posts_url(get_the_author_meta('ID'), get_the_author_meta('user_nicename')), 'post_permalink' => get_the_permalink(), 'read_time' => $readTime);

    endwhile;

  endif;
  //wp_reset_postdata();
  return $allposts;
} ?>
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