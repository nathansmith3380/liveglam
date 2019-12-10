<?php
  /**
   * My Account Dashboard
   *
   * Shows the first intro screen on the account dashboard.
   *
   * This template can be overridden by copying it to yourtheme/woocommerce/myaccount/dashboard.php.
   *
   * HOWEVER, on occasion WooCommerce will need to update template files and you
   * (the theme developer) will need to copy the new files to your theme to
   * maintain compatibility. We try to do this as little as possible, but it does
   * happen. When this occurs the version of the template file will be bumped and
   * the readme will list any important changes.
   *
   * @see         https://docs.woocommerce.com/document/template-structure/
   * @author      WooThemes
   * @package     WooCommerce/Templates
   * @version     2.6.0
   */
  liveglam_check_user_login();
  $userID = $current_user->ID;
  $user = get_userdata($userID);
  $refurl = add_query_arg('ref', $user->user_login, site_url(PAGE_REFERRAL));
  $refurl = str_replace(' ', '%20', $refurl);
  $userLevel = Liveglam_User_Level::get_user_level($userID);
  if(in_array($userLevel, array('diamond', 'diamond trial', 'diamond elite'))){
    wp_redirect(home_url('/rewards'));
  }
  $LG_userAvata = lg_get_avatar_for_user($userID, 300);
  $address = WC()->countries->get_address_fields(get_user_meta($userID, 'billing_country', true), 'billing_');
  //$user_subscriptions = wcs_get_users_subscriptions( $userID );
  $user_subscriptions = IzCustomization::get_user_subscription_sort_by_status($userID);
  $subscription_mm = LGS_User_Referrals::get_subscription_data($userID, $user_subscriptions, 'morpheme', MM_MONTHLY, MM_SIXMONTH, MM_ANNUAL);
  $subscription_km = LGS_User_Referrals::get_subscription_data($userID, $user_subscriptions, 'kissme', KM_MONTHLY, KM_SIXMONTH, KM_ANNUAL);
  $subscription_sm = LGS_User_Referrals::get_subscription_data($userID, $user_subscriptions, 'shadowme', SM_MONTHLY, SM_SIXMONTH, SM_ANNUAL);

  $mm_skipped = $km_skipped = $sm_skipped = false;
  if($subscription_mm['subscription']['status'] == 'on-hold' && get_post_meta($subscription_mm['subscription']['ID'], 'hold_month', true) == 1){
    $mm_skipped = true;
  }
  if($subscription_km['subscription']['status'] == 'on-hold' && get_post_meta($subscription_km['subscription']['ID'], 'hold_month', true) == 1){
    $km_skipped = true;
  }
  if($subscription_sm['subscription']['status'] == 'on-hold' && get_post_meta($subscription_sm['subscription']['ID'], 'hold_month', true) == 1){
    $sm_skipped = true;
  }

  //set payment subID for each club: status is active, waitlist, on-hold due failed payment or skipped | use for update payment methods
  $mm_payment_subID = $km_payment_subID = $sm_payment_subID = 0;
  if(in_array($subscription_mm['subscription']['status'], array('active', 'waitlist')) || $mm_skipped || $subscription_mm['notice']['notice_failed']){
    $mm_payment_subID = $subscription_mm['subscription']['ID'];
  }
  if(in_array($subscription_km['subscription']['status'], array('active', 'waitlist')) || $km_skipped || $subscription_km['notice']['notice_failed']){
    $km_payment_subID = $subscription_km['subscription']['ID'];
  }
  if(in_array($subscription_sm['subscription']['status'], array('active', 'waitlist')) || $sm_skipped || $subscription_sm['notice']['notice_failed']){
    $sm_payment_subID = $subscription_sm['subscription']['ID'];
  }

  $display_mm_next_payment = !empty($subscription_mm['time']['next_payment'])?date_i18n(wc_date_format(), $subscription_mm['time']['next_payment']):'';
  $display_km_next_payment = !empty($subscription_km['time']['next_payment'])?date_i18n(wc_date_format(), $subscription_km['time']['next_payment']):'';
  $display_sm_next_payment = !empty($subscription_sm['time']['next_payment'])?date_i18n(wc_date_format(), $subscription_sm['time']['next_payment']):'';

  $userLifetimeReferrals = IzCustomization::count_total_referral($userID);
  //check and reload address book for subscription
  if( class_exists('WC_Address_Book') ){
    WC_Address_Book::lg_reupdate_address_book_for_customer($subscription_mm['subscription']['ID'], $subscription_km['subscription']['ID'], $subscription_sm['subscription']['ID']);
  }
  $userCountry = $current_user->shipping_country?$current_user->shipping_country:$current_user->billing_country;
  $userPoint = RSPointExpiry::get_sum_of_total_earned_points($userID);
  $userPoint = floor($userPoint);
  $redeem_orders = LGS_User_Referrals::lgs_order_redeem_for_user($userID);
  $dob = get_user_meta($userID, '_date_of_birth', true);
  $dob = $dob?date("F d, Y", strtotime($dob)):"";

  $countSubsActive = 0;
  $countSubsActive = ($subscription_mm['subscription']['status'] == 'active')?$countSubsActive + 1:$countSubsActive;
  $countSubsActive = ($subscription_km['subscription']['status'] == 'active')?$countSubsActive + 1:$countSubsActive;
  $countSubsActive = ($subscription_sm['subscription']['status'] == 'active')?$countSubsActive + 1:$countSubsActive;

  $active_status = array('active', 'waitlist');
  $affiliate_link_mm = (in_array($subscription_mm['subscription']['status'], $active_status))?home_url('/monthly_brushes'):home_url(PAGE_PRE_CHECKOUT.'?club=morpheme');
  $affiliate_link_km = (in_array($subscription_km['subscription']['status'], $active_status))?home_url('/monthly_lipstick'):home_url(PAGE_PRE_CHECKOUT.'?club=kissme');
  $affiliate_link_sm = (in_array($subscription_sm['subscription']['status'], $active_status))?home_url('/'.PAGE_SHADOWME_MONTHLY):home_url(PAGE_PRE_CHECKOUT.'?club=shadowme');

  if($countSubsActive > 0):
    $activeMember = '<span><img src="'.get_stylesheet_directory_uri().'/assets/img/icon-green-circle.svg" alt="Active Member"></span>Active Member';
  else:
    $activeMember = '<span><img src="'.get_stylesheet_directory_uri().'/assets/img/icon-yellow-circle.svg" alt="Inactive Member"></span>Inactive Member';
  endif;

  $show_first = liveglam_get_last_subscription_active_for_user($user_subscriptions);

  $last_shop_order = LGS_User_Referrals::lgs_order_redeem_for_user(get_current_user_id(),1,0,true);

  $p_trade_mm = LGS_User_Referrals::trade_product_popup('morpheme');
  $p_trade_km = LGS_User_Referrals::trade_product_popup('kissme');
  $p_trade_sm = LGS_User_Referrals::trade_product_popup('shadowme');

  $waitlist_enable_upgrade_mm = LGS_CHECKOUT_SETTING::lgs_waitlist_enable_upgrade_on_dashboard('morpheme');
  $waitlist_enable_upgrade_km = LGS_CHECKOUT_SETTING::lgs_waitlist_enable_upgrade_on_dashboard('kissme');
  $waitlist_enable_upgrade_sm = LGS_CHECKOUT_SETTING::lgs_waitlist_enable_upgrade_on_dashboard('shadowme');

  $shop_member = LGS_Products::lgs_is_shop_member($userID);

  //new function get data for tab upcomming/progress here
  $data_shop_upcomming = LGS_User_Referrals::lgs_get_data_upcoming('shop', $last_shop_order);
  $data_shop_processed = LGS_User_Referrals::lgs_get_data_processed('shop', $last_shop_order);
  $data_mm_upcomming = LGS_User_Referrals::lgs_get_data_upcoming('morpheme', $subscription_mm);
  $data_mm_processed = LGS_User_Referrals::lgs_get_data_processed('morpheme', $subscription_mm);
  $data_km_upcomming = LGS_User_Referrals::lgs_get_data_upcoming('kissme', $subscription_km);
  $data_km_processed = LGS_User_Referrals::lgs_get_data_processed('kissme', $subscription_km);
  $data_sm_upcomming = LGS_User_Referrals::lgs_get_data_upcoming('shadowme', $subscription_sm);
  $data_sm_processed = LGS_User_Referrals::lgs_get_data_processed('shadowme', $subscription_sm);
?>

<?php do_action('woocommerce_account_dashboard'); ?>

<?php do_action('woocommerce_before_my_account'); ?>

