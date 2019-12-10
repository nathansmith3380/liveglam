<?php
  /**
   * Form KM reactive
   */

  if ( ! defined( 'ABSPATH' ) ) {
    exit;
  }

?>
<div class='mfp-hide form-skip-cancel form-reactive form-km-reactive' id="form-km-reactive">
  <div class="form-skip-cancel-head text-center">
    <div class="form-content">
      <p class="title">Are you sure you want to reactivate?</p>
      <p class="description"><?php echo $display_name; ?>, this action will reactivate your skipped subscription.</p>
    </div>
  </div>
  <div class="form-skip-cancel-footer text-center">
    <div class="form-content">
      <div class="single-action">
        <a href="<?php echo $link_reactive_km; ?>" class="btn-action btn-primary condensed btn-static">Continue to Reactivate</a>
        <a href="#" class="btn-action stop-skip-cancel">Never mind, I don’t want to reactivate.</a>
      </div>
    </div>
  </div>
</div>
