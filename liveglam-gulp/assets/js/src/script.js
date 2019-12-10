jQuery(document).ready(function($){
	
	/** 
	 * Header Shop Search Block 
	 * */

	var request, typeSearchTimer;

	// Hide header search block on close button clicked
	$('.lg-search-search-box__close').on('click', function() {
		$('#lg-search-overlay').toggleClass("visible");
		$('body').toggleClass("view--search-active");

		// Clear search
		if ($.active > 0 && request) request.abort();
		$('.lg-search-search-box__text-input').val('');
		$('#lg-search-overlay .loading').addClass('d-none');
		$('#lg-search-overlay .search-zero-state').removeClass('d-none');
		$('#lg-search-overlay .lg-search-results-container').empty();
		$('#lg-search-overlay .lg-search-layout-sidebar').empty();
		$('#lg-search-overlay .no-result').addClass('d-none');
		$('#lg-search-overlay .lg-search-paging-info').addClass('d-none');
		$('#lg-search-overlay .empty-search-state').addClass('d-none');
		$('#lg-search-overlay .lg-search-pagination').addClass('d-none');
	});

	// Toggle show/hide header search block on header search icon click
	$('.btn-search').on('click', function() {
		$('#lg-search-overlay').toggleClass("visible");
		$('body').toggleClass("view--search-active");
	});
	
	// Get suggested products on search input change
	$('body').on('keyup', '.lg-search-search-box__text-input', function() {
		var $this = this;
		if (typeSearchTimer) clearTimeout(typeSearchTimer);
		typeSearchTimer = setTimeout(function() { getSuggestions($this); }, 500);
	});

	// Get suggested products on search input change
	$('.lg-search-layout').on('change', '.lg-search-multi-value-facet__checkbox', function() {
		const wrapper = $(this).closest('.lg-search-layout');
		wrapper.find('.lg-search-multi-value-facet__checkbox').prop('checked', false);
		$(this).prop('checked', true);
		const tag = $(this).parent().find('.lg-search-multi-value-facet__input-text').text();

		if (tag == 'All') {
			wrapper.find('.lg-search-results-container .lg-search-result').removeClass('d-none');
		} else {
			wrapper.find('.lg-search-results-container .lg-search-result').each(function() {
				if ($(this).find('.result-tag').text() !== tag) $(this).addClass('d-none');
				else $(this).removeClass('d-none');
			});
		}

		$('.lg-search-layout-body').animate({ scrollTop: 0 }, 500);
		updatePagination(wrapper);

	});
	
	function getSuggestions(obj) {
		wrapper = $(obj).closest('.lg-search-layout').parent();
		if ($.active > 0 && request) request.abort();
		var p_text = $(obj).val();
		
		if (p_text.trim() == '') {
			wrapper.find('.empty-search-state').removeClass('d-none');
			wrapper.find('.search-zero-state').addClass('d-none');
			wrapper.find('.no-result').addClass('d-none');
			wrapper.find('.lg-search-results-container').empty();
			wrapper.find('.lg-search-layout-sidebar').empty();
			return;
		}

		wrapper.find('.empty-search-state').addClass('d-none');
		wrapper.find('.loading').removeClass('d-none');
		wrapper.find('.search-zero-state').addClass('d-none');
		wrapper.find('.no-result .no-result-main span').text(p_text);

		var data = { 'action': 'lg_ajax_search', 's': p_text, 'cat': 617, 'page':250 };
		request = $.post(ajaxurl, data, function(response) {
			wrapper.find('.loading').addClass('d-none');
			showSuggestions(response, obj);
		}, 'JSON');
	}

	function showSuggestions(data, obj) {
		var results = data['suggestions'];
		var sidebar = data['sidebar'];
		wrapper = $(obj).closest('.lg-search-layout').parent();

		if ( !results.length ) {
			wrapper.find('.no-result').removeClass('d-none');
			wrapper.find('.lg-search-layout-sidebar').css('opacity', 0);
			// wrapper.find('.lg-search-paging-info').addClass('d-none');
		} else {
			wrapper.find('.no-result').addClass('d-none');
			wrapper.find('.lg-search-layout-sidebar').css('opacity', 1);
			// wrapper.find('.lg-search-paging-info').removeClass('d-none');
		}

		// wrapper.find('.lg-search-paging-info').text(data['total'] + ' results found');

		wrapper.find('.lg-search-results-container').empty();
		wrapper.find('.lg-search-layout-sidebar').empty();


		results_str = '';

		for (i = 0; i < results.length; i++ ) {
			results_str += '<a href="' + results[i]['url'] + '" target="_blank" class="lg-search-result" id="result-' + results[i]['id'] + '">';
			results_str += 	'<div class="result-content">';
			results_str += 		'<h4 class="result-title">' + results[i]['title'];
			if (results[i]['price'] != '') results_str += '<span class="result-price">&nbsp;|&nbsp;' + results[i]['price'] + '</span>';
			results_str += 		'</h4>';
            results_str += 		'<div class="result-description">' + results[i]['desc'] + '</div>';
            results_str += 		'<div class="result-footer">';
			results_str += 			'<span class="result-tag">' + results[i]['tag'] + '</span>';
            results_str += 			'<span class="result-link">View ></span>';
			results_str += 		'</div>';
			results_str += 	'</div>';
			results_str += 	(results[i]['img'] != '') ? ('<div class="result-image">' + results[i]['img'] + '</div>') : '';
			results_str += '</a>';
		}

		wrapper.find('.lg-search-results-container').append(results_str);
		updatePagination(wrapper);


		sidebar_str = '';

		var entries = Object.entries(sidebar);
		for (var [group, count] of entries) {
			sidebar_str += 	'<div class="lg-search-multi-value-facet lg-search-facet">';
			sidebar_str += 		'<label for="' + group + '" class="lg-search-multi-value-facet__option-label">';
			sidebar_str += 			'<div class="lg-search-multi-value-facet__option-input-wrapper">';
			sidebar_str += 				'<input id="' + group + '" type="checkbox" class="lg-search-multi-value-facet__checkbox" ' +  ((group == 'All') ? 'checked=""' : '') +'>';
			sidebar_str += 				'<span class="lg-search-multi-value-facet__input-text">' + group + '</span>';
			sidebar_str += 				'<span class="lg-search-multi-value-facet__option-count">' + count + '</span>';
			sidebar_str += 			'</div>';
			sidebar_str += 		'</label>';
			sidebar_str += '</div>';
		}
		wrapper.find('.lg-search-layout-sidebar').append(sidebar_str);
		
	}
	
	function updatePagination(wrapper) {
		numPerPage = 10; // This can be added to backend option
		results = wrapper.find('.lg-search-results-container a:not(.d-none)');

		wrapper.find('.lg-search-results-container a').removeAttr('style');
		results.css('display', 'none');
		results.slice( 0, numPerPage ).removeAttr('style');

		wrapper.find('.lg-search-pagination').pagination({
			items: results.length,
			itemsOnPage: numPerPage,
			currentPage: 1,
			prevText: '<i class="fas fa-chevron-left" aria-hidden="true"></i>',
			nextText: '<i class="fas fa-chevron-right" aria-hidden="true"></i>',
			onPageClick: function (page, evt) {
				results.css('display', 'none');
				results.slice( (page-1)*numPerPage, page*numPerPage ).removeAttr('style');
				$('.lg-search-layout-body').animate({ scrollTop: 0 }, 500);
			}
		});
	}

	/* Carousel Begin */
	var newClubsStopped, reviewSliderStopped, blogSliderStopped, morphemeStopped;
	var currentWidth = jQuery(window).width();

	jQuery('.owl-carousel.normal').owlCarousel({
		autoplay:true,
		autoplayTimeout:5000,
		autoplayHoverPause:true,
		items: 2,
		loop:true,
		nav:true,
		navText: ["<img src='"+liveglam_custome.get_stylesheet_directory_uri+"/assets/img/left_arrow.png'>",
			"<img src='"+liveglam_custome.get_stylesheet_directory_uri+"/assets/img/right_arrow.png'>"],
	});
	jQuery('#carousel2').owlCarousel({
		autoplay:true,
		autoplayTimeout:5000,
		autoplayHoverPause:true,
		items: 1,
		loop:true,
		nav:true,
		navText: ["<img src='"+liveglam_custome.get_stylesheet_directory_uri+"/assets/img/left_arrow.png'>",
			"<img src='"+liveglam_custome.get_stylesheet_directory_uri+"/assets/img/right_arrow.png'>"],
	});

	jQuery('.carousel-share').owlCarousel({
		autoplay:false,
		autoplayTimeout:5000,
		autoplayHoverPause:true,
		items: 6,
		responsive:{
			0:{
				items:2
			},
			481:{
				items:4
			},
			1025:{
				items:6
			}
		},
		loop:true,
		nav:true,
		navText: ["<img src='"+liveglam_custome.get_stylesheet_directory_uri+"/assets/img/left_arrow.png'>",
			"<img src='"+liveglam_custome.get_stylesheet_directory_uri+"/assets/img/right_arrow.png'>"],
		dots: false
	});

	function isOnSection(identifierDesktop, identifierMobile) {
		var currentTop = jQuery(window).scrollTop();
		var currentBottom = currentTop + jQuery(window).height();

		if(currentWidth >= 768) {
			if(jQuery(identifierDesktop).length === 0) return false;
			var sectionTop = jQuery(identifierDesktop).offset().top;
			var sectionBottom = sectionTop + jQuery(identifierDesktop).height();
		} else {
			if(jQuery(identifierMobile).length === 0) return false;
			var sectionTop = jQuery(identifierMobile).offset().top;
			var sectionBottom = sectionTop + jQuery(identifierMobile).height();
		}

		if(currentTop < sectionTop && sectionBottom < currentBottom) {
			return true;
		} else {
			return false;
		}
	}

	/* Carousel End */

	jQuery( "#accordion1 .accordion-toggle" ).click(function() {
		jQuery('#accordion2 .panel-collapse.show').collapse('hide');
	});
	jQuery( "#accordion2 .accordion-toggle" ).click(function() {
		jQuery('#accordion1 .panel-collapse.show').collapse('hide');
	});
	jQuery('.card').on('show.bs.collapse', function () {
		jQuery(this).addClass('panel-opened');
		jQuery(this).find('.fas').removeClass('fa-plus').addClass('fa-minus');
	});
	jQuery('.card').on('hide.bs.collapse', function () {
		jQuery(this).removeClass('panel-opened');
		jQuery(this).find('.fas').removeClass('fa-minus').addClass('fa-plus');
	});
	jQuery('.commission').on('show.bs.collapse', function () {
		jQuery(this).addClass('panel-opened');
		jQuery(this).find('.fas.fa-chevron-down').removeClass('fa-chevron-down').addClass('fa-chevron-up');
	});
	jQuery('.commission').on('hide.bs.collapse', function () {
		jQuery(this).removeClass('panel-opened');
		jQuery(this).find('.fas.fa-chevron-up').removeClass('fa-chevron-up').addClass('fa-chevron-down');
	});
	jQuery('body').on('click', '.dashboard-content .dashboard-menu-nav li a',function(){
		var current = jQuery(this);
		current.closest('.dashboard-menu-nav').find('li.active').removeClass('active');
		//current.closest('li').addClass('active');
	});

	jQuery('body').on('click', 'section.choose-plan ul.plans li .plan-footer .txt-choose', function() {
		var width = (window.innerWidth > 0) ? window.innerWidth : screen.width;
		if (width <= 767) {
			var current_li = jQuery(this).closest('li'),
				link = current_li.find('.plan-footer').data('link');
			var rs = check_limit_lesdo(current_li,link);
			if(rs == true) {
				return false;
			}
			location.href = link;
		}
	});

	jQuery('body').on('click', 'section.choose-plan ul.plans li .plan-footer', function() {
		var width = (window.innerWidth > 0) ? window.innerWidth : screen.width;
		if(width <= 767){
			return false;
		}
		var current_li = jQuery(this).closest('li'),
				link = current_li.find('.plan-footer').data('link'),
				product = current_li.find('.plan-footer').data('product'),
				title = jQuery('#LGP_'+product).data('title'),
				price = jQuery('#LGP_'+product).data('price');
		if(!current_li.hasClass('active')){
			current_li.closest('ul.plans').find('li.active').removeClass('active');
			current_li.closest('section.choose-plan').find('.btn-proceed').attr('href', link);
			current_li.closest('section.choose-plan').find('.btn-proceed').data('title',title);
			current_li.closest('section.choose-plan').find('.btn-proceed').data('price',price);
			current_li.closest('section.choose-plan').find('.btn-proceed').data('product',product);
			current_li.toggleClass('active');
		} else {
			var rs = check_limit_lesdo(current_li,link);
			if(rs == true) {
				return false;
			}
			location.href = link;
		}
	});

	jQuery('body').on('click', 'a.limit_lesdo_sub', function() {
    var link = jQuery(this).attr('href');
    var rs = check_limit_lesdo(jQuery(this),link);
    if(rs == true) {
      return false;
    }
  });

  jQuery('body').on('click', '.popup-limit-lesdo-sub a.btn-ignore', function() {
    Cookies.remove('_km_save_name_ref');
    var link = jQuery(this).data('link');
    location.href = link;
    return false;
  });

	function check_limit_lesdo(element,link) {
		var users_code = jQuery('input#sale-lesdo-code').val(),
			current_ref = Cookies.get( '_km_save_name_ref' );
		if ("undefined" != typeof users_code && "undefined" != typeof current_ref) {
			users_code = users_code.split(',');
			if (users_code.length > 0 && current_ref.length > 0 && jQuery.inArray(current_ref, users_code) != -1) {
				if (element.hasClass('limit_lesdo_sub') && jQuery('.woocommerce-error-popup.popup-limit-lesdo-sub').length != 0) {
					jQuery.magnificPopup.open({
						items: {src: ".woocommerce-error-popup.popup-limit-lesdo-sub"},
						type: "inline",
						closeOnContentClick: false,
						closeOnBgClick: false,
						showCloseBtn: false
					});
					jQuery('.woocommerce-error-popup.popup-limit-lesdo-sub .btn-apply').attr('href', link);
					return true;
				}
			}
		}
		return false;
	}

	jQuery('body').on('click', 'section.choose-plan ul.plans li .plan-body', function() {
		var current_li = jQuery(this).closest('li'),
				link = current_li.find('.plan-footer').data('link'),
				product = current_li.find('.plan-footer').data('product'),
				title = jQuery('#LGP_'+product).data('title'),
				price = jQuery('#LGP_'+product).data('price');
		current_li.closest('ul.plans').find('li.active').removeClass('active');
		current_li.closest('section.choose-plan').find('.btn-proceed').attr('href',link);
		current_li.closest('section.choose-plan').find('.btn-proceed').data('title',title);
		current_li.closest('section.choose-plan').find('.btn-proceed').data('price',price);
		current_li.closest('section.choose-plan').find('.btn-proceed').data('product',product);
		current_li.toggleClass('active');
		var width = (window.innerWidth > 0) ? window.innerWidth : screen.width;
		if (width <= 767) {
			current_li.after(current_li.closest('section.choose-plan').find('.cta-process'));
		}
	});

	/* script buy points */
	jQuery('body').on('click', '.redeem-items-product .show_offer', function () {
		jQuery.magnificPopup.open({
			items: { src: '#show_offer' },
			type: 'inline',
			callbacks:{
				beforeOpen:function(){
					setTimeout(function(){ jQuery('.mfp-bg.mfp-ready').addClass('buy-points'); }, 100);
				}
			}});
		return false;
	});

	jQuery('body').on('change','select#load_points', function () {
		change_href_buy_points();
	});
	change_href_buy_points();

	function change_href_buy_points(){
		var link = jQuery('select#load_points option:selected').val();
		jQuery('a.btn_purchase').attr('href',link);
	}
	/* end script buy points */

	jQuery(function () {
		jQuery('body').on('click', '.faq-products .item-faq-nav',function () {
			if (location.pathname.replace(/^\//, '') == this.pathname.replace(/^\//, '') && location.hostname == this.hostname) {
				var width = (window.innerWidth > 0) ? window.innerWidth : screen.width;
				var faq_item = jQuery(this),
					heigh = jQuery('.fixed-top').height() + 15;
				if(width <= 767){
					var st = jQuery(window).scrollTop();
					var ot = jQuery("#scroller-anchor").offset().top;
					if(st < ot){
						heigh = jQuery('.fixed-top').height() + jQuery('.faq-nav').height() + 90;
					} else {
						heigh = jQuery('.fixed-top').height() + jQuery('.faq-nav').height() + 30;
					}
				}
				faq_item.parent().find('.faq-nav-item').removeClass('active');
				faq_item.find('.faq-nav-item').addClass('active');

				var target = jQuery(this.hash);
				target = target.length ? target : jQuery('[name=' + this.hash.slice(1) + ']');
				if (target.length) {
					jQuery('html, body').animate({
						scrollTop: target.offset().top - heigh
					}, 1000);
					return false;
				}
			}
			return false;
		});
	});
	/* end add script faq's page */

	jQuery(function () {
		jQuery('body').on('click', '.scroll-element',function () {
			if (location.pathname.replace(/^\//, '') == this.pathname.replace(/^\//, '') && location.hostname == this.hostname) {
				var target = jQuery(this.hash);
        lgs_scroll_to_element(target);
			}
			return false;
		});
	});

	function moveScroller() {

		var move = function() {
			var width = (window.innerWidth > 0) ? window.innerWidth : screen.width;
			var ps_top = "0px";
			if( width < 767 ) {
				ps_top = "59px";
			}
			if( jQuery('.dashboard-content div.nav').hasClass('scroller-target')) {
				var st = jQuery(window).scrollTop();
				var ot = jQuery("#scroller-anchor").offset().top;
				var s = jQuery(".scroller-target");
				if (st > ot) {
					s.addClass('sticky');
					s.css({
						position: "fixed",
						top: ps_top
					});
				} else {
					if (st <= ot) {
						s.removeClass('sticky');
						s.css({
							position: "relative",
							top: ""
						});
					}
				}
			}

			if( jQuery('.scrollspy').hasClass('sticky')){
				var dt_link = [];
				jQuery('.scrollspy ul.dashboard-menu-nav li a').each(function () {
					dt_link.push(jQuery(this).attr('href'));
				});
				for (var i = 0; i < dt_link.length; ++i) {
					var link = dt_link[i];
					if(scrollspyMove(link) == 1){
						link = link.replace("#","e-");
					   jQuery('.scrollspy ul.dashboard-menu-nav li.active').removeClass('active');
					   var current = jQuery('.scrollspy ul.dashboard-menu-nav li a.'+link+'');
					   current.closest('li').addClass('active');
					}
				}
			}
		};
		jQuery(window).scroll(move);
		move();
	}

	function scrollspyMove(taget) {
		var viewTop = jQuery(window).scrollTop() + jQuery('.scroller-target').height() + jQuery('.mobile-nav-bar').height(),
			elemTop = Math.round(jQuery(taget).offset().top),
			elemBot = Math.round(elemTop + jQuery(taget).height());
		if( elemTop <= viewTop && viewTop <= elemBot){
			return 1;
		}
		return 0;
	}
	jQuery(function() { moveScroller();});

	/* add script for send invites email */
	jQuery("body").on( "click", ".section-send-email-invites .send_email_invites", function () {
		var current = jQuery(this).closest("div.section-send-email-invites"),
			friendemails = current.find(".email_invites").val(),
			product = current.find("input.type-product").val();

		var show_error = false;
		if (friendemails === "") {
      show_error = true;
		} else {
      var emailArray = friendemails.split(",");
      for (i = 0; i <= (emailArray.length - 1); i++) {
        if (!checkemail(emailArray[i])) {
          show_error = true;
        }
      }
    }

		if( show_error ){
      jQuery("#send_email_invites_success").html("<div class='email_invites_header failed'><img src='"+liveglam_custome.get_stylesheet_directory_uri+"/assets/img/popup-cancel-black.svg'><h2>Oops.</h2></div><div class='email_invites_footer'><p>Something went wrong with what you entered! Wanna give it another go? Need help? <a href='"+liveglam_custome.home_url+"/contact-us/'>Contact us!</a></p><button class='btn btn-close-mfp btn-primary'>OK, GOT IT</button></div>");
      jQuery.magnificPopup.open({ items: { src: "#send_email_invites_success" }, type: "inline" });
      jQuery(".mfp-content").addClass("send-email-invites-popup popup-email-invite");
      return false;
    }

		current.find("button.send_email_invites").addClass('sending').text("Sending...");
		current.find("button.send_email_invites").prop("disabled", true);
		current.find("button.send_email_invites").css("background-color","#53cd84");
		var dataparam = ({
			action: "send_email_refer_friends_ajax_request",
			friendemails: friendemails,
			product: product
		});
		jQuery.post( ajaxurl, dataparam, function (response) {
			current.find("button.send_email_invites").removeClass('sending').text("Send");
			current.find("button.send_email_invites").prop("disabled", false);
			current.find("button.send_email_invites").css("background-color","#fff");
			current.find("input.email_invites").val("");
			jQuery("#send_email_invites_success").html("<div class='email_invites_header success'><img src='"+liveglam_custome.get_stylesheet_directory_uri+"/assets/img/popup-check-black.svg'><h2>Yasss!</h2></div><div class='email_invites_footer'><p>Your invite has been sent! Tell more friends to increase your chances of getting awesome Reward prizes!</p><button class='btn btn-close-mfp btn-primary'>OK, GOT IT</button></div>");
			jQuery.magnificPopup.open({ items: { src: "#send_email_invites_success" }, type: "inline" });
			jQuery(".mfp-content").addClass("send-email-invites-popup popup-email-invite");
		});
		return false;
	});
	/* end add script for send invites email */

	jQuery('body').on('click','button.btn-close-mfp',function () {
		jQuery.magnificPopup.close();
		jQuery('.woocommerce-error-popup,.woocommerce-success-popup').remove();
		return false;
	});

	/** add script for Join our Newsletter */
	jQuery('body').on( 'click','#send_newletter .btn_sendmail',function () {
		var newletter = jQuery(".email_news").val();
    jQuery('.email_news_error').text('');
		if (newletter === "") {
		  jQuery('.email_news_error').text('Email is required!');
		  return false;
		}
		if(!checkemail(newletter)){
      jQuery('.email_news_error').text('Please enter a valid email address.');
		  return false;
		}
		jQuery(".btn_sendmail").html('<span class="fas fa-spinner" aria-hidden="true"></span>');
		var data 	= {
			'action' : 'mailchimp_add_newletter_list',
			'newletter' :newletter
		};

		jQuery.post(ajaxurl, data, function(response) {
			jQuery.magnificPopup.open({ items: { src: "<i class='fas fa-paper-plane' aria-hidden='true' style='font-size: 4em;'></i>"+response }, type: "inline" });
			jQuery(".btn_sendmail").html('<span class="fas fa-chevron-right" aria-hidden="true"></span>');
			jQuery(".mfp-bg").addClass("news_bg");
			jQuery(".mfp-content").addClass("custom_popup popup-email-invite");
			jQuery('.popup-email-invite.custom_popup i .mfp-close').remove();
		});
		return false;
	});
	/** end script for Join our Newsletter */

	function checkemail(email) {
		email = jQuery.trim(email);
		var regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
		return regex.test(email);
	}

		jQuery('.stats_slider.owl-carousel').owlCarousel({
			autoplay: true,
			autoplayTimeout: 8000,
			autoplayHoverPause: true,
			smartSpeed: 750,
			autowidth: true,
			nav: false,
			dots: true,
			items: 1,
			loop: false,
		});

	/** script for view-order page **/
	jQuery('body').on('click','.review-order .rating_order',function(){
		var current = jQuery(this),
			rating_order = current.data('rate'),
			order_id = current.data('order_id');
		//if(current.hasClass('disabled')) return false;
		var data = {
			'action'         : 'rating_for_order',
			'rating_order'   : rating_order,
			'order_id'       : order_id
		};
		jQuery('.rating_order').each(function(){
			jQuery(this).removeClass('rating_order');
			var rate = jQuery(this).data('rate');
			if(rate <= rating_order){
				jQuery(this).removeClass('fas fa-star');
				jQuery(this).addClass('fas fa-star');
			}else{
				jQuery(this).addClass('fas fa-star');
				jQuery(this).removeClass('fas fa-star');

			}
		});
		jQuery.post(ajaxurl, data, function(response) {},'json');
	});
	/** end script for view-order page **/

	/** add script for hide/show menu when scroll down/up in dashboard **/
	var prevScrollpos = window.pageYOffset;
	jQuery(document).on('scroll',function () {
		var currentScrollPos = window.pageYOffset;
		if (prevScrollpos > currentScrollPos || prevScrollpos <= 60) {
			jQuery('.pg-dashboard .mobile-nav-bar').attr('style', 'top: 0');
		} else {
			jQuery('.pg-dashboard .mobile-nav-bar').attr('style', 'top: -6rem');
		}

		prevScrollpos = currentScrollPos;
  	});

	/** script on confirmation pages **/
	jQuery('.subscribe-confirmation .actions .action').on('click',function(){
		var current = jQuery(this),
			step = current.data('step');
		if( step != 0 ){
			jQuery('.subscribe-confirmation').hide();
			jQuery('.subscribe-confirmation.step'+step).show();
			jQuery('html, body').animate({ scrollTop: 0 },500);
			return false;
		}
	});

	/** script for special code on join now popup **/
	jQuery('body').on('click','.lgjn_submit_referral',function() {
		var current = jQuery(this),
			product = current.closest('.lgjn_referral_form').find('.lgjn_referral_type').val(),
			code = current.closest('.lgjn_referral_form').find('.lgjn_referral_code').val();

		var data = {
			'action': 'liveglam_join_now_check_referral',
			'code': code,
			'product': product
		};
		if( code == '' ){
			current.closest('.lgjn_referral_code_form').find('.lgjn_referral_message').text('Please enter the code ...');
			return false;
		}
		current.closest('.lgjn_referral_code_form').find('.lgjn_referral_message').text('Checking code ...');
		jQuery.post(ajaxurl, data, function(response) {
			current.closest('.lgjn_referral_code_form').find('.lgjn_referral_message').text(response.message);
      if( response.link_redirect != false ){
        window.location.replace( response.link_redirect );
      }
			if( response.need_update == true ){
				current.closest('.join-now-step2').find('ul.plans li.monthly-plan .plan-footer').data('link',response.link_update['link_ml']);
				current.closest('.join-now-step2').find('ul.plans li.sixmonth-plan .plan-footer').data('link',response.link_update['link_sm']);
				current.closest('.join-now-step2').find('ul.plans li.annual-plan .plan-footer').data('link',response.link_update['link_an']);
				current.closest('.join-now-step2').find('ul.plans li.monthly-plan .plan-body').click();
			}
		}, 'json');

		return false;
	});

	if(jQuery('.woocommerce-success-popup').html() !=='' && jQuery('.woocommerce-success-popup').length > 0){
		jQuery.magnificPopup.open({
			items:{src:'.woocommerce-success-popup'},
			type:'inline',
			closeOnContentClick: false,
			closeOnBgClick: false,
			showCloseBtn: false
		});
	}
	var checkWidth = (window.innerWidth > 0) ? window.innerWidth : screen.width;
	
	var table_leaderboard = '.table.table-leaderboard tbody tr',
		table_ld_numPerPage = 10,
		table_ld_totalItem = jQuery(table_leaderboard).length,
		table_ld_numPages = Math.ceil( table_ld_totalItem / table_ld_numPerPage );
	set_pagination_ld('#pagination-leaderboard', table_leaderboard, table_ld_numPages, table_ld_numPerPage);
	go_to_page_ld( table_leaderboard, 1, table_ld_numPerPage );

	function set_pagination_ld(element, element_selected, numPages, numPerPage) {
		var obj = jQuery(element).pagination({
			items: numPages,
			itemOnPage: numPerPage,
			currentPage: 1,
			cssStyle: '',
			prevText: '<i class="fas fa-chevron-left" aria-hidden="true"></i>',
			nextText: '<i class="fas fa-chevron-right" aria-hidden="true"></i>',
			onInit: function () {},
			onPageClick: function (page, evt) {
				go_to_page_ld( element_selected, page, numPerPage );
			}
		});
	}
	function go_to_page_ld( e, currentPage, numPerPage ) {
		jQuery(e).hide().slice( (currentPage - 1) * numPerPage, currentPage * numPerPage).show();
	}

	//close tooltip
  jQuery("body").on("click",".btn_close_tooltip,.dashboard-select-month.bootstrap-select button",function(){
    if( jQuery('.archive-tooltip').length > 0 ) {
      jQuery(".archive-tooltip").remove();
      jQuery.post(ajaxurl, {"action": "check_show_top_tooltip"}, function (response) {
      });
    }
  });

	/** new review block **/
  var new_reviews_one = jQuery('.new-reviews.new-reviews-one');
  new_reviews_one.on('initialized.owl.carousel', function(event){
    changeReviewImage();
  });

  new_reviews_one.owlCarousel({
    autoplay:false,
    autoplayTimeout:5000,
    autoplayHoverPause:true,
    items: 1,
    loop:true,
    nav:false,
    dots:true,
    navText: ["<img src='" + liveglam_custome.get_stylesheet_directory_uri + "/assets/img/left_arrow.png'>",
      "<img src='" + liveglam_custome.get_stylesheet_directory_uri + "/assets/img/right_arrow.png'>"],
    onTranslated: changeReviewImage
  });


  var new_reviews_two = jQuery('.new-reviews.new-reviews-two');
  new_reviews_two.on('initialized.owl.carousel', function(event){
    changeReviewImage();
  });

  new_reviews_two.owlCarousel({
    autoplay:false,
    autoplayTimeout:5000,
    autoplayHoverPause:true,
    responsive:{
      0:{
        items:1
      },
      768:{
        items:2
      }
    },
    loop:true,
    nav:true,
    dots:false,
    navText: ["<img src='" + liveglam_custome.get_stylesheet_directory_uri + "/assets/img/left_arrow.png'>",
      "<img src='" + liveglam_custome.get_stylesheet_directory_uri + "/assets/img/right_arrow.png'>"],
    onTranslated: changeReviewImage
  });

  function changeReviewImage() {
    jQuery('.new-reviews-dots .new-reviews-dots-lists .new-reviews-dots-item:visible').removeClass('active');
    jQuery('.new-reviews .owl-item.active:visible').each(function () {
      var sliderID = jQuery(this).find('.new-reviews-content').data('slider-id');
      jQuery('.new-reviews-dots .new-reviews-dots-lists .new-reviews-dots-item[data-slider-id="'+sliderID+'"]:visible').addClass('active');
    });
  }

  jQuery('body').on('click','.new-reviews-dots .new-reviews-dots-lists .new-reviews-dots-item',function () {
    var sliderID = jQuery(this).data('slider-id');
    new_reviews_one.trigger('to.owl.carousel', sliderID);
    new_reviews_two.trigger('to.owl.carousel', sliderID);
  });

	jQuery('body').on('click','.pg-payment-row.pg-payment-section .ValidationErrors',function(){
		var current = jQuery(this),
			scrolltoID = current.data('scrollto');
		if(current.hasClass('same-errors')){
			jQuery('.page-id-8 .payment-info .ValidationErrors').each(function(){
				if(jQuery(this).text() == 'Please enter the Required field'){
					scrolltoID = jQuery(this).closest('p').find('input').attr('id');
					return false;
				}
			})
		}
		jQuery('html,body').animate({
			scrollTop: jQuery("#" + scrolltoID+'_field').offset().top - jQuery('.nav-bar').height()
		}, 'slow');
	});
});

/*var selectIds = jQuery('#panel1,#panel2,#panel3,#panel4,#panel5,#panel6,#panel7,#panel8,#panel9');
jQuery(function () {
	selectIds.on('show.bs.collapse hidden.bs.collapse', function () {
		jQuery(this).prev().find('.fas').toggleClass('fa-plus fa-minus');
	})
});*/

function selectWriting(sel)
{
	sel.style.color = "#000";
}

jQuery( function choose_plan_landing_on_mobile(){
	var width = (window.innerWidth > 0) ? window.innerWidth : screen.width;
	if (width <= 767) {
    jQuery('section.choose-plan.choose-plan-landing ul.plans').each(function(){
      if(jQuery(this).css('display') != 'none'){
        jQuery(this).find('li:last-child .plan-body').click();
      }
    });
	}
});

(function($) {
  "use strict";
  (function () {
    window.checkout_validate = function(){
      var is_testing = Cookies.get('lg_checkout_script');
      if ("undefined" != typeof is_testing) {
        return false;
      }

      var check_input = true;
      if (jQuery('.create-account').html() !== '') {
        jQuery('.create-account .validate-required input[type!="hidden"]').each(function () {
          if (jQuery(this).hasClass('ErrorField') || jQuery(this).val() == '') {
            check_input = false;
          }
        });
      }
      if ( jQuery('#suggest_username').hasClass('ValidationErrors') ) {
        check_input = false;
      }
      jQuery('.billing-info .validate-required input:visible').each(function () {
        if (jQuery(this).hasClass('ErrorField') || jQuery(this).hasClass('ErrorEmail') || jQuery(this).val() == '') {
          check_input = false;
        }
      });
      if (jQuery('#use_lgs_extend').attr('checked') == 'checked') {
        jQuery('.billing-info-extend .validate-required input:visible').each(function () {
          if (jQuery(this).hasClass('ErrorField') || jQuery(this).val() == '') {
            check_input = false;
          }
        });
      }
      if (check_input) {
        jQuery('.pg-payment .btn-pay').removeClass('lg_vadilate_pay');
        jQuery('.pg-payment .lg_vadilate_pay_text').addClass('d-none');
        jQuery('.pg-payment .lg_vadilate_text').removeClass('d-none');
      } else {
        jQuery('.pg-payment .btn-pay').addClass('lg_vadilate_pay');
        jQuery('.pg-payment .lg_vadilate_pay_text').removeClass('d-none');
        jQuery('.pg-payment .lg_vadilate_text').addClass('d-none');
      }
    }
  })();
	Cookies.set('wordpress_test_cookie', 'WP Cookie check');
})(jQuery);

document.addEventListener("DOMContentLoaded", function() {
	// Lazy loading for videos
	var lazyVideos = [].slice.call(document.querySelectorAll("video.lazy"));	

	if("IntersectionObserver" in window) {
		var lazyVideoObserver = new IntersectionObserver(function(entries, observer) {
			entries.forEach(function(video) {
				if(video.isIntersecting) {
					for(var source in video.target.children) {
						var videoSource = video.target.children[source];
						if(typeof videoSource.tagName === "string" && videoSource.tagName === "SOURCE") {
							videoSource.src = videoSource.dataset.src;
						}
					}

					video.target.load();
					video.target.classList.remove("lazy");
					lazyVideoObserver.unobserve(video.target);
				}
			});
		});

		lazyVideos.forEach(function(lazyVideo) {
			lazyVideoObserver.observe(lazyVideo);
		});
	}

	// Lazy load for images
	var lazyImages = [].slice.call(document.querySelectorAll("img.lazy"));
	var lazyLoadingActive = false;

	var lazyLoad = function() {
		if(lazyLoadingActive === false) {
			lazyLoadingActive = true;

			setTimeout(function() {
				lazyImages.forEach(function(lazyImage) {
					if(lazyImage.getBoundingClientRect().top <= window.innerHeight && lazyImage.getBoundingClientRect().bottom >= 0) {
						lazyImage.src = lazyImage.dataset.src;
						lazyImage.classList.remove("lazy");

						lazyImages = lazyImages.filter(function(image) {
							return image !== lazyImage;
						});

						if(lazyImages.length === 0) {
							document.removeEventListener("scroll", lazyLoad);
							window.removeEventListener("resize", lazyLoad);
							window.removeEventListener("orientationchange", lazyLoad);
						}
					}
				});

				lazyLoadingActive = false;
			}, 200);
		}
	};

	document.addEventListener("scroll", lazyLoad);
	window.addEventListener("resize", lazyLoad);
	window.addEventListener("orientationchange", lazyLoad);
});


(function($) {
  "use strict";
  (function () {
    window.lgs_scroll_to_element = function (target) {
      var heigh_top = 0;
      if( jQuery('.fixed-top').is(':visible') ){
        heigh_top = heigh_top + jQuery('.fixed-top').height();
      }
      if( jQuery('.mobile-nav-bar').is(':visible') ){
        heigh_top = heigh_top + jQuery('.mobile-nav-bar').height();
      }
      if(jQuery('.scroller-target').is(':visible') && !jQuery('.scroller-target').hasClass('sticky')){
        heigh_top = heigh_top + jQuery('.scroller-target').height();
      }

      target = target.length ? target : jQuery('[name=' + this.hash.slice(1) + ']');
      if (target.length) {
        jQuery('html, body').animate({
          scrollTop: target.offset().top - heigh_top + 1
        }, 1000);
      }

      return false;
    }
  })();

})(jQuery);