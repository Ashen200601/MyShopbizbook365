<?php

if (!defined('ABSPATH')) {
    exit;
}

class FAQLY_Admin
{

    const FAQ_GROUP_POST_TYPE = 'faqly_faq_group';
    public $faqly_is_premium_user;

    public function __construct()
    {
        $this->faqly_is_premium_user = get_option('faqly_pro_is_premium', false);

        add_action('admin_menu', [$this, 'faqly_add_faq_admin_menu']);
        add_action('admin_enqueue_scripts', [$this, 'faqly_enqueue_admin_scripts']); // Add this line

        add_filter('manage_' . self::FAQ_GROUP_POST_TYPE . '_posts_columns', [$this, 'faqly_add_shortcode_column']);
        add_action('manage_' . self::FAQ_GROUP_POST_TYPE . '_posts_custom_column', [$this, 'faqly_render_shortcode_column'], 10, 2);
    }

    public function faqly_enqueue_admin_scripts()
    {
        wp_add_inline_script('jquery', "
        jQuery(document).ready(function($) {

            $('a[href=\"" . esc_js(FAQLY_PLUGIN_MAIN_URL . "products/the-ultimate-faq-wordpress-plugin") . "\"]')
                .attr('target', '_blank')
                .attr('rel', 'noopener noreferrer');

        });
    ");
    }

    public function faqly_add_faq_admin_menu()
    {
        // Main menu: FAQs
        add_menu_page(
            'FAQs',
            'FAQs',
            'edit_posts',
            'edit.php?post_type=' . self::FAQ_GROUP_POST_TYPE,
            '',
            'dashicons-editor-help',
            20
        );

        // Submenu: Manage FAQ Group
        add_submenu_page(
            'edit.php?post_type=' . self::FAQ_GROUP_POST_TYPE,
            'Manage FAQ Group',
            'Manage FAQ Group',
            'manage_options',
            'edit.php?post_type=' . self::FAQ_GROUP_POST_TYPE,
            ''
        );

        // Submenu: New FAQ Group
        add_submenu_page(
            'edit.php?post_type=' . self::FAQ_GROUP_POST_TYPE,
            'New FAQ Group',
            'New FAQ Group',
            'manage_options',
            'post-new.php?post_type=' . self::FAQ_GROUP_POST_TYPE,
            ''
        );

        // Submenu: All FAQs
        add_submenu_page(
            'edit.php?post_type=' . self::FAQ_GROUP_POST_TYPE,
            'All FAQs',
            'All FAQs',
            'edit_posts',
            'edit.php?post_type=faqly_faq'
        );

        // Submenu: Add New FAQ
        add_submenu_page(
            'edit.php?post_type=' . self::FAQ_GROUP_POST_TYPE,
            'Add New FAQ',
            'Add New FAQ',
            'edit_posts',
            'post-new.php?post_type=faqly_faq'
        );

        // Submenu: Tools
        add_submenu_page(
            'edit.php?post_type=' . self::FAQ_GROUP_POST_TYPE,
            'Tools',
            'Tools',
            'manage_options',
            'faqly_tools',
            [$this, 'faqly_render_tools_page']
        );

        // Submenu: Woocommerce FAQs
        add_submenu_page(
            'edit.php?post_type=' . self::FAQ_GROUP_POST_TYPE,
            'Woocommerce FAQs',
            'Woocommerce FAQs',
            'manage_options',
            'faqly_woocommerce',
            [$this, 'faqly_render_woocommerce_page']
        );

        // Submenu: Templates
        add_submenu_page(
            'edit.php?post_type=' . self::FAQ_GROUP_POST_TYPE,
            'Manage Templates',
            'Website Templates',
            'manage_options',
            'templates_page',
            [$this, 'faqly_render_templates_page']
        );

        if (!is_plugin_active('faqly-ultimate-faq-pro/faqly-ultimate-faq-pro.php')) {
            add_submenu_page(
                'edit.php?post_type=' . self::FAQ_GROUP_POST_TYPE,
                'Upgrade Pro',
                'Upgrade Pro',
                'manage_options',
                FAQLY_PLUGIN_MAIN_URL . 'products/the-ultimate-faq-wordpress-plugin'
            );
        }
    }



    public function faqly_add_shortcode_column($columns)
    {
        $new_columns = [];
        foreach ($columns as $key => $value) {
            if ($key === 'date') {
                $new_columns['faq_shortcode'] = 'Shortcode';
            }
            $new_columns[$key] = $value;
        }
        return $new_columns;
    }

    public function faqly_render_shortcode_column($column, $post_id)
    {
        if ($column === 'faq_shortcode') {
            echo '<code>[faqly_accordion id="' . esc_attr($post_id) . '"]</code>';
        }
    }

    //for templates 
    public function faqly_render_templates_page()
    {

        include_once FAQLY_PLUGIN_DIR . '/includes/faqly-themes.php';

    }

    // Render Tools page
    public function faqly_render_tools_page()
    {
        if (function_exists('faqly_render_tools_page')) {
            faqly_render_tools_page();
        }
    }

    // Render Woocommerce FAQs page
    public function faqly_render_woocommerce_page()
    {

        include_once FAQLY_PLUGIN_DIR . '/includes/faqly-woocommerce.php';

        faqly_render_woocommerce_faqs_page();
    }


}
