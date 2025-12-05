<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

function faqly_render_tools_page() {
    global $faqly_is_premium_user;
?>
<div class="wrap">
    <h1><?php _e( 'FAQly Tools', 'faqly-ultimate-faq' ); ?></h1>

    <!-- Bootstrap Tabs -->
    <div class="container-fluid mt-4">
        <ul class="nav nav-tabs" id="faqly-tools-tabs" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active" id="export-tab" data-bs-toggle="tab" data-bs-target="#export" type="button" role="tab" aria-controls="export" aria-selected="true">
                    <span class="dashicons dashicons-download me-2"></span>
                    <?php _e( 'Export', 'faqly-ultimate-faq' ); ?>
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="import-tab" data-bs-toggle="tab" data-bs-target="#import" type="button" role="tab" aria-controls="import" aria-selected="false">
                    <span class="dashicons dashicons-upload me-2"></span>
                    <?php _e( 'Import', 'faqly-ultimate-faq' ); ?>
                </button>
            </li>
        </ul>

        <div class="tab-content mt-4" id="faqly-tools-tab-content">
            <div class="tab-pane fade show active" id="export" role="tabpanel" aria-labelledby="export-tab">
                <div class="card">
                    <div class="card-body">
                        <h2 class="card-title"><?php _e( 'Export FAQ Data', 'faqly-ultimate-faq' ); ?> <?php echo faqly_pro_label( $faqly_is_premium_user ); ?></h2>
                        <p class="card-text"><?php _e( 'Choose what you want to export from your FAQ system. The exported data will be downloaded as a JSON file.', 'faqly-ultimate-faq' ); ?></p>

                        <div id="faqly-export-form">
                            <input type="hidden" id="faqly-export-nonce" value="<?php echo wp_create_nonce( 'faqly_export_nonce' ); ?>">

                            <div class="faqly-export-options">
                                <h3><?php _e( 'Choose what to export:', 'faqly-ultimate-faq' ); ?></h3>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="export_type" id="export_faqs" value="faqs" checked <?php echo faqly_field_disabled_attr( $faqly_is_premium_user ); ?>>
                                            <label class="form-check-label" for="export_faqs">
                                                <strong><?php _e( 'All FAQs', 'faqly-ultimate-faq' ); ?></strong>
                                                <br>
                                                <small class="text-muted"><?php _e( 'Export all individual FAQ posts (post_type=faqly_faq)', 'faqly-ultimate-faq' ); ?></small>
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="export_type" id="export_groups" value="groups" <?php echo faqly_field_disabled_attr( $faqly_is_premium_user ); ?>>
                                            <label class="form-check-label" for="export_groups">
                                                <strong><?php _e( 'All Accordion Groups', 'faqly-ultimate-faq' ); ?></strong>
                                                <br>
                                                <small class="text-muted"><?php _e( 'Export all FAQ accordion groups (post_type=faqly_faq_group)', 'faqly-ultimate-faq' ); ?></small>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="mt-4">
                                <button type="button" class="btn btn-primary faqly-export-btn" <?php echo faqly_field_disabled_attr( $faqly_is_premium_user ); ?>>
                                    <span class="dashicons dashicons-download me-2"></span>
                                    <?php _e( 'Export as JSON', 'faqly-ultimate-faq' ); ?>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="tab-pane fade" id="import" role="tabpanel" aria-labelledby="import-tab">
                <div class="card">
                    <div class="card-body">
                        <h2 class="card-title"><?php _e( 'Import FAQ Data', 'faqly-ultimate-faq' ); ?> <?php echo faqly_pro_label( $faqly_is_premium_user ); ?></h2>
                        <p class="card-text"><?php _e( 'Upload a JSON file exported from FAQly to import FAQ data. This will create new FAQ posts or update existing ones.', 'faqly-ultimate-faq' ); ?></p>

                        <div id="faqly-import-form">
                            <input type="hidden" id="faqly-import-nonce" value="<?php echo wp_create_nonce( 'faqly_import_nonce' ); ?>">

                            <div class="faqly-import-options">
                                <div class="mb-3">
                                    <label for="faqly-import-file" class="form-label">
                                        <strong><?php _e( 'Select JSON File to Import:', 'faqly-ultimate-faq' ); ?></strong>
                                    </label>
                                    <input type="file" class="form-control" id="faqly-import-file" accept=".json" required <?php echo faqly_field_disabled_attr( $faqly_is_premium_user ); ?>>
                                    <div class="form-text"><?php _e( 'Only JSON files exported from FAQly are supported.', 'faqly-ultimate-faq' ); ?></div>
                                </div>


                            </div>

                            <div class="mt-4">
                                <button type="button" class="btn btn-success faqly-import-btn" disabled <?php echo faqly_field_disabled_attr( $faqly_is_premium_user ); ?>>
                                    <span class="dashicons dashicons-upload me-2"></span>
                                    <?php _e( 'Import Data', 'faqly-ultimate-faq' ); ?>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php
}
?>
