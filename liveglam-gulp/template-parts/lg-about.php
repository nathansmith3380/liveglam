<?php
/**
 * Template Name: About page
 *
 * @package Liveglam
 */

get_header(); ?>


    <!-- Hero Section -->
    <div class="about-page about-hero">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <div class="about-tag nd19-block-content text-center">about us</div>
                    <div class="hero-title text-center nd19-hero-title">Since the beginning, we’ve had one main focus: to help you discover a more beauty-full you.</div>
                </div>
            </div>
        </div>
    </div>

    <!-- Reviews Section -->
    <div class="about-page about-review text-center">
        <div class="container">
            <div class="section-title nd19-section-title">Consider us your new BBF (best blend forever)! </div>
            <p class="nd19-section-subtitle">Whether you want to brush up your makeup kit, discover your next favorite lipstick, or let your eyes do the talking, we’re here to glam up your life every month.</p>
            <div class="flex-group reviews">
                <div class="flex-item">
                    <div class="review-value">75+</div>
                    <div class="about-tag nd19-block-content">team<br>members</div>
                </div>
                <div class="flex-item">
                    <div class="review-value">4+</div>
                    <div class="about-tag nd19-block-content">YEARS IN<br>BUSINESS</div>
                </div>
                <div class="flex-item">
                    <div class="review-value">10M</div>
                    <div class="about-tag nd19-block-content">PRODUCTS<br>SHIPPED</div>
                </div>
                <div class="flex-item">
                    <div class="review-value">98%</div>
                    <div class="about-tag nd19-block-content">Positive<br>reviews</div>
                </div>
            </div>
        </div>
    </div>

    <!-- Our Mission Section -->
    <div class="about-page about-mission text-center">
        <div class="container">
            <div class="content">
                <div class="skew-bg"><div class="text nd19-section-title">Our mission</div></div>
                <p class="nd19-section-subtitle">To inspire our Glammers by constantly creating, curating, and perfecting quality beauty products for a stress-free, empowered you.</p>
            </div>
        </div>
    </div>
    
    <!-- Loved Products Section -->
    <div class="about-page about-loved-products">
        <div class="container">
            <div class="section-title text-center nd19-section-title">You deserve beauty products that can keep up!</div>
            <div class="flex-group product-brush">
                <div class="flex-item">
                    <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/about-logo-brush@2x.png" class="product-logo">
                    <div class="about-tag nd19-block-content">BRUSH Club</div>
                    <p class="nd19-block-content">Ready to take your makeup kit and looks to the next level? We’ve partnered up with Morphe brushes to create the world’s first makeup brush club! Each month, members get 3-8 brushes delivered straight to their doors, including powder, foundation, contour, liner, eyeshadow brushes and more!</p>
                </div>
                <div class="flex-item">
                    <div class="img-with-bg"><img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/about-club-brush@2x.png"></div>
                </div>
            </div>
            <div class="flex-group product-lipstick">
                <div class="flex-item first-div">
                    <div class="img-with-bg"><img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/about-us-km.png"></div>
                </div>
                <div class="flex-item second-div">
                    <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/about-logo-lipstick@2x.png" class="product-logo">
                    <div class="about-tag nd19-block-content">Lipstick Club</div>
                    <p class="nd19-block-content">If having the perfect pout is more your style, our monthly Lippie Club has got you covered in our very own cruelty-free formulas! Members get 3 exclusive, long-lasting, vegan lip products every month ranging from liquid lipsticks, metallics, glosses, lip crayons, lip scrubs, and more. We also change up our casing often to keep things even more exciting!</p>
                </div>
            </div>
            <div class="flex-group product-shadow">
                <div class="flex-item">
                    <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/about-logo-shadow@2x.png" class="product-logo">
                    <div class="about-tag nd19-block-content">Eyeshadow Club</div>
                    <p class="nd19-block-content">Stay shades ahead with our newest club, ShadowMe! You'll get a new eyeshadow palette every other month packed with pigmented, buttery shades. Make plenty of room in your collection for mattes, sparkles, bolds, and neutrals packaged in the cutest palettes.</p>
                </div>
                <div class="flex-item">
                    <div class="img-with-bg"><img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/about-club-shadow@2x.png"></div>
                </div>
            </div>
            <div class="section-cta"><a href="<?php echo home_url(PAGE_PRE_CHECKOUT); ?>" class="btn-primary">join the glam fam</a></div>
        </div>
    </div>

    <!-- Studio Section -->
    <div class="about-page about-studios text-center">
        <div class="container">
            <div class="studio-intro">
                <div class="section-title nd19-section-title">Our studio</div>
                <p class="nd19-section-subtitle">The glam goes down at our content creation studio and fulfillment center in downtown, LA! We take our creative energy and blend it into exciting makeup tutorials and photoshoots with some of our favorite beauty influencers and MUA’s. Be sure to check out our socials and blog below to see everything we’ve been glamming up for you! </p>
                <img class="d-desktop" src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/about-studio@2x.png">
                <img class="d-mobile" src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/about-studio-mobile@2x.png">
            </div>
        </div>
    </div>

<?php get_footer(); ?>