<?php
  /**
   * Form Upcoming CLub Skipped Mobile
   */

  if ( ! defined( 'ABSPATH' ) ) {
    exit;
  }

?>

<div class="liveglam-order-item liveglam-sub-skip">
  <div class="order-item-content">
    <div class="item-header no-bottom">
      <div class="icon-subs-title has-line">
        <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/icon-subs-skip.png" alt="Icon Skip"/>
      </div>
      <p class="skip-waitlist-title">See you next month!</p>
      <p class="skip-waitlist-desc text-center"><?php echo $sub_skip_desc_top; ?></p>
      <hr class="skip-waitlist-desc-border">
      <div class="skip-content <?php echo (isset($skip_hide_next_box) && $skip_hide_next_box) ? 'd-none' : ''; ?>">
        <div class="skip-content-left">
          <p class="skip-content-title">Having FOMO?</p>
          <p class="skip-content-desc"><?php echo $sub_skip_desc; ?></p>
        </div>
        <div class="skip-content-right">
          <img class="skip-image" src="<?php echo $sub_skip_image_box; ?>" alt="Skip box">
        </div>
      </div>
      <div class="skip-action">
        <a class="skip-waitlist-link <?php echo $class_skip_reactive; ?>" href="#">
          <button class="btn btn-upgrade btn-primary condensed">
            Never mind, I don’t want to skip
          </button>
        </a>
      </div>
    </div>
    <div class="item-footer footer-single">
      <div class="subs-actions">
        <div class="lgs-data-info">
          <!--show plan subscription-->
          <?php if( !empty( $data_sub['subscription']['type_display'] ) ){ ?>
            <p class="lgdc-shipping-data">
              <span class="lgdc-shipping-details"><span class="lgdc-shipping-title">Plan: </span><?php echo $data_sub['subscription']['type_display']; ?> Sub</span>
              <?php if($data_sub['button']['show_upgrade']){ ?>
                <a href="javascript:;" class="upgrade upgrade_<?php echo $club; ?>" data-type="<?php echo $club; ?>">
                  Upgrade >
                </a>
              <?php } ?>
            </p>
          <?php } ?>
          <!--show shipping info-->
          <p class="lgdc-shipping-data">
            <span class="lgdc-shipping-details" style="-webkit-box-orient: vertical;"><span class="lgdc-shipping-title">Shipping: </span><?php echo str_replace("<br/>",", ",$data_sub['shipping']['shipping_address']); ?></span>
            <a class="edit_shipping" data-edit="shipping" data-id="<?php echo $data_sub['subscription']['ID']; ?>" data-type="<?php echo $club; ?>">
              <img alt="Icon Edit" src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/icon-edit-profile-pink.png" />
            </a>
          </p>
        </div>
      </div>
    </div>
  </div>
</div>
