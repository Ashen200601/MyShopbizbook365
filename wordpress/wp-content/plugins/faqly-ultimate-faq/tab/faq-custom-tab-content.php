<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}
// Retrieve saved FAQ data
$faqs = get_post_meta( get_the_ID(), '_faq_items', true );
$faqs = is_array( $faqs ) ? $faqs : [];
?>

<div id="faq-accordion" class="accordion">
    <?php foreach ( $faqs as $index => $faq ) : ?>
        <div class="accordion-item" id="faq-item-<?php echo esc_attr( $index ); ?>">
            <h2 class="accordion-header" id="heading-<?php echo esc_attr( $index ); ?>">
                <button class="accordion-button <?php echo $index === 0 ? '' : 'collapsed'; ?>" 
                        type="button" 
                        data-bs-toggle="collapse" 
                        data-bs-target="#collapse-<?php echo esc_attr( $index ); ?>" 
                        aria-expanded="<?php echo $index === 0 ? 'true' : 'false'; ?>" 
                        aria-controls="collapse-<?php echo esc_attr( $index ); ?>">
                    <!-- FAQ Title with Icon -->
                    <span class="faq-icon">
                        <i class="<?php echo esc_attr( $faq['icon'] ?? 'default-icon-class' ); ?>"></i>
                    </span>
                    FAQ #<?php echo esc_html( $index + 1 ); ?> 
                </button>
            </h2>
            <div id="collapse-<?php echo esc_attr( $index ); ?>" 
                 class="accordion-collapse collapse <?php echo $index === 0 ? 'show' : ''; ?>" 
                 aria-labelledby="heading-<?php echo esc_attr( $index ); ?>" 
                 data-bs-parent="#faq-accordion">
                <div class="accordion-body">
                    <div class="form-group">
                        <label for="faq_title_<?php echo esc_attr( $index ); ?>">Title:</label>
                        <input type="text" 
                               name="faq_items[<?php echo esc_attr( $index ); ?>][title]" 
                               id="faq_title_<?php echo esc_attr( $index ); ?>" 
                               class="form-control" 
                               value="<?php echo esc_attr( $faq['title'] ?? '' ); ?>" 
                               placeholder="Enter FAQ title">
                    </div>

                    <div class="form-group mt-3">
                        <label for="faq_description_<?php echo esc_attr( $index ); ?>">Description:</label>
                        <?php
                        wp_editor( 
                            $faq['description'] ?? '', 
                            'faq_description_' . $index, 
                            [
                                'textarea_name' => 'faq_items[' . $index . '][description]',
                                'media_buttons' => true,
                                'textarea_rows' => 6,
                                'teeny' => false,
                            ] 
                        );
                        ?>
                    </div>

                    <!-- Remove Button -->
                    <button type="button" class="btn btn-danger mt-3 remove-faq-btn" data-faq-id="<?php echo esc_attr( $index ); ?>">
                        Remove FAQ
                    </button>
                    
                </div>
            </div>
        </div>
    <?php endforeach; ?>
</div>

<div class="mt-4">
    <button type="button" id="add-faq-btn" class="btn btn-primary">Add New FAQ</button>
</div>