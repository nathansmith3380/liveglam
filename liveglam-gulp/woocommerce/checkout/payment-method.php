<?php
/**
 * Output a single payment method
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/checkout/payment-method.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see 	    https://docs.woocommerce.com/document/template-structure/
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     3.5.0
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}
$lgs_shipping_address_box = apply_filters('lgs_shipping_address_box',false);
?>
<li class="wc_payment_method payment_method_<?php echo $gateway->id; ?>">
    <input id="payment_method_<?php echo $gateway->id; ?>" type="radio" class="input-radio" name="payment_method" value="<?php echo esc_attr( $gateway->id ); ?>" <?php if( WC()->session->get( 'chosen_payment_method' ) == $gateway->id) { echo 'checked="checked"'; } //checked( $gateway->chosen, true ); ?> data-order_button_text="<?php echo esc_attr( $gateway->order_button_text ); ?>" />

  <?php if( isset($show_price) && $show_price ){ ?>
    <label for="payment_method_<?php echo $gateway->id; ?>">
      <?php if( $gateway->id == 'stripe'){
          echo "Pay using debit/credit card";
          echo ' - <strong class="gateway_price">'.sprintf(get_woocommerce_price_format(),get_woocommerce_currency_symbol(),number_format( $price_stripe, wc_get_price_decimals(), wc_get_price_decimal_separator(), wc_get_price_thousand_separator() ) ).'</strong>';
      } elseif( $gateway->id == 'reward_gateway'){
          echo "Pay using reward points";
          if( $price_reward == 0 ){
              echo ' - <strong class="gateway_price">Free Shipping</strong>';
          } else {
              echo ' - <strong class="gateway_price">'.$price_reward.' Points</strong>';
          }
      } ?>
    </label>
  <?php } ?>

    <?php if ( $gateway->has_fields() || $gateway->get_description() ) : ?>
        <?php if ($gateway->id == 'stripe'):?>
                <!--<div class="card-wrapper"></div>-->
        <?php endif;?>
        <div class="payment_box payment_method_<?php echo $gateway->id; ?> <?php if ( !WC()->session->get( 'chosen_payment_method' ) == $gateway->id ) : echo 'd-none'; endif; ?>">
            <?php $gateway->payment_fields(); ?>
        </div>
    <?php endif; ?>
</li>

<script>
    jQuery(document).ready(function () {

        <?php if($lgs_shipping_address_box){?>
            function liveglam_woogoogad_autoremplissageGoogleAddress(type) {
                var shipping_address = '';
                if(typeof wc_address_i18n_params !== 'undefined')
                    var woogoogad_locale_json = wc_address_i18n_params.locale.replace( /&quot;/g, '"' );
                else
                    var woogoogad_locale_json = woocommerce_params.locale.replace( /&quot;/g, '"' );

                var woogoogad_locale = jQuery.parseJSON( woogoogad_locale_json );

                country_val = jQuery('#'+type+'_country').val();

                if ( typeof woogoogad_locale[ country_val ] !== 'undefined' ) {
                    thislocale = woogoogad_locale[ country_val ];
                } else {
                    thislocale = woogoogad_locale['default'];
                }

                var has_state = false;

                if((typeof thislocale !== 'undefined') && (typeof thislocale.state !== 'undefined') && thislocale.state.label)
                    has_state = true;
                address1 = jQuery('#'+type+'_address_1').val();
                if(address1 == undefined)
                    address1 = '';
                address2 = jQuery('#'+type+'_address_2').val();
                if(address2 == undefined)
                    address2 = '';
                cp = jQuery('#'+type+'_postcode').val();
                if(cp == undefined)
                    cp = '';
                city = jQuery('#'+type+'_city').val();
                if(city == undefined)
                    city = '';

                if(has_state)
                    state = jQuery('#'+type+'_state').val();
                else
                    state = '';
                country = jQuery('#'+type+'_country').val();

                if(jQuery('#'+type+'_state').prop("tagName") == 'SELECT')
                {
                    if(state!='')
                        state = jQuery('#'+type+'_state option:selected').text();
                }

                if(jQuery('#'+type+'_country').prop("tagName") == 'SELECT')
                {
                    if(country!='')
                        country = jQuery('#'+type+'_country option:selected').text();
                }
                else
                {
                    country = jQuery('#'+type+'_country').prev('strong').text();
                }

                shipping_address = address1 != '' && address1 != undefined ?shipping_address+'<p>'+address1+'</p>':shipping_address+'';
                shipping_address = address2 != '' && address2 != undefined ?shipping_address+'<p>'+address2+'</p>':shipping_address+'';
                shipping_address = city != '' && city != undefined ?shipping_address+'<p>'+city+' '+cp+'</p>':shipping_address+'';
                shipping_address = state != '' && state != undefined ?shipping_address+'<p>'+state+'</p>':shipping_address+'';
                shipping_address = country != '' && country != undefined ?shipping_address+'<p>'+country+'</p>':shipping_address+'';


                if(jQuery('.lg_shipping_address_box_btm').html() != '' && jQuery('.lg_shipping_address_box_btm').html() != undefined){
                    if(shipping_address != ''){
                        jQuery('.lg_shipping_details').html(shipping_address);
                    }
                }
            }
            liveglam_woogoogad_autoremplissageGoogleAddress('billing');
        <?php }?>

        <?php if(empty($_COOKIE['lg_checkout_script'])){?>
        <?php if(is_user_logged_in()){?>
        jQuery('#billing_phone').blur();
        <?php }?>
        checkout_validate();
        <?php }?>
        if(jQuery('.stripe_new_card').css('display') == 'none'){
            jQuery('.card-wrapper').addClass('d-none');
        } else {
            jQuery('.card-wrapper').removeClass('d-none');
        }
        jQuery('body').on('change','.payment_box input[type=radio]',function () {
            var data = jQuery(this).val();
            if(data=='new' && !jQuery('.payment_box.payment_method_stripe').hasClass('d-none')){
                jQuery('.card-wrapper').removeClass('d-none');
            } else {
                jQuery('.card-wrapper').addClass('d-none');
            }
                jQuery('.iradio_flat-green.checked').removeClass('checked');
            jQuery('label[for="wc-stripe-payment-token-'+data+'"]').parent().find('.iradio_flat-green').addClass('checked');
        });
        jQuery('body').on( 'change', 'input[name="payment_method"]', function () {
            jQuery( '#billing_country, #shipping_country, .country_to_state' ).change();
            jQuery(document.body).trigger('update_checkout');
            jQuery('.select2-input').change();
        });

        jQuery('input.woocommerce-SavedPaymentMethods-tokenInput').iCheck({
            radioClass: 'iradio_flat-green'
        });
    });

    jQuery('input.woocommerce-SavedPaymentMethods-tokenInput').on('ifChanged', function (ev) {
        jQuery(ev.target).change();
    });
</script>

<?php if( isset($show_price) && $show_price) : ?>
    <script>
        jQuery(document).ready(function(){
            jQuery('input[name="payment_method"]').iCheck({
                radioClass: 'icheckbox_flat-green'
            });

            if( jQuery('.payment_method_stripe .icheckbox_flat-green').hasClass('checked') ){
                jQuery('.payment_box.payment_method_stripe').removeClass('d-none');
            } else {
                jQuery('.payment_box.payment_method_stripe').addClass('d-none');
            }

            if( jQuery('.payment_box.payment_method_stripe').hasClass('d-none') ){
                jQuery('.card-wrapper').addClass('d-none');
            } else {
                jQuery('.card-wrapper').removeClass('d-none');
            }

        });

        jQuery('input[name="payment_method"]').on('ifChanged', function (ev) {
            jQuery(ev.target).change();
            var gateway = jQuery(ev.target).val();
            if( gateway == 'stripe' ){
                jQuery('.payment_box.payment_method_stripe').removeClass('d-none');
            } else {
                jQuery('.payment_box.payment_method_stripe').addClass('d-none');
            }
        });




    </script>
<?php endif; ?>