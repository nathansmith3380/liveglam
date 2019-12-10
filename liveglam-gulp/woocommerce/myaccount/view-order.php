<?php
  /**
   * View Order
   *
   * Shows the details of a particular order on the account page.
   *
   * This template can be overridden by copying it to yourtheme/woocommerce/myaccount/view-order.php.
   *
   * HOWEVER, on occasion WooCommerce will need to update template files and you
   * (the theme developer) will need to copy the new files to your theme to
   * maintain compatibility. We try to do this as little as possible, but it does
   * happen. When this occurs the version of the template file will be bumped and
   * the readme will list any important changes.
   *
   * @see     https://docs.woocommerce.com/document/template-structure/
   * @author  WooThemes
   * @package WooCommerce/Templates
   * @version 3.0.0
   */

  if(!defined('ABSPATH')){
    exit;
  }

  $order_status = $order->get_status();
  $order_id = $order->get_id();
  $is_subscription_order = false;
  $has_trade_mm = $has_trade_km = $has_trade_sm = false;
  $has_mm = $has_km = $has_sm = false;
  foreach($order->get_items() as $item_id => $item){
    if(in_array($item['product_id'], lgs_product_mm)):
      $has_mm = true;
      $is_subscription_order = true;
    endif;
    if(in_array($item['product_id'], lgs_product_km)):
      $has_km = true;
      $is_subscription_order = true;
    endif;
    if(in_array($item['product_id'], lgs_product_sm)):
      $has_sm = true;
      $is_subscription_order = true;
    endif;
  }

  $order_track = lgs_get_order_track($order);
  $track_num = $order_track['number'];
  $order_link_track = $order_track['link'];

  $related_subscriptions = wcs_get_subscriptions_for_order($order->get_id(), array('order_type' => array('parent', 'renewal')));
  $is_holiday_KM_sale = get_post_meta($order->get_id(), 'lgs_kissme_sale', true);
  $lgs_kissme_sale_box = get_post_meta($order->get_id(), 'lgs_kissme_sale_box', true);
  //check order is not replacement
  $is_replacemnet_order = !empty(get_post_meta($order->get_id(), '_check_is_replacement_order', true))?true:false;
  $is_redeem = !empty(get_post_meta($order_id, 'sumo_gateway_used', true))?true:false;
  $order_add_on = ($is_redeem && $order->get_shipping_total() == 0)?true:false;
?>

