<?php

  /**
   * Template Name: Page Asset Affiliates MorpheMe
   *
   * @package Liveglam
   */

  liveglam_check_user_login();

  get_header(); ?>

<div class="lg_asset_affiliates container">
  <div class="lg_asset_heading">
    <h1>Assets for Instagram, Blog, Reddit, etc.</h1>
    <p>Tell your friends about #MorpheMe<br>
       Each of you gets a free makeup brush when they join.
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
      <li>
        <i class="fas fa-caret-right"></i><strong>Save the above image(s)</strong> of your choice to upload to instagram
      </li>
      <li><i class="fas fa-caret-right"></i> <strong>Update the link in your bio</strong> to your referral code above
      </li>
      <li><i class="fas fa-caret-right"></i>
        <strong>Create your own caption.</strong> Example: Addicted to makeup brushes? Join the club MorpheMe! Get $30+ in Morphe makeup brushes sent to your door each month for $19.99 by @LiveGlam.co. Plus get free shipping to US. Each month is a surprise and includes 3-7 powder, foundation, contour, eye shadow and liner brushes. Cancel anytime and skip months you don't want. It's that simple! Use the link in my bio to get a free brush upon checkout!
      </li>
    </ul>
  </div>

  <div class="lg_asset_blog blog-assets">
    <h2>Blog assets:</h2>
    <div class="col-md-4">
      <div class="left-one-third">
        <p>
          <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/pop-up-banners-morphe_10.jpg" data-no-lazy="1"/><br>
          <a class="nofancybox save_img" href="https://liveglam.com/?download_image=pop-up-banners-morphe_10.jpg" download="">
            <button>Save</button>
          </a><br>
          160X160
        </p>
        <p>
          <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/pop-up-banners-morphe_12.jpg" data-no-lazy="1"/><br>
          <a class="nofancybox save_img" href="https://liveglam.com/?download_image=pop-up-banners-morphe_12.jpg" download="">
            <button>Save</button>
          </a><br>
          120X600
        </p>
      </div>
    </div>
    <div class="col-md-8">
      <div class="right-one-third">
        <p>
          <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/pop-up-banners-morphe_15.jpg" data-no-lazy="1"/><br>
          <a class="nofancybox save_img" href="https://liveglam.com/?download_image=pop-up-banners-morphe_15.jpg" download="">
            <button>Save</button>
          </a><br>
          728X90
        </p>

        <p>
          <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/pop-up-banners-morphe_18.jpg" data-no-lazy="1"/><br>
          <a class="nofancybox save_img" href="https://liveglam.com/?download_image=pop-up-banners-morphe_18.jpg" download="">
            <button>Save</button>
          </a><br>
          468x60
        </p>
        <p>
          <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/pop-up-banners-morphe_22.jpg" data-no-lazy="1"/><br>
          <a class="nofancybox save_img" href="https://liveglam.com/?download_image=pop-up-banners-morphe_22.jpg" download="">
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
      <li><i class="fas fa-caret-right"></i> <strong>Update the URL in your banner</strong> to your referral code above
      </li>
      <li><i class="fas fa-caret-right"></i>
        <strong>Write a blog article about your #MorpheMe experience!</strong> Make sure your banner includes your personal tracing link at the top of this page. See samples below:
        <ul>
          <li>
            <a href="http://www.mysubscriptionaddiction.com/2016/09/morpheme-brush-club-subscription-box-review-september-2016.html" target="_blank">http://www.mysubscriptionaddiction.com/2016/09/morpheme-brush-club-subscription-box-review-september-2016.html</a>
          </li>
          <li>
            <a href="http://southernbeautyguide.com/2016/04/morpheme-monthly-brush-club-review-april.html" target="_blank">http://southernbeautyguide.com/2016/04/morpheme-monthly-brush-club-review-april.html</a>
          </li>
        </ul>
      </li>
    </ul>
  </div>
</div>

<?php get_footer(); ?>

