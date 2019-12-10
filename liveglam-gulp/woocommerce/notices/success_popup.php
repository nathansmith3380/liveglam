<?php
/**
 * Created by PhpStorm.
 * User: Sy
 * Date: 30/08/17
 * Time: 2:31 PM
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

if ( ! $messages ){
    return;
}

?>
<div class="woocommerce-success-popup mfp-hide">
    <div class='woocommerce-success-header woocommerce-message-header'>
        <img class="img-check" src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/popup-check-black.svg" alt="Image Check"/>
        <h2>Yasss!</h2>
    </div>
    <div class='woocommerce-success-footer woocommerce-message-footer'>
        <?php foreach ( $messages as $message ) : ?>
            <p><?php echo wp_kses_post( $message ); ?></p>
        <?php endforeach; ?>
        <button class='btn btn-close-mfp btn-primary'>OK, GOT IT</button>
    </div>
</div>