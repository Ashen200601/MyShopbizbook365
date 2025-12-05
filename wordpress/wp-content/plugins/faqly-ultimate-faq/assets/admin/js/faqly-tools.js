/**
 * FAQly Tools - Export Functionality JavaScript
 */

jQuery(document).ready(function($) {
    'use strict';
    if (typeof ajaxurl === 'undefined') {
        ajaxurl = faqly_admin_vars.ajax_url;
    }

    $('.faqly-export-btn').on('click', function(e) {
        e.preventDefault();

        var $btn = $(this);
        var $form = $('#faqly-export-form');
        var originalText = $btn.html();
        var exportType = $('input[name="export_type"]:checked').val();
        var nonce = $('#faqly-export-nonce').val();

        if (!exportType) {
            alert(faqly_admin_vars.i18n.select_export_type || 'Please select what you want to export.');
            return;
        }

        $btn.prop('disabled', true).html('<span class="dashicons dashicons-update spin"></span> ' +
            (faqly_admin_vars.i18n.preparing_export || 'Preparing Export...'));
        $form.addClass('loading');

        var ajaxData = {
            action: 'faqly_export_data',
            export_type: exportType,
            nonce: nonce
        };

        $.ajax({
            url: ajaxurl,
            type: 'POST',
            data: ajaxData,
            timeout: 30000, 
            success: function(response) {
                if (response.success) {
                    var data = response.data.data;
                    var filename = response.data.filename;
                    var count = response.data.count;

                    var successMsg = (faqly_admin_vars.i18n.export_complete || 'Export Complete') +
                        ' (' + count + ' ' + (faqly_admin_vars.i18n.items || 'items') + ')';
                    $btn.html('<span class="dashicons dashicons-yes"></span> ' + successMsg);

                    var jsonString = JSON.stringify(data, null, 2);
                    var blob = new Blob([jsonString], { type: 'application/json;charset=utf-8' });
                    var url = URL.createObjectURL(blob);

                    var a = document.createElement('a');
                    a.href = url;
                    a.download = filename;
                    a.style.display = 'none';
                    document.body.appendChild(a);
                    a.click();
                    document.body.removeChild(a);
                    URL.revokeObjectURL(url);

                    setTimeout(function() {
                        $btn.prop('disabled', false).html(originalText);
                        $form.removeClass('loading');
                    }, 2000);

                } else {
                    var errorMsg = response.data || (faqly_admin_vars.i18n.export_failed || 'Export failed');
                    alert(faqly_admin_vars.i18n.error || 'Error' + ': ' + errorMsg);
                    $btn.prop('disabled', false).html(originalText);
                    $form.removeClass('loading');
                }
            },
            error: function(xhr, status, error) {
                var errorMsg = (faqly_admin_vars.i18n.ajax_error || 'Export failed') + ': ' + error;
                if (status === 'timeout') {
                    errorMsg = faqly_admin_vars.i18n.timeout_error || 'Request timed out. Please try again.';
                }
                alert(errorMsg);
                $btn.prop('disabled', false).html(originalText);
                $form.removeClass('loading');
            }
        });
    });

    // Import functionality
    $('#faqly-import-file').on('change', function() {
        var file = this.files[0];
        var $btn = $('.faqly-import-btn');

        if (file) {
            if (file.type !== 'application/json' && !file.name.endsWith('.json')) {
                alert(faqly_admin_vars.i18n.invalid_file_type || 'Please select a valid JSON file.');
                this.value = '';
                $btn.prop('disabled', true);
                return;
            }

            // Validate file size (max 10MB)
            if (file.size > 10 * 1024 * 1024) {
                alert(faqly_admin_vars.i18n.file_too_large || 'File size must be less than 10MB.');
                this.value = '';
                $btn.prop('disabled', true);
                return;
            }

            $btn.prop('disabled', false);
        } else {
            $btn.prop('disabled', true);
        }
    });

    $('.faqly-import-btn').on('click', function(e) {
        e.preventDefault();

        var $btn = $(this);
        var $form = $('#faqly-import-form');
        var fileInput = $('#faqly-import-file')[0];
        var originalText = $btn.html();
        var nonce = $('#faqly-import-nonce').val();
        // var skipDuplicates = $('#faqly-import-skip-duplicates').is(':checked');

        // Validate file selection
        if (!fileInput.files[0]) {
            alert(faqly_admin_vars.i18n.select_file || 'Please select a JSON file to import.');
            return;
        }

        $btn.prop('disabled', true).html('<span class="dashicons dashicons-update spin"></span> ' +
            (faqly_admin_vars.i18n.importing || 'Importing...'));
        $form.addClass('loading');

        var reader = new FileReader();
        reader.onload = function(e) {
            try {
                var jsonData = JSON.parse(e.target.result);

                var ajaxData = {
                    action: 'faqly_import_data',
                    data: jsonData,
                    // skip_duplicates: skipDuplicates,
                    nonce: nonce
                };

                $.ajax({
                    url: ajaxurl,
                    type: 'POST',
                    data: ajaxData,
                    timeout: 60000, 
                    success: function(response) {
                        if (response.success) {
                            var imported = response.data.imported || 0;
                            var successMsg = (faqly_admin_vars.i18n.import_complete || 'Import Complete') +
                                ' (' + imported + ' ' + (faqly_admin_vars.i18n.imported || 'imported') + ')';
                            $btn.html('<span class="dashicons dashicons-yes"></span> ' + successMsg);

                            fileInput.value = '';

                            setTimeout(function() {
                                $btn.prop('disabled', true).html(originalText);
                                $form.removeClass('loading');
                            }, 3000);

                        } else {
            
                            var errorMsg = response.data || (faqly_admin_vars.i18n.import_failed || 'Import failed');
                            alert(faqly_admin_vars.i18n.error || 'Error' + ': ' + errorMsg);
                            $btn.prop('disabled', false).html(originalText);
                            $form.removeClass('loading');
                        }
                    },
                    error: function(xhr, status, error) {
                        // Handle AJAX error
                        var errorMsg = (faqly_admin_vars.i18n.ajax_error || 'Import failed') + ': ' + error;
                        if (status === 'timeout') {
                            errorMsg = faqly_admin_vars.i18n.timeout_error || 'Request timed out. Please try again.';
                        }
                        alert(errorMsg);
                        $btn.prop('disabled', false).html(originalText);
                        $form.removeClass('loading');
                    }
                });

            } catch (error) {
                alert(faqly_admin_vars.i18n.invalid_json || 'Invalid JSON file format.');
                $btn.prop('disabled', false).html(originalText);
                $form.removeClass('loading');
            }
        };

        reader.onerror = function() {
            alert(faqly_admin_vars.i18n.file_read_error || 'Error reading file.');
            $btn.prop('disabled', false).html(originalText);
            $form.removeClass('loading');
        };

        reader.readAsText(fileInput.files[0]);
    });

});
