<?php
  /**
   * Product loop sale flash
   *
   * This template can be overridden by copying it to yourtheme/woocommerce/loop/sale-flash.php.
   *
   * HOWEVER, on occasion WooCommerce will need to update template files and you
   * (the theme developer) will need to copy the new files to your theme to
   * maintain compatibility. We try to do this as little as possible, but it does
   * happen. When this occurs the version of the template file will be bumped and
   * the readme will list any important changes.
   *
   * @see      https://docs.woocommerce.com/document/template-structure/
   * @author    WooThemes
   * @package  WooCommerce/Templates
   * @version     1.6.4
   */

  if(!defined('ABSPATH')){
    exit; // Exit if accessed directly
  }

  global $post, $product;
?>
<?php $is_product_coming_soon = LGS_Products::is_product_coming_soon($product->get_id());
  if($is_product_coming_soon['is_coming_soon']): ?>

    <?php echo "<span class='btn-badge comingsoon'>{$is_product_coming_soon['text_badge']}</span>";

    endif;?>

<?php if(!empty($use_custom_badge = get_post_meta($product->get_id(),'use_custom_badge',true))):
  $select_type_custom_badge = get_post_meta($product->get_id(),'select_type_custom_badge',true);
  if( !empty($select_type_custom_badge) ){
    $image_url = wp_get_attachment_image_url(get_post_meta($product->get_id(), 'custom_badge_image', true), 'full');
    $badge_class = 'custom-image';
    $badge_style = '';
  } else{
    $custom_badge_text = get_post_meta($product->get_id(), 'custom_badge_text', true);
    $custom_badge_color = get_post_meta($product->get_id(), 'custom_badge_color', true);
    $custom_badge_background_color = get_post_meta($product->get_id(), 'custom_badge_background_color', true);
    $badge_class = 'custom-text';
    $badge_style = 'style="color: '.$custom_badge_color.' !important; background-color:'.$custom_badge_background_color.' !important;"';
  }
  $position_custom_badge = get_post_meta($product->get_id(), 'position_custom_badge', true);
  $badge_class .= !empty($position_custom_badge)?" custom-badge-on-right":"";
  ?>

  <span class="btn-badge custom_badge <?php echo $badge_class; ?>" <?php echo $badge_style; ?>>

    <?php if(!empty($select_type_custom_badge)): ?>

      <img src="<?php echo $image_url; ?>" alt="Custom Badge"/>

    <?php else : ?>

      <?php echo $custom_badge_text; ?>

    <?php endif; ?>

  </span>

  <?php if(!$position_custom_badge) return; ?>

<?php endif; ?>
<?php if(!$product->is_in_stock() || LGS_Products::lgs_pseudo_out_of_stock($product->get_id())): ?>

  <?php if('yes' == get_post_meta($product->get_id(),'_show_soldout_instead_outofstock',true)): ?>

    <?php echo apply_filters('woocommerce_sale_flash_outofstock', '<span class="btn-badge onoutofstock">'.esc_html__('Sold Out!', 'woocommerce').'</span>', $post, $product); ?>

  <?php else: ?>

    <?php echo apply_filters('woocommerce_sale_flash_outofstock', '<span class="btn-badge onoutofstock">'.esc_html__('Out of Stock!', 'woocommerce').'</span>', $post, $product); ?>

  <?php endif; ?>

<?php elseif($product->is_on_sale()) : ?>

  <?php echo apply_filters('woocommerce_sale_flash', '<span class="btn-badge onsale">'.esc_html__('Sale!', 'woocommerce').'</span>', $post, $product); ?>

<?php endif;

  /* Omit closing PHP tag at the end of PHP files to avoid "headers already sent" issues. */
