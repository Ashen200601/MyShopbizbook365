<?php
/**
 * Title: Featured Products
 * Slug: storefront_blocks/featured-products
 * Categories: storefront_blocks, featured-products
 */
?>
<!-- wp:group {"layout":{"type":"constrained","wideSize":"90%"}} -->
<div class="wp-block-group"><!-- wp:heading {"textAlign":"center","fontSize":"big"} -->
<h2 class="wp-block-heading has-text-align-center has-big-font-size"></h2>
<!-- /wp:heading -->

<!-- wp:group {"align":"full","backgroundColor":"base","layout":{"type":"constrained","wideSize":"90%"}} -->
<div class="wp-block-group alignfull has-base-background-color has-background"><!-- wp:columns {"style":{"spacing":{"padding":{"top":"0","bottom":"var:preset|spacing|60"}}}} -->
<div class="wp-block-columns" style="padding-top:0;padding-bottom:var(--wp--preset--spacing--60)"></div>
<!-- /wp:columns -->

<!-- wp:group {"layout":{"type":"constrained","wideSize":"90%"}} -->
<div class="wp-block-group"><!-- wp:heading {"textAlign":"center","fontSize":"big"} -->
<h2 class="wp-block-heading has-text-align-center has-big-font-size"></h2>
<!-- /wp:heading -->

<!-- wp:group {"align":"full","backgroundColor":"base","layout":{"type":"constrained","wideSize":"90%"}} -->
<div class="wp-block-group alignfull has-base-background-color has-background"><!-- wp:columns {"style":{"spacing":{"padding":{"top":"0","bottom":"var:preset|spacing|60"}}}} -->
<div class="wp-block-columns" style="padding-top:0;padding-bottom:var(--wp--preset--spacing--60)"><!-- wp:column {"style":{"spacing":{"padding":{"top":"var:preset|spacing|50","bottom":"var:preset|spacing|50","left":"var:preset|spacing|50","right":"var:preset|spacing|50"}}},"backgroundColor":"vivid-purple","className":"has-luminous-vivid-amber-background-color"} -->
<div class="wp-block-column has-luminous-vivid-amber-background-color has-vivid-purple-background-color has-background" style="padding-top:var(--wp--preset--spacing--50);padding-right:var(--wp--preset--spacing--50);padding-bottom:var(--wp--preset--spacing--50);padding-left:var(--wp--preset--spacing--50)"><!-- wp:query {"queryId":57,"query":{"perPage":"4","pages":0,"offset":0,"postType":"product","order":"desc","orderBy":"popularity","author":"","search":"","exclude":[],"sticky":"","inherit":false,"__woocommerceAttributes":[],"__woocommerceStockStatus":["instock","outofstock","onbackorder"]},"namespace":"woocommerce/product-query"} -->
<div class="wp-block-query"><!-- wp:post-template {"className":"products-block-post-template","layout":{"type":"grid","columnCount":4},"__woocommerceNamespace":"woocommerce/product-query/product-template"} -->
<!-- wp:woocommerce/product-image {"imageSizing":"thumbnail","isDescendentOfQueryLoop":true} /-->

<!-- wp:post-title {"textAlign":"center","level":3,"isLink":true,"style":{"spacing":{"margin":{"bottom":"0.75rem","top":"0"}}},"fontSize":"medium","__woocommerceNamespace":"woocommerce/product-query/product-title"} /-->

<!-- wp:woocommerce/product-price {"isDescendentOfQueryLoop":true,"textAlign":"center"} /-->

<!-- wp:woocommerce/product-button {"textAlign":"center","isDescendentOfQueryLoop":true,"fontSize":"small"} /-->
<!-- /wp:post-template -->

<!-- wp:query-no-results -->
<!-- wp:paragraph {"placeholder":"Add text or blocks that will display when a query returns no results."} -->
<p></p>
<!-- /wp:paragraph -->
<!-- /wp:query-no-results --></div>
<!-- /wp:query --></div>
<!-- /wp:column --></div>
<!-- /wp:columns --></div>
<!-- /wp:group --></div>
<!-- /wp:group --></div>
<!-- /wp:group --></div>
<!-- /wp:group -->