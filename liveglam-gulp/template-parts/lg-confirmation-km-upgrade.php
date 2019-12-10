<?php
/**
 * Template Name: Confirmation KissMe Upgrade
 *
 * @package Liveglam
 */

  get_header();

  $order_id = $_GET['order_id'];
  if(false === ($order = wc_get_order($order_id))){
    wp_redirect(home_url('/my-account/'));
    exit;
  }

  foreach ($order->get_items() as $item ){
    if( $item['product_id'] == KM_SIXMONTH ){
      $orderPoints = 100; break;
    }
    if( $item['product_id'] == KM_ANNUAL ){
      $orderPoints = 200; break;
    }
  }

  $orderPoints = isset($orderPoints)?$orderPoints:0; ?>

  <section class="subscribe-confirmation auto-height new-confirm-page flex-group upgrade-confirmation">
    <div class="new-confirm-page-left no-padding">
      <div class="new-confirm-main">
        <img class="bg-image hide-mobile" src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/confirm2019-upgrade-km.png" alt="Image Background">
        <img class="bg-image show-mobile" src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/confirm2019-upgrade-mb.jpg" alt="Image Background">
      </div>
    </div>
    <div class="new-confirm-page-right">
      <div class="new-confirm-main">
        <p class="txt-black new-confirm-title2019">You just committed to a more beauty-full you!</p>
        <p class="new-confirm-desc2019">To keep it extra glam, we just added <?php echo $orderPoints; ?> Reward points to your account.</p>

        <div class="new-share2019 new-share2019-shipping km-bg">
          <div class="new-share2019-content">
            <p class="new-share2019-type">SHIPPING DETAILS</p>
            <p class="new-share2019-title">You’ll be slaying very soon!</p>
            <p class="new-share2019-subtitle">Now that you've upgraded, your shipment dates haven't changed. Your next set of lippies will ship <?php echo date("M d, Y", strtotime("+1 months + 1 day", time())); ?></p>
            <p class="new-share2019-action"><a href="<?php echo home_url('my-account/view-order/'.$order->get_id()); ?>" class="action-link">View your upcoming order<span class="fas fa-chevron-right"></span></a></p>
          </div>
        </div>

        <div class="new-share2019 new-share2019-shop">
          <div class="new-share2019-content">
            <p class="new-share2019-type">SHOP</p>
            <p class="new-share2019-title">New products available in Shop!</p>
            <p class="new-share2019-subtitle">Grab exclusive products or past collections with member discounts to keep slaying! <a href="<?php echo home_url('shop'); ?>" class="action-link">Shop now<span class="fas fa-chevron-right"></span></a></p>
          </div>
        </div>

        <div class="new-share2019 new-share2019-rewards km-bg">
          <div class="new-share2019-content">
            <p class="new-share2019-type">LOTS OF REWARDS</p>
            <p class="new-share2019-title">You just got <?php echo $orderPoints; ?> Rewards Points!</p>
            <p class="new-share2019-subtitle">We add new products on a weekly basis! Check out our <a href="<?php echo home_url('rewards'); ?>" class="action-link">Rewards page<span class="fas fa-chevron-right"></span></a></p>
          </div>
        </div>

        <div class="hide-mobile">
          <div class="new-action2019 order-action-upgrade">
            <p class="view-faq">Questions? <a href="<?php echo home_url('faq'); ?>">View FAQ<span class="fas fa-chevron-right"></span></a></p>
            <a href="<?php echo home_url('shop'); ?>" class="btn-secondary btn-action btn-vw btn-solid transparent">VIEW SHOP</a>
            <a href="<?php echo home_url('my-account'); ?>" class="btn-primary btn-action btn-vw">GO TO MY DASHBOARD</a>
          </div>
        </div>
        <div class="show-mobile">
          <div class="new-action2019 order-action-upgrade">
            <p class="view-faq">Questions about uprading? <a href="<?php echo home_url(); ?>">View FAQ<span class="fas fa-chevron-right"></span></a></p>
            <a href="<?php echo home_url('rewards'); ?>" class="btn-secondary btn-action btn-vw btn-solid transparent">SHOP</a>
            <a href="<?php echo home_url('my-account'); ?>" class="btn-primary btn-action btn-vw">DASHBOARD</a>
          </div>
        </div>

      </div>
    </div>
  </section>
<?php get_footer(); ?>