<div class="dashboard-content dashboard-myaccount" xmlns="http://www.w3.org/1999/html">
  <div id="scroller-anchor"></div>
  <?php wc_print_notices(); ?>
  <div class="wrap hide-mobile">
    <div class="dashboard-header-content border-bot">
      <p class="welcome-title">Welcome back, <?php echo $current_user->first_name; ?></p>
      <?php show_dashboard_header_right(); ?>
    </div>
  </div>
  
  <div id="lg-search-overlay"><?php show_general_search_content(); ?></div>

  <section class="dashboard-notice">
    <?php $btn_close = "<a href='javascript:;' onclick='jQuery(this).closest(\".notification\").hide();return false;' class='btn-close'><img alt='Icon Close' src='".get_stylesheet_directory_uri()."/assets/img/icon-close-menu.png'></a>"; ?>
    <div class="info-notice mm-notice show_morpheme">
      <?php if($subscription_mm['notice']['notice_reactivate']){ ?>
        <?php if( !$subscription_mm['action']['reactive_free_gaga'] ){ ?>
          <div class='notification d-none'>
            <p>Oops! We can't send your brushes until you reactivate your account. <a class="btn-reactivate" href="<?php echo $subscription_mm['action']['reactive']; ?>">Reactivate now!</a></p>
            <?php echo $btn_close; ?>
          </div>
        <?php } else { ?>
          <div class='notification d-none'>
            <p>Oops! We can't send your brushes until you reactivate your account. <a class="btn-reactivate" href="<?php echo $subscription_mm['action']['reactive']; ?>">Reactivate & get a FREE brush!</a></p>
            <?php echo $btn_close; ?>
          </div>
        <?php } ?>
      <?php } ?>
      <?php if($subscription_mm['notice']['notice_failed']){ ?>
        <div class='notification'>
          <p>Oops! We can't send your <strong>brushes</strong> until you update your card ending in <span class="card_number"><?php echo $subscription_mm['card']['card_last4']; ?></span>. Update your card <a class="btn-reactivate" href="<?php echo $subscription_mm['action']['reactive']; ?>">here</a>!</p>
          <?php echo $btn_close; ?>
        </div>
      <?php } ?>
    </div>
    <div class="info-notice mm-notice show_kissme">
      <?php if($subscription_km['notice']['notice_reactivate']){ ?>
        <?php if( !$subscription_km['action']['reactive_free_gaga'] ){ ?>
          <div class='notification d-none'>
            <p>Oops! We can't send your lippies until you reactivate your account. <a class="btn-reactivate" href="<?php echo $subscription_km['action']['reactive']; ?>">Reactivate now!</a></p>
            <?php echo $btn_close; ?>
          </div>
        <?php } else { ?>
          <div class='notification d-none'>
            <p>Oops! We can't send your lippies until you reactivate your account. <a class="btn-reactivate" href="<?php echo $subscription_km['action']['reactive']; ?>">Reactivate & get a FREE lippie!</a></p>
            <?php echo $btn_close; ?>
          </div>
        <?php } ?>
      <?php } ?>
      <?php if($subscription_km['notice']['notice_failed']){ ?>
        <div class='notification'>
          <p>Oops! We can't send your <strong>lippies</strong> until you update your card ending in <span class="card_number"><?php echo $subscription_km['card']['card_last4']; ?></span>. Update your card <a class="btn-reactivate" href="<?php echo $subscription_km['action']['reactive']; ?>">here</a>!</p>
          <?php echo $btn_close; ?>
        </div>
      <?php } ?>
    </div>
    <div class="info-notice sm-notice show_shadowme">
      <?php if($subscription_sm['notice']['notice_reactivate']){ ?>
        <?php if( !$subscription_sm['action']['reactive_free_gaga'] ){ ?>
          <div class='notification d-none'>
            <p>Oops! We can't send your palette until you reactivate your account. <a class="btn-reactivate" href="<?php echo $subscription_sm['action']['reactive']; ?>">Reactivate now!</a></p>
            <?php echo $btn_close; ?>
          </div>
        <?php } else { ?>
          <div class='notification d-none'>
            <p>Oops! We can't send your palette until you reactivate your account. <a class="btn-reactivate" href="<?php echo $subscription_sm['action']['reactive']; ?>">Reactivate & get a FREE lippie!</a></p>
            <?php echo $btn_close; ?>
          </div>
        <?php } ?>
      <?php } ?>
      <?php if($subscription_sm['notice']['notice_failed']){ ?>
        <div class='notification'>
          <p>Oops! We can't send your <strong>palette</strong> until you update your card ending in <span class="card_number"><?php echo $subscription_sm['card']['card_last4']; ?></span>. Update your card <a class="btn-reactivate" href="<?php echo $subscription_sm['action']['reactive']; ?>">here</a>!</p>
          <?php echo $btn_close; ?>
        </div>
      <?php } ?>
    </div>
  </section>
  <?php echo do_shortcode('[show_notice_subscribers]'); ?>
  <section class="account-details show-mobile" id="account-details">
    <div class="detail">
      <div class="info-part">
        <div class="user-info">
          <div class="user-info-edit">
            <a href="#" class="setting-myaccount-2"><img alt="Edit Profile" src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/icon-edit-profile-pink.png" />Edit Profile</a>
          </div>
          <div class="wrap">
              <img src="<?php echo $LG_userAvata; ?>" alt="User Avatar" class="user-photo">
            <div class="mobile-part">
              <p class="display-name"><?php echo $current_user->first_name.' '.$current_user->last_name; ?></p>
              <p class="login-name"><?php echo $current_user->user_login; ?></p>
            </div>
          </div>
        </div>
        <?php if($userLevel != 'inactive'): ?>
          <div class="wrap">
            <div class="points">
              <div class="points-data">
                <span class="points-title"><?php echo $userLifetimeReferrals; ?></span>
                <p>REFERRALS<span class="mac-info" data-toggle="tooltip" data-placement="top" title="" data-original-title="Total number of Glammers you referred."><img alt="Info" src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/icon-myaccount-info-new.svg"/></span></p>
              </div>
              <div class="points-separator">&nbsp;</div>
              <div class="points-data">
                <span class="points-title">
                  <?php if($userLevel == 'gold'): ?>
                    <img alt="Gold Tier" src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/icon-reward-tier-gold.png">
                  <?php else: ?>
                    <img alt="Silver Tier" class="d-none d-md-block" src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/icon-reward-tier-silver.png">
                    <img alt="Silver Tier" class="d-md-none" src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/icon-reward-tier-silver-m@3x.png">
                  <?php endif; ?>
                </span>
                <p><?php echo $userLevel; ?><span class="mac-info" data-toggle="tooltip" data-placement="top" title="" data-original-title="Your membership tier."><img alt="Info" src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/icon-myaccount-info-new.svg"/></span></p>
              </div>
              <div class="points-separator">&nbsp;</div>
              <div class="points-data">
                <span class="points-title"><?php echo number_format($userPoint); ?></span>
                <p>POINTS<span class="mac-info" data-toggle="tooltip" data-placement="top" title="" data-original-title="Total points you got for referring new Glammers and being an active member!"><img alt="Info" src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/icon-myaccount-info-new.svg"/></span></p>
              </div>
            </div>
          </div>
        <?php endif; ?>
      </div>
    </div>
  </section>

  <section class="liveglam-orders show-mobile" id="liveglam-orders">
    <div class="wrap">
      <div class="liveglam-orders-content tab-mm-content tab-morpheme">
        <div class='section-header'>
          <div class="section-header-logo">
            <a href="#" class="lgs-action-collap morpheme-collap collap-hide d-none">
              <i class="fas fa-chevron-up"></i>
              <img class="lgs-data-logo" src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/logo-dashboard-mm.svg" alt="MorpheMe Logo" />
            </a>
            <a href="#" class="lgs-action-collap morpheme-collap collap-show">
              <i class="fas fa-chevron-down"></i>
              <img class="lgs-data-logo" src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/logo-dashboard-mm.svg" alt="MorpheMe Logo" />
            </a>
          </div>
          <div class="section-header-status">
            <?php if(in_array($subscription_mm['subscription']['status'],array('cancelled','pending-cancel')) || $subscription_mm['notice']['notice_failed']){ ?>
              <p class="status status-cancelled"><span class="status status-cancelled"></span><?php echo $subscription_mm['subscription']['show_status']; ?></p>
              <?php if(in_array($subscription_mm['subscription']['status'],array('cancelled','pending-cancel'))){ ?>
                <a href="<?php echo $subscription_mm['action']['reactive']; ?>">Reactivate &gt;</a>
              <?php }else{ ?>
                <a href="<?php echo $subscription_mm['action']['reactive']; ?>">Update Card &gt;</a>
              <?php } ?>
            <?php } else { ?>
              <p class="status status-<?php echo $subscription_mm['subscription']['status']; ?>"><span class="status status-<?php echo $subscription_mm['subscription']['status']; ?>"></span><?php echo $subscription_mm['subscription']['show_status']; ?></p>
              <?php if ($subscription_mm['subscription']['status'] === 'on-hold') { ?>
                <a href="#" class="skip_reactive_mm">Undo Skip &gt;</a>
              <?php } ?>
            <?php } ?>
          </div>
        </div>
        <div class="section-bottom d-none">
        <?php if ($subscription_mm['subscription']['status'] === 'pending-cancel') { ?>
          <div class="subscription-cancel-desc">
            Your account has been canceled. You’ll still have access to all your member benefits until
            <strong><?php echo $subscription_mm['time']['end_date']; ?></strong>
          </div>
        <?php } ?>
        <?php if ($subscription_mm['subscription']['status'] === 'cancelled') { ?>
          <div class="subscription-cancel-desc">
            Your account has been canceled.
          </div>
        <?php } ?>
        <?php if($subscription_mm['subscription']['status'] != 'not enrolled'){ ?>
          <ul class="nav nav-tabs data-nav" role="tablist">
            <li class="nav-item <?php echo $subscription_mm['show_tab'] == 'upcoming'?'active':''; ?>">
              <a class="nav-link <?php echo $subscription_mm['show_tab'] == 'upcoming'?'active':''; ?>" id="upcoming-tab-mm" data-toggle="tab" href="#upcoming-item-mm" role="tab" aria-controls="home" aria-selected="true">Upcoming</a>
            </li>
            <li class="nav-item <?php echo $subscription_mm['show_tab'] == 'processed'?'active':''; ?>">
              <a class="nav-link <?php echo $subscription_mm['show_tab'] == 'processed'?'active':''; ?>" id="processed-tab-mm" data-toggle="tab" href="#processed-item-mm" role="tab" aria-controls="profile" aria-selected="false">Latest Order</a>
            </li>
          </ul>
          <div class="data-content tab-content">
            <div class="order-item tab-pane fade <?php echo $subscription_mm['show_tab'] == 'upcoming'?'active show':''; ?>" id="upcoming-item-mm" role="tabpanel" aria-labelledby="upcoming-tab-mm">
              <div class="liveglam-order-list">
                <?php LGS_User_Referrals::lgs_get_tab_upcoming('morpheme',$data_mm_upcomming); ?>
              </div>
            </div>
            <div class="order-item tab-pane fade <?php echo $subscription_mm['show_tab'] == 'processed'?'active show':''; ?>" id="processed-item-mm" role="tabpanel" aria-labelledby="processed-tab-mm">
              <div class="liveglam-order-list">
                <?php LGS_User_Referrals::lgs_get_tab_processed('morpheme',$data_mm_processed); ?>
              </div>
            </div>
          </div>
        <?php }else{
          wc_get_template('myaccount/form-upcoming-processed/upcoming/club-notenrolled-mobile.php',$data_mm_upcomming);
        } ?>
        </div>
      </div>
      <div class="liveglam-orders-content tab-km-content tab-kissme">
        <div class='section-header'>
          <div class="section-header-logo">
            <a href="#" class="lgs-action-collap kissme-collap collap-hide d-none">
              <i class="fas fa-chevron-up"></i>
              <img class="lgs-data-logo" src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/logo-dashboard-km.svg" alt="KissMe Logo" />
            </a>
            <a href="#" class="lgs-action-collap kissme-collap collap-show">
              <i class="fas fa-chevron-down"></i>
              <img class="lgs-data-logo" src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/logo-dashboard-km.svg" alt="KissMe Logo" />
            </a>
          </div>
          <div class="section-header-status">
            <?php if(in_array($subscription_km['subscription']['status'],array('cancelled','pending-cancel')) || $subscription_km['notice']['notice_failed']){ ?>
              <p class="status status-cancelled"><span class="status status-cancelled"></span><?php echo $subscription_km['subscription']['show_status']; ?></p>
              <?php if(in_array($subscription_km['subscription']['status'],array('cancelled','pending-cancel'))){ ?>
                <a href="<?php echo $subscription_km['action']['reactive']; ?>">Reactivate &gt;</a>
              <?php }else{ ?>
                <a href="<?php echo $subscription_km['action']['reactive']; ?>">Update Card &gt;</a>
              <?php } ?>
            <?php } else { ?>
              <p class="status status-<?php echo $subscription_km['subscription']['status']; ?>"><span class="status status-<?php echo $subscription_km['subscription']['status']; ?>"></span><?php echo $subscription_km['subscription']['show_status']; ?></p>
              <?php if ($subscription_km['subscription']['status'] === 'on-hold') { ?>
                <a href="#" class="skip_reactive_km">Undo Skip &gt;</a>
              <?php } ?>
            <?php } ?>
          </div>
        </div>
        <div class="section-bottom d-none">
        <?php if ($subscription_km['subscription']['status'] === 'pending-cancel') { ?>
          <div class="subscription-cancel-desc">
            Your account has been canceled. You’ll still have access to all your member benefits until
            <strong><?php echo $subscription_km['time']['end_date']; ?></strong>
          </div>
        <?php } ?>
        <?php if ($subscription_km['subscription']['status'] === 'cancelled') { ?>
          <div class="subscription-cancel-desc">
            Your account has been canceled.
          </div>
        <?php } ?>
        <?php if($subscription_km['subscription']['status'] != 'not enrolled'){ ?>
          <ul class="nav nav-tabs data-nav" role="tablist">
            <li class="nav-item <?php echo $subscription_km['show_tab'] == 'upcoming'?'active':''; ?>">
              <a class="nav-link <?php echo $subscription_km['show_tab'] == 'upcoming'?'active':''; ?>" id="upcoming-tab-km" data-toggle="tab" href="#upcoming-item-km" role="tab" aria-controls="home" aria-selected="true">Upcoming</a>
            </li>
            <li class="nav-item <?php echo $subscription_km['show_tab'] == 'processed'?'active':''; ?>">
              <a class="nav-link <?php echo $subscription_km['show_tab'] == 'processed'?'active':''; ?>" id="processed-tab-km" data-toggle="tab" href="#processed-item-km" role="tab" aria-controls="profile" aria-selected="false">Latest Order</a>
            </li>
          </ul>
          <div class="data-content tab-content">
            <div class="order-item tab-pane fade <?php echo $subscription_km['show_tab'] == 'upcoming'?'active show':''; ?>" id="upcoming-item-km" role="tabpanel" aria-labelledby="upcoming-tab-km">
              <div class="liveglam-order-list">
                <?php LGS_User_Referrals::lgs_get_tab_upcoming('kissme',$data_km_upcomming); ?>
              </div>
            </div>
            <div class="order-item tab-pane fade <?php echo $subscription_km['show_tab'] == 'processed'?'active show':''; ?>" id="processed-item-km" role="tabpanel" aria-labelledby="processed-tab-km">
              <div class="liveglam-order-list">
                <?php LGS_User_Referrals::lgs_get_tab_processed('kissme',$data_km_processed); ?>
              </div>
            </div>
          </div>
        <?php }else{
          wc_get_template('myaccount/form-upcoming-processed/upcoming/club-notenrolled-mobile.php',$data_km_upcomming);
        } ?>
        </div>
      </div>
      <div class="liveglam-orders-content tab-sm-content tab-shadowme">
        <div class='section-header'>
          <div class="section-header-logo">
            <a href="#" class="lgs-action-collap shadowme-collap collap-hide d-none">
              <i class="fas fa-chevron-up"></i>
              <img class="lgs-data-logo" src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/logo-dashboard-sm.svg" alt="ShadowMe Logo" />
            </a>
            <a href="#" class="lgs-action-collap shadowme-collap collap-show">
              <i class="fas fa-chevron-down"></i>
              <img class="lgs-data-logo" src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/logo-dashboard-sm.svg" alt="ShadowMe Logo" />
            </a>
          </div>
          <div class="section-header-status">
            <?php if(in_array($subscription_sm['subscription']['status'],array('cancelled','pending-cancel')) || $subscription_sm['notice']['notice_failed']){ ?>
              <p class="status status-cancelled"><span class="status status-cancelled"></span><?php echo $subscription_sm['subscription']['show_status']; ?></p>
              <?php if(in_array($subscription_sm['subscription']['status'],array('cancelled','pending-cancel'))){ ?>
                <a href="<?php echo $subscription_sm['action']['reactive']; ?>">Reactivate &gt;</a>
              <?php }else{ ?>
                <a href="<?php echo $subscription_sm['action']['reactive']; ?>">Update Card &gt;</a>
              <?php } ?>
            <?php } else { ?>
              <p class="status status-<?php echo $subscription_sm['subscription']['status']; ?>"><span class="status status-<?php echo $subscription_sm['subscription']['status']; ?>"></span><?php echo $subscription_sm['subscription']['show_status']; ?></p>
              <?php if ($subscription_sm['subscription']['status'] === 'on-hold') { ?>
                <a href="#" class="skip_reactive_sm">Undo Skip &gt;</a>
              <?php } ?>
            <?php } ?>
          </div>
        </div>
        <div class="section-bottom d-none">
        <?php if ($subscription_sm['subscription']['status'] === 'pending-cancel') { ?>
          <div class="subscription-cancel-desc">
            Your account has been canceled. You’ll still have access to all your member benefits until
            <strong><?php echo $subscription_sm['time']['end_date']; ?></strong>
          </div>
        <?php } ?>
        <?php if ($subscription_sm['subscription']['status'] === 'cancelled') { ?>
          <div class="subscription-cancel-desc">
            Your account has been canceled.
          </div>
        <?php } ?>
        <?php if($subscription_sm['subscription']['status'] != 'not enrolled'){ ?>
          <ul class="nav nav-tabs data-nav" role="tablist">
            <li class="nav-item <?php echo $subscription_sm['show_tab'] == 'upcoming'?'active':''; ?>">
              <a class="nav-link <?php echo $subscription_sm['show_tab'] == 'upcoming'?'active':''; ?>" id="upcoming-tab-sm" data-toggle="tab" href="#upcoming-item-sm" role="tab" aria-controls="home" aria-selected="true">Upcoming</a>
            </li>
            <li class="nav-item <?php echo $subscription_sm['show_tab'] == 'processed'?'active':''; ?>">
              <a class="nav-link <?php echo $subscription_sm['show_tab'] == 'processed'?'active':''; ?>" id="processed-tab-sm" data-toggle="tab" href="#processed-item-sm" role="tab" aria-controls="profile" aria-selected="false">Latest Order</a>
            </li>
          </ul>
          <div class="data-content tab-content">
            <div class="order-item tab-pane fade <?php echo $subscription_sm['show_tab'] == 'upcoming'?'active show':''; ?>" id="upcoming-item-sm" role="tabpanel" aria-labelledby="upcoming-tab-sm">
              <div class="liveglam-order-list">
                <?php LGS_User_Referrals::lgs_get_tab_upcoming('shadowme',$data_sm_upcomming); ?>
              </div>
            </div>
            <div class="order-item tab-pane fade <?php echo $subscription_sm['show_tab'] == 'processed'?'active show':''; ?>" id="processed-item-sm" role="tabpanel" aria-labelledby="processed-tab-sm">
              <div class="liveglam-order-list">
                <?php LGS_User_Referrals::lgs_get_tab_processed('shadowme',$data_sm_processed); ?>
              </div>
            </div>
          </div>
        <?php }else{
          wc_get_template('myaccount/form-upcoming-processed/upcoming/club-notenrolled-mobile.php',$data_sm_upcomming);
        } ?>
        </div>
      </div>
      <div class="liveglam-orders-content tab-shop-content tab-shop">
        <div class="liveglam-orders-title">
          <div class="section-header-logo">
            <a href="#" class="lgs-action-collap shop-collap collap-hide d-none">
              <i class="fas fa-chevron-up"></i>
              <h2>Shop</h2>
            </a>
            <a href="#" class="lgs-action-collap shop-collap collap-show">
              <i class="fas fa-chevron-down"></i>
              <h2>Shop</h2>
            </a>
          </div>
          <?php if(!empty($last_shop_order)){?>
            <a href="javascript:;" class="show-redeem-order">View Past Orders ></a>
          <?php } ?>
        </div>
        <div class="section-bottom d-none">
        <ul class="nav nav-tabs data-nav" role="tablist">
          <li class="nav-item active">
            <a class="nav-link active" id="upcoming-tab" data-toggle="tab" href="#upcoming-item" role="tab" aria-controls="home" aria-selected="true">Upcoming</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" id="processed-tab" data-toggle="tab" href="#processed-item" role="tab" aria-controls="profile" aria-selected="false">Latest Order</a>
          </li>
        </ul>
        <div class="data-content tab-content">
          <div class="order-item tab-pane fade active show" id="upcoming-item" role="tabpanel" aria-labelledby="upcoming-tab">
            <div class="liveglam-order-list">
              <?php LGS_User_Referrals::lgs_get_tab_upcoming('shop',$data_shop_upcomming,false); ?>
            </div>
          </div>
          <div class="order-item tab-pane fade" id="processed-item" role="tabpanel" aria-labelledby="processed-tab">
            <div class="liveglam-order-list">
              <?php LGS_User_Referrals::lgs_get_tab_processed('shop',$data_shop_processed,false); ?>
            </div>
          </div>
        </div>
        </div>
      </div>
    </div>
  </section>

  <section class="liveglam-subscriptions" id="liveglam-subscriptions">
    <div class="wrap hide-mobile">

      <div id="morpheme-subscription" class="lgs-data-club lgs-data-mm lgs-data-morpheme panel-opened">
        <div class="lgs-data-top lgs-data-content">
          <img class="lgs-data-logo" src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/logo-dashboard-mm.svg" alt="MorpheMe Logo" />
          <div class="lgs-data-status">
            <div class="lgs-status-content">
              <?php if(in_array($subscription_mm['subscription']['status'],array('cancelled','pending-cancel')) || $subscription_mm['notice']['notice_failed']){ ?>
                <div class="lgs-status-left">
                  <p class="status status-cancelled"><span class="status status-cancelled"></span>
                    <?php echo ($subscription_mm['subscription']['status'] === 'pending-cancel')?'Active Until '.$subscription_mm['time']['end_date']:$subscription_mm['subscription']['show_status']; ?>
                  </p>
                </div>
                <div class="lgs-status-right">
                  <?php if(in_array($subscription_mm['subscription']['status'],array('cancelled','pending-cancel'))){ ?>
                    <a href="<?php echo $subscription_mm['action']['reactive']; ?>">Reactivate</a>
                  <?php }else{ ?>
                    <a href="<?php echo $subscription_mm['action']['reactive']; ?>">Update Card</a>
                  <?php } ?>
                  <div class="lgs-status-collap">
                    <a href="#" class="lgs-action-collap morpheme-collap collap-hide d-none"><i class="fas fa-chevron-up"></i></a>
                    <a href="#" class="lgs-action-collap morpheme-collap collap-show"><i class="fas fa-chevron-down"></i></a>
                  </div>
                </div>
              <?php }else{ ?>
                <?php if( !empty( $subscription_mm['subscription']['type_display'] ) ){ ?>
                  <div class="lgs-status-left"><?php echo $subscription_mm['subscription']['type_display']; ?> Subscription</div>
                <?php } ?>
                <div class="lgs-status-right">
                  <p class="status status-<?php echo $subscription_mm['subscription']['status']; ?>"><span class="status status-<?php echo $subscription_mm['subscription']['status']; ?>"></span><?php echo $subscription_mm['subscription']['show_status']; ?></p>
                  <div class="lgs-status-collap">
                    <a href="#" class="lgs-action-collap morpheme-collap collap-hide d-none"><i class="fas fa-chevron-up"></i></a>
                    <a href="#" class="lgs-action-collap morpheme-collap collap-show"><i class="fas fa-chevron-down"></i></a>
                  </div>
                </div>
              <?php } ?>
            </div>
          </div>
        </div>
        <div class="lgs-panel-collap d-none">
          <?php if (in_array($subscription_mm['subscription']['status'], array('pending-cancel'))) { ?>
            <div class="cancelled-alert-section">
              <span>Your account has been canceled. You’ll still have access to all your member benefits untill <span class="cancelled-alert-date"><?php echo $subscription_mm['time']['end_date']; ?></span></span>
            </div>
          <?php } ?>
          <?php if (in_array($subscription_mm['subscription']['status'], array('cancelled'))) { ?>
            <div class="cancelled-alert-section">
              <span>Your account has been cancelled.</span>
            </div>
          <?php } ?>
          <div class="lgs-data-mid lgs-data-content">
            <?php LGS_User_Referrals::lgs_get_tab_upcoming('morpheme',$data_mm_upcomming,true); ?>
            <?php LGS_User_Referrals::lgs_get_tab_processed('morpheme',$data_mm_processed,true); ?>
          </div>
          <?php if( !in_array( $subscription_mm['subscription']['status'], array('cancelled','not enrolled'))){ ?>
            <div class="lgs-data-mid lgs-data-content">
              <div class="lgs-data-info">
                <?php if(!empty($subscription_mm['time']['next_payment'])){ ?>
                  <?php if(!empty($subscription_mm['action']['change_date'])){ ?>
                    <!--case show edit billing date -->
                    <p class="lgdc-shipping-data">
                      <a class="edit_schedule lgdc-shipping-title" data-edit="schedule" data-id="<?php echo $subscription_mm['subscription']['ID']; ?>" data-type="morpheme">
                        <img alt="Next Billing Date" src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/icon-edit-profile-pink.png" />Next Billing Date:&nbsp;
                      </a><?php echo date('F d, Y',$subscription_mm['time']['next_payment']); ?>
                    </p>
                  <?php } else { ?>
                    <!--case show edit payment -->
                    <p class="lgdc-shipping-data">
                      <a href="javascript:;" class="edit_billing lgdc-shipping-title" data-edit="billing" data-id="<?php echo $subscription_mm['subscription']['ID']; ?>" data-type="morpheme">
                        <img alt="Next Billing Date" src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/icon-edit-profile-pink.png" />Next Billing Date:&nbsp;
                      </a><?php echo date('F d, Y',$subscription_mm['time']['next_payment']); ?>
                    </p>
                  <?php } ?>
                <?php } ?>
                <?php if(!empty($subscription_mm['card']['card_last4'])){ ?>
                  <p class="lgdc-shipping-data d-none">
                    <a href="javascript:;" class="edit_billing lgdc-shipping-title" data-edit="billing" data-id="<?php echo $subscription_mm['subscription']['ID']; ?>" data-type="morpheme">
                      <img alt="Card Info" src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/icon-edit-profile-pink.png" />From card ending with:&nbsp;
                    </a><?php echo $subscription_mm['card']['card_last4']; ?>
                  </p>
                <?php } ?>
                <p class="lgdc-shipping-data">
                  <a class="edit_shipping lgdc-shipping-title" data-edit="shipping" data-id="<?php echo $subscription_mm['subscription']['ID']; ?>" data-type="morpheme">
                    <img alt="Shipping" src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/icon-edit-profile-pink.png" />Shipping:&nbsp;
                  </a><?php echo str_replace("<br/>",", ",$subscription_mm['shipping']['shipping_address']); ?>
                </p>
              </div>
              <div class="lgs-data-info">
                <div class="lgdc-action">
                  <?php if(in_array($subscription_mm['subscription']['status'],array('cancelled','pending-cancel'))){ ?>
                    <a href="<?php echo $subscription_mm['action']['reactive']; ?>">
                      <div class="lgdc-action-button">
                        <img alt="Reactivate Subscription" src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/icon-myaccount-reactivate.png" />Reactivate Subscription
                      </div>
                    </a>
                  <?php } ?>
                  <?php if(!empty($subscription_mm['action']['cancel'])){ ?>
                    <a class="mm_cancel_action">
                      <div class="lgdc-action-button">
                        <img alt="Cancel Membership" src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/icon-myaccount-cancel.png" />Cancel Membership
                      </div>
                    </a>
                  <?php } ?>
                  <?php if(!empty($subscription_mm['action']['skip'])){ ?>
                    <a class="mm_skip_action">
                      <div class="lgdc-action-button">
                        <img alt="Skip This Month" src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/icon-myaccount-skip.png" />Skip This Month
                      </div>
                    </a>
                  <?php } ?>
                </div>
              </div>
            </div>
          <?php } ?>
        </div>
      </div>

      <div id="kissme-subscription" class="lgs-data-club lgs-data-km lgs-data-kissme panel-opened">
        <div class="lgs-data-top lgs-data-content">
          <img class="lgs-data-logo" src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/logo-dashboard-km.svg" alt="KissMe Logo" />
          <div class="lgs-data-status">
            <div class="lgs-status-content">
              <?php if(in_array($subscription_km['subscription']['status'],array('cancelled','pending-cancel')) || $subscription_km['notice']['notice_failed']){ ?>
                <div class="lgs-status-left">
                  <p class="status status-cancelled"><span class="status status-cancelled"></span>
                    <?php echo ($subscription_km['subscription']['status'] === 'pending-cancel')?'Active Until '.$subscription_km['time']['end_date']:$subscription_km['subscription']['show_status']; ?>
                  </p>
                </div>
                <div class="lgs-status-right">
                  <?php if(in_array($subscription_km['subscription']['status'],array('cancelled','pending-cancel'))){ ?>
                    <a href="<?php echo $subscription_km['action']['reactive']; ?>">Reactivate</a>
                  <?php }else{ ?>
                    <a href="<?php echo $subscription_km['action']['reactive']; ?>">Update Card</a>
                  <?php } ?>
                  <div class="lgs-status-collap">
                    <a href="#" class="lgs-action-collap kissme-collap collap-hide d-none"><i class="fas fa-chevron-up"></i></a>
                    <a href="#" class="lgs-action-collap kissme-collap collap-show"><i class="fas fa-chevron-down"></i></a>
                  </div>
                </div>
              <?php }else{ ?>
                <?php if( !empty( $subscription_km['subscription']['type_display'] ) ){ ?>
                  <div class="lgs-status-left"><?php echo $subscription_km['subscription']['type_display']; ?> Subscription</div>
                <?php } ?>
                <div class="lgs-status-right">
                  <p class="status status-<?php echo $subscription_km['subscription']['status']; ?>"><span class="status status-<?php echo $subscription_km['subscription']['status']; ?>"></span><?php echo $subscription_km['subscription']['show_status']; ?></p>
                  <div class="lgs-status-collap">
                    <a href="#" class="lgs-action-collap kissme-collap collap-hide d-none"><i class="fas fa-chevron-up"></i></a>
                    <a href="#" class="lgs-action-collap kissme-collap collap-show"><i class="fas fa-chevron-down"></i></a>
                  </div>
                </div>
              <?php } ?>
            </div>
          </div>
        </div>
        <div class="lgs-panel-collap d-none">
          <?php if (in_array($subscription_km['subscription']['status'], array('pending-cancel'))) { ?>
            <div class="cancelled-alert-section">
              <span>Your account has been canceled. You’ll still have access to all your member benefits untill <span class="cancelled-alert-date"><?php echo $subscription_km['time']['end_date']; ?></span></span>
            </div>
          <?php } ?>
          <?php if (in_array($subscription_km['subscription']['status'], array('cancelled'))) { ?>
            <div class="cancelled-alert-section">
              <span>Your account has been cancelled.</span>
            </div>
          <?php } ?>
          <div class="lgs-data-mid lgs-data-content">
            <?php LGS_User_Referrals::lgs_get_tab_upcoming('kissme',$data_km_upcomming,true); ?>
            <?php LGS_User_Referrals::lgs_get_tab_processed('kissme',$data_km_processed,true); ?>
          </div>
          <?php if( !in_array( $subscription_km['subscription']['status'], array('cancelled','not enrolled'))){ ?>
            <div class="lgs-data-mid lgs-data-content">
              <div class="lgs-data-info">
                <?php if(!empty($subscription_km['time']['next_payment'])){ ?>
                  <?php if(!empty($subscription_km['action']['change_date'])){ ?>
                    <!--case show edit billing date -->
                    <p class="lgdc-shipping-data">
                      <a class="edit_schedule lgdc-shipping-title" data-edit="schedule" data-id="<?php echo $subscription_km['subscription']['ID']; ?>" data-type="kissme">
                        <img alt="Next Billing Date" src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/icon-edit-profile-pink.png" />Next Billing Date:&nbsp;
                      </a><?php echo date('F d, Y',$subscription_km['time']['next_payment']); ?>
                    </p>
                  <?php } else { ?>
                    <!--case show edit payment -->
                    <p class="lgdc-shipping-data">
                      <a href="javascript:;" class="edit_billing lgdc-shipping-title" data-edit="billing" data-id="<?php echo $subscription_km['subscription']['ID']; ?>" data-type="kissme">
                        <img alt="Next Billing Date" src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/icon-edit-profile-pink.png" />Next Billing Date:&nbsp;
                      </a><?php echo date('F d, Y',$subscription_km['time']['next_payment']); ?>
                    </p>
                  <?php } ?>
                <?php } ?>
                <?php if(!empty($subscription_km['card']['card_last4'])){ ?>
                  <p class="lgdc-shipping-data d-none">
                    <a href="javascript:;" class="edit_billing lgdc-shipping-title" data-edit="billing" data-id="<?php echo $subscription_km['subscription']['ID']; ?>" data-type="kissme">
                      <img alt="Card Info" src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/icon-edit-profile-pink.png" />From card ending with:&nbsp;
                    </a><?php echo $subscription_km['card']['card_last4']; ?>
                  </p>
                <?php } ?>
                <p class="lgdc-shipping-data">
                  <a class="edit_shipping lgdc-shipping-title" data-edit="shipping" data-id="<?php echo $subscription_km['subscription']['ID']; ?>" data-type="kissme">
                    <img alt="Shipping" src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/icon-edit-profile-pink.png" />Shipping:&nbsp;
                  </a><?php echo str_replace("<br/>",", ",$subscription_km['shipping']['shipping_address']); ?>
                </p>
              </div>
              <div class="lgs-data-info">
                <div class="lgdc-action">
                  <?php if(in_array($subscription_km['subscription']['status'],array('cancelled','pending-cancel'))){ ?>
                    <a href="<?php echo $subscription_km['action']['reactive']; ?>">
                      <div class="lgdc-action-button">
                        <img alt="Reactivate Subscription" src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/icon-myaccount-reactivate.png" />Reactivate Subscription
                      </div>
                    </a>
                  <?php } ?>
                  <?php if(!empty($subscription_km['action']['cancel'])){ ?>
                    <a class="km_cancel_action">
                      <div class="lgdc-action-button">
                        <img alt="Cancel Membership" src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/icon-myaccount-cancel.png" />Cancel Membership
                      </div>
                    </a>
                  <?php } ?>
                  <?php if(!empty($subscription_km['action']['skip'])){ ?>
                    <a class="km_skip_action">
                      <div class="lgdc-action-button">
                        <img alt="Skip This Month" src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/icon-myaccount-skip.png" />Skip This Month
                      </div>
                    </a>
                  <?php } ?>
                </div>
              </div>
            </div>
          <?php } ?>
        </div>
      </div>

      <div id="shadowme-subscription" class="lgs-data-club lgs-data-sm lgs-data-shadowme panel-opened">
        <div class="lgs-data-top lgs-data-content">
          <img class="lgs-data-logo" src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/logo-dashboard-sm.svg" alt="ShadowMe Logo" />
          <div class="lgs-data-status">
            <div class="lgs-status-content">
              <?php if(in_array($subscription_sm['subscription']['status'],array('cancelled','pending-cancel')) || $subscription_sm['notice']['notice_failed']){ ?>
                <div class="lgs-status-left">
                  <p class="status status-cancelled"><span class="status status-cancelled"></span>
                    <?php echo ($subscription_sm['subscription']['status'] === 'pending-cancel')?'Active Until '.$subscription_sm['time']['end_date']:$subscription_sm['subscription']['show_status']; ?>
                  </p>
                </div>
                <div class="lgs-status-right">
                  <?php if(in_array($subscription_sm['subscription']['status'],array('cancelled','pending-cancel'))){ ?>
                    <a href="<?php echo $subscription_sm['action']['reactive']; ?>">Reactivate</a>
                  <?php }else{ ?>
                    <a href="<?php echo $subscription_sm['action']['reactive']; ?>">Update Card</a>
                  <?php } ?>
                  <div class="lgs-status-collap">
                    <a href="#" class="lgs-action-collap shadowme-collap collap-hide d-none"><i class="fas fa-chevron-up"></i></a>
                    <a href="#" class="lgs-action-collap shadowme-collap collap-show"><i class="fas fa-chevron-down"></i></a>
                  </div>
                </div>
              <?php }else{ ?>
                <?php if( !empty( $subscription_sm['subscription']['type_display'] ) ){ ?>
                  <div class="lgs-status-left"><?php echo $subscription_sm['subscription']['type_display']; ?> Subscription</div>
                <?php } ?>
                <div class="lgs-status-right">
                  <p class="status status-<?php echo $subscription_sm['subscription']['status']; ?>"><span class="status status-<?php echo $subscription_sm['subscription']['status']; ?>"></span><?php echo $subscription_sm['subscription']['show_status']; ?></p>
                  <div class="lgs-status-collap">
                    <a href="#" class="lgs-action-collap shadowme-collap collap-hide d-none"><i class="fas fa-chevron-up"></i></a>
                    <a href="#" class="lgs-action-collap shadowme-collap collap-show"><i class="fas fa-chevron-down"></i></a>
                  </div>
                </div>
              <?php } ?>
            </div>
          </div>
        </div>
        <div class="lgs-panel-collap d-none">
          <?php if (in_array($subscription_sm['subscription']['status'], array('pending-cancel'))) { ?>
            <div class="cancelled-alert-section">
              <span>Your account has been canceled. You’ll still have access to all your member benefits untill <span class="cancelled-alert-date"><?php echo $subscription_sm['time']['end_date']; ?></span></span>
            </div>
          <?php } ?>
          <?php if (in_array($subscription_sm['subscription']['status'], array('cancelled'))) { ?>
            <div class="cancelled-alert-section">
              <span>Your account has been cancelled.</span>
            </div>
          <?php } ?>
          <div class="lgs-data-mid lgs-data-content">
            <?php LGS_User_Referrals::lgs_get_tab_upcoming('shadowme',$data_sm_upcomming,true); ?>
            <?php LGS_User_Referrals::lgs_get_tab_processed('shadowme',$data_sm_processed,true); ?>
          </div>
          <?php if( !in_array( $subscription_sm['subscription']['status'], array('cancelled','not enrolled'))){ ?>
            <div class="lgs-data-mid lgs-data-content">
              <div class="lgs-data-info">
                <?php if(!empty($subscription_sm['time']['next_payment'])){ ?>
                  <?php if(!empty($subscription_sm['action']['change_date'])){ ?>
                    <!--case show edit billing date -->
                    <p class="lgdc-shipping-data">
                      <a class="edit_schedule lgdc-shipping-title" data-edit="schedule" data-id="<?php echo $subscription_sm['subscription']['ID']; ?>" data-type="shadowme">
                        <img alt="Next Billing Date" src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/icon-edit-profile-pink.png" />Next Billing Date:&nbsp;
                      </a><?php echo date('F d, Y',$subscription_sm['time']['next_payment']); ?>
                    </p>
                  <?php } else { ?>
                    <!--case show edit payment -->
                    <p class="lgdc-shipping-data">
                      <a href="javascript:;" class="edit_billing lgdc-shipping-title" data-edit="billing" data-id="<?php echo $subscription_sm['subscription']['ID']; ?>" data-type="shadowme">
                        <img alt="Next Billing Date" src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/icon-edit-profile-pink.png" />Next Billing Date:&nbsp;
                      </a><?php echo date('F d, Y',$subscription_sm['time']['next_payment']); ?>
                    </p>
                  <?php } ?>
                <?php } ?>
                <?php if(!empty($subscription_sm['card']['card_last4'])){ ?>
                  <p class="lgdc-shipping-data d-none">
                    <a href="javascript:;" class="edit_billing lgdc-shipping-title" data-edit="billing" data-id="<?php echo $subscription_sm['subscription']['ID']; ?>" data-type="shadowme">
                      <img alt="Card Info" src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/icon-edit-profile-pink.png" />From card ending with:&nbsp;
                    </a><?php echo $subscription_sm['card']['card_last4']; ?>
                  </p>
                <?php } ?>
                <p class="lgdc-shipping-data">
                  <a class="edit_shipping lgdc-shipping-title" data-edit="shipping" data-id="<?php echo $subscription_sm['subscription']['ID']; ?>" data-type="shadowme">
                    <img alt="Shipping" src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/icon-edit-profile-pink.png" />Shipping:&nbsp;
                  </a><?php echo str_replace("<br/>",", ",$subscription_sm['shipping']['shipping_address']); ?>
                </p>
              </div>
              <div class="lgs-data-info">
                <div class="lgdc-action">
                  <?php if(in_array($subscription_sm['subscription']['status'],array('cancelled','pending-cancel'))){ ?>
                    <a href="<?php echo $subscription_sm['action']['reactive']; ?>">
                      <div class="lgdc-action-button">
                        <img alt="Reactivate Subscription" src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/icon-myaccount-reactivate.png" />Reactivate Subscription
                      </div>
                    </a>
                  <?php } ?>
                  <?php if(!empty($subscription_sm['action']['cancel'])){ ?>
                    <a class="sm_cancel_action">
                      <div class="lgdc-action-button">
                        <img alt="Cancel Membership" src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/icon-myaccount-cancel.png" />Cancel Membership
                      </div>
                    </a>
                  <?php } ?>
                  <?php if(!empty($subscription_sm['action']['skip'])){ ?>
                    <a class="sm_skip_action">
                      <div class="lgdc-action-button">
                        <img alt="Skip This Month" src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/icon-myaccount-skip.png" />Skip This Month
                      </div>
                    </a>
                  <?php } ?>
                </div>
              </div>
            </div>
          <?php } ?>
        </div>
      </div>

      <div class="lgs-data-club lgs-data-shop">
        <div class="lgs-data-top lgs-data-content">
          <p class="lgs-data-logo">SHOP</p>
          <div class="lgs-data-status">
            <div class="lgs-status-content">
              <div class="lgs-status-right">
                <div class="lgs-status-collap">
                  <a href="#" class="lgs-action-collap shop-collap collap-hide d-none"><i class="fas fa-chevron-up"></i></a>
                  <a href="#" class="lgs-action-collap shop-collap collap-show"><i class="fas fa-chevron-down"></i></a>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="lgs-panel-collap d-none">
          <div class="lgs-data-mid lgs-data-content">
            <?php LGS_User_Referrals::lgs_get_tab_upcoming('shop',$data_shop_upcomming,true); ?>
            <?php LGS_User_Referrals::lgs_get_tab_processed('shop',$data_shop_processed,true); ?>
          </div>
        </div>
      </div>

    </div>

    <?php if(function_exists( 'wc_store_credit_get_customer_coupons' )){
      if ( $coupons = wc_store_credit_get_customer_coupons( $userID ) ) { ?>
        <div class="wrap store-credit">
          <h2>Store Credit<span class="pink-short-border"></span></h2>
          <div class="store-credit-content">
            <?php foreach ( $coupons as $coupon ) {
              $coupon_code = $coupon->get_code();
              if ( 'store_credit' === $coupon->get_discount_type() ) { ?>
                <p>You have <?php echo '$'.( $coupon->get_amount() ); ?> store credit, use the coupon code mentioned below</p>
                <h2 class="code"><?php echo $coupon_code; ?>
                  <div class="copy-action">
                    <button class="btn lgs-copy btn-primary btn-sm btn-vw condensed">Copy Coupon</button>
                    <label class="d-none" for="<?php echo $coupon_code; ?>">&nbsp;</label>
                    <input type="text" class="lgs-target" value="<?php echo $coupon_code; ?>" id="<?php echo $coupon_code; ?>" readonly>
                  </div>
                </h2>
            <?php } } ?>
          </div>
        </div>
      <?php } } ?>
  </section>

  <section class="offer-cards d-none" id="offer-cards">
    <div class="wrap">
      <div class="offer-cards-content">
        <div class="owl-carousel lgs-offer-cards">

          <?php echo do_shortcode("[bianca_master_class_dashboard_banner]"); ?>
          <?php echo do_shortcode("[breast_cancer_awareness_banner]"); ?>

          <?php if($subscription_mm['button']['show_upgrade']): ?>
            <?php if($subscription_mm['subscription']['status'] != 'waitlist'): ?>
              <div class="new-card morpheme text-left">
                <img class="card-imgbg" alt="Upgrade MorpheMe" src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/dashboard-banner-bg-mm.jpg" />
                <div class="new-card-container">
                  <div class="new-card-content">
                    <p class="new-card-title">Upgrade Your<br>MorpheMe<br>And Get Reward<br>Points!</p>
                    <p class="new-card-desc">You earn +200<br>bonus points.</p>
                    <p class="new-card-text txt-white">UPGRADE NOW:</p>
                    <div class="new-card-action">
                      <?php if($subscription_mm['button']['active_type'] == 'monthly'): ?>
                        <a class="action action-short" href="<?php echo home_url('/cart/?add-to-cart='.MM_SIXMONTH); ?>">
                          <button class="btn btn-primary condensed btn-vw">6 Months Sub</button>
                        </a>
                        <a class="action action-short" href="<?php echo home_url('/cart/?add-to-cart='.MM_ANNUAL); ?>">
                          <button class="btn btn-primary condensed btn-vw">12 Months Sub</button>
                        </a>
                      <?php elseif($subscription_mm['button']['active_type'] == '6month'): ?>
                        <a class="action action-long" href="<?php echo home_url('/cart/?add-to-cart='.MM_ANNUAL); ?>">
                          <button class="btn btn-primary condensed btn-vw">Upgrade to 12 months Subscription</button>
                        </a>
                      <?php endif; ?>
                    </div>
                  </div>
                </div>
              </div>
            <?php endif; ?>
          <?php endif; ?>

          <?php if($subscription_km['button']['show_upgrade']): ?>
            <?php if($subscription_km['subscription']['status'] != 'waitlist'): ?>
              <div class="new-card kissme text-left">
                <img class="card-imgbg" alt="Upgrade KissMe" src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/dashboard-banner-bg-km.jpg" />
                <div class="new-card-container">
                  <div class="new-card-content">
                    <p class="new-card-title">Upgrade<br>Your KissMe<br>And Get Reward<br>Points!</p>
                    <p class="new-card-desc">You earn +200<br>bonus points.</p>
                    <p class="new-card-text txt-pink">UPGRADE NOW:</p>
                    <div class="new-card-action">
                      <?php if($subscription_km['button']['active_type'] == 'monthly'): ?>
                        <a class="action action-short" href="<?php echo home_url('/cart/?add-to-cart='.KM_SIXMONTH); ?>">
                          <button class="btn btn-primary condensed btn-vw">6 Months Sub</button>
                        </a>
                        <a class="action action-short" href="<?php echo home_url('/cart/?add-to-cart='.KM_ANNUAL); ?>">
                          <button class="btn btn-primary condensed btn-vw">12 Months Sub</button>
                        </a>
                      <?php elseif($subscription_km['button']['active_type'] == '6month'): ?>
                        <a class="action action-long" href="<?php echo home_url('/cart/?add-to-cart='.KM_ANNUAL); ?>">
                          <button class="btn btn-primary condensed btn-vw">Upgrade to 12 months Subscription</button>
                        </a>
                      <?php endif; ?>
                    </div>
                  </div>
                </div>
              </div>
            <?php endif; ?>
          <?php endif; ?>

          <?php if($subscription_sm['button']['show_upgrade'] && $subscription_sm['subscription']['status'] != 'waitlist'): ?>
            <div class="new-card shadowme text-left">
              <img class="card-imgbg" alt="Upgrade ShadowMe" src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/dashboard-banner-bg-sm.jpg" />
              <div class="new-card-container">
                <div class="new-card-content">
                  <p class="new-card-title">Upgrade Your<br>ShadowMe<br>And Get Reward<br>Points!</p>
                  <p class="new-card-desc">You earn +200<br>bonus points.</p>
                  <p class="new-card-text txt-pink">UPGRADE NOW:</p>
                  <div class="new-card-action">
                    <?php if($subscription_sm['button']['active_type'] == 'monthly'): ?>
                      <a class="action action-short" href="<?php echo home_url('/cart/?add-to-cart='.SM_SIXMONTH); ?>">
                        <button class="btn btn-primary condensed btn-vw">6 Months Sub</button>
                      </a>
                      <a class="action action-short" href="<?php echo home_url('/cart/?add-to-cart='.SM_ANNUAL); ?>">
                        <button class="btn btn-primary condensed btn-vw">12 Months Sub</button>
                      </a>
                    <?php elseif($subscription_sm['button']['active_type'] == '6month'): ?>
                      <a class="action action-long" href="<?php echo home_url('/cart/?add-to-cart='.SM_ANNUAL); ?>">
                        <button class="btn btn-primary condensed btn-vw">Upgrade to 12 months Subscription</button>
                      </a>
                    <?php endif; ?>
                  </div>
                </div>
              </div>
            </div>
          <?php endif; ?>

          <div class="new-card rewards text-center">
            <img class="card-imgbg" alt="Treat yourself!" src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/dashboard-banner-bg-rewards.jpg" />
            <div class="new-card-container">
              <div class="new-card-content">
                <p class="new-card-title title-rewards"><span>Treat yourself!</span>Redeem your points to get<br>more beauty goodies!</p>
                <div class="new-card-action">
                  <a class="action action-long" href="<?php echo home_url('/rewards'); ?>">
                    <button class="btn btn-primary condensed btn-vw">View Rewards</button>
                  </a>
                </div>
              </div>
            </div>
          </div>

          <div class="new-card blog text-left">
            <img class="card-imgbg" alt="Check Out Our Blog" src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/dashboard-banner-bg-blog.jpg" />
            <div class="new-card-container">
              <div class="new-card-content">
                <p class="new-card-title">Stay brushed<br>up on the last<br>trends and<br>everything<br>LiveGlam!</p>
                <div class="new-card-action">
                  <a class="action action-long" href="<?php echo home_url('/blog'); ?>">
                    <button class="btn btn-primary condensed btn-vw">Check Out Our Blog</button>
                  </a>
                </div>
              </div>
            </div>
          </div>

        </div>
      </div>
    </div>
  </section>

  <section class="share-love" id="share-love">
    <div class="wrap">
      <div class="share-love-content">
        <div class="section-title">Free Goodies & Points</div>
        <div class="row no-gutters">
          <div class="col-md-6">
            <div class="block social-block">
              <h3>Share the love! Get Free Products for You & Your Friends!</h3>
              <p class="text-black">Invite your friends and they’ll get a free lippie or brush and you’ll score <?php echo $userLevel == 'gold'?250:200; ?> Points when they join.</p>
              <hr class="d-md-none">
              <p>Share through Social Media:</p>
              <div class="social-share">
                <?php echo do_shortcode('[social_share icon="fontawesome"]'); ?>
              </div>
            </div>
          </div>
          <div class="col-md-6">
            <div class="block inputs-block">
              <p>Share through Email:</p>
              <form class="send-email input-wrapper" action="">
                <div class="input-group inline-group section-send-email-invites">
                  <label class="d-none" for="email-invites-field">&nbsp;</label>
                  <input class="input-email email_invites input-field" id="email-invites-field" type="email" placeholder="Enter Your Friend’s emails (up to 10)">
                  <button class="btn-submit send_email_invites btn-action btn-primary condensed btn-vw" type="submit">Send</button>
                  <input type="hidden" value="morpheme" class="type-product"/>
                </div>
              </form>
              <p>Your Personal Referral Link:</p>
              <div class="copy-link input-wrapper">
                <div class="input-group inline-group section-send-email-invites"><!--section-send-email-invites-->
                  <label class="d-none" for="copyTarget-desktop">&nbsp;</label>
                  <input id="copyTarget-desktop" class="copyTarget input-field" type="text" value="<?php echo $refurl; ?>" readonly/><!--input-link-->
                  <button id="copyButton-desktop" class="btn-link btn btn-copy-link copyButton btn-action btn-primary condensed btn-vw">Copy</button>
                </div>
              </div>
            </div>
          </div>
          <div id="send_email_invites_success" class="white-popup-block-1 mfp-hide"></div>
        </div>
      </div>
    </div>
  </section>

  <section class="redeem-items d-none" id="redeem-items">
    <div class="wrap">
      <div class="redeem-items-content">
        <div class="section-title hide-mobile">Redeem Your Perks <span class="more_rewards"><a href="<?php echo home_url('rewards'); ?>">View All</a></span></div>
          <div class="show-mobile redeem-items-head">
            <div class="redeem-items-top">
            <h2>Redeem Your Rewards</h2>
          </div>
          <div class="redeem-item-bot">
            <p><span class="item-available"><?php echo IzCustomization::total_number_of_redeem_product(); ?> items available</span><span class="view-all"><a href="<?php echo home_url('/rewards'); ?>">View All<i class="fas fa-chevron-right" aria-hidden="true"></i></a></span></p>
          </div>
        </div>
        <?php echo LGS_User_Referrals::lgs_get_product_rewards(); ?>
      </div>
    </div>
    <?php
      if($userLevel == 'gold'){
        $check_address = gold_member_check_address_international();
        if($check_address){
          $add_on_notice = "You have selected an Add-On Item.  Add-On Items ship with your next monthly package or within 31 days, whichever is first. Since you are a valued gold member, you can get discounted international shipping, which would you rather do?";
          $add_on_pay_text = "Pay <span id='shipping_price'></span> & ship now";
          $add_on_freeship_text = "I'll wait and get free shipping";

        }else{
          $add_on_notice = "You have selected an Add-On Item.  Add-On Items ship with your next monthly package or within 31 days, whichever is first. Since you are a valued gold member, you can get free immediate shipping, which would you rather do?";
          $add_on_pay_text = "Ship immediately";
          $add_on_freeship_text = "I don't mind waiting";

        }
      }else{
        $add_on_notice = "You have selected an Add-On Item. Add-On Items ship with your next monthly package or within 31 days, whichever is first. Would you rather like to pay for it to ship now ?";
        $add_on_pay_text = "Pay <span id='shipping_price'></span> & ship now";
        $add_on_freeship_text = "I'll wait and get free shipping";
      }
    ?>
    <div id="addon_shipping_option" class="white-popup-block-2 mfp-hide">
      <div class="woocommerce-success-header woocommerce-message-header">
        <img class="img-check" alt="Check Image" src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/popup-check-black.svg" />
        <h2>Yasss!</h2>
      </div>
      <div class="woocommerce-success-footer woocommerce-message-footer">
        <p><?php echo $add_on_notice; ?></p>
        <a href='' class='addon_pay_shipping'>
          <button class="btn solid btn-primary condensed btn-static"><?php echo $add_on_pay_text; ?></button>
        </a>
        <a href='' class='addon_free_shipping'>
          <button class="btn btn-primary condensed btn-static"><?php echo $add_on_freeship_text; ?></button>
        </a>
      </div>
    </div>
    <?php
    ?>
  </section>

  <?php show_dashboard_footer('footer-dashboard'); ?>
