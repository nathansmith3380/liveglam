<?php
/**
 * Template Name: Confirmation ShadowMe Join Waitlist
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
    if( in_array($item['product_id'], lgs_product_sm) ) $productID = $item['product_id'];
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
        <img class="mb-image show-mobile" src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/sub_confirm_SM_mobile.jpg"/>
        <div class="col-lg-12">
            <div class="row">
                <div class="col-lg-6 confirmation-left-section text-center cfsm-waitlist">
                    <h1>
                        <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/moji-1.png">
                        <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/moji-2.png">
                        <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/moji-3.png">
                    </h1>
                    <h1 class="nd19-section-title">YOU'RE IN LINE!</h1>
                    <p class="nd19-block-content">On Your Way to a Whole New World of Beauty</p>
                    <div class="product-image d-desktop">
                        <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/sub_confirm_SM@2x.jpg">
                    </div>
                </div>
                <div class="col-lg-6 confirmation-right-section">
                    <p class="txt-pink thanks nd19-section-title">
                        The best blends are worth the wait! &nbsp; &nbsp;
                        <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/icon-stars.png">
                        <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/blush.png">
                        <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/icon-bingo.png">
                    </p>
                    <p class="nd19-block-content">We’re brushing open a spot now to get you off this waitlist ASAP!</p>
                    <ul class="confirmation-details">
                        <li>
                            <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/thumb-eyeshadow.jpg">
                            <div class="content">
                                <p class="header smcf-right-header2 nd19-block-content-s">Status</p>
                                <p class="title smcf-none-bold nd19-block-title-s">You Now Are on the Waitlist!</p>
                                <p class="description nd19-block-content-s">We’re blending a spot open for you right now- you’re currently #<?php echo do_shortcode('[lg_user_position_in_waitlist product=shadowme]');?> in line! To find out more info about the (oh-so-fun) Waitlist just how long the line is click <a href="--><?php //echo home_url('/my-account/');?><!--">here</a>! Your card will be charged when your palette is ready to ship. Once you’re in the club, your eyeshadows will ship within 5-7 business days!</p>
                            </div>
                        </li>
                        <li>
                            <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/thumb-eyeshadow1.jpg">
                            <div class="content">
                                <p class="header txt-light-blue smcf-right-header3 nd19-block-content-s">DASHBOARD - Your Account</p>
                                <p class="title smcf-none-bold nd19-block-title-s">Don’t worry- we haven’t charged your card yet!</p>
                                <p class="description nd19-block-content-s">While we’re perfecting your palettes, your account will remain inactive and your card won’t be charged til we get ya in the club! (although you may see a temporary authorization if you used a debit card.) Your future palettes will be charged on this day every other month! You can change billing, shipping, and personal details on your <a href="<?php echo home_url('my-account');?>">Dashboard</a>.</p>
                            </div>
                        </li>
                    </ul>
                    <div class="actions">
                        <div class="action active show-detail-confirmation text-left d-none d-sm-block" data-step="0" data-link="">
                        </div>
                        <div class="action show-share-confirmation text-right" data-step="2">
                            <div>
                                <p class="action-title nd19-block-content-s">Your palette comes packed with benefits <span class="right">02</span></p>
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
        <img class="mb-image show-mobile" src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/sub_confirm_SM_mobile.jpg"/>
        <div class="col-lg-12">
            <div class="row">
                <div class="col-lg-6 confirmation-left-section cfsm-waitlist">
                    <h1 class="nd19-section-title">
                        MORE THAN JUST PALETTES
                        <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/wave.png">
                        <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/hearteyes.png">
                        <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/party.png">
                    </h1>
                    <p class="nd19-block-content">Your palette is packed with benefits.</p>
                    <div class="product-image d-desktop">
                        <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/sub_confirm_SM@2x.jpg">
                    </div>
                </div>
                <div class="col-lg-6 confirmation-right-section">
                    <p class="txt-pink thanks nd19-section-title">
                        Loads of Perks
                        <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/pray.png">
                        <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/blush.png">
                        <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/sparkle.png">
                    </p>
                    <p class="nd19-block-content">Did you know your palette is much more than just shadow?</p>
                    <ul class="confirmation-details">
                        <li>
                            <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/thumb-eyeshadow2.jpg">
                            <div class="content">
                                <p class="header smcf-right-header2 nd19-block-content-s">Monthly Tutorials</p>
                                <p class="title smcf-none-bold nd19-block-title-s">Become a Palette Master.</p>
                                <p class="description nd19-block-content-s">Each palette we feature how-to videos highlighting how to use your new shadow. Check out your Members-only <a href="<?php echo home_url('/'.PAGE_SHADOWME_MONTHLY); ?>">ShadowMe</a> page for palette details and tutorials.</p>
                            </div>
                        </li>
                        <li>
                            <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/thumb-eyeshadow3.png">
                            <div class="content">
                                <p class="header smcf-right-header3 nd19-block-content-s">MORE THAN JUST PALETTES</p>
                                <p class="title smcf-none-bold nd19-block-title-s">You Will Earn 100 Reward Points!</p>
                                <p class="description nd19-block-content-s">You get 100 points with each palette! Plus you get 200 bonus points for each friend you refer to our squad. Check out our <a href="<?php echo home_url('/rewards'); ?>">Rewards</a> page for some great prizes you can redeem</p>
                            </div>
                        </li>
                        <li>
                            <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/thumb-eyeshadow4.jpg">
                            <div class="content">
                                <p class="header txt-light-blue nd19-block-content-s">THE POWER IS IN YOUR PALETTE</p>
                                <p class="title smcf-none-bold nd19-block-title-s">Trade, Skip or Cancel- It's That Simple.</p>
                                <p class="description nd19-block-content-s">Not feelin' your next palette? Trade it for something else! Strapped for cash one month? Skip a payment! Currently experiencing shadow overload? Cancel your membership anytime. We like to keep things like our dating life, as non-committal as possible. Check out your <a href="<?php echo home_url('/my-account'); ?>">Dashboard</a> to see all your options!</p>
                            </div>
                        </li>
                    </ul>
                    <div class="actions">
                        <div class="action active show-detail-confirmation" data-step="1">
                            <div>
                                <p class="action-title nd19-block-content-s"><span class="left">01</span> View your account details</p>
                                <p class="action-content txt-pink nd19-block-content">
                                    <span class="confirmation-narrow left"><i class="fas fa-arrow-left" aria-hidden="true"></i> Subscription & Shipping
                                </p>
                            </div>
                        </div>
                        <div class="action show-share-confirmation text-right" data-step="3">
                            <div>
                                <p class="action-title nd19-block-content-s">Get a free lipstick for you and your friends <span class="right">03</span></p>
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
        <img class="mb-image show-mobile" src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/sub_confirm_SM_mobile.jpg"/>
        <div class="col-lg-12">
            <div class="row">
                <div class="col-lg-6 confirmation-left-section smbg-confirmation-wl3 no-bottom-padding-mobile cfsm-waitlist">
                    <h1 class="nd19-section-title">
                        Share the love.
                        <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/wave.png">
                        <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/hearteyes.png">
                        <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/party.png">
                    </h1>
                    <p>Tell your friends about LiveGlam ShadowMe<br> and you can score some free lippies for you all!</p>
                    <div class="product-image d-desktop">
                        <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/sub_confirm_SM@2x.jpg"/>
                    </div>
                </div>
                <div class="col-lg-6 confirmation-right-section">
                    <p class="txt-pink thanks nd19-section-title">
                        Rewards & Freebies
                        <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/pray.png">
                        <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/blush.png">
                        <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/sparkle.png">
                    </p>
                    <p class="nd19-block-content">Because we want your experience with us to be glam-azing!</p>
                    <ul class="confirmation-details">
                        <li>
                            <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/thumb-eyeshadow1.jpg">
                            <div class="content">
                                <p class="header smcf-right-header4 nd19-block-content-s">Rewards</p>
                                <p class="title smcf-none-bold nd19-block-title-s"><?php echo IzCustomization::total_number_of_redeem_product();?> Rewards Available</p>
                                <p class="description nd19-block-content-s">We keep our <a href="<?php echo home_url('/rewards'); ?>">Rewards</a> stocked with your favorite LiveGlam products and other trendy items from top brands! New products are added every week to keep our inventory glamazing and fresh. </p>
                            </div>
                        </li>
                        <li>
                            <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/thumb-eyeshadow5.jpg"/>
                            <div class="content">
                                <p class="header txt-light-blue smcf-right-header5 nd19-block-content-s">FREE MAKEUP</p>
                                <p class="title smcf-none-bold nd19-block-title-s">Get Free Lippies for You and Your Friends!</p>
                                <p class="description nd19-block-content-s">When your friends sign up using your referral link, they get to choose a free LiveGlam KissMe lippie when they join and you get 200 points too! Use your points towards palettes, brushes, lippies or other awesome swag. Share using the buttons below.</p>
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
                                <p class="action-title nd19-block-content-s"><span class="left">02</span> Your palette comes packed with benefits</p>
                                <p class="action-content txt-pink nd19-block-content"><i class="fas fa-arrow-left" aria-hidden="true"></i> Loads of perks
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