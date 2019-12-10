<?php
/**
 * Single variation cart button
 *
 * @see https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates
 * @version 3.4.0
 */

defined( 'ABSPATH' ) || exit;

global $product;
$lgs_pseudo_out_of_stock = LGS_Products::lgs_pseudo_out_of_stock($product->get_id());

if($lgs_pseudo_out_of_stock || ( $product->get_manage_stock() && !$product->is_in_stock()) ){
    if(get_post_meta($product->get_id(),'_show_soldout_instead_outofstock',true) == 'yes'){ ?>
        <p class="stock out-of-stock"><?php esc_html_e( "Sorry babe, we're sold out!", 'woocommerce-subscriptions' ); ?></p>
    <?php } else{ ?>
            <p class="stock out-of-stock"><?php esc_html_e('Out of stock.', 'woocommerce-subscriptions'); ?></p>
    <?php }
} else {


$is_product_coming_soon = LGS_Products::is_product_coming_soon($product->get_id());
if( $is_product_coming_soon['is_coming_soon'] ):
    if( !empty( $is_product_coming_soon['message'] ) ):
        echo "<p class='coming_soon_message txt-pink'>{$is_product_coming_soon['message']}</p>";
    endif;
    else:
?>
<div class="woocommerce-variation-add-to-cart variations_button">
	<?php do_action( 'woocommerce_before_add_to_cart_button' ); ?>

	<?php
	do_action( 'woocommerce_before_add_to_cart_quantity' );

	woocommerce_quantity_input( array(
		'min_value'   => apply_filters( 'woocommerce_quantity_input_min', $product->get_min_purchase_quantity(), $product ),
		'max_value'   => apply_filters( 'woocommerce_quantity_input_max', $product->get_max_purchase_quantity(), $product ),
		'input_value' => isset( $_POST['quantity'] ) ? wc_stock_amount(  wc_clean( wp_unslash(  $_POST['quantity'] ) ) ) : $product->get_min_purchase_quantity(), // WPCS: CSRF ok, input var ok.
	) );

	do_action( 'woocommerce_after_add_to_cart_quantity' );
    $product_in_cart = woo_in_cart($product->get_id());
	?>

    <div class="single-product-action">
            <span class="add-to-cart-action-price single-product <?php echo $product_in_cart?'active':''; ?>">
                <?php
                $class = '';
                $text = 'Add to Bag';
                if($product_in_cart){
                    $class = 'added';
                    $text = 'Added';
                } ?>
                    <button type="button" name="add-to-cart" value="<?php echo esc_attr($product->get_id()); ?>"
                            class="single_add_to_cart_button button alt <?php echo $class; ?> btn-primary"><?php echo esc_html($text); ?></button>
                <?php if ( $price_html = $product->get_price_html() ) : ?>
                    <span class="price"><?php echo $price_html; ?></span>
                <?php endif; ?>
            </span>
    </div>
	<?php do_action( 'woocommerce_after_add_to_cart_button' ); ?>

	<input type="hidden" name="add-to-cart" value="<?php echo absint( $product->get_id() ); ?>" />
	<input type="hidden" name="product_id" value="<?php echo absint( $product->get_id() ); ?>" />
	<input type="hidden" name="variation_id" class="variation_id" value="0" />
</div>
    <?php endif;
}?>
<p class="stock out-of-stock d-none"><?php esc_html_e('Out of stock.', 'woocommerce-subscriptions'); ?></p>