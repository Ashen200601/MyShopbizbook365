<?php 

if ( ! function_exists( 'best_shop_default_settings' ) ) :

function best_shop_default_settings($setting_name){
    
	$values = array (

        'address_title' => '',
        'address' => '',
        'mail_title' => '',
        'mail_description' => '',
        'phone_title' => esc_html__('Call:', 'best-shop'),
        'phone_number' => '',
        
        'enable_mobile_search' => false,
        'woo_ajax_search_code' => '',
        'woo_category_title' => esc_html__('Top Categories', 'best-shop'),
        'hide_product_cat_list' => false,
        
        'header_shortcode' => '',
        
        'woo_search_dropdown_title' => esc_html__('All Categories', 'best-shop'),
        'woo_search_text' => esc_html__('Search products...', 'best-shop'),
        'enable_cart_icon_in_menu' => true,
        
        'footer_num_of_colums' => 4,
        
        'heading_font' => 'Poppins',
        'body_font' => 'Open Sans',
        'body_font_size' => 1,               
        
        'footer_copyright' => '',
        
        'primary_color' => '#ffd800',
        'secondary_color' => '#32B9A5',
        
        'woo_bar_color' => '#000000',
        'woo_bar_bg_color' => '#ffd800',
        
        'menu_text_color' => '#e8e8e8',
        'menu_bg_color' => '#000000',
        'text_color' => '#0c0c0c',
        
        'topbar_bg_color' => '#f8f9fa',
        'topbar_text_color' => '#000',
        
        'preloader_enabled' => false,
        
        'logo_width' => '90',
        
        'layout_width' => '1280',
        
        'enable_search' => true,
        'ed_social_links' => true,
        'social_links' => '',
        
        'enable_cart_icon' => true,
        'enable_myaccount_icon' => true,
        'enable_wishlist_icon' => true, 
        'enable_compare_icon' => true, 
        
        'header_layout' => 'woocommerce-bar',
        'hide_product_cat_search' => true,
        'menu_layout' => 'default',
        'header_banner_img' => '',
        
        'enable_sticky_menu' => false, 
        'enable_back_to_top' => true, 
        'enable_popup_cart' => true, 
        
        'enable_top_bar' => true,        
        'top_bar_left_content' => 'contacts',
        'top_bar_left_text' => esc_html__('edit top bar text', 'best-shop'),
        'top_bar_right_content' => 'menu_social',
        
        'page_sidebar_layout' => 'no-sidebar',
        'post_sidebar_layout' => 'right-sidebar',
        'layout_style' => 'right-sidebar',
        'woo_sidebar_layout' => 'left-sidebar',
        'product_sidebar_layout' => 'left-sidebar',
        'checkout_sidebar_layout' => 'no-sidebar',
        
        'post_page_note_text' => '',
        'enable_post_author' => false,
        'enable_post_date' => false,
        'enable_banner_comments' => false,
        'enable_post_read_calc' => false,
        'read_words_per_minute' => 200,
        'related_post_title' => esc_html__( 'Similar Posts', 'best-shop' ),
        'home_text' => esc_html__( 'Home', 'best-shop' ),
        
        'enable_breadcrumb' => true,
                
        'enable_banner_section' => 'static_banner',
        'banner_title' => esc_html__( 'Donec Cras Ut Eget Justo Nec Semper Sapien Viverra Ante', 'best-shop' ),
        'banner_content' => esc_html__( 'Structured gripped tape invisible moulded cups for sauppor firm hold strong powermesh front liner sport detail.', 'best-shop' ),
        'banner_btn_label' => esc_html__( 'Read More', 'best-shop' ),
        'banner_link' => '#',
        'banner_btn_two_label' => esc_html__( 'About Us', 'best-shop' ),
        'banner_btn_two_link' => '#',
        
        'enable_newsletter_section' => true,
        'newsletter_shortcode' => '',
        
        'blog_section_title' => esc_html__( 'Blog Posts', 'best-shop' ),
        
        'footer_text_color' => '#eee',
        'footer_color' => '#000',
        'footer_link' => 'https://gradientthemes.com/',
        'footer_copyright' => esc_html__( 'A theme by GradientThemes', 'best-shop' ),
        'footer_img' => '',
        
        'subscription_shortcode' => '',
        
    );
    
    $output = apply_filters('best_shop_settings', $values);
					 
	return $output[$setting_name];
}

endif;


/* 
 * Get default setting if no saved settings 
 */

if ( ! function_exists( 'best_shop_get_setting' ) ) :

function best_shop_get_setting($setting_name){
    
    return get_theme_mod($setting_name, best_shop_default_settings($setting_name)); 
    
}

endif;



if(class_exists('woocommerce') && best_shop_get_setting('enable_cart_icon_in_menu')) {
	add_filter('wp_nav_menu_items', 'best_shop_add_search_form_to_menu', 10, 2); 
}

