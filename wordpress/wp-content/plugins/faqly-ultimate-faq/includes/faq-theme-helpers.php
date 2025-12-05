<?php
if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

class FAQLY_Theme_Helpers
{

    /**
     * Get theme-specific classes
     *
     * @param string $theme_slug The theme slug
     * @return string CSS classes
     */
    public static function get_theme_classes($theme_slug)
    {
        $classes = '';

        switch ($theme_slug) {
            case 'faqly-one':
                $classes = 'theme-one';
                break;
            case 'faqly-two':
                $classes = 'theme-two';
                break;
            case 'faqly-three':
                $classes = 'theme-three';
                break;
            case 'faqly-four':
                $classes = 'theme-four';
                break;
            case 'faqly-five':
                $classes = 'theme-five';
                break;
            case 'faqly-six':
                $classes = 'theme-six';
                break;
            case 'faqly-seven':
                $classes = 'theme-seven';
                break;
            case 'faqly-eight':
                $classes = 'theme-eight';
                break;
            case 'faqly-nine':
                $classes = 'theme-nine';
                break;
            case 'faqly-ten':
                $classes = 'theme-ten';
                break;
            case 'faqly-eleven':
                $classes = 'theme-eleven';
                break;
            case 'faqly-twelve':
                $classes = 'theme-twelve';
                break;
            case 'faqly-thirteen':
                $classes = 'theme-thirteen';
                break;
            case 'faqly-fourteen':
                $classes = 'theme-fourteen';
                break;
            case 'faqly-fifteen':
                $classes = 'theme-fifteen';
                break;
            case 'faqly-sixteen':
                $classes = 'theme-sixteen';
                break;
            case 'faqly-seventeen':
                $classes = 'theme-seventeen';
                break;
            case 'faqly-eighteen':
                $classes = 'theme-eighteen';
                break;
            case 'faqly-nineteen':
                $classes = 'theme-nineteen';
                break;
            case 'faqly-twenty':
                $classes = 'theme-twenty';
                break;
            default:
                $classes = 'theme-one';
                break;
        }

        return $classes;
    }


    /**
     * Generate icon HTML based on the selected icon style
     *
     * @param string $icon_style The icon style to generate
     * @return string HTML markup for the icons
     */
    public static function generate_icon_html($icon_style)
    {
        $icon_config = [
            'theme-default' => [
                'open' => 'fas fa-plus',
                'close' => 'fas fa-minus'
            ],
            'plus-minus' => [
                'open' => 'fas fa-plus',
                'close' => 'fas fa-minus'
            ],
            'check-times' => [
                'open' => 'fas fa-check',
                'close' => 'fas fa-times'
            ],
            'arrow' => [
                'open' => 'fas fa-arrow-down',
                'close' => 'fas fa-arrow-up'
            ],
            'chevron' => [
                'open' => 'fas fa-chevron-down',
                'close' => 'fas fa-chevron-up'
            ],
            'angle' => [
                'open' => 'fas fa-angle-down',
                'close' => 'fas fa-angle-up'
            ],
            'caret' => [
                'open' => 'fas fa-caret-down',
                'close' => 'fas fa-caret-up'
            ],
            'double-angle' => [
                'open' => 'fas fa-angle-double-down',
                'close' => 'fas fa-angle-double-up'
            ],
            'circle' => [
                'open' => 'fas fa-arrow-circle-down',
                'close' => 'fas fa-arrow-circle-up'
            ],
            'square' => [
                'open' => 'fas fa-arrow-alt-circle-down',
                'close' => 'fas fa-arrow-alt-circle-up'
            ],
            'question-answer' => [
                'open' => 'fas fa-solid fa-q',
                'close' => 'fas fa-solid fa-a'
            ],
        ];

        // Get the icon configuration or default to plus-minus
        $icons = $icon_config[$icon_style] ?? $icon_config['plus-minus'];

        return sprintf(
            '<span class="faqly-icon"><i class="%s open-icon"></i><i class="%s close-icon"></i></span>',
            esc_attr($icons['open']),
            esc_attr($icons['close'])
        );
    }

    /**
     * Generate theme-specific default icon HTML
     *
     * @param string $theme_slug The theme slug to generate icons for
     * @return string HTML markup for the theme-specific icons
     */
    public static function generate_theme_default_icon_html($theme_slug)
    {
        $theme_icon_config = [
            'faqly-one' => [
                'open' => 'fas fa-plus',
                'close' => 'fas fa-minus'
            ],
            'faqly-two' => [
                'open' => 'fas fa-arrow-down',
                'close' => 'fas fa-arrow-up'
            ],
            'faqly-three' => [
                'open' => 'fas fa-angle-down',
                'close' => 'fas fa-angle-up'
            ],
            'faqly-four' => [
                'open' => 'fas fa-chevron-down',
                'close' => 'fas fa-chevron-up'
            ],
            'faqly-five' => [
                'open' => 'fas fa-plus',
                'close' => 'fas fa-minus'
            ]
        ];

        // Get the theme icon configuration or default to theme one
        $icons = $theme_icon_config[$theme_slug] ?? $theme_icon_config['faqly-one'];

        return sprintf(
            '<span class="faqly-icon"><i class="%s open-icon"></i><i class="%s close-icon"></i></span>',
            esc_attr($icons['open']),
            esc_attr($icons['close'])
        );
    }

    /**
     * Get theme-specific default icon position
     *
     * @param string $theme_slug The theme slug to get icon position for
     * @return string Icon position ('left' or 'right')
     */
    public static function get_theme_default_icon_position($theme_slug)
    {
        $theme_icon_position_config = [
            'faqly-one' => 'left',
            'faqly-two' => 'left',
            'faqly-three' => 'left',
            'faqly-four' => 'right',
            'faqly-five' => 'right'
        ];

        // Get the theme icon position or default to 'left'
        return $theme_icon_position_config[$theme_slug] ?? 'left';
    }
}
