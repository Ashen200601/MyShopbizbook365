<?php
if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

require_once plugin_dir_path(__FILE__) . 'faq-theme-helpers.php';

class FAQLY_Shortcode
{
    private static $accordion_counter = 0;

    public function __construct()
    {
        add_shortcode('faqly_accordion', [$this, 'faqly_render_faqly_accordion']);
    }

    public function faqly_render_faqly_accordion($atts)
    {
        $atts = shortcode_atts([
            'id' => 0,
        ], $atts, 'faqly_accordion');

        $post_id = intval($atts['id']);

        if (!$post_id) {
            return '<p>Error: No FAQ group specified.</p>';
        }

        $accordion_event = get_post_meta($post_id, '_accordion_event', true) ?: '.click';

        wp_enqueue_script('faqly-accordion-script1', FAQLY_PLUGIN_URL . 'assets/faq-accordion-front.js', ['jquery'], FAQLY_PLUGIN_VERSION, true);
        wp_enqueue_style('animate-css', FAQLY_PLUGIN_URL . 'assets/lib/animate.css', [], '4.1.1');
        wp_enqueue_style('faqly-dynamic-styles', FAQLY_PLUGIN_URL . 'assets/faq-dynamic-styles.css', [], FAQLY_PLUGIN_VERSION);

        $icon_style = get_post_meta($post_id, '_faq_icon_style', true) ?: 'theme-default';
        $selected_theme = get_post_meta($post_id, '_faqly_selected_theme', true) ?: 'faqly-one';
        $icon_position = get_post_meta($post_id, '_faq_icon_position', true);
        if (empty($icon_position)) {
            $icon_position = FAQLY_Theme_Helpers::get_theme_default_icon_position($selected_theme);
        }

        if ($icon_style === 'theme-default') {
            $icon_html = FAQLY_Theme_Helpers::generate_theme_default_icon_html($selected_theme);
        } else {

            $icon_html = FAQLY_Theme_Helpers::generate_icon_html($icon_style);
        }

        $faq_title_font_size = get_post_meta($post_id, '_faq_title_font_size', true) ?: '25px';
        $faq_desc_font_size = get_post_meta($post_id, '_faq_desc_font_size', true) ?: '18px';
        $faq_border_radius = get_post_meta($post_id, '_faq_border_radius', true) ?: '5px';

        $faq_animation_enable = get_post_meta($post_id, '_faq_animation_enable', true) ?: 'yes';
        $faq_animation_style = get_post_meta($post_id, '_faq_animation_style', true) ?: 'normal';
        $faq_transition_time = get_post_meta($post_id, '_faq_transition_time', true) ?: '300';

        // Display settings
        $faq_use_theme_default_style = get_post_meta($post_id, '_faq_use_theme_default_style', true) ?: 'enable';
        $faq_title_html_tag = get_post_meta($post_id, '_faq_title_html_tag', true) ?: 'h2';
        $faq_title_color = get_post_meta($post_id, '_faq_title_color', true) ?: '#333333';
        $faq_title_bg_color = get_post_meta($post_id, '_faq_title_bg_color', true) ?: '#ffffff';
        $faq_desc_color = get_post_meta($post_id, '_faq_desc_color', true) ?: '#666666';
        $faq_desc_bg_color = get_post_meta($post_id, '_faq_desc_bg_color', true) ?: '#f8f9fa';
        $faq_item_border_width = get_post_meta($post_id, '_faq_item_border_width', true) ?: '0';
        $faq_item_border_style = get_post_meta($post_id, '_faq_item_border_style', true) ?: 'solid';
        $faq_item_border_color = get_post_meta($post_id, '_faq_item_border_color', true) ?: '#dd3333';

        // Title padding settings
        $faq_title_padding_top = get_post_meta($post_id, '_faq_title_padding_top', true) ?: '10';
        $faq_title_padding_right = get_post_meta($post_id, '_faq_title_padding_right', true) ?: '10';
        $faq_title_padding_bottom = get_post_meta($post_id, '_faq_title_padding_bottom', true) ?: '10';
        $faq_title_padding_left = get_post_meta($post_id, '_faq_title_padding_left', true) ?: '10';

        // Description padding settings
        $faq_desc_padding_top = get_post_meta($post_id, '_faq_desc_padding_top', true) ?: '10';
        $faq_desc_padding_right = get_post_meta($post_id, '_faq_desc_padding_right', true) ?: '10';
        $faq_desc_padding_bottom = get_post_meta($post_id, '_faq_desc_padding_bottom', true) ?: '10';
        $faq_desc_padding_left = get_post_meta($post_id, '_faq_desc_padding_left', true) ?: '10';

        // Typography settings
        $faq_item_title_load_font = get_post_meta($post_id, '_faq_item_title_load_font', true) ?: 'off';
        $faq_item_title_font_family = get_post_meta($post_id, '_faq_item_title_font_family', true) ?: 'Arial';
        $faq_item_title_font_style = get_post_meta($post_id, '_faq_item_title_font_style', true) ?: 'normal';
        $faq_item_title_font_subset = get_post_meta($post_id, '_faq_item_title_font_subset', true) ?: 'latin';
        $faq_item_title_text_align = get_post_meta($post_id, '_faq_item_title_text_align', true) ?: 'left';
        $faq_item_title_text_transform = get_post_meta($post_id, '_faq_item_title_text_transform', true) ?: 'none';

        $faq_item_desc_load_font = get_post_meta($post_id, '_faq_item_desc_load_font', true) ?: 'off';
        $faq_item_desc_font_family = get_post_meta($post_id, '_faq_item_desc_font_family', true) ?: 'Arial';
        $faq_item_desc_font_style = get_post_meta($post_id, '_faq_item_desc_font_style', true) ?: 'normal';
        $faq_item_desc_font_subset = get_post_meta($post_id, '_faq_item_desc_font_subset', true) ?: 'latin';
        $faq_item_desc_text_align = get_post_meta($post_id, '_faq_item_desc_text_align', true) ?: 'left';
        $faq_item_desc_text_transform = get_post_meta($post_id, '_faq_item_desc_text_transform', true) ?: 'none';

        // Theme settings
        $selected_theme = get_post_meta($post_id, '_faqly_selected_theme', true) ?: 'faqly-one';

        // Get theme-specific classes
        $theme_classes = FAQLY_Theme_Helpers::get_theme_classes($selected_theme);

        $custom_css_props = [
            '--faq-title-font-size' => $faq_title_font_size,
            '--faq-desc-font-size' => $faq_desc_font_size,
            '--faq-border-radius' => $faq_border_radius,
            '--faq-title-font-family' => $faq_item_title_load_font === 'on' ? "'$faq_item_title_font_family', sans-serif" : 'inherit',
            '--faq-title-font-style' => $faq_item_title_font_style,
            '--faq-title-text-align' => $faq_item_title_text_align,
            '--faq-title-text-transform' => $faq_item_title_text_transform,
            '--faq-desc-font-family' => $faq_item_desc_load_font === 'on' ? "'$faq_item_desc_font_family', sans-serif" : 'inherit',
            '--faq-desc-font-style' => $faq_item_desc_font_style,
            '--faq-desc-text-align' => $faq_item_desc_text_align,
            '--faq-desc-text-transform' => $faq_item_desc_text_transform,
            '--faq-animation-enable' => $faq_animation_enable,
            '--faq-animation-style' => $faq_animation_style,
            '--faq-transition-time' => $faq_transition_time . 'ms',
        ];

        if ($faq_use_theme_default_style === 'disable') {
            // Use custom colors and styles when theme defaults are disabled
            $custom_css_props = array_merge($custom_css_props, [
                '--faq-title-color' => $faq_title_color,
                '--faq-title-bg-color' => $faq_title_bg_color,
                '--faq-desc-color' => $faq_desc_color,
                '--faq-desc-bg-color' => $faq_desc_bg_color,
                '--faq-border-width' => $faq_item_border_width . 'px',
                '--faq-border-style' => $faq_item_border_style,
                '--faq-border-color' => $faq_item_border_color,
                '--faq-title-padding-top' => $faq_title_padding_top . 'px',
                '--faq-title-padding-right' => $faq_title_padding_right . 'px',
                '--faq-title-padding-bottom' => $faq_title_padding_bottom . 'px',
                '--faq-title-padding-left' => $faq_title_padding_left . 'px',
                '--faq-desc-padding-top' => $faq_desc_padding_top . 'px',
                '--faq-desc-padding-right' => $faq_desc_padding_right . 'px',
                '--faq-desc-padding-bottom' => $faq_desc_padding_bottom . 'px',
                '--faq-desc-padding-left' => $faq_desc_padding_left . 'px',
            ]);
        } else {
            $custom_css_props = array_merge($custom_css_props, [
                '--faq-title-color' => 'inherit',
                '--faq-title-bg-color' => 'inherit',
                '--faq-desc-color' => 'inherit',
                '--faq-desc-bg-color' => 'inherit',
                '--faq-border-width' => 'inherit',
                '--faq-border-style' => 'inherit',
                '--faq-border-color' => 'inherit',
                '--faq-title-padding-top' => 'inherit',
                '--faq-title-padding-right' => 'inherit',
                '--faq-title-padding-bottom' => 'inherit',
                '--faq-title-padding-left' => 'inherit',
                '--faq-desc-padding-top' => 'inherit',
                '--faq-desc-padding-right' => 'inherit',
                '--faq-desc-padding-bottom' => 'inherit',
                '--faq-desc-padding-left' => 'inherit',
            ]);
        }

        $style_attr = '';
        foreach ($custom_css_props as $prop => $value) {
            $style_attr .= $prop . ': ' . $value . '; ';
        }

        $faq_search = get_post_meta($post_id, '_faq_search', true) === 'enable';
        $active_tab = get_post_meta($post_id, '_faq_active_tab', true) ?: 'faq-custom';
        $layout_selection = get_post_meta($post_id, '_layout_selection', true) ?: 'vertical';

        $accordion_id = 'faqAccordion-' . $post_id . '-' . self::$accordion_counter++;
        $content_data = $this->faqly_get_filtered_content($post_id, '', 1, $accordion_id);

        if ($content_data['total_items'] === 0) {
            return '<p>No FAQs found.</p>';
        }

        $faq_schema_markup_enable = get_post_meta($post_id, '_faq_schema_markup_enable', true) ?: 'disable';
        $schema_markup = '';

        if ($faq_schema_markup_enable === 'enable') {
            require_once plugin_dir_path(__FILE__) . 'class-schema-markup.php';

            if ($active_tab === 'faq-custom') {
                $all_custom_faqs = get_post_meta($post_id, '_faq_items', true);
                $all_custom_faqs = is_array($all_custom_faqs) ? $all_custom_faqs : [];
                $schema_markup = Faqly_Schema_Markup::generate_faq_schema($all_custom_faqs);
            } elseif ($active_tab === 'faq-post') {
                $faq_post_type = get_post_meta($post_id, '_faq_post_type', true) ?: 'post';
                $faq_custom_post_type = get_post_meta($post_id, '_faq_custom_post_type', true);
                $faq_filter_posts = get_post_meta($post_id, '_faq_filter_posts', true) ?: 'latest';
                $faq_order_by = get_post_meta($post_id, '_faq_order_by', true) ?: 'date';
                $faq_order = get_post_meta($post_id, '_faq_order', true) ?: 'DESC';
                $exclude_ids = get_post_meta($post_id, '_faq_exclude_ids', true) ?: '';

                $post_type_to_query = $faq_post_type;
                if ($faq_post_type === 'custom' && !empty($faq_custom_post_type)) {
                    $post_type_to_query = $faq_custom_post_type;
                }

                $query_args = [
                    'post_type' => $post_type_to_query,
                    'posts_per_page' => -1,
                    'orderby' => $faq_order_by,
                    'order' => $faq_order,
                    'post__not_in' => $exclude_ids ? explode(',', $exclude_ids) : [],
                ];

                // Handle different filter types
                switch ($faq_filter_posts) {
                    case 'latest':

                        break;
                    case 'taxonomy':
                        $faq_taxonomy_name = get_post_meta($post_id, '_faq_taxonomy_name', true);
                        $faq_taxonomy_terms = get_post_meta($post_id, '_faq_taxonomy_terms', true);

                        if (!empty($faq_taxonomy_name)) {
                            $tax_query = [
                                'taxonomy' => $faq_taxonomy_name,
                                'field' => 'slug',
                            ];

                            if (!empty($faq_taxonomy_terms)) {
                                $term_slugs = array_map('trim', explode(',', $faq_taxonomy_terms));
                                $tax_query['terms'] = $term_slugs;
                                $tax_query['operator'] = 'IN';
                            }

                            $query_args['tax_query'] = [$tax_query];
                        }
                        break;
                    case 'specific':
                        $faq_specific_posts = get_post_meta($post_id, '_faq_specific_posts', true);

                        if (!empty($faq_specific_posts)) {
                            $specific_ids = array_filter(array_map('intval', explode(',', $faq_specific_posts)));
                            if (!empty($specific_ids)) {
                                $query_args['post__in'] = $specific_ids;
                                $query_args['orderby'] = 'post__in';
                            }
                        }
                        break;
                }

                $all_posts_query = new WP_Query($query_args);
                $all_posts = $all_posts_query->have_posts() ? $all_posts_query->posts : [];
                wp_reset_postdata();

                $schema_markup = Faqly_Schema_Markup::generate_post_faq_schema($all_posts);
            }
        }

        $output = $schema_markup;
        $output .= '<!-- DEBUG: Selected layout is ' . esc_attr($layout_selection) . ' -->';

        $animation_class = '';
        if ($faq_animation_enable === 'no') {
            $animation_class = 'animation-disabled';
        } elseif ($faq_animation_enable === 'yes' && $faq_animation_style !== 'normal') {
            $animation_class = 'animate-enabled';
        }

        $dynamic_styles_class = ($faq_use_theme_default_style === 'disable') ? 'dynamic-styles-enabled' : '';

        $output .= '<div class="faq-accordion-container ' . esc_attr($theme_classes) . ' ' . esc_attr($animation_class) . ' ' . esc_attr($dynamic_styles_class) . '" style="' . esc_attr($style_attr) . '">';

        if ($faq_search) {
            $output .= '<div class="faq-search-container">
                            <input type="text" class="faq-search-box" placeholder="Search FAQs">
                        </div>';
        }

        // Add expand/collapse all button if enabled
        $expand_collapse_all = get_post_meta($post_id, '_faq_expand_collapse_all', true) ?: 'disable';
        if ($expand_collapse_all === 'enable') {
            $output .= '<div class="faq-expand-collapse-container">
                            <button class="faq-expand-all-btn" type="button">Expand All</button>
                            <button class="faq-collapse-all-btn" type="button">Collapse All</button>
                        </div>';
        }

        $accordion_event = get_post_meta($post_id, '_accordion_event', true) ?: '.click';
        $accordion_mode = get_post_meta($post_id, '_accordion_mode', true) ?: '.first_open';
        $multiple_active = get_post_meta($post_id, '_faq_multiple_active', true) ?: 'disable';
        $output .= '<div class="accordion ' . esc_attr($layout_selection) . '" id="' . esc_attr($accordion_id) . '" data-post-id="' . esc_attr($post_id) . '" data-current-page="' . esc_attr($content_data['current_page']) . '" data-total-pages="' . esc_attr($content_data['total_pages']) . '" data-animation-enable="' . esc_attr($faq_animation_enable) . '" data-animation-style="' . esc_attr($faq_animation_style) . '" data-transition-time="' . esc_attr($faq_transition_time) . '" data-accordion-event="' . esc_attr($accordion_event) . '" data-accordion-mode="' . esc_attr($accordion_mode) . '" data-multiple-active="' . esc_attr($multiple_active) . '">';
        $output .= $content_data['items_html'];
        $output .= '<div class="no-results-message" style="display:none;">No FAQs found according to your search.</div>';
        $output .= '</div>';
        $output .= $content_data['pagination_html'];
        $output .= '</div>'; // Close faq-accordion-container

        return $output;
    }

