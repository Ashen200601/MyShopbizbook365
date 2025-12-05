<?php
/*
 * title: Banner
 * slug: storefront_blocks/Banner
 * categories: storefront_blocks
 */
?>
    

<!-- wp:group {"layout":{"type":"constrained"}} -->
<div class="wp-block-group"><!-- wp:columns {"backgroundColor":"pale-pink"} -->
<div class="wp-block-columns has-pale-pink-background-color has-background"><!-- wp:column {"verticalAlignment":"center","style":{"border":{"width":"0px","style":"none"}}} -->
<div class="wp-block-column is-vertically-aligned-center" style="border-style:none;border-width:0px"><!-- wp:group {"style":{"dimensions":{"minHeight":""}},"layout":{"type":"constrained"},"fontSize":"large"} -->
<div class="wp-block-group has-large-font-size"><!-- wp:heading {"style":{"typography":{"fontSize":"68px","fontStyle":"normal","fontWeight":"600"}}} -->
<h2 class="wp-block-heading" style="font-size:68px;font-style:normal;font-weight:600"><?php esc_html_e("Discover the Latest trends","shop-startup"); ?></h2>
<!-- /wp:heading --></div>
<!-- /wp:group -->

<!-- wp:buttons -->
<div class="wp-block-buttons"><!-- wp:button {"backgroundColor":"vivid-red","style":{"border":{"width":"0px","style":"none","radius":"0px"}},"fontSize":"medium"} -->
<div class="wp-block-button has-custom-font-size has-medium-font-size"><a class="wp-block-button__link has-vivid-red-background-color has-background wp-element-button" style="border-style:none;border-width:0px;border-radius:0px"><?php esc_html_e("BUY NOW", "shop-startup"); ?></a></div>
<!-- /wp:button --></div>
<!-- /wp:buttons --></div>
<!-- /wp:column -->

<!-- wp:column -->
<div class="wp-block-column"><!-- wp:image {"lightbox":{"enabled":false},"id":596,"aspectRatio":"4/3","scale":"cover","sizeSlug":"large","linkDestination":"none","className":"is-style-default"} -->
<figure class="wp-block-image size-large is-style-default"><img src="<?php echo esc_url(get_theme_file_uri().'/assests/fashion_woman.jpeg'); ?>" alt="" class="wp-image-596" style="aspect-ratio:4/3;object-fit:cover"/></figure>
<!-- /wp:image --></div>
<!-- /wp:column --></div>
<!-- /wp:columns --></div>
<!-- /wp:group -->
