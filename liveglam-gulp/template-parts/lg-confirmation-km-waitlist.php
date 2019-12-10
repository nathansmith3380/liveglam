<?php
/**
 * Template Name: Confirmation KissMe Join Waitlist
 *
 * @package Liveglam
 */

  get_header();
  $earnPoint = (Liveglam_User_Level::get_user_level()=='gold')?250:200;

$order_id = $_GET['order_id'];
if(false === ($order = wc_get_order($order_id))){
    wp_redirect(home_url('/my-account/'));
    exit;
}
  foreach ($order->get_items() as $item ){
    if( in_array($item['product_id'], lgs_product_mm) ) $productID = $item['product_id'];
  }
  $total = 0;
  $subscriptions = wcs_get_subscriptions_for_order( $order->get_id(), array( 'order_type' => array( 'parent', 'renewal' ) ) );
  foreach ($subscriptions as $subscription){
    $subscription = wcs_get_subscription($subscription);
    $total = $subscription->get_total();
  }
?>

<script>
    var total = "<?php echo $total; ?>";
    window._conv_q = window._conv_q || [];
    _conv_q.push(["pushRevenue",total,1,"100126755"]);
</script>

<div class="waitlist-confirmation">
    <div class="subscribe-confirmation detail-confirmation step1">
        <img class="mb-image show-mobile" src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/sub_confirm_KM_mobile.jpg"/>
        <div class="col-lg-12">
            <div class="row">
                <div class="col-lg-6 confirmation-left-section text-center cfkm-waitlist">
                    <h1>
                        <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/wave.png">
                        <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/hearteyes.png">
                        <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/party.png">
                    </h1>
                    <h1 class="nd19-section-title">YOU'RE #<?php echo do_shortcode('[lg_user_position_in_waitlist product=kissme]');?> IN LINE!</h1>
                    <p class="nd19-block-content">On Your Way to a Whole New World of Beauty</p>
                    <div class="product-image d-desktop">
                        <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/sub_confirm_KM@2x.jpg"/>
                    </div>
                </div>
                <div class="col-lg-6 confirmation-right-section">
                    <p class="txt-pink thanks nd19-section-title">
                        The best things are worth the wait &nbsp; &nbsp;
                        <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/icon-stars.png">
                        <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/blush.png">
                        <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/icon-bingo.png">
                    </p>
                    <p class="nd19-block-content">Your monthly dose of KissMe Lippies + more!</p>
                    <ul class="confirmation-details">
                        <li>
                            <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/thumb-lipstick.jpg">
                            <div class="content">
                                <p class="header nd19-block-content-s">WAITLIST STATUS</p>
                                <p class="title nd19-block-title-s">You’re on the Waitlist- Now What?</p>
                                <p class="description nd19-block-content-s">Don’t sweat it, we’re working as hard as we can to get you off the waitlist! Once we have a spot for you, we’ll send you an email letting you know which lippies you’ll be getting, as well as your next billing date. You’ll also get a tracking number as soon as your beautiful lippies ship!</p>
                            </div>
                        </li>
                        <li>
                            <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/cfkm-thumb-1.jpg">
                            <div class="content">
                                <p class="header txt-light-blue nd19-block-content-s">YOUR ACCOUNT</p>
                                <p class="title nd19-block-title-s">No Worries, We Haven’t Charged You Yet!</p>
                                <p class="description nd19-block-content-s">While we're making up some space for you, your card won't be charged until you're in the club (if you used a debit card you may see an authorization but don't worry it's not a charge)!</p>
                            </div>
                        </li>
                    </ul>
                    <div class="actions">
                        <div class="action active show-detail-confirmation text-left d-none d-sm-block" data-step="0" data-link="">
                        </div>
                        <div class="action show-share-confirmation text-right" data-step="2">
                            <div>
                                <p class="action-title nd19-block-content-s">Your lipsticks come with benefits <span class="right">02</span></p>
                                <p class="action-content txt-pink nd19-block-content">
                                    Loads of perks <i class="fas fa-arrow-right" aria-hidden="true"></i>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="subscribe-confirmation detail-confirmation step2" style="display: none">
        <img class="mb-image show-mobile" src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/sub_confirm_KM_mobile.jpg"/>
        <div class="col-lg-12">
           <div class="row">
                <div class="col-lg-6 confirmation-left-section cfkm-waitlist">
                    <h1 class="nd19-section-title">
                        MORE THAN JUST LIPPIES.
                        <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/wave.png">
                        <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/hearteyes.png">
                        <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/party.png">
                    </h1>
                    <!--<p>Let your friends know of your awesome discovery,<br>  Give them lipstick, too, while your at it.</p>-->
                    <div class="product-image d-desktop">
                        <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/sub_confirm_KM@2x.jpg">
                    </div>
                </div>
                <div class="col-lg-6 confirmation-right-section">
                    <p class="txt-pink thanks nd19-section-title">
                        Loads of Perks
                        <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/pray.png">
                        <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/blush.png">
                        <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/sparkle.png">
                    </p>
                    <p class="nd19-block-title">Did you know your lippies come loaded with benefits?</p>
                    <ul class="confirmation-details">
                        <!--<li>
                            <img src="<?php /*echo get_stylesheet_directory_uri(); */?>/assets/img/cfkm-thumb-1-girl.jpg">
                            <div class="content">
                                <p class="header">Monthly Tutorials</p>
                                <p class="title">Become a Lipstick Master.</p>
                                <p class="description">Each month we feature monthly how-to videos highlighting how to use your new lipstick. Check out your Members-only <a href="<?php /*echo home_url('/monthly_lipstick'); */?>">KissMe</a> page for lipstick details and tutorials.</p>
                            </div>
                        </li>-->
                        <li>
                            <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/cfmm-thumb-1-barely.png">
                            <div class="content">
                                <p class="header nd19-block-content-s">More Than Just Lipstick</p>
                                <p class="title nd19-block-title-s">You Will Earn 100 Reward Points!</p>
                                <p class="description nd19-block-content-s">When you become an active KissMe member you will earn 100 reward points each month! Plus you get <?php echo $earnPoint; ?> bonus points for each friend you refer to our squad. Check out our <a href="<?php echo home_url('rewards');?>">Rewards</a> page for some great prizes you can redeem.</p>
                            </div>
                        </li>
                        <li>
                            <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/cfkm-thumb-1-trade.jpg">
                            <div class="content">
                                <p class="header txt-light-blue nd19-block-content-s">The Power is in Your Hands</p>
                                <p class="title nd19-block-title-s">Trade, Skip or Cancel- It's That Simple.</p>
                                <p class="description nd19-block-content-s">Not feelin’ your next set of lippies? Trade one or all of them for something else! Strapped for cash one month? Skip a payment! Currently experiencing lippie overload? Cancel your membership! We like to keep things like our dating life, as non-committal as possible. Check out your <a href="<?php echo home_url('/my-account'); ?>">Dashboard</a> to see all your options!</p>
                            </div>
                        </li>
                    </ul>
                    <div class="actions">
                        <div class="action active show-detail-confirmation" data-step="1">
                            <div>
                                <p class="action-title nd19-block-content-s"><span class="left">01</span> View Your Subscription Detail</p>
                                <p class="action-content txt-pink nd19-block-content"><i class="fas fa-arrow-left" aria-hidden="true"></i> Subscription & Shipping
                                </p>
                            </div>
                        </div>
                        <div class="action show-share-confirmation text-right" data-step="3">
                            <div>
                                <p class="action-title nd19-block-content-s">Get a Free Lipstick for You and Your Friends <span class="right">03</span></p>
                                <p class="action-content txt-pink nd19-block-content">
                                    Rewards & Freebies <i class="fas fa-arrow-right" aria-hidden="true"></i>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="subscribe-confirmation share-confirmation step3" style="display: none">
        <img class="mb-image show-mobile" src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/sub_confirm_KM_mobile.jpg"/>
        <div class="col-lg-12">
            <div class="row">
                <div class="col-lg-6 confirmation-left-section no-bottom-padding-mobile cfkm-waitlist">
                    <h1 class="nd19-section-title">
                        Spread the love.
                        <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/wave.png">
                        <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/hearteyes.png">
                        <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/party.png">
                    </h1>
                    <p class="nd19-block-content">Let your friends know about KissMe <br> and both of you can score some free lippies!</p>
                    <div class="product-image d-desktop">
                        <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/sub_confirm_KM@2x.jpg">
                    </div>
                </div>
                <div class="col-lg-6 confirmation-right-section">
                    <p class="txt-pink thanks nd19-section-title">
                        Rewards & Freebies&nbsp; &nbsp;
                        <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/party.png">
                        <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/blush.png">
                        <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/sparkle.png">
                    </p>
                    <p class="nd19-block-content">You're about to make your friends and your makeup kit very happy!</p>
                    <ul class="confirmation-details">
                        <li>
                            <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/thumb-lipstick.jpg">
                            <div class="content">
                                <p class="header nd19-block-content-s">LOTS OF REWARDS</p>
                                <p class="title nd19-block-title-s"><?php echo IzCustomization::total_number_of_redeem_product();?> Rewards Available!</p>
                                <p class="description nd19-block-content-s">Our <a href="<?php echo home_url('rewards');?>">Rewards</a> program is stocked with glam goodies galore! We add new products on a weekly basis! Check out all your options on the <a href="<?php echo home_url('rewards');?>">Rewards</a> page.</p>                        </li>
                        <li>
                            <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/cfkm-thumb-free.png">
                            <div class="content">
                                <p class="header txt-light-blue nd19-block-content-s">FREE LIPPIES</p>
                                <p class="title nd19-block-title-s">Get Free Lipstick for You & Your Friends!</p>
                                <p class="description nd19-block-content-s">When your friends sign up using your referral link, they get to choose a free KissMe lippie when they join and you get <?php echo $earnPoint; ?> points too! Use your points to redeem a free lippie or other awesome swag. Share using the buttons below:</p>
                            </div>
                        </li>
                    </ul>
                    <div class="social-share">
                        <?php echo do_shortcode('[social_share product="kissme"]');?>
                        <?php echo do_shortcode('[send_email_invites product="kissme" show_script=true]');?>
                    </div>
                    <div class="actions">
                        <div class="action show-detail-confirmation" data-step="2">
                            <div>
                                <p class="action-title nd19-block-content-s"><span class="left">02</span> Your lipsticks come with benefits</p>
                                <p class="action-content txt-pink nd19-block-content">
                                    <span class="confirmation-narrow left"><i class="fas fa-arrow-right" aria-hidden="true"></i> Loads of perks
                                </p>
                            </div>
                        </div>
                        <div class="action show-share-confirmation text-right" data-step="0">
                            <a href="<?php echo home_url('/rewards'); ?>">
                                <div>
                                    <p class="action-title nd19-block-content-s">Continue to</p>
                                    <p class="action-content txt-pink nd19-block-content">
                                        Rewards page <i class="fas fa-arrow-right" aria-hidden="true"></i>
                                    </p>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php get_footer(); ?>