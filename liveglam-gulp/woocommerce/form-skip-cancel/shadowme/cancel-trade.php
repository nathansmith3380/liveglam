<?php
  /**
   * Form SM cancel trade
   */

  if ( ! defined( 'ABSPATH' ) ) {
    exit;
  }

?>
<div class='mfp-hide form-skip-cancel form-cancel-trade form-sm-cancel-trade' id="form-sm-cancel-trade">
  <div class="form-skip-cancel-head text-center">
    <div class="form-content">
      <p class="title">Are you sure you want to cancel your trade?</p>
      <p class="description">If so, you'll receive our <?php echo $data_upcoming_sm['upcoming_collection']; ?> palette instead.</p>
    </div>
  </div>
  <div class="form-skip-cancel-footer text-center">
    <div class="form-content">
      <div class="single-action">
        <a href="#" class="btn-action btn-primary cancel_trade_action btn-static" data-subID="<?php echo $subscription_sm; ?>" data-club="sm">Cancel my Trade</a>
        <a href="#" class="btn-action stop-skip-cancel">Never mind, I'd like to keep my traded item(s).</a>
      </div>
    </div>
  </div>
</div>
