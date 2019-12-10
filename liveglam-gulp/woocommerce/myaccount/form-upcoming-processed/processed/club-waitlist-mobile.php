<?php
  /**
   * Form Processed CLub Active Mobile
   */

  if ( ! defined( 'ABSPATH' ) ) {
    exit;
  }

?>

<div class="liveglam-order-item liveglam-sub-order-waitlist">
  <div class="order-item-content">
    <div class="item-content vertical-center">
      <div class="icon-subs-title">
        <img class="image-waitlist-processed" src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/icon-myaccount-order-shipped2.png" alt="Icon Shipped"/>
      </div>
      <p class="skip-waitlist-title">You’re in waitlist,<br>so no orders have been<br>processed yet.</p>
      <p class="skip-waitlist-desc">Once you’re in club, your goodies will ship<br>within 2 business days!
      </p>
    </div>
      <div class="item-footer footer-single">
          <div class="subs-actions">
              <div class="lgs-data-info">
                  <!--show plan subscription-->
                  <?php if( !empty( $data_sub['subscription']['type_display'] ) ){ ?>
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
                          <span class="lgdc-shipping-details"><span class="lgdc-shipping-title">Next billing date: </span><?php echo date('F d, Y',$data_sub['time']['next_payment']); ?></span>
                          <?php if(!empty($data_sub['action']['change_date'])){ ?>
                              <a class="edit_schedule" data-edit="schedule" data-id="<?php echo $data_sub['subscription']['ID']; ?>" data-type="<?php echo $club; ?>">
                                  <img alt="Billing" src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/icon-edit-profile-pink.png" />
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
                      <span class="lgdc-shipping-details" style="-webkit-box-orient: vertical;"><span class="lgdc-shipping-title">Shipping: </span><?php echo str_replace("<br/>",", ",$data_sub['shipping']['shipping_address']); ?></span>
                      <a class="edit_shipping" data-edit="shipping" data-id="<?php echo $data_sub['subscription']['ID']; ?>" data-type="<?php echo $club; ?>">
                          <img alt="Shipping" src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/icon-edit-profile-pink.png" />
                      </a>
                  </p>
              </div>
              <?php if(!empty($data_sub['action']['cancel'])){ ?>
                  <div class="lgs-data-info">
                      <div class="lgdc-action">
                          <a class="lgdc-action-content single-action <?php echo $key_club; ?>_cancel_action">
                              <div class="lgdc-action-button">
                                  <img alt="Cancel" src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/icon-myaccount-cancel-mb.png" />Cancel Membership
                              </div>
                          </a>
                      </div>
                  </div>
              <?php } ?>
          </div>
      </div>
  </div>
</div>