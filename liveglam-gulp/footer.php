<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Liveglam
 */
?>

<?php if( ( is_account_page() && is_user_logged_in() )
    || is_post_type_archive( array('monthly_brushes','monthly_lipstick','monthly_eyeshadows') )
    || ( is_post_type_archive(array('product')) && is_user_logged_in() )
    || ( is_product() && is_user_logged_in() )
    || is_page( array('rewards') ) ) :
    wc_get_template( 'lg-footer-dashboard.php' );
elseif ( is_page(LGS_CONFIRMATION_PAGES) ):
    wc_get_template( 'lg-footer-confirmation.php' );
elseif ( is_checkout() || is_page(PAGE_PRE_CHECKOUT) || is_page('pre-checkout2') ):
    wc_get_template( 'lg-footer-checkout.php' );
else :
    wc_get_template( 'lg-footer-homepage.php' );
endif;
?>

<?php wp_footer(); ?>

<!--call jPushMenu, required-->
<script>
    jQuery(document).ready(function() {
        jQuery(".toggle-menu").jPushMenu({
            activeClass: 'menu-active is-active',
        });
        jQuery(window).bind('load',function () {
            /* replace images user is broken */
            jQuery("img.image-blog-author").each(function () {

                if((typeof this.naturalWidth != "undefined" && this.naturalWidth == 0 ) || this.readyState == 'uninitialized' ) {

                    jQuery(this).attr('src', '<?php echo get_stylesheet_directory_uri();?>/assets/img/avatar_placeholder.svg');
                }
            });
            /* replace images title blog is broken */
            jQuery("img.image-blog.image-blog-small").each(function () {

                if((typeof this.naturalWidth != "undefined" && this.naturalWidth == 0 ) || this.readyState == 'uninitialized' ) {

                    jQuery(this).attr('src', '<?php echo get_stylesheet_directory_uri();?>/assets/img/image-broken-small.jpg');
                }
            });
            jQuery("img.image-blog.image-blog-large").each(function () {

                if((typeof this.naturalWidth != "undefined" && this.naturalWidth == 0 ) || this.readyState == 'uninitialized' ) {

                    jQuery(this).attr('src', '<?php echo get_stylesheet_directory_uri();?>/assets/img/image-broken-large.jpg');
                }
            });
        });
    });
</script>
<input type="hidden" id="LGP_2592" data-title="MorpheMe Monthly Subscription" data-price="19.99">
<input type="hidden" id="LGP_9999477214" data-title="MorpheMe 6-Months Subscription" data-price="109.99">
<input type="hidden" id="LGP_2591" data-title="MorpheMe Annual Subscription" data-price="219.99">
<input type="hidden" id="LGP_9999995176" data-title="KissMe Monthly Subscription" data-price="19.99">
<input type="hidden" id="LGP_9999995195" data-title="KissMe 6-Months Subscription" data-price="109.99">
<input type="hidden" id="LGP_9999995199" data-title="KissMe Annual Subscription" data-price="219.99">
<input type="hidden" id="LGP_10002876000" data-title="ShadowMe Bi-Monthly Subscription" data-price="19.99">
<input type="hidden" id="LGP_10002876001" data-title="ShadowMe 6-Months Subscription" data-price="54.99">
<input type="hidden" id="LGP_10002876002" data-title="ShadowMe Annual Subscription" data-price="109.99">
<?php
global $product;
$page_id = get_the_ID();
if(!empty($product) && is_object($product)){
    $product_title = $product->get_title();
    $product_id = $product->get_id();
    $product_price = $product->get_price('float');
    $product_type = 'Shop';
}else{

  $product_type = 'Subscription';
  if(!WC()->cart->is_empty() && is_checkout()){
    foreach(WC()->cart->get_cart_contents() as $item){
      if(!empty($item['product_id'])){
        $ViewContentProduct = wc_get_product($item['product_id']);
      }
    }
  }
  if(in_array($page_id,array(PAGE_KISSME_ID,9999995205))){
    $ViewContentProduct = wc_get_product(9999995176);
  }
  if(in_array($page_id,array(PAGE_SHADOWME_ID,10002876224))){
    $ViewContentProduct = wc_get_product(10002876000);
  }

  if (empty($ViewContentProduct)) {
    $ViewContentProduct = wc_get_product(2592);
  }
  $product_title = $ViewContentProduct->get_title();
  $product_id = $ViewContentProduct->get_id();
  $product_price = $ViewContentProduct->get_price('float');
  $product_type = ucfirst($ViewContentProduct->get_type());
}

