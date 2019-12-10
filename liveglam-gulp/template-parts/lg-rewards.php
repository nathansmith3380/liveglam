<?php
  /**
   * Template Name: Rewards page
   *
   * @package Liveglam
   */

  if(!defined('ABSPATH')){
    exit; // Exit if accessed directly
  }
  //redirect to home if user haven't logged in
  liveglam_check_user_login();

  global $LG_userData, $LG_userAvata;
  global $wpdb;

  $userLevel = Liveglam_User_Level::get_user_level();
  if($userLevel == 'diamond'){
    get_template_part('template-parts/lg-rewards-diamond', 'page');
  }elseif($userLevel == 'diamond trial'){
    get_template_part('template-parts/lg-rewards-diamond-trial', 'page');
  }elseif($userLevel == 'diamond elite'){
    get_template_part('template-parts/lg-rewards-diamond-elite', 'page');
  }else{
    get_header();
    $userID = get_current_user_id();
    $user = get_userdata($userID);
    $refurl = add_query_arg('ref', $user->user_login, site_url(PAGE_REFERRAL));
    $refurl = str_replace(' ', '%20', $refurl);
    LiveGlam_User_Level::init_user_level();
    switch($userLevel){
      case 'gold':
        $key_usl = 'g';
        break;
      default:
        $key_usl = 's';
    }
    $userCountry = $user->shipping_country?$user->shipping_country:$user->billing_country;
    $userPoint = RSPointExpiry::get_sum_of_total_earned_points($userID);
    $userPoint = floor($userPoint);
    $userMonthlyReferrals = IzCustomization::count_total_referral($userID, true);
    $userLifetimeReferrals = IzCustomization::count_total_referral($userID);

    $top3referrals = LGS_User_Referrals::lgur_get_top_3_user_referrals();
    $userRank = LGS_User_Referrals::lgur_get_current_rank_user($userID);

    $faqs_mm = $faqs_km = $faqs_sm = array();
    $current_page_ID = get_the_ID();
    if(!empty($total_faqs = get_post_meta($current_page_ID, 'faqs_rewards_page', true))){
      for($i = 0; $i < $total_faqs; $i++):
        $type_faqs = get_post_meta($current_page_ID, 'faqs_rewards_page_'.$i.'_type_faqs', true);
        $all_faqs = array();
        if(!empty($faqs = get_post_meta($current_page_ID, 'faqs_rewards_page_'.$i.'_faqs', true))){
          for($j = 0; $j < $faqs; $j++):
            $question = get_post_meta($current_page_ID, 'faqs_rewards_page_'.$i.'_faqs_'.$j.'_question', true);
            $answers = get_post_meta($current_page_ID, 'faqs_rewards_page_'.$i.'_faqs_'.$j.'_answers', true);
            if(!empty($question) && !empty($answers)){
              $all_faqs[] = array('question' => $question, 'answers' => $answers,);
            }
          endfor;
        }
        if($type_faqs == 'morpheme'){
          $faqs_mm = $all_faqs;
        }elseif($type_faqs == 'kissme'){
          $faqs_km = $all_faqs;
        }elseif($type_faqs == 'shadowme'){
          $faqs_sm = $all_faqs;
        }
      endfor;
    }

    $user_subscriptions = IzCustomization::get_user_subscription_sort_by_status($userID);
    $show_share = liveglam_get_last_subscription_active_for_user($user_subscriptions);
    if( $show_share == 'shadowme' || $show_share == 'shop') $show_share = 'morpheme';

    $total_activity = $wpdb->get_var("SELECT COUNT(id) FROM wp_rsrecordpoints WHERE userid = '{$userID}' AND earnedpoints != redeempoints AND showuserlog = false AND checkpoints NOT IN ( 'LGDCP', 'LGDCPU', 'LGDBP', 'LGDBPU', 'LGDAP', 'CBRP', 'RCBRP','LGDAPU', 'RRP' )");
    $total_number_of_redeem_product = IzCustomization::total_number_of_redeem_product();
    ?>

    <div class="wc-dashboard-content ">
      <div class="wc-dashboard-overlay">
    <div class="dashboard-content dashboard-rewards">
      <div id="scroller-anchor"></div>

      <?php echo do_shortcode('[show_notice_subscribers]'); ?>

      <section class="view-activity-new show-mobile">
        <div class="view-activity-new-content">
          <img class="show-mobile" alt="Reward Background" src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/new-bg-reward-mobile.jpg">
          <div class="view-activity-vertical">
            <span class="fas fa-star hide-mobile"></span>
            <p class="view-activity-title">You Have <span class="points"><?php echo $userPoint; ?></span> Points</p>
            <p class="view-activity-desc">Earn 100 points each active month. Earn <?php echo $userLevel=='gold'?250:200; ?> points each referral.</p>
            <?php if( $total_activity > 0 ){ ?>
              <div class="view-activity-action">
                <button class="btn btn-view-activity show-activity">View Activity</button>
              </div>
            <?php } ?>
          </div>
        </div>
      </section>

      <section class="redeem-items reward-redeem" id="redeem-items">
        <div class="view-activity-new hide-mobile">
          <div class="view-activity-new-content">
            <img class="hide-mobile" alt="Reward Background" src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/new-bg-reward.jpg">
            <div class="view-activity-vertical">
              <span class="fas fa-star hide-mobile"></span>
              <p class="view-activity-title">You Have <span class="points"><?php echo $userPoint; ?> Points</span></p>
              <p class="view-activity-desc">Earn 100 points each active month. Earn <?php echo $userLevel=='gold'?250:200; ?> points each referral.</p>
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
        <div class="wrap">
          <div class="redeem-items-content" id="redeem-items-content">
            <div class="overlay d-none">
              <div class="loading_spinner"><span class="fas fa-spinner fa-pulse fa-3x fa-fw"></span></div>
            </div>
            <div class="section-title show_filter hide-mobile">
              <div class="section-title-content">
                Redeem Your Rewards
                <p class="section-title-desc">We currently have <?php echo $total_number_of_redeem_product; ?> different Rewards available!  We usually add new Reward items weekly so make sure to check back.</p>
              </div>
              <div class="dropdown dropdown-filter">
                <label class="d-none" for="dropdown-select-sort-product">&nbsp;</label>
                <select class="dropdown-select selectpicker" id="dropdown-select-sort-product">
                  <option value="1">Newest to Oldest</option>
                  <option value="2">Oldest to Newest</option>
                  <option value="3">High to Low points</option>
                  <option value="4">Low to High points</option>
                  <option value="5">Brands A-Z</option>
                  <option value="6">Brands Z-A</option>
                </select>
              </div>
            </div>
            <div class="show_title show-mobile">
              <p class="redeem-title">Redeem Rewards</p>
              <p class="redeem-desc text-center">We currently have <span><?php echo $total_number_of_redeem_product; ?></span> different Rewards available!  We usually add new Reward items weekly so make sure to check back.</p>
            </div>
            <div class="show_item">
              <div class="pg-nav">
                <nav class="text-center" aria-label="Page navigation">
                  <ul class="pagination" id="pagination"></ul>
                </nav>
              </div>
            </div>
          </div>
        </div>
      </section>

      <section class="share-love" id="share-love">
        <div class="wrap">
          <div class="share-love-content">
            <div class="section-title">Free Goodies & Points</div>
            <div class="row no-gutters">
              <div class="col-md-6">
                <div class="block social-block">
                  <h3>Share the love! Get Free Products for You & Your Friends!</h3>
                  <p class="text-black">Invite your friends and they’ll get a free lippie or brush and you’ll score <?php echo $userLevel == 'gold'?250:200; ?> Points when they join.</p>
                  <hr class="d-md-none">
                  <p>Share through Social Media:</p>
                  <div class="social-share">
                    <?php echo do_shortcode('[social_share icon="fontawesome"]'); ?>
                  </div>
                </div>
              </div>
              <div class="col-md-6">
                <div class="block inputs-block">
                  <p>Share through Email:</p>
                  <form class="send-email input-wrapper" action="">
                    <div class="input-group inline-group section-send-email-invites">
                      <label class="d-none" for="share-through-email">&nbsp;</label>
                      <input id="share-through-email" class="input-email email_invites input-field" type="email" placeholder="Enter Your Friend’s emails (up to 10)">
                      <button class="btn-submit send_email_invites btn-action btn-primary condensed btn-vw" type="submit">Send</button>
                      <input type="hidden" value="morpheme" class="type-product"/>
                    </div>
                  </form>
                  <p>Your Personal Referral Link:</p>
                  <div class="copy-link input-wrapper">
                    <div class="input-group inline-group section-send-email-invites"><!--section-send-email-invites-->
                      <label class="d-none" for="copyTarget-desktop">&nbsp;</label>
                      <input id="copyTarget-desktop" class="copyTarget input-field" type="text" value="<?php echo $refurl; ?>" readonly/><!--input-link-->
                      <button id="copyButton-desktop" class="btn-link btn btn-copy-link copyButton btn-action btn-primary condensed btn-vw">Copy</button>
                    </div>
                  </div>
                </div>
              </div>
              <div id="send_email_invites_success" class="white-popup-block-1 mfp-hide"></div>
            </div>
          </div>
        </div>
      </section>

      <section class="share-love share-love2">
        <div class="wrap">
          <div class="share-love-content mb-bg">
            <div class="section-title border-bot">
              <div class="section-desc section-dec-share-love select-options">
                <div>Reward your Followers
                  <p class="section-title-desc">Got a following on Instagram? Click on one of the below images and save them to your device. Then share it to your profile to get rewards for you and your followers when they join! Don't forget to tell them to use your referral link found above.</p>
                </div>
                <div class="dropdown dropdown-filter">
                  <label class="d-none" for="share-love-options">&nbsp;</label>
                  <select id="share-love-options" class="share-love-options filter-select selectpicker share-select filter-options" data-dropup-auto="false">
                    <option value="morpheme" selected>MorpheMe</option>
                    <option value="kissme">KissMe</option>
                    <option value="shadowme">ShadowMe</option>
                  </select>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-12">
                <div class="block reward-followers">
                  <div class="block-share-container hide-mobile">
                    <div class="block-share-left">
                      <p class="block-share-title">How To Do It:</p>
                      <div class="block-share-lists">
                        <div class="block-share-item">
                          <div class="item-left">
                            <img alt="Icon Reward Save" src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/icon-reward-save.png">
                          </div>
                          <div class="item-right">
                            <p class="title">1. Save an image you’d like to share</p>
                          </div>
                        </div>
                        <div class="block-separator"></div>
                        <div class="block-share-item">
                          <div class="item-left">
                            <img alt="Icon Reward Copy" src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/icon-reward-copy.png">
                          </div>
                          <div class="item-right">
                            <p class="title">2. Copy the sample caption or use your own</p>
                          </div>
                          <div class="item-center">
                            <p class="desc caption-content"></p>
                            <div class="item-action">
                              <button class="copyButton-caption btn btn-primary btn-sm btn-copy-caption btn-share-instagram condensed btn-vw" type="submit">Copy</button>
                            </div>
                          </div>
                        </div>
                        <div class="block-separator"></div>
                        <div class="block-share-item">
                          <div class="item-left">
                            <img alt="Icon Reward Share" src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/icon-reward-share.png">
                          </div>
                          <div class="item-right">
                            <p class="title">3. Share on Instagram</p>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="block-share-right">
                      <p class="block-share-title">Select, Save and Share on Instagram:</p>
                      <div class="share-container show_share_morpheme d-none">
                        <div class="show-share-content"></div>
                        <div class="pg-nav show-share-pagination">
                          <nav aria-label="Page navigation">
                            <ul class="pagination" id="share-pagination-morpheme"></ul>
                          </nav>
                        </div>
                      </div>
                      <div class="share-container show_share_kissme d-none">
                        <div class="show-share-content"></div>
                        <div class="pg-nav show-share-pagination">
                          <nav aria-label="Page navigation">
                            <ul class="pagination" id="share-pagination-kissme"></ul>
                          </nav>
                        </div>
                      </div>
                      <div class="share-container show_share_shadowme d-none">
                        <div class="show-share-content"></div>
                        <div class="pg-nav show-share-pagination">
                          <nav aria-label="Page navigation">
                            <ul class="pagination" id="share-pagination-shadowme"></ul>
                          </nav>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="block-share show-mobile">
                    <div class="block-share-header">
                      <div class="inner inner-share">
                        <div class="row">
                          <div class="share-step col-md-3">
                            <p class="border-top"><span>1.</span>Save an image you'd like to share</p>
                          </div>
                          <div class="share-step col-md-4 offset-md-1">
                            <p class="border-top"><span>2.</span>Copy the sample caption or create your own</p>
                          </div>
                          <div class="share-step col-md-3 offset-md-1">
                            <p class="border-top border-bottom"><span>3.</span>Share to Instagram</p>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="block-share-content">
                      <div class="inner inner-share">
                        <p class="text-center txt-pink hide-mobile">Select, Save and Share on Instagram:</p>
                        <div class="share-container show_share_morpheme d-none">
                        </div>
                        <div class="share-container show_share_kissme d-none">
                        </div>
                        <div class="share-container show_share_shadowme d-none">
                        </div>
                      </div>
                    </div>
                    <div class="block-share-bottom">
                      <div class="row">
                        <div class="col-lg-7 offset-lg-1 col-md-8 text-right text-caption">
                          <p class="caption-content"></p>
                        </div>
                        <div class="col-md-4 text-left button-caption">
                          <?php $type = liveglam_check_ios_android();
                            if($type == 'ios'){
                              echo '<a href="instagram://user"><button class="btn btn-share-instagram btn-primary btn-sm btn-vw condensed">Share on Instagram</button></a>';
                            }elseif($type == 'android'){
                              echo '<a href="intent://instagram.com/_n/mainfeed/#Intent;package=com.instagram.android;scheme=https;end"><button class="btn btn-share-instagram btn-primary btn-sm btn-solid condensed">Share on Instagram</button></a>';
                            }else{
                              echo '<button class="copyButton-caption btn btn-copy-caption btn-primary condensed btn-share-instagram btn-vw" type="submit">Copy Caption</button>';
                            }
                          ?>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="share-caption">
                    <label class="d-none" for="copyTarget-caption">&nbsp;</label>
                    <input id="copyTarget-caption" type="text" value="">
                    <input type="hidden" class="text-caption morpheme" value="Addicted to makeup brushes? Join the club #MorpheMe! Get $30+ in Morphe makeup brushes sent to your door each for $19.99 by @LiveGlam.co. Plus get free shipping to US. Each month is a surprise and includes 3-8 powder, foundation, contour, eyeshadow and liner brushes. Cancel anytime, skip payments and trade months you don’t want for other goodies. It’s that simple! PLUS use my link to get a free brush upon checkout!"/>
                    <input type="hidden" class="text-caption kissme" value="Addicted to liquid lipstick? Join the club KissMe! Get 3 liquid lipsticks sent to your door each for $19.99 by @LiveGlam.co. Plus get free shipping to US. Each month is a surprise and includes 3 different liquid lipsticks. Cancel anytime and skip months you don’t want. It’s that simple! Use the link in my bio to get a free lipstick upon checkout!"/>
                    <input type="hidden" class="text-caption shadowme" value="Love eyeshadow palettes? Join the LiveGlam Eyeshadow Club, ShadowMe, and also get a FREE liquid lipstick when you join using my link!"/>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </section>

      <section class="brushtistics" id="brushtistics">
        <div class="wrap hide-mobile">
          <div class="section-title">
            <div class="section-title-content">Leader Board: <span class="date"><?php echo date('F Y'); ?></span></div>
            <div class="section-tier">Your Tier: <?php echo ucwords($userLevel); ?>
              <img alt="User Tier" src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/icon-reward-tier-<?php echo $userLevel; ?>.png" /></div>
          </div>
          <div class="status-new">
            <div class="status-list">
              <div class="status-item">
                <div class="status-item-title"><img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/icon-rewards-ref-monthly.png" alt="Icon Referrals" /><?php echo $userMonthlyReferrals; ?></div>
                <div class="status-item-desc">Monthly Referrals</div>
              </div>
              <div class="status-item">
                <div class="status-item-title"><img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/icon-rewards-ref-lifetime.png" alt="Icon Referrals" /><?php echo $userLifetimeReferrals; ?></div>
                <div class="status-item-desc">Lifetime Referrals</div>
              </div>
              <div class="status-item">
                <div class="status-item-title"><img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/icon-rewards-ref-rank.png" alt="Icon Rank" /><?php echo $userRank!=0?$userRank:'NA'; ?></div>
                <div class="status-item-desc">Your Rank</div>
              </div>
              <div class="status-item">
                <div class="status-item-title"><img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/icon-rewards-ref-points.png" alt="Icon Points" /><?php echo $userPoint; ?></div>
                <div class="status-item-desc">Your Points</div>
              </div>
            </div>
          </div>
        </div>
        <div class="wrap show-mobile">
          <div class="title-part">
            <p class="title">Leader Board</p>
            <p class="date"><?php echo date('F Y'); ?></p>
          </div>
        </div>
        <div class="status show-mobile">
          <div class="wrap">
          <div class="row">
            <div class="col-4">
              <div class="content">
                <div class="ref-img ref-monthly"></div>
                <p class="ref-number"><?php echo $userMonthlyReferrals; ?></p>
                <p class="ref-title">Monthly<br>Referrals</p>
              </div>
            </div>
            <div class="col-4">
              <div class="content">
                <div class="ref-img ref-lifetime"></div>
                <p class="ref-number"><?php echo $userLifetimeReferrals; ?></p>
                <p class="ref-title">Lifetime<br>Referrals</p>
              </div>
            </div>
            <div class="col-4">
              <div class="content">
                <div class="ref-img ref-points"></div>
                <p class="ref-number"><?php echo $userPoint; ?></p>
                <p class="ref-title">Your<br>Points</p>
              </div>
            </div>
          </div>
          </div>
        </div>
        <div class="wrap show-mobile">
          <div class="section-tier-mb">
            <p class="your-data your-rank">Your Rank: <span><?php echo $userRank!=0?$userRank:'NA'; ?></span></p>
            <p class="your-data your-tier">Your Tier: <span><?php echo ucwords($userLevel); ?></span></p>
          </div>
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

                if(!in_array($userLevel, array('diamond', 'diamond trial', 'diamond elite')) && (!in_array($level, array('diamond', 'diamond trial', 'diamond elite')) && $countTop > 10) || $rfl['user_id'] == $userID || current_user_can('administrator')){
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
                  $user_level_image = "<img alt='Icon Tier' src='".get_stylesheet_directory_uri()."/assets/img/icon-reward-tier-{$img_extend}.png' />";
                }

              ?>
                <tr class="<?php if($rfl['user_id'] == $userID) echo 'tr-your-rank'; ?>">
                  <td class="td-rank"><?php echo $countTop; ?></td>
                  <td class="td-name">
                    <span><img class="img-td-user" alt="<?php echo $userdata->display_name; ?>" src="<?php echo $user_avatar; ?>"></span><?php echo $userdata->display_name; ?>
                    <span class="member-tier show-mobile"><?php echo ucwords($level); ?></span>
                  </td>
                  <td class="td-referral"><?php echo !in_array($userLevel, array('diamond', 'diamond trial', 'diamond elite')) && (!in_array($level, array('diamond', 'diamond trial', 'diamond elite')) && $countTop > 10) || $rfl['user_id'] == $userID || current_user_can('administrator')?$rfl['total_referral']:'Hidden'; ?></td>
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
                        <div class="list-item-desc">Invitation Only. Get 500 friends to join one month.</div>
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
            <input type="hidden" name="user-tier-slider" value="<?php echo (in_array($userLevel,array('diamond','diamond trial')))?2:($userLevel=='gold'?1:0); ?>" />
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
          <div class="row faqs faqs_morpheme show_share_morpheme">
            <?php $faq_col1 = 1;
              $faq_col2 = 0;
              $faq_num_per_col = count($faqs_mm) / 2;
              for($faq_col1; $faq_col1 <= 2; $faq_col1++){ ?>
                <div class="col-md-6">
                  <div class="panel-group" id="dkaccordion-mm<?php echo $faq_col1; ?>">
                    <?php for($faq_col2; $faq_col2 < $faq_col1 * $faq_num_per_col; $faq_col2++){
                      $faq = $faqs_mm[$faq_col2]; ?>
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
          <div class="row faqs faqs_kissme show_share_kissme">
            <?php $faq_col1 = 1;
              $faq_col2 = 0;
              $faq_num_per_col = count($faqs_km) / 2;
              for($faq_col1; $faq_col1 <= 2; $faq_col1++){ ?>
                <div class="col-md-6">
                  <div class="panel-group" id="dkaccordion-km<?php echo $faq_col1; ?>">
                    <?php for($faq_col2; $faq_col2 < $faq_col1 * $faq_num_per_col; $faq_col2++){
                      $faq = $faqs_km[$faq_col2]; ?>
                      <div class="card">
                        <div class="card-header">
                          <h4 class="card-title">
                            <a class="accordion-toggle" data-toggle="collapse" data-parent="#dkaccordion-km<?php echo $faq_col1; ?>" href="#dkpanel-km<?php echo $faq_col2; ?>"><em class="fas fa-plus"></em><span><?php echo $faq['question']; ?></span></a>
                          </h4>
                        </div>
                        <div id="dkpanel-km<?php echo $faq_col2; ?>" class="panel-collapse collapse">
                          <div class="card-body"><?php echo $faq['answers']; ?></div>
                        </div>
                      </div>
                    <?php } ?>

                  </div>
                </div>
              <?php } ?>
          </div>
          <div class="row faqs faqs_shadowme show_share_shadowme">
            <?php $faq_col1 = 1;
              $faq_col2 = 0;
              $faq_num_per_col = count($faqs_sm) / 2;
              for($faq_col1; $faq_col1 <= 2; $faq_col1++){ ?>
                <div class="col-md-6">
                  <div class="panel-group" id="dkaccordion-sm<?php echo $faq_col1; ?>">
                    <?php for($faq_col2; $faq_col2 < $faq_col1 * $faq_num_per_col; $faq_col2++){
                      $faq = $faqs_sm[$faq_col2]; ?>
                      <div class="card">
                        <div class="card-header">
                          <h4 class="card-title">
                            <a class="accordion-toggle" data-toggle="collapse" data-parent="#dkaccordion-sm<?php echo $faq_col1; ?>" href="#dkpanel-sm<?php echo $faq_col2; ?>"><em class="fas fa-plus"></em><span><?php echo $faq['question']; ?></span></a>
                          </h4>
                        </div>
                        <div id="dkpanel-sm<?php echo $faq_col2; ?>" class="panel-collapse collapse">
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
          <div class="row faqs faqs_morpheme show_share_morpheme">
            <?php $faq_col1 = 1;
              $faq_col2 = 0;
              $faq_num_per_col = count($faqs_mm) / 2;
              for($faq_col1; $faq_col1 <= 2; $faq_col1++){ ?>
                <div class="col-md-6">
                  <div class="panel-group" id="accordion-mm<?php echo $faq_col1; ?>">
                    <?php for($faq_col2; $faq_col2 < $faq_col1 * $faq_num_per_col; $faq_col2++){
                      $faq = $faqs_mm[$faq_col2]; ?>
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
          <div class="row faqs faqs_kissme show_share_kissme">
            <?php $faq_col1 = 1;
              $faq_col2 = 0;
              $faq_num_per_col = count($faqs_km) / 2;
              for($faq_col1; $faq_col1 <= 2; $faq_col1++){ ?>
                <div class="col-md-6">
                  <div class="panel-group" id="accordion-km<?php echo $faq_col1; ?>">
                    <?php for($faq_col2; $faq_col2 < $faq_col1 * $faq_num_per_col; $faq_col2++){
                      $faq = $faqs_km[$faq_col2]; ?>
                      <div class="card">
                        <div class="card-header">
                          <h4 class="card-title">
                            <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion-km<?php echo $faq_col1; ?>" href="#panel-km<?php echo $faq_col2; ?>"><em class="fas fa-plus"></em><span><?php echo $faq['question']; ?></span></a>
                          </h4>
                        </div>
                        <div id="panel-km<?php echo $faq_col2; ?>" class="panel-collapse collapse">
                          <div class="card-body"><?php echo $faq['answers']; ?></div>
                        </div>
                      </div>
                    <?php } ?>

                  </div>
                </div>
              <?php } ?>
          </div>
          <div class="row faqs faqs_shadowme show_share_shadowme">
            <?php $faq_col1 = 1;
              $faq_col2 = 0;
              $faq_num_per_col = count($faqs_sm) / 2;
              for($faq_col1; $faq_col1 <= 2; $faq_col1++){ ?>
                <div class="col-md-6">
                  <div class="panel-group" id="accordion-sm<?php echo $faq_col1; ?>">
                    <?php for($faq_col2; $faq_col2 < $faq_col1 * $faq_num_per_col; $faq_col2++){
                      $faq = $faqs_sm[$faq_col2]; ?>
                      <div class="card">
                        <div class="card-header">
                          <h4 class="card-title">
                            <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion-sm<?php echo $faq_col1; ?>" href="#panel-sm<?php echo $faq_col2; ?>"><em class="fas fa-plus"></em><span><?php echo $faq['question']; ?></span></a>
                          </h4>
                        </div>
                        <div id="panel-sm<?php echo $faq_col2; ?>" class="panel-collapse collapse">
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
              <p>You Have <strong class="points"><?php echo $userPoint; ?></strong> Points.</p>
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
    <?php
    if($userLevel == 'gold'){
      $check_address = gold_member_check_address_international();
      if($check_address){
        $add_on_notice = "You have selected an Add-On Item.  Add-On Items ship with your next monthly package or within 31 days, whichever is first. Since you are a valued gold member, you can get discounted international shipping, which would you rather do?";
        $add_on_pay_text = "Pay <span id='shipping_price'></span> & ship now";
        $add_on_freeship_text = "I'll wait and get free shipping";

      }else{
        $add_on_notice = "You have selected an Add-On Item.  Add-On Items ship with your next monthly package or within 31 days, whichever is first. Since you are a valued gold member, you can get free immediate shipping, which would you rather do?";
        $add_on_pay_text = "Ship immediately";
        $add_on_freeship_text = "I don't mind waiting";

      }
    }else{
      $add_on_notice = "You have selected an Add-On Item. Add-On Items ship with your next monthly package or within 31 days, whichever is first. Would you rather like to pay for it to ship now ?";
      $add_on_pay_text = "Pay <span id='shipping_price'></span> & ship now";
      $add_on_freeship_text = "I'll wait and get free shipping";
    }
    ?>
    <div id="addon_shipping_option" class="white-popup-block-2 mfp-hide">
      <div class="woocommerce-success-header woocommerce-message-header">
        <img class="img-check" alt="Image Check" src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/popup-check-black.svg" />
        <h2>Yasss!</h2>
      </div>
      <div class="woocommerce-success-footer woocommerce-message-footer">
        <p><?php echo $add_on_notice; ?></p>
        <a href='' class='addon_pay_shipping'>
          <button class="get_away btn solid btn-primary condensed btn-static"><?php echo $add_on_pay_text; ?></button>
        </a>
        <a href='' class='addon_free_shipping'>
          <button class="btn btn-primary condensed btn-static"><?php echo $add_on_freeship_text; ?></button>
        </a>
      </div>
    </div>

    <input name="total-activity" type="hidden" value="<?php echo $total_activity; ?>"/>

    <?php echo lg_show_product_offer(); ?>

    <?php get_footer(); ?>

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
        membership_tier_slider.trigger('to.owl.carousel',jQuery('input[name="user-tier-slider"]').val());

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
            prevText: '<em class="fas fa-chevron-left"></em>',
            nextText: '<em class="fas fa-chevron-right"></em>',
            onInit: function () {
            },
            onPageClick: function (page, evt) {
              go_to_page(element_selected, page, numPerPage);
            }
          });
        }

        function go_to_page(element_selected, currentPage, numPerPage) {
          load_activity(element_selected, currentPage, numPerPage);
        }

        function load_activity(table_element, page, offer) {
          var data = {
            'action': 'lgs_ajax_load_activity_member',
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

        jQuery('.show_filter .dropdown-filter .dropdown-select').val(1);
        jQuery('body').on('change', '.show_filter .dropdown-filter .dropdown-select', function () {
          load_rewards();
          return false;
        });
        load_rewards();
        function load_rewards() {
          var data = {
            'action': 'get_product_rewards_by_sort',
            'order_by': jQuery('.show_filter .dropdown-filter .dropdown-select option:selected').val()
          };
          jQuery('section.redeem-items .overlay').removeClass('d-none');
          jQuery.post(ajaxurl, data, function (response) {
            jQuery('section.redeem-items .show_item .redeem-items-product').remove();
            jQuery('section.redeem-items .show_item').prepend(response);
            jQuery('section.redeem-items .overlay').addClass('d-none');
            var fb_IMG_select = 'a[href*=".jpg"]:not(.nofancybox,.pin-it-button), area[href*=".jpg"]:not(.nofancybox), a[href*=".jpeg"]:not(.nofancybox,.pin-it-button), area[href*=".jpeg"]:not(.nofancybox), a[href*=".png"]:not(.nofancybox,.pin-it-button), area[href*=".png"]:not(.nofancybox)';
            jQuery(fb_IMG_select).addClass('fancybox image');
            var fb_IMG_sections = jQuery('div.gallery');
            fb_IMG_sections.each(function () {
              jQuery(this).find(fb_IMG_select).attr('rel', 'gallery-' + fb_IMG_sections.index(this));
            });
            jQuery('a.fancybox, area.fancybox, li.fancybox a:not(li.nofancybox a)').fancybox(jQuery.extend({}, fb_opts, {
              'type': 'image',
              'transitionIn': 'none',
              'easingIn': 'linear',
              'transitionOut': 'none',
              'easingOut': 'linear',
              'opacity': false,
              'hideOnContentClick': false,
              'titleShow': true,
              'titlePosition': 'over',
              'titleFromAlt': true,
              'showNavArrows': true,
              'enableKeyboardNav': true,
              'cyclic': false
            }));
            /*jQuery("img.image-product-rewards").each(function () {
             if((typeof this.naturalWidth != "undefined" && this.naturalWidth == 0 ) || this.readyState == 'uninitialized' ) {
             jQuery(this).attr('src', liveglam_custome.get_stylesheet_directory_uri+'/assets/img/only-icon.png');
             }
             });*/
            var rewards_numPerPage = 12;
            var rewards_element = '.redeem-items-product .items-product',
              total_product_otweek = jQuery(rewards_element + '.product_otweek').length,
              rewards_totalItem = jQuery(rewards_element).length + total_product_otweek,
              rewards_numPages = Math.ceil(rewards_totalItem / rewards_numPerPage);
            set_pagination_rw('#pagination', rewards_element, rewards_numPages, rewards_numPerPage, total_product_otweek);
            go_to_page_rw(rewards_element, 1, rewards_numPerPage, total_product_otweek, false);
          }, 'json');
        }

        function set_pagination_rw(element, element_selected, numPages, numPerPage, total_product_otweek) {
          var obj = jQuery(element).pagination({
            items: numPages,
            itemOnPage: numPerPage,
            currentPage: 1,
            cssStyle: '',
            prevText: '<em class="fas fa-chevron-left"></em>',
            nextText: '<em class="fas fa-chevron-right"></em>',
            onInit: function () {
            },
            onPageClick: function (page, evt) {
              go_to_page_rw(element_selected, page, numPerPage, total_product_otweek, true);
            }
          });
        }

        function go_to_page_rw(e, currentPage, numPerPage, total_product_otweek, need_scroll) {
          if (total_product_otweek > 0) {
            if (currentPage == 1) {
              jQuery(e).hide().slice(0, currentPage * numPerPage - total_product_otweek).show();
            } else {
              jQuery(e).hide().slice((currentPage - 1) * numPerPage - total_product_otweek, currentPage * numPerPage - total_product_otweek).show();
            }
          } else {
            jQuery(e).hide().slice((currentPage - 1) * numPerPage, currentPage * numPerPage).show();
          }
          if(need_scroll == true){
            lgs_scroll_to_element(jQuery('#redeem-items-content'));
          }
        }

        jQuery('select.filter-select.share-select').val('<?php echo $show_share; ?>');
        change_share(jQuery('select.filter-select.share-select option:selected').val());
        load_image_for_share(jQuery('select.filter-select.share-select option:selected').val());
        jQuery('body').on('change', 'select.filter-select.share-select', function () {
          var type = jQuery(this).val();
          //var type = jQuery('select.filter-select.share-select option:selected').val();
          load_image_for_share(type);
          change_share(type);
          return false;
        });
        function load_image_for_share(type) {

          if (!jQuery('.share-container.show_share_' + type).hasClass('lg_img_loadded')) {
            var data = {
              'action': 'lg_get_reward_image_share',
              'type': type
            };
            jQuery('.share-container.show_share_' + type).addClass('lg_img_loadded');
            jQuery.post(ajaxurl, data, function (response) {
              jQuery('.block-share-container .share-container.show_share_' + type + ' .show-share-content').html(response.list_image);
              jQuery('.block-share-container .share-container.show_share_' + type + ' .carousel-share').removeClass('owl-carousel owl-theme');

              var total_item = jQuery('.show_share_'+type+' .carousel-share .item-share').length,
                item_per_page = 6,
                total_pages = table_numPages = Math.ceil( total_item / item_per_page);

              if( total_pages > 1 ) {
                set_pagination_share('#share-pagination-' + type, '.show_share_' + type + ' .carousel-share .item-share', total_pages, item_per_page);
                go_to_page_share('.show_share_' + type + ' .carousel-share .item-share', 1, item_per_page);
              }

              jQuery('.block-share-content .share-container.show_share_' + type).html(response.list_image);
              jQuery('.block-share-content .share-container.show_share_' + type + ' .carousel-share').owlCarousel({
                autoplay: false,
                autoplayTimeout: 5000,
                autoplayHoverPause: true,
                items: 2,
                loop: false,
                nav: true,
                        navText: ["<img alt='Previous' src='<?php echo get_stylesheet_directory_uri(); ?>/assets/img/left_arrow.png'>",
                            "<img alt='Next' src='<?php echo get_stylesheet_directory_uri(); ?>/assets/img/right_arrow.png'>"],
                dots: false
              });
            }, 'json');
          }
        }

        function set_pagination_share(element, element_selected, numPages, numPerPage) {
          var obj = jQuery(element).pagination({
            items: numPages,
            itemOnPage: numPerPage,
            currentPage: 1,
            cssStyle: '',
            prevText: '<em class="fas fa-chevron-left"></em>',
            nextText: '<em class="fas fa-chevron-right"></em>',
            onInit: function () {},
            onPageClick: function (page, evt) {
              go_to_page_share(element_selected, page, numPerPage);
            }
          });
        }

        function go_to_page_share(e, currentPage, numPerPage) {
          jQuery(e).hide().slice((currentPage - 1) * numPerPage, currentPage * numPerPage).show();
        }

        function change_share(type) {
          jQuery('.show_share_morpheme,.show_share_kissme,.show_share_shadowme').addClass('d-none');
          jQuery('.show_share_' + type).removeClass('d-none');
          var text_caption = jQuery('.text-caption.' + type).val();
          jQuery('input#copyTarget-caption').val(text_caption);
          jQuery('p.caption-content').text(text_caption);
          var s_text = 'lippie';
          if (type == 'morpheme') {
            s_text = 'brush'
          }
          jQuery('span.club').text(s_text);
        }

        jQuery('body').on('click', '.add_on_option', function () {
          var product_id = jQuery(this).data('product_id');
          var checkout_url = '<?php echo home_url('cart/?add-to-cart=');?>' + product_id + '&redeem_rewards=true';
          var price_stripe = jQuery(this).data('price_stripe');
          var price_reward = jQuery(this).data('price_reward');
          var shipping_text = '';
          if (price_stripe != '' && price_reward == '') shipping_text = price_stripe;
          if (price_stripe == '' && price_reward != '') shipping_text = price_reward;
          if (price_stripe != '' && price_reward != '') shipping_text = price_stripe + ' or ' + price_reward;
          jQuery('span#shipping_price').text(shipping_text);
          jQuery('.addon_pay_shipping').attr('href', checkout_url + '&ship_immediately=true');
          jQuery('.addon_free_shipping').attr('href', checkout_url + '&free_shipping=true');
          jQuery.magnificPopup.open({items: {src: '#addon_shipping_option'}, type: 'inline'});
          return false;
        });
      });
    </script>
    </div>
    </div>
  <?php }