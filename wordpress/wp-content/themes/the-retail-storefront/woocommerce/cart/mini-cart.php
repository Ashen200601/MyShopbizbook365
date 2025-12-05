<?php
/**
 * Mini-cart
 */

defined( 'ABSPATH' ) || exit;

do_action( 'woocommerce_before_mini_cart' ); ?>

<?php if ( ! WC()->cart->is_empty() ) : ?>
	<div class="shopping-cart-header">
		<div class="cart-icon">
			<svg width="20" height="21"><path d="M19.167 6.769 20 10.76c0 .435-.35.787-.781.787h-.514l-.721 6.544a.784.784 0 0 1-.863.695.786.786 0 0 1-.689-.871l.798-7.243a.784.784 0 0 1 .777-.7h.431V8.397H1.563v1.575h16.653c.432 0 .781.354.781.788a.783.783 0 0 1-.781.787H2.882l.771 6.489a1.568 1.568 0 0 0 1.552 1.388h9.653c.796 0 1.464-.602 1.553-1.4a.783.783 0 0 1 .863-.694.785.785 0 0 1 .689.87 3.131 3.131 0 0 1-3.105 2.799H5.205a3.136 3.136 0 0 1-3.103-2.776l-.794-6.676H.781A.784.784 0 0 1 0 10.76V7.609c0-.435.35-.787.781-.787h2.771L9.347.317a.778.778 0 0 1 1.092-.169.792.792 0 0 1 .167 1.102L5.491 6.822h9.047L9.422 1.25A.793.793 0 0 1 9.59.148a.778.778 0 0 1 1.092.169l5.795 6.505h2.742c.431 0-.052-.488-.052-.053ZM9.219 13.91v3.151c0 .435.349.787.781.787a.784.784 0 0 0 .781-.787V13.91a.784.784 0 0 0-.781-.787.783.783 0 0 0-.781.787Zm3.125 0v3.151c0 .435.349.787.781.787a.784.784 0 0 0 .781-.787V13.91a.784.784 0 0 0-.781-.787.783.783 0 0 0-.781.787Zm-6.25 0v3.151c0 .435.35.787.781.787a.784.784 0 0 0 .781-.787V13.91a.784.784 0 0 0-.781-.787.784.784 0 0 0-.781.787Z"/></svg>
			<?php 
				if ( in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) {
					$count = WC()->cart->cart_contents_count;
					$cart_url = wc_get_cart_url();
					
					if ( $count > 0 ) {
					?>
						 <span class="badge"><?php echo esc_html( $count ); ?></span>
					<?php 
					}
					else {
						?>
						<span class="badge"><?php echo esc_html('0','the-retail-storefront'); ?></span>
						<?php 
					}
				}
			?>
		</div>
		<h3><?php _e( 'Total:', 'the-retail-storefront' ); ?> <?php echo WC()->cart->get_cart_subtotal(); ?></h3>
	</div>
	<ul class="woocommerce-mini-cart cart_list product_list_widget cart-items shopping-cart-items">
		<?php
		do_action( 'woocommerce_before_mini_cart_contents' );

		foreach ( WC()->cart->get_cart() as $cart_item_key => $cart_item ) {
			$_product   = apply_filters( 'woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key );
			$product_id = apply_filters( 'woocommerce_cart_item_product_id', $cart_item['product_id'], $cart_item, $cart_item_key );

			if ( $_product && $_product->exists() && $cart_item['quantity'] > 0 && apply_filters( 'woocommerce_widget_cart_item_visible', true, $cart_item, $cart_item_key ) ) {
				$product_name      = apply_filters( 'woocommerce_cart_item_name', $_product->get_name(), $cart_item, $cart_item_key );
				$thumbnail         = apply_filters( 'woocommerce_cart_item_thumbnail', $_product->get_image(), $cart_item, $cart_item_key );
				$product_price     = apply_filters( 'woocommerce_cart_item_price', WC()->cart->get_product_price( $_product ), $cart_item, $cart_item_key );
				$product_permalink = apply_filters( 'woocommerce_cart_item_permalink', $_product->is_visible() ? $_product->get_permalink( $cart_item ) : '', $cart_item, $cart_item_key );
				?>
				<li class="woocommerce-mini-cart-item <?php echo esc_attr( apply_filters( 'woocommerce_mini_cart_item_class', 'mini_cart_item', $cart_item, $cart_item_key ) ); ?>">
					<?php
					echo apply_filters( // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
						'woocommerce_cart_item_remove_link',
						sprintf(
							'<a href="%s" class="remove remove_from_cart_button" aria-label="%s" data-product_id="%s" data-cart_item_key="%s" data-product_sku="%s">&times;</a>',
							esc_url( wc_get_cart_remove_url( $cart_item_key ) ),
							esc_attr__( 'Remove this item', 'the-retail-storefront' ),
							esc_attr( $product_id ),
							esc_attr( $cart_item_key ),
							esc_attr( $_product->get_sku() )
						),
						$cart_item_key
					);
					?>
					<?php if ( empty( $product_permalink ) ) : ?>
						<div class="cart-img">
							<?php echo $thumbnail; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
						</div>
						
						<div class="media-body">
							<h4><?php echo $product_name; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?> 
							<?php echo apply_filters( 'woocommerce_widget_cart_item_quantity', '<span class="quantity item-price">' . sprintf( '%s &times; %s', $cart_item['quantity'], $product_price ) . '</span>', $cart_item, $cart_item_key ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
							</h4> 
						</div>
					<?php else : ?>
						<a href="<?php echo esc_url( $product_permalink ); ?>">
							<div class="cart-img">
								<?php echo $thumbnail; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
							</div>
							<div class="media-body">
								<h4><?php echo $product_name; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?> 
								<?php echo apply_filters( 'woocommerce_widget_cart_item_quantity', '<span class="quantity item-price">' . sprintf( '%s &times; %s', $cart_item['quantity'], $product_price ) . '</span>', $cart_item, $cart_item_key ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
								</h4> 
							</div>
						</a>
					<?php endif; ?>
					<?php echo wc_get_formatted_cart_item_data( $cart_item ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
				</li>
				<?php
			}
		}

		do_action( 'woocommerce_mini_cart_contents' );
		?>
	</ul>

	

	<?php do_action( 'woocommerce_widget_shopping_cart_before_buttons' ); ?>

	<a href="<?php echo esc_url( wc_get_checkout_url() ); ?>" class="theme-button"><?php echo esc_html_e('Checkout','the-retail-storefront'); ?> </a>

	<?php do_action( 'woocommerce_widget_shopping_cart_after_buttons' ); ?>

<?php else : ?>

	<p class="woocommerce-mini-cart__empty-message"><?php esc_html_e( 'No products in the cart.', 'the-retail-storefront' ); ?></p>

<?php endif; ?>

<?php do_action( 'woocommerce_after_mini_cart' ); ?>


<?php 
/**
 * Show cart contents / total Ajax
 */
add_filter( 'woocommerce_add_to_cart_fragments', 'woocommerce_header_add_to_cart_fragment' );

function woocommerce_header_add_to_cart_fragment( $fragments ) {
	global $woocommerce;

	ob_start();

	?>
<li class="shopping-cart">
	<?php if ( ! WC()->cart->is_empty() ) : ?>
		<div class="shopping-cart-header">
			<div class="cart-icon">
				<svg width="20" height="21"><path d="M19.167 6.769 20 10.76c0 .435-.35.787-.781.787h-.514l-.721 6.544a.784.784 0 0 1-.863.695.786.786 0 0 1-.689-.871l.798-7.243a.784.784 0 0 1 .777-.7h.431V8.397H1.563v1.575h16.653c.432 0 .781.354.781.788a.783.783 0 0 1-.781.787H2.882l.771 6.489a1.568 1.568 0 0 0 1.552 1.388h9.653c.796 0 1.464-.602 1.553-1.4a.783.783 0 0 1 .863-.694.785.785 0 0 1 .689.87 3.131 3.131 0 0 1-3.105 2.799H5.205a3.136 3.136 0 0 1-3.103-2.776l-.794-6.676H.781A.784.784 0 0 1 0 10.76V7.609c0-.435.35-.787.781-.787h2.771L9.347.317a.778.778 0 0 1 1.092-.169.792.792 0 0 1 .167 1.102L5.491 6.822h9.047L9.422 1.25A.793.793 0 0 1 9.59.148a.778.778 0 0 1 1.092.169l5.795 6.505h2.742c.431 0-.052-.488-.052-.053ZM9.219 13.91v3.151c0 .435.349.787.781.787a.784.784 0 0 0 .781-.787V13.91a.784.784 0 0 0-.781-.787.783.783 0 0 0-.781.787Zm3.125 0v3.151c0 .435.349.787.781.787a.784.784 0 0 0 .781-.787V13.91a.784.784 0 0 0-.781-.787.783.783 0 0 0-.781.787Zm-6.25 0v3.151c0 .435.35.787.781.787a.784.784 0 0 0 .781-.787V13.91a.784.784 0 0 0-.781-.787.784.784 0 0 0-.781.787Z"/></svg>
				<?php 
					if ( in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) {
						$count = WC()->cart->cart_contents_count;
						$cart_url = wc_get_cart_url();
						
						if ( $count > 0 ) {
						?>
							 <span class="badge"><?php echo esc_html( $count ); ?></span>
						<?php 
						}
						else {
							?>
							<span class="badge"><?php echo esc_html('0','the-retail-storefront'); ?></span>
							<?php 
						}
					}
				?>
			</div>
			<h3><?php _e( 'Total:', 'the-retail-storefront' ); ?> <?php echo WC()->cart->get_cart_subtotal(); ?></h3>
		</div>
		<ul class="woocommerce-mini-cart cart_list product_list_widget cart-items shopping-cart-items">
			<?php
			do_action( 'woocommerce_before_mini_cart_contents' );

			foreach ( WC()->cart->get_cart() as $cart_item_key => $cart_item ) {
				$_product   = apply_filters( 'woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key );
				$product_id = apply_filters( 'woocommerce_cart_item_product_id', $cart_item['product_id'], $cart_item, $cart_item_key );

				if ( $_product && $_product->exists() && $cart_item['quantity'] > 0 && apply_filters( 'woocommerce_widget_cart_item_visible', true, $cart_item, $cart_item_key ) ) {
					$product_name      = apply_filters( 'woocommerce_cart_item_name', $_product->get_name(), $cart_item, $cart_item_key );
					$thumbnail         = apply_filters( 'woocommerce_cart_item_thumbnail', $_product->get_image(), $cart_item, $cart_item_key );
					$product_price     = apply_filters( 'woocommerce_cart_item_price', WC()->cart->get_product_price( $_product ), $cart_item, $cart_item_key );
					$product_permalink = apply_filters( 'woocommerce_cart_item_permalink', $_product->is_visible() ? $_product->get_permalink( $cart_item ) : '', $cart_item, $cart_item_key );
					?>
					<li class="woocommerce-mini-cart-item <?php echo esc_attr( apply_filters( 'woocommerce_mini_cart_item_class', 'mini_cart_item', $cart_item, $cart_item_key ) ); ?>">
						<?php
						echo apply_filters( // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
							'woocommerce_cart_item_remove_link',
							sprintf(
								'<a href="%s" class="remove remove_from_cart_button" aria-label="%s" data-product_id="%s" data-cart_item_key="%s" data-product_sku="%s">&times;</a>',
								esc_url( wc_get_cart_remove_url( $cart_item_key ) ),
								esc_attr__( 'Remove this item', 'the-retail-storefront' ),
								esc_attr( $product_id ),
								esc_attr( $cart_item_key ),
								esc_attr( $_product->get_sku() )
							),
							$cart_item_key
						);
						?>
						<?php if ( empty( $product_permalink ) ) : ?>
							<div class="cart-img">
								<?php echo $thumbnail; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
							</div>
							
							<div class="media-body">
								<h4><?php echo $product_name; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?> 
								<?php echo apply_filters( 'woocommerce_widget_cart_item_quantity', '<span class="quantity item-price">' . sprintf( '%s &times; %s', $cart_item['quantity'], $product_price ) . '</span>', $cart_item, $cart_item_key ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
								</h4> 
							</div>
						<?php else : ?>
							<a href="<?php echo esc_url( $product_permalink ); ?>">
								<div class="cart-img">
									<?php echo $thumbnail; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
								</div>
								
								<div class="media-body">
									<h4><?php echo $product_name; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?> 
									<?php echo apply_filters( 'woocommerce_widget_cart_item_quantity', '<span class="quantity item-price">' . sprintf( '%s &times; %s', $cart_item['quantity'], $product_price ) . '</span>', $cart_item, $cart_item_key ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
									</h4> 
								</div>
							</a>
						<?php endif; ?>
						<?php echo wc_get_formatted_cart_item_data( $cart_item ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
					</li>
					<?php
				}
			}

			do_action( 'woocommerce_mini_cart_contents' );
			?>
		</ul>
	

		<?php do_action( 'woocommerce_widget_shopping_cart_before_buttons' ); ?>

		
		<a href="<?php echo esc_url( wc_get_checkout_url() ); ?>" class="theme-button"><?php echo esc_html('Checkout','the-retail-storefront'); ?> </a>

		<?php do_action( 'woocommerce_widget_shopping_cart_after_buttons' ); ?>

	<?php else : ?>

		<p class="woocommerce-mini-cart__empty-message"><?php esc_html_e( 'No products in the cart.', 'the-retail-storefront' ); ?></p>

	<?php endif; ?>

	<?php do_action( 'woocommerce_after_mini_cart' ); ?>
</li>	
	<?php
	$fragments['li.shopping-cart'] = ob_get_clean();
	return $fragments;
}
