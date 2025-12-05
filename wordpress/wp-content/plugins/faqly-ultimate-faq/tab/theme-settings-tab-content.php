<?php
if (!defined('ABSPATH')) {
    exit;
}

// Get the current selected theme
$selected_theme = get_post_meta(get_the_ID(), '_faqly_selected_theme', true) ?: 'faqly-one';
$faqly_is_premium_user = get_option('faqly_pro_is_premium', false);

// Define available themes
$themes = [
    'faqly-one'   => 'Theme One',
    'faqly-two'   => 'Theme Two', 
    'faqly-three' => 'Theme Three',
    'faqly-four'  => 'Theme Four',
    'faqly-five'  => 'Theme Five',
    'faqly-six'   => 'Theme Six',
    'faqly-seven' => 'Theme Seven',
    'faqly-eight' => 'Theme Eight',
    'faqly-nine'  => 'Theme Nine',
    'faqly-ten'   => 'Theme Ten',
    'faqly-eleven'   => 'Theme Eleven',
    'faqly-twelve'   => 'Theme Twelve',
    'faqly-thirteen' => 'Theme Thirteen',
    'faqly-fourteen' => 'Theme Fourteen',
    'faqly-fifteen'  => 'Theme Fifteen',
    'faqly-sixteen'  => 'Theme Sixteen',
    'faqly-seventeen'=> 'Theme Seventeen'
];

$is_selected_theme_valid = !in_array($selected_theme, ['faqly-one', 'faqly-two', 'faqly-three']) ? $faqly_is_premium_user : true;

if (!$is_selected_theme_valid) {
    $selected_theme = 'faqly-one';
}

?>
<div class="theme-settings-content">
    <h3>Select FAQ Theme</h3>
    <p>Choose from our pre-designed themes to style your FAQ accordion.</p>
    
    <div class="row theme-selection-container">
        <?php foreach ($themes as $theme_slug => $theme_name): 
            $is_pro_theme = !in_array($theme_slug, ['faqly-one', 'faqly-two', 'faqly-three']);
            $is_disabled = $is_pro_theme && !$faqly_is_premium_user;
            $is_selected = $selected_theme === $theme_slug;
            $is_selectable = !$is_disabled || $is_selected;
        ?>
            <div class="col-md-4 mb-4">
                <div class="card theme-card <?php echo $is_selected ? 'theme-selected' : ''; ?> <?php echo $is_disabled ? 'theme-disabled' : ''; ?>" 
                     data-theme="<?php echo esc_attr($theme_slug); ?>"
                     style="<?php echo $is_disabled ? 'opacity: 0.7; cursor: not-allowed;' : 'cursor: pointer;'; ?>">
                    <div class="card-body text-center">
                        <div class="theme-preview">
                            <img src="<?php echo esc_url(FAQLY_PLUGIN_URL . 'assets/images/theme-preview/' . $theme_slug . '.png'); ?>" 
                                 alt="<?php echo esc_attr($theme_name); ?>" 
                                 class="img-fluid theme-preview-image">
                        </div>
                        <h5 class="card-title mt-3"><?php echo esc_html($theme_name); ?> <?php echo $is_pro_theme ? faqly_pro_label($faqly_is_premium_user) : ''; ?></h5>
                        <div class="theme-selection-indicator">
                            <?php if ($is_selected): ?>
                                <span class="badge bg-success">Selected</span>
                            <?php elseif ($is_selectable): ?>
                                <span class="badge bg-secondary">Select</span>
                            <?php else: ?>
                                <span class="badge bg-secondary">Select</span>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
    
    <input type="hidden" name="faqly_selected_theme" id="faqly_selected_theme" value="<?php echo esc_attr($selected_theme); ?>">
</div>


