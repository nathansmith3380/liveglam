<?php
/**
 * Checkout terms and conditions area.
 *
 * @package 	WooCommerce/Templates
 * @version 3.4.0
 */
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}
if ( wc_get_page_id( 'terms' ) > 0 && apply_filters( 'woocommerce_checkout_show_terms', true ) ) : ?>
    <?php do_action( 'woocommerce_checkout_before_terms_and_conditions' ); ?>
    <p class="txt-sm text-center lg_vadilate_pay_text hide-mobile txt-red"><?php printf( __( 'Please complete all fields in checkout to proceed to pay.' ) ); ?></p>
    <p class="txt-sm text-center hide-mobile lg_vadilate_text">
        <input type="checkbox" class="input-checkbox" name="terms" checked="checked" <?php //checked( apply_filters( 'woocommerce_terms_is_checked_default', isset( $_POST['terms'] ) ), true ); ?> id="terms" />
        <!--<label for="termss" class="checkbox"><?php /*printf( __( 'I&rsquo;ve read and accept the <a href="%s" target="_blank">terms &amp; conditions</a>', 'woocommerce' ), esc_url( wc_get_page_permalink( 'terms' ) ) ); */?> <span class="required">*</span></label>-->
        <?php printf( __( 'By clicking “%s“ I agree to LiveGlam&rsquo;s <a href="%s" target="_blank">Terms of Service.</a>', 'woocommerce' ), isset($text_pay_button)?$text_pay_button:'Pay Securely', esc_url( wc_get_page_permalink( 'terms' ) ) ); ?>
        <input type="hidden" name="terms-field" value="1" />
    </p>
    <?php do_action( 'woocommerce_checkout_after_terms_and_conditions' ); ?>
<?php endif; ?>
