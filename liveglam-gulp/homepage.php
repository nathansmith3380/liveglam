<?php
  /**
   * Template Name: Homepage
   * ACF frontend enabled: Use ACF helper functions to retrieve ACF data.
   *
   * @package Liveglam
   */
  if(!defined('ABSPATH')){
    exit; // Exit if accessed directly
  }

  $member_perks = get_page_by_path('member-perks');
  $member_perks_id = $member_perks ? $member_perks->ID : null;

  get_header(); ?>

  <div class="home-banner-2" style="display: none">
    <div class="home-banner-content banner-2">
      <div class="container">
        <p class="home-banner-title">GET A FREE PRODUCT</p>
        <p class="home-banner-desc">WHEN YOU JOIN ANY OF OUR CLUBS!</p>
        <p class="home-banner-action hide-mobile">
          <a href="<?php echo home_url('pre-checkout/?ref=liveglam'); ?>" class="btn btn-primary">GET MY FREE PRODUCT HERE</a>
        </p>
        <p class="home-banner-action show-mobile">
          <a href="<?php echo home_url('pre-checkout/?ref=liveglam'); ?>" class="btn btn-primary">GET FREE PRODUCT</a>
        </p>
      </div>
    </div>
  </div>

  <div class="home-banner-3" style="display: none">
    <div class="home-banner-content banner-3">
      <div class="container">
        <p class="home-banner-title">GET A FREE PRODUCT</p>
        <p class="home-banner-desc">WHEN YOU JOIN ANY OF OUR CLUBS!</p>
        <p class="home-banner-action hide-mobile">
          <a href="<?php echo home_url('pre-checkout/?ref=liveglam'); ?>" class="btn btn-primary">GET MY FREE PRODUCT HERE</a>
        </p>
        <p class="home-banner-action show-mobile">
          <a href="<?php echo home_url('pre-checkout/?ref=liveglam'); ?>" class="btn btn-primary">GET FREE PRODUCT</a>
        </p>
      </div>
    </div>
  </div>

  <style>
    .home-banner-content {
      padding: 1vw 0 .75vw;
      text-align: center;
    }
    .home-banner-content.banner-2 {
      background: url(<?php echo get_stylesheet_directory_uri(); ?>/assets/img/home-banner-left-dk-B.png), url(<?php echo get_stylesheet_directory_uri(); ?>/assets/img/home-banner-right-dk-B.png), #FFEEE5;
      background-repeat: no-repeat, no-repeat;
      background-size: contain, contain;
      background-position: left center, right, center;
    }
    .home-banner-content.banner-3 {
      background: url(<?php echo get_stylesheet_directory_uri(); ?>/assets/img/home-banner-left-dk-C.png), url(<?php echo get_stylesheet_directory_uri(); ?>/assets/img/home-banner-right-dk-C.png), #FFEEE5;
      background-repeat: no-repeat, no-repeat;
      background-size: contain, contain;
      background-position: left center, right, center;
    }
    .home-banner-content .home-banner-title {
      font-size: 2vw;
      font-family: Bebas Neue;
      color: #fff;
      position: relative;
      display: inline-block;
      z-index: 1;
      margin: 0 auto;
      line-height: 2.5vw;
    }
    .home-banner-content .home-banner-title:before {
      content: " ";
      width: 124%;
      height: 100%;
      background-color: #000000;
      position: absolute;
      z-index: -1;
      transform: skew(20deg, 0);
      top: -8%;
      left: -12%;
      box-shadow: -0.5vw 0.5vw 0 #F05E7C;
    }
    .home-banner-content .home-banner-desc {
      font-size: 2vw;
      font-family: Bebas Neue;
      margin: 0.75vw auto 0;
      line-height: 2.5vw;
    }
    .home-banner-content .home-banner-action {
      margin: 0 auto;
    }
    .home-banner-content .home-banner-action a {
      height: 3vw;
      font-size: .7vw !important;
      letter-spacing: 1px;
    }
    @media only screen and (max-width: 767px) {
      .home-banner-content {
        padding: 4vw 0;
        text-align: left;
      }
      .home-banner-content.banner-2 {
        background: url(<?php echo get_stylesheet_directory_uri(); ?>/assets/img/home-banner-mb-B.png), #FFEEE5;
        background-position: right center;
        background-repeat: no-repeat;
        background-size: contain;
      }
      .home-banner-content.banner-3 {
        background: url(<?php echo get_stylesheet_directory_uri(); ?>/assets/img/home-banner-mb-C.png), #FFEEE5;
        background-position: right center;
        background-repeat: no-repeat;
        background-size: contain;
      }
      .home-banner-content .home-banner-title {
        font-size: 5vw;
        line-height: 7.5vw !important;
        letter-spacing: 1px;
      }
      .home-banner-content .home-banner-title:before {
        width: 180%;
        left: unset;
        right: -15%;
        box-shadow: -1vw 1vw 0 #F05E7C;
        top: -5%;
      }
      .home-banner-content .home-banner-desc {
        font-size: 5vw;
        line-height: 7vw !important;
        margin: 2vw auto 0;
        letter-spacing: .5px;
      }
      .home-banner-content .home-banner-action a {
        height: 9vw;
        font-size: 3.3vw !important;
        font-weight: 600;
        padding: 0 5vw;
      }
      .home-banner-content .home-banner-action a:before {
        top: .75vw;
        left: .75vw;
        right: .75vw;
        bottom: .75vw;
      }
    }
  </style>

<?php echo do_shortcode('[lgs_header_holiday]'); ?>

