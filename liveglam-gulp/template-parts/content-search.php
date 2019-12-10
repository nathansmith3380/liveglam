<?php
/**
 * Template part for displaying results in search pages.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Liveglam
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<a class="lg-search-result" href="<?php echo get_permalink(); ?>">
		<div class="result-content text-left">
			<h4 class="result-title"><?php the_title(); ?></h4>

			<?php $show_image = false;
			if (get_post_type() == 'product') {
				$product = wc_get_product( $post );
				if (!empty($product->get_image_id())) {
					$show_image = true;
				}
			} ?>

			<div class="result-description">
				<?php  $content = (get_post_type() == 'product') ? $product->get_short_description() : get_the_content();
				$content = html_entity_decode(strip_tags($content));
				echo substr($content, 0, 400); ?>
			</div><!-- .entry-summary -->

			<footer class="result-footer">
				<span class="result-tag"><?php echo (get_post_type() == 'post') ? 'blog' : get_post_type(); ?></span>
				<span class="result-link">View ></span>
			</footer><!-- .entry-footer -->
		</div>
	
		<?php if (get_post_type() == 'product'): 
			if (!empty($show_image)): ?>
				<div class="result-image"><?php echo $product->get_image('thumbnail'); ?></div>
			<?php endif; ?>
		<?php endif; ?>
	</a>
</article><!-- #post-## -->

