<?php
/**
 * The main template file
 *
 * @package WP Shop Woocommerce
 */

get_header();
?>

<?php
$wp_shop_woocommerce_archive_layout = get_theme_mod( 'wp_shop_woocommerce_archive_layout', 'layout-1' ); 
?> 

<div class="container">
	<?php if ( $wp_shop_woocommerce_archive_layout == 'layout-1' ) { ?>
		<div class="main-wrapper">
			<main id="primary" class="site-main ct-post-wrapper lay-width">
				<?php
				if ( have_posts() ) :

					if ( is_home() && ! is_front_page() ) :
						?>
						<header>
							<h1 class="page-title screen-reader-text"><?php single_post_title(); ?></h1>
						</header>
						<?php
					endif;

					/* Start the Loop */
					while ( have_posts() ) :
						the_post();
						
						get_template_part( 'revolution/template-parts/content', get_post_format() );

					endwhile;

					?><?php
					$wp_shop_woocommerce_pagination_wrap = absint(get_theme_mod('wp_shop_woocommerce_enable_pagination', 1));
					$pagination_type = get_theme_mod('wp_shop_woocommerce_pagination_type', 'type-1');

					if ($wp_shop_woocommerce_pagination_wrap == 1) {
						if ($pagination_type == 'type-1') {
							the_posts_pagination();
						} elseif ($pagination_type == 'type-2') {
							the_posts_navigation();
						}
					}
				?><?php

				else :

					get_template_part( 'revolution/template-parts/content', 'none' );

				endif;
				?>
			</main>
			<?php get_sidebar(); ?>
		</div>
	<?php 
	} elseif ( $wp_shop_woocommerce_archive_layout == 'layout-2' ) { ?>
		<div class="main-wrapper">
			<?php get_sidebar(); ?>
			<main id="primary" class="site-main ct-post-wrapper lay-width">
				<?php
				if ( have_posts() ) :

					if ( is_home() && ! is_front_page() ) :
						?>
						<header>
							<h1 class="page-title screen-reader-text"><?php single_post_title(); ?></h1>
						</header>
						<?php
					endif;

					/* Start the Loop */
					while ( have_posts() ) :
						the_post();
						
						get_template_part( 'revolution/template-parts/content', get_post_format() );

					endwhile;

					?><?php
					$wp_shop_woocommerce_pagination_wrap = absint(get_theme_mod('wp_shop_woocommerce_enable_pagination', 1));
					$pagination_type = get_theme_mod('wp_shop_woocommerce_pagination_type', 'type-1');

					if ($wp_shop_woocommerce_pagination_wrap == 1) {
						if ($pagination_type == 'type-1') {
							the_posts_pagination();
						} elseif ($pagination_type == 'type-2') {
							the_posts_navigation();
						}
					}
				?><?php

				else :

					get_template_part( 'revolution/template-parts/content', 'none' );

				endif;
				?>
			</main>
		</div>
	<?php 
	} elseif ( $wp_shop_woocommerce_archive_layout == 'layout-3' ) { // No-sidebar layout ?>
		<div class="main-wrapper full-width">
			<main id="primary" class="site-main ct-post-wrapper lay-width">
				<?php
				if ( have_posts() ) :

					if ( is_home() && ! is_front_page() ) :
						?>
						<header>
							<h1 class="page-title screen-reader-text"><?php single_post_title(); ?></h1>
						</header>
						<?php
					endif;

					/* Start the Loop */
					while ( have_posts() ) :
						the_post();
						
						get_template_part( 'revolution/template-parts/content', get_post_format() );

					endwhile;

					?><?php
					$wp_shop_woocommerce_pagination_wrap = absint(get_theme_mod('wp_shop_woocommerce_enable_pagination', 1));
					$pagination_type = get_theme_mod('wp_shop_woocommerce_pagination_type', 'type-1');

					if ($wp_shop_woocommerce_pagination_wrap == 1) {
						if ($pagination_type == 'type-1') {
							the_posts_pagination();
						} elseif ($pagination_type == 'type-2') {
							the_posts_navigation();
						}
					}
				?><?php

				else :

					get_template_part( 'revolution/template-parts/content', 'none' );

				endif;
				?>
			</main>
		</div>
	<?php } ?>
</div>

<?php get_footer(); ?>
