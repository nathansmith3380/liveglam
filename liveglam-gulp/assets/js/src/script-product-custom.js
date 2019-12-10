jQuery(document).ready(function($){

  var text_add_dk = "Add to Bag";
  var text_add_mb = "<img src='"+stylesheet_uri+"/assets/img/cart.png'/>  Add";
  var text_adding = "Adding";
  var text_added = "Added";

  function lgs_reload_cart_bag(content,count_items) {
    jQuery( '.cart_bag.cart_content' ).html(content);
    jQuery( '.cart_bag.count_items' ).text(count_items);
    if( count_items == 0 ){
      jQuery( '.btn-cart-bag-menu-mobile' ).addClass('hidden-important');
      jQuery( '.liveglam_join_now-mobile' ).removeClass('hidden-important');
    } else {
      jQuery( '.btn-cart-bag-menu-mobile' ).removeClass('hidden-important');
      jQuery( '.liveglam_join_now-mobile' ).addClass('hidden-important');
    }
    inputNumber(jQuery('.cart_bag input.qty'));
  }

  function lgs_load_cart_bag() {
    if(jQuery('.btn-cart-bag-menu').length && !jQuery('body').hasClass('page-id-8')) {
      if ( Cookies.get( 'woocommerce_items_in_cart' ) > 0 ) {
        var data = {
          'action': 'lgs_load_cart_bag'
        };
        jQuery.post(ajaxurl, data, function (response) {
          lgs_reload_cart_bag(response.html_cart,response.count_items);
        },'json');
      }
    }
  }

  lgs_load_cart_bag();

  jQuery('body').on('click','.button.single_add_to_cart_button',function () {
    var current = jQuery(this),
      product_id = current.val(),
      quantity = current.closest('form').find('input.qty').val(),
        variation_id = jQuery('input:hidden[name=variation_id]').val();
    if(current.hasClass('disabled')) return false;
    add_to_bag_action(current,product_id,quantity, variation_id, 0);
    return false;
  });

  jQuery('body').on('click','.button.add_to_bag',function () {
    var current = jQuery(this),
      product_id = current.data('product_id'),
      quantity = current.data('quantity'),
      variation_id = jQuery('input:hidden[name=variation_id]').val();
      if( !current.hasClass('action-go-single') ) {
        if (current.hasClass('outofstock')) return false;
        add_to_bag_action(current, product_id, quantity, variation_id, 1);
      return false;
    }
  });

  jQuery('body').on('change','.lgs-variable-options',function () {
    var current = jQuery(this),
        variation_id = current.find('option:selected').val(),
        add_cart_button = current.closest('.product-type-variable').find('.product-item-bottom .add_to_bag');
        add_cart_button.data('variation_id',variation_id);
        current.closest('.product-type-variable').find('.product-item-image').css('display','none');
        if(jQuery('.variable_product_'+variation_id) != undefined)
        jQuery('.variable_product_'+variation_id).fadeIn('200');
  });

  function add_to_bag_action(element,product_id,quantity,variation_id, is_shop_page) {
    if(element.hasClass('loading')) return false;
    element.addClass('loading').removeClass('added');
    if( is_shop_page ){
      element.find('span.show-mobile').html(text_adding);
      element.find('span.hide-mobile').html(text_adding);
    } else {
      element.html(text_adding);
    }
    //check if this is adding a variation but empty variation id
    if(jQuery('.woocommerce-variation-add-to-cart').length > 0 && !variation_id) return;
    var data = {
      action: 'lgs_add_to_bag',
      product_id: product_id,
      quantity: quantity,
      variation_id: variation_id
    };
    jQuery.post(ajaxurl,data,function (response) {
      element.removeClass('loading');
      if( is_shop_page ) {
        element.find('span.show-mobile').html(text_add_mb);
        element.find('span.hide-mobile').html(text_add_dk);
      } else {
        element.html(text_add_dk);
      }
      if( response.link_redirect != '' ){
        location.href = response.link_redirect;
      }
      if( response.status == 'success' ){
        element.addClass('added');
        if( is_shop_page ){
          element.find('span.show-mobile').html(text_added);
          element.find('span.hide-mobile').html(text_added);
        } else {
          element.html(text_added);
        }
        element.parent().addClass('active');
        lgs_reload_cart_bag(response.html_cart,response.count_items);
      }
      if( response.message != '' ){
        jQuery('body').append(response.message);
        jQuery.magnificPopup.open({
          items:{src:"#woocommerce-custom-notice-product"},
          type:"inline",
          closeOnContentClick: false,
          closeOnBgClick: false,
          showCloseBtn: false});
      }
      var width = (window.innerWidth > 0) ? window.innerWidth : screen.width;
      if (width <= 767) {
        jQuery('a.btn-cart-bag-menu-mobile').click();
      }
    },'json');
    show_cart_bag();
  }

  jQuery('body').on('jPushMenu_trigger_open_cart_bag',function () {
    var current = jQuery('a.btn-cart-bag-menu-mobile');
    if( current.hasClass('is-active') ){
      jQuery('body').prepend('<div class="overlay"></div>');
    }
  });

  jQuery( document ).on( 'change', '.cart_bag input.qty', function() {
    var item_hash = jQuery( this ).attr( 'name' ).replace(/cart\[([\w]+)\]\[qty\]/g, "$1");
    var item_quantity = jQuery( this ).val();
    var currentVal = parseFloat(item_quantity);
    var data = {
      'action' : 'lgs_update_qty_cart',
      'hash': item_hash,
      'quantity': currentVal
    };
    jQuery.post(ajaxurl,data,function(response) {
      lgs_reload_cart_bag(response.html_cart,response.count_items);
    },'json');

  });

  jQuery('body').on('keyup','input.qty',function(){
    var max = parseInt(jQuery(this).attr('max')),
      min = parseInt(jQuery(this).attr('min')),
      value = parseInt(jQuery(this).val());
    if( isNaN(value) ){
      jQuery(this).val(min);
    }
    if( value < min ){
      jQuery(this).val(min);
    }
    if( value > max ){
      jQuery(this).val(max);
    }
  });

  jQuery( document ).on( 'click', '.cart_bag .remove-item', function() {
    var item_key = jQuery( this ).data('item_key'),
      product_id = jQuery( this ).data('pid');
    var data = {
      'action' : 'lgs_remove_item_cart',
      'item_key': item_key
    };
    jQuery.post(ajaxurl,data,function(response) {
      lgs_reload_cart_bag(response.html_cart,response.count_items);
      jQuery('a[data-product_id="'+product_id+'"]').each(function () {
        jQuery(this).removeClass('added');
        jQuery(this).find('span.show-mobile').html(text_add_mb);
        jQuery(this).find('span.hide-mobile').html(text_add_dk);
        jQuery(this).parent().removeClass('active');
      });
      jQuery('button[data-product_id="'+product_id+'"]').each(function () {
        jQuery(this).removeClass('added');
        jQuery(this).find('span.show-mobile').html(text_add_mb);
        jQuery(this).find('span.hide-mobile').html(text_add_dk);
        jQuery(this).parent().removeClass('active');
      });
      jQuery('button.single_add_to_cart_button[value="'+product_id+'"]').each(function () {
        jQuery(this).removeClass('added').text(text_add_dk);
        jQuery(this).parent().removeClass('active');
      });
    },'json');
    return false;
  });

  jQuery('body').on('click','.coupon_form .coupon_submit',function () {
    var current = jQuery(this),
      parent = current.closest('.coupon_show'),
      code = parent.find('.coupon_input').val();
    var data = {
      'action': 'lgs_apply_coupon_code',
      'code': code
    };
    var svg_error = '<svg class="option-selected" width="133px" height="133px" viewBox="0 0 133 133" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"><g class="check-group" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd"><circle class="ck-filled-circle" fill="#f05e7c" cx="66.5" cy="66.5" r="54.5"></circle><circle class="ck-white-circle" fill="#FFFFFF" cx="66.5" cy="66.5" r="55.5"></circle><circle class="ck-outline" stroke="#D06079" stroke-width="4" cx="66.5" cy="66.5" r="54.5"></circle></circle><line class="ck-dash-line" fill="none" stroke="#ffffff" stroke-width="6" stroke-linecap="round" stroke-miterlimit="10" x1="40" y1="40" x2="90" y2="90"></line><line class="ck-dash-line" fill="none" stroke="#ffffff" stroke-width="6" stroke-linecap="round" stroke-miterlimit="10" x1="90" y1="40" x2="40" y2="90"></line></g></svg>',
      svg_success = '<svg class="option-selected" width="133px" height="133px" viewBox="0 0 133 133" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"><g class="check-group" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd"><circle class="ck-filled-circle" fill="#f05e7c" cx="66.5" cy="66.5" r="54.5"></circle><circle class="ck-white-circle" fill="#FFFFFF" cx="66.5" cy="66.5" r="55.5"></circle><circle class="ck-outline" stroke="#f05e7c" stroke-width="4" cx="66.5" cy="66.5" r="54.5"></circle><polyline class="ck-check" stroke="#FFFFFF" stroke-width="10" points="41 70 56 85 92 49"></polyline></g></svg>';
    if (code == '') {
      jQuery('.coupon-notice').html('<p class="coupon_message error">'+svg_error+'Please enter the code ...</p>');
      return false;
    }
    current.addClass('loading');
    jQuery.post(ajaxurl, data, function(response) {
      current.removeClass('loading');
      parent.find('.coupon_message').text();
      if( response.result == 'success' ){
        jQuery('.coupon-notice').html('<p class="coupon_message '+response.result+'">'+svg_success+response.message+'</p>');
        jQuery( 'body' ).trigger( 'update_checkout' );
      } else {
        jQuery('.coupon-notice').html('<p class="coupon_message '+response.result+'">'+svg_error+response.message+'</p>');
      }
    }, 'json');
    return false;
  });

  /** function show/hide cart bag on desktop **/
  jQuery('body').on('hover','.dropdown-cart-bag',function () {
    if( jQuery('.dropdown-content.cart_bag.cart_content').hasClass('need-hide') ){
      jQuery('.dropdown-content.cart_bag.cart_content').removeClass('need-hide');
      return false;
    }
    show_cart_bag();
  });

  jQuery('body').on('click','a.close-cart-bag',function () {
    hide_cart_bag();
    if (jQuery('.btn-cart-bag-menu-mobile').hasClass('is-active')) {
      jQuery('.btn-cart-bag-menu-mobile.is-active').click();
      jQuery('.overlay').remove();
    }
    return false;
  });

  function show_cart_bag() {
    jQuery('.dropdown-content.cart_bag.cart_content').removeClass('d-none');
  }

  function hide_cart_bag() {
    jQuery('.dropdown-content.cart_bag.cart_content').addClass('d-none need-hide');
  }

  /** end function show/hide cart bag on desktop **/

  //script add email to notifier for product
  jQuery('body').on('click','.popup-send-stock-notifier .stock-notifier-submit',function () {
    var email = jQuery(".popup-send-stock-notifier .stock-notifier-email").val(),
      productNAME = jQuery(".popup-send-stock-notifier .stock-notifier-productNAME").val(),
      productID = jQuery(".popup-send-stock-notifier .stock-notifier-productID").val();
    if (email === "") {
      jQuery(".popup-send-stock-notifier .stock-notifier-error").text('Email is required!');
      return false;
    }
    if(!lgs_checkemail(email)){
      jQuery(".popup-send-stock-notifier .stock-notifier-error").text('Please enter a valid email address.');
      return false;
    }
    jQuery(this).html("<span class='fas fa-spinner' aria-hidden='true'></span>").prop("disabled", true);
    var data 	= {
      'action' : 'lgs_add_stock_notifier',
      'email' :email,
      'productID': productID
    };
    jQuery.post(ajaxurl, data, function(response) {
      jQuery('.popup-send-stock-notifier .stock-notifier-form').hide();
      jQuery('.popup-send-stock-notifier .stock-notifier-message').show();
    });
    // if(typeof ga === 'function') {
      ga('send', 'event', 'back-in-stock-notification', 'submit', productNAME);
    // }
    return false;
  });


  //script for first trade and upgrade, ignore WL on checkout
  jQuery('body').on('ifChanged','.prc_product .prc_select input',function(){
    show_gaga_item_info();
  });

  jQuery('body').on('click','.product-item-trade-action .checkout-trade-choose',function(){
    var club = jQuery(this).closest('.product-items').data('club');
    show_step_select_trade(club, 'trade-choose', 0);
    return false;
  });

  jQuery('body').on('click','.product-item-trade-action .checkout-trade-confirm',function(){
    var parent = jQuery(this).closest('.product-items'),
      club = parent.data('club'),
      product_id = parent.find('.product-item-carousel .owl-item.active .product-item-list').data('product_id');
    show_step_select_trade(club, 'trade-confirm', product_id);
    var trade_past_collection = jQuery('input[name="trade-past-collection"]').val();
    if( trade_past_collection == 1 ){
      checkout_show_content_loading();
      lgs_trade_past_collection_confirm(club);
    }
    return false;
  });

  jQuery('body').on('translated.owl.carousel', '.product-item-contain .product-item-carousel', function() {
    var parent = jQuery(this).closest('.product-items'),
      club = parent.data('club');
    var slider = parent.find('.list-item .product-item.product-item-trade-list .owl-item.active .product-item-list').data('slider');
    Cookies.set('lg_trade_product_view_'+club, slider);
  });

  jQuery('body').on('click','.product-item-trade-action .checkout-trade-cancel',function(){
    var club = jQuery(this).closest('.product-items').data('club');
    show_step_select_trade(club, 'trade-cancel', 0);
    if( !jQuery(this).hasClass('checkout-trade-cancel-step2') ) {
      checkout_show_content_loading();
      lgs_trade_past_collection_cancel();
    }
    return false;
  });

  jQuery('body').on('click','.product-item-upgrade-action .checkout-upgrade-choose',function(){
    show_step_select_upgrade('upgrade-choose');
    return false;
  });

  jQuery('body').on('click','.product-item-upgrade-action .checkout-upgrade-plan',function(){
    checkout_show_content_loading();
    var data = {
      'action': 'lg_checkout_upgrade_membership',
      'type': 'upgrade_member',
      'product_id': jQuery(this).data('product_id')
    };
    jQuery.post(ajaxurl, data, function (response) {
      jQuery( 'body' ).trigger( 'update_checkout' );
    }, 'json');
    return false;
  });

  jQuery('body').on('click','.checkout-upgrade-cancel',function(){
    checkout_show_content_loading();
    Cookies.remove('free-selected');
    Cookies.remove('lg_trade_product_mm');
    Cookies.remove('lg_trade_product_km');
    Cookies.remove('lg_trade_product_sm');
    var data = {
      'action': 'lg_checkout_upgrade_membership',
      'type': 'upgrade_cancel'
    };
    jQuery.post(ajaxurl, data, function (response) {
      jQuery( 'body' ).trigger( 'update_checkout' );
    }, 'json');
    return false;
  });

  jQuery('body').on('click','.product-item-upgrade-action .upgrade-cancel',function(){
    show_step_select_upgrade('upgrade-cancel');
    return false;
  });

  function check_outofstock(variation){
    if (variation.is_in_stock) {
      jQuery('.woocommerce-variation-add-to-cart').removeClass('d-none');
      jQuery('.out-of-stock').addClass('d-none');
    } else {
      jQuery('.out-of-stock.d-none').removeClass('d-none');
      jQuery('.woocommerce-variation-add-to-cart').addClass('d-none');
    }
  }

  jQuery( 'form.variations_form' ).on( 'found_variation',
      function( event, variation ){
        check_outofstock(variation);

      jQuery(this).find('.quantity').removeClass('d-none');
        if(variation.variation_description !== ''){
          jQuery('.lg_product_short_description').fadeOut('100');
          jQuery('.lg_variable_short_description').html(variation.variation_description);
          jQuery('.lg_variable_short_description').fadeIn('200');
        }
        if(variation.price_html != ''){
          jQuery('.add-to-cart-action-price .price').remove();
          jQuery('.add-to-cart-action-price').append(variation.price_html);
        }
        if(variation.rating_row_html !== ''){
          jQuery('.variable-product-rating').html(variation.rating_row_html);
          jQuery('.single-product-rating').css('display','none');
          jQuery('.variable-product-rating').fadeIn('200');
        }
      jQuery('.add-to-cart-action-price').removeClass('lg-disabled-btn');
        jQuery('.add-to-cart-action-price .single_add_to_cart_button').data('variation_id', variation.variation_id);
      }
  );
  jQuery( 'form.variations_form' ).on( 'reset_data',
      function( event ){
        jQuery('.lg_product_short_description').fadeIn('200');
        jQuery('.lg_variable_short_description').fadeOut('100');
        jQuery('.variable-product-rating').css('display','none');
        jQuery('.single-product-rating').each(function(){
          if(!jQuery(this).hasClass('variable-product-rating')){
            jQuery(this).fadeIn('200');
          }
        });

    }
  );
  jQuery( 'form.variations_form' ).on( 'hide_variation',
    function(){
      jQuery(this).find('.quantity').addClass('d-none');
      jQuery('.add-to-cart-action-price').addClass('lg-disabled-btn');
      }
  );

  // Hide cart if user clicks anywhere off of the cart itself.
  $('body').on('click.hideCart', function(e) {
    // Check to see if the list is currently displayed.
    if (! $('cart_bag.cart_content').hasClass('d-none')) {
      // If element clicked on is NOT cart area, hide it.
      if (!$(e.target).parent().is('.cart_bag, .cart_content')) {
        $('.dropdown-content.cart_bag.cart_content').addClass('d-none'); // desktop
        if ($('.btn-cart-bag-menu-mobile').hasClass('is-active')) {
          $('a.btn-cart-bag-menu-mobile').click(); // mobile
          $('.overlay').remove();
        }
      }
    }
  });
});

