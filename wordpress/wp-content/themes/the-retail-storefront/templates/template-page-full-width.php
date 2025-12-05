<?php 
/**
	Template Name: Page Full Width
*/

get_header(); ?>

<section id="post-section" class="blog-area inarea-blog-2-column-area three">
	<div class="container">
		<div class="row row-cols-1 gy-5">
			<div class="col">
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
		</div>
	</div>
</section>
	
<?php get_footer(); ?>