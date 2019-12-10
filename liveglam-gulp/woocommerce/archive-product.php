<?php
  /**
   * The Template for displaying product archives, including the main shop page which is a post type archive
   *
   * This template can be overridden by copying it to yourtheme/woocommerce/archive-product.php.
   *
   * HOWEVER, on occasion WooCommerce will need to update template files and you
   * (the theme developer) will need to copy the new files to your theme to
   * maintain compatibility. We try to do this as little as possible, but it does
   * happen. When this occurs the version of the template file will be bumped and
   * the readme will list any important changes.
   *
   * @see      https://docs.woocommerce.com/document/template-structure/
   * @package  WooCommerce/Templates
   * @version 3.4.0
   */

  if(!defined('ABSPATH')){
    exit; // Exit if accessed directly
  }
  get_header();

  $is_product_category = false;
  if(is_product_category()){
    $term = get_term_by( 'slug', get_query_var( 'term' ), 'product_cat' );
    if($term->term_id == SHOP_CAT || term_is_ancestor_of(SHOP_CAT, $term->term_id, 'product_cat')){
      $is_product_category = true;
    }
  }

  $is_loggin = is_user_logged_in();
  $color_filter = LGS_Products::lgs_shop_filter_color();
  $date_filter = LGS_Products::lgs_shop_filter_date();
  $stock_filter = LGS_Products::lgs_shop_filter_stock();
  $shop_slider = LGS_Products::lgs_shop_slider();
  $cart_items = WC()->cart->get_cart_contents();
  $cart_product_ids = wp_list_pluck($cart_items, 'product_id');
  $current_time = current_time('timestamp');
  $shop_member = LGS_Products::lgs_is_shop_member();
  global $LG_userData, $LG_userAvata;
  global $total_list_individual; ?>

