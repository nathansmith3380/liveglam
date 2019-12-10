<?php
  /**
   * Template Name: Lipstick Club page
   *
   * @package Liveglam
   */

  get_header();
?>
<div class="page-lipstick-club abc123">
  <!-- new slider -->
  <?php $hero_slider = array();
    if(!empty($total_hero_slider = get_post_meta(9999995205, 'hero_slider', true))):
      $current_date = date('Y-m-d H:i:s',current_time('timestamp'));
      $currentdate = date('d',current_time('timestamp'));
      $current_month = $currentdate > 22 ? date('F',strtotime('+1 month')):date('F',current_time('timestamp'));
      $current_month .= ' LIPPIES';
      for($i = 0; $i < $total_hero_slider; $i++):
        $startdate = get_post_meta(9999995205, 'hero_slider_'.$i.'_start_date', true);
        $enddate = get_post_meta(9999995205, 'hero_slider_'.$i.'_end_date', true);
        if( !empty($startdate) && $startdate > $current_date ) continue;
        if( !empty($enddate) && $enddate < $current_date ) continue;
        $hero_slider[] = array(
          'is_current_month' => get_post_meta(9999995205, 'hero_slider_'.$i.'_is_current_month', true),
          'lippie_month' => get_post_meta(9999995205, 'hero_slider_'.$i.'_lippie_month', true),
          'lippie_subtitle' => get_post_meta(9999995205, 'hero_slider_'.$i.'_lippie_subtitle', true),
          'lippie_image' => wp_get_attachment_image_url(get_post_meta(9999995205, 'hero_slider_'.$i.'_lippie_image', true), 'full'),
          'lippie_video' => get_post_meta(9999995205, 'hero_slider_'.$i.'_lippie_video', true),
          'lippie_video_title' => get_post_meta(9999995205, 'hero_slider_'.$i.'_lippie_video_title', true),
          );
      endfor;
    endif; ?>
  <section class="intro <?php echo !empty($hero_slider)?'slider':''; ?>">
    <div class="vertical-center">
      <div class="container">
        <div class="row">
          <div class="col-md-6 no-padding">
            <?php if(empty($hero_slider)){ ?>
              <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/hero-transparent-kissme.png" class="show-mobile img-intro">
            <?php }else{ ?>
              <!--KM slider starts-->
              <div class="new-slider-section">
                <div class="container-fluid no-padding">
                  <div class="new_slider owl-carousel owl-theme">
                    <?php foreach($hero_slider as $key => $slider){ ?>
                      <div class="new_slider_info" data-video="<?php echo str_replace(' ', '-', $slider['lippie_month']); ?>">
                        <?php if($slider['is_current_month'] == true && $slider['lippie_month'] == strtoupper($current_month) && empty($hero_slider[$key-1]['is_current_month'])){ ?>
                          <div class="current_month-sm">
                            <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/Current-Month-Marker-SM.svg"/>
                          </div>
                        <?php } ?>
                        <div class="titles">
                          <h3><?php echo $slider['lippie_month']; ?></h3>
                          <h1><?php echo $slider['lippie_subtitle']; ?></h1>
                        </div>
                        <img src="<?php echo $slider['lippie_image']; ?>" alt="">
                      </div>
                    <?php } ?>
                  </div>
                </div>
              </div>
            <?php } ?>
            <!--KM slider ends-->
          </div>

          <div class="col-md-6 content">
            <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/logo_kissme.svg" alt="KissMe" class="logo-intro">
            <p class="title">Discover your next favorite lipstick</p>
            <p class="description">Get 3 exclusive long-lasting lippies for $19.99. You'll be falling in love with exciting shades every month!</p>
              <?php
              if (!rs_function_to_check_the_restriction_for_referral()){
                  LiveGlam_User_Level::show_block_referral_message_or_popup('km');
              }
              ?>
            <?php echo do_shortcode('[referral_code_form product="kissme"]'); ?>
            <div class="section-links">
              <a href="/pre-checkout?club=kissme" class="btn-primary">Start Getting Lipsticks</a>
            </div>
            <div class="memberships">
              <ul>
                <li>
                  <div class="grid has-right-border">
                    <span class="cost-bg">3</span>
                    <p class="type">Lipstick Shades</p>
                  </div>
                </li>
                <li>
                  <div class="grid has-right-border">
                    <span class="dollar">$</span>
                    <span class="cost-bg">19</span>
                    <span class="cost-sm">.99</span>
                    <p class="type">per month</p>
                  </div>
                </li>
                <li>
                  <div class="grid has-right-border">
                    <span class="dollar">$</span>
                    <span class="cost-bg">7</span>
                    <span class="cost-sm">Avg. Price<br/>per Lippie</span>
                    <p class="type">3 for the price of 1</p>
                  </div>
                </li>
                <li>
                  <div class="grid">
                    <span class="cost-md">Free<br/>Shipping</span>
                    <p class="type">for US & $3.99 worldwide</p>
                  </div>
                </li>
              </ul>
            </div>

            <?php if(!empty($hero_slider)): ?>
              <div class="section-video section-video-1 d-none">
                <?php $has_video = false;
                  foreach($hero_slider as $slider): if(!empty($slider['lippie_video'])):
                    $classvd = 'd-none';
                    if($has_video == false){
                      $has_video = true;
                      $classvd = '';
                    } ?>
                    <a rel="gallery1" title="<?php echo $slider['lippie_video_title']; ?>"
                       class="play-video <?php echo str_replace(' ', '-', $slider['lippie_month']); ?> <?php echo $classvd; ?>"
                       href="<?php echo $slider['lippie_video']; ?>">
                      <i class="fas fa-play-circle"></i>
                      Watch the Video
                    </a>
                  <?php endif; endforeach; ?>
                <?php if($has_video == false): ?>
                  <a rel="gallery1" title="" class="play-video" href="https://vimeo.com/273408419/b6c4f7cf46">
                    <i class="fas fa-play-circle"></i>
                    Watch the Video
                  </a>
                <?php endif; ?>
              </div>
            <?php endif; ?>

          </div>
        </div>
      </div>
    </div>
  </section>
  <script type="text/javascript">
    jQuery(document).ready(function () {
      var new_slider_owl = jQuery('.new_slider.owl-carousel');
      new_slider_owl.owlCarousel({
        autoplay: true,
        autoplayTimeout: 5000,
        autoplayHoverPause: false,
        smartSpeed: 750,
        items: 1,
        loop: true,
        nav: true,
        navText: ["<img src='<?php echo get_stylesheet_directory_uri(); ?>/assets/img/left_arrow.png' class='new_slider_nav nav-left'>",
          "<img src='<?php echo get_stylesheet_directory_uri(); ?>/assets/img/right_arrow.png' class='new_slider_nav nav-right'>"],
      });
    });
  </script>
  <!-- new slider ends-->

  <!-- Status -->
  <div class="status-bar brush-club">
    <div class="container show-desktop">
      <div class="row">
        <div class="col-md-4">
          <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/purple-shape-1.svg" class="status-shape">
          <p class="counter"><?php echo do_shortcode('[number_complete_order]'); ?></p>
          <div class="status-title">
            <p class="title-md">Products Shipped</p>
            <p class="title-sm">to LiveGlam Members last month</p>
          </div>
        </div>
        <div class="col-md-4">
          <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/purple-shape-2.svg" class="status-shape">
          <p class="counter">4.9</p>
          <div class="status-title">
            <p class="title-md">Stars out of 5</p>
            <p class="title-sm">on 500+ Facebook Reviews</p>
          </div>
        </div>
        <div class="col-md-4">
          <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/purple-shape-3.svg" class="status-shape">
          <p class="counter">98%</p>
          <div class="status-title">
            <p class="title-md">Positive Ratings</p>
            <p class="title-sm">on 500+ BBB customer reviews</p>
          </div>
        </div>
      </div>
    </div>
    <ul id="scroller" class="stats_slider owl-carousel owl-theme show-mobile">
      <li>
        <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/purple-shape-1.svg" class="status-shape">
        <p class="counter"><?php echo do_shortcode('[number_complete_order]'); ?></p>
        <div class="status-title">
          <p class="title-md">Products Shipped</p>
          <p class="title-sm">to LiveGlam Members last month</p>
        </div>
      </li>
      <li>
        <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/purple-shape-2.svg" class="status-shape">
        <p class="counter">4.9</p>
        <div class="status-title">
          <p class="title-md">Stars out of 5</p>
          <p class="title-sm">on 500+ Facebook Reviews</p>
        </div>
      </li>
      <li>
        <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/purple-shape-3.svg" class="status-shape">
        <p class="counter">98%</p>
        <div class="status-title">
          <p class="title-md">Positive Ratings</p>
          <p class="title-sm">on 500+ BBB customer reviews</p>
        </div>
      </li>
    </ul>
  </div>

  <!-- glamours -->
  <?php if(!empty($total_glamours = get_post_meta(9999995205, 'glamours', true))) : ?>
    <div class="glamour_color">
      <div class="container">
        <h2 class="section-title">Some of our #LiveGlamFam Rockin' KissMe</h2>
        <div class="list_glamours owl-carousel owl-theme normal">
          <?php for($i = 0; $i < $total_glamours; $i++):
            $glamours_image = wp_get_attachment_image_url(get_post_meta(9999995205, 'glamours_'.$i.'_glamours_image', true), 'full');
            $glamours_handle = get_post_meta(9999995205, 'glamours_'.$i.'_glamours_handle', true);
            $number_of_followers = get_post_meta(9999995205, 'glamours_'.$i.'_number_of_followers', true);
            $shade_color_code = get_post_meta(9999995205, 'glamours_'.$i.'_shade_color_code', true);
            $glamours_name = get_post_meta(9999995205, 'glamours_'.$i.'_glamours_name', true); ?>
            <div class="glam_carousel">
              <div class="info_glamour">
                <img src="<?php echo $glamours_image; ?>" alt="">
                <div class="glamours_handle">
                  <h3 class="htg_glam"><?php echo $glamours_handle; ?></h3>
                  <h4 class="wearing"><?php echo !empty($number_of_followers)?$number_of_followers.' |':''; ?> wearing</h4>
                  <h3 class="tl_glam" style="color:<?php echo $shade_color_code; ?>;"><?php echo $glamours_name; ?></h3>
                </div>
              </div>
            </div>
          <?php endfor; ?>
        </div>
      </div>
      <script type="text/javascript">
        jQuery(document).ready(function () {
          jQuery('.glamour_color .owl-carousel').owlCarousel({
            loop: true,
            margin: 10,
            dots: false,
            nav: true,
            navText: ["<img src='<?php echo get_stylesheet_directory_uri(); ?>/assets/img/left_arrow.png'>",
              "<img src='<?php echo get_stylesheet_directory_uri(); ?>/assets/img/right_arrow.png'>"],
            autoplay: true,
            autoplayTimeout: 5000,
            autoplayHoverPause: true,
            responsive: {
              0: {items: 1},
              767: {items: 2},
              1000: {items: 4}
            }
          });
        });
      </script>
    </div>
  <?php endif; ?>

  <!-- video slider issue #839 -->
  <?php $video_slider = array();
    if(!empty($total_video_slider = get_post_meta(9999995205, 'video_slider', true))) :
      $first_label_next_month = $last_label_previous_month = '';
      for($i = 0; $i < $total_video_slider; $i++):
        if(empty($first_label_next_month) && empty($last_label_previous_month)){
          $first_label_next_month = get_post_meta(9999995205, 'video_slider_'.$i.'_label_next_month', true);
          $last_label_previous_month = get_post_meta(9999995205, 'video_slider_'.$i.'_label_previous_month', true);
        }
        $video_slider[] = array(
          'video_url' => get_post_meta(9999995205, 'video_slider_'.$i.'_video_url', true),
          'background_image_dk' => wp_get_attachment_image_url(get_post_meta(9999995205, 'video_slider_'.$i.'_background_image_desktop', true), 'full'),
          'background_image_mb' => wp_get_attachment_image_url(get_post_meta(9999995205, 'video_slider_'.$i.'_background_image_mobile', true), 'full'),
          'month_name' => get_post_meta(9999995205, 'video_slider_'.$i.'_month_name', true),
          'month_subtitle' => get_post_meta(9999995205, 'video_slider_'.$i.'_month_subtitle', true),
          'next_month' => get_post_meta(9999995205, 'video_slider_'.$i.'_label_next_month', true),
          'prev_month' => get_post_meta(9999995205, 'video_slider_'.$i.'_label_previous_month', true),
          );
      endfor; ?>
      <div class="section-video section-video-2 d-none">
        <div class="container">
          <h2 class="section-title hide-mobile">Pucker Up & Watch This</h2>
          <div class="video-slider dk-video owl-carousel owl-theme hide-mobile">
            <?php foreach($video_slider as $slider): ?>
              <div class="item-video" data-merge="3">
                <div class="item-video-top">
                  <a class="owl-video nofancybox nolightbox" href="<?php echo $slider['video_url']; ?>">
                    <div class="owl-video-bg" style="background-image: url(<?php echo $slider['background_image_dk']; ?>);"></div>
                  </a>
                </div>
                <div class="item-video-bot">
                  <p class="item-video-content">
                    <span class="item-video-month-cloned left float-left"><?php echo $slider['month_name']; ?></span>
                    <?php echo $slider['month_subtitle']; ?>
                    <span class="item-video-month-cloned right float-right"><?php echo $slider['month_name']; ?></span>
                  </p>
                </div>
              </div>
            <?php endforeach; ?>

          </div>
          <div class="video-slider mb-video owl-carousel owl-theme show-mobile">
            <?php foreach($video_slider as $slider): ?>
              <div class="item-video" data-merge="3" data-next_month="<?php echo $slider['next_month']; ?>" data-prev_month="<?php echo $slider['prev_month']; ?>">
                <div class="video-title-mb">
                  <p>Pucker Up & Watch This</p>
                  <a rel="gallery2" class="video-slide-mobile" href="<?php echo $slider['video_url']; ?>" title="<?php echo strip_tags($slider['month_subtitle']); ?>"><i class="fas fa-play-circle"></i></a>
                </div>
                <div class="item-video-bot">
                  <img src="<?php echo $slider['background_image_mb']; ?>"/>
                </div>
              </div>
            <?php endforeach; ?>
          </div>
        </div>
        <script type="text/javascript">
          jQuery(document).ready(function () {
            var prev_text = '<?php echo $last_label_previous_month; ?>',
              next_text = '<?php echo $first_label_next_month; ?>';
            var width = (window.innerWidth > 0) ? window.innerWidth : screen.width,
              margin = 60;
            if (width <= 1024) {
              margin = 30;
              if (width <= 767) {
                margin = 0;
              }
            }
            var video_slider = jQuery('.video-slider');
            video_slider.owlCarousel({
              items: 1,
              margin: margin,
              merge: true,
              loop: true,
              video: true,
              lazyLoad: true,
              center: true,
              responsive: {
                0: {items: 2},
                768: {items: 4}
              },
              nav: true,
              navText: ["<i class='fas fa-angle-left'></i><span class='show-mobile'>" + prev_text + "</span>", "<span class='show-mobile'>" + next_text + "</span><i class='fas fa-angle-right'></i>"],
              dots: false
            });

            video_slider.on('translated.owl.carousel', function (event) {
              var current = jQuery(this);
              if (current.hasClass('mb-video')) {
                var next_month = current.find('.owl-item.active.center .item-video').data('next_month'),
                  prev_month = current.find('.owl-item.active.center .item-video').data('prev_month');
                current.find('.owl-nav .owl-prev span').text(prev_month);
                current.find('.owl-nav .owl-next span').text(next_month);
              }
            });

            jQuery('body').on('click', '.video-slide-mobile', function () {
              jQuery('#fancybox-overlay').addClass('overlay-smoothly');
              jQuery('#fancybox-close').addClass('default-style');
            });

            jQuery('body').on('click', '#fancybox-close', function () {
              jQuery('#fancybox-overlay').removeClass('overlay-smoothly');
              jQuery('#fancybox-close').removeClass('default-style');
            });

          });
        </script>
      </div>
    <?php endif; ?>

  <!-- how works -->
  <section class="how-works text-center row" id="how-works">
    <div class="col-md-6 left-section default-section-height">
      <div class="">
        <div class="vertical-center">
          <div class="left-half-container">
            <h2 class="section-title">How KissMe Works</h2>
            <p class="description first-decs">Calling all lipstick lovers! Get in on the action and take on the day when you receive 3 of our long-wear liquid lippies each month.</p>
            <p class="method txt-purple">You're In Control</p>
            <p class="description">Not feelin' your next lippies? Trade them! Strapped for cash? Skip a payment! Got lippie overload? Cancel anytime. It’s that simple.</p>
            <p class="method txt-purple">Lippies With Love</p>
            <p class="description">Your membership is more than just lipstick! You’ll score Reward points each month to use on free makeup and goodies!</p>
          </div>
        </div>
      </div>
    </div>
    <div class="col-md-6 howkissme default-section-height">
      <div class="">
        <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/howkissmeworks-mobile.png" class="show-mobile">
      </div>
    </div>
  </section>

  <!-- why subscribe -->
  <section class="why-subscribe row">
    <div class="col-md-6 youcannever default-section-height show-desktop">
    </div>
    <div class="col-md-6 right-section default-section-height">
      <div class="">
        <div class="vertical-center">
          <div class="right-half-container">
            <h2 class="section-title">You Can Never Have Too Many Lippies</h2>
            <p class="description first-decs">Step outside your comfort zone and discover a color you never knew you’d love! Our long-lasting formula will glide through your morning and even outlast your lunch. Each month is a new exciting theme that brings you beautiful lippies at an affordable price!</p>
          </div>
        </div>
      </div>
    </div>
    <div class="col-12 d-md-none"><img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/youcanneverhavetoomanylippies-mobile.png"></div>

  </section>

  <!-- join club -->
  <section class="join-club lipstick row">
    <div class="col-md-6 left-section default-section-height">
      <div class="">
        <div class="vertical-center">
          <div class="left-half-container">
            <h3 class="section-title">Shades for Days</h3>
            <p class="description first-decs">Every month you'll get 3 long-lasting lippies! Your lips will be dark and nude, bright, pastel, metallic, matte, glossy, and more! Get ready to meet your next favorite lippie.</p>
            <div class="section-links">
              <a href="/pre-checkout?club=kissme" class="btn-secondary">Sign Up to Start Receiving Lippies</a>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="col-md-6 lipsticks default-section-height">
      <div class="">
        <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/shadesfordays-mobile.png" class="show-mobile">
      </div>
    </div>
  </section>

  <!-- subscription plans -->
  <section class="subscription-plan row">
    <div class="col-md-6 sweet-spot default-section-height">
      <div class="">
        <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/packonmonthlysavings-mobile.png" class="show-mobile">
      </div>
    </div>
    <div class="col-md-6 right-section default-section-height">
      <div class="has-padding">
        <div class="vertical-center">
          <div class="right-half-container">
            <h3 class="section-title">Pucker Up and Save</h3>
            <p class="description first-decs">High quality lippies at an amazing price! You'll be mesmerized by the creamy, pigmented formula and all the colors you get to try. Plus you get free shipping in the US and $3.99 anywhere else in the world. Your lippies also come with Reward points to use on free makeup or other goodies!</p>
            <div class="section-links">
              <a href="/pre-checkout?club=kissme" class="btn-secondary">Explore Membership Options</a>
            </div>
          </div>
        </div>
      </div>
  </section>

  <!-- whenever you want -->
  <section class="whenever-want lipstick mobile-colored-block row">
    <div class="col-md-6 left-section default-section-height">
      <div class="">
        <div class="vertical-center">
          <div class="left-half-container">
            <h3 class="section-title">Lippies the Way You Love</h3>
            <p class="description">Get your lipstick fix on your terms. We’ll ship your lippies to you anywhere in the world. Plus, you can cancel, skip, or even trade your next set in for something new! It’s that simple.</p>
            <div class="section-links">
              <a href="/pre-checkout?club=kissme" class="btn-secondary btn-mobile-primary">Don't Miss Our Next Shipment of Lippies</a>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="col-md-6 right-section bg-countdown default-section-height">
      <div class="">
        <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/lipstick_countdown_bg.png" class="show-mobile full-width">
      </div>
      <div class="timer">
        <div class="timer-header">
          <h3>hurry!</h3>
          <p>Lippies Ship In:</p>
        </div>
        <?php echo do_shortcode('[ujicountdown id="3" expire="18:00" hide="false" url="" subscr="" recurring="24" rectype="hour" repeats=""]'); ?>
      </div>
    </div>
  </section>

  <!-- First Collection -->
  <section class="first-collection subscription-plan row" id="first-collection">
    <div class="col-md-6 left-section text-center default-section-height">
      <div class="">
        <div class="vertical-center">
          <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/desktop_and_mobile-KM-LP-gif.gif">
        </div>
      </div>
    </div>
    <div class="col-md-6 right-section default-section-height">
      <div class="">
        <div class="vertical-center">
          <div class="right-half-container">
            <h3 class="section-title">Glam the way you want it!</h3>
            <p class="description">You get to choose which collection you want to receive first. We're flexible as our lippie formula!</p>
            <div class="section-links">
              <a href="/pre-checkout?club=kissme" class="btn-secondary">Join Now and Choose Your Set On Checkout!</a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- Choose Plan -->
  <?php $option_cirle = '<svg class="option-selected" width="133px" height="133px" viewBox="0 0 133 133" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                      <g class="check-group" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                        <circle class="ck-filled-circle" fill="#f05e7c" cx="66.5" cy="66.5" r="54.5"></circle>
                        <circle class="ck-white-circle" fill="#FFFFFF" cx="66.5" cy="66.5" r="55.5"></circle>
                        <circle class="ck-outline" stroke="#f05e7c" stroke-width="4" cx="66.5" cy="66.5" r="54.5"></circle>
                        <polyline class="ck-check" stroke="#FFFFFF" stroke-width="10" points="41 70 56 85 92 49"></polyline>
                      </g>
                    </svg>'; ?>
    <!--default subscription box ends-->

  <!-- section testimonials -->
  <?php if(!empty($all_testimonials = liveglam_get_all_testimonials_by_termid(array(351), 8))): ?>
    <section class="testimonials new-testimonials">
      <!--<img src="<?php /*echo get_stylesheet_directory_uri();*/ ?>/assets/img/IMG_girl_heart-eyes.png" class="img-left-bottom show-desktop">
      <img src="<?php /*echo get_stylesheet_directory_uri();*/ ?>/assets/img/IMG_girl-heart.png" class="img-right-bottom show-desktop">-->
      <div class="container">
        <h2 class="section-title">Our Customers Love Us</h2>
        <p class="section-comment">Don’t take our word for it, take theirs</p>
        <div class="new-reviews-desktop hide-mobile">
          <div class="owl-carousel owl-theme new-reviews new-reviews-two" id="new-reviews">
            <?php $i = 0; foreach($all_testimonials as $testimonials): ?>
              <div class="new-reviews-content" data-slider-id="<?php echo $i++; ?>">
                <div class="new-reviews-container">
                  <img src="<?php echo $testimonials['customer_images']; ?>" class="photo image-blog-author">
                  <div class="new-slide-top">
                    <p class="title"><?php echo $testimonials['name']; ?></p>
                    <p class="desc"><?php echo $testimonials['content']; ?></p>
                  </div>
                  <div class="new-slide-bottom">
                    <div class="new-slide-bottom-content">
                      <!-- <p class="customer-subscribes">
                        <?php if( !empty( $testimonials['subscribes_club']) ): ?>
                          Subscribes to: <span><?php echo $testimonials['subscribes_club']; ?></span>
                        <?php endif; ?>
                        &nbsp;
                      </p> -->
                      <p class="customer-social">
                        <span><img src="<?php echo $testimonials['images_further']; ?>" class="icon-<?php echo $testimonials['further_choose']; ?>"></span><?php echo $testimonials['name_handle']; ?>
                      </p>
                    </div>
                  </div>
                </div>
              </div>
            <?php endforeach; ?>
          </div>
          <div class="new-reviews new-reviews-dots new-reviews-dots-two">
            <div class="new-reviews-dots-lists">
              <?php $i = 0; foreach($all_testimonials as $testimonials): ?>
                <div class="new-reviews-dots-item" data-slider-id="<?php echo $i++; ?>">
                  <img src="<?php echo $testimonials['customer_images']; ?>" class="photo image-blog-author">
                </div>
              <?php endforeach; ?>
            </div>
          </div>
        </div>
        <div class="new-reviews-mobile show-mobile">
          <div class="owl-carousel owl-theme new-reviews new-reviews-one" id="new-reviews">
            <?php $i = 0; foreach($all_testimonials as $testimonials): if( $i >= 6 ) break; ?>
              <div class="new-reviews-content" data-slider-id="<?php echo $i++; ?>">
                <div class="new-reviews-container">
                  <img src="<?php echo $testimonials['customer_images']; ?>" class="photo image-blog-author">
                  <div class="new-slide-top">
                    <p class="title"><?php echo $testimonials['name']; ?></p>
                    <p class="desc"><?php echo $testimonials['content']; ?></p>
                  </div>
                  <div class="new-slide-bottom">
                    <div class="new-slide-bottom-content">
                      <!-- <p class="customer-subscribes">
                        <?php if( !empty( $testimonials['subscribes_club']) ): ?>
                          Subscribes to: <span><?php echo $testimonials['subscribes_club']; ?></span>
                        <?php endif; ?>
                        &nbsp;
                      </p> -->
                      <p class="customer-social">
                        <span><img src="<?php echo $testimonials['images_further']; ?>" class="icon-<?php echo $testimonials['further_choose']; ?>"></span><?php echo $testimonials['name_handle']; ?>
                      </p>
                    </div>
                  </div>
                </div>
              </div>
            <?php endforeach; ?>
          </div>
          <div class="new-reviews new-reviews-dots">
            <div class="new-reviews-dots-lists">
              <?php $i = 0; foreach($all_testimonials as $testimonials): if( $i >= 6 ) break; ?>
                <div class="new-reviews-dots-item" data-slider-id="<?php echo $i++; ?>">
                  <img src="<?php echo $testimonials['customer_images']; ?>" class="photo image-blog-author">
                </div>
              <?php endforeach; ?>
            </div>
          </div>
        </div>
        <!--        <img src="--><?php //echo get_stylesheet_directory_uri();?><!--/assets/img/IMG_girl_heart-eyes-full.png" class="show-mobile img-girl">-->
        <div class="view-all-reveiews">
          <a href="<?php echo home_url('/reviews'); ?>" class="btn-secondary float-right">View All Reviews</a>
        </div>
      </div>
    </section>
  <?php endif; ?>
  <!-- end testimonial section -->

  <!-- section questions -->
  <?php $faqs = lgs_get_faq_landing_page(9999995205);
    if($faqs): ?>
      <section class="questions" id="faq">
        <h3 class="txt-lighter-purple">Frequently Asked Questions</h3>
        <div class="container">
          <div class="">
            <?php $faq_col1 = 1;
              $faq_col2 = 0;
              $faq_num_per_col = count($faqs) / 2;
              for($faq_col1; $faq_col1 <= 2; $faq_col1++){ ?>
                <div class="col-md-6">
                  <div class="panel-group" id="accordion<?php echo $faq_col1; ?>">
                    <?php for($faq_col2; $faq_col2 < $faq_col1 * $faq_num_per_col; $faq_col2++){
                      $faq = $faqs[$faq_col2]; ?>
                      <div class="card">
                        <div class="card-header">
                          <h4 class="card-title">
                            <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion<?php echo $faq_col1; ?>" href="#panel<?php echo $faq_col2; ?>"><i class="fas fa-plus"></i><span><?php echo $faq['question']; ?></span></a>
                          </h4>
                        </div>
                        <div id="panel<?php echo $faq_col2; ?>" class="panel-collapse collapse">
                          <div class="card-body"><?php echo $faq['answer']; ?></div>
                        </div>
                      </div>
                    <?php } ?>

                  </div>
                </div>
              <?php } ?>
          </div>
        </div>
      </section>
    <?php endif; ?>
  <!-- end section question -->

  <!-- subscribe question -->
  <section class="subscribe show-desktop">
    <div class="container">
      <p class="txt-lighter-purple">DISCOVER YOUR NEXT FAVORITE LIPPIE</p>
      <h2>A More Beauty-full You Awaits</h2>
      <a href="/pre-checkout?club=kissme" class="btn-primary">Start Getting Lippies</a>
      <div class="clear"></div>
      <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/hand-lipsticks.png">
    </div>
  </section>
