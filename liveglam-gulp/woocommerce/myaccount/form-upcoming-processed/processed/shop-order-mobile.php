<?php
  /**
   * Form Processed CLub Active Mobile
   */

  if ( ! defined( 'ABSPATH' ) ) {
    exit;
  }

?>

<?php if( $has_shop_order ){ ?>
  <?php if($status == 'processing'){ ?>
    <div class="liveglam-order-item liveglam-shop-order-processing">
      <div class="order-item-content">
        <div class="item-header">
          <p class="item-header-sub">Est Ship Date: <span class="est-time"><?php echo $estimate_ship_date_mobile; ?></p>
          <p class="item-header-sub">Order: <?php echo $orderID; ?></p>
        </div>
        <div class="item-content content-single">
          <!-- <div class="single-header">
            <p>Order: #< ?php echo $orderID; ?></p>
          </div> -->
          <div class="single-list">
            <?php foreach($data_items as $data_item){ ?>
              <div class="data-item">
                <div class="data-item-left">
                  <img src="<?php echo $data_item['image']; ?>" alt="<?php echo $data_item['title']; ?>"/>
                </div>
                <div class="data-item-right">
                  <p class="title"><?php echo $data_item['title']; ?></p>
                  <p class="desc"><?php echo $data_item['desc']; ?></p>
                </div>
              </div>
            <?php } ?>
          </div>
        </div>
        <div class="item-footer footer-single">
          <div class="order-notice">
            <p>
              <strong>Good news!</strong> Your order has processed. We’ll notify you with tracking info once it ships.
            </p>
          </div>
        </div>
      </div>
    </div>
  <?php }elseif($status == 'completed'){ ?>
    <div class="liveglam-order-item liveglam-shop-order-completed-track">
      <div class="order-item-content">
        <div class="item-header">
          <p class="item-header-sub"><?php echo $is_order_points?'Ordered on:':'Shipped On:'; ?><span class="float-right">Order: #<?php echo $orderID; ?></span></p>
          <p class="item-header-desc">
            <span class="time"><?php echo $ship_date; ?></span>
          </p>
        </div>
        <div class="item-content content-single">
          <div class="single-header shop-single-header">
            <p class="text-left">This is what you’re getting:</p>
          </div>
          <div class="single-list">
            <?php foreach($data_items as $data_item){ ?>
              <div class="data-item">
                <div class="data-item-left">
                  <img src="<?php echo $data_item['image']; ?>" alt="<?php echo $data_item['title']; ?>"/>
                </div>
                <div class="data-item-right">
                  <p class="title"><?php echo $data_item['title']; ?></p>
                  <p class="desc"><?php echo $data_item['desc']; ?></p>
                </div>
              </div>
            <?php } ?>
          </div>
        </div>
        <div class="item-footer footer-single">
          <div class="order-notice">
            <p>We hope you love your new goodies! Use #LiveGlamFam for a chance to get featured.</p>
            <?php if(!empty($track_link)){ ?>
              <div class="order-action">
                <a href="<?php echo $track_link; ?>" target="_blank">
                  <button class="btn btn-primary">Track My Package</button>
                </a>
              </div>
            <?php } ?>
          </div>
        </div>
      </div>
    </div>
  <?php } ?>
<?php } else { ?>
  <div class="liveglam-order-item">
    <div class="order-item-content">
      <div class="item-shop">
        <div class="notice-top">
          <p class="shop-title2">Oh no!</p>
          <p class="shop-desc2">You have no shipments<br>coming your way.</p>
        </div>
        <div class="notice-bot">
          <div class="icon-subs-title">
            <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/icon-myaccount-order-shipped2.png" alt="Order Shipped">
          </div>
          <p class="shop-title2">Let fix that!</p>
          <p class="shop-desc2">Get back to the glam and add more product to your kit!</p>
          <div class="shop-new-action">
            <a href="<?php echo home_url('/shop'); ?>">
              <button class="btn btn-primary btn-solid btn-block btn-sm btn-vw condensed">
                Go To Shop
              </button>
            </a>
          </div>
        </div>
      </div>
    </div>
  </div>
<?php } ?>