    /**
     * Generate pagination HTML
     *
     * @param int $post_id The post ID
     * @param int $current_page Current page number
     * @param int $total_pages Total number of pages
     * @return string Pagination HTML
     */
    private function generate_pagination_html($post_id, $current_page, $total_pages)
    {
        if ($total_pages <= 1) {
            return '<div class="faq-pagination" data-post-id="' . esc_attr($post_id) . '" style="display: none;"></div>';
        }

        $pagination_html = '<div class="faq-pagination" data-post-id="' . esc_attr($post_id) . '">';
        for ($page = 1; $page <= $total_pages; $page++) {
            $active_class = ($page == $current_page) ? ' active' : '';
            $pagination_html .= '<button class="faq-page-btn' . $active_class . '" data-page="' . esc_attr($page) . '">' . esc_html($page) . '</button>';
        }
        $pagination_html .= '</div>';

        return $pagination_html;
    }



    /**
     * Generate HTML for custom FAQ items
     */
    private function generate_items_html($items, $post_id, $page, $items_per_page, $layout_selection, $title_html_tag, $icon_html, $icon_position, $faq_multiple_active = 'disable', $accordion_id = '')
    {
        if (empty($accordion_id)) {
            $accordion_id = 'faqAccordion-' . $post_id;
        }
        $items_html = '';
        foreach ($items as $index => $faq) {
            $global_index = ($page - 1) * $items_per_page + $index;
            $is_first = $index === 0 ? ' show' : '';

            $button_text = esc_html($faq['title'] ?? 'FAQ ' . ($global_index + 1));
            if ($icon_position === 'left') {
                $button_content = $icon_html . ' ' . $button_text;
            } else {
                $button_content = $button_text . ' ' . $icon_html;
            }

            // Conditionally set data-bs-parent attribute based on multiple active setting
            $data_bs_parent = ($faq_multiple_active === 'enable') ? '' : ' data-bs-parent="#' . $accordion_id . '"';

            $heading_id = 'heading' . $accordion_id . '-' . $global_index;
            $collapse_id = 'collapse' . $accordion_id . '-' . $global_index;

            if ($layout_selection === 'horizontal') {
                $items_html .= '
                 <div class="accordion-item">
                        <' . esc_attr($title_html_tag) . ' class="accordion-header" id="' . $heading_id . '">
                            <button class="accordion-button faq-display-custom' . ($is_first ? '' : ' collapsed') . '" type="button" data-bs-toggle="collapse" data-bs-target="#' . $collapse_id . '" aria-expanded="' . ($is_first ? 'true' : 'false') . '" aria-controls="' . $collapse_id . '">
                                ' . $button_content . '
                            </button>
                        </' . esc_attr($title_html_tag) . '>
                        <div id="' . $collapse_id . '" class="accordion-collapse faq-display-custom-collapse collapse' . $is_first . '" aria-labelledby="' . $heading_id . '"' . $data_bs_parent . '>
                        <div class="accordion-body faq-display-custom-body">
                            ' . wp_kses_post(do_shortcode($faq['description'] ?? '')) . '
                        </div>
                    </div>
                    </div>';
            } else {
                $items_html .= '
                 <div class="accordion-item">
                        <' . esc_attr($title_html_tag) . ' class="accordion-header" id="' . $heading_id . '">
                            <button class="accordion-button faq-display-custom' . ($is_first ? '' : ' collapsed') . '" type="button" data-bs-toggle="collapse" data-bs-target="#' . $collapse_id . '" aria-expanded="' . ($is_first ? 'true' : 'false') . '" aria-controls="' . $collapse_id . '">
                                ' . $button_content . '
                            </button>
                        </' . esc_attr($title_html_tag) . '>
                        <div id="' . $collapse_id . '" class="accordion-collapse faq-display-custom-collapse collapse' . $is_first . '" aria-labelledby="' . $heading_id . '"' . $data_bs_parent . '>
                            <div class="accordion-body faq-display-custom-body">
                                ' . wp_kses_post(do_shortcode($faq['description'] ?? '')) . '
                            </div>
                        </div>
                    </div>';
            }
        }
        return $items_html;
    }

