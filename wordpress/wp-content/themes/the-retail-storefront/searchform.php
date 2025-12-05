<?php
/**
 * The template for displaying search form.
 *
 * @package The Retail Storefront
 * @since 1.0
 */
?>

<form method="get" class="search-form" action="<?php echo esc_url( home_url( '/' ) ); ?>">
	<label>
		<span class="screen-reader-text"><?php esc_html_e( 'Search for:', 'the-retail-storefront' ); ?></span>
		<input type="search" class="search-field" placeholder="<?php esc_attr_e( 'Search …', 'the-retail-storefront' ); ?>" value="" name="s">
	</label>
	<button type="submit" class="search-submit" value="<?php esc_attr_e( 'Search', 'the-retail-storefront' ); ?>">
		<i class="fa fa-search"></i>
	</button>
</form>