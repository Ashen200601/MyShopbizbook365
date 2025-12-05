<header class="main-header">
	<div class="headerbox">
	    <div class="header-main">
        	<div class="top-main py-2">
        		<div class="container">
	                <div class="row m-0">
	                	<div class="col-lg-2 col-md-3 align-self-center">
	                	</div>
	                	<div class="langauge-box col-lg-2 offset-lg-0 offset-md-3 col-md-9 text-md-start text-center align-self-center d-flex align-items-center">
		                    <span class="currency mb-lg-0 mb-2 me-md-2">
		                        <?php if (get_theme_mod('the_retail_storefront_currency_switcher', true) && class_exists('woocommerce')) : ?>
		                            <div class="currency-box d-md-inline-block">
		                                <?php echo do_shortcode('[woocs]'); ?>
		                            </div>
		                        <?php endif; ?>
		                    </span>
		                    <span class="translate-btn mb-lg-0 mb-2 d-flex">
		                        <?php if (get_theme_mod('the_retail_storefront_cart_language_translator', true) && class_exists('GTranslate')) : ?>
		                            <div class="translate-lang position-relative d-md-inline-block">
		                                <?php echo do_shortcode('[gtranslate]'); ?>
		                            </div>
		                        <?php endif; ?>
		                    </span>
		                </div>
		                <div class="col-lg-5 offset-lg-0 offset-md-3 col-md-9 align-self-center">
		                	<?php 
		                    $the_retail_storefront_topbar_text = get_theme_mod('the_retail_storefront_topbar_text', 'Welcome to Storefront. We provides best E-Commerce products');
		                    if (!empty($the_retail_storefront_topbar_text)) { ?>
		                        <p class="text-center topbar-top-text my-2 my-lg-0"><?php echo esc_html(sanitize_text_field($the_retail_storefront_topbar_text)); ?></p>
		                    <?php } ?>
		                </div>
	                    <div class="col-lg-3 offset-lg-0 offset-md-3 col-md-9 align-self-center top-contact">
	                        <div class="contact">
	                            <?php if (get_theme_mod('the_retail_storefront_call','1800 1200 110')) : ?>
	                                <p class="my-md-0 my-2 phone">
	                                    <a href="tel:<?php echo esc_html(get_theme_mod('the_retail_storefront_call','1800 1200 110')); ?>"><i class="fas fa-phone-alt me-2"></i><?php echo esc_html(get_theme_mod('the_retail_storefront_call','1800 1200 110')); ?>
	                                    </a>
	                                </p>
	                            <?php endif; ?>
	                            <?php if( get_theme_mod( 'the_retail_storefront_mail','info@example.com') != '') { ?>
			                        <p class="mb-md-0 mb-2 email ps-md-3"><a href="mailto:<?php echo esc_html( get_theme_mod('the_retail_storefront_mail','info@example.com') ); ?>"><i class="fas fa-envelope-open me-2"></i><?php echo esc_html( get_theme_mod('the_retail_storefront_mail','info@example.com')); ?></a></p>
			                    <?php } ?>
	                        </div>
	                    </div>
	                </div>
	            </div>
            </div>
	        
	        <div class="container">
	            <div class="row menu-box-col py-md-3">
	            	<div class="col-lg-2 col-md-3">
	            		<div class="logo-col">
			                <div class="logo">
							<?php 
								if (has_custom_logo()) {
									the_custom_logo();
								} else {
									// Check if both title and tagline settings are disabled
									$the_retail_storefront_tagline_enabled = get_theme_mod('the_retail_storefront_tagline_setting', false);
									$the_retail_storefront_title_enabled = get_theme_mod('the_retail_storefront_site_title_setting', true);

									if (!$the_retail_storefront_tagline_enabled && !$the_retail_storefront_title_enabled) {
										// Display the default logo
										$the_retail_storefront_default_logo_url = get_template_directory_uri() . '/assets/images/logo.png'; // Replace with your default logo path
										echo '<a href="' . esc_url(home_url('/')) . '">';
										echo '<img src="' . esc_url($the_retail_storefront_default_logo_url) . '" alt="' . esc_attr(get_bloginfo('name')) . '">';
										echo '</a>';
									}

									// Display tagline if the setting is enabled
									if ($the_retail_storefront_tagline_enabled) :
										$the_retail_storefront_site_desc = get_bloginfo('description'); ?>
										<p class="site-description"><?php echo esc_html($the_retail_storefront_site_desc); ?></p>
									<?php endif; ?>

									<?php
									// Display site title if the setting is enabled
									if ($the_retail_storefront_title_enabled) : ?>
										<p class="site-title">
											<a href="<?php echo esc_url(home_url('/')); ?>">
												<?php echo esc_html(get_bloginfo('name')); ?>
											</a>
										</p>
									<?php endif; ?>
								<?php } ?>
							</div>
						</div>
		            </div>
	                <div class="col-lg-5 col-md-1 align-self-center d-flex justify-content-center main-menu-box mb-md-0 mb-2">
	                    <div class="menubox <?php if( get_theme_mod( 'the_retail_storefront_sticky_header', '0')) { ?>sticky-header<?php } else { ?>close-sticky<?php } ?>">
                            <!-- Main menu -->
							<div class="navbar-menubar responsive-menu navigation_header">
								<div class="toggle-nav mobile-menu">
									<button onclick="the_retail_storefront_openNav()">
										<i class="fa-solid fa-bars"></i> <!-- Initial hamburger icon -->
									</button>
								</div>
								<div id="mySidenav" class="nav sidenav">
									<nav id="site-navigation" class="main-navigation navbar navbar-expand-xl" aria-label="<?php esc_attr_e( 'Top Menu', 'the-retail-storefront' ); ?>">

										<?php 
											wp_nav_menu(
												array(
													'theme_location' => 'primary',
													'container_class' => 'main-menu clearfix',
													'menu_class' => 'clearfix menu',
													'items_wrap' => '<ul id="%1$s" class="%2$s mobile_nav">%3$s</ul>',
													'fallback_cb' => 'wp_page_menu',
												)
											);
										?>
										<a href="javascript:void(0)" class="closebtn mobile-menu" onclick="the_retail_storefront_closeNav()">
											<i class="fa-solid fa-times"></i> <!-- Close icon for the menu -->
										</a>
									</nav>
								</div>
							</div>
                        </div>
	                </div>
	                <div class="col-lg-3 col-md-6 align-self-center d-flex justify-content-center mb-md-0 mb-2">
	                	<div class="bottom-center main-search">
	                        <?php if (class_exists('WooCommerce')): ?> 
	                            <div class="product-search">
	                                <form method="get" class="woocommerce-product-search" action="<?php echo esc_url(home_url('/')); ?>">
	                                    <label for="product-search-field" class="screen-reader-text"><?php esc_html_e('Search for:', 'the-retail-storefront'); ?></label>
	                                    <input type="search" id="product-search-field" class="search-field" placeholder="<?php esc_attr_e('Search Here', 'the-retail-storefront'); ?>" value="<?php echo esc_attr(get_search_query()); ?>" name="s" />
	                                    <input type="hidden" name="post_type" value="product" />
	                                    <button type="submit">
	                                        <span class="search-icon" aria-hidden="true"><i class="fas fa-search"></i></span>
	                                        <span class="screen-reader-text"><?php esc_html_e('Search', 'the-retail-storefront'); ?></span>
	                                    </button>
	                                </form>
	                            </div>
	                        <?php endif; ?>
	                    </div>
	                </div>
	                <div class="col-lg-2 col-md-2 col-12 align-self-center">
	                    <div class="header-details my-3 my-md-0 d-flex align-items-center justify-content-md-end justify-content-center">

	                        <?php if (class_exists('woocommerce')) : ?> 
		                        <p class="mb-0">
		                            <span class="product-cart text-center position-relative">
		                                <a href="<?php echo esc_url(wc_get_cart_url()); ?>" title="<?php esc_attr_e('Shopping cart', 'the-retail-storefront'); ?>">
		                                    <i class="fas fa-shopping-bag me-2"></i>
		                                    <?php 
		                                $the_retail_storefront_cart_count = WC()->cart->get_cart_contents_count(); 
		                                if ($the_retail_storefront_cart_count > 0): ?>
		                                    <span class="cart-count"><?php echo esc_html($the_retail_storefront_cart_count); ?></span>
		                                <?php endif; ?>
		                                </a>
		                            </span>
		                        </p>
		                    <?php endif; ?>

	                        <?php if (class_exists('woocommerce')) : ?>
	                            <?php if (get_theme_mod('the_retail_storefront_like_option') != '') : ?>
	                                <p class="mb-0">
	                                    <a href="<?php echo esc_url(get_theme_mod('the_retail_storefront_like_option')); ?>" aria-label="<?php esc_attr_e('Wishlist', 'the-retail-storefront'); ?>">
	                                        <i class="far fa-heart"></i>
	                                    </a>
	                                </p>
	                            <?php endif; ?>

	                            <?php if (class_exists('YITH_WCWL')) : ?>
	                                <p class="mb-0">
	                                    <a href="<?php echo esc_url(YITH_WCWL()->get_wishlist_url()); ?>" aria-label="<?php esc_attr_e('Wishlist', 'the-retail-storefront'); ?>">
	                                        <i class="fas fa-heart"></i>
	                                    </a>
	                                </p>
	                            <?php endif; ?>
	                        <?php endif; ?>

	                        <p class="mb-0">
	                            <?php if (class_exists('woocommerce')) : ?>
	                                <?php if (is_user_logged_in()) : ?>
	                                    <a href="<?php echo esc_url(get_permalink(get_option('woocommerce_myaccount_page_id'))); ?>" aria-label="<?php esc_attr_e('My Account', 'the-retail-storefront'); ?>">
	                                        <i class="fas fa-user"></i>
	                                    </a>
	                                <?php else : ?>
	                                    <a href="<?php echo esc_url(get_permalink(get_option('woocommerce_myaccount_page_id'))); ?>" aria-label="<?php esc_attr_e('My Account', 'the-retail-storefront'); ?>">
	                                        <i class="far fa-user"></i>
	                                    </a>
	                                <?php endif; ?>
	                            <?php endif; ?>
	                        </p>

	            		</div>
	                </div>
	            </div>
	        </div>
	    </div>
	</div>
</header>