    /**
     * Generate HTML for post-based FAQ items
     */
    private function generate_posts_html($posts, $post_id, $page, $items_per_page, $layout_selection, $title_html_tag, $icon_html, $icon_position, $faq_multiple_active = 'disable', $accordion_id = '')
    {
        if (empty($accordion_id)) {
            $accordion_id = 'faqAccordion-' . $post_id;
        }
        $items_html = '';
        $counter = 0;
        foreach ($posts as $post_item) {
            $counter++;
            $global_index = ($page - 1) * $items_per_page + $counter - 1;
            $is_first = $counter === 1 ? ' show' : '';

            setup_postdata($post_item);

            $post_title = esc_html(get_the_title($post_item->ID));
            $post_content = wp_kses_post(apply_filters('the_content', get_post_field('post_content', $post_item->ID)));

            if ($icon_position === 'left') {
                $button_content = $icon_html . ' ' . $post_title;
            } else {
                $button_content = $post_title . ' ' . $icon_html;
            }

            // Conditionally set data-bs-parent attribute based on multiple active setting
            $data_bs_parent = ($faq_multiple_active === 'enable') ? '' : ' data-bs-parent="#' . $accordion_id . '"';

            $heading_id = 'heading' . $accordion_id . '-' . $global_index;
            $collapse_id = 'collapse' . $accordion_id . '-' . $global_index;

            if ($layout_selection === 'horizontal') {
                $items_html .= '
        <div class="accordion-item">
            <' . esc_attr($title_html_tag) . ' class="accordion-header" id="' . $heading_id . '">
                <button class="accordion-button faq-display-custom' . ($is_first ? '' : ' collapsed') . '" type="button" data-bs-toggle="collapse" data-bs-target="#' . $collapse_id . '" aria-expanded="' . ($is_first ? 'true' : 'false') . '" aria-controls="' . $collapse_id . '">
                        ' . $button_content . '
                </button>
            </' . esc_attr($title_html_tag) . '>
            <div id="' . $collapse_id . '" class="accordion-collapse faq-display-custom-collapse collapse' . $is_first . '" aria-labelledby="' . $heading_id . '"' . $data_bs_parent . '>
                <div class="accordion-body faq-display-custom-body">
                    ' . $post_content . '
                </div>
            </div>
        </div>';
            } else {
                $items_html .= '
        <div class="accordion-item">
            <' . esc_attr($title_html_tag) . ' class="accordion-header" id="' . $heading_id . '">
                <button class="accordion-button faq-display-custom' . ($is_first ? '' : ' collapsed') . '" type="button" data-bs-toggle="collapse" data-bs-target="#' . $collapse_id . '" aria-expanded="' . ($is_first ? 'true' : 'false') . '" aria-controls="' . $collapse_id . '">
                        ' . $button_content . '
                </button>
            </' . esc_attr($title_html_tag) . '>
            <div id="' . $collapse_id . '" class="accordion-collapse faq-display-custom-collapse collapse' . $is_first . '" aria-labelledby="' . $heading_id . '"' . $data_bs_parent . '>
                <div class="accordion-body faq-display-custom-body">
                    ' . $post_content . '
                </div>
            </div>
        </div>';
            }
        }
        wp_reset_postdata();
        return $items_html;
    }

