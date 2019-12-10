<?php
  /**
   * Checkout shipping information form
   *
   * This template can be overridden by copying it to yourtheme/woocommerce/checkout/form-shipping.php.
   *
   * HOWEVER, on occasion WooCommerce will need to update template files and you
   * (the theme developer) will need to copy the new files to your theme to
   * maintain compatibility. We try to do this as little as possible, but it does
   * happen. When this occurs the version of the template file will be bumped and
   * the readme will list any important changes.
   *
   * @see     https://docs.woocommerce.com/document/template-structure/
   * @author  WooThemes
   * @package WooCommerce/Templates
   * @version 3.0.9
   */

  if(!defined('ABSPATH')){
    exit; // Exit if accessed directly
  }
  global $checkout_userlogin;
?>
<div class="woocommerce-billing-extend-fields">
  <?php if(wc_ship_to_billing_address_only() && WC()->cart->needs_shipping()) : ?>

    <div class="use-billing-extend">
      <div class="form-check float-left" id="use-billing-extend">
        <label for="use_lgs_extend" class="checkbox form-check-label">
          <input id="use_lgs_extend" class="input-checkbox form-check-input" <?php checked(apply_filters('liveglam_use_lgs_extend', 0), 1); ?> type="checkbox" name="use_lgs_extend" value="1"/>
          Use a different billing address
        </label>
      </div>
    </div>

    <div class="clear"></div>

    <div class="lgs_extend_address">

      <?php if(!$checkout_userlogin) : $num_shipping = 3;
        $settings = new LiveGlam_WaitlistSettings();
        $enable = $settings->getEnable('morpheme');
        foreach(WC()->cart->get_cart_contents() as $cart_item_key => $values){
          $productID = $values['product_id'];
          break;
        }
      else : $num_shipping = 2;
      endif; ?>

      <p class="sub-title">Billing Info</p>

      <?php do_action('woocommerce_before_checkout_lgs_extend_form', $checkout); ?>

      <?php $checkout = new WC_Checkout(); ?>

      <?php $fields = $checkout->get_checkout_fields('lgs_extend');

        foreach($fields as $key => $field) :

          woocommerce_form_field($key, $field, $checkout->get_value($key));

        endforeach; ?>

      <?php do_action('woocommerce_after_checkout_lgs_extend_form', $checkout); ?>

    </div>

  <?php endif; ?>

</div>
