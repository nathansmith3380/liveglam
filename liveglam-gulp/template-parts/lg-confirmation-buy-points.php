<?php
/**
 * Template Name: Confirmation Buy Points
 *
 * @package Liveglam
 */

get_header();
$order_id = $_GET['order_id'];
if(false === ($order = wc_get_order($order_id))){
    wp_redirect(home_url('/my-account/'));
    exit;
}
  $userID = $order->get_user_id();
  $totalPoints = floor(RSPointExpiry::get_sum_of_total_earned_points($userID));
  foreach ( $order->get_items() as $item ) { $orderPoint = $item['point']; }
?>

  <section class="subscribe-confirmation auto-height new-confirm-page flex-group">
    <div class="new-confirm-page-left no-padding">
      <div class="new-confirm-main">
        <div class="new-confirm-content confirm-redeem">
          <img class="congrat-image" src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/confirm2019-point-congrat.png" alt="Congrat">
          <p class="new-confirm-title2019">You Are Now <?php echo $totalPoints; ?> Points Richer!</p>
        </div>
        <img class="bg-image hide-mobile" src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/confirm2019-point-dk.png" alt="Image Background">
        <img class="bg-image show-mobile" src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/confirm2019-point-mb.jpg" alt="Image Background">
      </div>
    </div>
    <div class="new-confirm-page-right">
      <div class="new-confirm-main">
        <p class="txt-black new-confirm-title2019">Order Details</p>
        <p class="new-confirm-desc2019">Your order number <?php echo $order_id; ?> is complete and <?php echo $orderPoint; ?> points have been added to your account!</p>

        <div class="new-share2019">
          <div class="new-share2019-content">
            <p class="new-share2019-type">YOU NOW HAVE</p>
            <p class="new-share2019-points"><?php echo $totalPoints; ?> POINTS</p>
          </div>
        </div>

        <div class="new-confirm-details2019">
          <div class="order-details2019">
            <div class="order-details2019-content">
                <div class="order-details2019-item">
                  <p class="order-details2019-head">Order Number</p>
                  <p class="order-details2019-desc"><?php echo $order->get_id(); ?></p>
                  <a href="#" class="order-details2019-link">View Order Details<span class="fas fa-chevron-right"></span></a>
                </div>
                <div class="order-details2019-item">
                  <p class="order-details2019-head">Payment Method</p>
                  <p class="order-details2019-desc"><?php echo $order->get_payment_method_title(); ?></p>
                </div>
                <div class="order-details2019-item">
                  <p class="order-details2019-head">Date of Order</p>
                  <p class="order-details2019-desc"><?php if ($order->get_date_paid()) echo $order->get_date_paid()->date('M j, Y');?></p>
                </div>
            </div>
            <div class="order-details2019-content">
              <div class="order-details2019-item">
                <p class="order-details2019-head">Item Purchased</p>
                <p class="order-details2019-desc">Reward Points</p>
              </div>
              <div class="order-details2019-item">
                <p class="order-details2019-head">Amount Paid</p>
                <p class="order-details2019-desc">$<?php echo $order->get_total();?></p>
              </div>
            </div>
          </div>
        </div>

        <div class="new-share2019">
          <div class="new-share2019-content">
            <p class="new-share2019-type">REFERRAL LINK</p>
            <p class="new-share2019-desc">Invite your friends and they’ll get a free lippie or brush and you’ll score <?php echo Liveglam_User_Level::get_user_level()=='gold' ? 250 : 200; ?> Reward Points when they join.</p>

            <div class="new-share2019-referral">
              <label class="d-none" for="copyTarget">&nbsp;</label>
              <input id="copyTarget" class="copyTarget input-field" type="text" value="<?php echo lgs_get_referral_link($userID); ?>" readonly="">
              <button id="copyButton" class="btn-secondary btn-vw btn-solid transparent">Copy Link</button>
            </div>
          </div>
        </div>

        <div class="hide-mobile">
          <div class="new-action2019 order-action-redeem">
            <a href="<?php echo home_url('rewards'); ?>" class="btn-secondary btn-action btn-vw btn-solid transparent">GO TO REWARDS</a>
            <a href="<?php echo home_url('my-account'); ?>" class="btn-primary btn-action btn-vw">GO TO MY DASHBOARD</a>
          </div>
        </div>
        <div class="show-mobile">
          <div class="new-action2019 order-action-redeem">
            <a href="<?php echo home_url('rewards'); ?>" class="btn-secondary btn-action btn-vw btn-solid transparent">REWARDS</a>
            <a href="<?php echo home_url('my-account'); ?>" class="btn-primary btn-action btn-vw">DASHBOARD</a>
          </div>
        </div>
      </div>
    </div>
  </section>

<?php get_footer(); ?>