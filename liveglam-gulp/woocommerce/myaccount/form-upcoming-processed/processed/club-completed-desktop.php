<?php
  /**
   * Form Processed CLub Completed Desktop
   */

  if ( ! defined( 'ABSPATH' ) ) {
    exit;
  }

?>

<?php if(!$order_has_delivered){ ?>

  <div class="lgs-data-info">
    <p class="lgdi-title">Latest Order</p>
    <div class="lgdi-item">
      <div class="lgdi-item-content">
        <div class="item-header">
          <p class="item-header-title flcenter">Shipped On:<span><?php echo $ship_date; ?></span></p>
        </div>
        <div class="item-content content-single">
          <div class="single-list">
            <?php foreach($data_items as $data_item){ ?>
              <div class="data-item <?php echo (count($data_items) > 1 && $data_item['item_type'] == 'item-parent')?'border-bottom':''; ?>">
                <div class="data-item-left">
                  <img src="<?php echo $data_item['image']; ?>" alt="<?php echo $data_item['title']; ?>"/>
                </div>
                <div class="data-item-right">
                  <p class="title <?php if($data_item['trade'] == 1 || $data_item['item_type'] == 'item-free'){ ?>traded<?php } ?>">
                    <?php echo $data_item['title']; ?>
                    <?php if($data_item['trade'] == 1){ ?><span class="traded-badge">Traded</span><?php } ?>
                    <?php if($data_item['item_type'] == 'item-free'){ ?><span class="traded-badge">Free</span><?php } ?>
                  </p>
                  <?php if($data_item['option_rating']){ ?>
                    <p class="rating"><i class="fas fa-heart"></i>Rating available soon</p>
                  <?php }else{ ?>
                    <p class="desc <?php if($data_item['trade'] == 1 || $data_item['item_type'] == 'item-free'){ ?>traded<?php } ?>"><?php echo $data_item['desc']; ?></p>
                  <?php } ?>
                </div>
              </div>
            <?php } ?>
          </div>
        </div>
        <div class="item-footer footer-single">
          <div class="order-notice">
            <p>We hope you love your new goodies! Use #LiveGlamFam for a chance to get featured.</p>
          </div>
        </div>
      </div>
      <div class="lgdi-item-action">
        <?php if( !empty($data_sub['button']['show_rate']) ){ ?>
          <a class="lgdi-action multi-action rate_<?php echo $club; ?>">
            <button class="btn btn-secondary btn-solid btn-block condensed">
              <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/icon-mc-heart-pink.png" alt="Icon Heart" />
              Rate Products
            </button>
          </a>
        <?php } else { ?>
          <a class="lgdi-action multi-action view_order" data-id="<?php echo $data_sub['subscription']['ID']; ?>" data-edit="view-order" data-type="<?php echo $club; ?>">
            <button class="btn btn-secondary btn-solid btn-block condensed">
              <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/icon-mc-box-pink.png" alt="Icon Box" />
              View Past Orders
            </button>
          </a>
        <?php } ?>
        <?php if( !empty($track_link) ){ ?>
          <a href="<?php echo $track_link; ?>" target="_blank" class="lgdi-action multi-action">
            <button class="btn btn-primary btn-solid btn-block condensed">
              <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/icon-mc-track-white.png" alt="Icon Track" />
              Track My Package
            </button>
          </a>
        <?php } ?>
      </div>
    </div>
  </div>

<?php } else { ?>

  <div class="lgs-data-info">
    <p class="lgdi-title">Latest Order</p>
    <div class="lgdi-item">
      <div class="lgdi-item-content">
        <div class="item-header">
          <p class="item-header-title">Click the hearts to rate & earn points:</p>
        </div>
        <div class="item-content content-single">
          <div class="single-list">
            <?php foreach($data_items as $data_item){ ?>
              <div class="data-item <?php echo (count($data_items) > 1 && $data_item['item_type'] == 'item-parent')?'border-bottom':''; ?>">
                <div class="data-item-left">
                  <img src="<?php echo $data_item['image']; ?>" alt="<?php echo $data_item['title']; ?>"/>
                </div>
                <div class="data-item-right">
                  <p class="title <?php if($data_item['trade'] == 1 || $data_item['item_type'] == 'item-free'){ ?>traded<?php } ?>">
                    <?php echo $data_item['title']; ?>
                    <?php if($data_item['trade'] == 1){ ?><span class="traded-badge">Traded</span><?php } ?>
                    <?php if($data_item['item_type'] == 'item-free'){ ?><span class="traded-badge">Free</span><?php } ?>
                  </p>
                  <?php if($data_item['option_rating']){ ?>
                    <p class="my-rating">My Rate:
                      <?php if(!$has_rating_order && !empty($data_sub['button']['show_rate'])){ ?><a href="#" class="rate_<?php echo $club; ?>"><?php } ?>
                        <span class="rate <?php echo !$has_rating_order?'available':''; ?>">
                                        <?php for($i = 0; $i < 5; $i++){ ?>
                                          <?php if($i < $data_item['rate_star']){ ?>
                                            <i class="fas fa-heart active" data-num="<?php echo $i+1; ?>"></i>
                                          <?php }else{ ?>
                                            <i class="fas fa-heart" data-num="<?php echo $i+1; ?>"></i>
                                          <?php } ?>
                                        <?php } ?>
                                      </span>
                        <?php if(!$has_rating_order && !empty($data_sub['button']['show_rate'])){ ?></a><?php } ?>
                    </p>
                  <?php }else{ ?>
                    <p class="desc <?php if($data_item['trade'] == 1 || $data_item['item_type'] == 'item-free'){ ?>traded<?php } ?>"><?php echo $data_item['desc']; ?></p>
                  <?php } ?>
                </div>
              </div>
            <?php } ?>
          </div>
          <?php if($has_rating_order && !empty($data_sub['button']['show_rate'])){ ?>
            <div class="single-list">
              <a class="rate_<?php echo $club; ?>">
                <button class="btn btn-secondary btn-block condensed btn-solid btn-vw btn-sm">Rate Past Collections</button>
              </a>
            </div>
          <?php } ?>
        </div>
      </div>
      <div class="lgdi-item-action">
        <a class="lgdi-action multi-action view_order" data-id="<?php echo $data_sub['subscription']['ID']; ?>" data-edit="view-order" data-type="<?php echo $club; ?>">
          <button class="btn btn-secondary btn-block btn-solid condensed">
            <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/icon-mc-box-pink.png" alt="Icon Box" />
            View Past Orders
          </button>
        </a>
        <?php if(!$has_rating_order && !empty($data_sub['button']['show_rate'])){ ?>
          <a class="lgdi-action multi-action rate_<?php echo $club; ?>">
            <button class="btn btn-primary btn-block btn-solid condensed">
              <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/icon-mc-heart-white.png" alt="Icon Heart" />
              Rate Products
            </button>
          </a>
        <?php } else { ?>
          <a class="lgdi-action multi-action" href="<?php echo home_url('/shop'); ?>">
            <button class="btn btn-primary btn-block btn-solid condensed">
              <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/icon-shop-white.png" alt="Icon Shop" />
              View Shop
            </button>
          </a>
        <?php } ?>
      </div>
    </div>
  </div>

<?php } ?>