if(!empty($_GET['order_id'])){

  // sm live 10007048408,10007048414 facelift 15000041556,15000041571
  $is_mm = array(	9999511607, 10000065065);
  $is_km = array(	9999995207, 9999995229);
  $is_sm = array(	10007048408,10007048414);
  $is_shop = array( 10005383715,15000039383 ); //15000039383 is facelift shop order confirmation
  if(in_array($page_id, $is_mm)
    || in_array($page_id, $is_km)
    || in_array($page_id, $is_sm) || in_array($page_id, $is_shop) ){
    $order = wc_get_order($_GET['order_id']);
    if($order !== false){
      $eventName = '';

      if(!empty($order->get_meta('shop_order_individual', true))){
        $eventName = 'ShopPurchase';
        $_product_title = 'Shop Purchase';
        $_product_price = $order->get_total();
        $_product_type = 'Shop';
      }


      foreach ($order->get_items() as $item) {
        if (in_array($item['product_id'], lgs_product_sm) || in_array($item['product_id'], lgs_product_mm) || in_array($item['product_id'], lgs_product_km)) {
          if (in_array($item['product_id'], lgs_product_sm)) {
            if ($order->get_status() == 'waitlist') {
              $eventName = 'ShadowMeWaitlist';
            } elseif ($order->get_status() == 'processing') {
              $eventName = 'Shadowme Subscription';
            }
          }
          if (in_array($item['product_id'], lgs_product_km)) {
            if ($order->get_status() == 'waitlist') {
              $eventName = 'KissMeWaitlist';
            } elseif ($order->get_status() == 'processing') {
              $eventName = 'Kissme Subscription';
            }
          }
          if (in_array($item['product_id'], lgs_product_mm)) {
            if ($order->get_status() == 'waitlist') {
              $eventName = 'MorpheMeWaitlist';
            } elseif ($order->get_status() == 'processing') {
              $eventName = 'Morpheme Subscription';
            }
          }

          $_product = wc_get_product($item['product_id']);
          $product_title = $_product_title = $_product->get_title();
          $product_id = $_product_id = $_product->get_id();
          $product_price = $_product_price = $_product->get_price('float');
          $product_type = $_product_type = 'Subscription';
          break;
        }
        elseif ($eventName == 'ShopPurchase') {
          $product_ids[] = $item['product_id'];
        }
      }

      if (!empty($product_ids)) $_product_id = implode("','", $product_ids);
      if (!empty($eventName)):
      ?>
      <script>
          fbq('trackCustom', '<?php echo $eventName;?>', {
              content_name: '<?php echo $_product_title?>',
              content_category: '<?php echo $_product_type;?>',
              content_ids: ['<?php echo $_product_id?>'],
              content_type: 'product',
              value: <?php echo $_product_price?>,
              currency: 'USD'
          });
      </script>
      <?php
      endif;
    }
  }
}
?>

