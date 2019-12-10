<body <?php body_class(array('no-subscribe', 'no-mobile-navbar')); ?>>

<?php if(is_page(PAGE_PRE_CHECKOUT) || is_page('pre-checkout2')){ ?>


  <div class="lgs_body_page">

  <nav class="lg-sub-menubar fixed-top">
    <div class="container">
      <div class="lg-sub-menubar-content">
        <div class="logo-grid">
          <a class="btn-hamburger-back" href="<?php echo home_url(); ?>" data-home_url="<?php echo home_url(); ?>" data-step="1">&nbsp;</a>
          <a class="btn-hamburger-back back-to-step d-none" href="#" data-last_step="1">&nbsp;</a>
        </div>
        <div class="logo-img-content">
          <a href="<?php echo home_url(); ?>" class="btn-logo">
            <img class="logo-img" src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/liveglam.svg" alt="LiveGlam header logo">
          </a>
        </div>
      </div>
    </div>
  </nav>
<?php } else { ?>

<nav class="cbp-spmenu cbp-spmenu-vertical cbp-spmenu-right <?php echo is_user_logged_in()?'login':'logout'; ?>">
  <?php echo liveglam_sidebar_menu(); ?>
</nav>
<nav class="cbp-spmenu cbp-spmenu-vertical cbp-spmenu-left">
  <?php echo liveglam_sidebar_menu_left(); ?>
</nav>

<div class="lgs_body_page">
  <?php do_action('after_body_open_tag'); ?>

  <?php
    $img = '';
    foreach(WC()->cart->get_cart() as $cart_item_key => $cart_item):
      $productID = $cart_item['product_id'];

      if(in_array($productID, lgs_product_mm)):
        $img = '<img class="logo-sub-image hide-mobile" src="'.get_stylesheet_directory_uri().'/assets/img/logo-dashboard-mm.svg" alt="Logo MM"/>';
      elseif(in_array($productID, lgs_product_km) ):
        $img = '<img class="logo-sub-image hide-mobile" src="'.get_stylesheet_directory_uri().'/assets/img/logo-dashboard-km.svg" alt="Logo KM"/>';
      elseif(in_array($productID, lgs_product_sm)):
        $img = '<img class="logo-sub-image hide-mobile" src="'.get_stylesheet_directory_uri().'/assets/img/logo-dashboard-sm.svg" alt="Logo SM"/>';
      endif;

    endforeach;

  ?>

  <!-- Navigation Menu -->

  <nav class="lg-sub-menubar fixed-top">
    <div class="container">
      <div class="lg-sub-menubar-content">
        <div class="logo-grid">
          <a class="btn-hamburger-back checkout_goback payment-goback" href="#" data-home_url="<?php echo home_url(); ?>">&nbsp;</a>
        </div>
        <div class="logo-img-content">
          <a href="<?php echo home_url(); ?>" class="btn-logo">
            <img class="logo-img" src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/liveglam.svg" alt="LiveGlam header logo"><?php echo @$img; ?>
          </a>
        </div>
      </div>
    </div>
  </nav>

<?php } ?>