<?php
  /**
   * Template Name: FAQs page
   *
   * @package Liveglam
   */

  get_header();

  $all_faqs = get_posts(array(
    'post_type' => 'faqs',
    'post_status' => 'publish',
    'numberposts' => -1
  ));
  $defaults = array(
    'kissme' => array(),
    'morpheme' => array(),
    'shadowme' => array(),
    'general' => array(),
    'shipping' => array(),
    'orders' => array(),
    'billing' => array(),
    'rewards' => array(),
    'dashboard' => array()
  );
  $faqs = lgs_get_faqs();

  $faqs = wp_parse_args( $faqs, $defaults );
?>


  <!-- faq page -->
  <section class="faq-intro">
    <div class="container">
        <div class="text-container">
            <h3 class="faq-title nd19-block-content">How Can We Help?</h3>
            <p class="faq-description nd19-hero-title">Advice & answers<br />from the LiveGlam<br />team</p>
        </div>
    </div>
    <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/faq-banner-hero.png" class="hide-mobile banner-hero">
    <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/faq-banner-color.png" class="hide-mobile banner-color">
    <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/faq-hero-mobile.png" class="show-mobile banner-hero-mobile">
  </section>
  <div class="faq-search-box d-none">
    <form class="search" action="<?php echo home_url('/faq-search'); ?>" >
        <input type="search" name="keyword" class="keyword" placeholder="Search faqs..." />
        <button type="submit" class="submit btn btn-primary"><span>Search</span></button>
        <input type="hidden" name="p_type" value="faqs" />
    </form>
  </div>
  <section class="faq-products">
    <div class="container">
      <h3 class="category-select-header nd19-section-title">Select one of the categories below</h3>
      <div class="category-types">
        <div id="kissme" class="faq-category-type category-club" data-href="kissme">
            <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/logo_kissme_black.svg">
            <span class="category-type-name nd19-block-content">Lipstick Club</span>
            <span class="view-questions show-desktop nd19-block-content-s">View questions ></span>
        </div>
        <div id="morpheme" class="faq-category-type category-club" data-href="morpheme">
            <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/logo_morpheme_black.svg">
            <span class="category-type-name nd19-block-content">Brush Club</span>
            <span class="view-questions show-desktop nd19-block-content-s">View questions ></span>
        </div>
        <div id="shadowme" class="faq-category-type category-club" data-href="shadowme">
            <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/logo_shadowme_black.svg">
            <span class="category-type-name nd19-block-content">EyeShadow Club</span>
            <span class="view-questions show-desktop nd19-block-content-s">View questions ></span>
        </div>
        <div id="general" class="faq-category-type" data-href="general">
            <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/icon_search_black.png">
            <span class="category-type-name nd19-block-content">General</span>
            <span class="view-questions show-desktop nd19-block-content-s">View questions ></span>
        </div>
        <div id="shipping" class="faq-category-type" data-href="shipping">
            <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/icon_shipping_black.png">
            <span class="category-type-name nd19-block-content">Shipping</span>
            <span class="view-questions show-desktop nd19-block-content-s">View questions ></span>
        </div>
        <div id="orders" class="faq-category-type" data-href="orders">
            <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/icon_orders_black.png">
            <span class="category-type-name nd19-block-content">Orders</span>
            <span class="view-questions show-desktop nd19-block-content-s">View questions ></span>
        </div>
        <div id="billing" class="faq-category-type" data-href="billing">
            <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/icon_billing_black.png">
            <span class="category-type-name nd19-block-content">Billing</span>
            <span class="view-questions show-desktop nd19-block-content-s">View questions ></span>
        </div>
        <div id="rewards" class="faq-category-type" data-href="rewards">
            <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/icon_rewards_black.png">
            <span class="category-type-name nd19-block-content">Rewards</span>
            <span class="view-questions show-desktop nd19-block-content-s">View questions ></span>
        </div>
        <div id="dashboard" class="faq-category-type" data-href="dashboard">
            <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/icon_dashboard_black.png">
            <span class="category-type-name nd19-block-content">Dashboard</span>
            <span class="view-questions show-desktop nd19-block-content-s">View questions ></span>
        </div>
      </div>
        <div class="faq-lists d-none">
            <div class="category-lists">
                <a href="#anchor_link"><div class="category-item kissme category-club" data-href="kissme">
                    <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/logo_kissme_black.svg">
                    <img class="active-img" src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/logo_kissme_white.png">
                    <span class="category-type-name show-mobile">Lipstick Club</span>
                </div></a>
                <div class="faq-list-item show-mobile">
                  <?php show_faq('kissme', $faqs['kissme'], 'mobile'); ?>
                </div>
                <a href="#anchor_link"><div class="category-item morpheme category-club" data-href="morpheme">
                    <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/logo_morpheme_black.svg">
                    <img class="active-img" src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/logo_morpheme_white.png">
                    <span class="category-type-name show-mobile">Brush Club</span>
                </div></a>
                <div class="faq-list-item show-mobile">
                  <?php show_faq('morpheme', $faqs['morpheme'], 'mobile'); ?>
                </div>
                <a href="#anchor_link"><div class="category-item shadowme category-club" data-href="shadowme">
                    <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/logo_shadowme_black.svg">
                    <img class="active-img" src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/logo_shadowme_white.png">
                    <span class="category-type-name show-mobile">Eyeshadow Club</span>
                </div></a>
                <div class="faq-list-item show-mobile">
                  <?php show_faq('shadowme', $faqs['shadowme'], 'mobile'); ?>
                </div>
                <a href="#anchor_link"><div class="category-item general" data-href="general">
                    <span class="category-type-name">General</span>
                    <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/icon_search_black.png">
                    <img class="active-img" src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/icon_search_white.png">
                </div></a>
                <div class="faq-list-item show-mobile">
                  <?php show_faq('general', $faqs['general'], 'mobile'); ?>
                </div>
                <a href="#anchor_link"><div class="category-item shipping" data-href="shipping">
                    <span class="category-type-name">Shipping</span>
                    <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/icon_shipping_black.png">
                    <img class="active-img" src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/icon_shipping_white.png">
                </div></a>
                <div class="faq-list-item show-mobile">
                  <?php show_faq('shipping', $faqs['shipping'], 'mobile'); ?>
                </div>
                <a href="#anchor_link"><div class="category-item orders" data-href="orders">
                    <span class="category-type-name">Orders</span>
                    <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/icon_orders_black.png">
                    <img class="active-img" src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/icon_orders_white.png">
                </div></a>
                <div class="faq-list-item show-mobile">
                  <?php show_faq('orders', $faqs['orders'], 'mobile'); ?>
                </div>
                <a href="#anchor_link"><div class="category-item billing" data-href="billing">
                    <span class="category-type-name">Billing</span>
                    <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/icon_billing_black.png">
                    <img class="active-img" src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/icon_billing_white.png">
                </div></a>
                <div class="faq-list-item show-mobile">
                  <?php show_faq('billing', $faqs['billing'], 'mobile'); ?>
                </div>
                <a href="#anchor_link"><div class="category-item rewards" data-href="rewards">
                    <span class="category-type-name">Rewards</span>
                    <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/icon_rewards_black.png">
                    <img class="active-img" src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/icon_rewards_white.png">
                </div></a>
                <div class="faq-list-item show-mobile">
                  <?php show_faq('rewards', $faqs['rewards'], 'mobile'); ?>
                </div>
                <a href="#anchor_link"><div class="category-item dashboard" data-href="dashboard">
                    <span class="category-type-name">Dashboard</span>
                    <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/icon_dashboard_black.png">
                    <img class="active-img" src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/icon_dashboard_white.png">
                </div></a>
                <div class="faq-list-item show-mobile">
                  <?php show_faq('dashboard', $faqs['dashboard'], 'mobile'); ?>
                </div>
            </div>
            <div class="faq-contents show-desktop">
              <div id="anchor_link"></div>
              <?php show_faq('kissme', $faqs['kissme'], 'desktop'); ?>
              <?php show_faq('morpheme', $faqs['morpheme'], 'desktop'); ?>
              <?php show_faq('shadowme', $faqs['shadowme'], 'desktop'); ?>
              <?php show_faq('general', $faqs['general'], 'desktop'); ?>
              <?php show_faq('shipping', $faqs['shipping'], 'desktop'); ?>
              <?php show_faq('orders', $faqs['orders'], 'desktop'); ?>
              <?php show_faq('billing', $faqs['billing'], 'desktop'); ?>
              <?php show_faq('rewards', $faqs['rewards'], 'desktop'); ?>
              <?php show_faq('dashboard', $faqs['dashboard'], 'desktop'); ?>
            </div>
        </div>
    </div>
  </section>

  <section class="faq-no-answer">
    <h3 class="nd19-section-title">Still not finding your answers?</h3>
    <p class="nd19-section-subtitle">We have a dedicated team of Customer Happiness<br />reps that are ready to help you out!</p>
    <a href="<?php echo home_url('/contact-us/'); ?>" class="btn-secondary">Contact Us</a>
  </section>
  <!-- end faq page -->

