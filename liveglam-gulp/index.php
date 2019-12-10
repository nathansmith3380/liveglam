<?php
/**
 * The main template file.
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Liveglam Gulp
 */
if(!defined('ABSPATH')){
  exit; // Exit if accessed directly
}
if(is_author()){
  wp_redirect(home_url('/blog')); exit;
}
get_header(); ?>

<?php $categories = get_categories(); ?>

<?php
global $wp_query;
if($wp_query->have_posts()) : ?>

  <?php $allposts = get_post_by_query($wp_query); ?>

<?php endif; ?>

<?php if(is_home() && !is_front_page()) : ?>
    <!--blog page index-->
  <?php $last_blog = array_shift($allposts); ?>
  <?php //echo do_shortcode('[lgs_holiday_countdown_homepage]'); ?>
    <section class="best_article auto-height">
        <div class="container">
            <div class="blog-page-title-container">
                <div class="blog-page-title">
                    <span class="title-main show-desktop nd19-section-title">Get your latest dose of glam</span>
                    <span class="title-main show-mobile nd19-section-title">Get your latest<br />dose of glam</span>
                    <span class="title-sub show-desktop nd19-block-content">From our liveglam beauty squad!</span>
                    <span class="title-sub show-mobile nd19-block-content">From our liveglam<br/>beauty squad!</span>
                </div>
            </div>
            <div class="article">
                <a href="<?php echo $last_blog['post_permalink']; ?>" title="<?php echo $last_blog['post_title']; ?>" class="article_image">
                    <img class="image-blog image-blog-small" src="<?php echo $last_blog['post_thumbnail']; ?>" alt="<?php echo $last_blog['post_title']; ?>">
                </a>
                <div class="article_content">
                    <?php
                      $last_blog_title = (strlen($last_blog['post_title']) > 53) ? substr($last_blog['post_title'],0,50).'...' : $last_blog['post_title'];
                      $last_blog_summary = (strlen($last_blog['post_excerpt']) > 268) ? substr($last_blog['post_excerpt'],0,265).'...' : $last_blog['post_excerpt'];
                    ?>
                    <div class="header">
                        <p><?php echo $last_blog['posted_in']; ?></p>
                        <h3><?php echo $last_blog_title; ?></h3>
                        <p class="post-summary"><?php echo $last_blog_summary; ?></p>
                    </div>
                    <div class="footer">
                        <div class="poster">
                            <p class="poster-name">
                                <span><img class="image-blog-author" src="<?php echo $last_blog['post_author-avatar']; ?>" alt="<?php echo $last_blog['post_author']; ?> avatar"></span><?php echo $last_blog['post_author']; ?><!--<a href="<?php /*echo $last_blog['post_author-link']; */?>"></a>-->
                            </p>
                            <p class="float-right"><?php echo $last_blog['post_date']; ?></p>
                        </div>
                        <a href="<?php echo $last_blog['post_permalink']; ?>" class="btn btn-secondary btn-block btn-solid btn-sm mt-md-0 mt-3">Read More</a>
                    </div>
                </div>
            </div>
        </div>
    </section>

  <?php
  $popular_query = new WP_Query(array('post_status' => 'publish', 'posts_per_page' => 5, 'meta_key' => 'lgs_post_views_count', 'orderby' => 'meta_value_num', 'order' => 'DESC', 'post__not_in' => array($last_blog['post_id'])));
  $popularposts = get_post_by_query($popular_query);
  $count_popularpost = 0;
  $hide_popularposts = false;
  if(!empty($popularposts) && $hide_popularposts): ?>
      <section class="blog popular_article auto-height">
          <div class="container">
              <p class="article_type nd19-section-title">Popular Posts</p>
              <div class="row posts">
                <?php foreach($popularposts as $popularpost): $count_popularpost++;
                  $popularpost_title = (strlen($popularpost['post_title']) > 53) ? substr($popularpost['post_title'],0,50).'...' : $popularpost['post_title'];
                  $popularpost_comment = (strlen($popularpost['post_excerpt']) > 143) ? substr($popularpost['post_excerpt'],0,140).'...' : $popularpost['post_excerpt'];

                  if($count_popularpost != 4) : ?>
                      <div class="col-md-4 post">
                          <div class="article">
                              <div class="article_image">
                                  <a href="<?php echo $popularpost['post_permalink']; ?>" title="<?php echo $popularpost['post_title']; ?>"><img src="<?php echo $popularpost['post_thumbnail']; ?>" class="img-post image-blog image-blog-small" alt="<?php echo $popularpost['post_title']; ?>"></a>
                              </div>
                              <div class="content">
                                  <p class="post-header nd19-block-content"><?php echo $popularpost['posted_in']; ?></p>
                                  <h3 class="post-title nd19-block-title-s"><?php echo $popularpost_title; ?></h3>
                                  <p class="post-comment nd19-block-content"><?php echo $popularpost_comment; ?></p>
                                  <div class="post-footer">
                                      <div class="poster">
                                          <p class="poster-name nd19-block-content-s">
                                              <span><img class="image-blog-author" src="<?php echo $popularpost['post_author-avatar']; ?>" alt="><?php echo $popularpost['post_author']; ?> avatar"></span><?php echo $popularpost['post_author']; ?><!--<a href="<?php /*echo $popularpost['post_author-link']; */?>"></a>-->
                                          </p>
                                          <p class="float-right nd19-block-content-s"><?php echo $popularpost['post_date']; ?></p>
                                      </div>
                                      <a href="<?php echo $popularpost['post_permalink']; ?>" class="btn btn-secondary btn-block btn-solid btn-sm mt-md-0 mt-3">Read More</a>
                                  </div>
                              </div>
                          </div>
                      </div>
                  <?php else: ?>
                      <div class="col-md-8 post">
                          <div class="md-article">
                              <div class="article_image">
                                  <a href="<?php echo $popularpost['post_permalink']; ?>" alt="<?php echo $popularpost['post_title']; ?>"><img src="<?php echo $popularpost['post_thumbnail']; ?>" class="image-blog image-blog-large" alt="<?php echo $popularpost['post_title']; ?>"></a>
                              </div>
                              <div class="article_content">
                                  <div class="header">
                                      <p class="txt-grey"><?php echo $popularpost['posted_in']; ?></p>
                                      <h3><?php echo $popularpost_title; ?></h3>
                                      <p><?php echo $popularpost_comment; ?></p>
                                  </div>
                                  <div class="footer">
                                      <div class="poster">
                                          <p class="poster-name">
                                              <span><img class="image-blog-author" src="<?php echo $popularpost['post_author-avatar']; ?>" alt="<?php echo $popularpost['post_author']; ?> avatar"></span><?php echo $popularpost['post_author']; ?><!--<a href="<?php /*echo $popularpost['post_author-link']; */?>"></a>-->
                                          </p>
                                          <p class="float-right"><?php echo $popularpost['post_date']; ?></p>
                                      </div>
                                      <a href="<?php echo $popularpost['post_permalink']; ?>" class="btn btn-secondary btn-block btn-solid btn-sm mt-md-0 mt-3">Read More</a>
                                  </div>
                              </div>
                          </div>
                      </div>
                  <?php endif; ?>
                <?php endforeach; ?>
              </div>
          </div>
      </section>
  <?php endif; ?>

  <?php if(!empty($allposts)): ?>
        <section class="blog recent_posts auto-height" id="recent_posts">
            <div class="container">
                <p class="article_type nd19-section-title">Most recent posts</p>
                <div class="row posts">
                  <?php foreach($allposts as $allpost):
                    $allpost_title = (strlen($allpost['post_title']) > 53) ? substr($allpost['post_title'],0,50).'...' : $allpost['post_title'];
                    $allpost_comment = (strlen($allpost['post_excerpt']) > 143) ? substr($allpost['post_excerpt'],0,140).'...' : $allpost['post_excerpt'];
                  ?>
                      <div class="col-md-4 post">
                          <div class="article">
                              <div class="article_image">
                                  <a href="<?php echo $allpost['post_permalink']; ?>" title="<?php echo $allpost['post_title']; ?>"><img src="<?php echo $allpost['post_thumbnail']; ?>" class="img-post image-blog image-blog-small" alt="<?php echo $allpost['post_title']; ?>"></a>
                              </div>
                              <div class="content">
                                  <p class="post-header nd19-block-content"><?php echo $allpost['posted_in']; ?></p>
                                  <h3 class="post-title nd19-block-title-20"><?php echo $allpost_title; ?></h3>
                                  <p class="post-comment nd19-block-content"><?php echo $allpost_comment; ?></p>
                                  <div class="post-footer">
                                      <div class="poster">
                                          <p class="poster-name nd19-block-content-s">
                                              <span><img class="image-blog-author" src="<?php echo $allpost['post_author-avatar']; ?>" alt="<?php echo $allpost['post_author']; ?> avatar"></span><?php echo $allpost['post_author']; ?><!--<a href="<?php /*echo $allpost['post_author-link']; */?>"></a>-->
                                          </p>
                                          <p class="float-right nd19-block-content-s"><?php echo $allpost['post_date']; ?></p>
                                      </div>
                                      <a href="<?php echo $allpost['post_permalink']; ?>" class="btn btn-secondary btn-block btn-solid btn-sm mt-md-0 mt-3">Read More</a>
                                  </div>
                              </div>
                          </div>
                      </div>
                  <?php endforeach; ?>
                </div>
                <input type="hidden" class="num-post-per-page" value="9"/>
                <div class="pg-nav newdesign-pagination">
                    <nav class="text-center" aria-label="Page navigation">
                        <ul class="pagination" id="pagination"></ul>
                    </nav>
                </div>
            </div>
        </section>
  <?php endif; ?>

    <section class="post_categories auto-height">
        <div class="container">
            <p class="article_type nd19-section-title">Categories</p>
            <label class="d-none" for="blog-select-category">Select Category</label>
            <select id="blog-select-category" class="form-control filter-select selectpicker show-mobile" onChange="location = this.value;">
              <option value="" selected disabled>Select</option>
              <?php foreach($categories as $category): ?>
                  <option value="<?php echo home_url('/category/').$category->slug; ?>">
                    <?php echo $category->name; ?>
                  </option>
              <?php endforeach; ?>
            </select>
            <div class="categories show-desktop nd19-block-content-s">
              <?php
              foreach($categories as $category):
                $cat_color = get_term_meta($category->term_id, 'category_color', true);
                $color_style = '';
                if($cat_color)
                  $color_style = 'style="background-color: '.$cat_color.'"';
                ?>
                  <div class="category" id="cat_<?php echo $category->slug; ?>" <?php echo $color_style; ?>>
                      <a href="<?php echo home_url('/category/').$category->slug; ?>">
                        <?php echo $category->name; ?>
                      </a>
                  </div>
              <?php endforeach; ?>
            </div>
        </div>
    </section>

  <?php
  $lg_query = new WP_Query(array('post_status' => 'publish', 'posts_per_page' => 3, 'post_type' => 'post', 'orderby' => 'ID', 'order' => 'DESC', 'tax_query' => array(array('taxonomy' => 'category', 'field' => 'slug', 'terms' => 'liveglam-clubs'),),));
  $lg_posts = get_post_by_query($lg_query);
  if(!empty($lg_posts)): ?>
      <section class="blog liveglam-posts auto-height">
          <div class="container">
              <p class="article_type nd19-section-title">LiveGlam Club Posts</p>
              <div class="row posts">
                <?php foreach($lg_posts as $lg_post):
                  $lg_post_title = (strlen($lg_post['post_title']) > 53) ? substr($lg_post['post_title'],0,50).'...' : $lg_post['post_title'];
                  $lg_post_comment = (strlen($lg_post['post_excerpt']) > 143) ? substr($lg_post['post_excerpt'],0,140).'...' : $lg_post['post_excerpt'];
                ?>
                    <div class="col-md-4 post">
                        <div class="article">
                            <div class="article_image">
                                <a href="<?php echo $lg_post['post_permalink']; ?>" title="<?php echo $lg_post['post_title']; ?>"><img src="<?php echo $lg_post['post_thumbnail']; ?>" class="img-post image-blog image-blog-small" alt="<?php echo $lg_post['post_title']; ?>"></a>
                            </div>
                            <div class="content">
                                <p class="post-header nd19-block-content"><?php echo $lg_post['posted_in']; ?></p>
                                <h3 class="post-title nd19-block-title-s"><?php echo $lg_post_title; ?></h3>
                                <p class="post-comment nd19-block-content"><?php echo $lg_post_comment; ?></p>
                                <div class="post-footer">
                                    <div class="poster">
                                        <p class="poster-name nd19-block-content-s">
                                            <span><img class="image-blog-author" src="<?php echo $lg_post['post_author-avatar']; ?>" alt="<?php echo $lg_post['post_author']; ?> avatar"></span><?php echo $lg_post['post_author']; ?><!--<a href="<?php /*echo $lg_post['post_author-link']; */?>"></a>-->
                                        </p>
                                        <p class="float-right nd19-block-content-s"><?php echo $lg_post['post_date']; ?></p>
                                    </div>
                                    <a href="<?php echo $lg_post['post_permalink']; ?>" class="btn btn-secondary btn-block btn-solid btn-sm mt-md-0 mt-3">Read More</a>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
              </div>
          </div>
      </section>
  <?php endif; ?>

  <?php
  $popular_query = new WP_Query(array('post_status' => 'publish', 'posts_per_page' => 6, 'post_type' => 'post', 'orderby' => 'ID', 'order' => 'DESC', 'tax_query' => array(array('taxonomy' => 'category', 'field' => 'slug', 'terms' => 'liveglam'),),));
  $popularposts = get_post_by_query($popular_query);
  if(!empty($popularposts)): ?>
      <section class="blog popular_article auto-height">
          <div class="container">
              <p class="article_type nd19-section-title">LiveGlam posts</p>
              <div class="row posts">
                <?php foreach($popularposts as $popularpost):
                  $popularpost_title = (strlen($popularpost['post_title']) > 53) ? substr($popularpost['post_title'],0,50).'...' : $popularpost['post_title'];
                  $popularpost_comment = (strlen($popularpost['post_excerpt']) > 143) ? substr($popularpost['post_excerpt'],0,140).'...' : $popularpost['post_excerpt'];
                ?>
                    <div class="col-md-4 post">
                        <div class="article">
                            <div class="article_image">
                                <a href="<?php echo $popularpost['post_permalink']; ?>" title="<?php echo $popularpost['post_title']; ?>"><img src="<?php echo $popularpost['post_thumbnail']; ?>" class="img-post image-blog image-blog-small" alt="<?php echo $popularpost['post_title']; ?>"></a>
                            </div>
                            <div class="content">
                                <p class="post-header nd19-block-content"><?php echo $popularpost['posted_in']; ?></p>
                                <h3 class="post-title nd19-block-title-20"><?php echo $popularpost_title; ?></h3>
                                <p class="post-comment nd19-block-content"><?php echo $popularpost_comment; ?></p>
                                <div class="post-footer">
                                    <div class="poster">
                                        <p class="poster-name nd19-block-content-s">
                                            <span><img class="image-blog-author" src="<?php echo $popularpost['post_author-avatar']; ?>" alt="<?php echo $popularpost['post_author']; ?> avatar"></span><?php echo $popularpost['post_author']; ?><!--<a href="<?php /*echo $popularpost['post_author-link']; */?>"></a>-->
                                        </p>
                                        <p class="float-right nd19-block-content-s"><?php echo $popularpost['post_date']; ?></p>
                                    </div>
                                    <a href="<?php echo $popularpost['post_permalink']; ?>" class="btn btn-secondary btn-block btn-solid btn-sm mt-md-0 mt-3">Read More</a>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
              </div>
          </div>
      </section>
  <?php endif; ?>
    <!--end blog page index-->
