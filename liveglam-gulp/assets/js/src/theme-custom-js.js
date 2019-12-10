// Custom Javascript

// Preloader
/*(function($) {
    "use strict";
    $(window).load(function() {
      
         $('.preloader').fadeOut(800);
         $('.header-search-icon, .menu-burger-search').on('click', function(e) {
            $('.search-overlay').removeClass("d-none");
        });
         $('.menu-burger').on('click', function(e) {
            $('.menu-overlay').removeClass("d-none");
        });
         $('.menu-item-has-children').on('click', function(event) {
            
            $(this).children('ul').toggleClass('d-none');
            
        });   
      
            $('.closeicon').on('click', function(e) {
            $('.search-overlay').addClass("d-none");
            $('.menu-overlay').addClass("d-none");
            
        });
    });
})(jQuery);*/

// Header FX
/*
(function($) {
    "use strict";
    $(window).scroll(function () {
  if ( $(this).scrollTop() > 20 && !$('.site-header-fixed-background').hasClass('sticky') ) {
    $('.site-header-fixed-background').addClass('sticky');
    $('.site-header').addClass('sticky');
    $('.site-logo-image').addClass('sticky');
   } else if ( $(this).scrollTop() <= 20 ) {
    $('.site-header-fixed-background').removeClass('sticky');
    $('.site-header').removeClass('sticky');
    $('.site-logo-image').removeClass('sticky');
   }
});
})(jQuery);
*/

// Product Box Icons
(function($) {
    "use strict";
     $("body").on("click", ".woocommerce-quickview-icon-wrapper", function (e) {
        e.preventDefault();
        $(this).parent().parent().parent().find(".yith-wcqv-button").click();
    });
    $("body").on("click", ".woocommerce-wishlist-icon-wrapper", function (e) {
        e.preventDefault();
        $(this).parent().parent().parent().find(".add_to_wishlist").click();
    });
})(jQuery);

// Accordion
(function($) {
    "use strict";
$( "#accordion" ).accordion({
  
  animate: 300,
  heightStyle: "content",
    event:false, 
  active :false
  
  });
var noSections = $("#accordion h3").length-1;
$("h3").each(function (index, element)
{
    $(element).click(function()
    {
       if($(this).hasClass('ui-state-active'))
       {
           if(index < noSections)
              $("#accordion").accordion('option','active',index + 1);
           else
              $("#accordion").accordion('option','active',index - 1);
       }
       else
       {
          $("#accordion").accordion('option','active',index);
       }
   });
}); 
   
})(jQuery);

// Misc FX
/*(function($) {
    "use strict";
        $('li.product').hover(function() {
            $(this).find('img').fadeTo(500, 0.8);
        }, function() {
            $(this).find('img').fadeTo(500, 1);
        });
        $('.related.products h2').addClass("background-line");

        //$('div[id^="redux_blast"]').remove();
      
})(jQuery);*/


//onhover add class
jQuery(".sidebar_list").hover(function () {
    jQuery(this).toggleClass("result_hover");
 });
 
//popup for ignore trial and become regular member 
jQuery('#ignore_trial').magnificPopup({
	type: 'inline',
	closeBtnInside:true
	});


 
 