<script>
    fbq('track', 'ViewContent', {
        content_name: '<?php echo esc_html($product_title); ?>',
        content_category: '<?php echo $product_type;?>',
        content_ids: ['<?php echo $product_id?>'],
        content_type: 'product',
        value: <?php echo $product_price?>,
        currency: 'USD'
    });
    jQuery(document).ready(function(){
        var mm_productids = [<?php echo implode(",",lgs_product_mm)?>],
            km_productids = [<?php echo implode(",",lgs_product_km)?>],
            sm_productids = [<?php echo implode(",",lgs_product_sm)?>];
        jQuery('.btn-proceed.last-step .club-cta').click(function(){
            var current = jQuery(this),
                club = jQuery('input[name="lgs-preck-select-club"]').val(),
                product = jQuery('.choose-club-plan.choose-'+club+' .club-plan.active').data('product'),
                title = jQuery('#LGP_'+product).data('title'),
                price = jQuery('#LGP_'+product).data('price');
            var track = 'trackCustom',
                trackEventName = '';
            if(jQuery.inArray(product, mm_productids)>=0){
                trackEventName = 'InitiateCheckoutMorph';
            }
            if(jQuery.inArray(product, km_productids)>=0){
                trackEventName = 'InitiateCheckoutKiss';
            }
            if(jQuery.inArray(product, sm_productids)>=0){
                trackEventName = 'InitiateCheckoutShadow';
            }
            
            if(trackEventName != ''){
                fbq(track, trackEventName, {
                    content_name: title,
                    content_category: 'Subscription',
                    content_ids: ["'"+product+"'"],
                    content_type: 'product',
                    value: price,
                    currency: 'USD'
                });
            }
        });

        jQuery('.club-slider .club-cta').click(function(e){
            e.preventDefault();
            var current = jQuery(this),
                product_type = current.data('producttype');
            var track = 'trackCustom',
                trackEventName = '',
                productid = '';

                if (product_type == 'morpheme')productid = 2592;
                if (product_type == 'kissme')productid = 9999995176;
                if (product_type == 'shadowme')productid = 10002876000;

            var title = jQuery('#LGP_'+productid).data('title'),
                price = jQuery('#LGP_'+productid).data('price');
            if(jQuery.inArray(productid, mm_productids)>=0){
                trackEventName = 'PreCheck1Morph';
            }
            if(jQuery.inArray(productid, km_productids)>=0){
                trackEventName = 'PreCheck1Kiss';
            }
            if(jQuery.inArray(productid, sm_productids)>=0){
                trackEventName = 'PreCheck1Shadow';
            }

            if(trackEventName != ''){
                fbq(track, trackEventName, {
                    content_name: title,
                    content_category: 'Subscription',
                    content_ids: ["'"+productid+"'"],
                    content_type: 'product',
                    value: price,
                    currency: 'USD'
                });
            }
            window.location = current.attr('href');
        });
        jQuery('.add_to_bag').click(function(){
            var current = jQuery(this),
                product = current.data('product_id'),
                title = current.closest('.product-item-bottom').find('.product-item-title h2').text(),
                price = parseFloat(current.closest('.product-item-action').find('.price').text().slice(2));
            fbq('track', 'AddToCart', {
                content_name: title,
                content_category: 'Shop',
                content_ids: ["'"+product+"'"],
                content_type: 'product',
                value: price,
                currency: 'USD'
            });
        });
        jQuery('.single_add_to_cart_button').click(function(){
            var current = jQuery(this),
                product = current.val(),
                title = current.closest('.entry-summary').find('.single-collection-title').text(),
                price = parseFloat(current.closest('.single-product-action').find('.price').text().slice(2));
            fbq('track', 'AddToCart', {
                content_name: title,
                content_category: 'Shop',
                content_ids: ["'"+product+"'"],
                content_type: 'product',
                value: price,
                currency: 'USD'
            });
        });
    })
</script>

<script type="text/javascript">
  jQuery(window).on('load',function () {
    lgs_check_target_scroll();
    function lgs_check_target_scroll() {
      if( window.location.hash != '' && window.location.href.split("#")[1] != "undefined" ){
        var target = jQuery(window.location.hash);
        if( target.length > 0 ) {
          lgs_scroll_to_element(target);
        }
      }
    }
  });
</script>