</div>

<div class="dashboard-content dashboard-setting dashboard-setting-account" style="display: none;">
  <div class="dashboard-header-new">
    <div class="wrap dashboard-header-profile">
      <div class="title-header-content">
        <div class="title-header-left">
          <a href="#" class="close-setting"><img class="hide-mobile" alt="Close Setting" src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/arrow-gray-left.png"/>Back</a>
        </div>
        <div class="title-header-center show-mobile">
          <p>Profile Settings</p>
        </div>
      </div>
    </div>
    <div class="wrap dashboard-header-add-address-book d-none">
      <div class="title-header-content">
        <div class="title-header-center show-mobile">
          <p>Add New Address</p>
        </div>
        <div class="title-header-right">
          <a href="#" class="address_book_reset"><img class="hide-mobile" alt="Close Setting" src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/arrow-gray-left.png"/>Back</a>
        </div>
      </div>
    </div>
    <div class="wrap dashboard-header-edit-address-book d-none">
      <div class="title-header-content">
        <div class="title-header-center show-mobile">
          <p>Update Address</p>
        </div>
        <div class="title-header-right">
          <a href="#" class="address_book_reset"><img class="hide-mobile" alt="Close Setting" src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/arrow-gray-left.png"/>Back</a>
        </div>
      </div>
    </div>
  </div>
  


  <div class="dashboard-container panel-group" id="accordion-setting">
    <div class="new-tab">
      <ul class="nav nav-tabs new-nav wrap">
          <li class="nav-item"><a class="nav-link active" data-toggle="tab" href="#tab-account">Account</a></li>
          <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#tab-password">Password</a></li>
          <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#tab-address-book">Address Book</a></li>
      </ul>
    </div>
    <div class="liveglam-setting liveglam-setting-new tab-content">
      <div class="tab-content">
        <section id="tab-account" class="setting setting-account tab-pane fade show active">
          <div class="setting-account-title show-mobile">
            <p>Edit Your Profile</p>
          </div>
          <div class="wrap">
            <div class="setting-account-content">
            <h2 class="hide-mobile sac-title">Edit Your Profile</h2>
            <div class="row">
              <div class="lg-change-account col-md-6">
                <div class="account_avatar show-mobile">
                  <div class="lg-update-avatar">
                    <div class="lg-update-avatar-content">
                      <img class="account_img_photo" src="<?php echo $LG_userAvata; ?>" alt="User Avatar">
                      <div class="account_img_mask"></div>
                      <div class="lg-update-avatar-action">
                        <a class="fancybox-inline" href="#change-avatar-popup">Change Photo</a>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="lg-change-account-notice lg-notice"></div>
                <form class="edit-account" action="" method="post">
                  <p class="form-change-information form-row form-row-wide">
                    <label for="first_name"><?php _e('First name', 'woocommerce'); ?></label>
                    <input type="text" class="input-text form-control first_name" id="first_name" name="first_name" placeholder="<?php echo esc_attr($current_user->first_name); ?>" value="<?php echo esc_attr($current_user->first_name); ?>"/>
                  </p>
                  <p class="form-change-information form-row form-row-wide">
                    <label for="last_name"><?php _e('Last name', 'woocommerce'); ?></label>
                    <input type="text" class="input-text form-control last_name" id="last_name" name="last_name" placeholder="<?php echo esc_attr($current_user->last_name); ?>" value="<?php echo esc_attr($current_user->last_name); ?>"/>
                  </p>
                  <p class="form-change-information form-row form-row-wide">
                    <label for="account_email"><?php _e('Email', 'woocommerce'); ?></label>
                    <input type="text" class="input-text form-control account_email" id="account_email"
                          name="account_email" placeholder="<?php echo esc_attr($current_user->user_email); ?>"
                          value="<?php echo esc_attr($current_user->user_email); ?>"/>
                  </p>
                  <div class="form-group form-change-information">
                    <label for="account_birthday"><?php _e('Birthday', 'woocommerce'); ?></label>
                    <div class='input-group'>
                      <input type="text"
                            class="input-text form-control account_birthday <?php if($dob == '') echo 'account_birthday_datepicker'; ?>"
                            id="account_birthday" name="account_birthday" placeholder="no birthday on record."
                            value="<?php echo $dob; ?>" <?php if($dob != '') //echo 'readonly' ;?> readonly/><label
                        class="input-group-addon btn" for="account_birthday"><i class="fas fa-calendar-alt"></i></label>
                    </div>
                  </div>
                  <div class="form-group form-change-information form-row form-row-wide">
                    <?php echo woocommerce_form_field( 'user_billing_phone', $address['billing_phone'], get_user_meta($userID,'billing_phone',true) ); ?>
                  </div>
                  <p class="btn-submit-profile">
                    <button type="submit" class="button save_account lg-edit-button-profile btn-primary lg_vadilate_pay" name="save_account">Update Settings</button>
                  </p>
                </form>
              </div>
              <div class="lg-change-account col-md-6">
                <div class="account_avatar hide-mobile">
                  <div class="lg-update-avatar text-center">
                    <img class="account_img_photo" src="<?php echo $LG_userAvata; ?>" alt="User Avatar">
                    <div class="account_update_avatar">
                      <a class="fancybox-inline" href="#change-avatar-popup">
                        <button class="btn btn-secondary">UPDATE</button>
                      </a>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            </div>
          </div>
        </section>
        <section id="tab-password" class="setting setting-password tab-pane fade">
          <div class="setting-account-title show-mobile">
            <p>Change Your Password</p>
          </div>
          <div class="wrap">
            <div class="setting-account-content">
            <h2 class="hide-mobile sac-title">Change Your Password</h2>
            <div class="row">
              <div class="lg-change-password col-md-6">
                <div class="lg-change-password-notice lg-notice"></div>
                <form class="edit-password lost_reset_password" action="" method="post">
                  <p class="form-row form-row-wide">
                    <label for="password_old"><?php _e('Old Password', 'woocommerce'); ?></label>
                    <input type="password" class="input-text form-control password_old" id="password_old"
                          name="password_old" placeholder="Confirm Your Previous Password"/>
                  </p>
                  <p class="form-row form-row-wide">
                    <label for="password_1"><?php _e('New Password', 'woocommerce'); ?></label>
                    <input type="password" class="input-text form-control password_new1" id="password_1"
                          name="password_new1" placeholder="Enter Your New Password"/>
                  </p>
                  <p class="form-row form-row-wide">
                    <label for="password_2"><?php _e('Confirm Password', 'woocommerce'); ?></label>
                    <input type="password" class="input-text form-control password_new2" id="password_2"
                          name="password_new2" placeholder="Confirm Your New Password"/>
                  </p>
                  <p class="btn-submit-profile">
                    <button type="submit" class="button save_password lg-edit-button-profile btn-primary lg_vadilate_pay" name="save_password">Update Password</button>
                  </p>
                </form>
              </div>
            </div>
            </div>
          </div>
        </section>

        <section id="tab-address-book" class="setting setting-address-book tab-pane fade">
          <div class="lg-address-book-title">
            <div class="setting-account-title show-mobile">
              <p>Shipping Address Book</p>
            </div>
          </div>
          <div class="wrap">
            <div class="setting-account-content">
            <h2 class="hide-mobile sac-title">Shipping Address Book
              <button class="btn hide-mobile add-new-address float-right btn-secondary condensed"><i class="fas fa-plus"></i>&nbsp;Add New Address</button>
              <button class="btn hide-mobile edit-subscription-address float-right btn-secondary d-none"><i class="fas fa-times"></i> Cancel New Address</button>
            </h2>
            <div class="row address-book-details">
              <div class="address-book-column col-md-6 lg-address-book-primary">
                <div class="address_book">
                  <p class="myaccount_address hide-mobile">Addresses available during checkout:</p>
                  <div class="list-address-book">
                    <?php echo WC_Address_Book::lg_action_load_address_book($subscription_mm['subscription']['ID'],$subscription_km['subscription']['ID'],$subscription_sm['subscription']['ID']); ?>
                  </div>
                </div>
              </div>
              <div class="split-bar-new"></div>
              <div class="address-book-column col-md-6 border-left lg-address-book-subscription">
                <div class="address_book_subscription">
                  <h3 class="primary-address show-mobile">Other Addresses</h3>
                  <p class="myaccount_address">Select the address for each subscription:</p>
                  <div class="address-book-content has-bg">
                    <div class="list-address-subscription">
                      <?php echo WC_Address_Book::lg_action_load_address_subscription($subscription_mm['subscription']['ID'],$subscription_km['subscription']['ID'],$subscription_sm['subscription']['ID']); ?>
                    </div>
                    <div class="address_book_attention">
                      <p class="address_book_attention-title">Attention:</p>
                      <p class="address_book_attention-desc">Shipping cost will vary for domestic and international destinations.</p>
                    </div>
                    <div class="address_book_subscription_action d-none">
                      <p class="btn-submit-profile">
                        <button type="button" class="button address_book_save_subscription lg-edit-button-profile btn-primary">Save Change</button>
                      </p>
                    </div>
                    <div class="show-mobile text-left" style="margin: 0 auto 5vw;">
                      <button class="btn add-new-address btn-primary condensed"><i class="fas fa-plus"></i>&nbsp;Add New Address</button>
                    </div>
                  </div>
                  <div class="lg-change-address-notice lg-notice"></div>
                </div>
              </div>
              <div class="address-book-column col-md-6 border-left lg-address-book-new d-none">
                <div class="lg-change-address-notice lg-notice"></div>
                <div class="lg-address-book" id="lg-address-book"></div>
              </div>
            </div>
            </div>
          </div>
        </section>
      </div>
    </div>
  </div>
