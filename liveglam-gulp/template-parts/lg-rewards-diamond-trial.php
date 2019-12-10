<?php
  /**
   * Template Name: Rewards page Diamond Trial
   *
   * @package Liveglam
   */


  get_header();

  global $LG_userData, $LG_userAvata;
  global $wpdb;
  if(!is_user_logged_in())
    wp_redirect(home_url());
  $userID = get_current_user_id();
  $user = get_userdata($userID);
  $userPoint = floor(RSPointExpiry::get_sum_of_total_earned_points($userID));
  $user_enable_cash = (get_user_meta($userID,'enable_cash_out',true) === '0')?false:true;

  $top3referrals = LGS_User_Referrals::lgur_get_top_3_user_referrals();
  $userRank = LGS_User_Referrals::lgur_get_current_rank_user($userID);
  $userLevel = Liveglam_User_Level::get_user_level($userID);

  $userMonthlyReferrals = IzCustomization::count_total_referral($userID, true);
  $userLifetimeReferrals = IzCustomization::count_total_referral($userID);
  $balance = wc_price(Liveglam_User_Level::convert_point($userPoint));

  $time_diamond_upgrade = LGS_User_Referrals::lgs_get_time_upgrade_to_diamond($userID);

  $total_activity = $wpdb->get_var("SELECT COUNT(id) FROM wp_rsrecordpoints WHERE userid = '{$userID}' AND showuserlog = false AND earneddate >= '{$time_diamond_upgrade}' AND checkpoints IN ( 'LGDCP', 'LGDCPU', 'LGDBP', 'LGDBPU', 'LGDAP', 'CBRP', 'RCBRP','LGDAPU', 'CAACL', 'RCBRP', 'MAP', 'KMP' )");//'PPRRP'

  $all_faqs = array();
  $current_page_ID = get_the_ID();
  if(!empty($total_faqs = get_post_meta($current_page_ID, 'faqs_rewards_page', true))){
    for($i = 0; $i < $total_faqs; $i++):
      if('liveglam' == get_post_meta($current_page_ID, 'faqs_rewards_page_'.$i.'_type_faqs', true)){
        if(!empty($faqs = get_post_meta($current_page_ID, 'faqs_rewards_page_'.$i.'_faqs', true))){
          for($j = 0; $j < $faqs; $j++):
            $question = get_post_meta($current_page_ID, 'faqs_rewards_page_'.$i.'_faqs_'.$j.'_question', true);
            $answers = get_post_meta($current_page_ID, 'faqs_rewards_page_'.$i.'_faqs_'.$j.'_answers', true);
            if(!empty($question) && !empty($answers)){
              $all_faqs[] = array('question' => $question, 'answers' => $answers,);
            }
          endfor;
        }
      }
    endfor;
  }

?>

<div class="wc-dashboard-content ">
  <div class="wc-dashboard-overlay">
