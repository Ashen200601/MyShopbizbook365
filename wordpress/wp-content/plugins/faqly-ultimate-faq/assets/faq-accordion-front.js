jQuery(document).ready(function ($) {
    // Animation mapping
    var animationMap = {
        'normal': '',
        'fadeIn': 'fadeIn',
        'fadeInLeft': 'fadeInLeft',
        'fadeInUp': 'fadeInUp',
        'fadeInDownBig': 'fadeInDownBig',
        'shake': 'shake',
        'swing': 'swing',
        'rollIn': 'rollIn',
        'bounce': 'bounce',
        'wobble': 'wobble',
        'slideInDown': 'slideInDown',
        'slideInLeft': 'slideInLeft',
        'slideInUp': 'slideInUp',
        'zoomIn': 'zoomIn',
        'zoomInDown': 'zoomInDown',
        'zoomInUp': 'zoomInUp',
        'zoomInLeft': 'zoomInLeft',
        'bounceIn': 'bounceIn',
        'bounceInDown': 'bounceInDown',
        'bounceInUp': 'bounceInUp',
        'jello': 'jello'
    };

    $('.accordion').each(function () {
        var accordion = $(this);
        var animationEnable = accordion.data('animation-enable') || 'yes';
        var animationStyle = accordion.data('animation-style') || 'normal';
        var transitionTime = accordion.data('transition-time') || '300';
        var accordionEvent = accordion.data('accordion-event') || '.click';
        var accordionMode = accordion.data('accordion-mode') || '.first_open';
        var multipleActive = accordion.data('multiple-active') === 'enable';

        // Bind animation events
        if (animationEnable === 'yes' && animationStyle !== 'normal') {
            accordion.find('.accordion-collapse').on('show.bs.collapse', function () {
                var body = $(this).find('.accordion-body');
                var animateClass = animationMap[animationStyle];
                if (animateClass) {
                    body.addClass('animate__animated animate__' + animateClass);
                    body.css('--animate-duration', transitionTime + 'ms');
                }
            });

            accordion.find('.accordion-collapse').on('hide.bs.collapse', function () {
                var body = $(this).find('.accordion-body');
                body.removeClass(function (index, className) {
                    return (className.match(/\banimate__\S+/g) || []).join(' ');
                });
            });
        }

        // Bind accordion event
        if (accordionEvent === '.mouseover') {
            accordion.find('.accordion-button').each(function () {
                var button = $(this);
                button.on('mouseenter', function () {
                    var targetId = button.attr('data-bs-target');
                    var collapseElement = $(targetId);
                    if (!collapseElement.hasClass('show')) {
                        new bootstrap.Collapse(collapseElement[0], {
                            toggle: true
                        });
                    }
                });
                button.on('mouseleave', function () {
                    var targetId = button.attr('data-bs-target');
                    var collapseElement = $(targetId);
                    if (collapseElement.hasClass('show')) {
                        new bootstrap.Collapse(collapseElement[0], {
                            toggle: true
                        });
                    }
                });
            });
        }

        // Accordion mode
        if (accordionMode === '.first_open') {
            var firstAccordionButton = accordion.find('.accordion-button').first();
            var firstCollapseElement = $(firstAccordionButton.attr('data-bs-target'));
            if (!firstCollapseElement.hasClass('show')) {
                new bootstrap.Collapse(firstCollapseElement[0], {
                    toggle: true
                });
            }
        } else if (accordionMode === '.all_open') {
            accordion.find('.accordion-button').each(function () {
                var targetId = $(this).attr('data-bs-target');
                var collapseElement = $(targetId);
                if (!collapseElement.hasClass('show')) {
                    new bootstrap.Collapse(collapseElement[0], {
                        toggle: true
                    });
                }
            });
        } else if (accordionMode === '.all_folded') {
            accordion.find('.accordion-button').each(function () {
                var targetId = $(this).attr('data-bs-target');
                var collapseElement = $(targetId);
                if (collapseElement.hasClass('show')) {
                    new bootstrap.Collapse(collapseElement[0], {
                        toggle: true
                    });
                }
            });
        }

        // Multiple active
        if (multipleActive) {
            accordion.find('.accordion-button').off('click').on('click', function (e) {
                e.preventDefault();
                var targetId = $(this).attr('data-bs-target');
                var collapseElement = $(targetId)[0];
                var bsCollapse = bootstrap.Collapse.getInstance(collapseElement);
                if (!bsCollapse) {
                    bsCollapse = new bootstrap.Collapse(collapseElement, {
                        toggle: false
                    });
                }
                if ($(collapseElement).hasClass('show')) {
                    bsCollapse.hide();
                } else {
                    bsCollapse.show();
                }
            });
        }
    });

    // Modular AJAX function for loading FAQ content
    function loadFaqContent(postId, searchTerm = '', page = 1) {
        return $.ajax({
            url: faqly_ajax_object.ajax_url,
            type: 'POST',
            data: {
                action: 'faqly_load_faq_content',
                post_id: postId,
                search_term: searchTerm,
                page: page,
                nonce: faqly_ajax_object.nonce
            }
        });
    }

    // Handle content update after AJAX
    function handleContentUpdate(response, accordion, pagination, noResultsMessage) {
        if (response.success) {
            // Replace accordion items
            accordion.html(response.data.items_html);
            if (response.data.pagination_html) {
                pagination.replaceWith(response.data.pagination_html);
            } else {
                pagination.hide();
            }

            accordion.data('current-page', response.data.current_page);
            accordion.data('total-pages', response.data.total_pages || 1);

            if (noResultsMessage && response.data.total_items === 0) {
                noResultsMessage.show();
            } else if (noResultsMessage) {
                noResultsMessage.hide();
            }

            reinitializeAccordionContent(accordion);
        }
    }

    function reinitializeAccordionContent(accordion) {
        accordion.find('.accordion-collapse').each(function () {
            new bootstrap.Collapse(this, {
                toggle: false
            });
        });

        // Get settings from accordion data attributes
        var animationEnable = accordion.data('animation-enable') || 'yes';
        var animationStyle = accordion.data('animation-style') || 'normal';
        var transitionTime = accordion.data('transition-time') || '300';
        var accordionEvent = accordion.data('accordion-event') || '.click';
        var accordionMode = accordion.data('accordion-mode') || '.first_open';
        var multipleActive = accordion.data('multiple-active') === 'enable';

        // Re-apply animations if enabled
        if (animationEnable === 'yes' && animationStyle !== 'normal') {
            accordion.find('.accordion-collapse').on('show.bs.collapse', function () {
                var body = $(this).find('.accordion-body');
                var animateClass = animationMap[animationStyle];
                if (animateClass) {
                    body.addClass('animate__animated animate__' + animateClass);
                    body.css('--animate-duration', transitionTime + 'ms');
                }
            });

            accordion.find('.accordion-collapse').on('hide.bs.collapse', function () {
                var body = $(this).find('.accordion-body');
                body.removeClass(function (index, className) {
                    return (className.match(/\banimate__\S+/g) || []).join(' ');
                });
            });
        }

        // Re-apply accordion event settings to new items
        if (accordionEvent === '.mouseover') {
            accordion.find('.accordion-button').each(function () {
                var button = $(this);
                button.off('mouseenter mouseleave'); // Remove existing handlers
                button.on('mouseenter', function () {
                    var targetId = button.attr('data-bs-target');
                    var collapseElement = $(targetId);
                    if (!collapseElement.hasClass('show')) {
                        new bootstrap.Collapse(collapseElement[0], {
                            toggle: true
                        });
                    }
                });
                button.on('mouseleave', function () {
                    var targetId = button.attr('data-bs-target');
                    var collapseElement = $(targetId);
                    if (collapseElement.hasClass('show')) {
                        new bootstrap.Collapse(collapseElement[0], {
                            toggle: true
                        });
                    }
                });
            });
        }

        // Re-apply accordion mode settings
        if (accordionMode === '.first_open') {
            var firstAccordionButton = accordion.find('.accordion-button').first();
            var firstCollapseElement = $(firstAccordionButton.attr('data-bs-target'));
            if (!firstCollapseElement.hasClass('show')) {
                new bootstrap.Collapse(firstCollapseElement[0], {
                    toggle: true
                });
            }
        } else if (accordionMode === '.all_open') {
            accordion.find('.accordion-button').each(function () {
                var targetId = $(this).attr('data-bs-target');
                var collapseElement = $(targetId);
                if (!collapseElement.hasClass('show')) {
                    new bootstrap.Collapse(collapseElement[0], {
                        toggle: true
                    });
                }
            });
        } else if (accordionMode === '.all_folded') {
            accordion.find('.accordion-button').each(function () {
                var targetId = $(this).attr('data-bs-target');
                var collapseElement = $(targetId);
                if (collapseElement.hasClass('show')) {
                    new bootstrap.Collapse(collapseElement[0], {
                        toggle: true
                    });
                }
            });
        }

        // Re-apply multiple active behavior to new items
        if (multipleActive) {
            accordion.find('.accordion-button').off('click').on('click', function (e) {
                e.preventDefault();
                var targetId = $(this).attr('data-bs-target');
                var collapseElement = $(targetId)[0];
                var bsCollapse = bootstrap.Collapse.getInstance(collapseElement);
                if (!bsCollapse) {
                    bsCollapse = new bootstrap.Collapse(collapseElement, {
                        toggle: false
                    });
                }
                if ($(collapseElement).hasClass('show')) {
                    bsCollapse.hide();
                } else {
                    bsCollapse.show();
                }
            });
        }
    }


    $(document).on('input', '.faq-search-box', function () {
        var searchBox = $(this);
        var searchValue = searchBox.val().toLowerCase().trim();
        var searchContainer = searchBox.closest('.faq-search-container');
        var faqContainer = searchContainer.parent().find('.accordion').first();
        var postId = faqContainer.data('post-id');
        var paginationContainer = faqContainer.next('.faq-pagination');
        var noResultsMessage = faqContainer.find('.no-results-message');

        faqContainer.data('current-search', searchValue);

        clearTimeout(searchBox.data('timeout'));
        searchBox.data('timeout', setTimeout(function () {
            loadFaqContent(postId, searchValue, 1)
                .done(function (response) {
                    handleContentUpdate(response, faqContainer, paginationContainer, noResultsMessage);
                })
                .fail(function (xhr, status, error) {
                    console.error('Search AJAX error:', error);
                });
        }, 300)); // 300ms debounce
    });

    const horizontalAccordions = $(".accordion.horizontal");

    horizontalAccordions.each((index, element) => {
        const accordion = $(element);
        const collapses = accordion.find(".accordion-collapse");
        const headers = accordion.find(".accordion-header");

        if (accordion.hasClass('horizontal')) {
            const accordionHeight = accordion.height();
            accordion.css('height', accordionHeight + 'px');

            // Set all accordion items to the same height
            headers.css('height', '100%');
            collapses.css('height', '100%');

            // Mark collapsed items
            collapses.not(".show").each((index, element) => {
                $(element).parent().find(".accordion-button").addClass("collapsed");
            });
        }
    });

    // Handle horizontal accordion resize events
    $(window).on('resize', function () {
        horizontalAccordions.each((index, element) => {
            const accordion = $(element);
            if (accordion.hasClass('horizontal')) {
                const accordionHeight = accordion.height();
                accordion.find('.accordion-header, .accordion-collapse').css('height', '100%');
            }
        });
    });

    $(document).on('click', '.faq-page-btn', function (e) {
        e.preventDefault();
        const button = $(this);
        const pagination = button.closest('.faq-pagination');
        const postId = pagination.data('post-id');
        const page = button.data('page');
        const accordion = pagination.prev('.accordion');

        if (button.hasClass('active')) {
            return;
        }

        button.addClass('loading').text('...');

        const currentSearch = accordion.data('current-search') || '';
        loadFaqContent(postId, currentSearch, page)
            .done(function (response) {
                if (response.success) {
                    handleContentUpdate(response, accordion, pagination);
                } else {
                    console.error('Failed to load FAQ page:', response.data);
                    button.removeClass('loading').text(page);
                }
            })
            .fail(function (xhr, status, error) {
                console.error('AJAX error:', error);
                button.removeClass('loading').text(page);
            });
    });

    // Expand All FAQs functionality
    $(document).on('click', '.faq-expand-all-btn', function () {
        const container = $(this).closest('.faq-expand-collapse-container');
        const accordion = container.next('.accordion');

        accordion.find('.accordion-collapse').each(function () {
            const collapseElement = $(this);
            if (!collapseElement.hasClass('show')) {
                new bootstrap.Collapse(collapseElement[0], {
                    toggle: true
                });
            }
        });
    });

    // Collapse All FAQs functionality
    $(document).on('click', '.faq-collapse-all-btn', function () {
        const container = $(this).closest('.faq-expand-collapse-container');
        const accordion = container.next('.accordion');

        accordion.find('.accordion-collapse').each(function () {
            const collapseElement = $(this);
            if (collapseElement.hasClass('show')) {
                new bootstrap.Collapse(collapseElement[0], {
                    toggle: true
                });
            }
        });
    });

});
