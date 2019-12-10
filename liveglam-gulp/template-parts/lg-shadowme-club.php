<?php
  /**
   * Template Name: ShadowMe Club page
   *
   * @package Liveglam
   */

  get_header();
  ?>

  <style>
    .page-shadow-club section.why-subscribe {
      background: url(<?php echo get_stylesheet_directory_uri().'/assets/img/SM-landing-page-why-subscribe4.png'; ?>) #FFF4F3;
      background-repeat: no-repeat;
      background-position: right center;
      background-size: auto 100%;
    }
    @media only screen and (max-width: 767px){
      .page-shadow-club section.why-subscribe {
        background: linear-gradient(to left, #FFE2DB 0%, #FFDFD3 100%);
      }
    }
  </style>
<div class="page-shadow-club">
  <!-- new slider -->
  <?php $hero_slider = array();
    if(!empty($total_hero_slider = get_post_meta(PAGE_SHADOWME_ID, 'hero_slider_shadowme', true))):
      $current_date = date('Y-m-d H:i:s',current_time('timestamp'));
      $currentdate = date('d',current_time('timestamp'));
      $current_month = $currentdate > 22 ? date('F',strtotime('+1 month')):date('F',current_time('timestamp'));
      for($i = 0; $i < $total_hero_slider; $i++):
        $startdate = get_post_meta(PAGE_SHADOWME_ID, 'hero_slider_shadowme_'.$i.'_start_date', true);
        $enddate = get_post_meta(PAGE_SHADOWME_ID, 'hero_slider_shadowme_'.$i.'_end_date', true);
        if( !empty($startdate) && $startdate > $current_date ) continue;
        if( !empty($enddate) && $enddate < $current_date ) continue;
        $hero_slider[] = array(
          'is_current_month' => get_post_meta(PAGE_SHADOWME_ID, 'hero_slider_shadowme_'.$i.'_is_current_month', true),
          'eyeshadow_month' => get_post_meta(PAGE_SHADOWME_ID, 'hero_slider_shadowme_'.$i.'_eyeshadow_month', true),
          'eyeshadow_subtitle' => get_post_meta(PAGE_SHADOWME_ID, 'hero_slider_shadowme_'.$i.'_eyeshadow_subtitle', true),
          'eyeshadow_image' => wp_get_attachment_image_url(get_post_meta(PAGE_SHADOWME_ID, 'hero_slider_shadowme_'.$i.'_eyeshadow_image', true), 'full'),
        );
      endfor;
    endif; ?>

  <section class="intro intro-sm slider" id="intro-sm" style="background: none;">
    <div class="vertical-center">
      <div class="container">
        <div class="row">
          <div class="col-md-6 no-padding">
            <div class="new-slider-section">
              <div class="container-fluid no-padding">
                <div class="new_slider owl-carousel owl-theme">
                  <?php foreach($hero_slider as $key => $slider){ ?>
                    <div class="new_slider_info">
                      <?php if($slider['is_current_month'] == true){ ?>
                        <div class="current_month-sm">
                          <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/Current-Month-Marker-SM.svg"/>
                        </div>
                      <?php } ?>
                      <img src="<?php echo $slider['eyeshadow_image']; ?>" alt="">
                    </div>
                  <?php } ?>
                </div>
              </div>
            </div>
          </div>
          <div class="col-md-5 content">
            <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/SM-landing-page-shadowme-logo-copy.svg" alt="ShadowhMe" class="logo-intro-sm">
            <p class="title">Let your eyes do the talking!</p>
            <p class="description">Get 9-10 eyeshadows every other month for $19.99.<br/>Blend up a happier you!</p>
              <?php
              if (!rs_function_to_check_the_restriction_for_referral()){
                  LiveGlam_User_Level::show_block_referral_message_or_popup('sm');
              }
              ?>
              <?php echo do_shortcode('[referral_code_form product="shadowme"]');?>
            <div class="section-links">
              <a href="/pre-checkout?club=shadowme" class="btn-primary">Start Getting Palettes</a>
            </div>
          </div>
        </div>
      </div>
    </div>
    <script type="text/javascript">
      jQuery(document).ready(function () {
        var new_slider_owl = jQuery('.new_slider.owl-carousel');
        new_slider_owl.owlCarousel({
          autoplay: false,
          autoplayTimeout: 5000,
          autoplayHoverPause: true,
          smartSpeed: 750,
          items: 1,
          loop: false,
          nav: true,
          navText: ["<img src='<?php echo get_stylesheet_directory_uri(); ?>/assets/img/left_arrow.png' class='new_slider_nav nav-left'>",
            "<img src='<?php echo get_stylesheet_directory_uri(); ?>/assets/img/right_arrow.png' class='new_slider_nav nav-right'>"],
        });
      });
    </script>
  </section>

  <!-- Status -->
  <div class="status-bar brush-club">
    <div class="container show-desktop">
      <div class="row">
        <div class="col-md-4">
          <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/SM-landing-page-shape-1-1.png" class="status-shape">
          <p class="counter"><?php echo do_shortcode('[number_complete_order]'); ?></p>
          <div class="status-title">
            <p class="title-md">Products Shipped</p>
            <p class="title-sm">to LiveGlam Members last month</p>
          </div>
        </div>
        <div class="col-md-4">
          <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/SM-landing-page-shape-2-1.png" class="status-shape">
          <p class="counter">4.8</p>
          <div class="status-title">
            <p class="title-md">Stars out of 5</p>
            <p class="title-sm">on 350+ Facebook Reviews</p>
          </div>
        </div>
        <div class="col-md-4">
          <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/SM-landing-page-shape-3-1.png" class="status-shape">
          <p class="counter">98%</p>
          <div class="status-title">
            <p class="title-md">Positive Ratings</p>
            <p class="title-sm">on 190+ BBB customer reviews</p>
          </div>
        </div>
      </div>
    </div>
    <ul id="scroller" class="stats_slider owl-carousel owl-theme show-mobile">
      <li>
        <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/SM-landing-page-shape-1-1.png" class="status-shape">
        <p class="counter"><?php echo do_shortcode('[number_complete_order]'); ?></p>
        <div class="status-title">
          <p class="title-md">Products Shipped</p>
          <p class="title-sm">to LiveGlam Members last month</p>
        </div>
      </li>
      <li>
        <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/SM-landing-page-shape-2-1.png" class="status-shape">
        <p class="counter">4.8</p>
        <div class="status-title">
          <p class="title-md">Stars out of 5</p>
          <p class="title-sm">on 350+ Facebook Reviews</p>
        </div>
      </li>
      <li>
        <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/SM-landing-page-shape-3-1.png" class="status-shape">
        <p class="counter">98%</p>
        <div class="status-title">
          <p class="title-md">Positive Ratings</p>
          <p class="title-sm">on 190+ BBB customer reviews</p>
        </div>
      </li>
    </ul>
  </div>

  <!-- how works -->
  <section class="how-works text-center" id="how-works">
    <div class="vertical-center">
      <div class="container">
        <div class="row">
          <div class="col-md-6 text-left">
            <h2 class="section-title">How ShadowMe Works</h2>
            <p class="description first-decs">Calling all eyeshadow lovers! Get in on the action and see what beauty you can blend up with a new eyeshadow palette every other month!</p>
            <p class="method txt-light-pink2">You're in Control</p>
            <p class="description">Not feelin' your next palette? Trade it! Strapped for cash? Skip a payment! In eyeshadow overload? Cancel anytime. It’s that simple.</p>
            <p class="method txt-light-pink2">Shadows that Serve</p>
            <p class="description">You get more than just eyeshadow! Each month you receive a palette, you'll score Reward points to use on free makeup and goodies!</p>
          </div>
        </div>
      </div>
    </div>
    <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/how-shadowme-works-mb.jpg" class="show-mobile" style="margin: 0">
  </section>

  <!-- join club -->
  <section class="join-club shadow">
    <div class="vertical-center">
      <div class="container">
        <div class="row">
          <div class="col-md-5 offset-md-7">
            <h3 class="section-title">Shades for Days</h3>
            <p class="description">Your eyes will be smilin’ with 9-10 exclusive, buttery eyeshadows every 2 months. Step into the shade with highly-pigmented matte, shimmery, bold, and neutral colors.</p>
            <div class="section-links">
              <a href="/pre-checkout?club=shadowme" class="btn-primary">Don't Miss Our Next Shipment of Shadows</a>
            </div>
          </div>
        </div>
      </div>
    </div>
    <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/shadowme-bg7-mb.png" class="show-mobile" style="margin-top: 5vw">
  </section>

  <!-- why subscribe -->
  <section class="why-subscribe shadow">
    <div class="vertical-center">
      <div class="container">
        <div class="row">
          <div class="col-md-5">
            <h3 class="section-title">You Can Never Have Too Much Eyeshadow</h3>
            <p class="description">Have an eyeshadow for every occasion! Inspire your look and switch up your style with new palettes delivered right to you! Get quality without the compromise. You can skip months, trade your palette for other goodies, and cancel anytime! It's really that simple!</p>
            <div class="section-links">
              <a href="/pre-checkout?club=shadowme" class="btn-primary">Sign Up to Start Building Your Collection</a>
            </div>
          </div>
        </div>
      </div>
    </div>
      <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/SM-landing-page-why-subscribe4-mb.png" class="show-mobile">
  </section>


  <!-- tried and tested -->
  <section class="tried-and-tested">
    <div class="vertical-center">
      <div class="container">
        <div class="row">
          <div class="col-md-5 offset-md-7">
            <h3 class="section-title txt-black">Don’t Throw Shade at These Savings</h3>
            <p class="description">Keep your eyes on the prize with an affordable, high-quality palette every other month! Plus you get free shipping in the US and $5.99 shipping anywhere else in the world. Your palettes even come with Reward points to cash in on free makeup and other goodies!</p>
            <div class="section-links">
              <a href="/pre-checkout?club=shadowme" class="btn-primary">Explore Membership Options</a>
            </div>
          </div>
        </div>
      </div>
    </div>
    <img class="show-mobile" src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/SM-landing-page-tried3-mb.png">
  </section>

  <!-- section testimonials -->
  <?php if(!empty($all_testimonials = liveglam_get_all_testimonials_by_termid(array(629),8))): ?>
    <section class="testimonials new-testimonials">
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
        <div class="view-all-reveiews">
          <a href="<?php echo home_url('/reviews'); ?>" class="btn-secondary float-right">View All Reviews</a>
        </div>
      </div>
    </section>
  <?php endif; ?>
  <!-- end testimonial section -->

  <!-- section questions -->
  <?php if(!empty($faqs = lgs_get_faq_landing_page(PAGE_SHADOWME_ID))): ?>
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
    <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/sm-shipper-box.png">
    <div class="keep-the-shade">
      <p>KEEP THE SHADE ON YOUR CREASE</p>
      <h2>A More Beauty-full You Awaits.</h2>
      <a href="/pre-checkout?club=shadowme" class="btn-primary">Start Getting Palettes</a>
    </div>
  </section>

</div>

<?php get_footer(); ?>