</div>
<style>
  .section-video.section-video-1 {
    margin-top: 10px;
  }

  .section-video .play-video {
    line-height: 40px;
    display: flex;
    font-size: 16px;
    color: #8c4096;
  }

  .section-video .play-video i {
    font-size: 40px;
    margin-right: 10px;
  }

  .section-video.section-video-2 {
    padding: 4vw 0;
    background-color: rgba(255, 248, 241, 1);
    text-align: center;
  }

  .section-video.section-video-2 .section-title {
    margin-bottom: 3vw;
  }

  .video-slider .owl-item {
    padding: 0;
  }

  .video-slider .owl-item .owl-video-wrapper {
    background: rgba(0, 0, 0, 0);
  }

  .video-slider .owl-item .item-video .item-video-top {
    height: 26vw;
  }

  .video-slider .owl-item .item-video .item-video-top iframe {
    height: 26vw;
  }

  .video-slider .owl-item.owl-video-playing .item-video .item-video-top .owl-video {
    display: none !important;
  }

  .video-slider .owl-item .item-video .item-video-top .owl-video {
    display: block !important;
    position: absolute;
    z-index: 0;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    pointer-events: none;
  }

  .video-slider .owl-item .item-video .item-video-top .owl-video .owl-video-bg {
    background-color: rgb(253, 208, 187);
    background-size: 0 0;
    position: relative;
    width: 100%;
    height: 100%;
    background-repeat: no-repeat;
  }

  .video-slider .owl-item.active .item-video .item-video-top .owl-video .owl-video-bg {
    background-color: rgb(254, 210, 208);
  }

  .video-slider .owl-item.active.center .item-video .item-video-top .owl-video .owl-video-bg {
    background-color: rgba(0, 0, 0, 0);
    background-size: cover;
    background-position: center;
  }

  .video-slider .owl-item .item-video .item-video-bot {
    padding: 20px;
  }

  .video-slider .owl-item .item-video .item-video-bot .item-video-content {
    font-size: 15px;
    margin: 0;
    color: rgba(234, 115, 135, 1);
  }

  .video-slider .owl-item .item-video .item-video-bot .item-video-content span.item-video-month {
    color: rgb(225, 75, 105);
    font-weight: bold;
    letter-spacing: 1px;
    display: none;
    text-transform: uppercase;
  }

  .video-slider .owl-item .item-video .item-video-bot .item-video-content span.item-video-month-cloned {
    font-weight: bold;
    letter-spacing: 1px;
    display: block;
    text-transform: uppercase;
  }

  .video-slider .owl-item .item-video .item-video-bot .item-video-content span.item-video-month-cloned.left {
    color: rgb(253, 208, 187);
  }

  .video-slider .owl-item .item-video .item-video-bot .item-video-content span.item-video-month-cloned.right {
    color: rgb(254, 210, 208);
  }

  .video-slider .owl-item.center .item-video .item-video-bot .item-video-content span.item-video-month-cloned {
    display: none;
  }

  .video-slider .owl-item.center .item-video .item-video-bot .item-video-content span.item-video-month {
    display: inline-block;
  }

  .video-slider .owl-item.owl-video-playing .item-video .item-video-bot .item-video-content span.item-video-month-cloned {
    display: none;
  }

  .video-slider .owl-item.owl-video-playing .item-video .item-video-bot .item-video-content span.item-video-month {
    display: inline-block;
  }

  .video-slider .owl-item .owl-video-tn {
    opacity: 0 !important;
  }

  .video-slider .owl-nav {
    top: 45%;
    transform: translateY(-50%);
    margin: 0;
    height: 0;
    display: block;
  }

  .video-slider .owl-nav .owl-prev,
  .video-slider .owl-nav .owl-next {
    background-color: #fff !important;
    width: 50px;
    height: 50px;
    border-radius: 50%;
    padding: 0;
    line-height: 50px;
    display: inline-flex;
    justify-content: center;
  }

  .video-slider .owl-nav .owl-prev i,
  .video-slider .owl-nav .owl-next i {
    font-size: 40px;
    color: #f05e7c;
    line-height: 50px;
  }

  .video-slider .owl-nav .owl-prev {
    margin: -25px 0 0px 5% !important;
  }

  .video-slider .owl-nav .owl-next {
    margin: -25px 5% 0 0 !important;
  }

  #fancybox-left {
    width: 10%;
    left: -10%;
  }

  #fancybox-right {
    width: 10%;
    right: -10%;
  }

  #fancybox-left #fancybox-left-ico,
  #fancybox-right #fancybox-right-ico {
    left: 50% !important;
    transform: translateX(-50%);
  }

  @media only screen and (max-width: 768px) {
    .video-slider .owl-item .item-video .item-video-top {
      height: 35vw;
    }

    .video-slider .owl-item .item-video .item-video-top iframe {
      height: 35vw;
    }
  }

  @media screen and (max-width: 767px) {

    #fancybox-overlay.overlay-smoothly {
      background-color: rgba(0, 0, 0, 0.7) !important;
    }

    .section-video.section-video-2 {
      padding: 0;
    }

    .section-video.section-video-2 .container {
      padding: 0;
    }

    .video-slider {
      padding-bottom: 50px;
    }

    .video-slider .owl-nav {
      top: unset;
      transform: none;
      position: relative;
    }

    .video-slider .owl-nav .owl-next {
      background-color: rgba(254, 210, 208, 1) !important;
    }

    .video-slider .owl-nav .owl-prev {
      background-color: rgba(253, 208, 187, 1) !important;
    }

    .video-slider .owl-nav .owl-prev,
    .video-slider .owl-nav .owl-next {
      margin: 0 !important;
      color: #f05e7c !important;
      width: 50%;
      border-radius: 0;
      padding: 10px 0;
    }

    .video-slider .owl-nav .owl-prev i,
    .video-slider .owl-nav .owl-next i {
      font-size: 14px;
      font-weight: bold;
      width: 20px;
      height: 20px;
      background-color: #fff;
      border-radius: 50%;
      line-height: 20px;
      margin: 5px 0;
    }

    .video-slider .owl-nav .owl-prev span,
    .video-slider .owl-nav .owl-next span {
      width: 60%;
      line-height: 32px;
      font-size: 16px;
    }

    .video-slider .owl-item .item-video .item-video-bot {
      padding: 0;
    }

    .video-slider .owl-item .item-video .video-title-mb {
      position: absolute;
      top: 8%;
      width: 100%;
    }

    .video-slider .owl-item .item-video .video-title-mb p {
      font-size: 2.4rem;
      color: #fff;
      margin: 0 auto 1rem;
    }

    .video-slider .owl-item .item-video .video-title-mb i {
      font-size: 6rem;
      color: #fff;
    }

    #fancybox-left {
      width: 50%;
      bottom: -50px;
      height: 50px;
      left: 0;
    }

    #fancybox-right {
      width: 50%;
      bottom: -50px;
      height: 50px;
      right: 0;
    }

    .section-video.section-video-1 a {
      text-align: center;
      width: max-content;
      margin: 0 auto;
    }

    #fancybox-close.default-style {
      top: -15px !important;
      right: -15px !important;
      width: 30px !important;
      height: 30px !important;
      background: transparent url(<?php echo get_stylesheet_directory_uri(); ?>/../../wp-content/plugins/easy-fancybox/fancybox/fancybox.png) -40px 0 !important;
    }

    #fancybox-close.default-style:before {
      content: "";
    }
  }

</style>

<?php get_footer(); ?>