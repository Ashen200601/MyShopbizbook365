<?php

if (!defined('ABSPATH')) {
    exit;
}

class WOOCS_compatibility {

    public function __construct() {
        //include_once WOOCS_PATH . 'classes/compatibility/sumo_subscriptions.php';
        if (apply_filters('woocs_init_compatibility_woo_subscriptions', false)) {
            include_once WOOCS_PATH . 'classes/compatibility/woocommerce_subscriptions.php';
        }
    }
}
