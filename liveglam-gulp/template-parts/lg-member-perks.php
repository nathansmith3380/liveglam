<?php
/**
 * Template Name: Member Perks page
 *
 * @package Liveglam
 */

get_header(); ?>

<div class="benefits-page benefits-hero">
  <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/member-perks-mobile-top.jpg" alt="dashboard" class="show-mobile" />
    <div class="container">
        <div class="content">
            <div class="hero-title nd19-hero-title">Member Perks</div>
            <div class="hero-text nd19-hero-subtitle">Look your best and be in control of your <br class="d-desktop">makeup subscription.</div>
        </div>
    </div>
  <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/member-perks-mobile-bottom.jpg" alt="dashboard" class="show-mobile" />
</div>

<div class="benefits-page benefits-about-dashboard">
    <div class="container">
        <div class="about-dashboard-title text-center nd19-section-title">A fierce Dashboard</div>
        <div class="about-dashboard-subtitle text-center nd19-section-subtitle">Keep up with everything through an <br class="d-mobile">easy-to-use Dashboard.</div>

        <div class="flex-group bg-gray">
            <div class="description">
                <div class="description-subtitle nd19-block-title-s">View your collection<br>before it ships.</div>
                <p class="nd19-block-content">Our new collections debut on every 23rd of the month! We announce them at 9 am PST on our Beauty Blog, social accounts, and emails with a full product breakdown and tutorials so you can’t miss it. As a member, you can also view your next collection on your LiveGlam Dashboard before it ships out.</p>
            </div>
            <div class="screenshot">
                <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/member-perks-dashboard-1.gif" alt="dashboard">
            </div>
        </div>

        <div class="flex-group">
            <div class="screenshot">
                <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/member-perks-dashboard-trade.gif" alt="dashboard">
            </div>
            <div class="description">
                <div class="description-subtitle nd19-block-title-s">Trade whole set or<br>individual products.</div>
                <p class="nd19-block-content">Not loving a collection? You’re in control! Before your billing date every month, you have the option to trade individual products or your whole set through your LiveGlam Dashboard to get what you really want instead. We add new Trade options every month.</p>
            </div>
        </div>

        <div class="flex-group bg-gray">
            <div class="description">
                <div class="description-subtitle nd19-block-title-s">Skip any month or<br>change your billing date.</div>
                <p class="nd19-block-content">We’re as flexible as our formulas, so if you ever want to skip a month or change your billing date, you won’t be charged a thing! You can do all of this right through your Dashboard as a member. Just be sure to skip or change your billing before your next shipment.</p>
            </div>
            <div class="screenshot">
                <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/member-perks-dashboard-skip.gif" alt="dashboard">
            </div>
        </div>

        <div class="flex-group">
            <div class="screenshot">
                <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/member-perks-dashboard-4.gif" alt="dashboard">
            </div>
            <div class="description">
                <div class="description-subtitle nd19-block-title-s">Reward yourself!</div>
                <p class="nd19-block-content">Through our referral program, you can earn Reward points to use towards more beauty goodies or earn cash by simply referring your friends! You’ll also automatically get points for every monthly package you get, on your birthday, and by rating our collections. We add new Reward options every month.</p>
            </div>
        </div>

        <div class="flex-group bg-gray">
            <div class="description">
                <div class="description-subtitle nd19-block-title-s">Cancel anytime.</div>
                <p class="nd19-block-content">We hope you stay in our #LiveGlamFam forever, but if you ever need to cancel your membership, we understand!  As a member, you can blend out every part of your subscription including canceling through your Dashboard.</p>
            </div>
            <div class="screenshot">
                <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/member-perks-dashboard-cancel.gif" alt="dashboard">
            </div>
        </div>
    </div>
</div>

