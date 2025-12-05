/**
 * FAQly WooCommerce Settings JavaScript
 */

jQuery(document).ready(function($) {
    'use strict';

    let tabCount = faqly_wc_vars.tab_count || 0;

    $('#add-new-faq-tab').on('click', function() {
        tabCount++;
        const tabHtml = `
            <div class="faq-tab-item card mt-3" data-tab-id="${tabCount}">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4">
                            <label>${faqly_wc_vars.i18n.display_faqs_on}</label>
                            <select class="form-control display-faqs-on" name="faq_tabs[${tabCount}][display_on]" data-tab-id="${tabCount}">
                                <option value="all">${faqly_wc_vars.i18n.all_products}</option>
                                <option value="specific">${faqly_wc_vars.i18n.specific_products}</option>
                            </select>
                        </div>
                        <div class="col-md-4 specific-products-container" id="specific-products-${tabCount}" style="display: none;">
                            <label>${faqly_wc_vars.i18n.specific_products_label}</label>
                            <select class="form-control" name="faq_tabs[${tabCount}][product_ids][]" multiple>
                            </select>
                            <small class="form-text text-muted">${faqly_wc_vars.i18n.hold_ctrl_cmd}</small>
                        </div>
                        <div class="col-md-3">
                            <label>${faqly_wc_vars.i18n.select_faq_group}</label>
                            <select class="form-control" name="faq_tabs[${tabCount}][group_id]">
                                <option value="">${faqly_wc_vars.i18n.select_faq_group}</option>
                                ${faqly_wc_vars.faq_groups_options}
                            </select>
                        </div>
                        <div class="col-md-1">
                            <label>&nbsp;</label>
                            <button type="button" class="btn btn-danger btn-sm remove-tab" data-tab-id="${tabCount}">
                                <span class="dashicons dashicons-trash"></span>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        `;
        $('#faq-tabs-container').append(tabHtml);

        // Fetch products via AJAX for the new tab's product select
        $.ajax({
            url: faqly_wc_vars.ajax_url,
            method: 'POST',
            data: {
                action: 'faqly_get_products',
                nonce: faqly_wc_vars.nonce
            },
            success: function(response) {
                if (response.success && response.data) {
                    let options = '';
                    response.data.forEach(function(product) {
                        options += '<option value="' + product.id + '">' + product.name + '</option>';
                    });
                    $('#specific-products-' + tabCount + ' select').html(options);
                }
            },
            error: function() {
                console.error('Failed to load products for new tab');
            }
        });
    });

    $(document).on('change', '.display-faqs-on', function() {
        const tabId = $(this).data('tab-id');
        const selectedValue = $(this).val();
        const specificProductsContainer = $('#specific-products-' + tabId);

        if (selectedValue === 'specific') {
            specificProductsContainer.show();
        } else {
            specificProductsContainer.hide();
        }
    });

    $(document).on('click', '.remove-tab', function() {
        $(this).closest('.faq-tab-item').remove();
    });

    // Load products for existing saved tabs
    $('.specific-products-container select').each(function() {
        const $select = $(this);

        $.ajax({
            url: faqly_wc_vars.ajax_url,
            method: 'POST',
            data: {
                action: 'faqly_get_products',
                nonce: faqly_wc_vars.nonce
            },
            success: function(response) {
                if (response.success && response.data) {
                    let options = '';
                    response.data.forEach(function(product) {
                        const selected = $select.find('option[value="' + product.id + '"]').length > 0 ? 'selected' : '';
                        options += '<option value="' + product.id + '" ' + selected + '>' + product.name + '</option>';
                    });
                    $select.html(options);
                }
            },
            error: function() {
                console.error('Failed to load products for existing tab');
            }
        });
    });
});
