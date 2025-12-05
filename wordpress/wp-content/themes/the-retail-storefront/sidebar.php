<?php if ( is_active_sidebar('the-retail-storefront-sidebar-primary')) : ?>
 	<div class="col-lg-4">
		<div class="sidebar">
			<?php dynamic_sidebar('the-retail-storefront-sidebar-primary'); ?>
		</div>
	</div>
<?php else : ?>
	<!-- Add your else code here -->
	<div class="col-lg-4">
	    <div class="sidebar">
	    	 <!-- Add your search widget code here -->
		    <div class="widget">
		        <h4 class="widget-title mb-3"><?php echo esc_html('Search', 'the-retail-storefront'); ?></h4>
		        <?php get_search_form(); ?>
		    </div>
		    <!-- Add your archive widget code here -->
            <div class="widget">
                <h4 class="widget-title"><?php echo esc_html('Archives', 'the-retail-storefront'); ?></h4>
                <ul>
                    <?php wp_get_archives(); ?>
                </ul>
            </div>
            <!-- Add your Categories widget code here -->
	    	<div class="widget">
			    <h4 class="widget-title "><?php echo esc_html('Categories List' , 'the-retail-storefront'); ?> </h4>
				<ul>
					<?php wp_list_categories(array(
						'title_li' => ''
					)); ?>
				</ul>
		    </div>
		    <!-- Add your recent posts widget code here -->
            <div class="widget">
                <h4 class="widget-title"><?php echo esc_html('Recent Posts', 'the-retail-storefront'); ?></h4>
                <ul>
                    <?php
                    $the_retail_storefront_recent_posts = wp_get_recent_posts(array('numberposts' => 5));
                    foreach ($the_retail_storefront_recent_posts as $post) :
                        ?>
                        <li>
                            <a href="<?php echo get_permalink($post['ID']); ?>"><?php echo esc_html($post['post_title']); ?></a>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>
		</div>
	</div>
<?php endif; ?>