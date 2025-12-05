<?php
/**
 * Custom functions that act independently of the theme templates.
 *
 * Eventually, some of the functionality here could be replaced by core features.
 *
 * @package The Retail Storefront
 */

/**
 * Adds custom classes to the array of body classes.
 *
 * @param array $the_retail_storefront_classes Classes for the body element.
 * @return array
 */
function the_retail_storefront_body_classes( $the_retail_storefront_classes ) {
	// Adds a class of group-blog to blogs with more than 1 published author.
	if ( is_multi_author() ) {
		$the_retail_storefront_classes[] = 'group-blog';
	}

	// Adds a class of hfeed to non-singular pages.
	if ( ! is_singular() ) {
		$the_retail_storefront_classes[] = 'hfeed';
	}

	return $the_retail_storefront_classes;
}
add_filter( 'body_class', 'the_retail_storefront_body_classes' );

if ( ! function_exists( 'wp_body_open' ) ) {
	/**
	 * Backward compatibility for wp_body_open hook.
	 *
	 * @since 1.0.0
	 */
	function wp_body_open() {
		do_action( 'wp_body_open' );
	}
}

 /**
 * Breadcrumb Title
 */
 
if ( ! function_exists( 'the_retail_storefront_breadcrumb_title' ) ) {
	function the_retail_storefront_breadcrumb_title() {
		
		if ( is_home() || is_front_page()):
			
			single_post_title();
			
		elseif ( is_day() ) : 
		/* translators: %s: Daily Archives. */
			printf( __( 'Daily Archives: %s', 'the-retail-storefront' ), get_the_date() );
		
		elseif ( is_month() ) :
		/* translators: %s: Monthly Archives. */
			printf( __( 'Monthly Archives: %s', 'the-retail-storefront' ), (get_the_date( 'F Y' ) ));
		
		elseif ( is_year() ) :
		/* translators: %s: Yearly Archives. */
			printf( __( 'Yearly Archives: %s', 'the-retail-storefront' ), (get_the_date( 'Y' ) ) );
			
		elseif ( is_category() ) :
		/* translators: %s: Category Archives. */
			printf( __( 'Category Archives: %s', 'the-retail-storefront' ), (single_cat_title( '', false ) ));

		elseif ( is_tag() ) :
		/* translators: %s: Tag Archives. */
			printf( __( 'Tag Archives: %s', 'the-retail-storefront' ), (single_tag_title( '', false ) ));
			
		elseif ( is_404() ) :

			printf( __( 'Error 404', 'the-retail-storefront' ));
			
		elseif ( is_author() ) :
		/* translators: %s: Author. */
			printf( __( 'Author: %s', 'the-retail-storefront' ), (get_the_author( '', false ) ));		
			
		elseif ( class_exists( 'woocommerce' ) ) : 
			
			if ( is_shop() ) {
				woocommerce_page_title();
			}
			
			elseif ( is_cart() ) {
				the_title();
			}
			
			elseif ( is_checkout() ) {
				the_title();
			}
			
			else {
				the_title();
			}
		else :
				the_title();
				
		endif;
	}
}

 /**
 * Breadcrumb Content
 */

