<?php
  /**
   * The template for displaying product content in the single-product.php template
   *
   * This template can be overridden by copying it to yourtheme/woocommerce/content-single-product.php.
   *
   * HOWEVER, on occasion WooCommerce will need to update template files and you
   * (the theme developer) will need to copy the new files to your theme to
   * maintain compatibility. We try to do this as little as possible, but it does
   * happen. When this occurs the version of the template file will be bumped and
   * the readme will list any important changes.
   *
   * @see      https://docs.woocommerce.com/document/template-structure/
   * @package  WooCommerce/Templates
   * @version 3.6.0
   */

  if(!defined('ABSPATH')){
    exit;
  }
  global $product;
  global $previous_post, $next_post;
  global $subsStatus;

  /**
   * Hook Woocommerce_before_single_product.
   *
   * @hooked wc_print_notices - 10
   */
  do_action('woocommerce_before_single_product');

  if(post_password_required()){
    echo get_the_password_form(); // WPCS: XSS ok.
    return;
  }
  global $average, $total_average, $total_reviews, $total_comemnts, $product_visibility, $is_shop_member, $lgs_pseudo_out_of_stock, $is_in_stock;
  $class = is_user_logged_in()?'':'container shop-container';
  $productID = get_the_ID();

  $collection_name = get_post_meta($productID, 'collection_name', true);
  $product_title = get_the_title();
  $product_desc = $product->get_short_description();

  $show_upsell_subscription = false;
  if(get_field('show_upsell_subscription', $productID) && $is_in_stock && !$lgs_pseudo_out_of_stock && !in_array($subsStatus['get_status_kissme'], LiveGlam_Subscription_Status::$in_status)){
    $show_upsell_subscription = true;

    $upsell_subscription_type = get_post_meta($productID, 'upsell_subscription_type', true);
    $upsell_subscription_type = !empty($upsell_subscription_type) ? $upsell_subscription_type : 'km';

    if($upsell_subscription_type == 'mm'){
      $product_ml = MM_MONTHLY; $price_ml = MM_MONTHLY_PRICE;
      $product_sm = MM_SIXMONTH; $price_sm = MM_SIXMONTH_PRICE;
      $product_an = MM_ANNUAL; $price_an = MM_ANNUAL_PRICE;
      $title_default = 'SUBSCRIBE TO MORPHEME & GET THIS COLLECTION';
      $subtitle_default = 'Get 3-8 Morphe brushes every month. Skip, trade or cancel anytime.';
      $button_default = 'Subscribe & save';
    } elseif($upsell_subscription_type == 'sm') {
      $product_ml = SM_MONTHLY; $price_ml = SM_MONTHLY_PRICE;
      $product_sm = SM_SIXMONTH; $price_sm = SM_SIXMONTH_PRICE;
      $product_an = SM_ANNUAL; $price_an = SM_ANNUAL_PRICE;
      $title_default = 'SUBSCRIBE TO SHADOWME & GET THIS COLLECTION';
      $subtitle_default = 'Get new shadows every 2 months. Skip, trade or cancel anytime.';
      $button_default = 'Subscribe & save';
    } else {
      $product_ml = KM_MONTHLY; $price_ml = KM_MONTHLY_PRICE;
      $product_sm = KM_SIXMONTH; $price_sm = KM_SIXMONTH_PRICE;
      $product_an = KM_ANNUAL; $price_an = KM_ANNUAL_PRICE;
      $title_default = 'SUBSCRIBE TO KISSME & GET THIS COLLECTION';
      $subtitle_default = 'Get 3 lippies every month. Skip, trade or cancel anytime.';
      $button_default = 'Subscribe & save';
    }

    $upsell_subscription_title = get_post_meta($productID, 'upsell_subscription_title', true);
    $upsell_subscription_title = !empty($upsell_subscription_title) ? $upsell_subscription_title : $title_default;

    $upsell_subscription_subtitle = get_post_meta($productID, 'upsell_subscription_subtitle', true);
    $upsell_subscription_subtitle = !empty($upsell_subscription_subtitle) ? $upsell_subscription_subtitle : $subtitle_default;

    $upsell_subscription_description = get_post_meta($productID, 'upsell_subscription_description', true);

    $upsell_subscription_button = get_post_meta($productID, 'upsell_subscription_button', true);
    $upsell_subscription_button = !empty($upsell_subscription_button) ? $upsell_subscription_button : $button_default;
  }
