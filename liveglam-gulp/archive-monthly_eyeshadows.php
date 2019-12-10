<?php
  if(!defined('ABSPATH')){
    exit; // Exit if accessed directly
  }
  $subscriptions_status = LiveGlam_Subscription_Status::get_status();
  if(!is_user_logged_in() || !in_array($subscriptions_status['get_status_shadowme'], array('active', 'waitlist'))){
    wp_redirect(home_url('/my-account/?referer='.urlencode(home_url($_SERVER['REQUEST_URI']))));
    exit;
  }
  get_header(); ?>
<?php global $LG_userData, $LG_userAvata; ?>

<div class="wc-dashboard-content">

<div class="dashboard-content">
  <div id="scroller-anchor"></div>

  <?php $count_brushes = 0; $list_monthPost = array();
    while(have_posts()) : the_post();
      $postID = get_the_ID();
      $banner_image_mobile = get_post_meta($postID, 'banner_image_mobile', true)?wp_get_attachment_image_url(get_post_meta($postID, 'banner_image_mobile', true), 'full'):get_stylesheet_directory_uri().'/assets/img/default-mobile-banner-brushes-text2.jpg';
      $banner_image_desktop = get_post_meta($postID, 'banner_image_desktop', true)?wp_get_attachment_image_url(get_post_meta($postID, 'banner_image_desktop', true), 'full'):get_stylesheet_directory_uri().'/assets/img/default-desktop-banner-brushes-text.jpg';

      $product_items = array();
      if( !empty( $total_products = get_post_meta($postID, 'add_eyeshadow_for_the_month', true) ) ){
        for($i = 0; $i < $total_products; $i++){
          $product_items[] = array(
            'image' => wp_get_attachment_image_url(get_post_meta($postID, 'add_eyeshadow_for_the_month_'.$i.'_eyeshadow_image', true), 'full'),
            'type' => get_post_meta($postID, 'add_eyeshadow_for_the_month_'.$i.'_type', true),
            'title' => get_post_meta($postID, 'add_eyeshadow_for_the_month_'.$i.'_eyeshadow_title', true),
            'desc' => get_post_meta($postID, 'add_eyeshadow_for_the_month_'.$i.'_eyeshadow_description', true),
            'retail' => get_post_meta($postID, 'add_eyeshadow_for_the_month_'.$i.'_retail', true)
          );
        }
      }

      $list_monthPost[$count_brushes] = array(
        'postID' => $postID,
        'title' => get_the_title(),
        'date' => get_the_date( 'M j, Y' ),
        'name_collection' => get_post_meta($postID, 'name_of_the_collection', true),
        'product_items' => $product_items,
        'image_desktop' => $banner_image_desktop,
        'image_mobile' => $banner_image_mobile,
        'video_url' => get_post_meta($postID, 'video_url', true),
        'video_image' => wp_get_attachment_image_url(get_post_meta($postID, 'video_block_image', true), 'full'),
        'video_description' => get_post_meta($postID, 'video_description', true),
        'video_title' => get_post_meta($postID, 'video_title', true)
      );
      $count_brushes++;
    endwhile;
    rewind_posts(); ?>

  <div class="list-content">

    <?php foreach( $list_monthPost as $key => $monthPost ){ ?>

      <div class="item-content monthPost_<?php echo $key; ?>">
        <img class="img-banner hide-mobile" src="<?php echo $monthPost['image_desktop']; ?>" alt="<?php echo $monthPost['title']; ?>"/>
        <img class="img-banner show-mobile" src="<?php echo $monthPost['image_mobile']; ?>" alt="<?php echo $monthPost['title']; ?>"/>
      </div>

    <?php } ?>

    <div class="item-content-center hide-mobile">
      <div class="wrap">
        <div class="item-content-list">
          <div class="item-content-details">
            <?php foreach( $list_monthPost as $key => $monthPost ){ ?>
              <div class="item-content monthPost_<?php echo $key; ?>">
                <p class="item-content-title"><?php echo $monthPost['name_collection']; ?></p>
              </div>
            <?php } ?>
          </div>
          <div class="item-content-details">
            <label class="d-none" for="dashboard-select-month">&nbsp;</label>
            <select name="dashboard-select-month" id="dashboard-select-month" class="selectpicker dashboard-select-month right-border">
              <?php $selected = false; foreach($list_monthPost as $key => $monthPost ){ ?>
                <option value="<?php echo 'monthPost_'.$key; ?>" data-id="<?php echo $key; ?>" <?php if($selected == false){ $selected = true; echo 'selected="selected"'; } ?>><?php echo $monthPost['title']; ?></option>
              <?php } ?>
            </select>
          </div>
        </div>
      </div>
    </div>

    <?php foreach( $list_monthPost as $key => $monthPost ){ ?>

      <div class="item-content monthPost_<?php echo $key; ?>">
        <div class="wrap">
          <div class="item-content-bg">
            <?php if(!empty($monthPost['product_items'])): ?>
              <div class="tools" id="br_tools_<?php echo $key; ?>">
                <?php if(!empty($monthPost['name_collection'])){ ?>
                  <p class="collection-name show-mobile"><?php echo $monthPost['name_collection']; ?></p>
                <?php } ?>
                <ul>
                  <?php foreach($monthPost['product_items'] as $item){ ?>
                    <li class="shadowme">
                      <div class="inner hide-mobile">
                        <img src="<?php echo $item['image']; ?>" class="image-product-monthly" alt="<?php echo $item['title']; ?>">
                        <div class="comment">
                          <p class="type"><?php echo $item['type']; echo (!empty($item['retail']))?' | RETAIL: '.$item['retail']:''; ?></p>
                          <p class="name"><?php echo $item['title']; ?></p>
                          <p class="desc"><?php echo $item['desc']; ?></p>
                        </div>
                      </div>
                      <div class="inner new-inner show-mobile">
                        <div class="inner-center">
                          <img src="<?php echo $item['image']; ?>" class="new-image-product-monthly" alt="<?php echo $item['title']; ?>">
                          <p class="inner-title"><?php echo $item['title']; ?></p>
                        </div>
                        <div class="inner-bottom">
                          <p class="inner-desc"><?php echo $item['desc']; ?></p>
                        </div>
                      </div>
                    </li>
                  <?php } ?>
                </ul>
              </div>
            <?php endif; ?>
            <div class="on-theblog hide-mobile">
              <p class="theblog-title">On the Blog</p>
            </div>
            <div class="tutor" id="br_tutor_<?php echo $key; ?>">
              <?php if(!empty($monthPost['video_url']) && !empty($monthPost['video_image']) && !empty($monthPost['video_description']) && !empty($monthPost['video_title'])){ ?>
                <div class="section-video">
                  <div class="watch">
                    <img src="<?php echo $monthPost['video_image']; ?>" alt="<?php echo $monthPost['title']; ?>" />
                    <a class="btn-play" href="<?php echo $monthPost['video_url']; ?>"><img alt="Play" src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/icon-play-2019.svg"></a>
                  </div>
                  <div class="description">
                    <p class="tutor-video-brand"><?php echo $monthPost['date']; ?></p>
                    <p class="tutor-video-title"><?php echo $monthPost['video_title']; ?></p>
                    <p class="tutor-video-desc"><?php echo $monthPost['video_description']; ?></p>
                    <a href="<?php echo $monthPost['video_url']; ?>" class="view-more-btn">
                      <button class="btn btn-primary">Watch the Tutorial</button>
                    </a>
                  </div>
                </div>
              <?php } ?>
              <?php echo do_shortcode("[show_section_blogs post_id=".$monthPost['postID']." product=shadowme]"); ?>
            </div>
          </div>
        </div>
      </div>
    <?php } ?>

  </div>

  <?php show_dashboard_footer('footer-dashboard'); ?>
</div>


<?php get_footer(); ?>

</div>