<?php if (get_field('show_banner') && $content = get_field('content')):
  $banner_style = '.homepage-banner { background:';
  $desktop_left_image = get_field('desktop_left_image');
  if ($desktop_left_image) {
    $banner_style .= 'url('.$desktop_left_image.') no-repeat left center,';
  }
  $banner_background = get_field('banner_background');
  if (!$banner_background) $banner_background = '#fff';
  $banner_style .= $banner_background.'; }';

  $hide_under = get_field('hide_under');
  if (!$hide_under) $hide_under = '767.9';
  $banner_style .= '@media only screen and (max-width:'.$hide_under.'px) {';
  $banner_style .= '.homepage-banner { background:'.$banner_background.'; } }';

  echo '<style>'.$banner_style.'</style>';
?>
<!-- Start Banner Section -->
<div class="homepage-banner">
	<div class="container">
		<div class="row no-gutters">
			<div class="col col-md-8 d-flex align-items-center pr-md-5">
				<div class="d-none d-md-block">
					<img src="<?php if ($content['title_desktop']) echo $content['title_desktop']; ?>" alt="Home Banner">
					<div class="d-md-flex align-items-center nd19-block-content-s">
					<?php if ($content['description_desktop']) echo $content['description_desktop']; ?>
					<a class="btn-primary" href="<?php echo home_url(PAGE_PRE_CHECKOUT); ?>?club=kissme&trade=0">Subscribe</a>
					</div>
				</div>
				<div class="d-md-none my-3">
					<div class="banner-title"><?php if ($content['title_mobile']) echo $content['title_mobile']; ?></div>
					<p><?php if ($content['description_mobile']) echo $content['description_mobile']; ?></p>
					<a class="btn-primary btn-solid" href="<?php echo home_url(PAGE_PRE_CHECKOUT); ?>?club=kissme&trade=0">Subscribe</a>
				</div>
			</div>
			<div class="col-auto col-md-4 text-right">
        <img class="d-none d-md-block" src="<?php echo get_field('desktop_right_image'); ?>" alt="Home Banner">
				<img class="d-md-none" src="<?php echo get_field('mobile_right_image'); ?>" alt="Home Banner">
			</div>
		</div>
	</div>
</div>
<!-- End Banner Section -->
<?php endif; ?>


<!-- Start Hero Section -->
<div class="homepage-hero">
  <div class="container">
    <div class="flex-group">
      <div class="content">
        <div class="newmonthnewyou d-desktop"><img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/newmonthnewyou.png" alt="LiveGlam New Month New You"></div>
        <div class="newmonthnewyou d-mobile"><img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/newmonthnewyou-m.png" alt="LiveGlam New Month New You"></div>
        <div class="text nd19-section-subtitle">Join the <strong>#LiveGlamFam</strong> and choose from lippies, brushes and palettes for $19.99!</div>
        <a href="<?php echo home_url(PAGE_PRE_CHECKOUT); ?>" class="btn-primary">start now</a>
        <div class="nd19-block-content">
          <?php echo do_shortcode('[referral_code_form text="Got a code?"]'); ?>
        </div>
      </div>
      <div class="image">
        <img class="d-desktop" src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/home-hero-image@2x.png" alt="Banner image of model holding LiveGlam subscription products">
        <img class="d-mobile" src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/home-hero-image@2x_500.png" alt="Banner image of model holding LiveGlam subscription products">
      </div>
    </div>
  </div>
</div>
<!-- End Hero Section -->


<!-- Start Review Section -->
<div class="homepage-reviews">
  <div class="container">
    <?php /** Get Reviews slider data */
      if ( !empty($review_slider = get_field('review_slider')) ): ?>
      <div class="owl-carousel review-slider owl-nav-m-bottom">
        <?php foreach ($review_slider as $slide):
          if(false !== strpos($slide['title'],'[shipped-last-month]')){
            $slide['title'] = str_replace('[shipped-last-month]', count_number_complete_order(true), $slide['title']);
          } ?>
        <div class="review-slide">
          <img class="review-icon" src="<?php echo $slide['icon']; ?>" alt="<?php echo $slide['title']; ?>">
          <div class="review-content">
            <div class="review-title nd19-block-title-s"><?php echo $slide['title']?></div>
            <div class="review-desc nd19-block-content-s"><?php echo $slide['description']?></div>
          </div>
        </div>
        <?php endforeach; ?>
      </div>
    <?php endif; ?>
  </div>
