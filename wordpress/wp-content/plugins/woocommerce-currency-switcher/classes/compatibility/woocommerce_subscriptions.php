<?php
/**
 * Plugin Name:  Fix FOX multicurrency with Woocommerece Subscriptions.
 * Description:  Fix CSS
 * Version:      1.0.0
 * Author:       Dave
 * License:      MIT License
 */

/**
 * Class WOOCS_Subscriptions_Compatibility
 * Handles WooCommerce Currency Switcher (WOOCS) fixes for WooCommerce Subscriptions
 * Source - https://pluginus.net/support/topic/compatibility-fix-for-woocommerce-subscriptions-7-5/
 */
class WOOCS_Subscriptions_Compatibility {
    
    /**
     * Initialize the filters
     */
    public function init() {

       // Subscription price string details
       add_filter('woocommerce_subscription_price_string_details',
          [$this, 'fix_subscription_price_string_details'], 100, 2);

       // Get subscription orders
       add_filter('wcs_get_subscription_orders',
          [$this, 'fix_subscription_orders'], 10, 3);

       // New order items
       add_filter('wcs_new_order_items',
          [$this, 'fix_new_order_items'], 2, 3);

       // Variable subscription price HTML
       //add_filter('woocommerce_variable_subscription_price_html',
       //   [$this, 'fix_variable_subscription_price_html'], 10, 2);

       // Subscription product price string
       add_filter('woocommerce_subscriptions_product_price_string',
          [$this, 'fix_subscription_product_price_string'], 10, 3);

       // Subscription product price
       add_filter('woocommerce_subscriptions_product_price',
          [$this, 'fix_subscription_product_price'], 10, 2);

       // Renewal product title
       add_filter('woocommerce_subscriptions_renewal_product_title',
          [$this, 'fix_renewal_product_title'], 10, 2);

       // Cart item from session
       remove_filter('woocommerce_get_cart_item_from_session',
          [WC_Subscriptions_Core_Plugin::instance()->get_cart_handler(WCS_Cart_Renewal::class), 'add_cart_item_data']);
       add_filter('woocommerce_get_cart_item_from_session',
          [$this, 'adjust_cart_item_price_from_session'], 12, 3);
    }

    public function fix_subscription_price_string_details() {
       global $WOOCS;

       $order_currency = $subscription->get_meta('_order_currency');
       if ($order_currency && $WOOCS->current_currency !== $order_currency) {
          $WOOCS->set_currency($order_currency);
       }
       return $arg;
    }
    public function fix_subscription_orders ( $orders, $return_fields, $order_type) {

       if ( 'all' === $return_fields ) {
          foreach ( $orders as $order ) {
             global $WOOCS;
             $order_currency = $order->get_meta('_order_currency');
             if ($order_currency && $WOOCS->current_currency != $order_currency) {
                $WOOCS->set_currency($order_currency);
             }
          }
       }
       return $orders;
    }
    public function fix_new_order_items($items, $new_order, $subscription ) {
       global $WOOCS;
       $order_currency = $subscription->get_meta('_order_currency');
       if ($order_currency && $WOOCS->current_currency != $order_currency) {
          $WOOCS->set_currency($order_currency);
       }
       return $items;
    }