</div>

<div class="dashboard-content dashboard-setting dashboard-setting-morpheme" style="display: none;">
  <div class="dashboard-header-new">
    <div class="wrap">
      <div class="title-header-content">
        <div class="title-header-left">
          <a href="#" class="close-setting"><img class="hide-mobile" alt="Close Setting" src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/arrow-gray-left.png"/>Back</a>
        </div>
        <div class="title-header-center show-mobile">
          <p>Billing Details</p>
        </div>
      </div>
    </div>
  </div>
  <div class="dashboard-container panel-group">
    <div class="new-tab">
      <ul class="nav nav-tabs new-nav wrap">
          <?php if($subscription_mm['action']['change_date']): ?>
            <li class="nav-item"><a data-toggle="tab" href="#tab-schedule-morpheme" class="nav-link panel-schedule-setting" data-type="morpheme">Billing and Shipping Date</a></li>
          <?php endif; ?>
          <li class="nav-item"><a data-toggle="tab" href="#tab-billing-morpheme" class="nav-link active panel-payment-setting" data-type="morpheme">Payment Method</a></li>
      </ul>
    </div>
    <div class="liveglam-setting liveglam-setting-new tab-content">
      <div class="tab-content">
        <section id="tab-billing-morpheme" class="setting setting-billing setting-payment tab-pane fade show active">
          <div class="setting-account-title show-mobile">
            <p>Update Your Payment Method</p>
          </div>
          <div class="wrap">
            <div class="setting-account-content">
              <h2 class="hide-mobile sac-title">Update Your Payment Method</h2>
              <div class="row">
                <div class="lg-change-payment col-md-12">
              <div class="change-payment-methods row" id="change-payment-methods">
                <div class="col-md-6">

                  <div class="payment_methods_notice"></div>

                  <div class="form_payment_method_title">
                    <p>You can add, edit or change the default payment methods for your subscription here.</p>
                  </div>

                  <div class="display-payment-methods">

                    <?php echo LiveGlam_Stripe_Custom::display_payment_methods($mm_payment_subID, $km_payment_subID, $sm_payment_subID); ?>

                  </div>

                </div>

                <div class="payment_card_details col-md-12">
                  <div class="row">
                    <div class="col-sm-6">
                      <a class="button btn-add-payment-method add_payment btn-primary" href="#"><i class="fas fa-plus" aria-hidden="true"></i> ADD NEW PAYMENT METHOD</a>
                    </div>
                    <div class="col-md-12">
                      <div id="form-add-payment-method" style="display: none;">
                        <?php if($available_gateways = WC()->payment_gateways->get_available_payment_gateways()) : ?>
                          <form id="add_payment_method" method="post">
                            <div id="payment" class="woocommerce-Payment">
                              <?php if(count($available_gateways)){
                                current($available_gateways)->set_current();
                              } ?>
                              <ul class="woocommerce-PaymentMethods payment_methods methods">
                                <?php foreach($available_gateways as $gateway): ?>
                                  <?php if($gateway->id == 'stripe'): ?>
                                    <li class="woocommerce-PaymentMethod woocommerce-PaymentMethod--<?php echo $gateway->id; ?> payment_method_<?php echo $gateway->id; ?>">
                                      <input id="payment_method_<?php echo esc_attr($gateway->id); ?>" type="radio" class="input-radio d-none" name="payment_method" value="<?php echo esc_attr($gateway->id); ?>" <?php checked($gateway->chosen, true); ?> />
                                      <label for="payment_method_<?php echo esc_attr($gateway->id); ?>" class="d-none"><?php echo wp_kses_post($gateway->get_title()); ?><?php echo wp_kses_post($gateway->get_icon()); ?></label>
                                      <?php if($gateway->has_fields() || $gateway->get_description()){
                                        echo '<div class="card_payment_details woocommerce-PaymentBox woocommerce-PaymentBox--'.esc_attr($gateway->id).' payment_box payment_method_'.esc_attr($gateway->id).'">';
                                        echo '<p class="sub-title"><span>1</span>Card Details</p>';
                                        $gateway->payment_fields();
                                        echo '</div>';
                                      } ?>
                                    </li>
                                    <li>
                                      <div class="save_card_details">
                                        <div class="form-row payment_security">
                                          <h3><i class="fas fa-lock" aria-hidden="true"></i> Security</h3>
                                          <p>Security: Your card information is highly secured! We don’t save any credit card numbers on our servers. We created <a href="<?php echo home_url('2017/12/10/credit-card-information-safe-liveglam-risk-liveglam-fraud-credit-card-transactions-liveglam-scam-going-credit-cards/');?>">this blog article</a> for more information about how we protect your payment information.</p>
                                        </div>
                                        <div class="form-row row-save-card">
                                          <?php wp_nonce_field('woocommerce-add-payment-method'); ?>
                                          <input type="submit" class="save-new-card btn-primary btn-block" id="place_order" value="<?php esc_attr_e('Continue', 'woocommerce'); ?>"/>
                                          <input type="hidden" name="woocommerce_add_payment_method" id="woocommerce_add_payment_method" value="1"/>
                                        </div>
                                      </div>
                                    </li>
                                  <?php endif; ?>
                                <?php endforeach; ?>
                                <p class="card-detail d-none"></p>
                              </ul>
                            </div>
                          </form>
                        <?php else : ?>
                          <p><?php esc_html_e('Sorry, it seems that there are no payment methods which support adding a new payment method. Please contact us if you require assistance or wish to make alternate arrangements.', 'woocommerce'); ?></p>
                        <?php endif; ?>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="form_payment_method_details col-md-12">
                  <p><strong>Make Default:</strong> This will make the card selected the default method. We will only charge the default payment method.</p>
                  <p><strong>Delete:</strong> You can delete an already saved payment method from file. We will only charge the default card.</p>
                  <p><strong>Please note:</strong> You can have more than one payment method saved to your account. Your default payment method will be the one used to renew your subscription(s).</p>
                  <p><strong>Security:</strong> Your card information is highly secured! We don’t save any credit card numbers on our servers. We created this <a href="<?php echo home_url('2017/12/10/credit-card-information-safe-liveglam-risk-liveglam-fraud-credit-card-transactions-liveglam-scam-going-credit-cards/'); ?>">blog article</a> for more information about how we protect your payment information.</p>
                </div>
              </div>
                </div>
              </div>
            </div>
          </div>
        </section>
        <section id="tab-shipping-morpheme" class="setting setting-shipping tab-pane fade">
          <div class="wrap">
            <h2>Change Your Shipping Information<span class="pink-short-border"></span></h2>
            <div class="row">
              <div class="lg-change-shipping col-md-6">
                <div class="lg-change-shipping-content" id="lg-change-shipping-content">
                  <?php echo LGS_User_Referrals::lg_load_address_setting('shipping', $current_user); ?>
                </div>
              </div>
            </div>
          </div>
        </section>
        <?php if($subscription_mm['action']['change_date']): ?>
          <section id="tab-schedule-morpheme" class="setting setting-schedule tab-pane fade">
            <div class="setting-account-title show-mobile">
              <p>Change Your Billing Schedule</p>
              <div class="lg-current-billing-date">
                <div class="current-billing-date-content">
                  <p class="current-billing-date-title">Current Next Billing Date:</p>
                  <p class="current-billing-date-time"><?php echo date('F d, Y',$subscription_mm['time']['next_payment']); ?></p>
                </div>
              </div>
            </div>
            <div class="wrap">
              <div class="setting-account-content">
                <h2 class="hide-mobile sac-title">Change Your Billing Schedule</h2>
                <div class="row">
                  <div class="col-md-6 lg-change-schedule">
                    <div class="lg-change-schedule-notice lg-notice"></div>
                    <?php LGS_User_Referrals::display_change_schedule($subscription_mm['subscription']['ID'], 'morpheme', $subscription_mm['time']['next_payment']); ?>
                  </div>
                  <div class="col-md-6 hide-mobile">
                    <div class="lg-current-billing-date">
                      <p class="current-billing-date-title">Current Next Billing Date:</p>
                      <div class="current-billing-date-content">
                        <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/icon-current-billing-date2.png" alt="Next Billing Date">
                        <p class="current-billing-date-time"><?php echo date('F d, Y',$subscription_mm['time']['next_payment']); ?></p>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </section>
        <?php endif; ?>
      </div>
    </div>
  </div>