function lgs_checkemail(email) {
  email = jQuery.trim(email);
  var regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
  return regex.test(email);
}

// Product Counters
(function($) {
  "use strict";
  (function() {
    window.inputNumber = function(el) {
      var els = {};
      els.dec = el.prev();
      els.inc = el.next();
      el.each(function() {
        init($(this));
      });
      function init(el) {
        el.prev().on('click', decrement);
        el.next().on('click', increment);
        el.on('change',el_change);

        el_change();
        function el_change() {
          var value = el[0].value,
            max = el[0].max,
            min = el[0].min;

          el.parent().find('.input-number-increment').fadeTo(0, 1);
          el.parent().find('.input-number-decrement').fadeTo(0, 1);

          if( max && value == max ){
            el.parent().find('.input-number-increment').fadeTo(0, 0);
          }

          if( min && value == min ){
            el.parent().find('.input-number-decrement').fadeTo(0, 0);
          }
        }

        function decrement() {
          var min = el[0].min || false;
          var value = el[0].value;
          value--;
          if(!min || value >= min) {
            el[0].value = value;
            el.change();
          }
          if( value == min ){
            //el.parent().find('.input-number-decrement').fadeTo(0, 0);
          }
        }
        function increment() {
          var max = el[0].max || false;
          var value = el[0].value;
          value++;
          if(!max || value <= max) {
            el[0].value = value;
            el.change();
          }
          if( value == max ){
            //el.parent().find('.input-number-increment').fadeTo(0, 0);
          }
        }
      }
    }
  })();
  inputNumber($('.qty'));
})(jQuery);