    public function fix_variable_subscription_price_html( $price, $product ) {
       $prices                 = $product->get_variation_prices( true );
       $min_price_variation_id = $product->get_meta( '_min_price_variation_id' );

       $tax_display_mode = get_option( 'woocommerce_tax_display_shop' );

       $price = \WC_Subscriptions_Product::get_price( $min_price_variation_id );
       if (isset($prices['price'][$min_price_variation_id])) {
          $price = $prices['price'][$min_price_variation_id];
       }
       $price = 'incl' == $tax_display_mode ? wcs_get_price_including_tax( $product, array( 'price' => $price ) ) : wcs_get_price_excluding_tax( $product, array( 'price' => $price ) );
       $price = $product->get_price_prefix( $prices ) . wc_price( $price ) . $product->get_price_suffix();
       $price = apply_filters( 'woocommerce_variable_price_html', $price, $product );
       $price = \WC_Subscriptions_Product::get_price_string( $product, array( 'price' => $price ) );

       return $price;
    }
    public function fix_subscription_product_price_string($subscription_string, $product, $include ) {
       global $wp_locale;

       if ( ! \WC_Subscriptions_Product::is_subscription( $product ) ) {
          return;
       }

       $base_price          = \WC_Subscriptions_Product::get_price( $product );
       $billing_interval    = (int) \WC_Subscriptions_Product::get_interval( $product );
       $billing_period      = \WC_Subscriptions_Product::get_period( $product );
       $subscription_length = (int) \WC_Subscriptions_Product::get_length( $product );
       $trial_length        = (int) \WC_Subscriptions_Product::get_trial_length( $product );
       $trial_period        = \WC_Subscriptions_Product::get_trial_period( $product );
       $sign_up_fee         = 0;
       $include_length      = $include['subscription_length'] && 0 !== $subscription_length;

       if ( empty( $billing_period ) ) {
          $billing_period = 'month';
       }

       if ( $include_length ) {
          $ranges = wcs_get_subscription_ranges( $billing_period );
       }

       if ( $include['sign_up_fee'] ) {
          $sign_up_fee = is_bool( $include['sign_up_fee'] ) ? \WC_Subscriptions_Product::get_sign_up_fee( $product ) : $include['sign_up_fee'];
       }

       if ( $include['tax_calculation'] ) {
          if ( in_array( $include['tax_calculation'], array( 'exclude_tax', 'excl' ), true ) ) {
             // Calculate excluding tax.
             $price = isset( $include['price'] ) ? $include['price'] : wcs_get_price_excluding_tax( $product );
             if ( true === $include['sign_up_fee'] ) {
                $sign_up_fee = wcs_get_price_excluding_tax( $product, array( 'price' => \WC_Subscriptions_Product::get_sign_up_fee( $product ) ) );
             }
          } else {
             // Calculate including tax.
             $price = isset( $include['price'] ) ? $include['price'] : wcs_get_price_including_tax( $product );
             if ( true === $include['sign_up_fee'] ) {
                $sign_up_fee = wcs_get_price_including_tax( $product, array( 'price' => \WC_Subscriptions_Product::get_sign_up_fee( $product ) ) );
             }
          }
       } else {
          $price = isset( $include['price'] ) ? $include['price'] : wc_price( $base_price );
       }

       if ( is_numeric( $sign_up_fee ) ) {
          global $WOOCS;
          if ($WOOCS->is_multiple_allowed) {
             $sign_up_fee = $WOOCS->woocs_exchange_value(floatval($sign_up_fee));
          }
          $sign_up_fee = wc_price( $sign_up_fee );
       }

       $price .= ' <span class="subscription-details">';

       $subscription_string = '';

       if ( $include['subscription_price'] && $include['subscription_period'] ) { // Allow extensions to not show price or billing period e.g. Name Your Price.
          if ( $include_length && $subscription_length === $billing_interval ) {
             $subscription_string = $price; // Only for one billing period so show"$5 for 3 months" instead of"$5 every 3 months for 3 months".
          } elseif ( \WC_Subscriptions_Synchroniser::is_product_synced( $product ) && in_array( $billing_period, array( 'week', 'month', 'year' ), true ) ) {
             $subscription_string = '';

             if ( \WC_Subscriptions_Synchroniser::is_payment_upfront( $product ) && ! \WC_Subscriptions_Synchroniser::is_today( \WC_Subscriptions_Synchroniser::calculate_first_payment_date( $product, 'timestamp' ) ) ) {
                /* translators: %1$s refers to the price. This string is meant to prefix another string below, e.g."$5 now, and $5 on March 15th each year" */
                $subscription_string = sprintf( __( '%1$s now, and ', 'woocommerce-subscriptions' ), $price );
             }

             $payment_day = \WC_Subscriptions_Synchroniser::get_products_payment_day( $product );
             switch ( $billing_period ) {
                case 'week':
                   $payment_day_of_week = \WC_Subscriptions_Synchroniser::get_weekday( $payment_day );
                   if ( 1 === $billing_interval ) {
                      // translators: 1$: recurring amount string, 2$: day of the week (e.g."$10 every Wednesday").
                      $subscription_string .= sprintf( __( '%1$s every %2$s', 'woocommerce-subscriptions' ), $price, $payment_day_of_week );
                   } else {
                      $subscription_string .= sprintf(
                      // translators: 1$: recurring amount string, 2$: period, 3$: day of the week (e.g."$10 every 2nd week on Wednesday").
                         __( '%1$s every %2$s on %3$s', 'woocommerce-subscriptions' ),
                         $price,
                         wcs_get_subscription_period_strings( $billing_interval, $billing_period ),
                         $payment_day_of_week
                      );
                   }
                   break;
                case 'month':
                   if ( 1 === $billing_interval ) {
                      if ( $payment_day > 27 ) {
                         // translators: placeholder is recurring amount.
                         $subscription_string .= sprintf( __( '%s on the last day of each month', 'woocommerce-subscriptions' ), $price );
                      } else {
                         $subscription_string .= sprintf(
                         // translators: 1$: recurring amount, 2$: day of the month (e.g."23rd") (e.g."$5 every 23rd of each month").
                            __( '%1$s on the %2$s of each month', 'woocommerce-subscriptions' ),
                            $price,
                            wcs_append_numeral_suffix( $payment_day )
                         );
                      }
                   } else {
                      if ( $payment_day > 27 ) {
                         $subscription_string .= sprintf(
                         // translators: 1$: recurring amount, 2$: interval (e.g."3rd") (e.g."$10 on the last day of every 3rd month").
                            __( '%1$s on the last day of every %2$s month', 'woocommerce-subscriptions' ),
                            $price,
                            wcs_append_numeral_suffix( $billing_interval )
                         );
                      } else {
                         $subscription_string .= sprintf(
                         // translators: 1$: <price> on the, 2$: <date> day of every, 3$: <interval> month (e.g."$10 on the 23rd day of every 2nd month").
                            __( '%1$s on the %2$s day of every %3$s month', 'woocommerce-subscriptions' ),
                            $price,
                            wcs_append_numeral_suffix( $payment_day ),
                            wcs_append_numeral_suffix( $billing_interval )
                         );
                      }
                   }
                   break;
                case 'year':
                   if ( 1 === $billing_interval ) {
                      $subscription_string .= sprintf(
                      // translators: 1$: <price> on, 2$: <date>, 3$: <month> each year (e.g."$15 on March 15th each year").
                         __( '%1$s on %2$s %3$s each year', 'woocommerce-subscriptions' ),
                         $price,
                         $wp_locale->month[ $payment_day['month'] ],
                         wcs_append_numeral_suffix( $payment_day['day'] )
                      );
                   } else {
                      $subscription_string .= sprintf(
                      // translators: 1$: recurring amount, 2$: month (e.g."March"), 3$: day of the month (e.g."23rd").
                         __( '%1$s on %2$s %3$s every %4$s year', 'woocommerce-subscriptions' ),
                         $price,
                         $wp_locale->month[ $payment_day['month'] ],
                         wcs_append_numeral_suffix( $payment_day['day'] ),
                         wcs_append_numeral_suffix( $billing_interval )
                      );
                   }
                   break;
             }
          } else {
             $subscription_string = sprintf(
             // translators: 1$: recurring amount, 2$: subscription period (e.g."month" or"3 months") (e.g."$15 / month" or"$15 every 2nd month").
                _n( '%1$s / %2$s', '%1$s every %2$s', $billing_interval, 'woocommerce-subscriptions' ),
                $price,
                wcs_get_subscription_period_strings( $billing_interval, $billing_period )
             );
          }
       } elseif ( $include['subscription_price'] ) {
          $subscription_string = $price;
       } elseif ( $include['subscription_period'] ) {
          $subscription_string = '<span class="subscription-details">' . sprintf(
             // translators: billing period (e.g."every week").
                __( 'every %s', 'woocommerce-subscriptions' ),
                wcs_get_subscription_period_strings( $billing_interval, $billing_period )
             );
       } else {
          $subscription_string = '<span class="subscription-details">';
       }

       // Add the length to the end.
       if ( $include_length ) {
          // translators: 1$: subscription string (e.g."$10 up front then $5 on March 23rd every 3rd year"), 2$: length (e.g."4 years").
          $subscription_string = sprintf( __( '%1$s for %2$s', 'woocommerce-subscriptions' ), $subscription_string, $ranges[ $subscription_length ] );
       }

       if ( $include['trial_length'] && 0 !== $trial_length ) {
          $trial_string = wcs_get_subscription_trial_period_strings( $trial_length, $trial_period );
          // translators: 1$: subscription string (e.g."$15 on March 15th every 3 years for 6 years"), 2$: trial length (e.g.:"with 4 months free trial").
          $subscription_string = sprintf( __( '%1$s with %2$s free trial', 'woocommerce-subscriptions' ), $subscription_string, $trial_string );
       }

       if ( $include['sign_up_fee'] && \WC_Subscriptions_Product::get_sign_up_fee( $product ) > 0 ) {
          // translators: 1$: subscription string (e.g."$15 on March 15th every 3 years for 6 years with 2 months free trial"), 2$: signup fee price (e.g."and a $30 sign-up fee").
          $subscription_string = sprintf( __( '%1$s and a %2$s sign-up fee', 'woocommerce-subscriptions' ), $subscription_string, $sign_up_fee );
       }

       $subscription_string .= '</span>';
       return $subscription_string;
    }
    