</div>

<div class="dashboard-content dashboard-setting dashboard-setting-kissme" style="display: none;">
  <div class="dashboard-header-new">
    <div class="wrap">
      <div class="title-header-content">
        <div class="title-header-left">
          <a href="#" class="close-setting"><img class="hide-mobile" alt="Close Setting" src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/arrow-gray-left.png"/>Back</a>
        </div>
        <div class="title-header-center show-mobile">
          <p>Billing Details</p>
        </div>
      </div>
    </div>
  </div>
  <div class="dashboard-container panel-group">
    <div class="new-tab">
      <ul class="nav nav-tabs new-nav wrap">
          <?php if($subscription_km['action']['change_date']): ?>
            <li class="nav-item"><a data-toggle="tab" href="#tab-schedule-kissme" class="nav-link panel-schedule-setting" data-type="kissme">Billing and Shipping Date</a></li>
          <?php endif; ?>
          <li class="nav-item"><a data-toggle="tab" href="#tab-billing-kissme" class="nav-link active panel-payment-setting" data-type="kissme">Payment Method</a></li>
      </ul>
    </div>
    <div class="liveglam-setting liveglam-setting-new tab-content">
      <div class="tab-content">
        <section id="tab-billing-kissme" class="setting setting-billing setting-payment tab-pane fade show active">
          <div class="setting-account-title show-mobile">
            <p>Update Your Payment Method</p>
          </div>
          <div class="wrap">
            <div class="setting-account-content">
              <h2 class="hide-mobile sac-title">Update Your Payment Method</h2>
              <div class="row">
                <div class="lg-change-payment col-md-12"></div>
              </div>
            </div>
          </div>
        </section>
        <section id="tab-shipping-kissme" class="setting setting-shipping tab-pane fade">
          <div class="wrap">
            <h2>Change Your Shipping Information<span class="pink-short-border"></span></h2>
            <div class="lg-change-shipping"></div>
          </div>
        </section>
        <?php if($subscription_km['action']['change_date']): ?>
          <section id="tab-schedule-kissme" class="setting setting-schedule tab-pane fade">
            <div class="setting-account-title show-mobile">
              <p>Change Your Billing Schedule</p>
            </div>
            <div class="wrap">
              <div class="setting-account-content">
                <h2 class="hide-mobile sac-title">Change Your Billing Schedule</h2>
                <div class="row">
                  <div class="col-md-6 lg-change-schedule">
                    <div class="lg-change-schedule-notice lg-notice"></div>
                    <?php LGS_User_Referrals::display_change_schedule($subscription_km['subscription']['ID'], 'kissme', $subscription_km['time']['next_payment']); ?>
                  </div>
                  <div class="col-md-6 hide-mobile">
                    <div class="lg-current-billing-date">
                      <p class="current-billing-date-title">Current Next Billing Date:</p>
                      <div class="current-billing-date-content">
                        <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/icon-current-billing-date2.png" alt="Next Billing Date">
                        <p class="current-billing-date-time"><?php echo date('F d, Y',$subscription_km['time']['next_payment']); ?></p>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </section>
        <?php endif; ?>
      </div>
    </div>
  </div>
