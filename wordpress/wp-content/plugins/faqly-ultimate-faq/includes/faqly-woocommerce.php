<?php
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Render the Woocommerce FAQs settings page
 */
function faqly_render_woocommerce_faqs_page()
{
    global $faqly_is_premium_user;

    // Check if WooCommerce is active
    if (!class_exists('WooCommerce')) {
        ?>
        <div class="wrap">
            <h1><?php _e('Woocommerce FAQs', 'faqly-ultimate-faq'); ?></h1>
            <div class="notice notice-warning">
                <p><?php _e('WooCommerce is not active. Please install and activate WooCommerce to use these settings.', 'faqly-ultimate-faq'); ?>
                </p>
            </div>
        </div>
        <?php
        return;
    }

    // Get current settings
    $faqs_enabled = get_option('faqly_wc_faqs_enabled', 'yes');
    $tab_label = get_option('faqly_wc_faqs_tab_label', 'FAQs');
    $tab_priority = get_option('faqly_wc_faqs_tab_priority', 50);
    $saved_faq_tabs = get_option('faqly_wc_faq_tabs', array());
    ?>
    <div class="wrap">

        <div class="notice notice-info" style="margin-bottom: 20px;">
            <p>
                <?php echo esc_html__('Note: If multiple FAQ tabs apply to the same product, the first matching rule will be used. Specific product rules take priority over "All products".', 'faqly-ultimate-faq'); ?>
            </p>
        </div>

        <form method="post" action="<?php echo esc_url(admin_url('admin-post.php')); ?>">
            <input type="hidden" name="action" value="faqly_save_woocommerce_settings">


            <?php wp_nonce_field('faqly_woocommerce_settings', 'faqly_woocommerce_settings_nonce'); ?>

            <div class="card">
                <div class="card-body">
                    <h2 class="card-title"><?php _e('WooCommerce FAQs Settings', 'faqly-ultimate-faq'); ?>
                        <?php echo faqly_pro_label($faqly_is_premium_user); ?>
                    </h2>

                    <!-- 1. WooCommerce FAQs Tab -->
                    <div class="mb-4">
                        <p class="text-muted">
                            <?php _e('WooCommerce\'s FAQs tab gives quick answers to common customer queries about products and services.', 'faqly-ultimate-faq'); ?>
                        </p>

                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="faqly_wc_faqs_enabled" id="faqs_enabled_yes"
                                value="yes" <?php checked($faqs_enabled, 'yes'); ?><?php echo faqly_field_disabled_attr($faqly_is_premium_user); ?>>
                            <label class="form-check-label" for="faqs_enabled_yes">
                                <?php _e('Enable', 'faqly-ultimate-faq'); ?>
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="faqly_wc_faqs_enabled" id="faqs_enabled_no"
                                value="no" <?php checked($faqs_enabled, 'no'); ?><?php echo faqly_field_disabled_attr($faqly_is_premium_user); ?>>
                            <label class="form-check-label" for="faqs_enabled_no">
                                <?php _e('Disable', 'faqly-ultimate-faq'); ?>
                            </label>
                        </div>
                    </div>

                    <!-- 2. FAQs Tab Label -->
                    <div class="mb-4">
                        <h3><?php _e('FAQs Tab Label', 'faqly-ultimate-faq'); ?>
                            <?php echo faqly_pro_label($faqly_is_premium_user); ?>
                        </h3>
                        <p class="text-muted"><?php _e('Set custom text for FAQ tab.', 'faqly-ultimate-faq'); ?></p>

                        <div class="row">
                            <div class="col-md-6">
                                <input type="text" class="form-control" name="faqly_wc_faqs_tab_label"
                                    value="<?php echo esc_attr($tab_label); ?>"
                                    placeholder="<?php _e('Enter tab label', 'faqly-ultimate-faq'); ?>" <?php echo faqly_field_disabled_attr($faqly_is_premium_user); ?>>
                            </div>
                        </div>
                    </div>

                    <!-- 3. FAQs Tab Priority -->
                    <div class="mb-4">
                        <h3><?php _e('FAQs Tab Priority', 'faqly-ultimate-faq'); ?>
                            <?php echo faqly_pro_label($faqly_is_premium_user); ?>
                        </h3>
                        <p class="text-muted">
                            <?php _e('Set WooCommerce FAQs tab priority position. Default value is 50.', 'faqly-ultimate-faq'); ?>
                        </p>

                        <div class="row">
                            <div class="col-md-6">
                                <input type="number" class="form-control" name="faqly_wc_faqs_tab_priority"
                                    value="<?php echo esc_attr($tab_priority); ?>" min="1" max="100" <?php echo faqly_field_disabled_attr($faqly_is_premium_user); ?>>
                            </div>
                        </div>
                    </div>

                    <!-- 4. FAQs Tabs -->
                    <div class="mb-4">
                        <h3><?php _e('FAQs Tabs', 'faqly-ultimate-faq'); ?>
                            <?php echo faqly_pro_label($faqly_is_premium_user); ?>
                        </h3>
                        <p class="text-muted">
                            <?php _e('Manage FAQ tabs for WooCommerce products.', 'faqly-ultimate-faq'); ?>
                        </p>

                        <button type="button" class="btn btn-primary" id="add-new-faq-tab" <?php echo faqly_field_disabled_attr($faqly_is_premium_user); ?>>
                            <span class="dashicons dashicons-plus"></span>
                            <?php _e('Add New', 'faqly-ultimate-faq'); ?>
                        </button>

                        <div id="faq-tabs-container" class="mt-3">
                            <!-- FAQ tabs will be dynamically added here -->
                            <?php
                            if (!empty($saved_faq_tabs) && is_array($saved_faq_tabs)) {
                                $tab_index = 0;
                                foreach ($saved_faq_tabs as $tab) {
                                    $tab_index++;
                                    $display_on = isset($tab['display_on']) ? $tab['display_on'] : 'all';
                                    $group_id = isset($tab['group_id']) ? intval($tab['group_id']) : 0;
                                    $product_ids = isset($tab['product_ids']) && is_array($tab['product_ids']) ? $tab['product_ids'] : array();
                                    ?>
                                    <div class="faq-tab-item card mt-3" data-tab-id="<?php echo esc_attr($tab_index); ?>">
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <label><?php _e('Display FAQs on', 'faqly-ultimate-faq'); ?></label>
                                                    <select class="form-control display-faqs-on"
                                                        name="faq_tabs[<?php echo esc_attr($tab_index); ?>][display_on]"
                                                        data-tab-id="<?php echo esc_attr($tab_index); ?>" <?php echo faqly_field_disabled_attr($faqly_is_premium_user); ?>>
                                                        <option value="all" <?php selected($display_on, 'all'); ?>>
                                                            <?php _e('All products', 'faqly-ultimate-faq'); ?>
                                                        </option>
                                                        <option value="specific" <?php selected($display_on, 'specific'); ?>>
                                                            <?php _e('Specific products', 'faqly-ultimate-faq'); ?>
                                                        </option>
                                                    </select>
                                                </div>
                                                <div class="col-md-4 specific-products-container"
                                                    id="specific-products-<?php echo esc_attr($tab_index); ?>"
                                                    style="<?php echo ($display_on === 'specific') ? '' : 'display:none;'; ?>">
                                                    <label><?php _e('Specific Product(s)', 'faqly-ultimate-faq'); ?></label>
                                                    <select class="form-control"
                                                        name="faq_tabs[<?php echo esc_attr($tab_index); ?>][product_ids][]" multiple
                                                        <?php echo faqly_field_disabled_attr($faqly_is_premium_user); ?>>
                                                        <?php
                                                        if (!empty($product_ids)) {
                                                            $products = wc_get_products(array(
                                                                'status' => 'publish',
                                                                'include' => $product_ids,
                                                                'limit' => -1
                                                            ));
                                                            foreach ($products as $product) {
                                                                echo '<option value="' . esc_attr($product->get_id()) . '" selected>' . esc_html($product->get_name()) . '</option>';
                                                            }
                                                        }
                                                        ?>
                                                    </select>
                                                    <small
                                                        class="form-text text-muted"><?php _e('Hold Ctrl/Cmd to select multiple products', 'faqly-ultimate-faq'); ?></small>
                                                </div>
                                                <div class="col-md-3">
                                                    <label><?php _e('Select FAQ Group', 'faqly-ultimate-faq'); ?></label>
                                                    <select class="form-control"
                                                        name="faq_tabs[<?php echo esc_attr($tab_index); ?>][group_id]" <?php echo faqly_field_disabled_attr($faqly_is_premium_user); ?>>
                                                        <option value=""><?php _e('Select FAQ Group', 'faqly-ultimate-faq'); ?>
                                                        </option>
                                                        <?php
                                                        $faq_groups = get_posts(array(
                                                            'post_type' => 'faqly_faq_group',
                                                            'posts_per_page' => -1,
                                                            'post_status' => 'publish'
                                                        ));
                                                        foreach ($faq_groups as $group) {
                                                            $selected_group = ($group_id === $group->ID) ? 'selected' : '';
                                                            echo '<option value="' . esc_attr($group->ID) . '" ' . $selected_group . '>' . esc_html($group->post_title) . '</option>';
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                                <div class="col-md-1">
                                                    <label>&nbsp;</label>
                                                    <button type="button" class="btn btn-danger btn-sm remove-tab"
                                                        data-tab-id="<?php echo esc_attr($tab_index); ?>" <?php echo faqly_field_disabled_attr($faqly_is_premium_user); ?>>
                                                        <span class="dashicons dashicons-trash"></span>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <?php
                                }
                            }
                            ?>
                        </div>
                    </div>

                    <!-- Save Button -->
                    <div class="mt-4">
                        <button type="submit" class="btn btn-success" <?php echo faqly_field_disabled_attr($faqly_is_premium_user); ?>>
                            <span class="dashicons dashicons-yes"></span>
                            <?php _e('Save Settings', 'faqly-ultimate-faq'); ?>
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </div>
    <?php
}
