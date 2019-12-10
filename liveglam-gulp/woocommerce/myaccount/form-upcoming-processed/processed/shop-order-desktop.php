<?php
  /**
   * Form Processed CLub Active Mobile
   */

  if ( ! defined( 'ABSPATH' ) ) {
    exit;
  }

?>

<?php if( $has_shop_order ){ ?>
  <div class="lgs-data-info">
    <p class="lgdi-title">Latest Order<span><a class="show-redeem-order" href="javascript:;">View Past Orders <i class="fas fa-chevron-right"></i></a></span></p>
    <div class="lgdi-item">
      <div class="lgdi-item-content extra-height">
        <div class="item-header">
          <?php if( $status == 'processing' ){ ?>
            <p class="item-header-title flcenter">Est Ship Date:<span><?php echo $estimate_ship_date; ?></span></p>
          <?php }elseif( $status == 'completed'){ ?>
            <?php if($is_order_points){ ?>
              <p class="item-header-title">Ordered on:</p>
              <p class="item-header-track"><strong><?php echo $ship_date; ?></strong></p>
            <?php }elseif(!empty($track_link)){ ?>
              <p class="item-header-title">Ship On:<span><?php echo $ship_date; ?></span></p>
              <p class="item-header-track"><a href="<?php echo $track_link; ?>" target="_blank">Track</a></p>
            <?php } ?>
          <?php } ?>
        </div>
        <div class="item-content content-single">
          <div class="single-list">
            <?php foreach($data_items as $data_item){ ?>
              <div class="data-item">
                <div class="data-item-left">
                  <img src="<?php echo $data_item['image']; ?>" alt="<?php echo $data_item['title']; ?>"/>
                </div>
                <div class="data-item-right">
                  <p class="title"><span class="shop-order-count"><?php echo $data_item['qty'].'x ' ?></span><?php echo $data_item['title']; ?></p>
                  <p class="desc"><?php echo $data_item['desc']; ?></p>
                </div>
              </div>
            <?php } ?>
          </div>
        </div>
        <div class="item-footer footer-single">
          <div class="order-notice">
            <?php if( $status == 'processing' ){ ?>
              <p><strong>Good news!</strong> Your order has processed and we are preparing your goodies now. We'll notify you with tracking info once it ships.</p>
            <?php }elseif( $status == 'completed' ){ ?>
              <p>We hope you love your new goodies! Use #LiveGlamFam for a chance to get featured.</p>
            <?php } ?>
          </div>
        </div>
      </div>
    </div>
  </div>
<?php } else { ?>
  <div class="lgs-data-info">
    <p class="lgdi-title">Latest Order</p>
    <div class="lgdi-item">
      <div class="lgdi-item-content extra-height">
        <div class="item-footer">
          <div class="notice-top">
            <p class="skip-waitlist-title">Oh no!</p>
            <p class="shop-desc-biger">You have no shipments<br>coming your way.</p>
          </div>
          <div class="notice-bot">
            <div class="icon-subs-title">
              <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/icon-myaccount-order-shipped2.png" alt="Order Shipped">
            </div>
            <p class="skip-waitlist-title">Let fix that!</p>
            <p class="shop-desc-biger">Get back to the glam and<br>add more product to your kit!</p>
            <div class="skip-waitlist-action go-shop">
              <a href="<?php echo home_url('/shop'); ?>">
                <button class="btn btn-primary btn-solid btn-block btn-vw btn-sm condensed">
                  Go To Shop
                </button>
              </a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
<?php } ?>