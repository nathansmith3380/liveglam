<?php
  /**
   * Form MM skip 1
   */

  if ( ! defined( 'ABSPATH' ) ) {
    exit;
  }

?>
<div class='mfp-hide form-skip-cancel form-skip form-mm-skip-1' id="form-mm-skip-1">
  <div class="form-skip-cancel-head text-center">
    <div class="form-content">
      <p class="title">Are You Sure You Want to Skip One Month?</p>
    </div>
  </div>
  <div class="form-skip-show-points">
    <div class="form-content">
      <div class="show-points-row">
        <div class="show-points-left">
          <p class="show-points-title hide-mobile"><?php echo $display_name; ?>, you have <?php echo $points; ?> points</p>
          <p class="show-points-desc hide-mobile">You are so close to earning some amazing prizes!</p>
          <p class="show-points-title show-mobile">You have <?php echo $points; ?> points</p>
          <p class="show-points-desc show-mobile"><?php echo $display_name; ?>, you are so close to earning some amazing prizes!</p>
        </div>
        <div class="show-points-right text-center">
          <div class="show-points-action">
            <a href="<?php echo home_url('/rewards'); ?>" class="btn-secondary condensed btn-static">View all Reward prizes</a>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="form-skip-cancel-body">
    <div class="form-content">
      <div class="form-skip-explain">
        <div class="form-skip-explain-left hide-mobile">
          <div class="form-skip-explain-content">
            <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/form-skip-cancel-mm-badge-skip.png" alt="Image Badge Skip"/>
          </div>
        </div>
        <div class="form-skip-explain-right">
          <div class="form-skip-explain-content">
            <div class="explain-content">
              <p class="explain-title">If you skip a month of MorpheMe:</p>
              <p class="explain-lists">You will not make your next payment</p>
              <p class="explain-lists">You will not receive your next brushes</p>
              <p class="explain-lists">You will not receive your monthly Reward points</p>
              <p class="explain-lists">Your pending trades will be cancelled, if you submitted one for this order.</p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="form-skip-cancel-footer text-center">
    <div class="form-content">
      <div class="single-action">
        <a href="#" class="btn-action btn-primary stop-skip-cancel condensed btn-static">Never mind, I don’t wanna skip</a>
        <a href="#" class="btn-action continue-skip-cancel">Continue skipping a month</a>
      </div>
    </div>
  </div>
</div>

