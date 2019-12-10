<?php

  /**
   * Template Name: Page Asset Affiliates KissMe
   *
   * @package Liveglam
   */

  liveglam_check_user_login();

  get_header(); ?>

<div class="lg_asset_affiliates container">
  <div class="lg_asset_heading">
    <h1>Assets for Instagram, Blog, Reddit, etc.</h1>
    <p>Tell your friends about KissMe<br>
       Each of you gets a free lippie when they join.
      <span class="hover-title" title="" data-toggle="tooltip" data-placement="top" data-original-title="Tell your friends about KissMe. Each of you gets a free lippie when they join. ">i</span>
    </p>
  </div>
  <div id="ref-url" class="lg_asset_ref">
    <h2>Your personal referral link is:</h2>
    <p class="ref_link"><?php echo home_url(PAGE_REFERRAL.'?ref=').do_shortcode('[currentuser_username]'); ?></p>
  </div>
  <div class="lg_asset_content instagram-assets">
    <h2>Instagram assets:</h2>
    <?php echo do_shortcode('[diamond_affiliate_image]'); ?>
  </div>
  <div class="lg_asset_instructions posting-instructions">
    <h3>Posting Instructions:</h3>
    <ul>
      <li><i class="fas fa-caret-right"></i><strong>Save the above image(s)</strong> of your choice to upload to instagram</li>
      <li><i class="fas fa-caret-right"></i> <strong>Update the link in your bio</strong> to your referral code above</li>
      <li><i class="fas fa-caret-right"></i><strong>Create your own caption.</strong> Example: Addicted to liquid lipstick? Join the club KissMe! Get 3 liquid lipsticks sent to your door each month for $19.99 by @LiveGlam.co. Plus get free shipping to US. Each month is a surprise and includes 3 different liquid lipsticks. Cancel anytime and skip months you don’t want. It’s that simple! Use the link in my bio to get a free lipstick upon checkout!</li>
    </ul>
  </div>

  <div class="lg_asset_blog blog-assets">
    <h2>Blog assets:</h2>
    <div class="col-md-4">
      <div class="left-one-third">
        <p>
          <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/km_affiliate_banner_160x600.jpg" data-no-lazy="1"/><br>
          <a class="nofancybox save_img" href="https://liveglam.com/?download_image=km_affiliate_banner_160x600.jpg" download="">
            <button>Save</button>
          </a><br>
          160X160
        </p>
        <p>
          <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/km_affiliate_banner_120x600.jpg" data-no-lazy="1"/><br>
          <a class="nofancybox save_img" href="https://liveglam.com/?download_image=km_affiliate_banner_120x600.jpg" download="">
            <button>Save</button>
          </a><br>
          120X600
        </p>
      </div>
    </div>
    <div class="col-md-8">
      <div class="right-one-third">
        <p>
          <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/km_affiliate_banner_728x90.jpg" data-no-lazy="1"/><br>
          <a class="nofancybox save_img" href="https://liveglam.com/?download_image=km_affiliate_banner_728x90.jpg" download="">
            <button>Save</button>
          </a><br>
          728X90
        </p>

        <p>
          <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/km_affiliate_banner_468x60.jpg" data-no-lazy="1"/><br>
          <a class="nofancybox save_img" href="https://liveglam.com/?download_image=km_affiliate_banner_468x60.jpg" download="">
            <button>Save</button>
          </a><br>
          468x60
        </p>
        <p>
          <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/km_affiliate_banner_300x250.jpg" data-no-lazy="1"/><br>
          <a class="nofancybox save_img" href="https://liveglam.com/?download_image=km_affiliate_banner_300x250.jpg" download="">
            <button>Save</button>
          </a><br>
          300x250
        </p>
      </div>
    </div>
  </div>
  <div class="lg_asset_instructions posting-instructions">
    <h3>Posting Instructions:</h3>
    <ul>
      <li><i class="fas fa-caret-right"></i>
        <strong>Save the above image(s)</strong> of your choice to fit on your blog post or anywhere on your website.
      </li>
      <li><i class="fas fa-caret-right"></i>
        <strong>Write a blog article about your KissMe experience!</strong> Make sure your banner includes your personal tracking link at the top of this page.
      </li>
    </ul>
  </div>
</div>

<?php get_footer(); ?>

