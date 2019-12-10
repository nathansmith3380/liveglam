<?php
  /**
   * Form Processed CLub Active Mobile
   */

  if ( ! defined( 'ABSPATH' ) ) {
    exit;
  }

?>

<div class="liveglam-order-item liveglam-sub-order-processing">
  <div class="order-item-content">
    <div class="item-header">
      <p class="item-header-sub">Est Ship Date: <span class="float-right">Order: #<?php echo $orderID; ?></span></p>
      <p class="item-header-desc"><span class="time"><?php echo $estimate_ship_date; ?></span></p>
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
              <?php if($data_item['option_rating']){ ?>
                <p class="rating"><i class="fas fa-heart"></i>Rating available soon</p>
              <?php }else{ ?>
                <p class="desc <?php if($data_item['trade'] == 1 || $data_item['item_type'] == 'item-free'){ ?>traded<?php } ?>"><?php echo $data_item['desc']; ?></p>
              <?php } ?>
            </div>
          </div>
        <?php } ?>
      </div>
    </div>
    <div class="item-footer footer-single">
      <div class="order-notice">
        <p><strong>Good news!</strong> Your order has processed. We’ll notify you with tracking info once it ships.  <?php if($data_sub['button']['show_rate']) echo 'While you wait, <a href="#" class="rate_'.$club.'">rate your other packages.</a>'; ?></p>
      </div>
      <div class="order-actions">
        <div class="order-action">
          <a href="#" class="view_order" data-id="<?php echo $data_sub['subscription']['ID']; ?>" data-edit="view-order" data-type="<?php echo $club; ?>">
            <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/icon-mc-box-pink.png" alt="Icon Box" />
            <p class="title">View Past Orders</p>
          </a>
        </div>
        <div class="order-action">
          <p class="title disabled">Tracking<br>available soon</p>
        </div>
      </div>
        <div class="subs-actions">
            <div class="lgs-data-info">
                <!--show plan subscription-->
                <?php if(!empty($data_sub['subscription']['type_display'])){ ?>
                    <p class="lgdc-shipping-data">
                        <span class="lgdc-shipping-details"><span class="lgdc-shipping-title">Plan: </span><?php echo $data_sub['subscription']['type_display']; ?> Sub</span>
                        <?php if($data_sub['button']['show_upgrade']){ ?>
                            <a href="javascript:;" class="upgrade upgrade_<?php echo $club; ?>" data-type="<?php echo $club; ?>">
                                Upgrade >
                            </a>
                        <?php } ?>
                    </p>
                <?php } ?>
                <!--show next billing date-->
                <?php if(!empty($data_sub['time']['next_payment'])){ ?>
                    <p class="lgdc-shipping-data">
                        <span class="lgdc-shipping-details"><span class="lgdc-shipping-title">Next billing date: </span><?php echo date('F d, Y', $data_sub['time']['next_payment']); ?></span>
                        <?php if(!empty($data_sub['action']['change_date'])){ ?>
                            <a class="edit_schedule" data-edit="schedule" data-id="<?php echo $data_sub['subscription']['ID']; ?>" data-type="<?php echo $club; ?>">
                                <img alt="Billing" src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/icon-edit-profile-pink.png"/>
                            </a>
                        <?php } ?>
                    </p>
                <?php } ?>
                <!--show card info-->
                <?php if(!empty($data_sub['card']['card_last4'])){ ?>
                  <p class="lgdc-shipping-data d-none">
                    <span class="lgdc-shipping-details"><span class="lgdc-shipping-title">From card ending with: </span><?php echo $data_sub['card']['card_last4']; ?></span>
                    <a class="edit_billing" data-edit="billing" data-id="<?php echo $data_sub['subscription']['ID']; ?>" data-type="<?php echo $club; ?>">
                      <img alt="Card Info" src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/icon-edit-profile-pink.png"/>
                    </a>
                  </p>
                <?php } ?>
                <!--show shipping info-->
                <p class="lgdc-shipping-data">
                    <span class="lgdc-shipping-details" style="-webkit-box-orient: vertical;"><span class="lgdc-shipping-title">Shipping: </span><?php echo str_replace("<br/>", ", ", $data_sub['shipping']['shipping_address']); ?></span>
                    <a class="edit_shipping" data-edit="shipping" data-id="<?php echo $data_sub['subscription']['ID']; ?>" data-type="<?php echo $club; ?>">
                        <img alt="Shipping" src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/icon-edit-profile-pink.png"/>
                    </a>
                </p>
            </div>
            <?php if(!empty($data_sub['action']['cancel']) || !empty($data_sub['action']['skip'])){ ?>
                <div class="lgs-data-info">
                    <div class="lgdc-action">
                        <?php if(!empty($data_sub['action']['cancel'])){ ?>
                            <a class="lgdc-action-content multi-action <?php echo $key_club; ?>_cancel_action">
                                <div class="lgdc-action-button">
                                    <img alt="Cancel" src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/icon-myaccount-cancel-mb.png"/>Cancel
                                </div>
                            </a>
                        <?php } ?>
                        <?php if(!empty($data_sub['action']['skip'])){ ?>
                            <a class="lgdc-action-content multi-action <?php echo $key_club; ?>_skip_action">
                                <div class="lgdc-action-button">
                                    <img alt="Skip" src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/icon-myaccount-skip-mb.png"/>Skip
                                </div>
                            </a>
                        <?php } ?>
                        <a class="lgdc-action-content multi-action edit_billing" data-edit="billing" data-id="<?php echo $data_sub['subscription']['ID']; ?>" data-type="<?php echo $club; ?>">
                            <div class="lgdc-action-button">
                                <img alt="Billing" src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/icon-myaccount-billing-mb.png"/>Billing
                            </div>
                        </a>
                    </div>
                </div>
            <?php } ?>
        </div>
    </div>
  </div>
</div>