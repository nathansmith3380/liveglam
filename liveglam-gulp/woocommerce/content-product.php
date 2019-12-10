<?php
  /**
   * The template for displaying product content within loops
   *
   * This template can be overridden by copying it to yourtheme/woocommerce/content-product.php.
   *
   * HOWEVER, on occasion WooCommerce will need to update template files and you
   * (the theme developer) will need to copy the new files to your theme to
   * maintain compatibility. We try to do this as little as possible, but it does
   * happen. When this occurs the version of the template file will be bumped and
   * the readme will list any important changes.
   *
   * @see     https://docs.woocommerce.com/document/template-structure/
   * @package WooCommerce/Templates
   * @version 3.6.0
   */

  if(!defined('ABSPATH')){
    exit; // Exit if accessed directly
  }

  global $product;

  // Ensure visibility
  if(empty($product) || !$product->is_visible()){
    return;
  }

  $shop_member = !empty($shop_member)?true:false;
  $productID = $product->get_id();
  if( !LGS_Products::lgs_product_enable($productID, $shop_member) ) return;

  $is_product_coming_soon = LGS_Products::is_product_coming_soon($productID);
  $product_coming_soon = $is_product_coming_soon['is_coming_soon'];
  $coomming_soon_text_badge = $is_product_coming_soon['text_badge'];

  $instock = ($product->is_in_stock()&&!LGS_Products::lgs_pseudo_out_of_stock($productID));

  $average = LGS_Products::lgs_product_average_rating($productID);
  $cart_product_ids = !empty($cart_product_ids)?$cart_product_ids:array();
  $product_data_setting = LGS_Products::lgs_get_product_data_shop( $productID);
  $_show_soldout_instead_outofstock = $product_data_setting['_show_soldout_instead_outofstock'];
  $product_color = $product_data_setting['product_color'];
  $collection_month = $product_data_setting['collection_month'];
  $collection_name = $product_data_setting['collection_name'];
  $collection_image_bg = $product_data_setting['collection_image_bg'];
  $collection_color_bg = $product_data_setting['collection_color_bg'];
  global $total_list_individual;
  $total_list_individual = 1;
  $badge_class_on_right = '';
  if(!empty($use_custom_badge = get_post_meta($productID,'use_custom_badge',true))){
    $position_custom_badge = get_post_meta($productID, 'position_custom_badge', true);
    $badge_class_on_right = !empty($position_custom_badge)?"d-none":"";
  }
  ?>

<li <?php post_class(); ?> data-color="<?php echo $product_color; ?>" data-month="<?php echo $collection_month; ?>" data-stock="<?php echo $instock?1:0; ?>">

  <?php if(isset($show_bg_top) && $show_bg_top === true):

    echo sprintf("<div class='background-top' style='background-color:%s ;background-image: url( %s );display: none;'></div>", esc_attr($collection_color_bg), esc_attr($collection_image_bg));

  endif; ?>

  <a class="product-link" href="<?php echo esc_url(get_the_permalink()); ?>">

    <div class="product-item-header <?php echo (isset($show_bg_top) && $show_bg_top === true)?'product-collection':''; ?>">

      <div class="product-item-image">
        <div class="product-item-image-inner">

          <?php do_action('woocommerce_before_shop_loop_item_title'); ?>

        </div>
      </div>
    </div>

    <div class="product-item-bottom  <?php echo (isset($show_bg_top) && $show_bg_top === true)?'product-collection':''; ?>">

      <?php $class = ($instock&&!$product_coming_soon)?'instock':'outofstock';
        $product_in_cart = in_array($productID, $cart_product_ids);
        $variable_product = ($product->get_type() == 'variable');
        $show_notifier = ( !$product_coming_soon && !$instock && LGS_Products_Stock_Notifier::lgs_psn_enable($productID) )?'show_notifier':'';
        $pink_price = $product->get_price();
        $compare_price = LGS_Products::lgs_get_compare_price($product, $shop_member);
        $gray_price = LGS_Products::lgs_get_product_price($product, !$shop_member);
        $gray_price = ($gray_price != $pink_price && !empty($gray_price))?$gray_price:0;
      ?>

      <div class="product-item-details">

        <?php if(!isset($show_bg_top) || !$show_bg_top === true):
          echo sprintf("<p class='collection-name'>%s</p>", $collection_name);
        endif; ?>

        <p class="item-title"><?php echo get_the_title(); ?></p>

        <p class="item-price-pink">
            <span><?php echo '$'.$pink_price; ?></span>
            <?php if(!empty($compare_price)) : ?>
            <span class="compare-price"><?php echo '$'.$compare_price; ?></span>
            <?php endif; ?>
        </p>

        <p class="item-price-gray">

          <?php if(!empty($gray_price)){ ?>
            <?php echo ($shop_member)?'NON-MEMBERS: ':'MEMBERS: '; echo '$'.$gray_price; ?>
          <?php } ?>

        </p>

      </div>

      <div class="product-item-action">

