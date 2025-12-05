<?php
if (!defined('ABSPATH')) {
    exit;
}

class Faqly_Schema_Markup
{

    /**
     * Generate JSON-LD schema markup for FAQPage
     *
     * @param array $faqs Array of FAQ items with 'title' and 'description'
     * @return string JSON-LD script tag
     */
    public static function generate_faq_schema($faqs)
    {
        if (empty($faqs) || !is_array($faqs)) {
            return '';
        }

        $schema_data = [
            '@context' => 'https://schema.org',
            '@type' => 'FAQPage',
            'mainEntity' => []
        ];

        foreach ($faqs as $faq) {
            if (!empty($faq['title']) && !empty($faq['description'])) {
                $schema_data['mainEntity'][] = [
                    '@type' => 'Question',
                    'name' => wp_strip_all_tags($faq['title']),
                    'acceptedAnswer' => [
                        '@type' => 'Answer',
                        'text' => wp_strip_all_tags($faq['description'])
                    ]
                ];
            }
        }

        if (empty($schema_data['mainEntity'])) {
            return '';
        }

        $json_ld = wp_json_encode($schema_data, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);

        return '<script type="application/ld+json">' . $json_ld . '</script>';
    }

    /**
     * Generate schema for post-based FAQs
     *
     * @param array $posts Array of WP_Post objects
     * @return string JSON-LD script tag
     */
    public static function generate_post_faq_schema($posts)
    {
        if (empty($posts) || !is_array($posts)) {
            return '';
        }

        $schema_data = [
            '@context' => 'https://schema.org',
            '@type' => 'FAQPage',
            'mainEntity' => []
        ];

        foreach ($posts as $post) {
            if ($post instanceof WP_Post) {
                $title = get_the_title($post->ID);
                $content = apply_filters('the_content', get_post_field('post_content', $post->ID));
                $content = wp_strip_all_tags($content);

                if (!empty($title) && !empty($content)) {
                    $schema_data['mainEntity'][] = [
                        '@type' => 'Question',
                        'name' => $title,
                        'acceptedAnswer' => [
                            '@type' => 'Answer',
                            'text' => $content
                        ]
                    ];
                }
            }
        }

        if (empty($schema_data['mainEntity'])) {
            return '';
        }

        $json_ld = wp_json_encode($schema_data, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);

        return '<script type="application/ld+json">' . $json_ld . '</script>';
    }
}
