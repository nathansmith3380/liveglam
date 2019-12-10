<?php
/**
 * Template Name: Confirmation Shop Individual
 *
 * @package Liveglam
 */

  get_header();
$order_id = $_GET['order_id'];
if(false === ($order = wc_get_order($order_id))){
    wp_redirect(home_url('/my-account/'));
    exit;
}
  $shipping_address = $order->get_address('shipping');
  if(isset($shipping_address['first_name'])) unset($shipping_address['first_name']);
  if(isset($shipping_address['last_name'])) unset($shipping_address['last_name']);
  $shipping_address = WC()->countries->get_formatted_address($shipping_address, ', ');

  $order_subtotal = $order->get_subtotal();
  $order_shipping = $order->get_shipping_total();
  $order_tax = $order->get_total_tax();
  $order_discount = $order->get_discount_total();
  $p_id = 0;

  foreach( $order->get_items() as $item ){
    if(in_array($item['product_id'], LDM_PRODUCTS_HOLIDAY) ){ //LDM sale
      $p_id = 2;
      break;
    }
  }
?>

<?php if($p_id == 2){ ?>
    <style>
      .shop-confirmation .confirmation-received {
        background: url(<?php echo get_stylesheet_directory_uri();?>/assets/img/ldmjoy-sale-confirm-bg.png), linear-gradient(to right, #AABED6 0%, #C6D7EB 70%);
        background-repeat: no-repeat;
        background-position: right bottom;
        background-size: 35% auto, 100% 100%;
      }
      @media only screen and (max-width: 767px){
        .shop-confirmation .confirmation-received {
          background: linear-gradient(to bottom, #C6D7EB 0%, #AABED6 100%);
        }
        .shop-confirmation .conf-wrap .shop-confirm-content {
          width: 100%;
        }
        .new-confirm-page .new-confirm-main .new-confirm-title2019 {
          color: #F05E7C !important;
        }
      }
    </style>
<?php } ?>

<section class="shop-confirmation auto-height new-confirm-page">
    <div class="confirmation-received">
        <div class="conf-wrap new-confirm-main">
          <div class="shop-confirm-content">
            <p class="txt-black new-confirm-title2019 hide-mobile">Hey Glammer! Thanks for shopping at LiveGlam!</p>
            <p class="txt-black new-confirm-title2019 show-mobile">Thanks for shopping at LiveGlam!</p>
            <p class="new-confirm-desc2019">We're so excited for you to play with your new goodies! FYI - your package is being prepped and will be en route to you within <strong>2 business days!</strong></p>
          </div>
          <div class="conf-details">
            <div class="conf-table-top">
              <p>ORDER DETAILS</p>
            </div>
            <div class="conf-table-body">
              <div class="conf-body-top">
                <div class="conf-list-item">
                  <div class="col-body-left">
                    <p class="conf-body-subtitle">Product</p>
                  </div>
                  <div class="col-body-right">
                    <p class="conf-body-subtitle">Price</p>
                  </div>
                </div>
                <?php foreach($order->get_items('line_item') as $key => $item): ?>
                  <div class="conf-list-item">
                    <div class="col-body-left">
                      <div class="conf-list-item-details">
                        <div class="conf-list-item-left">
                        <?php $product = wc_get_product($item['product_id']);
                          if(!empty($item['variation_id'])){
                            $variation = wc_get_product($item['variation_id']);
                            echo $variation->get_image(array(100, 100));
                          }else{
                            echo $product->get_image(array(100, 100));
                          } ?>
                        </div>
                        <div class="conf-list-item-right ">
                          <p class="conf-body-price"><strong><?php echo $item['quantity']; ?>x </strong><?php echo $item['name']; ?></p>
                        </div>
                      </div>
                    </div>
                    <div class="col-body-right">
                      <div class="conf-list-item-details">
                        <p class="conf-body-price"><?php echo wc_price($item['subtotal']); ?></p>
                      </div>
                    </div>
                  </div>
                <?php endforeach; ?>
              </div>
              <div class="conf-body-bot">
                <?php if($order_subtotal > 0) : ?>
                  <div class="conf-list-item conf-subtotal">
                    <div class="col-body-left">
                      <div class="conf-list-item-details">
                        <p class="conf-body-subtitle">Subtotal</p>
                      </div>
                    </div>
                    <div class="col-body-right">
                      <div class="conf-list-item-details">
                        <p class="conf-body-price"><?php echo wc_price($order_subtotal); ?></p>
                      </div>
                    </div>
                  </div>
                <?php endif;
                  if($order_discount > 0) : ?>
                    <div class="conf-list-item conf-discount">
                      <div class="col-body-left">
                        <p class="conf-body-subtitle">Discount</p>
                      </div>
                      <div class="col-body-right">
                        <div class="conf-list-item-details">
                          <p class="conf-body-price"><?php echo wc_price($order_discount); ?></p>
                        </div>
                      </div>
                    </div>
                  <?php endif;
                  if($order_shipping > 0) : ?>
                    <div class="conf-list-item conf-shipping">
                      <div class="col-body-left">
                        <div class="conf-list-item-details">
                          <p class="conf-body-subtitle">Shipping<br>
                            <small class="shipped_via"><?php echo sprintf(__('Via %s', 'woocommerce'), $order->get_shipping_method()); ?></small>
                          </p>
                        </div>
                      </div>
                      <div class="col-body-right">
                        <div class="conf-list-item-details">
                          <p class="conf-body-price"><?php echo wc_price($order_shipping); ?></p>
                        </div>
                      </div>
                    </div>
                  <?php endif;
                  if($order_tax > 0) : ?>
                    <div class="conf-list-item conf-tax">
                      <div class="col-body-left">
                        <p class="conf-body-subtitle">Tax</p>
                      </div>
                      <div class="col-body-right">
                        <div class="conf-list-item-details">
                          <p class="conf-body-price"><?php echo wc_price($order_tax); ?></p>
                        </div>
                      </div>
                    </div>
                  <?php endif; ?>
              </div>
            </div>
            <div class="conf-details-bot conf-table-bot">
              <div class="conf-total conf-list-item">
                <div class="col-body-left">
                  <p>TOTAL</p>
                </div>
                <div class="col-body-right">
                  <p><?php echo wc_price($order->get_total()); ?></p>
                </div>
              </div>
            </div>
          </div>
          <div class="conf-summary">
            <div class="conf-table-top">
              <p>SUMMARY</p>
            </div>
            <div class="conf-table-body">
              <div class="conf-body-top conf-body-order-details">
                  <div class="conf-body-order-item">
                    <p class="conf-body-title">Order number</p>
                    <p class="conf-body-content"><?php echo $order->get_id(); ?></p>
                  </div>
                  <div class="conf-body-order-item">
                    <p class="conf-body-title">Date</p>
                    <p class="conf-body-content"><?php echo $order->get_date_created()->date('F d, Y'); ?></p>
                  </div>
                  <div class="conf-body-order-item">
                    <p class="conf-body-title">Total</p>
                    <p class="conf-body-content"><?php echo  wc_price($order->get_total()); ?></p>
                  </div>
                  <div class="conf-body-order-item">
                    <p class="conf-body-title">Payment Method</p>
                    <p class="conf-body-content"><?php echo $order->get_payment_method_title(); ?></p>
                  </div>
              </div>
              <div class="conf-body-bot conf-body-shipping-details">
                <div class="conf-body-order-center">
                  <p class="conf-body-title">Shipping Address
                    <a class="wrong-address float-right hide-mobile" href="<?php echo home_url('/contact-us'); ?>">Wrong address? Contact Us <span class="fas fa-chevron-right"></span></a>
                  </p>
                  <p class="conf-body-content"><?php echo $shipping_address; ?></p>
                  <p class="conf-body-content text-left show-mobile"><a class="wrong-address responsive" href="<?php echo home_url('/contact-us'); ?>">Wrong address? Contact Us <span class="fas fa-chevron-right"></span></a></p>
                </div>
              </div>
            </div>
          </div>
          <div class="conf-notice">
            <p class="conf-notice-note"><strong>We'll send you a tracking email once your order ships!</strong> You can view your order anytime by logging into your Dashboard. And as always, if you have any questions about your order please <a href="<?php echo home_url('/contact-us'); ?>">contact us.</a></p>
            <div class="conf-notice-action">
              <a href="<?php echo home_url('my-account'); ?>" class="btn-primary btn-action btn-vw">GO TO MY DASHBOARD</a>
            </div>
          </div>
        </div>
    </div>

    <div class="shop-individual">
      <div class="conf-wrap new-confirm-main">
        <div class="new-share2019 mb-0">
          <div class="new-share2019-content">
            <p class="new-share2019-type">FREE GOODIES</p>
            <p class="new-share2019-notice">Get Free Products for You & Your Friends!</p>
            <p class="new-share2019-desc">Invite your friends and they'll get a free lippie or brush and you'll score <?php echo Liveglam_User_Level::get_user_level()=='gold' ? 250 : 200; ?> Reward Points when they join.</p>
            <div class="new-share2019-email">
              <p class="share-free-content-text">Share through Email:</p>
              <?php echo do_shortcode('[send_email_invites product="morpheme"]'); ?>
              <div class="social-icons">
                <p class="share-free-content-text">Or on your social media:</p>
                <?php echo do_shortcode('[social_share product="shadowme"]'); ?>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
</section>
<footer>
  <div class="fourth-footer">
    <div class="container nd19-block-content-xs">
      <div class="row">
        <div class="col-md-4">
          <p class="copyright">© <?php echo date('Y'); ?> LiveGlam, Inc. All rights reserved</p>
        </div>
        <div class="col-md-8">
          <div class="row">
            <div class="col-md-11 offset-md-1">
              <p class="safety">Your Info is safe with us. Secured by Expedited SSL.</p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</footer>
<?php get_footer(); ?>
