<section id="main-slider">
    <div class="container">
        <div class="row">

            <div class="col-lg-3 col-md-3 mb-2">
                <?php if(class_exists('woocommerce')){ ?>
                    <div class="category-btn"><i class="fa fa-bars" aria-hidden="true"></i><?php echo esc_html(get_theme_mod('the_retail_storefront_category_text','Top Best Category','the-retail-storefront')); ?></div>
                    <div class="category-dropdown">
                        <?php
                          $the_retail_storefront_args = array(
                            'number'     => get_theme_mod('the_retail_storefront_product_category_number','12'),
                            'orderby'    => 'title',
                            'order'      => 'ASC',
                            'hide_empty' => 0,
                            'parent'  => 0
                          );
                          $the_retail_storefront_product_categories = get_terms( 'product_cat', $the_retail_storefront_args );
                          $the_retail_storefront_count = count($the_retail_storefront_product_categories);
                          if ( $the_retail_storefront_count > 0 ){
                            foreach ( $the_retail_storefront_product_categories as $product_category ) {
                              $the_retail_storefront_cat_id   = $product_category->term_id;
                              $the_retail_storefront_cat_link = get_category_link( $the_retail_storefront_cat_id );
                              if ($product_category->category_parent == 0) { ?>
                            <li class="drp_dwn_menu"><a href="<?php echo esc_url(get_term_link( $product_category ) ); ?>">
                            <?php
                            }
                            echo esc_html( $product_category->name ); ?></a></li>
                            <?php
                            }
                          }
                        ?>
                    </div>
                <?php }?>
            </div>

            <div class="col-lg-9 col-md-9">
                <div class="row">
                    <div class="col-lg-8 col-md-8 mb-2">
                        <?php 
                        $the_retail_storefront_slider = get_theme_mod('the_retail_storefront_slider_setting', true);

                        if ($the_retail_storefront_slider == '1') :
                        ?>
                            <div id="slider">
                                <div id="owl-carousel" class="owl-carousel">
                                    <?php

                                    $the_retail_storefront_slide_pages = array();
                                    for ($the_retail_storefront_count = 1; $the_retail_storefront_count <= 3; $the_retail_storefront_count++) {
                                        $the_retail_storefront_mod = intval(get_theme_mod('the_retail_storefront_slider_page' . $the_retail_storefront_count));
                                        if ($the_retail_storefront_mod !== 0 && $the_retail_storefront_mod !== '') {
                                            $the_retail_storefront_slide_pages[] = $the_retail_storefront_mod;
                                        }
                                    }

                                    if (!empty($the_retail_storefront_slide_pages)) :
                                        $the_retail_storefront_args = array(
                                            'post_type' => 'page',
                                            'post__in' => $the_retail_storefront_slide_pages,
                                            'orderby' => 'post__in'
                                        );
                                        $the_retail_storefront_query = new WP_Query($the_retail_storefront_args);
                                        if ($the_retail_storefront_query->have_posts()) :
                                            while ($the_retail_storefront_query->have_posts()) : $the_retail_storefront_query->the_post(); ?>
                                                <div class="item">
                                                    <?php if (has_post_thumbnail()) { ?>
                                                        <img src="<?php echo esc_url(get_the_post_thumbnail_url(get_the_ID(), 'full')); ?>" alt="<?php echo esc_attr(get_the_title()); ?>" />
                                                    <?php } else { ?>
                                                        <div class="slider-color-box"></div>
                                                    <?php } ?>

                                                    <div class="container">
                                                        <div class="carousel-caption">
                                                            <div class="inner_carousel">
                                                                <?php if (get_theme_mod('the_retail_storefront_slider_short_heading') != '') { ?>
                                                                    <p class="slidetop-text mb-1"><?php echo esc_html(get_theme_mod('the_retail_storefront_slider_short_heading', '')); ?></p>
                                                                <?php } ?>
                                                                <h1 class="custom-title mb-2">
                                                                  <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                                                                </h1>
                                                                <p class="mb-2 slider-content"><?php echo esc_html(wp_trim_words(get_the_content(), 15)); ?></p>
                                                                <div class="more-btn mt-3">
                                                                    <?php 
                                                                    $the_retail_storefront_btn_text = get_theme_mod('the_retail_storefront_slider_btn_text', __('Shop Now', 'the-retail-storefront'));
                                                                    $the_retail_storefront_btn_link = get_theme_mod('the_retail_storefront_slider_btn_link');
                                                                    
                                                                    if ($the_retail_storefront_btn_text || $the_retail_storefront_btn_link) { ?>
                                                                        <a target="_blank" class="text-capitalize slider-btn1" href="<?php echo esc_url($the_retail_storefront_btn_link ? $the_retail_storefront_btn_link : get_permalink()); ?>">
                                                                            <i class="fas fa-cart-plus me-2"></i><?php echo esc_html($the_retail_storefront_btn_text); ?>
                                                                        </a>
                                                                    <?php } ?>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            <?php endwhile;
                                            wp_reset_postdata(); ?>
                                        <?php else : ?>
                                            <div class="no-postfound"></div>
                                        <?php endif;
                                    endif; ?>
                                </div>
                            </div>
                        <?php endif; ?>
                    </div>

                    <div class="col-lg-4 col-md-4 mb-2">
                        <div class="slide-banner">
                          <?php if( get_theme_mod( 'the_retail_storefront_discount_sale_img1') != '') { ?>
                            <div class="banner-1 mb-3">
                              <div class="product-img">
                                <img src="<?php echo esc_url(get_theme_mod('the_retail_storefront_discount_sale_img1')); ?>" alt="<?php echo esc_attr(get_theme_mod('the_retail_storefront_topproduct_title1', 'Product Image')); ?>" />
                                <div class="main-product-content first">
                                    <h2 class="discount-text my-1 text-capitalize"><a href="<?php the_permalink(); ?>"><?php echo esc_html(get_theme_mod('the_retail_storefront_product_sale_discount_title1')); ?></a></h2>
                                    <?php if(get_theme_mod('the_retail_storefront_topproduct_price') != ''){ ?>
                                        <p class="toppro-content"><span class="pro-price-text me-2"><?php esc_html_e('From:', 'the-retail-storefront'); ?></span><span class="price-text"><?php echo esc_html(get_theme_mod('the_retail_storefront_topproduct_price')); ?></span></p>
                                    <?php }?>
                                  <div class="product-btn mt-3" data-wow-duration="2s">
                                    <?php if(get_theme_mod('the_retail_storefront_product_btn_text1', 'Shop Now') != '' ){ ?>
                                      <a class="text-capitalize" href="<?php echo esc_url(get_theme_mod('the_retail_storefront_product_btn_link1')); ?>"><i class="fas fa-cart-plus me-2"></i><?php echo esc_html(get_theme_mod('the_retail_storefront_product_btn_text1','Shop Now')); ?><span class="screen-reader-text"><?php echo esc_html(get_theme_mod('the_retail_storefront_product_btn_text1')); ?></span></a>
                                    <?php }?>
                                  </div>
                                </div>
                              </div>
                            </div>
                          <?php } ?>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-3 col-md-6 align-self-center pe-md-0 mb-2">
                        <?php if (get_theme_mod('the_retail_storefront_add_support_heading') != '' || get_theme_mod('the_retail_storefront_add_support_details') != '') { ?>
                            <div class="main-delivery-detail">
                                <div class="delivery-icon">
                                    <i class="fas fa-headset"></i>
                                </div>
                                <div class="delivery-text ps-2">
                                    <div class="deliver-title"><?php echo esc_html(get_theme_mod('the_retail_storefront_add_support_heading', '')); ?></div>
                                    <div class="delivery-text"><?php echo esc_html(get_theme_mod('the_retail_storefront_add_support_details', '')); ?></div>
                                </div>
                            </div>
                        <?php } ?>
                    </div>
                    <div class="col-lg-3 col-md-6 align-self-center pe-md-0 mb-2">
                        <?php if (get_theme_mod('the_retail_storefront_add_payment_heading') != '' || get_theme_mod('the_retail_storefront_add_payment_details') != '') { ?>
                            <div class="main-delivery-detail">
                                <div class="delivery-icon">
                                    <i class="fas fa-eye"></i>
                                </div>
                                <div class="delivery-text ps-2">
                                    <div class="deliver-title"><?php echo esc_html(get_theme_mod('the_retail_storefront_add_payment_heading', '')); ?></div>
                                    <div class="delivery-text"><?php echo esc_html(get_theme_mod('the_retail_storefront_add_payment_details', '')); ?></div>
                                </div>
                            </div>
                        <?php } ?>
                    </div>
                    <div class="col-lg-3 col-md-6 align-self-center pe-md-0 mb-2">
                        <?php if (get_theme_mod('the_retail_storefront_add_shipping_heading') != '' || get_theme_mod('the_retail_storefront_add_shipping_details') != '') { ?>
                            <div class="main-delivery-detail">
                                <div class="delivery-icon">
                                    <i class="fas fa-truck"></i>
                                </div>
                                <div class="delivery-text ps-2">
                                    <div class="deliver-title"><?php echo esc_html(get_theme_mod('the_retail_storefront_add_shipping_heading', '')); ?></div>
                                    <div class="delivery-text"><?php echo esc_html(get_theme_mod('the_retail_storefront_add_shipping_details', '')); ?></div>
                                </div>
                            </div>
                        <?php } ?>
                    </div>
                    <div class="col-lg-3 col-md-6 align-self-center pe-lg-auto pe-md-0 mb-2">
                        <?php if (get_theme_mod('the_retail_storefront_add_return_heading') != '' || get_theme_mod('the_retail_storefront_add_return_details') != '') { ?>
                            <div class="main-delivery-detail">
                                <div class="delivery-icon">
                                    <i class="fas fa-shopping-bag"></i>
                                </div>
                                <div class="delivery-text ps-2">
                                    <div class="deliver-title"><?php echo esc_html(get_theme_mod('the_retail_storefront_add_return_heading', '')); ?></div>
                                    <div class="delivery-text"><?php echo esc_html(get_theme_mod('the_retail_storefront_add_return_details', '')); ?></div>
                                </div>
                            </div>
                        <?php } ?>
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>