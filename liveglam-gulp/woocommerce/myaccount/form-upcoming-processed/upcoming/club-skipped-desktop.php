<?php
  /**
   * Form Upcoming CLub Skipped Desktop
   */

  if ( ! defined( 'ABSPATH' ) ) {
    exit;
  }

?>

<div class="lgs-data-info">
  <p class="lgdi-title">Upcoming Shipment<span><a class="undo-skipped <?php echo $class_skip_reactive; ?>" href="#">Undo Skip</a></span></p>
  <div class="lgdi-item">
    <div class="lgdi-item-content">
      <div class="item-footer">
        <div class="notice-top">
          <div class="icon-subs-title">
            <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/icon-subs-skip.png" alt="Icon Skip">
          </div>
          <p class="skip-waitlist-title">See you next month!</p>
          <p class="skip-waitlist-desc text-center"><?php echo $sub_skip_desc_top; ?></p>
        </div>
        <div class="notice-bot <?php echo (isset($skip_hide_next_box) && $skip_hide_next_box) ? 'd-none' : ''; ?>">
          <p class="skip-bot-title">Having FOMO?</p>
          <div class="bottom-content">
            <div class="bottom-content-left">
              <p class="skip-bot-desc"><?php echo $sub_skip_desc; ?></p>
            </div>
            <div class="bottom-content-right">
              <img src="<?php echo $sub_skip_image_box; ?>" alt="Skip box">
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="lgdi-item-action">
      <a href="#" class="lgdi-action single-action <?php echo $class_skip_reactive; ?>">
        <button class="btn btn-primary btn-block btn-solid condensed">
          Nevermind I don’t want to skip
        </button>
      </a>
    </div>
  </div>
</div>
