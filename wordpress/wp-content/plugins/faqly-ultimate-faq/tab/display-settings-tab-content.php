<?php
if (!defined('ABSPATH')) {
    exit;
}
?>

<div id="display-settings-tabs" class="d-flex">
    <ul class="nav flex-column nav-pills me-3" id="displaySettingsTab" role="tablist" aria-orientation="vertical">
        <li class="nav-item" role="presentation">
            <button class="nav-link active" id="title-description-tab" data-bs-toggle="pill" data-bs-target="#title-description" type="button" role="tab" aria-controls="title-description" aria-selected="true">
                Title & Description
            </button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="expand-collapse-icon-tab" data-bs-toggle="pill" data-bs-target="#expand-collapse-icon" type="button" role="tab" aria-controls="expand-collapse-icon" aria-selected="true">
            Expand & Collapse Icon
            </button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="animation-effect-tab" data-bs-toggle="pill" data-bs-target="#animation-effect" type="button" role="tab" aria-controls="animation-effect" aria-selected="false">
                Animation Effect
            </button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="ajax-pagination-tab" data-bs-toggle="pill" data-bs-target="#ajax-pagination" type="button" role="tab" aria-controls="ajax-pagination" aria-selected="false">
                Ajax Pagination
            </button>
        </li>
    </ul>
    <div class="tab-content flex-grow-1" id="displaySettingsTabContent">
        <div class="tab-pane fade show active" id="title-description" role="tabpanel" aria-labelledby="title-description-tab">
            <!-- Title & Description Settings -->
            <div class="display-settings-section">
                <h4>Title & Description Settings</h4>
                <p class="description">Configure how titles and descriptions are displayed in your FAQ accordions.</p>


                <!-- Use Theme Default Style Settings -->
                <div class="setting-group">
                    <label class="setting-label">
                        <strong>Use Theme Default Style Settings:</strong><?php echo faqly_pro_label( $faqly_is_premium_user ); ?><br>
                        
                    </label>
                    <div class="radio-group">
                        <?php
                        $faq_use_theme_default_style = get_post_meta(get_the_ID(), '_faq_use_theme_default_style', true) ?: 'enable';
                        ?>
                        <label class="radio-option">
                            <input type="radio" name="faq_use_theme_default_style" value="enable" <?php checked($faq_use_theme_default_style, 'enable'); ?><?php echo faqly_field_disabled_attr( $faqly_is_premium_user ); ?> />
                            Enable
                        </label>
                        <label class="radio-option">
                            <input type="radio" name="faq_use_theme_default_style" value="disable" <?php checked($faq_use_theme_default_style, 'disable'); ?><?php echo faqly_field_disabled_attr( $faqly_is_premium_user ); ?> />
                            Disable
                        </label>
                    </div>
                </div>

                <!-- Title HTML Tag -->
                <div class="setting-group">
                    <label for="faq_title_html_tag" class="setting-label">
                        <strong>Title HTML Tag</strong>
                        <span class="description">Select HTML tag for accordion title</span><?php echo faqly_pro_label( $faqly_is_premium_user ); ?>
                    </label>
                    <?php
                    $faq_title_html_tag = get_post_meta(get_the_ID(), '_faq_title_html_tag', true) ?: 'h2';
                    ?>
                    <select name="faq_title_html_tag" id="faq_title_html_tag" class="form-control" <?php echo faqly_field_disabled_attr( $faqly_is_premium_user ); ?>>
                        <option value="h1" <?php selected($faq_title_html_tag, 'h1'); ?>>H1</option>
                        <option value="h2" <?php selected($faq_title_html_tag, 'h2'); ?>>H2</option>
                        <option value="h3" <?php selected($faq_title_html_tag, 'h3'); ?>>H3</option>
                        <option value="h4" <?php selected($faq_title_html_tag, 'h4'); ?>>H4</option>
                        <option value="h5" <?php selected($faq_title_html_tag, 'h5'); ?>>H5</option>
                        <option value="h6" <?php selected($faq_title_html_tag, 'h6'); ?>>H6</option>
                        <option value="div" <?php selected($faq_title_html_tag, 'div'); ?>>DIV</option>
                        <option value="span" <?php selected($faq_title_html_tag, 'span'); ?>>SPAN</option>
                    </select>
                </div>

                <!-- Title Color -->
                <div class="setting-group">
                    <label for="faq_title_color" class="setting-label">
                        <strong>Title Color</strong>
                        <span class="description">Set accordion title text color</span><?php echo faqly_pro_label( $faqly_is_premium_user ); ?>
                    </label>
                    <?php
                    $faq_title_color = get_post_meta(get_the_ID(), '_faq_title_color', true) ?: '#333333';
                    ?>
                    <div class="color-picker-wrapper">
                        <input type="color" name="faq_title_color" id="faq_title_color" class="color-picker"
                               value="<?php echo esc_attr($faq_title_color); ?>" data-default-color="#333333" <?php echo faqly_field_disabled_attr( $faqly_is_premium_user ); ?>>
                        <input type="text" class="color-value" value="<?php echo esc_attr($faq_title_color); ?>" readonly <?php echo faqly_field_disabled_attr( $faqly_is_premium_user ); ?>>
                    </div>
                </div>

                <!-- Title Background Color -->
                <div class="setting-group">
                    <label for="faq_title_bg_color" class="setting-label">
                        <strong>Title Background Color</strong>
                        <span class="description">Set accordion title background color</span><?php echo faqly_pro_label( $faqly_is_premium_user ); ?>
                    </label>
                    <?php
                    $faq_title_bg_color = get_post_meta(get_the_ID(), '_faq_title_bg_color', true) ?: '#ffffff';
                    ?>
                    <div class="color-picker-wrapper">
                        <input type="color" name="faq_title_bg_color" id="faq_title_bg_color" class="color-picker"
                               value="<?php echo esc_attr($faq_title_bg_color); ?>" data-default-color="#ffffff" <?php echo faqly_field_disabled_attr( $faqly_is_premium_user ); ?>>
                        <input type="text" class="color-value" value="<?php echo esc_attr($faq_title_bg_color); ?>" readonly <?php echo faqly_field_disabled_attr( $faqly_is_premium_user ); ?>>
                    </div>
                </div>

                <!-- Description Color -->
                <div class="setting-group">
                    <label for="faq_desc_color" class="setting-label">
                        <strong>Description Color</strong>
                        <span class="description">Set accordion description text color</span><?php echo faqly_pro_label( $faqly_is_premium_user ); ?>
                    </label>
                    <?php
                    $faq_desc_color = get_post_meta(get_the_ID(), '_faq_desc_color', true) ?: '#666666';
                    ?>
                    <div class="color-picker-wrapper">
                        <input type="color" name="faq_desc_color" id="faq_desc_color" class="color-picker"
                               value="<?php echo esc_attr($faq_desc_color); ?>" data-default-color="#666666" <?php echo faqly_field_disabled_attr( $faqly_is_premium_user ); ?>>
                        <input type="text" class="color-value" value="<?php echo esc_attr($faq_desc_color); ?>" readonly <?php echo faqly_field_disabled_attr( $faqly_is_premium_user ); ?>>
                    </div>
                </div>

                <!-- Description Background Color -->
                <div class="setting-group">
                    <label for="faq_desc_bg_color" class="setting-label">
                        <strong>Description Background Color</strong>
                        <span class="description">Set accordion description background color</span><?php echo faqly_pro_label( $faqly_is_premium_user ); ?>
                    </label>
                    <?php
                    $faq_desc_bg_color = get_post_meta(get_the_ID(), '_faq_desc_bg_color', true) ?: '#f8f9fa';
                    ?>
                    <div class="color-picker-wrapper">
                        <input type="color" name="faq_desc_bg_color" id="faq_desc_bg_color" class="color-picker"
                               value="<?php echo esc_attr($faq_desc_bg_color); ?>" data-default-color="#f8f9fa" <?php echo faqly_field_disabled_attr( $faqly_is_premium_user ); ?>>
                        <input type="text" class="color-value" value="<?php echo esc_attr($faq_desc_bg_color); ?>" readonly <?php echo faqly_field_disabled_attr( $faqly_is_premium_user ); ?>>
                    </div>
                </div>

                <?php
                $faq_title_font_size = get_post_meta(get_the_ID(), '_faq_title_font_size', true) ?: '16';
                $faq_desc_font_size = get_post_meta(get_the_ID(), '_faq_desc_font_size', true) ?: '14';
                ?>

                <!-- font sizes -->

                <div class="setting-group">
                        <p class="setting-label"><strong>FAQ Title Font Size (px):</strong></p>
                        <input type="number" name="faq_title_font_size" value="<?php echo esc_attr($faq_title_font_size); ?>" min="10" max="50"  />
                    </div>

                    <hr class="setting-divider" />

                    <div class="setting-group">
                        <p class="setting-label"><strong>FAQ Description Font Size (px):</strong></p>
                        <input type="number" name="faq_desc_font_size" value="<?php echo esc_attr($faq_desc_font_size); ?>" min="10" max="50" />
                    </div>

                    <hr class="setting-divider" />

                    <div class="setting-group">
                        <p class="setting-label"><strong>FAQ Border Radius (px):</strong></p>
                        <input type="number" name="faq_border_radius" value="<?php echo esc_attr(get_post_meta(get_the_ID(), '_faq_border_radius', true) ?: '0'); ?>" min="0" max="80" />
                </div>

                <!-- end -->

                <!-- Item Border -->
                <div class="setting-group">
                    <label class="setting-label">
                        <strong>Item Border</strong>
                        <span class="description">Set border for accordion items</span><?php echo faqly_pro_label( $faqly_is_premium_user ); ?>
                    </label>
                    <div class="border-settings-wrapper" style="display: flex; gap: 10px; align-items: center;">
                        <!-- Border Width -->
                        <div class="border-width-wrapper">
                            <label for="faq_item_border_width" style="font-size: 12px; margin-bottom: 2px;">Width (px)</label>
                            <?php
                            $faq_item_border_width = get_post_meta(get_the_ID(), '_faq_item_border_width', true) ?: '0';
                            ?>
                            <input type="number" name="faq_item_border_width" id="faq_item_border_width" class="form-control"
                                   value="<?php echo esc_attr($faq_item_border_width); ?>" placeholder="1" min="0" max="20" style="width: 60px;" <?php echo faqly_field_disabled_attr( $faqly_is_premium_user ); ?>>
                        </div>

                        <!-- Border Style -->
                        <div class="border-style-wrapper">
                            <label for="faq_item_border_style" style="font-size: 12px; margin-bottom: 2px;">Style</label>
                            <?php
                            $faq_item_border_style = get_post_meta(get_the_ID(), '_faq_item_border_style', true) ?: 'solid';
                            ?>
                            <select name="faq_item_border_style" id="faq_item_border_style" class="form-control" style="width: 80px;" <?php echo faqly_field_disabled_attr( $faqly_is_premium_user ); ?>>
                                <option value="solid" <?php selected($faq_item_border_style, 'solid'); ?>>Solid</option>
                                <option value="dashed" <?php selected($faq_item_border_style, 'dashed'); ?>>Dashed</option>
                                <option value="dotted" <?php selected($faq_item_border_style, 'dotted'); ?>>Dotted</option>
                                <option value="double" <?php selected($faq_item_border_style, 'double'); ?>>Double</option>
                                <option value="groove" <?php selected($faq_item_border_style, 'groove'); ?>>Groove</option>
                                <option value="ridge" <?php selected($faq_item_border_style, 'ridge'); ?>>Ridge</option>
                                <option value="inset" <?php selected($faq_item_border_style, 'inset'); ?>>Inset</option>
                                <option value="outset" <?php selected($faq_item_border_style, 'outset'); ?>>Outset</option>
                            </select>
                        </div>

                        <!-- Border Color -->
                        <div class="border-color-wrapper">
                            <label for="faq_item_border_color" style="font-size: 12px; margin-bottom: 2px;">Color</label>
                            <?php
                            $faq_item_border_color = get_post_meta(get_the_ID(), '_faq_item_border_color', true) ?: '#dd3333';
                            ?>
                            <div class="color-picker-wrapper" style="margin-top: 0;">
                                <input type="color" name="faq_item_border_color" id="faq_item_border_color" class="color-picker"
                                       value="<?php echo esc_attr($faq_item_border_color); ?>" data-default-color="#dd3333" <?php echo faqly_field_disabled_attr( $faqly_is_premium_user ); ?>>
                                <input type="text" class="color-value" value="<?php echo esc_attr($faq_item_border_color); ?>" readonly style="width: 70px;" <?php echo faqly_field_disabled_attr( $faqly_is_premium_user ); ?>>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Title Padding -->
                <div class="setting-group">
                    <label class="setting-label">
                        <strong>Title Padding</strong>
                        <span class="description">Set accordion title custom padding</span><?php echo faqly_pro_label( $faqly_is_premium_user ); ?>
                    </label>
                    <div class="padding-settings-wrapper" style="display: flex; gap: 10px; align-items: center;">
                        <!-- Top Padding -->
                        <div class="padding-wrapper">
                            <label for="faq_title_padding_top" style="font-size: 12px; margin-bottom: 2px;"><i class="fa fa-long-arrow-up"></i> Top (px)</label>
                            <?php
                            $faq_title_padding_top = get_post_meta(get_the_ID(), '_faq_title_padding_top', true) ?: '10';
                            ?>
                            <input type="number" name="faq_title_padding_top" id="faq_title_padding_top" class="form-control"
                                   value="<?php echo esc_attr($faq_title_padding_top); ?>" placeholder="10" min="0" max="100" style="width: 60px;" <?php echo faqly_field_disabled_attr( $faqly_is_premium_user ); ?>>
                        </div>

                        <!-- Right Padding -->
                        <div class="padding-wrapper">
                            <label for="faq_title_padding_right" style="font-size: 12px; margin-bottom: 2px;"><i class="fa fa-long-arrow-right"></i> Right (px)</label>
                            <?php
                            $faq_title_padding_right = get_post_meta(get_the_ID(), '_faq_title_padding_right', true) ?: '10';
                            ?>
                            <input type="number" name="faq_title_padding_right" id="faq_title_padding_right" class="form-control"
                                   value="<?php echo esc_attr($faq_title_padding_right); ?>" placeholder="10" min="0" max="100" style="width: 60px;" <?php echo faqly_field_disabled_attr( $faqly_is_premium_user ); ?>>
                        </div>

                        <!-- Bottom Padding -->
                        <div class="padding-wrapper">
                            <label for="faq_title_padding_bottom" style="font-size: 12px; margin-bottom: 2px;"><i class="fa fa-long-arrow-down"></i> Bottom (px)</label>
                            <?php
                            $faq_title_padding_bottom = get_post_meta(get_the_ID(), '_faq_title_padding_bottom', true) ?: '10';
                            ?>
                            <input type="number" name="faq_title_padding_bottom" id="faq_title_padding_bottom" class="form-control"
                                   value="<?php echo esc_attr($faq_title_padding_bottom); ?>" placeholder="10" min="0" max="100" style="width: 60px;" <?php echo faqly_field_disabled_attr( $faqly_is_premium_user ); ?>>
                        </div>

                        <!-- Left Padding -->
                        <div class="padding-wrapper">
                            <label for="faq_title_padding_left" style="font-size: 12px; margin-bottom: 2px;"><i class="fa fa-long-arrow-left"></i> Left (px)</label>
                            <?php
                            $faq_title_padding_left = get_post_meta(get_the_ID(), '_faq_title_padding_left', true) ?: '10';
                            ?>
                            <input type="number" name="faq_title_padding_left" id="faq_title_padding_left" class="form-control"
                                   value="<?php echo esc_attr($faq_title_padding_left); ?>" placeholder="10" min="0" max="100" style="width: 60px;" <?php echo faqly_field_disabled_attr( $faqly_is_premium_user ); ?>>
                        </div>
                    </div>
                </div>

                <!-- Description Padding -->
                <div class="setting-group">
                    <label class="setting-label">
                        <strong>Description Padding</strong>
                        <span class="description">Set accordion description custom padding</span><?php echo faqly_pro_label( $faqly_is_premium_user ); ?>
                    </label>
                    <div class="padding-settings-wrapper" style="display: flex; gap: 10px; align-items: center;">
                        <!-- Top Padding -->
                        <div class="padding-wrapper">
                            <label for="faq_desc_padding_top" style="font-size: 12px; margin-bottom: 2px;"><i class="fa fa-long-arrow-up"></i> Top (px)</label>
                            <?php
                            $faq_desc_padding_top = get_post_meta(get_the_ID(), '_faq_desc_padding_top', true) ?: '10';
                            ?>
                            <input type="number" name="faq_desc_padding_top" id="faq_desc_padding_top" class="form-control"
                                   value="<?php echo esc_attr($faq_desc_padding_top); ?>" placeholder="10" min="0" max="100" style="width: 60px;" <?php echo faqly_field_disabled_attr( $faqly_is_premium_user ); ?>>
                        </div>

                        <!-- Right Padding -->
                        <div class="padding-wrapper">
                            <label for="faq_desc_padding_right" style="font-size: 12px; margin-bottom: 2px;"><i class="fa fa-long-arrow-right"></i> Right (px)</label>
                            <?php
                            $faq_desc_padding_right = get_post_meta(get_the_ID(), '_faq_desc_padding_right', true) ?: '10';
                            ?>
                            <input type="number" name="faq_desc_padding_right" id="faq_desc_padding_right" class="form-control"
                                   value="<?php echo esc_attr($faq_desc_padding_right); ?>" placeholder="10" min="0" max="100" style="width: 60px;" <?php echo faqly_field_disabled_attr( $faqly_is_premium_user ); ?>>
                        </div>

                        <!-- Bottom Padding -->
                        <div class="padding-wrapper">
                            <label for="faq_desc_padding_bottom" style="font-size: 12px; margin-bottom: 2px;"><i class="fa fa-long-arrow-down"></i> Bottom (px)</label>
                            <?php
                            $faq_desc_padding_bottom = get_post_meta(get_the_ID(), '_faq_desc_padding_bottom', true) ?: '10';
                            ?>
                            <input type="number" name="faq_desc_padding_bottom" id="faq_desc_padding_bottom" class="form-control"
                                   value="<?php echo esc_attr($faq_desc_padding_bottom); ?>" placeholder="10" min="0" max="100" style="width: 60px;" <?php echo faqly_field_disabled_attr( $faqly_is_premium_user ); ?>>
                        </div>

                        <!-- Left Padding -->
                        <div class="padding-wrapper">
                            <label for="faq_desc_padding_left" style="font-size: 12px; margin-bottom: 2px;"><i class="fa fa-long-arrow-left"></i> Left (px)</label>
                            <?php
                            $faq_desc_padding_left = get_post_meta(get_the_ID(), '_faq_desc_padding_left', true) ?: '10';
                            ?>
                            <input type="number" name="faq_desc_padding_left" id="faq_desc_padding_left" class="form-control"
                                   value="<?php echo esc_attr($faq_desc_padding_left); ?>" placeholder="10" min="0" max="100" style="width: 60px;" <?php echo faqly_field_disabled_attr( $faqly_is_premium_user ); ?>>
                        </div>

                        
                    </div>
                </div>
            </div>
        </div>
        <div class="tab-pane fade" id="expand-collapse-icon" role="tabpanel" aria-labelledby="expand-collapse-icon-tab">
            <!-- Animation Effect content will be displayed here -->
            <div class="display-settings-section">
                <h4>Expand & Collapse Icon Settings</h4>

                <!-- Icon Style -->
                    <div class="setting-group">
                        <p class="setting-label"><strong>Icon Style:</strong><?php echo faqly_pro_label( $faqly_is_premium_user ); ?></p>
                        <div class="radio-group">
                            <label class="radio-option">
                                <input type="radio" name="icon_style" value="theme-default" <?php checked($icon_style, 'theme-default'); ?> />
                                Theme Default
                            </label>
                            <label class="radio-option">
                                <input type="radio" name="icon_style" value="plus-minus" <?php checked($icon_style, 'plus-minus'); ?> <?php echo faqly_field_disabled_attr( $faqly_is_premium_user ); ?>/>
                                Plus / Minus
                            </label>
                            <label class="radio-option">
                                <input type="radio" name="icon_style" value="check-times" <?php checked($icon_style, 'check-times'); ?><?php echo faqly_field_disabled_attr( $faqly_is_premium_user ); ?> />
                                Check / Times
                            </label>
                            <label class="radio-option">
                                <input type="radio" name="icon_style" value="arrow" <?php checked($icon_style, 'arrow'); ?><?php echo faqly_field_disabled_attr( $faqly_is_premium_user ); ?> />
                                Arrow
                            </label>
                            <label class="radio-option">
                                <input type="radio" name="icon_style" value="chevron" <?php checked($icon_style, 'chevron'); ?><?php echo faqly_field_disabled_attr( $faqly_is_premium_user ); ?> />
                                Chevron
                            </label>
                            <label class="radio-option">
                                <input type="radio" name="icon_style" value="angle" <?php checked($icon_style, 'angle'); ?><?php echo faqly_field_disabled_attr( $faqly_is_premium_user ); ?> />
                                Angle
                            </label>
                            <label class="radio-option">
                                <input type="radio" name="icon_style" value="caret" <?php checked($icon_style, 'caret'); ?><?php echo faqly_field_disabled_attr( $faqly_is_premium_user ); ?> />
                                Caret
                            </label>
                            <label class="radio-option">
                                <input type="radio" name="icon_style" value="double-angle" <?php checked($icon_style, 'double-angle'); ?><?php echo faqly_field_disabled_attr( $faqly_is_premium_user ); ?> />
                                Double Angle
                            </label>
                            <label class="radio-option">
                                <input type="radio" name="icon_style" value="circle" <?php checked($icon_style, 'circle'); ?><?php echo faqly_field_disabled_attr( $faqly_is_premium_user ); ?> />
                                Circle
                            </label>
                            <label class="radio-option">
                                <input type="radio" name="icon_style" value="square" <?php checked($icon_style, 'square'); ?><?php echo faqly_field_disabled_attr( $faqly_is_premium_user ); ?> />
                                Square
                            </label>
                            <label class="radio-option">
                                <input type="radio" name="icon_style" value="question-answer" <?php checked($icon_style, 'question-answer'); ?><?php echo faqly_field_disabled_attr( $faqly_is_premium_user ); ?> />
                                Q/A
                            </label>
                        </div>
                    </div>

                    <div class="setting-group">
                        <p class="setting-label"><strong>Icon Position:</strong><?php echo faqly_pro_label( $faqly_is_premium_user ); ?></p>
                        <div class="radio-group">
                            <label class="radio-option">
                                <input type="radio" name="icon_position" value="left" <?php checked($icon_position, 'left'); ?><?php echo faqly_field_disabled_attr( $faqly_is_premium_user ); ?> /> Left
                            </label>
                            <label class="radio-option">
                                <input type="radio" name="icon_position" value="right" <?php checked($icon_position, 'right'); ?><?php echo faqly_field_disabled_attr( $faqly_is_premium_user ); ?> />
                                Right
                            </label>
                        </div>
                    </div>

               
            </div>
        </div>
        <div class="tab-pane fade" id="animation-effect" role="tabpanel" aria-labelledby="animation-effect-tab">
            <!-- Animation Effect content will be displayed here -->
            <div class="display-settings-section">
                <h4>Animation Settings</h4>
                <p class="description">Configure accordion animation settings.</p>

                <!-- Animation Enable/Disable -->
                <div class="setting-group">
                    <label for="faq_animation_enable" class="setting-label">
                        <strong>Enable Animation</strong>
                        <span class="description">Enable or disable accordion animation.</span><?php echo faqly_pro_label( $faqly_is_premium_user ); ?>
                    </label>
                    <?php
                    $faq_animation_enable = get_post_meta(get_the_ID(), '_faq_animation_enable', true) ?: 'yes';
                    ?>
                    <select name="faq_animation_enable" id="faq_animation_enable" class="form-control" <?php echo faqly_field_disabled_attr( $faqly_is_premium_user ); ?>>
                        <option value="yes" <?php selected($faq_animation_enable, 'yes'); ?>>Enable</option>
                        <option value="no" <?php selected($faq_animation_enable, 'no'); ?>>Disable</option>
                    </select>
                </div>

                <!-- Animation Style -->
                <div class="setting-group">
                    <label for="faq_animation_style" class="setting-label">
                        <strong>Animation Style</strong>
                        <span class="description">Select an animation style for the description content when accordion expands.</span><?php echo faqly_pro_label( $faqly_is_premium_user ); ?>
                    </label>
                    <?php
                    $faq_animation_style = get_post_meta(get_the_ID(), '_faq_animation_style', true) ?: 'normal';
                    $animation_styles = [
                        'normal' => 'Normal (No Animation)',
                        'fadeIn' => 'Fade In',
                        'fadeInLeft' => 'Fade In Left',
                        'fadeInUp' => 'Fade In Up',
                        'fadeInDownBig' => 'Fade In Down Big',
                        'shake' => 'Shake',
                        'swing' => 'Swing',
                        'rollIn' => 'Roll In',
                        'bounce' => 'Bounce',
                        'wobble' => 'Wobble',
                        'slideInDown' => 'Slide In Down',
                        'slideInLeft' => 'Slide In Left',
                        'slideInUp' => 'Slide In Up',
                        'zoomIn' => 'Zoom In',
                        'zoomInDown' => 'Zoom In Down',
                        'zoomInUp' => 'Zoom In Up',
                        'zoomInLeft' => 'Zoom In Left',
                        'bounceIn' => 'Bounce In',
                        'bounceInDown' => 'Bounce In Down',
                        'bounceInUp' => 'Bounce In Up',
                        'jello' => 'Jello'
                    ];
                    ?>
                    <select name="faq_animation_style" id="faq_animation_style" class="form-control">
                    <?php foreach ($animation_styles as $key => $label) : ?>
                            <option value="<?php echo esc_attr($key); ?>" <?php echo faqly_field_disabled_attr( $faqly_is_premium_user ); ?> <?php selected($faq_animation_style, $key); ?>><?php echo esc_html($label); ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <!-- Transition Time -->
                <div class="setting-group">
                    <label for="faq_transition_time" class="setting-label">
                        <strong>Transition Time (ms)</strong>
                        <span class="description">Set accordion expand and collapse transition time in milliseconds.</span><?php echo faqly_pro_label( $faqly_is_premium_user ); ?>
                    </label>
                    <?php
                    $faq_transition_time = get_post_meta(get_the_ID(), '_faq_transition_time', true) ?: '300';
                    ?>
                    <input type="number" name="faq_transition_time" id="faq_transition_time" class="form-control" min="0" <?php echo faqly_field_disabled_attr( $faqly_is_premium_user ); ?> value="<?php echo esc_attr($faq_transition_time); ?>">
                </div>
            </div>
        </div>
        <div class="tab-pane fade" id="ajax-pagination" role="tabpanel" aria-labelledby="ajax-pagination-tab">
            <!-- Ajax Pagination content will be displayed here -->
            <div class="display-settings-section">
                <h4>Ajax Pagination Settings</h4>
                <p class="description">Configure ajax pagination for accordion items.</p>

                <!-- Ajax Pagination Enable/Disable -->
                <div class="setting-group">
                    <label for="faq_ajax_pagination_enable" class="setting-label">
                        <strong>Ajax Pagination</strong>
                        <span class="description">Enable or disable accordion item pagination.</span><?php echo faqly_pro_label( $faqly_is_premium_user ); ?>
                    </label>
                    <div class="radio-group">
                        <?php
                        $faq_ajax_pagination_enable = get_post_meta(get_the_ID(), '_faq_ajax_pagination_enable', true) ?: 'disable';
                        ?>
                        <label class="radio-option">
                            <input type="radio" name="faq_ajax_pagination_enable" value="enable" <?php checked($faq_ajax_pagination_enable, 'enable'); ?><?php echo faqly_field_disabled_attr( $faqly_is_premium_user ); ?> />
                            Enable
                        </label>
                        <label class="radio-option">
                            <input type="radio" name="faq_ajax_pagination_enable" value="disable" <?php checked($faq_ajax_pagination_enable, 'disable'); ?><?php echo faqly_field_disabled_attr( $faqly_is_premium_user ); ?> />
                            Disable
                        </label>
                    </div>
                </div>

                <!-- Items Per Page -->
                <div class="setting-group">
                    <label for="faq_items_per_page" class="setting-label">
                        <strong>Accordion Items Per Page</strong>
                        <span class="description">Set number of accordion items to show per page/click.</span><?php echo faqly_pro_label( $faqly_is_premium_user ); ?>
                    </label>
                    <?php
                    $faq_items_per_page = get_post_meta(get_the_ID(), '_faq_items_per_page', true) ?: '10';
                    ?>
                    <input type="number" name="faq_items_per_page" id="faq_items_per_page" class="form-control" min="1" max="100" <?php echo faqly_field_disabled_attr( $faqly_is_premium_user ); ?> value="<?php echo esc_attr($faq_items_per_page); ?>">
                </div>
            </div>
        </div>
    </div>
</div>
