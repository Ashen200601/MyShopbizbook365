<?php
if (!defined('ABSPATH')) {
    exit;
}
?>

<div id="typography-settings-tabs" class="d-flex">
    <ul class="nav flex-column nav-pills me-3" id="typographySettingsTab" role="tablist" aria-orientation="vertical">
        <li class="nav-item" role="presentation">
            <button class="nav-link active" id="section-title-typography-tab" data-bs-toggle="pill"
                data-bs-target="#section-title-typography" type="button" role="tab"
                aria-controls="section-title-typography" aria-selected="true">
                Section Typography
            </button>
        </li>
    </ul>
    <div class="tab-content flex-grow-1" id="typographySettingsTabContent">
        <!-- Section Title Typography -->
        <div class="tab-pane fade show active" id="section-title-typography" role="tabpanel"
            aria-labelledby="section-title-typography-tab">


            <!-- tittle start-->
            <div class="typography-settings-section">
                <h4>Item Title Typography</h4>
                <p class="description">Configure typography settings for accordion item titles.</p>

                <!-- Load Google Font Toggle -->
                <div class="setting-group">
                    <label for="faq_item_title_load_font" class="setting-label">
                        <strong>Load Accordion Item Title Font</strong>
                        <span class="description">Enable/disable Google fonts for the accordion item title</span><?php echo faqly_pro_label( $faqly_is_premium_user ); ?>
                    </label>
                    <?php
                    $faq_item_title_load_font = get_post_meta(get_the_ID(), '_faq_item_title_load_font', true);
                    if ($faq_item_title_load_font === '') {
                        $faq_item_title_load_font = 'off';
                    }
                    ?>
                    <div class="toggle-wrapper">
                        <label class="toggle-switch">
                            <input type="checkbox" name="faq_item_title_load_font" id="faq_item_title_load_font" <?php checked($faq_item_title_load_font, 'on'); ?><?php echo faqly_field_disabled_attr( $faqly_is_premium_user ); ?> >
                            <span class="toggle-slider"></span>
                        </label>
                    </div>
                </div>

                <!-- Item Title Font Properties -->
                <div class="setting-group">
                    <label class="setting-label">
                        <strong>Item Title Font</strong>
                        <span class="description">Set font properties for accordion item titles</span><?php echo faqly_pro_label( $faqly_is_premium_user ); ?>
                    </label>
                    <div class="font-properties-wrapper"
                        style="display: flex; flex-wrap: wrap; gap: 15px; align-items: end;">
                        <!-- Font Family -->
                        <div class="font-property-wrapper">
                            <label for="faq_item_title_font_family" style="font-size: 12px; margin-bottom: 2px;">Font
                                Family</label>
                            <?php
                            $faq_item_title_font_family = get_post_meta(get_the_ID(), '_faq_item_title_font_family', true) ?: 'Arial';
                            $google_fonts = [
                                'Roboto' => 'Roboto',
                                'Source Sans 3' => 'Source Sans 3',
                                'Open Sans' => 'Open Sans',
                                'Lato' => 'Lato',
                                'Montserrat' => 'Montserrat',
                                'Poppins' => 'Poppins',
                                'Nunito' => 'Nunito',
                                'Inter' => 'Inter',
                                'Work Sans' => 'Work Sans',
                                // Unique / Creative Fonts
                                'Unica One' => 'Unica One',
                                'Silkscreen' => 'Silkscreen',
                                'Lobster' => 'Lobster',
                                'Fredericka the Great' => 'Fredericka the Great',
                                'Bungee' => 'Bungee',
                                'Orbitron' => 'Orbitron',
                                'Righteous' => 'Righteous',
                                'Monoton' => 'Monoton',
                                'Zen Dots' => 'Zen Dots',
                                'VT323' => 'VT323'
                            ];
                            ?>
                            <select name="faq_item_title_font_family" id="faq_item_title_font_family" <?php echo faqly_field_disabled_attr( $faqly_is_premium_user ); ?>
                                class="form-control" style="width: 120px;">
                                <?php foreach ($google_fonts as $key => $label): ?>
                                    <option value="<?php echo esc_attr($key); ?>" <?php selected($faq_item_title_font_family, $key); ?>><?php echo esc_html($label); ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <!-- Font Style -->
                        <div class="font-property-wrapper">
                            <label for="faq_item_title_font_style" style="font-size: 12px; margin-bottom: 2px;">Font
                                Style</label>
                            <?php
                            $faq_item_title_font_style = get_post_meta(get_the_ID(), '_faq_item_title_font_style', true) ?: 'normal';
                            ?>
                            <select name="faq_item_title_font_style" id="faq_item_title_font_style" class="form-control" <?php echo faqly_field_disabled_attr( $faqly_is_premium_user ); ?> 
                                style="width: 100px;">
                                <option value="normal" <?php selected($faq_item_title_font_style, 'normal'); ?>>Normal
                                </option>
                                <option value="italic" <?php selected($faq_item_title_font_style, 'italic'); ?>>Italic
                                </option>
                                <option value="oblique" <?php selected($faq_item_title_font_style, 'oblique'); ?>>
                                    Oblique</option>
                            </select>
                        </div>

                        <!-- Font Subset -->
                        <div class="font-property-wrapper">
                            <label for="faq_item_title_font_subset"
                                style="font-size: 12px; margin-bottom: 2px;">Subset</label>
                            <?php
                            $faq_item_title_font_subset = get_post_meta(get_the_ID(), '_faq_item_title_font_subset', true) ?: 'latin';
                            ?>
                            <select name="faq_item_title_font_subset" id="faq_item_title_font_subset" <?php echo faqly_field_disabled_attr( $faqly_is_premium_user ); ?>
                                class="form-control" style="width: 100px;">
                                <option value="latin" <?php selected($faq_item_title_font_subset, 'latin'); ?>>Latin
                                </option>
                                <option value="latin-ext" <?php selected($faq_item_title_font_subset, 'latin-ext'); ?>>
                                    Latin Ext</option>
                                <option value="cyrillic" <?php selected($faq_item_title_font_subset, 'cyrillic'); ?>>
                                    Cyrillic</option>
                                <option value="cyrillic-ext" <?php selected($faq_item_title_font_subset, 'cyrillic-ext'); ?>>Cyrillic Ext</option>
                                <option value="greek" <?php selected($faq_item_title_font_subset, 'greek'); ?>>Greek
                                </option>
                                <option value="greek-ext" <?php selected($faq_item_title_font_subset, 'greek-ext'); ?>>
                                    Greek Ext</option>
                                <option value="vietnamese" <?php selected($faq_item_title_font_subset, 'vietnamese'); ?>>Vietnamese</option>
                            </select>
                        </div>

                        <!-- Text Align -->
                        <div class="font-property-wrapper">
                            <label for="faq_item_title_text_align" style="font-size: 12px; margin-bottom: 2px;">Text
                                Align</label>
                            <?php
                            $faq_item_title_text_align = get_post_meta(get_the_ID(), '_faq_item_title_text_align', true) ?: 'left';
                            ?>
                            <select name="faq_item_title_text_align" id="faq_item_title_text_align" class="form-control" <?php echo faqly_field_disabled_attr( $faqly_is_premium_user ); ?>
                                style="width: 100px;">
                                <option value="left" <?php selected($faq_item_title_text_align, 'left'); ?>>Left
                                </option>
                                <option value="center" <?php selected($faq_item_title_text_align, 'center'); ?>>Center
                                </option>
                                <option value="right" <?php selected($faq_item_title_text_align, 'right'); ?>>Right
                                </option>
                                <option value="justify" <?php selected($faq_item_title_text_align, 'justify'); ?>>
                                    Justify</option>
                            </select>
                        </div>

                        <!-- Text Transform -->
                        <div class="font-property-wrapper">
                            <label for="faq_item_title_text_transform" style="font-size: 12px; margin-bottom: 2px;">Text
                                Transform</label>
                            <?php
                            $faq_item_title_text_transform = get_post_meta(get_the_ID(), '_faq_item_title_text_transform', true) ?: 'none';
                            ?>
                            <select name="faq_item_title_text_transform" id="faq_item_title_text_transform" <?php echo faqly_field_disabled_attr( $faqly_is_premium_user ); ?>
                                class="form-control" style="width: 120px;">
                                <option value="none" <?php selected($faq_item_title_text_transform, 'none'); ?>>None
                                </option>
                                <option value="capitalize" <?php selected($faq_item_title_text_transform, 'capitalize'); ?>>Capitalize</option>
                                <option value="uppercase" <?php selected($faq_item_title_text_transform, 'uppercase'); ?>>Uppercase</option>
                                <option value="lowercase" <?php selected($faq_item_title_text_transform, 'lowercase'); ?>>Lowercase</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>

            <!-- tittle end -->

            <!-- description start -->

            <div class="typography-settings-section">
                <h4>Item Description Typography</h4>
                <p class="description">Configure typography settings for accordion item descriptions.</p>

                <!-- Load Google Font Toggle -->
                <div class="setting-group">
                    <label for="faq_item_desc_load_font" class="setting-label">
                        <strong>Load Accordion Item Description Font</strong>
                        <span class="description">Enable/disable Google fonts for the accordion item description</span><?php echo faqly_pro_label( $faqly_is_premium_user ); ?>
                    </label>
                    <?php
                    $faq_item_desc_load_font = get_post_meta(get_the_ID(), '_faq_item_desc_load_font', true);
                    if ($faq_item_desc_load_font === '') {
                        $faq_item_desc_load_font = 'off';
                    }
                    ?>
                    <div class="toggle-wrapper">
                        <label class="toggle-switch">
                            <input type="checkbox" name="faq_item_desc_load_font" id="faq_item_desc_load_font" <?php checked($faq_item_desc_load_font, 'on'); ?><?php echo faqly_field_disabled_attr( $faqly_is_premium_user ); ?>>
                            <span class="toggle-slider"></span>
                        </label>
                    </div>
                </div>

                <!-- Item Description Font Properties -->
                <div class="setting-group">
                    <label class="setting-label">
                        <strong>Description Font</strong>
                        <span class="description">Set font properties for accordion item descriptions</span><?php echo faqly_pro_label( $faqly_is_premium_user ); ?>
                    </label>
                    <div class="font-properties-wrapper"
                        style="display: flex; flex-wrap: wrap; gap: 15px; align-items: end;">
                        <!-- Font Family -->
                        <div class="font-property-wrapper">
                            <label for="faq_item_desc_font_family" style="font-size: 12px; margin-bottom: 2px;">Font
                                Family</label>
                            <?php
                            $faq_item_desc_font_family = get_post_meta(get_the_ID(), '_faq_item_desc_font_family', true) ?: 'Arial';
                            ?>
                            <select name="faq_item_desc_font_family" id="faq_item_desc_font_family" class="form-control" <?php echo faqly_field_disabled_attr( $faqly_is_premium_user ); ?>
                                style="width: 120px;">
                                <?php foreach ($google_fonts as $key => $label): ?>
                                    <option value="<?php echo esc_attr($key); ?>" <?php selected($faq_item_desc_font_family, $key); ?>><?php echo esc_html($label); ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <!-- Font Style -->
                        <div class="font-property-wrapper">
                            <label for="faq_item_desc_font_style" style="font-size: 12px; margin-bottom: 2px;">Font
                                Style</label>
                            <?php
                            $faq_item_desc_font_style = get_post_meta(get_the_ID(), '_faq_item_desc_font_style', true) ?: 'normal';
                            ?>
                            <select name="faq_item_desc_font_style" id="faq_item_desc_font_style" class="form-control" <?php echo faqly_field_disabled_attr( $faqly_is_premium_user ); ?>
                                style="width: 100px;">
                                <option value="normal" <?php selected($faq_item_desc_font_style, 'normal'); ?>>Normal
                                </option>
                                <option value="italic" <?php selected($faq_item_desc_font_style, 'italic'); ?>>Italic
                                </option>
                                <option value="oblique" <?php selected($faq_item_desc_font_style, 'oblique'); ?>>Oblique
                                </option>
                            </select>
                        </div>

                        <!-- Font Subset -->
                        <div class="font-property-wrapper">
                            <label for="faq_item_desc_font_subset"
                                style="font-size: 12px; margin-bottom: 2px;">Subset</label>
                            <?php
                            $faq_item_desc_font_subset = get_post_meta(get_the_ID(), '_faq_item_desc_font_subset', true) ?: 'latin';
                            ?>
                            <select name="faq_item_desc_font_subset" id="faq_item_desc_font_subset" class="form-control" <?php echo faqly_field_disabled_attr( $faqly_is_premium_user ); ?>
                                style="width: 100px;">
                                <option value="latin" <?php selected($faq_item_desc_font_subset, 'latin'); ?>>Latin
                                </option>
                                <option value="latin-ext" <?php selected($faq_item_desc_font_subset, 'latin-ext'); ?>>
                                    Latin Ext</option>
                                <option value="cyrillic" <?php selected($faq_item_desc_font_subset, 'cyrillic'); ?>>
                                    Cyrillic</option>
                                <option value="cyrillic-ext" <?php selected($faq_item_desc_font_subset, 'cyrillic-ext'); ?>>Cyrillic Ext</option>
                                <option value="greek" <?php selected($faq_item_desc_font_subset, 'greek'); ?>>Greek
                                </option>
                                <option value="greek-ext" <?php selected($faq_item_desc_font_subset, 'greek-ext'); ?>>
                                    Greek Ext</option>
                                <option value="vietnamese" <?php selected($faq_item_desc_font_subset, 'vietnamese'); ?>>
                                    Vietnamese</option>
                            </select>
                        </div>

                        <!-- Text Align -->
                        <div class="font-property-wrapper">
                            <label for="faq_item_desc_text_align" style="font-size: 12px; margin-bottom: 2px;">Text
                                Align</label>
                            <?php
                            $faq_item_desc_text_align = get_post_meta(get_the_ID(), '_faq_item_desc_text_align', true) ?: 'left';
                            ?>
                            <select name="faq_item_desc_text_align" id="faq_item_desc_text_align" class="form-control" <?php echo faqly_field_disabled_attr( $faqly_is_premium_user ); ?>
                                style="width: 100px;">
                                <option value="left" <?php selected($faq_item_desc_text_align, 'left'); ?>>Left</option>
                                <option value="center" <?php selected($faq_item_desc_text_align, 'center'); ?>>Center
                                </option>
                                <option value="right" <?php selected($faq_item_desc_text_align, 'right'); ?>>Right
                                </option>
                                <option value="justify" <?php selected($faq_item_desc_text_align, 'justify'); ?>>Justify
                                </option>
                            </select>
                        </div>

                        <!-- Text Transform -->
                        <div class="font-property-wrapper">
                            <label for="faq_item_desc_text_transform" style="font-size: 12px; margin-bottom: 2px;">Text
                                Transform</label>
                            <?php
                            $faq_item_desc_text_transform = get_post_meta(get_the_ID(), '_faq_item_desc_text_transform', true) ?: 'none';
                            ?>
                            <select name="faq_item_desc_text_transform" id="faq_item_desc_text_transform" <?php echo faqly_field_disabled_attr( $faqly_is_premium_user ); ?>
                                class="form-control" style="width: 120px;">
                                <option value="none" <?php selected($faq_item_desc_text_transform, 'none'); ?>>None
                                </option>
                                <option value="capitalize" <?php selected($faq_item_desc_text_transform, 'capitalize'); ?>>Capitalize</option>
                                <option value="uppercase" <?php selected($faq_item_desc_text_transform, 'uppercase'); ?>>Uppercase</option>
                                <option value="lowercase" <?php selected($faq_item_desc_text_transform, 'lowercase'); ?>>Lowercase</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>

            <!-- description end  -->
        </div>
    </div>
</div>