</div>
<!-- End Review Section -->

  <!-- Start Features Section -->
  <div class="homepage-features">
    <div class="container">
      <div class="section-title nd19-section-title">How Our Subscriptions Work</div>
      <div class="section-sub-title nd19-section-subtitle">The easiest and most effortless way to build your makeup collection.</div>
      <div class="owl-carousel features-slider owl-nav-m-bottom">
        <div class="feature">
          <img class="feature-icon" src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/home-holiday-choose-your-glam.gif" alt="LiveGlam choose your glam">
          <div class="feature-title nd19-block-title-s">Choose Your Glam</div>
          <div class="feature-desc nd19-block-content">Get a consistent supply of lippies, brushes, palettes, or all 3! The glam is in your hands.</div>
        </div>
        <div class="feature">
          <img class="feature-icon" src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/home-holiday-customize.gif" alt="LiveGlam customize your box">
          <div class="feature-title nd19-block-title-s">Customize</div>
          <div class="feature-desc nd19-block-content">Trade, skip, or cancel anytime. You can also choose your own billing date.</div>
        </div>
        <div class="feature">
          <img class="feature-icon" src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/home-holiday-ships.gif" alt="LiveGlam earn rewards and perks">
          <div class="feature-title nd19-block-title-s">Ships Immediately</div>
          <div class="feature-desc nd19-block-content">Free shipping within the U.S. and flat-rate shipping everywhere else.</div>
        </div>
        <div class="feature">
          <img class="feature-icon" src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/home-holiday-rewards-perks.gif" alt="LiveGlam earn rewards and perks">
          <div class="feature-title nd19-block-title-s">Rewards & Perks</div>
          <div class="feature-desc nd19-block-content">Score Reward points each month to use on free makeup and goodies!</div>
        </div>
      </div>
      <div class="section-cta"><a href="<?php echo home_url('/member-perks'); ?>" class="btn-primary">see member perks</a></div>
    </div>
  </div>
  <!-- End Features Section -->

    <!-- Start Clubs Section -->
    <div class="homepage-update-clubs">
      <?php /** Get Select Culb slider data */
      $current_time = current_time('timestamp');
      $kissme_club = get_field('kissme_club');
      if(!empty($kissme_club['club_image'])){
        foreach($kissme_club['club_image'] as $club_image){
          if( empty($club_image['start_displaying_it_on']) || $current_time >= strtotime($club_image['start_displaying_it_on'])){
            $kissme_club['club_image'] = !empty($club_image['image_to_show']) ? wp_get_attachment_image($club_image['image_to_show'], 'medium') : $kissme_club['club_image'];
            $kissme_club['club_subtitle'] = $club_image['club_subtitle'];
          }
        }
      } else {
        $kissme_club['club_image'] = '<img src="'.get_stylesheet_directory_uri().'/assets/img/pre-checkout-lippies-default.png" alt="KissMe Image">';
        $kissme_club['club_subtitle'] = '';
      }
      $morpheme_club = get_field('morpheme_club');
      if(!empty($morpheme_club['club_image'])){
        foreach($morpheme_club['club_image'] as $club_image){
          if( empty($club_image['start_displaying_it_on']) || $current_time >= strtotime($club_image['start_displaying_it_on'])){
            $morpheme_club['club_image'] = !empty($club_image['image_to_show']) ? wp_get_attachment_image($club_image['image_to_show'], 'medium') : $morpheme_club['club_image'];
            $morpheme_club['club_subtitle'] = $club_image['club_subtitle'];
          }
        }
      } else {
        $morpheme_club['club_image'] = '<img src="'.get_stylesheet_directory_uri().'/assets/img/pre-checkout-brushes.png" alt="MorpheMe Image">';
        $morpheme_club['club_subtitle'] = '';
      }
      $shadowme_club = get_field('shadowme_club');
      if(!empty($shadowme_club['club_image'])){
        $img_url = $subtitle = '';
        foreach($shadowme_club['club_image'] as $club_image){
          if( empty($club_image['start_displaying_it_on']) || $current_time >= strtotime($club_image['start_displaying_it_on'])){
            $shadowme_club['club_image'] = !empty($club_image['image_to_show']) ? wp_get_attachment_image($club_image['image_to_show'], 'medium') : $shadowme_club['club_image'];
            $shadowme_club['club_subtitle'] = $club_image['club_subtitle'];
          }
        }
      } else {
        $shadowme_club['club_image'] = '<img src="'.get_stylesheet_directory_uri().'/assets/img/pre-checkout-makeup.png" alt="ShadowMe Image">';
        $shadowme_club['club_subtitle'] = '';
      }
      ?>
      <div class="new-collections">
        <div class="container">
          <div class="new-collection-header show-desktop">
            <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/newest_collections_desktop.png" alt="New Collection Logo">
            <?php echo do_shortcode('[referral_code_form text="Got a code?" hide_script="true"]'); ?>
          </div>
          <img class="new-collection-logo show-mobile" src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/newest_collections_mobile.png" alt="New Collection Logo">
          <div class="new-collection-title hide-mobile nd19-section-subtitle">Glam the way you want it! You get to choose your first collection when you join.</div>
          <div class="new-collection-title show-mobile nd19-block-content text-center mt-3">Glam the way you want it! You get to choose your first collection when you join.</div>
            <div class="owl-carousel club-slider owl-nav-m-bottom">
              <div class="club-slide">
                <div class="club-border">
                  <div class="club-title nd19-block-title">
                    <p><?php echo $morpheme_club['club_title']?></p>
                  </div>
                  <div class="club-image">
                    <?php echo $morpheme_club['club_image']?>
                  </div>
                  <div class="club-logo">
                    <img src="<?php echo $morpheme_club['club_logo']?>" alt="<?php echo $morpheme_club['club_title']?>">
                  </div>
                  <div class="club-club"><?php echo $morpheme_club['club_subtitle']?></div>
                  <a href="<?php echo home_url(PAGE_PRE_CHECKOUT.'?club=morpheme'); ?>" data-producttype="morpheme" class="club-cta btn-primary show-desktop"><?php echo $morpheme_club['cta_text']?></a>
                  <div class="club-desc show-mobile nd19-block-content"><?php echo $morpheme_club['club_description']?></div>
                </div>
                <a href="<?php echo home_url(PAGE_PRE_CHECKOUT.'?club=morpheme'); ?>" data-producttype="morpheme" class="club-cta btn-primary show-mobile"><?php echo $morpheme_club['cta_text']?></a>
                <div class="club-desc show-desktop nd19-block-content"><?php echo $morpheme_club['club_description']?></div>
              </div>
              <div class="club-slide">
                <div class="club-border">
                  <div class="club-title nd19-block-title">
                    <p>
                      <?php echo $kissme_club['club_title']?>
                    </p>
                  </div>
                  <div class="club-image">
                    <?php echo $kissme_club['club_image']?>
                  </div>
                  <div class="club-logo">
                    <img src="<?php echo $kissme_club['club_logo']?>" alt="<?php echo $kissme_club['club_title']?>">
                  </div>
                  <div class="club-club"><?php echo $kissme_club['club_subtitle']?></div>
                  <a href="<?php echo home_url(PAGE_PRE_CHECKOUT.'?club=kissme'); ?>" data-producttype="kissme" class="club-cta btn-primary show-desktop"><?php echo $kissme_club['cta_text']?></a>
                  <div class="club-desc nd19-block-content show-mobile"><?php echo $kissme_club['club_description']?></div>
                </div>
                <a href="<?php echo home_url(PAGE_PRE_CHECKOUT.'?club=kissme'); ?>" data-producttype="kissme" class="club-cta btn-primary show-mobile"><?php echo $kissme_club['cta_text']?></a>
                <div class="club-desc nd19-block-content show-desktop"><?php echo $kissme_club['club_description']?></div>
              </div>
              <div class="club-slide">
                <div class="club-border">
                  <div class="club-title nd19-block-title">
                    <p>
                      <?php echo $shadowme_club['club_title']?>
                    </p>
                  </div>
                  <div class="club-image">
                    <?php echo $shadowme_club['club_image']?>
                  </div>
                  <div class="club-logo">
                    <img src="<?php echo $shadowme_club['club_logo']?>" alt="<?php echo $shadowme_club['club_title']?>">
                  </div>
                  <div class="club-club"><?php echo $shadowme_club['club_subtitle']?></div>
                  <a href="<?php echo home_url(PAGE_PRE_CHECKOUT.'?club=shadowme'); ?>" data-producttype="shadowme" class="club-cta btn-primary show-desktop"><?php echo $shadowme_club['cta_text']?></a>
                  <div class="club-desc nd19-block-content show-mobile"><?php echo $shadowme_club['club_description']?></div>
                </div>
                <a href="<?php echo home_url(PAGE_PRE_CHECKOUT.'?club=shadowme'); ?>" data-producttype="shadowme" class="club-cta btn-primary show-mobile"><?php echo $shadowme_club['cta_text']?></a>
                <div class="club-desc nd19-block-content show-desktop"><?php echo $shadowme_club['club_description']?></div>
              </div>
            </div>
            <div class="show-mobile">
              <?php echo do_shortcode('[referral_code_form text="Got a code?" hide_script="true"]'); ?>
            </div>
        </div>
      </div>

      <?php $alternative_data = [];
        $morpheme_alternative = LGS_User_Referrals::liveglam_get_set_product_trade('morpheme', true, false);
        $kissme_alternative = LGS_User_Referrals::liveglam_get_set_product_trade('kissme', true, false);
        $shadowme_alternative = LGS_User_Referrals::liveglam_get_set_product_trade('shadowme', true, false);
        $link_url = home_url(PAGE_PRE_CHECKOUT);
        if(!empty($kissme_alternative)){
          foreach($kissme_alternative as $index => $value){
            $alternative_item = (object)[
              'id' => $value['id'],
              'image' => $value['image'],
              'title' => $value['title'],
              'subtitle' => $value['subtitle'],
              'collection_name' => (trim($value['title']) != trim($value['collection_name'])) ? $value['collection_name'] : '',
              'club' => 'kissme',
              'link' => $link_url.'?club=kissme&trade='.$value['id'],
              'logo' => get_stylesheet_directory_uri().'/assets/img/logo-dashboard-km.svg',
            ];
            array_push($alternative_data, $alternative_item);
            if (!empty($morpheme_alternative) && isset($morpheme_alternative[$index])){
              $alternative_item = (object)[
                'id' => $morpheme_alternative[$index]['id'],
                'image' => $morpheme_alternative[$index]['image'],
                'title' => $morpheme_alternative[$index]['title'],
                'subtitle' => $morpheme_alternative[$index]['subtitle'],
                'collection_name' => (trim($morpheme_alternative[$index]['title']) != trim($morpheme_alternative[$index]['collection_name'])) ? $morpheme_alternative[$index]['collection_name'] : '',
                'club' => 'morpheme',
                'link' => $link_url.'?club=morpheme&trade='.$morpheme_alternative[$index]['id'],
                'logo' => get_stylesheet_directory_uri().'/assets/img/logo-dashboard-mm.svg',
              ];
              array_push($alternative_data, $alternative_item);
            }
            
            if (!empty($shadowme_alternative) &&  isset($shadowme_alternative[$index])){
              $alternative_item = (object)[
                'id' => $shadowme_alternative[$index]['id'],
                'image' => $shadowme_alternative[$index]['image'],
                'title' => $shadowme_alternative[$index]['title'],
                'subtitle' => $shadowme_alternative[$index]['subtitle'],
                'collection_name' => (trim($shadowme_alternative[$index]['title']) != trim($shadowme_alternative[$index]['collection_name'])) ? $shadowme_alternative[$index]['collection_name'] : '',
                'club' => 'shadowme',
                'link' => $link_url.'?club=shadowme&trade='.$value['id'],
                'logo' => get_stylesheet_directory_uri().'/assets/img/logo-dashboard-sm.svg',
              ];
              array_push($alternative_data, $alternative_item);
            }
            
          }
        }

        if(!empty($alternative_data)) {?>
        <div class="alternative-collections">
            <div class="container">
            <img class="alternative-logo show-mobile" src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/alternative_collections_mobile.png" alt="Alternative logo" />
              <p class="alternative-desc show-mobile nd19-block-content text-center mt-3">Want some more options? No problem! Choose any of the below collections as your first package.</p>
                <div class="owl-carousel alternative-data-selected">
                  <?php foreach($alternative_data as $alternative): ?>
                    <div class="alternative-slide">
                      <img class="alternative-img" src="<?php echo $alternative->image; ?>">
                      <img class="club-logo" src="<?php echo $alternative->logo;?>">
                      <p class="alternative-title"><?php echo $alternative->title;?></p>
                      <p class="alternative-subtitle"><?php echo $alternative->subtitle;?></p>
                    </div>
                  <?php endforeach;?>
                </div>
                <div class="alternative-list">
              <img class="alternative-logo show-desktop" src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/alternative_collections_desktop.png" alt="Alternative logo" />
                    <p class="alternative-desc hide-mobile nd19-section-subtitle">Want some more options? No problem! Choose any of the below collections as your first package.</p>
                    <div class="owl-carousel alternative-items alternative-items-slider" data-selected="0">
                        <?php
                        $data_size = sizeof($alternative_data);
                        $last_index = -1;
                        if ($data_size % 2 != 0) {
                            $last_index = $data_size - 1;
                            $data_size--;
                        }
                        for ($index = 0; $index < $data_size; $index+=2) { ?>
                            <div class="alternative-slide">
                                <img class="alternative-list-img" src="<?php echo $alternative_data[$index]->image; ?>" data-index="<?php echo $index; ?>" data-club="<?php echo $alternative_data[$index]->club; ?>" alt="<?php echo $alternative_data[$index]->title; ?>">
                                <img class="alternative-list-img" src="<?php echo $alternative_data[$index+1]->image; ?>" data-index="<?php echo $index+1; ?>" data-club="<?php echo $alternative_data[$index+1]->club; ?>" alt="<?php echo $alternative_data[$index+1]->title; ?>">
                            </div>
                        <?php }
                        if ($last_index > -1) { ?>
                        <div class="alternative-slide">
                          <img class="alternative-list-img" src="<?php echo $alternative_data[$last_index]->image; ?>" data-index="<?php echo $last_index; ?>" data-club="<?php echo $alternative_data[$last_index]->club; ?>" alt="<?php echo $alternative_data[$last_index]->title; ?>">
                        </div>
                        <?php } ?>
                    </div>
                    <div class="alternative-select-collection">
                        <a href="<?php echo home_url(PAGE_PRE_CHECKOUT); ?>" class="club-cta btn-primary">Get this collection</a>
                    </div>
                    <?php echo do_shortcode('[referral_code_form text="Got a code?" hide_script="true"]'); ?>
                </div>
            </div>
        </div>
      <?php } ?>
    </div>
    <!-- End Culbs Section -->