    /**
     * Unified method to get filtered FAQ content (handles both search and pagination)
     *
     * @param int $post_id The post ID
     * @param string $search_term Search term (optional)
     * @param int $page Current page number
     * @return array Response data with items_html, pagination_html, etc.
     */
    public function faqly_get_filtered_content($post_id, $search_term = '', $page = 1, $accordion_id = '')
    {
        // Get settings
        $active_tab = get_post_meta($post_id, '_faq_active_tab', true) ?: 'faq-custom';
        $faq_ajax_pagination_enable = get_post_meta($post_id, '_faq_ajax_pagination_enable', true) ?: 'disable';
        $faq_items_per_page = intval(get_post_meta($post_id, '_faq_items_per_page', true)) ?: 10;

        // Get other settings needed for rendering
        $layout_selection = get_post_meta($post_id, '_layout_selection', true) ?: 'vertical';
        $selected_theme = get_post_meta($post_id, '_faqly_selected_theme', true) ?: 'faqly-one';
        $icon_position = get_post_meta($post_id, '_faq_icon_position', true) ?: 'right';
        $icon_style = get_post_meta($post_id, '_faq_icon_style', true) ?: 'plus';
        $faq_title_html_tag = get_post_meta($post_id, '_faq_title_html_tag', true) ?: 'h2';
        $faq_multiple_active = get_post_meta($post_id, '_faq_multiple_active', true) ?: 'disable';

        $theme_classes = FAQLY_Theme_Helpers::get_theme_classes($selected_theme);

        if ($icon_style === 'theme-default') {
            $icon_html = FAQLY_Theme_Helpers::generate_theme_default_icon_html($selected_theme);
        } else {
            $icon_html = FAQLY_Theme_Helpers::generate_icon_html($icon_style);
        }

        if (empty($accordion_id)) {
            $accordion_id = 'faqAccordion-' . $post_id;
        }

        $filtered_items = [];
        $total_filtered = 0;
        $total_pages = 1;

        if ($active_tab === 'faq-custom') {
            $custom_faqs = get_post_meta($post_id, '_faq_items', true);
            $custom_faqs = is_array($custom_faqs) ? $custom_faqs : [];

            if (empty($custom_faqs)) {
                return [
                    'items_html' => '',
                    'pagination_html' => '<div class="faq-pagination" data-post-id="' . esc_attr($post_id) . '" style="display: none;"></div>',
                    'total_pages' => 0,
                    'current_page' => $page,
                    'total_items' => 0
                ];
            }

            // Filter FAQs based on search term
            if (!empty($search_term)) {
                foreach ($custom_faqs as $faq) {
                    $title = isset($faq['title']) ? $faq['title'] : '';
                    $description = isset($faq['description']) ? $faq['description'] : '';

                    if (stripos($title, $search_term) !== false || stripos(strip_tags($description), $search_term) !== false) {
                        $filtered_items[] = $faq;
                    }
                }
            } else {
                $filtered_items = $custom_faqs;
            }

            $total_filtered = count($filtered_items);

            // Handle pagination for filtered results
            if ($faq_ajax_pagination_enable === 'enable' && $total_filtered > $faq_items_per_page) {
                $total_pages = ceil($total_filtered / $faq_items_per_page);
                $offset = ($page - 1) * $faq_items_per_page;
                $current_items = array_slice($filtered_items, $offset, $faq_items_per_page);
            } else {
                $total_pages = 1;
                $current_items = $filtered_items;
            }

            $items_html = $this->generate_items_html($current_items, $post_id, $page, $faq_items_per_page, $layout_selection, $faq_title_html_tag, $icon_html, $icon_position, $faq_multiple_active, $accordion_id);

        } elseif ($active_tab === 'faq-post') {
            $faq_post_type = get_post_meta($post_id, '_faq_post_type', true) ?: 'post';
            $faq_custom_post_type = get_post_meta($post_id, '_faq_custom_post_type', true);
            $faq_filter_posts = get_post_meta($post_id, '_faq_filter_posts', true) ?: 'latest';
            $faq_order_by = get_post_meta($post_id, '_faq_order_by', true) ?: 'date';
            $faq_order = get_post_meta($post_id, '_faq_order', true) ?: 'DESC';
            $exclude_ids = get_post_meta($post_id, '_faq_exclude_ids', true) ?: '';

            // Determine post type to query
            $post_type_to_query = $faq_post_type;
            if ($faq_post_type === 'custom' && !empty($faq_custom_post_type)) {
                $post_type_to_query = $faq_custom_post_type;
            }

            $query_args = [
                'post_type' => $post_type_to_query,
                'posts_per_page' => -1,
                'orderby' => $faq_order_by,
                'order' => $faq_order,
                'post__not_in' => $exclude_ids ? explode(',', $exclude_ids) : [],
            ];

            // Handle different filter types
            switch ($faq_filter_posts) {
                case 'latest':
                    // Default behavior - already handled by orderby and order
                    break;

                case 'taxonomy':
                    // Add taxonomy filtering logic
                    $faq_taxonomy_name = get_post_meta($post_id, '_faq_taxonomy_name', true);
                    $faq_taxonomy_terms = get_post_meta($post_id, '_faq_taxonomy_terms', true);

                    if (!empty($faq_taxonomy_name)) {
                        $tax_query = array(
                            'taxonomy' => $faq_taxonomy_name,
                            'field' => 'slug',
                        );

                        if (!empty($faq_taxonomy_terms)) {
                            $term_slugs = array_map('trim', explode(',', $faq_taxonomy_terms));
                            $tax_query['terms'] = $term_slugs;
                            $tax_query['operator'] = 'IN';
                        }

                        $query_args['tax_query'] = array($tax_query);
                    }
                    break;

                case 'specific':
                    $faq_specific_posts = get_post_meta($post_id, '_faq_specific_posts', true);

                    if (!empty($faq_specific_posts)) {
                        $specific_ids = array_filter(array_map('intval', explode(',', $faq_specific_posts)));
                        if (!empty($specific_ids)) {
                            $query_args['post__in'] = $specific_ids;
                            $query_args['orderby'] = 'post__in';
                        }
                    }
                    break;
            }

            if (!empty($search_term)) {
                $query_args['s'] = $search_term;
            }

            $all_posts_query = new WP_Query($query_args);

            if (!$all_posts_query->have_posts()) {
                return [
                    'items_html' => '',
                    'pagination_html' => '<div class="faq-pagination" data-post-id="' . esc_attr($post_id) . '" style="display: none;"></div>',
                    'total_pages' => 0,
                    'current_page' => $page,
                    'total_items' => 0
                ];
            }

            $all_posts = $all_posts_query->posts;
            wp_reset_postdata();

            $total_filtered = count($all_posts);

            if ($faq_ajax_pagination_enable === 'enable' && $total_filtered > $faq_items_per_page) {
                $total_pages = ceil($total_filtered / $faq_items_per_page);
                $offset = ($page - 1) * $faq_items_per_page;
                $current_posts = array_slice($all_posts, $offset, $faq_items_per_page);
            } else {
                $total_pages = 1;
                $current_posts = $all_posts;
            }

            $items_html = $this->generate_posts_html($current_posts, $post_id, $page, $faq_items_per_page, $layout_selection, $faq_title_html_tag, $icon_html, $icon_position, $faq_multiple_active, $accordion_id);
        }

        $pagination_html = $this->generate_pagination_html($post_id, $page, $total_pages);

        return [
            'items_html' => $items_html,
            'pagination_html' => $pagination_html,
            'total_pages' => $total_pages,
            'current_page' => $page,
            'total_items' => $total_filtered
        ];
    }
}

new FAQLY_Shortcode();