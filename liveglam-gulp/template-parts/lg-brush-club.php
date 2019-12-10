<?php
  /**
   * Template Name: Brush Club page
   *
   * @package Liveglam
   */

  get_header(); ?>

<div class="page-brush-club">
  <!-- Intro -->
  <section class="intro">
    <div class="offical-badge badge-square">
      <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/mm-badge-square.png" />
    </div>
    <div class="vertical-center">
      <div class="container">
        <div class="row">
          <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/mobile-MM-hero.png" class="show-mobile img-intro">
          <div class="col-md-6 offset-md-6 content">
            <div class="offical-badge badge-circular">
              <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/mm_badge_circular.png" />
            </div>
            <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/LiveGlam_MorpheMe_Logo.png" alt="MorpheMe" class="logo-intro">
            <p class="title">Receive Monthly <span class="change-word">Powder Brushes</span></p>
            <p class="description desc">Get 3-8 Morphe brushes each month for $19.99.
                                        Brushing up your kit has never been so easy!</p>
              <?php

              if (!rs_function_to_check_the_restriction_for_referral()){
                  LiveGlam_User_Level::show_block_referral_message_or_popup('mm');
              }
              ?>
            <?php echo do_shortcode('[referral_code_form product="morpheme"]'); ?>
            <div class="section-links">
              <a href="/pre-checkout?club=morpheme" class="btn-primary">Join Brush Club</a>
            </div>
            <div class="memberships">
              <ul>
                <li>
                  <div class="grid has-right-border">
                    <span class="cost-bg">3-8</span>
                    <p class="type">Makeup Brushes</p>
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
                    <span class="cost-bg">4</span>
                    <span class="cost-sm">Avg. Price<br/>per Brush</span>
                    <p class="type">Save over 33%</p>
                  </div>
                </li>
                <li>
                  <div class="grid">
                    <span class="cost-md">Free<br/>Shipping</span>
                    <p class="type">for US & $4.99 worldwide</p>
                  </div>
                </li>
              </ul>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
  <!--Intro ends-->

  <!--slider starts-->
  <?php $hero_slider = array();
    if(!empty($total_hero_slider = get_post_meta(9999378286, 'hero_slider_morpheme', true))):
      $current_date = date('Y-m-d H:i:s',current_time('timestamp'));
      for($i = 0; $i < $total_hero_slider; $i++):
        $startdate = get_post_meta(9999378286, 'hero_slider_morpheme_'.$i.'_start_date', true);
        $enddate = get_post_meta(9999378286, 'hero_slider_morpheme_'.$i.'_end_date', true);
        if( !empty($startdate) && $startdate > $current_date ) continue;
        if( !empty($enddate) && $enddate < $current_date ) continue;
        $hero_slider[] = array('is_current_month' => get_post_meta(9999378286, 'hero_slider_morpheme_'.$i.'_is_current_month', true), 'brush_month' => get_post_meta(9999995196, 'hero_slider_morpheme_'.$i.'_brush_month', true), 'brush_subtitle' => get_post_meta(9999995196, 'hero_slider_morpheme_'.$i.'_brush_subtitle', true), 'brushes_image' => wp_get_attachment_image_url(get_post_meta(9999378286, 'hero_slider_morpheme_'.$i.'_brushes_image', true), 'full'),);
      endfor;
    endif; ?>
  <section class="d-none intro <?php echo !empty($hero_slider)?'slider':''; ?>">
    <div class="vertical-center">
      <div class="container">
        <div class="row">
          <div class="col-md-6 no-padding">
            <?php if(empty($hero_slider)){ ?>
              <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/mobile-MM-hero.png" class="show-mobile img-intro">
            <?php }else{ ?>
              <!--MM slider starts-->
              <div class="new-slider-section">
                <div class="container-fluid no-padding">
                  <div class="new_slider owl-carousel owl-theme">
                    <?php
                      foreach($hero_slider as $slider){ ?>
                        <div class="new_slider_info">
                          <?php if($slider['is_current_month'] == true){ ?>
                            <div class="current_month">
                              <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/Current-Month-Marker.png"/>
                            </div>
                          <?php } ?>
                          <div class="titles">
                            <h3><?php echo $slider['brush_month']; ?></h3>
                            <h1><?php echo $slider['brush_subtitle']; ?></h1>
                          </div>

                          <img src="<?php echo $slider['brushes_image']; ?>" alt="">
                        </div>
                      <?php } ?>
                  </div>
                </div>
              </div>
            <?php } ?>
            <!--MM slider ends-->
          </div>
          <div class="col-md-6 content">
            <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/LiveGlam_MorpheMe_Logo.png" alt="MorpheMe" class="logo-intro">
            <p class="title">Receive Monthly <span class="change-word">Powder Brushes</span></p>
            <p class="description desc">Get 3-8 Morphe brushes each month for $19.99.
                                        Brushing up your kit has never been so easy!</p>
            <div class="section-links">
              <a href="/pre-checkout?club=morpheme" class="btn-primary">Join Brush Club</a>
            </div>
            <div class="memberships">
              <ul>
                <li>
                  <div class="grid has-right-border">
                    <span class="cost-bg">3-8</span>
                    <p class="type">Makeup Brushes</p>
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
                    <span class="cost-bg">4</span>
                    <span class="cost-sm">Avg. Price<br/>per Brush</span>
                    <p class="type">Save over 33%</p>
                  </div>
                </li>
                <li>
                  <div class="grid">
                    <span class="cost-md">Free<br/>Shipping</span>
                    <p class="type">for US & $4.99 worldwide</p>
                  </div>
                </li>
              </ul>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
  <script type="text/javascript">
    jQuery(document).ready(function () {
      jQuery('.new_slider.owl-carousel').owlCarousel({
        autoplay: true,
        autoplayTimeout: 5000,
        autoplayHoverPause: true,
        smartSpeed: 750,
        items: 1,
        loop: true,
        nav: true,
        navText: ["<img src='<?php echo get_stylesheet_directory_uri(); ?>/assets/img/Left-Arrow.png' class='new_slider_nav nav-left'>",
          "<img src='<?php echo get_stylesheet_directory_uri(); ?>/assets/img/Right-Arrow.png' class='new_slider_nav nav-right'>"],
      });
    });
  </script>
  <!--slider ends-->

  <!-- Status -->
  <div class="status-bar brush-club">
    <div class="container show-desktop">
      <div class="row">
        <div class="col-md-4">
          <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/blue-shape-1.svg" class="status-shape">
          <p class="counter"><?php echo do_shortcode('[number_complete_order]'); ?></p>
          <div class="status-title">
            <p class="title-md">Products Shipped</p>
            <p class="title-sm">to LiveGlam Members last month</p>
          </div>
        </div>
        <div class="col-md-4">
          <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/blue-shape-2.svg" class="status-shape">
          <p class="counter">4.9</p>
          <div class="status-title">
            <p class="title-md">Stars out of 5</p>
            <p class="title-sm">on 500+ Facebook Reviews</p>
          </div>
        </div>
        <div class="col-md-4">
          <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/blue-shape-3.svg" class="status-shape">
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
        <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/blue-shape-1.svg" class="status-shape">
        <p class="counter"><?php echo do_shortcode('[number_complete_order]'); ?></p>
        <div class="status-title">
          <p class="title-md">Products Shipped</p>
          <p class="title-sm">to LiveGlam Members last month</p>
        </div>
      </li>
      <li>
        <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/blue-shape-2.svg" class="status-shape">
        <p class="counter">4.9</p>
        <div class="status-title">
          <p class="title-md">Stars out of 5</p>
          <p class="title-sm">on 500+ Facebook Reviews</p>
        </div>
      </li>
      <li>
        <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/blue-shape-3.svg" class="status-shape">
        <p class="counter">98%</p>
        <div class="status-title">
          <p class="title-md">Positive Ratings</p>
          <p class="title-sm">on 500+ BBB customer reviews</p>
        </div>
      </li>
    </ul>
  </div>

  <!-- how works -->
  <section class="how-works text-center row" id="how-works">
    <div class="col-md-6 left-section default-section-height">
      <div class="">
        <div class="vertical-center">
          <div class="left-half-container">
            <h2 class="section-title">How MorpheMe Works</h2>
            <p class="description first-decs">Brush addicts rejoice! Get in on the action and see what magic you can create with a new shipment of Morphe brushes each month.</p>
            <p class="method txt-blue">You're in Control</p>
            <p class="description">Not feelin' your next brushes? Trade them! Strapped for cash? Skip a payment! Got brush overload? Cancel anytime. It’s that simple.</p>
            <p class="method txt-blue">Brushes With Benefits</p>
            <p class="description">Your membership is more than just brushes! You’ll score Reward points each month to use on free makeup and goodies!</p>
          </div>
        </div>
      </div>
    </div>
    <div class="col-md-6 howkissme default-section-height show-desktop">
    </div>
    <div class="col-12 d-md-none"><img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/howmorphemeworks-mobile.png"></div>

  </section>

  <!-- why subscribe -->
  <section class="why-subscribe row">
    <div class="col-md-6 youcannever default-section-height show-desktop">
    </div>
    <div class="col-md-6 right-section default-section-height">
      <div class="">
        <div class="vertical-center">
          <div class="right-half-container">
            <h2 class="section-title">You Can Never Have Too Many Brushes</h2>
            <p class="description first-decs">Every makeup addict knows how important their tools are. Don’t let your creativity be limited by your makeup kit. Get quality brushes at an affordable price delivered to you each month.</p>
          </div>
        </div>
      </div>
    </div>
    <div class="col-12 d-md-none"><img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/youcanneverhave- toomanybrushes-mobile.png"></div>

  </section>

  <!-- join club -->
  <section class="join-club row">
    <div class="col-md-6 left-section default-section-height">
      <div class="">
        <div class="vertical-center">
          <div class="left-half-container">
            <h3 class="section-title">Brush Up Your Kit</h3>
            <p class="description first-decs">Every month you'll get anywhere from 3-8 Morphe brushes. Soon you'll be rolling in Powder, Liner, Contour, Eyeshadow, & Foundation Brushes + more! Never the same brush twice.</p>
            <div class="section-links">
              <a href="/pre-checkout?club=morpheme" class="btn-secondary">Sign Up to Start Receiving Brushes</a>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="col-md-6 right-section default-section-height">
      <div class="">
        <div class="vertical-center">
          <div class="assets">
            <ul class="brush-types">
              <li>
                Powder Brushes
                <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/brush-powder-lrg.png" class="brush brush-1">
              </li>
              <li>
                Liner Brushes
                <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/brush_angle-large.png" class="brush brush-2">
              </li>
              <li>
                Contour Brushes
                <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/brush-contour-lrg.png" class="brush brush-3">
              </li>
              <li>
                Eyeshadow Brushes
                <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/brush-eye.png" class="brush brush-4">
              </li>
              <li>
                Foundation Brushes
                <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/brush-foundation-lrg.png" class="brush brush-5">
              </li>
            </ul>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- subscription plans -->
  <section class="subscription-plan row">
    <div class="col-md-6 sweet-spot default-section-height">
      <div class="">
        <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/packonmonthlysavings-mobile-mm.jpg" class="show-mobile">
      </div>
    </div>
    <div class="col-md-6 right-section default-section-height">
      <div class="has-padding">
        <div class="vertical-center">
          <div class="right-half-container">
            <h3 class="section-title">Pack On Monthly Savings</h3>
            <p class="description first-decs">Get $30+ of Morphe brushes for $19.99 and never worry about buying another brush again. Plus you get free shipping in the US and $4.99 anywhere else in the world. Your brushes also come with Reward points to use on free makeup or other goodies!</p>
            <div class="section-links">
              <a href="/pre-checkout?club=morpheme" class="btn-secondary">Explore Brush Subscription Plans</a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- whenever you want -->
  <section class="whenever-want mobile-colored-block row">
    <div class="col-md-6 left-section default-section-height">
      <div class="">
        <div class="vertical-center">
          <div class="left-half-container">
            <h3 class="section-title">Brushes the Way You Love</h3>
            <p class="description">Get your brush fix your way. We’ll ship your brushes to you anywhere in the world. Plus, you can cancel, skip, or even trade your next set in for something new! It’s that simple.</p>
            <div class="section-links">
              <a href="/pre-checkout?club=morpheme" class="btn-secondary white-bordered btn-mobile-primary">Don't Miss Our Next Shipment of Brushes</a>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="col-md-6 right-section text-center default-section-height">
      <div class="">
        <div class="vertical-center">
          <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/map-2.png" class="img-map">
          <h3>Hurry! Brushes ship in:</h3>
          <?php echo do_shortcode('[ujicountdown id="1" expire="18:00" hide="false" url="" subscr="" recurring="24" rectype="hour" repeats=""]'); ?>
        </div>
      </div>
    </div>
  </section>

  <!-- First Collection -->
  <section class="first-collection subscription-plan row" id="first-collection">
    <div class="col-md-6 left-section text-center default-section-height">
      <div class="">
        <div class="vertical-center">
          <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/desktop_and_mobile-MM-LP-gif.gif">
        </div>
      </div>
    </div>
    <div class="col-md-6 right-section default-section-height">
      <div class="">
        <div class="vertical-center">
          <div class="right-half-container">
            <h3 class="section-title">Glam the way you want it!</h3>
            <p class="description">You get to choose which collection you want to receive first. We're flexible as our makeup brushes!</p>
            <div class="section-links">
              <a href="/pre-checkout?club=morpheme" class="btn-secondary">Join Now and Choose Your Set On Checkout!</a>
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
  <!-- section testimonials -->
  <?php
  $all_testimonials = liveglam_get_all_testimonials_by_termid(array(325),8);
  ?>

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
  <!-- end testimonial section -->

  <!-- section questions -->
  <?php $faqs = lgs_get_faq_landing_page(9999378286);
    if($faqs): ?>
      <section class="questions" id="faq">
        <h3>Frequently Asked Questions</h3>
        <div class="container">
          <div class="row">
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
      <p>BRUSH UP YOUR KIT</p>
      <h2>A More Beauty-full You Awaits</h2>
      <a href="/pre-checkout?club=morpheme" class="btn-primary">Start Getting Brushes</a>
      <div class="clear"></div>
      <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/brush-hand.png">
    </div>
  </section>
</div>


<?php get_footer(); ?>

<script type="text/javascript">
  jQuery(function () {
    count = 0;
    wordsArray = ["Powder Brushes", "Liner Brushes", "Contour Brushes", "Eyeshadow Brushes", "Foundation Brushes"];
    setInterval(function () {
      count++;
      jQuery(".change-word").fadeOut(400, function () {
        jQuery(this).text(wordsArray[count % wordsArray.length]).fadeIn(400);
      });
    }, 3000);
  });
</script>