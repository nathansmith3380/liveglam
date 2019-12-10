<?php
  /**
   * Review order table
   *
   * This template can be overridden by copying it to yourtheme/woocommerce/checkout/review-order.php.
   *
   * HOWEVER, on occasion WooCommerce will need to update template files and you
   * (the theme developer) will need to copy the new files to your theme to
   * maintain compatibility. We try to do this as little as possible, but it does
   * happen. When this occurs the version of the template file will be bumped and
   * the readme will list any important changes.
   *
   * @see      https://docs.woocommerce.com/document/template-structure/
   * @author    WooThemes
   * @package  WooCommerce/Templates
   * @version     3.3.0
   */

  if(!defined('ABSPATH')){
    exit;
  }
$lgs_shipping_address_box = apply_filters('lgs_shipping_address_box',false);
?>
<table class="shop_table woocommerce-checkout-review-order-table">
  <tbody>
  <?php $referral_code_checkout = do_shortcode('[referral_code_checkout]');
    $lgs_form_coupon_code = do_shortcode('[lgs_form_coupon_code]');
    if( !empty( $referral_code_checkout ) || !empty( $lgs_form_coupon_code ) ): ?>
    <tr>
      <th colspan="2" class="no-padding">
        <div class="coupon-notice"></div>
        <?php echo $referral_code_checkout; ?>
        <?php echo $lgs_form_coupon_code; ?>
      </th>
    </tr>
  <?php endif; ?>
  <?php
    do_action('woocommerce_review_order_before_cart_contents');

    foreach(WC()->cart->get_cart() as $cart_item_key => $cart_item){
      $_product = apply_filters('woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key);

      if($_product && $_product->exists() && $cart_item['quantity'] > 0 && apply_filters('woocommerce_checkout_cart_item_visible', true, $cart_item, $cart_item_key)){

        $shop_product = $sub_product = false;
        $productID = $cart_item['product_id'];
        if(in_array($productID, lgs_product_mm) || in_array($productID, lgs_product_km) || in_array($productID, lgs_product_sm)){
          $sub_product = true;
        }elseif(!isset($cart_item['redeem_rewards']) && $productID != BUY_POINT_ID){
          $shop_product = true;
        }
        ?>
        <tr class="<?php echo esc_attr(apply_filters('woocommerce_cart_item_class', 'cart_item', $cart_item, $cart_item_key)); ?>">
          <td class="product-name <?php echo $shop_product?'shop-product':''; ?>">

            <?php if($shop_product){
                ?>
            <div class="product-reviews">
              <div class="product-review-image">
                <?php echo $_product->get_image('medium'); ?>
              </div>
              <div class="product-name-title">
                <div class="title-content">
                  <p>
                    <?php }elseif($sub_product && false){
                      if(in_array($productID, lgs_product_mm)){ ?>
                        <img class="sub-image" src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/LiveGlam_MorpheMe_Logo.png" alt="MM"/>
                      <?php }elseif(in_array($productID, lgs_product_km)){ ?>
                        <img class="sub-image" src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/logo_kissme.svg" alt="KM"/>
                      <?php }elseif(in_array($productID, lgs_product_sm)){ ?>
                        <img class="sub-image" src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/logo_shadowme_home4.svg" alt="SM"/>
                      <?php }
                    } ?>

                    <?php if($sub_product): echo "<span>"; endif; ?>
                    <?php echo apply_filters('woocommerce_cart_item_name', $_product->get_title(), $cart_item, $cart_item_key).'&nbsp;'; ?>
                    <?php if($sub_product): echo "</span>";  endif; ?>
                    <?php echo apply_filters('woocommerce_checkout_cart_item_quantity', ' <span class="product-quantity">'.sprintf('&times; %s', $cart_item['quantity']).'</span>', $cart_item, $cart_item_key); ?>

                    <?php if($shop_product){ ?>
                  </p>
                    <?php
                    if($_product->get_type() == 'variation'){
                        ?>
                        <p class="lgs-variation-attribute">
                            <?php
                            echo ucfirst(implode(' - ',$_product->get_attributes()));
                            ?>
                        </p>
                        <?php
                    }
                    ?>
                </div>
              </div>
            </div>
          <?php } ?>
          </td>
          <td class="product-total <?php echo $shop_product?'shop-product':''; ?>">
            <?php echo apply_filters('woocommerce_cart_item_subtotal', WC()->cart->get_product_subtotal($_product, $cart_item['quantity']), $cart_item, $cart_item_key); ?>
          </td>
        </tr>
        <?php
      }
    }

    do_action('woocommerce_review_order_after_cart_contents');
  ?>
  </tbody>
  <tfoot>

  <tr class="cart-subtotal">
    <th><?php _e('Subtotal', 'woocommerce'); ?></th>
    <td><?php wc_cart_totals_subtotal_html(); ?></td>
  </tr>

  <?php if(WC()->cart->get_totals()['discount_total'] > 0): ?>
    <?php foreach(WC()->cart->get_coupons() as $code => $coupon) : ?>
      <tr class="cart-discount coupon-<?php echo esc_attr(sanitize_title($code)); ?>">
        <th><?php wc_cart_totals_coupon_label($coupon); ?></th>
        <td><?php wc_cart_totals_coupon_html($coupon); ?></td>
      </tr>
    <?php endforeach; ?>
  <?php endif; ?>

  <?php if(WC()->cart->needs_shipping() && WC()->cart->show_shipping()) : ?>

    <?php do_action('woocommerce_review_order_before_shipping'); ?>

    <?php wc_cart_totals_shipping_html(); ?>

    <?php do_action('woocommerce_review_order_after_shipping'); ?>

  <?php endif; ?>

  <?php foreach(WC()->cart->get_fees() as $fee) : ?>
    <tr class="fee">
      <th><?php echo esc_html($fee->name); ?></th>
      <td><?php wc_cart_totals_fee_html($fee); ?></td>
    </tr>
  <?php endforeach; ?>

  <?php if(wc_tax_enabled() && 'excl' === WC()->cart->tax_display_cart) : ?>
    <?php if('itemized' === get_option('woocommerce_tax_total_display')) : ?>
      <?php foreach(WC()->cart->get_tax_totals() as $code => $tax) : ?>
        <tr class="tax-rate tax-rate-<?php echo sanitize_title($code); ?>">
          <th><?php echo esc_html($tax->label); ?></th>
          <td><?php echo wp_kses_post($tax->formatted_amount); ?></td>
        </tr>
      <?php endforeach; ?>
    <?php else : ?>
      <tr class="tax-total lg_show_tax">
        <th><?php echo esc_html(WC()->countries->tax_or_vat()); ?></th>
        <td><?php wc_cart_totals_taxes_total_html(); ?></td>
      </tr>
    <?php endif; ?>
  <?php endif; ?>

  <?php do_action('woocommerce_review_order_before_order_total'); ?>

  <tr class="order-total">
    <th><?php _e('Total', 'woocommerce'); ?></th>
    <td><?php wc_cart_totals_order_total_html(); ?></td>
  </tr>

  <?php do_action('woocommerce_review_order_after_order_total'); ?>

  </tfoot>
</table>
