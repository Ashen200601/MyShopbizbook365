<?php
/**
 * Plugin Name:       FAQly – Ultimate FAQ
 * Plugin URI:        https://www.seothemesexpert.com/products/best-wordpress-faq-plugin-free
 * Description:       A plugin to manage FAQs and display them as an accordion using a shortcode.
 * Version:           1.1.3
 * Requires at least: 5.2
 * Requires PHP:      7.4
 * Author:            drakearthur
 * Author URI:        https://www.seothemesexpert.com/
 * License:           GPL v2 or later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:       faqly-ultimate-faq
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}
define('FAQLY_PLUGIN_DIR', plugin_dir_path(__FILE__));
define('FAQLY_PLUGIN_URL', plugin_dir_url(__FILE__));
define('FAQLY_PLUGIN_VERSION', '1.1.3');

define('FAQLY_PLUGIN_MAIN_URL', 'https://www.seothemesexpert.com/');
define('FAQLY_PLUGIN_LICENSE_URL', 'https://license.seothemesexpert.com/api/public/');
define('FAQLY_PLUGIN_THEME_BUNDLE_IMAGE_URL', plugin_dir_url(__FILE__) . 'assets/images/get-theme-bundle-img.png');
$faqly_is_premium_user = get_option('faqly_pro_is_premium', false);


require_once FAQLY_PLUGIN_DIR . 'includes/class-faq-post-type.php';
require_once FAQLY_PLUGIN_DIR . 'includes/class-faq-admin.php';
require_once FAQLY_PLUGIN_DIR . 'includes/class-faq-metabox.php';
require_once FAQLY_PLUGIN_DIR . 'includes/class-faq-shortcode.php';
require_once FAQLY_PLUGIN_DIR . 'includes/faqly-tools.php';
require_once FAQLY_PLUGIN_DIR . 'ajax/ajax.php';

// Initialize the plugin
add_action('plugins_loaded', function () {
    new FAQLY_Post_Type();
    new FAQLY_Admin();
    new FAQLY_Shortcode();
    new FAQLY_Metabox();
});

register_activation_hook(__FILE__, 'faqly_plugin_activation_hook');
function faqly_plugin_activation_hook()
{
    update_option('faqly_show_activation_popup', true);
}

register_deactivation_hook(__FILE__, 'faqly_plugin_deactivation_hook');
function faqly_plugin_deactivation_hook()
{
    delete_option('faqly_show_deactivation_popup');
}


add_action('wp_login', 'faqly_user_login_hook', 10, 2);
function faqly_user_login_hook($user_login, $user)
{
    update_option('faqly_show_activation_popup', true);
}

add_action('wp_logout', function () {
    delete_option('faqly_show_deactivation_popup');
});


add_action('admin_footer', 'faqly_custom_popup_html');
function faqly_custom_popup_html()
{
    if (!get_option('faqly_show_activation_popup'))
        return;
    if (isset($_GET['page']) && $_GET['page'] === 'templates_page') {
        return;
    }
    ?>
    <div id="faqly-popup-overlay">
        <div id="faqly-popup-content">
            <span class="dashicons dashicons-plus-alt2 faqly-popup-dismiss"></span>
            <img src="<?php echo esc_url(FAQLY_PLUGIN_THEME_BUNDLE_IMAGE_URL); ?>" alt="Bundle Image">
            <h2><?php echo esc_html('Elevate Your Website with Premium Themes from $45'); ?></h2>
            <div class="faqly-popup-wrap">
                <a href="<?php echo esc_url(admin_url('edit.php?post_type=faqly_faq_group&page=templates_page')); ?>"
                    class="button button-primary faqly-popup-template-btn"><?php echo esc_html('View Premium Templates'); ?></a>
                <a href="<?php echo esc_url(FAQLY_PLUGIN_MAIN_URL) . 'products/wordpress-theme-bundle'; ?>" target="_blank"
                    class="button button-primary faqly-popup-bundle-btn"><?php echo esc_html('Get Theme Bundle'); ?></a>
            </div>
        </div>
    </div>
    <?php
}

add_action('admin_enqueue_scripts', function () {

    if (isset($_GET['page']) && $_GET['page'] === 'templates_page') {
        return;
    }

    if (!get_option('faqly_show_activation_popup')) {
        update_option('faqly_show_deactivation_popup', true);
    }

    $dismissed = get_option('faqly_show_deactivation_popup');

    wp_register_style('faqly-admin-styles', false);
    wp_enqueue_style('faqly-admin-styles');

    if (!$dismissed) {
        $css = '.faqly-premium-floating-btn { display: none !important; position: fixed; bottom: 20px; right: 20px; z-index: 9999; padding: 10px 15px; }';
    } else {
        $css = '.faqly-premium-floating-btn { display: inline-block; position: fixed; bottom: 20px; right: 20px; z-index: 9999; padding: 10px 15px; }';
    }

    wp_add_inline_style('faqly-admin-styles', $css);
});


add_action('admin_footer', function () {

    if (isset($_GET['page']) && $_GET['page'] === 'templates_page') {
        return;
    }
    ?>
    <a href="<?php echo esc_url(admin_url('edit.php?post_type=faqly_faq_group&page=templates_page')); ?>"
        class="faqly-premium-floating-btn button button-primary">
        <?php echo esc_html('View Premium Templates'); ?>
    </a>
    <?php
});

function faqly_maybe_enqueue_scripts()
{
    if (is_admin()) {
        return;
    }

    global $post;
    // Case 1: shortcode in normal post/page content
    if (isset($post->post_content) && has_shortcode($post->post_content, 'faqly_accordion')) {
        add_action('wp_enqueue_scripts', 'faqly_accordion_front_enqueue_scripts');
        return;
    }

    // Case 2: WooCommerce product page with FAQ tab
    if (function_exists('is_product') && is_product()) {
        add_action('wp_enqueue_scripts', 'faqly_accordion_front_enqueue_scripts');
        return;
    }
}
add_action('wp', 'faqly_maybe_enqueue_scripts');


// Enqueue frontend scripts and styles
function faqly_accordion_front_enqueue_scripts()
{
    wp_enqueue_script('jquery');
    wp_enqueue_style('faqly-accordion-style', FAQLY_PLUGIN_URL . 'assets/faq-accordion-front.css', array(), FAQLY_PLUGIN_VERSION);
    wp_enqueue_style('faqly-themes-style', FAQLY_PLUGIN_URL . 'assets/faqly-themes.css', array(), FAQLY_PLUGIN_VERSION);
    wp_enqueue_style('faqly-bootstrap-front-css', FAQLY_PLUGIN_URL . 'assets/lib/bootstrap.min.css', array(), FAQLY_PLUGIN_VERSION);
    wp_enqueue_script('faqly-bootstrap-front-js', FAQLY_PLUGIN_URL . 'assets/lib/bootstrap.bundle.min.js', array('jquery'), FAQLY_PLUGIN_VERSION, true);
    wp_enqueue_script(
        'faqly-accordion-front', // Handle
        FAQLY_PLUGIN_URL . 'assets/faq-accordion-front.js',
        array('jquery', 'faqly-bootstrap-front-js'),
        FAQLY_PLUGIN_VERSION,
        true
    );

    wp_localize_script('faqly-accordion-front', 'faqly_ajax_object', [
        'ajax_url' => admin_url('admin-ajax.php'),
        'nonce' => wp_create_nonce('faqly_ajax_nonce')
    ]);

    // new font awesome
    wp_enqueue_style('faqly-font-awesome', FAQLY_PLUGIN_URL . 'assets/lib/all.min.css', array(), FAQLY_PLUGIN_VERSION);
}


function faqly_enqueue_faq_admin_scripts($hook)
{

    if ($hook == 'faqs_page_templates_page') {
        wp_enqueue_style('faqly-templates-accordion-style', FAQLY_PLUGIN_URL . 'assets/admin/css/faq-templates-accordion.css', array(), FAQLY_PLUGIN_VERSION);
    }

    // if (isset($_GET['page']) && $_GET['page'] === 'faqly-woocommerce') {
    wp_enqueue_style('faqly-woocommerce-style', FAQLY_PLUGIN_URL . 'assets/admin/css/faqly-woocommerce.css', array(), FAQLY_PLUGIN_VERSION);
    wp_enqueue_script('faqly-woocommerce-script', FAQLY_PLUGIN_URL . 'assets/admin/js/faqly-woocommerce.js', array('jquery'), FAQLY_PLUGIN_VERSION, true);

    // Get FAQ groups for JS
    $faq_groups = get_posts(array(
        'post_type' => 'faqly_faq_group',
        'posts_per_page' => -1,
        'post_status' => 'publish'
    ));
    $faq_groups_options = '';
    foreach ($faq_groups as $group) {
        $faq_groups_options .= '<option value="' . esc_attr($group->ID) . '">' . esc_html($group->post_title) . '</option>';
    }

    wp_localize_script('faqly-woocommerce-script', 'faqly_wc_vars', [
        'ajax_url' => admin_url('admin-ajax.php'),
        'nonce' => wp_create_nonce('faqly_wc_nonce'),
        'tab_count' => count(get_option('faqly_wc_faq_tabs', array())),
        'faq_groups_options' => $faq_groups_options,
        'i18n' => [
            'display_faqs_on' => __('Display FAQs on', 'faqly-ultimate-faq'),
            'all_products' => __('All products', 'faqly-ultimate-faq'),
            'specific_products' => __('Specific products', 'faqly-ultimate-faq'),
            'specific_products_label' => __('Specific Product(s)', 'faqly-ultimate-faq'),
            'select_faq_group' => __('Select FAQ Group', 'faqly-ultimate-faq'),
            'hold_ctrl_cmd' => __('Hold Ctrl/Cmd to select multiple products', 'faqly-ultimate-faq'),
        ],
    ]);
    // }

    wp_enqueue_style('faqly-accordion-style', FAQLY_PLUGIN_URL . 'assets/admin/css/faq-accordion.css', array(), FAQLY_PLUGIN_VERSION);
    wp_enqueue_style('faqly-accordion-tool-style', FAQLY_PLUGIN_URL . 'assets/admin/css/faqly-tools.css', array(), FAQLY_PLUGIN_VERSION);
    wp_enqueue_script('faqly-accordion-tool-script', FAQLY_PLUGIN_URL . 'assets/admin/js/faqly-tools.js', [], FAQLY_PLUGIN_VERSION, true);
    wp_localize_script('faqly-accordion-tool-script', 'faqly_admin_vars', [
        'ajax_url' => admin_url('admin-ajax.php'),
        'i18n' => [
            'select_export_type' => __('Please select what you want to export.', 'faqly-ultimate-faq'),
            'preparing_export' => __('Preparing Export...', 'faqly-ultimate-faq'),
            'export_complete' => __('Export Complete', 'faqly-ultimate-faq'),
            'items' => __('items', 'faqly-ultimate-faq'),
            'export_failed' => __('Export failed', 'faqly-ultimate-faq'),
            'error' => __('Error', 'faqly-ultimate-faq'),
            'ajax_error' => __('Export failed', 'faqly-ultimate-faq'),
            'timeout_error' => __('Request timed out. Please try again.', 'faqly-ultimate-faq'),
            'invalid_file_type' => __('Please select a valid JSON file.', 'faqly-ultimate-faq'),
            'file_too_large' => __('File size must be less than 10MB.', 'faqly-ultimate-faq'),
            'select_file' => __('Please select a JSON file to import.', 'faqly-ultimate-faq'),
            'importing' => __('Importing...', 'faqly-ultimate-faq'),
            'import_complete' => __('Import Complete', 'faqly-ultimate-faq'),
            'imported' => __('imported', 'faqly-ultimate-faq'),
            'import_failed' => __('Import failed', 'faqly-ultimate-faq'),
            'invalid_json' => __('Invalid JSON file format.', 'faqly-ultimate-faq'),
            'file_read_error' => __('Error reading file.', 'faqly-ultimate-faq'),
        ],
    ]);
    wp_enqueue_script('faqly-accordion-script', FAQLY_PLUGIN_URL . 'assets/admin/js/faq-accordion.js', [], FAQLY_PLUGIN_VERSION, true);
    wp_localize_script('faqly-accordion-script', 'faqly_ajax_object', [
        'ajax_url' => admin_url('admin-ajax.php'),
    ]);

    if ('post.php' === $hook || 'post-new.php' === $hook || (isset($_GET['page']) && ('templates_page' === $_GET['page'] || 'faqly_tools' === $_GET['page'] || 'faqly_woocommerce' === $_GET['page'] || 'faqly-license-key' === $_GET['page']))) {

        wp_enqueue_style('faqly-bootstrap-dash-css', FAQLY_PLUGIN_URL . 'assets/lib/bootstrap.min.css', array(), FAQLY_PLUGIN_VERSION);
        wp_enqueue_script('faqly-bootstrap-dash-js', FAQLY_PLUGIN_URL . 'assets/lib/bootstrap.bundle.min.js', array('jquery'), FAQLY_PLUGIN_VERSION, true);

        add_action('admin_print_scripts', 'faqly_remove_admin_notices', 99);
    }
}
add_action('admin_enqueue_scripts', 'faqly_enqueue_faq_admin_scripts');



function faqly_enqueue_block_editor_assets()
{
    wp_register_script(
        'faqly-template-modal-js',
        FAQLY_PLUGIN_URL . 'assets/admin/js/faq-modal.js',
        array('jquery'),
        FAQLY_PLUGIN_VERSION,
        true
    );

    wp_localize_script(
        'faqly-template-modal-js',
        'faqly_template_modal_js',
        array('admin_ajax' => admin_url('admin-ajax.php'))
    );
    wp_enqueue_script('faqly-template-modal-js');

    wp_enqueue_style('faqly-template-modal-css', FAQLY_PLUGIN_URL . 'assets/admin/css/faq-template-modal.css', array(), FAQLY_PLUGIN_VERSION);
}
add_action('enqueue_block_editor_assets', 'faqly_enqueue_block_editor_assets');

// for remove admin notices
function faqly_remove_admin_notices()
{
    echo '<style>.notice, .update-nag, .updated, .error, .is-dismissible { display: none !important; }</style>';
    remove_all_actions('admin_notices');
    remove_all_actions('all_admin_notices');
}
//for post messege 

add_filter('post_updated_messages', function ($messages) {
    global $post;

    if ($post && $post->post_type === 'faqly_faq_group') {
        $messages['faqly_faq_group'] = [
            1 => 'Accordion updated.', // Updated
            6 => 'Accordion published.', // Published
            4 => 'Accordion updated.', // Updated
            8 => 'Accordion submitted.', // Submitted for review
            10 => 'Accordion draft updated.', // Draft saved
        ];
    }

    return $messages;
});

// for banner 

add_action('admin_notices', 'faqly_admin_notice_with_html');

function faqly_admin_notice_with_html()
{
    ?>
    <div class="notice is-dismissible faqly-upsell-banner">
        <div class="faqly-notice-notice-main-img faqly-upsell-banner-image">
            <img src="<?php echo esc_url(FAQLY_PLUGIN_URL . 'assets/images/faqly-banner.png'); ?>" alt="">
        </div>
        <div class="faqly-notice-banner-wrap faqly-upsell-banner-container">
            <div class="faqly-notice-left-img faqly-upsell-banner-content">
                <h1><?php echo esc_html('WORDPRESS THEMES BUNDLE'); ?></h1>
                <p><?php echo esc_html('GET OVER 50+ RESPONSIVE WORDPRESS THEMES FOR ONLY $79!'); ?></p>
            </div>

            <div class="faqly-notice-btn faqly-upsell-banner-btn">
                <a class="faqly-buy-btn" target="_blank"
                    href="<?php echo esc_url(FAQLY_PLUGIN_MAIN_URL . 'products/wordpress-theme-bundle'); ?>"><?php echo esc_html('BUY NOW'); ?></a>
            </div>
        </div>
    </div>
    <?php
}


add_filter('woocommerce_product_tabs', 'faqly_add_faqs_tab');

function faqly_add_faqs_tab($tabs)
{
    $enabled = get_option('faqly_wc_faqs_enabled', 'yes');
    if ($enabled !== 'yes') {
        return $tabs;
    }

    global $product;
    $product_id = $product->get_id();

    $tab_label = get_option('faqly_wc_faqs_tab_label', __('FAQs', 'faqly-ultimate-faq'));
    $tab_priority = intval(get_option('faqly_wc_faqs_tab_priority', 50));
    $faq_tabs = get_option('faqly_wc_faq_tabs', array());

    $selected_group_id = 0;
    if (!empty($faq_tabs)) {
        foreach ($faq_tabs as $tab) {
            $display_on = $tab['display_on'] ?? 'all';
            $group_id = $tab['group_id'] ?? 0;
            $product_ids = $tab['product_ids'] ?? array();

            if ($display_on === 'all' && $group_id) {
                $selected_group_id = $group_id;
                break;
            }

            if ($display_on === 'specific' && in_array($product_id, $product_ids) && $group_id) {
                $selected_group_id = $group_id;
                break;
            }
        }
    }

    if (!$selected_group_id) {
        return $tabs;
    }

    $tabs['faqly_faqs'] = array(
        'title' => esc_html($tab_label),
        'priority' => $tab_priority,
        'callback' => function () use ($selected_group_id) {
            faqly_render_faqs_tab_content($selected_group_id);
        },
    );

    return $tabs;
}

/**
 * Render FAQs tab content
 */