</div>

<div class="dashboard-content dashboard-setting dashboard-setting-shadowme" style="display: none;">
  <div class="dashboard-header-new">
    <div class="wrap">
      <div class="title-header-content">
        <div class="title-header-left">
          <a href="#" class="close-setting"><img class="hide-mobile" alt="Close Setting" src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/arrow-gray-left.png"/>Back</a>
        </div>
        <div class="title-header-center show-mobile">
          <p>Billing Details</p>
        </div>
      </div>
    </div>
  </div>
  <div class="dashboard-container panel-group">
    <div class="new-tab">
      <ul class="nav nav-tabs new-nav wrap">
          <?php if($subscription_sm['action']['change_date']): ?>
            <li class="nav-item"><a data-toggle="tab" href="#tab-schedule-shadowme" class="nav-link panel-schedule-setting" data-type="shadowme">Billing and Shipping Date</a></li>
          <?php endif; ?>
          <li class="nav-item"><a data-toggle="tab" href="#tab-billing-shadowme" class="nav-link active panel-payment-setting" data-type="shadowme">Payment Method</a></li>
      </ul>
    </div>
    <div class="liveglam-setting liveglam-setting-new tab-content">
      <div class="tab-content">
        <section id="tab-billing-shadowme" class="setting setting-billing setting-payment tab-pane fade show active">
          <div class="setting-account-title show-mobile">
            <p>Update Your Payment Method</p>
          </div>
          <div class="wrap">
            <div class="setting-account-content">
              <h2 class="hide-mobile sac-title">Update Your Payment Method</h2>
              <div class="row">
                <div class="lg-change-payment col-md-12"></div>
              </div>
            </div>
          </div>
        </section>
        <section id="tab-shipping-shadowme" class="setting setting-shipping tab-pane fade">
          <div class="wrap">
            <h2>Change Your Shipping Information<span class="pink-short-border"></span></h2>
            <div class="row">
              <div class="lg-change-shipping col-md-6"></div>
            </div>
          </div>
        </section>
        <?php if($subscription_sm['action']['change_date']): ?>
          <section id="tab-schedule-shadowme" class="setting setting-schedule tab-pane fade">
            <div class="setting-account-title show-mobile">
              <p>Change Your Billing Schedule</p>
            </div>
            <div class="wrap">
              <div class="setting-account-content">
                <h2 class="hide-mobile sac-title">Change Your Billing Schedule</h2>
                <div class="row">
                  <div class="col-md-6 lg-change-schedule">
                    <div class="lg-change-schedule-notice lg-notice"></div>
                    <?php LGS_User_Referrals::display_change_schedule($subscription_sm['subscription']['ID'], 'shadowme', $subscription_sm['time']['next_payment']); ?>
                  </div>
                  <div class="col-md-6 hide-mobile">
                    <div class="lg-current-billing-date">
                      <p class="current-billing-date-title">Current Next Billing Date:</p>
                      <div class="current-billing-date-content">
                        <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/icon-current-billing-date2.png" alt="Next Billing Date">
                        <p class="current-billing-date-time"><?php echo date('F d, Y',$subscription_sm['time']['next_payment']); ?></p>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </section>
        <?php endif; ?>
      </div>
    </div>
  </div>
</div>

<div class="dashboard-content dashboard-setting view-order-morpheme" style="display: none;">
  <div class="dashboard-header-new">
    <div class="wrap view-all-order">
      <div class="title-header-content">
        <div class="title-header-left">
          <a href="#" class="close-setting"><img class="hide-mobile" alt="Close Setting" src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/arrow-gray-left.png"/>Back</a>
        </div>
        <div class="title-header-center show-mobile">
          <p>MorpheMe Order History</p>
        </div>
      </div>
    </div>
    <div class="wrap view-detail-order d-none">
      <div class="title-header-content">
        <div class="title-header-left">
          <a href="#" class="close-order-details"><img class="hide-mobile" alt="Close Setting" src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/arrow-gray-left.png"/>Back</a>
        </div>
        <div class="title-header-center title-order-details show-mobile">
          <p>MorpheMe Order History</p>
        </div>
      </div>
    </div>
  </div>
  <div class="dashboard-container">
    <div class="liveglam-setting liveglam-setting-new liveglam-orders-history">
      <section class="setting">
        <div class="order-history">
          <div class="order-history-list">
            <div class="setting-account-title hide-mobile">
              <p>MorpheMe Order History</p>
            </div>
            <?php foreach($subscription_mm['related_orders'] as $order): ?>
              <div class="order-history-item show-mobile">
                <p class="item-date"><?php echo date('m/d/Y', strtotime($order['order-date'])); ?></p>
                <p class="item-content-list item-subs"><span class="item-title">Order code:</span><span class="item-data"><?php echo $order['order-id']; ?></span></p>
                <p class="item-content-list item-status"><span class="item-title">Status:</span><span class="item-data"><?php echo ucfirst($order['order-status']); ?></span></p>
                <p class="item-action"><a class="view-order-details" data-title="<?php echo date('m/d/Y', strtotime($order['order-date'])); ?>" data-type="morpheme" data-subscription-id="<?php echo $subscription_mm['subscription']['ID']; ?>" data-order-id="<?php echo $order['order-id']; ?>">View Details<i class="fas fa-chevron-right"></i></a></p>
              </div>
              <div class="order-history-item hide-mobile">
                <div class="order-history-item-left">
                  <p class="item-date"><?php echo date('m/d/Y', strtotime($order['order-date'])); ?></p>
                  <p class="item-action"><a class="view-order-details" data-title="<?php echo date('m/d/Y', strtotime($order['order-date'])); ?>" data-type="morpheme" data-subscription-id="<?php echo $subscription_mm['subscription']['ID']; ?>" data-order-id="<?php echo $order['order-id']; ?>">View Details<i class="fas fa-chevron-right"></i></a></p>
                </div>
                <div class="order-history-item-right">
                  <p class="item-content-list item-subs"><span class="item-title">Order code:</span><span class="item-data"><?php echo $order['order-id']; ?></span></p>
                  <p class="item-content-list item-status"><span class="item-title">Status:</span><span class="item-data"><?php echo ucfirst($order['order-status']); ?></span></p>
                </div>
              </div>
            <?php endforeach; ?>
          </div>
          <div class="order-history-details morpheme" style="display: none;"></div>
        </div>
      </section>
    </div>
  </div>
</div>

