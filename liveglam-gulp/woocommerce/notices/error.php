<?php
/**
 * Show error messages
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/notices/error.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see 	    https://docs.woocommerce.com/document/template-structure/
 * @package 	WooCommerce/Templates
 * @version     3.6.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! $messages ){
	return;
}
if(is_checkout()){

  if( WC()->cart->check_cart_item_stock() !== true ){
    $popup_show = '.woocommerce-error-popup.error-popup-checkout2';
  } else {
    $popup_show = '.woocommerce-error-popup.error-popup-checkout';
  }

	?>
	<script>
    var message = '<?php foreach ( $messages as $message ) : ?><p><?php echo wp_kses_post( $message ); ?></p><?php endforeach; ?>';
    var popup_show = '<?php echo $popup_show; ?>';
    jQuery(popup_show+' .error-message').html(message);
		jQuery.magnificPopup.open({
			items:{src:popup_show},
			type:"inline",
			closeOnContentClick: false,
			closeOnBgClick: false,
			showCloseBtn: false});
	</script>
	<?php
}else{
  //#1629: remove message error from dashboard page
  foreach($messages as $key => $message){
    if(is_account_page() ){
      if(strpos($message, "has been removed from your cart") !== false
      || strpos($message, "Sorry, this product cannot be purchased.") !== false){
        unset($messages[$key]);
      }
    }
  }
  if(empty($messages)) return; ?>
	<div class="woocommerce-error" role="alert">
		<?php foreach ( $messages as $message ) : ?>
			<li><?php echo wp_kses_post( $message ); ?></li>
		<?php endforeach; ?>
	</div>
	<?php
}


