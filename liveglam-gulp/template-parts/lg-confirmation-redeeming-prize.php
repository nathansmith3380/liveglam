<?php
/**
 * Template Name: Confirmation Redeem Prize
 *
 * @package Liveglam
 */

  $order_id = $_GET['order_id'];
  if(false === ($order = wc_get_order($order_id))){
    wp_redirect(home_url('/my-account/'));
    exit;
  }
  $userID = $order->get_user_id();
  get_header(); ?>

    <section class="subscribe-confirmation auto-height new-confirm-page flex-group">
      <div class="new-confirm-page-left no-padding">
        <div class="new-confirm-main">
          <div class="new-confirm-content confirm-redeem">
            <img class="congrat-image" src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/confirm2019-redeem-congrat.png" alt="Congrat">
            <p class="new-confirm-title2019">on Redeeming Your Reward!</p>
          </div>
          <img class="bg-image hide-mobile" src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/confirm2019-redeem-dk.png" alt="Image Background">
          <img class="bg-image show-mobile" src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/confirm2019-redeem-mb.jpg" alt="Image Background">
        </div>
      </div>
      <div class="new-confirm-page-right">
        <div class="new-confirm-main">
          <p class="txt-black new-confirm-title2019 hide-mobile">The best things in life are free!</p>
          <p class="txt-black new-confirm-title2019 show-mobile">Order Details</p>
          <p class="new-confirm-desc2019">Ins’t it nice to get some freebies with your membership? You’ll soon be receiving an email with your tracking link when it ships! Score even more points to be able to redeem more prizes.</p>

          <div class="new-confirm-details2019">
            <div class="order-details-items2019">
              <div class="details-products details-products-subscription">
                <div class="product-item">
                  <div class="item-content">
                    <div class="item-info item-center">
                      <p class="product-item-type">This is what you redeemed:</p>
                    </div>
                  </div>
                </div>
              </div>
              <div class="details-products details-products-individual">
                <?php foreach($order->get_items() as $item):
                  $productID = !empty($item['variation_id'])?$item['variation_id']:$item['product_id'];
                  if (false !== ($shop_product = wc_get_product($item['product_id']))){
                    $product_img = wp_get_attachment_image_src(get_post_thumbnail_id($item['product_id']), array(80, 80));
                    $product_img = $product_img[0];
                    if (!empty($item['variation_id'])) {
                      $variation = wc_get_product($item['variation_id']);
                      $variation_img_url = wp_get_attachment_image_src($variation->get_image_id(), array(300, 300));
                      if(!empty($variation_img_url[0]))
                        $product_img = $variation_img_url[0];
                    }
                  }
                  $item_total = get_post_meta($productID, '_rewardsystem__points', true).' Points'; ?>
                  <div class="product-item">
                    <div class="item-content">
                      <div class="item-info item-left">
                        <img src="<?php echo $product_img; ?>" alt="<?php echo $item['name']; ?>">
                      </div>
                      <div class="item-info item-right">
                        <p class="product-item-title"><span class='quantity'><?php echo $item['qty']; ?>x </span><?php echo $item['name']; ?></p>
                        <p class="product-item-desc"><?php echo $item_total; ?></p>
                      </div>
                    </div>
                  </div>
                <?php endforeach; ?>
              </div>
            </div>
          </div>

          <div class="new-share2019">
            <div class="new-share2019-content">
              <p class="new-share2019-type">YOU NOW HAVE</p>
              <p class="new-share2019-points"><?php echo floor(RSPointExpiry::get_sum_of_total_earned_points($userID)); ?> POINTS</p>
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