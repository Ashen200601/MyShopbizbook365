<?php
if (!defined('ABSPATH')) {
    exit;
}
require_once 'class-general-settings-metabox.php';
class FAQLY_Metabox
{

    public function __construct()
    {
        add_action('add_meta_boxes', [$this, 'faqly_add_faq_group_metabox']);
        add_action('add_meta_boxes', [$this, 'faqly_add_shortcode_display_metabox']);
        add_action('add_meta_boxes', [$this, 'faqly_add_general_settings_metabox']);
        add_action('add_meta_boxes', [$this, 'faqly_remove_slug_metabox']); // Add this
        add_action('wp_ajax_faqly_get_notice_dismiss', [$this, 'faqly_get_notice_dismiss']);
        add_action('add_meta_boxes', [$this, 'faqly_add_buy_pro_metabox']);

        if (function_exists('faqly_save_pro_metabox') && function_exists('faqly_save_pro_faq_group_meta')) {
            add_action('save_post', 'faqly_save_pro_metabox');
            add_action('save_post', 'faqly_save_pro_faq_group_meta');
        } else {
            add_action('save_post', [$this, 'faqly_save_faq_group_meta']);
            add_action('save_post', ['Faqly_General_Settings_Metabox', 'faqly_save_metabox']);
        }

        add_filter('postbox_classes_group_faq_accordion_faq_group_settings', function ($classes) {
            return array_diff($classes, ['closed']);
        });

    }



    // Remove the default "Slug" metabox
    public function faqly_remove_slug_metabox()
    {
        remove_meta_box('slugdiv', 'faqly_faq_group', 'normal');
    }

    public function faqly_add_faq_group_metabox()
    {
        add_meta_box(
            'faq_group_settings',
            'FAQ Group Settings',
            [$this, 'faqly_render_faq_group_metabox'],
            'faqly_faq_group',
            'normal',
            'high'
        );
    }

    public function faqly_get_notice_dismiss()
    {
        delete_option('faqly_show_activation_popup');
        update_option('faqly_show_deactivation_popup', true);

        wp_send_json_success([
            "code" => 200,
            "msg" => "Activation popup preference saved successfully."
        ]);
    }

    public function faqly_add_shortcode_display_metabox()
    {
        add_meta_box(
            'faq_shortcode_display',
            'FAQ Shortcode',
            [$this, 'faqly_render_shortcode_display_metabox'],
            'faqly_faq_group',
            'side',
            'high'
        );
    }

    // Add the General Settings metabox
    public function faqly_add_general_settings_metabox()
    {
        add_meta_box(
            'general_settings',
            'General Settings',
            ['Faqly_General_Settings_Metabox', 'faqly_render_metabox'],
            'faqly_faq_group',
            'normal',
            'high'
        );
    }

    public function faqly_add_buy_pro_metabox()
    {
        $faqly_is_premium_user = get_option( 'faqly_pro_is_premium', false );

        if (!$faqly_is_premium_user) {
            add_meta_box(
                'faqly_buy_pro_metabox',            // Metabox ID
                'Upgrade to Pro',                   // Title
                [$this, 'faqly_render_buy_pro_metabox'], // Callback
                'faqly_faq_group',                  // Post type
                'side',                             // Context (side panel)
                'high'                              // Priority
            );
        }
    }

    public function faqly_render_buy_pro_metabox($post)
    {
        ?>
        <div class="faqly-buy-pro-metabox">
            <p class="faqly-buy-pro-text">Unlock more features with the Pro version.</p>
            <a href="<?php echo esc_url( FAQLY_PLUGIN_MAIN_URL. 'products/the-ultimate-faq-wordpress-plugin'); ?>" target="_blank" class="button faqly-buy-pro-button">Upgrade To Pro!</a>
        </div>
        <?php
    }


    public function faqly_render_shortcode_display_metabox($post)
    {
        $shortcode = '[faqly_accordion id="' . esc_attr($post->ID) . '"]';
        ?>
        <p>Use the shortcode below to display this FAQ group:</p>
        <div style="background: #f9f9f9; padding: 10px; border: 1px solid #ddd; border-radius: 4px;">
            <code><?php echo esc_html($shortcode); ?></code>
        </div>
        <?php
    }


