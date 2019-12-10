<?php
  /**
   * Form SM skip 2
   */

  if ( ! defined( 'ABSPATH' ) ) {
    exit;
  }

?>
<div class='mfp-hide form-skip-cancel form-skip form-sm-skip-2' id="form-sm-skip-2">
  <div class="form-skip-cancel-head text-center">
    <div class="form-content">
      <p class="title">Would you Rather Trade Your Palette?</p>
      <p class="description">You can easily replace your next set of palette with some of these awesome alternatives for no additional cost.</p>
    </div>
  </div>
  <div class="form-skip-cancel-body">
    <div class="form-content">
      <div class="form-select-trade">
        <div class="form-select-trade-left">
          <div class="form-select-trade-content">
            <div class="select-trade-content">
              <p class="select-trade-content-title">New trade options<br class="show-desktop">are added regularly!</p>
              <a href="#" class="trade_action trade_shadowme btn-secondary btn-solid condensed btn-static transparent">Trade this month’s palette</a>
            </div>
          </div>
        </div>
        <div class="form-select-trade-right">
          <div class="form-select-trade-content">
            <div class="select-trade-lists">
              <?php echo $product_trade_sm; ?>
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

