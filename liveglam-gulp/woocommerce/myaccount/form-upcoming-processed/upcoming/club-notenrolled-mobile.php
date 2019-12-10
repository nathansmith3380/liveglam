<?php
  /**
   * Form Upcoming CLub Not Enrolled Mobile
   */

  if ( ! defined( 'ABSPATH' ) ) {
    exit;
  }

?>

<div class="data-content">
  <div class="order-item">
    <div class="liveglam-order-list">
      <div class="liveglam-order-item notenrolled">
        <div class="order-item-image">
          <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/dashboard-signup-<?php echo $key_club; ?>.jpg" alt="Image signup" />
        </div>
        <div class="order-item-content-2">
          <div class="sub-data-details">
            <div class="sub-data-detail">
              <p class="title"><?php echo $sub_not_enrolled_title; ?></p>
              <p class="desc">Choose one of these plans and join now!</p>
              <div class="plan-list">
                <div class="plan-item">
                  <a href="<?php echo $link_ck_monthly; ?>">
                    <div class="plan-item-content">
                      <div class="plan-item-left">Pay as you go</div>
                      <div class="plan-item-right"><?php echo $price_monthly; ?><i class="fas fa-chevron-right"></i></div>
                    </div>
                  </a>
                </div>
                <div class="plan-item">
                  <a href="<?php echo $link_ck_sixmonth; ?>">
                    <div class="plan-item-content">
                      <div class="plan-item-left">Pay every 6 months</div>
                      <div class="plan-item-right"><?php echo $price_sixmonth; ?><i class="fas fa-chevron-right"></i></div>
                    </div>
                  </a>
                </div>
                <div class="plan-item">
                  <a href="<?php echo $link_ck_annual; ?>">
                    <div class="plan-item-content">
                      <div class="plan-item-left">Pay every 12 months</div>
                      <div class="plan-item-right"><?php echo $price_annual; ?><i class="fas fa-chevron-right"></i></div>
                    </div>
                  </a>
                </div>
                <div class="plan-action">
                  <a href="<?php echo $club_link_monthly; ?>">
                    <button class="btn btn-secondary btn-solid">Learn More</button>
                  </a>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
