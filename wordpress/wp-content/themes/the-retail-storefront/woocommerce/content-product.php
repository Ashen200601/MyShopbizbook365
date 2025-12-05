<?php
/**
 * The template for displaying product content within loops
 */

defined( 'ABSPATH' ) || exit;

global $product;

// Ensure visibility.
if ( empty( $product ) || ! $product->is_visible() ) {
	return;
}
?>
<li <?php wc_product_class( '', $product ); ?>>
	<div class="product">
		<div class="product-single">
			<div class="product-img">
				<?php
				/**
				 * Hook: woocommerce_before_shop_loop_item.
				 *
				 * @hooked woocommerce_template_loop_product_link_open - 10
				 */
				do_action( 'woocommerce_before_shop_loop_item' );
				?>
				<a href="<?php echo esc_url(get_permalink()); ?>">
					<?php
					if ( has_post_thumbnail() ) {
						the_post_thumbnail();
					} else {
						// Placeholder image URL
						$the_retail_storefront_placeholder_image_url = get_template_directory_uri() . '/assets/images/woo-placeholder.png'; // Adjust the path as needed
						echo '<img src="' . esc_url( $the_retail_storefront_placeholder_image_url ) . '" alt="' . esc_attr__( 'Placeholder Image', 'the-retail-storefront' ) . '" />';
					}
					?>
				</a>
				
				<?php if ( $product->is_on_sale() ) : ?>

				<?php echo apply_filters( 'woocommerce_sale_flash', '<div class="sale-ribbon"><span class="tag-line">' . esc_html__( 'Sale', 'the-retail-storefront' ) . '</span></div>', $post, $product ); ?>
				<?php endif; ?>
				<div class="product-action">			
					<?php

					/**
					 * Hook: woocommerce_after_shop_loop_item.
					 *
					 * @hooked woocommerce_template_loop_product_link_close - 5
					 * @hooked woocommerce_template_loop_add_to_cart - 10
					 */
					do_action( 'woocommerce_after_shop_loop_item' );
					?>
				</div>
			</div>
			<div class="product-content-outer">
				<div class="product-content">
					<div class="pro-rating">
						<?php if ($average = $product->get_average_rating()) : ?>
						<?php /* translators: %s: Rated 1 out of 5. */ echo '<div class="star-rating" title="'.sprintf(__( 'Rated %s out of 5', 'the-retail-storefront' ), $average).'"><span style="width:'.( ( $average / 5 ) * 100 ) . '%"><strong itemprop="ratingValue" class="rating">'.$average.'</strong> '.__( 'out of 5', 'the-retail-storefront' ).'</span></div>'; ?>
						<?php endif; ?>
					</div>
					<h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
					<div class="price">
						<?php echo $product->get_price_html(); ?>
					</div>
				</div>
			</div>
		</div>
	</div>
</li>