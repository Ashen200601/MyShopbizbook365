<?php
/**
 * The template for displaying archive pages.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package The Retail Storefront
 */

$the_retail_storefront_show_hide_related_post = get_theme_mod('the_retail_storefront_show_hide_related_post', '1');

get_header();
?>
<section class="blog-area inarea-blog-single-page-two">
	<div class="container">
		<div class="row">
            <?php 
                $the_retail_storefront_single_post_sidebar_setting = get_theme_mod('the_retail_storefront_single_post_sidebar_setting','1');
                $the_retail_storefront_sidebar_position = get_theme_mod('the_retail_storefront_sidebar_position', 'right');
                $the_retail_storefront_content_class = ($the_retail_storefront_single_post_sidebar_setting == '') ? 'col-lg-12' : 'col-lg-8';

                // Set classes for left or right sidebar
	            $the_retail_storefront_content_order_class = ($the_retail_storefront_sidebar_position == 'left') ? 'order-lg-2' : '';
	            $the_retail_storefront_sidebar_order_class = ($the_retail_storefront_sidebar_position == 'left') ? 'order-lg-1' : '';
            ?>
            <div class="<?php echo esc_attr($the_retail_storefront_content_class . ' ' . $the_retail_storefront_content_order_class); ?>">
				<div class="singel-page-area">
					<?php if( have_posts() ): ?>
						<?php while( have_posts() ): the_post(); ?>
							<?php get_template_part('template-parts/content/content-post', get_post_format() ); ?>
						<?php endwhile; ?>
					<?php endif; ?>

					<?php comments_template( '', true ); // show comments  ?>

					<?php if ($the_retail_storefront_show_hide_related_post == '1') : ?>
						<?php get_template_part('template-parts/content/related-posts'); ?>
					<?php endif; ?>

				</div>
			</div>
			<?php if( $the_retail_storefront_single_post_sidebar_setting != '') { ?> 
                <?php get_sidebar(); ?>
            <?php } ?>
		</div>
	</div>
</section>
<?php get_footer(); ?>