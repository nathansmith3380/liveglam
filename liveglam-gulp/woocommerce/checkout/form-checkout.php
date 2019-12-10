<?php
  /**
   * Checkout Form
   *
   * This template can be overridden by copying it to yourtheme/woocommerce/checkout/form-checkout.php.
   *
   * HOWEVER, on occasion WooCommerce will need to update template files and you
   * (the theme developer) will need to copy the new files to your theme to
   * maintain compatibility. We try to do this as little as possible, but it does
   * happen. When this occurs the version of the template file will be bumped and
   * the readme will list any important changes.
   *
   * @see      https://docs.woocommerce.com/document/template-structure/
   * @package  WooCommerce/Templates
 * @version 3.5.0
   */

  if(!defined('ABSPATH')){
    exit;
  }

  do_action('woocommerce_before_checkout_form', $checkout);

  // If checkout registration is disabled and not logged in, the user cannot checkout
  if(!$checkout->enable_signup && !$checkout->enable_guest_checkout && !is_user_logged_in()){
    echo apply_filters('woocommerce_checkout_must_be_logged_in_message', __('You must be logged in to checkout.', 'woocommerce'));
    return;
  }

  global $checkout_userlogin;
  $checkout_userlogin = is_user_logged_in();
  foreach(WC()->cart->get_cart_contents() as $cart_item_key => $values){
    $current_productID = $values['product_id'];
    $is_product_subscription = ($values['data']->get_type() == 'subscription')?true:false;
    $product_name = $values['data']->get_title();
    break;
  }
  $is_waitlist = (LiveGlam_WaitlistOrder::cartHasWaitlistedItems(WC()->cart) && !LiveGlam_WaitlistOrder::check_is_payment_for_order_failed())?true:false;
  $lg_the_username_suggestion = get_option('lg_the_username_suggestion_on_checkout');
  $lgs_shipping_address_box = apply_filters('lgs_shipping_address_box',false);

