<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

$post_type = get_post_meta( get_the_ID(), '_faq_post_type', true );
$order_by = get_post_meta( get_the_ID(), '_faq_order_by', true );
$order = get_post_meta(get_the_ID(), '_faq_order', true); 
$faqly_is_premium_user = get_option('faqly_pro_is_premium', false);

// $faq_icon = get_post_meta(get_the_ID(), '_faq_icon', true); 
?>

<div class="form-group">
    <label for="faq_post_type">Post Type:</label>
    <select name="faq_post_type" id="faq_post_type" class="form-control">
        <option value="faqly_faq" <?php selected( $post_type, 'faqly_faq' ); ?>>All Posts (FAQ)</option>
        <option value="post" <?php selected( $post_type, 'post' ); ?>>Normal Posts</option>
        <option value="page" <?php selected( $post_type, 'page' ); ?><?php echo faqly_field_disabled_attr( $faqly_is_premium_user ); ?>>Pages(<?php echo faqly_pro_label( $faqly_is_premium_user ); ?>)</option>
        <option value="product" <?php selected( $post_type, 'product' ); ?><?php echo faqly_field_disabled_attr( $faqly_is_premium_user ); ?>>Product(<?php echo faqly_pro_label( $faqly_is_premium_user ); ?>)</option>
        <option value="custom" <?php selected( $post_type, 'custom' ); ?><?php echo faqly_field_disabled_attr( $faqly_is_premium_user ); ?>>All Custom Posts(<?php echo faqly_pro_label( $faqly_is_premium_user ); ?>)</option>
    </select>
    <input type="text" name="faq_custom_post_type" id="faq_custom_post_type" class="form-control" style="margin-top:10px; display: <?php echo ($post_type === 'custom') ? 'block' : 'none'; ?>;" placeholder="Enter custom post type" value="<?php echo esc_attr( get_post_meta( get_the_ID(), '_faq_custom_post_type', true ) ); ?>">

<!-- New Filter Posts dropdown -->
<div class="form-group" style="margin-top: 15px;">
    <label for="faq_filter_posts">Filter Posts:</label>
    <select name="faq_filter_posts" id="faq_filter_posts" class="form-control">
        <option value="latest" <?php selected( get_post_meta( get_the_ID(), '_faq_filter_posts', true ), 'latest' ); ?>>Latest</option>
        <option value="taxonomy" <?php selected( get_post_meta( get_the_ID(), '_faq_filter_posts', true ), 'taxonomy' ); ?><?php echo faqly_field_disabled_attr( $faqly_is_premium_user ); ?>>Taxonomy (<?php echo faqly_pro_label( $faqly_is_premium_user ); ?>)</option>
        <option value="specific" <?php selected( get_post_meta( get_the_ID(), '_faq_filter_posts', true ), 'specific' ); ?><?php echo faqly_field_disabled_attr( $faqly_is_premium_user ); ?>>Specific Posts(<?php echo faqly_pro_label( $faqly_is_premium_user ); ?>)</option>
    </select>
</div>

<!-- Taxonomy Filter Input -->
<div class="form-group taxonomy-filter" style="margin-top: 10px; display: <?php echo (get_post_meta( get_the_ID(), '_faq_filter_posts', true ) === 'taxonomy') ? 'block' : 'none'; ?>;">
    <label for="faq_taxonomy_name">Taxonomy Name:</label>
    <input type="text" name="faq_taxonomy_name" id="faq_taxonomy_name" class="form-control"
           placeholder="e.g. category, post_tag, custom_taxonomy"
           value="<?php echo esc_attr( get_post_meta( get_the_ID(), '_faq_taxonomy_name', true ) ); ?>"<?php echo faqly_field_disabled_attr( $faqly_is_premium_user ); ?>>
    <small class="form-text text-muted">Enter the taxonomy slug (e.g. category, post_tag, or custom taxonomy name)</small>
</div>

<!-- Taxonomy Terms Input -->
<div class="form-group taxonomy-terms" style="margin-top: 10px; display: <?php echo (get_post_meta( get_the_ID(), '_faq_filter_posts', true ) === 'taxonomy') ? 'block' : 'none'; ?>;">
    <label for="faq_taxonomy_terms">Taxonomy Terms:</label>
    <input type="text" name="faq_taxonomy_terms" id="faq_taxonomy_terms" class="form-control"
           placeholder="e.g. term-slug-1, term-slug-2"
           value="<?php echo esc_attr( get_post_meta( get_the_ID(), '_faq_taxonomy_terms', true ) ); ?>"<?php echo faqly_field_disabled_attr( $faqly_is_premium_user ); ?>>
    <small class="form-text text-muted">Enter term slugs separated by commas (leave empty for all terms in the taxonomy)</small>
</div>

<!-- Specific Posts Input -->
<div class="form-group specific-posts" style="margin-top: 10px; display: <?php echo (get_post_meta( get_the_ID(), '_faq_filter_posts', true ) === 'specific') ? 'block' : 'none'; ?>;">
    <label for="faq_specific_posts">Specific Post IDs:</label>
    <input type="text" name="faq_specific_posts" id="faq_specific_posts" class="form-control"
           placeholder="e.g. 12,45,89"
           value="<?php echo esc_attr( get_post_meta( get_the_ID(), '_faq_specific_posts', true ) ); ?>">
    <small class="form-text text-muted">Enter post IDs separated by commas</small>
</div>
</div>

<div class="form-group">
    <label for="faq_order_by">Order By:</label>
    <select name="faq_order_by" id="faq_order_by" class="form-control">
        <option value="title" <?php selected( $order_by, 'title' ); ?>>Title</option>
        <option value="date" <?php selected( $order_by, 'date' ); ?>>Date</option>
        <option value="ID" <?php selected( $order_by, 'ID' ); ?>>ID</option>
    </select>
</div>

<div class="form-group">
    <label for="faq_order">Order (Ascending/Descending):</label>
    <select name="faq_order" id="faq_order" class="form-control">
        <option value="ASC" <?php selected($order, 'ASC'); ?>>Ascending</option>
        <option value="DESC" <?php selected($order, 'DESC'); ?>>Descending</option>
    </select>
</div>


<!-- //new -->
 <div class="form-group">
    <label for="faq_exclude_ids">Exclude by ID (comma separated):</label>
    <input type="text" name="faq_exclude_ids" id="faq_exclude_ids" class="form-control"
           value="<?php echo esc_attr( get_post_meta( get_the_ID(), '_faq_exclude_ids', true ) ); ?>"
           placeholder="e.g. 12,45,89">
</div>


