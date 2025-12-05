jQuery(document).ready(function ($) {
    let faqIndex = $('#faq-accordion .accordion-item').length;

    // Add New FAQ
    $('#add-faq-btn').on('click', function () {
        const newItem = `
        <div class="accordion-item" id="faq-item-${faqIndex}">
            <h2 class="accordion-header" id="heading-${faqIndex}">
                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                        data-bs-target="#collapse-${faqIndex}" aria-expanded="false" 
                        aria-controls="collapse-${faqIndex}">
                    FAQ #${faqIndex + 1}
                </button>
            </h2>
            <div id="collapse-${faqIndex}" class="accordion-collapse collapse" 
                 aria-labelledby="heading-${faqIndex}" data-bs-parent="#faq-accordion">
                <div class="accordion-body">
                    <div class="form-group">
                        <label for="faq_title_${faqIndex}">Title:</label>
                        <input type="text" name="faq_items[${faqIndex}][title]" 
                               id="faq_title_${faqIndex}" class="form-control" 
                               placeholder="Enter FAQ title">
                    </div>
                    
                    <div class="form-group mt-3">
                        <label for="faq_description_${faqIndex}">Description:</label>
                        <textarea name="faq_items[${faqIndex}][description]" 
                                  id="faq_description_${faqIndex}" class="form-control" 
                                  rows="6" placeholder="Enter FAQ description"></textarea>
                    </div>

                    

                    <button type="button" class="btn btn-danger mt-3 remove-faq-btn" data-faq-id="${faqIndex}">
                        Remove FAQ
                    </button>
                </div>
            </div>
        </div>
    `;
        $('#faq-accordion').append(newItem);
        faqIndex++;
    });

    // Remove FAQ
    $(document).on('click', '.remove-faq-btn', function () {
        const faqId = $(this).data('faq-id');
        $(`#faq-item-${faqId}`).remove();

        // Recalculate FAQ numbers after removal
        $('#faq-accordion .accordion-item').each(function (index) {
            const newId = `faq-item-${index}`;
            $(this).attr('id', newId);
            $(this).find('.accordion-header').attr('id', `heading-${index}`);
            $(this).find('.accordion-button')
                .text(`FAQ #${index + 1}`)
                .attr('data-bs-target', `#collapse-${index}`)
                .attr('aria-controls', `collapse-${index}`);
            $(this).find('.accordion-collapse')
                .attr('id', `collapse-${index}`)
                .attr('aria-labelledby', `heading-${index}`);
            $(this).find('.remove-faq-btn').attr('data-faq-id', index);
        });
        faqIndex = $('#faq-accordion .accordion-item').length;
    });
});


jQuery(document).ready(function ($) {
    // When the tab is changed, update the hidden field
    $('#pills-tab button').on('click', function () {
        var activeTab = $(this).data('bs-target').replace('#', ''); // tab ID
        $('input[name="active_tab"]').val(activeTab);
    });
});


jQuery(document).ready(function ($) {

    $('#faqly-popup-content .faqly-popup-dismiss, #faqly-popup-content .faqly-popup-template-btn').on('click', function () {
        $.ajax({
            url: faqly_ajax_object.ajax_url,
            type: 'POST',
            data: { action: 'faqly_get_notice_dismiss' },
            success: function (response) {
                $('#faqly-popup-overlay').hide();
                // $('.faqly-premium-floating-btn').fadeIn(); 
                $('.faqly-premium-floating-btn')
                    .fadeIn()
                    .attr('style', 'display:inline-block !important;');
            }
        });
    });

});

// theme settings tab

jQuery(document).ready(function ($) {
    $('.theme-card').on('click', function () {

         // Check if the theme is disabled (for free users)
         if ($(this).hasClass('theme-disabled')) {
            return false; // Don't allow selection
        }

        // Remove selected class from all cards
        $('.theme-card').removeClass('theme-selected');
        $('.theme-selection-indicator .badge')
            .removeClass('bg-success')
            .addClass('bg-secondary')
            .text('Select');

        // Add selected class to clicked card
        $(this).addClass('theme-selected');
        $(this).find('.badge')
            .removeClass('bg-secondary')
            .addClass('bg-success')
            .text('Selected');

        // Update hidden input value
        var selectedTheme = $(this).data('theme');
        $('#faqly_selected_theme').val(selectedTheme);
    });
});


// its for dropdown custom posttype


jQuery(document).ready(function ($) {
    $('#faq_post_type').on('change', function () {
        var selectedValue = $(this).val();
        var customPostTypeInput = $('#faq_custom_post_type');

        if (selectedValue === 'custom') {
            customPostTypeInput.show();
        } else {
            customPostTypeInput.hide();
        }
    });

    // Handle filter posts input visibility
    $('#faq_filter_posts').on('change', function () {
        var selectedValue = $(this).val();
        var taxonomyFilter = $('.taxonomy-filter');
        var taxonomyTerms = $('.taxonomy-terms');
        var specificPosts = $('.specific-posts');

        // Hide all filter inputs first
        taxonomyFilter.hide();
        taxonomyTerms.hide();
        specificPosts.hide();

        // Show relevant inputs based on selection
        if (selectedValue === 'taxonomy') {
            taxonomyFilter.show();
            taxonomyTerms.show();
        } else if (selectedValue === 'specific') {
            specificPosts.show();
        }
    });

    $('#faq_post_type').trigger('change');
    $('#faq_filter_posts').trigger('change');
});