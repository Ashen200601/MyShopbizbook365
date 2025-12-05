<?php
/**
 * Custom template tags for this theme.
 *
 * Eventually, some of the functionality here could be replaced by core features.
 *
 * @package The Retail Storefront
 */

if ( ! function_exists( 'the_retail_storefront_posted_on' ) ) :
/**
 * Prints HTML with meta information for the current post-date/time and author.
 */
function the_retail_storefront_posted_on() {
	$the_retail_storefront_time_string = '<time class="entry-date published updated" datetime="%1$s">%2$s</time>';
	if ( get_the_time( 'U' ) !== get_the_modified_time( 'U' ) ) {
		$the_retail_storefront_time_string = '<time class="entry-date published" datetime="%1$s">%2$s</time><time class="updated" datetime="%3$s">%4$s</time>';
	}

	$the_retail_storefront_time_string = sprintf( $the_retail_storefront_time_string,
		esc_attr( get_the_date( 'c' ) ),
		esc_html( get_the_date() ),
		esc_attr( get_the_modified_date( 'c' ) ),
		esc_html( get_the_modified_date() )
	);

	$the_retail_storefront_posted_on = sprintf(
		/* translators: %s: Date. */
		esc_html_x( 'Posted on %s', 'post date', 'the-retail-storefront' ),
		'<a href="' . esc_url( get_permalink() ) . '" rel="bookmark">' . $the_retail_storefront_time_string . '</a>'
	);

	$the_retail_storefront_byline = sprintf(
		/* translators: %s: by. */
		esc_html_x( 'by %s', 'post author', 'the-retail-storefront' ),
		'<span class="author vcard"><a class="url fn n" href="' . esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ) . '">' . esc_html( get_the_author() ) . '</a></span>'
	);
	echo '<span class="posted-on">' . $the_retail_storefront_posted_on . '</span><span class="byline"> ' . $the_retail_storefront_byline . '</span>'; // WPCS: XSS OK.
}
endif;


if ( ! function_exists( 'the_retail_storefront_entry_footer' ) ) :
/**
 * Prints HTML with meta information for the categories, tags and comments.
 */
function the_retail_storefront_entry_footer() {
	// Hide category and tag text for pages.
	if ( 'post' === get_post_type() ) {
		/* translators: used between list items, there is a space after the comma */
		$the_retail_storefront_categories_list = get_the_category_list( esc_html__( ', ', 'the-retail-storefront' ) );
		if ( $the_retail_storefront_categories_list && the_retail_storefront_categorized_blog() ) {
			/* translators: %1$s: Posted. */
			printf( '<span class="cat-links">' . esc_html__( 'Posted in %1$s', 'the-retail-storefront' ) . '</span>', $the_retail_storefront_categories_list ); // WPCS: XSS OK.
		}

		/* translators: used between list items, there is a space after the comma */
		$the_retail_storefront_tags_list = get_the_tag_list( '', esc_html__( ', ', 'the-retail-storefront' ) );
		if ( $the_retail_storefront_tags_list ) {
			/* translators: %1$s: Tagged. */
			printf( '<span class="tags-links">' . esc_html__( 'Tagged %1$s', 'the-retail-storefront' ) . '</span>', $the_retail_storefront_tags_list ); // WPCS: XSS OK.
		}
	}

	if ( ! is_single() && ! post_password_required() && ( comments_open() || get_comments_number() ) ) {
		echo '<span class="comments-link">';
		/* translators: %s: post title */
		comments_popup_link( sprintf( wp_kses( __( 'Leave a Comment<span class="screen-reader-text"> on %s</span>', 'the-retail-storefront' ), array( 'span' => array( 'class' => array() ) ) ), get_the_title() ) );
		echo '</span>';
	}

	edit_post_link(
		sprintf(
			/* translators: %s: Name of current post */
			esc_html__( 'Edit %s', 'the-retail-storefront' ),
			the_title( '<span class="screen-reader-text">"', '"</span>', false )
		),
		'<span class="edit-link">',
		'</span>'
	);
}
endif;

/**
 * Returns true if a blog has more than 1 category.
 *
 * @return bool
 */
function the_retail_storefront_categorized_blog() {
	if ( false === ( $the_retail_storefront_all_the_cool_cats = get_transient( 'the_retail_storefront_categories' ) ) ) {
		// Create an array of all the categories that are attached to posts.
		$the_retail_storefront_all_the_cool_cats = get_categories( array(
			'fields'     => 'ids',
			'hide_empty' => 1,
			// We only need to know if there is more than one category.
			'number'     => 2,
		) );

		// Count the number of categories that are attached to the posts.
		$the_retail_storefront_all_the_cool_cats = count( $the_retail_storefront_all_the_cool_cats );

		set_transient( 'the_retail_storefront_categories', $the_retail_storefront_all_the_cool_cats );
	}

	if ( $the_retail_storefront_all_the_cool_cats > 1 ) {
		// This blog has more than 1 category so the_retail_storefront_categorized_blog should return true.
		return true;
	} else {
		// This blog has only 1 category so the_retail_storefront_categorized_blog should return false.
		return false;
	}
}

/**
 * Flush out the transients used in the_retail_storefront_categorized_blog.
 */
function the_retail_storefront_category_transient_flusher() {
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}
	// Like, beat it. Dig?
	delete_transient( 'the_retail_storefront_categories' );
}
add_action( 'edit_category', 'the_retail_storefront_category_transient_flusher' );
add_action( 'save_post',     'the_retail_storefront_category_transient_flusher' );

/**
 * Register Breadcrumb for Multiple Variation
 */
function the_retail_storefront_breadcrumbs_style() {
	get_template_part('./template-parts/sections/section','breadcrumb');
}

/**
 * This Function Check whether Sidebar active or Not
 */
if(!function_exists( 'the_retail_storefront_post_layout' )) :
function the_retail_storefront_post_layout(){
	if(is_active_sidebar('the-retail-storefront-sidebar-primary'))
		{ echo 'col-lg-8'; } 
	else 
		{ echo 'col-lg-12'; }  
} endif;