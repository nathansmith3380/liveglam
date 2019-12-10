<?php
/**
 * Template Name: Confirmation MorpheMe Resume
 *
 * @package Liveglam
 */

get_header();

  $order_id = $_GET['order_id'];
  if(false === ($order = wc_get_order($order_id))){
    wp_redirect(home_url('/my-account/'));
    exit;
  }
  foreach($order->get_items() as $item){
    if(in_array($item['product_id'], lgs_product_mm))
      $productID = $item['product_id'];
  }
  switch($productID){
    case MM_MONTHLY:$orderType = '1 month'; break;
    case MM_SIXMONTH: $orderType = '6 months'; break;
    case MM_ANNUAL: $orderType = '12 months'; break;
  }
  $earnPoint = (Liveglam_User_Level::get_user_level() == 'gold')?250:200;

  $subscriptions = wcs_get_subscriptions_for_order($order->get_id(), array('order_type' => array('parent', 'renewal')));
  foreach($subscriptions as $subscription){
    $subscription = wcs_get_subscription($subscription);
    $next_billing_date = date('M d, Y', $subscription->get_time('next_payment', 'site'));
    $next_shipment = LGS_User_Referrals::lg_get_next_shipment_date($subscription, true);
    $next_shipment = !empty($next_shipment)?date('m/d/Y', $next_shipment):0;
  }

  $shipping_address = $order->get_address('shipping');
  if(isset($shipping_address['first_name'])) unset($shipping_address['first_name']);
  if(isset($shipping_address['last_name'])) unset($shipping_address['last_name']);
  $shipping_address = WC()->countries->get_formatted_address($shipping_address, ', ');

  $order_details = lgs_order_detail_items($order, 'morpheme');

