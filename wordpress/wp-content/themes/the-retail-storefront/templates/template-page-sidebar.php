<?php 
/**
	Template Name: Page with Sidebar
*/

get_header(); ?>

<section id="post-section" class="blog-area inarea-blog-2-column-area three">
	<div class="container">
		<div class="row row-cols-1 gy-5">
		<?php 
                $the_retail_storefront_single_page_sidebar_setting = get_theme_mod('the_retail_storefront_single_page_sidebar_setting','1');
                $the_retail_storefront_sidebar_position = get_theme_mod('the_retail_storefront_sidebar_position', 'right');
                $the_retail_storefront_content_class = ($the_retail_storefront_single_page_sidebar_setting == '') ? 'col-lg-12' : 'col-lg-8';

				// Set classes for left or right sidebar
	            $the_retail_storefront_content_order_class = ($the_retail_storefront_sidebar_position == 'left') ? 'order-lg-2' : '';
	            $the_retail_storefront_sidebar_order_class = ($the_retail_storefront_sidebar_position == 'left') ? 'order-lg-1' : '';
            ?>
            <div class="<?php echo esc_attr($the_retail_storefront_content_class . ' ' . $the_retail_storefront_content_order_class); ?>">
				<?php the_post(); ?>
				<article class="post-items">
					<div class="post-content">
						<?php
							the_content();
						?>
					</div>
				</article>
				<?php
					if( $post->comment_status == 'open' ) { 
						comments_template( '', true ); // show comments 
					}
				?>
			</div>
            <?php if( $the_retail_storefront_single_page_sidebar_setting != '') { ?> 
                <?php get_sidebar(); ?>
            <?php } ?>
		</div>
	</div>
</section>
	
<?php get_footer(); ?>