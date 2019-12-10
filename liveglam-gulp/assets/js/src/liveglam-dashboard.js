jQuery(document).ready(function(){

  /* script show first, share */
  var show_first = jQuery('input.show_first').val(),
      show_club =jQuery('input.show_club').val(),
      show_club_nav =jQuery('input.show_club_nav').val(),
      show_first_share = jQuery('input.show_first_share').val(),
      check_hash = window.location.hash;

  if (check_hash === '#morpheme-subscription') {
    show_club = show_first = show_first_share = 'morpheme';
  }
  if (check_hash === '#kissme-subscription') {
    show_club = show_first = show_first_share = 'kissme';
  }
  if (check_hash === '#shadowme-subscription') {
    show_club = show_first = show_first_share = 'shadowme';
  }

  function clear_url() {
    history.pushState("", document.title, window.location.pathname);
  }

  jQuery(window).load(function () {
    if(show_club !== ''){
      if(jQuery('.lgs-data-club.lgs-data-'+show_club).is(':visible')) {
        lgs_scroll_to_element(jQuery('.lgs-data-club.lgs-data-' + show_club));
      }
      if(jQuery('.liveglam-orders-content.tab-'+show_club).is(':visible')) {
        lgs_scroll_to_element(jQuery('.liveglam-orders-content.tab-'+show_club));
      }
      clear_url();
        jQuery('.lgs-action-collap.' + show_club + '-collap.collap-show:visible').click();

        if(show_club_nav !== ''){
          jQuery('.liveglam-orders-content.tab-'+show_club+' #'+show_club_nav).click();
        }
    } else {
        jQuery('.lgs-action-collap.' + show_first + '-collap.collap-show:visible').click();
        if(show_club_nav !== ''){
            jQuery('.liveglam-orders-content.tab-'+show_first+' #'+show_club_nav).click();
        }
    }

    jQuery('select.filter-options').val(show_first_share).change();
  });
  /* script show first, share */

  var old_account_details = [];
  jQuery('form.edit-account input[type!="hidden"]').each(function () {
    old_account_details[jQuery(this).attr('name')] = jQuery(this).val();
  });
  old_account_details['user_billing_phone'] = user_billing_phone;

  function check_validate(formid) {
    var check_input = false,compare=0;
    if(jQuery('#'+formid).hasClass('edit-account')){
      jQuery('form.edit-account input[type!="hidden"]').each(function () {
        if(!jQuery(this).hasClass('ErrorField') && old_account_details[jQuery(this).attr('name')] != jQuery(this).val() ){
          check_input = true;
        }
      });
    }

    if (check_input) {
      jQuery('form.edit-account .lg-edit-button-profile').removeClass('lg_vadilate_pay');
    } else {
      jQuery('form.edit-account .lg-edit-button-profile').addClass('lg_vadilate_pay');
    }
  }

  /*script change billing, shipping address*/
  jQuery('button.save_address').click(function () {
    var current = jQuery(this),
        type = current.data('type'),
        element = current.data('product'),
        subscription_id = jQuery('#update_subscription_address').val();
    current.html('<i class="fas fa-circle-notch fa-spin fa-lg fa-fw"></i> Updating ...').addClass('ch_background').prop("disabled", true);

    var data_address = {
      'action': 'lg_action_update_address',
      'type': type,
      'subscription_id': subscription_id,
      'country': jQuery('.dashboard-setting-' + element + ' .liveglam-setting #shipping_country option:selected').val(),
      'state': jQuery('.dashboard-setting-' + element + ' .liveglam-setting #shipping_state option:selected').val() ? jQuery('.dashboard-setting-' + element + ' .liveglam-setting #shipping_state option:selected').val() : jQuery('.dashboard-setting-' + element + ' .liveglam-setting #shipping_state').val(),
      'address_1': jQuery('.dashboard-setting-' + element + ' .liveglam-setting #shipping_address_1').val(),
      'address_2': jQuery('.dashboard-setting-' + element + ' .liveglam-setting #shipping_address_2').val(),
      'city': jQuery('.dashboard-setting-' + element + ' .liveglam-setting #shipping_city').val(),
      'postcode': jQuery('.dashboard-setting-' + element + ' .liveglam-setting #shipping_postcode').val(),
      'first_name': jQuery('.dashboard-setting-' + element + ' .liveglam-setting #shipping_first_name').val(),
      'last_name': jQuery('.dashboard-setting-' + element + ' .liveglam-setting #shipping_last_name').val(),
      'update_all_subs': jQuery('.dashboard-setting-' + element + ' .liveglam-setting input.shipping_all_subscriptions').is(':checked') ? 1 : 0
    };

    jQuery('#tab-billing-address').find('.lg-change-billing-address-notice').removeClass('woocommerce-error woocommerce-message');
    jQuery.post(ajaxurl, data_address, function (response) {
      current.closest('.liveglam-setting').find('.lg-change-address-notice').removeClass('woocommerce-error woocommerce-message').addClass(response.class);
      current.closest('.liveglam-setting').find('.lg-change-address-notice').html('<li>' + response.message + '</li>');
      current.text('Save My ' + type + ' Details').removeClass('ch_background').prop("disabled", false);
      if (response.class == 'woocommerce-message') jQuery('input[name="check-reload-page"]').val('1');

      jQuery('html, body').animate({scrollTop: 0}, 'slow');
    }, 'json');

    return false;

  });

  jQuery('body').on('click', '.view_order', function () {
    var data_type = jQuery(this).data('type');

    jQuery('.dashboard-myaccount').fadeOut(1000);
    jQuery('.dashboard-setting.view-order-' + data_type).fadeIn(1000);

    change_zindex('1000');
    jQuery('html, body').animate({scrollTop: 0}, 1000);
    return false;
  });

  jQuery('body').on('click', '.show-redeem-order', function () {

    if(jQuery('.order-history-list.shop-history').data('show') == 0){
      jQuery('.order-history-list.shop-history').data('show',1);
      var data = {
        'action': 'lgs_ajax_load_redeem_orders'
      };
      jQuery.post(ajaxurl,data,function (response) {
        if(response.status == 'success'){
          jQuery('.order-history-list.shop-history').html(response.return);
        }
      },'json');
    }

    jQuery('.dashboard-myaccount').fadeOut(1000);
    jQuery('.dashboard-setting.view-order-shop').fadeIn(1000);

    change_zindex('1000');
    jQuery('html, body').animate({scrollTop: 0}, 1000);
    return false;
  });

  jQuery('body').on('click', '.view-order-details', function () {
    var current = jQuery(this).closest('.dashboard-content'),
        data_title = jQuery(this).data('title'),
        data_type = jQuery(this).data('type'),
        order_id = jQuery(this).data('order-id'),
        subscription_id = jQuery(this).data('subscription-id');

    current.find('.view-detail-order .title-header-center p').text(data_title);
    current.find('.liveglam-orders-history').addClass('blockUI blockOverlay wc-updating');

    var data = {
      'action': 'lg_show_order_details',
      'order_id': order_id,
      'subscription_id': subscription_id,
      'order_type': data_type
    };
    jQuery.post(ajaxurl,data,function (response) {
      current.find('.liveglam-orders-history').removeClass('blockUI blockOverlay wc-updating');
      if( response.order_details != '' ) {
        jQuery('.view-order-' + data_type + ' .liveglam-orders-history .order-history-details').html(response.order_details);
        current.find('.view-all-order').addClass('d-none');
        current.find('.view-detail-order').removeClass('d-none');
        current.find('.liveglam-orders-history .order-history-list').hide();
        current.find('.liveglam-orders-history .order-history-details').show();
      }
    },'json');

    return false;
  });

  jQuery('body').on('click', '.close-order-details', function () {
    var current = jQuery(this).closest('.dashboard-content');
    current.find('.view-all-order').removeClass('d-none');
    current.find('.view-detail-order').addClass('d-none');
    current.find('.liveglam-orders-history .order-history-list').show();
    current.find('.liveglam-orders-history .order-history-details').hide();
    return false;
  });

  jQuery('body').on('click', '.edit_billing, .edit_schedule, .edit_payment', function () {
    var data_edit = jQuery(this).data('edit'),
        data_type = jQuery(this).data('type'),
        affiliate_link = jQuery('input.affiliate_link.' + data_type).val();
    jQuery('.affiliate_link.blog_article').attr('href', affiliate_link);
    jQuery('#update_subscription_address').val(jQuery(this).data('id'));
    // @TODO: remove comment here
    jQuery('.dashboard-myaccount').fadeOut(1000);
    jQuery('.dashboard-setting.dashboard-setting-' + data_type).fadeIn(1000);
    //move form change shipping
    jQuery('#lg-change-shipping-content').prependTo('#tab-shipping-' + data_type + ' .lg-change-shipping');
    jQuery('.save_address.shipping').attr('data-product', data_type);
    //move form change billing
    jQuery('#change-payment-methods').prependTo('#tab-billing-' + data_type + ' .lg-change-payment');
    jQuery('.save-new-card').attr('data-product', data_type);
    jQuery('.save-new-card').attr('data-type', data_edit);
    jQuery('a[href="#tab-' + data_edit + '-' + data_type + '"]').click();
    update_value_address(data_type);
    set_form_change_next_payment(data_type);
    change_zindex('1000');
    jQuery('html, body').animate({scrollTop: 0}, 1000);
    return false;
  });

  function update_value_address(element) {
    //update billing address to form
    jQuery('.dashboard-setting-' + element + ' .liveglam-setting #billing_country option').removeAttr('selected');
    jQuery('.dashboard-setting-' + element + ' .liveglam-setting #billing_state option').removeAttr('selected');
    jQuery('.dashboard-setting-' + element + ' .liveglam-setting #billing_address_1').val(jQuery('.' + element + '-billing-address_1').val());
    jQuery('.dashboard-setting-' + element + ' .liveglam-setting #billing_address_2').val(jQuery('.' + element + '-billing-address_2').val());
    jQuery('.dashboard-setting-' + element + ' .liveglam-setting #billing_city').val(jQuery('.' + element + '-billing-city').val());
    jQuery('.dashboard-setting-' + element + ' .liveglam-setting #billing_postcode').val(jQuery('.' + element + '-billing-postcode').val());
    jQuery('.dashboard-setting-' + element + ' .liveglam-setting #billing_country').val(jQuery('.' + element + '-billing-country').val()).trigger('change');
    jQuery('.dashboard-setting-' + element + ' .liveglam-setting #billing_state').val(jQuery('.' + element + '-billing-state').val()).trigger('change');
    jQuery('.dashboard-setting-' + element + ' .liveglam-setting #billing_email').val(jQuery('.' + element + '-billing-email').val());
    jQuery('.dashboard-setting-' + element + ' .liveglam-setting #billing_phone').val(jQuery('.' + element + '-billing-phone').val());
    //update shipping address to form
    jQuery('.dashboard-setting-' + element + ' .liveglam-setting #shipping_country option').removeAttr('selected');
    jQuery('.dashboard-setting-' + element + ' .liveglam-setting #shipping_state option').removeAttr('selected');
    jQuery('.dashboard-setting-' + element + ' .liveglam-setting #shipping_address_1').val(jQuery('.' + element + '-shipping-address_1').val());
    jQuery('.dashboard-setting-' + element + ' .liveglam-setting #shipping_address_2').val(jQuery('.' + element + '-shipping-address_2').val());
    jQuery('.dashboard-setting-' + element + ' .liveglam-setting #shipping_city').val(jQuery('.' + element + '-shipping-city').val());
    jQuery('.dashboard-setting-' + element + ' .liveglam-setting #shipping_postcode').val(jQuery('.' + element + '-shipping-postcode').val());
    jQuery('.dashboard-setting-' + element + ' .liveglam-setting #shipping_country').val(jQuery('.' + element + '-shipping-country').val()).trigger('change');
    jQuery('.dashboard-setting-' + element + ' .liveglam-setting #shipping_state').val(jQuery('.' + element + '-shipping-state').val()).trigger('change');
  }

  jQuery('body').on('click', '.edit_shipping', function () {
    jQuery('.dashboard-myaccount').fadeOut(1000);
    jQuery('.dashboard-setting.dashboard-setting-account').fadeIn(1000);
    jQuery('a[href="#tab-address-book"]').click();
    show_address_book();
    change_zindex('1000');
    return false;
  });
  /*end script change billing, shipping address*/

  /* script change next payment date */
  function set_form_change_next_payment(type) {

    var month = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
    var subID = jQuery('.subscriptionID.' + type).val(),
        next_payment = jQuery('.next_payment.' + type).val();

    var save_next_payment = new Date(next_payment),
        save_date = save_next_payment.getDate(),
        save_month = save_next_payment.getMonth(),
        save_year = save_next_payment.getFullYear();

    var next_payment = new Date(next_payment),
        next_payment_date = next_payment.getDate(),
        next_payment_month = next_payment.getMonth()+1;

    jQuery('.subs-option.subs-option-next').css('display', 'none');
    jQuery('.date-in-month.disabled').removeClass('disabled');
    jQuery('.date-in-month.active').removeClass('active');

    jQuery('.billing-current-date').text(save_date);
    jQuery('.billing-current-month').text(month[save_month]);
    jQuery('.billing-current-year').text(save_year);

    jQuery('#form-schedule-subscriptionID').val(subID);
    jQuery('#form-schedule-new_date').val('');
    jQuery('#form-schedule-new_month').val('');
    jQuery('#form-schedule-new_year').val('');

    jQuery('p.date-options.select-date .date-in-month[data-date="' + next_payment_date + '"][data-month="'+next_payment_month+'"]').addClass('disabled');
    jQuery('p.date-options.select-month .date-in-month[data-month="'+next_payment_month+'"]').addClass('active');
    show_date_option_by_month(next_payment_month);
    /* choose date in month */
    jQuery('body').on('click', '.date-in-month', function () {
      var current = jQuery(this);
      if (current.hasClass('disabled')) return false;
      current.closest('p.date-options').find('.date-in-month.active').removeClass('active');
      current.addClass('active');

      var new_date = jQuery(this).data('date'),
          new_month = jQuery(this).data('month'),
          new_year = jQuery(this).data('year');

      if(current.hasClass('pick-month')){
        show_date_option_by_month(new_month);
      } else {
        current.closest('.lg-change-schedule').find('.billing-next-date').text(new_date);
        current.closest('.lg-change-schedule').find('.billing-next-month').text(month[new_month - 1]);
        current.closest('.lg-change-schedule').find('.billing-next-year').text(new_year);
        current.closest('.lg-change-schedule').find('.subs-option.subs-option-next').css('display', 'block');
        jQuery('#form-schedule-new_date').val(new_date);
        jQuery('#form-schedule-new_month').val(new_month);
        jQuery('#form-schedule-new_year').val(new_year);
      }
      return false;
    });

    function show_date_option_by_month(month) {
      jQuery('p.date-options.select-date .date-in-month[data-month!="'+month+'"]').addClass('d-none');
      jQuery('p.date-options.select-date .date-in-month[data-month="'+month+'"]').removeClass('d-none');
    }

    /* submit change next-payemnt */
    jQuery('body').on('click', 'button.change_next_payment', function () {
      if (jQuery('#form-schedule-new_date').val() == '') return false;
      if (jQuery('#form-schedule-new_month').val() == '') return false;
      if (jQuery('#form-schedule-new_year').val() == '') return false;
      jQuery(this).html('<i class="fas fa-circle-notch fa-spin fa-lg fa-fw"></i> Please Wait...').prop("disabled", true);
      var data = {
        'action': 'lgs_change_next_payment_date',
        'subscriptionID': jQuery('#form-schedule-subscriptionID').val(),
        'new_date': jQuery('#form-schedule-new_date').val(),
        'new_month': jQuery('#form-schedule-new_month').val(),
        'new_year': jQuery('#form-schedule-new_year').val(),
      };
      jQuery.post(ajaxurl, data, function (response) {
        if (response.status == 'success') {
          jQuery('.dashboard-myaccount').fadeIn(1000);
          jQuery('.dashboard-setting').fadeOut(1000);
          change_zindex('0');
          jQuery.magnificPopup.open({
            items: {src: response.return},
            type: "inline",
            closeOnContentClick: false,
            closeOnBgClick: false,
            showCloseBtn: false
          });
        } else {
          location.reload();
        }
      }, 'json');
    });
  }
  /* end script change next payment date */

  /*script edit account*/
  jQuery("#first_name").lgvalidate({
    expression: "if (VAL) return true; else return false;",
    message: "Please enter the Required field"
  });
  jQuery("#last_name").lgvalidate({
    expression: "if (VAL) return true; else return false;",
    message: "Please enter the Required field"
  });
  jQuery("#account_email").lgvalidate({
    expression: "if (!VAL.match(/.con$/) && VAL.match(/^[a-zA-Z0-9\\_\\-\\.\\+]/)) return true; else return false;",
    message: "Should be a valid Email id"
  });
  jQuery("#account_email").lgvalidate({
    expression: "if (!VAL.match(/.con$/) && VAL.match(/^[a-zA-Z0-9\\_\\-\\.\\+]*\\@/)) return true; else return false;",
    message: "You are missing @ in entered email"
  });
  jQuery("#account_email").lgvalidate({
    expression: "if (!VAL.match(/.con$/) && VAL.match(/^[a-zA-Z0-9\\_\\-\\.\\+]*\\@[a-zA-Z0-9_]*\\./) ) return true; else return false;",
    message: "You are missing . in entered email"
  });
  jQuery("#account_email").lgvalidate({
    expression: "if (!VAL.match(/.con$/) && VAL.match(/^[a-zA-Z0-9\\_\\-\\.\\+]*\\@[a-zA-Z0-9_]+(\\.[a-zA-Z0-9_]+)*\\.[a-zA-Z]{2,4}$/) ) return true; else return false;",
    message: "You are missing domain in entered email</br>example: Johndoe@gmail.com"
  });
  jQuery('form.edit-account input#user_billing_phone,#first_name,#last_name,#account_birthday,#account_email').on('focus keypress click change keyup blur',function(){

    var FormID = jQuery(this).parents('form:first').attr("id");
    setTimeout(function(){check_validate(FormID);},500);
  });

  jQuery('body').on('keyup change','form.edit-password #password_old, form.edit-password #password_1', function () {
    lgs_validate_change_pw();
  });

  jQuery('body').on('keyup change','form.edit-password #password_2', function () {
    var password_1 = jQuery('form.edit-password input#password_1').val(),
        password_2 = jQuery('form.edit-password input#password_2').val(),
        current_element = jQuery('form.edit-password #password_2').closest('p');

    if( password_1 != password_2 && password_2 ){
      current_element.addClass('woocommerce-invalid woocommerce-invalid-required-field');
      current_element.find('input').addClass('ErrorField');
      current_element.find('#password_2-error').remove();
      current_element.append('<label id="password_2-error" class="error" for="password_2">Please enter the same password as above</label>');
    } else {
      current_element.removeClass('woocommerce-invalid woocommerce-invalid-required-field');
      current_element.find('input').removeClass('ErrorField');
      current_element.find('#password_2-error').remove();
    }
    lgs_validate_change_pw();
  });

  function lgs_validate_change_pw() {
    var password_old = jQuery('form.edit-password input#password_old').val(),
        password_1 = jQuery('form.edit-password input#password_1').val(),
        password_2 = jQuery('form.edit-password input#password_2').val();
    var password_strong = 0;
    if( jQuery('form.edit-password .woocommerce-password-strength').hasClass('good') || jQuery('form.edit-password .woocommerce-password-strength').hasClass('strong') ){
      password_strong = 1;
    }
    if (password_old && password_1 && password_2 && password_1 == password_2 && password_strong == 1) {
      jQuery('form.edit-password .lg-edit-button-profile').removeClass('lg_vadilate_pay');
    } else {
      jQuery('form.edit-password .lg-edit-button-profile').addClass('lg_vadilate_pay');
    }
  }

  jQuery('form.edit-account').on('submit', function () {

    var first_name = jQuery('form.edit-account input#first_name').val(),
        last_name = jQuery('form.edit-account input#last_name').val(),
        account_email = jQuery('form.edit-account input#account_email').val(),
        account_birthday = jQuery('form.edit-account input#account_birthday').val(),
        account_phone = jQuery('form.edit-account input#user_billing_phone').val(),
        checkUpdateDOB = 'no';
    if (jQuery('form.edit-account input#account_birthday').hasClass('account_birthday_datepicker')) {
      checkUpdateDOB = 'yes';
    }
    if (first_name && last_name && account_email) {
      jQuery('form.edit-account').find('.save_account.lg-edit-button-profile').html('<i class="fas fa-circle-notch fa-spin fa-lg fa-fw"></i> Updating ...').addClass('ch_background').prop("disabled", true);

      var data = {
        'action': 'lg_action_update_account',
        'first_name': first_name,
        'last_name': last_name,
        'account_email': account_email,
        'account_birthday': account_birthday,
        'account_phone': account_phone,
        'checkUpdateDOB': checkUpdateDOB
      };
      jQuery.post(ajaxurl, data, function (response) {
        jQuery('.lg-change-account-notice').removeClass('woocommerce-error woocommerce-message').addClass(response.class);
        jQuery('.lg-change-account-notice').text(response.message);
        if (response.class == 'woocommerce-message') jQuery('input[name="check-reload-page"]').val('1');
        if(response.class == 'woocommerce-message'){
          jQuery('form.edit-account input[type!="hidden"]').each(function () {
            old_account_details[jQuery(this).attr('name')] = jQuery(this).val();
          });
          var FormID = jQuery('form.edit-account').attr("id");
          setTimeout(function(){check_validate(FormID);},500);
        }

        jQuery('form.edit-account').find('.save_account.lg-edit-button-profile').text('Update Settings').removeClass('ch_background').prop("disabled", false);
      }, 'json');
    }
    return false;
  });

  jQuery('form.edit-password').on('submit', function () {
    var password_old = jQuery('form.edit-password input#password_old').val(),
        password_new1 = jQuery('form.edit-password input#password_1').val(),
        password_new2 = jQuery('form.edit-password input#password_2').val();
    if (password_old && password_new1 && password_new2) {
      jQuery('form.edit-password').find('.save_password.lg-edit-button-profile').html('<i class="fas fa-circle-notch fa-spin fa-lg fa-fw"></i> Updating ...').addClass('ch_background').prop("disabled", true);

      var data = {
        'action': 'lg_action_update_password',
        'password_old': password_old,
        'password_new1': password_new1,
        'password_new2': password_new2
      };
      jQuery.post(ajaxurl, data, function (response) {
        jQuery('.lg-change-password-notice').removeClass('woocommerce-error woocommerce-message').addClass(response.class).text(response.message);
        jQuery('form.edit-password input#password_old').val('');
        jQuery('form.edit-password input#password_1').val('');
        jQuery('form.edit-password input#password_2').val('');
        setTimeout(function () {
          jQuery('.lg-change-password-notice').removeClass('woocommerce-error woocommerce-message').text('');
        },10000);
        jQuery('form.edit-password').find('.save_password.lg-edit-button-profile').text('Update Password').removeClass('ch_background').prop("disabled", false);
      }, 'json');
    }
    return false;
  });
  /*end script edit account*/

  jQuery('input.billing_all_subscriptions, input.shipping_all_subscriptions').iCheck({checkboxClass: 'icheckbox_square-green'});
  jQuery('input.billing_all_subscriptions, input.shipping_all_subscriptions').iCheck('uncheck');
  jQuery('input.billing_all_subscriptions, input.shipping_all_subscriptions').removeAttr('checked');
  jQuery(".nicescroll").niceScroll({cursorborder: "", cursorcolor: "#cccccc", touchbehavior: true}).resize();

  jQuery('body').on('click', '.view-announcement', function () {
    jQuery(this).closest('.comment').addClass('d-none');
    if (jQuery(this).hasClass('content')) {
      jQuery(this).closest('li').find('.description').removeClass('d-none');
    }
    if (jQuery(this).hasClass('description')) {
      jQuery(this).closest('li').find('.content').removeClass('d-none');
    }
    jQuery(".nicescroll").niceScroll({cursorborder: "", cursorcolor: "#cccccc", touchbehavior: true}).resize();
    return false;
  });

  jQuery('body').on('click', '.dashboard-setting .close-setting', function () {
    var show = check_show_save_subscription_address();
    if( show.length >= 1 ){
      show_popup_exit_without_saving(1);
      jQuery('.btn-close-popup-save-address').addClass('action_close_setting');
      return false;
    }

    if (jQuery('input[name="check-reload-page"]').val() == 1) {
      window.location.href =  window.location.href.split("#")[0];
    } else {
      jQuery('.dashboard-myaccount').fadeIn(1000);
      jQuery('.dashboard-setting').fadeOut(1000);
      change_zindex('0');
    }
    return false;
  });

  jQuery('body').on('click', '.setting-myaccount-2', function () {
    edit_profile_open();
    return false;
  });

  function edit_profile_open(){
    jQuery('.close-jPushMenu').click();
    jQuery('.dashboard-myaccount').fadeOut(1000);
    jQuery('.dashboard-setting.dashboard-setting-account').fadeIn(1000);
    show_address_book();
    change_zindex('1000');
  }

  function change_zindex(num) {
    if(num == 0){
      jQuery('.dashboard-menu-list .dbml-item.active2').addClass('active');
    } else {
      jQuery('.dashboard-menu-list .dbml-item.active').removeClass('active').addClass('active2');
    }
    jQuery('.wc-dashboard-content').css('z-index', num);
  }

  jQuery('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
    jQuery(document.body).trigger('country_to_state_changed');
  });

  /* script dob */
  jQuery('.account_birthday_datepicker').datepicker({
    changeMonth: true,
    changeYear: true,
    dateFormat: "M dd, yy",
    numberOfMonths: 1,
    showButtonPanel: true,
    showOn: "focus",
    buttonImageOnly: true,
    autoSize: true,
    defaultDate: "Jan 01, 2003",
    yearRange: "-85:-14",
  });
  /* end script dob */

  /* add script for address book */
  jQuery('body').on('click','.wc-address-book-delete-open-popup',function () {
    var current = jQuery(this),
        name = current.attr('id'),
        show = check_show_save_subscription_address();

    if(current.hasClass('address-show-message')){
      jQuery.magnificPopup.open({
        items: {src: '#confirm-delete-book-address-message'},
        type: 'inline',
        closeOnContentClick: false,
        closeOnBgClick: false,
        showCloseBtn: false
      });
    } else if( show.length >= 1 ){
      show_popup_exit_without_saving(1);
      jQuery('.btn-close-popup-save-address').addClass('action_delete_book_address').data('option',name);
    } else {
      show_address_book_delete(name);
    }
    return false;
  });

  jQuery('body').on('click','#confirm-delete-book-address .submit-delete',function () {
    var current = jQuery(this),
        name = current.attr('id');
    jQuery.magnificPopup.close();

    var data = {
      'action': 'lg_action_address_book_delete',
      'name': name,
      'subMM_id': jQuery('.subscriptionID.morpheme').val(),
      'subKM_id': jQuery('.subscriptionID.kissme').val(),
      'subSM_id': jQuery('.subscriptionID.shadowme').val(),
    };
    jQuery('.wc-address-book-delete-open-popup#'+name).closest( '.wc-address-book-address' ).addClass('blockUI blockOverlay wc-updating');
    jQuery.post(ajaxurl,data,function (response) {
      lg_update_display_address_book(response.list_address_book, response.list_address_subscription)
    },'json');

    show_form_add_address_book(0);
    show_dashboar_header_setting(0);
    return false;
  });

  jQuery('body').on('click','.address_book .wc-address-book-make-primary-lg', function() {
    var name = jQuery(this).attr('id'),
        show = check_show_save_subscription_address();
    if( show.length >= 1 ){
      show_popup_exit_without_saving(1);
      jQuery('.btn-close-popup-save-address').addClass('action_make_primary_book_address').data('option',name);
    } else {
      show_address_book_make_primary(name);
    }
  });

  jQuery('body').on('click','.address_book_save',function () {
    var current = jQuery(this),
        text_before = 'Add New Shipping Address',
        text_after = 'Adding',
        check_edit_address = jQuery('#tab-address-book #lg-address-book #shipping_address-book-edit').val(),
        list_subs = [];

    if(check_edit_address != ''){
      text_before = 'Update Shipping Address',
          text_after = 'Updating';
      var list = jQuery('.list-use-for-subscription.'+check_edit_address).val();
      if(typeof list !== "undefined" ){
        list_subs = list.split(',');
      }
    }

    current.text(text_after).addClass('ch_background').prop("disabled", true);

    if( list_subs.length > 0){
      jQuery('input[name="check-reload-page"]').val('1');
    }

    var data_address = {
      'action': 'lg_action_address_book_update',
      'country': jQuery('#tab-address-book #lg-address-book #shipping_country option:selected').val(),
      'state': jQuery('#tab-address-book #lg-address-book #shipping_state option:selected').val() ? jQuery('#tab-address-book #lg-address-book #shipping_state option:selected').val() : jQuery('#tab-address-book #lg-address-book #shipping_state').val(),
      'first_name': jQuery('#tab-address-book #lg-address-book #shipping_first_name').val(),
      'last_name': jQuery('#tab-address-book #lg-address-book #shipping_last_name').val(),
      'address_1': jQuery('#tab-address-book #lg-address-book #shipping_address_1').val(),
      'address_2': jQuery('#tab-address-book #lg-address-book #shipping_address_2').val(),
      'city': jQuery('#tab-address-book #lg-address-book #shipping_city').val(),
      'postcode': jQuery('#tab-address-book #lg-address-book #shipping_postcode').val(),
      'book_name': jQuery('#tab-address-book #lg-address-book #shipping_book_name').val(),
      'book_edit': jQuery('#tab-address-book #lg-address-book #shipping_address-book-edit').val(),
      'subMM_id': jQuery('.subscriptionID.morpheme').val(),
      'subKM_id': jQuery('.subscriptionID.kissme').val(),
      'subSM_id': jQuery('.subscriptionID.shadowme').val(),
      'list_subs': list_subs
    };

    jQuery.post(ajaxurl, data_address, function (response) {

      show_address_book_message(response.class,response.message);

      lg_update_display_address_book(response.list_address_book, response.list_address_subscription);
      current.text(text_before).removeClass('ch_background').prop("disabled", false);

    }, 'json');

    return false;
  });

  jQuery('body').on('click','.wc-address-book-edit',function () {
    var name = jQuery(this).attr('id'),
        show = check_show_save_subscription_address();
    if( show.length >= 1 ){
      show_popup_exit_without_saving(1);
      jQuery('.btn-close-popup-save-address').addClass('action_edit_book_address').data('option',name);
    } else {
      show_address_book_edit(name);
    }
    return false;
  });

  jQuery('body').on('click','.address_book_reset, .edit-subscription-address',function () {
    show_form_add_address_book(0);
    show_dashboar_header_setting(0);
    jQuery('.address_book_save').text('Add New Shipping Address');
    load_address_book('','','','','','','','','','');
    jQuery('html, body').animate({scrollTop: jQuery(".address_book_subscription").offset().top}, 1000);
    return false;
  });

  jQuery('body').on('click','.dashboard-setting-account #accordion-setting .nav-tabs a', function(){
    var show = check_show_save_subscription_address(),
        href = jQuery(this).attr('href');
    if( show.length >= 1 ){
      show_popup_exit_without_saving(1);
      jQuery('.btn-close-popup-save-address').addClass('action_open_other_tabs').data('option',href);
      return false;
    } else {
      show_form_add_address_book(0);
      show_dashboar_header_setting(0);
      jQuery('.address_book_save').text('Add New Shipping Address');
      load_address_book('','','','','','','','','','');
    }
  });

  jQuery('body').on('click','.add-new-address',function () {
    var show = check_show_save_subscription_address();
    if( show.length >= 1 ){
      show_popup_exit_without_saving(1);
      jQuery('.btn-close-popup-save-address').addClass('action_add_new_address');
    } else {
      show_add_new_address_book();
    }
    return false;
  });

  jQuery('body').on('click','.address_book_save_subscription',function () {
    var data_subscription = check_show_save_subscription_address();
    var data_address = {
      'action': 'lg_action_address_book_save_subscription',
      'data_subscription': data_subscription,
      'subMM_id': jQuery('.subscriptionID.morpheme').val(),
      'subKM_id': jQuery('.subscriptionID.kissme').val(),
      'subSM_id': jQuery('.subscriptionID.shadowme').val(),
    };

    if( data_subscription.length > 0){
      jQuery('input[name="check-reload-page"]').val('1');
    }

    jQuery.post(ajaxurl, data_address, function (response) {
      lg_update_display_address_book(response.list_address_book, response.list_address_subscription);
      show_address_book_message('woocommerce-message','Address updated on your subscription successfully.');
    }, 'json');

    return false;
  });

  jQuery('body').on('change','select.address-book-subscription-edit',function () {
    show_action_edit_subs_address();
    return false;
  });

  jQuery('body').on('click','.collapsible-action a, .address_book_name',function () {
    var current = jQuery(this).closest('.wc-address-book-address');
    if( !current.hasClass('primary-panel') ) {
      if (current.hasClass('collapsible-panel')) {
        current.removeClass('collapsible-panel');
      } else {
        current.addClass('collapsible-panel');
      }
    }
    return false;
  });

  jQuery('body').on('click','.btn-close-popup-save-address', function(){
    jQuery.magnificPopup.close();
    var current = jQuery(this),
        name = current.data('option');
    if(current.hasClass('action_add_new_address')){
      show_add_new_address_book();
      address_book_reload();
    } else if(current.hasClass('action_open_other_tabs')){
      jQuery('.dashboard-setting-account #accordion-setting .nav-tabs a[href="'+name+'"]').tab('show');
      address_book_reload();
    } else if(current.hasClass('action_delete_book_address')){
      show_address_book_delete(name);
      address_book_reload();
    } else if(current.hasClass('action_make_primary_book_address')){
      show_address_book_make_primary(name);
    } else if(current.hasClass('action_edit_book_address')){
      show_address_book_edit(name);
      address_book_reload();
    } else if (jQuery('input[name="check-reload-page"]').val() == 1) {
      window.location.href =  window.location.href.split("#")[0];
    } else {
      jQuery('.dashboard-myaccount').fadeIn(1000);
      jQuery('.dashboard-setting').fadeOut(1000);
      change_zindex('0');
      address_book_reload();
    }
    return false;
  });

  jQuery('body').on('click','.dashboard-sticky-2019 a', function(){
    var show = check_show_save_subscription_address();
    if( show.length >= 1 ){
      show_popup_exit_without_saving(jQuery(this).attr('href'));
      return false;
    }
  });

  function show_address_book_delete(name) {
    var current = jQuery('.wc-address-book-delete-open-popup#'+name),
        address = current.closest('.wc-address-book-address').find('address').html();

    jQuery('#confirm-delete-book-address address').html(address);
    jQuery('#confirm-delete-book-address .submit-delete').attr('id', name);
    jQuery.magnificPopup.open({
      items: {src: '#confirm-delete-book-address'},
      type: 'inline',
      closeOnContentClick: false,
      closeOnBgClick: false,
      showCloseBtn: false
    });
  }

  function show_address_book_message(type,msg) {
    jQuery('.lg-change-address-notice').removeClass('woocommerce-error woocommerce-message').html('');
    if(type == 'woocommerce-error'){
      jQuery('.liveglam-setting').find('.lg-address-book-new .lg-change-address-notice').addClass(type).html(msg);
      jQuery('html, body').animate({scrollTop: jQuery(".lg-address-book-new .lg-change-address-notice").offset().top}, 1000);
    } else {
      show_form_add_address_book(0);
      show_dashboar_header_setting(0);
      jQuery('.liveglam-setting').find('.lg-address-book-subscription .lg-change-address-notice').addClass(type).html(msg);
      jQuery('html, body').animate({scrollTop: jQuery(".lg-address-book-subscription .lg-change-address-notice").offset().top}, 1000);
    }
    setTimeout(function () {
      jQuery('.lg-change-address-notice').removeClass('woocommerce-error woocommerce-message').html('');
    },15000);

  }

  function show_address_book_make_primary(name) {
    var current = jQuery('.wc-address-book-make-primary-lg#'+name);
    var primary_address = jQuery('.woocommerce-Addresses .u-column2.woocommerce-Address address');
    var alt_address = current.parent().siblings( 'address' );

    // Swap HTML values for address and label
    var pa_html = primary_address.html();
    var aa_html = alt_address.html();

    alt_address.html(pa_html);
    primary_address.html(aa_html);

    primary_address.addClass('blockUI blockOverlay wc-updating');
    alt_address.addClass('blockUI blockOverlay wc-updating');

    var data = {
      'action': 'lg_action_address_book_make_primary',
      'name': name,
      'subMM_id': jQuery('.subscriptionID.morpheme').val(),
      'subKM_id': jQuery('.subscriptionID.kissme').val(),
      'subSM_id': jQuery('.subscriptionID.shadowme').val(),
    };
    jQuery.post(ajaxurl,data,function (response) {
      jQuery('.wc-updating').removeClass('blockUI blockOverlay wc-updating');
      lg_update_display_address_book(response.list_address_book, response.list_address_subscription)
    },'json');
  }

  function show_address_book_edit(name) {
    show_form_add_address_book(1);
    show_dashboar_header_setting('edit');
    var book_name = jQuery('input.'+name+'.book_name').val(),
        fname = jQuery('input.'+name+'.first_name').val(),
        lname = jQuery('input.'+name+'.last_name').val(),
        add1 = jQuery('input.'+name+'.address_1').val(),
        add2 = jQuery('input.'+name+'.address_2').val(),
        city = jQuery('input.'+name+'.city').val(),
        state = jQuery('input.'+name+'.state').val(),
        postcode = jQuery('input.'+name+'.postcode').val(),
        country = jQuery('input.'+name+'.country').val();
    load_address_book(name,book_name,fname,lname,add1,add2,city,postcode,country,state);
    jQuery('html, body').animate({
      scrollTop: jQuery("#lg-change-shipping-content").offset().top
    }, 1000,function () {
      jQuery("#lg-change-shipping-content").fadeIn(50).fadeOut(50).fadeIn(50).fadeOut(50).fadeIn(50);
    });
    jQuery('.address_book_save').text('Update Shipping Address');
  }

  function show_add_new_address_book() {
    show_form_add_address_book(1);
    show_dashboar_header_setting('new');
    load_address_book('','','','','','','','','','');
    jQuery('.address_book_save').text('Add New Shipping Address');
    jQuery('html, body').animate({scrollTop: jQuery("#lg-change-shipping-content").offset().top}, 1000);
  }

  function show_dashboar_header_setting(open){
    if( open == 'new' ){
      jQuery('.dashboard-header-new .dashboard-header-profile').addClass('d-none');
      jQuery('.dashboard-header-new .dashboard-header-add-address-book').removeClass('d-none');
      jQuery('.dashboard-header-new .dashboard-header-edit-address-book').addClass('d-none');
      jQuery('#tab-address-book .wrap').addClass('bg-gray');
    } else {
      if( open == 'edit' ){
        jQuery('.dashboard-header-new .dashboard-header-profile').addClass('d-none');
        jQuery('.dashboard-header-new .dashboard-header-add-address-book').addClass('d-none');
        jQuery('.dashboard-header-new .dashboard-header-edit-address-book').removeClass('d-none');
        jQuery('#tab-address-book .wrap').addClass('bg-gray');
      } else {
        jQuery('.dashboard-header-new .dashboard-header-profile').removeClass('d-none');
        jQuery('.dashboard-header-new .dashboard-header-add-address-book').addClass('d-none');
        jQuery('.dashboard-header-new .dashboard-header-edit-address-book').addClass('d-none');
        jQuery('#tab-address-book .wrap').removeClass('bg-gray');
      }
    }
  }

  function show_popup_exit_without_saving(redirect) {
    jQuery('.btn-close-popup-save-address').removeClass().addClass('btn btn-accept btn-close-popup-save-address btn-primary');
    jQuery.magnificPopup.open({items: {src: '#exit-without-saving-address'}, type: 'inline'});
    if(redirect == 1){
      jQuery('.btn-continue-redirect').addClass('d-none');
      jQuery('.btn-close-popup-save-address').removeClass('d-none');
    } else {
      jQuery('.btn-continue-redirect').removeClass('d-none');
      jQuery('a.btn-continue-redirect').attr('href',redirect);
      jQuery('.btn-close-popup-save-address').addClass('d-none');
    }
  }

  function address_book_reload() {
    var data_address = {
      'action': 'lg_action_address_book_load',
      'subMM_id': jQuery('.subscriptionID.morpheme').val(),
      'subKM_id': jQuery('.subscriptionID.kissme').val(),
      'subSM_id': jQuery('.subscriptionID.shadowme').val(),
    };

    jQuery.post(ajaxurl, data_address, function (response) {
      lg_update_display_address_book(response.list_address_book, response.list_address_subscription)
    }, 'json');
  }

  function check_show_save_subscription_address() {
    var show = [];
    if( jQuery('.address-book-mm select').val() != jQuery('.address-book-mm select').data('old-shipping') ){
      show.push({
        sub_id: jQuery('.address-book-mm select').data('sub_id'),
        shipping: jQuery('.address-book-mm select').val()
      });
    }
    if( jQuery('.address-book-km select').val() != jQuery('.address-book-km select').data('old-shipping') ){
      show.push({
        sub_id: jQuery('.address-book-km select').data('sub_id'),
        shipping: jQuery('.address-book-km select').val()
      });
    }
    if( jQuery('.address-book-sm select').val() != jQuery('.address-book-sm select').data('old-shipping') ){
      show.push({
        sub_id: jQuery('.address-book-sm select').data('sub_id'),
        shipping: jQuery('.address-book-sm select').val()
      });
    }
    return show;
  }

  function show_action_edit_subs_address() {
    var show = check_show_save_subscription_address();
    if( show.length >= 1 ){
      jQuery('.address_book_subscription_action').removeClass('d-none');
    } else {
      jQuery('.address_book_subscription_action').addClass('d-none');
    }
  }

  function show_form_add_address_book(open) {

    var width = (window.innerWidth > 0) ? window.innerWidth : screen.width;
    if( width < 767 ) {
      if (open == 1) {
        jQuery('.address-book-details .split-bar-new').addClass('d-none');
        jQuery('.lg-address-book-primary').addClass('d-none');
        jQuery('.lg-address-book-title').addClass('d-none');
        jQuery('.dashboard-setting #accordion-setting .new-nav').addClass('d-none');
        jQuery('.lg-address-book-subscription').addClass('d-none');
        jQuery('.lg-address-book-new').removeClass('d-none');
        jQuery('.add-new-address').addClass('d-none');
        jQuery('.edit-subscription-address').removeClass('d-none');
      } else {
        jQuery('.address-book-details .split-bar-new').removeClass('d-none');
        jQuery('.lg-address-book-primary').removeClass('d-none');
        jQuery('.lg-address-book-title').removeClass('d-none');
        jQuery('.dashboard-setting #accordion-setting .new-nav').removeClass('d-none');
        jQuery('.lg-address-book-subscription').removeClass('d-none');
        jQuery('.lg-address-book-new').addClass('d-none');
        jQuery('.add-new-address').removeClass('d-none');
        jQuery('.edit-subscription-address').addClass('d-none');
      }
    } else {
      if (open == 1) {
        jQuery('.lg-address-book-subscription').addClass('d-none');
        jQuery('.lg-address-book-new').removeClass('d-none');
        jQuery('.add-new-address').addClass('d-none');
        jQuery('.edit-subscription-address').removeClass('d-none');
      } else {
        jQuery('.lg-address-book-subscription').removeClass('d-none');
        jQuery('.lg-address-book-new').addClass('d-none');
        jQuery('.add-new-address').removeClass('d-none');
        jQuery('.edit-subscription-address').addClass('d-none');
      }
    }
    jQuery('#tab-address-book #lg-address-book #shipping_country').select2();
  }

  function lg_update_display_address_book(list_address_book,list_address_subscription) {
    jQuery('.list-address-book').html(list_address_book);
    jQuery('.list-address-subscription').html(list_address_subscription);
    jQuery('.address-book-sub .selectpicker').selectpicker();
    show_action_edit_subs_address();
  }

  function show_address_book() {
    jQuery('#lg-change-shipping-content').prependTo('#tab-address-book #lg-address-book');
    load_address_book('','','','','','','','','','');
  }

  function load_address_book( name, book_name, fname, lname, add1, add2, city, postcode, country , state ) {
    jQuery('#tab-address-book #lg-address-book #shipping_country option').removeAttr('selected');
    jQuery('#tab-address-book #lg-address-book #shipping_state option').removeAttr('selected');
    jQuery('#tab-address-book #lg-address-book #shipping_first_name').val(fname);
    jQuery('#tab-address-book #lg-address-book #shipping_last_name').val(lname);
    jQuery('#tab-address-book #lg-address-book #shipping_address_1').val(add1);
    jQuery('#tab-address-book #lg-address-book #shipping_address_2').val(add2);
    jQuery('#tab-address-book #lg-address-book #shipping_city').val(city);
    jQuery('#tab-address-book #lg-address-book #shipping_postcode').val(postcode);
    jQuery('#tab-address-book #lg-address-book #shipping_country').val(country).trigger('change');
    jQuery('#tab-address-book #lg-address-book #shipping_state').val(state).trigger('change');
    jQuery('#tab-address-book #lg-address-book #shipping_address-book-edit').val(name);
    jQuery('#tab-address-book #lg-address-book #shipping_book_name').val(book_name);
  }
  /* end script for address book */

  /* script skip-cancel subscription */
  jQuery('body').on('click', '.stop-skip-cancel', function () {
    jQuery.magnificPopup.close();
    return false;
  });

  function abtest_skip_cancel_new() {
    window._conv_q = window._conv_q || [];
    _conv_q.push(["triggerConversion","100128625"]);
  }
  function abtest_skip_submission() {
    window._conv_q = window._conv_q || [];
    _conv_q.push(["triggerConversion","100128792"]);
  }
  function abtest_cancel_submission() {
    window._conv_q = window._conv_q || [];
    _conv_q.push(["triggerConversion","100128793"]);
  }
  function lgs_ga_tracking_submit(category, club, action){
    var club_name = (club=='mm')?'MorpheMe Club':((club=='km')?'KissMe Club':'ShadowMe Club');
    ga('send', 'event', category, action, club_name);
  }

  //process confirm cancel trade
  jQuery('body').on('click', '.trade_cancel_action', function () {
     var current = jQuery(this);
     if( current.hasClass('trade_cancel_morpheme') ){
         jQuery.magnificPopup.open({items: {src: '#form-mm-cancel-trade'}, type: 'inline'});
     }
     if( current.hasClass('trade_cancel_kissme') ){
         jQuery.magnificPopup.open({items: {src: '#form-km-cancel-trade'}, type: 'inline'});
     }
     if( current.hasClass('trade_cancel_shadowme') ){
         jQuery.magnificPopup.open({items: {src: '#form-sm-cancel-trade'}, type: 'inline'});
     }
     return false;
  });

  jQuery('body').on('click', '.cancel_trade_action', function () {
      var current = jQuery(this),
          subid = current.data('subid'),
          club = current.data('club');
      var data = {
          'action': 'liveglam_trade_cancel_action',
          'subscriptionID': subid,
          'club': club,
      };
      jQuery.post(ajaxurl, data, function (response) {
          jQuery.magnificPopup.close();
          jQuery.magnificPopup.open({items: {src: '#form-'+club+'-cancel-trade-confirmation'}, type: 'inline', closeOnContentClick: false, closeOnBgClick: false, showCloseBtn: false});
      });
      lgs_ga_tracking_submit('Canx trade', club, 'Submit canx trade');
      return false;
  });

  // new - process skip mm
  jQuery('body').on('click', '.skip_reactive_mm', function () {
    jQuery.magnificPopup.open({items: {src: '#form-mm-reactive'}, type: 'inline'});
    return false;
  });
  jQuery('body').on('click', '.mm_skip_action', function () {
    jQuery.magnificPopup.open({items: {src: '#form-mm-skip-1'}, type: 'inline'});
    return false;
  });
  jQuery('body').on('click', '#form-mm-skip-1 .continue-skip-cancel', function () {
    if (jQuery('input.morpheme.show_trade').val() == 1 && jQuery('input.morpheme.show_trade_message').val() == 0) {
      jQuery.magnificPopup.open({items: {src: '#form-mm-skip-2'}, type: 'inline'});
    } else {
      jQuery.magnificPopup.open({items: {src: '#form-mm-skip-3'}, type: 'inline'});
    }
    return false;
  });
  jQuery('body').on('click', '#form-mm-skip-2 .continue-skip-cancel', function () {
    jQuery.magnificPopup.open({items: {src: '#form-mm-skip-3'}, type: 'inline'});
    return false;
  });
  jQuery('body').on('click', '#form-mm-skip-3 .continue-skip-cancel', function () {
    //do action skip here
    action_form_skip_cancel(jQuery(this),'morpheme','skip');
    return false;
  });
  // new - process cancel mm
  jQuery('body').on('click', '.mm_cancel_action', function () {
    if (jQuery('input.morpheme.show_cancel_message').val() == 1) {
      jQuery.magnificPopup.open({items: {src: '#mm_cancel_message_popup'}, type: 'inline'});
    } else {
      jQuery.magnificPopup.open({items: {src: '#form-mm-cancel-1'}, type: 'inline'});
    }
    return false;
  });
  jQuery('body').on('click', '#form-mm-cancel-1 .continue-skip-cancel', function () {
    if (jQuery('input.morpheme.show_trade').val() == 1 && jQuery('input.morpheme.show_trade_message').val() == 0) {
      jQuery.magnificPopup.open({items: {src: '#form-mm-cancel-2'}, type: 'inline'});
    } else {
      if (jQuery('input.morpheme.show_skip').val() == 1) {
        jQuery.magnificPopup.open({items: {src: '#form-mm-cancel-3'}, type: 'inline'});
      } else {
        jQuery.magnificPopup.open({items: {src: '#form-mm-cancel-4'}, type: 'inline'});
      }
    }
    return false;
  });
  jQuery('body').on('click', '#form-mm-cancel-2 .continue-skip-cancel', function () {
    if (jQuery('input.morpheme.show_skip').val() == 1) {
      jQuery.magnificPopup.open({items: {src: '#form-mm-cancel-3'}, type: 'inline'});
    } else {
      jQuery.magnificPopup.open({items: {src: '#form-mm-cancel-4'}, type: 'inline'});
    }
    return false;
  });
  jQuery('body').on('click', '#form-mm-cancel-3 .continue-skip-cancel', function () {
    jQuery.magnificPopup.open({items: {src: '#form-mm-cancel-4'}, type: 'inline'});
    return false;
  });
  jQuery('body').on('click', '#form-mm-cancel-3 .skip_a_month', function () {
    jQuery.magnificPopup.open({items: {src: '#form-mm-skip-3'}, type: 'inline'});
    return false;
  });
  jQuery('body').on('click', '#form-mm-cancel-4 .continue-skip-cancel', function () {
    //do action cancel here
    action_form_skip_cancel(jQuery(this),'morpheme','cancel');
    return false;
  });

  // new - process skip km
  jQuery('body').on('click', '.skip_reactive_km', function () {
    jQuery.magnificPopup.open({items: {src: '#form-km-reactive'}, type: 'inline'});
    return false;
  });
  jQuery('body').on('click', '.km_skip_action', function () {
    jQuery.magnificPopup.open({items: {src: '#form-km-skip-1'}, type: 'inline'});
    return false;
  });
  jQuery('body').on('click', '#form-km-skip-1 .continue-skip-cancel', function () {
    if (jQuery('input.kissme.show_trade').val() == 1 && jQuery('input.kissme.show_trade_message').val() == 0) {
      jQuery.magnificPopup.open({items: {src: '#form-km-skip-2'}, type: 'inline'});
    } else {
      jQuery.magnificPopup.open({items: {src: '#form-km-skip-3'}, type: 'inline'});
    }
    return false;
  });
  jQuery('body').on('click', '#form-km-skip-2 .continue-skip-cancel', function () {
    jQuery.magnificPopup.open({items: {src: '#form-km-skip-3'}, type: 'inline'});
    return false;
  });
  jQuery('body').on('click', '#form-km-skip-3 .continue-skip-cancel', function () {
    //do action skip here
    action_form_skip_cancel(jQuery(this),'kissme','skip');
    return false;
  });
  // new - process cancel km
  jQuery('body').on('click', '.km_cancel_action', function () {
    if (jQuery('input.kissme.show_cancel_message').val() == 1) {
      jQuery.magnificPopup.open({items: {src: '#km_cancel_message_popup'}, type: 'inline'});
    } else {
      jQuery.magnificPopup.open({items: {src: '#form-km-cancel-1'}, type: 'inline'});
    }
    return false;
  });
  jQuery('body').on('click', '#form-km-cancel-1 .continue-skip-cancel', function () {
    if (jQuery('input.kissme.show_trade').val() == 1 && jQuery('input.kissme.show_trade_message').val() == 0) {
      jQuery.magnificPopup.open({items: {src: '#form-km-cancel-2'}, type: 'inline'});
    } else {
      if (jQuery('input.kissme.show_skip').val() == 1) {
        jQuery.magnificPopup.open({items: {src: '#form-km-cancel-3'}, type: 'inline'});
      } else {
        jQuery.magnificPopup.open({items: {src: '#form-km-cancel-4'}, type: 'inline'});
      }
    }
    return false;
  });
  jQuery('body').on('click', '#form-km-cancel-2 .continue-skip-cancel', function () {
    if (jQuery('input.kissme.show_skip').val() == 1) {
      jQuery.magnificPopup.open({items: {src: '#form-km-cancel-3'}, type: 'inline'});
    } else {
      jQuery.magnificPopup.open({items: {src: '#form-km-cancel-4'}, type: 'inline'});
    }
    return false;
  });
  jQuery('body').on('click', '#form-km-cancel-3 .continue-skip-cancel', function () {
    jQuery.magnificPopup.open({items: {src: '#form-km-cancel-4'}, type: 'inline'});
    return false;
  });
  jQuery('body').on('click', '#form-km-cancel-3 .skip_a_month', function () {
    jQuery.magnificPopup.open({items: {src: '#form-km-skip-3'}, type: 'inline'});
    return false;
  });
  jQuery('body').on('click', '#form-km-cancel-4 .continue-skip-cancel', function () {
    //do action cancel here
    action_form_skip_cancel(jQuery(this),'kissme','cancel');
    return false;
  });

  // new - process skip sm
  jQuery('body').on('click', '.skip_reactive_sm', function () {
    jQuery.magnificPopup.open({items: {src: '#form-sm-reactive'}, type: 'inline'});
    return false;
  });
  jQuery('body').on('click', '.sm_skip_action', function () {
    jQuery.magnificPopup.open({items: {src: '#form-sm-skip-1'}, type: 'inline'});
    return false;
  });
  jQuery('body').on('click', '#form-sm-skip-1 .continue-skip-cancel', function () {
    if (jQuery('input.shadowme.show_trade').val() == 1 && jQuery('input.shadowme.show_trade_message').val() == 0) {
      jQuery.magnificPopup.open({items: {src: '#form-sm-skip-2'}, type: 'inline'});
    } else {
      jQuery.magnificPopup.open({items: {src: '#form-sm-skip-3'}, type: 'inline'});
    }
    return false;
  });
  jQuery('body').on('click', '#form-sm-skip-2 .continue-skip-cancel', function () {
    jQuery.magnificPopup.open({items: {src: '#form-sm-skip-3'}, type: 'inline'});
    return false;
  });
  jQuery('body').on('click', '#form-sm-skip-3 .continue-skip-cancel', function () {
    //do action skip here
    action_form_skip_cancel(jQuery(this),'shadowme','skip');
    return false;
  });
  // new - process cancel sm
  jQuery('body').on('click', '.sm_cancel_action', function () {
    if (jQuery('input.shadowme.show_cancel_message').val() == 1) {
      jQuery.magnificPopup.open({items: {src: '#sm_cancel_message_popup'}, type: 'inline'});
    } else {
      jQuery.magnificPopup.open({items: {src: '#form-sm-cancel-1'}, type: 'inline'});
    }
    return false;
  });
  jQuery('body').on('click', '#form-sm-cancel-1 .continue-skip-cancel', function () {
    if (jQuery('input.shadowme.show_trade').val() == 1 && jQuery('input.shadowme.show_trade_message').val() == 0) {
      jQuery.magnificPopup.open({items: {src: '#form-sm-cancel-2'}, type: 'inline'});
    } else {
      if (jQuery('input.shadowme.show_skip').val() == 1) {
        jQuery.magnificPopup.open({items: {src: '#form-sm-cancel-3'}, type: 'inline'});
      } else {
        jQuery.magnificPopup.open({items: {src: '#form-sm-cancel-4'}, type: 'inline'});
      }
    }
    return false;
  });
  jQuery('body').on('click', '#form-sm-cancel-2 .continue-skip-cancel', function () {
    if (jQuery('input.shadowme.show_skip').val() == 1) {
      jQuery.magnificPopup.open({items: {src: '#form-sm-cancel-3'}, type: 'inline'});
    } else {
      jQuery.magnificPopup.open({items: {src: '#form-sm-cancel-4'}, type: 'inline'});
    }
    return false;
  });
  jQuery('body').on('click', '#form-sm-cancel-3 .continue-skip-cancel', function () {
    jQuery.magnificPopup.open({items: {src: '#form-sm-cancel-4'}, type: 'inline'});
    return false;
  });
  jQuery('body').on('click', '#form-sm-cancel-3 .skip_a_month', function () {
    jQuery.magnificPopup.open({items: {src: '#form-sm-skip-3'}, type: 'inline'});
    return false;
  });
  jQuery('body').on('click', '#form-sm-cancel-4 .continue-skip-cancel', function () {
    //do action cancel here
    action_form_skip_cancel(jQuery(this),'shadowme','cancel');
    return false;
  });

  function action_form_skip_cancel(current,product_type,type_action) {
    var window_width = jQuery(window).width(),
        error = 0,
        subscriptionID = jQuery('.subscriptionID.'+product_type).val(),
        parent = current.closest('.form-skip-cancel'),
        comment = parent.find('.submit-comment').val();
    if( window_width >= 768 ){
      var reason = parent.find('input.submit-reason:checked').val();
    } else {
      var reason = parent.find('select.submit-reason option:selected').val();
    }

    if( typeof comment == 'undefined' || comment == '' ){
      parent.find('.form-comment').addClass('error-validate');
      error = 1;
    } else {
      parent.find('.form-comment').removeClass('error-validate');
    }

    if( typeof reason == 'undefined' || reason == '' ){
      parent.find('.form-reason').addClass('error-validate');
      error = 1;
    } else {
      parent.find('.form-reason').removeClass('error-validate');
    }

    if( error == 0 ){
      abtest_skip_cancel_new();
      if( type_action == 'cancel' ){
        abtest_cancel_submission();
      } else {
        abtest_skip_submission();
      }
      jQuery.magnificPopup.close();
      jQuery.magnificPopup.open({items: {src: '#gform_popupui.new-form'}, type: 'inline', closeOnContentClick: false, closeOnBgClick: false, showCloseBtn: false});
      var data = {
        'action': 'lgs_subscription_skip_cancel',
        'subscriptionID': subscriptionID,
        'type_action': type_action,
        'product_type': product_type,
        'reason': reason,
        'comment': comment
      };
      jQuery.post(ajaxurl, data, function (response) {
        if( product_type == 'kissme' ) {
          if( type_action == 'cancel' ) {
              lgs_ga_tracking_submit('Canx sub', 'km', 'Submit canx sub');
            jQuery.magnificPopup.open({items: {src: '#form-km-cancel-5'}, type: 'inline', closeOnContentClick: false, closeOnBgClick: false, showCloseBtn: false});
          } else {
              lgs_ga_tracking_submit('Skip a month', 'km', 'Submit skip');
            jQuery.magnificPopup.open({items: {src: '#form-km-skip-4'}, type: 'inline', closeOnContentClick: false, closeOnBgClick: false, showCloseBtn: false});
          }
        } else if( product_type == 'morpheme' ) {
          if( type_action == 'cancel' ) {
              lgs_ga_tracking_submit('Canx sub', 'mm', 'Submit canx sub');
            jQuery.magnificPopup.open({items: {src: '#form-mm-cancel-5'}, type: 'inline', closeOnContentClick: false, closeOnBgClick: false, showCloseBtn: false});
          } else {
              lgs_ga_tracking_submit('Skip a month', 'mm', 'Submit skip');
            jQuery.magnificPopup.open({items: {src: '#form-mm-skip-4'}, type: 'inline', closeOnContentClick: false, closeOnBgClick: false, showCloseBtn: false});
          }
        } else if( product_type == 'shadowme' ) {
          if( type_action == 'cancel' ) {
              lgs_ga_tracking_submit('Canx sub', 'sm', 'Submit canx sub');
            jQuery.magnificPopup.open({items: {src: '#form-sm-cancel-5'}, type: 'inline', closeOnContentClick: false, closeOnBgClick: false, showCloseBtn: false});
          } else {
              lgs_ga_tracking_submit('Skip a month', 'sm', 'Submit skip');
            jQuery.magnificPopup.open({items: {src: '#form-sm-skip-4'}, type: 'inline', closeOnContentClick: false, closeOnBgClick: false, showCloseBtn: false});
          }
        }
      });
    }
  }

  jQuery('body').on('click', '.reload-skip-cancel', function () {
    window.location.reload();
    return false;
  });

  jQuery('body').on('change', '.form-reason input.submit-reason, .form-reason select.submit-reason', function () {
    var value = jQuery(this).val();
    if( typeof value == 'undefined' || value == '' ){
      jQuery(this).closest('.form-reason').addClass('error-validate');
    } else {
      jQuery(this).closest('.form-reason').removeClass('error-validate');
    }
  });

  jQuery('body').on('change focusout', '.form-comment .submit-comment', function () {
    var value = jQuery(this).val();
    if( typeof value == 'undefined' || value == '' ){
      jQuery(this).closest('.form-comment').addClass('error-validate');
    } else {
      jQuery(this).closest('.form-comment').removeClass('error-validate');
    }
  });
  jQuery('body').on('focusin', '.form-comment .submit-comment', function () {
    jQuery(this).closest('.form-comment').removeClass('error-validate');
  });

  jQuery('body').on('click', '.lg_confirm_gf .btn-reload-page,#reactivate_form button.btn-primary', function () {
    window.location.reload();
  });
  /* end script skip-cancel subscription */

  /* script for action delete/set default payment methods */
  jQuery('body').on('click', '.payment-method-actions a.button, .payment-method-maybe_use_for a.button.maybe_use_for', function () {
    var current = jQuery(this);

    var subscription_ids = [], list_club = [];
    //case action is set card for clubs
    if(current.data('type_action') == 'set_card'){
      if( current.closest('.lgs-maybe-use-for').find('select').length > 0 ) {
        current.closest('.lgs-maybe-use-for').find('select option:selected').each(function () {
          subscription_ids.push(jQuery(this).val());
          list_club.push(jQuery(this).text());
        });
      } else {
        subscription_ids.push(current.closest('.lgs-maybe-use-for').find('p.lgs-stripe-custom').data('list_sub'));
        list_club.push(current.closest('.lgs-maybe-use-for').find('p.lgs-stripe-custom').data('list_club'));
      }
      //if no club select then return false
      if(subscription_ids.length < 1){
        return false;
      }
    }

    var data = {
      'action': 'lg_update_payment_method_action',
      'token_id': current.data('token_id'),
      'type_action': current.data('type_action'),
      'list_sub': subscription_ids.join(","),
      'list_club': list_club.join(","),
    };
    jQuery('.payment_methods_notice').html('');
    jQuery.post(ajaxurl, data, function (response) {
      load_dispay_payment_methods_table();
      jQuery('.payment_methods_notice').html(response);
      //need reload selectpicker after 1sec
      setTimeout(function () {
        jQuery('.lgs-maybe-use-for select').selectpicker();
      },1000);

    });
    return false;
  });

  function load_dispay_payment_methods_table() {
    var data = {
      'action': 'lg_load_display_payment_methods',
      'subMM_id': jQuery('input[name="list-payment-subID"]').data('mm'),
      'subKM_id': jQuery('input[name="list-payment-subID"]').data('km'),
      'subSM_id': jQuery('input[name="list-payment-subID"]').data('sm'),
    };
    jQuery.post(ajaxurl, data, function (response) {
      jQuery('.display-payment-methods').html(response);
    });
  }

  jQuery('body').on('change', '.lgs-maybe-use-for select', function () {
    var current =jQuery(this);
    if(current.val() === null){
      current.closest('.lgs-maybe-use-for').find('a.button.maybe_use_for').addClass('d-none');
    } else{
      current.closest('.lgs-maybe-use-for').find('a.button.maybe_use_for').removeClass('d-none');
    }
  });

  jQuery('body').on('click', '.btn-add-payment-method', function () {
    var current = jQuery(this);
    if (current.hasClass('add_payment')) {
      current.removeClass('add_payment');
      current.removeClass('btn-primary');
      current.addClass('btn-secondary');
      current.html('<i class="fas fa-minus" aria-hidden="true"></i> Discard Update');
      current.closest('.lg-change-payment').find('#form-add-payment-method').fadeIn(1000);
      jQuery(document.body).trigger('country_to_state_changed');
    } else {
      current.addClass('add_payment');
      current.addClass('btn-primary');
      current.removeClass('btn-secondary');
      current.html('<i class="fas fa-plus" aria-hidden="true"></i> ADD NEW PAYMENT METHOD');
      current.closest('.lg-change-payment').find('#form-add-payment-method').fadeOut(1000);
    }
    return false;
  });
  /* end script for action delete/set default payment methods */

  /*change avatar*/
  jQuery('body').on('change', '#basic-local-avatar', function () {
    readURL(this);
  });

  function readURL(input) {
    if (input.files && input.files[0]) {
      var reader = new FileReader();
      reader.onload = function (e) {
        var fileName = jQuery(input).val();
        var img = e.target.result;
        var urls = 'url("' + img + '"';
        jQuery('.avatar-image').css('background-image', urls);
      };
      reader.readAsDataURL(input.files[0]);
    }
  }
  /*end change avatar*/

  /* script add on product */
  jQuery('body').on('click', '.add_on_option', function () {
    var product_id = jQuery(this).data('product_id');
    var checkout_url = home_url + '/cart/?add-to-cart=' + product_id + '&redeem_rewards=true';
    var price_stripe = jQuery(this).data('price_stripe');
    var price_reward = jQuery(this).data('price_reward');
    var shipping_text = '';
    if (price_stripe != '' && price_reward == '') shipping_text = price_stripe;
    if (price_stripe == '' && price_reward != '') shipping_text = price_reward;
    if (price_stripe != '' && price_reward != '') shipping_text = price_stripe + ' or ' + price_reward;
    jQuery('span#shipping_price').text(shipping_text);
    jQuery('.addon_pay_shipping').attr('href', checkout_url + '&ship_immediately=true');
    jQuery('.addon_free_shipping').attr('href', checkout_url + '&free_shipping=true');
    jQuery.magnificPopup.open({items: {src: '#addon_shipping_option'}, type: 'inline'});
    return false;
  });
  /* end script add on product */

  /* script for new DB */
  //upgrade waitlist inline
  jQuery('body').on('click', '.upgrade_waitlist_inline', function() {
    var width = (window.innerWidth > 0) ? window.innerWidth : screen.width;
    if( width < 767 ) {
      var parent = jQuery(this).closest('.liveglam-order-item');
      parent.find('.order-item-content').hide();
      parent.find('.order-item-content.order-item-content-2').show();
    } else {
      var parent = jQuery(this).closest('.lgs-data-info');
      parent.find('.lgdi-item').hide();
      parent.find('.lgdi-item.skip-waitlist-section').show();
    }
  });

  jQuery('body').on('click', '.ignore_waitlist_inline', function() {
    var width = (window.innerWidth > 0) ? window.innerWidth : screen.width;
    if( width < 767 ) {
      var parent = jQuery(this).closest('.liveglam-order-item');
      parent.find('.order-item-content').show();
      parent.find('.order-item-content.order-item-content-2').hide();
    } else {
      var parent = jQuery(this).closest('.lgs-data-info');
      parent.find('.lgdi-item').show();
      parent.find('.lgdi-item.skip-waitlist-section').hide();
    }
  });

  //hover on rating heart
  jQuery('.my-rating .rate.available i').on('mouseover', function(){
    var parent = jQuery(this).closest('.rate'),
        onStar = parseInt(jQuery(this).data('num'), 10);
    parent.children('i').each(function(e){
      if (e < onStar) {
        jQuery(this).addClass('active');
      } else {
        jQuery(this).removeClass('active');
      }
    });
  }).on('mouseout', function(){
    jQuery(this).closest('.rate').children('i').each(function(e){
      jQuery(this).removeClass('active');
    });
  });

  jQuery('.owl-carousel.prs-carousel').owlCarousel({
    autoplayTimeout: 5000,
    autoplayHoverPause: true,
    items: 3,
    responsive: {
      0: {
        items: 1,
        nav: true
      },
      480: {
        items: 2
      },
      768: {
        items: 3
      }
    },
    loop: false,
    nav:true,
    navText: ["<img alt='Previous' src='"+stylesheet_uri+"/assets/img/left_arrow.png'>",
      "<img alt='Next' src='"+stylesheet_uri+"/assets/img/right_arrow.png'>"],
    dots: false
  });

  jQuery('.redeem-items-product').owlCarousel({
    autoplayTimeout: 5000,
    autoplayHoverPause: true,
    items: 2,
    responsive: {
      0: { items: 2, margin: 8 },
      768: { items: 3, margin: 20 }
    },
    loop: false,
    nav: true,
    navText: ['<i class="fas fa-angle-left" aria-hidden="true"></i>',
      '<i class="fas fa-angle-right" aria-hidden="true"></i>'],
    dots: true
  });

  jQuery('.lgs-offer-cards').owlCarousel({
    autoplayTimeout: 5000,
    autoplayHoverPause: true,
    items: 2,
    margin: 20,
    responsive: {
      0: { items: 1 },
      768: { items: 2 }
    },
    loop: false,
    nav: true,
    navText: ["<img alt='Previous' src='"+stylesheet_uri+"/assets/img/left_arrow.png'>",
      "<img alt='Next' src='"+stylesheet_uri+"/assets/img/right_arrow.png'>"],
    dots: true
  });

  /* Remove video thumnail scrolling on mobile version */
  jQuery('.liveglam-orders.show-mobile .liveglam-orders-content .single-video').closest('.item-content').css('overflow-y', 'unset');

  jQuery('.shop-list-carousel').owlCarousel({
    autoplay: false,
    items: 1,
    loop: false,
    nav: true,
    navText: ["<img alt='Previous' src='"+stylesheet_uri+"/assets/img/left_arrow.png'>",
      "<img alt='Next' src='"+stylesheet_uri+"/assets/img/right_arrow.png'>"],
    dots: true
  });

  jQuery(window).load(function () {
    //show redeem-items block
    jQuery("#redeem-items").removeClass('d-none');

    //check and show offer block
    if(jQuery('#offer-cards .owl-stage .owl-item').length > 0 ) {
      jQuery("#offer-cards").removeClass('d-none');
    }
  });

  jQuery('body').on('click','.lgs-action-collap', function (){
    var width = (window.innerWidth > 0) ? window.innerWidth : screen.width;
    var current = jQuery(this);
    current.addClass('d-none');
    if( width > 767 ) {
      if ( current.hasClass('collap-hide') ) {
        current.closest('.lgs-data-club').find('.collap-show').removeClass('d-none');
        current.closest('.lgs-data-club').find('.lgs-panel-collap').addClass('d-none');
      } else {
        current.closest('.lgs-data-club').find('.collap-hide').removeClass('d-none');
        current.closest('.lgs-data-club').find('.lgs-panel-collap').removeClass('d-none');
      }
    } else {
      if ( current.hasClass('collap-hide') ) {
        current.closest('.liveglam-orders-content').find('.collap-show').removeClass('d-none');
        current.closest('.liveglam-orders-content').find('.section-bottom').addClass('d-none');
      } else {
        current.closest('.liveglam-orders-content').find('.collap-hide').removeClass('d-none');
        current.closest('.liveglam-orders-content').find('.section-bottom').removeClass('d-none');
      }
    }
    lgs_load_height();
    return false;
  });

  jQuery('.liveglam-orders .nav-link').on('shown.bs.tab', function (e) {
    lgs_load_height();
  });

  jQuery('body').on('click','.breakdown a', function () {
    var current = jQuery(this);
    var width = (window.innerWidth > 0) ? window.innerWidth : screen.width;
    if( width < 767 ) {
      if( current.hasClass('show-breakdown') ){
        current.closest('.breakdown').find('.show-breakdown').hide();
        current.closest('.breakdown').find('.hide-breakdown').show();
        current.closest('.content-single').css('overflow-y', 'auto');
        current.closest('.content-single').find('.single-list').show();
        current.closest('.content-single').find('.single-video').hide();
        current.closest('.content-single').find('.single-trade').hide();
      } else {
        current.closest('.breakdown').find('.show-breakdown').show();
        current.closest('.breakdown').find('.hide-breakdown').hide();
        current.closest('.content-single').css('overflow-y', 'unset');
        current.closest('.content-single').find('.single-list').hide();
        current.closest('.content-single').find('.single-video').show();
        current.closest('.content-single').find('.single-trade').show();
      }
    } else {
      if( current.hasClass('show-breakdown') ){
        current.closest('.breakdown').find('.show-breakdown').hide();
        current.closest('.breakdown').find('.hide-breakdown').show();
        current.closest('.lgdi-item-content').find('.single-list').show();
        current.closest('.lgdi-item-content').find('.single-video').hide();
        current.closest('.lgdi-item-content').find('.single-trade').hide();
      } else {
        current.closest('.breakdown').find('.show-breakdown').show();
        current.closest('.breakdown').find('.hide-breakdown').hide();
        current.closest('.lgdi-item-content').find('.single-list').hide();
        current.closest('.lgdi-item-content').find('.single-video').show();
        current.closest('.lgdi-item-content').find('.single-trade').show();
      }
    }
    lgs_load_height();
  });

  lgs_load_height();

  jQuery( window ).resize(function() {
    lgs_load_height();
  });

  function lgs_load_height() {
    jQuery('.liveglam-order-item .item-content.content-single').each(function () {
      var current = jQuery(this),
          parent_padding_top = (current.closest('.liveglam-order-item').find('.order-item-content').outerHeight() - current.closest('.liveglam-order-item').find('.order-item-content').height() ) / 2,
          height_top = current.closest('.liveglam-order-item').find('.item-header').outerHeight(),
          height_bot = current.closest('.liveglam-order-item').find('.item-footer').outerHeight(),
          height_total = current.closest('.liveglam-order-item').find('.order-item-content').outerHeight();
      if(current.closest('.liveglam-order-item').find('.item-header').hasClass('item-header-new')){
        parent_padding_top = 0;
      }
      var max_height = height_total - height_top - height_bot - parent_padding_top;
      current.css('height',max_height+'px');
      //maybe set height for glamrock video
      var height_glamrock = current.find('.single-header').outerHeight(),
          parent_padding_height_glamrock = (current.closest('.liveglam-order-item').find('.item-content.content-single').outerHeight() - current.closest('.liveglam-order-item').find('.item-content.content-single').height() ) / 2,
          max_height_glamrock_video = max_height - height_glamrock - parent_padding_height_glamrock;
      current.find('.single-video').css('height',max_height_glamrock_video+'px');
      current.find('.single-trade').css('height',max_height_glamrock_video+'px');
    });
    jQuery('.lgdi-item .item-content.content-single').each(function () {
      var current = jQuery(this),
          parent_padding_top = (current.closest('.lgdi-item').find('.lgdi-item-content').outerHeight() - current.closest('.lgdi-item').find('.lgdi-item-content').height() ) / 2,
          height_top = current.closest('.lgdi-item').find('.item-header').outerHeight(),
          height_bot = current.closest('.lgdi-item').find('.item-footer').outerHeight(),
          height_total = current.closest('.lgdi-item').find('.lgdi-item-content').outerHeight(),
          max_height = height_total - height_top - height_bot - parent_padding_top;
      current.css('height',max_height+'px');
      //maybe set height for glamrock video
      var height_glamrock = current.find('.single-header').outerHeight(),
          max_height_glamrock_video = max_height - height_glamrock;
      current.find('.single-video').css('height',max_height_glamrock_video+'px');
      current.find('.single-trade').css('height',max_height_glamrock_video+'px');
    });
  }

  jQuery('body').on('click','.liveglam-noclub .show-noclub',function(){
    var current = jQuery(this),
        club = current.data('club');
    current.closest('.liveglam-noclub').find('.item-noclub-all').hide();
    current.closest('.liveglam-noclub').find('.item-noclub-'+club).show();
    return false;
  });

  jQuery('body').on('click','.liveglam-noclub .hide-noclub',function(){
    var current = jQuery(this),
        club = current.data('club');
    current.closest('.liveglam-noclub').find('.item-noclub-all').show();
    current.closest('.liveglam-noclub').find('.item-noclub-'+club).hide();
    return false;
  });

  jQuery('body').on('click','.sub-data-details .go-next-waitlist',function(){
    var current = jQuery(this).closest('.sub-data-details');
    current.find('.sub-data-detail.wl-notice').hide();
    current.find('.sub-data-detail.wl-upgrade').show();
    return false;
  });

  jQuery('body').on('click','.sub-data-details .go-back-waitlist',function(){
    var current = jQuery(this).closest('.sub-data-details');
    current.find('.sub-data-detail.wl-notice').show();
    current.find('.sub-data-detail.wl-upgrade').hide();
    return false;
  });

  /* end script for new DB */

    /** script for trade feature **/

    var open_trade_from_skip_cancel = 0;
    function abtest_trade_submission() {
        window._conv_q = window._conv_q || [];
        _conv_q.push(["triggerConversion","100128802"]);
    }

    jQuery('body').on('click', '.form-skip-cancel .trade_action, .gform_body .trade_action', function () {
        open_trade_from_skip_cancel = 1;
    });

    jQuery('body').on('click', '.trade_action.trade_kissme', function () {
        lgs_show_trade('kissme');
        return false;
    });

    jQuery('body').on('click', '.trade_action.trade_shadowme', function () {
        lgs_show_trade('shadowme');
        return false;
    });

    jQuery('body').on('click', '.trade_action.trade_brushes,.trade_action.trade_morpheme', function () {
        lgs_show_trade('morpheme');
        return false;
    });

    function lgs_show_trade(type_product) {
        jQuery.magnificPopup.close();
        if (jQuery('input.' + type_product + '.show_trade_message').val() != 0) {
            jQuery.magnificPopup.open({items: {src: '#show_trade_message'}, type: 'inline'});
            jQuery('#show_trade_message .email_invites_footer p').text(jQuery('input.' + type_product + '.show_trade_message').val());
            jQuery(".mfp-content").addClass("send-email-invites-popup popup-email-invite");
        } else {
            if (type_product == 'shadowme') {
                jQuery.magnificPopup.open({items: {src: '#lg_trade_monthly_' + type_product + '_set_step2'}, type: 'inline'});
                jQuery('#lg_trade_monthly_' + type_product + '_set_step2 .lg_trade_monthly_nav').addClass('d-none');
            } else {
                jQuery.magnificPopup.open({items: {src: '#lg_trade_monthly_' + type_product}, type: 'inline'});
                jQuery('#lg_trade_monthly_' + type_product + '_set_step2 .lg_trade_monthly_nav').removeClass('d-none');
            }
        }
        reload_value_trade();
    }

    function reload_value_trade() {
        jQuery('input.lg-trade-product_trade').val('');
        jQuery('input.lg-trade-product_trade_old').val('');
        jQuery('input.lg-trade-type_trade').val('');
        jQuery('input.lg-trade-subscription_id').val('');
        jQuery('input.lg-trade-point_old').val('');
        jQuery('input.lg-trade-point_new').val('');
    }

    reload_value_trade();

    jQuery('body').on('change', '.lg_trade_monthly input.lg_trade_step1', function () {
        var current = jQuery(this),
            type = current.val();
        current.closest('.lg_trade_option').find('label.selected').removeClass('selected');
        current.closest('label').addClass('selected');
        current.closest('.lg_trade_monthly').find('button.next_confirm').data('type', type);
        if (current.hasClass('disabled-trade-single')) {
            current.closest('.lg_trade_monthly').find('button.next_confirm').data('disabled', 'true');
        } else {
            current.closest('.lg_trade_monthly').find('button.next_confirm').data('disabled', 'false');
        }

    });

    jQuery('body').on('click', '.lg_trade_monthly .next_confirm', function () {
        var current = jQuery(this),
            product = current.data('product'),
            type = current.data('type'),
            num = current.data('num') + 1;
        if (current.hasClass('disabled')) {
            return false;
        }
        if (num == 2) {
            jQuery('#lg_trade_monthly_' + product + '_' + type + '_step' + num).find('.btn-confirm-trade-' + type).addClass('disabled');
            jQuery('#lg_trade_monthly_' + product + '_' + type + '_step' + num).find('.trade-label.selected').removeClass('selected');
        }
        if (num == 3) {
            jQuery('#lg_trade_monthly_' + product + '_' + type + '_step' + num).find('.btn-confirm-trade-' + type).addClass('disabled');
            jQuery('#lg_trade_monthly_' + product + '_' + type + '_step' + num).find('.trade-label.selected').removeClass('selected');
            jQuery('.lg_trade_notice_points').addClass('d-none');
        }
        jQuery.magnificPopup.close();
        if (num == 2 && current.data('disabled') == 'true') {
            jQuery.magnificPopup.open({
                items: {src: '#lg_trade_monthly_' + product + '_step5_disabled_trade_single'},
                type: 'inline'
            });
        } else {
            jQuery.magnificPopup.open({
                items: {src: '#lg_trade_monthly_' + product + '_' + type + '_step' + num},
                type: 'inline'
            });
        }
        return false;
    });

    jQuery('body').on('click', '.lg_trade_monthly .btn-last-confirm', function () {

        if( open_trade_from_skip_cancel == 1 ){
            abtest_trade_submission();
        }

        var current = jQuery(this),
            product = current.data('product'),
            type = current.data('type'),
            club = (product=='morpheme')?'mm':((club=='kissme')?'km':'sm');
            num = current.data('num') + 1;
        current.prop('disabled', true);

        var data = {
            'action': "liveglam_trade_product_action",
            'product_trade': jQuery('input.lg-trade-product_trade').val(),
            'product_trade_old': jQuery('input.lg-trade-product_trade_old').val(),
            'type_trade': jQuery('input.lg-trade-type_trade').val(),
            'subscription_id': jQuery('input.lg-trade-subscription_id').val(),
            'point_old': jQuery('input.lg-trade-point_old').val(),
            'point_new': jQuery('input.lg-trade-point_new').val(),
            'product': product
        };
        jQuery.post(ajaxurl, data, function (response) {
            jQuery.magnificPopup.close();
            jQuery.magnificPopup.open({
                items: {src: '#lg_trade_monthly_' + product + '_step' + num},
                type: 'inline',
                closeOnContentClick: false,
                closeOnBgClick: false,
                showCloseBtn: false
            });
        });

        if(type == 'set') {
            lgs_ga_tracking_submit('WT Trade', club, 'Submit WT');
        } else {
            lgs_ga_tracking_submit('IT Trade', club, 'Submit IT');
        }

        return false;

    });

    jQuery('body').on('click', '.lg_trade_monthly .back_confirm', function () {
        var current = jQuery(this),
            product = current.data('product'),
            type = current.data('type'),
            num = current.data('num');
        jQuery.magnificPopup.close();
        if (num == 1) {
            jQuery.magnificPopup.open({items: {src: '#lg_trade_monthly_' + product}, type: 'inline'});
        } else {
            jQuery.magnificPopup.open({
                items: {src: '#lg_trade_monthly_' + product + '_' + type + '_step' + num},
                type: 'inline'
            });
        }
    });

    jQuery('body').on('change', '.lg_trade_monthly .radio_trade_set', function () {
        var current = jQuery(this);

        if (current.parents('.trade-label').hasClass('selected')) {
            return false;
        }
        var id = current.val(),
            product = current.data('product'),
            title = current.data('title'),
            virtual = current.data('virtual'),
            brand = current.data('brand'),
            image = current.data('image'),
            shipping = current.data('shipping'),
            show_shipping = current.data('show_shipping'),
            subscription_id = current.data('subscription_id');

        current.closest('.owl-stage').find('.trade-label.selected').removeClass('selected');
        current.closest('.trade-label').addClass('selected');

        jQuery('.lg_trade_monthly_' + product).find('.trade-set.image-new-item').attr('src', image);
        jQuery('.lg_trade_monthly_' + product).find('.trade-set.title-new-item').text(title);
        jQuery('.lg_trade_monthly_' + product).find('.trade-set.brand-new-item').html(brand + '&nbsp;');
        jQuery('.lg_trade_monthly_' + product).find('.trade-set.product_name').text(title);
        current.closest('.lg_trade_monthly').find('.btn-confirm-trade-set').removeClass('disabled');
        if (virtual == 'yes') {
            jQuery('.lg_trade_monthly_' + product).find('.trade-set.virtual-yes').show();
            jQuery('.lg_trade_monthly_' + product).find('.trade-set.virtual-no').hide();
        } else {
            jQuery('.lg_trade_monthly_' + product).find('.trade-set.virtual-yes').hide();
            jQuery('.lg_trade_monthly_' + product).find('.trade-set.virtual-no').show();
        }

        if (shipping != 0 && show_shipping == 1) {
            jQuery('.lg_trade_monthly_' + product).find('.trade-set.add-shipping').show();
            jQuery('.lg_trade_monthly_' + product).find('.trade-set.add-shipping strong.total-shipping').text(shipping);
        } else {
            jQuery('.lg_trade_monthly_' + product).find('.trade-set.add-shipping').hide();
        }
        jQuery('input.lg-trade-product_trade').val(id);
        jQuery('input.lg-trade-type_trade').val('set');
        jQuery('input.lg-trade-subscription_id').val(subscription_id);
    });

    jQuery('body').on('change', '.lg_trade_monthly .radio_trade_single_old', function () {
        var current = jQuery(this);

        if (current.parents('.trade-label').hasClass('selected')) {
            return false;
        }
        var id = current.val(),
            product = current.data('product'),
            title = current.data('title'),
            brand = current.data('brand'),
            point_trade = current.data('point_trade'),
            subscription_id = current.data('subscription_id'),
            image = current.data('image');

        current.closest('.owl-stage').find('.trade-label.selected').removeClass('selected');
        current.closest('.trade-label').addClass('selected');
        current.closest('.lg_trade_monthly').find('.btn-confirm-trade-single').removeClass('disabled');

        jQuery('.lg_trade_monthly_' + product).find('.trade-single.image-old-item').attr('src', image);
        jQuery('.lg_trade_monthly_' + product).find('.trade-single.title-old-item').text(title);
        jQuery('.lg_trade_monthly_' + product).find('.trade-single.brand-old-item').html(brand + '&nbsp;');
        jQuery('.lg_trade_monthly_' + product).find('.trade-single.product_name_old').text(title);
        jQuery('input.lg-trade-product_trade_old').val(id);
        if (product == 'morpheme') {
            //need reload carousel for morpheme "get items"
            jQuery('input.lg-trade-point_old').val(point_trade);
            current.closest('.lg_trade_monthly').find('.btn-confirm-trade-single').addClass('disabled');
            jQuery('#lg_trade_monthly_' + product + '_single_step3 .lg_trade_option_single .owl-carousel.lg_trade_carousel').trigger('destroy.owl.carousel');
            jQuery('#lg_trade_monthly_' + product + '_single_step3 .lg_trade_option_single .owl-carousel.lg_trade_carousel').removeClass('owl-hidden owl-loaded').html('');
            var data = {
                'action': 'liveglam_reload_product_individual_trade',
                'type': product,
                'points': point_trade,
                'subscription_id': subscription_id
            };
            jQuery.post(ajaxurl, data, function (data) {
                jQuery('#lg_trade_monthly_' + product + '_single_step3 .lg_trade_option_single .owl-carousel.lg_trade_carousel').html(data.content);
                if (data.loaded == true) {
                    jQuery('#lg_trade_monthly_' + product + '_single_step3 .lg_trade_option_single .owl-carousel.lg_trade_carousel').trigger('destroy.owl.carousel');
                    jQuery('#lg_trade_monthly_' + product + '_single_step3 .lg_trade_option_single .owl-carousel.lg_trade_carousel').owlCarousel({
                        autoplayTimeout: 5000,
                        autoplayHoverPause: true,
                        items: 3,
                        responsive: {0: {items: 1}, 480: {items: 2}, 1024: {items: 3}},
                        loop: false,
                        nav: true,
                        navText: ["<img alt='Previous' src='" + liveglam_custome.get_stylesheet_directory_uri + "/assets/img/left_arrow.png' data-no-lazy='1'>",
                            "<img alt='Next' src='" + liveglam_custome.get_stylesheet_directory_uri + "/assets/img/right_arrow.png' data-no-lazy='1'>"],
                        dots: false
                    });
                } else {
                    jQuery('#lg_trade_monthly_' + product + '_single_step3 .lg_trade_option_single .owl-carousel.lg_trade_carousel').addClass('owl-loaded');
                }
                current.closest('.lg_trade_monthly').find('.btn-confirm-trade-single').removeClass('disabled');
            }, 'json');
        }
    });

    jQuery('body').on('change', '.lg_trade_monthly .radio_trade_single_new', function () {
        var current = jQuery(this);

        if (current.parents('.trade-label').hasClass('selected')) {
            return false;
        }
        var id = current.val(),
            product = current.data('product'),
            title = current.data('title'),
            brand = current.data('brand'),
            image = current.data('image'),
            point_trade = current.data('point_trade'),
            subscription_id = current.data('subscription_id');

        current.closest('.owl-stage').find('.trade-label.selected').removeClass('selected');
        current.closest('.trade-label').addClass('selected');
        current.closest('.lg_trade_monthly').find('.btn-confirm-trade-single').removeClass('disabled');

        jQuery('.lg_trade_monthly_' + product).find('.trade-single.image-new-item').attr('src', image);
        jQuery('.lg_trade_monthly_' + product).find('.trade-single.title-new-item').text(title);
        jQuery('.lg_trade_monthly_' + product).find('.trade-single.brand-new-item').html(brand + '&nbsp;');
        jQuery('.lg_trade_monthly_' + product).find('.trade-single.product_name').text(title);
        jQuery('input.lg-trade-product_trade').val(id);
        jQuery('input.lg-trade-type_trade').val('single');
        jQuery('input.lg-trade-subscription_id').val(subscription_id);
        if (product == 'morpheme') {
            jQuery('input.lg-trade-point_new').val(point_trade);
            jQuery('.lg_trade_monthly_' + product + ' .trade-label .lg_trade_notice_points').remove();
            var old_point_trade = jQuery('input.lg-trade-point_old').val(),
                increase_point_trade = old_point_trade - point_trade;
            //add points on 'Confirm Your Trade'
            jQuery('.lg_trade_monthly_' + product + ' .trade-single.points-old-item').html(old_point_trade + ' Points');
            jQuery('.lg_trade_monthly_' + product + ' .trade-single.points-new-item').html(point_trade + ' Points');
            jQuery('.lg_trade_monthly_' + product + ' .lg_trade_with_points .lg_trade_increase_points').html(increase_point_trade);
            if (increase_point_trade > 0) {
                jQuery('.lg_trade_monthly_' + product + ' .lg_trade_notice_points .lg_trade_old_points').html(old_point_trade);
                jQuery('.lg_trade_monthly_' + product + ' .lg_trade_notice_points .lg_trade_new_points').html(point_trade);
                jQuery('.lg_trade_monthly_' + product + ' .lg_trade_notice_points .lg_trade_increase_points').html(increase_point_trade);
                jQuery('.lg_trade_monthly_' + product + ' .lg_trade_notice_points').clone().removeClass('d-none').appendTo(current.closest('.trade-label'));
                //change message on 'Confirm Your Trade'
                jQuery('.lg_trade_monthly_' + product + ' .lg_trade_no_points').addClass('d-none');
                jQuery('.lg_trade_monthly_' + product + ' .lg_trade_with_points').removeClass('d-none');
            } else {
                jQuery('.lg_trade_monthly_' + product + ' .lg_trade_no_points').removeClass('d-none');
                jQuery('.lg_trade_monthly_' + product + ' .lg_trade_with_points').addClass('d-none');
            }
        }
    });

    jQuery('.owl-carousel.lg_trade_carousel').owlCarousel({
        autoplay: false,
        items: 3,
        responsive: {
            0: {
                items: 1
            },
            768: {
                items: 3
            },
        },
        loop: false,
        nav: true,
        navText: ["<img alt='Previous' src='" + liveglam_custome.get_stylesheet_directory_uri + "/assets/img/arrow-grey-left@2x.png' data-no-lazy='1'>",
                  "<img alt='Next' src='" + liveglam_custome.get_stylesheet_directory_uri + "/assets/img/arrow-grey-right@2x.png' data-no-lazy='1'>"],
        dots: false
    });
    /** end script for trade feature **/

    /** script for rate feature **/

    jQuery('body').on('click', '.rate_kissme', function () {
        lgs_show_rate('kissme');
        return false;
    });

    jQuery('body').on('click', '.rate_morpheme', function () {
        lgs_show_rate('morpheme');
        return false;
    });

    jQuery('body').on('click', '.rate_shadowme', function () {
        lgs_show_rate('shadowme');
        return false;
    });

    function lgs_show_rate(type_product) {
        jQuery.magnificPopup.close();
        jQuery.magnificPopup.open({items: {src: '#lg_view_past_' + type_product}, type: 'inline',fixedContentPos: true,closeOnBgClick:false});
        //lg_restart_rate
        jQuery('#lg_view_past_' + type_product + ' .lg_rate_past_header').removeClass('d-none');
        jQuery('#lg_view_past_' + type_product + ' .lg_view_monthly_before').removeClass('d-none');
        jQuery('#lg_view_past_' + type_product + ' .lg_view_monthly_chosen').addClass('d-none');

    }

    function rating_product() {
        jQuery('.lg_rate_process').each(function () {
            if (jQuery(this).hasClass('lg_rating_product')) {
                var data = jQuery(this).find('.lg_rate_product_info'),
                    rate_collection = data.data('collection'),
                    type = data.data('type_product'),
                    img = data.data('img_url'),
                    number_product = data.data('number_product'),
                    number = data.data('number'),
                    rated = data.data('rated'),
                    added = data.data('added'),
                    view = data.data('view_product'),
                    traded_individual = data.data('traded_individual'),
                    display_name = data.data('display_name'),
                    total_product = data.data('total_product');
                var parent_div = view == '1' ? '#lg_view_past_' + type : '#lg_rate_past_' + type;
                // jQuery(parent_div+' .lg_rate_product_header').trigger("to.owl.carousel", [number, 1, true]);
                if (rate_collection) {
                } else {
                    jQuery(parent_div + ' .lg_rate_content_header .lg_rate_container_title').removeClass('d-none');
                    jQuery(parent_div + ' .lg_rate_content_header .lg_rate_title_product').text(jQuery(this).find('.lg_rate_title_product').text());
                }
                if(traded_individual == 1){
                    jQuery(parent_div + ' .lg_rate_content_header .lg_traded_individual').removeClass('d-none');
                } else {
                    jQuery(parent_div + ' .lg_rate_content_header .lg_traded_individual').addClass('d-none');
                }
                jQuery(parent_div + ' .lg_rate_container_img_' + type + ' img').attr('src', img);
                jQuery(parent_div + ' .lg_before_reason .lg_rate_container_title .display_name').text(' ' + display_name + '?');
                jQuery(parent_div + ' .lg_rate_container_img_' + type + ' .lg_rate_title_product').text(display_name);
                var i = 5,
                    question = jQuery('.lg_rating_product .lg_rate_product_question').val(),
                    answer = jQuery('.lg_rating_product .lg_rate_product_answer').val(),
                    rate_5 = '';
                for (i; i >= 1; i--) {
                    var class_rate = ( i <= rated && added !== 1) ? 'fa-heart lg_product_rate' : 'fa-heart';
                    var rating_product = added == 1 && i <= rated ? 'rated_product' : added == 1 ? '' : 'rating_product';
                    rate_5 = rate_5 + '<i class="fas ' + class_rate + ' ' + rating_product + '" data-product="' + type + '" data-rate="' + i + '" aria-hidden="true"></i>';
                }
                if(rated !=null && rated!=0){
                  jQuery(parent_div + ' .lg_rate_reason').removeClass('d-none');
                }
                if (added == 1) {
                    jQuery(parent_div + ' .lg_rate_questions button').addClass('lg-rated-disable');
                    jQuery(parent_div + ' .lg_rate_questions select').addClass('lg-rated-disable');
                    jQuery(parent_div + ' .lg_answers textarea').addClass('lg-rated-disable');
                    if (total_product == number) {
                        jQuery(parent_div + ' .lg_rate_content_footer button.rate_next_confirm').addClass('d-none');
                    }
                }
                if (question ==''){
                  jQuery(parent_div + ' .lg_rate_content_footer button.rate_next_confirm').addClass('disabled');
                }
                else{
                  jQuery(parent_div + ' .lg_rate_reason').removeClass('d-none');
                }
                jQuery(parent_div + ' .lg_rate_process_' + type).find('i').remove();
                jQuery(parent_div + ' .lg_rate_process_' + type).html(rate_5);
                jQuery(parent_div + ' .lg_rate_questions').val(question).trigger('change.select2');
                jQuery(parent_div + ' .lg_answers textarea').val(answer);
                jQuery(parent_div + ' .lg_number_product').text(number_product);
                if (rated > 0) {
//                        next_step(type);
                    check_product(type, view);
                }
                jQuery(parent_div + ' .lg_rate_reason .lg_rate_container_title').addClass('d-none');
                jQuery(parent_div + ' .lg_rate_reason .lg_rate_container_title.lg_rated_' + rated).removeClass('d-none');
                jQuery(parent_div + ' .lg_question .lg_rate_questions').addClass('d-none');
                if (rated > 3) {
                    if (rate_collection) {
                        jQuery(parent_div + ' .lg_question.lg-level-rate-5.collection-level-rate .lg_rate_questions').removeClass('d-none');
                    } else {
                        jQuery(parent_div + ' .lg_question.lg-level-rate-5.single-level-rate .lg_rate_questions').removeClass('d-none');
                    }
                } else {
                    if (rate_collection) {
                        jQuery(parent_div + ' .lg_question.lg-level-rate-3.collection-level-rate .lg_rate_questions').removeClass('d-none');
                    } else {
                        jQuery(parent_div + ' .lg_question.lg-level-rate-3.single-level-rate .lg_rate_questions').removeClass('d-none');
                    }
                }
                if ((view !== '1' && rated == '') || rated == null) {
                    jQuery(parent_div + ' .lg_rate_content_footer button.rate_next_action').addClass('next_hold_on');
                } else {
                    jQuery(parent_div + ' .lg_rate_content_footer button.rate_next_action').removeClass('next_hold_on');
                }
                jQuery(parent_div + ' .lg_rate_questions').val(question);
                jQuery(parent_div + ' .lg_rate_questions').selectpicker('refresh');
                jQuery(parent_div + ' .lg_rate_container_content .lg_rate_questions').removeClass('lg_rate_error');
                jQuery(parent_div + ' .lg_rate_product_carousel').trigger('destroy.owl.carousel');
                jQuery(parent_div + ' .lg_rate_product_carousel').trigger('destroy.owl.carousel').owlCarousel({
                    autoplay: false,
                    items: 5,
                    loop: false,
                    nav: false,
                    dots: false
                });
                jQuery(parent_div + ' .lg_rate_product_carousel').trigger("to.owl.carousel", [number, 0, true]);
            }
        });
    }

    function previous_step(type, view) {
        var parent_div = view == '1' ? '#lg_view_past_' + type : '#lg_rate_past_' + type;
        jQuery(parent_div + ' .lg_before_reason').removeClass('lg_after_rate');
        jQuery(parent_div + ' .lg_rate_reason').addClass('d-none');
        var n = jQuery(parent_div + ' .lg_rating_product');
    }

    function check_product(type, view) {
        var parent_div = view == '1' ? '#lg_view_past_' + type : '#lg_rate_past_' + type;
        var n = jQuery(parent_div + ' .lg_rating_product');
        jQuery('.mfp-close').show();
        if (n.hasClass('lg_final_step')) {
            jQuery(parent_div + ' .lg_rate_past_content .d-md-flex .col-md-5').addClass('d-none');
            jQuery(parent_div + ' .lg_rate_past_content .lg_rate_content_footer').addClass('mx-auto');
            jQuery(parent_div + ' .lg_rate_past_content .lg_rate_right').addClass('text-center');
            jQuery(parent_div + ' .lg_rate_past_content .d-md-flex .lg_before_reason').addClass('d-none');
            jQuery(parent_div + ' .lg_rate_feedback').removeClass('d-none');
            jQuery(parent_div + ' .lg_rate_content_header .lg_rate_nav.lg_rate_left .lg_rate_title_product').addClass('d-none');
            jQuery(parent_div + ' .lg_rate_content_header .lg_rate_nav.lg_rate_left img').removeClass('d-none');
            jQuery(parent_div + ' .lg_rate_content_footer button.rate_final_confirm').removeClass('d-none');
            jQuery(parent_div + ' .rate_next_confirm').addClass('d-none');
            jQuery(parent_div + ' .lg_rate_reason').addClass('d-none');

        } else {
            jQuery(parent_div + ' .lg_rate_past_content .d-md-flex .col-md-5').removeClass('d-none');
            jQuery(parent_div + ' .lg_rate_past_content .lg_rate_content_footer').removeClass('mx-auto');
            jQuery(parent_div + ' .lg_rate_past_content .lg_rate_right').removeClass('text-center');
            jQuery(parent_div + ' .lg_rated_success').removeClass('d-none');
            jQuery(parent_div + ' .rate_next_confirm').removeClass('d-none');
            jQuery(parent_div + ' .lg_rate_content_footer button.rate_final_confirm').addClass('d-none');
            jQuery(parent_div + ' .lg_rate_content_header .lg_rate_nav.lg_rate_left .lg_rate_title_product').removeClass('d-none');
            jQuery(parent_div + ' .lg_rate_content_header .lg_rate_nav.lg_rate_left img').addClass('d-none');
            jQuery(parent_div + ' .lg_before_reason').removeClass('d-none');
            jQuery(parent_div + ' .lg_rate_feedback').addClass('d-none');
        }
    }

    function check_rate(type, view) {
        var parent_div = view == '1' ? '#lg_view_past_' + type : '#lg_rate_past_' + type;
        var product_rate = jQuery(parent_div + ' .lg_rating_product .lg_rate_product_info').data('rated');
        jQuery(parent_div + ' .lg_rating_process .rating_product').each(function () {
            if (jQuery(this).data('rate') <= product_rate) {
                jQuery(this).addClass('lg_product_rate');
            } else {
                jQuery(this).removeClass('lg_product_rate');
                jQuery(parent_div + ' .lg_rate_reason').addClass('d-none');
            }
        });
    }

    rating_product();

    jQuery('body').on('click', '.lg_rate_content_footer button.rate_back_confirm', function () {
        var type = jQuery(this).data('product'),
            view = jQuery(this).data('view_product');
        var parent_div = view == '1' ? '#lg_view_past_' + type : '#lg_rate_past_' + type;
        jQuery(parent_div + ' .lg_rate_reason').removeClass('d-none');
        jQuery(parent_div + ' .rate_next_confirm').removeClass('disabled');
        var n = jQuery(parent_div + ' .lg_rating_product');
        if (n.hasClass('lg_first_product')) {
            if (view == '1') {
                jQuery('#lg_view_past_' + type + ' .lg_view_monthly_before').removeClass('d-none');
                jQuery('#lg_view_past_' + type + ' .lg_view_monthly_chosen').addClass('d-none');
                jQuery('#lg_view_past_' + type + ' .lg_view_monthly_chosen .lg_rate_past').remove();
            }
            check_product(type, view);
            return;
        }
        var current = jQuery(parent_div + ' .lg_rating_product');
        if (current.hasClass('lg_final_step')) {
            jQuery(parent_div + ' .lg_rating_product').parents('.lg_rate_product_header').find('.lg_last_product').addClass('lg_rating_product');
        } else {
            var prev = current.parent();
            prev.prev().find('.lg_rate_process').addClass('lg_rating_product');
        }
        current.removeClass('lg_rating_product');
        jQuery(parent_div + ' .lg_rating_product').removeClass('lg_rated_step1');
        rating_product();
        next_step(type, view);
        check_product(type, view);
    });

    jQuery('body').on('click', '.lg_rate_content_footer button.rate_next_confirm', function () {
        var type = jQuery(this).data('product'),
            view = jQuery(this).data('view_product');
        var parent_div = view == '1' ? '#lg_view_past_' + type : '#lg_rate_past_' + type;
        var answer = jQuery(parent_div + ' .lg_rate_container_content .lg_answers textarea'),
            question = '',
            current = jQuery(parent_div + ' .lg_rating_product');
        jQuery(parent_div + ' .lg_question select.lg_rate_questions').each(function () {
            var classs = jQuery(this).parent().parent().attr('class');
            if (!jQuery(this).parent().hasClass('d-none')) {
                question = jQuery(this).find('option:selected').val();
            }
        });
        if (question == '' || question == null) {
          return;
        }
        if (question == "What's the dealio?") {
            jQuery(parent_div + ' .lg_question .lg_rate_questions').addClass('lg_rate_error');
            return;
        } else {
            jQuery(parent_div + ' .lg_rating_product .lg_rate_product_question').val(question);
            jQuery(parent_div + ' .lg_rating_product .lg_rate_product_answer').val(answer.val());
        }
        current.addClass('lg_rated_success');
        current.find('.lg_rate_circle_number i').remove();
        current.find('.lg_rate_circle_number').html('<i class="fas fa-check" aria-hidden="true"></i>');
        if (current.hasClass('lg_last_product')) {
            jQuery(parent_div + ' .lg_rating_product').parents('.lg_rate_product_header').find('.lg_final_step.lg_rate_process').addClass('lg_rating_product');
        } else {
            var next_product = current.parent();
            next_product.next().find('.lg_rate_process').addClass('lg_rating_product');
        }
        current.removeClass('lg_rating_product');

        check_rate(type, view);
        rating_product();
        check_product(type, view);
    });

    jQuery('body').on('click', '.lg_rate_content_footer button.rate_final_confirm', function () {
        var type = jQuery(this).data('product'),
            view = jQuery(this).data('view_product');
        var parent_div = view == '1' ? '#lg_view_past_' + type : '#lg_rate_past_' + type;
        var data_feedback = {};
        var i = 0;
        var feedback_comment = jQuery(parent_div + ' .lg_feedback_new textarea').val(),
            month_key = jQuery(parent_div + ' .lg_rate_postid').data('monthly');
        jQuery(parent_div + ' .lg_feedback_item input[type=checkbox]').each(function () {
            if (jQuery(this).is(':checked')) {
                data_feedback[i] = jQuery(this).val();
                i = parseInt(i + 1);
            }
        });
        if (jQuery.isEmptyObject(data_feedback))return;
        var data_rate = {};
        var j = 0;
        jQuery(parent_div + ' .lg_rated_success').each(function () {
            var new_data = {};
            new_data['product_name'] = jQuery(this).find('.lg_rate_title_product').data('product_name');
            new_data['question'] = jQuery(this).find('.lg_rate_product_question').val();
            new_data['answer'] = jQuery(this).find('.lg_rate_product_answer').val();
            new_data['rate'] = jQuery(this).find('.lg_rate_product_info').data('rated');
            new_data['added'] = jQuery(this).find('.lg_rate_product_info').data('added');
            data_rate[j] = new_data;
            j = parseInt(j + 1);
        });
        if (jQuery.isEmptyObject(data_rate))return;
        jQuery(this).addClass('lg_rated_disable');
        var data = {
            'action': 'liveglam_feedback_product_action',
            'data_feedback': data_feedback,
            'feedback_comment': feedback_comment,
            'data_rate': data_rate,
            'post_id': jQuery(parent_div + ' .lg_rate_postid').val(),
            'type': jQuery(this).data('product'),
            'month_key': month_key,
            'subscriptionid': jQuery(parent_div + ' .lg_rate_postid').data('subscriptionid')
        };
        jQuery.post(ajaxurl, data, function (response) {
            if (response.add_feedback = 'success') {
                jQuery(parent_div + ' label.lg_view_past_month').each(function () {
                    var monthkey = jQuery(this).find('input').val();
                    if (monthkey === month_key) {
                        jQuery(this).prepend('<i class="fas fa-check" aria-hidden="true"></i>');
                        jQuery(this).addClass('lg_rated_disable');
                    }
                });
                jQuery(parent_div + ' .lg_rate_past_header').addClass('d-none');
                jQuery(parent_div + ' .lg_rate_past_content').addClass('d-none');
                jQuery(parent_div + ' .lg_rate_thankyou').removeClass('d-none');
                jQuery.magnificPopup.close();
                jQuery.magnificPopup.open({
                    items: {src: '#lg_rate_past_' + type},
                    type: 'inline',
                    fixedContentPos: true,
                    closeOnBgClick:false,
                    callbacks: {
                        close: function () {
                            jQuery('#lg_rate_past_' + type).remove();
                        }
                    }
                });
                jQuery('.mfp-close').hide();
            } else {
                jQuery(this).removeClass('lg_rated_disable');
                jQuery('#lg_rate_past_' + type + ' .lg_rate_past_header').removeClass('d-none');
                jQuery('#lg_rate_past_' + type + ' .lg_rate_past_content').removeClass('d-none');
                jQuery('#lg_rate_past_' + type + ' .lg_rate_thankyou').addClass('d-none');
            }
        }, 'JSON');
    });

    jQuery('body').on('click', '.lg_rate_past_month', function () {
        var current = jQuery(this),
            type = current.find('input[type=hidden]').data('type');
        var data = {
            'action': 'liveglam_get_rated_product_action',
            'type': type,
            'sub_id': current.find('input[type=hidden]').data('sub_id'),
            'month_shipping': current.find('input[type=hidden]').data('month_shipping'),
            'month_key': current.find('input[type=hidden]').data('monthly_key'),
            'order_id': current.find('input[type=hidden]').data('order_id'),
        };
        jQuery.post(ajaxurl, data, function (response) {
            if (response == false) return;
            jQuery('#lg_view_past_' + type + ' .lg_view_monthly_before').addClass('d-none');
            jQuery('#lg_view_past_' + type + ' .lg_view_monthly_chosen').removeClass('d-none');
            jQuery('#lg_view_past_' + type + ' .lg_view_monthly_chosen .lg_rate_past').remove();
            jQuery('#lg_view_past_' + type + ' .lg_view_monthly_chosen').append(response);
            jQuery('#lg_view_past_' + type + ' .lg_view_monthly_chosen .owl-carousel.lg_rate_product_carousel').owlCarousel({
                autoplay: false,
                autoplayHoverPause: true,
                margin: 10,
                autoWidth: true,
                items: 5,
                loop: false,
                nav: false,
                dots: false
            });
            rating_product();
        });
        return false;
    });

    jQuery('body').on('click', '.lg_rating_process .rating_product', function () {
        var type = jQuery(this).data('product'),
            view = jQuery(this).data('view_product'),
            rate = jQuery(this).data('rate');
        jQuery('#lg_rate_past_' + type + ' .lg_rating_product .lg_rate_product_info').data('rated', rate);
        var parent_div = view == '1' ? '#lg_view_past_' + type : '#lg_rate_past_' + type;
        jQuery(parent_div + ' .lg_rate_reason').removeClass('d-none');
        jQuery(parent_div+ ' .rate_next_confirm').addClass('disabled');
        rating_product();
    });

    jQuery('body').on('change', '.lg_feedback_item .checkbox', function() {
      var data_feedback = {};
      var i = 0;
      jQuery('.lg_feedback_item input[type=checkbox]').each(function() {
          if (jQuery(this).is(':checked')) {
            data_feedback[i] = jQuery(this).val();
            i = parseInt(i + 1);
          }
      });
      if (!jQuery.isEmptyObject(data_feedback)) {
        jQuery('.rate_final_confirm').removeClass('disabled');
      } else{
        jQuery('.rate_final_confirm').addClass('disabled');
      }
    });

    jQuery('body').on('change', '.lg_rate_container_content .lg_rate_questions.lg_rate_error', function () {
        if (jQuery(this).val() !== '' || jQuery(this).val() !== null) {
            jQuery(this).removeClass('lg_rate_error');
        }
    });

  jQuery('body').on('change', '.lg_rate_container_content .lg_rate_questions', function() {
      var parent_div = jQuery(this).closest('.lg_rate_past_content');
      jQuery(parent_div).find(' .rate_next_confirm').removeClass('disabled');
  });

    jQuery('.owl-carousel.lg_rate_product_carousel').owlCarousel({
        autoplay: false,
        autoplayHoverPause: true,
        items: 5,
        loop: false,
        nav: false,
        dots: false
    });

    /** end script for rate feature **/

});