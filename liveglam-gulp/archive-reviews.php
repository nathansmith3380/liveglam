<?php
  /**
   * Template Name: Reviews page
   *
   * @package Liveglam
   */
  if(!defined('ABSPATH')){
    exit; // Exit if accessed directly
  }
  get_header(); ?>

<!-- reviews page -->
<?php $all_testimonials = liveglam_get_all_testimonials_by_termid(array(), 6); ?>
<section class="review-intro">
  <div class="vertical-center">
    <div class="container">
      <div class="row">
        <div class="col-md-7">
          <h3 class="nd19-hero-title">Our customers love us</h3>
          <p class="sub-header nd19-block-content-s">See why they love being a part of our Glam Fam!</p>
          <div class="new-reviews-desktop">
            <div class="owl-carousel owl-theme new-reviews new-reviews-one" id="new-reviews">
              <?php $i = 0; foreach($all_testimonials as $testimonials): ?>
                  <div class="new-reviews-content" data-slider-id="<?php echo $i++; ?>">
                    <div class="new-reviews-container">
                      <img src="<?php echo $testimonials['customer_images']; ?>" class="photo image-blog-author">
                    <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/review-page-mobile.png" class="photo image-sub-author show-mobile ">
                      <div class="new-slide-top">
                        <p class="title nd19-block-title"><?php echo $testimonials['name']; ?></p>
                        <p class="desc nd19-block-content"><?php echo $testimonials['content']; ?></p>
                      </div>
                      <div class="new-slide-bottom">
                        <div class="new-slide-bottom-content">
                        <p class="customer-social nd19-block-content-s">
                          <span><img src="<?php echo $testimonials['images_further']; ?>" class="icon-<?php echo $testimonials['further_choose']; ?>"></span><?php echo $testimonials['name_handle']; ?>
                        </p>
                          <p class="customer-subscribes nd19-block-content-s">
                            <?php if(!empty($testimonials['subscribes_club'])): ?>
                              Subscribes to: <span><?php echo $testimonials['subscribes_club']; ?></span>
                            <?php endif; ?>
                          </p>
                        </div>
                      </div>
                    </div>
                  </div>
                <?php endforeach; ?>
            </div>

          </div>
        </div>
      </div>
    </div>
  </div>
</section>
<section class="review" id="section-review">
  <div class="filter-options">
    <div class="container">
      <ul class="nav nav-tabs">
        <li class="active"><a href="#" data-filter=".all">All</a></li>
        <li><a href="#" data-filter=".kissme"><img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/about-logo-lipstick@2x.svg"></a></li>
        <li><a href="#" data-filter=".morpheme"><img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/logo_morpheme_reviews.svg"></a></li>
        <li><a href="#" data-filter=".shadowme"><img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/logo_shadowme_home4.svg"></a></li>
      </ul>
      <select class="form-control filter-select selectpicker d-none">
        <option value=".filter" selected>Filter</option>
        <option value=".instagram">Instagram</option>
        <option value=".twitter">Twitter</option>
        <option value=".facebook">Facebook</option>
        <option value=".yelp">Yelp</option>
        <option value=".google">Google</option>
        <option value=".youtube">Youtube</option>
      </select>
    </div>
  </div>
  <div class="results">
    <div class="container">
      <ul class="list isotope">
      </ul>

    </div>
    <div class="page-load-status">
      <div class="loader-ellips infinite-scroll-request">
        <span class="loader-ellips__dot"></span>
        <span class="loader-ellips__dot"></span>
        <span class="loader-ellips__dot"></span>
        <span class="loader-ellips__dot"></span>
      </div>
    </div>

  </div>

  <div class="text-center load-more-container">
    <button class="load-more-reviews btn-secondary">Load More Reviews</button>
  </div>
</section>
<!-- end reviews page -->

<?php get_footer(); ?>

<script type="text/javascript">

  jQuery(document).ready(function () {

    jQuery('.selectpicker').selectpicker({dropupAuto: false});


    var itemSelector = '.grid-item',
      currentFilter = '*';

    var $container = jQuery('.list.isotope').isotope({
      itemSelector: itemSelector,
      filter: currentFilter,
      layoutMode: 'masonry',
      transitionDuration: '0'
    });

    // get Isotope instance
    var iso = $container.data('isotope');

    // init Infinite Scroll
    $container.infiniteScroll({
      path:  function() {
        var a = jQuery('.filter-options .nav-tabs li.active a').data('filter').replace('.', ''),
            b = jQuery('.filter-options .filter-select option:selected').val().replace('.', '');
            var nextIndex = this.loadCount + 1;
            return '<?php echo admin_url( 'admin-ajax.php' );?>?action=load_more_reviews&page='+nextIndex+'&term='+a+'&source='+b;
      },
      append: '.grid-item',
      button: '.load-more-reviews',
      outlayer: iso,
      history: false,
      scrollThreshold: false,
      status: '.page-load-status',
      checkLastPage: '.pagination__next',
      debug: true
    });

    $container.on( 'append.infiniteScroll', function( event, response, path, items ) {
      $container.isotope({
        filter: '*'
      })
    });

    show_item(1);


    jQuery('body').on('click', '.filter-options .nav-tabs li a', function (e) {
      e.preventDefault();
      var tab_this = jQuery(this).parent('li');
      if (tab_this.hasClass('active')) {
        return false;
      }

      jQuery('.filter-options .nav-tabs li.active').removeClass('active');
      tab_this.addClass('active');
      //do action pagination here
      show_item(1);

      return false;
    });

    jQuery('body').on('change', '.filter-options .filter-select', function () {
      show_item(1);
      return false;
    });


    function show_item(currentPage, reload_pagination = true) {
      jQuery('.isotope').css('height', 0);
      $container.isotope('remove', $container.isotope('getFilteredItemElements'));
      infScroll = jQuery('.list.isotope').data('infiniteScroll');
      infScroll.pageIndex = 1;
      infScroll.loadCount = 0;
      infScroll.canLoad = true;
      infScroll.isScrollWatching = true;
      infScroll.loadNextPage();
      return false;
    }
  });
</script>