<div class="dashboard-content dashboard-setting dashboard-orders">
    <div class="dashboard-header-new">
        <div class="wrap view-detail-order">
            <div class="title-header-content">
                <div class="title-header-left">
                    <a href="<?php echo home_url('/my-account/'); ?>"><img class="hide-mobile" alt="Back" src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/arrow-gray-left.png">Back</a>
                    </div>
                    <div class="title-header-center title-order-details show-mobile">
                    <p></p>
                </div>
            </div>
        </div>
    </div>
    <div class="dashboard-container">
        <div class="liveglam-setting liveglam-setting-new liveglam-orders-history">
            <section class="setting">
                <div class="order-history">
                    <div class="order-history-details">
                        <?php foreach ( $related_subscriptions as $subscription ){
                            $subscription_status = $subscription->get_status();
                            foreach($subscription->get_items() as $item_id => $item){
                            if(in_array($item['product_id'], lgs_product_mm)):
                                $subscription_title_image = '<img src="'.get_stylesheet_directory_uri().'/assets/img/logo-dashboard-mm.svg" alt="Logo MM">';
                            elseif(in_array($item['product_id'], lgs_product_km)):
                                $subscription_title_image = '<img src="'.get_stylesheet_directory_uri().'/assets/img/logo-dashboard-km.svg" alt="Logo KM">';
                            elseif(in_array($item['product_id'], lgs_product_sm)):
                                $subscription_title_image = '<img src="'.get_stylesheet_directory_uri().'/assets/img/logo-dashboard-sm.svg" alt="Logo SM">';
                            endif;
                            break;
                            }
                        }
                        ?>
                        <div class="order-details-top">
                            <div class="setting-account-title hide-mobile">
                                <?php if ( !empty($subscription_title_image )): ?>
                                    <p><?php echo $subscription_title_image; ?></p>
                                <?php else: ?>
                                    <p class="shop">SHOP</p>
                                <?php endif; ?>
                            </div>
                            <?php if ( !empty( $order_paid_date = $order->get_date_paid() ) ): ?>
                                <div class="setting-account-desc hide-mobile">
                                    <p>Order <?php echo date( "m/d/Y", $order_paid_date->getOffsetTimestamp() ); ?></p>
                                </div>
                            <?php endif; ?>
                            <div class="order-top-list">
                            <div class="order-item-content">
                            <p class="item-content-title show-mobile">
                                <span class="item-image"> <?php echo $subscription_title_image; ?></span>
                                <span class="item-status">
                                    <span class="status status-<?php echo $subscription_status; ?>"></span>
                                    <?php echo ucfirst($subscription_status); ?>
                                </span>
                            </p>
                            <p class="item-content-list">
                                <span class="item-title"><?php echo $is_subscription_order ? 'Order code' : 'Order number'; ?>:</span>
                                <span class="item-data"><?php echo $order_id; ?></span>
                            </p>
                            <?php if ( !empty( $order_paid_date = $order->get_date_paid() ) ): ?>
                                <p class="item-content-list">
                                    <span class="item-title">Date paid:</span>
                                    <span class="item-data"><?php echo date( "F d, Y", $order_paid_date->getOffsetTimestamp() ); ?></span>
                                </p>
                            <?php endif; ?>
                        </div>
                        <?php if (in_array($order_status, array('processing', 'completed'))):
                            $date_paid = empty($order->get_date_paid())?$order->get_date_created():$order->get_date_paid();
                            $date_shipping = date("F d, Y", strtotime("+2 days", $date_paid->getOffsetTimestamp()));
                            if ($has_sm) {
                                $date_shipping = date("F d, Y", strtotime("+5 days", $date_paid->getOffsetTimestamp()));
                            }
                          if($order_add_on){
                            if(!empty($est_time = LGS_User_Referrals::lgs_get_time_shipping_for_add_on_order($order->get_user_id()))){
                              $date_shipping = date("F d, Y", $est_time);
                            } else {
                              $date_shipping = 'Along with your next renewal.';
                            }
                          } ?>
                            <div class="item-content-estimated">
                                <p class="estimated-date-title">Estimated Shipping Date</p>
                                <p class="estimated-date-time"><?php echo $date_shipping; ?></p>
                            </div>
                        <?php endif; ?>
                        </div>
                        </div>
                        <div class="order-details-center">
                            <div class="order-center-list">
                                <div class="order-item-content">
                                    <p class="item-content-title">Order Invoice</p>

                                    <?php
                                    if ($is_subscription_order):
                                        foreach ($order->get_items() as $item_id => $item):
                                            $product_total = $is_replacemnet_order?wc_price(0):$order->get_formatted_line_subtotal($item);
                                            $item_sub = '';
                                            $product_name = $item['name'];

                                            if (in_array($item['product_id'], lgs_product_mm)):
                                                $product_name = 'MorpheMe';
                                                $item_sub = ($item['product_id'] == MM_ANNUAL)?'Annual':(($item['product_id'] == MM_SIXMONTH)?'6-Month':'Monthly');
                                            elseif (in_array($item['product_id'], lgs_product_km)):
                                                $product_name = 'KissMe';
                                                $item_sub = ($item['product_id'] == KM_ANNUAL)?'Annual':(($item['product_id'] == KM_SIXMONTH)?'6-Month':'Monthly');
                                            elseif (in_array($item['product_id'], lgs_product_sm)):
                                                $product_name = 'ShadowMe';
                                                $item_sub = ($item['product_id'] == SM_ANNUAL)?'Annual':(($item['product_id'] == SM_SIXMONTH)?'Bi-Annual':'Bi-Monthly');
                                            endif;

                                            if( $item['qty'] > 1 ) {
                                                $product_name .= "x {$item['qty']}";
                                            } ?>
                                            <p class="item-content-list">
                                                <span class="item-title"><?php echo $product_name; ?>
                                                    <?php if ( !empty( $item_sub ) ): ?>
                                                    <span class="item-sub"><?php echo $item_sub; ?></span>
                                                    <?php endif; ?>
                                                </span>
                                                <span class="item-data"><?php echo $product_total; ?></span>
                                            </p>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                    
                                    <?php foreach ($order->get_order_item_totals() as $key => $total):
                                        if ( $key == 'cart_subtotal' ) continue;
                                        if ( $is_replacemnet_order ) {
                                            if ($key == 'order_total') {
                                                $total['value'] = wc_price(0);
                                            } else{
                                                continue;
                                            }
                                        } ?>
                                        <p class="item-content-list">
                                            <span class="item-title"><?php echo strpos($key, 'refund') !== false?'Refunded':$total['label']; ?></span>
                                            <span class="item-data"><?php echo $total['value']; ?></span>
                                        </p>
                                    <?php endforeach; ?>
                                </div>

                                <div class="order-item-content">
                                    <p class="item-content-title">Status</p>
                                
                                    <?php if( $order_status == 'processing' ) {
                                        $order_item_sub = 'Details will be available once the package arrives at the UPS facility. Please check back soon';
                                        $order_item_img = '<img src="'.get_stylesheet_directory_uri().'/assets/img/icon-myaccount-order-processing2.png" alt="Order Processing">';
                                    } elseif ( $order_status == 'completed' ) {
                                        $order_status = 'Shipped';
                                        $order_item_sub = $order_track['note'];
                                        $order_item_img = '<img src="'.get_stylesheet_directory_uri().'/assets/img/icon-myaccount-order-shipped3.png" alt="Order Shipped">';
                                        $completed_time = $order->get_date_completed();
                                        if(!empty($completed_time) && !empty( $completed_date = $completed_time->getTimestamp())){
                                            $time_delivered = $completed_date + ( 3600 * 24 * 4 );
                                            if( $time_delivered <= current_time('timestamp') ){
                                                $order_status = 'Shipped';
                                                $order_item_img = '<img src="'.get_stylesheet_directory_uri().'/assets/img/icon-myaccount-order-delivered2.png" alt="Order Delivered">';
                                            }
                                        }
                                    } elseif ( $order_status == 'failed' && $subscription_status != 'cancelled') {
                                        $order_item_sub = 'Pay for your failed order and reactivate your subscription.';
                                    } ?>
                                    <p class="item-content-list no-border">
                                        <span class="item-title"><?php echo !empty($order_status) ? $order_status: ''; ?>
                                            <span class="item-sub"><?php echo !empty($order_item_sub) ? $order_item_sub: ''; ?></span>
                                        </span>
                                        <span class="item-data"><?php echo !empty($order_item_img) ? $order_item_img: ''; ?></span>
                                    </p>
                                    <?php if (!empty($order_track['link'])): ?>
                                        <p class="item-content-list">
                                            <a href="<?php echo $order_track['link']; ?>" target="_blank">
                                            <button class="track-package btn-secondary btn-solid btn-sm condensed">Track your package</button></a>
                                        </p>
                                    <?php endif; ?>

                                </div>

                                <?php if ($is_subscription_order): ?>
                                    <?php if (!empty($address = $order->get_formatted_shipping_address())): ?>
                                        <div class="order-item-content">
                                            <p class="item-content-title">Shipped to</p>
                                            <p class="item-content-list text-left"><?php echo wp_kses($address, array('br' => array())); ?></p>
                                        </div>
                                    <?php endif; ?>

                                    <?php if (!$is_replacemnet_order && !in_array($order_status, array('waitlist', 'waitlist-cleared'))): ?>
                                        <div class="order-item-content">
                                            <p class="item-content-title">Item info</p>

                                            <?php
                                            if ($has_mm) {
                                                if (empty($shiping_box = (int)get_post_meta($order->get_id(), 'shipping_box', true))) {
                                                    //set shipping box name here
                                                    if (in_array($order_status,array('processing','completed'))) {
                                                        $time_created = $order->get_date_created()->getOffsetTimestamp();
                                                        $time_paid = !empty($order->get_date_paid())?$order->get_date_paid()->getOffsetTimestamp():null;
                                                        if ( !empty($shiping_box) ){
                                                            if(LGS_User_Referrals::lgs_calculate_shipping_box($time_created) == $shiping_box) {
                                                                $time = $time_created;
                                                            } elseif(LGS_User_Referrals::lgs_calculate_shipping_box($time_paid) == $shiping_box) {
                                                                    $time = $time_paid;
                                                            }
                                                        } else {
                                                            $time = $time_created;
                                                        }
                                                    } else {
                                                        $time = current_time('timestamp');
                                                    }
                                                    $shiping_box = LGS_User_Referrals::lgs_calculate_shipping_box($time);
                                                }
                                                $shipping_name = date('F', mktime(0, 0, 0, $shiping_box, 10))." Brushes";
                                                $trade_type = '';
                                                if (!empty($has_trade_mm = Iz_Liveglam_MorpheMe_Renewal::lgs_maybe_have_trade('mm',$order_id))) {
                                                    $trade_type = 'Whole Set Trade';
                                                    $order_trade = get_post_meta($order_id, "_lgs_mm_trade_new", true);
                                                    if (get_post_meta($order_id, '_lgs_mm_trade_type', true) == 'single') {
                                                        $trade_type = 'Individual Trade';
                                                        $order_trade = get_post_meta($order_id, "_lgs_mm_trade_old", true).' Traded '.' with '.$order_trade;
                                                    } else {
                                                        $order_trade = 'Traded With '.$order_trade;
                                                    }
                                                    if (!empty(get_post_meta($order_id, 'trade-first-order-mm', true))) {
                                                        $trade_type = 'First Set Trade';
                                                    }
                                                }
                                            }

                                            if ($has_km) {
                                                $is_renewal = wcs_order_contains_renewal($order);
                                                if (!$is_renewal && isset($lgs_kissme_sale_box) && !empty($lgs_kissme_sale_box)) {
                                                    $shipping_name = $lgs_kissme_sale_box;
                                                } elseif (!$is_renewal && $is_holiday_KM_sale == 'lgs_kissme_sale-2018'){
                                                    $shipping_name = 'Holiday KM Restock<br> Collection';
                                                } else {
                                                    if (empty($shiping_box = (int)get_post_meta($order->get_id(), 'shipping_box', true))) {
                                                        //set shipping box name here
                                                        if (in_array($order_status, array('processing', 'completed'))) {
                                                            $time_created = $order->get_date_created()->getOffsetTimestamp();
                                                            $time_paid = !empty($order->get_date_paid())?$order->get_date_paid()->getOffsetTimestamp():null;
                                                            if (!empty($shiping_box)) {
                                                                if(LGS_User_Referrals::lgs_calculate_shipping_box($time_created) == $shiping_box) {
                                                                    $time = $time_created;
                                                                }elseif(LGS_User_Referrals::lgs_calculate_shipping_box($time_paid) == $shiping_box) {
                                                                    $time = $time_paid;
                                                                }
                                                            }else{
                                                                $time = $time_created;
                                                            }
                                                        } else {
                                                            $time = current_time('timestamp');
                                                        }
                                                        $shiping_box = LGS_User_Referrals::lgs_calculate_shipping_box($time);
                                                    }
                                                    $shipping_name = date('F', mktime(0, 0, 0, $shiping_box, 10))." Lipsticks";
                                                }
                                                $trade_type = '';
                                                if (!empty($has_trade_km = Iz_Liveglam_MorpheMe_Renewal::lgs_maybe_have_trade('km',$order_id))) {
                                                    $trade_type = 'Whole Set Trade';
                                                    $order_trade = get_post_meta($order_id, "_lgs_km_trade_new", true);
                                                    if(get_post_meta($order_id, '_lgs_km_trade_type', true) == 'single') {
                                                        $trade_type = 'Individual Trade';
                                                        $order_trade = get_post_meta($order_id, "_lgs_km_trade_old", true).' Traded '.' with '.$order_trade;
                                                    } else {
                                                        $order_trade = 'Traded With '.$order_trade;
                                                    }
                                                    if (!empty(get_post_meta($order_id, 'trade-first-order-km', true))) {
                                                        $trade_type = 'First Set Trade';
                                                    }
                                                }
                                            }

                                            if ($has_sm) {
                                                $shipping_name = get_post_meta($order->get_id(), 'shipping_box_sm', true);
                                                $trade_type = '';
                                                if (!empty($has_trade_sm = Iz_Liveglam_MorpheMe_Renewal::lgs_maybe_have_trade('sm',$order_id))) {
                                                    $trade_type = 'Whole Set Trade';
                                                    $order_trade = 'Traded With '.get_post_meta($order_id, "_lgs_sm_trade_new", true);
                                                    if (!empty(get_post_meta($order_id, 'trade-first-order-sm', true))) {
                                                        $trade_type = 'First Set Trade';
                                                    }
                                                }
                                            } ?>
                                            <p class="item-content-list">
                                                <span class="item-title"><?php echo $trade_type; ?>
                                                    <span class="item-sub"><?php echo $shipping_name; ?><br>
                                                    <?php if (!empty($order_trade)) echo $order_trade; ?></span>
                                                </span>
                                            </p>
                                        </div>
                                    <?php endif;?>
                                <?php endif; ?>
                            </div>
                                                           
                            <?php if (!$is_subscription_order): ?>
                                <div class="order-center-breakdown">
                                    <div class="order-item-content">
                                        <p class="item-content-title">Order Breakdown</p>
                                        <?php foreach($order->get_items() as $item):
                                            $productID = !empty($item['variation_id'])?$item['variation_id']:$item['product_id'];
                                            if (false !== ($shop_product = wc_get_product($item['product_id']))){
                                                $shop_product_img = wp_get_attachment_image_src(get_post_thumbnail_id($item['product_id']), array(80, 80));
                                                $shop_product_img = $shop_product_img[0];
                                                if (!empty($item['variation_id'])) {
                                                    $variation = wc_get_product($item['variation_id']);
                                                    $variation_img_url = wp_get_attachment_image_src($variation->get_image_id(), array(80, 80));
                                                    if(!empty($variation_img_url[0]))
                                                    $shop_product_img = $variation_img_url[0];
                                                }
                                            }
                                            if ($is_redeem) {
                                                $item_total = get_post_meta($productID, '_rewardsystem__points', true).' Points';
                                            } else {
                                                $item_total = wc_price($item['total']);
                                            } ?>
                                            <div class="item-shop-list">
                                                <div class="item-shop-product-img">
                                                    <img src="<?php echo $shop_product_img; ?>" alt="<?php echo $item['name']; ?>">
                                                </div>
                                                <div class="item-shop-product-detail">
                                                    <p class="itemt-shop-product-title"><?php echo $item['qty']; ?>x <strong><?php echo $item['name']; ?></strong></p>
                                                    <p class="itemt-shop-product-subtitle"><?php echo $item_total; ?></p>
                                                </div>
                                            </div>

                                        <?php endforeach; ?>
                                    </div>
                                </div>
                            <?php endif; ?>

                            <?php if ($is_subscription_order): ?>
                            <p class="view-faq">Have questions? <a href="<?php echo home_url("faq"); ?>">Get answers!</a></p>
                            <?php endif; ?>
                        </div>

                        <?php if ( !empty( $related_subscriptions ) ): ?>
                            <div class="order-details-bottom">
                                <div class="order-center-list">
                                    <?php foreach ( $related_subscriptions as $related_subscription ):
                                        $related_subscription_name = '';
                                        foreach($related_subscription->get_items() as $item_id => $item){
                                            if(in_array($item['product_id'], lgs_product_mm)):
                                                $related_subscription_name = 'MorpheMe';
                                            elseif(in_array($item['product_id'], lgs_product_km)):
                                                $related_subscription_name = 'KissMe';
                                            elseif(in_array($item['product_id'], lgs_product_sm)):
                                                $related_subscription_name = 'ShadowMe';
                                            endif;
                                            break;
                                        } ?>
                                        <div class="order-item-content">
                                            <p class="item-content-title"><?php echo $related_subscription_name; ?> Subscription</p>
                                            <div class="item-content-lists">
                                                <p class="item-content-list">
                                                    <span class="item-title">Subscription id:</span>
                                                    <span class="item-data"><?php echo esc_html($related_subscription->get_order_number()); ?></span>
                                                </p>
                                                <p class="item-content-list">
                                                    <span class="item-title">Subscription Status:</span>
                                                    <span class="item-data"><?php echo esc_attr(wcs_get_subscription_status_name($related_subscription->get_status())); ?></span>
                                                </p>
                                                <p class="item-content-list">
                                                    <span class="item-title">Subscription Start Date:</span>
                                                    <span class="item-data"><?php echo esc_attr($related_subscription->get_date_to_display('date_created')); ?></span>
                                                </p>
                                                <p class="item-content-list">
                                                    <span class="item-title">Subscription Cost:</span>
                                                    <span class="item-data"><?php echo wp_kses_post($related_subscription->get_formatted_order_total()); ?></span>
                                                </p>
                                            </div>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                        <?php endif; ?>
                    <div>
                </div>
            </section>
        </div>
    </div>
</div>