<?php if($is_loggin): ?>
<div class="wc-dashboard-content">
<div class="dashboard-content dashboard-rewards">
  <div id="scroller-anchor"></div>
  <?php //echo do_shortcode('[lgs_holiday_countdown_landing]'); ?>
  <div class="wrap hide-mobile">
    <div class="dashboard-header-content">
      <p class="title-page">Shop LiveGlam</p>
      <?php show_dashboard_header_right(); ?>
    </div>
  </div>

  <div id="lg-search-overlay"><?php show_general_search_content(); ?></div>

  <div class="nav hide-mobile">
    <div class="wrap">
      <ul class="nav-left dashboard-menu-nav">
        <li class="active"><a href="#">Shop</a></li>
      </ul>
      <div class="nav-right"></div>
    </div>
  </div>

  <?php echo do_shortcode('[show_notice_subscribers]'); ?>

  <?php else: ?>
  <?php //echo do_shortcode('[lgs_holiday_countdown_landing]'); ?>
  <?php endif; ?>

  <?php if(!empty($shop_slider)){ ?>
    <div class="product-banner">
      <div class="product-banner-slider owl-carousel owl-theme">
        <?php $i = 0; foreach($shop_slider as $slider): $i++; $pid = time().$i;
          if( !empty($slider['startdate']) && strtotime($slider['startdate']) > $current_time ) continue;
          if( !empty($slider['enddate']) && strtotime($slider['enddate']) < $current_time ) continue;
          $productID = $slider['productID'];
          if(!empty($productID)){
            $product = new WC_Product($productID);
            if(!$product || !$product->is_purchasable() || !($product->is_in_stock() && !LGS_Products::lgs_pseudo_out_of_stock($productID)) || LGS_Products::lgs_disable_purchase_and_visibility_product_shop($productID)) continue;
            $product_visibility = LGS_Products::lgs_product_visibility($productID);
            if(($shop_member && $product_visibility == 'non_member') || (!$shop_member && $product_visibility == 'member')) continue;
            $product_in_cart = woo_in_cart($productID);
          } else{
            if(($shop_member && $slider['slide_visibility'] == 'non_member') || (!$shop_member && $slider['slide_visibility'] == 'member')) continue;
          }
        ?>
            <div class="banner-slider <?php echo $is_loggin?'login':'logout'; ?>" style="background-image: url(<?php echo $slider['banner_slider_dk']; ?>);background-color: <?php echo !empty($slider['collection_bg_color'])?$slider['collection_bg_color']:'transparent'; ?>;">
              <?php if( !empty($slider['banner_link']) ):?><a href="<?php echo $slider['banner_link'];?>"><?php endif;?>
                <div class="banner-slider-link show-desktop"></div>
                <div class="banner-slider-mb show-mobile" style="background-image: url(<?php echo $slider['banner_slider_mb']; ?>)"></div>
              <?php if( !empty($slider['banner_link']) ):?></a><?php endif;?>
              <div class="banner-slider-content">
                <p class="collection-name" <?php echo !empty($slider['collection_name_color'])?'style="color:'.$slider['collection_name_color'].';"':''; ?>><?php echo !empty($slider['collection_name'])?$slider['collection_name']:'&nbsp;'; ?></p>
                <p class="collection-title" <?php echo !empty($slider['collection_title_color'])?'style="color:'.$slider['collection_title_color'].';"':''; ?>><?php echo $slider['collection_title']; ?></p>
                <div class="collection-description" <?php echo !empty($slider['collection_description_color'])?'style="color:'.$slider['collection_description_color'].';"':''; ?>><?php echo $slider['collection_description']; ?></div>
                <style>
                  <?php if(!empty($slider['collection_product_color'])): ?>
                  .product-banner-slider .banner-slider .banner-slider-content .banner-slider-action.banner-slider-<?php echo $pid; ?> span.add-to-cart-action-price a,
                  .product-banner-slider .banner-slider .banner-slider-content .banner-slider-action.banner-slider-<?php echo $pid; ?> span.add-to-cart-action-price span.price {
                    color: <?php echo $slider['collection_product_color']; ?> !important;
                  }
                  <?php endif; ?>
                  <?php if(!empty($slider['collection_product_background_color'])): ?>
                  .product-banner-slider .banner-slider .banner-slider-content .banner-slider-action.banner-slider-<?php echo $pid; ?> span.add-to-cart-action-price a {
                    background-color: <?php echo $slider['collection_product_background_color']; ?> !important;
                  }
                  <?php endif; ?>
                </style>
                <div class="banner-slider-action banner-slider-<?php echo $pid; ?>">
                  <?php if(!empty($productID)){ ?>
                    <span class="add-to-cart-action-price <?php echo($product_in_cart?'active':''); ?>">
                      <?php $args = array(
                        'quantity'         => 1,
                        'class'            => implode(' ', array_filter(array(
                          'button add_to_bag btn-primary',
                          'product_type_'.$product->get_type(),
                          $product_in_cart?'added':'',
                        ))),
                        'attributes'       => array(
                          'data-product_id'  => $product->get_id(),
                          'data-product_sku' => $product->get_sku(),
                          'aria-label'       => $product->add_to_cart_description(),
                          'rel'              => 'nofollow',
                        ),
                        'add_to_cart_text' => $product_in_cart?'Added':'Add to Bag',
                      );
                        echo sprintf('<a href="#" data-quantity="%s" class="%s" %s>%s</a>', esc_attr(isset($args['quantity'])?$args['quantity']:1), esc_attr(isset($args['class'])?$args['class']:'button'), isset($args['attributes'])?wc_implode_html_attributes($args['attributes']):'', esc_html($args['add_to_cart_text']));
                        $compare_price = LGS_Products::lgs_get_compare_price($product, $shop_member);
                        if($price_html = $product->get_price_html()) {?>
                          <span class="price">
                            <?php echo $price_html; ?>
                            <?php if(!empty($compare_price)): ?>
                              <span class="compare-price"><?php echo '$'.$compare_price; ?></span>
                            <?php endif; ?>
                          </span>
                        <?php } else { ?>
                          <span class="price show-desktop"></span><span class="price show-mobile">&nbsp;</span>
                        <?php } ?>
                    </span>
                  <?php } elseif(!empty($slider['button_option'])) { ?>
                    <span class="add-to-cart-action-price">
                      <a href="<?php echo $slider['button_option']['url']; ?>" class="btn-primary"><?php echo $slider['button_option']['title']; ?></a>
                      <span class="price show-desktop"></span><span class="price show-mobile">&nbsp;</span>
                    </span>
                  <?php } ?>
                </div>
              </div>
            </div>
          <?php endforeach; ?>
      </div>
    </div>
  <?php } ?>

  <?php if(!$is_product_category){

    $terms = get_terms(array(
      'taxonomy' => 'product_cat',
      'orderby'  => 'id',
      'order'    => 'DESC',
      'parent'   => SHOP_CAT
    ));

    foreach($terms as $term): if($term->term_id == SHOP_CAT_SPECIAL_OFFERS && $term->count > 0):
      $num_perpage = get_field('number_product_per_page',$term->taxonomy . '_' . $term->term_id);
      $num_perpage = !empty($num_perpage)?$num_perpage:4;
      $num_perpage_mobie = get_field('number_product_per_page_mobile',$term->taxonomy . '_' . $term->term_id);
      $num_perpage_mobie = !empty($num_perpage_mobie)?$num_perpage_mobie:2;
      ?>

      <div class="products-shop products-individual products-individual-special-offer" id="products-special-offers">
        <?php if(!$is_loggin): ?><div class="container shop-container"><?php endif; ?>
          <div class="wrap">

            <div class="list-individual" id="list-<?php echo $term->term_id; ?>" data-term_id="<?php echo $term->term_id; ?>" data-perpage="<?php echo $num_perpage; ?>" data-perpage-mobile="<?php echo $num_perpage_mobie; ?>">

              <p class="products-shop-title" id="<?php echo $term->slug; ?>"><?php echo $term->name; ?></p>

              <?php if( !empty( get_field('show_the_filter_on_shop_page',$term->taxonomy . '_' . $term->term_id) ) ): ?>

              <?php endif; ?>

              <div class="product-items" id="product-items-<?php echo $term->term_id; ?>">
                <?php $all_product = LGS_Products::lgs_load_products(array($term->term_id));
                  $total_list_individual = 0;
                  if($all_product->have_posts()):
                    woocommerce_product_loop_start();
                    while($all_product->have_posts()):
                      $all_product->the_post();
                      do_action('woocommerce_shop_loop');
                      wc_get_template('content-product.php', array(
                        'shop_member' => $shop_member,
                        'cart_product_ids' => $cart_product_ids,
                        'show_bg_top'      => false
                      ));
                    endwhile;
                    woocommerce_product_loop_end();
                  endif;
                  if( empty( $total_list_individual ) ){ ?>
                    <style>
                      #products-individual .list-individual#list-<?php echo $term->term_id; ?> {
                        display: none !important;
                      }
                    </style>
                  <?php }
                ?>
                <div class="product-not-found" style="display: none;">
                  <?php do_action('woocommerce_no_products_found'); ?>
                </div>
              </div>

              <div class="newdesign-pagination pg-nav">
                <nav class="text-center" aria-label="Page navigation">
                  <ul class="pagination pagination-comments" id="pagination-<?php echo $term->term_id; ?>"></ul>
                </nav>
              </div>

            </div>

          </div>
        <?php if(!$is_loggin): ?></div><?php endif; ?>
      </div>

  <?php endif; endforeach; ?>


  <div class="products-shop products-collections" id="products-collections">
    <?php if(!$is_loggin): ?><div class="container shop-container"><?php endif; ?>
      <?php $collection_products = LGS_Products::lgs_load_products(array(SHOP_CAT_COLLECTION));
        $total_list_individual = 0;
        if($collection_products->have_posts()):
          $shop_collection = get_term(SHOP_CAT_COLLECTION);
          $num_perpage = get_field('number_product_per_page',$shop_collection->taxonomy . '_' . $shop_collection->term_id);
          $num_perpage = !empty($num_perpage)?$num_perpage:4;
          $num_perpage_mobie = get_field('number_product_per_page_mobile',$shop_collection->taxonomy . '_' . $shop_collection->term_id);
          $num_perpage_mobie = !empty($num_perpage_mobie)?$num_perpage_mobie:2;
        ?>
        <div class="wrap">
          <div class="list-individual" id="list-<?php echo $shop_collection->term_id; ?>" data-term_id="<?php echo $shop_collection->term_id; ?>" data-perpage="<?php echo $num_perpage; ?>" data-perpage-mobile="<?php echo $num_perpage_mobie; ?>">

            <p class="products-shop-title" id="collection"><?php echo $shop_collection->name; ?></p>

            <div class="product-items" id="product-items-<?php echo $shop_collection->term_id; ?>">
              <ul class="products">
                <?php while($collection_products->have_posts()) :
                  $collection_products->the_post();
                  wc_get_template('content-product.php', array(
                    'shop_member' => $shop_member,
                    'cart_product_ids' => $cart_product_ids,
                    'show_bg_top'      => true
                  ));
                endwhile; wp_reset_postdata(); ?>
              </ul>
            </div>

            <div class="newdesign-pagination pg-nav">
              <nav class="text-center" aria-label="Page navigation">
                <ul class="pagination pagination-comments" id="pagination-<?php echo $shop_collection->term_id; ?>"></ul>
              </nav>
            </div>
          </div>
        </div>
      <?php endif; ?>
      <?php if( empty( $total_list_individual ) ){ ?>
        <style>
          #products-collections {
            display: none !important;
          }
        </style>
      <?php } ?>
    <?php if(!$is_loggin): ?></div><?php endif; ?>
  </div>

  <div class="products-shop products-individual" id="products-individual">
    <?php if(!$is_loggin): ?><div class="container shop-container"><?php endif; ?>
      <div class="wrap">
        <?php foreach($terms as $term){
            if($term->term_id != SHOP_CAT_COLLECTION && $term->term_id != SHOP_CAT_SPECIAL_OFFERS && $term->count > 0){

              $num_perpage = get_field('number_product_per_page',$term->taxonomy . '_' . $term->term_id);
              $num_perpage = !empty($num_perpage)?$num_perpage:4;
              $num_perpage_mobie = get_field('number_product_per_page_mobile',$term->taxonomy . '_' . $term->term_id);
              $num_perpage_mobie = !empty($num_perpage_mobie)?$num_perpage_mobie:2;

              $child_terms = get_terms(array(
                'taxonomy' => 'product_cat',
                'parent'   => $term->term_id
              ));?>

              <div class="list-individual" id="list-<?php echo $term->term_id; ?>" data-term_id="<?php echo $term->term_id; ?>" data-perpage="<?php echo $num_perpage; ?>" data-perpage-mobile="<?php echo $num_perpage_mobie; ?>">

                <p class="products-shop-title" id="<?php echo $term->slug; ?>"><?php echo $term->name; ?></p>

                <?php if( !empty( get_field('show_the_filter_on_shop_page',$term->taxonomy . '_' . $term->term_id) ) ): ?>

                <div class="filter-container product-filter" id="product-filter-<?php echo $term->term_id; ?>">

                  <div class="filter-setting">

                    <div class='product-category'>
                      <div class="product-category-options">
                        <select class="selectpicker" multiple data-dropup-auto="false" title="Sort by product" data-term_id="<?php echo $term->term_id; ?>">
                          <?php foreach($child_terms as $child_term): ?>
                            <option value="product_cat-<?php echo $child_term->slug; ?>"><?php echo $child_term->name; ?></option>
                          <?php endforeach; ?>
                        </select>
                      </div>
                    </div>

                    <?php if(!empty($date_filter)): ?>
                      <div class="product-date">
                        <div class="product-date-options">
                          <select class="selectpicker" multiple data-dropup-auto="false" title="Sort by month" data-term_id="<?php echo $term->term_id; ?>">
                            <?php foreach($date_filter as $filter): ?>
                              <option data-month="<?php echo $filter['collection_name']; ?>" value="<?php echo strtolower(str_replace(' ','-',$filter['collection_name'])); ?>">
                                <?php echo $filter['collection_name']; ?>
                              </option>
                            <?php endforeach; ?>
                          </select>
                        </div>
                      </div>
                    <?php endif; ?>

                    <?php if(!empty($color_filter)): ?>
                      <div class="product-color">
                        <div class="color-picker">
                          <?php foreach($color_filter as $filter): ?>
                            <span data-term_id="<?php echo $term->term_id; ?>" class="filter-color filter-color-<?php echo $term->term_id; ?>" data-color="<?php echo strtolower(str_replace(' ','-',$filter['color_name'])); ?>" style="background-color: <?php echo $filter['color_picker']; ?>"></span>
                          <?php endforeach; ?>
                        </div>
                      </div>
                    <?php endif; ?>

                    <?php if(!empty($stock_filter)): ?>
                      <div class="product-stock">
                        <div class="stock-picker">
                          <input type="checkbox" class="filter-stock filter-stock-<?php echo $term->term_id; ?>" id="<?php echo $term->term_id; ?>-instock" data-term_id="<?php echo $term->term_id; ?>">
                          <label for="<?php echo $term->term_id; ?>-instock"><span></span>In Stock</label>
                        </div>
                      </div>
                    <?php endif; ?>

                    <div class="filter-action d-none">
                      <a href="#" class="clear-filter" data-term_id="<?php echo $term->term_id; ?>">Clear Filter</a>
                    </div>
                  </div>

                </div>

                <?php endif; ?>

                <div class="product-items" id="product-items-<?php echo $term->term_id; ?>">
                  <?php $all_product = LGS_Products::lgs_load_products(array($term->term_id));
                    $total_list_individual = 0;
                    if($all_product->have_posts()):
                      woocommerce_product_loop_start();
                      while($all_product->have_posts()):
                        $all_product->the_post();
                        do_action('woocommerce_shop_loop');
                        wc_get_template('content-product.php', array(
                          'shop_member' => $shop_member,
                          'cart_product_ids' => $cart_product_ids,
                          'show_bg_top'      => false
                        ));
                      endwhile;
                      woocommerce_product_loop_end();
                    endif;
                    if( empty( $total_list_individual ) ){ ?>
                      <style>
                        #products-individual .list-individual#list-<?php echo $term->term_id; ?> {
                          display: none !important;
                        }
                      </style>
                    <?php }
                  ?>
                  <div class="product-not-found" style="display: none;">
                    <?php do_action('woocommerce_no_products_found'); ?>
                  </div>
                </div>

                <div class="newdesign-pagination pg-nav">
                  <nav class="text-center" aria-label="Page navigation">
                    <ul class="pagination pagination-comments" id="pagination-<?php echo $term->term_id; ?>"></ul>
                  </nav>
                </div>

              </div>

            <?php }
          } ?>
      </div>
    <?php if(!$is_loggin): ?></div><?php endif; ?>
  </div>

  <?php } else { ?>

    <div class="products-shop products-individual" id="products-individual">
      <?php if(!$is_loggin): ?><div class="container shop-container"><?php endif; ?>
        <div class="wrap">
          <?php if($term->count > 0){

            $child_terms = get_terms(array(
              'taxonomy' => 'product_cat',
              'parent'   => $term->term_id
            ));?>

            <div class="list-individual" id="list-<?php echo $term->term_id; ?>" data-term_id="<?php echo $term->term_id; ?>" data-perpage="12" data-perpage-mobile="10">

              <p class="products-shop-title" id="<?php echo $term->slug; ?>"><?php echo $term->name; ?></p>

              <?php if( !empty( get_field('show_the_filter_on_shop_page',$term->taxonomy . '_' . $term->term_id) ) ): ?>

                <div class="filter-container product-filter" id="product-filter-<?php echo $term->term_id; ?>">

                  <div class="filter-setting">

                    <div class='product-category'>
                      <div class="product-category-options">
                        <select class="selectpicker" multiple data-dropup-auto="false" title="Sort by product" data-term_id="<?php echo $term->term_id; ?>">
                          <?php foreach($child_terms as $child_term): ?>
                            <option value="product_cat-<?php echo $child_term->slug; ?>"><?php echo $child_term->name; ?></option>
                          <?php endforeach; ?>
                        </select>
                      </div>
                    </div>

                    <?php if(!empty($date_filter)): ?>
                      <div class="product-date">
                        <div class="product-date-options">
                          <select class="selectpicker" multiple data-dropup-auto="false" title="Sort by month" data-term_id="<?php echo $term->term_id; ?>">
                            <?php foreach($date_filter as $filter): ?>
                              <option data-month="<?php echo $filter['collection_name']; ?>" value="<?php echo strtolower(str_replace(' ','-',$filter['collection_name'])); ?>">
                                <?php echo $filter['collection_name']; ?>
                              </option>
                            <?php endforeach; ?>
                          </select>
                        </div>
                      </div>
                    <?php endif; ?>

                    <?php if(!empty($color_filter)): ?>
                      <div class="product-color">
                        <div class="color-picker">
                          <?php foreach($color_filter as $filter): ?>
                            <span data-term_id="<?php echo $term->term_id; ?>" class="filter-color filter-color-<?php echo $term->term_id; ?>" data-color="<?php echo strtolower(str_replace(' ','-',$filter['color_name'])); ?>" style="background-color: <?php echo $filter['color_picker']; ?>"></span>
                          <?php endforeach; ?>
                        </div>
                      </div>
                    <?php endif; ?>

                    <?php if(!empty($stock_filter)): ?>
                      <div class="product-stock">
                        <div class="stock-picker">
                          <input type="checkbox" class="filter-stock filter-stock-<?php echo $term->term_id; ?>" id="<?php echo $term->term_id; ?>-instock" data-term_id="<?php echo $term->term_id; ?>">
                          <label for="<?php echo $term->term_id; ?>-instock"><span></span>In Stock</label>
                        </div>
                      </div>
                    <?php endif; ?>

                    <div class="filter-action d-none">
                      <a href="#" class="clear-filter" data-term_id="<?php echo $term->term_id; ?>">Clear Filter</a>
                    </div>
                  </div>

                </div>

              <?php endif; ?>

              <div class="product-items" id="product-items-<?php echo $term->term_id; ?>">

                <?php $all_product = LGS_Products::lgs_load_products(array($term->term_id));
                  $total_list_individual = 0;
                  if($all_product->have_posts()):
                    woocommerce_product_loop_start();
                    while($all_product->have_posts()):
                      $all_product->the_post();
                      do_action('woocommerce_shop_loop');
                      wc_get_template('content-product.php', array(
                        'shop_member' => $shop_member,
                        'cart_product_ids' => $cart_product_ids,
                        'show_bg_top'      => false
                      ));
                    endwhile;
                    woocommerce_product_loop_end();
                  endif; ?>

                  <?php if( empty( $total_list_individual ) ){ ?>
                    <style>
                      #products-individual .list-individual#list-<?php echo $term->term_id; ?> {
                        display: none !important;
                      }
                    </style>
                  <?php } ?>
                <div class="product-not-found" style="display: none;">
                  <?php do_action('woocommerce_no_products_found'); ?>
                </div>
              </div>

              <div class="newdesign-pagination pg-nav">
                <nav class="text-center" aria-label="Page navigation">
                  <ul class="pagination pagination-comments" id="pagination-<?php echo $term->term_id; ?>"></ul>
                </nav>
              </div>

            </div>

          <?php } else { ?>

            <div class="product-not-found">
              <?php do_action('woocommerce_no_products_found'); ?>
            </div>

          <?php } ?>
        </div>
      <?php if(!$is_loggin): ?></div><?php endif; ?>
    </div>

  <?php } ?>

  <div class="shop-subscribe">
    <img class="subscribe-left-img hide-mobile" src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/subscribe-lippies.png" alt="subscribe left" />
    <?php if(!$is_loggin): ?><div class="container shop-container"><?php endif; ?>
      <div class="wrap">
        <div class="subscribe-content">
          <p class="subscribe-title">Subscribe for more exclusive beauty products!</p>
          <p class="subscribe-body">Join our <strong>#LiveGlamFam</strong> and get new beauty products delivered straight to your door monthly.</p>
          <div class="subscribe-button">
            <a class="hide-mobile" href="<?php echo home_url(PAGE_PRE_CHECKOUT); ?>">
              <button class="button btn-primary btn-vw">SUBSCRIBE</button>
            </a>
            <a class="show-mobile" href="<?php echo home_url(PAGE_PRE_CHECKOUT); ?>">
              <button class="button btn-secondary" style="min-width: 230px">Join Now</button>
            </a>
          </div>
        </div>
      </div>
    <?php if(!$is_loggin): ?></div><?php endif; ?>
    <img class="subscribe-right-img hide-mobile" src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/subscribe-brushes.png" alt="subscribe right" />
  </div>

  <?php if($is_loggin): ?>
  <?php show_dashboard_footer('footer-dashboard'); ?>
