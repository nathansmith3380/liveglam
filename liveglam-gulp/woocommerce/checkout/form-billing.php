<?php
/**
 * Checkout billing information form
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/checkout/form-billing.php.
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
 * @version 3.6.0
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

/** @global WC_Checkout $checkout */

global $checkout_userlogin;

?>

<div class="woocommerce-billing-fields">
    <?php if ( wc_ship_to_billing_address_only() ) : ?>

      <?php if ( WC()->cart->needs_shipping() ) : ?>

      <?php $title = 'Shipping Info'; ?>

      <?php else : ?>

        <?php $title = 'Billing Info'; ?>

      <?php endif; ?>

    <?php else : ?>

      <?php $title = 'Billing Info'; ?>

    <?php endif; ?>

    <?php if( !$checkout_userlogin ) : $num_billing = 2;
      $settings = new LiveGlam_WaitlistSettings();
      $enable = $settings->getEnable('morpheme');
      foreach (WC()->cart->get_cart_contents() as $cart_item_key => $values) {
        $productID = $values['product_id']; break;
      }
    else : $num_billing = 1;
    endif; ?>

    <p class="sub-title"><span><?php echo $num_billing; ?></span><?php echo $title; ?></p>

    <?php do_action( 'woocommerce_before_checkout_billing_form', $checkout ); ?>

  <div class="billing_address">

    <?php
    $fields = $checkout->get_checkout_fields( 'billing' );
    foreach ( $fields as $key => $field ) : ?>

        <?php switch ($key){
            case 'billing_first_name': $field['placeholder'] = 'Your First Name'; break;
            case 'billing_last_name': $field['placeholder'] = 'Your Last Name'; break;
            case 'billing_email': $field['placeholder'] = 'Your Email Address'; break;
            case 'billing_phone': $field['placeholder'] = 'Your Phone Number'; break;
        }?>

        <?php woocommerce_form_field( $key, $field, $checkout->get_value( $key ) ); ?>

    <?php endforeach; ?>

  </div>

    <?php do_action('woocommerce_after_checkout_billing_form', $checkout ); ?>

</div>