?>
<div id="product-<?php echo $productID; ?>" <?php post_class(); ?>>

  <div class="product-details-new show-mobile">
    <div class="container shop-container">

      <?php if(!empty($collection_name)){
        echo "<p class='single-collection-title'>".$collection_name."</p>";
      }
        echo '<h1 class="product_title entry-title">'.$product_title.'</h1>';

        if(!empty(trim($product_desc))){
          echo '<p class="product-description">'.$product_desc.'</p>';
        }
      ?>

    </div>
  </div>

  <div class="product-details">
    <?php if (!is_user_logged_in()): ?>
    <div class="nav-product hide-mobile">
      <div class="nav-arrow prev">
        <?php if(false !== $previous_post): ?>
          <a href="<?php echo get_the_permalink($previous_post); ?>">
            <div class="single-popover popover-prev fa">
              <div class="popover-container">
                <div class="content-popover">
                  <?php if(false && !empty($collection_name = get_post_meta($previous_post, 'collection_name', true))){ ?>
                    <p class='popover-container-collection collection-prev text-left'><?php echo $collection_name; ?></p>
                  <?php } ?>
                  <p class="popover-container-title title-prev text-left"><?php echo get_the_title($previous_post); ?></p>
                </div>
              </div>
            </div>
            <?php echo "<img src='".get_the_post_thumbnail_url($previous_post,array(100,100))."' alt='Previous Product' />"; ?>
          </a>
        <?php endif; ?>
      </div>
      <div class="nav-arrow next">
        <?php if(false !== $next_post): ?>
          <a href="<?php echo get_the_permalink($next_post); ?>">
            <?php echo "<img src='".get_the_post_thumbnail_url($next_post,array(100,100))."' alt='Next Product' />"; ?>
            <div class="single-popover popover-next fa">
              <div class="popover-container">
                <div class="content-popover">
                  <?php if(false && !empty($collection_name = get_post_meta($next_post, 'collection_name', true))){ ?>
                    <p class='popover-container-collection collection-next text-right'><?php echo $collection_name; ?></p>
                  <?php } ?>
                  <p class="popover-container-title title-next text-right"><?php echo get_the_title($next_post); ?></p>
                </div>
              </div>
            </div>
          </a>
        <?php endif; ?>
      </div>
    </div>
    <?php endif; ?>

    <div class="wrap <?php echo $class; ?>">

      <?php
        /**
         * Hook: woocommerce_before_single_product_summary.
         *
         * @hooked woocommerce_show_product_sale_flash - 10
         * @hooked woocommerce_show_product_images - 20
         */
        do_action('woocommerce_before_single_product_summary');
      ?>

      <div class="summary entry-summary">

        <div class="single-product-details">
          <?php if(!empty($collection_name)){
            echo "<p class='single-collection-title hide-mobile'>".$collection_name."</p>";
          }
            echo '<h1 class="product_title entry-title hide-mobile">'.$product_title.'</h1>';

            if(!empty(trim($product_desc))){
             echo '<p class="product-description hide-mobile">'.$product_desc.'</p>';
            }

          if($total_reviews || $average) {?>
          <div class="product-review">
            <?php if($total_reviews){
              echo "<p class='single-review-total'><a href='#product-data-reviews' class='scroll-element'>";
              printf(esc_html(_n('%1$s Review', '%1$s Reviews', $total_reviews, 'woocommerce')), esc_html($total_reviews));
              echo "</a></p>";
            } ?>

            <?php if($average){ echo lgs_heart_rating($average); } ?>
          </div>
          <?php } ?>
        </div>

        <?php if(!empty($total_product_description = get_post_meta($productID, 'product_description', true)) || $total_reviews > 0): ?>

          <div class="single-product-rating">

            <?php if($show_upsell_subscription){ ?>
              <p class="product-breakdown">Collection Breakdown
                <a href="#" class="breakdown-action breakdown-show">
                  <span class="br-show">View<img alt="Arrow down" src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/arrow-gray-down.png"></span>
                  <span class="br-hide">Hide<img alt="Arrow up" src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/arrow-gray-up.png"</span>
                </a>
              </p>
              <div class="product-breakdown-content" style="display: none">
            <?php } ?>

            <?php for($i = 0; $i, $i < $total_product_description; $i++): ?>

              <p class="product_description-item"><?php echo get_post_meta($productID, 'product_description_'.$i.'_description_title', true); ?>:
                <span><?php echo get_post_meta($productID, 'product_description_'.$i.'_description_content', true); ?></span>
              </p>

            <?php endfor; ?>

            <?php if( !empty( $attributes = array_filter( $product->get_attributes(), 'wc_attributes_array_filter_visible' ) ) ){

              foreach ( $attributes as $attribute ) {
                $values = array();

                if ( $attribute->is_taxonomy() ) {
                  $attribute_taxonomy = $attribute->get_taxonomy_object();
                  $attribute_values   = wc_get_product_terms( $product->get_id(), $attribute->get_name(), array( 'fields' => 'all' ) );

                  foreach ( $attribute_values as $attribute_value ) {
                    $value_name = esc_html( $attribute_value->name );

                    if ( $attribute_taxonomy->attribute_public ) {
                      $values[] = '<a href="' . esc_url( get_term_link( $attribute_value->term_id, $attribute->get_name() ) ) . '" rel="tag">' . $value_name . '</a>';
                    } else {
                      $values[] = $value_name;
                    }
                  }
                } else {
                  $values = $attribute->get_options();

                  foreach ( $values as &$value ) {
                    $value = make_clickable( esc_html( $value ) );
                  }
                }

                $product_attributes[ 'attribute_' . sanitize_title_with_dashes( $attribute->get_name() ) ] = array(
                  'label' => wc_attribute_label( $attribute->get_name() ),
                  'value' => implode( ', ', $values ),
                );
              }
              $product_attributes = apply_filters( 'woocommerce_display_product_attributes', $product_attributes, $product );

              foreach( $product_attributes as $key => $product_attribute ){ ?>
                <p class="product_description-item"><?php echo $product_attribute['label']; ?>:
                  <span><?php echo $product_attribute['value']; ?></span>
                </p>
              <?php }
            } ?>

            <?php if($show_upsell_subscription){ ?>
              </div>
            <?php } ?>

          </div>

        <?php endif; ?>

        <?php if($product->get_type() == 'variable'){ ?>
          <div class="single-product-rating variable-product-rating" style="display: none"></div>
        <?php } ?>

        <?php if($show_upsell_subscription){ ?>
          <div class="single-product-collection">
            <div class="product-collection">
              <p class="product-collection-title"><?php echo $upsell_subscription_title; ?></p>
              <div class="hide-mobile">
                <p class="product-collection-desc plan-price plan-<?php echo $product_ml; ?>"><span class="woocommerce-Price-amount amount"><span class="woocommerce-Price-currencySymbol">$</span>&nbsp;<?php echo $price_ml; ?></span></p>
                <p class="product-collection-desc plan-price plan-<?php echo $product_sm; ?> d-none"><span class="woocommerce-Price-amount amount"><span class="woocommerce-Price-currencySymbol">$</span>&nbsp;<?php echo $price_sm; ?></span></p>
                <p class="product-collection-desc plan-price plan-<?php echo $product_an; ?> d-none"><span class="woocommerce-Price-amount amount"><span class="woocommerce-Price-currencySymbol">$</span>&nbsp;<?php echo $price_an; ?></span></p>
              </div>
            </div>
            <p class="product-collection-subtitle"><?php echo $upsell_subscription_subtitle; ?></p>
            <div class="product-collection-action">
              <div class="product-collection-left">
                <label class="d-none" for="single-select-plan">&nbsp;</label>
                <select id="single-select-plan" name="select-plan" class="selectpicker">
                  <option value="<?php echo $product_ml; ?>" selected="selected">Monthly Plan</option>
                  <option value="<?php echo $product_sm; ?>">6 Months Plan</option>
                  <option value="<?php echo $product_an; ?>">Annual Plan</option>
                </select>
                <div class="show-mobile">
                  <p class="product-collection-desc plan-price plan-<?php echo $product_ml; ?>"><span class="woocommerce-Price-amount amount"><span class="woocommerce-Price-currencySymbol">$</span>&nbsp;<?php echo $price_ml; ?></span></p>
                  <p class="product-collection-desc plan-price plan-<?php echo $product_sm; ?> d-none"><span class="woocommerce-Price-amount amount"><span class="woocommerce-Price-currencySymbol">$</span>&nbsp;<?php echo $price_sm; ?></span></p>
                  <p class="product-collection-desc plan-price plan-<?php echo $product_an; ?> d-none"><span class="woocommerce-Price-amount amount"><span class="woocommerce-Price-currencySymbol">$</span>&nbsp;<?php echo $price_an; ?></span></p>
                </div>
              </div>
              <div class="product-collection-right">
                <button class="btn-primary btn-block subscriber_save <?php echo $upsell_subscription_type; ?>"><?php echo $upsell_subscription_button; ?></button>
              </div>
            </div>
            <?php if(!empty($upsell_subscription_description)){ ?>
              <p class="product-collection-notice"><?php echo $upsell_subscription_description; ?></p>
            <?php } ?>
          </div>
        <?php } ?>

        <div class="single-product-actions">
          <?php if($is_shop_member && $product_visibility == 'non_member'){ ?>

            <p class="stock out-of-stock"><?php esc_html_e( "Sorry! You can not purchase this product as its for non members only.", 'woocommerce-subscriptions' ); ?></p>

          <?php }elseif(!$is_shop_member && $product_visibility == 'member'){ ?>

            <p class="stock out-of-stock"><?php esc_html_e( "Sorry! You can not purchase this product as its for members only.", 'woocommerce-subscriptions' ); ?></p>

          <?php }else{ ?>

            <?php woocommerce_template_single_add_to_cart(); ?>

          <?php } ?>
        </div>

        <?php if(!is_user_logged_in() && $is_in_stock && !$lgs_pseudo_out_of_stock){
          $member_price = LGS_Products::lgs_get_product_price($product, true);
          $nonmember_price = LGS_Products::lgs_get_product_price($product, false);
          $compare_price = LGS_Products::lgs_get_compare_price($product, $is_shop_member);
          if($member_price != $nonmember_price && !empty($member_price) && !empty($nonmember_price)){ ?>
            <div class="single-product-login single-product-actions">
              <div class="product-sotp second-block">
                <p class="product-sotp-title">MEMBER SHOP PURCHASE</p>
                <p class="product-sotp-desc hide-mobile">
                    <span><?php echo wc_price($member_price); ?></span>
                    <?php if(!empty($compare_price)): ?>
                        <span class="compare-price"><?php echo wc_price($compare_price); ?></span>
                    <?php endif; ?>
                </p>
              </div>
              <div class="product-login-content">
                <div class="product-login-left">
                  <p class="product-login-text">Log in and get your special pricing!</p>
                </div>
                <p class="product-sotp-desc show-mobile single-action">
                    <span><?php echo wc_price($member_price); ?></span>
                    <?php if(!empty($compare_price)): ?>
                      <span class="compare-price"><?php echo wc_price($compare_price); ?></span>
                    <?php endif; ?>
                </p>
                <div class="product-login-right">
                  <a href="#" class="simplemodal-login">
                    <button class="product-login-button btn-secondary btn-block btn-solid">LOG IN</button>
                  </a>
                  <p class="product-sotp-subtitle">Shipping & taxes calculated at checkout.</p>
                </div>
              </div>
            </div>
          <?php } ?>
        <?php } ?>

      </div>
    </div>
  </div>

  <div class="product-wyl">
    <div class="wrap <?php echo $class; ?>">
      <div class="row">
        <div class="col-lg-6">
          <div class="pwyl pwyl-content pwyl-left">
            <div class="lg_product_short_description">
            <?php the_content(); ?>
            </div>
            <?php if($product->get_type() == 'variable'){ ?>
              <div class="lg_variable_short_description"></div>
            <?php } ?>
          </div>
        </div>
        <div class="col-lg-6 pwyl-content pwyl-right">
          <?php $key_title = get_post_meta($productID, 'product_key_title', true);
            $key_description = get_post_meta($productID, 'product_key_description', true);
            if(!empty($key_title) && !empty($key_description)){ ?>
              <div class="product_key">
                <p class="product_key_title pwyl-product-title"><?php echo $key_title; ?></p>
                <p class="product_key_description"><?php echo $key_description; ?></p>
              </div>
            <?php }
            //product also:
            if(!empty($product_also_tags = get_post_meta($productID, 'product_also_tags', true))): ?>

              <div class="product_also">

                <p class="product_also_title pwyl-product-title"><?php echo !empty($pa_title = get_post_meta($productID, 'product_also_title', true))?$pa_title:"This product is also:"; ?></p>

                <div class="product_also_tags">

                  <?php for($i = 0; $i < $product_also_tags; $i++): ?>

                    <span class="tag-item"><?php echo get_post_meta($productID, 'product_also_tags_'.$i.'_tag_name', true); ?></span>

                  <?php endfor; ?>

                </div>

              </div>

            <?php endif; ?>

        </div>
      </div>
    </div>
  </div>

  <?php if($total_comemnts > 0): ?>
    <div class="product-data" id="product-data-reviews">
      <div class="wrap <?php echo $class; ?>">
        <div class="woocommerce-comments">
          <p class="review-header">Reviews</p>
          <div class="comments-header">
            <div class="comment-header-list">
              <div class="comment-header-item comment-header-left">
                <p class="general-rating">General Rating</p>
                <?php echo lgs_heart_rating($average); ?>
                <p class="comment-header-count"><?php echo $average; ?> | <?php printf(esc_html(_n('%1$s review', '%1$s reviews', $total_reviews, 'woocommerce')), esc_html($total_reviews)); ?></p>
              </div>
              <div class="comment-header-item comment-header-center">
                <div class="comment-count">
                  <div class="newdesign-heart-rating">
                    <span class="fas fa-heart"></span>
                    <span class="fas fa-heart"></span>
                    <span class="fas fa-heart"></span>
                    <span class="fas fa-heart"></span>
                    <span class="fas fa-heart"></span>
                  </div>
                  <?php echo $total_average['5']; ?>
                </div>
                <div class="comment-count">
                  <div class="newdesign-heart-rating">
                    <span class="fas fa-heart"></span>
                    <span class="fas fa-heart"></span>
                    <span class="fas fa-heart"></span>
                    <span class="fas fa-heart"></span>
                    <span class="far fa-heart"></span>
                  </div>
                  <?php echo $total_average['4']; ?>
                </div>
                <div class="comment-count">
                  <div class="newdesign-heart-rating">
                    <span class="fas fa-heart"></span>
                    <span class="fas fa-heart"></span>
                    <span class="fas fa-heart"></span>
                    <span class="far fa-heart"></span>
                    <span class="far fa-heart"></span>
                  </div>
                  <?php echo $total_average['3']; ?>
                </div>
                <div class="comment-count">
                  <div class="newdesign-heart-rating">
                    <span class="fas fa-heart"></span>
                    <span class="fas fa-heart"></span>
                    <span class="far fa-heart"></span>
                    <span class="far fa-heart"></span>
                    <span class="far fa-heart"></span>
                  </div>
                  <?php echo $total_average['2']; ?>
                </div>
                <div class="comment-count">
                  <div class="newdesign-heart-rating">
                    <span class="fas fa-heart"></span>
                    <span class="far fa-heart"></span>
                    <span class="far fa-heart"></span>
                    <span class="far fa-heart"></span>
                    <span class="far fa-heart"></span>
                  </div>
                  <?php echo $total_average['1']; ?>
                </div>
              </div>
              <!-- <div class="comment-header-item comment-header-right text-center" style="display: none;">
                <p class="title-htproduct">Have this product?</p>
                <a href="#">
                  <button class="btn btn-primary btn-vw">WRITE A REVIEW</button>
                </a>
              </div> -->
            </div>
          </div>
          <div class="comments-footer">
            <div class="comments-commentlist">
              <?php
                LGS_Products::lgs_product_show_comment_html($product->get_id());
              ?>
            </div>
            <div class="pg-nav newdesign-pagination">
              <nav class="text-center" aria-label="Page navigation">
                <ul class="pagination" id="pagination-comments"></ul>
              </nav>
            </div>
          </div>
        </div>
      </div>
    </div>
  <?php endif; ?>

  <!-- Start LiveGlamFam Section -->
  <div class="homepage-liveglamfam">
    <div class="wrap <?php echo $class; ?>">
      <div class="skew-bg"><div class="liveglamfam-title">
        <div class="text nd19-block-content">Become a part of our</div>
        <div class="nd19-section-title">#<strong>LiveGlamFam</strong></div>
      </div></div>
      <?php /** Get LiveGlamFam slider data */
        if ( !empty($liveglamfam_slider = get_field('liveglamfam_slider', get_option('page_on_front'))) ): ?>
          <div class="owl-carousel liveglamfam-slider">
            <?php foreach ($liveglamfam_slider as $slide): ?>
              <div class="liveglamfam-slide">
                <img class="review-image" src="<?php echo $slide['slide_image']?>" alt="<?php echo $slide['name']?>">
                <div class="liveglamfam-title">
                  <strong class="liveglamfam-name"><?php echo $slide['name']?></strong>
                  <span class="liveglamfam-counts">using</span>
                  <span class="liveglamfam-desc"><?php echo $slide['description']?></span>
                </div>
              </div>
            <?php endforeach; ?>
          </div>
        <?php endif; ?>
    </div>
  </div>
  <!-- End LiveGlamFam Section -->
  <?php do_action( 'woocommerce_single_product_summary' );?>
  <div class="product-related">
    <div class="wrap <?php echo $class; ?>">
      <?php
        remove_action('woocommerce_after_single_product_summary', 'woocommerce_output_product_data_tabs', 10);
        remove_action('woocommerce_after_single_product_summary', 'woocommerce_upsell_display', 15);
        /**
         * Hook: woocommerce_after_single_product_summary.
         *
         * @hooked woocommerce_output_product_data_tabs - 10
         * @hooked woocommerce_upsell_display - 15
         * @hooked woocommerce_output_related_products - 20
         */
        do_action('woocommerce_after_single_product_summary');
      ?>
    </div>
  </div>
</div>

<?php do_action('woocommerce_after_single_product'); ?>

<script>
jQuery(document).ready(function($) {
  $(window).load(function() {
    $('.woocommerce-product-gallery ol').addClass('owl-carousel');
    $('.woocommerce-product-gallery ol').owlCarousel({
      loop: false,
      nav: true,
      dots: false,
      items:4,
      navText: ['<span class="single-product-img single-product-left"></span>', '<span class="single-product-img single-product-right"></span>']
    });

  });
});
</script>