<div class="dashboard-content dashboard-setting view-order-kissme" style="display: none;">
  <div class="dashboard-header-new">
    <div class="wrap view-all-order">
      <div class="title-header-content">
        <div class="title-header-left">
          <a href="#" class="close-setting"><img class="hide-mobile" alt="Close Setting" src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/arrow-gray-left.png"/>Back</a>
        </div>
        <div class="title-header-center show-mobile">
          <p>KissMe Order History</p>
        </div>
      </div>
    </div>
    <div class="wrap view-detail-order d-none">
      <div class="title-header-content">
        <div class="title-header-left">
          <a href="#" class="close-order-details"><img class="hide-mobile" alt="Close Setting" src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/arrow-gray-left.png"/>Back</a>
        </div>
        <div class="title-header-center title-order-details show-mobile">
          <p>KissMe Order History</p>
        </div>
      </div>
    </div>
  </div>
  <div class="dashboard-container">
    <div class="liveglam-setting liveglam-setting-new liveglam-orders-history">
      <section class="setting">
        <div class="order-history">
          <div class="order-history-list">
            <div class="setting-account-title hide-mobile">
              <p>KissMe Order History</p>
            </div>
            <?php foreach($subscription_km['related_orders'] as $order): ?>
              <div class="order-history-item show-mobile">
                <p class="item-date"><?php echo date('m/d/Y', strtotime($order['order-date'])); ?></p>
                <p class="item-content-list item-subs"><span class="item-title">Order code:</span><span class="item-data"><?php echo $order['order-id']; ?></span></p>
                <p class="item-content-list item-status"><span class="item-title">Status:</span><span class="item-data"><?php echo ucfirst($order['order-status']); ?></span></p>
                <p class="item-action"><a class="view-order-details" data-title="<?php echo date('m/d/Y', strtotime($order['order-date'])); ?>" data-type="kissme" data-subscription-id="<?php echo $subscription_km['subscription']['ID']; ?>" data-order-id="<?php echo $order['order-id']; ?>">View Details<i class="fas fa-chevron-right"></i></a></p>
              </div>
              <div class="order-history-item hide-mobile">
                <div class="order-history-item-left">
                  <p class="item-date"><?php echo date('m/d/Y', strtotime($order['order-date'])); ?></p>
                  <p class="item-action"><a class="view-order-details" data-title="<?php echo date('m/d/Y', strtotime($order['order-date'])); ?>" data-type="kissme" data-subscription-id="<?php echo $subscription_km['subscription']['ID']; ?>" data-order-id="<?php echo $order['order-id']; ?>">View Details<i class="fas fa-chevron-right"></i></a></p>
                </div>
                <div class="order-history-item-right">
                  <p class="item-content-list item-subs"><span class="item-title">Order code:</span><span class="item-data"><?php echo $order['order-id']; ?></span></p>
                  <p class="item-content-list item-status"><span class="item-title">Status:</span><span class="item-data"><?php echo ucfirst($order['order-status']); ?></span></p>
                </div>
              </div>
            <?php endforeach; ?>
          </div>
          <div class="order-history-details kissme" style="display: none;"></div>
        </div>
      </section>
    </div>
  </div>
</div>

<div class="dashboard-content dashboard-setting view-order-shadowme" style="display: none;">
  <div class="dashboard-header-new">
    <div class="wrap view-all-order">
      <div class="title-header-content">
        <div class="title-header-left">
          <a href="#" class="close-setting"><img class="hide-mobile" alt="Close Setting" src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/arrow-gray-left.png"/>Back</a>
        </div>
        <div class="title-header-center show-mobile">
          <p>ShadowMe Order History</p>
        </div>
      </div>
    </div>
    <div class="wrap view-detail-order d-none">
      <div class="title-header-content">
        <div class="title-header-left">
          <a href="#" class="close-order-details"><img class="hide-mobile" alt="Close Setting" src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/arrow-gray-left.png"/>Back</a>
        </div>
        <div class="title-header-center title-order-details show-mobile">
          <p>ShadowMe Order History</p>
        </div>
      </div>
    </div>
  </div>
  <div class="dashboard-container">
    <div class="liveglam-setting liveglam-setting-new liveglam-orders-history">
      <section class="setting">
        <div class="order-history">
          <div class="order-history-list">
            <div class="setting-account-title hide-mobile">
              <p>ShadowMe Order History</p>
            </div>
            <?php foreach($subscription_sm['related_orders'] as $order): ?>
              <div class="order-history-item show-mobile">
                <p class="item-date"><?php echo date('m/d/Y', strtotime($order['order-date'])); ?></p>
                <p class="item-content-list item-subs"><span class="item-title">Order code:</span><span class="item-data"><?php echo $order['order-id']; ?></span></p>
                <p class="item-content-list item-status"><span class="item-title">Status:</span><span class="item-data"><?php echo ucfirst($order['order-status']); ?></span></p>
                <p class="item-action"><a class="view-order-details" data-title="<?php echo date('m/d/Y', strtotime($order['order-date'])); ?>" data-type="shadowme" data-subscription-id="<?php echo $subscription_sm['subscription']['ID']; ?>" data-order-id="<?php echo $order['order-id']; ?>">View Details<i class="fas fa-chevron-right"></i></a></p>
              </div>
              <div class="order-history-item hide-mobile">
                <div class="order-history-item-left">
                  <p class="item-date"><?php echo date('m/d/Y', strtotime($order['order-date'])); ?></p>
                  <p class="item-action"><a class="view-order-details" data-title="<?php echo date('m/d/Y', strtotime($order['order-date'])); ?>" data-type="shadowme" data-subscription-id="<?php echo $subscription_sm['subscription']['ID']; ?>" data-order-id="<?php echo $order['order-id']; ?>">View Details<i class="fas fa-chevron-right"></i></a></p>
                </div>
                <div class="order-history-item-right">
                  <p class="item-content-list item-subs"><span class="item-title">Order code:</span><span class="item-data"><?php echo $order['order-id']; ?></span></p>
                  <p class="item-content-list item-status"><span class="item-title">Status:</span><span class="item-data"><?php echo ucfirst($order['order-status']); ?></span></p>
                </div>
              </div>
            <?php endforeach; ?>
          </div>
          <div class="order-history-details shadowme" style="display: none;"></div>
        </div>
      </section>
    </div>
  </div>
</div>

<div class="dashboard-content dashboard-setting view-order-shop" style="display: none;">
  <div class="dashboard-header-new">
    <div class="wrap view-all-order">
      <div class="title-header-content">
        <div class="title-header-left">
          <a href="#" class="close-setting"><img class="hide-mobile" alt="Close Setting" src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/arrow-gray-left.png"/>Back</a>
        </div>
        <div class="title-header-center show-mobile">
          <p>Shop Order History</p>
        </div>
      </div>
    </div>
    <div class="wrap view-detail-order d-none">
      <div class="title-header-content">
        <div class="title-header-left">
          <a href="#" class="close-order-details"><img class="hide-mobile" alt="Close Setting" src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/arrow-gray-left.png"/>Back</a>
        </div>
        <div class="title-header-center title-order-details show-mobile">
          <p>Shop Order History</p>
        </div>
      </div>
    </div>
  </div>
  <div class="dashboard-container">
    <div class="liveglam-setting liveglam-setting-new liveglam-orders-history">
      <section class="setting">
        <div class="order-history">
          <div class="order-history-list shop-history" data-show="0">
            <div class="setting-account-title hide-mobile">
              <p>Shop Order History</p>
            </div>
          </div>
          <div class="order-history-details shop" style="display: none;"></div>
        </div>
      </section>
    </div>
  </div>
</div>


<div class="dashboard-data d-none">

  <div class="d-none lgs-data-setting">

    <input type="hidden" name="list-payment-subID" data-mm="<?php echo $mm_payment_subID; ?>" data-km="<?php echo $km_payment_subID; ?>" data-sm="<?php echo $sm_payment_subID; ?>" />

    <!-- setting show share -->
    <input type="hidden" class="show_first" value="<?php echo $show_first;?>" />
    <input type="hidden" class="show_club" value="<?php echo (isset($_GET['tab']) && !empty($_GET['tab']))?$_GET['tab']:''; ?>" />
    <input type="hidden" class="show_club_nav" value="<?php echo (isset($_GET['nav']) && !empty($_GET['nav']))?$_GET['nav']:''; ?>" />
    <input type="hidden" class="show_first_share" value="<?php echo ($show_first == 'shop')?'morpheme':$show_first; ?>" />

    <?php echo do_shortcode('[upgrade_morpheme type="button" show_popup=1 button_text="Upgrade"]'); ?>
    <?php echo do_shortcode('[upgrade_kissme type="button" show_popup=1 button_text="Upgrade"]'); ?>
    <?php echo do_shortcode('[upgrade_shadowme type="button" show_popup=1 button_text="Upgrade"]'); ?>

    <?php
      LGS_User_Referrals::liveglam_trade_monthly_product( $subscription_mm['trade']['show_single'], $subscription_mm['trade']['show_set'], 'morpheme',$subscription_mm['subscription']['ID'], $subscription_mm['subscription']['payment_in_month'] );
      LGS_User_Referrals::liveglam_trade_monthly_product( $subscription_km['trade']['show_single'], $subscription_km['trade']['show_set'], 'kissme',$subscription_km['subscription']['ID'], $subscription_km['subscription']['payment_in_month'] );
      LGS_User_Referrals::liveglam_trade_monthly_product( $subscription_sm['trade']['show_single'], $subscription_sm['trade']['show_set'], 'shadowme',$subscription_sm['subscription']['ID'], $subscription_sm['subscription']['payment_in_month'] );

      if( $subscription_mm['button']['show_rate'] ) {
        LiveGlam_Rate_Feature::liveglam_view_past_product('morpheme', $subscription_mm['subscription']['ID']);
      }
      if( $subscription_km['button']['show_rate'] ) {
        LiveGlam_Rate_Feature::liveglam_view_past_product('kissme', $subscription_km['subscription']['ID']);
      }
      if( $subscription_sm['button']['show_rate'] ) {
        LiveGlam_Rate_Feature::liveglam_view_past_product('shadowme', $subscription_sm['subscription']['ID']);
      }
    ?>

    <!-- setting trade popup -->
    <input type="hidden" class="lg-trade-subscription_id" value="" />
    <input type="hidden" class="lg-trade-type_trade" value="" />
    <input type="hidden" class="lg-trade-product_trade" value="" />
    <input type="hidden" class="lg-trade-product_trade_old" value="" />
    <input type="hidden" class="lg-trade-point_old" value="" />
    <input type="hidden" class="lg-trade-point_new" value="" />

    <input class='morpheme show show_trade_message' type='hidden' value="<?php echo esc_html($subscription_mm['button']['show_trade_message']); ?>"/>
    <input class='kissme show show_trade_message' type='hidden' value="<?php echo esc_html($subscription_km['button']['show_trade_message']); ?>" />
    <input class='shadowme show show_trade_message' type='hidden' value="<?php echo esc_html($subscription_sm['button']['show_trade_message']); ?>" />
    <!-- end setting trade popup -->

    <div id="show_trade_message" class='mfp-hide show_trade_message white-popup-block-1'>
      <div class='email_invites_header failed'>
        <img class="img-check" alt="Check Image" src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/popup-cancel-black.svg" />
        <h2>Oops.</h2>
      </div>
      <div class='email_invites_footer'>
        <p>Oh no, your order is still processing! Trade will be available shortly please check back later.</p>
        <button class='btn btn-close-mfp btn-primary'>OK, GOT IT</button>
      </div>
    </div>
  </div>

  <div class="subscription-morpheme-data">
    <?php
      foreach($subscription_mm['billing']['billing_data'] as $key => $value){
        echo "<input class='form-control morpheme morpheme-billing morpheme-billing-{$key}' type='hidden' value='{$value}' />";
      }
      foreach($subscription_mm['shipping']['shipping_data'] as $key => $value){
        echo "<input class='form-control morpheme morpheme-shipping morpheme-shipping-{$key}' type='hidden' value='{$value}' />";
      }
      echo "<input class='form-control morpheme trade-link' type='hidden' value='{$subscription_mm['trade']['link']}'/>";
      echo "<input class='form-control morpheme show show_upgrade' type='hidden' value='{$subscription_mm['button']['show_upgrade']}'/>";
      echo "<input class='form-control morpheme show show_trade' type='hidden' value='{$subscription_mm['button']['show_trade']}'/>";
      echo "<input class='form-control morpheme show show_trade_message' type='hidden' value='{$subscription_mm['button']['show_trade_message']}'/>";
      echo "<input class='form-control morpheme show show_skip' type='hidden' value='{$subscription_mm['button']['show_skip']}'/>";
      echo "<input class='form-control morpheme subs_status' type='hidden' value='{$subscription_mm['subscription']['status']}'/>";
      echo "<input class='form-control morpheme subscriptionID' type='hidden' value='{$subscription_mm['subscription']['ID']}'/>";
      echo "<input class='form-control morpheme action change_date' type='hidden' value='{$subscription_mm['action']['change_date']}'/>";
      echo "<input class='form-control morpheme action reactive' type='hidden' value='{$subscription_mm['action']['reactive']}'/>";
      echo "<input class='form-control morpheme action cancel' type='hidden' value='{$subscription_mm['action']['cancel']}'/>";
      echo "<input class='form-control morpheme show show_cancel_message' type='hidden' value='{$subscription_mm['button']['show_cancel_message']}'/>";
      echo "<input class='form-control morpheme action share' type='hidden' value='{$subscription_mm['action']['share']}'/>";
      echo "<input class='form-control morpheme action skip' type='hidden' value='{$subscription_mm['action']['skip']}'/>";
      echo "<input class='form-control morpheme time next_payment' type='hidden' value='{$display_mm_next_payment}'/>";
      echo "<input class='form-control morpheme time last_payment' type='hidden' value='{$subscription_mm['time']['last_payment']}'/>";
    ?>
  </div>

  <div class="subscription-kissme-data">
    <?php
      foreach($subscription_km['billing']['billing_data'] as $key => $value){
        echo "<input class='form-control kissme morpheme-billing kissme-billing-{$key}' type='hidden' value='{$value}' />";
      }
      foreach($subscription_km['shipping']['shipping_data'] as $key => $value){
        echo "<input class='form-control kissme morpheme-shipping kissme-shipping-{$key}' type='hidden' value='{$value}' />";
      }
      echo "<input class='form-control kissme trade-link' type='hidden' value='{$subscription_km['trade']['link']}'/>";
      echo "<input class='form-control kissme show show_upgrade' type='hidden' value='{$subscription_km['button']['show_upgrade']}' />";
      echo "<input class='form-control kissme show show_trade' type='hidden' value='{$subscription_km['button']['show_trade']}' />";
      echo "<input class='form-control kissme show show_trade_message' type='hidden' value='{$subscription_km['button']['show_trade_message']}' />";
      echo "<input class='form-control kissme show show_skip' type='hidden' value='{$subscription_km['button']['show_skip']}' />";
      echo "<input class='form-control kissme subs_status' type='hidden' value='{$subscription_km['subscription']['status']}'/>";
      echo "<input class='form-control kissme subscriptionID' type='hidden' value='{$subscription_km['subscription']['ID']}'/>";
      echo "<input class='form-control kissme action change_date' type='hidden' value='{$subscription_km['action']['change_date']}' />";
      echo "<input class='form-control kissme action reactive' type='hidden' value='{$subscription_km['action']['reactive']}' />";
      echo "<input class='form-control kissme action cancel' type='hidden' value='{$subscription_km['action']['cancel']}' />";
      echo "<input class='form-control kissme show show_cancel_message' type='hidden' value='{$subscription_km['button']['show_cancel_message']}' />";
      echo "<input class='form-control kissme action share' type='hidden' value='{$subscription_km['action']['share']}' />";
      echo "<input class='form-control kissme action skip' type='hidden' value='{$subscription_km['action']['skip']}' />";
      echo "<input class='form-control kissme time next_payment' type='hidden' value='{$display_km_next_payment}'/>";
      echo "<input class='form-control kissme time last_payment' type='hidden' value='{$subscription_km['time']['last_payment']}'/>";
    ?>
  </div>

  <div class="subscription-shadowme-data">
    <?php
      foreach($subscription_sm['billing']['billing_data'] as $key => $value){
        echo "<input class='form-control shadowme morpheme-billing shadowme-billing-{$key}' type='hidden' value='{$value}' />";
      }
      foreach($subscription_sm['shipping']['shipping_data'] as $key => $value){
        echo "<input class='form-control shadowme morpheme-shipping shadowme-shipping-{$key}' type='hidden' value='{$value}' />";
      }
      echo "<input class='form-control shadowme trade-link' type='hidden' value='{$subscription_sm['trade']['link']}'/>";
      echo "<input class='form-control shadowme show show_upgrade' type='hidden' value='{$subscription_sm['button']['show_upgrade']}' />";
      echo "<input class='form-control shadowme show show_trade' type='hidden' value='{$subscription_sm['button']['show_trade']}' />";
      echo "<input class='form-control shadowme show show_trade_message' type='hidden' value='{$subscription_sm['button']['show_trade_message']}' />";
      echo "<input class='form-control shadowme show show_skip' type='hidden' value='{$subscription_sm['button']['show_skip']}' />";
      echo "<input class='form-control shadowme subs_status' type='hidden' value='{$subscription_sm['subscription']['status']}'/>";
      echo "<input class='form-control shadowme subscriptionID' type='hidden' value='{$subscription_sm['subscription']['ID']}'/>";
      echo "<input class='form-control shadowme action change_date' type='hidden' value='{$subscription_sm['action']['change_date']}' />";
      echo "<input class='form-control shadowme action reactive' type='hidden' value='{$subscription_sm['action']['reactive']}' />";
      echo "<input class='form-control shadowme action cancel' type='hidden' value='{$subscription_sm['action']['cancel']}' />";
      echo "<input class='form-control shadowme show show_cancel_message' type='hidden' value='{$subscription_sm['button']['show_cancel_message']}' />";
      echo "<input class='form-control shadowme action share' type='hidden' value='{$subscription_sm['action']['share']}' />";
      echo "<input class='form-control shadowme action skip' type='hidden' value='{$subscription_sm['action']['skip']}' />";
      echo "<input class='form-control shadowme time next_payment' type='hidden' value='{$display_sm_next_payment}'/>";
      echo "<input class='form-control shadowme time last_payment' type='hidden' value='{$subscription_sm['time']['last_payment']}'/>";
    ?>
  </div>

  <input type="hidden" class="affiliate_link morpheme" value="<?php echo $affiliate_link_mm; ?>"/>
  <input type="hidden" class="affiliate_link kissme" value="<?php echo $affiliate_link_km; ?>"/>
  <input type="hidden" class="affiliate_link shadowme" value="<?php echo $affiliate_link_sm; ?>"/>

  <?php echo lg_show_product_offer(); ?>

  <!--form change next payment-->
  <input type="hidden" id="form-schedule-subscriptionID" value="">
  <input type="hidden" id="form-schedule-new_date" value="">
  <input type="hidden" id="form-schedule-new_month" value="">
  <input type="hidden" id="form-schedule-new_year" value="">

  <?php echo do_shortcode('[basic-user-avatars-my-account]'); ?>
  <input type="hidden" name="update_subscription_address" id="update_subscription_address" value="0">
  <input type="hidden" id="current_point" value="<?php echo $userPoint; ?>">
  <input type="hidden" id="customer_id" value="<?php echo $userID; ?>">
  <input type="hidden" id="total-redeem-orders" value="<?php echo count($redeem_orders); ?>">

  <!-- setting trade popup -->
  <input type="hidden" class="lg-trade-subscription_id" value=""/>
  <input type="hidden" class="lg-trade-type_trade" value=""/>
  <input type="hidden" class="lg-trade-product_trade" value=""/>
  <input type="hidden" class="lg-trade-product_trade_old" value=""/>
  <input type="hidden" class="lg-trade-point_old" value=""/>
  <input type="hidden" class="lg-trade-point_new" value=""/>
  <!-- end setting trade popup -->

  <!--km cancel message popup-->
  <?php if( $subscription_km['button']['show_cancel_message'] ):
    $data_msg_stop_cancel = LGS_CUSTOM_FP::lgs_get_data_message_stop_cancel( $subscription_km['subscription']['ID'], 'kissme' );
    $message_stop_cancel_subscription = $data_msg_stop_cancel['message'];
    $name_sale = $data_msg_stop_cancel['sale_name'];
  ?>
  <div id="km_cancel_message_popup" class='woocommerce-error-popup mfp-hide'>
    <div class='woocommerce-error-header woocommerce-message-header'>
      <img class="img-check" alt="Check Image" src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/popup-cancel-black.svg"/>
      <h2>Hey Glammer!</h2>
    </div>
    <div class='woocommerce-error-footer woocommerce-message-footer'>
      <p><?php echo $message_stop_cancel_subscription; ?></p>
      <a class='btn btn-close btn-primary btn-block btn-solid condensed' onclick="jQuery.magnificPopup.close();" href="#">Never mind, I'll wait.</a>
      <a class='btn btn-contact btn-primary btn-block btn-solid condensed' href="mailto:support@liveglam.com?Subject=<?php echo esc_html("I subscribed to the {$name_sale} and would like to cancel my subscription #".$subscription_km['subscription']['ID']); ?>" >Contact support.</a>
    </div>
  </div>
  <?php endif; ?>

  <!--mm cancel message popup-->
  <?php if( $subscription_mm['button']['show_cancel_message'] ):
    $data_msg_stop_cancel = LGS_CUSTOM_FP::lgs_get_data_message_stop_cancel( $subscription_mm['subscription']['ID'], 'morpheme' );
    $message_stop_cancel_subscription = $data_msg_stop_cancel['message'];
    $name_sale = $data_msg_stop_cancel['sale_name'];
  ?>
  <div id="mm_cancel_message_popup" class='woocommerce-error-popup mfp-hide'>
    <div class='woocommerce-error-header woocommerce-message-header'>
      <img class="img-check" alt="Check Image" src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/popup-cancel-black.svg"/>
      <h2>Hey Glammer!</h2>
    </div>
    <div class='woocommerce-error-footer woocommerce-message-footer'>
      <p><?php echo $message_stop_cancel_subscription; ?></p>
      <a class='btn btn-close btn-primary btn-block btn-solid condensed' onclick="jQuery.magnificPopup.close();" href="#">Never mind, I'll wait.</a>
      <a class='btn btn-contact btn-primary btn-block btn-solid condensed' href="mailto:support@liveglam.com?Subject=<?php echo esc_html("I subscribed to the {$name_sale} and would like to cancel my subscription #".$subscription_mm['subscription']['ID']); ?>" >Contact support.</a>
    </div>
  </div>
  <?php endif; ?>

  <!--sm cancel message popup-->
  <?php if( $subscription_sm['button']['show_cancel_message'] ):
    $data_msg_stop_cancel = LGS_CUSTOM_FP::lgs_get_data_message_stop_cancel( $subscription_sm['subscription']['ID'], 'shadowme' );
    $message_stop_cancel_subscription = $data_msg_stop_cancel['message'];
    $name_sale = $data_msg_stop_cancel['sale_name'];
  ?>
  <div id="sm_cancel_message_popup" class='woocommerce-error-popup mfp-hide'>
    <div class='woocommerce-error-header woocommerce-message-header'>
      <img class="img-check" alt="Check Image" src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/popup-cancel-black.svg"/>
      <h2>Hey Glammer!</h2>
    </div>
    <div class='woocommerce-error-footer woocommerce-message-footer'>
      <p><?php echo $message_stop_cancel_subscription; ?></p>
      <a class='btn btn-close btn-primary btn-block btn-solid condensed' onclick="jQuery.magnificPopup.close();" href="#">Never mind, I'll wait.</a>
      <a class='btn btn-contact btn-primary btn-block btn-solid condensed' href="mailto:support@liveglam.com?Subject=<?php echo esc_html("I subscribed to the {$name_sale} and would like to cancel my subscription #".$subscription_sm['subscription']['ID']); ?>" >Contact support.</a>
    </div>
  </div>
  <?php endif; ?>

  <!--check need reload my-account after change setting-->
  <input type="hidden" name="check-reload-page" value="0">