<?php else: ?>
    <!--blog caregory page-->

  <?php if(!empty($allposts)): ?>
        <section class="blog tutorials auto-height" id="recent_posts">
            <div class="container">
              <div class="blog-page-title-container">
                <div class="blog-page-title">
                    <?php if(is_category()): ?>
                        <span class="title-main nd19-section-title"><?php echo $wp_query->queried_object->name; ?></span>
                        <span class="title-sub nd19-block-content">Learn Something new everyday.</span>
                    <?php elseif(is_author()): ?>
                        <span class="title-main nd19-section-title"><?php echo $wp_query->queried_object->data->display_name; ?></span>
                        <span class="title-sub nd19-block-content"><?php echo $wp_query->queried_object->data->user_email; ?></span>
                    <?php endif; ?>
                </div>
              </div>

                <div class="row posts">

                  <?php foreach($allposts as $allpost):
                    $allpost_title = (strlen($allpost['post_title']) > 53) ? substr($allpost['post_title'],0,50).'...' : $allpost['post_title'];
                    $allpost_comment = (strlen($allpost['post_excerpt']) > 143) ? substr($allpost['post_excerpt'],0,140).'...' : $allpost['post_excerpt'];
                  ?>
                      <div class="col-md-4 post">
                          <div class="article">
                              <div class="article_image">
                                  <a href="<?php echo $allpost['post_permalink']; ?>" title="<?php echo $allpost['post_title']; ?>"><img src="<?php echo $allpost['post_thumbnail']; ?>" class="img-post image-blog image-blog-small" alt="<?php echo $allpost['post_title']; ?>"></a>
                              </div>
                              <div class="content">
                                  <p class="post-header nd19-block-content"><?php echo $allpost['posted_in']; ?></p>
                                  <h3 class="post-title nd19-block-title-s"><?php echo $allpost_title; ?></h3>
                                  <p class="post-comment nd19-block-content"><?php echo $allpost_comment; ?></p>
                                  <div class="post-footer">
                                      <div class="poster">
                                          <p class="poster-name nd19-block-content-s">
                                              <span><img class="image-blog-author" src="<?php echo $allpost['post_author-avatar']; ?>" alt="<?php echo $allpost['post_author']; ?> avatar"></span><?php echo $allpost['post_author']; ?><!--<a href="<?php /*echo $allpost['post_author-link']; */?>"></a>-->
                                          </p>
                                          <p class="float-right nd19-block-content-s"><?php echo $allpost['post_date']; ?></p>
                                      </div>
                                      <a href="<?php echo $allpost['post_permalink']; ?>" class="btn btn-secondary btn-block btn-solid btn-sm mt-md-0 mt-3">Read More</a>
                                  </div>
                              </div>
                          </div>
                      </div>
                  <?php endforeach; ?>
                </div>
                <input type="hidden" class="num-post-per-page" value="15"/>
                <div class="pg-nav newdesign-pagination">
                    <nav class="text-center" aria-label="Page navigation">
                        <ul class="pagination" id="pagination"></ul>
                    </nav>
                </div>
            </div>
        </section>
  <?php endif; ?>

    <section class="post_categories auto-height">
        <div class="container">
            <p class="article_type nd19-section-title">Categories</p>
            <label class="d-none" for="blog-select-category">Select Category</label>
            <select id="blog-select-category" class="form-control filter-select selectpicker show-mobile" onChange="location = this.value;">
                <option value="" selected disabled>Select</option>
              <?php foreach($categories as $category): ?>
                  <option value="<?php echo home_url('/category/').$category->slug; ?>">
                    <?php echo $category->name; ?>
                  </option>
              <?php endforeach; ?>
            </select>
            <div class="categories show-desktop">
              <?php
              foreach($categories as $category):
                $cat_color = get_term_meta($category->term_id, 'category_color', true);
                $color_style = '';
                if($cat_color)
                  $color_style = 'style="background-color: '.$cat_color.'"';
                ?>
                  <div class="category" id="cat_<?php echo $category->slug; ?>" <?php echo $color_style; ?>>
                      <a href="<?php echo home_url('/category/').$category->slug; ?>">
                        <?php echo $category->name; ?>
                      </a>
                  </div>
              <?php endforeach; ?>
            </div>
        </div>
    </section>


    <!--end blog caregory page-->
