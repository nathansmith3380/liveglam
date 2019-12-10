<?php
  /**
   * Form Upcoming CLub Active Mobile
   */

  if ( ! defined( 'ABSPATH' ) ) {
    exit;
  }

?>

<?php if($is_release_new_box){ //case next box is release?>
  <div class="liveglam-order-item liveglam-sub-active-release">
    <div class="order-item-content">
        <?php if(!$is_trade_points){ ?>
      <?php if(!empty($sub_active_next_shipment)){ ?>
        <div class="item-header">
          <p class="item-header-sub">Estimated Ship Date:
            <span class="float-right item-header-right">
              <?php if($data_sub['action']['change_date']){ ?>
                <a class="edit_schedule" data-edit="schedule" data-id="<?php echo $data_sub['subscription']['ID']; ?>" data-type="<?php echo $club; ?>"><?php echo date('F j, Y', $sub_active_next_shipment); ?>
                  <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/icon-edit-profile-pink.png" alt="Icon Edit"/>
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
          <p class="breakdown">
            <?php if($show_breakdown){ ?>
              <a class="show-breakdown" href="javascript:;">View Collection Breakdown<i class="fas fa-chevron-down"></i></a>
              <a class="hide-breakdown" href="javascript:;" style="display: none;">Hide Collection Breakdown<i class="fas fa-chevron-up"></i></a>
              <?php if($is_traded_set || $is_traded_single){ ?>
                <span class="customized-banner">Traded</span>
              <?php } ?>
            <?php } ?>
          </p>
        </div>
        <div class="single-list" <?php echo $show_breakdown?"style='display: none;'":""; ?>>
          <?php foreach($sub_active_single_list as $single_list){ ?>
            <div class="data-item">
              <div class="data-item-left">
                <img src="<?php echo $single_list['image']; ?>" alt="<?php echo $single_list['title']; ?>"/>
              </div>
              <div class="data-item-right">
                <p class="title <?php if($single_list['trade'] == 1){ ?>traded<?php } ?>"><?php echo $single_list['title'];
                    if($single_list['trade'] == 1){ ?><span class="traded-badge">Traded</span><?php } ?></p>
                <p class="desc <?php if($single_list['trade'] == 1){ ?>traded<?php } ?>"><?php echo $single_list['desc']; ?></p>
              </div>
            </div>
          <?php } ?>
        </div>
        <?php if($show_breakdown){ ?>
            <?php if( $is_traded_set && $status == 'active' ){ ?>
                <div class="single-trade">
                    <div class="item-trade-new">
                        <div class="n-trade-content">
                            <div class="n-trade-center">
                                <div class="n-trade-image image-center float-left">
                                    <img alt="Trade old" class="trade-image" src="<?php echo $trade_month_image; ?>" />
                                </div>
                                <div class="n-trade-image image-center float-right active">
                                    <img alt="Trade new" class="trade-image" src="<?php echo $trade_new_image; ?>" />
                                </div>
                                <img alt="Icon Trade" class="trade-confirm" src="<?php echo get_stylesheet_directory_uri().'/assets/img/icon-myaccount-trade-confirm.svg'; ?>">
                            </div>
                        </div>
                        <div class="n-trade-footer">
                            <p class="n-trade-title"><b>You’ve successfully traded your upcoming collection for <?php echo $traded_new_product; ?></b> You have until <b><?php echo date('m/d', $data_sub['time']['trade_cancel_until']); ?></b> to modify or cancel this trade.</p>
                        </div>
                        <div class="n-trade-action">
                            <a class="trade_cancel_action trade_cancel_<?php echo $club; ?>">
                                <button class="btn btn-upgrade btn-secondary btn-solid condensed btn-vw btn-sm">
                                    Modify Trade <?php echo (!empty($data_sub['time']['trade_cancel_until']))?'(until '.date('m/d', $data_sub['time']['trade_cancel_until']).')':''; ?>
                                </button>
                            </a>
                            <a class="n-trade-view-collection" href="<?php echo $club_link_monthly; ?>">View Current Collection ></a>
                        </div>
                    </div>
                </div>
            <?php } else { ?>
                <div class="single-video" style="background-image: url(<?php echo $monthPost['data_video']['video_block_image']; ?>);">
                    <div class="play-video">
                        <a href="<?php echo $monthPost['data_video']['video_url']; ?>">
                            <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/icon-myaccount-play.png" alt="Play">
                        </a>
                    </div>
                </div>
            <?php } ?>
        <?php } ?>
      </div>
        <?php } else { ?>
            <div class="item-content no-border">
                <div class="single-trade">
                    <div class="trade-point-top">
                        <div class="trade-point-icon">
                            <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/icon-sub-points.png" alt="Icon Point"/>
                        </div>
                        <p class="trade-point-title">You got 600 Reward<br>points richer!</p>
                        <p class="trade-point-desc text-center">You chose to trade our monthly collection <?php echo $monthpost_collection; ?> for more Reward points.</p>
                    </div>
                    <div class="trade-point-bot">
                        <div class="skip-content">
                            <div class="skip-content-left">
                                <p class="skip-content-title">Having FOMO?</p>
                                <p class="skip-content-desc"><span><?php echo $time_trade_cancel_left['time'].' '.strtoupper($time_trade_cancel_left['type']); ?> LEFT</span> to still get this collection. It's not too late to get there <?php echo ($key_club=='mm'?'brushes':($key_club=='km'?'lippies':'eyeshadow')); ?>! Click the button below <?php echo (!empty($data_sub['time']['trade_cancel_until']))?'until <b>'.date('m/d', $data_sub['time']['trade_cancel_until']).'</b>':''; ?> to snag them before they're gone.</p>
                            </div>
                            <div class="skip-content-right">
                                <img class="skip-image" src="<?php echo $trade_month_image; ?>" alt="Monthly box">
                            </div>
                        </div>
                        <div class="n-trade-action">
                            <a class="trade_cancel_action trade_cancel_<?php echo $club; ?>" href="#">
                                <button class="btn btn-upgrade btn-secondary btn-solid condensed btn-vw btn-sm">
                                    Modify Trade <?php echo (!empty($data_sub['time']['trade_cancel_until']))?'(until '.date('m/d', $data_sub['time']['trade_cancel_until']).')':''; ?>
                                </button>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        <?php } ?>
      <div class="item-footer footer-single">
        <?php if(!$is_traded_set && !$is_traded_single){ ?>
          <div class="trade-action">
            <?php if(!empty($data_sub['button']['show_trade'])){ ?>
              <div class="view-action view-trade">
                <a class="trade_action trade_<?php echo $club; ?>">
                  <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/icon-mc-trade-pink.png" alt="Icon Trade"/>
                  <p class="title">Trade</p>
                  <p class="desc">Available <?php echo (!empty($data_sub['time']['trade_until']))?'until '.date('m/d', $data_sub['time']['trade_until']):''; ?></p>
                </a>
              </div>
            <?php } ?>
            <div class="view-action view-collection">
              <a href="<?php echo $club_link_monthly; ?>">
                <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/icon-mc-view-pink.png" alt="Icon View"/>
                <p class="title">See Collection</p>
                <p class="desc">View full breakdown</p>
              </a>
            </div>
          </div>
        <?php } elseif ( $is_traded_single) { ?>
          <div class="trade-action">
            <?php if(!empty($data_sub['button']['show_trade_cancel'])){ ?>
                <div class="view-action view-trade">
                    <a class="trade_cancel_action trade_cancel_<?php echo $club; ?>">
                        <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/icon-mc-trade-pink.png" alt="Icon Trade"/>
                        <p class="title">Modify Trade</p>
                        <p class="desc">Available <?php echo (!empty($data_sub['time']['trade_cancel_until']))?'until '.date('m/d', $data_sub['time']['trade_cancel_until']):''; ?></p>
                    </a>
                </div>
            <?php } ?>
            <div class="view-action view-collection">
                <a href="<?php echo $club_link_monthly; ?>">
                    <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/icon-mc-view-pink.png" alt="Icon View"/>
                    <p class="title">See Collection</p>
                    <p class="desc">View full breakdown</p>
                </a>
            </div>
          </div>
        <?php } ?>
        <div class="subs-actions">
          <div class="lgs-data-info">
            <!--show plan subscription-->
            <?php if(!empty($data_sub['subscription']['type_display'])){ ?>
              <p class="lgdc-shipping-data">
                <span class="lgdc-shipping-details"><span class="lgdc-shipping-title">Plan: </span><?php echo $data_sub['subscription']['type_display']; ?> Sub</span>
                <?php if($data_sub['button']['show_upgrade']){ ?>
                  <a href="javascript:;" class="upgrade upgrade_<?php echo $club; ?>" data-type="<?php echo $club; ?>">
                    Upgrade >
                  </a>
                <?php } ?>
              </p>
            <?php } ?>
            <!--show next billing date-->
            <?php if(!empty($data_sub['time']['next_payment'])){ ?>
              <p class="lgdc-shipping-data">
                <span class="lgdc-shipping-details"><span class="lgdc-shipping-title">Next billing date: </span><?php echo date('F d, Y', $data_sub['time']['next_payment']); ?></span>
                <?php if(!empty($data_sub['action']['change_date'])){ ?>
                  <a class="edit_schedule" data-edit="schedule" data-id="<?php echo $data_sub['subscription']['ID']; ?>" data-type="<?php echo $club; ?>">
                    <img alt="Icon Edit" src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/icon-edit-profile-pink.png"/>
                  </a>
                <?php } ?>
              </p>
            <?php } ?>
            <!--show card info-->
            <?php if(!empty($data_sub['card']['card_last4'])){ ?>
              <p class="lgdc-shipping-data d-none">
                <span class="lgdc-shipping-details"><span class="lgdc-shipping-title">From card ending with: </span><?php echo $data_sub['card']['card_last4']; ?></span>
                <a class="edit_billing" data-edit="billing" data-id="<?php echo $data_sub['subscription']['ID']; ?>" data-type="<?php echo $club; ?>">
                  <img alt="Icon Edit" src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/icon-edit-profile-pink.png"/>
                </a>
              </p>
            <?php } ?>
            <!--show shipping info-->
            <p class="lgdc-shipping-data">
              <span class="lgdc-shipping-details" style="-webkit-box-orient: vertical;"><span class="lgdc-shipping-title">Shipping: </span><?php echo str_replace("<br/>", ", ", $data_sub['shipping']['shipping_address']); ?></span>
              <a class="edit_shipping" data-edit="shipping" data-id="<?php echo $data_sub['subscription']['ID']; ?>" data-type="<?php echo $club; ?>">
                <img alt="Icon Edit" src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/icon-edit-profile-pink.png"/>
              </a>
            </p>
          </div>
          <?php if(!empty($data_sub['action']['cancel']) || !empty($data_sub['action']['skip'])){ ?>
            <div class="lgs-data-info">
              <div class="lgdc-action">
                <?php if(!empty($data_sub['action']['cancel'])){ ?>
                  <a class="lgdc-action-content multi-action <?php echo $key_club; ?>_cancel_action">
                    <div class="lgdc-action-button">
                      <img alt="Icon Cancel" src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/icon-myaccount-cancel-mb.png"/>Cancel
                    </div>
                  </a>
                <?php } ?>
                <?php if(!empty($data_sub['action']['skip'])){ ?>
                  <a class="lgdc-action-content multi-action <?php echo $key_club; ?>_skip_action">
                    <div class="lgdc-action-button">
                      <img alt="Icon Skip" src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/icon-myaccount-skip-mb.png"/>Skip
                    </div>
                  </a>
                <?php } ?>
                <a href="javascript:;" class="lgdc-action-content multi-action edit_billing" data-edit="billing" data-id="<?php echo $data_sub['subscription']['ID']; ?>" data-type="<?php echo $club; ?>">
                  <div class="lgdc-action-button">
                    <img alt="Icon Edit" src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/icon-myaccount-billing-mb.png"/>Billing
                  </div>
                </a>
              </div>
            </div>
          <?php } ?>
        </div>
      </div>
    </div>
  </div>
<?php }else{ //case next box not release yet?>
  <div class="liveglam-order-item liveglam-sub-active-norelease">
    <div class="order-item-content">
        <?php if( !$is_traded_set) { ?>
      <div class="item-header item-header-new">
        <div class="time-release <?php echo $club; ?>">
          <div class="time-release-icon">
            <img src="<?php echo $sub_active_img_norelease; ?>" alt="Monthly box"/>
          </div>
            <p class="time-release-title"><?php echo $time_release['time']; ?></p>
            <p class="time-release-desc"><?php echo $time_release['type']. " until we reveal <br>our next ".($key_club=='mm'?'Brushes':($key_club=='km'?'Lippies':'Shades')); ?></p>
        </div>
      </div>
      <div class="item-content content-single">
        <p class="notice-release">We always release our monthly collection<br>on the 23rd. Stay tuned! In the meantime,<br><a href="<?php echo home_url('/shop'); ?>">shop other LiveGlam products here.
            <span>Shop<i class="fas fa-chevron-right"></i></span></a></p>
        <div class="not-release-border"></div>
        <div class="not-release-action">
          <?php if(!empty($data_sub['button']['show_trade'])){ ?>
            <a class="lgdi-action multi-action trade_action trade_<?php echo $club; ?>">
              <img alt="Trade new" src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/icon-mc-trade-pink.png"/>
                Trade Collection
            </a>
          <?php } ?>
          <a href="<?php echo $club_link_monthly; ?>" class="lgdi-action <?php echo !empty($data_sub['button']['show_trade'])?'multi-action':'single-action'; ?>">
            <img alt="Trade old" src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/view-past-collection-mobile.svg"/>
            Past Collections
          </a>
        </div>
      </div>
        <?php } elseif(!$is_trade_points) { ?>
            <?php if(!empty($sub_active_next_shipment)){ ?>
                <div class="item-header">
                    <p class="item-header-sub">Estimated Ship Date:
                        <span class="float-right item-header-right">
                            <?php if($data_sub['action']['change_date']){ ?>
                                <a class="edit_schedule" data-edit="schedule" data-id="<?php echo $data_sub['subscription']['ID']; ?>" data-type="<?php echo $club; ?>"><?php echo date('F j, Y', $sub_active_next_shipment); ?>
                                    <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/icon-edit-profile-pink.png" alt="Icon Edit"/>
                                </a>
                            <?php } ?>
                        </span>
                    </p>
                </div>
            <?php } ?>
            <div class="item-content content-single">
                <div class="single-header">
                    <p class="glamrock"><?php echo $traded_new_product; ?><span></span></p>
                    <p class="breakdown">
                        <a class="show-breakdown" href="javascript:;">View Collection Breakdown<i class="fas fa-chevron-down"></i></a>
                        <a class="hide-breakdown" style="display: none;" href="javascript:;">Hide Collection Breakdown<i class="fas fa-chevron-up"></i></a>
                        <span class="customized-banner">Traded</span>
                    </p>
                </div>
                <div class="single-list" style="display: none">
                    <?php foreach($sub_active_single_list as $single_list){ ?>
                        <div class="data-item">
                            <div class="data-item-left">
                                <img src="<?php echo $single_list['image']; ?>" alt="<?php echo $single_list['title']; ?>"/>
                            </div>
                            <div class="data-item-right">
                                <p class="title <?php if($single_list['trade'] == 1){ ?>traded<?php } ?>"><?php echo $single_list['title'];
                                    if($single_list['trade'] == 1){ ?><span class="traded-badge">Traded</span><?php } ?></p>
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
                                <p class="n-trade-desc">You have until <b><?php echo date('m/d', $data_sub['time']['trade_cancel_until']); ?></b> to modify or cancel this trade.</p>
                            </div>
                            <div class="n-trade-right">
                                <div class="n-trade-image single-image">
                                    <img alt="New trade" class="trade-image" src="<?php echo $trade_new_image; ?>" />
                                    <img alt="Confirm trade" class="trade-confirm" src="<?php echo get_stylesheet_directory_uri().'/assets/img/icon-myaccount-trade-confirm.svg'; ?>">
                                </div>
                            </div>
                        </div>
                        <div class="n-trade-action">
                            <a class="trade_cancel_action trade_cancel_<?php echo $club; ?>">
                                <button class="btn btn-upgrade btn-secondary btn-solid condensed btn-vw">
                                    Modify Trade <?php echo (!empty($data_sub['time']['trade_cancel_until']))?'(until '.date('m/d', $data_sub['time']['trade_cancel_until']).')':''; ?>
                                </button>
                            </a>
                        </div>
                    </div>
                    <div class="time-release time-release2 <?php echo $club; ?>">
                        <p class="time-release-title2"><?php echo $time_release['time'] .' '. $time_release['type']; ?></p>
                        <p class="time-release-desc2"><?php echo "until we reveal <br>our next ".($key_club=='mm'?'Brushes':($key_club=='km'?'Lippies':'Shades')); ?></p>
                    </div>
                </div>
            </div>
        <?php } else { ?>
            <div class="item-content no-border">
                <div class="trade-point-content">
                    <div class="trade-point-top">
                        <div class="trade-point-icon">
                            <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/icon-sub-points.png" alt="Icon Point"/>
                        </div>
                        <p class="trade-point-title">You got 600 Reward<br>points richer!</p>
                        <p class="trade-point-desc text-center">You chose to trade our monthly collection <?php echo $monthpost_collection; ?> for more Reward points.</p>
                    </div>
                    <div class="time-release time-release3 <?php echo $club; ?>">
                        <p class="time-release-title3"><?php echo $time_release['time'] .' '. $time_release['type']; ?></p>
                        <p class="time-release-desc3"><?php echo "until we reveal <br>our next ".($key_club=='mm'?'Brushes':($key_club=='km'?'Lippies':'Shades')); ?></p>
                        <div class="time-release-break"></div>
                        <p class="time-release-notice">If you see our next collection and change<br>your mind, no worries, you'll have until<br><b><?php echo date('m/d', $data_sub['time']['trade_cancel_until']); ?></b> to modify this action.</p>
                        <a class="trade_cancel_action trade_cancel_<?php echo $club; ?>">
                            <button class="btn btn-upgrade btn-secondary trade-point-action btn-solid condensed btn-vw btn-sm">
                                Modify Trade
                            </button>
                        </a>
                    </div>
                </div>
            </div>
        <?php } ?>
      <div class="item-footer footer-single">
        <div class="subs-actions">
          <div class="lgs-data-info">
            <!--show plan subscription-->
            <?php if(!empty($data_sub['subscription']['type_display'])){ ?>
              <p class="lgdc-shipping-data">
                <span class="lgdc-shipping-details"><span class="lgdc-shipping-title">Plan: </span><?php echo $data_sub['subscription']['type_display']; ?> Sub</span>
                <?php if($data_sub['button']['show_upgrade']){ ?>
                  <a href="javascript:;" class="upgrade upgrade_<?php echo $club; ?>" data-type="<?php echo $club; ?>">
                    Upgrade >
                  </a>
                <?php } ?>
              </p>
            <?php } ?>
            <!--show next billing date-->
            <?php if(!empty($data_sub['time']['next_payment'])){ ?>
              <p class="lgdc-shipping-data">
                <span class="lgdc-shipping-details"><span class="lgdc-shipping-title">Next billing date: </span><?php echo date('F d, Y', $data_sub['time']['next_payment']); ?></span>
                <?php if(!empty($data_sub['action']['change_date'])){ ?>
                  <a class="edit_schedule" data-edit="schedule" data-id="<?php echo $data_sub['subscription']['ID']; ?>" data-type="<?php echo $club; ?>">
                    <img alt="Icon Edit" src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/icon-edit-profile-pink.png"/>
                  </a>
                <?php } ?>
              </p>
            <?php } ?>
            <!--show card info-->
            <?php if(!empty($data_sub['card']['card_last4'])){ ?>
              <p class="lgdc-shipping-data d-none">
                <span class="lgdc-shipping-details"><span class="lgdc-shipping-title">From card ending with: </span><?php echo $data_sub['card']['card_last4']; ?></span>
                <a class="edit_billing" data-edit="billing" data-id="<?php echo $data_sub['subscription']['ID']; ?>" data-type="<?php echo $club; ?>">
                  <img alt="Icon Edit" src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/icon-edit-profile-pink.png"/>
                </a>
              </p>
            <?php } ?>
            <!--show shipping info-->
            <p class="lgdc-shipping-data">
              <span class="lgdc-shipping-details" style="-webkit-box-orient: vertical;"><span class="lgdc-shipping-title">Shipping: </span><?php echo str_replace("<br/>", ", ", $data_sub['shipping']['shipping_address']); ?></span>
              <a class="edit_shipping" data-edit="shipping" data-id="<?php echo $data_sub['subscription']['ID']; ?>" data-type="<?php echo $club; ?>">
                <img alt="Icon Edit" src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/icon-edit-profile-pink.png"/>
              </a>
            </p>
          </div>
          <?php if(!empty($data_sub['action']['cancel']) || !empty($data_sub['action']['skip'])){ ?>
            <div class="lgs-data-info">
              <div class="lgdc-action">
                <?php if(!empty($data_sub['action']['cancel'])){ ?>
                  <a class="lgdc-action-content multi-action <?php echo $key_club; ?>_cancel_action">
                    <div class="lgdc-action-button">
                      <img alt="Icon Edit" src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/icon-myaccount-cancel-mb.png"/>Cancel
                    </div>
                  </a>
                <?php } ?>
                <?php if(!empty($data_sub['action']['skip'])){ ?>
                  <a class="lgdc-action-content multi-action <?php echo $key_club; ?>_skip_action">
                    <div class="lgdc-action-button">
                      <img alt="Icon Edit" src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/icon-myaccount-skip-mb.png"/>Skip
                    </div>
                  </a>
                <?php } ?>
                <a href="javascript:;" class="lgdc-action-content multi-action edit_billing" data-edit="billing" data-id="<?php echo $data_sub['subscription']['ID']; ?>" data-type="<?php echo $club; ?>">
                  <div class="lgdc-action-button">
                    <img alt="Icon Edit" src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/icon-myaccount-billing-mb.png"/>Billing
                  </div>
                </a>
              </div>
            </div>
          <?php } ?>
        </div>
      </div>
    </div>
  </div>
<?php } ?>
