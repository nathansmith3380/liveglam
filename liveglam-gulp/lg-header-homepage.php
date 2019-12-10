<body <?php body_class('no-subscribe'); ?>>

<nav class="cbp-spmenu cbp-spmenu-vertical cbp-spmenu-right <?php echo is_user_logged_in()?'login':'logout'; ?>">
  <?php echo liveglam_sidebar_menu(); ?>
</nav>
<nav class="cbp-spmenu cbp-spmenu-vertical cbp-spmenu-left">
  <?php echo liveglam_sidebar_menu_left(); ?>
</nav>

<div class="lgs_body_page">
  <?php if (!is_page('search')): ?><div id="lg-search-overlay"><?php show_general_search_content(); ?></div><?php endif;?>

  <?php echo do_shortcode('[show_notice_subscribers banner=1]'); ?>

  <?php do_action('after_body_open_tag'); ?>

  <!-- New Navigation Menu 2019 -->
  <nav class="nav-bar fixed-top no-subscribe nd19-block-content">
    <div class="new-navbar-container container">
      <div class="new-navbar-content">
        <div class="new-navbar-inner new-navbar-left text-left">
          <div class="new-navbar-lists justify-content-left">
            <div class="new-navbar-item no-margin-left">
              <a href="<?php echo home_url('/member-perks'); ?>" class="<?php echo (is_page('member-perks')?'active':''); ?>">Member Perks</a>
            </div>
            <div class="new-navbar-item">
              <a href="<?php echo home_url('/blog'); ?>" class="<?php echo((is_home() && !is_front_page())?'active':''); ?>">Blog</a>
            </div>
            <div class="new-navbar-item">
              <a href="<?php echo get_permalink(wc_get_page_id('shop')); ?>" class="<?php echo(is_shop()?'active':''); ?>">Shop</a>
            </div>
          </div>
        </div>
        <div class="new-navbar-inner new-navbar-center text-center">
          <div class="new-navbar-lists justify-content-center">
            <div class="new-navbar-item">
              <a class="new-navbar-logo" href="<?php echo home_url(); ?>">
                <img class="logo-img" src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/liveglam.svg" alt="LiveGlam header logo">
              </a>
            </div>
          </div>
        </div>
        <div class="new-navbar-inner new-navbar-right text-right">
          <div class="new-navbar-lists justify-content-right">
            <?php if (get_field('enable_search', 'option')): ?>
              <?php if (!is_page('search')): ?>
              <div class="new-navbar-item no-margin-right">
                <a class="btn-search">
                  <img class="logo-search" src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/header-search.png" alt="Search Logo">
                </a>
              </div>
              <?php endif;?>
            <?php endif;?>
            <div class="new-navbar-item dropdown-cart-bag">
              <a class="new-navbar-bag dropbtn btn-cart-bag">
                <img class="logo-bag" src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/header-shop-bag.png" alt="Cart icon">
                <span class="cart_bag count_items">0</span>
              </a>
              <div class="dropdown-content cart_bag cart_bag_desktop cart_content d-none"></div>
            </div>
            <?php if(!is_user_logged_in()) : ?>
              <?php if(!is_account_page()){ ?>
                <div class="new-navbar-item no-margin-right">
                  <a href="<?php echo home_url('/my-account'); ?>" id="modal_login" class="simplemodal-login btn-login text-center">
                    <button class="btn btn-secondary">Log In</button>
                  </a>
                </div>
              <?php } ?>
              <?php if( !empty( get_option( 'options_enable_sign_up_button', 0 ) ) ): ?>
                <div class="new-navbar-item no-margin-right">
                  <a href="<?php echo home_url(PAGE_PRE_CHECKOUT); ?>" class="btn-signup text-center"><!--liveglam_join_now-->
                    <button class="btn btn-primary">Sign Up</button>
                  </a>
                </div>
              <?php endif; ?>
            <?php else: ?>
              <div class="new-navbar-item no-margin-right">
                <a class="btn-logout text-center" href="<?php echo esc_url(wc_logout_url(wc_get_page_permalink('myaccount'))); ?>">
                  <button class="btn btn-secondary">Logout</button>
                </a>
              </div>
              <div class="new-navbar-item no-margin-right">
                <a href="<?php echo esc_url(wc_get_page_permalink('myaccount')); ?>" class="btn-signup text-center btn-dashboard">
                  <button class="btn btn-primary">Dashboard</button>
                </a>
              </div>
            <?php endif; ?>
          </div>
        </div>
      </div>
    </div>

  </nav>

  <div class="mobile-nav-bar">
    <?php echo liveglam_mobile_navbar(); ?>
  </div>

  <div class="notice_subscribers">
    <div class="container">
      <?php echo do_shortcode('[show_notice_subscribers]'); ?>
    </div>
  </div>