<?php endif; ?>

<?php get_footer(); ?>

<script type="text/javascript">
    jQuery(document).ready(function () {
        jQuery('.selectpicker').selectpicker({dropupAuto: false});

        var element_selected = '#recent_posts .posts .post',
            numPerPage = jQuery('input.num-post-per-page').val(),
            totalItem = jQuery(element_selected).length,
            numPages = Math.ceil(totalItem / numPerPage);
        set_pagination(numPages);
        go_to_page(element_selected, 1);

        function set_pagination(numPages) {
            var obj = jQuery('#pagination').pagination({
                items: numPages,
                itemOnPage: numPerPage,
                currentPage: 1,
                cssStyle: '',
                prevText: '<i class="fas fa-chevron-left" aria-hidden="true"></i>',
                nextText: '<i class="fas fa-chevron-right" aria-hidden="true"></i>',
                onInit: function () {
                },
                onPageClick: function (page, evt) {
                    go_to_page(element_selected, page, numPerPage);
                    var target = jQuery('#recent_posts');
                    var heigh_top = jQuery('.fixed-top').height();
                    if (target.length) {
                        jQuery('html, body').animate({
                            scrollTop: target.offset().top - heigh_top
                        }, 1000);
                    }
                }
            });
        }

        function go_to_page(e, currentPage) {
            jQuery(e).hide().slice((currentPage - 1) * numPerPage, currentPage * numPerPage).show();
        }
    });
</script>

<?php function get_post_by_query($query){
  $allposts = array();
  if(have_posts()) :
    while($query->have_posts()) : $query->the_post();
      $author_id = get_the_author_meta('ID');
      $allposts[] = array('post_id' => get_the_ID(), 'post_title' => get_the_title(), 'post_date' => get_the_date('M d, Y'), 'post_thumbnail' => get_the_post_thumbnail_url(null, 'shop_catalog'), 'post_excerpt' => get_the_excerpt(), 'posted_in' => get_the_category_list(', '), 'post_author' => get_the_author(), 'post_author-avatar' => lg_get_avatar_for_user($author_id, 64), 'post_author-link' => get_author_posts_url(get_the_author_meta('ID'), get_the_author_meta('user_nicename')), 'post_permalink' => get_the_permalink(),);

    endwhile;

  endif;
  return $allposts;
} ?>