<!-- Start LiveGlamFam Section -->
<div class="homepage-shop-excollection-section">
  <div class="container">
    <div class="section-title-image">
      <img class="d-none d-md-block" src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/shop exclusive collections.png" alt="shop exclusive collections">
      <img class="d-md-none" src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/shop exclusive collections mobile.png" alt="shop exclusive collections">
    </div>
    <div class="nd19-section-subtitle my-4 hide-mobile shop-excollection-desc">Not ready to subscribe? Check out these amazing collections available through our <a href="<?php echo home_url('shop'); ?>">Shop!</a></div>
    <div class="nd19-block-content mt-3 show-mobile shop-excollection-desc text-center">Not ready to subscribe? Check out these amazing collections available through our <a href="<?php echo home_url('shop'); ?>">Shop!</a></div>
    <div class="owl-carousel shop-excollection-slider owl-nav-m-bottom mt-md-5 mt-3">
      <?php if(!empty($collections_products = get_field('select_collections_products'))):
        $shop_member = LGS_Products::lgs_is_shop_member();
        $cart_items = WC()->cart->get_cart_contents();
        $cart_product_ids = wp_list_pluck($cart_items, 'product_id');
        $total_item = 0;
        foreach($collections_products as $productID):

          if(false === ($product = wc_get_product($productID)) || !$product->is_visible()){
            continue;
          }

          if( !LGS_Products::lgs_product_enable($productID, $shop_member) ) {
            continue;
          }

          if (!$product->is_in_stock() || LGS_Products::lgs_pseudo_out_of_stock($productID)){
            continue;
          }

          $total_item++;

          $product_in_cart = in_array($productID, $cart_product_ids);
          $is_product_coming_soon = LGS_Products::is_product_coming_soon($productID);
          $product_coming_soon = $is_product_coming_soon['is_coming_soon'];
          $coomming_soon_text_badge = $is_product_coming_soon['text_badge'];
          $variable_product = ($product->get_type() == 'variable');

          $pink_price = $product->get_price();
          $compare_price = LGS_Products::lgs_get_compare_price($product, $shop_member);
          $gray_price = LGS_Products::lgs_get_product_price($product, !$shop_member);
          $gray_price = ($gray_price != $pink_price && !empty($gray_price))?$gray_price:0;
        ?>
        <div class="shop-excollection-slide woocommerce">
          <a href="<?php echo $product->get_permalink(); ?>">
            <div class="collection-image">
              <?php echo woocommerce_get_product_thumbnail();; ?>
            </div>
            <div class="collection-title">
              <?php echo $product->get_title();  ?>
            </div>
            <div class="collection-price">$<?php echo $pink_price; ?></div>
            <div class="collection-helper">
              <?php echo empty($gray_price) ? "&nbsp;" : ( ($shop_member ? 'NON-MEMBERS: ':'MEMBERS: ') . '$'.$gray_price ); ?>
            </div>
            <div class="collection-action">
              <?php if($product_coming_soon): ?>

                <button class="btn btn-primary"><?php echo $coomming_soon_text_badge; ?></button>

              <?php elseif( $variable_product):?>

                <button class="btn btn-primary">Select</button>

              <?php else: ?>

                <?php $args = array(
                  'class' => $product_in_cart ? ' button add_to_bag added' : ' button add_to_bag',
                  'attributes' => array(
                    'data-product_id' => $productID,
                    'data-product_sku' => $product->get_sku(),
                    'aria-label' => $product->add_to_cart_description(),
                    'rel' => 'nofollow'
                  ),
                ); ?>

                <?php $text_dk = $text_mb = '';

                  if($product_in_cart){
                    $text_dk = $text_mb = 'ADDED';
                  } else {
                    $text_dk = 'ADD TO BAG';
                    $text_mb = '<img src="'.get_stylesheet_directory_uri().'/assets/img/cart.png" alt=Add To Bag/> ADD';
                  }
                ?>

                <?php echo sprintf("<button data-quantity='1' class='btn btn-primary %s' %s><span class='hide-mobile'>%s</span><span class='show-mobile'>%s</span></button>", esc_attr($args['class']), isset($args['attributes'])?wc_implode_html_attributes($args['attributes']):'', esc_html($text_dk), $text_mb); ?>

              <?php endif; ?>
              <p class="view-details">VIEW DETAILS <span class="fas fa-chevron-right"></span></p>
            </div>
          </a>
        </div>
      <?php endforeach;
      endif;
      if( $total_item == 0 ){ ?>
        <style>
          .homepage-shop-excollection-section {
            display: none !important;
          }
        </style>
      <?php } ?>
    </div>
    <div class="section-cta"><a href="<?php echo home_url('shop'); ?>" class="btn-primary">Go to shop</a></div>
  </div>
