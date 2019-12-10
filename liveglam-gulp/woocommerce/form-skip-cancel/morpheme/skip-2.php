<?php
  /**
   * Form MM skip 2
   */

  if ( ! defined( 'ABSPATH' ) ) {
    exit;
  }

?>
<div class='mfp-hide form-skip-cancel form-skip form-mm-skip-2' id="form-mm-skip-2">
  <div class="form-skip-cancel-head text-center">
    <div class="form-content">
      <p class="title">Would you Rather Trade Your Brushes?</p>
      <p class="description">You can easily replace your next set of brushes with some of these awesome alternatives for no additional cost.</p>
    </div>
  </div>
  <div class="form-skip-cancel-body">
    <div class="form-content">
      <div class="form-select-trade">
        <div class="form-select-trade-left">
          <div class="form-select-trade-content">
            <div class="select-trade-content">
              <p class="select-trade-content-title">New trade options<br class="show-desktop">are added regularly!</p>
              <a href="#" class="trade_action trade_morpheme btn-secondary btn-solid condensed btn-static transparent">Trade this month’s brushes</a>
            </div>
          </div>
        </div>
        <div class="form-select-trade-right">
          <div class="form-select-trade-content">
            <div class="select-trade-lists">
              <?php echo $product_trade_mm; ?>
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