<div class="benefits-page benefits-member-perks">
    <div class="container">
        <div class="section-title nd19-section-title">Subscription Benefits</div>
        <p class="section-description nd19-section-subtitle">There are a lot of perks that come with being a part of the #LiveGlamFam!</p>

        <div class="flex-group">
            <div class="flex-item">
                <div class="perk-icon"><img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/subscription-perk-1.png" alt="Shop discount"></div>
                <div class="perk-title nd19-block-title-s">Shop discount</div>
                <div class="perk-desc nd19-block-content">Get a member’s exclusive discount on all of our Shop products.</div>
            </div>
            <div class="flex-item">
                <div class="perk-icon"><img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/subscription-perk-2.png" alt="First access to launches"></div>
                <div class="perk-title nd19-block-title-s">First access to launches</div>
                <div class="perk-desc nd19-block-content">You’ll be the ﬁrst to know about all of our launches, promos, and special collabs!</div>
            </div>
            <div class="flex-item">
                <div class="perk-icon"><img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/subscription-perk-3.png" alt="Video Streaming"></div>
                <div class="perk-title nd19-block-title-s">Monthly tutorials</div>
                <div class="perk-desc nd19-block-content">Learn how to use your LiveGlam products through monthly video tutorials with our fav influencers!</div>
            </div>
        </div>
    </div>
</div>

<div class="benefits-page benefits-customer-service">
    <div class="content">
        <img class="section-logo" src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/subscription-benefits-perks-logo.gif" alt="Customer Service">
        <div class="section-title nd19-section-title">The best customer service</div>
        <p class="section-subtitle nd19-section-subtitle">Still have any doubts? You will love the support you receive.</p>
        <p class="nd19-section-subtitle">Our top-notch Customer Happiness team is always available to blend away any issues. Our team typically responds within 2 hours or less and has a 98% satisfaction rate.</p>
        <div class="section-cta">
            <a href="<?php echo home_url('contact-us'); ?>" class="btn-secondary d-desktop">get in touch</a>
            <a href="<?php echo home_url('faq'); ?>" class="btn-primary">view faqs</a>
            <a href="<?php echo home_url('contact-us'); ?>" class="link d-mobile">get in touch ></a>
        </div>
    </div>
</div>

<!-- Start Join now Section : From Member Perks -->
<div class="benefits-page benefits-join-now m-fixed-height">
    <img class="subscribe-left-img hide-mobile" src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/subscribe-lippies.png" alt="" />
    <div class="subscribe-content">
        <div class="section-title nd19-block-title">Subscribe for more exclusive beauty products!</div>
        <p class="nd19-section-subtitle">Join our <strong>#LiveGlamFam</strong> and get new beauty products delivered straight to your door monthly.</p>
        <div class="section-cta d-desktop"><a href="<?php echo home_url(PAGE_PRE_CHECKOUT); ?>" class="btn-primary">Subscribe</a></div>
        <div class="section-cta d-mobile"><a href="<?php echo home_url(PAGE_PRE_CHECKOUT); ?>" class="btn-secondary">join now</a></div>
    </div>
    <img class="subscribe-right-img hide-mobile" src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/subscribe-brushes.png" alt="" />
</div>

<!-- *** Hide For now *** -->
<!-- <div class="benefits-page benefits-instagram">
    <div class="section-title nd19-section-title">Shop our Instagram</div>
    <p class="section-subtitle nd19-section-subtitle">Check Out Some of Our Fam Favorites</p>

    <?php /** Get Instagram image slider */
    $instagram_images = get_field('instagram_images');
    if ( !empty($instagram_images) ): ?>
        <div class="owl-carousel instagram-slider owl-nav-m-bottom">
            <?php foreach ($instagram_images as $slide): ?>
            <a href="<?php echo $slide['link']; ?>" target="_blank"><div class="slide"><img src="<?php echo $slide['image']; ?>" alt="Oops! No Image.."></div></a>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
    <div class="section-cta"><a href="<?php echo site_url();?>/shop" class="btn-primary">Go to Shop</a></div>
</div> -->


<script>
    // jQuery(document).ready(function ($) {
    //     // Init instagram image slider
    //     $('.instagram-slider').owlCarousel({
    //         loop: true,
    //         margin: 25,
    //         autoplay: true,
    //         smartSpeed: 1000,
    //         autoplayHoverPause: true,
    //         responsive: {
    //             0: {
    //                 items: 1,
    //                 nav: true,
    //                 dots: true
    //             },
    //             768: {
    //                 items: 6,
    //                 nav: false,
    //                 dots: false,
    //             }
    //         },
    //         navText: ["<img src='<?php echo get_stylesheet_directory_uri(); ?>/assets/img/arrow-white-left@2x.png'>",
    //                 "<img src='<?php echo get_stylesheet_directory_uri(); ?>/assets/img/arrow-white-right@2x.png'>"]
    //     });
    // });
</script>


<?php get_footer(); ?>