    public function fix_subscription_product_price($active_price, $product) {

       $subscription_price = \WC_Subscriptions_Product::get_meta_data( $product, 'subscription_price', 0 );
       $sale_price         = \WC_Subscriptions_Product::get_sale_price( $product );

       if ($subscription_price) {
          global $WOOCS;
          if ($WOOCS->is_multiple_allowed) {
             $subscription_price = $WOOCS->woocs_exchange_value(floatval($subscription_price));
          }
       }
       $active_price = ( $subscription_price ) ? $subscription_price :  $product->get_regular_price();

       // Ensure that $sale_price is non-empty because other plugins can use woocommerce_product_is_on_sale filter to
       // forcefully set a product's is_on_sale flag (like Dynamic Pricing )
       if ( $product->is_on_sale() && '' !== $sale_price && $subscription_price > $sale_price ) {
          $active_price = $sale_price;
       }
       return $active_price;
    }
    public function fix_renewal_product_title( $line_item_name, $_product) {
       global $WOOCS;
       if ($WOOCS->is_multiple_allowed) {
          // TODO: get subscription object.
          $curr = get_post_meta($subscription->get_id(), '_order_currency', true);
          $currencies = $WOOCS->get_currencies();
          $rate = $currencies[$curr]['rate'];
          $price = $price / ($rate);
       }
       return $line_item_name;
    }
    public function adjust_cart_item_price_from_session($cart_item_session_data, $cart_item, $key) {

       /** @var \WCS_Cart_Renewal $cart_renewal */
       $cart_renewal = \WC_Subscriptions_Core_Plugin::instance()->get_cart_handler(\WCS_Cart_Renewal::class);
       if ( $cart_renewal->should_honor_subscription_prices( $cart_item ) ) {
          $cart_item_session_data[ $this->cart_item_key ] = $cart_item[ $cart_renewal->cart_item_key ];

          $_product = $cart_item_session_data['data'];

          // Need to get the original subscription or order price, not the current price
          $subscription = wc_get_order( $cart_item[ $cart_renewal->cart_item_key ]['renewal_order_id'] );

          if ( $subscription ) {
             $subscription_items = $subscription->get_items();
             $item_to_renew      = [];

             /**
              * Find the subscription or order line item that represents this cart item.
              *
              * If cart item data correctly records a valid line item ID, use that to find the line item.
              * Otherwise, use the cart item key stored in line item meta.
              */
             if ( isset( $subscription_items[ $cart_item_session_data[ $cart_renewal->cart_item_key ]['line_item_id'] ] ) ) {
                $item_to_renew = $subscription_items[ $cart_item_session_data[ $cart_renewal->cart_item_key ]['line_item_id'] ];
             } else {
                foreach ( $subscription_items as $item ) {
                   if ( $item->get_meta( '_cart_item_key_' . $cart_renewal->cart_item_key, true ) === $key ) {
                      $item_to_renew = $item;
                      break;
                   }
                }
             }

             // If we can't find the item to renew, return the cart item session data as is.
             if ( empty( $item_to_renew ) ) {
                return $cart_item_session_data;
             }

             $price = $item_to_renew['line_subtotal'];

             if ( $_product->is_taxable() && $subscription->get_prices_include_tax() ) {

                // If this item's subtracted tax data hasn't been repaired, do that now.
                if ( isset( $item_to_renew['_subtracted_base_location_tax'] ) ) {
                   \WC_Subscriptions_Upgrader::repair_subtracted_base_taxes( $item_to_renew->get_id() );

                   // The item has been updated so get a refreshed version of the item.
                   $item_to_renew = \WC_Order_Factory::get_order_item( $item_to_renew->get_id() );
                }

                if ( isset( $item_to_renew['_subtracted_base_location_taxes'] ) ) {
                   $price += array_sum( $item_to_renew['_subtracted_base_location_taxes'] ) * $item_to_renew['qty'];
                } elseif ( isset( $item_to_renew['taxes']['subtotal'] ) ) {
                   $price += array_sum( $item_to_renew['taxes']['subtotal'] ); // Use the taxes array items here as they contain taxes to a more accurate number of decimals.
                }
             }

             global $WOOCS;
             if ($WOOCS->is_multiple_allowed) {
                $curr = $subscription->get_meta('_order_currency');
                $currencies = $WOOCS->get_currencies();
                $rate = $currencies[$curr]['rate'];
                $price = $price / ($rate);
             }

             // In rare cases quantity can be zero. Check first to prevent triggering a fatal error in php8+
             if ( 0 !== (int) $item_to_renew['qty'] ) {
                $_product->set_price( $price / $item_to_renew['qty'] );
             }

             // Don't carry over any sign up fee
             wcs_set_objects_property( $_product, 'subscription_sign_up_fee', 0, 'set_prop_only' );

             // Allow plugins to add additional strings to the product name for renewals
             $line_item_name = is_callable( $item_to_renew, 'get_name' ) ? $item_to_renew->get_name() : $item_to_renew['name'];
             wcs_set_objects_property( $_product, 'name', apply_filters( 'woocommerce_subscriptions_renewal_product_title', $line_item_name, $_product ), 'set_prop_only' );

             // Make sure the same quantity is renewed
             $cart_item_session_data['quantity'] = $item_to_renew['qty'];
          }
       }

       return $cart_item_session_data;
    }
}


if ( class_exists( 'WOOCS' ) && class_exists( 'WC_Subscriptions' ) ) {
   $wcs_compatibilty = new WOOCS_Subscriptions_Compatibility ();
   $wcs_compatibilty->init();
}
