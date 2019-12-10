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
 * @version 3.6.0
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}
global $checkout_userlogin;
?>
<div class="woocommerce-shipping-fields">
    <?php if ( true === WC()->cart->needs_shipping_address() ) : ?>

        <div class="ship-to-address">
            <div class="form-check float-left" id="ship-to-different-address">
                <label for="ship-to-different-address-checkbox" class="checkbox form-check-label">
                    <input  id="ship-to-different-address-checkbox" class="input-checkbox form-check-input" <?php checked( apply_filters( 'woocommerce_ship_to_different_address_checked', 'shipping' === get_option( 'woocommerce_ship_to_destination' ) ? 1 : 0 ), 1 ); ?> type="checkbox" name="ship_to_different_address" value="1" />
                    <?php _e( apply_filters( 'trs_ship_to_a_different_address', 'Ship to a different address?' ), 'woocommerce' ); ?>
                </label>
            </div>
        </div>

        <div class="shipping_address">

            <?php if( !$checkout_userlogin ) : $num_shipping = 3;
                $settings = new LiveGlam_WaitlistSettings();
                $enable = $settings->getEnable('morpheme');
                foreach (WC()->cart->get_cart_contents() as $cart_item_key => $values) {
                    $productID = $values['product_id']; break;
                }
            else : $num_shipping = 2;
            endif; ?>

            <p class="sub-title"><span><?php echo $num_shipping; ?></span>Shipping Info</p>

            <?php do_action( 'woocommerce_before_checkout_shipping_form', $checkout ); ?>

            <?php $fields = $checkout->get_checkout_fields( 'shipping' );

            foreach ( $fields as $key => $field ) : ?>

                <?php switch ($key){
                    case 'shipping_first_name': $field['placeholder'] = 'Your First Name'; break;
                    case 'shipping_last_name': $field['placeholder'] = 'Your Last Name'; break;
                }?>

                <?php woocommerce_form_field( $key, $field, $checkout->get_value( $key ) ); ?>

            <?php endforeach; ?>

            <?php do_action( 'woocommerce_after_checkout_shipping_form', $checkout ); ?>

        </div>

    <?php endif; ?>

    <?php do_action( 'woocommerce_before_order_notes', $checkout ); ?>

    <?php if ( apply_filters( 'woocommerce_enable_order_notes_field', get_option( 'woocommerce_enable_order_comments', 'yes' ) === 'yes' ) ) : ?>

        <?php foreach ( $checkout->checkout_fields['order'] as $key => $field ) : ?>

            <?php woocommerce_form_field( $key, $field, $checkout->get_value( $key ) ); ?>

        <?php endforeach; ?>

    <?php endif; ?>

    <?php do_action( 'woocommerce_after_order_notes', $checkout ); ?>
</div>
