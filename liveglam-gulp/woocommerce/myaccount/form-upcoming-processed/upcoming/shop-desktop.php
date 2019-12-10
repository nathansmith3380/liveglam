<?php
  /**
   * Form Upcoming Shop Desktop
   */

  if ( ! defined( 'ABSPATH' ) ) {
    exit;
  }

?>

<div class="lgs-data-info">
  <p class="lgdi-title"><?php echo $total_products; ?> ITEMS ON SHOP</p>
  <div class="lgdi-item">
    <div class="lgdi-item-content extra-height">
      <div class="item-shop">
        <p class="shop-title">New on Shop!</p>
        <p class="shop-desc">Members get special pricing!</p>
        <?php if(isset($list_shop_images) && !empty($list_shop_images)){ ?>
          <div class="shop-list shop-list-carousel owl-carousel owl-theme">
            <?php foreach($list_shop_images as $list_shop_image){ ?>
              <div class="shop-list-item">
                <img alt="Shop Image" src="<?php echo $list_shop_image; ?>"/>
              </div>
            <?php } ?>
          </div>
          <div class="skip-waitlist-action">
            <a href="<?php echo home_url('/shop'); ?>">
              <button class="btn btn-secondary btn-block btn-solid transparent btn-sm btn-vw condensed">
                Shop Now
              </button>
            </a>
          </div>
        <?php } ?>
      </div>
    </div>
  </div>
</div>