    public function faqly_render_faq_group_metabox($post)
    {
        // Retrieve the active tab from the post meta
        $active_tab = get_post_meta($post->ID, '_faq_active_tab', true);

        // Set a default active tab
        if (empty($active_tab)) {
            $active_tab = 'faq-custom';
        }

        //for nounce 
        wp_nonce_field('save_faq_meta', 'faq_nonce');

        ?>
        <!-- Tabs Navigation -->
        <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link <?php echo ($active_tab === 'faq-custom') ? 'active' : ''; ?>" id="faq-custom-tab"
                    data-bs-toggle="pill" data-bs-target="#faq-custom" type="button" role="tab" aria-controls="faq-custom"
                    aria-selected="<?php echo ($active_tab === 'faq-custom') ? 'true' : 'false'; ?>">
                    Custom
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link <?php echo ($active_tab === 'faq-post') ? 'active' : ''; ?>" id="faq-post-tab"
                    data-bs-toggle="pill" data-bs-target="#faq-post" type="button" role="tab" aria-controls="faq-post"
                    aria-selected="<?php echo ($active_tab === 'faq-post') ? 'true' : 'false'; ?>">
                    Post
                </button>
            </li>
        </ul>

        <!-- Tabs Content -->
        <div class="tab-content" id="pills-tabContent">
            <div class="tab-pane fade <?php echo ($active_tab === 'faq-custom') ? 'show active' : ''; ?>" id="faq-custom"
                role="tabpanel" aria-labelledby="faq-custom-tab">
                <?php include FAQLY_PLUGIN_DIR . 'tab/faq-custom-tab-content.php'; ?>
            </div>
            <div class="tab-pane fade <?php echo ($active_tab === 'faq-post') ? 'show active' : ''; ?>" id="faq-post"
                role="tabpanel" aria-labelledby="faq-post-tab">
                <?php include FAQLY_PLUGIN_DIR . 'tab/faq-post-tab-content.php'; ?>
            </div>
        </div>

        <input type="hidden" name="active_tab" value="<?php echo esc_attr($active_tab); ?>" />

        <?php
    }


    // new save function 
    public function faqly_save_faq_group_meta($post_id)
    {

        if (!isset($_POST['faq_nonce']) || !wp_verify_nonce(sanitize_text_field(wp_unslash($_POST['faq_nonce'])), 'save_faq_meta')) {
            return;
        }

        if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE)
            return;

        if (!current_user_can('edit_post', $post_id))
            return;

        $active_tab = isset($_POST['active_tab']) ? sanitize_text_field(wp_unslash($_POST['active_tab'])) : 'custom';
        $faq_post_type = isset($_POST['faq_post_type']) ? sanitize_text_field(wp_unslash($_POST['faq_post_type'])) : '';
        $faq_order_by = isset($_POST['faq_order_by']) ? sanitize_text_field(wp_unslash($_POST['faq_order_by'])) : '';
        $faq_order = isset($_POST['faq_order']) ? sanitize_text_field(wp_unslash($_POST['faq_order'])) : '';

        $faq_exclude_ids = isset($_POST['faq_exclude_ids']) ? sanitize_text_field(wp_unslash($_POST['faq_exclude_ids'])) : '';
        $faq_limit = (isset($_POST['faq_limit']) && $_POST['faq_limit'] != '') ? intval($_POST['faq_limit']) : '';

        // Save meta values
        update_post_meta($post_id, '_faq_active_tab', $active_tab);
        update_post_meta($post_id, '_faq_post_type', $faq_post_type);
        update_post_meta($post_id, '_faq_order_by', $faq_order_by);
        update_post_meta($post_id, '_faq_order', $faq_order);

        update_post_meta($post_id, '_faq_exclude_ids', $faq_exclude_ids);
        update_post_meta($post_id, '_faq_limit', $faq_limit);

        // Save the custom FAQ items
        $faq_items = array();

        if (isset($_POST['faq_items']) && is_array($_POST['faq_items'])) {
            // phpcs:ignore WordPress.Security.ValidatedSanitizedInput.MissingUnslash, WordPress.Security.ValidatedSanitizedInput.InputNotSanitized
            $raw_faq_items = wp_unslash($_POST['faq_items']); // Unslash first

            foreach ($raw_faq_items as $index => $faq_item) {
                $faq_title = isset($faq_item['title']) ? sanitize_text_field($faq_item['title']) : '';
                $faq_description = isset($faq_item['description']) ? wp_kses_post($faq_item['description']) : '';

                $faq_items[] = array(
                    'title' => $faq_title,
                    'description' => $faq_description,
                );
            }
        }

        update_post_meta($post_id, '_faq_items', $faq_items);

    }
    //end 

}

new FAQLY_Metabox();

