<?php
/**
 * Show messages
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/notices/success.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see 	    https://docs.woocommerce.com/document/template-structure/
 * @package 	WooCommerce/Templates
 * @version     3.5.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! $messages ){
	return;
}
$show_dismiss = false;
if(is_account_page() && !is_ajax()){
  $show_dismiss = true;
}
?>

<?php foreach ( $messages as $message ) : ?>
  <?php if($show_dismiss) { ?>
    <div class="alert alert-success alert-dismissible show" role="alert">
      <?php echo wp_kses_post( $message ); ?>
      <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
      </button>
    </div>
<?php } else { ?>
	<div class="woocommerce-message" role="alert"><?php echo wp_kses_post( $message ); ?></div>
<?php } ?>
<?php endforeach; ?>
