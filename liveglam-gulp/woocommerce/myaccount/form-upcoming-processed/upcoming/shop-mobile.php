<?php
  /**
   * Form Upcoming Shop Mobile
   */

  if ( ! defined( 'ABSPATH' ) ) {
    exit;
  }

?>

<div class="liveglam-order-item liveglam-shop">
  <div class="order-item-content order-item-shop">
    <div class="item-shop vertical-center">
      <p class="shop-title">New on Shop!</p>
      <p class="shop-desc">Members get special pricing!</p>
      <?php if(isset($list_shop_images) && !empty($list_shop_images)){ ?>
        <div class="shop-list shop-list-carousel owl-carousel owl-theme">
          <?php foreach($list_shop_images as $list_shop_image){ ?>
            <div class="shop-list-item">
              <img alt="Shop Image" src="<?php echo $list_shop_image; ?>"/>
              <div class="shop-new-action">
                <a href="<?php echo home_url('/shop'); ?>">
                  <button class="btn btn-secondary btn-block btn-solid transparent btn-sm btn-vw condensed">
                    Shop Now
                  </button>
                </a>
              </div>
            </div>
          <?php } ?>
        </div>
      <?php } ?>
    </div>
  </div>
</div>
