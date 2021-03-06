<?php
  /**
   * Form SM cancel 1
   */

  if ( ! defined( 'ABSPATH' ) ) {
    exit;
  }

?>
<div class='mfp-hide form-skip-cancel form-cancel form-sm-cancel-1' id="form-sm-cancel-1">
  <div class="form-skip-cancel-head text-center">
    <div class="form-content">
      <p class="title">Are You Sure You Want To Cancel?</p>
      <p class="description"><?php echo $display_name; ?>, look how close you are to earning some amazing prizes! If you cancel, you will lose <?php echo (!empty($points_related_to_sm) && $points > $points_related_to_sm)?$points_related_to_sm:'all your';?> points!</p>
    </div>
  </div>
  <div class="form-cancel-show-points">
    <img class="hide-mobile" src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/form-skip-cancel-banner-cancel.jpg" alt="ShadowMe Image"/>
    <img class="show-mobile" src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/form-skip-cancel-banner-cancel-mb.jpg"  alt="ShadowMe Image"/>
    <div class="show-points-content">
      <div class="show-points-center">
        <p class="show-points-title">You have <?php echo $points; ?> points</p>
        <p class="show-points-desc">Redeem your points for some great products!</p>
        <div class="show-points-action">
          <a href="<?php echo home_url('/rewards'); ?>" class="btn-secondary condensed btn-static">View all Reward prizes</a>
        </div>
      </div>
    </div>
  </div>
  <div class="form-skip-cancel-footer text-center">
    <div class="form-content">
      <div class="single-action">
        <a href="#" class="btn-action btn-primary stop-skip-cancel condensed btn-static">Never mind, I don’t wanna cancel</a>
        <a href="#" class="btn-action continue-skip-cancel">Continue cancelation</a>
      </div>
    </div>
  </div>
</div>