</div>
<!-- End LiveGlamFam Section -->


  <!-- Start LiveGlamFam Section -->
  <div class="homepage-liveglamfam">
    <div class="container">
      <div class="section-sub-title nd19-section-subtitle d-desktop mb-0 d-block">Become a part of our</div>
      <div class="section-title nd19-section-title mb-5">#LiveGlamFam</div>
      <?php /** Get LiveGlamFam slider data */
      if ( !empty($liveglamfam_slider = get_field('liveglamfam_slider')) ): ?>
        <div class="hide-mobile">
          <div class="owl-carousel liveglamfam-slider owl-nav-m-bottom">
            <?php foreach ($liveglamfam_slider as $slide): ?>
              <div class="liveglamfam-slide">
                  <img class="review-image" src="<?php echo $slide['slide_image']?>" alt="<?php echo $slide['name']?> using <?php echo $slide['description']?>">
                <div class="liveglamfam-title">
                  <strong class="liveglamfam-name"><?php echo $slide['name']?></strong>
                  <span class="liveglamfam-counts">using</span>
                  <span class="liveglamfam-desc"><?php echo $slide['description']?></span>
                </div>
              </div>
            <?php endforeach; ?>
          </div>
        </div>
        <div class="show-mobile">
        <div class="owl-carousel liveglamfam-slider owl-nav-m-bottom">
          <?php $total = 12; foreach ($liveglamfam_slider as $slide): if($total <= 0) continue; $total--;  ?>
            <div class="liveglamfam-slide">
                <img class="review-image" src="<?php echo $slide['slide_image']?>" alt="<?php echo $slide['name']?> using <?php echo $slide['description']?>">
              <div class="liveglamfam-title">
                <strong class="liveglamfam-name"><?php echo $slide['name']?></strong>
                <span class="liveglamfam-counts">using</span>
                <span class="liveglamfam-desc"><?php echo $slide['description']?></span>
              </div>
            </div>
          <?php endforeach; ?>
        </div>
        </div>
      <?php endif; ?>
      <div class="section-cta"><a href="<?php echo home_url(PAGE_PRE_CHECKOUT); ?>" class="btn-primary">join the fam</a></div>
    </div>
  </div>
  <!-- End LiveGlamFam Section -->


