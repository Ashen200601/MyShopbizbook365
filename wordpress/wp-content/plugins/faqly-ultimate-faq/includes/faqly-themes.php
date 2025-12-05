<header>
    <div>
        <div>
            <h2 class="faqly-templates">Website Templates</h2>
            <p class="faqly-para">Experience the most innovative, intuitive, and lightning-fast WordPress theme. Create
                your next website visually, quickly, and effortlessly.</p>
        </div>

        <!-- new add -->
        <ul class="faqly-navigation nav nav-pills " id="pills-tab" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active" id="pills-home-tab" data-bs-toggle="pill" data-bs-target="#pills-home"
                    type="button" role="tab" aria-controls="pills-home" aria-selected="true">Premium Templates</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="pills-pro-tab" data-bs-toggle="pill" data-bs-target="#pills-pro"
                    type="button" role="tab" aria-controls="pills-pro" aria-selected="true">Faqly Pro</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="pills-profile-tab" data-bs-toggle="pill" data-bs-target="#pills-profile"
                    type="button" role="tab" aria-controls="pills-pro" aria-selected="true">All Themes</button>
            </li>
        </ul>
    </div>
</header>

<div class="tab-content faqly-templates-tabs" id="pills-tabContent">
    <div class="tab-pane fade show active" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab">


        <div id="faqly-block-tab">
            <div class="search-wrapper-outer">

                <div class="search-container">
                    <input type="text" id="search-box" class="form-control" placeholder="Search products...">
                    <span class="dashicons dashicons-search"></span>
                    <button id="search-button" class="btn btn-secondary">Search</button>
                </div>
                <select id="api-response-dropdown" class="form-control">

                    <option value="">Themes Categories</option>

                </select>

            </div>
            <div id="product-cards" class="row">
                <div class="col-12 col-md-6 col-lg-3 mb-3">

                </div>
            </div>

            <button id="load-more" class="btn btn-primary" style="display:none;">Load More</button>
            <div class="support-container">
                <div class="support-content">
                    <h2>Need Assistance or Expert Advice?</h2>
                    <p>Have a question or need assistance with the theme? Feel free to submit a support ticket or
                        connect with our helpful community on our website.</p>
                    <div class="support-buttons">
                        <a class="sup-btn" target="_blank"
                            href="<?php echo esc_url(FAQLY_PLUGIN_MAIN_URL . 'pages/community'); ?>">Submit a Support
                            Ticket</a>
                    </div>
                </div>
            </div>
        </div>


    </div>
    <div class="tab-pane fade show" id="pills-pro" role="tabpanel" aria-labelledby="pills-pro-tab">


        <div id="faqly-pro-tab" class="row">


            <div class="faqly-card">
                <div class="faqly-pro-plugin">
                    <div class="faqly-po-img-wrap">
                        <img src="<?php echo FAQLY_PLUGIN_URL . 'assets/images/faqly-pro-plugin.png'; ?>"
                            alt="Upgrade To Pro!" />
                    </div>
                    <a href="<?php echo esc_url(FAQLY_PLUGIN_MAIN_URL . 'products/the-ultimate-faq-wordpress-plugin'); ?>"
                        class="buy-button" target="_blank">Upgrade To Pro!</a>
                </div>
            </div>


        </div>


    </div>
    <div class="tab-pane fade" id="pills-profile" role="tabpanel" aria-labelledby="pills-profile-tab">
        <!-- new -->
        <div id="bundle-product-cards" class="row">
            <div class="col-8 mb-3 position-relative">

            </div>

        </div>
        <!-- end -->
    </div>

</div>


