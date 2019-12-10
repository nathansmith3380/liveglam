<?php
  /**
   * Form Upcoming CLub Not Enrolled Desktop
   */

  if ( ! defined( 'ABSPATH' ) ) {
    exit;
  }

?>

<div class="lgs-data-info-left">
  <div class="lgdi-item">
    <div class="lgdi-item-content no-border">
      <div class="order-notice">
        <p><?php echo $sub_not_enrolled_title; ?></p>
      </div>
      <p class="plan-notice">Choose a plan and join now!</p>
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
            <button class="btn btn-secondary btn-vw btn-block btn-solid btn-sm">Learn More</button>
          </a>
        </div>
      </div>
    </div>
  </div>
</div>
<div class="lgs-data-info-right">
  <div class="lgdi-item">
    <div class="lgdi-item-content no-border">
      <div class="item-sub-signup">
        <img class="signup-image" alt="Image signup" src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/dashboard-signup-<?php echo $key_club; ?>.jpg" />
        <div class="signup-action">
          <a href="<?php echo $club_link_monthly; ?>">
            <button class="btn btn-primary btn-block btn-vw">Join <?php echo $club_title; ?></button>
          </a>
        </div>
      </div>
    </div>
  </div>
</div>