<!-- Start Blog Section -->
<div class="homepage-blog">
  <div class="container">
    <div class="section-title nd19-section-title">From the Blog</div>
    <div class="section-sub-title nd19-section-subtitle d-desktop">Stay brushed up on the latest trends and everything LiveGlam!</div>
    <div class="owl-carousel blog-slider owl-nav-m-bottom">
      <?php /** Get Blog slider data */
      $args = array(
        'post_type' => 'post',
        'posts_per_page' => 12,
        'orderby' => 'date',
        'order' => 'DESC',
        'post_status' => 'publish'
      );
      $blog_query = new WP_Query($args);
      $all_blogs = array();
      if($blog_query->have_posts()) :
        while($blog_query->have_posts()) : $blog_query->the_post();
          $all_blogs[] = array(
            'image' => get_the_post_thumbnail_url(null, 'shop_catalog'),
            'categories' => get_the_category_list(', '),
            'title' => get_the_title(),
            'link' => esc_url(get_the_permalink())
          );
        endwhile;
        wp_reset_postdata();
      endif; ?>

      <?php foreach($all_blogs as $blog): ?>
      <div class="blog-slide">
        <a class="blog-image" href="<?php echo $blog['link']; ?>" title="<?php echo $blog['title']; ?>">
          <img src="<?php echo $blog['image']; ?>" alt="<?php echo $blog['title']; ?>">
        </a>
        <div class="blog-content">
          <div class="blog-category nd19-category-link hide-mobile"><?php echo $blog['categories']; ?></div>
          <div class="blog-title nd19-block-title-s"><?php echo $blog['title']; ?></div>
        </div>
      </div>
      <?php endforeach; ?>
    </div>
    <div class="section-cta"><a href="<?php echo site_url();?>/blog" class="btn-secondary">GO TO BLOG</a></div>
  </div>
