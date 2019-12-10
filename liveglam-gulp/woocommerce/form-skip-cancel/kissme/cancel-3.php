<?php
  /**
   * Form KM cancel 3
   */

  if(!defined('ABSPATH')){
    exit;
  }

?>
<div class='mfp-hide form-skip-cancel form-cancel form-km-cancel-3' id="form-km-cancel-3">
  <div class="form-skip-cancel-head text-center">
    <div class="form-content">
      <p class="title-extend">LAST CHANCE</p>
      <p class="title">Would You Rather Skip a Payment Instead?</p>
      <p class="description">You might not like this month’s lippies, but you don’t have to cancel.</p>
    </div>
  </div>
  <div class="form-skip-cancel-body">
    <div class="form-content">
      <div class="form-wanna-skip">
        <img class="wanna-skip-image" src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/form-skip-cancel-skip-payment.png" alt="Image Skip"/>
        <div class="wanna-skip-action show-mobile">
          <a href="#" class="skip_a_month skip_month_km btn-secondary btn-solid transparent btn-static">Skip one month</a>
        </div>
        <p class="wanna-skip-title">You can skip this month, and you will not be charged. And you can keep all those hard-earned Reward points you have currently.</p>
        <div class="wanna-skip-action hide-mobile">
          <a href="#" class="skip_a_month skip_month_km btn-secondary btn-solid transparent btn-static">Skip one month</a>
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