function the_retail_storefront_breadcrumbs() {
	
	$showOnHome	= esc_html__('1','the-retail-storefront'); 	// 1 - Show breadcrumbs on the homepage, 0 - don't show
	$delimiter 	= '';   // Delimiter between breadcrumb
	$home 		= esc_html__('Home','the-retail-storefront'); 	// Text for the 'Home' link
	$showCurrent= esc_html__('1','the-retail-storefront'); // Current post/page title in breadcrumb in use 1, Use 0 for don't show
	$before		= '<li class="active">'; // Tag before the current Breadcrumb
	$after 		= '</li>'; // Tag after the current Breadcrumb
	$seprator	= get_theme_mod('the_retail_storefront_breadcrumb_seprator','/');
	global $post;
	$homeLink = home_url();

	if (is_home() || is_front_page()) {
 
	if ($showOnHome == 1) echo '<li><a href="' . esc_url($homeLink) . '">' . esc_html($home) . '</a></li>';
 
	} else {
 
    echo '<li><a href="' . esc_url($homeLink) . '">' . esc_html($home) . '</a> ' . '&nbsp' . wp_kses_post($seprator) . '&nbsp';
 
    if ( is_category() ) 
	{
		$thisCat = get_category(get_query_var('cat'), false);
		if ($thisCat->parent != 0) echo get_category_parents($thisCat->parent, TRUE, ' ' . ' ');
		echo $before . esc_html__('Archive by category','the-retail-storefront').' "' . esc_html(single_cat_title('', false)) . '"' .$after;
		
	} 
	
	elseif ( is_search() ) 
	{
		echo $before . esc_html__('Search results for','the-retail-storefront').' "' . esc_html(get_search_query()) . '"' . $after;
	} 
	
	elseif ( is_day() )
	{
		echo '<a href="' . esc_url(get_year_link(get_the_time('Y'))) . '">' . esc_html(get_the_time('Y')) . '</a> ' . '&nbsp' . wp_kses_post($seprator) . '&nbsp';
		echo '<a href="' . esc_url(get_month_link(get_the_time('Y'),get_the_time('m'))) . '">' . esc_html(get_the_time('F')) . '</a> '. '&nbsp' . wp_kses_post($seprator) . '&nbsp';
		echo $before . esc_html(get_the_time('d')) . $after;
	} 
	
	elseif ( is_month() )
	{
		echo '<a href="' . esc_url(get_year_link(get_the_time('Y'))) . '">' . esc_html(get_the_time('Y')) . '</a> ' . esc_attr($delimiter) . '&nbsp' . wp_kses_post($seprator) . '&nbsp';
		echo $before . esc_html(get_the_time('F')) . $after;
	} 
	
	elseif ( is_year() )
	{
		echo $before . esc_html(get_the_time('Y')) . $after;
	} 
	
	elseif ( is_single() && !is_attachment() )
	{
		if ( get_post_type() != 'post' )
		{
			if ( class_exists( 'WooCommerce' ) ) {
				if ($showCurrent == 1) echo ' ' . esc_attr($delimiter) . '&nbsp&nbsp' . $before . wp_kses_post(get_the_title()) . $after;
			}else{	
			$post_type = get_post_type_object(get_post_type());
			$slug = $post_type->rewrite;
			echo '<a href="' . esc_url($homeLink) . '/' . $slug['slug'] . '/">' . $post_type->labels->singular_name . '</a>';
			if ($showCurrent == 1) echo ' ' . esc_attr($delimiter) . '&nbsp' . wp_kses_post($seprator) . '&nbsp' . $before . wp_kses_post(get_the_title()) . $after;
			}
		}
		else
		{
			$cat = get_the_category(); $cat = $cat[0];
			$cats = get_category_parents($cat, TRUE, ' ' . esc_attr($delimiter) . '&nbsp' . wp_kses_post($seprator) . '&nbsp');
			if ($showCurrent == 0) $cats = preg_replace("#^(.+)\s$delimiter\s$#", "$1", $cats);
			echo $cats;
			if ($showCurrent == 1) echo $before . esc_html(get_the_title()) . $after;
		}
 
    }
		
	elseif ( !is_single() && !is_page() && get_post_type() != 'post' && !is_404() ) {
		if ( class_exists( 'WooCommerce' ) ) {
			if ( is_shop() ) {
				$thisshop = woocommerce_page_title();
			}
		}	
		else  {
			$post_type = get_post_type_object(get_post_type());
			echo $before . $post_type->labels->singular_name . $after;
		}	
	} 
	
	elseif ( !is_single() && !is_page() && get_post_type() != 'post' && !is_404() ) 
	{
		$post_type = get_post_type_object(get_post_type());
		echo $before . $post_type->labels->singular_name . $after;
	} 
	
	elseif ( is_attachment() ) 
	{
		$parent = get_post($post->post_parent);
		$cat = get_the_category($parent->ID); 
		if(!empty($cat)){
		$cat = $cat[0];
		echo get_category_parents($cat, TRUE, ' ' . esc_attr($delimiter) . '&nbsp' . wp_kses_post($seprator) . '&nbsp');
		}
		echo '<a href="' . esc_url(get_permalink($parent)) . '">' . $parent->post_title . '</a>';
		if ($showCurrent == 1) echo ' ' . esc_attr($delimiter) . ' ' . $before . esc_html(get_the_title()) . $after;
 
    } 
	
	elseif ( is_page() && !$post->post_parent ) 
	{
		if ($showCurrent == 1) echo $before . esc_html(get_the_title()) . $after;
	} 
	
	elseif ( is_page() && $post->post_parent ) 
	{
		$parent_id  = $post->post_parent;
		$breadcrumbs = array();
		while ($parent_id) 
		{
			$page = get_page($parent_id);
			$breadcrumbs[] = '<a href="' . esc_url(get_permalink($page->ID)) . '">' . esc_html(get_the_title($page->ID)) . '</a>' . '&nbsp' . wp_kses_post($seprator) . '&nbsp';
			$parent_id  = $page->post_parent;
		}
		
		$breadcrumbs = array_reverse($breadcrumbs);
		for ($i = 0; $i < count($breadcrumbs); $i++) 
		{
			echo $breadcrumbs[$i];
			if ($i != count($breadcrumbs)-1) echo ' ' . esc_attr($delimiter) . '&nbsp' . wp_kses_post($seprator) . '&nbsp';
		}
		if ($showCurrent == 1) echo ' ' . esc_attr($delimiter) . ' ' . $before . esc_html(get_the_title()) . $after;
 
    } 
	elseif ( is_tag() ) 
	{
		echo $before . esc_html__('Posts tagged ','the-retail-storefront').' "' . esc_html(single_tag_title('', false)) . '"' . $after;
	} 
	
	elseif ( is_author() ) {
		global $author;
		$userdata = get_userdata($author);
		echo $before . esc_html__('Articles posted by ','the-retail-storefront').'' . $userdata->display_name . $after;
	} 
	
	elseif ( is_404() ) {
		echo $before . esc_html__('Error 404 ','the-retail-storefront'). $after;
    }
	
    if ( get_query_var('paged') ) {
		if ( is_category() || is_day() || is_month() || is_year() || is_search() || is_tag() || is_author() ) echo '';
		echo ' ( ' . esc_html__('Page','the-retail-storefront') . '' . esc_html(get_query_var('paged')). ' )';
		if ( is_category() || is_day() || is_month() || is_year() || is_search() || is_tag() || is_author() ) echo '';
    }
 
    echo '</li>';
 
  }
}




