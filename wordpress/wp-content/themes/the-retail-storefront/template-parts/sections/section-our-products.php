<?php 
$the_retail_storefront_aboutus = get_theme_mod('the_retail_storefront_our_products_show_hide_section', true);

if ($the_retail_storefront_aboutus == '1') : ?>
<section id="product-section" class="py-md-5 py-3 mx-md-0 mx-3">
  <div class="container">
    <div class="product-head text-start my-2">
      <?php
      // Section Heading
      $the_retail_storefront_our_products_heading_section = get_theme_mod('the_retail_storefront_our_products_heading_section');
      if (!empty($the_retail_storefront_our_products_heading_section)) : ?>
        <h2 class="mb-2 product-heading">
          <?php echo esc_html($the_retail_storefront_our_products_heading_section); ?>
        </h2>
      <?php endif; ?>

      <?php
      // Short Heading for the section
      $the_retail_storefront_short_heading = get_theme_mod('the_retail_storefront_our_products_short_heading_section');
      if (!empty($the_retail_storefront_short_heading)) : ?>
        <p class="mb-3 short-product-heading">
          <?php echo esc_html($the_retail_storefront_short_heading); ?>
        </p>
      <?php endif; ?>
    </div>
    
    <?php if (class_exists('woocommerce')) : ?>
      <div class="row">
        <?php
        // Query Products by Selected Category
        $the_retail_storefront_selected_category = get_theme_mod('the_retail_storefront_our_product_product_category','product_cat1');
        if ($the_retail_storefront_selected_category) {
            $the_retail_storefront_args = array(
                'post_type'      => 'product',
                'posts_per_page' => 50,
                'product_cat'    => $the_retail_storefront_selected_category,
                'order'          => 'ASC'
            );
            $the_retail_storefront_loop = new WP_Query($the_retail_storefront_args);
            if ($the_retail_storefront_loop->have_posts()) : 
                while ($the_retail_storefront_loop->have_posts()) : $the_retail_storefront_loop->the_post();
                global $product;
        ?>
          <div class="col-lg-3 col-md-4 mb-5">
            <div class="product-box">
              <div class="product-image mb-2 position-relative">
                <?php echo woocommerce_get_product_thumbnail(); ?>
              </div>
              <div class="row">
                <div class="col-lg-9 col-md-9 col-9">
                  <div class="product-content text-start">
                    <div class="product-cat">
                      <?php 
                      // Display Product Categories
                      $the_retail_storefront_terms = get_the_terms(get_the_ID(), 'product_cat');
                      if ($the_retail_storefront_terms && !is_wp_error($the_retail_storefront_terms)) {
                        $the_retail_storefront_term_links = array();
                        foreach ($the_retail_storefront_terms as $term) {
                          $the_retail_storefront_term_links[] = '<a class="mt-2" href="' . esc_url(get_term_link($term)) . '">' . esc_html($term->name) . '</a>';
                        }
                        echo implode(', ', $the_retail_storefront_term_links);
                      }
                      ?>
                    </div>
                    <h3 class="my-1"><a href="<?php the_permalink(); ?>"><?php echo esc_html(get_the_title()); ?></a></h3>
                    
                    <p class="my-2 product-price" style="color: <?php echo $product->is_on_sale() ? 'black' : 'gray'; ?>">
                      <?php echo $product->get_price_html(); ?>
                    </p>

                    <div class="product-rating">
                      <?php
                      if ($product->get_rating_count()) {
                          woocommerce_template_loop_rating();
                      }
                      ?>
                    </div>
                  </div>
                </div>
                <div class="col-lg-3 col-md-3 col-3 d-flex align-items-end mb-lg-3">
                  <div class="cart-button">
                    <div class="cart-button">
                      <?php if ($product->is_type('simple')) { woocommerce_template_loop_add_to_cart(); } ?>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        <?php
                endwhile;
                wp_reset_postdata();
            endif;
        }
        ?>
      </div>
    <?php endif; ?>
  </div>
</section>
<?php endif; ?>