function faqly_render_faqs_tab_content($group_id)
{
    echo do_shortcode('[faqly_accordion id="' . intval($group_id) . '"]');
}


if (!function_exists('faqly_field_disabled_attr')) {
    function faqly_field_disabled_attr($is_premium_user)
    {
        return $is_premium_user ? '' : 'disabled="disabled"';
    }
}

if (!function_exists('faqly_pro_label')) {
    function faqly_pro_label($is_premium_user)
    {
        return $is_premium_user ? '' : '<a href="' . esc_url(FAQLY_PLUGIN_MAIN_URL . 'products/the-ultimate-faq-wordpress-plugin') . '" target="_blank" class="faqly-pro-label"><span class="dashicons dashicons-lock"></span> Pro</a>';
    }
}



add_action('in_admin_header', 'faqly_show_admin_topbar');
function faqly_show_admin_topbar() {
    if (!current_user_can('manage_options')) {
        return;
    }

    $screen = get_current_screen();
    if ( isset($screen->base) && in_array($screen->base, ['post', 'post-new'], true) ) {
        return;
    }

    $theme      = wp_get_theme();
    $author     = $theme->get('Author');
    $textdomain = $theme->get('TextDomain');

    $shop_url = FAQLY_PLUGIN_MAIN_URL . 'collections/wordpress-themes-shop';

    if ( strtolower(trim($author)) === 'drakearthur') {
        $constant_name = strtoupper(str_replace('-', '_', $textdomain)) . '_PRO_THEME_URL';
        if (defined($constant_name)) {
            $shop_url = constant($constant_name);
        }
    } ?>

    <div class="faqly-admin-topbar">
        <span class="faqly-topbar-text"><?php echo esc_html('Flat 30% OFF Black Friday Deal on WordPress Themes – Use Code '); ?><strong><?php echo esc_html('"BLACK30"'); ?></strong><?php echo esc_html(' This Black Friday!'); ?></span>
        <a href="<?php echo esc_url($shop_url); ?>" target="_blank" class="faqly-topbar-btn"><?php echo esc_html('Buy Now'); ?></a>
    </div>

<?php }


