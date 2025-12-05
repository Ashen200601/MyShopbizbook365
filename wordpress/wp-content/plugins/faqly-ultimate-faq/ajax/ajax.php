<?php
function faqly_get_templates() {

    $url = FAQLY_PLUGIN_LICENSE_URL . 'getFilteredProducts';

    $handle = isset($_POST['handle']) ? $_POST['handle'] : '';
    $search = isset($_POST['search']) ? $_POST['search'] : '';
    $cursor = isset($_POST['cursor']) ? $_POST['cursor'] : null;

    $data = [
        "collectionHandle" => $handle,
        "productHandle" => $search,
        "paginationParams" => [
            "first" => 9,
            "afterCursor" => $cursor,
            "beforeCursor" => null,
            "reverse" => true
        ]
    ];

    $args = [
        'method'    => 'POST',
        'body'      => json_encode($data),
        'headers'   => [
            'Content-Type' => 'application/json',
        ]
    ];

    $response = wp_remote_post($url, $args);

    if (is_wp_error($response)) {
        echo json_encode(array(
            'status'    => false,
            'code'      => 100,
            'data'      => array(),
            'msg'       => $response->get_error_message()
        ));
        exit;
    } else {

        $response_body = wp_remote_retrieve_body($response);
        $data = json_decode($response_body, true);

        echo json_encode(array(
            'status'    => true,
            'code'      => 200,
            'data'      => isset($data['data']) ? $data['data'] : array(),
            'msg'       => 'Templates data retrieved'
        ));
        exit;
    }
}
add_action('wp_ajax_faqly_get_templates', 'faqly_get_templates');
add_action('wp_ajax_nopriv_faqly_get_templates', 'faqly_get_templates');

function faqly_load_faq_content() {
    try {
        if (!isset($_POST['post_id'])) {
            wp_send_json_error('Missing post_id parameter');
            return;
        }

        $post_id = intval($_POST['post_id']);
        $search_term = isset($_POST['search_term']) ? sanitize_text_field($_POST['search_term']) : '';
        $page = isset($_POST['page']) ? intval($_POST['page']) : 1;

        // Include the shortcode class if not already loaded
        if (!class_exists('FAQLY_Shortcode')) {
            $shortcode_file = FAQLY_PLUGIN_DIR . 'includes/class-faq-shortcode.php';
            if (!file_exists($shortcode_file)) {
                wp_send_json_error('Shortcode file not found: ' . $shortcode_file);
                return;
            }
            require_once $shortcode_file;
        }

        // Create shortcode instance and get filtered content
        $shortcode = new FAQLY_Shortcode();
        $result = $shortcode->faqly_get_filtered_content($post_id, $search_term, $page);

        if ($result !== false) {
            wp_send_json_success($result);
        } else {
            wp_send_json_error('Failed to load FAQ content');
        }
    } catch (Exception $e) {
        wp_send_json_error('Exception: ' . $e->getMessage());
    }
}
add_action('wp_ajax_faqly_load_faq_content', 'faqly_load_faq_content');
add_action('wp_ajax_nopriv_faqly_load_faq_content', 'faqly_load_faq_content');

function faqly_export_data() {
    try {
        // Verify nonce
        if (!isset($_POST['nonce']) || !wp_verify_nonce($_POST['nonce'], 'faqly_export_nonce')) {
            wp_send_json_error('Security check failed');
            return;
        }

        // Check user permissions
        if (!current_user_can('manage_options')) {
            wp_send_json_error('Insufficient permissions');
            return;
        }

        // Get export type
        $export_type = isset($_POST['export_type']) ? sanitize_text_field($_POST['export_type']) : '';

        if (empty($export_type)) {
            wp_send_json_error('Please select what to export');
            return;
        }

        $post_type = '';
        $filename = '';

        switch ($export_type) {
            case 'faqs':
                $post_type = 'faqly_faq';
                $filename = 'faqly_faqs_export_' . date('Y-m-d_H-i-s') . '.json';
                break;
            case 'groups':
                $post_type = 'faqly_faq_group';
                $filename = 'faqly_groups_export_' . date('Y-m-d_H-i-s') . '.json';
                break;
            default:
                wp_send_json_error('Invalid export type selected');
                return;
        }

        // Get all posts of the selected type
        $args = array(
            'post_type'      => $post_type,
            'posts_per_page' => -1,
            'post_status'    => 'any',
        );

        $posts = get_posts($args);
        $export_data = array();

        foreach ($posts as $post) {
            $post_data = array(
                'ID'           => $post->ID,
                'post_title'   => $post->post_title,
                'post_content' => $post->post_content,
                'post_status'  => $post->post_status,
                'post_date'    => $post->post_date,
                'post_modified' => $post->post_modified,
                'post_type'    => $post->post_type,
            );

            // Get post meta
            $meta = get_post_meta($post->ID);
            if (!empty($meta)) {
                $post_data['meta'] = array();
                foreach ($meta as $key => $values) {
                    $post_data['meta'][$key] = maybe_unserialize($values[0]);
                }
            }

            // Get taxonomy terms if any
            $taxonomies = get_object_taxonomies($post_type);
            if (!empty($taxonomies)) {
                $post_data['taxonomies'] = array();
                foreach ($taxonomies as $taxonomy) {
                    $terms = wp_get_post_terms($post->ID, $taxonomy);
                    if (!is_wp_error($terms) && !empty($terms)) {
                        $post_data['taxonomies'][$taxonomy] = array();
                        foreach ($terms as $term) {
                            $post_data['taxonomies'][$taxonomy][] = array(
                                'term_id' => $term->term_id,
                                'name'    => $term->name,
                                'slug'    => $term->slug,
                            );
                        }
                    }
                }
            }

            $export_data[] = $post_data;
        }

        // Return success with data and filename
        wp_send_json_success(array(
            'data' => $export_data,
            'filename' => $filename,
            'count' => count($export_data)
        ));

    } catch (Exception $e) {
        wp_send_json_error('Export failed: ' . $e->getMessage());
    }
}
add_action('wp_ajax_faqly_export_data', 'faqly_export_data');

