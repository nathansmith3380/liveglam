<?php
/**
 * Edit address form
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/myaccount/form-edit-address.php.
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
 * @version 2.6.0
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

$title = ( $load_address === 'billing' ) ? __( 'Billing', 'woocommerce' ) : __( 'Shipping', 'woocommerce' );
do_action( 'woocommerce_before_edit_account_address_form' ); ?>

<?php if( $load_address == 'shipping'): ?>
    <p class="wc_shipping_desc">You must update your shipping address at least 24 hours before your next shipment date. Has your package already shipped or is shipping within less than 24 hours to the wrong address? <a href="<?php echo home_url('/contact-us/'); ?>">Contact us</a> and we'll help you out right away!</p>
<?php endif; ?>

<?php if ( ! $load_address ) : ?>
    <?php wc_get_template( 'myaccount/my-address.php' ); ?>
<?php else : ?>

    <form method="post">

        <?php do_action( "woocommerce_before_edit_address_form_{$load_address}" ); ?>

        <?php foreach ( $address as $key => $field ) :?>

            <?php echo woocommerce_form_field( $key, $field, ! empty( $_POST[ $key ] ) ? wc_clean( $_POST[ $key ] ) : $field['value'] ); ?>

        <?php endforeach; ?>

      <div class="address-book-action">
        <p class="btn-submit-profile">
          <input type="hidden" name="<?php echo $load_address; ?>_address-book-edit" id="<?php echo $load_address; ?>_address-book-edit" value=""/>
          <button type="button" class="button address_book_save lg-edit-button-profile btn-primary" data-type="<?php echo $load_address; ?>">Add New Shipping Address</button>
          <button type="button" class="button address_book_reset lg-edit-button-profile btn-secondary" data-type="<?php echo $load_address; ?>">Cancel</button>
        </p>
      </div>

      <div class="subscription-action">

        <p class="<?php echo $load_address; ?>_all_subscriptions_filed update-all-subscriptions">
            <input id="<?php echo $load_address; ?>_all_subscriptions" class="<?php echo $load_address; ?>_all_subscriptions" type="checkbox">
            <label for="<?php echo $load_address; ?>_all_subscriptions">Update All Subscriptions</label>
        </p>


        <p class="btn-submit-profile">
            <button type="submit" class="button save_address lg-edit-button-profile btn-primary <?php echo $load_address; ?>" data-type="<?php echo $load_address; ?>" data-product="">Save My <?php echo $title; ?> Details</button>
        </p>

      </div>

    </form>

<?php endif; ?>

<?php do_action( 'woocommerce_after_edit_account_address_form' ); ?>