<div class="dashboard-content dashboard-rewards dashboard-rewards-diamond">
  <div id="scroller-anchor"></div>

  <?php echo do_shortcode('[show_notice_subscribers]'); ?>

  <section class="message_text">
    <div class="wrap">
      <p class="notice_title"> Hey
        <span class="user_diamond"><?php echo $user->first_name; ?></span>! You will earn $5 - $7 for every friend that signs up to any of our clubs using your affiliate referral code!
      </p>
    </div>
  </section>

  <section class="view-activity-new show-mobile">
    <div class="view-activity-new-content">
      <img class="show-mobile" alt="Reward Background" src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/new-bg-reward-mobile.jpg">
      <div class="view-activity-vertical">
        <span class="fas fa-star hide-mobile"></span>
        <p class="view-activity-title">You Have <span class="points"><?php echo $balance; ?></span></p>
        <?php if( $total_activity > 0 ){ ?>
          <div class="view-activity-action">
            <button class="btn btn-view-activity show-activity">View Activity</button>
          </div>
        <?php } ?>
      </div>
    </div>
  </section>

  <section class="redeem-items reward-redeem hide-mobile" id="redeem-items">
    <div class="view-activity-new">
      <div class="view-activity-new-content">
        <img class="hide-mobile" alt="Reward Background" src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/new-bg-reward.jpg">
        <div class="view-activity-vertical">
          <span class="fas fa-star hide-mobile"></span>
          <p class="view-activity-title">You Have <span class="points"><?php echo $balance; ?></span></p>
          <?php if( $total_activity > 0 ){ ?>
            <div class="view-activity-action">
              <button class="btn btn-view-activity show-activity-dk">View Activity</button>
              <button class="btn btn-view-activity hide-activity-dk d-none">Hide Activity</button>
              <div class="activity-content-new">
                <div class="activity-content-bg">
                  <div class="activity-list"></div>
                  <?php if( $total_activity > 5 ){ ?>
                    <div class="pg-nav">
                      <nav class="text-center" aria-label="Page navigation">
                        <ul class="pagination" id="pagination-table"></ul>
                      </nav>
                    </div>
                  <?php } ?>
                </div>
              </div>
            </div>
          <?php } ?>
        </div>
      </div>
    </div>
  </section>


  <section class="brushtistics" id="brushtistics">
    <div class="wrap hide-mobile">
      <div class="section-title">
        <div class="section-title-content">Leader Board: <span class="date"><?php echo date('F Y'); ?></span></div>
        <div class="section-tier">Your Tier: Diamond
          <img alt="Diamond" src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/icon-reward-tier-diamond.png" /></div>
      </div>
    </div>
    <div class="wrap show-mobile">
      <div class="title-part">
        <p class="title">Leader Board</p>
        <p class="date"><?php echo date('F Y'); ?></p>
      </div>
    </div>

    <div class="wrap">
      <div class="status">
          <ul>
            <li>
              <div class="content monthly_referrral">
                <h4><?php echo $userMonthlyReferrals; ?></h4>
                <p>Monthly Referrals</p>
                <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/icon-moon.svg" alt="Icon Moon">
              </div>
            </li>
            <?php
              global $wpdb;
              $userWaitlistedReferrals = $wpdb->get_var("SELECT count(ID) FROM wp_posts
                                                  LEFT JOIN wp_postmeta ON ID=post_id
                                                  WHERE meta_key ='increase_points_referrer'
                                                  AND meta_value ='{$user->user_login}'
                                                  AND post_type = 'shop_subscription'
                                                  AND post_status = 'wc-waitlist'");
              if($userWaitlistedReferrals):
                ?>
                <li>
                  <div class="content monthly_referrral">
                    <h4><?php echo $userWaitlistedReferrals; ?></h4>
                    <p>Waitlisted Referrals</p>
                  </div>
                </li>
              <?php endif; ?>
            <li>
              <div class="content lifetime_referral">
                <h4><?php echo $userLifetimeReferrals; ?></h4>
                <p>Lifetime Referrals</p>
                <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/icon-sun.svg" alt="Icon Sun">
              </div>
            </li>
            <li>
              <div class="content your_rank">
                <h4><?php if($userRank != 0)
                    echo $userRank;else echo "NA"; ?></h4>
                <p>Your Rank</p>
                <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/icon-cup.svg" alt="Icon Cup">
              </div>
            </li>
            <li>
              <div class="content your_balance">
                <h4><?php echo $balance; ?></h4>
                <p>Your Balance</p>
                <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/icon-cash.svg" alt="Icon Cash">
              </div>
            </li>
            <li>
              <div class="content lifetime_earnings">
                <h4><?php echo wc_price(Liveglam_User_Level::convert_point(IzCustomization::get_lifetime_earned_points($userID))); ?></h4>
                <p>Lifetime Earnings</p>
                <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/icon-cash.svg" alt="Icon Cash">
              </div>
            </li>
            <li>
              <div class="content monthly_earnings">
                <h4><?php echo wc_price(Liveglam_User_Level::convert_point(IzCustomization::get_monthly_referral_points($userID))); ?></h4>
                <p>Monthly Earnings</p>
                <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/icon-cash.svg" alt="Icon Cash">
              </div>
            </li>
            <li>
              <div class="content your_status">
                <h4>Diamond</h4>
                <p>Status</p>
                <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/icon-circle.svg" alt="Icon Circle">
              </div>
            </li>
            <li>
              <div class="content your_affiliate_code">
                <h4><?php echo $user->user_login; ?></h4>
                <p>Your affiliate code</p>
              </div>
            </li>
          </ul>
      </div>
      <?php
        $products = IzCustomization::get_commission_report(get_current_user_id());
        $products_salesfrom_shop = IzCustomization::get_commission_from_shop_report(get_current_user_id());
        if (!empty($products)):
          $total_productsales = count($products);
          ?>
          <div class="commission">
              <p class="commission_title">
                <?php
                  if($total_productsales>1){
                    ?>
                    <a data-toggle="collapse" href="#CommissionProduct" role="button" aria-expanded="false">
                      Non-subscription Sales <span class="fas fa-chevron-down"></span>
                    </a>
                    <?php
                  }else{
                    ?>Non-subscription Sales<?php
                  }
                ?>
              </p>
              <div id="CommissionProduct" class="<?php echo $total_productsales>1?'collapse':'';?>">
                <?php foreach ($products as $key_product_id=>$product):?>
                  <div class="status">
                    <p class="txt-pink"><?php echo $product['title'];?></p>
                    <ul>
                      <li>
                        <div class="content monthly_referrral">
                          <h4><?php echo $product['member'];?></h4>
                          <p>Member sales<br/>Commission Rate: $<?php echo $product['member_commission'];?></p>
                        </div>
                      </li>
                      <li>
                        <div class="content your_affiliate_code">
                          <h4><?php echo $product['nonmember'];?></h4>
                          <p>Non Member sales<br/>Commission Rate: $<?php echo $product['non_member_commission'];?></p>
                        </div>
                      </li>
                      <li>
                        <div class="content monthly_earnings">
                          <h4>$ <?php echo number_format($product['total'], 2);?></h4>
                          <p>Total commission for Non-subscription sales<?php if (get_post_meta($key_product_id,'add_point_and_log',true) == 'yes') echo ' (included in "Your Balance")'; else echo "<p>&nbsp;</p>";?></p>
                        </div>
                      </li>
                    </ul>
                  </div>
                <?php endforeach;?>
              </div>
          </div>
        <?php endif;?>
      <?php if (!empty($products_salesfrom_shop)):
        ?>
        <div class="commission">
            <p class="commission_title">Commission from shop referral</p>
            <div class="status">
              <ul>
                <li>
                  <div class="content">
                    <h4><?php echo $products_salesfrom_shop['member'];?></h4>
                    <p>Member sales</p>
                  </div>
                </li>
                <li>
                  <div class="content">
                    <h4><?php echo $products_salesfrom_shop['nonmember'];?></h4>
                    <p>Non Member sales</p>
                  </div>
                </li>
                <li>
                  <div class="content monthly_earnings">
                    <h4>$ <?php echo number_format($products_salesfrom_shop['totalsale'], 2);?></h4>
                    <p>Total commission from shop referral</p>
                  </div>
                </li>
              </ul>
            </div>
        </div>
      <?php endif;?>
      <?php if($user_enable_cash !== false){
        $rs_minimum_points_for_encash = get_option('rs_minimum_points_encashing_request') != ''?get_option('rs_minimum_points_encashing_request'):0; ?>
        <div class="request_cashout">
          <p class="request_title">Request Cashout</p>
          <p class="request_info">Your available balance is
            <span class="txt-pink"><?php echo $balance; ?></span><?php echo ($rs_minimum_points_for_encash == 0 || empty($rs_minimum_points_for_encash))?".":", you can request for a cashout if you have minimum ".wc_price(Liveglam_User_Level::convert_point($rs_minimum_points_for_encash))." available balance."; ?>
          </p>
          <a href="#" id="btn_cashout" class="btn-pink btn <?php echo ($userPoint >= $rs_minimum_points_for_encash && !empty($userPoint))?'':'disabled'; ?>">Cash Out</a>

        </div>
      <?php } ?>
    </div>

    <div class="wrap">
      <?php if(count($top3referrals) > 0): $countTop = 1; ?>
        <table class="table rank-table table-leaderboard">
          <thead>
          <tr>
            <th class="th-rank">#</th>
            <th class="th-name">Name</th>
            <th class="th-referral">Referrals</th>
            <th class="th-waitlist-referral">Waitlisted</th>
            <th class="th-member hide-mobile">Member Tier</th>
          </tr>
          </thead>
          <tbody>
          <?php foreach($top3referrals as $rfl): $level = Liveglam_User_Level::get_user_level($rfl['user_id']); $level = $level=='diamond trial'?'diamond':$level;
            $user_avatar = lg_get_avatar_for_user($rfl['user_id'], 64);
            $userdata = get_userdata($rfl['user_id']);

            if(!in_array($level, array('diamond', 'diamond trial', 'diamond elite')) && $countTop > 10 || $rfl['user_id'] == $userID || current_user_can('administrator')){
              $userWaitlistedReferrals = $wpdb->get_var("SELECT count(ID) FROM wp_posts
                                                LEFT JOIN wp_postmeta ON ID=post_id
                                                WHERE meta_key ='increase_points_referrer'
                                                AND meta_value ='{$userdata->user_login}'
                                                AND post_type = 'shop_subscription'
                                                AND post_status = 'wc-waitlist'");
            } else {
              $userWaitlistedReferrals = 'Hidden';
            }

            $user_level_image = '';

            if( in_array( $level, array( 'silver', 'gold', 'diamond', 'diamond trial', 'diamond elite' ) ) ){
              $img_extend = ($level == 'diamond trial')?'diamond':(($level == 'diamond elite')?'diamond-elite':$level);
              $user_level_image = "<img alt='User Tier' src='".get_stylesheet_directory_uri()."/assets/img/icon-reward-tier-{$img_extend}.png' />";
            }

            ?>
            <tr class="<?php if($rfl['user_id'] == $userID) echo 'tr-your-rank'; ?>">
              <td class="td-rank"><?php echo $countTop; ?></td>
              <td class="td-name">
                <span><img class="img-td-user" alt="<?php echo $userdata->display_name; ?>" src="<?php echo $user_avatar; ?>"></span><?php echo $userdata->display_name; ?>
                <span class="member-tier show-mobile"><?php echo ucwords($level); ?></span>
              </td>
              <td class="td-referral"><?php echo !in_array($level, array('diamond', 'diamond trial', 'diamond elite')) && $countTop > 10 || $rfl['user_id'] == $userID || current_user_can('administrator')?$rfl['total_referral']:'Hidden'; ?></td>
              <td class="td-waitlist-referral"><?php echo $userWaitlistedReferrals; ?></td>
              <td class="td-member hide-mobile"><?php echo $user_level_image; ?></td>
            </tr>
          <?php $countTop++; endforeach; ?>
          </tbody>
        </table>
        <div class="top-referrers hide-mobile">Top 3 gold members get 200 bonus points and top 3 diamond get a $200 cash bonus each month!</div>
        <?php if(count($top3referrals) > 10) { ?>
          <div class="newdesign-pagination pg-nav leaderboard-nav">
            <nav class="text-center" aria-label="Page navigation">
              <ul class="pagination" id="pagination-leaderboard"></ul>
            </nav>
          </div>
        <?php } ?>
      <?php endif; ?>
      <div class="top-referrers show-mobile">Top 3 gold members get 200 bonus points and top 3 diamond get a $200 cash bonus each month!</div>
    </div>
  </section>

  <?php $member_ships = array(
    'Receive 100 points each active month' => array('s' => 1, 'g' => 1, 'd' => 0, 'de' => 0),
    'Get bonus points on your birthday' => array('s' => 1, 'g' => 1, 'd' => 0, 'de' => 0),
    'Earn 25% bonus points per referral' => array('s' => 0, 'g' => 1, 'd' => 0, 'de' => 0),
    'Free or discounted shipping on all rewards' => array('s' => 0, 'g' => 1, 'd' => 0, 'de' => 0),
    'Collect cash as prizes' => array('s' => 0, 'g' => 1, 'd' => 1, 'de' => 1),
    'Get dedicated success manager' => array('s' => 0, 'g' => 0, 'd' => 1, 'de' => 1),
    'Free products to all clubs every month' => array('s' => 0, 'g' => 0, 'd' => 1, 'de' => 1),
    'Earn cash for each referral' => array('s' => 0, 'g' => 0, 'd' => 1, 'de' => 1),
    'Early access to upcoming collections' => array('s' => 0, 'g' => 0, 'd' => 1, 'de' => 1),
    'Access to special bonuses and gifts' => array('s' => 0, 'g' => 0, 'd' => 1, 'de' => 1),
    'Instagram giveaways' => array('s' => 0, 'g' => 0, 'd' => 0, 'de' => 1),
    'Curate your own LiveGlam favorites collections' => array('s' => 0, 'g' => 0, 'd' => 0, 'de' => 1),
    'LiveGlam product collaborations' => array('s' => 0, 'g' => 0, 'd' => 0, 'de' => 1),
    'Meet and greets and in-person events' => array('s' => 0, 'g' => 0, 'd' => 0, 'de' => 1),
  ); ?>
  <section class="memberships-tiers" id="memberships-tiers">
    <div class="wrap">
      <div class="hide-mobile">
        <div class="section-title">Membership Tiers</div>
        <div class="memberships-top">
          <div class="memberships-list-tiers">
            <div class="list-item">
              <div class="list-item-title silver">
                <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/icon-reward-tier-silver.png" alt="Silver" />Silver
              </div>
              <div class="list-item-desc">Join a club</div>
            </div>
            <div class="list-item">
              <div class="list-item-title gold">
                <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/icon-reward-tier-gold.png" alt="Gold" />Gold
              </div>
              <div class="list-item-desc">Get 3 friends to join in one month.</div>
            </div>
            <div class="list-item">
              <div class="list-item-title diamond">
                <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/icon-reward-tier-diamond.png" alt="Diamond" />Diamond
              </div>
              <div class="list-item-desc">Get 50 friends to join in one month.</div>
            </div>
            <div class="list-item">
              <div class="list-item-title diamond-elite">
                <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/icon-reward-tier-diamond-elite.png" alt="Diamond Elite" />Diamond Elite
              </div>
              <div class="list-item-desc">Invitation Only. Get 500 friends to join in one month.</div>
            </div>
          </div>
        </div>
        <div class="memberships-bot">
          <div class="memberships-perk-header">
            <div class="perks-list">
              <div class="perks-item perks1">Perks</div>
              <div class="perks-item perks2">Silver</div>
              <div class="perks-item perks2">Gold</div>
              <div class="perks-item perks3">Diamond</div>
              <div class="perks-item perks3">Diamond Elite</div>
            </div>
          </div>
          <div class="memberships-perk-content">
            <?php foreach($member_ships as $member_ship => $data){ ?>
              <div class="perks-list">
                <div class="perks-item perks1"><?php echo $member_ship; ?></div>
                <div class="perks-item perks2"><?php if($data['s'] == '1'){ ?><img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/icon-reward-tier-silver.png" alt="Silver" /><?php }else{ ?><span class="nothing"></span><?php } ?></div>
                <div class="perks-item perks2"><?php if($data['g'] == '1'){ ?><img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/icon-reward-tier-gold.png" alt="Gold" /><?php }else{ ?><span class="nothing"></span><?php } ?></div>
                <div class="perks-item perks3"><?php if($data['d'] == '1'){ ?><img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/icon-reward-tier-diamond.png" alt="Diamond" /><?php }else{ ?><span class="nothing"></span><?php } ?></div>
                <div class="perks-item perks3"><?php if($data['de'] == '1'){ ?><img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/icon-reward-tier-diamond-elite.png" alt="Diamond Elite" /><?php }else{ ?><span class="nothing"></span><?php } ?></div>
              </div>
            <?php } ?>
          </div>
        </div>
      </div>
      <div class="show-mobile">
        <p class="memberships-title">Membership Tiers</p>
        <div class="memberships">
          <div class="memberships-tier owl-carousel owl-theme">
            <div class="memberships-tier-list">
              <div class="memberships-top">
                <div class="memberships-list-tiers">
                  <div class="list-item">
                    <div class="list-item-title silver">
                      <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/icon-reward-tier-silver.png" alt="Silver" />Silver
                    </div>
                    <div class="list-item-desc">Join a club</div>
                  </div>
                </div>
              </div>
              <div class="memberships-bot">
                <div class="memberships-perk-content">
                  <?php foreach($member_ships as $member_ship => $data){ ?>
                    <div class="perks-list">
                      <div class="perks-item perks1"><?php echo $member_ship; ?></div>
                      <div class="perks-item perks2"><?php if($data['s'] == '1'){ ?><img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/icon-reward-tier-silver.png" alt="Silver" /><?php }else{ ?><span class="nothing"></span><?php } ?></div>
                    </div>
                  <?php } ?>
                </div>
              </div>
            </div>
            <div class="memberships-tier-list">
              <div class="memberships-top">
                <div class="memberships-list-tiers">
                  <div class="list-item">
                    <div class="list-item-title gold">
                      <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/icon-reward-tier-gold.png" alt="Gold" />Gold
                    </div>
                    <div class="list-item-desc">Get 3 friends to join in one month.</div>
                  </div>
                </div>
              </div>
              <div class="memberships-bot">
                <div class="memberships-perk-content">
                  <?php foreach($member_ships as $member_ship => $data){ ?>
                    <div class="perks-list">
                      <div class="perks-item perks1"><?php echo $member_ship; ?></div>
                      <div class="perks-item perks2"><?php if($data['g'] == '1'){ ?><img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/icon-reward-tier-gold.png" alt="Gold" /><?php }else{ ?><span class="nothing"></span><?php } ?></div>
                    </div>
                  <?php } ?>
                </div>
              </div>
            </div>
            <div class="memberships-tier-list">
              <div class="memberships-top">
                <div class="memberships-list-tiers">
                  <div class="list-item">
                    <div class="list-item-title diamond">
                      <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/icon-reward-tier-diamond.png" alt="Diamond" />Diamond
                    </div>
                    <div class="list-item-desc">Get 50 friends to join in one month.</div>
                  </div>
                </div>
              </div>
              <div class="memberships-bot">
                <div class="memberships-perk-content">
                  <?php foreach($member_ships as $member_ship => $data){ ?>
                    <div class="perks-list">
                      <div class="perks-item perks1"><?php echo $member_ship; ?></div>
                      <div class="perks-item perks2"><?php if($data['d'] == '1'){ ?><img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/icon-reward-tier-diamond.png" alt="Diamond" /><?php }else{ ?><span class="nothing"></span><?php } ?></div>
                    </div>
                  <?php } ?>
                </div>
              </div>
            </div>
            <div class="memberships-tier-list">
              <div class="memberships-top">
                <div class="memberships-list-tiers">
                  <div class="list-item">
                    <div class="list-item-title diamond-elite">
                      <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/icon-reward-tier-diamond-elite.png" alt="Diamond Elite" />Diamond Elite
                    </div>
                    <div class="list-item-desc">Invitation Only. Get 500 friends to join in one month.</div>
                  </div>
                </div>
              </div>
              <div class="memberships-bot">
                <div class="memberships-perk-content">
                  <?php foreach($member_ships as $member_ship => $data){ ?>
                    <div class="perks-list">
                      <div class="perks-item perks1"><?php echo $member_ship; ?></div>
                      <div class="perks-item perks2"><?php if($data['de'] == '1'){ ?><img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/icon-reward-tier-diamond-elite.png" alt="Diamond Elite" /><?php }else{ ?><span class="nothing"></span><?php } ?></div>
                    </div>
                  <?php } ?>
                </div>
              </div>
            </div>
          </div>
          <a href="#share-love" class="btn-primary btn-invite scroll-element">Invite More Friends</a>
        </div>
      </div>
    </div>
  </section>

  <section class="questions-new hide-mobile">
    <div class="wrap">
      <div class="questions-new-content">
        <div class="section-title border-bot">
          <div class="section-title-content">
            Frequently Asked Questions
            <p class="section-title-desc">Still have any doubts? See our complete FAQ <a href="<?php echo home_url('/faq'); ?>">here</a></p>
          </div>
          <div class="section-contact">
            <a href="<?php echo home_url('/contact-us');?>">
              <button class="btn btn-secondary btn-vw">Contact Support</button>
            </a>
          </div>
        </div>
        <div class="row faqs">
          <?php $faq_col1 = 1;
            $faq_col2 = 0;
            $faq_num_per_col = count($all_faqs) / 2;
            for($faq_col1; $faq_col1 <= 2; $faq_col1++){ ?>
              <div class="col-md-6">
                <div class="panel-group" id="dkaccordion-mm<?php echo $faq_col1; ?>">
                  <?php for($faq_col2; $faq_col2 < $faq_col1 * $faq_num_per_col; $faq_col2++){
                    $faq = $all_faqs[$faq_col2]; ?>
                    <div class="card">
                      <div class="card-header">
                        <h4 class="card-title">
                          <a class="accordion-toggle" data-toggle="collapse" data-parent="#dkaccordion-mm<?php echo $faq_col1; ?>" href="#dkpanel-mm<?php echo $faq_col2; ?>"><em class="fas fa-plus"></em><span><?php echo $faq['question']; ?></span></a>
                        </h4>
                      </div>
                      <div id="dkpanel-mm<?php echo $faq_col2; ?>" class="panel-collapse collapse">
                        <div class="card-body"><?php echo $faq['answers']; ?></div>
                      </div>
                    </div>
                  <?php } ?>
                </div>
              </div>
            <?php } ?>
        </div>
      </div>
    </div>
  </section>

  <section class="questions show-mobile">
    <div class="wrap">
      <p class="question-title">Frequently Asked Questions</p>
      <p class="question-desc">Still have any doubts? See our complete FAQ <a href="<?php echo home_url('/faq'); ?>">here</a></p>
      <div class="row faqs">
        <?php $faq_col1 = 1;
          $faq_col2 = 0;
          $faq_num_per_col = count($all_faqs) / 2;
          for($faq_col1; $faq_col1 <= 2; $faq_col1++){ ?>
            <div class="col-md-6">
              <div class="panel-group" id="accordion-mm<?php echo $faq_col1; ?>">
                <?php for($faq_col2; $faq_col2 < $faq_col1 * $faq_num_per_col; $faq_col2++){
                  $faq = $all_faqs[$faq_col2]; ?>
                  <div class="card">
                    <div class="card-header">
                      <h4 class="card-title">
                        <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion-mm<?php echo $faq_col1; ?>" href="#panel-mm<?php echo $faq_col2; ?>"><em class="fas fa-plus"></em><span><?php echo $faq['question']; ?></span></a>
                      </h4>
                    </div>
                    <div id="panel-mm<?php echo $faq_col2; ?>" class="panel-collapse collapse">
                      <div class="card-body"><?php echo $faq['answers']; ?></div>
                    </div>
                  </div>
                <?php } ?>
              </div>
            </div>
          <?php } ?>
      </div>
    </div>
  </section>

  <?php show_dashboard_footer('footer-dashboard'); ?>
</div>

<div class="dashboard-content dashboard-setting dashboard-activity" style="display: none">
  <div class="dashboard-header-new show-mobile">
    <div class="wrap dashboard-header-profile">
      <div class="title-header-content">
        <div class="title-header-left">
          <a href="#" class="close-setting">Close</a>
        </div>
        <div class="title-header-center">
          <p>View Activity</p>
        </div>
      </div>
    </div>
  </div>
  <div class="dashboard-container">
    <div class="liveglam-setting liveglam-setting-new">
      <section class="setting">
        <div class="setting-account-title show-mobile">
          <p>You Have <strong class="points"><?php echo $balance; ?></strong></p>
        </div>
        <div class="activity-details">
          <div class="wrap">
            <div class="activity-list"></div>
            <?php if( $total_activity > 5 ){ ?>
              <div class="pg-nav">
                <nav aria-label="Page navigation">
                  <ul class="pagination" id="pagination-table1"></ul>
                </nav>
              </div>
            <?php } ?>
          </div>
        </div>
      </section>
    </div>
  </div>
</div>

<div id="cashout" class="white-popup-block mfp-hide" style="background: #fff none repeat scroll 0 0;margin: 20px auto;max-width: 50%;padding: 50px;position: relative;width: auto;">
  <p class="price_text">
    <?php echo '<span class="available_balance_cashout"> Your available balance: '.$balance.'</span>'; ?>
  </p>
  <?php echo do_shortcode('[rsencashform]'); ?>
</div>

<input name="total-activity" type="hidden" value="<?php echo $total_activity; ?>"/>

<script type="text/javascript">
  jQuery(document).ready(function () {
    var membership_tier_slider = jQuery('.memberships-tier.owl-carousel');
    membership_tier_slider.owlCarousel({
      autoplay: false,
      items: 1,
      loop: false,
      nav: false,
      dots: true,
      margin: 20,
    });
    membership_tier_slider.trigger('to.owl.carousel',2);


    jQuery('body').on('click', '.dashboard-setting .close-setting', function () {
      jQuery('.dashboard-rewards').fadeIn(1000);
      jQuery('.dashboard-activity').fadeOut(1000);
      change_zindex(0);
      return false;
    });

    jQuery('body').on('click', '.show-activity', function () {
      jQuery('.dashboard-activity').fadeIn(1000);
      jQuery('.dashboard-rewards').fadeOut(1000);
      change_zindex(1000);
      return false;
    });

    jQuery('body').on('click', '.show-activity-dk', function () {
      show_hide_activity('show');
      return false;
    });

    jQuery('body').on('click', '.hide-activity-dk', function () {
      show_hide_activity('hide');
    });

    function show_hide_activity(type) {
      if( type == 'show' ){
        jQuery('.show-activity-dk').addClass('d-none');
        jQuery('.hide-activity-dk').removeClass('d-none');
        jQuery('.wc-dashboard-overlay').addClass('show');
        jQuery('.view-activity-new-content').addClass('show');
      } else {
        jQuery('.show-activity-dk').removeClass('d-none');
        jQuery('.hide-activity-dk').addClass('d-none');
        jQuery('.wc-dashboard-overlay').removeClass('show');
        jQuery('.view-activity-new-content').removeClass('show');
      }
    }

    jQuery('body').on("click", '.lgs_body_page', function(event){
      var $box = jQuery(".activity-content-new");
      if ($box.has(event.target).length == 0 && !$box.is(event.target) ){
        show_hide_activity('hide');
      }
    });

    function change_zindex(num) {
      jQuery('.wc-dashboard-content').css('z-index', num);
    }

    var table_element = '.activity-logs .table tbody, .activity-details .activity-list',
      table_numPerPage = 5,
      table_totalItem = jQuery('input[name="total-activity"]').val(),
      table_numPages = Math.ceil(table_totalItem / table_numPerPage);
    set_pagination('#pagination-table', table_element, table_numPages, table_numPerPage);
    set_pagination('#pagination-table1', table_element, table_numPages, table_numPerPage);
    go_to_page(table_element, 1, table_numPerPage);

    function set_pagination(element, element_selected, numPages, numPerPage) {
      var obj = jQuery(element).pagination({
        items: numPages,
        itemOnPage: numPerPage,
        currentPage: 1,
        cssStyle: '',
        prevText: '<span class="fas fa-chevron-left"></span>',
        nextText: '<span class="fas fa-chevron-right"></span>',
        onInit: function () {
        },
        onPageClick: function (page, evt) {
          go_to_page(element_selected, page, numPerPage);
        }
      });
    }

    function go_to_page(table_element, currentPage, numPerPage) {
      load_activity(table_element, currentPage, numPerPage);
    }

    function load_activity(table_element, page, offer) {
      var data = {
        'action': 'lgs_ajax_load_activity_diamond',
        'page': page,
        'offer': offer
      };
      jQuery.post(ajaxurl, data, function (response) {
        if (response.status == 'success') {
          jQuery('.activity-content-new .activity-list').html(response.return);
          jQuery('.activity-details .activity-list').html(response.return);
        }
      }, 'json');
    }

    jQuery("#dc_sc_change_billing form a").removeAttr("href");
    jQuery('body').on('click', '#btn_cashout', function () {
      jQuery.magnificPopup.open({
        items: {src: '#cashout'}, type: 'inline', callbacks: {
          open: function () {
            jQuery(document.body).trigger('country_to_state_changed');
          }
        }
      });
      return false;
    });

    jQuery('body').on('change', 'select#rs_encash_payment_method', function () {
      jQuery(document.body).trigger('country_to_state_changed');
    });
  });
</script>

<?php get_footer(); ?>

  </div>
</div>