<?php get_footer(); ?>

    <script>
        jQuery(document).ready(function () {
            jQuery(document).on('click', '.faq-category-type', function() {
                var category = jQuery(this).data('href');
                jQuery('.faq-products .category-types').addClass('d-none');
                jQuery('.category-select-header').addClass('d-none');
                jQuery('.faq-lists').removeClass('d-none');
                jQuery('.faq-lists .category-item').removeClass('active');
                jQuery('.faq-lists .category-item.'+category).addClass('active');
                jQuery('.faq-lists .faq-list').removeClass('d-none').addClass('d-none');
                jQuery('.faq-lists .faq-list.faqs-'+category).removeClass('d-none');
            });

            jQuery(document).on('click', '.faq-lists .category-item', function() {
                var category = jQuery(this).data('href');
                jQuery('.faq-lists .category-item').removeClass('active');
                jQuery(this).addClass('active');
                jQuery('.faq-lists .faq-list').removeClass('d-none').addClass('d-none');
                jQuery('.faq-lists .faq-list.faqs-'+category).removeClass('d-none');
            })
        });
    </script>

<?php
function show_faq($category, $faq_data, $device){

  if(!$category || !in_array($category, array('kissme', 'morpheme', 'shadowme', 'general', 'shipping', 'orders', 'billing', 'rewards', 'dashboard')))
    return;

  switch($category) {
    case 'kissme':  $title = 'Lipstick Club'; break;
    case 'morpheme': $title = 'Brush Club'; break;
    case 'shadowme': $title = 'Eyeshadow Club'; break;
    case 'general': $title = 'General'; break;
    case 'shipping': $title = 'Shipping'; break;
    case 'orders': $title = 'Orders'; break;
    case 'billing': $title = 'Billing'; break;
    case 'rewards': $title = 'Rewards'; break;
    case 'dashboard': $title = 'Dashboard'; break;
    default: break;
  }

  echo '<div class="faq-list faqs-'.$category.'">
            <p class="faq-list-title show-desktop nd19-section-title"">'.$title.'</p>';

  if(count($faq_data)):
    $count = 0;
    foreach($faq_data as $faq): $count++;
      echo '<div class="card">
                <div class="card-header">
                    <p class="card-title">
                        <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion-'.$category.'-panel'.$count.'-'.$device.'" href="#accordion-'.$category.'-panel'.$count.'-'.$device.'">
                            <span class="panel-icon panel-open-icon"><i class="fas fa-plus"></i></span>
                            <span class="panel-icon panel-close-icon"><i class="fas fa-minus"></i></span>'
                            .$faq->post_title.'
                        </a>
                    </p>
                </div>
                <div id="accordion-'.$category.'-panel'.$count.'-'.$device.'" class="panel-collapse collapse">
                    <div class="card-body">'.wpautop($faq->post_content).'</div>
                </div>
            </div>';
    endforeach;
  endif;

  echo '</div>';

}
?>

<script>
jQuery(document).ready(function($) {
  $(document).on('click', 'a[href^="#"]', function (event) {
      if ($(document).width() < 768) return;
      event.preventDefault();

      $('html, body').animate({
          scrollTop: $($.attr(this, 'href')).offset().top - 200
      }, 500);
  });
});
</script>