function faqly_get_products() {
    try {
        // Check user permissions
        if (!current_user_can('manage_options')) {
            wp_send_json_error('Insufficient permissions');
            return;
        }

        if (!class_exists('WooCommerce')) {
            wp_send_json_error('WooCommerce is not active');
            return;
        }

        $products = wc_get_products(array(
            'status' => 'publish',
            'limit' => 100, // Increased limit for better UX
            'orderby' => 'title',
            'order' => 'ASC'
        ));

        $product_data = array();
        foreach ($products as $product) {
            $product_data[] = array(
                'id' => $product->get_id(),
                'name' => $product->get_name()
            );
        }

        wp_send_json_success($product_data);

    } catch (Exception $e) {
        wp_send_json_error('Failed to fetch products: ' . $e->getMessage());
    }
}
add_action('wp_ajax_faqly_get_products', 'faqly_get_products');

function faqly_import_data() {
    try {
        // Verify nonce
        if (!isset($_POST['nonce']) || !wp_verify_nonce($_POST['nonce'], 'faqly_import_nonce')) {
            wp_send_json_error('Security check failed');
            return;
        }

        // Check user permissions
        if (!current_user_can('manage_options')) {
            wp_send_json_error('Insufficient permissions');
            return;
        }

        // Check if data is provided
        if (!isset($_POST['data']) || empty($_POST['data'])) {
            wp_send_json_error('No import data provided');
            return;
        }

        $import_data = $_POST['data'];

        if (!is_array($import_data)) {
            wp_send_json_error('Invalid import data format');
            return;
        }

        $imported_count = 0;

        foreach ($import_data as $item) {
            if (!isset($item['ID']) || !isset($item['post_type'])) {
                continue; // skip invalid entries
            }

            $post_id = intval($item['ID']);
            $post_type = sanitize_text_field($item['post_type']);

            // Check if post already exists
            $existing_post = get_post($post_id);

            $post_data = [
                'ID'           => $post_id,
                'post_title'   => isset($item['post_title']) ? sanitize_text_field($item['post_title']) : '',
                'post_content' => isset($item['post_content']) ? wp_kses_post($item['post_content']) : '',
                'post_status'  => isset($item['post_status']) ? sanitize_text_field($item['post_status']) : 'publish',
                'post_type'    => $post_type,
                'post_date'    => isset($item['post_date']) ? sanitize_text_field($item['post_date']) : current_time('mysql'),
                'post_modified'=> isset($item['post_modified']) ? sanitize_text_field($item['post_modified']) : current_time('mysql'),
            ];

            if ($existing_post) {
                // Update existing post
                wp_update_post($post_data);
                $new_post_id = $post_id;
            } else {
                // Insert new post
                unset($post_data['ID']);
                $new_post_id = wp_insert_post($post_data);
            }

            if (is_wp_error($new_post_id) || !$new_post_id) {
                continue; // skip on error
            }

            // Update post meta
            if (isset($item['meta']) && is_array($item['meta'])) {
                foreach ($item['meta'] as $meta_key => $meta_value) {
                    update_post_meta($new_post_id, sanitize_key($meta_key), maybe_unserialize($meta_value));
                }
            }

            // Update taxonomies
            if (isset($item['taxonomies']) && is_array($item['taxonomies'])) {
                foreach ($item['taxonomies'] as $taxonomy => $terms) {
                    $term_slugs = [];
                    foreach ($terms as $term) {
                        if (isset($term['slug'])) {
                            $term_slugs[] = sanitize_title($term['slug']);
                        }
                    }
                    wp_set_object_terms($new_post_id, $term_slugs, sanitize_text_field($taxonomy));
                }
            }

            $imported_count++;
        }

        wp_send_json_success([
            'imported' => $imported_count,
            // 'skipped' => $skipped_count,
        ]);

    } catch (Exception $e) {
        wp_send_json_error('Import failed: ' . $e->getMessage());
    }
}
add_action('wp_ajax_faqly_import_data', 'faqly_import_data');
