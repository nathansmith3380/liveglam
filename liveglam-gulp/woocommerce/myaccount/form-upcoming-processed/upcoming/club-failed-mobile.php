<?php
  /**
   * Form Upcoming CLub Failled Mobile
   */

  if ( ! defined( 'ABSPATH' ) ) {
    exit;
  }

?>

<?php if($sub_failed_type == 'renewal'){ ?>
  <div class="liveglam-order-item liveglam-sub-failed">
    <div class="order-item-content">
      <div class="item-header">
        <p class="item-header-title">Card Update Needed!</p>
      </div>
      <div class="item-content no-border">
          <div class="failed-content">
              <p class="notice-failed"><?php echo $sub_failed_renewal_title; ?></p>
              <p class="failed-bottom-title"><?php echo $sub_failed_title; ?></p>
              <div class="failed-bottom-content">
                  <p class="failed-bottom-desc"><?php echo $sub_failed_renewal_desc; ?></p>
                  <img src="<?php echo $sub_failed_image_box; ?>" alt="Failed box"/>
              </div>
              <div class="failed-bottom-action">
                  <div class="failed-action-left"><a href="<?php echo home_url('/contact-us'); ?>">
                          <button class="btn btn-secondary condensed btn-vw btn-solid">Get In Touch</button>
                      </a></div>
                  <div class="failed-action-right"><a href="<?php echo $data_sub['action']['reactive']; ?>">
                          <button class="btn btn-primary condensed btn-vw">Update Card</button>
                      </a></div>
              </div>
          </div>
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
                    <img alt="Icon Edit" src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/icon-edit-profile-pink.png" />
                  </a>
                <?php } ?>
              </p>
            <?php } ?>
            <!--show card info-->
            <?php if(!empty($data_sub['card']['card_last4'])){ ?>
              <p class="lgdc-shipping-data d-none">
                <span class="lgdc-shipping-details"><span class="lgdc-shipping-title">From card ending with: </span><?php echo $data_sub['card']['card_last4']; ?></span>
                <a class="edit_billing" data-edit="billing" data-id="<?php echo $data_sub['subscription']['ID']; ?>" data-type="<?php echo $club; ?>">
                  <img alt="Icon Edit" src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/icon-edit-profile-pink.png"/>
                </a>
              </p>
            <?php } ?>
            <!--show shipping info-->
            <p class="lgdc-shipping-data">
              <span class="lgdc-shipping-details" style="-webkit-box-orient: vertical;"><span class="lgdc-shipping-title">Shipping: </span><?php echo str_replace("<br/>",", ",$data_sub['shipping']['shipping_address']); ?></span>
              <a class="edit_shipping" data-edit="shipping" data-id="<?php echo $data_sub['subscription']['ID']; ?>" data-type="<?php echo $club; ?>">
                <img alt="Icon Edit" src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/icon-edit-profile-pink.png" />
              </a>
            </p>
          </div>
          <?php if(!empty($data_sub['action']['cancel'])){ ?>
            <div class="lgs-data-info">
              <div class="lgdc-action">
                <?php if(!empty($data_sub['action']['cancel'])){ ?>
                  <a class="lgdc-action-content single-action <?php echo $key_club; ?>_cancel_action">
                    <div class="lgdc-action-button">
                      <img alt="Icon Cancel" src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/icon-myaccount-cancel-mb.png"/>Cancel
                    </div>
                  </a>
                <?php } ?>
              </div>
            </div>
          <?php } ?>
        </div>
      </div>
    </div>
  </div>
<?php }else{ ?>
  <div class="liveglam-order-item liveglam-sub-failed">
    <div class="order-item-content">
      <div class="item-header">
        <p class="item-header-title">Card Update Needed!</p>
      </div>
      <div class="item-content no-border">
          <div class="failed-content">
              <p class="notice-failed"><?php echo $sub_failed_parent_title; ?></p>
              <p class="failed-bottom-title"><?php echo $sub_failed_title; ?></p>
              <div class="failed-bottom-content">
                  <p class="failed-bottom-desc"><?php echo $sub_failed_parent_desc; ?></p>
                  <img src="<?php echo $sub_failed_image_box; ?>" alt="Failed box"/>
              </div>
              <div class="failed-bottom-action">
                  <div class="failed-action-left"><a href="<?php echo home_url('/contact-us'); ?>">
                          <button class="btn btn-secondary condensed btn-vw btn-solid">Get In Touch</button>
                      </a></div>
                  <div class="failed-action-right"><a href="<?php echo $data_sub['action']['reactive']; ?>">
                          <button class="btn btn-primary condensed btn-vw">Pay Now</button>
                      </a></div>
              </div>
          </div>
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
                      <img alt="Icon Edit" src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/icon-edit-profile-pink.png" />
                    </a>
                  <?php } ?>
                </p>
              <?php } ?>
              <!--show card info-->
              <?php if(!empty($data_sub['card']['card_last4'])){ ?>
                <p class="lgdc-shipping-data d-none">
                  <span class="lgdc-shipping-details"><span class="lgdc-shipping-title">From card ending with: </span><?php echo $data_sub['card']['card_last4']; ?></span>
                  <a class="edit_billing" data-edit="billing" data-id="<?php echo $data_sub['subscription']['ID']; ?>" data-type="<?php echo $club; ?>">
                    <img alt="Icon Edit" src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/icon-edit-profile-pink.png"/>
                  </a>
                </p>
              <?php } ?>
              <!--show shipping info-->
              <p class="lgdc-shipping-data">
                <span class="lgdc-shipping-details" style="-webkit-box-orient: vertical;"><span class="lgdc-shipping-title">Shipping: </span><?php echo str_replace("<br/>",", ",$data_sub['shipping']['shipping_address']); ?></span>
                <a class="edit_shipping" data-edit="shipping" data-id="<?php echo $data_sub['subscription']['ID']; ?>" data-type="<?php echo $club; ?>">
                  <img alt="Icon Edit" src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/icon-edit-profile-pink.png" />
                </a>
              </p>
            </div>
          </div>
        </div>
    </div>
  </div>
<?php } ?>
