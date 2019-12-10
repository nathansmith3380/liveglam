<?php
/**
 * Simple product add to cart
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/add-to-cart/simple.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see 	    https://docs.woocommerce.com/document/template-structure/
 * @package 	WooCommerce/Templates
 * @version 3.4.0
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

global $product, $is_shop_member, $lgs_pseudo_out_of_stock, $is_in_stock;
  $productID = $product->get_id();
if ( ! $product->is_purchasable() ) {
	?>
	<p class="stock out-of-stock"><?php esc_html_e( 'This product is currently out of stock and unavailable.', 'woocommerce-subscriptions' ); ?></p>
	<?php
	return;
}
if($lgs_pseudo_out_of_stock || !$is_in_stock){
  if( !LGS_Products_Stock_Notifier::lgs_psn_enable($productID) ):
    if(get_post_meta($productID,'_show_soldout_instead_outofstock',true) == 'yes'){ ?>
      <p class="stock out-of-stock"><?php esc_html_e( "Sorry babe, we're sold out!", 'woocommerce-subscriptions' ); ?></p>
    <?php } else{ ?>
      <p class="stock out-of-stock"><?php esc_html_e('Out of stock.', 'woocommerce-subscriptions'); ?></p>
    <?php } ?>
  <?php else: ?>
    <div class="popup-send-stock-notifier">
      <div class="stock-notifier-form">
        <p class="stock-notifier-notice">Enter your email address and be the first to know when this product is ready to be slayed!</p>
        <div class="stock-notifier-data">
          <label for="stock-notifier-email" class="d-none">&nbsp;</label>
          <input type="text" class="stock-notifier-email" id="stock-notifier-email" value="" placeholder="name@email.com">
          <label for="stock-notifier-productID" class="d-none">&nbsp;</label>
          <input type="hidden" class="btn stock-notifier-productID" id="stock-notifier-productID" value="<?php echo $productID; ?>">
          <label for="stock-notifier-productNAME" class="d-none">&nbsp;</label>
          <input type="hidden" class="btn stock-notifier-productNAME" id="stock-notifier-productNAME" value="<?php echo get_the_title(); ?>">
          <button class="btn btn-stock-notifier stock-notifier-submit"><img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/arrow-right.svg" alt="Arrow right"></button>
        </div>
        <div class="stock-notifier-error"></div>
      </div>
      <div class="stock-notifier-message" style="display: none;">
        <svg class="option-selected" width="133px" height="133px" viewBox="0 0 133 133" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
          <g class="check-group" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
            <circle class="ck-filled-circle" fill="#059DAF" cx="66.5" cy="66.5" r="54.5"></circle>
            <circle class="ck-white-circle" fill="#FFFFFF" cx="66.5" cy="66.5" r="55.5"></circle>
            <circle class="ck-outline" stroke="#059DAF" stroke-width="4" cx="66.5" cy="66.5" r="54.5"></circle>
            <polyline class="ck-check" stroke="#FFFFFF" stroke-width="10" points="41 70 56 85 92 49"></polyline>
          </g>
        </svg>
        <p class="stock-notifier-success">You've successfully submitted your email address. We'll be in touch soon, gorgeous!</p>
      </div>
    </div>
  <?php endif;
}elseif( $product->get_stock_quantity() <= 10 ) {
    echo wc_get_stock_html($product);
}

$compare_price = LGS_Products::lgs_get_compare_price($product, $is_shop_member);

$is_product_coming_soon = LGS_Products::is_product_coming_soon($productID);
if( $is_product_coming_soon['is_coming_soon'] ):
  if( !empty( $is_product_coming_soon['message'] ) ):
    echo "<p class='coming_soon_message txt-pink'>{$is_product_coming_soon['message']}</p>";
  endif;
elseif ( $is_in_stock && !$lgs_pseudo_out_of_stock ) : ?>

	<?php do_action( 'woocommerce_before_add_to_cart_form' ); ?>

  <div class="product-sotp">
    <p class="product-sotp-title">
      <?php $member_price = LGS_Products::lgs_get_product_price($product, true);
        $nonmember_price = LGS_Products::lgs_get_product_price($product, false);
        if($member_price != $nonmember_price && !empty($member_price) && !empty($nonmember_price)){
          echo $is_shop_member?'MEMBER SHOP PURCHASE':'NON MEMBER SHOP PURCHASE';
        } else {
          echo 'SHOP PURCHASE';
        } ?>
    </p>
    <p class="product-sotp-desc hide-mobile">
      <?php echo $product->get_price_html(); ?>
      <?php if(!empty($compare_price)): ?>
          <span class="compare-price"><?php echo wc_price($compare_price); ?></span>
      <?php endif; ?>
    </p>
  </div>

	<form class="cart">
		<?php
			/**
			 * @since 2.1.0.
			 */
			do_action( 'woocommerce_before_add_to_cart_button' );

			/**
			 * @since 3.0.0.
			 */
			do_action( 'woocommerce_before_add_to_cart_quantity' );
            $max_quantity = LGS_Products::lgs_custom_max_quantity_product($product);
            if( $max_quantity !== -1 ){
                $max_quantity = max(1,$max_quantity);
            }
			woocommerce_quantity_input( array(
				'min_value'   => apply_filters( 'woocommerce_quantity_input_min', $product->get_min_purchase_quantity(), $product ),
				'max_value'   => apply_filters( 'woocommerce_quantity_input_max', $max_quantity, $product ),
				'input_value' => isset( $_POST['quantity'] ) ? wc_stock_amount(  wc_clean( wp_unslash( $_POST['quantity'] ) ) ) : $product->get_min_purchase_quantity(),
			) );

			/**
			 * @since 3.0.0.
			 */
			do_action( 'woocommerce_after_add_to_cart_quantity' );
			$product_in_cart = woo_in_cart($productID);
		?>

    <p class="product-sotp-desc show-mobile <?php echo ($max_quantity==1)?'single-action':'multi-action'; ?>">
      <?php echo $product->get_price_html(); ?>
      <?php if ($compare_price) : ?>
          <span class="compare-price"><?php echo wc_price($compare_price); ?></span>
      <?php endif; ?>
    </p>

        <div class="single-product-action <?php echo ($max_quantity==1)?'single-action':'multi-action'; ?>">
            <span class="add-to-cart-action-price single-product <?php echo $product_in_cart?'active':''; ?>">
                <?php
                $class = '';
                $text = 'Add to Bag';
                if($product_in_cart){
                    $class = 'added';
                    $text = 'Added';
                } ?>
		        <button type="button" name="add-to-cart" value="<?php echo esc_attr( $productID ); ?>" class="single_add_to_cart_button button alt <?php echo $class; ?> btn-primary btn-block"><?php echo esc_html( $text ); ?></button>
            </span>
          <p class="product-sotp-subtitle">Shipping & taxes calculated at checkout.</p>
        </div>

		<?php
			/**
			 * @since 2.1.0.
			 */
			do_action( 'woocommerce_after_add_to_cart_button' );
		?>
	</form>

	<?php do_action( 'woocommerce_after_add_to_cart_form' ); ?>

<?php endif; ?>