<!--        <p class="quick-shop"><button class="btn btn-shop btn-secondary btn-vw"><img src="<?php /*echo get_stylesheet_directory_uri(); */?>/assets/img/icon-quick-shop.svg" />QUICK SHOP</button></p>
-->
        <p class="<?php echo $class; ?> <?php echo $show_notifier; ?> <?php echo $product_in_cart?'active':''; ?>">

          <?php if($product_coming_soon): ?>

            <?php echo "<button data-quantity='0' class='btn btn-shop btn-primary btn-vw outofstock button add_to_bag'>{$coomming_soon_text_badge}</button>"; ?>

          <?php elseif( !$instock && LGS_Products_Stock_Notifier::lgs_psn_enable($productID) ): ?>

            <?php echo "<button data-quantity='0' class='btn btn-shop btn-primary btn-vw outofstock show_notifier button add_to_bag action-go-single notifier-btn'>Get Restock Updates</button>"; ?>

          <?php elseif( $variable_product):?>

            <?php echo "<button data-quantity='0' class='btn btn-shop btn-primary btn-vw variable button add_to_bag action-go-single'>Select</button>"; ?>

          <?php else: ?>

            <?php $args = array( 'class' => $class.($product_in_cart?' button add_to_bag added':' button add_to_bag'), 'attributes' => array('data-product_id' => $productID, 'data-product_sku' => $product->get_sku(), 'aria-label' => $product->add_to_cart_description(), 'rel' => 'nofollow',), 'text' => $instock?($product_in_cart?'ADDED':'ADD TO BAG'):(($_show_soldout_instead_outofstock=='yes')?'Sold Out':'Out of stock')); ?>

            <?php $text_dk = $text_mb = '';

            if($instock){
              if($product_in_cart){
                $text_dk = $text_mb = 'ADDED';
              } else {
                $text_dk = 'ADD TO BAG';
                $text_mb = '<img src="'.get_stylesheet_directory_uri().'/assets/img/cart.png" alt=Add To Bag/> ADD';
              }
            } else {
              if($_show_soldout_instead_outofstock=='yes'){
                $text_dk = $text_mb = 'Sold Out';
              } else {
                $text_dk = $text_mb = 'Out of stock';
              }
            }
            ?>

            <?php echo sprintf("<button data-quantity='1' class='btn btn-shop btn-primary btn-vw %s' %s><span class='hide-mobile'>%s</span><span class='show-mobile'>%s</span></button>", esc_attr($args['class']), isset($args['attributes'])?wc_implode_html_attributes($args['attributes']):'', esc_html($text_dk), $text_mb); ?>

          <?php endif; ?>

        </p>

        <p class="view-details">VIEW DETAILS <span class="fas fa-chevron-right"></span></p>
      </div>
    </div>
  </a>
</li>
