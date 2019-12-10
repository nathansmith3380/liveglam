<?php
  /**
   * The Template for displaying all single products
   *
   * This template can be overridden by copying it to yourtheme/woocommerce/single-product.php.
   *
   * HOWEVER, on occasion WooCommerce will need to update template files and you
   * (the theme developer) will need to copy the new files to your theme to
   * maintain compatibility. We try to do this as little as possible, but it does
   * happen. When this occurs the version of the template file will be bumped and
   * the readme will list any important changes.
   *
   * @see      https://docs.woocommerce.com/document/template-structure/
   * @author    WooThemes
   * @package  WooCommerce/Templates
   * @version     1.6.4
   */

  if(!defined('ABSPATH')){
    exit; // Exit if accessed directly
  }
  while(have_posts()) : the_post();
    /**
     * Check subscription products and redirect them to landing page
     * @$product WC_Product
     */

    if ($product->get_type() == 'subscription') {
        if (in_array($product->get_id(), array('2591','2592','9999477214'))) {
            wp_redirect(home_url('/morphe-brushes/'));
            die();
        };
        if (in_array($product->get_id(), array( KM_MONTHLY, KM_SIXMONTH, KM_ANNUAL ))) {
            wp_redirect(home_url('/kissme/'));
            die();
        };
        if (in_array($product->get_id(), array(  SM_MONTHLY, SM_SIXMONTH, SM_ANNUAL ))) {
            wp_redirect(home_url('/shadowme/'));
            die();
        };
    }

    if( !has_term( 'shop', 'product_cat' ) || LGS_Products::lgs_disable_purchase_and_visibility_product_shop($product->get_id())) {
      wp_redirect(get_permalink(wc_get_page_id('shop'))); exit;
    }


    get_header('shop');


    global $LG_userData, $LG_userAvata;
    global $average, $total_average, $total_reviews, $total_comemnts, $product_visibility, $is_shop_member, $lgs_pseudo_out_of_stock, $is_in_stock;
    global $previous_post, $next_post;

    $is_in_stock = $product->is_in_stock();
    $lgs_pseudo_out_of_stock = LGS_Products::lgs_pseudo_out_of_stock($product->get_id());
    $product_visibility = LGS_Products::lgs_product_visibility($product->get_id());
    $is_shop_member = LGS_Products::lgs_is_shop_member();

    $average = LGS_Products::lgs_product_average_rating($product->get_id());
    $total_average = LGS_Products::lgs_product_average_rating($product->get_id(), false);
    $total_reviews = LGS_Products::lgs_product_total_review($product->get_id(), 'reviews');
    $total_comemnts = LGS_Products::lgs_product_total_review($product->get_id(), 'comments');

    $next_post = LGS_Products::lgs_get_previous_post_shop($product->get_id());
    $previous_post = LGS_Products::lgs_get_next_post_shop($product->get_id());
    $is_login = is_user_logged_in();

    if($is_login):?>
      <div class="wc-dashboard-content">
      <div class="dashboard-content dashboard-rewards" style="background: #fff;">
      <?php //echo do_shortcode('[lgs_countdown_sale_homepage]'); ?>
      <div class="wrap hide-mobile">
        <div class="dashboard-header-content">
          <p class="title-page">Shop LiveGlam</p>
          <?php show_dashboard_header_right(); ?>
        </div>
      </div>

      <div id="lg-search-overlay"><?php show_general_search_content(); ?></div>

    <?php endif; ?>

        <div class="nav-single-product">
          <?php if(!$is_login) { ?><div class="container shop-container"><?php } ?>
          <div class="wrap">
            <ul class="nav-left dashboard-menu-nav">
              <li class="float-left previous hide-mobile">
                <?php if(false !== $previous_post)
                  echo '<a href="'.get_the_permalink($previous_post).'" rel="prev"><em class="fas fa-angle-left" aria-hidden="true"></em> Previous</a>'; ?>
              </li>
              <?php if ( function_exists('yoast_breadcrumb') ) {
                  yoast_breadcrumb( '<li class="active">','</li>' );
                } else{ ?>
                <li class="active">
                  <a href="<?php echo home_url(); ?>" style="text-decoration: underline !important;">LiveGlam</a>
                  <span class="breadcrump" style="margin: 0 10px;"><em class="fas fa-angle-right" aria-hidden="true"></em></span>
                  <a href="<?php echo get_permalink(wc_get_page_id('shop')); ?>" style="text-decoration: underline !important;">Shop</a>
                  <span class="breadcrump" style="margin: 0 10px;"><em class="fas fa-angle-right" aria-hidden="true"></em></span>
                  <span class="current-product" style="text-decoration: underline;"><?php the_title(); ?></span>
                </li>
              <?php } ?>

              <li class="float-right next hide-mobile">
                <?php if(false !== $next_post)
                  echo '<a href="'.get_the_permalink($next_post).'" rel="prev">Next <em class="fas fa-angle-right" aria-hidden="true"></em></a>'; ?>
              </li>
            </ul>
            <div class="nav-right"></div>
          </div>
            <?php if(!$is_login) { ?></div><?php } ?>
        </div>
        <div class="nav-single-product show-mobile">
          <div class="container shop-container">
          <div class="wrap">
            <ul class="nav-left dashboard-menu-nav">
              <li class="float-left previous">
                <?php if(false !== $previous_post)
                  echo '<a href="'.get_the_permalink($previous_post).'" rel="prev"><em class="fas fa-angle-left" aria-hidden="true"></em> Previous</a>'; ?>
              </li>
              <li class="float-right next">
                <?php if(false !== $next_post)
                  echo '<a href="'.get_the_permalink($next_post).'" rel="prev">Next <em class="fas fa-angle-right" aria-hidden="true"></em></a>'; ?>
              </li>
            </ul>
            <div class="nav-right"></div>
          </div>
          </div>
        </div>

        <input type="hidden" name="total_comments" value="<?php echo $total_comemnts; ?>"/>
        <input type="hidden" name="productID" value="<?php echo $product->get_id(); ?>"/>

        <?php wc_get_template_part('content', 'single-product'); ?>

    <?php if($is_login): ?>

        <?php show_dashboard_footer('footer-dashboard'); ?>

      </div>
      </div>

    <?php else: ?>

      <style>
        nav.nav-bar.no-subscribe.menu-single {
          background-color: #f05e7c;
          height: auto;
          padding: 1.5vw 5.2vw;
        }

        .menu-single-nav {
          margin: 0 auto;
          list-style: none;
          padding: 0;
        }

        .menu-single-nav li {
          color: #fff;
          display: inline-block;
        }

        .menu-single-nav li.previous a {
          margin-right: 15px;
          color: #000;
        }

        .menu-single-nav li.previous i {
          margin-right: 5px;
        }

        .menu-single-nav li.next a {
          margin-left: 15px;
          color: #000;
        }

        .menu-single-nav li.next i {
          margin-left: 5px;
        }
      </style>

    <?php endif; ?>