add_filter( 'woocommerce_sale_flash', 'the_retail_storefront_woocommerce_sale_flash_percentage', 10, 3 );

function the_retail_storefront_woocommerce_sale_flash_percentage( $html, $post, $product ) {

	$found = preg_match( '#(<span.*?>)(.*?)(</span>)#', $html, $matches );

	if ( ! $found ) {
		return $html;
	}

	$tag_open      = $matches[1];
	$tag_close     = $matches[3];
	$original_text = $matches[2];

	$percentages = the_retail_storefront_woocommerce_get_product_sale_percentages( $product );
	$label       = the_retail_storefront_woocommerce_get_product_sale_percentage_label( $percentages, $original_text );

	$html = $tag_open . $label . $tag_close;

	return $html;
}

function the_retail_storefront_woocommerce_get_product_sale_percentages( $product ) {
	$percentages = array(
		'min' => false,
		'max' => false,
	);

	switch ( $product->get_type() ) {
		case 'grouped':
			$children = array_filter( array_map( 'wc_get_product', $product->get_children() ), 'wc_products_array_filter_visible_grouped' );

			foreach ( $children as $child ) {
				if ( $child->is_purchasable() && ! $child->is_type( 'grouped' ) && $child->is_on_sale() ) {
					$child_percentage = the_retail_storefront_woocommerce_get_product_sale_percentages( $child );

					$percentages['min'] = false !== $percentages['min'] ? $percentages['min'] : $child_percentage['min'];
					$percentages['max'] = false !== $percentages['max'] ? $percentages['max'] : $child_percentage['max'];

					if ( $child_percentage['min'] < $percentages['min'] ) {
						$percentages['min'] = $child_percentage['min'];
					}

					if ( $child_percentage['max'] > $percentages['max'] ) {
						$percentages['max'] = $child_percentage['max'];
					}
				}
			}

			break;

		case 'variable':
			$prices = $product->get_variation_prices();

			foreach ( $prices['price'] as $variation_id => $price ) {
				$regular_price = (float) $prices['regular_price'][ $variation_id ];
				$sale_price    = (float) $prices['sale_price'][ $variation_id ];

				if ( $sale_price < $regular_price ) {
					$variation_percentage = ( ( $regular_price - $sale_price ) / $regular_price ) * 100;

					$percentages['min'] = false !== $percentages['min'] ? $percentages['min'] : $variation_percentage;
					$percentages['max'] = false !== $percentages['max'] ? $percentages['max'] : $variation_percentage;

					if ( $variation_percentage < $percentages['min'] ) {
						$percentages['min'] = $variation_percentage;
					}

					if ( $variation_percentage > $percentages['max'] ) {
						$percentages['max'] = $variation_percentage;
					}
				}
			}
			break;

		case 'external':
		case 'variation':
		case 'simple':
		default:
			$regular_price = (float) $product->get_regular_price();
			$sale_price    = (float) $product->get_sale_price();

			if ( $sale_price < $regular_price ) {
				$percentages['max'] = ( ( $regular_price - $sale_price ) / $regular_price ) * 100;
			}
	}
	return $percentages;
}

