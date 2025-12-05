<?php
/**
 * Template Name: Home Page
 */

get_header();
?>

<main id="primary">
    <div class="slider-bg">
       <div class="container">
            <div class="slider-divide">
            <?php 
            $wp_shop_woocommerce_main_slider_wrap = absint(get_theme_mod('wp_shop_woocommerce_enable_slider', 0));
            if($wp_shop_woocommerce_main_slider_wrap == 1){ 
            ?>
            <div class="slider-boxx">
                <section id="main-slider-wrap">
                    <div class="owl-carousel">
                        <?php for ($wp_shop_woocommerce_i=1; $wp_shop_woocommerce_i <= 3; $wp_shop_woocommerce_i++) { ?>
                          <?php  if (
                                get_theme_mod( 'wp_shop_woocommerce_slider_image'.$wp_shop_woocommerce_i ) != '' ||
                                get_theme_mod( 'wp_shop_woocommerce_slider_xtra_heading'.$wp_shop_woocommerce_i ) != '' ||
                                get_theme_mod( 'wp_shop_woocommerce_slider_heading'.$wp_shop_woocommerce_i ) != '' ||
                                get_theme_mod( 'wp_shop_woocommerce_slider_text'.$wp_shop_woocommerce_i ) != '' ||
                                get_theme_mod( 'wp_shop_woocommerce_slider_button1_link'.$wp_shop_woocommerce_i ) != '' ||
                                get_theme_mod( 'wp_shop_woocommerce_slider_button1_text'.$wp_shop_woocommerce_i ) != ''
                            ) {  ?>
                            <div class="main-slider-inner-box">
                                <?php if ( get_theme_mod('wp_shop_woocommerce_slider_image'.$wp_shop_woocommerce_i) ) : ?>
                                    <img src="<?php echo esc_url( get_theme_mod('wp_shop_woocommerce_slider_image'.$wp_shop_woocommerce_i) ); ?>">
                                    <div class="main-slider-content-box">
                                        <?php if ( get_theme_mod('wp_shop_woocommerce_slider_xtra_heading'.$wp_shop_woocommerce_i) ) : ?><p class="xtra-head"><?php echo esc_html( get_theme_mod('wp_shop_woocommerce_slider_xtra_heading'.$wp_shop_woocommerce_i) ); ?></p><?php endif; ?>
                                        <?php if ( get_theme_mod('wp_shop_woocommerce_slider_heading'.$wp_shop_woocommerce_i) ) : ?><h3><?php echo esc_html( get_theme_mod('wp_shop_woocommerce_slider_heading'.$wp_shop_woocommerce_i) ); ?></h3><?php endif; ?>
                                        <hr>
                                        <?php if ( get_theme_mod('wp_shop_woocommerce_slider_text'.$wp_shop_woocommerce_i) ) : ?><p class="slider-content"><?php echo esc_html( get_theme_mod('wp_shop_woocommerce_slider_text'.$wp_shop_woocommerce_i) ); ?></p><?php endif; ?>
                                        <div class="main-slider-button">
                                            <?php if ( get_theme_mod('wp_shop_woocommerce_slider_button1_link'.$wp_shop_woocommerce_i) ||  get_theme_mod('wp_shop_woocommerce_slider_button1_text'.$wp_shop_woocommerce_i )) : ?><a class="btn-1" href="<?php echo esc_url( get_theme_mod('wp_shop_woocommerce_slider_button1_link'.$wp_shop_woocommerce_i) ); ?>"><?php echo esc_html( get_theme_mod('wp_shop_woocommerce_slider_button1_text'.$wp_shop_woocommerce_i) ); ?></a><?php endif; ?>
                                        </div>
                                    </div>
                                <?php endif; ?>
                            </div>
                        <?php }?>
                        <?php } ?>
                    </div>
                </section>
            </div>
            <?php } ?>
            <div class="category-list">
              <?php if(class_exists('woocommerce')){ ?>
                <div class="categry-title">
                    <strong><i class="fa fa-bars" aria-hidden="true"></i><?php echo esc_html_e('ALL CATEGORIES','the-storefront-woocommerce'); ?></strong>
                </div>
                <div class="product-cat" id="style-2">
                  <?php
                    $wp_shop_woocommerce_args = array(                  
                      'orderby'    => 'title',
                      'order'      => 'ASC',
                      'hide_empty' => 0,
                      'parent'  => 0
                    );
                    $product_categories = get_terms( 'product_cat', $wp_shop_woocommerce_args );
                    $wp_shop_woocommerce_count = count($product_categories);
                    if ( $wp_shop_woocommerce_count > 0 ){
                        foreach ( $product_categories as $product_category ) {
                          $wp_shop_woocommerce_kids_cat_id   = $product_category->term_id;
                          $cat_link = get_category_link( $wp_shop_woocommerce_kids_cat_id );
                          if ($product_category->category_parent == 0) { ?>
                        <li class="drp_dwn_menu"><a href="<?php echo esc_url(get_term_link( $product_category ) ); ?>">
                        <?php
                      }
                        echo esc_html( $product_category->name ); ?></a><i class="fas fa-caret-right"></i></li>
                        <?php
                        }
                      }
                  ?>
                </div>
              <?php }?> 
            </div>
        </div>
    </div>  
    </div> 
    <?php 
    $wp_shop_woocommerce_main_expert_wrap = absint(get_theme_mod('wp_shop_woocommerce_enable_product', 0));
    if($wp_shop_woocommerce_main_expert_wrap == 1){ 
    ?>
    <section id="product-sec" class="product-section">
        <div class="container">
            <div class="product-divide">
                <div class="product-blog">
                   <div class="top-expert-wrap">   
                        <?php 
                // Check if WooCommerce is active
                if (class_exists('WooCommerce')) {
                    $args = array( 
                        'post_type' => 'product',
                        'product_cat' => esc_html(get_theme_mod('the_storefront_woocommerce_product_category','product_cat1')), // Escaped for security
                        'order' => 'ASC',
                        'posts_per_page' => -1,
                    );
                    $loop = new WP_Query($args);
                    
                    // Check if there are products
                    if ($loop->have_posts()) : 
                ?>
                    <div class="owl-carousel one-product-carousel">
                        <?php 
                        // Start the loop to display products
                        while ($loop->have_posts()) : $loop->the_post(); 
                            global $product;

                            // Calculate the sale percentage if applicable
                            $the_storefront_woocommerce_regular_price = (float) $product->get_regular_price();
                            $the_storefront_woocommerce_sale_price = (float) $product->get_sale_price();
                            $the_storefront_woocommerce_discount_percentage = ($the_storefront_woocommerce_regular_price > 0 && $the_storefront_woocommerce_sale_price > 0) 
                                ? round((($the_storefront_woocommerce_regular_price - $the_storefront_woocommerce_sale_price) / $the_storefront_woocommerce_regular_price) * 100) 
                                : 0;
                        ?>
                            <div class="product-box">  
                                <div class="product-box-content-one">
                                    <!-- Product Image with Content -->
                                    <div class="product-image-wrapper">
                                        <div class="product-image-one">
                                            <?php 
                                            if (has_post_thumbnail()) {
                                                the_post_thumbnail('shop_catalog');
                                            } else {
                                                echo '<img src="' . esc_url(wc_placeholder_img_src()) . '" alt="' . esc_attr__('Placeholder', 'the-storefront-woocommerce') . '" />';
                                            }
                                            ?>
                                        </div>
                                        <div class="content-over-image">
                                            <!-- Sale Tag -->
                                            <?php if ($product->is_on_sale()) : ?>
                                                <div class="sale-tag">
                                                    <?php 
                                                    if ($product->is_on_sale()) {
                                                        echo esc_html__('Sale', 'the-storefront-woocommerce'); 
                                                    }
                                                    ?>
                                                </div>

                                                <div class="sale-percentage">
                                                    <?php echo esc_html__('UP TO ', 'the-storefront-woocommerce') . esc_html($the_storefront_woocommerce_discount_percentage) . esc_html__('% OFF', 'the-storefront-woocommerce'); ?>
                                                </div>
                                            <?php endif; ?>
                                            <!-- Product Title -->
                                            <h2 class="product-heading-text">
                                                <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                                            </h2>

                                            <!-- Product Price -->
                                            <p class="product-price d-flex <?php echo esc_attr(apply_filters('woocommerce_product_price_class', 'price')); ?>">
                                                <?php echo wp_kses_post($product->get_price_html()); ?>
                                            </p>

                                            <div class="main-shop-now">
                                            <!-- Show Now Button -->
                                                <a href="<?php echo esc_url(wc_get_cart_url()); ?>" class="button show-now">
                                                    <?php esc_html_e('Show Now', 'the-storefront-woocommerce'); ?>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div> 
                        <?php 
                        endwhile; 
                        wp_reset_postdata(); 
                        ?>
                    </div>
                <?php 
                    endif; 
                } 
                ?>
                    </div> 
                </div>
                 <div class="product-list">
                    <div class="heading-expert-wrap">
                        <?php if ( get_theme_mod('wp_shop_woocommerce_event_heading') ) : ?><h5><?php echo esc_html( get_theme_mod('wp_shop_woocommerce_event_heading') ); ?></h5>
                    <hr><?php endif; ?>
                    </div>
                    <div class="product-carousel owl-carousel owl-theme">
                      <?php 
                      if ( class_exists( 'WooCommerce' ) ) {
                          $args = array( 
                            'post_type' => 'product',
                            'posts_per_page' => 12, // multiple of 6
                            'orderby' => 'date',
                            'order'   => 'DESC'
                          );
                          $loop = new WP_Query( $args );

                          $count = 0;
                          echo '<div class="item"><div class="grid-box">';
                          while ( $loop->have_posts() ) : $loop->the_post(); global $product;
                              ?>
                              <div class="product-box">  
                                <div class="product-image">
                                  <?php 
                                    if ( has_post_thumbnail() ) {
                                        echo get_the_post_thumbnail( get_the_ID(), 'shop_catalog' );
                                    } else {
                                        echo '<img src="' . esc_url(woocommerce_placeholder_img_src()) . '" alt="Placeholder" />';
                                    }
                                  ?>
                                </div>
                                <div class="product-detail">
                                  <h6 class="product-heading-text"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h6>
                                  <p class="product-rating"><?php echo $product->get_price_html(); ?></p>
                                </div>
                              </div>
                              <?php
                              $count++;
                              if($count % 6 == 0 && $count < $loop->post_count){
                                  echo '</div></div><div class="item"><div class="grid-box">';
                              }
                          endwhile;
                          echo '</div></div>';
                          wp_reset_postdata();
                      }
                      ?>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <?php } ?>
</main>

<?php
get_footer();