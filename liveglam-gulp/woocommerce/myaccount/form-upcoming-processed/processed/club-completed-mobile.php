<?php
  /**
   * Form Processed CLub Completed Mobile
   */

  if ( ! defined( 'ABSPATH' ) ) {
    exit;
  }

?>

<?php if(!$order_has_delivered){ ?>
  <div class="liveglam-order-item liveglam-sub-order-completed-track">
    <div class="order-item-content">
      <div class="item-header">
        <p class="item-header-sub">Shipped On:<span class="float-right">Order: #<?php echo $orderID; ?></span></p>
        <p class="item-header-desc"><span class="time"><?php echo $ship_date; ?></span></p>
      </div>
      <div class="item-content content-single">
        <div class="single-header shop-single-header">
          <p class="text-left">This is what you’re getting:</p>
        </div>
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
          <p>We hope you love your new goodies! Use #LiveGlamFam for a chance to get featured.</p>
        </div>
        <div class="order-actions">
          <?php if( !empty($data_sub['button']['show_rate']) ){ ?>
            <div class="order-action">
              <a href="#" class="rate_<?php echo $club; ?>">
                <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/icon-mc-heart-pink.png" alt="Icon Heart" />
                <p class="title">Rate Products</p>
              </a>
            </div>
          <?php } else { ?>
            <div class="order-action">
              <a href="#" class="view_order" data-id="<?php echo $data_sub['subscription']['ID']; ?>" data-edit="view-order" data-type="<?php echo $club; ?>">
                <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/icon-mc-box-pink.png" alt="Icon Box" />
                <p class="title">View Past Orders</p>
              </a>
            </div>
          <?php } ?>
          <?php if( !empty($track_link) ){ ?>
            <div class="order-action">
              <a href="<?php echo $track_link; ?>" target="_blank">
                <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/icon-mc-track-pink.png" alt="Icon Track" />
                <p class="title">Track My Package</p>
              </a>
            </div>
          <?php } ?>
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
                                      <img alt=Cancel"" src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/icon-myaccount-cancel-mb.png"/>Cancel
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
<?php } else { ?>

  <?php if(!$has_rating_order){ ?>
    <div class="liveglam-order-item liveglam-sub-order-completed-rating">
      <div class="order-item-content">
        <div class="item-header">
          <p class="item-header-title">Tab the hearts to rate and earn points:</p>
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
                  <p class="my-rating">My Rate:
                    <?php if(!empty($data_sub['button']['show_rate'])){ ?><a href="#" class="rate_<?php echo $club; ?>"><?php } ?>
                    <span class="rate available">
                      <?php for($i = 0; $i < 5; $i++){ ?>
                        <i class="fas fa-heart" data-num="<?php echo $i+1; ?>"></i>
                      <?php } ?>
                    </span>
                    <?php if(!empty($data_sub['button']['show_rate'])){ ?></a><?php } ?>
                  </p>
                </div>
              </div>
            <?php } ?>
          </div>
        </div>
        <div class="item-footer footer-single">
          <div class="order-actions">
            <div class="order-action">
              <a href="#" class="view_order" data-id="<?php echo $data_sub['subscription']['ID']; ?>" data-edit="view-order" data-type="<?php echo $club; ?>">
                <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/icon-mc-box-pink.png" alt="Icon Box" />
                <p class="title">View Past Orders</p>
              </a>
            </div>
            <?php if( !empty($data_sub['button']['show_rate']) ){ ?>
              <div class="order-action">
                <a href="#" class="rate_<?php echo $club; ?>">
                  <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/icon-mc-heart-pink.png" alt="Icon Heart" />
                  <p class="title">Rate Products</p>
                </a>
              </div>
            <?php } else { ?>
              <div class="order-action">
                <a href="<?php echo home_url('/shop'); ?>">
                  <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/icon-shop-pink-new.png" alt="Icon Shop" />
                  <p class="title">View Shop</p>
                </a>
              </div>
            <?php } ?>
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
  <?php }else{ ?>
    <div class="liveglam-order-item liveglam-sub-order-completed-rated">
      <div class="order-item-content">
        <div class="item-header">
          <p class="item-header-title">Your feedback helps us to improve!</p>
        </div>
        <div class="item-content content-single">
          <div class="single-list">
            <?php foreach($data_items as $data_item){ ?>
              <div class="data-item <?php echo (count($data_items) > 1 && $data_item['item_type'] == 'item-parent')?'border-bottom':''; ?>">
                <div class="data-item-left">
                  <img src="<?php echo $data_item['image']; ?>" alt="<?php echo $data_item['title']; ?>"/>
                </div>
                <div class="data-item-right">
                  <p class="title <?php if($data_item['trade'] == 1){ ?>traded<?php } ?>"><?php echo $data_item['title'];
                      if($data_item['trade'] == 1){ ?><span class="traded-badge">Traded</span><?php } ?>
                  </p>
                  <p class="my-rating">My Rate:<span class="rate">
                                    <?php for($i = 0; $i < 5; $i++){ ?>
                                      <?php if($i < $data_item['rate_star']){ ?>
                                        <i class="fas fa-heart active"></i>
                                      <?php }else{ ?>
                                        <i class="fas fa-heart"></i>
                                      <?php } ?>
                                    <?php } ?>
                                  </span></p>
                </div>
              </div>
            <?php } ?>
          </div>
          <?php if( !empty($data_sub['button']['show_rate']) ){ ?>
            <div class="single-list2">
              <a class="rate_<?php echo $club; ?>">
                <button class="btn btn-secondary condensed btn-vw btn-sm">Rate Past Collections</button>
              </a>
            </div>
          <?php } ?>
        </div>
        <div class="item-footer footer-single">
          <div class="order-actions">
            <div class="order-action">
              <a href="#" class="view_order" data-id="<?php echo $data_sub['subscription']['ID']; ?>" data-edit="view-order" data-type="<?php echo $club; ?>">
                <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/icon-mc-box-pink.png" alt="Icon Box" />
                <p class="title">View Past Orders</p>
              </a>
            </div>
            <?php if( !empty($data_sub['button']['show_rate']) ){ ?>
              <div class="order-action">
                <a href="#" class="rate_<?php echo $club; ?>">
                  <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/icon-mc-heart-pink.png" alt="Icon Heart" />
                  <p class="title">Rate Products</p>
                </a>
              </div>
            <?php } else { ?>
              <div class="order-action">
                <a href="<?php echo home_url('/shop'); ?>">
                  <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/icon-shop-pink-new.png" alt="Icon Shop" />
                  <p class="title">View Shop</p>
                </a>
              </div>
            <?php } ?>
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
  <?php } ?>

<?php } ?>