function the_retail_storefront_woocommerce_get_product_sale_percentage_label( $percentages, $original_label ) {
	$label = '';

	$rounded_percentages = $percentages;
	$rounded_percentages = array_map( 'round', $percentages );
	$rounded_percentages = array_map( 'intval', $rounded_percentages );

	if ( ( empty( $percentages['min'] ) || empty( $percentages['max'] ) ) || ( $percentages['min'] === $percentages['max'] ) ) {
		/* translators: -%1$d%%: Woocommerce. */
		$label = sprintf( _x( '-%1$d%%', 'product discount', 'the-retail-storefront' ), max( $rounded_percentages ) );
	} else {
		/* translators: -%1$d%%: Woocommerce. */
		$label = sprintf( _x( '-%1$d%% / -%2$d%%', 'product discount', 'the-retail-storefront' ), $rounded_percentages['min'], $rounded_percentages['max'] );
	}

	$label = apply_filters( 'the_retail_storefront_woocommerce_sale_flash_percentage_label', $label, $rounded_percentages, $percentages, $original_label );

	return $label;
}

function the_retail_storefront_default_styles() {
    // Begin Style
    $the_retail_storefront_css = '<style>';

    $the_retail_storefront_logo_width = get_theme_mod('the_retail_storefront_logo_width', 100);
    $the_retail_storefront_css .= '
        .main-header .logo a.custom-logo-link img{
            max-width: ' . esc_attr($the_retail_storefront_logo_width) . 'px !important;
            max-height: ' . esc_attr($the_retail_storefront_logo_width) . 'px !important;
            overflow: hidden;
            display: inline-block;
        }
    ';

    // End Style
    $the_retail_storefront_css .= '</style>';

    echo $the_retail_storefront_css;
}

add_action('wp_head', 'the_retail_storefront_default_styles', 999); // Use a priority to ensure it loads after other styles