(function ($) {
    wp.data.subscribe(() => {
        appendButton();
    });

    function appendButton() {
        if (!$('.faqly-templates-btn-wrap').length) {
            var faqly_btn = `<div class="faqly-templates-btn-wrap"><span>Templates</span></div>`;
            $('.components-accessible-toolbar.edit-post-header-toolbar').append(faqly_btn);
        }
    }

    window.onload = function () {

        if (!$('.faqly-templates-modal-wrap').length) {
            $('body').append(`
                <div class="faqly-templates-modal-wrap-main">
                    <div class="faqly templates-modal-wrap">
                        <span class="faqly-dismiss-modal">x</span>
                        <div class="faqly templates-modal-content-wrap">
                            <div class="faqly templates-modal-content-cards-wrap">
                                <div class="faqly templates-modal-content-cards"></div>
                                <button class="faqly templates-load-more">Load More</button>
                            </div>
                        </div>
                    </div>
                </div>
            `);
        }

        $('body').on('click', '.faqly-templates-btn-wrap', function () {
            $('.faqly-templates-modal-wrap-main').show();
        })

        $('body').on('click', '.faqly-dismiss-modal', function () {
            $('.faqly-templates-modal-wrap-main').hide();
        })

        $('body').on('click', '.faqly.templates-load-more', function () {
            faqly_get_templates_records($(this).attr('data-cursor'));
        })
    }

    faqly_get_templates_records();

    let alreadyInsertedLifetime = false;

    function faqly_get_templates_records(cursor = '') {
        const isFirstLoad = (cursor === '');

        const data = {
            cursor: cursor,
            action: 'faqly_get_templates'
        };

        $.ajax({
            method: "POST",
            url: faqly_template_modal_js.admin_ajax,
            data: data
        }).done(function (data) {
            const response = JSON.parse(data);
            if (response.code == 200 && response.data.products.length) {
                const templates_arr = response.data;
                const products = templates_arr.products;
                const pagination = templates_arr.pageInfo;

                $('.faqly.templates-load-more').hide();
                if (pagination.hasNextPage) {
                    $('.faqly.templates-load-more').attr('data-cursor', pagination.endCursor).show();
                }

                const cardContainer = $('.faqly.templates-modal-content-cards');

                const filteredProducts = products.filter(p => p.node.handle !== 'wordpress-theme-package');

                if (isFirstLoad) {
                    if (filteredProducts.length > 0) {
                        appendProductCard(filteredProducts[0].node, cardContainer);
                    }

                    fetchSearchData('lifetime access').then(searchResponse => {
                        if (
                            searchResponse.code === 200 &&
                            searchResponse.data.products.length > 0
                        ) {
                            const searchProduct = searchResponse.data.products.find(p => p.node.handle === 'wordpress-theme-package');
                            if (searchProduct && !alreadyInsertedLifetime) {
                                appendProductCard(searchProduct.node, cardContainer); // Insert at position [1]
                                alreadyInsertedLifetime = true;
                            }
                        }

                        // Append (after [1])
                        filteredProducts.slice(1).forEach(p => {
                            appendProductCard(p.node, cardContainer);
                        });
                    });

                } else {

                    filteredProducts.forEach(p => {
                        appendProductCard(p.node, cardContainer);
                    });
                }
            }
        });
    }

    function appendProductCard(product, container) {
        let demo_url = '';
        let product_url = product.onlineStoreUrl || '';
        let image_src = product.images.edges.length > 0 ? product.images.edges[0].node.src : '';
        let price = product.variants.edges.length > 0 ? `$${product.variants.edges[0].node.price}` : '';

        if (product.hasOwnProperty('metafields') && product.metafields.edges) {
            product.metafields.edges.forEach(metafield_edge => {
                let metafield = metafield_edge.node;
                if (metafield.key === 'custom.live_demo') {
                    demo_url = metafield.value;
                }
            });
        }

        let cardHtml = `
            <div class="faqly-box faqly_filter">
                <div class="faqly-box-widget">
                    <div class="faqly-media">
                        <img class="faqly-product-img" src="${image_src}" alt="${product.title}">
                        <div class="faqly-product-banner-wrap">
                            <h2>${price}</h2>
                        </div>
                    </div>
                    <div class="faqly-template-title">${product.title}</div>
                    <div class="faqly-btn">
                        <a href="${product_url}" target="_blank" rel="noopener noreferrer" class="btn ins-btn installbtn">Buy Now</a>
                        ${demo_url ? `<a href="${demo_url}" target="_blank" rel="noopener noreferrer" class="btn pre-btn previewbtn">Preview</a>` : ''}
                    </div>
                </div>
            </div>
        `;

        if (!product.hasOwnProperty('inCollection') || product.inCollection) {
            container.append(cardHtml);
        }
    }

    function fetchSearchData(search) {
        return new Promise((resolve) => {
            $.ajax({
                method: "POST",
                url: faqly_template_modal_js.admin_ajax,
                data: {
                    action: 'faqly_get_templates',
                    search: search
                }
            }).done(function (data) {
                resolve(JSON.parse(data));
            });
        });
    }
})(jQuery);