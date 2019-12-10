<?php
  /**
   * Single Product Video
   */

  defined('ABSPATH') || exit;

  if(!function_exists('wc_get_gallery_image_html')){
    return;
  }

  global $product;

  if(!empty($total_video = get_post_meta($product->get_id(), 'product_video_gallery', true))){
    $flexslider = (bool)apply_filters('woocommerce_single_product_flexslider_enabled', get_theme_support('wc-product-gallery-slider'));
    for($i = 0; $i < $total_video; $i++):
      $video_url = get_post_meta($product->get_id(), 'product_video_gallery_'.$i.'_video_url', true);
      $attachment_id = get_post_meta($product->get_id(), 'product_video_gallery_'.$i.'_image_placeholder', true);
      if(empty($video_url) || empty($attachment_id)) continue;
      $gallery_thumbnail = wc_get_image_size('gallery_thumbnail');
      $thumbnail_size = apply_filters('woocommerce_gallery_thumbnail_size', array($gallery_thumbnail['width'], $gallery_thumbnail['height']));
      $image_size = apply_filters('woocommerce_gallery_image_size', $flexslider?'woocommerce_single':$thumbnail_size);
      $full_size = apply_filters('woocommerce_gallery_full_size', apply_filters('woocommerce_product_thumbnails_large_size', 'full'));
      $thumbnail_src = wp_get_attachment_image_src($attachment_id, $thumbnail_size);
      $full_src = wp_get_attachment_image_src($attachment_id, $full_size);
      $image = wp_get_attachment_image($attachment_id, $image_size, false, array('title' => get_post_field('post_title', $attachment_id), 'data-caption' => get_post_field('post_excerpt', $attachment_id), 'data-src' => $full_src[0], 'data-large_image' => $full_src[0], 'data-large_image_width' => $full_src[1], 'data-large_image_height' => $full_src[2], 'class' => 'lgs-product-gallery__video',));

      ?>

      <div data-thumb="<?php echo esc_url($thumbnail_src[0]); ?>" class="woocommerce-product-gallery__image">
        <div class="video-slider owl-carousel owl-theme">
          <div class="item-video" style="width:<?php echo $full_src[1]; ?>">
            <a class="owl-video" href="<?php echo $video_url; ?>"></a>
            <?php echo $image; ?>
          </div>
        </div>
      </div>

    <?php endfor; ?>


    <style>
      .video-slider .owl-stage {
        width: 100% !important;
      }

      .video-slider .owl-stage .owl-item {
        width: 100% !important;
      }

      .video-slider .owl-stage .owl-item.owl-video-playing .lgs-product-gallery__video {
        display: none;
      }

      .video-slider .owl-item .owl-video-wrapper {
        top: 50%;
        position: absolute;
        height: auto;
        left: 50%;
        transform: translate(-50%, -50%);
      }

      .video-slider .owl-item .item-video {
        position: relative;
      }

      .video-slider .owl-item.owl-video-playing .owl-video-wrapper {
        position: relative;
        top: 0;
        left: 0;
        transform: none;
      }
    </style>

    <script type="text/javascript">
      jQuery(document).ready(function () {

        load_video();
        jQuery(document).bind('webkitTransitionEnd transitionend', function () {
          reload_video();
          load_video();
        });

        function reload_video() {
          jQuery('.video-slider').each(function () {
            jQuery(this).trigger('destroy.owl.carousel');
            jQuery(this).find('.owl-video-frame').remove();
            jQuery(this).find('.owl-video-play-icon').remove();
            jQuery(this).find('.owl-video-tn').remove();
          });
        }

        function load_video() {
          jQuery('.video-slider').each(function () {
            jQuery(this).owlCarousel({
              items: 1,
              margin: 0,
              loop: false,
              video: true,
              lazyLoad: true,
              nav: false,
              dots: false,
              responsive: {
                0: {items: 1}
              }
            });
          });
        }

      });
    </script>
    <?php
  }
