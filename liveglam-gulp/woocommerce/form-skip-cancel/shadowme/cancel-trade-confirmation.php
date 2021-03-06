<?php
  /**
   * Form SM cancel trade confirmation
   */

  if ( ! defined( 'ABSPATH' ) ) {
    exit;
  }

?>
<div class='mfp-hide form-skip-cancel form-cancel-trade form-confirm form-sm-cancel-trade-confirmation' id="form-sm-cancel-trade-confirmation">
  <div class="form-skip-cancel-head text-center">
    <div class="form-content">
      <img class="img-check" src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/popup-check-black.svg" alt="Image Check"/>
      <p class="title">Your trade has been successfully cancelled.</p>
    </div>
  </div>
  <div class="form-skip-cancel-footer text-center">
    <div class="form-content">
      <!--<div class="form-message">
        <p class="form-message-title">Need update title!!!</p>
        <p class="form-message-content">Need update description!!!</p>
      </div>-->
      <div class="single-action">
        <a href="<?php echo home_url('/my-account?tab=shadowme&nav=upcoming-tab-sm'); ?>" class="btn-action btn-primary reload-skip-cancel btn-static">OK</a>
      </div>
    </div>
  </div>
</div>