?>

  <section class="subscribe-confirmation auto-height detail-confirmation">
    <div class="banner-order-confirm">
      <img class="hide-mobile" src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/confirm2019-resume-mm.png" alt="MorpheMe Confirm Image">
      <img class="show-mobile" src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/confirm2019-resume-mm1.png" alt="MorpheMe Confirm Image">
    </div>
    <div class="new-confirm-page flex-group confirm-joinin2019">
      <div class="new-confirm-page-left">
        <div class="new-confirm-main">
          <p class="new-confirm-title2019 hide-mobile">Hey <?php echo $order->get_billing_first_name(); ?>!</p>
          <p class="new-confirm-title2019 show-mobile">Yaas! You’re back!</p>
          <p class="new-confirm-desc2019 hide-mobile">Thank you for rejoining MorpheMe! It's always great to have you here! FYI - Your brushes are being prepped and will be en route to you within <strong>2 business days.</strong></p>
          <p class="new-confirm-desc2019 show-mobile">Hey <?php echo $order->get_billing_first_name(); ?>! Thank you for rejoining MorpheMe! It's always great to have you here! FYI - Your brushes are being prepped and will be en route to you within <strong>2 business days.</strong></p>
          <div class="new-confirm-details2019">
            <?php if(!empty($order_details['individual_item']) || !empty($order_details['trade']['traded_item']) || !empty($order_details['free_gaga'])) : ?>
              <div class="order-details-items2019">
                <div class="details-products details-products-subscription">
                  <div class="product-item">
                    <div class="item-content">
                      <div class="item-info item-center">
                        <p class="product-item-type">This is what you’re getting:</p>
                      </div>
                    </div>
                  </div>
                </div>
                <?php if(!empty($order_details['individual_item'])): ?>
                  <div class="details-products details-products-individual">
                    <?php foreach($order_details['individual_item'] as $item): ?>
                      <div class="product-item">
                        <div class="item-content">
                          <div class="item-info item-left">
                            <img src="<?php echo $item['image']; ?>" alt="<?php echo $item['title']; ?>">
                          </div>
                          <div class="item-info item-right">
                            <p class="product-item-title"><span class='quantity'>1x </span><?php echo $item['title']; ?></p>
                            <p class="product-item-desc"><?php echo $item['desc']; ?></p>
                          </div>
                        </div>
                      </div>
                    <?php endforeach; ?>
                  </div>
                <?php endif; ?>

                <?php if(!empty($order_details['trade']['traded_item'])): ?>
                  <div class="details-products details-products-trade">
                    <?php foreach($order_details['trade']['traded_item'] as $item): ?>
                      <div class="product-item">
                        <div class="product-badge"><span>Traded</span></div>
                        <div class="item-content">
                          <div class="item-info item-left">
                            <img src="<?php echo $item['image']; ?>" alt="<?php echo $item['title']; ?>">
                          </div>
                          <div class="item-info item-right show-badge">
                            <p class="product-item-title"><span class='quantity'>1x </span><?php echo $item['title']; ?></p>
                            <p class="product-item-desc"><?php echo $item['desc']; ?></p>
                          </div>
                        </div>
                      </div>
                    <?php endforeach; ?>
                  </div>
                <?php endif; ?>

                <?php if(!empty($order_details['free_gaga'])): ?>
                  <div class="details-products details-products-free">
                    <?php foreach($order_details['free_gaga'] as $item): ?>
                      <div class="product-item">
                        <div class="product-badge"><span>Free</span></div>
                        <div class="item-content">
                          <div class="item-info item-left">
                            <img src="<?php echo $item['image']; ?>" alt="<?php echo $item['title']; ?>">
                          </div>
                          <div class="item-info item-right show-badge">
                            <p class="product-item-title"><span class='quantity'>1x </span><?php echo $item['title']; ?></p>
                            <p class="product-item-desc"><?php echo $item['desc']; ?></p>
                          </div>
                        </div>
                      </div>
                    <?php endforeach; ?>
                  </div>
                <?php endif; ?>
              </div>
            <?php endif; ?>
          </div>
          <p class="confirm-details-title">Next Collection</p>
          <p class="new-confirm-desc2019 next_collection_content mb-0">
            Our new collections are always debuted on the <strong>23rd of each month! </strong>Your
            <strong>2nd Collection will ship on <?php echo $next_shipment; ?></strong>. So make sure to keep up with our socials to find out what other exciting products we've got in store for you!
          </p>
        </div>
      </div>
      <div class="new-confirm-page-right">
        <div class="new-confirm-main">
          <p class="txt-black new-confirm-title2019">Order Details</p>
          <p class="new-confirm-desc2019">Change your billing date & shipping info anytime in your
            <a href="<?php echo home_url('/my-account'); ?>">Dashboard.</a> Learn everything about the perks that come with your membership + our Dashboard
            <a href="<?php echo home_url('/my-account'); ?>">here.</a>
          </p>
          <div class="new-confirm-details2019">
            <div class="order-details2019">
              <div class="order-details2019-content">
                <div class="order-details2019-item colspan3 content-inline">
                  <p class="order-details2019-desc mt-0 ml-0 mr-0 mb-0">MorpheMe Subscription - <?php echo $orderType; ?></p>
                  <p class="order-details2019-head mt-0 ml-0 mr-0 mb-0">Total: <span class="order-details2019-desc txt-pink"><?php echo '$ '.$order->get_total() ?></span></p>
                </div>
              </div>
              <div class="order-details2019-content">
                <div class="order-details2019-item">
                  <p class="order-details2019-head">Order Number</p>
                  <p class="order-details2019-desc"><?php echo $order->get_id(); ?></p>
                  <a href="<?php echo home_url('my-account/view-order/'.$order->get_id()); ?>" class="order-details2019-link">View Order Details<span class="fas fa-chevron-right"></span></a>
                </div>
                <div class="order-details2019-item">
                  <p class="order-details2019-head">Payment Method</p>
                  <p class="order-details2019-desc"><?php echo $order->get_payment_method_title(); ?></p>
                </div>
                <div class="order-details2019-item">
                  <p class="order-details2019-head">Next Billing <span class="hide-mobile">Date</span></p>
                  <p class="order-details2019-desc"><?php echo $next_billing_date; ?></p>
                </div>
              </div>
              <div class="order-details2019-content">
                <div class="order-details2019-item colspan3">
                  <p class="order-details2019-head">Shipping Address</p>
                  <p class="order-details2019-desc"><?php echo $shipping_address; ?></p>
                  <a href="<?php echo home_url('/contact-us'); ?>" class="order-details2019-link">Wrong address? Contact Us<span class="fas fa-chevron-right"></span></a>
                </div>
              </div>
            </div>
          </div>
          <hr class="show-mobile">
          <p class="txt-black new-confirm-title2019 share-the-love">Share the Love</p>
          <div class="new-share2019 mb-0">
            <div class="new-share2019-content">
              <p class="new-share2019-type">FREE GOODIES</p>
              <p class="new-share2019-notice">Get Free Products for You & Your Friends!</p>
              <p class="new-share2019-desc">Invite your friends and they'll get a free lippie or brush and you'll score <?php echo $earnPoint; ?> Reward Points when they join.</p>
              <div class="new-share2019-email">
                <p class="share-free-content-text">Share through Email:</p>
                <?php echo do_shortcode('[send_email_invites]'); ?>
                <div class="social-icons">
                  <p class="share-free-content-text">Or on your social media:</p>
                  <?php echo do_shortcode('[social_share]'); ?>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="new-confirm-page-bottom">
      <div class="bottom-content hide-mobile">
        <div class="question-faq">
          <a href="<?php echo home_url('faq'); ?>">Questions? <span>View FAQ <i class="fas fa-chevron-right"></i></span></a>
        </div>
        <div class="dashboard-go">
          <a class="btn-action btn btn-primary btn-solid btn-vw change-view" href="<?php echo home_url('shop') ?>">View Shop</a>
          <a href="<?php echo home_url('/my-account/'); ?>" class="btn-action btn btn-secondary btn-vw">Go my dashboard</a>
        </div>
      </div>
      <div class="bottom-content show-mobile">
        <div class="question-faq">
          <a href="<?php echo home_url('faq'); ?>">Questions? <span>View FAQ <i class="fas fa-chevron-right"></i></span></a>
        </div>
        <div class="dashboard-go">
          <a class="btn-action btn btn-secondary btn-solid btn-vw transparent" href="<?php echo home_url('shop') ?>">Shop</a>
          <a href="<?php echo home_url('/my-account/'); ?>" class="btn-action btn btn-primary btn-vw">Dashboard</a>
        </div>
      </div>
    </div>
  </section>
<?php get_footer(); ?>