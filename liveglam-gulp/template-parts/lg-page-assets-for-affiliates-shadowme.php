<?php

  /**
   * Template Name: Page Asset Affiliates ShadowMe
   *
   * @package Liveglam
   */

  liveglam_check_user_login();

  get_header(); ?>

<div class="lg_asset_affiliates container">
  <div class="lg_asset_heading">
    <h1>Assets for Instagram, Blog, Reddit, etc.</h1>
    <p>Tell your friends about ShadowMe<br>
       Give your friends a free lippie and snag one for yourself for each friend that joins!</p>
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
      <li><i class="fas fa-caret-right"></i><strong>Create your own caption.</strong> Example: Do you love new eyeshadow palettes? Join the LiveGlam Eyeshadow club, ShadowMe! See what beauty you can blend with a new 6-pan eyeshadow palette every 2 months for $19.99 by @LiveGlam.co. Each month is a surprise with 6 brand new eyeshadows. You can skip months you don’t want, trade your palette for other glammed-out goodies, and cancel anytime. It’s that simple! Use the link in my bio to get a free brush upon checkout!</li>
    </ul>
  </div>

  <div class="lg_asset_blog blog-assets">
    <h2>Blog assets:</h2>
    <div class="col-md-4">
      <div class="left-one-third">
        <p>
          <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/sm_affiliate_banner_160x600.jpg" data-no-lazy="1"/><br>
          <a class="nofancybox save_img" href="https://liveglam.com/?download_image=sm_affiliate_banner_160x600.jpg" download="">
            <button>Save</button>
          </a><br>
          160X160
        </p>
        <p>
          <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/sm_affiliate_banner_120x600.jpg" data-no-lazy="1"/><br>
          <a class="nofancybox save_img" href="https://liveglam.com/?download_image=sm_affiliate_banner_120x600.jpg" download="">
            <button>Save</button>
          </a><br>
          120X600
        </p>
      </div>
    </div>
    <div class="col-md-8">
      <div class="right-one-third">
        <p>
          <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/sm_affiliate_banner_728x90.jpg" data-no-lazy="1"/><br>
          <a class="nofancybox save_img" href="https://liveglam.com/?download_image=sm_affiliate_banner_728x90.jpg" download="">
            <button>Save</button>
          </a><br>
          728X90
        </p>

        <p>
          <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/sm_affiliate_banner_468x60.jpg" data-no-lazy="1"/><br>
          <a class="nofancybox save_img" href="https://liveglam.com/?download_image=sm_affiliate_banner_468x60.jpg" download="">
            <button>Save</button>
          </a><br>
          468x60
        </p>
        <p>
          <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/sm_affiliate_banner_300x250.jpg" data-no-lazy="1"/><br>
          <a class="nofancybox save_img" href="https://liveglam.com/?download_image=sm_affiliate_banner_300x250.jpg" download="">
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
      <li><i class="fas fa-caret-right"></i><strong>Save the above image(s)</strong> of your choice to fit on your blog post or anywhere on your website.</li>
      <li><i class="fas fa-caret-right"></i> <strong>Update the URL in your banner</strong> to your referral code above</li>
      <li><i class="fas fa-caret-right"></i><strong>Write a blog article about your ShadowMe experience!</strong>  Make sure your banner links to your personal referral code at the <a class="scroll-element" href="#ref-url" >top</a> of this page so you can score Reward points!</li>
    </ul>
  </div>
</div>

<?php get_footer(); ?>

