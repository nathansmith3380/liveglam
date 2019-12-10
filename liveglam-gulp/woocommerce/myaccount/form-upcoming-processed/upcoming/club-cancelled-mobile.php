<?php
  /**
   * Form Upcoming CLub Cancelled Mobile
   */

  if ( ! defined( 'ABSPATH' ) ) {
    exit;
  }

?>

<?php if($in_48h_cancel){ //case cancel in 48 hours?>
  <div class="liveglam-order-item liveglam-sub-cancel-in48h">
    <div class="order-item-content">
        <div class="cancelled-content">
      <div class="icon-subs-title">
        <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/icon-subs-cancel.png" alt="Icon Cancel">
      </div>
      <div class="item-content">
        <p class="cancel-title">We are so sad to<br>see you go!</p>
        <p class="cancel-desc"><?php echo $sub_cancel_desc_in48h; ?></p>
      </div>
      <div class="item-footer">
        <p class="cancel-desc-48h"><?php echo $sub_cancel_notice_in48; ?></p>
        <div class="cancel-action">
          <a href="mailto:support@liveglam.com?Subject=<?php echo esc_html("I want to reactivate my subscription has cancelled within 48h #".$data_sub['subscription']['ID']); ?>">
            <button class="btn btn-primary">Reactivate</button>
          </a>
        </div>
      </div>
        </div>
    </div>
  </div>
<?php }elseif($in_30d_cancel){ //case cancel in 30 days?>
  <div class="liveglam-order-item liveglam-sub-cancel-in30d">
    <div class="order-item-content">
        <div class="cancelled-content">
      <div class="item-footer">
        <p class="cancel-title"><?php echo $sub_cancel_title_in30d; ?></p>
        <img class="cancel-image" src="<?php echo $sub_cancel_image_box; ?>" alt="Cancel box">
        <p class="cancel-desc-30d"><?php echo $sub_cancel_desc_in30d; ?></p>
        <div class="cancel-action">
          <a href="<?php echo $data_sub['action']['reactive']; ?>">
            <button class="btn btn-primary">Come back to <?php echo $club_title; ?></button>
          </a>
        </div>
      </div>
        </div>
    </div>
  </div>
<?php }else{ //case cancelled than 30 days?>
  <div class="liveglam-order-item liveglam-sub-cancel-after30d">
    <div class="order-item-content">
        <div class="cancelled-content">
      <div class="item-footer">
        <p class="cancel-title"><?php echo $sub_cancel_title_out30d; ?></p>
        <img class="cancel-image" src="<?php echo $sub_cancel_image_box; ?>" alt="Cancel box">
        <p class="cancel-desc-30d"><?php echo $sub_cancel_desc_out30d; ?></p>
        <div class="cancel-action">
          <a href="<?php echo $data_sub['action']['reactive']; ?>">
            <button class="btn btn-primary">Come back to <?php echo $club_title; ?></button>
          </a>
        </div>
      </div>
        </div>
    </div>
  </div>
<?php } ?>