<?php get_footer(); ?>

    <?php endwhile; // end of the loop. ?>

<script type="text/javascript">
  jQuery(document).ready(function () {
    var table_element = '.woocommerce-comments .comments-commentlist',
      table_numPerPage = 5,
      table_totalItem = jQuery('input[name="total_comments"]').val(),
      table_numPages = Math.ceil(table_totalItem / table_numPerPage);
    set_pagination('#pagination-comments', table_element, table_numPages, table_numPerPage);
    go_to_page(table_element, 1, table_numPerPage);

    function set_pagination(element, element_selected, numPages, numPerPage) {
      if (numPages > 1) {
        var obj = jQuery(element).pagination({
          items: numPages,
          itemOnPage: numPerPage,
          currentPage: 1,
          cssStyle: '',
          prevText: '<em class="fas fa-chevron-left" aria-hidden="true"></em>',
          nextText: '<em class="fas fa-chevron-right" aria-hidden="true"></em>',
          onInit: function () {
          },
          onPageClick: function (page, evt) {
            go_to_page(element_selected, page, numPerPage);
          }
        });
      }
    }

    function go_to_page(element_selected, currentPage, numPerPage) {
      load_product_comments(element_selected, currentPage, numPerPage);
    }

    function load_product_comments(element, page, limit) {
      var data = {
        'action': 'lgs_ajax_load_product_comments',
        'productID': jQuery('input[name="productID"]').val(),
        'page': page,
        'limit': limit
      };
      jQuery.post(ajaxurl, data, function (response) {
        if (response.status == 'success') {
          jQuery(element).html(response.html_comments);
        }
      }, 'json');
    }
  });