</div>
<div id="reactivate_form" class='mfp-hide confirm_form'>
  <div class="mb-4">Thank You!<br>Your subscription has been re-activated.</div>
  <button class='btn btn-primary btn-static condensed'>Got it!</button>
</div>
<div class="mfp-hide gform_popupui new-form" id="gform_popupui">
  <div class='popup_UI'><span class='default-loading-icon spin'></span>
    <p>Please wait while we submit your request.</p></div>
</div>
  <div id="gform_popupui" class="d-none old-form">
  <div class='popup_UI'><span class='default-loading-icon spin'></span>
    <p>Please wait while we submit your request.</p></div>
</div>

  <!-- form confirm delete book address -->
  <div class='mfp-hide confirm-address-book-opoup' id="confirm-delete-book-address">
    <div class='confirm-delete-book-address-header'>
      <h2>Delete Address?</h2>
    </div>
    <div class='confirm-delete-book-address-body'>
      <p>If you delete this address, you will receive your subscriptions in the primary address</p>
    </div>
    <div class='confirm-delete-book-address-footer'>
      <div class="address">
        <address></address>
      </div>
      <div class="address-btn-action">
        <button class='btn btn-close btn-secondary btn-static btn-solid condensed' onclick='jQuery.magnificPopup.close();'>CANCEL</button>
        <button class='btn btn-accept submit-delete btn-primary btn-static condensed'>DELETE ADDRESS</button>
      </div>
    </div>
  </div>
  <div class='mfp-hide confirm-address-book-opoup' id="confirm-delete-book-address-message">
    <div class='confirm-delete-book-address-header'>
      <h2>Oops!</h2>
    </div>
    <div class='confirm-delete-book-address-footer'>
      <p>Looks like you are trying to delete a shipping address that is currently being used for a subscription. You will need to assign all subscriptions to a new shipping address before removing this address!</p>
      <div class="address-btn-action once-btn">
        <button class='btn btn-accept btn-primary btn-static condensed' onclick='jQuery.magnificPopup.close();'>Okay.</button>
    </div>
    </div>
  </div>
  <div class='mfp-hide confirm-address-book-opoup' id="exit-without-saving-address">
    <div class='confirm-delete-book-address-header'>
      <h2>Exit without saving changes?</h2>
    </div>
    <div class='confirm-delete-book-address-footer'>
      <p>Looks like you updated your shipping address but did not save the changes! Are you sure you want to proceed?</p>
      <div class="address-btn-action once-btn">
        <button class='btn btn-accept btn-close-popup-save-address btn-primary btn-static condensed' data-option="">I'm sure.</button>
        <a href="" class="btn-continue-redirect"><button class='btn btn-accept btn-continue-redirect d-none btn-primary btn-static condensed'>I'm sure.</button></a>
      </div>
    </div>
  </div>
<?php do_action('woocommerce_after_my_account'); ?>

<?php $data_args = array(
    'subscription_mm' => $subscription_mm['subscription']['ID'],
    'product_trade_mm' => $p_trade_mm,
    'link_reactive_mm' => $subscription_mm['action']['reactive'],
    'points_related_to_mm' => $subscription_mm['subscription']['points_related_to_club'],
    'active_type_mm' => $subscription_mm['button']['active_type'],
    'subscription_km' => $subscription_km['subscription']['ID'],
    'product_trade_km' => $p_trade_km,
    'link_reactive_km' => $subscription_km['action']['reactive'],
    'points_related_to_km' => $subscription_km['subscription']['points_related_to_club'],
    'active_type_km' => $subscription_km['button']['active_type'],
    'subscription_sm' => $subscription_sm['subscription']['ID'],
    'product_trade_sm' => $p_trade_sm,
    'link_reactive_sm' => $subscription_sm['action']['reactive'],
    'points_related_to_sm' => $subscription_sm['subscription']['points_related_to_club'],
    'active_type_sm' => $subscription_sm['button']['active_type'],
    'points' => $userPoint,
    'display_name' => ucwords($current_user->first_name.' '.$current_user->last_name),
    'data_upcoming_mm' => $data_mm_upcomming,
    'data_upcoming_km' => $data_km_upcomming,
    'data_upcoming_sm' => $data_sm_upcomming,
  );
  wc_get_template('form-skip-cancel/kissme/skip-1.php',$data_args);
  wc_get_template('form-skip-cancel/kissme/skip-2.php',$data_args);
  wc_get_template('form-skip-cancel/kissme/skip-3.php',$data_args);
  wc_get_template('form-skip-cancel/kissme/skip-4.php',$data_args);
  wc_get_template('form-skip-cancel/kissme/cancel-1.php',$data_args);
  wc_get_template('form-skip-cancel/kissme/cancel-2.php',$data_args);
  wc_get_template('form-skip-cancel/kissme/cancel-3.php',$data_args);
  wc_get_template('form-skip-cancel/kissme/cancel-4.php',$data_args);
  wc_get_template('form-skip-cancel/kissme/cancel-5.php',$data_args);
  wc_get_template('form-skip-cancel/kissme/reactive.php',$data_args);
  wc_get_template('form-skip-cancel/kissme/cancel-trade.php',$data_args);
  wc_get_template('form-skip-cancel/kissme/cancel-trade-confirmation.php',$data_args);

  wc_get_template('form-skip-cancel/morpheme/skip-1.php',$data_args);
  wc_get_template('form-skip-cancel/morpheme/skip-2.php',$data_args);
  wc_get_template('form-skip-cancel/morpheme/skip-3.php',$data_args);
  wc_get_template('form-skip-cancel/morpheme/skip-4.php',$data_args);
  wc_get_template('form-skip-cancel/morpheme/cancel-1.php',$data_args);
  wc_get_template('form-skip-cancel/morpheme/cancel-2.php',$data_args);
  wc_get_template('form-skip-cancel/morpheme/cancel-3.php',$data_args);
  wc_get_template('form-skip-cancel/morpheme/cancel-4.php',$data_args);
  wc_get_template('form-skip-cancel/morpheme/cancel-5.php',$data_args);
  wc_get_template('form-skip-cancel/morpheme/reactive.php',$data_args);
  wc_get_template('form-skip-cancel/morpheme/cancel-trade.php',$data_args);
  wc_get_template('form-skip-cancel/morpheme/cancel-trade-confirmation.php',$data_args);

  wc_get_template('form-skip-cancel/shadowme/skip-1.php',$data_args);
  wc_get_template('form-skip-cancel/shadowme/skip-2.php',$data_args);
  wc_get_template('form-skip-cancel/shadowme/skip-3.php',$data_args);
  wc_get_template('form-skip-cancel/shadowme/skip-4.php',$data_args);
  wc_get_template('form-skip-cancel/shadowme/cancel-1.php',$data_args);
  wc_get_template('form-skip-cancel/shadowme/cancel-2.php',$data_args);
  wc_get_template('form-skip-cancel/shadowme/cancel-3.php',$data_args);
  wc_get_template('form-skip-cancel/shadowme/cancel-4.php',$data_args);
  wc_get_template('form-skip-cancel/shadowme/cancel-5.php',$data_args);
  wc_get_template('form-skip-cancel/shadowme/reactive.php',$data_args);
  wc_get_template('form-skip-cancel/shadowme/cancel-trade.php',$data_args);
  wc_get_template('form-skip-cancel/shadowme/cancel-trade-confirmation.php',$data_args);
?>