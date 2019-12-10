<?php
/**
 * Related Products
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/related.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see 	    https://docs.woocommerce.com/document/template-structure/
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     3.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( $related_products ) : ?>

  <div class="products-shop products-related" id="products-related">

        <div class="list-individual" data-perpage="4" data-perpage-mobile="4">

          <p class="products-shop-title"><?php esc_html_e( 'You Might Also Like', 'woocommerce' ); ?></p>

    <div class="product-items">

        <ul class="products owl-carousel owl-theme">

			<?php foreach ( $related_products as $related_product ) : ?>

        <?php if(!$related_product->is_in_stock() || LGS_Products::lgs_pseudo_out_of_stock($related_product->get_id())) continue; ?>

				<?php
				 	$post_object = get_post( $related_product->get_id() );

					setup_postdata( $GLOBALS['post'] =& $post_object );

					wc_get_template_part( 'content', 'product' ); ?>

			<?php endforeach; ?>

        </ul>

    </div>

          <div class="newdesign-pagination pg-nav">
            <nav class="text-center" aria-label="Page navigation">
              <ul class="pagination pagination-related" id="pagination-related"></ul>
            </nav>
          </div>

        </div>

  </div>

<?php endif;

wp_reset_postdata();
