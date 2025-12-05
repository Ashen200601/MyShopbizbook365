</div>
<?php
    $the_retail_storefront_footer_bg_color = get_theme_mod('the_retail_storefront_footer_bg_color');
    $the_retail_storefront_footer_bg_image = get_theme_mod('the_retail_storefront_footer_bg_image');
    $the_retail_storefront_footer_opacity = get_theme_mod('the_retail_storefront_footer_bg_image_opacity', 50);
    $the_retail_storefront_opacity_decimal = $the_retail_storefront_footer_opacity / 100;

    // Compose inline styles for footer background
    $the_retail_storefront_footer_styles = 'background-color: ' . esc_attr($the_retail_storefront_footer_bg_color) . ';';
    if ($the_retail_storefront_footer_bg_image) {
        $the_retail_storefront_footer_styles .= ' background-image: linear-gradient(rgba(0,0,0,' . (1 - $the_retail_storefront_opacity_decimal) . '), rgba(0,0,0,' . (1 - $the_retail_storefront_opacity_decimal) . ')), url(' . esc_url($the_retail_storefront_footer_bg_image) . ');';
    }
?>
<footer class="footer-area" style="<?php echo esc_attr($the_retail_storefront_footer_styles); ?>">  
	<div class="container"> 
		<?php 
		$the_retail_storefront_footer_widgets_setting = get_theme_mod('the_retail_storefront_footer_widgets_setting', '1');

		do_action('the_retail_storefront_footer_above'); 
		
		if ($the_retail_storefront_footer_widgets_setting != '') { 
			if (is_active_sidebar('the-retail-storefront-footer-widget-area')) { ?>
				<div class="row footer-row"> 
					<?php dynamic_sidebar('the-retail-storefront-footer-widget-area'); ?>
				</div>  
			<?php 
			} else { ?>
				<div class="row footer-row">
					<div class="footer-widget col-lg-3 col-sm-6 wow fadeIn" data-wow-delay="0.2s">
						<aside id="search-3" class="widget widget_search default_footer_search">
							<h2 class="widget-title w-title"><?php esc_html_e('Search', 'the-retail-storefront'); ?></h2>
							<?php get_search_form(); ?>
						</aside>
					</div>
					<div class="footer-widget col-lg-3 col-sm-6 wow fadeIn" data-wow-delay="0.2s">
						<aside id="archives-2" class="widget widget_archive">
							<h2 class="widget-title w-title"><?php esc_html_e('Recent Posts', 'the-retail-storefront'); ?></h2>
							<ul>
								<?php
								wp_get_archives(array(
									'type' => 'postbypost',
									'format' => 'html',
									'limit' => 5,
								));
								?>
							</ul>
						</aside>
					</div>
					<div class="footer-widget col-lg-3 col-sm-6 wow fadeIn" data-wow-delay="0.2s">
						<aside id="pages-2" class="widget widget_pages">
							<h2 class="widget-title w-title"><?php esc_html_e('Pages', 'the-retail-storefront'); ?></h2>
							<ul>
								<?php
								wp_list_pages(array(
									'title_li' => '',
									'number'  => 5,
								));
								?>
							</ul>
						</aside>
					</div>
					<div class="footer-widget col-lg-3 col-sm-6 wow fadeIn" data-wow-delay="0.2s">
						<aside id="categories-2" class="widget widget_categories">
							<h2 class="widget-title w-title"><?php esc_html_e('Categories', 'the-retail-storefront'); ?></h2>
							<ul>
								<?php
								wp_list_categories(array(
									'title_li' => '',
									'number'  => 5,
								));
								?>
							</ul>
						</aside>
					</div>
				</div>
			<?php } 
		} ?>
	</div>
	
	<?php 
		$the_retail_storefront_footer_copyright = get_theme_mod('the_retail_storefront_footer_copyright','');
	?>
	<?php $the_retail_storefront_footer_copyright_setting = get_theme_mod('the_retail_storefront_footer_copyright_setting','1');
	 if( $the_retail_storefront_footer_copyright_setting != ''){?> 
	<div class="copy-right"> 
		<div class="container">
			<p class="copyright-text">
				<?php
					echo esc_html( apply_filters('the_retail_storefront_footer_copyright',($the_retail_storefront_footer_copyright)));
			    ?>
				<?php if (empty($the_retail_storefront_footer_copyright)) { ?>
				    <?php echo esc_html__('Copyright &copy; 2025,', 'the-retail-storefront'); ?>
				    <a href="<?php echo esc_url('https://www.seothemesexpert.com/products/free-storefront-wordpress-theme'); ?>" target="_blank"><?php echo esc_html__('The Retail Storefront', 'the-retail-storefront'); ?></a>
				    <span> | </span>
				    <a href="<?php echo esc_url('https://wordpress.org/'); ?>" target="_blank">
				        <?php echo esc_html__('WordPress Theme', 'the-retail-storefront'); ?>
				    </a>
				<?php } ?>
			</p>
		</div>
	</div>
	<?php }?>
	<?php $the_retail_storefront_scroll_top = get_theme_mod('the_retail_storefront_scroll_top_setting','1');
      if($the_retail_storefront_scroll_top == '1') { ?>
		<a id="scrolltop"><span><?php echo esc_html('TOP', 'the-retail-storefront'); ?></span></a>
	<?php } ?>
</footer>
</div>
<?php wp_footer(); ?>
</body>
</html>
