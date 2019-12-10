<?php
  /**
   * Template Name: Pre Checkout page
   *
   * @package Liveglam
   */
  wc_nocache_headers();

  get_header();
  $option_cirle = '<svg class="option-selected" width="133px" height="133px" viewBox="0 0 133 133" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                <g class="check-group" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                  <circle class="ck-filled-circle" fill="#f05e7c" cx="66.5" cy="66.5" r="54.5"></circle>
                  <circle class="ck-white-circle" fill="#FFFFFF" cx="66.5" cy="66.5" r="55.5"></circle>
                  <circle class="ck-outline" stroke="#f05e7c" stroke-width="4" cx="66.5" cy="66.5" r="54.5"></circle>
                  <polyline class="ck-check" stroke="#FFFFFF" stroke-width="10" points="41 70 56 85 92 49"></polyline>
                </g>
              </svg>';
  $option_cirle_completed = '<svg class="option-selected" width="20px" height="20px" viewBox="0 0 133 133" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                <g class="check-group" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                  <circle class="ck-filled-circle" fill="#2d6573" cx="66.5" cy="66.5" r="54.5"></circle>
                  <circle class="ck-white-circle" fill="#FFFFFF" cx="66.5" cy="66.5" r="55.5"></circle>
                  <circle class="ck-outline" stroke="#2d6573" stroke-width="4" cx="66.5" cy="66.5" r="54.5"></circle>
                  <polyline class="ck-check" stroke="#FFFFFF" stroke-width="10" points="41 70 56 85 92 49"></polyline>
                </g>
              </svg>';

  $check_enable_multiple_product = '';
  $selected_club = (isset($_GET['club'])&&!empty($_GET['club']))?sanitize_text_field($_GET['club']):'';
  $selected_trade_km = $selected_trade_mm = $selected_trade_sm = '';
  if(in_array($selected_club, array('kissme','shadowme','morpheme'))){
    $selected_trade = (isset($_GET['trade']))?sanitize_text_field($_GET['trade']):'';
    if(is_numeric($selected_trade)){
      switch($selected_club){
        case 'kissme': $selected_trade_km = $selected_trade; break;
        case 'morpheme': $selected_trade_mm = $selected_trade; break;
        case 'shadowme': $selected_trade_sm = $selected_trade; break;
      }
    }
  } else {
    $selected_club = '';
  }

  $faqs = lgs_get_faqs();

  $class_club_mm = $class_club_km = $class_club_sm = '';
  if(is_user_logged_in()){
    $status_array = array('active', 'waitlist', 'on-hold', 'pause');
    $subscriptions_status = LiveGlam_Subscription_Status::get_status();

    if(in_array($subscriptions_status['get_status_morpheme'], $status_array)){
      $class_club_mm = 'disabled active-club';
    }
    if(in_array($subscriptions_status['get_status_kissme'], $status_array)){
      $class_club_km = 'disabled active-club';
    }
    if(in_array($subscriptions_status['get_status_shadowme'], $status_array)){
      $class_club_sm = 'disabled active-club';
    }
  }

  $home_page_id = get_option('page_on_front');
  $current_time = current_time('timestamp');
  $kissme_club_image = '<img src="'.get_stylesheet_directory_uri().'/assets/img/pre-checkout-lippies-default.png" alt="KissMe Image">';
  $morpheme_club_image = '<img src="'.get_stylesheet_directory_uri().'/assets/img/pre-checkout-brushes.png" alt="MorpheMe Image">';
  $shadowme_club_image = '<img src="'.get_stylesheet_directory_uri().'/assets/img/pre-checkout-makeup.png" alt="ShadowMe Image">';

  $kissme_club = get_field('kissme_club', $home_page_id);
  if(!empty($kissme_club['club_image'])){
    foreach($kissme_club['club_image'] as $club_image){
      if( empty($club_image['start_displaying_it_on']) || $current_time >= strtotime($club_image['start_displaying_it_on'])){
        $kissme_club_image = !empty($club_image['image_to_show']) ? wp_get_attachment_image($club_image['image_to_show'], 'medium') : $kissme_club_image;
      }
    }
  }
  $morpheme_club = get_field('morpheme_club', $home_page_id);
  if(!empty($morpheme_club['club_image'])){
    $img_url = '';
    foreach($morpheme_club['club_image'] as $club_image){
      if( empty($club_image['start_displaying_it_on']) || $current_time >= strtotime($club_image['start_displaying_it_on'])){
        $morpheme_club_image = !empty($club_image['image_to_show']) ? wp_get_attachment_image($club_image['image_to_show'], 'medium') : $morpheme_club_image;
      }
    }
  }
  $shadowme_club = get_field('shadowme_club', $home_page_id);
  if(!empty($shadowme_club['club_image'])){
    $img_url = '';
    foreach($shadowme_club['club_image'] as $club_image){
      if( empty($club_image['start_displaying_it_on']) || $current_time >= strtotime($club_image['start_displaying_it_on'])){
        $shadowme_club_image = !empty($club_image['image_to_show']) ? wp_get_attachment_image($club_image['image_to_show'], 'medium') : $shadowme_club_image;
      }
    }
  }

  $show_sale = false;
  if(!empty(get_option('options_ldmpt_show_new_design_preck'))){
    $show_sale = true;
  }

?>