</div>
<!-- End Blog Section -->


<!-- Start Testimonial Section -->
<div class="homepage-testimonial m-fixed-height">
  <div class="container">
    <div class="section-title nd19-section-title">Our Glammers love us</div>
    <div class="section-sub-title nd19-section-subtitle d-desktop">Don’t just take our word for it, here’s what our <strong>#LiveGlamFam</strong> has to say!</div>
    <div class="owl-carousel testimonial-slider owl-nav-m-bottom">
      <?php 
      $all_testimonials = liveglam_get_all_testimonials_by_termid(null, 12);
      foreach($all_testimonials as $testimonials): ?>
      <div class="testimonial-slide">
        <div class="image-group">
          <div class="image-back-white"></div>
          <div class="quote">“</div>
          <img src="<?php echo $testimonials['customer_images']; ?>" class="testimonial-image" alt="Testimonial from <?php echo $testimonials['name']; ?>">
        </div>
        <div class="testimonial-content">
          <div class="testimonial-title nd19-block-title-s"><?php echo $testimonials['name']; ?></div>
          <div class="testimonial-desc nd19-block-content-s">
            <?php echo strlen($testimonials['content']) > 200 ? substr($testimonials['content'], 0, 200).' ...' : $testimonials['content']; ?></div>
        </div>
        <div class="testimonial-social">
          <img src="<?php echo $testimonials['images_further']; ?>" alt="Testimonial from <?php echo $testimonials['name']; ?>">
          <span><?php echo $testimonials['name_handle']; ?></span>
        </div>
      </div>
      <?php endforeach; ?>
    </div>
    <div class="section-cta"><a href="<?php echo site_url();?>/reviews" class="btn-primary">Read more</a></div>
  </div>
</div>
<!-- End Testimonial Section -->

<!-- *** Hide For now *** -->
<!-- Start Instagram Section : From Member Perks -->
<!-- <div class="benefits-instagram m-fixed-height">
  <div>
    <div class="section-title nd19-section-title">Shop our Instagram</div>
    <p class="section-subtitle nd19-section-subtitle">Check Out Some of Our Fam Favorites</p>

    <?php /** Get Instagram image slider */
    if ($member_perks_id):
    $instagram_images = get_field('instagram_images', $member_perks_id);
    if ( !empty($instagram_images) ): ?>
        <div class="owl-carousel instagram-slider owl-nav-m-bottom">
            <?php foreach ($instagram_images as $slide): ?>
            <a href="<?php echo $slide['link']; ?>" target="_blank"><div class="slide"><img src="<?php echo $slide['image']; ?>" alt="Oops! No Image.."></div></a>
            <?php endforeach; ?>
        </div>
    <?php endif; endif; ?>
    <div class="section-cta"><a href="<?php echo site_url();?>/shop" class="btn-primary">Go to Shop</a></div>
  </div>
</div> -->
<!-- End Instagram Section : From Member Perks -->

<!-- Start Join now Section : From Member Perks -->
<div class="benefits-join-now m-fixed-height">
  <img class="subscribe-left-img hide-mobile" src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/subscribe-lippies.png" alt="KissMe lippies image" />
  <div class="subscribe-content">
    <div class="section-title nd19-block-title">Subscribe for more exclusive beauty products!</div>
    <p class="nd19-section-subtitle">Join our <strong>#LiveGlamFam</strong> and get new beauty products delivered straight to your door monthly.</p>
    <div class="section-cta d-desktop"><a href="<?php echo home_url(PAGE_PRE_CHECKOUT); ?>" class="btn-primary">Subscribe</a></div>
    <div class="section-cta d-mobile"><a href="<?php echo home_url(PAGE_PRE_CHECKOUT); ?>" class="btn-secondary">join now</a></div>
  </div>
  <img class="subscribe-right-img hide-mobile" src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/subscribe-brushes.png" alt="MorpheMe brushes image" />
</div>
<!-- End Join now Section : From Member Perks -->

