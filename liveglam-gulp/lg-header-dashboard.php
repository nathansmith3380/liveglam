<?php $class_no_subscribe = array('no-top', ' no-mobile-navbar'); ?>
<body <?php body_class($class_no_subscribe); ?>>

<nav class="cbp-spmenu cbp-spmenu-vertical cbp-spmenu-right <?php echo is_user_logged_in()?'login':'logout'; ?>">
  <?php echo liveglam_sidebar_menu(); ?>
</nav>
<nav class="cbp-spmenu cbp-spmenu-vertical cbp-spmenu-left">
  <?php echo liveglam_sidebar_menu_left(); ?>
</nav>

<div class="lgs_body_page">

  <?php do_action('after_body_open_tag'); ?>

  <?php
    global $LG_userData, $LG_userAvata;
    global $subsStatus;
    global $img_sidebar_mm, $img_sidebar_km, $img_sidebar_sm;

    $active_mm = $active_km = $active_sm = '';
    $class_mm = $class_km = $class_sm = $class_lg = '';
    $link_mm = $link_km = $link_sm = $link_lg = '';

    $userID = get_current_user_id();
    $userLevel = Liveglam_User_Level::get_user_level($userID);
    $LG_userData = new WP_User($userID);
    $local_avatars = get_user_meta($userID, 'basic_user_avatar', true);
    $LG_userAvata = lg_get_avatar_for_user($userID, 300);

    $status_array = array('active', 'waitlist');
    $current_date = date('j', current_time('timestamp'));
    $current_month = date('n', current_time('timestamp'));
    if($current_date > 22){
      $current_month = $current_month + 1;
    }

    $shipping_box = date('F', mktime(0, 0, 0, $current_month, 10));
    if(in_array($subsStatus['get_status_morpheme'], $status_array)){
      $link_mm = home_url('/monthly_brushes/');
      $title_mm = 'Subscribed this '.$shipping_box;
      $img_mm = get_stylesheet_directory_uri().'/assets/img/check.png';
      $active_mm = 'subscribed';
    }else{
      $link_mm = home_url(PAGE_PRE_CHECKOUT.'?club=morpheme');
      $title_mm = 'Receive '.$shipping_box.' Brushes';
      $img_mm = get_stylesheet_directory_uri()."/assets/img/minus.png";
      $class_mm = 'unchecked';
    }

    if(in_array($subsStatus['get_status_kissme'], $status_array)){
      $link_km = home_url('/monthly_lipstick/');
      $title_km = 'Subscribed this '.$shipping_box;
      $img_km = get_stylesheet_directory_uri().'/assets/img/check.png';
      $active_km = 'subscribed';
    }else{
      $link_km = home_url(PAGE_PRE_CHECKOUT.'?club=kissme');
      $title_km = 'Receive '.$shipping_box.' Lippies';
      $img_km = get_stylesheet_directory_uri()."/assets/img/minus.png";
      $class_km = 'unchecked';
    }

    if(in_array($subsStatus['get_status_shadowme'], $status_array)){
      $link_sm = home_url('/'.PAGE_SHADOWME_MONTHLY);
      $title_sm = 'Subscribed this '.$shipping_box;
      $img_sm = get_stylesheet_directory_uri().'/assets/img/check.png';
      $active_sm = 'subscribed';
    }else{
      $link_sm = home_url(PAGE_PRE_CHECKOUT.'?club=shadowme');
      //$title_sm = 'Receive '.$shipping_box .' Eyeshadow';
      $title_sm = 'Receive '.LGS_SHADOWME_ORDER::lgs_calculate_shipping_box_sm(current_time('timestamp'));
      $img_sm = get_stylesheet_directory_uri()."/assets/img/minus.png";
      $class_sm = 'unchecked';
    }

    $img_sidebar_mm = isset($img_sidebar_mm)?$img_sidebar_mm:get_stylesheet_directory_uri().'/assets/img/sm-thumb-brush.png';
    $img_sidebar_km = isset($img_sidebar_km)?$img_sidebar_km:get_stylesheet_directory_uri().'/assets/img/sm-thumb-lipstick.png';
    $img_sidebar_sm = isset($img_sidebar_sm)?$img_sidebar_sm:get_stylesheet_directory_uri().'/assets/img/icon-monthly-shadowme.png';

    $userPoint = RSPointExpiry::get_sum_of_total_earned_points($userID);
    $userPoint = floor($userPoint);
    if(in_array($userLevel, array('diamond','diamond trial', 'diamond elite'))){
      $userPoint = wc_price(Liveglam_User_Level::convert_point($userPoint), array('decimals' => 0));
    }
    $imageLevel_url = '';
    if(in_array( $userLevel, array( 'silver', 'gold', 'diamond', 'diamond trial', 'diamond elite' ) ) ){
      $img_extend = ($userLevel == 'diamond trial')?'diamond':(($userLevel == 'diamond elite')?'diamond-elite':$userLevel);
      $imageLevel_url = get_stylesheet_directory_uri()."/assets/img/icon-reward-tier-{$img_extend}.png";
    }

    $userLifetimeReferrals = IzCustomization::count_total_referral($userID);

    echo do_shortcode('[show_notice_subscribers banner=1]');

  ?>

  <div class="pg-dashboard">
    <div class="dashboard-nav-2019 hide-mobile">
      <div class="dashboard-inner-2019">
        <div class="dashboard-sticky-2019">
          <div class="dashboard-logo">
            <a href="<?php echo home_url(); ?>">
              <img class="logo-img" src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/liveglam.svg" alt="LiveGlam header log">
            </a>
          </div>
          <div class="dashboard-user-info">
            <div class="dbui-content">
              <div class="dbui-top">
                <div class="dbui-top-content">
                  <img class="dbui-img-avatar" alt="User Avatar" src="<?php echo $LG_userAvata; ?>" />
                </div>
              </div>
              <div class="dbui-mid">
                <p class="dbui-name"><?php echo $LG_userData->first_name.' '.$LG_userData->last_name; ?></p>
                <p class="dbui-display_name"><?php echo $LG_userData->user_login; ?></p>
                <?php if(is_page('my-account')){ ?>
                  <a class="setting-myaccount-2">
                    <p class="dbui-action"><img alt="Edit Profile" src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/icon-edit-profile-pink.png" />Edit Profile</p>
                  </a>
                <?php } ?>
              </div>
              <div class="dbui-bot">
                <div class="dbui-data">
                  <span><?php echo $userLifetimeReferrals; ?></span>
                  <span class="mac-info">REFERRALS</span>
                  <span class="mac-info" data-toggle="tooltip" data-placement="top" title="" data-original-title="Total number of Glammers you referred."><img alt="Info" src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/icon-myaccount-info-new.svg"/></span>
                </div>
                <div class="dbui-separator">&nbsp;</div>
                <div class="dbui-data">
                  <span><?php if(!empty($imageLevel_url)){ ?><img class="dbui-img-tier" alt="User Tier" src="<?php echo $imageLevel_url; ?>" /><?php } ?></span>
                  <span class="mac-info"><?php echo $userLevel=='diamond trial'?'Diamond':ucwords($userLevel); ?></span>
                  <span class="mac-info" data-toggle="tooltip" data-placement="top" title="" data-original-title="Your membership tier."><img alt="Info" src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/icon-myaccount-info-new.svg"/></span>
                </div>
                <div class="dbui-separator">&nbsp;</div>
                <div class="dbui-data">
                  <span><?php echo $userPoint; ?></span>
                  <span class="mac-info"><?php echo in_array($userLevel, array('diamond', 'diamond trial', 'diamond elite'))?'BALANCE':'POINTS'; ?></span>
                  <span class="mac-info" data-toggle="tooltip" data-placement="top" title="" data-original-title="Total <?php echo in_array($userLevel, array('diamond','diamond trial', 'diamond elite'))?'cash':'points'; ?> you got for referring new Glammers and being an active member!"><img alt="Info" src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/icon-myaccount-info-new.svg"/></span>
                </div>
              </div>
            </div>
          </div>
          <div class="dashboard-menu-list">
            <a href="<?php echo home_url('/my-account'); ?>">
              <div class="dbml-item <?php echo is_page('my-account')?'active':''; ?>">
                <img class="dbml-icon show-active" alt="My Dashboard" src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/icon-myaccount-pink-new.png" />
                <img class="dbml-icon hide-active" alt="My Dashboard" src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/icon-myaccount-gray.png" />
                My Dashboard
              </div>
            </a>
            <a href="<?php echo $link_mm; ?>">
              <div class="dbml-item <?php echo is_post_type_archive('monthly_brushes')?'active':''; ?>">
                <img class="dbml-icon show-active" alt="MorpheMe" src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/icon-morpheme-pink-new.png" />
                <img class="dbml-icon hide-active" alt="MorpheMe" src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/icon-morpheme-gray.png" />
                MorpheMe
              </div>
            </a>
            <a href="<?php echo $link_km; ?>">
              <div class="dbml-item <?php echo is_post_type_archive('monthly_lipstick')?'active':''; ?>">
                <img class="dbml-icon show-active" alt="KissMe" src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/icon-kissme-pink-new.png" />
                <img class="dbml-icon hide-active" alt="KissMe" src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/icon-kissme-gray.png" />
                KissMe
              </div>
            </a>
            <a href="<?php echo $link_sm; ?>">
              <div class="dbml-item <?php echo is_post_type_archive('monthly_eyeshadows')?'active':''; ?>">
                <img class="dbml-icon show-active" alt="ShadowMe" src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/icon-shadowme-pink-new.png" />
                <img class="dbml-icon hide-active" alt="ShadowMe" src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/icon-shadowme-gray.png" />
                ShadowMe
              </div>
            </a>
            <a href="<?php echo home_url('/shop'); ?>">
              <div class="dbml-item <?php echo is_shop()?'active':''; ?>">
                <img class="dbml-icon show-active" alt="Shop" src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/icon-shop-pink-new.png" />
                <img class="dbml-icon hide-active" alt="Shop" src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/icon-shop-gray.png" />
                Shop
              </div>
            </a>
            <a href="<?php echo home_url('/rewards'); ?>">
              <div class="dbml-item <?php if(is_page('rewards')) echo 'active'; ?>">
                <img class="dbml-icon show-active" alt="Rewards" src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/icon-rewards-pink-new.png" />
                <img class="dbml-icon hide-active" alt="Rewards" src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/icon-rewards-gray.png" />
                Rewards
              </div>
            </a>
            <a href="<?php echo home_url('/blog'); ?>">
              <div class="dbml-item <?php echo (is_home() && ! is_front_page())?'active':''; ?>">
                <img class="dbml-icon show-active" alt="Blog" src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/icon-blog-pink-new.png" />
                <img class="dbml-icon hide-active" alt="Blog" src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/icon-blog-gray.png" />
                Blog
              </div>
            </a>
            <a href="<?php echo home_url('/faq'); ?>">
              <div class="dbml-item <?php echo is_page('faq')?'active':''; ?>">
                <img class="dbml-icon show-active" alt="FAQ" src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/icon-faq-pink-new.png" />
                <img class="dbml-icon hide-active" alt="FAQ" src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/icon-faq-gray.png" />
                FAQ
              </div>
            </a>
            <a href="<?php echo esc_url( wc_logout_url( wc_get_page_permalink( 'myaccount' ) ) ); ?>">
              <div class="dbml-item">
                <img class="dbml-icon show-active" alt="Logout" src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/icon-logout-pink-new.png" />
                <img class="dbml-icon hide-active" alt="Logout" src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/icon-logout-gray.png" />
                Logout
              </div>
            </a>
          </div>
        </div>
      </div>
    </div>

    <div class="mobile-nav-bar">

      <?php if( is_user_logged_in() && is_post_type_archive( array('monthly_brushes','monthly_lipstick','monthly_eyeshadows') ) ): ?>

        <div class="mobile-nav-monthly">
          <div class="mobile-nav-monthly-content">
            <div class="mobile-nav-monthly-left">
              <a href="<?php echo home_url('/my-account/'); ?>">Close</a>
            </div>
            <div class="mobile-nav-monthly-right">
              <label class="d-none" for="dashboard-select-month2">&nbsp;</label>
              <select name="dashboard-select-month" id="dashboard-select-month2" class="selectpicker dashboard-select-month right-border">
                <?php $monthly_brushes = 0;
                  while(have_posts()) : the_post(); ?>
                    <option value="<?php echo 'monthPost_'.$monthly_brushes; ?>" data-id="<?php echo $monthly_brushes; ?>" <?php if($monthly_brushes == 0)
                      echo 'selected="selected"'; ?>><?php echo get_the_title(); ?></option>
                    <?php $monthly_brushes++; endwhile;
                  rewind_posts(); ?>
              </select>
            </div>
          </div>
        </div>

      <?php else: ?>

        <?php echo liveglam_mobile_navbar(); ?>

      <?php endif; ?>

    </div>