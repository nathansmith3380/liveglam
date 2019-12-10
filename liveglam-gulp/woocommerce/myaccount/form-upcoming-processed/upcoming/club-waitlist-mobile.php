<?php
  /**
   * Form Upcoming CLub Waitlist Mobile
   */

  if ( ! defined( 'ABSPATH' ) ) {
    exit;
  }

?>

<div class="liveglam-order-item liveglam-sub-waitlist">
  <div class="order-item-content">
      <div class="item-footer">
          <div class="waitlist-content">
              <div class="icon-subs-title has-line">
                  <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/icon-subs-waitlist.png" alt="Icon Waitlist"/>
              </div>
              <p class="skip-waitlist-title">You’re #<?php echo do_shortcode("[lg_user_position_in_waitlist product=".$club."]"); ?> in line!</p>
              <p class="skip-waitlist-desc">We’re smooching to make more room in<br>our club. Your card will be charged once a<br>spot opens!
              </p>
              <div class="skip-action-top">
                  <a class="skip-waitlist-link" href="<?php echo home_url('/2018/05/08/morpheme-kissme-waitlist-information'); ?>">Read More<i class="fas fa-chevron-right"></i></a>
              </div>
          </div>
          <?php if(in_array($subscription_type, array('monthly','sixmonth')) && LGS_CHECKOUT_SETTING::lgs_waitlist_enable_upgrade_on_dashboard($club)){ ?>
          <div class="waitlist-content">
        <p class="skip-waitlist-title">Don’t want to wait?</p>
        <p class="skip-waitlist-desc">Skip the waitlist by upgrading your<br>subscription or choose a past collection.</p>
        <div class="skip-action">
          <a class="upgrade_waitlist_inline" data-club="<?php echo $club; ?>">
            <button class="btn btn-secondary btn-vw btn-sm condensed">Upgrade Membership</button>
          </a>
          <!--<a href="#"><button class="btn btn-secondary">Choose Past Collection</button></a>-->
        </div>
        </div>
          <?php } ?>
      </div>
      <div class="item-footer footer-single">
        <div class="subs-actions">
          <div class="lgs-data-info">
            <!--show plan subscription-->
            <?php if( !empty( $data_sub['subscription']['type_display'] ) ){ ?>
              <p class="lgdc-shipping-data">
                <span class="lgdc-shipping-details"><span class="lgdc-shipping-title">Plan: </span><?php echo $data_sub['subscription']['type_display']; ?> Sub</span>
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
  <div class="order-item-content order-item-content-2" style="display: none;">
    <div class="sub-data-details">
      <div class="sub-data-detail">
        <p class="skip-waitlist-title">Skip the Waitlist!</p>
        <p class="skip-waitlist-desc">Our monthly plan is currently on waitlist.<br>But you can upgrade to skip the waitlist<br>right now! Choose below another plan.</p>
        <div class="plan-list">
          <?php if($subscription_type != 'sixmonth'){ ?>
            <div class="plan-item">
              <a href="<?php echo $link_ck_sixmonth; ?>&subscription_wl=<?php echo $data_sub['subscription']['ID']; ?>">
                <div class="plan-item-content">
                  <div class="plan-item-left">Pay every 6 months</div>
                  <div class="plan-item-right"><?php echo $price_sixmonth; ?><i class="fas fa-chevron-right"></i></div>
                </div>
              </a>
            </div>
          <?php } ?>
          <div class="plan-item">
            <a href="<?php echo $link_ck_annual; ?>&subscription_wl=<?php echo $data_sub['subscription']['ID']; ?>">
              <div class="plan-item-content">
                <div class="plan-item-left">Pay every 12 months</div>
                <div class="plan-item-right"><?php echo $price_annual; ?><i class="fas fa-chevron-right"></i></div>
              </div>
            </a>
          </div>
        </div>
      </div>
    </div>
    <div class="skip-waitlist-footer">
      <span class="ignore_waitlist_inline"><i class="fas fa-chevron-left"></i>Do Nothing & Continue on Waitlist</span>
    </div>
  </div>
</div>
