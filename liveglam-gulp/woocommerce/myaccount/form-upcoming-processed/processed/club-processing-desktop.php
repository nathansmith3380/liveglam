<?php
  /**
   * Form Processed CLub Active Mobile
   */

  if ( ! defined( 'ABSPATH' ) ) {
    exit;
  }

?>

<div class="lgs-data-info">
  <p class="lgdi-title">Latest Order</p>
  <div class="lgdi-item">
    <div class="lgdi-item-content">
      <div class="item-header">
        <p class="item-header-title flcenter">Est Ship Date:<span><?php echo $estimate_ship_date; ?></span></p>
      </div>
      <div class="item-content content-single">
        <div class="single-list">
          <?php foreach($data_items as $data_item){ ?>
            <div class="data-item <?php echo (count($data_items) > 1 && $data_item['item_type'] == 'item-parent')?'border-bottom':''; ?>">
              <div class="data-item-left">
                <img src="<?php echo $data_item['image']; ?>" alt="<?php echo $data_item['title']; ?>"/>
              </div>
              <div class="data-item-right">
                <p class="title <?php if($data_item['trade'] == 1 || $data_item['item_type'] == 'item-free'){ ?>traded<?php } ?>">
                  <?php echo $data_item['title']; ?>
                  <?php if($data_item['trade'] == 1){ ?><span class="traded-badge">Traded</span><?php } ?>
                  <?php if($data_item['item_type'] == 'item-free'){ ?><span class="traded-badge">Free</span><?php } ?>
                </p>
                <p class="desc <?php if($data_item['trade'] == 1 || $data_item['item_type'] == 'item-free'){ ?>traded<?php } ?>"><?php echo $data_item['desc']; ?></p>
              </div>
            </div>
          <?php } ?>
        </div>
      </div>
      <div class="item-footer footer-single">
        <div class="order-notice">
          <p><strong>Good news!</strong> Your order has processed and we are preparing your goodies now. We'll notify you with tracking info once it ships. <?php if($data_sub['button']['show_rate']) echo 'While you wait, <a href="#" class="rate_'.$club.'">rate your other packages.</a>'; ?></p>
        </div>
      </div>
    </div>
    <div class="lgdi-item-action">
      <a href="#" class="lgdi-action multi-action view_order" data-id="<?php echo $data_sub['subscription']['ID']; ?>" data-edit="view-order" data-type="<?php echo $club; ?>">
        <button class="btn btn-secondary btn-solid btn-block condensed">
          <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/icon-mc-box-pink.png" alt="Icon box" />
          View Past Orders
        </button>
      </a>
      <a class="lgdi-action multi-action track_not_available">
        <button class="btn btn-primary disabled btn-solid btn-block condensed">
          Tracking Available Soon
        </button>
      </a>
    </div>
  </div>
</div>