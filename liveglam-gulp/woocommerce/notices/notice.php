<?php
/**
 * Show messages
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/notices/notice.php.
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
	exit; // Exit if accessed directly
}

if ( ! $messages ){
	return;
}

  //#1629: remove message notice from dashboard page
  foreach($messages as $key => $message){
    if( is_account_page() ){
      if( strpos($message, "Woops! Looks like you're already a member of this club. Log in to access your Dashboard and manage your subscription settings!") !== false ){
        unset($messages[$key]);
      }
    }
  }
  if(empty($messages)) return;
?>

<?php foreach ( $messages as $message ) : ?>
	<div class="woocommerce-info"><?php echo wp_kses_post( $message ); ?></div>
<?php endforeach; ?>