<section class="liveglam-join-now-new woocommerce" id="liveglam_join_now_new">

  <?php LGS_PRECHECKOUT_SETTING::lgs_preck_maybe_show_notice(); ?>

  <div class="new-step-bar">
    <div class="container">
      <div class="steps-process-list">
      <div class="steps-process main-step-1 current" data-step="1"><?php echo $option_cirle_completed; ?>
        <span class="step-number"></span><span class="hide-mobile">Choose Your Club</span><span class="show-mobile">Clubs</span>
      </div>
      <div class="steps-process main-step-2 d-none" data-step="2"><?php echo $option_cirle_completed; ?>
        <span class="step-number"></span><span class="hide-mobile">See Collections</span><span class="show-mobile">Collections</span>
      </div>
      <div class="steps-process main-step-3" data-step="3"><?php echo $option_cirle_completed; ?>
        <span class="step-number"></span><span class="hide-mobile">Choose Plan</span><span class="show-mobile">Plans</span>
      </div>
      <div class="steps-process main-step-4 d-none" data-step="4"><?php echo $option_cirle_completed; ?>
        <span class="step-number"></span><span>Gift</span>
      </div>
      <div class="steps-process main-step-5 last-step" data-step="5"><?php echo $option_cirle_completed; ?>
        <span class="step-number"></span><span>Checkout</span>
      </div>
      </div>
    </div>
  </div>

  <div class="step-details step1">
    <div class="container" style="z-index: 2; position: relative;">
      <p class="title-new hide-mobile">Let's make you even more beautiful!</p>
      <p class="subtitle-new" data-title="Choose Your Club!">Choose Your Club!</p>

      <div class="lg-step-content">
        <ul class="product-types-new select-club">
          <li class="select-club-content text-center club-morpheme <?php echo $class_club_mm; ?>" data-select="morpheme" data-title="Nice choice! You're going to brushin' love these.">
            <?php echo $option_cirle; ?>
            <label class="d-none" for="club-type-morpheme">
              <input id="club-type-morpheme" type="radio" class="d-none club-type" name="club-type" value="morpheme">
            Club MorpheMe</label>
            <div class="joinbox-content">
              <div class="joinbox-body">
                <div class="rounded-box">
                  <img class="rounded-box-img" src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/logo-dashboard-mm.svg" alt="MorpheMe logo" />
                  <div class="rounded-box-content">
                    <?php echo $morpheme_club_image; ?>
                    <div class="join-desc show-mobile">
                      <h3 class="product-title">Brushes</h3>
                      <p class="txt-xs">Every month</p>
                    </div>
                  </div>
                </div>
                <div class="join-desc hide-mobile">
                  <h3 class="product-title">Brushes</h3>
                  <p class="txt-xs">Every month</p>
                </div>
              </div>
            </div>
          </li>

          <li class="select-club-content text-center club-kissme <?php echo $class_club_km; ?>" data-select="kissme" data-title="Great choice! You're going to fall in love with this formula.">
            <?php echo $option_cirle; ?>
            <label class="d-none" for="club-type-kissme">
              <input id="club-type-kissme" type="radio" class="d-none club-type" name="club-type" value="kissme">
            Club KissMe</label>
            <div class="joinbox-content">
              <div class="joinbox-body">
                <div class="rounded-box">
                  <img class="rounded-box-img" src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/logo-dashboard-km.svg" alt="KissMe logo" />
                  <div class="rounded-box-content">
                    <?php echo $kissme_club_image; ?>
                    <div class="join-desc show-mobile">
                      <h3 class="product-title">Lippies</h3>
                      <p class="txt-xs">Every month</p>
                    </div>
                  </div>
                </div>
                <div class="join-desc hide-mobile">
                  <h3 class="product-title">Lippies</h3>
                  <p class="txt-xs">Every month</p>
                </div>
              </div>
            </div>
          </li>

          <li class="select-club-content text-center club-shadowme <?php echo $class_club_sm; ?>" data-select="shadowme" data-title="Nice choice! You're going to have shades for days.">
            <?php echo $option_cirle; ?>
            <label class="d-none" for="club-type-shadowme">
              <input id="club-type-shadowme" type="radio" class="d-none club-type" name="club-type" value="shadowme">
            Club ShadowMe</label>
            <div class="joinbox-content">
              <div class="joinbox-body">
                <div class="rounded-box">
                  <img class="rounded-box-img" src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/logo-dashboard-sm.svg" alt="ShadowMe logo" />
                  <div class="rounded-box-content">
                    <?php echo $shadowme_club_image; ?>
                    <div class="join-desc show-mobile">
                      <h3 class="product-title">Eyeshadows</h3>
                      <p class="txt-xs">Every other month</p>
                    </div>
                  </div>
                </div>
                <div class="join-desc hide-mobile">
                  <h3 class="product-title">Eyeshadows</h3>
                  <p class="txt-xs">Every other month</p>
                </div>
              </div>
            </div>
          </li>
        </ul>
      </div>
    </div>


    <?php //@todo: remove code after sale aug 2019
    if( $show_sale ){ ?>
      <div class="lgs-2019pre-2019 sale-precheckout">
        <style>
          .lgs-2019pre-2019 {
            position: relative;
            background: url(<?php echo get_stylesheet_directory_uri(); ?>/assets/img/ldmbf-sale-pre-left.png), url(<?php echo get_stylesheet_directory_uri(); ?>/assets/img/ldmbf-sale-pre-right.png), url(<?php echo get_stylesheet_directory_uri(); ?>/assets/img/ldmbf-sale-pre-bg.png), linear-gradient(135deg, #FFA7B9 0%, #212121 100%);
            background-size: auto 100%, auto 100%, 100% 100%;
            background-position: left center, right center, center center;
            background-repeat: no-repeat;
            margin-top: -10rem;
            z-index: 1;
            padding-top: 11rem;
            padding-bottom: 2rem;
          }
          .lgs-2019pre-2019 .lgs-2019pre-2019-content {
            width: 90%;
            margin: 0 auto 0 0;
            position: relative;
            overflow: hidden;
            display: flex;
            align-items: center;
            flex-wrap: wrap;
          }
          .lgs-2019pre-2019 .lgs-2019pre-2019-content .lgs-2019pre-2019-left {
            width: 45%;
          }
          .lgs-2019pre-2019 .lgs-2019pre-2019-content .lgs-2019pre-2019-right {
            width: 55%;
          }
          .lgs-2019pre-2019 .lgs-2019pre-2019-content .sale-2019pre-desc {
            margin: 0 auto 1rem;
            font-size: 2rem;
            line-height: 3rem;
            color: #fff;
          }
          .lgs-2019pre-2019 .lgs-2019pre-2019-content .sale-2019pre-time {
            color: #fff;
            font-size: 1.05rem;
            margin: 0 auto;
          }
          @media only screen and (max-width: 1199.9px) {
            .lgs-2019pre-2019 .lgs-2019pre-2019-content .sale-2019pre-desc {
              margin: 0 auto .75vw;
              font-size: 1.6vw;
              line-height: 2.3vw;
            }

            .lgs-2019pre-2019 .lgs-2019pre-2019-content .sale-2019pre-time {
              font-size: .85vw;
            }
            .lgs-2019pre-2019 {
              margin-top: -8vw;
              padding-top: 9vw;
            }
          }
          @media only screen and (max-width: 767.9px) {
            .lgs-2019pre-2019 {
              margin: 5vw auto 0;
              padding: 7.5vw 0 5vw;
              background: url(<?php echo get_stylesheet_directory_uri(); ?>/assets/img/ldmbf-sale-pre-bg.png), linear-gradient(135deg, #FFA7B9 0%, #212121 100%);
              background-size: auto 100%;
              background-repeat: no-repeat;
            }
            .lgs-2019pre-2019 .lgs-2019pre-2019-content {
              width: 100%;
              margin: 0 auto;
            }
            .lgs-2019pre-2019 .lgs-2019pre-2019-content .lgs-2019pre-2019-left,
            .lgs-2019pre-2019 .lgs-2019pre-2019-content .lgs-2019pre-2019-right {
              width: 100%;
            }
            .lgs-2019pre-2019 .lgs-2019pre-2019-content .sale-2019pre-desc {
              margin: 5vw auto 3vw;
              font-size: 4.25vw;
              line-height: 6.5vw !important;
            }
            .lgs-2019pre-2019 .lgs-2019pre-2019-content .sale-2019pre-time {
              font-size: 2.5vw;
            }
          }
        </style>
        <div class="container">
          <div class="lgs-2019pre-2019-content">
            <div class="lgs-2019pre-2019-left">
              <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/ldmbf-sale-logo1.png" alt="BFCM logo" />
            </div>
            <div class="lgs-2019pre-2019-right">
              <?php if(isset($_COOKIE['_lgs_save_name_ref']) && LGS_CUSTOM_FP::lgs_gaga_km_2galgal($_COOKIE['_lgs_save_name_ref']) ){ ?>
                <p class="sale-2019pre-desc">Yay! You unlocked our Black Friday<br>deal and you're getting <strong>TWO free<br>products</strong> when you join!</p>
              <?php } else { ?>
                <p class="sale-2019pre-desc">Treat yourself to more than leftovers!<br>Join any LiveGlam Club and get <strong>2 free<br>products</strong> with your first package!</p>
                <p class="sale-2019pre-time">Participating code required. Available NOW to 12/3 11:59 pm PST</p>
              <?php } ?>
            </div>
          </div>
        </div>
      </div>
    <?php } ?>

    <div class="container">
      <div class="lg-refcode">
        <div class="lg-ref-field">
          <?php echo do_shortcode("[liveglam_join_now_code_form_new]"); ?>
        </div>
      </div>
    </div>


    <div class="container">
      <div class="shadow-layout">
        <a href="#" class="btn-proceed next-step"><button class="club-cta btn-primary">Next</button></a>
      </div>

      <div class="lg-notice-select lg-notice-select-club">
            <p>Choose a club above to continue.</p>
      </div>

    </div>
  </div>

  <div class="step-details step2 d-none">
    <div class="container">
      <p class="title-new hide-mobile">Let's customize your first package!</p>
      <p class="subtitle-new" data-title="Choose Your First Collection!">Choose Your First Collection!</p>
      <div class="lg-step-content">
        <div class="lg-trade-collections" id="lg-trade-collections">
          <div class="lg-trade-content">
            <div class="lg-trade-body">
              <div class="first-trade trade-morpheme"></div>
              <div class="first-trade trade-kissme d-none"></div>
              <div class="first-trade trade-shadowme d-none"></div>
            </div>
          </div>
        </div>
      </div>
      <div class="shadow-layout">
        <a href="#" class="btn-proceed next-step"><button class="club-cta btn-primary">Next</button></a>
      </div>
      <div class="lg-notice-select lg-notice-select-collection">
        <p>Select a collection above to continue.</p>
      </div>
    </div>
  </div>

  <div class="step-details step3 d-none">
    <div class="container">
      <p class="title-new hide-mobile">Let's customize your first package!</p>
      <p class="subtitle-new">Choose Your Plan!</p>
      <div class="lg-step-content">
        <div class="choose-club-plan choose-morpheme">
          <p class="subtitle-desc plan-waitlist plan-waitlist-morpheme plan-waitlist-disable d-none" style="display: none;">Yeah! You chose a past collection so you're skipping the waitlist!</p>
          <p class="subtitle-desc plan-waitlist plan-waitlist-morpheme plan-waitlist-upgrade d-none" style="display: none;"><?php echo LGS_CHECKOUT_SETTING::lgs_waitlist_get_subtitle_select_plan('morpheme'); ?></p>
          <ul class="product-types-new">
            <li class="club-plan monthly-plan" data-select="morpheme" data-product="<?php echo MM_MONTHLY; ?>">
              <?php echo $option_cirle; ?>
              <div class="plan">
                <div class="plan-header">
                  <p class="plan-title">MONTHLY</p>
                </div>
                <div class="plan-footer">
                  <div class="plan-footer-content hide-mobile">
                    <p class="plan-data plan-price"><span class="dollar">$</span>19.99</p>
                    <p class="plan-data plan-period">per month</p>
                    <p class="plan-data plan-free"></p>
                    <hr>
                    <p class="plan-data plan-list">$30+ in Morphe Brushes</p>
                    <p class="plan-data plan-list">Cancel anytime</p>
                  </div>
                  <div class="plan-footer-content show-mobile">
                    <p class="plan-data plan-price"><span class="dollar">$</span>19<span class="decimal">.99</span><span class="period">per month</span></p>
                    <p class="plan-data plan-list">$30+ in Morphe Brushes, Cancel anytime, Pay as you go</p>
                  </div>
                  <p class="plan-data plan-list plan-waitlist plan-waitlist-morpheme plan-waitlist-enable" style="display: none">We're in waitlist!</p>
                  </div>
              </div>
            </li>
            <li class="club-plan sixmonth-plan" data-select="morpheme" data-product="<?php echo MM_SIXMONTH; ?>">
              <?php echo $option_cirle; ?>
              <div class="plan">
                <div class="plan-header">
                  <p class="plan-title">6 MONTHS<span class="free-title show-mobile">Save $10!</span></p>
                </div>
                <div class="plan-footer">
                  <div class="plan-footer-content hide-mobile">
                    <p class="plan-data plan-price"><span class="dollar">$</span>109.99</p>
                    <p class="plan-data plan-period">every 6 months</p>
                    <p class="plan-data plan-free">Save $10!</p>
                    <hr class="hide-mobile">
                    <p class="plan-data plan-list">$180+ in Morphe Brushes</p>
                    <p class="plan-data plan-list">$25+ in Free Beauty Products</p>
                  </div>
                  <div class="plan-footer-content show-mobile">
                    <p class="plan-data plan-price"><span class="dollar">$</span>109<span class="decimal">.99</span><span class="period">pay every 6 months</span></p>
                    <p class="plan-data plan-list">$180+ in Morphe Brushes, $25+ in Free Beauty Products</p>
                  </div>
                  <p class="plan-data plan-list plan-waitlist plan-waitlist-morpheme plan-waitlist-enable plan-upgrade" style="display: none">Skip the waitlist by upgrading to a 6 months subscription</p>
                  <p class="plan-data plan-list plan-waitlist plan-waitlist-morpheme plan-waitlist-enable plan-noupgrade" style="display: none">We're in waitlist!</p>
                </div>
              </div>
            </li>
            <li class="club-plan annual-plan" data-select="morpheme" data-product="<?php echo MM_ANNUAL; ?>">
              <div class="plan-badge hide-mobile"><div class="badge-content"><span>BEST DEAL!</span></div></div>
              <?php echo $option_cirle; ?>
              <div class="plan">
                <div class="plan-header">
                  <p class="plan-title">ANNUAL<span class="free-title show-mobile">1 month free!</span></p>
                </div>
                <div class="plan-footer">
                  <div class="plan-footer-content hide-mobile">
                    <p class="plan-data plan-price"><span class="dollar">$</span>219.99</p>
                    <p class="plan-data plan-period">every 12 months</p>
                    <p class="plan-data plan-free">1 month free!</p>
                    <hr class="hide-mobile">
                    <p class="plan-data plan-list">$360+ in Morphe Brushes</p>
                    <p class="plan-data plan-list">$50+ in Free Beauty Products</p>
                  </div>
                  <div class="plan-footer-content show-mobile">
                    <p class="plan-data plan-price"><span class="dollar">$</span>219<span class="decimal">.99</span><span class="period">pay every 12 months</span></p>
                    <p class="plan-data plan-list">$360+ in Morphe Brushes, $50+ in Free Beauty Products</p>
                  </div>
                  <p class="plan-data plan-list plan-waitlist plan-waitlist-morpheme plan-waitlist-enable plan-upgrade" style="display: none">Skip the waitlist by upgrading to an annual subscription</p>
                  <p class="plan-data plan-list plan-waitlist plan-waitlist-morpheme plan-waitlist-enable plan-noupgrade" style="display: none">We're in waitlist!</p>
                </div>
              </div>
            </li>
          </ul>
        </div>

        <div class="choose-club-plan choose-kissme d-none">
          <p class="subtitle-desc plan-waitlist plan-waitlist-kissme plan-waitlist-disable d-none" style="display: none;">Yeah! You chose a past collection so you're skipping the waitlist!</p>
          <p class="subtitle-desc plan-waitlist plan-waitlist-kissme plan-waitlist-upgrade d-none" style="display: none;"><?php echo LGS_CHECKOUT_SETTING::lgs_waitlist_get_subtitle_select_plan('kissme'); ?></p>
          <ul class="product-types-new">
            <li class="club-plan monthly-plan" data-select="kissme" data-product="<?php echo KM_MONTHLY; ?>">
              <?php echo $option_cirle; ?>
              <div class="plan">
                <div class="plan-header">
                  <p class="plan-title">MONTHLY</p>
                </div>
                <div class="plan-footer">
                  <div class="plan-footer-content hide-mobile">
                    <p class="plan-data plan-price"><span class="dollar">$</span>19.99</p>
                    <p class="plan-data plan-period">per month</p>
                    <p class="plan-data plan-free"></p>
                    <hr class="hide-mobile">
                    <p class="plan-data plan-list">3 KissMe Lippies</p>
                    <p class="plan-data plan-list">Cancel anytime</p>
                    <p class="plan-data plan-list">Pay as you go</p>
                  </div>
                  <div class="plan-footer-content show-mobile">
                    <p class="plan-data plan-price"><span class="dollar">$</span>19<span class="decimal">.99</span><span class="period">per month</span></p>
                    <p class="plan-data plan-list">3 KissMe Lippies, Cancel anytime</p>
                  </div>
                  <p class="plan-data plan-list plan-waitlist plan-waitlist-kissme plan-waitlist-enable" style="display: none;">We're in waitlist!</p>
                </div>
              </div>
            </li>
            <li class="club-plan sixmonth-plan" data-select="kissme" data-product="<?php echo KM_SIXMONTH; ?>">
              <?php echo $option_cirle; ?>
              <div class="plan">
                <div class="plan-header">
                  <p class="plan-title">6 MONTHS<span class="free-title show-mobile">Save $10!</span></p>
                </div>
                <div class="plan-footer">
                  <div class="plan-footer-content hide-mobile">
                    <p class="plan-data plan-price"><span class="dollar">$</span>109.99</p>
                    <p class="plan-data plan-period"></p>
                    <p class="plan-data plan-free">Save $10!</p>
                    <hr class="hide-mobile">
                    <p class="plan-data plan-list">18 KissMe Lippies</p>
                    <p class="plan-data plan-list">$25+ in Free Beauty Products</p>
                    <p class="plan-data plan-list">Pay every 6 months</p>
                  </div>
                  <div class="plan-footer-content show-mobile">
                    <p class="plan-data plan-price"><span class="dollar">$</span>109<span class="decimal">.99</span><span class="period">pay every 6 months</span></p>
                    <p class="plan-data plan-list">18 KissMe Lippies, $25+ in Free Beauty Products</p>
                  </div>
                  <p class="plan-data plan-list plan-waitlist plan-waitlist-kissme plan-waitlist-enable plan-upgrade" style="display: none;">Skip the waitlist by upgrading to a 6 months subscription</p>
                  <p class="plan-data plan-list plan-waitlist plan-waitlist-kissme plan-waitlist-enable plan-noupgrade" style="display: none;">We're in waitlist!</p>
                </div>
              </div>
            </li>
            <li class="club-plan annual-plan" data-select="kissme" data-product="<?php echo KM_ANNUAL; ?>">
              <div class="plan-badge hide-mobile"><div class="badge-content"><span>BEST DEAL!</span></div></div>
              <?php echo $option_cirle; ?>
              <div class="plan">
                <div class="plan-header">
                  <p class="plan-title">ANNUAL<span class="free-title show-mobile">1 month free!</span></p>
                </div>
                <div class="plan-footer">
                  <div class="plan-footer-content hide-mobile">
                    <p class="plan-data plan-price"><span class="dollar">$</span>219.99</p>
                    <p class="plan-data plan-period"></p>
                    <p class="plan-data plan-free">1 month free!</p>
                    <hr class="hide-mobile">
                    <p class="plan-data plan-list">36 KissMe Lippies</p>
                    <p class="plan-data plan-list">$50+ in Free Beauty Products</p>
                    <p class="plan-data plan-list">Pay every 12 months</p>
                  </div>
                  <div class="plan-footer-content show-mobile">
                    <p class="plan-data plan-price show-mobie"><span class="dollar">$</span>219<span class="decimal">.99</span><span class="period">pay every 12 months</span></p>
                    <p class="plan-data plan-list">36 KissMe Lippies, $50+ in Free Beauty Products</p>
                  </div>
                  <p class="plan-data plan-list plan-waitlist plan-waitlist-kissme plan-waitlist-enable plan-upgrade" style="display: none;">Skip the waitlist by upgrading to an annual subscription</p>
                  <p class="plan-data plan-list plan-waitlist plan-waitlist-kissme plan-waitlist-enable plan-noupgrade" style="display: none;">We're in waitlist!</p>
                </div>
              </div>
            </li>
          </ul>
        </div>

        <div class="choose-club-plan choose-shadowme d-none">
          <p class="subtitle-desc plan-waitlist plan-waitlist-shadowme plan-waitlist-disable d-none" style="display: none;">Yeah! You chose a past collection so you're skipping the waitlist!</p>
          <p class="subtitle-desc plan-waitlist plan-waitlist-shadowme plan-waitlist-upgrade d-none" style="display: none;"><?php echo LGS_CHECKOUT_SETTING::lgs_waitlist_get_subtitle_select_plan('shadowme'); ?></p>
          <ul class="product-types-new">
            <li class="club-plan monthly-plan" data-select="shadowme" data-product="<?php echo SM_MONTHLY; ?>">
              <?php echo $option_cirle; ?>
              <div class="plan">
                <div class="plan-header">
                  <p class="plan-title">BI-MONTHLY</p>
                </div>
                <div class="plan-footer">
                  <div class="plan-footer-content hide-mobile">
                    <p class="plan-data plan-price"><span class="dollar">$</span>19.99</p>
                    <p class="plan-data plan-period">per every 2 months</p>
                    <p class="plan-data plan-free"></p>
                    <hr class="hide-mobile">
                    <p class="plan-data plan-list">1 ShadowMe Palette</p>
                    <p class="plan-data plan-list">Cancel anytime</p>
                    <p class="plan-data plan-list">Pay as you go</p>
                  </div>
                  <div class="plan-footer-content show-mobile">
                    <p class="plan-data plan-price"><span class="dollar">$</span>19<span class="decimal">.99</span><span class="period">pay every 2 months</span></p>
                    <p class="plan-data plan-list">1 ShadowMe Palette, Cancel anytime</p>
                  </div>
                  <p class="plan-data plan-list plan-waitlist plan-waitlist-shadowme plan-waitlist-enable" style="display: none;">We're in waitlist!</p>
                </div>
              </div>
            </li>
            <li class="club-plan sixmonth-plan" data-select="shadowme" data-product="<?php echo SM_SIXMONTH; ?>">
              <?php echo $option_cirle; ?>
              <div class="plan">
                <div class="plan-header">
                  <p class="plan-title">6 MONTHS<span class="free-title show-mobile">Save $5!</span></p>
                </div>
                <div class="plan-footer">
                  <div class="plan-footer-content hide-mobile">
                    <p class="plan-data plan-price"><span class="dollar">$</span>54.99</p>
                    <p class="plan-data plan-period"></p>
                    <p class="plan-data plan-free">Save $5!</p>
                    <hr class="hide-mobile">
                    <p class="plan-data plan-list">3 ShadowMe Palettes</p>
                    <p class="plan-data plan-list">$25+ in Free Beauty Products</p>
                    <p class="plan-data plan-list">Earn free beauty products!</p>
                  </div>
                  <div class="plan-footer-content show-mobile">
                    <p class="plan-data plan-price"><span class="dollar">$</span>54<span class="decimal">.99</span><span class="period">pay every 6 months</span></p>
                    <p class="plan-data plan-list">3 ShadowMe Palettes, $25+ in Free Beauty Products, Earn free beauty products!</p>
                  </div>
                  <p class="plan-data plan-list plan-waitlist plan-waitlist-shadowme plan-waitlist-enable plan-upgrade" style="display: none;">Skip the waitlist by upgrading to a 6 months subscription</p>
                  <p class="plan-data plan-list plan-waitlist plan-waitlist-shadowme plan-waitlist-enable plan-noupgrade" style="display: none;">We're in waitlist!</p>
                </div>
              </div>
            </li>
            <li class="club-plan annual-plan" data-select="shadowme" data-product="<?php echo SM_ANNUAL; ?>">
              <div class="plan-badge hide-mobile"><div class="badge-content"><span>BEST DEAL!</span></div></div>
              <?php echo $option_cirle; ?>
              <div class="plan">
                <div class="plan-header">
                  <p class="plan-title">ANNUAL<span class="free-title show-mobile">Save $10!</span></p>
                </div>
                <div class="plan-footer">
                  <div class="plan-footer-content hide-mobile">
                    <p class="plan-data plan-price"><span class="dollar">$</span>109.99</p>
                    <p class="plan-data plan-period"></p>
                    <p class="plan-data plan-free">Save $10!</p>
                    <hr class="hide-mobile">
                    <p class="plan-data plan-list">6 ShadowMe Palettes</p>
                    <p class="plan-data plan-list">$50+ in Free Beauty Products</p>
                    <p class="plan-data plan-list">Earn free beauty products!</p>
                  </div>
                  <div class="plan-footer-content show-mobile">
                    <p class="plan-data plan-price"><span class="dollar">$</span>109<span class="decimal">.99</span><span class="period">pay every 12 months</span></p>
                    <p class="plan-data plan-list">6 ShadowMe Palettes, $50+ in Free Beauty Products, Earn free beauty products!</p>
                  </div>
                  <p class="plan-data plan-list plan-waitlist plan-waitlist-shadowme plan-waitlist-enable plan-upgrade" style="display: none;">Skip the waitlist by upgrading to an annual subscription</p>
                  <p class="plan-data plan-list plan-waitlist plan-waitlist-shadowme plan-waitlist-enable plan-noupgrade" style="display: none;">We're in waitlist!</p>
                </div>
              </div>
            </li>
          </ul>
        </div>
      </div>
      <div class="shadow-layout">
        <a href="#" class="btn-proceed last-step"><button class="club-cta btn-primary">Next</button></a>
      </div>
      <div class="lg-notice-select lg-notice-select-plan">
        <p>Select a plan above to continue.</p>
      </div>
    </div>
  </div>

  <div class="step-details step4 d-none">
    <div class="container">
      <div class="lg-step-content">
        <div class="gift-box-morpheme free-gift-box d-none" data-select="morpheme">
          <div class="gift-box">
            <div class="choose-gift">
              <input type="hidden" class="choose-total-gift-morpheme" value="0">
            </div>
          </div>
        </div>
        <div class="gift-box-kissme free-gift-box d-none" data-select="kissme">
          <div class="gift-box">
            <div class="choose-gift">
              <input type="hidden" class="choose-total-gift-kissme" value="0">
            </div>
          </div>
        </div>
        <div class="gift-box-shadowme free-gift-box d-none" data-select="shadowme">
          <div class="gift-box">
            <div class="choose-gift">
              <input type="hidden" class="choose-total-gift-shadowme" value="0">
            </div>
          </div>
        </div>
      </div>
      <div class="shadow-layout">
        <a href="#" class="btn-proceed last-step"><button class="club-cta btn-primary">Confirm Free Gift</button></a>
      </div>
      <div class="lg-notice-select lg-notice-select-gift choose-morpheme d-none">
        <p class="gift-1">Please select your free brushes.</p>
        <p class="gift-2 d-none">Please select 1 more free lippie.</p>
      </div>
      <div class="lg-notice-select lg-notice-select-gift choose-kissme d-none">
        <p class="gift-1">Please select your free lippies.</p>
        <p class="gift-2 d-none">Please select 1 more free lippie.</p>
      </div>
      <div class="lg-notice-select lg-notice-select-gift choose-shadowme d-none">
        <p class="gift-1">Please select your free lippies.</p>
        <p class="gift-2 d-none">Please select 1 more free lippie.</p>
      </div>
    </div>
  </div>

  <input type="hidden" name="lgs-preck-select-club" value="" />
  <input type="hidden" name="lgs-gaga-available-morpheme" value="0" />
  <input type="hidden" name="lgs-gaga-available-kissme" value="0" />
  <input type="hidden" name="lgs-gaga-available-shadowme" value="0" />
  <input type="hidden" name="lgs-collection-available-morpheme" value="0" />
  <input type="hidden" name="lgs-collection-available-kissme" value="0" />
  <input type="hidden" name="lgs-collection-available-shadowme" value="0" />
  <input type="hidden" name="lgs-default-trade-morpheme" value="0" />
  <input type="hidden" name="lgs-default-trade-kissme" value="0" />
  <input type="hidden" name="lgs-default-trade-shadowme" value="0" />
  <input type="hidden" name="lgs-morpheme-waitlist" value="0" />
  <input type="hidden" name="lgs-kissme-waitlist" value="0" />
  <input type="hidden" name="lgs-shadowme-waitlist" value="0" />
  <input type="hidden" name="lgs-morpheme-waitlist-upgrade" value="0" />
  <input type="hidden" name="lgs-kissme-waitlist-upgrade" value="0" />
  <input type="hidden" name="lgs-shadowme-waitlist-upgrade" value="0" />
  <input type="hidden" name="lgs-auto-select-collection-morpheme" value="<?php echo LGS_CHECKOUT_SETTING::lgs_precheckout_enable_auto_select_collection('morpheme')?1:0; ?>" />
  <input type="hidden" name="lgs-auto-select-collection-kissme" value="<?php echo LGS_CHECKOUT_SETTING::lgs_precheckout_enable_auto_select_collection('kissme')?1:0; ?>" />
  <input type="hidden" name="lgs-auto-select-collection-shadowme" value="<?php echo LGS_CHECKOUT_SETTING::lgs_precheckout_enable_auto_select_collection('shadowme')?1:0; ?>" />
  <input type="hidden" id="lg-enabled-multiple" value="<?php echo !empty($check_enable_multiple_product) && $check_enable_multiple_product == 'yes'?'1':''; ?>">

  <!--maybe have trade on url -->
  <input type="hidden" class="selected-trade morpheme" value="<?php echo $selected_trade_mm; ?>" />
  <input type="hidden" class="selected-trade kissme" value="<?php echo $selected_trade_km; ?>" />
  <input type="hidden" class="selected-trade shadowme" value="<?php echo $selected_trade_sm; ?>" />
  <!--@todo: remove key lgs-data-old-gift after LDM sale-->
  <input type="hidden" name="lgs-data-old-gift" value="0" />
</section>

<div class="pre-checkout-faq">
  <div class="container">
    <p class="frequently-title frequently-action faq-open">
      Frequently Asked Questions
      <img class="img-up" alt="" src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/arrow-black-up.png" />
      <img class="img-down" alt="" src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/arrow-black-down.png" />
    </p>
  <?php if(!empty($faqs) && !empty($faqs['general'])) : ?>
    <div class="frequently-questions general">
      <div class="row requently-collapse" style="display: none;">
        <?php $faq_col1 = 1;
          $faq_col2 = 0;
          $faq_num_per_col = count($faqs['general']) / 2;
          for($faq_col1; $faq_col1 <= 2; $faq_col1++){ ?>
            <div class="col-md-6">
              <div class="panel-group" id="accordion<?php echo $faq_col1; ?>general">
                <?php for($faq_col2; $faq_col2 < $faq_col1 * $faq_num_per_col; $faq_col2++){
                  $faq = $faqs['general'][$faq_col2]; ?>
                  <div class="card">
                    <div class="card-header">
                      <h4 class="card-title">
                        <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion<?php echo $faq_col1; ?>general" href="#panel<?php echo $faq_col2; ?>general"><span class="panel-icon panel-open-icon">+</span><span><?php echo $faq->post_title; ?></span></a>
                      </h4>
                    </div>
                    <div id="panel<?php echo $faq_col2; ?>general" class="panel-collapse collapse">
                      <div class="card-body"><?php echo wpautop($faq->post_content); ?></div>
                    </div>
                  </div>
                <?php } ?>

              </div>
            </div>
          <?php } ?>
      </div>
    </div>
  <?php endif; ?>
  <?php if(!empty($faqs) && !empty($faqs['kissme'])) : ?>
    <div class="frequently-questions kissme d-none">
      <div class="row requently-collapse" style="display: none;">
        <?php $faq_col1 = 1;
          $faq_col2 = 0;
          $faq_num_per_col = count($faqs['kissme']) / 2;
          for($faq_col1; $faq_col1 <= 2; $faq_col1++){ ?>
            <div class="col-md-6">
              <div class="panel-group" id="accordion<?php echo $faq_col1; ?>kissme">
                <?php for($faq_col2; $faq_col2 < $faq_col1 * $faq_num_per_col; $faq_col2++){
                  $faq = $faqs['kissme'][$faq_col2]; ?>
                  <div class="card">
                    <div class="card-header">
                      <h4 class="card-title">
                        <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion<?php echo $faq_col1; ?>kissme" href="#panel<?php echo $faq_col2; ?>kissme"><span class="panel-icon panel-open-icon">+</span><span><?php echo $faq->post_title; ?></span></a>
                      </h4>
                    </div>
                    <div id="panel<?php echo $faq_col2; ?>kissme" class="panel-collapse collapse">
                      <div class="card-body"><?php echo wpautop($faq->post_content); ?></div>
                    </div>
                  </div>
                <?php } ?>

              </div>
            </div>
          <?php } ?>
      </div>
    </div>
  <?php endif; ?>
  <?php if(!empty($faqs) && !empty($faqs['morpheme'])) : ?>
    <div class="frequently-questions morpheme d-none">
      <div class="row requently-collapse" style="display: none;">
        <?php $faq_col1 = 1;
          $faq_col2 = 0;
          $faq_num_per_col = count($faqs['morpheme']) / 2;
          for($faq_col1; $faq_col1 <= 2; $faq_col1++){ ?>
            <div class="col-md-6">
              <div class="panel-group" id="accordion<?php echo $faq_col1; ?>morpheme">
                <?php for($faq_col2; $faq_col2 < $faq_col1 * $faq_num_per_col; $faq_col2++){
                  $faq = $faqs['morpheme'][$faq_col2];
                  ?>
                  <div class="card">
                    <div class="card-header">
                      <h4 class="card-title">
                        <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion<?php echo $faq_col1; ?>morpheme" href="#panel<?php echo $faq_col2; ?>morpheme"><span class="panel-icon panel-open-icon">+</span><span><?php echo $faq->post_title; ?></span></a>
                      </h4>
                    </div>
                    <div id="panel<?php echo $faq_col2; ?>morpheme" class="panel-collapse collapse">
                      <div class="card-body"><?php echo wpautop($faq->post_content); ?></div>
                    </div>
                  </div>
                <?php } ?>
              </div>
            </div>
          <?php } ?>
      </div>
    </div>
  <?php endif; ?>
  <?php if(!empty($faqs) && !empty($faqs['shadowme'])) : ?>
    <div class="frequently-questions shadowme d-none">
      <div class="row requently-collapse" style="display: none;">
        <?php $faq_col1 = 1;
          $faq_col2 = 0;
          $faq_num_per_col = count($faqs['shadowme']) / 2;
          for($faq_col1; $faq_col1 <= 2; $faq_col1++){ ?>
            <div class="col-md-6">
              <div class="panel-group" id="accordion<?php echo $faq_col1; ?>shadowme">
                <?php for($faq_col2; $faq_col2 < $faq_col1 * $faq_num_per_col; $faq_col2++){
                  $faq = $faqs['shadowme'][$faq_col2]; ?>
                  <div class="card">
                    <div class="card-header">
                      <h4 class="card-title">
                        <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion<?php echo $faq_col1; ?>shadowme" href="#panel<?php echo $faq_col2; ?>shadowme"><span class="panel-icon panel-open-icon">+</span><span><?php echo $faq->post_title; ?></span></a>
                      </h4>
                    </div>
                    <div id="panel<?php echo $faq_col2; ?>shadowme" class="panel-collapse collapse">
                      <div class="card-body"><?php echo wpautop($faq->post_content); ?></div>
                    </div>
                  </div>
                <?php } ?>
              </div>
            </div>
          <?php } ?>
      </div>
    </div>
  <?php endif; ?>
  </div>
</div>

<div class='woocommerce-error-popup error-popup-checkout mfp-hide'>
  <div class='woocommerce-error-header woocommerce-message-header'>
    <img class='img-check' src='<?php echo get_stylesheet_directory_uri(); ?>/assets/img/popup-cancel-black.svg' alt=''/>
    <h2>Oops.</h2>
  </div>
  <div class='woocommerce-error-footer woocommerce-message-footer-preck'>
    <p class="error-message"></p>
    <a onclick="jQuery.magnificPopup.close();" class="btn btn-close btn-primary btn-static">OK, GOT IT</a>
  </div>
</div>

<div class='woocommerce-error-popup popup-notice-club mfp-hide'>
  <div class='woocommerce-error-header woocommerce-message-header'>
    <img class='img-check' src='<?php echo get_stylesheet_directory_uri(); ?>/assets/img/popup-cancel-black.svg' alt=''/>
    <h2>Oops.</h2>
  </div>
  <div class='woocommerce-error-footer woocommerce-message-footer-preck'>
    <p class="error-message">You already signed up for this club.</p>
    <a href="<?php echo get_permalink( wc_get_page_id( 'myaccount' ) ); ?>" class="btn btn-close btn-primary btn-static">GO TO DASHBOARD</a>
    <a onclick="jQuery.magnificPopup.close();" class="btn btn-close btn-primary btn-static">CHOOSE OTHER CLUB</a>
  </div>
</div>

<?php get_footer(); ?>

<script>
  jQuery(document).ready(function () {

    var width = (window.innerWidth > 0) ? window.innerWidth : screen.width;

//    load_carousel_for_plan_type();
    function load_carousel_for_plan_type() {
      jQuery('.fst-club').owlCarousel({
        autoplay: false,
        nav: true,
        navText: ["<img src='<?php echo get_stylesheet_directory_uri(); ?>/assets/img/left_arrow.png'>",
          "<img src='<?php echo get_stylesheet_directory_uri(); ?>/assets/img/right_arrow.png'>"],
        dots: true,
        responsive: {
          0: { items: 1 },
          768: { items: 3 }
        },
      });

        jQuery('.trade-thumbnail-images').owlCarousel({
            autoplay: false,
            center: false,
            loop: false,
            nav: true,
            pullDrag: false,
            touchDrag: false,
            mouseDrag: false,
            navText: ["<img src='<?php echo get_stylesheet_directory_uri(); ?>/assets/img/left_arrow.png'>",
                "<img src='<?php echo get_stylesheet_directory_uri(); ?>/assets/img/right_arrow.png'>"],
            dots: false,
            responsive: {
                0: { items: 3 },
                768: { items: 4 },
            },
        });

    }

//    set_slider_for_free_products();
    function set_slider_for_free_products() {
      var fps_list_option = jQuery('.fps-section .fps-container .fps-bottom .fps-list-options');
        fps_list_option.owlCarousel({
          autoplay: false,
          autoplayTimeout: 5000,
          autoplayHoverPause: true,
          responsive: {
            0: { items: 1 },
            768: { items: 3 }
          },
          loop: false,
          nav: true,
          navText: ["<img src='<?php echo get_stylesheet_directory_uri(); ?>/assets/img/left_arrow.png'>",
            "<img src='<?php echo get_stylesheet_directory_uri(); ?>/assets/img/right_arrow.png'>"],
          dots: true
        });
      inputNumber(jQuery('.qty'));
    }

    //@todo: remove after LDM sale
    var ldm_product = '<?php echo LDM_PRODUCT; ?>';
    var ldm_sale_code = '<?php echo LDM_SALE_CODE; ?>';
    jQuery('body').on('click', '.ldm-sale-get-collection', function () {
      Cookies.set('_lgs_save_name_ref', ldm_sale_code);

      jQuery('.select-club .select-club-content').removeClass('active not-active');
      var jn_select = 'kissme';
      //load data collection and gaga for 1st
      if (!jQuery('.lg-trade-collections .lg-trade-body .first-trade.trade-' + jn_select).hasClass('sale-loaded')) {
        jQuery('.liveglam-join-now-new .step-details').addClass('blockUI blockOverlay wc-updating');
        var data = {
          'action': 'lgs_load_data_precheckout',
          'productType': jn_select
        };
        jQuery.post(ajaxurl, data, function (response) {
          //update step2: reload data collection
          jQuery('.lg-trade-collections .lg-trade-body .first-trade.trade-' + jn_select).replaceWith(response.collection_data);
          load_carousel_for_plan_type();

          //update step4: reload data gaga
          jQuery('.free-gift-box.gift-box-'+ jn_select).replaceWith(response.gaga_data);
          set_slider_for_free_products();

          //save data default trade/gaga available
          jQuery('input[name="lgs-gaga-available-'+jn_select+'"]').val(response.gaga_total);
          jQuery('input[name="lgs-data-old-gift"]').val(response.gaga_total);
          jQuery('input[name="lgs-collection-available-'+jn_select+'"]').val(response.collection_total);
          if( !jQuery('input[name="trade-product-for-' + jn_select + '"][value="' + ldm_product + '"]').closest('.trade-option').hasClass('outstock')) {
            jQuery('input[name="lgs-default-trade-' + jn_select + '"]').val(ldm_product);
          }

          //maybe auto select collection on step2
          if(ldm_product != 0) {
            //go to slider auto selected
            var next_slider = 0, found_slider = 0;
            jQuery('input[name="trade-product-for-' + jn_select + '"]').each(function () {
              if(jQuery(this).val() == ldm_product){
                found_slider = 1;
              } else {
                if(found_slider == 0) {
                  next_slider++;
                }
              }
            });
            if(found_slider == 0){
              next_slider = 0;
            }
            if( width > 767 ) {
              next_slider = parseInt(next_slider / 3);
            }
            jQuery('.fst-club#fst-'+jn_select).trigger('to.owl.carousel', next_slider);
            if( !jQuery('input[name="trade-product-for-' + jn_select + '"][value="' + ldm_product + '"]').closest('.trade-option').hasClass('outstock')){
              jQuery('input[name="trade-product-for-' + jn_select + '"][value="' + ldm_product + '"]').click();
            }
          }

          //maybe show/hide step2 after ajax loaded
          if( response.collection_total > 0){
            jQuery('.liveglam-join-now-new .new-step-bar .main-step-2').removeClass('d-none');
          } else {
            jQuery('.liveglam-join-now-new .new-step-bar .main-step-2').addClass('d-none');
          }

          //maybe show/hide step4 after ajax loaded
          if( response.gaga_total > 0){
            jQuery('.liveglam-join-now-new .new-step-bar .main-step-4').removeClass('d-none');
            jQuery('.liveglam-join-now-new .step-details.step3 .shadow-layout a').addClass('next-step').removeClass('last-step');
          } else {
            jQuery('.liveglam-join-now-new .new-step-bar .main-step-4').addClass('d-none');
            jQuery('.liveglam-join-now-new .step-details.step3 .shadow-layout a').addClass('last-step').removeClass('next-step');
          }

          jQuery('.liveglam-join-now-new .step-details').removeClass('blockUI blockOverlay wc-updating');

          //maybe show text notice waitlist
          if(response.is_waitlist == 1) {
            jQuery('.choose-club-plan.choose-' + jn_select + ' .plan-waitlist').show();
            if(response.upgrade_waitlist == 1) {
              jQuery('.choose-club-plan.choose-' + jn_select + ' .plan-waitlist.plan-upgrade').show();
              jQuery('.choose-club-plan.choose-' + jn_select + ' .plan-waitlist.plan-noupgrade').hide();
            } else {
              jQuery('.choose-club-plan.choose-' + jn_select + ' .plan-waitlist.plan-noupgrade').show();
              jQuery('.choose-club-plan.choose-' + jn_select + ' .plan-waitlist.plan-upgrade').hide();
            }
          } else {
            jQuery('.choose-club-plan.choose-' + jn_select + ' .plan-waitlist').hide();
          }

          jQuery('.lg-trade-collections .lg-trade-body .first-trade.trade-' + jn_select).addClass('sale-loaded');
          if( !jQuery('.select-club .select-club-content.club-' + jn_select).hasClass('active')) {
            jQuery('.select-club .select-club-content.club-' + jn_select).click();
          }

          if( jQuery('.select-club .select-club-content.club-' + jn_select).hasClass('active')) {
            jQuery('.step-details.step1 .shadow-layout .btn-proceed').click();
            jQuery('.step-details.step2 .shadow-layout .btn-proceed').click();
          }

        },'json');
      } else {

        //maybe auto select collection on step2
        if(ldm_product != 0) {
          //go to slider auto selected
          var next_slider = 0, found_slider = 0;
          jQuery('input[name="trade-product-for-' + jn_select + '"]').each(function () {
            if(jQuery(this).val() == ldm_product){
              found_slider = 1;
            } else {
              if(found_slider == 0) {
                next_slider++;
              }
            }
          });
          if( width > 767 ) {
            next_slider = parseInt(next_slider / 3);
          }
          jQuery('.fst-club#fst-'+jn_select).trigger('to.owl.carousel', next_slider);
          if( !jQuery('input[name="trade-product-for-' + jn_select + '"][value="' + ldm_product + '"]').closest('.trade-option').hasClass('outstock')){
            jQuery('input[name="trade-product-for-' + jn_select + '"][value="' + ldm_product + '"]').click();
          }
        }

        jQuery('.lg-trade-collections .lg-trade-body .first-trade.trade-' + jn_select).addClass('sale-loaded');
        if( !jQuery('.select-club .select-club-content.club-' + jn_select).hasClass('active')) {
          jQuery('.select-club .select-club-content.club-' + jn_select).click();
        }
        if( jQuery('.select-club .select-club-content.club-' + jn_select).hasClass('active')) {
          jQuery('.step-details.step1 .shadow-layout .btn-proceed').click();
          jQuery('.step-details.step2 .shadow-layout .btn-proceed').click();
        }
      }


      return false;
    });

    jQuery('.liveglam-join-now-new ul.select-club li').on('click', function () {
      var current = jQuery(this),
        jn_select = current.data('select'),
        gaga_available = jQuery('input[name="lgs-gaga-available-'+jn_select+'"]').val(),
        collection_available = jQuery('input[name="lgs-collection-available-'+jn_select+'"]').val(),
        collection_trade = jQuery('input[name="lgs-default-trade-'+jn_select+'"]').val(),
        collection_auto_select = jQuery('input[name="lgs-auto-select-collection-'+jn_select+'"]').val(),
        check_enable_multiple = jQuery('#lg-enabled-multiple').val();

      if(current.hasClass('disabled')){
        jQuery.magnificPopup.open({
          items: {src: ".woocommerce-error-popup.popup-notice-club"},
          type: "inline",
          closeOnContentClick: false,
          closeOnBgClick: false,
          showCloseBtn: false
        });
        return false;
      }

      //collapsed all faq
      collapsed_all_faq();

      if (!current.hasClass('active')) {
        if (check_enable_multiple != 1) {
          //case not enable bundle checkout
          jQuery('.liveglam-join-now-new .step-details.step1 .product-types-new li').removeClass('active').addClass('not-active');
        }
        current.removeClass('not-active').addClass('active');

        //maybe go to slider message on top
        if(jQuery('.lg-message-details .lg-message-box').length > 0){
          var msg_slider = 0, found_msg_slider = 0;
          jQuery('.lg-message-details .lg-message-box').each(function () {
            if(jQuery(this).data('club') == jn_select){
              found_msg_slider = 1;
            } else {
              if(found_msg_slider == 0) {
                msg_slider++;
              }
            }
          });
          jQuery('.lg-message-details').trigger('to.owl.carousel', msg_slider);
        }

        jQuery('input[name="lgs-preck-select-club"]').val(jn_select);
        current.find('.club-type').attr('checked', 'checked');

        //step 1: reload title for
        jQuery('.liveglam-join-now-new .step-details.step1 .subtitle-new').text(current.data('title'));
        jQuery('.liveglam-join-now-new .lg-notice-select-club').css('display', 'none');

        //step 2: show/hide collection for club base on select
        jQuery('.liveglam-join-now-new .step-details.step2 .first-trade').addClass('d-none');
        jQuery('.liveglam-join-now-new .step-details.step2 .first-trade.trade-' + jn_select).removeClass('d-none');
        jQuery('.liveglam-join-now-new .step-details.step2 .subtitle-new').text(jQuery('.liveglam-join-now-new .step-details.step2 .subtitle-new').data('title'));
        //step 2: reload 1st selected
        jQuery('.liveglam-join-now-new input.trade-for-club').each(function(){
          if(jQuery(this).is(':checked')){
            jQuery(this).prop('checked',false).change();
          }
        });
        jQuery('.liveglam-join-now-new .step-details.step2 .trade-option').removeClass('not-active active');
        jQuery('.liveglam-join-now-new .step-details.step2 .btn-proceed').removeClass('active');
        jQuery('.liveglam-join-now-new .lg-notice-select-collection').removeClass('d-none');
        //step 2: maybe auto select collection
        if(collection_trade != 0 || collection_auto_select == 1) {
          //go to slider auto selected
          var next_slider = 0, found_slider = 0;
          jQuery('input[name="trade-product-for-' + jn_select + '"]').each(function () {
            if(jQuery(this).val() == collection_trade){
              found_slider = 1;
            } else {
              if(found_slider == 0) {
                next_slider++;
              }
            }
          });
          if(found_slider == 0){
            next_slider = 0;
          }
          if( width > 767 ) {
            next_slider = parseInt(next_slider / 3);
          }
          jQuery('.fst-club#fst-'+jn_select).trigger('to.owl.carousel', next_slider);
          if( !jQuery('input[name="trade-product-for-' + jn_select + '"][value="' + collection_trade + '"]').closest('.trade-option').hasClass('outstock')){
            jQuery('input[name="trade-product-for-' + jn_select + '"][value="' + collection_trade + '"]').click();
          }
        }

        //step 3: show/hide plan for club base on select
        jQuery('.liveglam-join-now-new .step-details.step3 .choose-club-plan').addClass('d-none');
        jQuery('.liveglam-join-now-new .step-details.step3 .choose-club-plan.choose-' + jn_select).removeClass('d-none');
        //step 3: reload select club
        jQuery('.liveglam-join-now-new .step-details.step3 .choose-club-plan .club-plan').removeClass('not-active active');
        jQuery('.liveglam-join-now-new .step-details.step3 .btn-proceed').removeClass('active');
        jQuery('.liveglam-join-now-new .lg-notice-select-plan').removeClass('d-none');

        //step 4: show/hide gaga for club base on select
        jQuery('.liveglam-join-now-new .step-details.step4 .free-gift-box').addClass('d-none');
        jQuery('.liveglam-join-now-new .step-details.step4 .free-gift-box.gift-box-'+ jn_select).removeClass('d-none');
        jQuery('.liveglam-join-now-new .step-details.step4 .lg-notice-select-gift').addClass('d-none');
        jQuery('.liveglam-join-now-new .step-details.step4 .lg-notice-select-gift.choose-'+ jn_select).removeClass('d-none');
        //step 4: reload GAGA selected
        jQuery('.liveglam-join-now-new .step-details.step4 .btn-proceed').removeClass('active');
        jQuery('.free-gift-box.gift-box-'+jn_select+' .prc_product .prc_select input.fps-input').each(function(){
          if(jQuery(this).is(':checked')){
            jQuery(this).prop('checked',false).change();
          }
        });

        //show/hide faq base on club
        jQuery('.frequently-questions').addClass('d-none');
        jQuery('.frequently-questions.' + jn_select).removeClass('d-none');

        jQuery('.liveglam-join-now-new .step4 .last-step').data('select', jn_select);
        jQuery('.liveglam-join-now-new .step3 .last-step').data('select', jn_select);

        //maybe show/hide step2
        if( collection_available > 0){
          jQuery('.liveglam-join-now-new .new-step-bar .main-step-2').removeClass('d-none');
        } else {
          jQuery('.liveglam-join-now-new .new-step-bar .main-step-2').addClass('d-none');
        }

        //maybe show/hide step4
        if( gaga_available > 0){
          jQuery('.liveglam-join-now-new .new-step-bar .main-step-4').removeClass('d-none');
          jQuery('.liveglam-join-now-new .step-details.step3 .shadow-layout a').addClass('next-step').removeClass('last-step');
        } else {
          jQuery('.liveglam-join-now-new .new-step-bar .main-step-4').addClass('d-none');
          jQuery('.liveglam-join-now-new .step-details.step3 .shadow-layout a').addClass('last-step').removeClass('next-step');
        }

        //maybe show/hide notice on change code form
        if(jQuery('.lgjn_referral_code_form .lgjn_got_code .notice.notice-'+jn_select).length > 0){
          jQuery('.lgjn_referral_code_form .lgjn_got_code .notice').addClass('d-none');
          jQuery('.lgjn_referral_code_form .lgjn_got_code .notice.notice-'+jn_select).removeClass('d-none');
        } else {
          jQuery('.lgjn_referral_code_form .lgjn_got_code .notice').addClass('d-none');
          jQuery('.lgjn_referral_code_form .lgjn_got_code .notice.notice-default').removeClass('d-none');
        }
      } else {
        jQuery('.liveglam-join-now-new .step-details.step1 .product-types-new li').removeClass('not-active active');

        //step 1: reload title
        jQuery('.liveglam-join-now-new .step-details.step1 .subtitle-new').text(jQuery('.liveglam-join-now-new .step-details.step1 .subtitle-new').data('title'));
        jQuery('.liveglam-join-now-new .lg-notice-select-club').show();

        //step 2: reload title
        jQuery('.liveglam-join-now-new .step-details.step2 .subtitle-new').text(jQuery('.liveglam-join-now-new .step-details.step2 .subtitle-new').data('title'));

        //show faq general
        jQuery('.frequently-questions').addClass('d-none');
        jQuery('.frequently-questions.general').removeClass('d-none');

        //maybe go to slider message on top
        if(jQuery('.lg-message-details .lg-message-box').length > 0){
          var general_slider = 0, found_general_slider = 0;
          jQuery('.lg-message-details .lg-message-box').each(function () {
            if(jQuery(this).data('club') == 'general'){
              found_general_slider = 1;
            } else {
              if(found_general_slider == 0) {
                general_slider++;
              }
            }
          });
          jQuery('.lg-message-details').trigger('to.owl.carousel', general_slider);
        }

        //maybe show/hide notice on change code form
        jQuery('.lgjn_referral_code_form .lgjn_got_code .notice').addClass('d-none');
        jQuery('.lgjn_referral_code_form .lgjn_got_code .notice.notice-default').removeClass('d-none');
      }

      var total_active = jQuery('.liveglam-join-now-new .step1 .product-types-new li.active').length;
      if (total_active > 0) {
        jQuery('.liveglam-join-now-new .step-details.step1 .btn-proceed').addClass('active');
      } else {
        jQuery('.liveglam-join-now-new .step-details.step1 .btn-proceed').removeClass('active');
      }

      //load data collection and gaga for 1st
      if (!jQuery('.lg-trade-collections .lg-trade-body .first-trade.trade-' + jn_select).hasClass('trade-loaded')) {
        jQuery('.liveglam-join-now-new .step-details').addClass('blockUI blockOverlay wc-updating');
        var data = {
          'action': 'lgs_load_data_precheckout',
          'productType': jn_select
        };
        jQuery.post(ajaxurl, data, function (response) {
          //update step2: reload data collection
          jQuery('.lg-trade-collections .lg-trade-body .first-trade.trade-' + jn_select).replaceWith(response.collection_data);
          load_carousel_for_plan_type();

          //update step4: reload data gaga
          jQuery('.free-gift-box.gift-box-'+ jn_select).replaceWith(response.gaga_data);
          set_slider_for_free_products();

          //save data default trade/gaga available
          jQuery('input[name="lgs-gaga-available-'+jn_select+'"]').val(response.gaga_total);
          jQuery('input[name="lgs-collection-available-'+jn_select+'"]').val(response.collection_total);
          jQuery('input[name="lgs-default-trade-'+jn_select+'"]').val(response.collection_default);
          jQuery('input[name="lgs-'+jn_select+'-waitlist"]').val(response.is_waitlist);
          jQuery('input[name="lgs-'+jn_select+'-waitlist-upgrade"]').val(response.upgrade_waitlist);

          //@todo: remove after LDM sale
          if( jn_select == 'kissme' ){
            jQuery('input[name="lgs-data-old-gift"]').val(response.gaga_total);
          }

          //maybe show/hide step4 after ajax loaded
          if( response.gaga_total > 0){
            jQuery('.liveglam-join-now-new .new-step-bar .main-step-4').removeClass('d-none');
            jQuery('.liveglam-join-now-new .step-details.step3 .shadow-layout a').addClass('next-step').removeClass('last-step');
          } else {
            jQuery('.liveglam-join-now-new .new-step-bar .main-step-4').addClass('d-none');
            jQuery('.liveglam-join-now-new .step-details.step3 .shadow-layout a').addClass('last-step').removeClass('next-step');
          }

          //maybe show text notice waitlist
          if(response.is_waitlist == 1) {
            jQuery('.choose-club-plan.choose-' + jn_select + ' .plan-waitlist').show();
            if(response.upgrade_waitlist == 1) {
              jQuery('.choose-club-plan.choose-' + jn_select + ' .plan-waitlist.plan-upgrade').show();
              jQuery('.choose-club-plan.choose-' + jn_select + ' .plan-waitlist.plan-noupgrade').hide();
            } else {
              jQuery('.choose-club-plan.choose-' + jn_select + ' .plan-waitlist.plan-noupgrade').show();
              jQuery('.choose-club-plan.choose-' + jn_select + ' .plan-waitlist.plan-upgrade').hide();
            }
          } else {
            jQuery('.choose-club-plan.choose-' + jn_select + ' .plan-waitlist').hide();
          }

          //maybe have select collection from url
          var selected_trade = jQuery('input.selected-trade.'+jn_select).val();
          if(selected_trade != ''){
            if(selected_trade == 0){
              collection_auto_select = 1;
            } else {
              response.collection_default = selected_trade;
            }
          }
          //maybe auto select collection on step2
          if(response.collection_default != 0 || collection_auto_select == 1) {
            //go to slider auto selected
            var next_slider = 0, found_slider = 0;
            jQuery('input[name="trade-product-for-' + jn_select + '"]').each(function () {
              if(jQuery(this).val() == response.collection_default){
                found_slider = 1;
              } else {
                if(found_slider == 0) {
                  next_slider++;
                }
              }
            });
            if(found_slider == 0){
              next_slider = 0;
            }
            if( width > 767 ) {
              next_slider = parseInt(next_slider / 3);
            }
            jQuery('.fst-club#fst-'+jn_select).trigger('to.owl.carousel', next_slider);
            if( !jQuery('input[name="trade-product-for-' + jn_select + '"][value="' + response.collection_default + '"]').closest('.trade-option').hasClass('outstock')) {
              jQuery('input[name="trade-product-for-' + jn_select + '"][value="' + response.collection_default + '"]').click();
            }
          }

          //maybe show/hide step2 after ajax loaded
          if( response.collection_total > 0){
            jQuery('.liveglam-join-now-new .new-step-bar .main-step-2').removeClass('d-none');
            //auto go to step 2 if have data in url
            if(selected_trade != ''){
              jQuery('.step-details.step1 .shadow-layout .btn-proceed').click();
            }
          } else {
            jQuery('.liveglam-join-now-new .new-step-bar .main-step-2').addClass('d-none');
          }

          jQuery('.liveglam-join-now-new .step-details').removeClass('blockUI blockOverlay wc-updating');

        },'json');
      }

      return false;
    });

    jQuery('body').on('click', '.liveglam-join-now-new .step2 .trade-option .trade-image', function () {
      var current = jQuery(this).closest('.trade-option'),
        club = current.data('select');
      if( current.hasClass('outstock') ){
        return false;
      }
      if( current.hasClass('active')) {
        jQuery('.liveglam-join-now-new input.trade-for-club').each(function () {
          if (jQuery(this).is(':checked')) {
            jQuery(this).prop('checked', false).change();
          }
        });
        jQuery('.liveglam-join-now-new .step-details.step2 .subtitle-new').text(jQuery('.liveglam-join-now-new .step-details.step2 .subtitle-new').data('title'));
        jQuery('.liveglam-join-now-new .step-details.step2 .trade-option').removeClass('not-active active');
        jQuery('.liveglam-join-now-new .step-details.step2 .btn-proceed').removeClass('active');
        jQuery('.liveglam-join-now-new .lg-notice-select-collection').removeClass('d-none');
        return false;
      } else {
        jQuery('.liveglam-join-now-new .step-details.step2 .subtitle-new').text(current.closest('.trade-option').data('title'));
        current.find('input.trade-for-club').prop('checked', true).change();
        return false;
      }
    });

    jQuery('.liveglam-join-now-new .step3 .choose-club-plan .product-types-new li').on('click', function () {
      var jn_this = jQuery(this),
        jn_select = jn_this.data('select'),
        current_club = jn_this.closest('.product-types-new');
      if (!jn_this.hasClass('active')) {
        current_club.find('li').removeClass('active').addClass('not-active');
        jn_this.removeClass('not-active').addClass('active');
        jQuery('.liveglam-join-now-new .lg-notice-select-plan').addClass('d-none');
        jQuery('.liveglam-join-now-new .step-details.step3 .btn-proceed').addClass('active');
          var product_type = jn_this.data('select');
          var track = 'trackCustom',
              trackEventName = '',
              productid = jQuery('.step3 .choose-'+product_type+' .product-types-new .club-plan.active').data('product');
          var title = jQuery('#LGP_'+productid).data('title'),
              price = jQuery('#LGP_'+productid).data('price');
          if(jQuery.inArray(productid, mm_productids)>=0){
              trackEventName = 'PreCheck3Morph';
          }
          if(jQuery.inArray(productid, km_productids)>=0){
              trackEventName = 'PreCheck3Kiss';
          }
          if(jQuery.inArray(productid, sm_productids)>=0){
              trackEventName = 'PreCheck3Shadow';
          }

          if(trackEventName != ''){
              fbq(track, trackEventName, {
                  content_name: title,
                  content_category: 'Subscription',
                  content_ids: ["'"+productid+"'"],
                  content_type: 'product',
                  value: price,
                  currency: 'USD'
              });
          }
      } else {
        jQuery('.liveglam-join-now-new .step3 .choose-club-plan .product-types-new li').removeClass('active not-active');
        jQuery('.liveglam-join-now-new .lg-notice-select-plan').removeClass('d-none');
        jQuery('.liveglam-join-now-new .step-details.step3 .btn-proceed').removeClass('active');
      }
    });

    jQuery('body').on('click','.lg-trade-collections .lg-trade-content .trade-option .trade-thumbnail-images .item',function(){
      var current = jQuery(this),
        img_src = current.find('img').attr('src'),
        img_text = current.find('img').data('text'),
        tradeoption = current.closest('.trade-option');
      if(!current.hasClass('active')){
        tradeoption.find('.trade-thumbnail-images .item').removeClass('active');
        current.addClass('active');
        tradeoption.find('.trade-image img').attr('src',img_src);
        tradeoption.find('.trade-image .trade-title .collection_title').text(img_text);
      }
      return false;
    });

    jQuery('body').on('change', '.liveglam-join-now-new input.trade-for-club', function () {
      var current = jQuery(this).closest('.trade-option'),
        club = current.data('select');

      jQuery('input[name="trade-product-for-'+club+'"]').each(function () {
        var current_input = jQuery(this);

        if(current_input.is(':checked')){
          current_input.closest('.trade-option').removeClass('not-active').addClass('active');
          jQuery('.liveglam-join-now-new .step-details.step2 .subtitle-new').text(current_input.closest('.trade-option').data('title'));
        } else {
          current_input.closest('.trade-option').removeClass('active').addClass('not-active');
        }

        //@todo: remove after LDM sale
        if(club == 'kissme' && current_input.val() == ldm_product){
          //maybe reload gift step here: show/hide if cx select/unselect ldm collection
          var current_gaga = jQuery('input[name="lgs-gaga-available-'+club+'"]').val(),
            old_gaga = jQuery('input[name="lgs-data-old-gift"]').val(),
            new_gaga = old_gaga;

          jQuery('input[name="lgs-data-old-gift"]').val(current_gaga);
          if(current_input.is(':checked')){
            new_gaga = 0;
            jQuery('input[name="lgs-gaga-available-'+club+'"]').val(0);
          } else {
            jQuery('input[name="lgs-gaga-available-'+club+'"]').val(old_gaga);
          }

          //maybe show/hide step4 after LDM collection selecte/unselect
          if( new_gaga > 0){
            jQuery('.liveglam-join-now-new .new-step-bar .main-step-4').removeClass('d-none');
            jQuery('.liveglam-join-now-new .step-details.step3 .shadow-layout a').addClass('next-step').removeClass('last-step');
          } else {
            jQuery('.liveglam-join-now-new .new-step-bar .main-step-4').addClass('d-none');
            jQuery('.liveglam-join-now-new .step-details.step3 .shadow-layout a').addClass('last-step').removeClass('next-step');
          }
        }
      });

      var current_trade = jQuery('input[name="trade-product-for-'+club+'"]:checked').val();
      if(typeof current_trade === 'undefined' || current_trade == 0){
        jQuery('.liveglam-join-now-new .step3 .choose-club-plan.choose-'+club+' .plan-waitlist-enable').removeClass('d-none');
        jQuery('.liveglam-join-now-new .step3 .choose-club-plan.choose-'+club+' .plan-waitlist-disable').addClass('d-none');
        if(jQuery('input[name="lgs-'+club+'-waitlist"]').val() == 1 && jQuery('input[name="lgs-'+club+'-waitlist-upgrade"]').val() == 1 ) {
          jQuery('.liveglam-join-now-new .step3 .choose-club-plan.choose-' + club + ' .plan-waitlist-upgrade').removeClass('d-none');
        }
      } else {
        jQuery('.liveglam-join-now-new .step3 .choose-club-plan.choose-'+club+' .plan-waitlist-enable').addClass('d-none');
        jQuery('.liveglam-join-now-new .step3 .choose-club-plan.choose-'+club+' .plan-waitlist-disable').removeClass('d-none');
        jQuery('.liveglam-join-now-new .step3 .choose-club-plan.choose-'+club+' .plan-waitlist-upgrade').addClass('d-none');
      }

      jQuery('.liveglam-join-now-new .step-details.step2 .btn-proceed').addClass('active');
      jQuery('.liveglam-join-now-new .lg-notice-select-collection').addClass('d-none');
    });

    jQuery('body').on('click', '.liveglam-join-now-new .shadow-layout .last-step', function (e) {
      var current = jQuery(this),
        club = jQuery('input[name="lgs-preck-select-club"]').val(),
        productid = jQuery('.choose-club-plan.choose-'+club+' .club-plan.active').data('product'),
        trade_collection = jQuery('input[name="trade-product-for-'+club+'"]:checked').val(),
        jn_gaga = jQuery('.liveglam-join-now-new .step4 .gift-box-' + club + ' .fps-options.selected'),
        select_gaga = '';

      if(current.hasClass('disabled')) {
        return false;
      }

      current.addClass('disabled');

      if(typeof trade_collection === 'undefined'){
        trade_collection = 0;
      }

      var total_qty = 0,
        gaga_available = parseInt(jQuery('input[name="lgs-gaga-available-'+club+'"]').val());

      if (jn_gaga.length > 0) {
        jn_gaga.each(function () {
          var gaga_product_id = jQuery(this).find('.fps-checked input:checked').val(),
            qty = parseInt(jQuery(this).find('.cart-item-quantity .qty').val());
          total_qty = total_qty + qty;
          if (!select_gaga == '') {
            gaga_product_id = '-' + gaga_product_id;
          }
          if (qty == 2) {
            gaga_product_id = gaga_product_id + '-' + gaga_product_id;
          }
          select_gaga = select_gaga + gaga_product_id;
        });
      }

      if(gaga_available == 0){
        select_gaga = '';
      }

      //maybe check cx selected free product before submit
      if(total_qty < gaga_available){
        var gaga_left = gaga_available - total_qty,
          message = '';
        if(gaga_left == 1){
          if(club == 'morpheme'){
            message = 'Please select 1 more free brush';
          } else {
            message = 'Please select 1 more free lippie.';
          }
        } else {
          if(club == 'morpheme'){
            message = 'Please select '+gaga_left+' free brushes.';
          } else {
            message = 'Please select '+gaga_left+' free lippies.';
          }
        }
        //open popup error to notice cx select more free product
        jQuery('.error-popup-checkout .error-message').html(message);
        jQuery.magnificPopup.open({
          items: {src: ".woocommerce-error-popup.error-popup-checkout"},
          type: "inline",
          closeOnContentClick: false,
          closeOnBgClick: false,
          showCloseBtn: false
        });
        current.removeClass('disabled');
        return false;
      }

      //show progress indicator
        var progress_indicator = [];
        jQuery('.liveglam-join-now-new .new-step-bar .steps-process-list .steps-process').each(function () {
            if(jQuery(this).is(':visible')){
                progress_indicator.push(jQuery(this).data('step'))
            }
        });

      if(current.hasClass('active')) {
        var track = 'trackCustom',
            trackEventName = '';
        var title = jQuery('#LGP_'+productid).data('title'),
            price = jQuery('#LGP_'+productid).data('price');
        if(jQuery.inArray(productid, mm_productids)>=0){
            trackEventName = 'InitiateCheckoutMorph';
        }
        if(jQuery.inArray(productid, km_productids)>=0){
            trackEventName = 'InitiateCheckoutKiss';
        }
        if(jQuery.inArray(productid, sm_productids)>=0){
            trackEventName = 'InitiateCheckoutShadow';
        }

        if(trackEventName != ''){
            fbq(track, trackEventName, {
                content_name: title,
                content_category: 'Subscription',
                content_ids: ["'"+productid+"'"],
                content_type: 'product',
                value: price,
                currency: 'USD'
            });
        }
        var data = {
          'action': 'lgs_checkout_combine_proceed',
            'show_progress_indicator': progress_indicator.join(','),
        };
        if (club == 'morpheme') {
          data.mm_plan = productid;
          data.mm_gaga = select_gaga;
          data.mm_fst = trade_collection;
        }
        if (club == 'kissme') {
          data.km_plan = productid;
          data.km_gaga = select_gaga;
          data.km_fst = trade_collection;
        }
        if (club == 'shadowme') {
          data.sm_plan = productid;
          data.sm_gaga = select_gaga;
          data.sm_fst = trade_collection;
        }

        jQuery.post(ajaxurl, data, function (response) {
          if (response.status != "error") {
            window.location = response.redirect_url;
            current.removeClass('disabled');
          }
        }, 'json');

      }

      return false;

    });

    jQuery('body').on('click', '.liveglam-join-now-new .shadow-layout .next-step', function () {
      var current = jQuery(this),
        current_step = jQuery('.liveglam-join-now-new .new-step-bar .steps-process.current'),
        stepnumber = current_step.data('step'),
        next_step = current_step.next('.steps-process'),
        next_step_number = next_step.data('step');
      if (next_step.hasClass('d-none')) {
        next_step = next_step.next('.steps-process');
        next_step_number = next_step.data('step');
      }
      if(current.hasClass('active')){
        current_step.removeClass('current').addClass('completed');
        next_step.addClass('current');
        jQuery('.lg-sub-menubar .btn-hamburger-back').addClass('d-none');
        jQuery('.lg-sub-menubar .btn-hamburger-back.back-to-step').removeClass('d-none');
        jQuery('.liveglam-join-now-new .step' + stepnumber).addClass('d-none');
        jQuery('.liveglam-join-now-new .step' + next_step_number).removeClass('d-none');
        jQuery('.newdesign-message-bar').addClass('d-none');
      }
      if(stepnumber == 1 && next_step_number == 2){
          var current = jQuery('.step1 .select-club .select-club-content.active'),
              product_type = current.data('select');
          var track = 'trackCustom',
              trackEventName = '',
              productid = jQuery('.step3 .choose-'+product_type+' .product-types-new .club-plan.active').data('product');
          if(productid == undefined || productid ==''){
              if (product_type == 'morpheme')productid = 2592;
              if (product_type == 'kissme')productid = 9999995176;
              if (product_type == 'shadowme')productid = 10002876000;
          }
          var title = jQuery('#LGP_'+productid).data('title'),
              price = jQuery('#LGP_'+productid).data('price');
          if(jQuery.inArray(productid, mm_productids)>=0){
              trackEventName = 'PreCheck2Morph';
          }
          if(jQuery.inArray(productid, km_productids)>=0){
              trackEventName = 'PreCheck2Kiss';
          }
          if(jQuery.inArray(productid, sm_productids)>=0){
              trackEventName = 'PreCheck2Shadow';
          }

          if(trackEventName != ''){
              fbq(track, trackEventName, {
                  content_name: title,
                  content_category: 'Subscription',
                  content_ids: ["'"+productid+"'"],
                  content_type: 'product',
                  value: price,
                  currency: 'USD'
              });
          }
      }
      lgs_ga_tracking(next_step_number);
      lgs_maybe_scroll_step();
      collapsed_all_faq();
      return false;
    });

    jQuery('.lg-sub-menubar .back-to-step').on('click', function () {
      var current_step = jQuery('.liveglam-join-now-new .new-step-bar .steps-process.current'),
        stepnumber = current_step.data('step'),
        last_step = current_step.prev('.steps-process'),
        last_step_number = last_step.data('step');
      if (last_step.hasClass('d-none')) {
        last_step = last_step.prev('.steps-process');
        last_step_number = last_step.data('step');
      }
      current_step.removeClass('current');
      last_step.removeClass('completed').addClass('current');
      jQuery('.liveglam-join-now-new .step' + stepnumber).addClass('d-none');
      jQuery('.liveglam-join-now-new .step' + last_step_number).removeClass('d-none');
      if (last_step_number == 1) {
        jQuery('.lg-sub-menubar .btn-hamburger-back').removeClass('d-none');
        jQuery(this).addClass('d-none');
        jQuery('.newdesign-message-bar').removeClass('d-none');
      }
      lgs_ga_tracking(last_step_number);
      lgs_maybe_scroll_step();
      collapsed_all_faq();
      return false;
    });

    jQuery('body').on('click','.liveglam-join-now-new .new-step-bar .steps-process',function(){

      var current_step = jQuery(this),
        current_step_number = current_step.data('step');

      if(current_step.hasClass('completed')){

        jQuery('.liveglam-join-now-new .step-details').addClass('d-none');
        jQuery('.liveglam-join-now-new .step-details.step' + current_step_number).removeClass('d-none');

        lgs_ga_tracking(current_step_number);
        current_step.addClass('current');
        current_step.removeClass('completed');
        jQuery('.liveglam-join-now-new .new-step-bar .steps-process').each(function(){
          jQuery(this).removeClass('completed current');
          var stepnumber = jQuery(this).data('step');
          if(stepnumber < current_step_number){
            jQuery(this).addClass('completed');
          }
          if(stepnumber == current_step_number){
            jQuery(this).addClass('current');
          }
        });

        if(current_step_number > 1){
          jQuery('.lg-sub-menubar .btn-hamburger-back').addClass('d-none');
          jQuery('.lg-sub-menubar .btn-hamburger-back.back-to-step').removeClass('d-none');
        }else{
          jQuery('.lg-sub-menubar .btn-hamburger-back').removeClass('d-none');
          jQuery('.lg-sub-menubar .btn-hamburger-back.back-to-step').addClass('d-none');
          jQuery('.newdesign-message-bar').removeClass('d-none');
        }
      }

      collapsed_all_faq();

      return false;

    });

    lgs_ga_tracking(1);
    function lgs_ga_tracking(step) {
      var step_name = 'select_club';
      if(step == 2) step_name = 'select_collection';
      if(step == 3) step_name = 'select_plan';
      if(step == 4) step_name = 'select_gift';
      if(typeof ga === 'function') {
        ga('send', 'pageview', "/pre-checkout/" + step_name);
      }
    }

    function lgs_maybe_scroll_step() {
      jQuery('html, body').animate({ scrollTop: 0 },1000);
      var width = (window.innerWidth > 0) ? window.innerWidth : screen.width;
      if( width < 767 ) {
        var total_left = 0, found_current = 0;
        jQuery('.liveglam-join-now-new .new-step-bar .steps-process-list .steps-process').each(function () {
          if(jQuery(this).hasClass('current')){
            found_current = 1;
          } else {
            if(found_current == 0){
              total_left = total_left + jQuery(this).outerWidth();
            }
          }
        });
        jQuery('.steps-process-list').animate({scrollLeft: total_left}, 800);
      }
    }

    /** script change qty for free product **/
    jQuery('body').on('change', '.liveglam-join-now-new .prc_product .prc_select .fps-checked input.fps-input', function () {
      var current = jQuery(this),
        product = current.closest('.free-gift-box').data('select'),
        limit_qty = jQuery('.choose-total-gift-' + product).val(),
        totalchecked = current.closest('.prc_product').find('.fps-checked input.fps-input').filter(":checked").length;


      jQuery('.free-gift-box.gift-box-'+product+' .prc_product .prc_select input.fps-input').each(function () {
        var current_input = jQuery(this);

        if(current_input.is(':checked')){
          current_input.closest('.fps-options').addClass('selected');
          current_input.closest('.owl-item').addClass('selected');
          if(current_input.closest('.prc_select').find('.cart-item-quantity .qty').val() == 0) {
            current_input.closest('.prc_select').find('.cart-item-quantity .qty').val('1').change();
          }
        } else {
          current_input.closest('.fps-options').removeClass('selected');
          current_input.closest('.owl-item').removeClass('selected');
          current_input.closest('.prc_select').find('.cart-item-quantity .qty').val('0').change();
        }
      });
    });

    jQuery('body').on('change', '.liveglam-join-now-new .prc_product .prc_select .cart-item-quantity .qty', function () {
      var current = jQuery(this),
        product = current.closest('.free-gift-box').data('select');

      if( current.val() > 0 ){
          current.closest('.prc_select').find('.fps-checked input').attr('checked','checked').change();
          current.closest('.owl-item').addClass('selected');
          current.closest('.prc_select').addClass('selected');
      }else{
        current.closest('.prc_select').find('.fps-checked input').removeAttr('checked');
        current.closest('.owl-item').removeClass('selected');
        current.closest('.prc_select').removeClass('selected');
      }
      lgs_maybe_check_limit(product);
    });

    function lgs_maybe_check_limit(club){
      var total_limit = jQuery('.choose-total-gift-' + club).val(),
        count_qty = 0;
      jQuery('.free-gift-box.gift-box-'+club+' .fps-options .cart-item-quantity .qty').each(function (){
        count_qty = count_qty + parseInt(jQuery(this).val());
      });

      var qty_left = total_limit - count_qty;
      if(qty_left == 0){
        jQuery('.liveglam-join-now-new .step-details.step4 .lg-notice-select-gift.choose-'+club).addClass('d-none');
      } else {
        jQuery('.liveglam-join-now-new .step-details.step4 .lg-notice-select-gift.choose-'+club).removeClass('d-none');
      }
      if(qty_left == 1 && total_limit > 1){
        jQuery('.liveglam-join-now-new .step-details.step4 .lg-notice-select-gift.choose-'+club+' .gift-1').addClass('d-none');
        jQuery('.liveglam-join-now-new .step-details.step4 .lg-notice-select-gift.choose-'+club+' .gift-2').removeClass('d-none');
      } else {
        jQuery('.liveglam-join-now-new .step-details.step4 .lg-notice-select-gift.choose-'+club+' .gift-1').removeClass('d-none');
        jQuery('.liveglam-join-now-new .step-details.step4 .lg-notice-select-gift.choose-'+club+' .gift-2').addClass('d-none');
      }
      jQuery('.free-gift-box.gift-box-'+club+' .fps-options .cart-item-quantity .qty').each(function () {
        var limit = parseInt(jQuery(this).val());
        if(total_limit == count_qty) {
          jQuery('.liveglam-join-now-new .step-details.step4 .btn-proceed').addClass('active');
          jQuery(this).attr('max', limit);
          //only disable for input type checkbox
          if(jQuery(this).closest('.owl-item').find('.prc_select .fps-checked input.fps-input').attr('type') == 'checkbox') {
            if (limit == 0) {
              jQuery(this).closest('.owl-item').addClass('disabled');
            } else {
              jQuery(this).closest('.owl-item').removeClass('disabled');
            }
          }
        } else {
          jQuery('.liveglam-join-now-new .step-details.step4 .btn-proceed').removeClass('active');
          jQuery(this).attr('max', limit+qty_left);
          jQuery(this).closest('.owl-item').removeClass('disabled');
        }

        //show/hide button increase input
        if (limit == jQuery(this).attr('max')) {
          jQuery(this).closest('.owl-item').find('.input-number-increment').css('opacity', 0);
        } else {
          jQuery(this).closest('.owl-item').find('.input-number-increment').css('opacity', 1);
        }

        //show/hide button decrement input
        if (limit == jQuery(this).attr('min')) {
          jQuery(this).closest('.owl-item').find('.input-number-decrement').css('opacity', 0);
        } else {
          jQuery(this).closest('.owl-item').find('.input-number-decrement').css('opacity', 1);
        }

      });
    }
    /** end script change qty for free product **/

    /** script enter ref code **/
    jQuery('body').on('click', '.lgjn_submit_referral', function () {
      var current = jQuery(this),
        code = current.closest('.lgjn_referral_form').find('.lgjn_referral_code').val();
      var data = {
        'action': 'liveglam_join_now_check_referral',
        'code': code
      };
      if (code == '') {
        current.closest('.lgjn_referral_code_form').addClass('error');
        current.closest('.lgjn_referral_code_form').find('.lgjn_referral_message').text('Please enter the code ...');
        return false;
      }
      current.closest('.lgjn_referral_code_form').removeClass('error');
      current.closest('.lgjn_referral_code_form').find('.lgjn_referral_message').text('Checking code ...');
      jQuery.post(ajaxurl, data, function (response) {
        current.closest('.lgjn_referral_code_form').find('.lgjn_referral_message').html(response.message);
        if (response.success) {
          current.closest('.lgjn_referral_code_form').removeClass('error');
          var club = jQuery('input[name="lgs-preck-select-club"]').val();

          if(club != ''){
            window.location.href = window.location.origin + window.location.pathname + '?club='+club;
          } else {
            location.reload();
          }
        } else {
          current.closest('.lgjn_referral_code_form').addClass('error');
          current.closest('.lgjn_referral_code_form').find('.lgjn_submit_referral').addClass('d-none');
          current.closest('.lgjn_referral_code_form').find('.lgjn_clear_error_referral').removeClass('d-none');
        }
      }, 'json');
      return false;
    });

    jQuery('body').on('click', '.lgjn_clear_error_referral', function (event) {
      event.preventDefault();
      var current = jQuery(this);
      current.closest('.lgjn_referral_code_form').find('.lgjn_referral_message').html('');
      current.closest('.lgjn_referral_code_form').find('.lgjn_got_code_message').toggle('slide');
      current.closest('.lgjn_referral_code_form').removeClass('error');
      current.closest('.lgjn_referral_code_form').find('.lgjn_referral_code').val('');
      current.closest('.lgjn_referral_code_form').find('.lgjn_submit_referral').removeClass('d-none');
      current.closest('.lgjn_referral_code_form').find('.lgjn_clear_error_referral').addClass('d-none');
      return false;
    });
    /** end script enter ref code **/

    /* script faq */
    jQuery('body').on('click', '.frequently-action', function () {
      var current = jQuery(this);
      if(current.hasClass('faq-open')){
        current.removeClass('faq-open').addClass('faq-close');
        jQuery('.frequently-questions .requently-collapse').show();
      } else {
        current.addClass('faq-open').removeClass('faq-close');
        jQuery('.frequently-questions .requently-collapse').hide();
      }
    });

    function collapsed_all_faq() {
      //collapsed all faq
      jQuery('.frequently-action').addClass('faq-open').removeClass('faq-close');
      jQuery('.frequently-questions .requently-collapse').hide();
    }
    /* end script faq */


    //maybe auto select club
    var selected_club = '<?php echo $selected_club; ?>';
    if(selected_club != ''){
      jQuery('.select-club .club-'+selected_club).click();
    }
    //clear_url();
    function clear_url() {
      var uri = window.location.toString();
      if (uri.indexOf("?") > 0) {
        var clean_uri = uri.substring(0, uri.indexOf("?"));
        window.history.replaceState({}, document.title, clean_uri);
      }
    }
      var mm_productids = [<?php echo implode(",",lgs_product_mm)?>],
          km_productids = [<?php echo implode(",",lgs_product_km)?>],
          sm_productids = [<?php echo implode(",",lgs_product_sm)?>];
    jQuery('.step1 .select-club .select-club-content').on('click',function(){
        var current = jQuery(this),
            product_type = current.data('select');
        var track = 'trackCustom',
            trackEventName = '',
            productid = jQuery('.step3 .choose-'+product_type+' .product-types-new .club-plan.active').data('product');
        if(productid == undefined || productid ==''){
          if (product_type == 'morpheme')productid = 2592;
          if (product_type == 'kissme')productid = 9999995176;
          if (product_type == 'shadowme')productid = 10002876000;
        }
        var title = jQuery('#LGP_'+productid).data('title'),
            price = jQuery('#LGP_'+productid).data('price');
        if(jQuery.inArray(productid, mm_productids)>=0){
            trackEventName = 'PreCheck1Morph';
        }
        if(jQuery.inArray(productid, km_productids)>=0){
            trackEventName = 'PreCheck1Kiss';
        }
        if(jQuery.inArray(productid, sm_productids)>=0){
            trackEventName = 'PreCheck1Shadow';
        }

        if(trackEventName != ''){
            fbq(track, trackEventName, {
                content_name: title,
                content_category: 'Subscription',
                content_ids: ["'"+productid+"'"],
                content_type: 'product',
                value: price,
                currency: 'USD'
            });
        }
    });
  });
</script>