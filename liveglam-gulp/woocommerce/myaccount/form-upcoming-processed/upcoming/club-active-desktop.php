<?php
  /**
   * Form Upcoming CLub Active Desktop
   */

  if ( ! defined( 'ABSPATH' ) ) {
    exit;
  }

?>

<?php if($is_release_new_box){ //case next box is release?>
  <div class="lgs-data-info">
    <p class="lgdi-title">Upcoming Shipment<span><a href="javascript:;" class="edit_billing" data-edit="billing" data-id="<?php echo $data_sub['subscription']['ID']; ?>" data-type="<?php echo $club; ?>">Billing Details<i class="fas fa-chevron-right"></i></a></span></p>
    <div class="lgdi-item">
      <div class="lgdi-item-content">
          <?php if(!$is_trade_points){ ?>
        <?php if(!empty($sub_active_next_shipment)){?>
          <div class="item-header">
            <p class="item-header-title flcenter">Estimated Ship Date:
              <span><?php echo date('F j, Y', $sub_active_next_shipment); ?>
                <?php if($data_sub['action']['change_date']){ ?>
                  <a class="edit_schedule" data-edit="schedule" data-id="<?php echo $data_sub['subscription']['ID']; ?>" data-type="<?php echo $club; ?>">
                    <img alt="Icon Edit" src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/icon-edit-profile-pink.png" />
                  </a>
                <?php } ?>
              </span>
            </p>
          </div>
        <?php } ?>
        <div class="item-content content-single">
          <div class="single-header">
              <?php if( $is_traded_set && $status == 'active' ){ ?>
                  <p class="glamrock"><?php echo $traded_new_product; ?><span></span></p>
            <?php } elseif(!empty($monthpost_title) || !empty($monthpost_collection)){ ?>
              <p class="glamrock"><?php echo $monthpost_collection; ?><span><?php echo $monthpost_title; ?></span></p>
            <?php } ?>
            <?php if( $show_breakdown ){ ?>
              <p class="breakdown">
                <a class="show-breakdown" href="javascript:;">View Collection Breakdown<i class="fas fa-chevron-down"></i></a>
                <a class="hide-breakdown"  href="javascript:;" style="display: none;">Hide Collection Breakdown<i class="fas fa-chevron-up"></i></a>
                <?php if ($is_traded_set || $is_traded_single) { ?>
                  <span class="customized-banner">Traded</span>
                <?php } ?>
              </p>
            <?php } ?>
          </div>
          <div class="single-list" <?php echo $show_breakdown?"style='display: none;'":""; ?>>
            <?php foreach($sub_active_single_list as $single_list){ ?>
              <div class="data-item">
                <div class="data-item-left">
                  <img src="<?php echo $single_list['image']; ?>" alt="<?php echo $single_list['title']; ?>"/>
                </div>
                <div class="data-item-right">
                  <p class="title <?php if($single_list['trade'] == 1){ ?>traded<?php } ?>"><?php echo $single_list['title']; ?><?php if($single_list['trade'] == 1){ ?><span class="traded-badge">Traded</span><?php } ?></p>
                  <p class="desc <?php if($single_list['trade'] == 1){ ?>traded<?php } ?>"><?php echo $single_list['desc']; ?></p>
                </div>
              </div>
            <?php } ?>
          </div>
          <?php if( $show_breakdown ){ ?>
              <?php if( $is_traded_set && $status == 'active' ){ ?>
                  <div class="single-trade">
                      <div class="item-trade-new">
                          <div class="n-trade-content">
                              <div class="n-trade-center">
                                  <div class="n-trade-image image-center float-left">
                                      <img alt="Old trade" class="trade-image" src="<?php echo $trade_month_image; ?>" />
                                  </div>
                                  <div class="n-trade-image image-center float-right active">
                                      <img alt="New trade" class="trade-image" src="<?php echo $trade_new_image; ?>" />
                                  </div>
                                  <img alt="Trade confirm" class="trade-confirm" src="<?php echo get_stylesheet_directory_uri().'/assets/img/icon-myaccount-trade-confirm.svg'; ?>">
                              </div>
                          </div>
                          <div class="n-trade-footer">
                              <p class="n-trade-title"><b>You’ve successfully traded your upcoming collection for <?php echo $traded_new_product; ?></b> You have until <b><?php echo date('m/d', $data_sub['time']['trade_cancel_until']); ?></b> to modify or cancel this trade.</p>
                          </div>
                      </div>
                  </div>
              <?php } else { ?>
                  <div class="single-video" style="background-image: url(<?php echo $monthPost['data_video']['video_block_image']; ?>);">
                      <div class="play-video">
                          <a href="<?php echo $monthPost['data_video']['video_url']; ?>">
                              <img alt="Play" src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/icon-myaccount-play.png">
                          </a>
                      </div>
                  </div>
              <?php } ?>
          <?php } ?>
        </div>
          <?php } else { ?>
              <div class="item-content">
                  <div class="trade-point-content">
                      <div class="trade-point-top">
                          <div class="trade-point-icon">
                              <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/icon-sub-points.png" alt="Icon Point">
                          </div>
                          <p class="trade-point-title">You got 600 Reward<br>points richer!</p>
                          <p class="trade-point-desc text-center">You chose to trade our monthly collection <?php echo $monthpost_collection; ?> for more Reward points.</p>
                      </div>
                      <div class="trade-point-bot">
                          <p class="trade-point-bot-title">Having FOMO?</p>
                          <div class="bottom-content">
                              <div class="bottom-content-left">
                                  <p class="skip-bot-desc"><span class='time-left'><?php echo $time_trade_cancel_left['time'].' '.strtoupper($time_trade_cancel_left['type']); ?> LEFT</span> to still get this collection. It's not too late to get there <?php echo ($key_club=='mm'?'brushes':($key_club=='km'?'lippies':'eyeshadow')); ?>! Click the button below<?php if(!empty($data_sub['time']['trade_cancel_until'])){ ?> until <b><?php echo date('m/d', $data_sub['time']['trade_cancel_until']); ?></b><?php } ?> to snag them before they're gone.</p>
                              </div>
                              <div class="bottom-content-right">
                                  <img src="<?php echo $trade_month_image; ?>" alt="Old trade">
                              </div>
                          </div>
                      </div>
                  </div>
              </div>
          <?php } ?>
      </div>
      <div class="lgdi-item-action">
        <?php if(!empty($data_sub['button']['show_trade'])){ ?>
          <a class="lgdi-action multi-action trade_action trade_<?php echo $club; ?>">
            <button class="btn btn-secondary btn-solid btn-block condensed">
              <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/icon-mc-trade-pink.png" alt="Icon Trade" />
              Trade <?php echo (!empty($data_sub['time']['trade_until']))?'(until '.date('m/d', $data_sub['time']['trade_until']).')':''; ?>
            </button>
          </a>
        <?php } ?>
        <?php if(!empty($data_sub['button']['show_trade_cancel'])){ ?>
          <a class="lgdi-action multi-action trade_cancel_action trade_cancel_<?php echo $club; ?>">
            <button class="btn btn-secondary btn-solid btn-block condensed">
              <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/icon-mc-trade-pink.png" alt="Icon Trade" />
              Cancel Trade
            </button>
          </a>
        <?php } ?>
        <a href="<?php echo $club_link_monthly; ?>" class="lgdi-action <?php echo (!empty($data_sub['button']['show_trade'])||!empty($data_sub['button']['show_trade_cancel']))?'multi-action':'single-action'; ?>">
          <button class="btn btn-primary btn-solid btn-block condensed">
            <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/icon-mc-view-white.png" alt="Icon view" />
            Get More Details
          </button>
        </a>
      </div>
    </div>
  </div>
<?php }else{ //case next box not release yet?>
  <div class="lgs-data-info">
    <p class="lgdi-title">Upcoming Shipment<span><a href="javascript:;" class="edit_billing" data-edit="billing" data-id="<?php echo $data_sub['subscription']['ID']; ?>" data-type="<?php echo $club; ?>">Billing Details<i class="fas fa-chevron-right"></i></a></span></p>
    <div class="lgdi-item">
      <div class="lgdi-item-content">
          <?php if( !$is_traded_set) { ?>
        <div class="time-release <?php echo $club; ?>">
          <div class="time-release-icon">
            <img src="<?php echo $sub_active_img_norelease; ?>" alt="Image not release">
          </div>
            <p class="time-release-title"><?php echo $time_release['time']; ?></p>
            <p class="time-release-desc"><?php echo $time_release['type']. " until we reveal <br>our next ".($key_club=='mm'?'Brushes':($key_club=='km'?'Lippies':'Shades')); ?></p>
        </div>
        <div class="item-footer">
          <p class="notice-release text-center">We always release our monthly collection<br>on the 23rd. Stay tuned! In the meantime,<br><a href="<?php echo home_url('/shop'); ?>">shop other LiveGlam products here. <span>Shop<i class="fas fa-chevron-right"></i></span></a></p>
        </div>
          <?php } elseif(!$is_trade_points) { ?>
              <?php if(!empty($sub_active_next_shipment)){?>
                  <div class="item-header">
                      <p class="item-header-title flcenter">Estimated Ship Date:
                          <span><?php echo date('F j, Y', $sub_active_next_shipment); ?>
                              <?php if($data_sub['action']['change_date']){ ?>
                                  <a class="edit_schedule" data-edit="schedule" data-id="<?php echo $data_sub['subscription']['ID']; ?>" data-type="<?php echo $club; ?>">
                                      <img alt="Icon Edit" src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/icon-edit-profile-pink.png" />
                                  </a>
                              <?php } ?>
                          </span>
                      </p>
                  </div>
              <?php } ?>
            <div class="item-content content-single">
              <div class="single-header">
                  <?php if(!empty($traded_new_product)){ ?>
                      <p class="glamrock"><?php echo $traded_new_product; ?><span></span></p>
                  <?php } ?>
                  <p class="breakdown">
                      <a class="show-breakdown" href="javascript:;">View Collection Breakdown<i class="fas fa-chevron-down"></i></a>
                      <a class="hide-breakdown" style="display: none;" href="javascript:;">Hide Collection Breakdown<i class="fas fa-chevron-up"></i></a>
                      <span class="customized-banner">Traded</span>
                  </p>
              </div>
              <div class="single-list" style="display: none;">
                  <?php foreach($sub_active_single_list as $single_list){ ?>
                      <div class="data-item">
                          <div class="data-item-left">
                              <img src="<?php echo $single_list['image']; ?>" alt="<?php echo $single_list['title']; ?>"/>
                          </div>
                          <div class="data-item-right">
                              <p class="title <?php if($single_list['trade'] == 1){ ?>traded<?php } ?>"><?php echo $single_list['title']; ?><?php if($single_list['trade'] == 1){ ?><span class="traded-badge">Traded</span><?php } ?></p>
                              <p class="desc <?php if($single_list['trade'] == 1){ ?>traded<?php } ?>"><?php echo $single_list['desc']; ?></p>
                          </div>
                      </div>
                  <?php } ?>
              </div>
              <div class="single-trade">
                  <div class="item-trade-new">
                      <div class="n-trade-content">
                          <div class="n-trade-left">
                              <p class="n-trade-title"><b>You’ve successfully traded your upcoming collection for <?php echo $traded_new_product; ?></b></p>
                            <?php if(!empty($data_sub['time']['trade_cancel_until'])){ ?>
                              <p class="n-trade-desc">You have until <b><?php echo date('m/d', $data_sub['time']['trade_cancel_until']); ?></b> to modify or cancel this trade.</p>
                            <?php } ?>
                          </div>
                          <div class="n-trade-right">
                              <div class="n-trade-image">
                                  <img alt="New trade" class="trade-image" src="<?php echo $trade_new_image; ?>" />
                                  <img alt="Confirm trade" class="trade-confirm" src="<?php echo get_stylesheet_directory_uri().'/assets/img/icon-myaccount-trade-confirm.svg'; ?>">
                              </div>
                          </div>
                      </div>
                  </div>
                  <div class="time-release time-release2 <?php echo $club; ?>">
                      <p class="time-release-title2"><?php echo $time_release['time'] .' '. $time_release['type']; ?></p>
                      <p class="time-release-desc2"><?php echo "until we reveal <br>our next ".($key_club=='mm'?'Brushes':($key_club=='km'?'Lippies':'Shades')); ?></p>
                  </div>
              </div>
            </div>
          <?php } else { ?>
              <div class="item-content content-single">
                  <div class="trade-point-content">
                      <div class="trade-point-top no-bottom">
                          <div class="trade-point-icon">
                              <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/icon-sub-points.png" alt="Icon Point">
                          </div>
                          <p class="trade-point-title">You got 600 Reward<br>points richer!</p>
                          <p class="trade-point-desc text-center">You chose to trade our monthly collection <?php echo $monthpost_collection; ?> for more Reward points.</p>
                      </div>
                  </div>
                  <div class="time-release time-release3 <?php echo $club; ?>">
                      <p class="time-release-title3"><?php echo $time_release['time'] .' '. $time_release['type']; ?></p>
                      <p class="time-release-desc3"><?php echo "until we reveal <br>our next ".($key_club=='mm'?'Brushes':($key_club=='km'?'Lippies':'Shades')); ?></p>
                      <div class="time-release-break"></div>
                      <p class="time-release-notice">If you see our next collection and change your<br>mind, no worries, you'll have until <b><?php echo date('m/d', $data_sub['time']['trade_cancel_until']); ?></b> to<br>modify this action.</p>
                  </div>
              </div>
          <?php } ?>
      </div>
      <div class="lgdi-item-action">
        <?php if(!empty($data_sub['button']['show_trade'])){ ?>
          <a class="lgdi-action multi-action trade_action trade_<?php echo $club; ?>">
            <button class="btn btn-secondary btn-solid btn-block condensed">
              Trade Next Collection
            </button>
          </a>
        <?php } ?>
        <?php if(!empty($data_sub['button']['show_trade_cancel'])){ ?>
            <a class="lgdi-action multi-action trade_cancel_action trade_cancel_<?php echo $club; ?>">
                <button class="btn btn-secondary btn-solid btn-block condensed">
                    <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/icon-mc-trade-pink.png" alt="Icon Trade" />
                    Modify Trade
                </button>
            </a>
        <?php } ?>
        <a href="<?php echo $club_link_monthly; ?>" class="lgdi-action <?php echo (!empty($data_sub['button']['show_trade'])||!empty($data_sub['button']['show_trade_cancel']))?'multi-action':'single-action'; ?>">
          <button class="btn btn-primary btn-solid btn-block condensed">
            View Past Collections
          </button>
        </a>
      </div>
    </div>
  </div>
<?php } ?>
