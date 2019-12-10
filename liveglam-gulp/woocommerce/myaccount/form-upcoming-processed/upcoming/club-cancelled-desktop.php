<?php
  /**
   * Form Upcoming CLub Cancelled Desktop
   */

  if ( ! defined( 'ABSPATH' ) ) {
    exit;
  }

?>

<?php if($in_48h_cancel){ //case cancel in 48 hours?>
  <div class="lgs-data-info">
    <p class="lgdi-title">Upcoming Shipment<span><a href="javascript:;" class="edit_billing" data-edit="billing" data-id="<?php echo $data_sub['subscription']['ID']; ?>" data-type="<?php echo $club; ?>">Billing Details<i class="fas fa-chevron-right"></i></a></span></p>
    <div class="lgdi-item">
      <div class="lgdi-item-content">
        <div class="item-footer">
          <div class="notice-top">
            <div class="icon-subs-title">
              <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/icon-subs-cancel.png" alt="Icon cancel">
            </div>
            <p class="skip-waitlist-title">We are so sad to<br>see you go!</p>
            <p class="skip-waitlist-desc text-center"><?php echo $sub_cancel_desc_in48h; ?></p>
          </div>
          <div class="notice-bot">
            <p class="notice-failed"><?php echo $sub_cancel_notice_in48; ?></p>
          </div>
        </div>
      </div>
      <div class="lgdi-item-action">
        <a class="lgdi-action single-action" href="mailto:support@liveglam.com?Subject=<?php echo esc_html("I want to reactivate my subscription has cancelled within 48h #".$data_sub['subscription']['ID']); ?>">
          <button class="btn btn-primary btn-block btn-solid condensed">
            Contact Us to Reactivate
          </button>
        </a>
      </div>
    </div>
  </div>
<?php }else{ ?>
  <div class="lgs-data-info">
    <p class="lgdi-title">Upcoming Shipment<span><a href="javascript:;" class="edit_billing" data-edit="billing" data-id="<?php echo $data_sub['subscription']['ID']; ?>" data-type="<?php echo $club; ?>">Billing Details<i class="fas fa-chevron-right"></i></a></span></p>
    <div class="lgdi-item">
      <div class="lgdi-item-content">
        <div class="item-footer">
          <p class="skip-waitlist-title"><?php echo $sub_cancel_title_in30d; ?></p>
          <div class="cancel-image">
            <img alt="Cancel box" src="<?php echo $sub_cancel_image_box; ?>" />
          </div>
          <p class="notice-failed nt-cancel"><?php echo $sub_cancel_desc_in30d; ?></p>
        </div>
      </div>
      <div class="lgdi-item-action">
        <a href="<?php echo $data_sub['action']['reactive']; ?>" class="lgdi-action single-action">
          <button class="btn btn-primary btn-block btn-solid condensed">
            Come back to <?php echo $club_title; ?>
          </button>
        </a>
      </div>
    </div>
  </div>
<?php } ?>