<script type="text/javascript">
jQuery(document).ready(function () {
  
  /** Start owl-carousel Initiate */

  jQuery('.owl-carousel.review-slider').owlCarousel({
    dots: false,
    nav: true,
    responsive: {
      0: { loop: true, items:1, },
      768: { loop: true, items:3, }
    },
    navText: ["<img src='<?php echo get_stylesheet_directory_uri(); ?>/assets/img/arrow-grey-left@2x.png' alt='Previous'>",
              "<img src='<?php echo get_stylesheet_directory_uri(); ?>/assets/img/arrow-grey-right@2x.png' alt='Next'>"]
  });

  jQuery('.owl-carousel.club-slider').owlCarousel({
    margin: 30,
    nav: true,
    responsive: {
      0: { loop: true, items:1, startPosition: 1},
      768: { loop: false, items:3, dots: false, }
    },
    navText: ["<img src='<?php echo get_stylesheet_directory_uri(); ?>/assets/img/arrow-grey-left@2x.png' alt='Previous'>",
              "<img src='<?php echo get_stylesheet_directory_uri(); ?>/assets/img/arrow-grey-right@2x.png' alt='Next'>"]
  });

  jQuery('.owl-carousel.features-slider').owlCarousel({
    nav: true,
    responsive: {
      0: { loop: true, items: 1, },
      768: { loop: false, items:4, dots: false, }
    },
    navText: ["<img src='<?php echo get_stylesheet_directory_uri(); ?>/assets/img/arrow-grey-left@2x.png' alt='Previous'>",
              "<img src='<?php echo get_stylesheet_directory_uri(); ?>/assets/img/arrow-grey-right@2x.png' alt='Next'>"]
  });

  jQuery('.owl-carousel.shop-excollection-slider').owlCarousel({
    nav: true,
    margin: 40,
    responsive: {
      0: { items: 1, },
      768: { items: 3 },
      992: { items: 4 }
    },
    navText: ["<img src='<?php echo get_stylesheet_directory_uri(); ?>/assets/img/arrow-grey-left@2x.png' alt='Previous'>",
              "<img src='<?php echo get_stylesheet_directory_uri(); ?>/assets/img/arrow-grey-right@2x.png' alt='Next'>"]
  });

  jQuery('.owl-carousel.liveglamfam-slider').owlCarousel({
    loop: true,
    nav: true,
    responsive:{
      0: { items:1, margin: 14, stagePadding: 50, dotsEach: 1, settings: {rows: 2}},
      768: { items:4, margin: 30}
    },
    navText: ["<img src='<?php echo get_stylesheet_directory_uri(); ?>/assets/img/arrow-grey-left@2x.png' alt='Previous'>",
              "<img src='<?php echo get_stylesheet_directory_uri(); ?>/assets/img/arrow-grey-right@2x.png' alt='Next'>"]
  });

  jQuery('.owl-carousel.blog-slider').owlCarousel({
    loop: true,
    nav: true,
    margin: 20,
    responsive: {
      0: { items:1, },
      768: { items:3, }
    },
    navText: ["<img src='<?php echo get_stylesheet_directory_uri(); ?>/assets/img/arrow-white-left@2x.png' alt='Previous'>",
              "<img src='<?php echo get_stylesheet_directory_uri(); ?>/assets/img/arrow-white-right@2x.png' alt='Next'>"]
  });
 
  jQuery('.owl-carousel.testimonial-slider').owlCarousel({
    loop: true,
    nav: true,
    margin: 40,
    responsive: {
      0: { items:1, },
      768: { items:3, }
    },
    navText: ["<img src='<?php echo get_stylesheet_directory_uri(); ?>/assets/img/arrow-grey-left@2x.png' alt='Previous'>",
              "<img src='<?php echo get_stylesheet_directory_uri(); ?>/assets/img/arrow-grey-right@2x.png' alt='Next'>"]
  });

  // Init instagram image slider
  // jQuery('.instagram-slider').owlCarousel({
  //     loop: true,
  //     margin: 25,
  //     autoplay: true,
  //     autoplayHoverPause: true,
  //     responsive: {
  //         0: {
  //             items: 1,
  //             nav: true,
  //             dots: true
  //         },
  //         768: {
  //             items: 6,
  //             nav: false,
  //             dots: false,
  //         }
  //     },
  //     navText: ["<img src='/assets/img/arrow-white-left@2x.png' alt='Previous'>",
  //             "<img src='/assets/img/arrow-white-right@2x.png' alt='Next'>"]
  // });

  /** End owl-carousel Initiate */

  if(Cookies.get('_lgs_save_name_ref') == 'facebookfam'){
    jQuery('.referral_code_form.special-code-form').hide();
  }

  jQuery('.owl-carousel.alternative-items-slider').owlCarousel({
      navigation: true,
      items: 4,
      loop: false,
      nav: true,
      dots: false,
      navText: ["<img src='<?php echo get_stylesheet_directory_uri(); ?>/assets/img/arrow-grey-left@2x.png' alt='Previous'>",
          "<img src='<?php echo get_stylesheet_directory_uri(); ?>/assets/img/arrow-grey-right@2x.png' alt='Next'>"]
  });

  var alternativeData = <?php echo json_encode($alternative_data); ?>;
  jQuery('.owl-carousel.alternative-data-selected').owlCarousel({
      navigation: true,
      items: 1,
      loop: false,
      nav: true,
      dots: false,
      navText: false
  });

  jQuery(document).on('click', '.alternative-items .alternative-list-img', function() {
      if (!jQuery(this).hasClass('selected')) {
        jQuery('.alternative-items .alternative-list-img').removeClass('selected');
        jQuery(this).addClass('selected');
      }

      var selectedIdx = jQuery(this).data('index');
      var club = jQuery(this).data('club');
      jQuery('.alternative-items').data('selected', selectedIdx);
      jQuery('.owl-carousel.alternative-data-selected').trigger('to.owl.carousel', selectedIdx);
      jQuery('.alternative-select-collection .club-cta').attr('href',alternativeData[selectedIdx].link);
  });
  jQuery('.owl-carousel.alternative-data-selected').on('changed.owl.carousel', function(event) {
    jQuery('.alternative-items .alternative-list-img').eq(event.item.index).click();
    jQuery('.owl-carousel.alternative-items-slider').trigger('to.owl.carousel', Math.floor((event.item.index-8)/2+1));
  });

jQuery('.alternative-items .alternative-list-img').first().click();

});
</script>

<?php get_footer(); ?>