(function($) {
  "use strict";
  (function () {
    window.liveglam_test = function(e){
      console.log(e);
    }

    window.lgs_trade_past_collection_confirm = function(club){
      var data = {
        'action': 'lg_checkout_trade_past_collection',
        'type': 'remove_waitlist',
        'club': club
      };
      jQuery.post(ajaxurl, data, function (response) {
        jQuery( 'body' ).trigger( 'update_checkout' );
      }, 'json');
    }

    window.lgs_trade_past_collection_cancel = function(){
      var data = {
        'action': 'lg_checkout_trade_past_collection',
        'type': 'check_waitlist'
      };
      jQuery.post(ajaxurl, data, function (response) {
        jQuery('body').trigger('update_checkout');
      }, 'json');
    }

    window.show_gaga_item_info = function() {
      var options = [], free_selected = [];
      jQuery('.prc_product .prc_select input:checked').each(function () {
        options.push({
          product_id: jQuery(this).data('product_id'),
          title: jQuery(this).data('title'),
          subtitle: jQuery(this).data('subtitle'),
          subtitle_summary: jQuery(this).data('subtitle_summary'),
          description: jQuery(this).data('description'),
          image: jQuery(this).data('image')
        });
      });
      var output = '';
      if (options.length > 0) {
        for (var i = 0; i < options.length; i++) {
          free_selected.push(options[i].product_id);
          output = output + "<div class='product-item product-item-gaga'><div class='product-badge'><span>Free</span></div><div class='product-item-contain'><div class='item-content'><div class='item-info item-left'><img src='" + options[i].image + "'></div><div class='item-info item-right'><div class='info-content'><div class='info-content-tool'><p class='product-item-title short-title'>" + options[i].title + "</p><p class='product-item-desc'>" + options[i].subtitle_summary + "</p></div></div></div></div></div></div>";
        }
      }

      if(free_selected.length > 0){
        Cookies.set('free-selected', free_selected.join('-'));
      } else {
        Cookies.remove('free-selected');
      }
      jQuery('.product-items .list-item.product-gaga.data-checkout').html(output);
    }

    window.show_load_trade = function() {
      var first_time_load_trade = jQuery('input[name="lgs-first-time-load-trade"]').val(),
        product_id_mm = Cookies.get('lg_trade_product_mm'),
        product_id_km = Cookies.get('lg_trade_product_km'),
        product_id_sm = Cookies.get('lg_trade_product_sm');

      if(first_time_load_trade == 0){
        jQuery('input[name="lgs-first-time-load-trade"]').val(1);
      }

      //case load for MM
      if( typeof product_id_mm != 'undefined' ){
        show_load_trade_club('morpheme', product_id_mm, first_time_load_trade);
      } else {
        var product_id_mm = jQuery('input[name="trade-first-order-mm"]').val();
        if( product_id_mm != 0 && ( typeof product_id_mm != 'undefined' ) ){
          show_load_trade_club('morpheme', product_id_mm, first_time_load_trade);
        } else {
          show_load_trade_view('morpheme');
        }
      }

      //case load for KM
      if( typeof product_id_km != 'undefined' ){
        show_load_trade_club('kissme', product_id_km, first_time_load_trade);
      } else {
        var product_id_km = jQuery('input[name="trade-first-order-km"]').val();
        if( product_id_km != 0 && ( typeof product_id_km != 'undefined' ) ){
          show_load_trade_club('kissme', product_id_km, first_time_load_trade);
        } else {
          show_load_trade_view('kissme');
        }
      }

      //case load for SM
      if( typeof product_id_sm != 'undefined' ){
        show_load_trade_club('shadowme', product_id_sm, first_time_load_trade);
      } else {
        var product_id_sm = jQuery('input[name="trade-first-order-sm"]').val();
        if( product_id_sm != 0 && ( typeof product_id_sm != 'undefined' ) ){
          show_load_trade_club('shadowme', product_id_sm, first_time_load_trade);
        } else {
          show_load_trade_view('shadowme');
        }
      }
    }

    window.show_load_trade_club = function(club, product_id, first_time) {
      var current = jQuery('.product-items.'+club);
      if( current.find('.product-item-list[data-product_id="' + product_id + '"]').length < 1 ){
        show_step_select_trade(club, 'trade-cancel', product_id);
      } else {
        show_step_select_trade(club, 'trade-load', product_id);
        if(first_time == 0){
          lgs_trade_past_collection_confirm(0);
        }
      }
    }

    window.show_load_trade_view = function(club) {
      var current = jQuery('.product-items.'+club);
      var slider = Cookies.get('lg_trade_product_view_'+club);
      if( typeof slider != 'undefined' ){
        if( jQuery('.liveglam-show-product-items .product-items.'+club).length > 0 ) {
          show_step_select_trade(club, 'trade-choose', 0);
          setTimeout(function () {
            current.find('.product-item-contain .product-item-carousel').trigger('to.owl.carousel', slider);
          }, 300);
        }
      }
    }

    window.show_step_select_trade = function(club, step, product_id) {
      var current = jQuery('.product-items.'+club),
        key_club = (club == 'morpheme')?'mm':(club == 'kissme'?'km':(club == 'shadowme'?'sm':club));
      Cookies.remove('lg_trade_product_'+key_club);
      Cookies.remove('lg_trade_product_view_'+club);
      jQuery('input[name="trade-first-order-'+key_club+'"]').val(product_id);

      //option show/hide notice on checkout
      var fst_mm_extend = jQuery('input[name="lgs-list-extend-trade-mm"]').val().split(',');
      var fst_km_extend = jQuery('input[name="lgs-list-extend-trade-km"]').val().split(',');
      var fst_sm_extend = jQuery('input[name="lgs-list-extend-trade-sm"]').val().split(',');
      // var club = jQuery('.product-items').data('club');

      if( fst_mm_extend.length > 0 || fst_km_extend.length > 0 || fst_sm_extend.length > 0 ){
        var productID = '' + product_id; //convert type number to string before check
        if( jQuery.inArray(productID, fst_mm_extend) != -1 || jQuery.inArray(productID, fst_km_extend) != -1 || jQuery.inArray(productID, fst_sm_extend) != -1 ){
          jQuery('.sale-promo-notice').closest('div.woocommerce-info').show();
        } else {
          jQuery('.sale-promo-notice').closest('div.woocommerce-info').hide();
        }
      }

      current.find('.product-item.product-item-trade-confirm .product-item-contain').empty();
      if( step == 'trade-cancel' ){
        current.find('.trade-item-checked').hide();
        current.find('.list-item .product-item.product-item-trade-list').slideUp();
        current.find('.list-item .product-item.product-item-trade-confirm').slideUp();
        current.find('.list-item .product-item.product-item-subscription').slideDown();
        current.find('.title-item-subscription').show();
        current.find('.title-item-trade-list').hide();
        current.find('.title-item-trade-confirm').hide();
      } else if( step == 'trade-choose' ){
        current.find('.trade-item-checked').show();
        current.find('.list-item .product-item.product-item-subscription').slideUp();
        current.find('.list-item .product-item.product-item-trade-list').slideDown();
        current.find('.title-item-subscription').hide();
        current.find('.title-item-trade-list').show();
        current.find('.title-item-trade-confirm').hide();
        if( current.find('.list-item .product-item.product-item-trade-list .owl-item.active').length > 0 ){
          var slider = current.find('.list-item .product-item.product-item-trade-list .owl-item.active .product-item-list').data('slider');
        } else {
          var slider = 0;
        }
        Cookies.set('lg_trade_product_view_'+club, slider);
      } else {
        if (step == 'trade-confirm') {
          current.find('.trade-item-checked').hide();
          current.find('.list-item .product-item.product-item-trade-list').slideUp();
          current.find('.list-item .product-item.product-item-trade-confirm').slideDown();
          current.find('.title-item-subscription').hide();
          current.find('.title-item-trade-list').hide();
          current.find('.title-item-trade-confirm').show();
          //do not trigger update checkout to avoid session update multiple for case trade to ignore WL
          if( typeof jQuery('input[name="trade-past-collection"]').val() == 'undefined' ) {
            jQuery('body').trigger('update_checkout');
          }
        } else if (step == 'trade-load') {
          current.find('.list-item .product-item.product-item-subscription').slideUp();
          current.find('.list-item .product-item.product-item-trade-confirm').slideDown();
          current.find('.title-item-subscription').hide();
          current.find('.title-item-trade-list').hide();
          current.find('.title-item-trade-confirm').show();
        }
        current.find('.product-item-list[data-product_id="' + product_id + '"]').clone().prependTo('.product-item.product-item-trade-confirm .product-item-contain');
        Cookies.set('lg_trade_product_'+key_club, product_id);
      }
    }

    window.show_step_select_upgrade = function(step) {
      if( step == 'upgrade-cancel' ){
        jQuery('.trade-item-checked').hide();
        jQuery('.list-item .product-item.product-item-upgrade-options').slideUp();
        jQuery('.list-item .product-item.product-item-subscription').slideDown();
      } else if( step == 'upgrade-choose' ){
        jQuery('.list-item .product-item.product-item-subscription').slideUp();
        jQuery('.list-item .product-item.product-item-upgrade-options').slideDown();
      }
    }

    window.checkout_show_content_loading = function () {
      jQuery('.liveglam-show-product-items .product-items').addClass('ck-content-loading');
      jQuery('.liveglam-show-option-notices .liveglam-notice-wrapper').addClass('ck-content-loading');
    }

    window.checked_gaga_item = function() {
      var free_selected = Cookies.get('free-selected');
      if( typeof free_selected != 'undefined' && free_selected != '' ){
        Cookies.remove('free-selected');
        free_selected = free_selected.split('-');
        if (free_selected.length > 0) {
          for (var i = 0; i < free_selected.length; i++) {
            jQuery('.prc_product .prc_select input[data-product_id="'+free_selected[i]+'"]').prop('checked',true);
          }
        }
        jQuery('.prc_product .prc_select input').iCheck('update').trigger('ifChanged');
        show_gaga_item_info();
      } else {
        // #1090 Remove default check mark from GAGA
        /*var gaga = jQuery('.prc_product .prc_select input[type="radio"]');
         if (gaga.length > 0) {
         var first_check = 0;
         gaga.each(function () {
         if (first_check == 0) {
         jQuery(this).prop('checked', true).iCheck('update').trigger('ifChanged');
         first_check++;
         }
         });
         show_gaga_item_info();
         }*/
      }
    }

  })();

})(jQuery);