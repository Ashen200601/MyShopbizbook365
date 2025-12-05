jQuery(document).ready(function ($) {
    // When the notice is dismissed
    $(document).on('click', '.the-retail-storefront-notice .notice-dismiss', function () {
        $.post(ajaxurl, {
            action: 'the_retail_storefront_dismiss_notice'
        });
    });
});