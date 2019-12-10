jQuery(document).ready(function() {
    jQuery(window).load(function () {
      var country_show_cookie_consent = jQuery('input[name="cookie-consent-allow-country"]').val(),
        site_url = jQuery('input[name="cookie-consent-site-url"]').val();
      if( country_show_cookie_consent.length > 0 ) {
        jQuery.get(site_url, function (data) {
          country_show_cookie_consent = country_show_cookie_consent.split(',');
          if ( jQuery.inArray(jQuery.trim(data), country_show_cookie_consent) == -1 ) {
            show_collection_popup();
          }
        });
      } else {
        show_collection_popup();
      }
    });

  function show_collection_popup(){
    var email_collection_popup = Cookies.get('email_collection_popup');
    if ('undefined' == typeof email_collection_popup) {
      setTimeout(function(){
        jQuery('.email-collection-popup').addClass('active');
      }, 10000);
    }
  }

    jQuery('.email-collection-popup .mask, .email-collection-popup .close').on('click', function() {
        closeCollectionModal();
    });

    jQuery(document).keyup(function(e) {
        if (e.keyCode == 27) {
            closeCollectionModal();
        }
    });

    jQuery('.email-collection-popup .collection-modal .collection-next-step').on('click', function() {
        if (jQuery('.email-collection-popup .collection-modal.collection-step-1').hasClass('active')) {
            var glam_email = jQuery(".get_glam_email").val();
            if (glam_email === "") {
                jQuery(".error-message").text('Email is required!');
                return false;
            }
            if(!checkemail(glam_email)){
                jQuery(".error-message").text('Please enter a valid email address.');
                return false;
            }
            jQuery(".btn_get_glam").html("<i class=\'fas fa-spinner\' aria-hidden=\'true\'></i>");
            var data 	= {
                'action' : 'mailchimp_add_liveglam_updates_list',
                'glam_email' :glam_email
            };

            jQuery.post(ajaxurl, data, function(response) {
                jQuery('.email-collection-popup .collection-modal.collection-step-1').removeClass('active');
                if (response === 'success') {
                    jQuery('.email-collection-popup .collection-modal.collection-step-2').addClass('active');
                } else {
                    jQuery('.email-collection-popup .collection-modal.collection-step-3').addClass('active');
                }
                setEmailCollectionPopupCookie();
            });
        }
    });

    function closeCollectionModal() {
        jQuery('.email-collection-popup').removeClass('active');
        setEmailCollectionPopupCookie();
    }

    function setEmailCollectionPopupCookie() {
        jQuery.cookie('email_collection_popup', 'visited', { expires: 7, path: '/' });
    }

    function checkemail(email) {
        email = jQuery.trim(email);
        var regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
        return regex.test(email);
    }
});