</script>
<script type="text/javascript">
  jQuery(document).ready(function () {
    var width = (window.innerWidth > 0) ? window.innerWidth : screen.width;
    //set pagination for related product
    var related_element = '.products-related .list-individual .product-items ul li',
      related_numPerPage = (width > 767)?jQuery('.products-related .list-individual').data('perpage'):jQuery('.products-related .list-individual').data('perpage-mobile'),
      related_totalItem = jQuery('.products-related .list-individual .product-items ul li').length,
      related_numPages = Math.ceil(related_totalItem / related_numPerPage);
    set_pagination_related('#pagination-related', related_element, related_numPages, related_numPerPage);
    go_to_page_related(related_element, 1, related_numPerPage);

    function set_pagination_related(element, element_selected, numPages, numPerPage) {
      if (numPages > 1) {
        var obj = jQuery(element).pagination({
          items: numPages,
          itemOnPage: numPerPage,
          currentPage: 1,
          cssStyle: '',
          prevText: '<em class="fas fa-chevron-left" aria-hidden="true"></em>',
          nextText: '<em class="fas fa-chevron-right" aria-hidden="true"></em>',
          onInit: function () {
          },
          onPageClick: function (page, evt) {
            go_to_page_related(element_selected, page, numPerPage);
          }
        });
      }
    }

    function go_to_page_related(element_selected, currentPage, numPerPage) {
      var item = 1;
      jQuery(element_selected).each(function (e) {
        if (item % 4 == 0) {
          jQuery(this).addClass('last-row');
        }
        item++;
      });
      jQuery(element_selected).hide().slice((currentPage - 1) * numPerPage, currentPage * numPerPage).show();
    }

    jQuery( window ).resize(function() {
      reload_heigh_product();
    });
    reload_heigh_product();
    function reload_heigh_product() {

      var product_collection = 0,
        product_title = 0,
        product_price_pink = 0,
        product_price_gray = 0;

      jQuery('.list-individual .product-items ul li .collection-name').css('min-height','');
      jQuery('.list-individual .product-items ul li .item-title').css('min-height','');
      jQuery('.list-individual .product-items ul li .item-price-pink').css('min-height','');
      jQuery('.list-individual .product-items ul li .item-price-gray').css('min-height','');
      var width = (window.innerWidth > 0) ? window.innerWidth : screen.width;

      jQuery('.list-individual .product-items ul li').each(function () {
        var current = jQuery(this);
        product_collection = (current.find('.collection-name').height() > product_collection)?current.find('.collection-name').height():product_collection,
          product_title = (current.find('.item-title').height() > product_title)?current.find('.item-title').height():product_title,
          product_price_pink = (current.find('.item-price-pink').height() > product_price_pink)?current.find('.item-price-pink').height():product_price_pink,
          product_price_gray = (current.find('.item-price-gray').height() > product_price_gray)?current.find('.item-price-gray').height():product_price_gray;
      });
      jQuery('.list-individual .product-items ul li .collection-name').css('min-height',product_collection);
      jQuery('.list-individual .product-items ul li .item-title').css('min-height',product_title);
      jQuery('.list-individual .product-items ul li .item-price-pink').css('min-height',product_price_pink);
      jQuery('.list-individual .product-items ul li .item-price-gray').css('min-height',product_price_gray);
    }

    /** script for #LiveGlamFam **/
    jQuery('.owl-carousel.liveglamfam-slider').owlCarousel({
      loop: true,
      responsive:{
        0: { items:1, nav: false, dots: false, margin: 14, stagePadding: 50, },
        768: { items:4, nav: true, margin: 30, }
      },
      navText: ["<img src='<?php echo get_stylesheet_directory_uri(); ?>/assets/img/arrow-black-left@2x.png'>",
        "<img src='<?php echo get_stylesheet_directory_uri(); ?>/assets/img/arrow-black-right@2x.png'>"]
    });

    /** script for LDM sale **/
    jQuery('body').on('click', '.subscriber_save', function () {
      var trade_product = jQuery('input[name="productID"]').val(),
      plan_product = jQuery('select[name="select-plan"]').val();

      if( jQuery(this).hasClass('mm') ){
        var data = {
          'action': 'lgs_checkout_combine_proceed',
          'mm_plan': plan_product,
          'mm_fst': trade_product,
          'mm_gaga': ''
        };
      } else {
        if( jQuery(this).hasClass('sm') ){
          var data = {
            'action': 'lgs_checkout_combine_proceed',
            'sm_plan': plan_product,
            'sm_fst': trade_product,
            'sm_gaga': ''
          };
        } else {
          var data = {
            'action': 'lgs_checkout_combine_proceed',
            'km_plan': plan_product,
            'km_fst': trade_product,
            'km_gaga': ''
          };
        }
      }

      jQuery.post(ajaxurl, data, function (response) {
        if (response.status != "error") {
          window.location = response.redirect_url;
        }
      }, 'json');
    });

    jQuery('body').on('change', 'select[name="select-plan"]', function () {
      var planID = jQuery(this).val();
      jQuery('.product-collection-desc.plan-price').addClass('d-none');
      jQuery('.product-collection-desc.plan-price.plan-'+planID).removeClass('d-none');
    });

    jQuery('body').on('click', '.breakdown-action', function () {
      var current = jQuery(this);
      if(current.hasClass('breakdown-show')){
        current.removeClass('breakdown-show').addClass('breakdown-hide');
        current.closest('.single-product-rating').find('.product-breakdown-content').show();
      } else {
        current.removeClass('breakdown-hide').addClass('breakdown-show');
        current.closest('.single-product-rating').find('.product-breakdown-content').hide();
      }
      return false;
    });
    /** end script for LDM sale **/
  });
</script>