<!-- new end -->
<script type="text/javascript">
    document.addEventListener('DOMContentLoaded', function () {
        const apiEndpoint = '<?php echo esc_url(plugin_dir_url(__FILE__) . 'fetch-api.php'); ?>';
        let endCursor = null;
        let searchQuery = '';
        let selectedCollection = '';
        let debounceTimeout = null;

        //new fetchDataBySearchQuery 
        function fetchDataBySearchQuery(searchQuery1) {
            return fetch(apiEndpoint, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({
                    action: 'getProducts',
                    collectionHandle: selectedCollection,
                    productHandle: searchQuery1,
                    paginationParams: {
                        first: 12,
                        afterCursor: null,
                        reverse: true
                    }
                })
            })
                .then(response => response.json())
                .then(data => {
                    return data; // Return the raw data to be handled elsewhere
                })
                .catch(error => {
                    console.error('Error fetching products by search query:', error);
                    return null; // Return null or handle error appropriately
                });
        }

        function fetchCollections() {
            return fetch(apiEndpoint, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({
                    action: 'getCollections'
                })
            })
                .then(response => response.json())
                .then(data => populateDropdown(data))
                .catch(error => console.error('Error fetching collections:', error));
        }

        function fetchApiData(afterCursor = null, append = false) {
            return fetch(apiEndpoint, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({
                    action: 'getProducts',
                    collectionHandle: selectedCollection,
                    productHandle: searchQuery,
                    paginationParams: {
                        first: 12,
                        afterCursor: afterCursor,
                        reverse: true
                    }
                })
            })
                .then(response => response.json())
                .then(data => {
                    displayData(data, append);
                    if (!append) {
                        displaybundleData(data, append);
                    }
                    endCursor = data.data.pageInfo.endCursor;
                    document.getElementById('load-more').style.display = data.data.pageInfo.hasNextPage ? 'block' : 'none';
                })
                .catch(error => console.error('Error fetching products:', error));
        }

        function populateDropdown(data) {
            const dropdown = document.getElementById('api-response-dropdown');
            dropdown.innerHTML = '<option value="">Themes Categories</option>';

            if (data && data.data && Array.isArray(data.data)) {
                data.data.forEach(collection => {

                    if (collection.handle == "free") {
                        return;
                    }

                    const option = document.createElement('option');
                    option.value = collection.handle;
                    option.textContent = collection.title;
                    dropdown.appendChild(option);
                });
            } else {
                console.error('Data format is incorrect:', data);
            }
        }

        function displaybundleData(data, append = false) {
            const productCards = document.getElementById('bundle-product-cards');
            if (!append) productCards.innerHTML = '';

            if (data && data.data && Array.isArray(data.data.products)) {
                let filteredProducts = data.data.products;

                if (searchQuery) {
                    filteredProducts = filteredProducts.filter(product => product.node.inCollection === true);
                }

                // Filter to include only "wordpress-theme-bundle" in Bundles tab
                filteredProducts = filteredProducts.filter(product => product.node.handle === "wordpress-theme-bundle");

                filteredProducts.forEach(product => {
                    const item = product.node;
                    const imageSrc = item.images.edges[0]?.node.src || 'default-image.jpg';
                    const price = item.variants.edges[0]?.node.price || 'N/A';
                    const demoLink = item.metafield?.value || '#';

                    const colElement = document.createElement('div');
                    colElement.classList.add('col-5', 'position-relative');
                    colElement.innerHTML = `
                        <div class="card faqly-product-card">
                            <div class="card-img-wrap faqly-product-img-wrap">
                                <img src="${imageSrc}" class="card-img-top" alt="${item.title}">
                            </div>
                        </div>
                        <div class="card-body faqly-product-card-body">
                            <h5 class="card-title faqly-product-card-title">${item.title}</h5>
                            <div class="faqly-button-wrapper">
                                <a href="${item.onlineStoreUrl}" class="btn btn-primary card-buy-now-btn" target="_blank">Buy Now</a>
                                <p class="card-text faqly-product-card-text"><span>Price: </span>$${price}</p>
                            </div>
                        </div>
                    `;
                    productCards.appendChild(colElement);
                });

                // Add the "wordpress-theme-package" product fetched by search query "lifetime access"
                fetchDataBySearchQuery("lifetime access").then(searchResponse => {
                    if (
                        searchResponse &&
                        searchResponse.data &&
                        Array.isArray(searchResponse.data.products) &&
                        searchResponse.data.products.length > 0
                    ) {
                        const searchProduct = searchResponse.data.products.find(p => p.node.handle === 'wordpress-theme-package');
                        if (searchProduct) {
                            const item = searchProduct.node;
                            const imageSrc = item.images.edges[0]?.node.src || 'default-image.jpg';
                            const price = item.variants.edges[0]?.node.price || 'N/A';
                            const demoLink = item.metafield?.value || '#';
                            const demoButton = demoLink !== '#' ?
                                `<a href="${demoLink}" class="btn btn-primary demo card-demo-btn" target="_blank" style="margin-left: 10px;">Demo</a>`
                                : '';

                            const colElement = document.createElement('div');
                            colElement.classList.add('col-5', 'position-relative');
                            colElement.innerHTML = `
                                <div class="card faqly-product-card">
                                    <div class="card-img-wrap faqly-product-img-wrap">
                                        <img src="${imageSrc}" class="card-img-top" alt="${item.title}">
                                    </div>
                                </div>
                                <div class="card-body faqly-product-card-body">
                                    <h5 class="card-title faqly-product-card-title">${item.title}</h5>
                                    <div class="faqly-button-wrapper">
                                        <a href="${item.onlineStoreUrl}" class="btn btn-primary card-buy-now-btn" target="_blank">Buy Now</a>
                                        ${demoButton}
                                    </div>
                                    <p class="card-text faqly-product-card-text"><span>Price: </span>$${price}</p>
                                </div>
                            `;
                            productCards.appendChild(colElement);
                        }
                    }
                });

            } else {
                console.error('Data format is incorrect:', data);
            }
        }

        //new add 
        // Make displayData async
        async function displayData(data, append = false) {
            const productCards = document.getElementById('product-cards');
            if (!append) productCards.innerHTML = '';

            if (data && data.data && Array.isArray(data.data.products)) {
                let filteredProducts = data.data.products;

                if (searchQuery) {
                    filteredProducts = filteredProducts.filter(product => product.node.inCollection === true);
                }

                // Filter out bundle products from Premium Templates tab
                // filteredProducts = filteredProducts.filter(product => {
                //     const handle = product.node.handle;
                //     return handle !== "wordpress-theme-bundle" && handle !== "wordpress-theme-package";
                // });

                const productCards = document.getElementById('product-cards');
                productCards.innerHTML = '';

                filteredProducts.forEach(product => {
                    const item = product.node;

                    const imageSrc = item.images.edges[0]?.node.src || 'default-image.jpg';
                    const price = item.variants.edges[0]?.node.price || 'N/A';
                    const demoLink = item.metafield?.value || '#';

                    const colElement = document.createElement('div');
                    colElement.classList.add('col-12', 'col-md-6', 'col-lg-3', 'mb-3');
                    colElement.innerHTML = `
                        <div class="card faqly-product-card">
                            <div class="card-img-wrap faqly-product-img-wrap">
                                <img src="${imageSrc}" class="card-img-top" alt="${item.title}">
                            </div>
                            <div class="card-body faqly-product-card-body">
                                <h5 class="card-title faqly-product-card-title">${item.title}</h5>
                                <div class="faqly-button-wrapper ">
                                    <a href="${item.onlineStoreUrl}" class="btn btn-primary card-buy-now-btn" target="_blank">Buy Now</a>
                                    <a href="${demoLink}" class="btn btn-primary demo card-demo-btn" target="_blank" style="margin-left: 10px;">Demo</a>
                                </div>
                                <p class="card-text faqly-product-card-text"><span>Price: </span>$${price}</p>
                            </div>
                        </div>
                    `;
                    productCards.appendChild(colElement);
                });

            } else {
                console.error('Data format is incorrect:', data);
            }
        }


        // search function
        function debouncedSearch() {
            clearTimeout(debounceTimeout);
            debounceTimeout = setTimeout(function () {
                endCursor = null;
                fetchApiData();
            }, 1000);
        }

        // Event listener search input
        document.getElementById('search-box').addEventListener('input', function () {
            searchQuery = this.value.trim();
            debouncedSearch();
        });

        document.getElementById('load-more').addEventListener('click', function () {
            if (endCursor) fetchApiData(endCursor, true);
        });

        document.getElementById('api-response-dropdown').addEventListener('change', function () {
            selectedCollection = this.value;
            endCursor = null;
            fetchApiData();
        });

        fetchCollections();
        fetchApiData();
    });
</script>