?>

  <div class="pg-payment">
    <div class="content payment-form">
      <div class="container">

        <form name="checkout" method="post" class="checkout woocommerce-checkout" action="<?php echo esc_url(wc_get_checkout_url()); ?>" enctype="multipart/form-data">

          <div class="row pg-payment-row pg-payment-details">
            <div class="col-lg-4 order-lg-2 colmb-nopadding">

              <?php do_action('liveglam_before_checkout_review_order');?>

              <div class="order-summary">

                <div class="show-mobile">
                  <div class="liveglam-show-option-notices"></div>
                </div>

                <div class="liveglam-show-product-items"></div>

                <div id="order_review" class="woocommerce-checkout-review-order">
                  <?php woocommerce_order_review(); ?>

                </div>

              </div>

              <?php if($lgs_shipping_address_box){ ?>
                <div class="lg_shipping_address show-desktop">
                  <div class="lg_shipping_address_box">
                    <div class="lg_shipping_address_box_top">
                      <p>Verify Your Address<img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/newdesign-icon-pin.svg" alt="Icon Pin"/></p>
                    </div>
                    <div class="lg_shipping_address_box_center">
                      <p>By proceeding to payment, you are verifying the following shipping address:</p>
                    </div>
                    <div class="lg_shipping_address_box_btm">
                      <div class="lg_shipping_details">
                      </div>
                    </div>
                  </div>
                </div>
              <?php } ?>
            </div>

            <div class="col-lg-8 order-lg-1 colmb-nopadding">

              <div class="hide-mobile">
                <div class="liveglam-show-option-notices"></div>
              </div>

              <div class="liveglam-gaga-options">
                <div class="liveglam-gaga-value-input d-none"></div>
                <div class="liveglam-gaga-select-option"></div>
              </div>

              <div class="payment-info pg-background">

                <?php if($checkout->get_checkout_fields()) : ?>

                  <?php do_action('woocommerce_checkout_before_customer_details'); ?>

                  <?php //echo do_shortcode('[referral_code_checkout]'); ?>
                  <?php //echo do_shortcode('[lgs_form_coupon_code]'); ?>

                  <?php if(!is_user_logged_in() && $checkout->enable_signup) : ?>

                    <div class="create-account">

                      <?php if($checkout->enable_guest_checkout) : ?>

                        <p class="form-row form-row-wide create-account">
                          <input class="input-checkbox" id="createaccount" <?php checked((true === $checkout->get_value('createaccount') || (true === apply_filters('woocommerce_create_account_default_checked', false))), true) ?> type="checkbox" name="createaccount" value="1"/>
                          <label for="createaccount" class="checkbox"><?php _e('Create an account?', 'woocommerce'); ?></label>
                        </p>

                      <?php endif; ?>

                      <?php do_action('woocommerce_before_checkout_registration_form', $checkout); ?>

                      <?php if(!empty($checkout->checkout_fields['account'])) : ?>

                        <div class="payment-sub-title">
                          <p class="sub-title">
                            <span>1</span>
                            Create Your Account</p>

                          <p class="already_member">Already a member? <a href="#" class="log-in simplemodal-login">Log in</a></p>
                        </div>

                        <?php foreach($checkout->checkout_fields['account'] as $key => $field) : ?>

                          <?php woocommerce_form_field($key, $field, $checkout->get_value($key)); ?>

                        <?php endforeach; ?>

                        <div class="clear"></div>

                      <?php endif; ?>

                      <?php do_action('woocommerce_after_checkout_registration_form', $checkout); ?>

                    </div>

                    <div class="payment-mobile-bg show-mobile"></div>

                  <?php endif; ?>

                  <div id="customer_details" class="customer_details">

                    <div class="billing-info">
                      <?php do_action('woocommerce_checkout_billing'); ?>
                    </div>

                    <div class="billing-info-extend">
                      <?php do_action('liveglam_checkout_lgs_extend'); ?>
                    </div>

                    <div class="shipping-info">
                      <?php do_action('woocommerce_checkout_shipping'); ?>
                    </div>
                  </div>

                  <?php do_action('woocommerce_checkout_after_customer_details'); ?>

                <?php endif; ?>
                <?php if($lgs_shipping_address_box){
                  ?>
                  <div class="lg_shipping_address show-mobile">
                    <div class="lg_shipping_address_box">
                      <div class="lg_shipping_address_box_top">
                        <p>Verify Your Address<img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/newdesign-icon-pin.svg" alt="Icon Pin"/></p>
                      </div>
                      <div class="lg_shipping_address_box_center">
                        <p>By proceeding to payment, you are verifying the following shipping address:</p>
                      </div>
                      <div class="lg_shipping_address_box_btm">
                        <div class="lg_shipping_details"></div>
                      </div>
                    </div>
                  </div>
                  <?php
                }?>

                <div class="payment-mobile-bg show-mobile"></div>
                  <div class="pg-payment-row pg-payment-section">

              <?php do_action('woocommerce_checkout_before_order_review'); ?>

              <div class="card-info pg-background">

                <p class="sub-title"><span><?php echo $checkout_userlogin?2:3; ?></span>Card Details</p>

                <div id="order_review" class="woocommerce-checkout-review-order">
                  <?php remove_action('woocommerce_checkout_order_review', 'woocommerce_order_review', 10);
                    do_action('woocommerce_checkout_order_review'); ?>
                </div>

              </div>

              <?php do_action('woocommerce_checkout_after_order_review'); ?>
            </div>
              </div>

            </div>
          </div>

        </form>

        <?php do_action('woocommerce_after_checkout_form', $checkout); ?>

      </div>
    </div>

    <div class="content payment-faqs">
      <div class="container">
        <div class="row">
          <div class="col-xl-8">
            <?php $faqs = add_faq_on_checkout();
              if(!empty($faqs)) :?>
                <div class="frequently-questions">
                  <h3 class="text-center">Frequently Asked Questions</h3>
                  <div class="row requently-collapse">
                    <?php $faq_col1 = 1;
                      $faq_col2 = 0;
                      $faq_num_per_col = count($faqs) / 2;
                      for($faq_col1; $faq_col1 <= 2; $faq_col1++){ ?>
                        <div class="col-lg-6">
                          <div class="panel-group" id="accordion<?php echo $faq_col1; ?>">
                            <?php for($faq_col2; $faq_col2 < $faq_col1 * $faq_num_per_col; $faq_col2++){
                              $faq = $faqs[$faq_col2]; ?>
                                    <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion<?php echo $faq_col1; ?>" href="#panel<?php echo $faq_col2; ?>"><i class="fas fa-plus"></i><span><?php echo $faq['question']; ?></span></a>
                              <div class="card">
                                <div class="card-header">
                                  <h4 class="card-title">
                                  </h4>
                                </div>
                                <div id="panel<?php echo $faq_col2; ?>" class="panel-collapse collapse">
                                  <div class="card-body"><?php echo $faq['answer']; ?></div>
                                </div>
                              </div>
                            <?php } ?>

                          </div>
                        </div>
                      <?php } ?>

                  </div>
                </div>
              <?php endif; ?>
          </div>
          <div class="col-xl-4 requently-collapse1">
            <div class="frequently-support">
              <div class="support hide-mobile">
                <div class="support-content">
                  <div class="support-content-left text-left">
                    <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/help-blue.png" class="img-lock" alt="Help Blue"> How Can We Help?
                  </div>
                  <div class="support-content-right text-left">
                    <!--<p class="txt-sm">How can We Help?</p>-->
                    <p class="txt-xs">Send an email to support@liveglam.com or Contact us:</p>
                  </div>
                </div>
                <div class="support-content text-center">
                  <a href="<?php echo home_url('/contact-us'); ?>" class="btn-primary btn-solid btn-sm btn-block">Contact Support</a>
                </div>
              </div>
              <div class="support show-mobile">
                <div class="support-content">
                  <div class="support-content-right text-left">
                    <p class="txt-sm">How Can We Help?</p>
                    <p class="txt-xs">Send an email to support@liveglam.com or Contact us:</p>
                  </div>
                </div>
                <div class="support-content text-center">
                  <a href="<?php echo home_url('/contact-us'); ?>" class="btn-primary btn-solid btn-sm btn-block">Contact Support</a>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  </div>

  <div class='woocommerce-error-popup error-popup-checkout mfp-hide'>
    <div class='woocommerce-error-header woocommerce-message-header'>
      <img class='img-check' src='<?php echo get_stylesheet_directory_uri(); ?>/assets/img/popup-cancel-black.svg' alt='Image Check'/>
      <h2>Oops.</h2>
    </div>
    <div class='woocommerce-error-footer woocommerce-message-footer'>
      <p class="error-message"></p>
      <button class='btn btn-close btn-primary lgs-error-custom'>OK, GOT IT</button>
    </div>
  </div>

  <div class='woocommerce-error-popup error-popup-checkout2 mfp-hide'>
    <div class='woocommerce-error-header woocommerce-message-header'>
      <img class='img-check' src='<?php echo get_stylesheet_directory_uri(); ?>/assets/img/popup-cancel-black.svg' alt='Image Check'/>
      <h2>Oops.</h2>
    </div>
    <div class='woocommerce-error-footer woocommerce-message-footer'>
      <p class="error-message"></p>
      <a href="<?php echo home_url('/cart'); ?>" class='btn btn-primary'>OK, GOT IT</a>
    </div>
  </div>

  <div class='woocommerce-error-popup check-duplicate-order mfp-hide'>
    <div class='woocommerce-error-header woocommerce-message-header'>
      <img class='img-check' src='<?php echo get_stylesheet_directory_uri(); ?>/assets/img/popup-cancel-black.svg' alt='Image Check'/>
      <h2>Oops.</h2>
    </div>
    <div class='woocommerce-error-footer woocommerce-message-footer'>
      <div class="error-message">
        <p>We saw you already placed an order for <span class="product-list txt-pink">same product</span> in the last <?php $time_disable = !empty($time_disable = get_option('time_disable_same_product_for_customer'))?$time_disable:0; echo sprintf(_n('%1$s minute', ' %1$s minutes', $time_disable), $time_disable); ?>. Do you want to proceed with another order?</p>
      </div>
      <div class="check-duplicate-order-action">
        <button class='btn btn-close check-duplicate-order-true btn-primary btn-solid btn-half' onclick="jQuery.magnificPopup.close();jQuery('button#place_order').click();">Yes</button>
        <button class='btn btn-close check-duplicate-order-false btn-primary btn-solid btn-half' onclick="jQuery.magnificPopup.close();restore_place_order();">No</button>
      </div>
    </div>
  </div>

  <script type="text/javascript">
    jQuery(document.body).on('lgs_checkout_custom', function () {
      jQuery('body').addClass('stop-scrolling');
      jQuery('body').bind('touchmove', function (e) {
        e.preventDefault()
      });
      jQuery.blockUI({
        message: "<div class='popup_UI'><span class='default-loading-icon spin'></span><p>Please wait while we process your order...<br>This may take up to 1 minute.</p><div>"
      });
    });
    function restore_place_order() {
      jQuery('.btn-pay').prop('disabled', false);
      jQuery('.btn-pay').html('<img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/white-lock.png" class="img-lock" alt="Image Lock">Pay Securely');
    }

    jQuery('body').on('ifChanged', '.prc_product .prc_select input[type="checkbox"]', function (ev) {
      var checkboxes = jQuery('.prc_product .prc_select input[type="checkbox"]');
      var current = jQuery(this);
      if (checkboxes.filter(":checked").length >= 2) {
        checkboxes.not(":checked").iCheck('disable');
      } else {
        checkboxes.not(":checked").iCheck('enable');
      }
    });

    jQuery('form.woocommerce-checkout').on('checkout_place_order', function () {

      //shows popup asking customer to confirm trade or cancel it
      var need_confirm_trade = false;
      jQuery('.liveglam-show-product-items .product-items .product-item-trade-list').each(function () {
        if( jQuery(this).is(':visible') ){
          need_confirm_trade = true;
        }
      });
      if( need_confirm_trade ){
        var message = '<p>Please confirm or cancel your trade before completing your payment!</p>';
        jQuery('.error-popup-checkout .error-message').html(message);
        jQuery.magnificPopup.open({
          items: {src: ".woocommerce-error-popup.error-popup-checkout"},
          type: "inline",
          closeOnContentClick: false,
          closeOnBgClick: false,
          showCloseBtn: false
        });
        restore_place_order();
        return false;
      }

      //check have select free gaga and show notice select gaga
      var option_free = jQuery('.prc_product .prc_select input[type="radio"]');
      if( option_free.is(':visible') && option_free.length > 0 && option_free.filter(":checked").length == 0 ){
        var please_select = false,
          message = '',
          input_name = option_free.attr('name'),
          list_free_mm = ['givefp_brush','lgs_gaga_mm'],
          list_free_km = ['givefp_kissme','lgs_gaga_km','givefp_shadowme','lgs_gaga_sm'];

        if(jQuery.inArray(input_name,list_free_mm) != -1){
          please_select = true;
          message = '<p>Please, select your free brush.</p>';
        } else if(jQuery.inArray(input_name,list_free_km) != -1){
          please_select = true;
          message = '<p>Please, select your free lippie.</p>';
        }

        if( please_select == true && message != '' ){
          jQuery('.error-popup-checkout .error-message').html(message);
          jQuery.magnificPopup.open({
            items: {src: ".woocommerce-error-popup.error-popup-checkout"},
            type: "inline",
            closeOnContentClick: false,
            closeOnBgClick: false,
            showCloseBtn: false
          });
          restore_place_order();
          return false;
        }
      }

      //check have select free gaga and show notice select gaga: multiple gaga
      var option_free = jQuery('.prc_product .prc_select input[type="checkbox"]');
      if( option_free.is(':visible') && option_free.length > 0 && option_free.filter(":checked").length < 2 ){
        var please_select = false,
          message = '',
          allcheckboxes = option_free.length,
          checkedboxes = option_free.filter(":checked").length,
          input_name = option_free.attr('name'),
          list_free_mm = ['lgs_gaga_mm[]'],
          list_free_km = ['lgs_gaga_km[]','lgs_gaga_sm[]'];

        if(jQuery.inArray(input_name,list_free_mm) != -1){
          if (checkedboxes == 0 && allcheckboxes >= 1) {
            please_select = true;
            message = '<p>Please select 2 free brushes.</p>';
          } else {
            if (checkedboxes == 1 && allcheckboxes >= 2) {
              please_select = true;
              message = '<p>Please select 1 more free brush.</p>';
            }
          }
        } else if(jQuery.inArray(input_name,list_free_km) != -1){
          please_select = true;
          if (checkedboxes == 0 && allcheckboxes >= 1) {
            please_select = true;
            message = '<p>Please select 2 free lippies.</p>';
          } else {
            if (checkedboxes == 1 && allcheckboxes >= 2) {
              please_select = true;
              message = '<p>Please select 1 more free lippie.</p>';
            }
          }
        }

        if( please_select == true && message != '' ){
          jQuery('.error-popup-checkout .error-message').html(message);
          jQuery.magnificPopup.open({
            items: {src: ".woocommerce-error-popup.error-popup-checkout"},
            type: "inline",
            closeOnContentClick: false,
            closeOnBgClick: false,
            showCloseBtn: false
          });
          restore_place_order();
          return false;
        }
      }

      setTimeout(function () {
        restore_place_order();
      }, 3000);
    });
    jQuery(document.body).on('checkout_error', function () {
      restore_place_order();
      jQuery('body').unbind('touchmove');
      jQuery('body').removeClass('stop-scrolling');
      jQuery('.card-error').remove();
      jQuery.unblockUI();
    });

    jQuery('form.woocommerce-checkout').on('click', '#place_order', function () {
      jQuery('.card-error').remove();
      jQuery('.btn-pay').html('<i class="fas fa-circle-notch fa-spin fa-lg fa-fw"></i> Please Wait');
    });

    jQuery('.show-if-disable-one').addClass('d-none');
    var total_clicked = 0;
    jQuery('body').on('click', '.btn.btn-pay', function () {
      var  heigh_top = jQuery('.fixed-top').height() + jQuery('.free-subscription-bar').height() + jQuery('.scroller-target').height();
      //check if need show payment fields
      if(jQuery('.wc_payment_methods').hasClass('disabled_one-payment')){
        jQuery('.wc_payment_methods').removeClass('disabled_one-payment').fadeIn(300);
        jQuery('html, body').animate({scrollTop: jQuery('.pg-payment-section').offset().top - heigh_top + 1}, 'slow');
        return false;
      }
      //disable payment if nummber/expiry/cvc is empty
      if((jQuery('#stripe-card-element:visible').length && !jQuery('#stripe-card-element:visible').hasClass('StripeElement--complete'))
        || (jQuery('#stripe-exp-element:visible').length && !jQuery('#stripe-exp-element:visible').hasClass('StripeElement--complete'))
        || (jQuery('#stripe-cvc-element:visible').length && !jQuery('#stripe-cvc-element:visible').hasClass('StripeElement--complete'))){
        jQuery('html, body').animate({scrollTop: jQuery('.pg-payment-section').offset().top - heigh_top + 1}, 'slow');
        return false;
      }

      jQuery('.btn-pay').prop('disabled', true);

      //add condition here to check duplicate order if enable #960
      var data = {'action':'lgs_check_duplicate_purchase'};
      jQuery.post(ajaxurl,data,function(e){
        if(e.result == 'success'){
          jQuery('button#place_order').click();
        } else {
          jQuery('.woocommerce-error-popup.check-duplicate-order .error-message .product-list').text(e.products);
          jQuery.magnificPopup.open({
            items: {src: ".woocommerce-error-popup.check-duplicate-order"},
            type: "inline",
            closeOnContentClick: false,
            closeOnBgClick: false,
            showCloseBtn: false
          });
        }
      },'json');
      return false;
    });

    jQuery(document).on('stripeError', function (event, responseObject) {
        if(jQuery('.card-error li').text() != '' && jQuery('.card-error li').text() != undefined){
            return;
        }
      jQuery('body').unbind('touchmove');
      jQuery('body').removeClass('stop-scrolling');
      jQuery.unblockUI();

      if (responseObject.error.message) {
        jQuery('form.checkout').prepend('<ul class="card-error woocommerce-error">' +
          '<li>' + responseObject.error.message + '</li>' +
          '</ul>');
        jQuery('html, body').animate({scrollTop: 0}, 700);
      }
    });

    jQuery("body").on("wc-stripe-error", function (event, response) {
      jQuery('body').unbind('touchmove');
      jQuery('body').removeClass('stop-scrolling');
      jQuery.unblockUI();
      jQuery('.card-error').remove();
      if (response.response.error.message) {
        jQuery('form.checkout').prepend('<ul class="card-error woocommerce-error">' +
          '<li>' + response.response.error.message + '</li>' +
          '</ul>');
      }
    });

    /*jQuery("body").on( "updated_checkout", function (event) {
     var name;
     name = jQuery('input[name="billing_first_name"]').val()+" "+jQuery('input[name="billing_last_name"]').val();
     name = jQuery.trim(name);

     jQuery('#payment').card({
     container: '.card-wrapper',
     formatting: false,
     formSelectors: {
     numberInput: 'input#stripe-card-number',
     expiryInput: 'input#stripe-card-expiry',
     cvcInput: 'input#stripe-card-cvc',
     nameInput: 'input[name="billing_first_name"], input[name="billing_last_name"]'
     },
     debug: true
     });
     if (name) jQuery('.jp-card-name').text(name);
     });*/

    jQuery("body").on( "updated_checkout", function () {
      jQuery('#billing_phone').blur();
    });

    jQuery('body').on('update_checkout', function () {
      if (jQuery('#billing_country').val() == 'PR') {
        jQuery('#billing_state').val('PR').prop('readonly', true);
      } else {
        jQuery('#billing_state').prop('readonly', false);
      }
      if (jQuery('#shipping_country').val() == 'PR' && jQuery('#ship-to-different-address-checkbox').is(":checked")) {
        jQuery('#shipping_state').val('PR').prop('readonly', true);
      } else {
        jQuery('#shipping_state').prop('readonly', false);
      }
    });

    jQuery("body").on('payment.cardType', function (event, cardType) {
      var cardTypes = ['jp-card-amex', 'jp-card-dankort', 'jp-card-dinersclub', 'jp-card-discover', 'jp-card-jcb', 'jp-card-laser', 'jp-card-maestro', 'jp-card-mastercard', 'jp-card-unionpay', 'jp-card-visa', 'jp-card-visaelectron', 'jp-card-elo'];
      if (!jQuery(".jp-card").hasClass(cardType)) {
        jQuery(".jp-card").removeClass('jp-card-unknown');
        jQuery(".jp-card").removeClass(cardTypes.join(' '));
        jQuery(".jp-card").addClass("jp-card-" + cardType);
        if (cardType !== 'unknown') jQuery(".jp-card").toggleClass('jp-card-identified');
      }

    });

    jQuery(document).ready(function () {

      jQuery("#account_username").lgvalidate({
        expression: "if ( VAL.indexOf(' ') < 0 ) return true; else return false;",
        message: "Blank space is not allowed in username"
      });
      jQuery("#account_username").lgvalidate({
        expression: "if ( VAL ) return true; else return false;",
        message: "Please enter the Required field"
      });
      jQuery("#account_password").lgvalidate({
        expression: "if (VAL.length > 5 && VAL) return true; else return false;",
        message: "Password should be minimum 6 characters"
      });
      jQuery("#billing_first_name").lgvalidate({
        expression: "if (VAL) return true; else return false;",
        message: "Please enter the Required field"
      });
      jQuery("#billing_last_name").lgvalidate({
        expression: "if (VAL) return true; else return false;",
        message: "Please enter the Required field"
      });
      jQuery("#billing_address_1").lgvalidate({
        expression: "if (VAL) return true; else return false;",
        message: "Please enter the Required field"
      });
      jQuery("#billing_city").lgvalidate({
        expression: "if (VAL) return true; else return false;",
        message: "Please enter the Required field"
      });
      jQuery("#billing_postcode").lgvalidate({
        expression: "if (VAL) return true; else return false;",
        message: "Please enter the Required field"
      });
      jQuery("#billing_phone").on('keypress',function(evt){
        if(evt.which === 8 || evt.which === 0) return;
        if(evt.which< 40 || evt.which > 57 ) evt.preventDefault();
        if(evt.which == 42) evt.preventDefault();
      });
      jQuery("#billing_email").lgvalidate({
        expression: "if (!VAL.match(/.con$/) && VAL.match(/^[a-zA-Z0-9\\_\\-\\.\\+]/)) return true; else return false;",
        message: "Your Email should be a valid Email id"
      });
      jQuery("#billing_email").lgvalidate({
        expression: "if (!VAL.match(/.con$/) && VAL.match(/^[a-zA-Z0-9\\_\\-\\.\\+]*\\@/)) return true; else return false;",
        message: "You are missing @ in entered email"
      });
      jQuery("#billing_email").lgvalidate({
        expression: "if (!VAL.match(/.con$/) && VAL.match(/^[a-zA-Z0-9\\_\\-\\.\\+]*\\@[a-zA-Z0-9\\_\\-]*\\./) ) return true; else return false;",
        message: "You are missing . in entered email"
      });
      jQuery("#billing_email").lgvalidate({
        expression: "if (!VAL.match(/.con$/) && VAL.match(/^[a-zA-Z0-9\\_\\-\\.\\+]*\\@[a-zA-Z0-9\\_\\-]+(\\.[a-zA-Z0-9_]+)*\\.[a-zA-Z]{2,4}$/) ) return true; else return false;",
        message: "You are missing domain in entered email</br>example: Johndoe@gmail.com"
      });

      checkout_validate();
      jQuery('.validate-required input').on('focus keypress focusout', function () {
        checkout_validate();
      });

      <?php if( !$checkout_userlogin ):?>
      <?php if( isset($lg_the_username_suggestion) && $lg_the_username_suggestion == 'yes' ):?>
      jQuery('body').on('change',"#account_username",function(){
        if(jQuery(this).val() == '') return;
        var data = {
          'action'    : 'check_username_is_exist',
          'username'  : jQuery(this).val()
        };
        jQuery.post(ajaxurl,data,function(e){
          if(e.suggest){
            var suggest_username = '';
            for (index = 0; index < e.suggest.length; ++index) {
              suggest_username += e.suggest[index];
            }
            jQuery('#suggest_username').remove();
            jQuery('#account_username').addClass('ErrorField');
            jQuery('#account_username_field').removeClass('woocommerce-validated');
            jQuery('#account_username_field').addClass('woocommerce-invalid woocommerce-invalid-required-field');
            jQuery('#account_username_field').append('<span id="suggest_username" class="ValidationErrors"><span style="font-weight: bold">The username is taken.</span></br>You can try: '+suggest_username+'</span>');
            jQuery('.pg-payment-row.pg-payment-section #order_review').after('<span class="suggest_username ValidationErrors">The username is taken</span>');
          }else{
            jQuery('#suggest_username, .suggest_username').remove();
            jQuery('#account_username').removeClass('ErrorField');
            jQuery('#account_username_field').removeClass('woocommerce-invalid woocommerce-invalid-required-field');
            jQuery('#account_username_field').addClass('woocommerce-validated');

          }
          checkout_validate();
        },'JSON');
      });
      <?php endif;?>

      jQuery('body').on('change',"#billing_email",function(){
        var email = jQuery(this).val();
        jQuery('#email_exist,.email_exist').remove();
        if( !checkemail(email) ) return;
        var data = {
          'action'    : 'check_email_is_exist',
          'email'  : jQuery(this).val()
        };
        jQuery.post(ajaxurl,data,function(e){
          if(e == 1){
            jQuery('#billing_email').addClass('ErrorField ErrorEmail');
            jQuery('#billing_email_field').removeClass('woocommerce-validated');
            jQuery('#billing_email_field').addClass('woocommerce-invalid woocommerce-invalid-required-field');
            jQuery('#billing_email_field').append('<span class="email_exist ValidationErrors">An account already exist with this email please try to <a class="simplemodal-login underline" href="#">login</a></span>');
            jQuery('.pg-payment-row.pg-payment-section #order_review').after('<span id="email_exist" class="ValidationErrors">An account already exist with this email please try to <a class="simplemodal-login underline" href="#">login</a></span>');
          }else{
            jQuery('#billing_email').removeClass('ErrorField ErrorEmail');
            jQuery('#billing_email_field').removeClass('woocommerce-invalid woocommerce-invalid-required-field');
            jQuery('#billing_email_field').addClass('woocommerce-validated');
            jQuery('#email_exist,.email_exist').remove();

          }
          checkout_validate();
        },'JSON');
      });
      function checkemail(email) {
        email = jQuery.trim(email);
        var regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
        return regex.test(email);
      }
      jQuery('body').on('click', '.another_username', function () {
        jQuery('#account_username').val(jQuery(this).text()).change();
        //jQuery('#account_username').removeClass('ErrorField');
        //jQuery('#account_username_field').removeClass('woocommerce-invalid woocommerce-invalid-required-field');
        //jQuery('#account_username_field').addClass('woocommerce-validated');
        jQuery('#suggest_username,.suggest_username').remove();
      });
      <?php endif;?>

      jQuery('body').on('click', '.payment-info .review-subscription ul li', function () {
        if (jQuery(this).hasClass('active')) {
          return false;
        }

        window.location.href = jQuery(this).data('id');

        return false;
      });

      //auto expand the fields to update address manually
      jQuery('body').on('focusout', '#shipping_address_google_field input', function () {
        jQuery('.details_shipping').slideDown();
        jQuery('#shipping_address_not_found').hide();
        return false;
      });
      jQuery('body').on('focusout', '#billing_address_google_field input', function () {
        jQuery('.details_billing').slideDown();
        jQuery('#billing_address_not_found').hide();
        return false;
      });

      jQuery('body').on('click', '.lgs-error-custom', function (){
        jQuery.magnificPopup.close();
        var e_scrollTop = 0;
        if( jQuery('.liveglam-gaga-options').length > 0 ){
          e_scrollTop = jQuery('.liveglam-gaga-options').offset().top - parseInt(jQuery('body').css('padding-top')) - 30;
        }
        jQuery('.liveglam-show-product-items .product-items .product-item-trade-list').each(function () {
          if( jQuery(this).is(':visible') ) {
            e_scrollTop = jQuery(this).offset().top - parseInt(jQuery('body').css('padding-top')) - 30;
          }
        });
        jQuery('html, body').animate({ scrollTop: e_scrollTop }, 1000);
      });

      //#970 use different billing address
      jQuery('body').on('focusout', '#lgs_extend_address_google_field input', function () {
        jQuery('.details_lgs_extend').slideDown();
        jQuery('#lgs_extend_address_not_found').hide();
        return false;
      });
      jQuery('body').on('change', '#use-billing-extend input', function () {
        use_different_billing_address();
        checkout_validate();
      });

      use_different_billing_address();

      function use_different_billing_address() {
        jQuery( 'div.lgs_extend_address' ).hide();
        if ( jQuery( '#use-billing-extend input' ).is( ':checked' ) ) {
          jQuery( 'div.lgs_extend_address' ).slideDown();
        }

        jQuery( document.body ).trigger( 'country_to_state_changed');
      }

    });
  </script>

  <script type="text/javascript">
    var cookie_name = 'last_page';
    var cookie_productid = 'last_product';
    function goBack(home_url) {
      if (getCookie(cookie_productid) != '<?php echo $current_productID;?>' && getCookie(cookie_productid) != '') {
        window.location.href = home_url + '/cart/?add-to-cart=' + getCookie(cookie_productid);
      } else {
        if (getCookie(cookie_name) != '') {
          window.location.href = getCookie(cookie_name);
        } else {
          window.location.href = home_url;
        }
      }

    }
    setCookie(cookie_name, document.referrer, 'url');
    setCookie(cookie_productid, '<?php echo $current_productID;?>', 'product');
    function setCookie(cookiename, value, type) {
      if (type == 'url') {
        if (getCookie(cookiename) != document.URL && document.URL != value) {
          var d = new Date();
          d.setTime(d.getTime() + (24 * 60 * 60));
          var expires = "expires=" + d.toUTCString();
          document.cookie = cookiename + "=" + value + ";" + expires + ";path=/";
        }
      } else {
        if (type == 'product') {
          if (document.URL != document.referrer) {
            var d = new Date();
            d.setTime(d.getTime() + (24 * 60 * 60));
            var expires = "expires=" + d.toUTCString();
            document.cookie = cookiename + "=" + value + ";" + expires + ";path=/";
          }
        }
      }


    }
    function getCookie(cname) {
      var cnameCookie = document.cookie.match ('(^|;) ?' + cname + '=([^;]*)(;|$)');
      if (cnameCookie && cnameCookie.length > 0) {
          return cnameCookie[2];
      }
      return "";
    }

    function questions_collapse() {
      if( jQuery('.pg-payment .content .frequently-questions').length > 0 ) {
        var currentWidth = jQuery(window).width(),
          current = jQuery('.pg-payment .content .frequently-questions h3');
        if (currentWidth >= 768) {
          current.removeClass('active');
          jQuery('.requently-collapse').slideDown();
        } else {
          if (current.hasClass('active')) {
            current.removeClass('active');
            jQuery('.requently-collapse').slideDown();
          } else {
            current.addClass('active');
            jQuery('.requently-collapse').slideUp();
          }
        }
      }
    }
    jQuery(document).ready(function () {

      jQuery('body').on('click', '.checkout_goback', function () {
        goBack(jQuery(this).data('home_url'));
        return false;
      });

      questions_collapse();
      jQuery('body').on('click', '.pg-payment .content .frequently-questions h3', function () {
        questions_collapse();
        return false;
      });
    });
  </script>

<?php
  function add_faq_on_checkout(){

    $faqs = array();
    $key_product = '';

    foreach(WC()->cart->get_cart_contents() as $cart_item_key => $values){
      if(in_array($values['product_id'], lgs_product_mm)){
        $key_product = 'mm_faqs';
      }elseif(in_array($values['product_id'], lgs_product_km)){
        $key_product = 'km_faqs';
      }elseif(in_array($values['product_id'], lgs_product_sm)){
        $key_product = 'sm_faqs';
      }
    }

    if(!empty($key_product) && !empty($total_faqs = get_post_meta(get_the_ID(), $key_product, true))){
      for($i = 0; $i < $total_faqs; $i++){
        $question = get_post_meta(get_the_ID(), $key_product.'_'.$i.'_question', true);
        $answer = wpautop(get_post_meta(get_the_ID(), $key_product.'_'.$i.'_answer', true));
        if(!empty($question) && !empty($answer)){
          $faqs[] = array('question' => $question, 'answer' => $answer);
        }
      }
    }

    return $faqs;
  }