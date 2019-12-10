<?php
  /**
   * Form Upcoming CLub Failled Desktop
   */

  if ( ! defined( 'ABSPATH' ) ) {
    exit;
  }

?>

<?php if($sub_failed_type == 'renewal'){ ?>
  <div class="lgs-data-info">
    <p class="lgdi-title">Upcoming Shipment<span><a href="javascript:;" class="edit_billing" data-edit="billing" data-id="<?php echo $data_sub['subscription']['ID']; ?>" data-type="<?php echo $club; ?>">Billing Details<i class="fas fa-chevron-right"></i></a></span></p>
    <div class="lgdi-item">
      <div class="lgdi-item-content">
        <div class="item-header">
          <p class="item-header-title"><strong>Card Update Needed!</strong></p>
        </div>
        <div class="item-footer">
          <div class="notice-top">
            <p class="notice-failed"><?php echo $sub_failed_renewal_title; ?></p>
          </div>
          <div class="notice-bot">
            <div class="bottom-content">
              <div class="bottom-content-left">
                <p class="failed-bottom-title"><?php echo $sub_failed_title; ?></p>
                <p class="failed-bottom-desc"><?php echo $sub_failed_renewal_desc; ?></p>
              </div>
              <div class="bottom-content-right">
                <img src="<?php echo $sub_failed_image_box; ?>" alt="Failed box">
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="lgdi-item-action">
        <a href="<?php echo home_url('/contact-us'); ?>" class="lgdi-action multi-action">
          <button class="btn btn-secondary btn-block btn-solid condensed">
            Get In Touch
          </button>
        </a>
        <a href="<?php echo $data_sub['action']['reactive']; ?>" class="lgdi-action multi-action">
          <button class="btn btn-primary btn-block btn-solid condensed">
            Update Your Card
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
        <div class="item-header">
          <p class="item-header-title"><strong>Card Update Needed!</strong></p>
        </div>
        <div class="item-footer">
          <div class="notice-top">
            <p class="notice-failed"><?php echo $sub_failed_parent_title; ?></p>
          </div>
          <div class="notice-bot">
            <div class="bottom-content">
              <div class="bottom-content-left">
                <p class="failed-bottom-title"><?php echo $sub_failed_title; ?></p>
                <p class="failed-bottom-desc"><?php echo $sub_failed_renewal_desc; ?></p>
              </div>
              <div class="bottom-content-right">
                <img src="<?php echo $sub_failed_image_box; ?>" alt="Failed box">
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="lgdi-item-action">
        <a href="<?php echo home_url('/contact-us'); ?>" class="lgdi-action multi-action">
          <button class="btn btn-secondary btn-block btn-solid condensed">
            Get In Touch
          </button>
        </a>
        <a href="<?php echo $data_sub['action']['reactive']; ?>" class="lgdi-action multi-action">
          <button class="btn btn-primary btn-block btn-solid condensed">
            Update Your Card
          </button>
        </a>
      </div>
    </div>
  </div>
<?php } ?>