</div>
</div>

<?php else: ?>

  <style>
    .post-type-archive-product {
      background-color: #f3f6f9;
    }
  </style>

<?php endif; ?>

<?php get_footer(); ?>

<script type="text/javascript">
  jQuery(document).ready(function () {
    jQuery('.product-banner .product-banner-slider').owlCarousel({
      autoplay: true,
      autoplayTimeout: 12000,
      autoplayHoverPause: true,
      smartSpeed: 1000,
      items: 1,
      loop: true,
      nav: true,
      navText: ["<img src='<?php echo get_stylesheet_directory_uri(); ?>/assets/img/arrow-grey-left@2x.png' alt='Previous'>",
        "<img src='<?php echo get_stylesheet_directory_uri(); ?>/assets/img/arrow-grey-right@2x.png' alt='Next'>"],
      dots: true,
      responsive: {
        0: { margin: 10 },
        768: { margin: 0 }
      },
      onResized: reload_heigh_slider
    });

    var pageClass = 'page-',
      itemRowClass = 'item-row-',
      lastClass = 'last-row';

    load_products_1st();

    function load_products_1st() {
      if (jQuery('.products-individual .list-individual').length > 0) {
        jQuery('.products-individual .list-individual').each(function () {
          var id = '#list-' + jQuery(this).data('term_id');
          sort_stock(id);
          load_all_product(id);
        });
      }
      if (jQuery('.products-collections .list-individual').length > 0) {
        jQuery('.products-collections .list-individual').each(function () {
          var id = '#list-' + jQuery(this).data('term_id');
          sort_stock(id);
          load_all_product(id);
        });
      }
    }

    function sort_stock(p_lists) {
      jQuery(p_lists+' ul.products li').each(function(){
        if(jQuery(this).data('stock') == 0){
          jQuery(this).appendTo(p_lists+' ul.products');
        }
      });
    }

    jQuery('body').on('change', 'input.select-cat-mb', function () {
      var current = jQuery(this);
      if (current.closest('.category').hasClass('active')) {
        current.closest('.category').removeClass('active');
      } else {
        current.closest('.category').addClass('active');
      }
    });

    jQuery('body').on('change', 'input.select-month-mb', function () {
      var current = jQuery(this);
      if (current.closest('.date-month').hasClass('active')) {
        current.closest('.date-month').removeClass('active');
      } else {
        current.closest('.date-month').addClass('active');
      }
    });

    jQuery('body').on('click', '.product-color .color-picker span', function () {
      var width = (window.innerWidth > 0) ? window.innerWidth : screen.width,
        target = jQuery(this),
        id = '#list-' + jQuery(this).data('term_id');
      if (target.hasClass('active')) {
        target.removeClass('active');
      } else {
        target.addClass('active');
      }
      var current = jQuery(id).find('.product-filter');

      if (current.find('.filter-setting .product-color .color-picker span').length > 0) {
        if (current.find('.filter-setting .product-color .color-picker span.active').length > 0) {
          current.find('.filter-setting .product-color .color-picker span').each(function () {
            if (!jQuery(this).hasClass('active')) {
              jQuery(this).animate({opacity: .2}, 1000);
            } else {
              jQuery(this).animate({opacity: 1}, 1000);
            }
          });
        } else {
          current.find('.filter-setting .product-color .color-picker span').animate({opacity: 1}, 1000);
        }
      }

      load_all_product(id);
      return false;
    });

    jQuery('body').on('click', '.apply-filter', function () {
      var current = '#' + jQuery(this).closest('.list-individual').attr('id');
      load_all_product(current);
      return false;
    });

    jQuery('body').on('click', '.clear-filter', function () {
      var width = (window.innerWidth > 0) ? window.innerWidth : screen.width,
        id = '#list-' + jQuery(this).data('term_id');
      jQuery(id).find('.product-filter .filter-setting .product-stock input').prop('checked', false);
      jQuery(id).find('.product-filter .filter-setting .product-category select option:selected').prop('selected', false);
      jQuery(id).find('.product-filter .filter-setting .product-date select option:selected').prop('selected', false);
      jQuery(id).find('.product-filter .filter-setting .product-color .color-picker span').removeClass('active').animate({opacity: 1}, 1000);;
      jQuery('.selectpicker').selectpicker('refresh');
      load_all_product(id);
      return false;
    });

    jQuery('body').on('change', '.product-filter .filter-setting .product-category select', function () {
      var id = '#list-' + jQuery(this).data('term_id');
      load_all_product(id);
    });

    jQuery('body').on('change', '.product-filter .filter-setting .product-date select', function () {
      var id = '#list-' + jQuery(this).data('term_id');
      load_all_product(id);
    });

    jQuery('body').on('change', '.product-filter .filter-setting .product-stock input', function () {
      var id = '#list-' + jQuery(this).data('term_id');
      load_all_product(id);
    });

    function load_all_product(list_individual) {
      var width = (window.innerWidth > 0) ? window.innerWidth : screen.width,
        current = jQuery(list_individual),
        p_lists = '#' + current.find('.product-items').attr('id'),
        p_pagination = '#' + current.find('.pagination-comments').attr('id'),
        p_perpage = (width > 767)?current.data('perpage'):current.data('perpage-mobile');

      //get value filter for desktop
      var p_cat = current.find('.product-filter .filter-setting .product-category select').val(),
        p_month = current.find('.product-filter .filter-setting .product-date select').val(),
        p_instock = current.find('.product-filter .filter-setting .product-stock .stock-picker input.filter-stock').is(":checked") ? 1 : 0;

      var p_color = [];
      if (current.find('.product-filter .filter-setting .product-color .color-picker span.active').length > 0) {
        current.find('.product-filter .filter-setting .product-color .color-picker span.active').each(function () {
          p_color.push(jQuery(this).data('color'));
        });
      }

      if (p_color.length === 0 && (p_cat == null || p_cat.length == 0) && p_instock == 0 && (p_month == null || p_month.length == 0)) {
        current.find('.product-filter .filter-action').addClass('d-none');
      } else {
        current.find('.product-filter .filter-action').removeClass('d-none');
      }

      if(p_cat == null || p_cat.length == 0) p_cat = [];
      p_month = (p_month == null || p_month.length == 0)? [] : p_month;

      p_instock = (typeof p_instock !== "undefined" ) ? p_instock : '';

      go_to_page(p_lists, p_pagination, 1, 1, p_cat, p_month, p_color, p_instock, p_perpage);
    }

    function go_to_page(p_lists, p_pagination, currentPage, reload_pagination, p_cat, p_month, p_color, p_instock, p_perpage) {
      load_products(p_lists, p_pagination, currentPage, reload_pagination, p_cat, p_month, p_color, p_instock, p_perpage);
    }

    function load_products(p_lists, p_pagination, currentPage, reload_pagination, p_cat, p_month, p_color, p_instock, p_perpage) {
      if(reload_pagination) {
        reload_page_num(p_lists);
          jQuery(p_pagination).html('');
        var totalItems = setup_page_num(p_lists, p_cat, p_month, p_color, p_instock, p_perpage);
        if(totalItems > 0) {
          jQuery(p_lists+' .product-not-found').hide();
          var totalPage = Math.ceil(totalItems / p_perpage);
          if (totalPage > 1) {
            jQuery(p_pagination).closest('.pg-nav ul').show();
            set_pagination(p_lists, p_pagination, totalPage, p_cat, p_month, p_color, p_instock, p_perpage);
          } else {
            jQuery(p_pagination).closest('.pg-nav ul').hide();
          }
        } else {
          //case no product found
          jQuery(p_lists+' .product-not-found').show();
        }
      }

      //show hide list product by page
      jQuery(p_lists + ' ul.products li.product').each(function (e) {
        if(jQuery(this).hasClass(pageClass+currentPage)){
          jQuery(this).show(1000);
        } else {
          jQuery(this).hide(1000);
        }
      });
    }

    function set_pagination(p_lists, p_pagination, totalPage, p_cat, p_month, p_color, p_instock, p_perpage) {
      var obj = jQuery(p_pagination).pagination({
        items: totalPage,
        itemOnPage: p_perpage,
        currentPage: 1,
        cssStyle: '',
        prevText: '<i class="fas fa-chevron-left" aria-hidden="true"></i>',
        nextText: '<i class="fas fa-chevron-right" aria-hidden="true"></i>',
        onInit: function () {
        },
        onPageClick: function (page, evt) {
          go_to_page(p_lists, p_pagination, page, 0, p_cat, p_month, p_color, p_instock, p_perpage);
          var width = (window.innerWidth > 0) ? window.innerWidth : screen.width;
          var heigh_top = jQuery(p_lists).closest('.list-individual').offset().top;
          if( width < 767 ) {
            heigh_top = heigh_top - jQuery('.mobile-nav-bar').height();
          }else{
            heigh_top = heigh_top - jQuery('.fixed-top').height();
          }
          jQuery('html, body').animate({scrollTop: heigh_top}, 'slow');
        }
      });
    }

    function reload_page_num(p_lists){
      jQuery(p_lists + ' ul.products li.product').each(function (e) {
        var key = pageClass+'+',
          key2 = itemRowClass+'+';
        var cl =  jQuery(this).attr("class").split(" ");
        var newcl =[],
          newcl1 = [],
          newcl2 = [];
        for(var i=0;i<cl.length;i++){
          r = cl[i].search(key);
          if(r)newcl[newcl.length] = cl[i];
        }
        for(var i=0;i<newcl.length;i++){
          r = newcl[i].search(key2);
          if(r)newcl1[newcl1.length] = newcl[i];
        }
        for(var i=0;i<newcl1.length;i++){
          r = newcl1[i].search(lastClass);
          if(r)newcl2[newcl2.length] = newcl1[i];
        }
        jQuery(this).removeClass().addClass(newcl2.join(" "));
      });
    }

    function setup_page_num(p_lists, p_cat, p_month, p_color, p_instock, p_perpage) {
      var item = 1,
        page = 1,
        item_row = 0,
        total_items = 0;
      jQuery(p_lists + ' ul.products li.product').each(function (e) {
        var all_class =  jQuery(this).attr("class").split(" "),
          product_month = jQuery(this).data('month'),
          product_color = jQuery(this).data('color').split(','),
          product_stock = jQuery(this).data('stock'),
          check_cat = 1,
          check_color = 1,
          check_month = 1,
          check_stock = 1;

        if(p_cat.length != 0){
          var same_class = getMatch(p_cat,all_class);
          if(same_class.length ==0 ){
            check_cat = 0;
          }
        }

        if(p_month.length != 0 && jQuery.inArray(product_month, p_month) == -1){
          check_month = 0;
        }

        if(p_color.length != 0 && product_color.length != 0){
          var same_color = getMatch(p_color,product_color);
          if(same_color.length ==0 ){
            check_color = 0;
          }
        }

        if( p_instock == 1 && p_instock != product_stock){
          check_stock = 0;
        }

        if( check_cat && check_stock && check_color && check_month ) {
          if (item > p_perpage) {
            page++;
            item = 1;
          }
          jQuery(this).addClass(pageClass + page);
          jQuery(this).addClass(itemRowClass+item_row);
          if(item % 4 == 0){
            jQuery(this).addClass(lastClass);
            item_row++;
          }
          item++;
          total_items++;
        }
      });
      return total_items;
    }

    function getMatch(a, b) {
      var matches = [];
      for ( var i = 0; i < a.length; i++ ) {
        for ( var e = 0; e < b.length; e++ ) {
          if ( a[i] === b[e] ) matches.push( a[i] );
        }
      }
      return matches;
    }

    function getQueryVariable(variable) {
      var query = window.location.search.substring(1);
      var vars = query.split("&");
      for (var i=0;i<vars.length;i++) {
        var pair = vars[i].split("=");
        if(pair[0] == variable){return pair[1];}
      }
      return(false);
    }

    lgsLoadShop();
    function lgsLoadShop() {
      var list_individual = window.location.hash,
        is_product_category = '<?php echo $is_product_category?1:0; ?>';
      if(list_individual != '' || is_product_category == 1){
        if(is_product_category != 1) {
          var current = jQuery(list_individual).closest('.list-individual');
        } else {
          var current = jQuery('.list-individual');
        }
        var texture = getQueryVariable('texture'),
          month = getQueryVariable('month'),
          color = getQueryVariable('color');

        texture = texture != false ? texture.split(','):[];
        month = month != false ? month.split(','):[];
        color = color != false ? color.split(','):[];

        if( texture.length > 0 ) {/* select texture */
          jQuery.each(texture, function (key, value) {
            current.find('.product-category select option').filter('[value=product_cat-'+value.toLowerCase()+']').attr('selected', true).change();
          });
        }

        if( month.length > 0 ) {/* select month */
          jQuery.each(month, function (key, value) {
            current.find('.product-date select option').filter('[value='+value.toLowerCase()+']').attr('selected', true).change();
          });
        }

        if( color.length > 0 ) {/* select color */
          jQuery.each(color, function (key, value) {
            current.find('.product-color .color-picker span[data-color="'+value.toLowerCase()+'"]').click();
          });
        }
      }
    };

    jQuery( window ).resize(function() {
      reload_heigh_product();
    });

    reload_heigh_product();
    reload_heigh_slider();

    function reload_heigh_product() {

      var product_collection = 0,
        product_title = 0,
        product_price_pink = 0,
        product_price_gray = 0;

      jQuery('.list-individual .product-items ul li .collection-name').css('min-height','');
      jQuery('.list-individual .product-items ul li .item-title').css('min-height','');
      jQuery('.list-individual .product-items ul li .item-price-pink').css('min-height','');
      jQuery('.list-individual .product-items ul li .item-price-gray').css('min-height','');

      jQuery('.list-individual .product-items ul li').each(function () {
        var current = jQuery(this);
        product_collection = (current.find('.collection-name').height() > product_collection)?current.find('.collection-name').height():product_collection,
          product_title = (current.find('.item-title').height() > product_title)?current.find('.item-title').height():product_title,
          product_price_pink = (current.find('.item-price-pink').height() > product_price_pink)?current.find('.item-price-pink').height():product_price_pink,
          product_price_gray = (current.find('.item-price-gray').height() > product_price_gray)?current.find('.item-price-gray').height():product_price_gray;
      });

      jQuery('.list-individual .product-items ul li .collection-name').css('min-height',product_collection);
      jQuery('.list-individual .product-items ul li .item-title').css('min-height',product_title);
      jQuery('.list-individual .product-items ul li .item-price-pink').css('min-height',product_price_pink);
      jQuery('.list-individual .product-items ul li .item-price-gray').css('min-height',product_price_gray);

    }

    function reload_heigh_slider() {
      var collection_name = 0,
        collection_title = 0,
        collection_desc = 0;

      jQuery('.product-banner .banner-slider .collection-name').css('min-height', 0);
      jQuery('.product-banner .banner-slider .collection-title').css('min-height', 0);
      jQuery('.product-banner .banner-slider .collection-description').css('min-height', 0);

      var width = (window.innerWidth > 0) ? window.innerWidth : screen.width;

      if( width > 768 ) return false;

      jQuery('.product-banner .banner-slider').each(function () {
        var current = jQuery(this);
        collection_name = (current.find('.collection-name').height() > collection_name)?current.find('.collection-name').height():collection_name,
          collection_title = (current.find('.collection-title').height() > collection_title)?current.find('.collection-title').height():collection_title,
          collection_desc = (current.find('.collection-description').height() > collection_desc)?current.find('.collection-description').height():collection_desc;
      });

      jQuery('.product-banner .banner-slider .collection-name').css('min-height',collection_name);
      jQuery('.product-banner .banner-slider .collection-title').css('min-height',collection_title);
      jQuery('.product-banner .banner-slider .collection-description').css('min-height',collection_desc);
    }
  });
</script>