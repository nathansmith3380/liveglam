<?php
/**
 * Checkout Payment Section
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/checkout/payment.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see 	    https://docs.woocommerce.com/document/template-structure/
 * @package 	WooCommerce/Templates
 * @version 3.5.3
 */
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}


if ( ! is_ajax() ) {
    do_action( 'woocommerce_review_order_before_payment' );
}
?>
    <div id="payment" class="woocommerce-checkout-payment">

        <?php if ( WC()->cart->needs_payment() ) : ?>
          <ul class="wc_payment_methods payment_methods methods">
            <?php
                if ( ! empty( $available_gateways ) ) {
                    $show_price = false; $price_stripe = $price_reward = 0;
                    if( class_exists('Liveglam_Reward_Shipping') ):
                        $product_id = Liveglam_Reward_Shipping::is_reward_product();
                        if( $product_id ){
                            $package = WC()->cart->get_shipping_packages();
                            $package = reset( $package );
                            $country = $package["destination"]["country"];
                            $key_usl = Liveglam_Reward_Shipping::key_user_level();
                            WC()->cart->calculate_shipping();
                            $Liveglam_Reward_Shipping = new Liveglam_Reward_Shipping();
                            $Liveglam_Reward_Shipping->calculate_shipping($package);
                            if( in_array($country, $Liveglam_Reward_Shipping->array_country ) ){
                                $type_stripe = $key_usl.'pid';
                                $type_reward = $key_usl.'pod';
                            } else {
                                $type_stripe = $key_usl.'pii';
                                $type_reward = $key_usl.'poi';
                            }

                            $price_stripe = lrs_get_price_shipping( $product_id, $type_stripe );
                            $price_reward = lrs_get_price_shipping( $product_id, $type_reward );
                            if (!empty($price_reward) || !empty($price_stripe) ) $show_price = true;
                            foreach ( WC()->cart->get_cart() as $key => $item   ) {
                                if (isset($item['free_shipping'])) $show_price = false;
                            }
                            WC_Shortcode_Cart::calculate_shipping();
                        }
                    endif;
                    foreach ( $available_gateways as $gateway ) {
                        wc_get_template( 'checkout/payment-method.php', array( 'gateway' => $gateway, 'show_price' => $show_price, 'price_stripe' => $price_stripe, 'price_reward' => $price_reward ) );
                    }
                } else {
					echo '<li>' . apply_filters( 'woocommerce_no_available_payment_methods_message', WC()->customer->get_billing_country() ? __( 'Sorry, it seems that there are no available payment methods for your state. Please contact us if you require assistance or wish to make alternate arrangements.', 'woocommerce' ) : __( 'Please fill in your details above to see available payment methods.', 'woocommerce' ) ) . '</li>';
                }
                ?>
            </ul>
        <?php endif; ?>

        <?php if ( ! empty( $optin_label = get_option( 'wc_twilio_sms_checkout_optin_checkbox_label', '' ) ) ){
            if( is_ajax() && strpos($_POST['post_data'], 'wc_twilio_sms_optin') !== false ){
              $value_sms_optin = 1;
            }else{
              $value_sms_optin = ('checked' === get_option('wc_twilio_sms_checkout_optin_checkbox_default', 'unchecked'))?1:0;
              if(!empty($country_consent = get_option('options_country_show_cookie_consent'))){
                if(in_array(WC_Geolocation::geolocate_ip()['country'],$country_consent)){
                  $value_sms_optin = 0;
                }
              }
            } ?>
          <div class="twilio_sms_option">
            <input type="checkbox" class="input-checkbox" name="wc_twilio_sms_optin" id="wc_twilio_sms_optin" value="1" <?php echo checked( $value_sms_optin, 1, false ); ?> />
            <label for="wc_twilio_sms_optin1">
              <?php echo $optin_label; ?>&nbsp;<button type="button" class="fal-info" data-toggle="tooltip" data-html="true" data-placement="top" title="I want to be updated with text messages (SMS and MMS) from LiveGlam. I consent to these texts being sent via autodialer to the mobile number I provided. I understand consent is not a condition of purchase, msg & data rates may apply and I can reply 'STOP' to any LiveGlam text to stop receiving them. I also acknowledge and agree to the <a href='<?php echo home_url('/terms-conditions'); ?>'>Terms & Conditions</a> and <a href='<?php echo home_url('/privacy-policy'); ?>'>Privacy Policy</a>.">i</button>
            </label>
          </div>
        <?php } ?>

        <div class="pay-action">

            <div class="checkout-action-payment">

                <noscript>
                    <?php _e( 'Since your browser does not support JavaScript, or it is disabled, please ensure you click the <em>Update Totals</em> button before placing your order. You may be charged more than the amount stated above if you fail to do so.', 'woocommerce' ); ?>
                    <br/><input type="submit" class="button alt" name="woocommerce_checkout_update_totals" value="<?php esc_attr_e( 'Update totals', 'woocommerce' ); ?>" />
                </noscript>

                <?php do_action( 'woocommerce_review_order_before_submit' ); ?>

                <?php //echo apply_filters( 'woocommerce_order_button_html', '<input type="submit" class="button alt btn-pay" name="woocommerce_checkout_place_order" id="place_order" value="' . esc_attr( $order_button_text ) . '" data-value="' . esc_attr( $order_button_text ) . '" />' ); ?>
              <button class="btn btn-pay btn-primary btn-block"><span>Pay Securely</span></button>
                <button class="place_order" id="place_order" style="display: none"></button>

                <?php wc_get_template( 'checkout/terms.php' ); ?>

                <?php do_action( 'woocommerce_review_order_after_submit' ); ?>

                <?php wp_nonce_field( 'woocommerce-process_checkout' ); ?>

            </div>
        </div>

      <div class="pay-secure">
        <p class="txt-sm pay-secure-title">Secure Card Payment</p>
        <p class="txt-xs"><?php echo wp_kses_post( wc_replace_policy_page_link_placeholders( wc_get_privacy_policy_text( 'checkout' ) ) ); ?></p>
      </div>

    </div>
  <script type="text/javascript">
    jQuery(document).ready(function(jQuery){
      jQuery('[data-toggle="tooltip"]').tooltip();

      jQuery('input[name="wc_twilio_sms_optin"]').iCheck({
        checkboxClass: 'icheckbox_square-pink'
      });
    });

  </script>
<?php
if ( ! is_ajax() ) {
    do_action( 'woocommerce_review_order_after_payment' );
}