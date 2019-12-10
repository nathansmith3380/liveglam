<?php
  /**
   * Form Upcoming CLub Waitlist Desktop
   */

  if ( ! defined( 'ABSPATH' ) ) {
    exit;
  }

?>

<div class="lgs-data-info">
  <p class="lgdi-title">Upcoming Shipment<span><a href="javascript:;" class="edit_billing" data-edit="billing" data-id="<?php echo $data_sub['subscription']['ID']; ?>" data-type="<?php echo $club; ?>">Billing Details<i class="fas fa-chevron-right"></i></a></span></p>
  <div class="lgdi-item">
    <div class="lgdi-item-content">
      <div class="notice-content align-center">
        <div class="notice-top">
          <div class="icon-subs-title">
            <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/icon-subs-waitlist.png" alt="Icon Waitlist">
          </div>
          <p class="skip-waitlist-title">You’re #<?php echo do_shortcode("[lg_user_position_in_waitlist product=".$club."]"); ?> in line!</p>
          <p class="skip-waitlist-desc text-center">We’re smooching to make more room in our club.<br>Your card will be charged once a spot opens!<span><a href="<?php echo home_url('/shop'); ?>">Shop<i class="fas fa-chevron-right"></i></a></span></p>
        </div>
        <?php if(in_array($subscription_type, array('monthly','sixmonth')) && LGS_CHECKOUT_SETTING::lgs_waitlist_enable_upgrade_on_dashboard($club)){ ?>
          <div class="notice-bot">
            <p class="skip-waitlist-title">Don’t want to wait?</p>
            <p class="skip-waitlist-desc text-center">Skip the waitlist by upgrading your subscription</p>
            <div class="skip-waitlist-action">
              <a class="upgrade_waitlist_inline" data-club="<?php echo $club ?>">
                <button class="btn btn-secondary btn-block btn-solid btn-vw btn-sm condensed">
                  Upgrade Membership
                </button>
              </a>
            </div>
          </div>
        <?php } ?>
      </div>
    </div>
  </div>
  <div class="lgdi-item skip-waitlist-section">
    <div class="lgdi-item-content">
      <div class="notice-content align-center">
        <p class="skip-waitlist-title">Skip the Waitlist!</p>
        <p class="skip-waitlist-desc text-center">Our monthly plan is currently on waitlist.<br>But you can upgrade to skip the waitlist<br>right now! Choose below another plan.</p>
        <div class="skip-waitlist-plan plan-list">
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
      <div class="skip-waitlist-footer">
        <span class="ignore_waitlist_inline"><i class="fas fa-chevron-left"></i>Do Nothing & Continue on Waitlist</span>
      </div>
    </div>
  </div>
</div>
